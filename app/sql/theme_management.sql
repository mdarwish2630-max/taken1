-- =============================================
-- Theme Management System - إدارة القوالب
-- Admin control: activate/deactivate, paid/free, pricing, requests
-- Compatible with MySQL 5.7+ and MariaDB 10.0+
-- =============================================

-- 1. إضافة أعمدة جديدة لجدول themes (بشكل آمن - متوافق مع MySQL 5.7)
-- يتم التحقق من وجود العمود قبل إضافته

-- is_paid
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'themes' AND COLUMN_NAME = 'is_paid');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `is_paid` TINYINT(1) NOT NULL DEFAULT 0 COMMENT ''هل القالب مدفوع 0=مجاني 1=مدفوع'' AFTER `is_premium`', 'SELECT ''Column is_paid already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- price
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'themes' AND COLUMN_NAME = 'price');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `price` DECIMAL(10,2) DEFAULT 0.00 COMMENT ''سعر القالب المدفوع'' AFTER `is_paid`', 'SELECT ''Column price already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- currency
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'themes' AND COLUMN_NAME = 'currency');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `currency` VARCHAR(10) DEFAULT ''SAR'' COMMENT ''عملة السعر'' AFTER `price`', 'SELECT ''Column currency already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- payment_link
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'themes' AND COLUMN_NAME = 'payment_link');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `payment_link` VARCHAR(500) DEFAULT NULL COMMENT ''رابط الدفع للقالب المدفوع'' AFTER `currency`', 'SELECT ''Column payment_link already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- sort_order
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'themes' AND COLUMN_NAME = 'sort_order');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `sort_order` INT(11) NOT NULL DEFAULT 0 COMMENT ''ترتيب العرض'' AFTER `payment_link`', 'SELECT ''Column sort_order already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- name_en (قد يكون موجوداً من ملفات ثنائية اللغة السابقة)
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'themes' AND COLUMN_NAME = 'name_en');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `name_en` VARCHAR(100) DEFAULT NULL COMMENT ''اسم القالب بالإنجليزية'' AFTER `name`', 'SELECT ''Column name_en already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- description_en (قد يكون موجوداً من ملفات ثنائية اللغة السابقة)
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'themes' AND COLUMN_NAME = 'description_en' AND TABLE_SCHEMA = DATABASE());
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `description_en` TEXT DEFAULT NULL COMMENT ''وصف القالب بالإنجليزية'' AFTER `description`', 'SELECT ''Column description_en already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- preview_image
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'themes' AND COLUMN_NAME = 'preview_image');
SET @sql = IF(@col_exists = 0, 'ALTER TABLE `themes` ADD COLUMN `preview_image` VARCHAR(255) DEFAULT NULL COMMENT ''صورة معاينة القالب'' AFTER `description_en`', 'SELECT ''Column preview_image already exists - skipped''');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 2. تحديث بيانات الثيمات الحالية (كلها مجانية)
UPDATE `themes` SET `is_paid` = 0, `price` = 0.00 WHERE `is_paid` IS NULL OR `is_paid` = 0;

-- 3. إنشاء جدول طلبات تفعيل الثيمات المدفوعة
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
