<?php
/**
 * CMS Platform - Site Feature Model
 * نموذج مميزات الموقع (دعم متعدد المستأجرين)
 */

class SiteFeature extends Model
{
    protected $table = 'site_features';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'icon', 'title', 'title_en', 'description', 'description_en',
        'display_order', 'is_active'
    ];

    /**
     * الحصول على مميزات مستأجر معين (النشطة فقط)
     */
    public function getTenantFeatures($tenantId, $activeOnly = true)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ?";
        if ($activeOnly) {
            $sql .= " AND is_active = 1";
        }
        $sql .= " ORDER BY display_order ASC";

        return $this->db->query($sql, [$tenantId])->results();
    }

    /**
     * الحصول على المميزات العامة للمنصة (بدون مستأجر)
     */
    public function getGlobalFeatures($activeOnly = true)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id IS NULL";
        if ($activeOnly) {
            $sql .= " AND is_active = 1";
        }
        $sql .= " ORDER BY display_order ASC";

        return $this->db->query($sql)->results();
    }

    /**
     * الحصول على المميزات النشطة (للإدارة)
     */
    public function getActive()
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY display_order ASC"
        )->results();
    }

    /**
     * الحصول على جميع المميزات (للإدارة)
     */
    public function getAll()
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY display_order ASC"
        )->results();
    }

    /**
     * الحصول على مميزة محددة
     */
    public function findById($id)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE id = ?", [$id]
        )->first();
    }

    /**
     * إضافة ميزة جديدة لمستأجر
     */
    public function addFeature($data)
    {
        if (!isset($data['display_order'])) {
            $tenantId = $data['tenant_id'] ?? null;
            $sql = "SELECT COALESCE(MAX(display_order), 0) as max_order FROM {$this->table} WHERE tenant_id " . ($tenantId ? "= ?" : "IS NULL");
            $params = $tenantId ? [$tenantId] : [];
            $maxOrder = $this->db->query($sql, $params)->first()->max_order;
            $data['display_order'] = $maxOrder + 1;
        }

        return $this->create($data);
    }

    /**
     * تحديث ميزة
     */
    public function updateFeature($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * حذف ميزة
     */
    public function deleteFeature($id)
    {
        return $this->delete($id);
    }

    /**
     * تفعيل/تعطيل ميزة
     */
    public function toggleActive($id)
    {
        $feature = $this->findById($id);
        if ($feature) {
            return $this->update($id, ['is_active' => $feature->is_active ? 0 : 1]);
        }
        return false;
    }

    /**
     * عدد مميزات المستأجر
     */
    public function countByTenant($tenantId)
    {
        return $this->db->query(
            "SELECT COUNT(*) as total FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first()->total;
    }

    /**
     * الحصول على المميزات للموقع (مع دعم اللغة)
     * إذا لم يكن لدى المستأجر مميزات، يرجع المميزات العامة
     */
    public function getSiteFeatures($tenantId)
    {
        $features = $this->getTenantFeatures($tenantId, true);

        // إذا لم يكن لدى المستأجر مميزات، استخدم المميزات العامة
        if (empty($features)) {
            $features = $this->getGlobalFeatures(true);
        }

        // دعم اللغة الإنجليزية
        $lang = \Language::current();
        foreach ($features as $f) {
            if ($lang === 'en') {
                $f->display_title = $f->title_en ?: $f->title;
                $f->display_description = $f->description_en ?: $f->description;
            } else {
                $f->display_title = $f->title;
                $f->display_description = $f->description;
            }
        }

        return $features;
    }
}
