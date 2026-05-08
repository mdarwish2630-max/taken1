-- ============================================================
-- TakweenWeb - Sections Control System
-- نظام التحكم بأقسام الموقع لكل مستأجر
-- ============================================================

-- 1. إنشاء جدول التحكم بالأقسام
CREATE TABLE IF NOT EXISTS `sections_config` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `section_key` varchar(50) NOT NULL COMMENT 'hero, services, about, why_us, testimonials, gallery, faq, contact, booking, partners',
  `section_label_ar` varchar(100) NOT NULL,
  `section_label_en` varchar(100) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `section_icon` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tenant_section` (`tenant_id`, `section_key`),
  KEY `idx_tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. إدراج الأقسام لجميع المستأجرين الحاليين
INSERT IGNORE INTO `sections_config` (`tenant_id`, `section_key`, `section_label_ar`, `section_label_en`, `is_enabled`, `display_order`, `section_icon`)
SELECT t.id, s.section_key, s.section_label_ar, s.section_label_en, s.is_enabled, s.display_order, s.section_icon
FROM `tenants` t
CROSS JOIN (
    SELECT 'hero' AS section_key, 'القسم الرئيسي (Hero)' AS section_label_ar, 'Hero Section' AS section_label_en, 1 AS is_enabled, 1 AS display_order, 'fas fa-home' AS section_icon
    UNION ALL SELECT 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell'
    UNION ALL SELECT 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building'
    UNION ALL SELECT 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star'
    UNION ALL SELECT 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments'
    UNION ALL SELECT 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images'
    UNION ALL SELECT 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle'
    UNION ALL SELECT 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope'
    UNION ALL SELECT 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check'
    UNION ALL SELECT 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake'
) s
WHERE NOT EXISTS (
    SELECT 1 FROM sections_config sc WHERE sc.tenant_id = t.id
);
