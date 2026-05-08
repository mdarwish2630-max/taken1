<?php
/**
 * CMS Platform - Subscription Plan Model
 * نموذج خطط الاشتراك
 */

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'currency', 'duration_days', 'trial_days',
        'has_custom_domain', 'has_ssl', 'has_analytics', 'has_custom_colors',
        'has_gallery', 'has_testimonials', 'has_banners', 'has_blog', 'has_forms', 'has_seo',
        'max_services', 'max_gallery', 'max_banners', 'max_pages', 'max_testimonials',
        'max_forms', 'storage_limit_mb', 'is_active', 'is_free', 'is_popular', 'sort_order',
        'price_monthly', 'price_yearly', 'features', 'custom_domain', 'remove_branding',
        'analytics_access', 'priority_support', 'display_order'
    ];

    /**
     * الحصول على جميع الخطط النشطة
     */
    public function getActivePlans()
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY display_order ASC, price_monthly ASC"
        )->results();
    }

    /**
     * الحصول على الخطة المجانية
     */
    public function getFreePlan()
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE is_free = 1 AND is_active = 1 LIMIT 1"
        )->first();
    }

    /**
     * الحصول على خطة بالـ slug
     */
    public function findBySlug($slug)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE slug = ? AND is_active = 1",
            [$slug]
        )->first();
    }

    /**
     * الحصول على ميزات الخطة كـ array
     */
    public function getFeatures($planId)
    {
        $plan = $this->find($planId);
        
        if (!$plan) {
            return $this->getDefaultFeatures();
        }
        
        return [
            'has_custom_domain' => (bool) ($plan->custom_domain ?? 0),
            'has_ssl' => (bool) ($plan->has_ssl ?? 1),
            'has_analytics' => (bool) ($plan->analytics_access ?? 0),
            'has_custom_colors' => (bool) ($plan->has_custom_colors ?? 1),
            'has_gallery' => (bool) ($plan->has_gallery ?? 1),
            'has_testimonials' => (bool) ($plan->has_testimonials ?? 1),
            'has_banners' => (bool) ($plan->has_banners ?? 1),
            'has_blog' => (bool) ($plan->has_blog ?? 0),
            'has_forms' => (bool) ($plan->has_forms ?? 0),
            'has_seo' => (bool) ($plan->has_seo ?? 1),
            'has_remove_branding' => (bool) ($plan->remove_branding ?? 0),
            'has_priority_support' => (bool) ($plan->priority_support ?? 0),
            'max_services' => (int) ($plan->max_services ?? 3),
            'max_gallery' => (int) ($plan->max_gallery ?? 10),
            'max_banners' => (int) ($plan->max_banners ?? 2),
            'max_pages' => (int) ($plan->max_pages ?? 5),
            'max_testimonials' => (int) ($plan->max_testimonials ?? 10),
            'max_forms' => (int) ($plan->max_forms ?? 0),
            'storage_limit_mb' => (int) ($plan->storage_limit_mb ?? 100),
        ];
    }

    /**
     * الميزات الافتراضية (للمواقع بدون خطة)
     */
    public function getDefaultFeatures()
    {
        return [
            'has_custom_domain' => false,
            'has_ssl' => true,
            'has_analytics' => false,
            'has_custom_colors' => true,
            'has_gallery' => true,
            'has_testimonials' => true,
            'has_banners' => true,
            'has_blog' => false,
            'has_forms' => false,
            'has_seo' => true,
            'has_remove_branding' => false,
            'has_priority_support' => false,
            'max_services' => 3,
            'max_gallery' => 10,
            'max_banners' => 2,
            'max_pages' => 5,
            'max_testimonials' => 10,
            'max_forms' => 0,
            'storage_limit_mb' => 100,
        ];
    }

    /**
     * إنشاء خطة جديدة
     */
    public function createPlan($data)
    {
        // توليد slug إذا لم يكن موجوداً
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }
        
        return $this->create($data);
    }

    /**
     * تحديث خطة
     */
    public function updatePlan($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * حذف خطة
     */
    public function deletePlan($id)
    {
        // التحقق من عدم وجود مشتركين في الخطة
        $count = $this->db->query(
            "SELECT COUNT(*) as count FROM tenants WHERE plan_id = ?",
            [$id]
        )->first()->count;
        
        if ($count > 0) {
            return false; // لا يمكن حذف خطة بها مشتركين
        }
        
        return $this->delete($id);
    }

    /**
     * توليد slug فريد
     */
    private function generateSlug($name)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->findBySlug($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * التحقق من حدود الخطة
     */
    public function checkLimit($tenantId, $resource)
    {
        $tenantModel = new Tenant();
        $tenant = $tenantModel->find($tenantId);
        
        if (!$tenant || !$tenant->subscription_plan_id) {
            $features = $this->getDefaultFeatures();
        } else {
            $features = $this->getFeatures($tenant->subscription_plan_id);
        }
        
        $limitField = 'max_' . $resource;
        
        if (!isset($features[$limitField])) {
            return ['allowed' => true, 'limit' => -1, 'current' => 0];
        }
        
        $limit = $features[$limitField];
        
        // -1 يعني غير محدود
        if ($limit == -1) {
            return ['allowed' => true, 'limit' => -1, 'current' => 0];
        }
        
        // الحصول على العدد الحالي
        $current = $this->getResourceCount($tenantId, $resource);
        
        return [
            'allowed' => $current < $limit,
            'limit' => $limit,
            'current' => $current
        ];
    }

    /**
     * الحصول على عدد موارد معينة
     */
    private function getResourceCount($tenantId, $resource)
    {
        $tables = [
            'services' => 'services',
            'gallery' => 'gallery',
            'banners' => 'banners',
            'pages' => 'pages',
            'testimonials' => 'testimonials',
            'forms' => 'custom_forms'
        ];
        
        if (!isset($tables[$resource])) {
            return 0;
        }
        
        $table = $tables[$resource];
        
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM {$table} WHERE tenant_id = ? AND status = 'active'",
            [$tenantId]
        )->first();
        
        return $result ? $result->count : 0;
    }

    /**
     * التحقق من ميزة معينة
     */
    public function hasFeature($tenantId, $feature)
    {
        $tenantModel = new Tenant();
        $tenant = $tenantModel->find($tenantId);
        
        if (!$tenant || !$tenant->subscription_plan_id) {
            $features = $this->getDefaultFeatures();
        } else {
            $features = $this->getFeatures($tenant->subscription_plan_id);
        }
        
        $featureField = 'has_' . $feature;
        
        if (isset($features[$featureField])) {
            return $features[$featureField];
        }

        // دعم الحقول بدون بادئة has_
        if (isset($features[$feature])) {
            return (bool) $features[$feature];
        }
        
        return false;
    }

    /**
     * الحصول على جميع الخطط (للأدمن)
     */
    public function getAllPlans()
    {
        return $this->db->query(
            "SELECT sp.*, 
                    (SELECT COUNT(*) FROM tenants WHERE plan_id = sp.id) as subscribers_count
             FROM {$this->table} sp 
             ORDER BY sp.display_order ASC, sp.price_monthly ASC"
        )->results();
    }
}
