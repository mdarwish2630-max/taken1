<?php
/**
 * CMS Platform - Authentication Class
 * كلاس المصادقة وإدارة المستخدمين
 */

class Auth
{
    private static $user = null;
    private static $tenant = null;

    /**
     * محاولة تسجيل الدخول
     */
    public static function attempt($email, $password, $remember = false)
    {
        $db = Database::getInstance();
        
        $user = $db->query(
            "SELECT * FROM users WHERE email = ? AND status = 'active'",
            [$email]
        )->first();
        
        if ($user && Security::verifyPassword($password, $user->password)) {
            self::login($user, $remember);
            return true;
        }
        
        return false;
    }

    /**
     * تسجيل دخول المستخدم
     */
    public static function login($user, $remember = false)
    {
        // تحديث آخر تسجيل دخول
        $db = Database::getInstance();
        $db->query(
            "UPDATE users SET last_login = NOW() WHERE id = ?",
            [$user->id]
        );
        
        // حفظ بيانات المستخدم في الجلسة
        Session::put('user_id', $user->id);
        Session::put('user_email', $user->email);
        Session::put('user_role', $user->role);
        Session::put('user_name', $user->full_name);
        
        // تجديد الجلسة للأمان
        Session::regenerate();
        
        // تحميل بيانات المستخدم
        self::$user = $user;
        
        // إذا كان المستخدم عميل، تحميل بيانات الموقع
        if ($user->role === 'customer') {
            self::loadTenant($user->id);
        }
        
        // تذكرني
        if ($remember) {
            self::setRememberCookie($user->id);
        }
    }

    /**
     * تسجيل الخروج
     */
    public static function logout()
    {
        // حذف كوكي التذكر
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // تدمير الجلسة
        Session::destroy();
        
        self::$user = null;
        self::$tenant = null;
    }

    /**
     * التحقق من تسجيل الدخول
     */
    public static function check()
    {
        return Session::has('user_id') || self::checkRememberToken();
    }

    /**
     * التحقق من كون المستخدم زائر
     */
    public static function guest()
    {
        return !self::check();
    }

    /**
     * الحصول على المستخدم الحالي
     */
    public static function user()
    {
        if (self::$user === null && self::check()) {
            $db = Database::getInstance();
            self::$user = $db->query(
                "SELECT * FROM users WHERE id = ?",
                [Session::get('user_id')]
            )->first();
        }
        
        return self::$user;
    }

    /**
     * الحصول على معرف المستخدم
     */
    public static function id()
    {
        return Session::get('user_id');
    }

    /**
     * الحصول على دور المستخدم
     */
    public static function role()
    {
        return Session::get('user_role');
    }

    /**
     * التحقق من كون المستخدم مدير
     */
    public static function isAdmin()
    {
        return self::role() === 'admin';
    }

    /**
     * التحقق من كون المستخدم عميل
     */
    public static function isCustomer()
    {
        return self::role() === 'customer';
    }

    /**
     * تحميل بيانات الموقع للعميل
     */
    private static function loadTenant($userId)
    {
        $db = Database::getInstance();
        self::$tenant = $db->query(
            "SELECT t.*, th.slug as theme_slug 
             FROM tenants t 
             LEFT JOIN themes th ON t.theme_id = th.id 
             WHERE t.user_id = ?",
            [$userId]
        )->first();
        
        if (self::$tenant) {
            Session::put('tenant_id', self::$tenant->id);
            Session::put('tenant_slug', self::$tenant->slug);
        }
    }

    /**
     * الحصول على بيانات الموقع
     */
    public static function tenant()
    {
        if (self::$tenant === null && self::isCustomer()) {
            self::loadTenant(self::id());
        }
        
        return self::$tenant;
    }

    /**
     * تحديث بيانات الموقع المخزنة مؤقتاً
     * يستخدم بعد تغيير الثيم أو الإعدادات
     */
    public static function refreshTenant()
    {
        if (self::isCustomer()) {
            self::$tenant = null;
            self::loadTenant(self::id());
        }
    }

    /**
     * الحصول على معرف الموقع
     */
    public static function tenantId()
    {
        return Session::get('tenant_id');
    }

    /**
     * التحقق من صلاحية الوصول للموقع
     */
    public static function canAccessTenant($tenantId)
    {
        if (self::isAdmin()) {
            return true;
        }
        
        return self::tenantId() == $tenantId;
    }

    /**
     * التحقق من صلاحية معينة
     */
    public static function can($permission)
    {
        // المدير لديه كل الصلاحيات
        if (self::isAdmin()) {
            return true;
        }
        
        // يمكن إضافة نظام صلاحيات متقدم لاحقاً
        $permissions = [
            'manage_site' => true,
            'edit_content' => true,
            'manage_media' => true,
            'view_analytics' => true,
        ];
        
        return $permissions[$permission] ?? false;
    }

    /**
     * تعيين كوكي "تذكرني"
     */
    private static function setRememberCookie($userId)
    {
        $token = Security::generateToken();
        $hash = hash('sha256', $token);
        
        // حفظ الـ token في قاعدة البيانات
        $db = Database::getInstance();
        $db->query(
            "UPDATE users SET remember_token = ? WHERE id = ?",
            [$hash, $userId]
        );
        
        // تعيين الكوكي
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') == 443;
        setcookie(
            'remember_token',
            $userId . ':' . $token,
            time() + (86400 * 30), // 30 يوم
            '/',
            '',
            $isSecure,
            true
        );
    }

    /**
     * التحقق من كوكي "تذكرني"
     */
    private static function checkRememberToken()
    {
        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }
        
        $parts = explode(':', $_COOKIE['remember_token']);
        if (count($parts) !== 2) {
            return false;
        }
        
        list($userId, $token) = $parts;
        $hash = hash('sha256', $token);
        
        $db = Database::getInstance();
        $user = $db->query(
            "SELECT * FROM users WHERE id = ? AND remember_token = ? AND status = 'active'",
            [$userId, $hash]
        )->first();
        
        if ($user) {
            // [SEC-FIX-17] Verify email before allowing remember-me auto-login
            if (empty($user->email_verified)) {
                return false;
            }
            self::login($user);
            return true;
        }
        
        return false;
    }

    /**
     * التحقق من حالة الاشتراك
     */
    public static function hasActiveSubscription()
    {
        $tenant = self::tenant();
        
        if (!$tenant) {
            return false;
        }
        
        return in_array($tenant->subscription_status, ['trial', 'active']);
    }

    /**
     * التحقق من انتهاء الاشتراك
     */
    public static function subscriptionExpired()
    {
        $tenant = self::tenant();
        
        if (!$tenant) {
            return true;
        }
        
        return $tenant->subscription_status === 'expired';
    }
}
