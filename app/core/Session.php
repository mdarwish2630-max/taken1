<?php
/**
 * CMS Platform - Session Class
 * كلاس إدارة الجلسات
 */

class Session
{
    /**
     * وضع قيمة في الجلسة
     */
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * الحصول على قيمة من الجلسة
     */
    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set rate limit timestamp for a given action key.
     * Stores the current time as the last attempt time and increments the attempt counter.
     * @param string $key The rate limit key (e.g. 'login_attempts', 'api_request')
     * @param int $window Window in seconds for the rate limit check
     * @return void
     */
    public static function setRateLimit($key, $window = 60)
    {
        $now = time();
        $rateKey = 'rate_limit_' . $key;

        if (!self::has($rateKey)) {
            self::put($rateKey, [
                'attempts' => 1,
                'first_attempt' => $now,
                'last_attempt' => $now
            ]);
        } else {
            $data = self::get($rateKey);
            // Reset window if expired
            if (($now - $data['first_attempt']) > $window) {
                $data = [
                    'attempts' => 1,
                    'first_attempt' => $now,
                    'last_attempt' => $now
                ];
            } else {
                $data['attempts']++;
                $data['last_attempt'] = $now;
            }
            self::put($rateKey, $data);
        }
    }

    /**
     * Check if rate limit is exceeded for a given action key.
     * @param string $key The rate limit key
     * @param int $maxAttempts Maximum allowed attempts within the window
     * @param int $window Window in seconds
     * @return bool True if rate limit is exceeded
     */
    public static function isRateLimited($key, $maxAttempts = 5, $window = 60)
    {
        $rateKey = 'rate_limit_' . $key;
        $data = self::get($rateKey);

        if (!$data) {
            return false;
        }

        // Reset if window expired
        if ((time() - $data['first_attempt']) > $window) {
            self::forget($rateKey);
            return false;
        }

        return $data['attempts'] >= $maxAttempts;
    }

    /**
     * Get the remaining time in seconds before the rate limit window resets.
     * @param string $key The rate limit key
     * @param int $window Window in seconds
     * @return int Seconds remaining, or 0 if not rate limited
     */
    public static function getRateLimitResetTime($key, $window = 60)
    {
        $rateKey = 'rate_limit_' . $key;
        $data = self::get($rateKey);

        if (!$data) {
            return 0;
        }

        $remaining = $window - (time() - $data['first_attempt']);
        return max(0, $remaining);
    }

    /**
     * Clear rate limit data for a given action key.
     * @param string $key The rate limit key
     * @return void
     */
    public static function clearRateLimit($key)
    {
        self::forget('rate_limit_' . $key);
    }

    /**
     * التحقق من وجود مفتاح في الجلسة
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * حذف قيمة من الجلسة
     */
    public static function forget($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * حذف جميع بيانات الجلسة
     */
    public static function flush()
    {
        $_SESSION = [];
    }

    /**
     * تدمير الجلسة
     */
    public static function destroy()
    {
        self::flush();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        session_destroy();
    }

    /**
     * إ regenerated جلسة
     */
    public static function regenerate()
    {
        session_regenerate_id(true);
    }

    /**
     * وضع رسالة فلاش
     */
    public static function flash($key, $message = null)
    {
        if ($message === null) {
            $message = self::get($key);
            self::forget($key);
            return $message;
        }
        
        self::put($key, $message);
    }

    /**
     * الحصول على رسالة فلاش وحذفها
     */
    public static function getFlash($key, $default = null)
    {
        $value = self::get($key, $default);
        self::forget($key);
        return $value;
    }

    /**
     * وضع رسالة نجاح
     */
    public static function success($message)
    {
        self::put('success', $message);
    }

    /**
     * وضع رسالة خطأ
     */
    public static function error($message)
    {
        self::put('error', $message);
    }

    /**
     * وضع رسالة تحذير
     */
    public static function warning($message)
    {
        self::put('warning', $message);
    }

    /**
     * وضع رسالة معلومات
     */
    public static function info($message)
    {
        self::put('info', $message);
    }

    /**
     * الحصول على جميع رسائل الفلاش
     */
    public static function getMessages()
    {
        $messages = [];
        
        foreach (['success', 'error', 'warning', 'info'] as $type) {
            if (self::has($type)) {
                $messages[$type] = self::getFlash($type);
            }
        }
        
        return $messages;
    }

    /**
     * الحصول على رسالة النجاح وحذفها
     */
    public static function getSuccess()
    {
        return self::getFlash('success', '');
    }

    /**
     * الحصول على رسالة الخطأ وحذفها
     */
    public static function getError()
    {
        return self::getFlash('error', '');
    }
}
