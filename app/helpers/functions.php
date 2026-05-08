<?php
/**
 * CMS Platform - Helper Functions
 * الدوال المساعدة العامة
 */

/**
 * ترجمة النصوص
 * ملاحظة: دالة lang() موجودة في app/core/Language.php
 */
function __($key, $default = '')
{
    return Language::get($key, $default);
}

/**
 * الحصول على قيمة الإعداد
 */
function setting($key, $default = null)
{
    static $settings = null;
    
    if ($settings === null) {
        $settings = [];
        try {
            $db = Database::getInstance();
            $results = $db->query("SELECT setting_key, setting_value FROM settings")->results();
            if (is_iterable($results)) {
                foreach ($results as $row) {
                    $settings[$row->setting_key] = $row->setting_value;
                }
            }
        } catch (\Exception $e) {
            // إذا فشلت قاعدة البيانات، نرجع القيمة الافتراضية
        }
    }
    
    return $settings[$key] ?? $default;
}

/**
 * إنشاء رابط
 */
function url($path = '')
{
    return SITE_URL . ($path ? '/' . ltrim($path, '/') : '');
}

/**
 * إنشاء رابط للأصول
 */
function asset($path)
{
    return SITE_URL . '/public/assets/' . $path;
}

/**
 * إنشاء رابط للرفعات
 */
function upload($path)
{
    if (!$path) {
        return asset('images/placeholder.png');
    }
    return SITE_URL . '/uploads/' . $path;
}

/**
 * حقل CSRF المخفي للاستمارات
 */
function csrf_field()
{
    return Security::csrfField();
}

/**
 * إخراج آمن
 */
function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * الحصول على المستخدم الحالي
 */
function user()
{
    return Auth::user();
}

/**
 * الحصول على بيانات الموقع
 */
function tenant()
{
    return Auth::tenant();
}

/**
 * التحقق من تسجيل الدخول
 */
function auth()
{
    return Auth::check();
}

/**
 * الحصول على رسائل الفلاش
 */
function flash($type = null)
{
    if ($type) {
        return Session::getFlash($type);
    }
    return Session::getMessages();
}

/**
 * التحقق من وجود رسالة فلاش
 */
function hasFlash($type)
{
    return Session::has($type);
}

/**
 * تنسيق التاريخ
 */
function formatDate($date, $format = 'Y-m-d')
{
    if (!$date || $date == '0000-00-00') return '';
    return date($format, strtotime($date));
}

/**
 * تنسيق السعر
 */
function formatPrice($price, $currency = 'SAR')
{
    $formatted = number_format($price, 2);
    $symbols = [
        'SAR' => 'ر.س',
        'USD' => '$',
        'EUR' => '€',
    ];
    return $formatted . ' ' . ($symbols[$currency] ?? $currency);
}

/**
 * توليد slug من نص
 */
function generateSlug($text, $separator = '-')
{
    // تحويل للأحرف الصغيرة
    $text = mb_strtolower($text, 'UTF-8');
    
    // استبدال المسافات
    $text = str_replace(' ', $separator, $text);
    
    // إزالة الأحرف الخاصة
    $text = preg_replace('/[^a-z0-9\-\p{Arabic}]/u', '', $text);
    
    // إزالة الـ separators المتكررة
    $text = preg_replace('/' . $separator . '+/', $separator, $text);
    
    return trim($text, $separator);
}

/**
 * توليد slug فريد
 */
function generateUniqueSlug($text, $table, $column = 'slug', $excludeId = null)
{
    $db = Database::getInstance();
    $baseSlug = generateSlug($text);
    $slug = $baseSlug;
    $counter = 1;
    
    while (true) {
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
        $params = [$slug];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $db->query($sql, $params)->first();
        
        if ($result->count == 0) {
            return $slug;
        }
        
        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }
}

/**
 * اقتطاع نص
 */
function truncate($text, $length = 100, $suffix = '...')
{
    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length, 'UTF-8') . $suffix;
}

/**
 * تحويل JSON إلى مصفوفة
 */
function jsonDecode($json, $assoc = true)
{
    return json_decode($json, $assoc);
}

/**
 * تحويل مصفوفة إلى JSON
 */
function jsonEncode($data)
{
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}

/**
 * التحقق من طلب AJAX
 */
function isAjax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * إرسال استجابة JSON
 */
function jsonResponse($data, $code = 200)
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * تصحيح متغير
 */
function dd($data)
{
    echo '<pre dir="ltr">';
    var_dump($data);
    echo '</pre>';
    die;
}

/**
 * طباعة متغير
 */
function dump($data)
{
    echo '<pre dir="ltr">';
    var_dump($data);
    echo '</pre>';
}

/**
 * الحصول على القيمة من مصفوفة
 */
function array_get($array, $key, $default = null)
{
    return $array[$key] ?? $default;
}

/**
 * تحديد قيمة في مصفوفة
 */
function array_set(&$array, $key, $value)
{
    $array[$key] = $value;
}

/**
 * التحقق من قيمة حقيقية
 */
function array_has($array, $key)
{
    return isset($array[$key]);
}

/**
 * إنشاء كلمة مرور عشوائية
 */
function randomPassword($length = 12)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    return substr(str_shuffle($chars), 0, $length);
}

/**
 * الحصول على المحتوى ثنائي اللغة من كائن
 * يُرجع الحقل الإنجليزي إذا كانت اللغة الحالية إنجليزية والحقل موجود، وإلا يُرجع الحقل العربي
 *
 * @param object $object الكائن (service, banner, gallery, etc.)
 * @param string $field اسم الحقل الأساسي (title, description, content, etc.)
 * @return string
 */
function localized($object, $field)
{
    if (!$object) return '';
    
    $currentLang = Language::current();
    
    // إذا كانت اللغة الإنجليزية، نحاول الحصول على الحقل الإنجليزي
    if ($currentLang === 'en') {
        $enField = $field . '_en';
        // إذا كان الحقل الإنجليزي موجود وليس فارغ
        if (isset($object->$enField) && !empty($object->$enField)) {
            return $object->$enField;
        }
    }
    
    // إرجاع الحقل الافتراضي (العربي)
    return $object->$field ?? '';
}

/**
 * إرسال بريد إلكتروني
 * يستخدم EmailService مع SMTP إذا كان مُعداً، أو mail() كاحتياطي
 */
function sendMail($to, $subject, $message, $headers = [])
{
    try {
        $email = EmailService::getInstance();
        return $email->send($to, $subject, $message);
    } catch (\Exception $e) {
        // Fallback: mail() الأساسية
        $defaultHeaders = [
            'From: ' . (setting('smtp_from_email') ?? ADMIN_EMAIL),
            'Content-Type: text/html; charset=UTF-8',
        ];
        $headers = array_merge($defaultHeaders, $headers);
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
}

/**
 * إنشاء رابط كامل
 */
function fullUrl($path = '')
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . url($path);
}

/**
 * إعادة توجيه
 */
function redirect($url)
{
    header('Location: ' . url($url));
    exit;
}

/**
 * إعادة توجيه مع رسالة
 */
function redirectWith($url, $type, $message)
{
    Session::flash($type, $message);
    redirect($url);
}
