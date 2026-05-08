<?php
/**
 * CMS Platform - Testimonial Model
 * نموذج آراء العملاء
 */

class Testimonial extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'client_name', 'client_title', 'client_image', 'content',
        'rating', 'show_on_home', 'display_order', 'status',
        'content_en', 'client_title_en'
    ];

    /**
     * الحصول على آراء موقع معين
     */
    public function getTenantTestimonials($tenantId, $status = null)
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
     * الحصول على آراء الصفحة الرئيسية
     */
    public function getHomeTestimonials($tenantId, $limit = null)
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
     * إنشاء رأي جديد
     */
    public function createTestimonial($data)
    {
        // التحقق من التقييم
        if (!isset($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) {
            $data['rating'] = 5;
        }
        
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
     * تبديل الحالة
     */
    public function toggleStatus($id)
    {
        $testimonial = $this->find($id);
        
        if (!$testimonial) {
            return false;
        }
        
        $newStatus = $testimonial->status === 'active' ? 'inactive' : 'active';
        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * تبديل العرض في الرئيسية
     */
    public function toggleHomeDisplay($id)
    {
        $testimonial = $this->find($id);
        
        if (!$testimonial) {
            return false;
        }
        
        $newValue = $testimonial->show_on_home ? 0 : 1;
        return $this->update($id, ['show_on_home' => $newValue]);
    }

    /**
     * الحصول على متوسط التقييم
     */
    public function getAverageRating($tenantId)
    {
        $result = $this->db->query(
            "SELECT AVG(rating) as avg_rating FROM {$this->table} WHERE tenant_id = ? AND status = 'active'",
            [$tenantId]
        )->first();
        
        return $result ? round($result->avg_rating, 1) : 0;
    }

    /**
     * حذف مع صورة العميل
     */
    public function deleteWithImage($id)
    {
        $testimonial = $this->find($id);
        
        if (!$testimonial) {
            return false;
        }
        
        // حذف الصورة
        if ($testimonial->client_image) {
            $imagePath = UPLOAD_PATH . '/' . $testimonial->client_image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        return $this->delete($id);
    }
}
