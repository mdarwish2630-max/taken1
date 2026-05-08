<?php
/**
 * CMS Platform - Theme Settings Model
 * نموذج إعدادات الثيم
 */

class ThemeSettings extends Model
{
    protected $table = 'theme_settings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'font_primary', 'font_secondary', 'font_size_base',
        'border_radius', 'header_style', 'footer_style', 'hero_style',
        'custom_css', 'custom_js', 'header_logo_height', 'footer_logo_height',
        'button_style', 'card_style', 'animation_enabled'
    ];

    /**
     * الخطوط العربية المتاحة
     */
    public static $arabicFonts = [
        'Tajawal' => 'Tajawal',
        'Cairo' => 'Cairo',
        'Almarai' => 'Almarai',
        'IBM Plex Sans Arabic' => 'IBM Plex Sans Arabic',
        'Noto Sans Arabic' => 'Noto Sans Arabic',
        'Amiri' => 'Amiri',
        'Lateef' => 'Lateef',
        'Scheherazade' => 'Scheherazade'
    ];

    /**
     * الخطوط الإنجليزية المتاحة
     */
    public static $englishFonts = [
        'Inter' => 'Inter',
        'Roboto' => 'Roboto',
        'Open Sans' => 'Open Sans',
        'Poppins' => 'Poppins',
        'Montserrat' => 'Montserrat',
        'Lato' => 'Lato',
        'Nunito' => 'Nunito'
    ];

    /**
     * الحصول على إعدادات ثيم موقع
     */
    public function getTenantSettings($tenantId)
    {
        $settings = $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first();

        if (!$settings) {
            // إنشاء إعدادات افتراضية
            $this->create(['tenant_id' => $tenantId]);
            return $this->getTenantSettings($tenantId);
        }

        return $settings;
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings($tenantId, $data)
    {
        $settings = $this->getTenantSettings($tenantId);
        
        return $this->update($settings->id, $data);
    }

    /**
     * إنشاء CSS مخصص
     */
    public function generateCustomCSS($tenantId, $tenant)
    {
        $settings = $this->getTenantSettings($tenantId);

        $css = "/* Custom Theme CSS */\n";
        $css .= ":root {\n";
        $css .= "  --primary: {$tenant->primary_color};\n";
        $css .= "  --primary-dark: {$tenant->secondary_color};\n";
        $css .= "  --accent: {$tenant->accent_color};\n";
        $css .= "  --text: {$tenant->text_color};\n";
        $css .= "  --bg: {$tenant->background_color};\n";
        $css .= "  --font-primary: '{$settings->font_primary}', sans-serif;\n";
        $css .= "  --font-secondary: '{$settings->font_secondary}', sans-serif;\n";
        $css .= "  --font-size-base: {$settings->font_size_base};\n";
        $css .= "  --border-radius: {$settings->border_radius};\n";
        $css .= "  --header-logo-height: {$settings->header_logo_height};\n";
        $css .= "  --footer-logo-height: {$settings->footer_logo_height};\n";
        $css .= "}\n\n";

        // أنماط الأزرار
        $css .= $this->generateButtonStyles($settings->button_style, $settings->border_radius);

        // أنماط البطاقات
        $css .= $this->generateCardStyles($settings->card_style);

        // أنماط الرأس والتذييل
        $css .= $this->generateLayoutStyles($settings);

        // CSS مخصص من المستخدم
        if ($settings->custom_css) {
            $css .= "\n/* Custom User CSS */\n";
            $css .= $settings->custom_css;
        }

        return $css;
    }

    /**
     * أنماط الأزرار
     */
    private function generateButtonStyles($style, $radius)
    {
        $borderRadius = $style === 'rounded' ? $radius : ($style === 'pill' ? '50px' : '0');

        return <<<CSS
.btn-primary, .btn {
    border-radius: {$borderRadius};
    font-family: var(--font-primary);
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

CSS;
    }

    /**
     * أنماط البطاقات
     */
    private function generateCardStyles($style)
    {
        switch ($style) {
            case 'shadow':
                return <<<CSS
.card {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border-radius: var(--border-radius);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

CSS;
            case 'border':
                return <<<CSS
.card {
    border: 1px solid #e5e7eb;
    box-shadow: none;
    border-radius: var(--border-radius);
}

.card:hover {
    border-color: var(--primary);
}

CSS;
            default:
                return <<<CSS
.card {
    border: none;
    box-shadow: none;
    border-radius: var(--border-radius);
}

CSS;
        }
    }

    /**
     * أنماط التخطيط
     */
    private function generateLayoutStyles($settings)
    {
        $css = '';

        // نمط الرأس
        switch ($settings->header_style) {
            case 'centered':
                $css .= <<<CSS
.header-container {
    flex-direction: column;
    text-align: center;
}
.nav {
    margin-top: 1rem;
}

CSS;
                break;
            case 'transparent':
                $css .= <<<CSS
.header {
    background: transparent;
    position: absolute;
}
.header .nav a {
    color: #fff;
}

CSS;
                break;
        }

        // الرسوم المتحركة
        if ($settings->animation_enabled) {
            $css .= <<<CSS
/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.section {
    animation: fadeIn 0.6s ease forwards;
}

CSS;
        }

        return $css;
    }

    /**
     * إنشاء JavaScript مخصص
     */
    public function getCustomJS($tenantId)
    {
        $settings = $this->getTenantSettings($tenantId);

        if ($settings->custom_js) {
            return '<script>' . $settings->custom_js . '</script>';
        }

        return '';
    }

    /**
     * الحصول على Google Fonts URL
     */
    public function getGoogleFontsUrl($tenantId)
    {
        $settings = $this->getTenantSettings($tenantId);
        
        $fonts = [];
        if ($settings->font_primary) {
            $fonts[] = str_replace(' ', '+', $settings->font_primary) . ':wght@400;500;700';
        }
        if ($settings->font_secondary && $settings->font_secondary !== $settings->font_primary) {
            $fonts[] = str_replace(' ', '+', $settings->font_secondary) . ':wght@400;500;700';
        }

        if (empty($fonts)) {
            return 'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap';
        }

        return 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
    }

    /**
     * إعادة تعيين الإعدادات
     */
    public function resetToDefaults($tenantId)
    {
        $settings = $this->getTenantSettings($tenantId);

        return $this->update($settings->id, [
            'font_primary' => 'Tajawal',
            'font_secondary' => 'Tajawal',
            'font_size_base' => '16px',
            'border_radius' => '8px',
            'header_style' => 'default',
            'footer_style' => 'default',
            'hero_style' => 'default',
            'custom_css' => null,
            'custom_js' => null,
            'header_logo_height' => '50px',
            'footer_logo_height' => '40px',
            'button_style' => 'rounded',
            'card_style' => 'shadow',
            'animation_enabled' => 1
        ]);
    }
}
