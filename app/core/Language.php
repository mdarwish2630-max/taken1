<?php
/**
 * CMS Platform - Language Class
 * كلاس إدارة اللغات
 */

class Language
{
    private static $instance = null;
    private $currentLang = 'ar';
    private $translations = [];
    private $supportedLangs = ['ar', 'en'];
    
    /**
     * الحصول على نسخة وحيدة
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * المنشئ
     */
    private function __construct()
    {
        // تحديد اللغة الحالية
        $this->determineLanguage();
        
        // تحميل ملفات الترجمة
        $this->loadTranslations();
    }
    
    /**
     * تحديد اللغة الحالية
     */
    private function determineLanguage()
    {
        // 1. من الجلسة (أولوية للمستخدم المسجل)
        if (Session::has('lang') && in_array(Session::get('lang'), $this->supportedLangs)) {
            $this->currentLang = Session::get('lang');
            return;
        }
        
        // 2. من إعدادات الموقع (للمواقع الفرعية)
        if (Session::has('tenant_lang') && in_array(Session::get('tenant_lang'), $this->supportedLangs)) {
            $this->currentLang = Session::get('tenant_lang');
            return;
        }
        
        // 3. من الكوكي
        if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $this->supportedLangs)) {
            $this->currentLang = $_COOKIE['lang'];
            return;
        }
        
        // 4. الافتراضية (العربية)
        $this->currentLang = 'ar';
    }
    
    /**
     * تحميل ملفات الترجمة
     */
    private function loadTranslations()
    {
        $langFile = ROOT_PATH . '/app/lang/' . $this->currentLang . '.php';
        
        if (file_exists($langFile)) {
            $this->translations = require $langFile;
        }
        
        // تحميل ترجمات إضافية للموقع الحالي
        $this->loadTenantTranslations();
    }
    
    /**
     * تحميل ترجمات الموقع
     */
    private function loadTenantTranslations()
    {
        // يمكن تحميل ترجمات مخصصة للموقع من قاعدة البيانات
        // سيتم تنفيذها لاحقاً
    }
    
    /**
     * الحصول على ترجمة
     */
    public static function get($key, $default = '', $params = [])
    {
        $instance = self::getInstance();
        
        $translation = $instance->translations[$key] ?? $default ?: $key;
        
        // استبدال المعاملات
        if (!empty($params)) {
            foreach ($params as $param => $value) {
                $translation = str_replace(':' . $param, $value, $translation);
            }
        }
        
        return $translation;
    }
    
    /**
     * الحصول على اللغة الحالية
     */
    public static function current()
    {
        return self::getInstance()->currentLang;
    }
    
    /**
     * تغيير اللغة
     */
    public static function setLocale($lang)
    {
        if (!in_array($lang, self::getInstance()->supportedLangs)) {
            return false;
        }
        
        Session::put('lang', $lang);
        setcookie('lang', $lang, time() + (86400 * 30), '/');
        
        self::getInstance()->currentLang = $lang;
        self::getInstance()->loadTranslations();
        
        return true;
    }
    
    /**
     * تعيين لغة الموقع
     */
    public static function setTenantLang($lang)
    {
        if (!in_array($lang, self::getInstance()->supportedLangs)) {
            return false;
        }
        
        Session::put('tenant_lang', $lang);
        
        return true;
    }
    
    /**
     * الحصول على اللغة المعاكسة
     */
    public static function opposite()
    {
        return self::current() === 'ar' ? 'en' : 'ar';
    }
    
    /**
     * التحقق من كون اللغة RTL
     */
    public static function isRtl()
    {
        return self::current() === 'ar';
    }
    
    /**
     * الحصول على اتجاه النص
     */
    public static function direction()
    {
        return self::isRtl() ? 'rtl' : 'ltr';
    }
    
    /**
     * الحصول على محاذاة النص
     */
    public static function align()
    {
        return self::isRtl() ? 'right' : 'left';
    }
    
    /**
     * الحصول على المحاذاة المعاكسة
     */
    public static function oppositeAlign()
    {
        return self::isRtl() ? 'left' : 'right';
    }
    
    /**
     * الحصول على اللغات المدعومة
     */
    public static function supported()
    {
        return self::getInstance()->supportedLangs;
    }
    
    /**
     * الحصول على اسم اللغة
     */
    public static function name($lang = null)
    {
        $names = [
            'ar' => 'العربية',
            'en' => 'English'
        ];
        
        return $names[$lang ?? self::current()] ?? $lang;
    }
    
    /**
     * الحصول على جميع الترجمات
     */
    public static function all()
    {
        return self::getInstance()->translations;
    }
}

/**
 * دالة مساعدة للترجمة
 */
function lang($key = null, $default = '', $params = [])
{
    if ($key === null) {
        return Language::current();
    }
    return Language::get($key, $default, $params);
}

/**
 * دالة مساعدة للحصول على اللغة الحالية
 */
function currentLang()
{
    return Language::current();
}

/**
 * دالة مساعدة للاتجاه
 */
function langDir()
{
    return Language::direction();
}
