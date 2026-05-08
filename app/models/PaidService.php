<?php
/**
 * CMS Platform - PaidService Model
 * نموذج الخدمات المدفوعة
 */

class PaidService extends Model
{
    protected $table = 'paid_services';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'slug', 'description', 'price', 'currency',
        'icon', 'category', 'payment_link',
        'is_recurring', 'recurring_period',
        'is_active', 'sort_order', 'max_quantity', 'requires_approval'
    ];

    /**
     * الحصول على الخدمات النشطة
     */
    public function getActive($category = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
        $params = [];

        if ($category) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY sort_order ASC";
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على الخدمات مجمّعة حسب الفئة
     */
    public function getActiveGrouped()
    {
        $services = $this->getActive();
        $grouped = [];

        foreach ($services as $service) {
            if (!isset($grouped[$service->category])) {
                $grouped[$service->category] = [];
            }
            $grouped[$service->category][] = $service;
        }

        return $grouped;
    }

    /**
     * الحصول على جميع الخدمات (للأدمن)
     */
    public function getAll()
    {
        return $this->db->query(
            "SELECT ps.*, 
                    (SELECT COUNT(*) FROM tenant_purchases tp WHERE tp.service_id = ps.id AND tp.status IN ('paid','approved')) as purchase_count
             FROM {$this->table} ps 
             ORDER BY ps.sort_order ASC"
        )->results();
    }

    /**
     * الحصول على الفئات المتاحة
     */
    public function getCategories()
    {
        $results = $this->db->query(
            "SELECT DISTINCT category FROM {$this->table} WHERE is_active = 1 ORDER BY category ASC"
        )->results();

        $categories = [];
        foreach ($results as $row) {
            $categories[$row->category] = $this->getCategoryLabel($row->category);
        }

        return $categories;
    }

    /**
     * الحصول على اسم الفئة بالعربية
     */
    public function getCategoryLabel($category)
    {
        $labels = [
            'domains' => 'النطاقات والدومين',
            'features' => 'ميزات إضافية',
            'marketing' => 'التسويق و SEO',
            'content' => 'المحتوى والكتابة',
            'design' => 'التصميم',
            'support' => 'الدعم الفني',
            'general' => 'خدمات عامة'
        ];

        return $labels[$category] ?? $category;
    }

    /**
     * البحث بالـ slug
     */
    public function findBySlug($slug)
    {
        return $this->findBy('slug', $slug);
    }

    /**
     * إنشاء خدمة جديدة
     */
    public function createService($data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }

        return $this->create($data);
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
     * الحصول على إحصائيات المبيعات
     */
    public function getSalesStats()
    {
        return $this->db->query(
            "SELECT ps.title, ps.category, ps.price,
                    COUNT(tp.id) as total_purchases,
                    SUM(CASE WHEN tp.status IN ('paid','approved') THEN tp.amount ELSE 0 END) as total_revenue,
                    SUM(CASE WHEN tp.status = 'pending' THEN 1 ELSE 0 END) as pending_count
             FROM {$this->table} ps
             LEFT JOIN tenant_purchases tp ON ps.id = tp.service_id
             WHERE ps.is_active = 1
             GROUP BY ps.id
             ORDER BY total_revenue DESC"
        )->results();
    }
}
