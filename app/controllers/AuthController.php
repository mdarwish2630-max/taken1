<?php
/**
 * CMS Platform - Auth Controller
 * متحكم المصادقة - مع دعم SMTP كامل
 * 
 * === إصلاحات الأمان المطبقة ===
 * 1. [FIX-07] تعزيز Rate Limiting - استخدام MAX_LOGIN_ATTEMPTS و LOGIN_LOCKOUT_TIME
 * 2. [FIX-08] توحيد التحقق من طول كلمة المرور باستخدام PASSWORD_MIN_LENGTH و PASSWORD_MAX_LENGTH
 * 3. [FIX-09] إضافة CSRF protection لـ resendVerification
 * 4. [FIX-10] التحقق من صلاحية Token في resetPassword (منع SQL Injection عبر Token)
 * 5. [FIX-11] تجديد Session ID بعد تسجيل الدخول (منع Session Fixation)
 * 6. [FIX-12] Rate Limiting لإعادة إرسال إيميل التحقق (منع Spam)
 * 7. [SEC-01] إضافة CAPTCHA رياضية لمنع الروبوتات في تسجيل الدخول والتسجيل
 * 8. [SEC-02] فرض تأكيد البريد الإلكتروني - منع الدخول بدون تأكيد
 */

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->model('User');
    }

    /**
     * عرض صفحة تسجيل الدخول
     */
    public function login()
    {
        // إذا كان مسجل دخوله مسبقاً
        if (Auth::check()) {
            if (Auth::isAdmin()) {
                $this->redirect('/admin');
            }
            $this->redirect('/dashboard');
        }

        // توليد كابتشا
        $captcha = Security::generateCaptcha();

        $this->view('auth/login', [
            'title' => 'تسجيل الدخول',
            'captcha' => $captcha
        ]);
    }

    /**
     * معالجة تسجيل الدخول
     */
    public function doLogin()
    {
        $this->verifyCsrf();

        $ip = Security::getClientIp();
        $maxAttempts = defined('MAX_LOGIN_ATTEMPTS') ? MAX_LOGIN_ATTEMPTS : 5;
        $lockoutTime = defined('LOGIN_LOCKOUT_TIME') ? LOGIN_LOCKOUT_TIME : 900;
        $minLength = defined('PASSWORD_MIN_LENGTH') ? PASSWORD_MIN_LENGTH : 8;
        $maxLength = defined('PASSWORD_MAX_LENGTH') ? PASSWORD_MAX_LENGTH : 128;

        // [FIX-07] تعزيز Rate Limiting مع Lockout أطول
        if (!Security::rateLimit('login_' . $ip, $maxAttempts, $lockoutTime / 60)) {
            Session::error('تم تجاوز الحد الأقصى للمحاولات. يرجى المحاولة بعد ' . ceil($lockoutTime / 60) . ' دقيقة');
            $this->redirect('/login');
        }

        $email = $this->input('email');
        $password = $this->input('password');
        $remember = $this->input('remember') === 'on';
        $captchaAnswer = $this->input('captcha_answer');

        // [SEC-01] التحقق من الكابتشا
        if (!Security::verifyCaptcha($captchaAnswer)) {
            Session::error('إجابة مسألة الأمان غير صحيحة');
            $this->back();
        }

        // [FIX-08] التحقق من طول كلمة المرور
        if ($password !== null && (strlen($password) < $minLength || strlen($password) > $maxLength)) {
            Session::error('كلمة المرور يجب أن تكون بين ' . $minLength . ' و ' . $maxLength . ' حرف');
            $this->back();
        }

        // التحقق من البيانات
        $errors = $this->validate($_POST, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!empty($errors)) {
            Session::error(array_values($errors)[0]);
            $this->back();
        }

        // محاولة تسجيل الدخول
        if (Auth::attempt($email, $password, $remember)) {
            // [SEC-02] التحقق من تأكيد البريد الإلكتروني
            $user = Auth::user();
            if (!$user->email_verified && $user->role !== 'admin') {
                // المدير ما يحتاج تأكيد
                Auth::logout();
                session_regenerate_id(true);
                Session::error('يجب تأكيد بريدك الإلكتروني أولاً قبل تسجيل الدخول. يرجى فحص بريدك الإلكتروني لرابط التأكيد');
                $this->redirect('/login');
            }

            // [FIX-11] تجديد Session ID بعد تسجيل الدخول الناجح
            session_regenerate_id(true);

            // مسح عداد المحاولات الفاشلة
            Security::clearRateLimit('login_' . $ip);

            Session::success('تم تسجيل الدخول بنجاح');
            
            // توجيه حسب الدور
            if (Auth::isAdmin()) {
                $this->redirect('/admin');
            } else {
                $this->redirect('/dashboard');
            }
        }

        Session::error('البريد الإلكتروني أو كلمة المرور غير صحيحة');
        $this->back();
    }

    /**
     * عرض صفحة التسجيل
     */
    public function register()
    {
        if (Auth::check()) {
            if (Auth::isAdmin()) {
                $this->redirect('/admin');
            }
            $this->redirect('/dashboard');
        }

        // توليد كابتشا
        $captcha = Security::generateCaptcha();

        $this->view('auth/register', [
            'title' => 'إنشاء حساب جديد',
            'captcha' => $captcha
        ]);
    }

    /**
     * معالجة التسجيل
     */
    public function doRegister()
    {
        $this->verifyCsrf();

        // [FIX-12] Rate Limiting للتسجيل
        if (!Security::rateLimit('register_' . Security::getClientIp(), 3, 5)) {
            Session::error('تم تجاوز الحد الأقصى لطلبات التسجيل. يرجى المحاولة لاحقاً');
            $this->back();
        }

        // [SEC-01] التحقق من الكابتشا
        $captchaAnswer = $this->input('captcha_answer');
        if (!Security::verifyCaptcha($captchaAnswer)) {
            Session::error('إجابة مسألة الأمان غير صحيحة');
            $this->back();
        }

        $data = [
            'full_name' => $this->input('full_name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'password' => $this->input('password'),
            'confirm_password' => $this->input('confirm_password')
        ];

        $minLength = defined('PASSWORD_MIN_LENGTH') ? PASSWORD_MIN_LENGTH : 8;
        $maxLength = defined('PASSWORD_MAX_LENGTH') ? PASSWORD_MAX_LENGTH : 128;

        // التحقق من البيانات
        $errors = $this->validate($data, [
            'full_name' => ['required', 'min:3', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'max:20'],
            'password' => ['required', 'min:' . $minLength],
            'confirm_password' => ['required', 'match:password']
        ]);

        // [FIX-08] التحقق من الحد الأقصى لكلمة المرور
        if (!empty($data['password']) && strlen($data['password']) > $maxLength) {
            $errors['password'] = 'كلمة المرور يجب ألا تتجاوز ' . $maxLength . ' حرف';
        }

        if (!empty($errors)) {
            Session::error(array_values($errors)[0]);
            $this->back();
        }

        // التحقق من وجود البريد
        if ($this->userModel->emailExists($data['email'])) {
            Session::error('البريد الإلكتروني مسجل مسبقاً');
            $this->back();
        }

        // إنشاء المستخدم (غير مفعل - يحتاج تأكيد إيميل)
        $userId = $this->userModel->register([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'status' => 'active',
            'email_verified' => 0
        ]);

        if ($userId) {
            $user = $this->userModel->find($userId);

            // محاولة إرسال إيميل التحقق
            try {
                $emailService = EmailService::getInstance();
                $verificationLink = fullUrl('/verify-email/' . $user->verification_token);
                $emailService->sendVerificationEmail($user, $verificationLink);
            } catch (\Exception $e) {
                if (defined('DEBUG_MODE') && DEBUG_MODE) {
                    error_log('Email verification failed: ' . $e->getMessage());
                }
            }

            // [FIX-11] تجديد Session ID بعد التسجيل
            session_regenerate_id(true);

            // [SEC-02] لا نسجل الدخول تلقائياً - نوجه لصفحة تأكيد البريد
            Session::success('تم إنشاء حسابك بنجاح! يرجى تأكيد بريدك الإلكتروني لتفعيل الحساب');
            $this->redirect('/verification-pending?email=' . urlencode($data['email']));
        }

        Session::error('حدث خطأ أثناء إنشاء الحساب');
        $this->back();
    }

    /**
     * عرض صفحة انتظار تأكيد البريد الإلكتروني
     */
    public function verificationPending()
    {
        // إذا مسجل دخول وبريده مؤكد، وجهه للداشبورد
        if (Auth::check() && Auth::user()->email_verified) {
            $this->redirect('/dashboard');
        }

        $email = isset($_GET['email']) ? urldecode($_GET['email']) : '';

        $this->view('auth/verification-pending', [
            'title' => 'تأكيد البريد الإلكتروني',
            'email' => $email
        ]);
    }

    /**
     * إعادة إرسال إيميل التحقق (بدون تسجيل دخول)
     */
    public function resendVerificationPublic()
    {
        $this->verifyCsrf();

        // Rate Limiting
        $ip = Security::getClientIp();
        if (!Security::rateLimit('verify_public_' . $ip, 2, 5)) {
            Session::error('تم تجاوز الحد الأقصى لإرسال إيميل التحقق. يرجى المحاولة لاحقاً');
            $this->back();
        }

        $email = $this->input('email');

        if (!$email) {
            Session::error('يرجى إدخال البريد الإلكتروني');
            $this->back();
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && !$user->email_verified) {
            // إنشاء رمز تحقق جديد
            $newToken = Security::generateVerificationToken();
            $this->userModel->update($user->id, [
                'verification_token' => $newToken
            ]);
            $user->verification_token = $newToken;

            try {
                $emailService = EmailService::getInstance();
                $verificationLink = fullUrl('/verify-email/' . $newToken);
                $emailService->sendVerificationEmail($user, $verificationLink);
                Session::success('تم إرسال إيميل التحقق بنجاح! تحقق من صندوق البريد');
            } catch (\Exception $e) {
                if (defined('DEBUG_MODE') && DEBUG_MODE) {
                    error_log('Verification email failed: ' . $e->getMessage());
                }
                Session::error('تعذر إرسال الإيميل. تأكد من إعدادات SMTP');
            }
        } else {
            // لا نكشف إذا كان الإيميل موجود أو مؤكد (أمان)
            Session::success('إذا كان البريد غير مؤكد، سيتم إرسال رابط التأكيد إليه');
        }

        $this->back();
    }

    /**
     * تسجيل الخروج
     */
    public function logout()
    {
        Auth::logout();

        // [FIX-11] تجديد Session ID عند الخروج
        session_regenerate_id(true);

        Session::success('تم تسجيل الخروج بنجاح');
        $this->redirect('/');
    }

    /**
     * عرض صفحة نسيت كلمة المرور
     */
    public function forgotPassword()
    {
        // توليد كابتشا
        $captcha = Security::generateCaptcha();

        $this->view('auth/forgot-password', [
            'title' => 'استعادة كلمة المرور',
            'captcha' => $captcha
        ]);
    }

    /**
     * إرسال رابط/OTP استعادة كلمة المرور
     */
    public function sendResetLink()
    {
        $this->verifyCsrf();

        // [SEC-01] التحقق من الكابتشا
        $captchaAnswer = $this->input('captcha_answer');
        if (!Security::verifyCaptcha($captchaAnswer)) {
            Session::error('إجابة مسألة الأمان غير صحيحة');
            $this->back();
        }

        // [FIX-12] Rate Limiting لاستعادة كلمة المرور
        if (!Security::rateLimit('reset_' . Security::getClientIp(), 3, 5)) {
            Session::error('تم تجاوز الحد الأقصى لطلبات الاستعادة. يرجى المحاولة لاحقاً');
            $this->back();
        }

        $email = $this->input('email');

        if (!$email) {
            Session::error('يرجى إدخال البريد الإلكتروني');
            $this->back();
        }

        $token = $this->userModel->createResetToken($email);

        if ($token) {
            // إرسال إيميل استعادة كلمة المرور
            try {
                $user = $this->userModel->findByEmail($email);
                $emailService = EmailService::getInstance();
                $resetLink = fullUrl('/reset-password/' . $token);
                $emailService->sendPasswordResetEmail($user, $resetLink);
                Session::success('تم إرسال رابط الاستعادة إلى بريدك الإلكتروني');
            } catch (\Exception $e) {
                if (defined('DEBUG_MODE') && DEBUG_MODE) {
                    error_log('Password reset email failed: ' . $e->getMessage());
                }
                Session::error('تعذر إرسال الإيميل. تأكد من إعدادات SMTP أو تواصل مع الدعم الفني');
            }
        } else {
            // لا نكشف إذا كان الإيميل موجود أو لا (أمان)
            Session::success('إذا كان البريد مسجلاً، سيتم إرسال رابط الاستعادة إليه');
        }

        $this->redirect('/login');
    }

    /**
     * عرض صفحة إعادة تعيين كلمة المرور
     */
    public function resetPassword($token)
    {
        // [FIX-10] التحقق من صلاحية Token
        if (empty($token) || !preg_match('/^[a-zA-Z0-9]{32,64}$/', $token)) {
            Session::error('رابط الاستعادة غير صالح');
            $this->redirect('/login');
        }

        $user = $this->userModel->verifyResetToken($token);

        if (!$user) {
            Session::error('رابط الاستعادة غير صالح أو منتهي الصلاحية');
            $this->redirect('/login');
        }

        $this->view('auth/reset-password', [
            'title' => 'إعادة تعيين كلمة المرور',
            'token' => $token
        ]);
    }

    /**
     * تحديث كلمة المرور
     */
    public function updatePassword()
    {
        $this->verifyCsrf();

        $token = $this->input('token');
        $password = $this->input('password');
        $confirmPassword = $this->input('confirm_password');

        // [FIX-10] التحقق من صلاحية Token
        if (empty($token) || !preg_match('/^[a-zA-Z0-9]{32,64}$/', $token)) {
            Session::error('رمز الاستعادة غير صالح');
            $this->back();
        }

        if ($password !== $confirmPassword) {
            Session::error('كلمتا المرور غير متطابقتين');
            $this->back();
        }

        // [FIX-08] توحيد التحقق من طول كلمة المرور
        $minLength = defined('PASSWORD_MIN_LENGTH') ? PASSWORD_MIN_LENGTH : 8;
        $maxLength = defined('PASSWORD_MAX_LENGTH') ? PASSWORD_MAX_LENGTH : 128;

        if (strlen($password) < $minLength) {
            Session::error('كلمة المرور يجب أن تكون ' . $minLength . ' أحرف على الأقل');
            $this->back();
        }

        if (strlen($password) > $maxLength) {
            Session::error('كلمة المرور يجب ألا تتجاوز ' . $maxLength . ' حرف');
            $this->back();
        }

        if ($this->userModel->resetPassword($token, $password)) {
            // [FIX-11] تجديد Session ID بعد تغيير كلمة المرور
            session_regenerate_id(true);

            Session::success('تم تحديث كلمة المرور بنجاح');
            $this->redirect('/login');
        }

        Session::error('حدث خطأ أثناء تحديث كلمة المرور');
        $this->back();
    }

    /**
     * تأكيد البريد الإلكتروني
     */
    public function verifyEmail($token)
    {
        // [FIX-10] التحقق من صلاحية Token
        if (empty($token) || !preg_match('/^[a-zA-Z0-9]{32,64}$/', $token)) {
            Session::error('رابط التأكيد غير صالح');
            $this->redirect('/login');
        }

        $user = $this->userModel->verifyEmail($token);

        if ($user) {
            // [FIX-11] تجديد Session ID بعد تأكيد الإيميل
            session_regenerate_id(true);

            // تسجيل الدخول تلقائياً بعد التأكيد
            if (!Auth::check()) {
                Auth::login($user);
            }
            Session::success('تم تأكيد بريدك الإلكتروني بنجاح! مرحباً بك');
            $this->redirect('/dashboard');
        }

        Session::error('رابط التأكيد غير صالح أو منتهي الصلاحية');
        $this->redirect('/login');
    }

    /**
     * إعادة إرسال إيميل التحقق (للمستخدم المسجل)
     */
    public function resendVerification()
    {
        // [FIX-09] إضافة CSRF protection
        $this->verifyCsrf();

        if (!Auth::check()) {
            $this->redirect('/login');
        }

        // [FIX-12] Rate Limiting لإعادة إرسال إيميل التحقق
        if (!Security::rateLimit('verify_email_' . Auth::id(), 2, 5)) {
            Session::error('تم تجاوز الحد الأقصى لإرسال إيميل التحقق. يرجى المحاولة لاحقاً');
            $this->back();
        }

        $user = Auth::user();

        if ($user->email_verified) {
            Session::error('بريدك الإلكتروني مفعّل بالفعل');
            $this->redirect('/dashboard');
        }

        // إنشاء رمز تحقق جديد
        $newToken = Security::generateVerificationToken();
        $this->userModel->update($user->id, [
            'verification_token' => $newToken
        ]);
        $user->verification_token = $newToken;

        try {
            $email = EmailService::getInstance();
            $verificationLink = fullUrl('/verify-email/' . $newToken);
            $email->sendVerificationEmail($user, $verificationLink);
            Session::success('تم إرسال إيميل التحقق بنجاح');
        } catch (\Exception $e) {
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                error_log('Verification email resend failed: ' . $e->getMessage());
            }
            Session::error('تعذر إرسال الإيميل. تأكد من إعدادات SMTP');
        }

        $this->back();
    }
}
