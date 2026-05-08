<?php
/**
 * CMS Platform - Banner Model
 * نموذج البانرات
 */

class Banner extends Model
{
    protected $table = 'banners';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'title', 'subtitle', 'description', 'image', 'link',
        'button_text', 'position', 'display_order', 'status',
        'title_en', 'subtitle_en', 'description_en', 'button_text_en'
    ];

    /**
     * الحصول على بانرات موقع معين
     */
    public function getTenantBanners($tenantId, $status = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ?";
        $params = [$tenantId];
        
        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY display_order ASC";
        
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على البانرات النشطة
     */
    public function getActiveBanners($tenantId, $position = null, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ? AND status = 'active'";
        $params = [$tenantId];
        
        if ($position) {
            $sql .= " AND position = ?";
            $params[] = $position;
        }
        
        $sql .= " ORDER BY display_order ASC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على بانرات Hero
     */
    public function getHeroBanners($tenantId)
    {
        return $this->getActiveBanners($tenantId, 'hero');
    }

    /**
     * إنشاء بانر جديد
     */
    public function createBanner($data)
    {
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
        $banner = $this->find($id);
        
        if (!$banner) {
            return false;
        }
        
        $newStatus = $banner->status === 'active' ? 'inactive' : 'active';
        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * عدد بانرات مستأجر
     */
    public function countByTenant($tenantId)
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first();
        return $result ? $result->count : 0;
    }

    /**
     * حذف بانر مع صورته
     */
    public function deleteWithImage($id)
    {
        $banner = $this->find($id);
        
        if (!$banner) {
            return false;
        }
        
        // حذف الصورة
        if ($banner->image) {
            $imagePath = UPLOAD_PATH . '/' . $banner->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        return $this->delete($id);
    }
}
