<?php
/**
 * CMS Platform - Service Model
 * نموذج الخدمات
 */

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'title', 'slug', 'description', 'content', 'image', 'icon',
        'price', 'price_text', 'show_on_home', 'display_order', 'status',
        'title_en', 'description_en', 'content_en'
    ];

    /**
     * الحصول على خدمات موقع معين
     */
    public function getTenantServices($tenantId, $status = 'active')
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ?";
        $params = [$tenantId];
        
        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY display_order ASC, created_at DESC";
        
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على خدمات الصفحة الرئيسية
     */
    public function getHomeServices($tenantId, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE tenant_id = ? AND status = 'active' AND show_on_home = 1 
                ORDER BY display_order ASC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql, [$tenantId])->results();
    }

    /**
     * إنشاء خدمة جديدة
     */
    public function createService($data)
    {
        // توليد slug فريد
        $data['slug'] = generateUniqueSlug(
            $data['title'], 
            $this->table, 
            'slug',
            $data['id'] ?? null
        );
        
        // تعيين الترتيب
        if (!isset($data['display_order'])) {
            $maxOrder = $this->db->query(
                "SELECT COALESCE(MAX(display_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
                [$data['tenant_id']]
            )->first()->max_order;
            
            $data['display_order'] = $maxOrder + 1;
        }
        
        return $this->create($data);
    }

    /**
     * تحديث خدمة
     */
    public function updateService($id, $data)
    {
        if (isset($data['title'])) {
            $service = $this->find($id);
            $data['slug'] = generateUniqueSlug(
                $data['title'], 
                $this->table, 
                'slug',
                $id
            );
        }
        
        return $this->update($id, $data);
    }

    /**
     * البحث بواسطة Slug والموقع
     */
    public function findBySlug($slug, $tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE slug = ? AND tenant_id = ?",
            [$slug, $tenantId]
        )->first();
    }

    /**
     * تحديث الترتيب
     */
    public function updateOrder($id, $order)
    {
        return $this->update($id, ['display_order' => $order]);
    }

    /**
     * تبديل الحالة
     */
    public function toggleStatus($id)
    {
        $service = $this->find($id);
        
        if (!$service) {
            return false;
        }
        
        $newStatus = $service->status === 'active' ? 'inactive' : 'active';
        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * الحصول على عدد الخدمات
     */
    public function countByTenant($tenantId, $status = null)
    {
        $conditions = "tenant_id = ?";
        $params = [$tenantId];
        
        if ($status) {
            $conditions .= " AND status = ?";
            $params[] = $status;
        }
        
        return $this->count($conditions, $params);
    }
}
