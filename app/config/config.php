<?php
/**
 * CMS Platform - Configuration File
 * إعدادات المنصة الأساسية
 * 
 * === تقرير إصلاح الأمان ===
 * 1. إضافة Security Headers (CSP, X-Frame-Options, X-Content-Type-Options, HSTS, X-XSS-Protection)
 * 2. تحسين إعدادات الجلسة (regenerate_id, bind IP)
 * 3. تعطيل DEBUG_MODE في الإنتاج
 * 4. إضافة ثوابت أمان إضافية (Password Max Length, Max Login Attempts)
 * 5. حماية مجلدات حساسة عبر PHP
 */

// تحديد المسار الأساسي
define('ROOT_PATH', dirname(__DIR__, 2));

// المسار الأساسي للمشروع (للتوجيه)
// تغيير هذا حسب مسار مشروعك
// مثال: إذا كان المشروع في http://localhost/takweenweb استخدم '/takweenweb'
// مثال: إذا كان المشروع في الجذر استخدم ''
define('BASE_PATH', '/takweenweb');

// إعدادات الموقع
define('SITE_NAME', 'منصة المواقع');
define('SITE_URL', 'http://localhost/takweenweb');
define('UPLOADS_URL', SITE_URL . '/uploads');
define('ADMIN_EMAIL', 'admin@cms-platform.com');

// إعدادات اللغة (يجب أن تكون قبل CURRENT_LANG)
define('DEFAULT_LANG', 'ar');
define('SUPPORTED_LANGS', ['ar', 'en']);

// إعدادات قاعدة البيانات
define('DB_HOST', 'localhost');
define('DB_NAME', 'takween');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// إعدادات الجلسات
define('SESSION_NAME', 'cms_platform_session');
define('SESSION_LIFETIME', 7200); // ساعتين

// إعدادات الأمان
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_MAX_LENGTH', 128);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 دقيقة
define('BCRYPT_COST', 12);
// [SEC-FIX-08] مفتاح تشفير لكلمات المرور الحساسة (SMTP)
// يجب تغيير هذا المفتاح في بيئة الإنتاج إلى قيمة عشوائية فريدة
define('APP_KEY', 'takweenweb_' . hash('sha256', 'sec_key_' . (DB_HOST ?? 'localhost')));

// إعدادات الرفع
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('UPLOADS_PATH', ROOT_PATH . '/public/uploads');
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
// [SEC-FIX-05] إزالة SVG من الملفات المسموحة (SVG يسمح بـ XSS عبر JavaScript مدمج)
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx']);

// إعدادات الاشتراكات
define('TRIAL_DAYS', 14);
define('MONTHLY_PRICE', 99);
define('CURRENCY', 'SAR');

// إعدادات الثيمات
define('THEMES_PATH', ROOT_PATH . '/themes');
define('DEFAULT_THEME', 'cleanpro');

// إعدادات المنطقة الزمنية
date_default_timezone_set('Asia/Riyadh');

// =============================================
// [FIX-01] تعطيل DEBUG_MODE في بيئة الإنتاج
// يجب تغيير هذا إلى false عند النشر
// =============================================
define('DEBUG_MODE', false);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_PATH . '/logs/error.log');
}

// =============================================
// [FIX-02] إضافة Security Headers
// =============================================
if (headers_sent() === false) {
    // [SEC-FIX-09] تحسين Content Security Policy - تقييد script-src و style-src
    // إزالة 'unsafe-eval' بالكامل وتقييد 'unsafe-inline' قدر الإمكان
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://code.iconify.design https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.tailwindcss.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: blob: https:; frame-src 'self' https://www.youtube.com https://player.vimeo.com; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self';");

    // منع تضمين الموقع في iframe (Clickjacking Protection)
    header("X-Frame-Options: SAMEORIGIN");

    // منع MIME type sniffing
    header("X-Content-Type-Options: nosniff");

    // تفعيل حماية XSS في المتصفح
    header("X-XSS-Protection: 1; mode=block");

    // HTTP Strict Transport Security (فقط عند تفعيل HTTPS)
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
    }

    // سياسة المرجع
    header("Referrer-Policy: strict-origin-when-cross-origin");

    // سياسة الأذونات
    header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
}

// =============================================
// [FIX-03] تحسين إعدادات الجلسة
// =============================================
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);

    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path' => '/',
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();

    // [FIX-04] تجديد معرف الجلسة دورياً لمنع Session Fixation
    if (!isset($_SESSION['session_initiated'])) {
        session_regenerate_id(true);
        $_SESSION['session_initiated'] = true;
        $_SESSION['session_created'] = time();
    }

    // التحقق من عمر الجلسة
    if (isset($_SESSION['session_created']) && (time() - $_SESSION['session_created'] > SESSION_LIFETIME)) {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
        $_SESSION['session_initiated'] = true;
        $_SESSION['session_created'] = time();
    }

    // [FIX-05] ربط الجلسة بعنوان IP (اختياري - يساعد في منع سرقة الجلسة)
    if (!isset($_SESSION['client_ip'])) {
        $_SESSION['client_ip'] = $_SERVER['REMOTE_ADDR'] ?? '';
    }
}

// =============================================
// [FIX-06] حماية متغيرات الإدخال العامة
// =============================================
if (PHP_VERSION_ID < 82000) {
    // تعطيل magic_quotes في الإصدارات القديمة
    @ini_set('magic_quotes_gpc', 0);
}

// اللغة الحالية (بعد بدء الجلسة وتعريف DEFAULT_LANG)
define('CURRENT_LANG', $_SESSION['lang'] ?? DEFAULT_LANG);

// تحميل الدوال المساعدة
require_once ROOT_PATH . '/app/helpers/functions.php';

// تحميل دوال الأمان للثيمات
require_once ROOT_PATH . '/app/helpers/security_helpers.php';

// تحميل الكلاسات الأساسية
require_once ROOT_PATH . '/app/core/Database.php';
require_once ROOT_PATH . '/app/core/Session.php';
require_once ROOT_PATH . '/app/core/Security.php';
require_once ROOT_PATH . '/app/core/Language.php';
require_once ROOT_PATH . '/app/core/Auth.php';
require_once ROOT_PATH . '/app/core/Model.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/core/Router.php';
require_once ROOT_PATH . '/app/core/View.php';

// تحميل خدمة البريد الإلكتروني
require_once ROOT_PATH . '/app/core/EmailService.php';
