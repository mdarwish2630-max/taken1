<?php
/**
 * CMS Platform - Demo Data Model
 * نموذج البيانات التجريبية
 * يستخدم لاستيراد بيانات تجريبية للمواقع الجديدة
 */

class DemoData extends Model
{
    protected $table = 'demo_imports';
    protected $primaryKey = 'id';
    protected $fillable = ['tenant_id', 'imported_at'];

    /**
     * البيانات التجريبية العامة (قالب واحد - نوفا)
     */
    private static $demoData = [
        'nova' => [
            'services' => [
                ['title' => 'خدماتنا المميزة', 'description' => 'نقدم مجموعة واسعة من الخدمات عالية الجودة لتلبية احتياجاتكم بأعلى المعايير.', 'icon' => 'fas fa-star', 'show_on_home' => 1],
                ['title' => 'استشارات متخصصة', 'description' => 'نقدم استشارات مهنية متخصصة لمساعدتك في تحقيق أهدافك.', 'icon' => 'fas fa-comments', 'show_on_home' => 1],
                ['title' => 'خدمة عملاء متميزة', 'description' => 'فريق خدمة عملاء متاح على مدار الساعة للرد على استفساراتكم.', 'icon' => 'fas fa-headset', 'show_on_home' => 1],
                ['title' => 'حلول مخصصة', 'description' => 'نصمم حلولاً مخصصة تتناسب مع احتياجاتكم ومتطلباتكم.', 'icon' => 'fas fa-cogs', 'show_on_home' => 1]
            ],
            'testimonials' => [
                ['client_name' => 'محمد الأحمد', 'client_title' => 'عميل', 'content' => 'تجربة ممتازة من البداية للنهاية. أنصح الجميع بالتعامل معهم.', 'rating' => 5],
                ['client_name' => 'فاطمة الزهراني', 'client_title' => 'عميلة', 'content' => 'سعيدة جداً بالخدمة المقدمة. جودة عالية وسرعة في الإنجاز.', 'rating' => 5]
            ],
            'banners' => [
                ['title' => 'مرحباً بكم في موقعنا', 'subtitle' => 'نسعى لخدمتكم بأعلى جودة', 'description' => 'نقدم أفضل الخدمات والحلول الاحترافية', 'position' => 'hero', 'button_text' => 'تواصل معنا']
            ]
        ],
        // بيانات افتراضية للتوافق
        'general' => [
            'services' => [
                ['title' => 'خدماتنا المميزة', 'description' => 'نقدم مجموعة واسعة من الخدمات عالية الجودة لتلبية احتياجاتكم.', 'icon' => 'fas fa-star', 'show_on_home' => 1],
                ['title' => 'استشارات متخصصة', 'description' => 'نقدم استشارات مهنية متخصصة لمساعدتك.', 'icon' => 'fas fa-comments', 'show_on_home' => 1],
                ['title' => 'خدمة عملاء متميزة', 'description' => 'فريق خدمة عملاء متاح للرد على استفساراتكم.', 'icon' => 'fas fa-headset', 'show_on_home' => 1],
                ['title' => 'حلول مخصصة', 'description' => 'نصمم حلولاً مخصصة تتناسب مع احتياجاتكم.', 'icon' => 'fas fa-cogs', 'show_on_home' => 1]
            ],
            'testimonials' => [
                ['client_name' => 'محمد الأحمد', 'client_title' => 'عميل', 'content' => 'تجربة ممتازة من البداية للنهاية.', 'rating' => 5],
                ['client_name' => 'فاطمة الزهراني', 'client_title' => 'عميلة', 'content' => 'سعيدة جداً بالخدمة المقدمة.', 'rating' => 5]
            ],
            'banners' => [
                ['title' => 'مرحباً بكم', 'subtitle' => 'نسعى لخدمتكم', 'description' => 'نقدم أفضل الخدمات بجودة عالية', 'position' => 'hero', 'button_text' => 'تواصل معنا']
            ]
        ]
    ];

    /**
     * استيراد البيانات التجريبية لموقع معين
     */
    public function importForTenant($tenantId, $themeSlug)
    {
        if ($this->hasImported($tenantId)) {
            return false;
        }

        $demoData = $this->getDemoDataForTheme($themeSlug);
        
        if (!$demoData) {
            return false;
        }

        try {
            // استيراد الخدمات
            if (!empty($demoData['services'])) {
                $serviceModel = new Service();
                foreach ($demoData['services'] as $index => $service) {
                    $serviceModel->createService([
                        'tenant_id' => $tenantId,
                        'title' => $service['title'],
                        'description' => $service['description'],
                        'icon' => $service['icon'],
                        'show_on_home' => $service['show_on_home'] ?? 1,
                        'display_order' => $index + 1,
                        'status' => 'active'
                    ]);
                }
            }

            // استيراد آراء العملاء
            if (!empty($demoData['testimonials'])) {
                $testimonialModel = new Testimonial();
                foreach ($demoData['testimonials'] as $testimonial) {
                    $testimonialModel->createTestimonial([
                        'tenant_id' => $tenantId,
                        'client_name' => $testimonial['client_name'],
                        'client_title' => $testimonial['client_title'],
                        'content' => $testimonial['content'],
                        'rating' => $testimonial['rating'],
                        'show_on_home' => 1,
                        'status' => 'active'
                    ]);
                }
            }

            // استيراد البانرات
            if (!empty($demoData['banners'])) {
                $bannerModel = new Banner();
                foreach ($demoData['banners'] as $banner) {
                    $bannerModel->createBanner([
                        'tenant_id' => $tenantId,
                        'title' => $banner['title'],
                        'subtitle' => $banner['subtitle'] ?? '',
                        'description' => $banner['description'] ?? '',
                        'position' => $banner['position'] ?? 'hero',
                        'button_text' => $banner['button_text'] ?? '',
                        'status' => 'active'
                    ]);
                }
            }

            // تسجيل عملية الاستيراد
            $this->create([
                'tenant_id' => $tenantId,
                'imported_at' => date('Y-m-d H:i:s')
            ]);

            return true;

        } catch (Exception $e) {
            error_log("Demo import error: " . $e->getMessage());
            return false;
        }
    }

    private function getDemoDataForTheme($themeSlug)
    {
        return self::$demoData[$themeSlug] ?? self::$demoData['general'];
    }

    public function hasImported($tenantId)
    {
        return $this->count('tenant_id = ?', [$tenantId]) > 0;
    }

    public function reimportForTenant($tenantId, $themeSlug)
    {
        // حذف البيانات القديمة
        $this->db->query("DELETE FROM services WHERE tenant_id = ?", [$tenantId]);
        $this->db->query("DELETE FROM testimonials WHERE tenant_id = ?", [$tenantId]);
        $this->db->query("DELETE FROM banners WHERE tenant_id = ?", [$tenantId]);
        $this->db->query("DELETE FROM {$this->table} WHERE tenant_id = ?", [$tenantId]);

        return $this->importForTenant($tenantId, $themeSlug);
    }

    public static function getAvailableThemes()
    {
        return array_keys(self::$demoData);
    }
}
