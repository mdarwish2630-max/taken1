-- =============================================
-- استعادة جدول themes - Restore Themes Table
-- يشمل: إنشاء الجدول + البيانات الأساسية (6 ثيمات)
-- =============================================

-- 1. حذف جدول طلبات الثيمات أولاً (لوجود foreign key)
DROP TABLE IF EXISTS `theme_requests`;

-- 2. حذف جدول الثيمات القديم إن وجد
DROP TABLE IF EXISTS `themes`;

-- 3. إنشاء جدول themes بالبنية الكاملة (شامل كل الأعمدة)
CREATE TABLE `themes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `name_en` VARCHAR(100) DEFAULT NULL COMMENT 'اسم القالب بالإنجليزية',
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `description_en` TEXT DEFAULT NULL COMMENT 'وصف القالب بالإنجليزية',
    `category` ENUM('maintenance', 'decor', 'electric', 'plumbing', 'cleaning', 'general', 'other') NOT NULL DEFAULT 'general',
    `preview_image` VARCHAR(255) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_premium` TINYINT(1) NOT NULL DEFAULT 0,
    `is_paid` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'هل القالب مدفوع 0=مجاني 1=مدفوع',
    `price` DECIMAL(10,2) DEFAULT 0.00 COMMENT 'سعر القالب المدفوع',
    `currency` VARCHAR(10) DEFAULT 'SAR' COMMENT 'عملة السعر',
    `payment_link` VARCHAR(500) DEFAULT NULL COMMENT 'رابط الدفع للقالب المدفوع',
    `sort_order` INT(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب العرض',
    `version` VARCHAR(20) DEFAULT '1.0.0',
    `settings_schema` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. إدخال البيانات الأساسية (6 ثيمات مع الترجمة الإنجليزية)
INSERT INTO `themes` (`name`, `name_en`, `slug`, `description`, `description_en`, `category`, `preview_image`, `is_active`, `is_premium`, `is_paid`, `price`, `currency`, `payment_link`, `sort_order`) VALUES
('خدمات الصيانة', 'Maintenance Services', 'maintenance', 'قالب متخصص لشركات الصيانة والإصلاحات المنزلية', 'Specialized template for maintenance and home repair companies', 'maintenance', 'maintenance-preview.jpg', 1, 0, 0, 0.00, 'SAR', NULL, 2),
('خدمات الديكور', 'Decor & Design', 'decor', 'قالب أنيق لشركات الديكور والتصميم الداخلي', 'Elegant template for interior design and decoration companies', 'decor', 'decor-preview.jpg', 1, 0, 0, 0.00, 'SAR', NULL, 3),
('خدمات الكهرباء', 'Electrical Services', 'electric', 'قالب احترافي للكهربائيين وشركات الكهرباء', 'Professional template for electricians and electrical companies', 'electric', 'electric-preview.jpg', 1, 0, 0, 0.00, 'SAR', NULL, 4),
('خدمات السباكة', 'Plumbing Services', 'plumbing', 'قالب متخصص للسباكين وشركات السباكة', 'Specialized template for plumbers and plumbing companies', 'plumbing', 'plumbing-preview.jpg', 1, 0, 0, 0.00, 'SAR', NULL, 5),
('خدمات التنظيف', 'Cleaning Services', 'cleaning', 'قالب منعش لشركات التنظيف', 'Fresh template for cleaning companies', 'cleaning', 'cleaning-preview.jpg', 1, 0, 0, 0.00, 'SAR', NULL, 6),
('خدمات عامة', 'General Services', 'general', 'قالب عام مناسب لجميع أنواع الخدمات', 'General template suitable for all types of services', 'general', 'general-preview.jpg', 1, 0, 0, 0.00, 'SAR', NULL, 7);

-- 5. إعادة إنشاء جدول طلبات تفعيل الثيمات المدفوعة
CREATE TABLE IF NOT EXISTS `theme_requests` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `theme_id` INT(11) UNSIGNED NOT NULL,
    `status` ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
    `amount` DECIMAL(10,2) DEFAULT 0.00,
    `currency` VARCHAR(10) DEFAULT 'SAR',
    `payment_method` VARCHAR(100) DEFAULT NULL,
    `payment_ref` VARCHAR(255) DEFAULT NULL,
    `admin_notes` TEXT DEFAULT NULL COMMENT 'ملاحظات الأدمن عند القبول/الرفض',
    `tenant_notes` TEXT DEFAULT NULL COMMENT 'ملاحظات المشترك',
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
