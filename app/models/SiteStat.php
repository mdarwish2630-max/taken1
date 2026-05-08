<?php
/**
 * CMS Platform - SiteStat Model
 * نموذج إحصائيات الموقع (العداد)
 */

class SiteStat extends Model
{
    protected $table = 'site_stats';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'label', 'label_en', 'value', 'suffix', 'icon',
        'sort_order', 'is_active'
    ];

    /**
     * الحصول على إحصائيات موقع معين
     */
    public function getTenantStats($tenantId, $activeOnly = true)
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
     * إنشاء إحصائية جديدة
     */
    public function createStat($data)
    {
        if (!isset($data['sort_order'])) {
            $maxOrder = $this->db->query(
                "SELECT COALESCE(MAX(sort_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
                [$data['tenant_id']]
            )->first()->max_order;

            $data['sort_order'] = $maxOrder + 1;
        }

        return $this->create($data);
    }

    /**
     * تحديث إحصائية
     */
    public function updateStat($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * حذف إحصائية
     */
    public function deleteStat($id)
    {
        return $this->delete($id);
    }

    /**
     * تبديل حالة التفعيل
     */
    public function toggleActive($id)
    {
        $stat = $this->find($id);
        if (!$stat) return false;

        $newValue = $stat->is_active ? 0 : 1;
        return $this->update($id, ['is_active' => $newValue]);
    }

    /**
     * عدد إحصائيات موقع معين
     */
    public function countByTenant($tenantId)
    {
        return $this->count("tenant_id = ?", [$tenantId]);
    }
}
