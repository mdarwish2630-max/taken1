<?php
/**
 * CMS Platform - Email Service
 * خدمة البريد الإلكتروني باستخدام PHPMailer + SMTP
 */

require_once ROOT_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once ROOT_PATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once ROOT_PATH . '/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private static $instance = null;
    private $mailer;
    private $smtpConfig = null;

    private function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    /**
     * الحصول على نسخة واحدة (Singleton)
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * تحميل إعدادات SMTP من قاعدة البيانات
     */
    private function loadSmtpConfig()
    {
        if ($this->smtpConfig !== null) {
            return $this->smtpConfig;
        }

        // محاولة جلب الإعدادات من قاعدة البيانات
        try {
            $db = Database::getInstance();
            $rows = $db->query(
                "SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'smtp_%'"
            )->results();

            $config = [];
            if (is_iterable($rows)) {
                foreach ($rows as $row) {
                    $config[$row->setting_key] = $row->setting_value;
                }
            }

            // إذا لم توجد إعدادات في DB، نستخدم الإعدادات الافتراضية
            if (empty($config)) {
                $config = [
                    'smtp_host' => defined('SMTP_HOST') ? SMTP_HOST : '',
                    'smtp_port' => defined('SMTP_PORT') ? SMTP_PORT : 587,
                    'smtp_username' => defined('SMTP_USERNAME') ? SMTP_USERNAME : '',
                    'smtp_password' => defined('SMTP_PASSWORD') ? SMTP_PASSWORD : '',
                    'smtp_encryption' => defined('SMTP_ENCRYPTION') ? SMTP_ENCRYPTION : 'tls',
                    'smtp_from_name' => defined('SITE_NAME') ? SITE_NAME : 'منصة المواقع',
                    'smtp_from_email' => defined('ADMIN_EMAIL') ? ADMIN_EMAIL : '',
                ];
            }

            $this->smtpConfig = $config;
        } catch (\Exception $e) {
            $this->smtpConfig = [
                'smtp_host' => defined('SMTP_HOST') ? SMTP_HOST : '',
                'smtp_port' => defined('SMTP_PORT') ? SMTP_PORT : 587,
                'smtp_username' => defined('SMTP_USERNAME') ? SMTP_USERNAME : '',
                'smtp_password' => defined('SMTP_PASSWORD') ? SMTP_PASSWORD : '',
                'smtp_encryption' => defined('SMTP_ENCRYPTION') ? SMTP_ENCRYPTION : 'tls',
                'smtp_from_name' => defined('SITE_NAME') ? SITE_NAME : 'منصة المواقع',
                'smtp_from_email' => defined('ADMIN_EMAIL') ? ADMIN_EMAIL : '',
            ];
        }

        return $this->smtpConfig;
    }

    /**
     * تهيئة PHPMailer مع SMTP
     */
    private function configure()
    {
        $config = $this->loadSmtpConfig();

        // إذا لم يتم تكوين SMTP
        if (empty($config['smtp_host']) || empty($config['smtp_username'])) {
            throw new \Exception('لم يتم تكوين إعدادات SMTP بعد. يرجى إعدادها من لوحة تحكم المدير.');
        }

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host       = $config['smtp_host'];
        $this->mailer->Port       = (int)($config['smtp_port'] ?? 587);
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $config['smtp_username'];
        $this->mailer->Password   = $config['smtp_password'];

        // التشفير
        $encryption = strtolower($config['smtp_encryption'] ?? 'tls');
        if ($encryption === 'ssl') {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($encryption === 'none') {
            $this->mailer->SMTPSecure = '';
            $this->mailer->SMTPAutoTLS = false;
        } else {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        // إعدادات اللغة والأحرف
        $this->mailer->CharSet  = 'UTF-8';
        $this->mailer->setLanguage('ar', ROOT_PATH . '/vendor/phpmailer/phpmailer/language/');

        // وقت الانتظار
        $this->mailer->Timeout  = 30;
        $this->mailer->SMTPDebug = (defined('DEBUG_MODE') && DEBUG_MODE) ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;

        // المرسل الافتراضي
        $fromEmail = $config['smtp_from_email'] ?? $config['smtp_username'];
        $fromName  = $config['smtp_from_name'] ?? SITE_NAME;

        $this->mailer->setFrom($fromEmail, $fromName);
        $this->mailer->addReplyTo($fromEmail, $fromName);

        return $this;
    }

    /**
     * إرسال إيميل
     * 
     * @param string|array $to بريد أو عدة بريد (['email@x.com' => 'الاسم'])
     * @param string $subject الموضوع
     * @param string $body محتوى HTML
     * @param string $template اسم القالب (اختياري)
     * @param array $data بيانات القالب (اختياري)
     * @return bool
     */
    public function send($to, $subject, $body, $template = null, $data = [])
    {
        try {
            $this->configure();

            // المستلمين
            if (is_array($to)) {
                foreach ($to as $email => $name) {
                    if (is_numeric($email)) {
                        $this->mailer->addAddress($name);
                    } else {
                        $this->mailer->addAddress($email, $name);
                    }
                }
            } else {
                $this->mailer->addAddress($to);
            }

            // الموضوع
            $this->mailer->Subject = $subject;

            // محتوى HTML
            if ($template && $this->templateExists($template)) {
                $html = $this->renderTemplate($template, array_merge($data, [
                    'subject' => $subject,
                    'body'    => $body,
                ]));
            } else {
                $html = $body;
            }

            $this->mailer->isHTML(true);
            $this->mailer->Body    = $html;
            $this->mailer->AltBody = $this->htmlToText($html);

            $result = $this->mailer->send();

            // إعادة تعيين للإرسال التالي
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();
            $this->mailer->clearReplyTos();
            $this->mailer->clearCCs();
            $this->mailer->clearBCCs();

            return $result;

        } catch (Exception $e) {
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                error_log('Email Error: ' . $e->getMessage());
            }
            return false;
        }
    }

    /**
     * إرسال إيميل ترحيبي بعد التسجيل
     */
    public function sendWelcomeEmail($user, $verificationLink = null)
    {
        $body = $verificationLink
            ? '<p>مرحباً <strong>' . htmlspecialchars($user->full_name) . '</strong>،</p>
               <p>شكراً لانضمامك إلى ' . htmlspecialchars(SITE_NAME) . '! للحفاظ على أمان حسابك، يرجى تأكيد عنوان بريدك الإلكتروني بالضغط على الزر أدناه:</p>'
            : '<p>مرحباً <strong>' . htmlspecialchars($user->full_name) . '</strong>،</p>
               <p>شكراً لانضمامك إلى ' . htmlspecialchars(SITE_NAME) . '! تم إنشاء حسابك بنجاح.</p>';

        $data = [
            'user_name'          => $user->full_name,
            'user_email'         => $user->email,
            'verification_link'  => $verificationLink,
            'show_verify_button' => !empty($verificationLink),
            'button_text'        => 'تأكيد البريد الإلكتروني',
            'button_link'        => $verificationLink,
        ];

        return $this->send(
            $user->email,
            'مرحباً بك في ' . SITE_NAME,
            $body,
            'welcome',
            $data
        );
    }

    /**
     * إرسال إيميل تأكيد البريد الإلكتروني
     */
    public function sendVerificationEmail($user, $verificationLink)
    {
        $body = '<p>مرحباً <strong>' . htmlspecialchars($user->full_name) . '</strong>،</p>
                 <p>يرجى تأكيد عنوان بريدك الإلكتروني بالضغط على الزر أدناه:</p>';

        $data = [
            'user_name'          => $user->full_name,
            'verification_link'  => $verificationLink,
            'show_verify_button' => true,
            'button_text'        => 'تأكيد البريد الإلكتروني',
            'button_link'        => $verificationLink,
        ];

        return $this->send(
            $user->email,
            'تأكيد البريد الإلكتروني - ' . SITE_NAME,
            $body,
            'verify-email',
            $data
        );
    }

    /**
     * إرسال كود OTP
     */
    public function sendOtpEmail($user, $otp, $purpose = 'تسجيل الدخول')
    {
        $body = '<p>مرحباً <strong>' . htmlspecialchars($user->full_name) . '</strong>،</p>
                 <p>طلبك رمز التحقق لغرض: <strong>' . htmlspecialchars($purpose) . '</strong></p>
                 <p>رمز التحقق الخاص بك هو:</p>';

        $data = [
            'user_name'    => $user->full_name,
            'otp_code'     => $otp,
            'otp_purpose'  => $purpose,
            'show_otp'     => true,
        ];

        return $this->send(
            $user->email,
            'رمز التحقق - ' . SITE_NAME,
            $body,
            'otp',
            $data
        );
    }

    /**
     * إرسال رابط استعادة كلمة المرور
     */
    public function sendPasswordResetEmail($user, $resetLink)
    {
        $body = '<p>مرحباً <strong>' . htmlspecialchars($user->full_name) . '</strong>،</p>
                 <p>تلقينا طلباً لإعادة تعيين كلمة المرور لحسابك. اضغط على الزر أدناه لإعادة تعيينها:</p>
                 <p style="color: #64748b; font-size: 0.9rem;">هذا الرابط صالح لمدة ساعة واحدة فقط.</p>';

        $data = [
            'user_name'     => $user->full_name,
            'reset_link'    => $resetLink,
            'show_button'   => true,
            'button_text'   => 'إعادة تعيين كلمة المرور',
            'button_link'   => $resetLink,
        ];

        return $this->send(
            $user->email,
            'إعادة تعيين كلمة المرور - ' . SITE_NAME,
            $body,
            'reset-password',
            $data
        );
    }

    /**
     * إرسال إشعار بطلب خدمة جديدة (للادمن)
     */
    public function sendNewPurchaseNotification($purchase, $customer, $service)
    {
        $body = '<p>لديك طلب خدمة جديد من <strong>' . htmlspecialchars($customer->full_name) . '</strong></p>
                 <table style="width:100%; border-collapse:collapse; margin: 16px 0;">
                     <tr><td style="padding:8px; border:1px solid #e2e8f0; background:#f8fafc;"><strong>العميل</strong></td><td style="padding:8px; border:1px solid #e2e8f0;">' . htmlspecialchars($customer->full_name) . ' (' . htmlspecialchars($customer->email) . ')</td></tr>
                     <tr><td style="padding:8px; border:1px solid #e2e8f0; background:#f8fafc;"><strong>الخدمة</strong></td><td style="padding:8px; border:1px solid #e2e8f0;">' . htmlspecialchars($service->title) . '</td></tr>
                     <tr><td style="padding:8px; border:1px solid #e2e8f0; background:#f8fafc;"><strong>المبلغ</strong></td><td style="padding:8px; border:1px solid #e2e8f0;">' . number_format($purchase->amount, 0) . ' ر.س</td></tr>
                     <tr><td style="padding:8px; border:1px solid #e2e8f0; background:#f8fafc;"><strong>التاريخ</strong></td><td style="padding:8px; border:1px solid #e2e8f0;">' . date('Y/m/d H:i') . '</td></tr>
                 </table>';

        $adminEmail = setting('smtp_from_email') ?? ADMIN_EMAIL;
        $siteName = setting('site_name') ?? SITE_NAME;

        return $this->send(
            $adminEmail,
            'طلب خدمة جديد - ' . $siteName,
            $body,
            'notification',
            ['user_name' => 'المدير', 'notification_title' => 'طلب خدمة جديد']
        );
    }

    /**
     * إرسال إشعار بتغيير حالة الطلب (للعميل)
     */
    public function sendPurchaseStatusEmail($user, $serviceTitle, $status, $adminNotes = '')
    {
        $statusLabels = [
            'approved'  => 'تمت الموافقة ✅',
            'cancelled' => 'تم الرفض ❌',
        ];

        $isApproved = ($status === 'approved');
        $statusText = $statusLabels[$status] ?? $status;

        $body = '<p>مرحباً <strong>' . htmlspecialchars($user->full_name) . '</strong>،</p>
                 <p>تم تحديث حالة طلبك للخدمة <strong>' . htmlspecialchars($serviceTitle) . '</strong></p>
                 <p style="font-size: 1.1rem; font-weight: 700; color: ' . ($isApproved ? '#16a34a' : '#dc2626') . ';">' . $statusText . '</p>';

        if ($adminNotes) {
            $body .= '<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin: 12px 0;">
                         <strong>ملاحظات الإدارة:</strong><br>' . nl2br(htmlspecialchars($adminNotes)) . '
                      </div>';
        }

        $data = [
            'user_name' => $user->full_name,
            'is_approved' => $isApproved,
        ];

        return $this->send(
            $user->email,
            'تحديث حالة الطلب - ' . SITE_NAME,
            $body,
            'purchase-status',
            $data
        );
    }

    /**
     * إرسال إشعار بانتهاء الاشتراك
     */
    public function sendSubscriptionExpiryEmail($user, $siteName, $expiryDate, $daysLeft)
    {
        $body = '<p>مرحباً <strong>' . htmlspecialchars($user->full_name) . '</strong>،</p>
                 <p>نشكرك لاستخدامك منصة ' . htmlspecialchars(SITE_NAME) . '.</p>
                 <p>نود إعلامك بأن اشتراك موقعك <strong>' . htmlspecialchars($siteName) . '</strong> سينتهي خلال <strong style="color: #dc2626;">' . $daysLeft . ' يوم</strong> (تاريخ الانتهاء: ' . $expiryDate . ').</p>
                 <p>لضمان عدم انقطاع خدمات موقعك، يرجى تجديد الاشتراك قبل تاريخ الانتهاء.</p>';

        $data = [
            'user_name'    => $user->full_name,
            'show_button'  => true,
            'button_text'  => 'تجديد الاشتراك',
            'button_link'  => fullUrl('/dashboard/subscription/renew'),
        ];

        return $this->send(
            $user->email,
            'تنبيه انتهاء الاشتراك - ' . SITE_NAME,
            $body,
            'alert',
            $data
        );
    }

    /**
     * اختبار إعدادات SMTP
     */
    public function testConnection($testEmail)
    {
        try {
            $this->configure();
            $this->mailer->addAddress($testEmail);
            $this->mailer->Subject = 'اختبار SMTP - ' . SITE_NAME;
            $this->mailer->Body    = '<h2>✅ تم إعداد SMTP بنجاح!</h2><p>هذا إيميل اختباري لتأكيد أن إعدادات SMTP تعمل بشكل صحيح.</p><p>تم الإرسال في: ' . date('Y/m/d H:i:s') . '</p>';
            $this->mailer->AltBody = 'تم إعداد SMTP بنجاح! هذا إيميل اختباري.';
            $this->mailer->isHTML(true);

            $this->mailer->send();
            return ['success' => true, 'message' => 'تم إرسال الإيميل الاختباري بنجاح'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'فشل الإرسال: ' . $e->getMessage()];
        }
    }

    /**
     * حفظ إعدادات SMTP
     */
    public static function saveSmtpSettings($settings)
    {
        try {
            $db = Database::getInstance();

            foreach ($settings as $key => $value) {
                if (strpos($key, 'smtp_') !== 0) continue;

                // تحقق من وجود الإعداد
                $exists = $db->query(
                    "SELECT COUNT(*) as count FROM settings WHERE setting_key = ?",
                    [$key]
                )->first();

                if ($exists->count > 0) {
                    $db->query(
                        "UPDATE settings SET setting_value = ? WHERE setting_key = ?",
                        [$value, $key]
                    );
                } else {
                    $db->query(
                        "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)",
                        [$key, $value]
                    );
                }
            }

            // مسح الكاش
            self::$instance = null;
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * جلب إعدادات SMTP الحالية
     */
    public static function getSmtpSettings()
    {
        try {
            $db = Database::getInstance();
            $rows = $db->query(
                "SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'smtp_%'"
            )->results();

            $config = [];
            if (is_iterable($rows)) {
                foreach ($rows as $row) {
                    $config[$row->setting_key] = $row->setting_value;
                }
            }

            return $config;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * التحقق من وجود قالب
     */
    private function templateExists($template)
    {
        $path = ROOT_PATH . '/app/views/emails/' . $template . '.php';
        return file_exists($path);
    }

    /**
     * عرض قالب إيميل
     */
    private function renderTemplate($template, $data = [])
    {
        $templatePath = ROOT_PATH . '/app/views/emails/' . $template . '.php';
        $layoutPath = ROOT_PATH . '/app/views/emails/layout.php';

        // استخراج المتغيرات
        extract($data, EXTR_SKIP);

        // عرض محتوى القالب
        ob_start();
        include $templatePath;
        $content = ob_get_clean();

        // عرض داخل اللAYOUT
        ob_start();
        $emailContent = $content;
        include $layoutPath;
        return ob_get_clean();
    }

    /**
     * تحويل HTML إلى نص عادي
     */
    private function htmlToText($html)
    {
        $text = preg_replace('/<br\s*\/?>/i', "\n", $html);
        $text = preg_replace('/<hr\s*\/?>/i', "----------------\n", $text);
        $text = preg_replace('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/is', "\n$1\n", $text);
        $text = preg_replace('/<p[^>]*>(.*?)<\/p>/is', "$1\n", $text);
        $text = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "• $1\n", $text);
        $text = preg_replace('/<tr[^>]*>(.*?)<\/tr>/is', "$1\n", $text);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        return trim($text);
    }
}
