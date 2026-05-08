<?php
/**
 * Sections Config Model
 * نموذج التحكم بأقسام الموقع
 */
class SectionsConfig
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * الحصول على جميع أقسام المستأجر
     */
    public function getByTenant($tenantId)
    {
        return $this->db->query(
            "SELECT * FROM sections_config WHERE tenant_id = ? ORDER BY display_order ASC",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على الأقسام المفعلة كمصفوفة ترابطي
     */
    public function getEnabledMap($tenantId)
    {
        $rows = $this->db->query(
            "SELECT section_key, is_enabled FROM sections_config WHERE tenant_id = ? ORDER BY display_order ASC",
            [$tenantId]
        )->results();

        $map = [];
        foreach ($rows as $row) {
            $map[$row->section_key] = (bool) $row->is_enabled;
        }
        return $map;
    }

    /**
     * التحقق من تفعيل قسم معين
     */
    public function isEnabled($tenantId, $sectionKey)
    {
        $row = $this->db->query(
            "SELECT is_enabled FROM sections_config WHERE tenant_id = ? AND section_key = ?",
            [$tenantId, $sectionKey]
        )->row();

        if (!$row) return true; // إذا لم يكن موجود، اعتبره مفعلاً
        return (bool) $row->is_enabled;
    }

    /**
     * تفعيل/تعطيل قسم
     */
    public function toggle($tenantId, $sectionKey, $enabled)
    {
        return $this->db->query(
            "UPDATE sections_config SET is_enabled = ? WHERE tenant_id = ? AND section_key = ?",
            [$enabled ? 1 : 0, $tenantId, $sectionKey]
        )->affectedRows() > 0;
    }

    /**
     * تحديث ترتيب قسم
     */
    public function updateOrder($tenantId, $sectionKey, $order)
    {
        return $this->db->query(
            "UPDATE sections_config SET display_order = ? WHERE tenant_id = ? AND section_key = ?",
            [$order, $tenantId, $sectionKey]
        )->affectedRows() > 0;
    }

    /**
     * حفظ جميع الأقسام دفعة واحدة
     */
    public function saveAll($tenantId, $sections)
    {
        foreach ($sections as $section) {
            $this->db->query(
                "UPDATE sections_config SET is_enabled = ?, display_order = ? WHERE tenant_id = ? AND section_key = ?",
                [
                    isset($section['is_enabled']) ? ($section['is_enabled'] ? 1 : 0) : 1,
                    $section['display_order'] ?? 0,
                    $tenantId,
                    $section['section_key']
                ]
            );
        }
        return true;
    }

    /**
     * تهيئة الأقسام الافتراضية لمستأجر جديد
     */
    public function initDefaults($tenantId)
    {
        $defaults = [
            ['hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 'fas fa-home'],
            ['services', 'خدماتنا', 'Our Services', 2, 'fas fa-concierge-bell'],
            ['about', 'من نحن', 'About Us', 3, 'fas fa-building'],
            ['why_us', 'لماذا نحن', 'Why Choose Us', 4, 'fas fa-star'],
            ['testimonials', 'آراء العملاء', 'Testimonials', 5, 'fas fa-comments'],
            ['gallery', 'معرض الأعمال', 'Gallery', 6, 'fas fa-images'],
            ['faq', 'الأسئلة الشائعة', 'FAQ', 7, 'fas fa-question-circle'],
            ['contact', 'اتصل بنا', 'Contact Us', 8, 'fas fa-envelope'],
            ['booking', 'حجز موعد', 'Book Appointment', 9, 'fas fa-calendar-check'],
            ['partners', 'شركاؤنا', 'Our Partners', 10, 'fas fa-handshake'],
        ];

        foreach ($defaults as $def) {
            $this->db->query(
                "INSERT IGNORE INTO sections_config (tenant_id, section_key, section_label_ar, section_label_en, is_enabled, display_order, section_icon) VALUES (?, ?, ?, ?, 1, ?, ?)",
                [$tenantId, $def[0], $def[1], $def[2], $def[3], $def[4]]
            );
        }
    }
}
