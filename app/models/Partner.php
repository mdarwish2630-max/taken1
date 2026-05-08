<?php
/**
 * CMS Platform - Partner Model
 * نموذج الشركاء (دعم متعدد المستأجرين)
 */

class Partner extends Model
{
    protected $table = 'partners';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'name', 'name_en', 'logo', 'link', 'sort_order', 'is_active'
    ];

    /**
     * الحصول على شركاء مستأجر معين
     */
    public function getTenantPartners($tenantId, $activeOnly = true)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ?";
        $params = [$tenantId];
        if ($activeOnly) {
            $sql .= " AND is_active = 1";
        }
        $sql .= " ORDER BY sort_order ASC";
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على شريك محدد
     */
    public function findById($id)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE id = ?", [$id]
        )->first();
    }

    /**
     * إضافة شريك جديد
     */
    public function createPartner($data)
    {
        if (!isset($data['sort_order'])) {
            $tenantId = $data['tenant_id'] ?? null;
            $maxOrder = $this->db->query(
                "SELECT COALESCE(MAX(sort_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
                [$tenantId]
            )->first()->max_order;
            $data['sort_order'] = $maxOrder + 1;
        }
        return $this->create($data);
    }

    /**
     * تحديث شريك
     */
    public function updatePartner($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * حذف شريك مع صورته
     */
    public function deletePartner($id)
    {
        $partner = $this->findById($id);
        if ($partner && $partner->logo) {
            $imagePath = UPLOAD_PATH . '/' . $partner->logo;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        return $this->delete($id);
    }

    /**
     * تفعيل/تعطيل شريك
     */
    public function toggleActive($id)
    {
        $partner = $this->findById($id);
        if ($partner) {
            return $this->update($id, ['is_active' => $partner->is_active ? 0 : 1]);
        }
        return false;
    }

    /**
     * عدد شركاء المستأجر
     */
    public function countByTenant($tenantId)
    {
        return $this->db->query(
            "SELECT COUNT(*) as total FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first()->total;
    }
}
