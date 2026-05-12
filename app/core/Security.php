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
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
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
        $cacheKey = 'rate_limit_' . $key;
        $now = time();
        $decaySeconds = $decayMinutes * 60;
        
        $data = Session::get($cacheKey, ['attempts' => 0, 'first_attempt' => 0]);
        
        // Reset if decay time has passed
        if ($data['first_attempt'] > 0 && ($now - $data['first_attempt']) > $decaySeconds) {
            $data = ['attempts' => 0, 'first_attempt' => 0];
        }
        
        if ($data['attempts'] >= $maxAttempts) {
            return false;
        }
        
        $data['attempts']++;
        if ($data['first_attempt'] === 0) {
            $data['first_attempt'] = $now;
        }
        
        Session::put($cacheKey, $data);
        return true;
    }

    /**
     * إعادة تعيين Rate Limit
     */
    public static function clearRateLimit($key)
    {
        Session::forget('rate_limit_' . $key);
    }

    /**
     * توليد سؤال كابتشا رياضي
     * يُرجع مصفوفة تحتوي: question (النص المعروض), answer (الإجابة الصحيحة)
     */
    public static function generateCaptcha()
    {
        $operations = ['+', '-', '×'];
        $op = $operations[array_rand($operations)];

        switch ($op) {
            case '+':
                $a = rand(1, 20);
                $b = rand(1, 20);
                $answer = $a + $b;
                break;
            case '-':
                $a = rand(5, 30);
                $b = rand(1, $a - 1); // نتأكد الناتج موجب
                $answer = $a - $b;
                break;
            case '×':
                $a = rand(2, 9);
                $b = rand(2, 9);
                $answer = $a * $b;
                break;
        }

        // نص السؤال بالعربية
        $questionAr = $a . ' ' . $op . ' ' . $b . ' = ?';

        // حفظ الإجابة وبيانات السؤال في الجلسة
        Session::put('captcha_answer', $answer);
        Session::put('captcha_time', time());
        Session::put('captcha_question', $questionAr);
        Session::put('captcha_a', $a);
        Session::put('captcha_b', $b);
        Session::put('captcha_op', $op);

        return [
            'question' => $questionAr,
            'a' => $a,
            'b' => $b,
            'op' => $op
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
        Session::forget('captcha_question');
        Session::forget('captcha_a');
        Session::forget('captcha_b');
        Session::forget('captcha_op');

        // مقارنة الإجابة
        return $userAnswer !== null && intval($userAnswer) === intval($storedAnswer);
    }

    /**
     * الحصول على سؤال الكابتشا الحالي بدون توليد جديد
     */
    public static function getCurrentCaptcha()
    {
        $answer = Session::get('captcha_answer');
        if ($answer === null) {
            return self::generateCaptcha();
        }

        // إذا الكابتشا منتهية (أكثر من 10 دقائق)، ولّد واحد جديد
        $captchaTime = Session::get('captcha_time', 0);
        if (time() - $captchaTime > 600) {
            return self::generateCaptcha();
        }

        // نرجع نفس السؤال الحالي (نولّد نص السؤال من الإجابة المحفوظة)
        // ملاحظة: للحصول على النص الأصلي، نحفظه أيضاً
        return [
            'question' => Session::get('captcha_question', ''),
            'a' => Session::get('captcha_a', 0),
            'b' => Session::get('captcha_b', 0),
            'op' => Session::get('captcha_op', '+')
        ];
    }
}
