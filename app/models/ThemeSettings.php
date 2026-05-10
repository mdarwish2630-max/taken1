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
        'tenant_id', 'primary_font', 'secondary_font', 'base_font_size',
        'heading_font_weight', 'body_font_weight',
        'primary_color', 'secondary_color', 'accent_color',
        'text_color', 'text_muted_color', 'background_color',
        'card_background', 'border_color',
        'border_radius', 'button_radius', 'card_radius',
        'header_style', 'footer_style', 'hero_style',
        'button_style', 'button_shadow', 'card_style', 'card_hover_effect',
        'enable_animations', 'animation_type',
        'container_width', 'header_fixed', 'sidebar_position',
        'custom_css', 'custom_js'
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

        // Read colors from settings (theme_settings table) with fallback to tenant
        $primaryColor = $settings->primary_color ?? $tenant->primary_color ?? '#2563eb';
        $secondaryColor = $settings->secondary_color ?? $tenant->secondary_color ?? '#1e40af';
        $accentColor = $settings->accent_color ?? $tenant->accent_color ?? '#f59e0b';
        $textColor = $settings->text_color ?? $tenant->text_color ?? '#1f2937';
        $bgColor = $settings->background_color ?? $tenant->background_color ?? '#ffffff';

        $css = "/* Custom Theme CSS */\n";
        $css .= ":root {\n";
        $css .= "  --primary: {$primaryColor};\n";
        $css .= "  --primary-dark: {$secondaryColor};\n";
        $css .= "  --accent: {$accentColor};\n";
        $css .= "  --text: {$textColor};\n";
        $css .= "  --bg: {$bgColor};\n";
        $css .= "  --font-primary: '{$settings->primary_font}', sans-serif;\n";
        $css .= "  --font-secondary: '{$settings->secondary_font}', sans-serif;\n";
        $css .= "  --font-size-base: {$settings->base_font_size};\n";
        $css .= "  --border-radius: {$settings->border_radius};\n";
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
        if (!empty($settings->enable_animations)) {
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
        $primaryFont = $settings->primary_font ?? $settings->font_primary ?? null;
        $secondaryFont = $settings->secondary_font ?? $settings->font_secondary ?? null;

        if ($primaryFont) {
            $fonts[] = str_replace(' ', '+', $primaryFont) . ':wght@400;500;700';
        }
        if ($secondaryFont && $secondaryFont !== $primaryFont) {
            $fonts[] = str_replace(' ', '+', $secondaryFont) . ':wght@400;500;700';
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
            'primary_font' => 'Tajawal',
            'secondary_font' => 'Tajawal',
            'base_font_size' => '16',
            'heading_font_weight' => '700',
            'body_font_weight' => '400',
            'primary_color' => '#2563eb',
            'secondary_color' => '#1e40af',
            'accent_color' => '#f59e0b',
            'text_color' => '#1f2937',
            'text_muted_color' => '#6b7280',
            'background_color' => '#ffffff',
            'card_background' => '#ffffff',
            'border_color' => '#e5e7eb',
            'border_radius' => '8',
            'button_radius' => '8',
            'card_radius' => '12',
            'header_style' => 'default',
            'footer_style' => 'default',
            'hero_style' => 'default',
            'button_style' => 'rounded',
            'button_shadow' => 0,
            'card_style' => 'shadow',
            'card_hover_effect' => 'lift',
            'enable_animations' => 1,
            'animation_type' => 'fade',
            'container_width' => '1200',
            'header_fixed' => 0,
            'sidebar_position' => 'right',
            'custom_css' => null,
            'custom_js' => null,
        ]);
    }

    /**
     * Alias for backward compatibility (ThemeController calls resetToDefault without 's')
     */
    public function resetToDefault($tenantId)
    {
        return $this->resetToDefaults($tenantId);
    }
}
