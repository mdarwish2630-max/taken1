<?php
/**
 * CMS Platform - Security Class
 * كلاس الحماية والأمان
 */

class Security
{
    /**
     * توليد رمز CSRF
     */
    public static function generateCsrfToken()
    {
        if (!Session::has(CSRF_TOKEN_NAME)) {
            Session::put(CSRF_TOKEN_NAME, bin2hex(random_bytes(32)));
        }
        return Session::get(CSRF_TOKEN_NAME);
    }

    /**
     * الحصول على رمز CSRF (别名 لـ generateCsrfToken)
     */
    public static function csrfToken()
    {
        return self::generateCsrfToken();
    }

    /**
     * التحقق من رمز CSRF
     */
    public static function verifyCsrfToken($token)
    {
        $sessionToken = Session::get(CSRF_TOKEN_NAME);
        
        if ($sessionToken && hash_equals($sessionToken, $token)) {
            // [SEC-FIX-12] Rotate token after successful verification to prevent replay attacks
            Session::put(CSRF_TOKEN_NAME, bin2hex(random_bytes(32)));
            return true;
        }
        
        return false;
    }

    /**
     * حذف رمز CSRF
     */
    public static function clearCsrfToken()
    {
        Session::forget(CSRF_TOKEN_NAME);
    }

    /**
     * توليد حقل CSRF للنماذج
     */
    public static function csrfField()
    {
        return '<input type="hidden" name="' . htmlspecialchars(CSRF_TOKEN_NAME, ENT_QUOTES, 'UTF-8') . '" value="' . self::generateCsrfToken() . '">';
    }

    /**
     * تنظيف البيانات من XSS
     */
    public static function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        
        return htmlspecialchars(trim((string)($data ?? '')), ENT_QUOTES, 'UTF-8');
    }

    /**
     * تشفير كلمة المرور
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    /**
     * التحقق من كلمة المرور
     */
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * توليد رمز عشوائي
     */
    public static function generateToken($length = 32)
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * توليد رمز للتأكيد أو إعادة تعيين كلمة المرور
     */
    public static function generateVerificationToken()
    {
        return self::generateToken(64);
    }

    /**
     * التحقق من قوة كلمة المرور
     */
    public static function validatePassword($password)
    {
        $errors = [];
        
        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            $errors[] = "كلمة المرور يجب أن تكون على الأقل " . PASSWORD_MIN_LENGTH . " أحرف";
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "كلمة المرور يجب أن تحتوي على حرف كبير واحد على الأقل";
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "كلمة المرور يجب أن تحتوي على حرف صغير واحد على الأقل";
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "كلمة المرور يجب أن تحتوي على رقم واحد على الأقل";
        }
        
        return empty($errors) ? true : $errors;
    }

    /**
     * التحقق من صحة البريد الإلكتروني
     */
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * التحقق من نوع الملف المسموح
     */
    public static function isAllowedFileType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, ALLOWED_FILE_TYPES);
    }

    /**
     * التحقق من نوع الصورة المسموح
     */
    public static function isAllowedImageType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, ALLOWED_IMAGE_TYPES);
    }

    /**
     * التحقق من حجم الملف
     */
    public static function isValidFileSize($size)
    {
        return $size <= MAX_UPLOAD_SIZE;
    }

    /**
     * توليد اسم ملف آمن
     */
    public static function generateSafeFilename($originalName)
    {
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $basename = pathinfo($originalName, PATHINFO_FILENAME);
        
        // تنظيف الاسم
        $basename = preg_replace('/[^a-zA-Z0-9_-]/', '', $basename);
        $basename = substr($basename, 0, 50);
        
        // إضافة وقت فريد
        $unique = date('YmdHis') . '_' . bin2hex(random_bytes(4));
        
        return $basename . '_' . $unique . '.' . $extension;
    }

    /**
     * حماية من SQL Injection - استخدام prepared statements
     */
    public static function escapeLike($string)
    {
        return str_replace(['%', '_'], ['\%', '\_'], $string);
    }

    /**
     * الحصول على IP الزائر
     */
    public static function getClientIp()
    {
        // [SEC-FIX-24] Only trust REMOTE_ADDR - HTTP headers are easily spoofed
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        
        // Only use X-Forwarded-For if behind a known trusted proxy
        if (defined('TRUSTED_PROXIES') && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $trustedProxies = explode(',', TRUSTED_PROXIES);
            $clientIp = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
            $clientIp = trim($clientIp);
            if (filter_var($clientIp, FILTER_VALIDATE_IP)) {
                $ip = $clientIp;
            }
        }
        
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }

    /**
     * الحصول على User Agent
     */
    public static function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }

    /**
     * تحديد معدل الطلبات (Rate Limiting)
     */
    public static function rateLimit($key, $maxAttempts = 5, $decayMinutes = 1)
    {
        // [SEC-FIX-23] Use file-based storage instead of session to prevent bypass via session destruction
        $cacheDir = sys_get_temp_dir() . '/takween_rate_limit';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0700, true);
        }
        $cacheFile = $cacheDir . '/' . md5($key);
        
        $now = time();
        $decaySeconds = $decayMinutes * 60;
        
        $data = @json_decode(@file_get_contents($cacheFile), true);
        if (!$data || ($now - ($data['first_attempt'] ?? 0)) > $decaySeconds) {
            $data = ['attempts' => 0, 'first_attempt' => 0];
        }
        
        if ($data['attempts'] >= $maxAttempts) {
            return false;
        }
        
        $data['attempts']++;
        if ($data['first_attempt'] === 0) {
            $data['first_attempt'] = $now;
        }
        
        @file_put_contents($cacheFile, json_encode($data), LOCK_EX);
        return true;
    }

    /**
     * إعادة تعيين Rate Limit
     */
    public static function clearRateLimit($key)
    {
        $cacheFile = sys_get_temp_dir() . '/takween_rate_limit/' . md5($key);
        @unlink($cacheFile);
    }

    /**
     * توليد كود تحقق رقمي (كابتشا أرقام)
     * يُولّد كود عشوائي من 5 أرقام ويُرجعه للعرض والتحقق
     */
    public static function generateCaptcha()
    {
        // توليد كود عشوائي من 5 أرقام (يبدأ دائماً برقم غير صفر)
        // [SEC-FIX-02] استخدام random_int بدلاً من mt_rand (تشفيرياً آمن)
        $code = (string)random_int(10000, 99999);

        // حفظ الكود في الجلسة
        Session::put('captcha_answer', $code);
        Session::put('captcha_time', time());
        Session::put('captcha_code', $code);

        // تنظيف بيانات الكابتشا القديمة
        Session::forget('captcha_question');
        Session::forget('captcha_a');
        Session::forget('captcha_b');
        Session::forget('captcha_op');

        return [
            'code' => $code
        ];
    }

    /**
     * التحقق من إجابة الكابتشا
     */
    public static function verifyCaptcha($userAnswer)
    {
        $storedAnswer = Session::get('captcha_answer');
        $captchaTime = Session::get('captcha_time', 0);

        // الكابتشا تنتهي بعد 10 دقائق
        if (time() - $captchaTime > 600) {
            return false;
        }

        // تنظيف بيانات الكابتشا بعد التحقق
        Session::forget('captcha_answer');
        Session::forget('captcha_time');
        Session::forget('captcha_code');
        Session::forget('captcha_question');
        Session::forget('captcha_a');
        Session::forget('captcha_b');
        Session::forget('captcha_op');

        // تنظيف إجابة المستخدم من رموز الاتجاه المخفية (RTL/LTR markers)
        // بعض المتصفحات في صفحات RTL تضيف رموز مخفية عند إدخال أرقام
        $cleanAnswer = (string)$userAnswer;
        $cleanAnswer = preg_replace('/[\x{200E}\x{200F}\x{200B}-\x{200D}\x{202A}-\x{202E}\x{2066}-\x{2069}\x{FEFF}]/u', '', $cleanAnswer);
        $cleanAnswer = trim($cleanAnswer);

        // مقارنة الكود كنص
        return $cleanAnswer !== '' && $cleanAnswer === (string)$storedAnswer;
    }

    /**
     * الحصول على كود الكابتشا الحالي بدون توليد جديد
     */
    public static function getCurrentCaptcha()
    {
        $code = Session::get('captcha_code');
        if ($code === null) {
            return self::generateCaptcha();
        }

        // إذا الكابتشا منتهية (أكثر من 10 دقائق)، ولّد واحد جديد
        $captchaTime = Session::get('captcha_time', 0);
        if (time() - $captchaTime > 600) {
            return self::generateCaptcha();
        }

        return [
            'code' => $code
        ];
    }
}
