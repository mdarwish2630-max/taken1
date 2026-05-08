<?php
/**
 * CMS Platform - FAQ Model
 * نموذج الأسئلة الشائعة
 */

class Faq extends Model
{
    protected $table = 'faqs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'question', 'question_en', 'answer', 'answer_en',
        'category', 'sort_order', 'is_active'
    ];

    /**
     * الحصول على أسئلة موقع معين
     */
    public function getTenantFaqs($tenantId, $activeOnly = false)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ?";
        $params = [$tenantId];

        if ($activeOnly) {
            $sql .= " AND is_active = 1";
        }

        $sql .= " ORDER BY sort_order ASC, created_at ASC";

        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على أسئلة مصنفة لموقع معين
     */
    public function getTenantFaqsGroupedByCategory($tenantId, $activeOnly = true)
    {
        $faqs = $this->getTenantFaqs($tenantId, $activeOnly);

        $grouped = [];
        foreach ($faqs as $faq) {
            $category = $faq->category ?: 'general';
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $faq;
        }

        return $grouped;
    }

    /**
     * الحصول على الأسئلة حسب التصنيف
     */
    public function getByCategory($tenantId, $category, $activeOnly = true)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ? AND category = ?";
        $params = [$tenantId, $category];

        if ($activeOnly) {
            $sql .= " AND is_active = 1";
        }

        $sql .= " ORDER BY sort_order ASC, created_at ASC";

        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على التصنيفات المتاحة لموقع معين
     */
    public function getCategories($tenantId)
    {
        $result = $this->db->query(
            "SELECT DISTINCT category FROM {$this->table} WHERE tenant_id = ? ORDER BY category ASC",
            [$tenantId]
        )->results();

        return array_column($result, 'category');
    }

    /**
     * إنشاء سؤال جديد
     */
    public function createFaq($data)
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
     * تحديث سؤال
     */
    public function updateFaq($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * حذف سؤال
     */
    public function deleteFaq($id)
    {
        return $this->delete($id);
    }

    /**
     * تبديل حالة التفعيل
     */
    public function toggleActive($id)
    {
        $faq = $this->find($id);
        if (!$faq) return false;

        $newValue = $faq->is_active ? 0 : 1;
        return $this->update($id, ['is_active' => $newValue]);
    }

    /**
     * عدد أسئلة موقع معين
     */
    public function countByTenant($tenantId)
    {
        return $this->count("tenant_id = ?", [$tenantId]);
    }
}
