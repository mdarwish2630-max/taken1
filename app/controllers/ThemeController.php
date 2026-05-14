<?php
/**
 * CMS Platform - Theme Controller
 * متحكم تخصيص الثيم
 */

class ThemeController extends Controller
{
    private $themeSettingsModel;
    private $tenantModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
        
        $this->view->setLayout('dashboard');
        
        require_once ROOT_PATH . '/app/models/ThemeSettings.php';
        $this->themeSettingsModel = new ThemeSettings();
        $this->tenantModel = $this->model('Tenant');
    }

    /**
     * عرض صفحة تخصيص الثيم
     */
    public function index()
    {
        $tenant = Auth::tenant();
        $themeSettings = $this->themeSettingsModel->getTenantSettings($tenant->id);

        // getTenantSettings يعمل create تلقائياً إذا ما كانت موجودة

        // الخطوط المتاحة
        $fonts = $this->getAvailableFonts();

        $this->view('dashboard/theme', [
            'title' => lang('theme_customization'),
            'tenant' => $tenant,
            'settings' => $themeSettings,
            'fonts' => $fonts
        ]);
    }

    /**
     * تحديث إعدادات الثيم
     */
    public function update()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            // الخطوط
            'primary_font' => $this->input('primary_font', 'Tajawal'),
            'secondary_font' => $this->input('secondary_font', 'Tajawal'),
            'base_font_size' => $this->input('base_font_size', '16'),
            'heading_font_weight' => $this->input('heading_font_weight', '700'),
            'body_font_weight' => $this->input('body_font_weight', '400'),
            
            // الألوان
            'primary_color' => $this->input('primary_color', '#2563eb'),
            'secondary_color' => $this->input('secondary_color', '#1e40af'),
            'accent_color' => $this->input('accent_color', '#f59e0b'),
            'text_color' => $this->input('text_color', '#1f2937'),
            'text_muted_color' => $this->input('text_muted_color', '#6b7280'),
            'background_color' => $this->input('background_color', '#ffffff'),
            'card_background' => $this->input('card_background', '#ffffff'),
            'border_color' => $this->input('border_color', '#e5e7eb'),
            
            // التصميم
            'border_radius' => $this->input('border_radius', '8'),
            'button_radius' => $this->input('button_radius', '8'),
            'card_radius' => $this->input('card_radius', '12'),
            'header_style' => $this->input('header_style', 'default'),
            'footer_style' => $this->input('footer_style', 'default'),
            'hero_style' => $this->input('hero_style', 'fullwidth'),
            
            // الأزرار
            'button_style' => $this->input('button_style', 'rounded'),
            'button_shadow' => $this->input('button_shadow') ? 1 : 0,
            
            // البطاقات
            'card_style' => $this->input('card_style', 'shadow'),
            'card_hover_effect' => $this->input('card_hover_effect', 'lift'),
            
            // الرسوم المتحركة
            'enable_animations' => $this->input('enable_animations') ? 1 : 0,
            'animation_type' => $this->input('animation_type', 'fade'),
            
            // التخطيط
            'container_width' => $this->input('container_width', '1200'),
            'header_fixed' => $this->input('header_fixed') ? 1 : 0,
            'sidebar_position' => $this->input('sidebar_position', 'right'),
            
            // CSS و JS مخصص - [SEC-FIX-01] تنظيف باستخدام الدوال المتخصصة
            'custom_css' => function_exists('sanitizeCSS') ? sanitizeCSS($this->rawInput('custom_css')) : $this->input('custom_css'),
            'custom_js' => $this->sanitizeCustomJS($this->rawInput('custom_js')),
        ];

        if ($this->themeSettingsModel->updateSettings($tenant->id, $data)) {
            Session::success(lang('settings_saved'));
        } else {
            Session::error(lang('error_occurred'));
        }

        $this->redirect('/dashboard/theme');
    }

    /**
     * إعادة تعيين للإعدادات الافتراضية
     */
    public function reset()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        if ($this->themeSettingsModel->resetToDefault($tenant->id)) {
            Session::success(lang('settings_reset'));
        } else {
            Session::error(lang('error_occurred'));
        }

        $this->redirect('/dashboard/theme');
    }

    /**
     * الخطوط المتاحة
     */
    private function getAvailableFonts()
    {
        return [
            'Tajawal' => 'Tajawal (تجوال)',
            'Cairo' => 'Cairo (القاهرة)',
            'Almarai' => 'Almarai (المراعي)',
            'Noto Sans Arabic' => 'Noto Sans Arabic',
            'IBM Plex Sans Arabic' => 'IBM Plex Sans Arabic',
            'Tinos' => 'Tinos',
            'Amiri' => 'Amiri (أميري)',
            'Roboto' => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Poppins' => 'Poppins',
            'Montserrat' => 'Montserrat',
        ];
    }

    /**
     * تنظيف كود JavaScript المخصص
     * يزيل الأكواد الخبيثة مع السماح بـ JS عادي
     * [SEC-FIX-01] منع XSS عبر حقن </script> أو event handlers
     */
    private function sanitizeCustomJS($js)
    {
        if (empty($js)) return '';
        $js = (string)$js;
        // إزالة محاولات إغلاق تاغ script وفتح تاغات HTML/JS جديدة
        $js = preg_replace('#</script[^>]*>#si', '', $js);
        // إزالة محاولات حقن تاغات HTML داخل السياق
        $js = preg_replace('#<script[^>]*>#si', '', $js);
        $js = preg_replace('#</?iframe[^>]*>#si', '', $js);
        $js = preg_replace('#</?embed[^>]*>#si', '', $js);
        $js = preg_replace('#</?object[^>]*>#si', '', $js);
        $js = preg_replace('#</?link[^>]*>#si', '', $js);
        $js = preg_replace('#</?meta[^>]*>#si', '', $js);
        $js = preg_replace('#document\.cookie#si', '/* blocked */', $js);
        $js = preg_replace('#document\.write\s*\(.*?\)#si', '', $js);
        $js = preg_replace('#eval\s*\(.*?\)#si', '', $js);
        $js = preg_replace('#Function\s*\(.*?\)#si', '', $js);
        return trim($js);
    }

    /**
     * الحصول على أنماط الهيدر
     */
    public static function getHeaderStyles()
    {
        return [
            'default' => lang('default'),
            'centered' => lang('centered_logo'),
            'minimal' => lang('minimal'),
            'boxed' => lang('boxed'),
        ];
    }

    /**
     * الحصول على أنماط الفوتر
     */
    public static function getFooterStyles()
    {
        return [
            'default' => lang('default'),
            'minimal' => lang('minimal'),
            'expanded' => lang('expanded'),
            'centered' => lang('centered'),
        ];
    }

    /**
     * الحصول على أنماط الهيرو
     */
    public static function getHeroStyles()
    {
        return [
            'fullwidth' => lang('full_width'),
            'boxed' => lang('boxed'),
            'split' => lang('split'),
            'carousel' => lang('carousel'),
        ];
    }
}
