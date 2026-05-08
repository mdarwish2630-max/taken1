<?php
/**
 * CMS Platform - Site Testimonial Model
 * نموذج شهادات الموقع الرئيسي
 */

class SiteTestimonial extends Model
{
    protected $table = 'site_testimonials';
    protected $primaryKey = 'id';
    protected $fillable = [
        'client_name', 'client_title', 'client_company', 'client_image',
        'content', 'rating', 'display_order', 'is_active'
    ];

    /**
     * الحصول على الشهادات النشطة
     */
    public function getActive()
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY display_order ASC"
        )->results();
    }

    /**
     * الحصول على جميع الشهادات
     */
    public function getAll()
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY display_order ASC"
        )->results();
    }

    /**
     * إضافة شهادة
     */
    public function addTestimonial($data)
    {
        // تحديد ترتيب العرض
        if (!isset($data['display_order'])) {
            $maxOrder = $this->db->query(
                "SELECT COALESCE(MAX(display_order), 0) as max_order FROM {$this->table}"
            )->first()->max_order;
            
            $data['display_order'] = $maxOrder + 1;
        }
        
        return $this->create($data);
    }

    /**
     * تحديث ترتيب الشهادات
     */
    public function updateOrder($orders)
    {
        foreach ($orders as $id => $order) {
            $this->update($id, ['display_order' => $order]);
        }
        
        return true;
    }
}
