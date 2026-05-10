-- ترقية نظام الثيمات - ملف SQL بسيط
-- شغّله في phpMyAdmin: تبويب SQL

SET FOREIGN_KEY_CHECKS = 0;

UPDATE IGNORE `tenants` SET `theme_id` = 1 WHERE `theme_id` = 6;
UPDATE IGNORE `tenants` SET `theme_id` = 2 WHERE `theme_id` = 3;
UPDATE IGNORE `tenants` SET `theme_id` = 3 WHERE `theme_id` = 5;
UPDATE IGNORE `tenants` SET `theme_id` = 4 WHERE `theme_id` = 2;
UPDATE IGNORE `tenants` SET `theme_id` = 5 WHERE `theme_id` = 1;
UPDATE IGNORE `tenants` SET `theme_id` = 6 WHERE `theme_id` = 4;

DROP TABLE IF EXISTS `theme_requests`;
DROP TABLE IF EXISTS `themes`;

CREATE TABLE `themes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `name_en` VARCHAR(100) DEFAULT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `description_en` TEXT DEFAULT NULL,
    `category` ENUM('general','maintenance','decor','electric','plumbing','cleaning','medical','realestate','restaurant','education','fitness','legal','other') NOT NULL DEFAULT 'general',
    `preview_image` VARCHAR(255) DEFAULT NULL,
    `thumbnail` VARCHAR(500) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_premium` TINYINT(1) NOT NULL DEFAULT 0,
    `is_paid` TINYINT(1) NOT NULL DEFAULT 0,
    `price` DECIMAL(10,2) DEFAULT 0.00,
    `currency` VARCHAR(10) DEFAULT 'SAR',
    `payment_link` VARCHAR(500) DEFAULT NULL,
    `sort_order` INT(11) NOT NULL DEFAULT 0,
    `version` VARCHAR(20) DEFAULT '1.0.0',
    `settings_schema` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `category` (`category`),
    KEY `is_active` (`is_active`),
    KEY `is_paid` (`is_paid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `themes` (`id`,`name`,`name_en`,`slug`,`description`,`description_en`,`category`,`preview_image`,`thumbnail`,`is_active`,`is_premium`,`is_paid`,`price`,`currency`,`sort_order`,`version`) VALUES
(1,'خدمات عامة','General Services','general','قالب متعدد الاستخدامات مناسب لجميع أنواع الخدمات','Versatile template for all types of services','general','uploads/themes/previews/general-preview.png','uploads/themes/previews/general-preview.png',1,0,0,0.00,'SAR',1,'1.0.0'),
(2,'كهرباء الموثوق','Reliable Electric','electric','قالب احترافي متخصص لشركات الكهرباء','Professional template for electrical companies','electric','uploads/themes/previews/electric-preview.png','uploads/themes/previews/electric-preview.png',1,0,0,0.00,'SAR',2,'1.0.0'),
(3,'نضارة','CleanSpark','cleaning','قالب منعش ومشرق لشركات التنظيف','Fresh template for cleaning companies','cleaning','uploads/themes/previews/cleaning-preview.png','uploads/themes/previews/cleaning-preview.png',1,0,0,0.00,'SAR',3,'1.0.0'),
(4,'أثر الديكور','Decor Mark','decor','قالب أنيق وفاخر لشركات الديكور','Elegant template for interior design','decor','uploads/themes/previews/decor-preview.png','uploads/themes/previews/decor-preview.png',1,0,0,0.00,'SAR',4,'1.0.0'),
(5,'الصيانة الأولى','First Maintenance','maintenance','قالب عملي وموثوق لشركات الصيانة','Practical template for maintenance','maintenance','uploads/themes/previews/maintenance-preview.png','uploads/themes/previews/maintenance-preview.png',1,0,0,0.00,'SAR',5,'1.0.0'),
(6,'سباكة الضمان','Warranty Plumbing','plumbing','قالب متخصص لشركات السباكة','Specialized template for plumbing','plumbing','uploads/themes/previews/plumbing-preview.png','uploads/themes/previews/plumbing-preview.png',1,0,0,0.00,'SAR',6,'1.0.0'),
(7,'طبيبروف','MediPro','medical','قالب طبي احترافي للعيادات والمستشفيات','Professional medical template','medical','uploads/themes/previews/medical-preview.png','uploads/themes/previews/medical-preview.png',1,1,1,149.00,'SAR',7,'1.0.0'),
(8,'عقار الخليج','Gulf Estates','realestate','قالب فاخر لشركات العقارات','Luxurious real estate template','realestate','uploads/themes/previews/realestate-preview.png','uploads/themes/previews/realestate-preview.png',1,1,1,199.00,'SAR',8,'1.0.0'),
(9,'مائدة شهية','Feast Table','restaurant','قالب أنيق للمطاعم والكافيهات','Elegant restaurant template','restaurant','uploads/themes/previews/restaurant-preview.png','uploads/themes/previews/restaurant-preview.png',1,1,1,149.00,'SAR',9,'1.0.0'),
(10,'مسار المعرفة','Knowledge Path Academy','education','قالب أكاديمي للمدارس ومراكز التدريب','Academic template for schools','education','uploads/themes/previews/education-preview.png','uploads/themes/previews/education-preview.png',1,1,1,149.00,'SAR',10,'1.0.0'),
(11,'العدل للمحاماة','Al-Adal Legal','legal','قالب رسمي فاخر لمكاتب المحاماة','Premium template for law firms','legal','uploads/themes/previews/legal-preview.png','uploads/themes/previews/legal-preview.png',1,1,1,199.00,'SAR',11,'1.0.0'),
(12,'أبطال الصحة','Health Champions','fitness','قالب رياضي للنوادي وصالات الجيم','Sports template for gyms','fitness','uploads/themes/previews/fitness-preview.png','uploads/themes/previews/fitness-preview.png',1,1,1,149.00,'SAR',12,'1.0.0');

CREATE TABLE IF NOT EXISTS `theme_requests` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `theme_id` INT(11) UNSIGNED NOT NULL,
    `status` ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
    `amount` DECIMAL(10,2) DEFAULT 0.00,
    `currency` VARCHAR(10) DEFAULT 'SAR',
    `payment_method` VARCHAR(100) DEFAULT NULL,
    `payment_ref` VARCHAR(255) DEFAULT NULL,
    `admin_notes` TEXT DEFAULT NULL,
    `tenant_notes` TEXT DEFAULT NULL,
    `approved_at` DATETIME DEFAULT NULL,
    `rejected_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    KEY `theme_id` (`theme_id`),
    KEY `status` (`status`),
    CONSTRAINT `theme_requests_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `theme_requests_theme_fk` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
