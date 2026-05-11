<?php
/**
 * CMS Platform - Tenant Model
 * نموذج المواقع (العملاء)
 */

class Tenant extends Model
{
    protected $table = 'tenants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'site_name', 'slug', 'subdomain', 'custom_domain', 'theme_id', 'plan_id', 'subscription_plan_id',
        'subscription_status', 'subscription_start', 'subscription_end', 'trial_ends_at',
        'site_status', 'logo', 'favicon',
        'contact_email', 'contact_phone', 'contact_phone2', 'contact_whatsapp',
        'address', 'working_hours',
        'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok',
        'meta_title', 'meta_description', 'meta_keywords',
        'primary_color', 'secondary_color', 'accent_color', 'text_color', 'background_color',
        'settings', 'default_language', 'sections_config', 'plan_features',
        'site_name_en', 'meta_description_en',
        'cta_title', 'cta_title_en', 'cta_text', 'cta_text_en',
        'cta_button_text', 'cta_button_text_en', 'cta_button_link', 'cta_is_active'
    ];

    /**
     * الأقسام الافتراضية المتاحة
     */
    public static $availableSections = [
        'hero' => 'البانر الرئيسي',
        'stats' => 'شريط الإحصائيات',
        'services' => 'الخدمات',
        'why_us' => 'لماذا نحن',
        'gallery' => 'معرض الأعمال',
        'testimonials' => 'آراء العملاء',
        'faq' => 'الأسئلة الشائعة',
        'partners' => 'شركاؤنا',
        'contact' => 'نموذج التواصل'
    ];

    /**
     * إنشاء موقع جديد
     */
    public function createSite($data)
    {
        // توليد slug فريد
        $data['slug'] = generateUniqueSlug($data['site_name'], $this->table, 'slug');
        
        // تعيين فترة التجربة
        $data['subscription_status'] = 'trial';
        $data['trial_ends_at'] = date('Y-m-d H:i:s', strtotime('+' . TRIAL_DAYS . ' days'));
        
        // إنشاء الموقع
        $tenantId = $this->create($data);
        
        if ($tenantId) {
            // إنشاء الصفحات الافتراضية
            $this->createDefaultPages($tenantId);
        }
        
        return $tenantId;
    }

    /**
     * إنشاء الصفحات الافتراضية
     */
    private function createDefaultPages($tenantId)
    {
        $pageModel = new Page();
        
        $defaultPages = [
            [
                'title' => 'الرئيسية',
                'slug' => 'home',
                'content' => '',
                'is_home' => 1,
                'show_in_menu' => 0,
                'menu_order' => 0
            ],
            [
                'title' => 'من نحن',
                'slug' => 'about',
                'content' => '<h2>من نحن</h2><p>أضف محتوى صفحة من نحن هنا</p>',
                'is_home' => 0,
                'show_in_menu' => 1,
                'menu_order' => 1
            ],
            [
                'title' => 'خدماتنا',
                'slug' => 'services',
                'content' => '',
                'is_home' => 0,
                'show_in_menu' => 1,
                'menu_order' => 2
            ],
            [
                'title' => 'معرض الأعمال',
                'slug' => 'gallery',
                'content' => '',
                'is_home' => 0,
                'show_in_menu' => 1,
                'menu_order' => 3
            ],
            [
                'title' => 'اتصل بنا',
                'slug' => 'contact',
                'content' => '',
                'is_home' => 0,
                'show_in_menu' => 1,
                'menu_order' => 4
            ]
        ];
        
        foreach ($defaultPages as $page) {
            $page['tenant_id'] = $tenantId;
            $pageModel->create($page);
        }
    }

    /**
     * البحث بواسطة المستخدم
     */
    public function findByUserId($userId)
    {
        return $this->findBy('user_id', $userId);
    }

    /**
     * البحث بواسطة Slug
     */
    public function findBySlug($slug)
    {
        return $this->db->query(
            "SELECT t.*, th.slug as theme_slug, th.name as theme_name 
             FROM {$this->table} t 
             LEFT JOIN themes th ON t.theme_id = th.id 
             WHERE t.slug = ?",
            [$slug]
        )->first();
    }

    /**
     * البحث بواسطة Subdomain
     */
    public function findBySubdomain($subdomain)
    {
        return $this->db->query(
            "SELECT t.*, th.slug as theme_slug 
             FROM {$this->table} t 
             LEFT JOIN themes th ON t.theme_id = th.id 
             WHERE t.subdomain = ?",
            [$subdomain]
        )->first();
    }

    /**
     * البحث بواسطة الدومين المخصص
     */
    public function findByCustomDomain($domain)
    {
        return $this->db->query(
            "SELECT t.*, th.slug as theme_slug 
             FROM {$this->table} t 
             LEFT JOIN themes th ON t.theme_id = th.id 
             WHERE t.custom_domain = ?",
            [$domain]
        )->first();
    }

    /**
     * تحديث الثيم
     */
    public function updateTheme($tenantId, $themeId)
    {
        return $this->update($tenantId, ['theme_id' => $themeId]);
    }

    /**
     * تحديث الألوان
     */
    public function updateColors($tenantId, $colors)
    {
        $data = [
            'primary_color' => $colors['primary_color'] ?? '#2563eb',
            'secondary_color' => $colors['secondary_color'] ?? '#1e40af',
            'accent_color' => $colors['accent_color'] ?? '#f59e0b',
            'text_color' => $colors['text_color'] ?? '#1f2937',
            'background_color' => $colors['background_color'] ?? '#ffffff'
        ];
        
        return $this->update($tenantId, $data);
    }

    /**
     * تحديث الشعار
     */
    public function updateLogo($tenantId, $logoPath)
    {
        return $this->update($tenantId, ['logo' => $logoPath]);
    }

    /**
     * تحديث معلومات التواصل
     */
    public function updateContact($tenantId, $data)
    {
        $allowedFields = [
            'contact_email', 'contact_phone', 'contact_phone2', 
            'contact_whatsapp', 'address', 'working_hours'
        ];
        
        $updateData = array_intersect_key($data, array_flip($allowedFields));
        
        return $this->update($tenantId, $updateData);
    }

    /**
     * تحديث السوشال ميديا
     */
    public function updateSocial($tenantId, $data)
    {
        $allowedFields = [
            'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok'
        ];
        
        $updateData = array_intersect_key($data, array_flip($allowedFields));
        
        return $this->update($tenantId, $updateData);
    }

    /**
     * تحديث SEO
     */
    public function updateSeo($tenantId, $data)
    {
        $allowedFields = ['meta_title', 'meta_description', 'meta_keywords'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));
        
        return $this->update($tenantId, $updateData);
    }

    /**
     * تحديث اللغة الافتراضية
     */
    public function updateLanguage($tenantId, $language)
    {
        if (!in_array($language, SUPPORTED_LANGS)) {
            return false;
        }
        
        return $this->update($tenantId, ['default_language' => $language]);
    }

    /**
     * التحقق من حالة الاشتراك
     */
    public function checkSubscription($tenantId)
    {
        $tenant = $this->find($tenantId);
        
        if (!$tenant) {
            return false;
        }
        
        // التحقق من انتهاء التجربة
        if ($tenant->subscription_status === 'trial' && strtotime($tenant->trial_ends_at) < time()) {
            $this->update($tenantId, ['subscription_status' => 'expired']);
            return false;
        }
        
        // التحقق من انتهاء الاشتراك
        if ($tenant->subscription_status === 'active' && strtotime($tenant->subscription_end) < time()) {
            $this->update($tenantId, ['subscription_status' => 'expired']);
            return false;
        }
        
        return in_array($tenant->subscription_status, ['trial', 'active']);
    }

    /**
     * تجديد الاشتراك
     */
    public function renewSubscription($tenantId, $months = 1)
    {
        $tenant = $this->find($tenantId);
        
        if (!$tenant) {
            return false;
        }
        
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+{$months} months"));
        
        return $this->update($tenantId, [
            'subscription_status' => 'active',
            'subscription_start' => $startDate,
            'subscription_end' => $endDate
        ]);
    }

    /**
     * الحصول على المواقع المنشورة
     */
    public function getPublishedSites()
    {
        return $this->db->query(
            "SELECT t.*, th.name as theme_name 
             FROM {$this->table} t 
             LEFT JOIN themes th ON t.theme_id = th.id 
             WHERE t.site_status = 'published' 
             ORDER BY t.created_at DESC"
        )->results();
    }

    /**
     * الحصول على المواقع المنتهية
     */
    public function getExpiredSites()
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE subscription_status IN ('expired', 'suspended') 
             OR (subscription_status = 'trial' AND trial_ends_at < NOW())"
        )->results();
    }

    /**
     * إحصائيات الموقع
     */
    public function getStats($tenantId)
    {
        $stats = [];
        
        // عدد الخدمات
        $serviceModel = new Service();
        $stats['services'] = $serviceModel->count('tenant_id = ? AND status = ?', [$tenantId, 'active']);
        
        // عدد الصور
        $galleryModel = new Gallery();
        $stats['gallery'] = $galleryModel->count('tenant_id = ? AND status = ?', [$tenantId, 'active']);
        
        // عدد آراء العملاء
        $testimonialModel = new Testimonial();
        $stats['testimonials'] = $testimonialModel->count('tenant_id = ? AND status = ?', [$tenantId, 'active']);
        
        // عدد البانرات
        $bannerModel = new Banner();
        $stats['banners'] = $bannerModel->count('tenant_id = ? AND status = ?', [$tenantId, 'active']);
        
        // عدد الرسائل
        $stats['messages'] = $this->db->query(
            "SELECT COUNT(*) as count FROM contact_messages WHERE tenant_id = ?",
            [$tenantId]
        )->first()->count;
        
        return $stats;
    }

    /**
     * الحصول على إعدادات الأقسام
     */
    public function getSectionsConfig($tenantId)
    {
        $tenant = $this->find($tenantId);
        
        if (!$tenant || empty($tenant->sections_config)) {
            // إرجاع الإعدادات الافتراضية (جميع الأقسام ظاهرة)
            return $this->getDefaultSectionsConfig();
        }
        
        $config = json_decode($tenant->sections_config, true);
        
        // دمج مع الإعدادات الافتراضية للتأكد من وجود جميع الأقسام
        return array_merge($this->getDefaultSectionsConfig(), $config);
    }

    /**
     * الإعدادات الافتراضية للأقسام
     */
    public function getDefaultSectionsConfig()
    {
        return [
            'hero' => true,
            'stats' => true,
            'services' => true,
            'why_us' => true,
            'gallery' => true,
            'testimonials' => true,
            'faq' => true,
            'partners' => true,
            'contact' => true
        ];
    }

    /**
     * تحديث إعدادات الأقسام
     */
    public function updateSectionsConfig($tenantId, $config)
    {
        // التأكد من أن القيم صحيحة
        $validSections = array_keys(self::$availableSections);
        $cleanConfig = [];
        
        foreach ($validSections as $section) {
            $cleanConfig[$section] = isset($config[$section]) && $config[$section] ? true : false;
        }
        
        return $this->update($tenantId, [
            'sections_config' => json_encode($cleanConfig)
        ]);
    }

    /**
     * التحقق من ظهور قسم معين
     */
    public function isSectionVisible($tenantId, $section)
    {
        $config = $this->getSectionsConfig($tenantId);
        
        return isset($config[$section]) ? $config[$section] : true;
    }

    /**
     * الحصول على خطة المستأجر
     */
    public function getPlan($tenantId)
    {
        $tenant = $this->find($tenantId);
        
        if (!$tenant || !$tenant->plan_id) {
            return null;
        }
        
        $planModel = new SubscriptionPlan();
        return $planModel->find($tenant->plan_id);
    }

    /**
     * الحصول على ميزات الخطة للمستأجر
     */
    public function getPlanFeatures($tenantId)
    {
        $tenant = $this->find($tenantId);
        
        // إذا كانت ميزات مخزنة كـ JSON
        if ($tenant && !empty($tenant->plan_features)) {
            return json_decode($tenant->plan_features, true);
        }
        
        // الحصول على ميزات الخطة
        if ($tenant && $tenant->plan_id) {
            $planModel = new SubscriptionPlan();
            return $planModel->getFeatures($tenant->plan_id);
        }
        
        // ميزات افتراضية
        $planModel = new SubscriptionPlan();
        return $planModel->getDefaultFeatures();
    }

    /**
     * التحقق من ميزة معينة للمستأجر
     */
    public function hasPlanFeature($tenantId, $feature)
    {
        $features = $this->getPlanFeatures($tenantId);
        $featureField = 'has_' . $feature;
        
        return isset($features[$featureField]) ? $features[$featureField] : false;
    }

    /**
     * التحقق من حد مورد معين
     */
    public function checkPlanLimit($tenantId, $resource)
    {
        $planModel = new SubscriptionPlan();
        return $planModel->checkLimit($tenantId, $resource);
    }

    /**
     * تعيين خطة للمستأجر
     */
    public function assignPlan($tenantId, $planId)
    {
        $planModel = new SubscriptionPlan();
        $plan = $planModel->find($planId);
        
        if (!$plan) {
            return false;
        }
        
        // تخزين ميزات الخطة كـ JSON
        $features = $planModel->getFeatures($planId);
        
        // حساب تاريخ انتهاء الفترة التجريبية
        $trialEndsAt = null;
        if ($plan->trial_days > 0) {
            $trialEndsAt = date('Y-m-d H:i:s', strtotime('+' . $plan->trial_days . ' days'));
        }
        
        return $this->update($tenantId, [
            'plan_id' => $planId,
            'subscription_plan_id' => $planId,
            'plan_features' => json_encode($features),
            'subscription_status' => 'trial',
            'trial_ends_at' => $trialEndsAt
        ]);
    }

    /**
     * التحقق من صلاحية الدومين المخصص
     */
    public function canUseCustomDomain($tenantId)
    {
        return $this->hasPlanFeature($tenantId, 'custom_domain');
    }

    /**
     * التحقق من حالة التجربة
     */
    public function isOnTrial($tenantId)
    {
        $tenant = $this->find($tenantId);
        
        if (!$tenant) {
            return false;
        }
        
        return $tenant->subscription_status === 'trial' && 
               $tenant->trial_ends_at && 
               strtotime($tenant->trial_ends_at) > time();
    }

    /**
     * الحصول على الأيام المتبقية في التجربة
     */
    public function getTrialDaysRemaining($tenantId)
    {
        $tenant = $this->find($tenantId);
        
        if (!$tenant || !$tenant->trial_ends_at) {
            return 0;
        }
        
        $remaining = strtotime($tenant->trial_ends_at) - time();
        
        return max(0, ceil($remaining / 86400)); // أيام
    }
}
