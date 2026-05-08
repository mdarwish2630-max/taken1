<?php
/**
 * CMS Platform - Site Settings Model
 * نموذج إعدادات الموقع الرئيسي
 */

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'logo', 'logo_white', 'favicon',
        'hero_title', 'hero_subtitle', 'hero_image', 'hero_button_text', 'hero_button_link',
        'features_title', 'features_subtitle', 'show_features',
        'show_themes_section', 'show_pricing_section', 'pricing_title', 'pricing_subtitle',
        'testimonials_title', 'show_testimonials',
        'contact_title', 'contact_subtitle', 'show_contact_form',
        'contact_email', 'contact_phone', 'contact_whatsapp', 'contact_address',
        'facebook', 'twitter', 'instagram', 'linkedin', 'youtube',
        'meta_title', 'meta_description', 'meta_keywords',
        'footer_text', 'copyright_text',
        'head_scripts', 'body_scripts',
        'maintenance_mode', 'maintenance_message'
    ];

    /**
     * الحصول على الإعدادات
     */
    public function getSettings()
    {
        $settings = $this->db->query("SELECT * FROM {$this->table} LIMIT 1")->first();
        
        if (!$settings) {
            // إنشاء إعدادات افتراضية
            $this->createDefaultSettings();
            $settings = $this->db->query("SELECT * FROM {$this->table} LIMIT 1")->first();
        }
        
        return $settings;
    }

    /**
     * إنشاء إعدادات افتراضية
     */
    private function createDefaultSettings()
    {
        $this->db->query(
            "INSERT INTO {$this->table} 
            (hero_title, hero_subtitle, hero_button_text, hero_button_link,
             features_title, pricing_title, testimonials_title, contact_title,
             meta_title, copyright_text) 
            VALUES 
            ('أنشئ موقعك الإلكتروني الاحترافي', 
             'منصة سهلة ومرنة لإنشاء مواقع احترافية',
             'ابدأ الآن', '/register',
             'لماذا تختارنا؟', 'خطط الأسعار', 'آراء العملاء', 'تواصل معنا',
             'منصة المواقع', '© 2024 جميع الحقوق محفوظة')"
        );
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings($data)
    {
        $settings = $this->getSettings();
        
        if ($settings) {
            return $this->update($settings->id, $data);
        }
        
        return $this->create($data);
    }

    /**
     * تحديث الشعار
     */
    public function updateLogo($logoPath, $type = 'logo')
    {
        $settings = $this->getSettings();
        
        $field = $type === 'white' ? 'logo_white' : 'logo';
        
        return $this->update($settings->id, [$field => $logoPath]);
    }

    /**
     * تحديث البانر الرئيسي
     */
    public function updateHero($data)
    {
        $settings = $this->getSettings();
        
        $updateData = [
            'hero_title' => $data['hero_title'] ?? null,
            'hero_subtitle' => $data['hero_subtitle'] ?? null,
            'hero_button_text' => $data['hero_button_text'] ?? null,
            'hero_button_link' => $data['hero_button_link'] ?? null,
        ];
        
        if (isset($data['hero_image'])) {
            $updateData['hero_image'] = $data['hero_image'];
        }
        
        return $this->update($settings->id, $updateData);
    }

    /**
     * التحقق من وضع الصيانة
     */
    public function isMaintenanceMode()
    {
        $settings = $this->getSettings();
        return (bool) ($settings->maintenance_mode ?? false);
    }

    /**
     * تفعيل/إيقاف وضع الصيانة
     */
    public function toggleMaintenance($enabled, $message = null)
    {
        $settings = $this->getSettings();
        
        return $this->update($settings->id, [
            'maintenance_mode' => $enabled ? 1 : 0,
            'maintenance_message' => $message
        ]);
    }

    /**
     * الحصول على معلومات التواصل
     */
    public function getContactInfo()
    {
        $settings = $this->getSettings();
        
        return [
            'email' => $settings->contact_email ?? null,
            'phone' => $settings->contact_phone ?? null,
            'whatsapp' => $settings->contact_whatsapp ?? null,
            'address' => $settings->contact_address ?? null,
        ];
    }

    /**
     * الحصول على روابط السوشال ميديا
     */
    public function getSocialLinks()
    {
        $settings = $this->getSettings();
        
        return [
            'facebook' => $settings->facebook ?? null,
            'twitter' => $settings->twitter ?? null,
            'instagram' => $settings->instagram ?? null,
            'linkedin' => $settings->linkedin ?? null,
            'youtube' => $settings->youtube ?? null,
        ];
    }

    /**
     * الحصول على SEO
     */
    public function getSeo()
    {
        $settings = $this->getSettings();
        
        return [
            'title' => $settings->meta_title ?? null,
            'description' => $settings->meta_description ?? null,
            'keywords' => $settings->meta_keywords ?? null,
        ];
    }
}
