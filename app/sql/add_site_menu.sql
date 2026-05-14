-- ============================================
-- إضافة جدول إدارة المنو (site_menu)
-- replaces: pages table menu usage
-- ============================================

CREATE TABLE IF NOT EXISTS `site_menu` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `tenant_id` INT UNSIGNED NOT NULL,
    `item_type` ENUM('section','page','external') NOT NULL DEFAULT 'section',
    `section_key` VARCHAR(50) DEFAULT NULL COMMENT 'home, about, services, gallery, faq, partners, contact, booking, blog',
    `page_id` INT UNSIGNED DEFAULT NULL COMMENT 'if item_type = page',
    `label` VARCHAR(100) NOT NULL COMMENT 'النص بالعربي',
    `label_en` VARCHAR(100) DEFAULT NULL COMMENT 'النص بالإنجليزي',
    `url` VARCHAR(255) DEFAULT NULL COMMENT 'للـ external فقط',
    `icon` VARCHAR(50) DEFAULT NULL COMMENT 'fa-home مثلاً',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `menu_order` INT NOT NULL DEFAULT 0,
    `open_in_new_tab` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_tenant_active` (`tenant_id`, `is_active`, `menu_order`),
    INDEX `idx_tenant_type` (`tenant_id`, `item_type`),
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================
-- إضافة عناصر المنو الافتراضية لكل المستأجرين الحاليين
-- ============================================

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'home', 'الرئيسية', 'Home', 'fa-home', 1, 1
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'home'
);

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'about', 'من نحن', 'About Us', 'fa-building', 1, 2
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'about'
);

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'services', 'خدماتنا', 'Our Services', 'fa-concierge-bell', 1, 3
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'services'
);

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'gallery', 'معرض الأعمال', 'Gallery', 'fa-photo-video', 1, 4
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'gallery'
);

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'faq', 'الأسئلة الشائعة', 'FAQ', 'fa-question-circle', 1, 5
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'faq'
);

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'partners', 'شركاؤنا', 'Our Partners', 'fa-handshake', 1, 6
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'partners'
);

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'blog', 'المدونة', 'Blog', 'fa-blog', 1, 7
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'blog'
);

INSERT INTO `site_menu` (`tenant_id`, `item_type`, `section_key`, `label`, `label_en`, `icon`, `is_active`, `menu_order`)
SELECT `id`, 'section', 'contact', 'اتصل بنا', 'Contact Us', 'fa-envelope', 1, 8
FROM `tenants` WHERE NOT EXISTS (
    SELECT 1 FROM `site_menu` sm WHERE sm.tenant_id = tenants.id AND sm.section_key = 'contact'
);
