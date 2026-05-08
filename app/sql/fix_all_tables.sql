-- ============================================
-- إصلاح شامل لجميع الجداول والأعمدة المطلوبة
-- تنفيذ هذا الملف مرة واحدة في phpMyAdmin
-- ============================================

-- 1. التأكد من وجود جدول site_features مع جميع الأعمدة
CREATE TABLE IF NOT EXISTS `site_features` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED DEFAULT NULL,
    `icon` VARCHAR(100) DEFAULT NULL,
    `title` VARCHAR(255) NOT NULL,
    `title_en` VARCHAR(255) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `description_en` TEXT DEFAULT NULL,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_tenant_id` (`tenant_id`),
    INDEX `idx_tenant_active` (`tenant_id`, `is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. إضافة الأعمدة المفقودة لجدول site_features (إذا لم تكن موجودة)
-- نستخدم إجراء مخزن لتجنب خطأ IF NOT EXISTS في ALTER TABLE
SET @dbname = DATABASE();
SET @tablename = 'site_features';

-- إضافة tenant_id
SET @columnname = 'tenant_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `site_features` ADD COLUMN `tenant_id` INT(11) UNSIGNED DEFAULT NULL AFTER `id`'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- إضافة title_en
SET @columnname = 'title_en';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `site_features` ADD COLUMN `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- إضافة description_en
SET @columnname = 'description_en';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `site_features` ADD COLUMN `description_en` TEXT DEFAULT NULL AFTER `description`'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- إضافة الفهارس
SET @indexname = 'idx_tenant_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND INDEX_NAME = @indexname) > 0,
  'SELECT 1',
  'ALTER TABLE `site_features` ADD INDEX `idx_tenant_id` (`tenant_id`)'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- ============================================
-- 3. التأكد من وجود جدول partners
-- ============================================
CREATE TABLE IF NOT EXISTS `partners` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `name_en` VARCHAR(255) DEFAULT NULL,
    `logo` VARCHAR(500) DEFAULT NULL,
    `link` VARCHAR(500) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_partner_tenant` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. إضافة أعمدة CTA لجدول tenants (إذا لم تكن موجودة)
-- ============================================
SET @tablename = 'tenants';

SET @columnname = 'cta_title';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_title` VARCHAR(255) DEFAULT NULL COMMENT ''عنوان CTA بالعربية'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'cta_title_en';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_title_en` VARCHAR(255) DEFAULT NULL COMMENT ''عنوان CTA بالإنجليزية'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'cta_text';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_text` TEXT DEFAULT NULL COMMENT ''نص CTA بالعربية'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'cta_text_en';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_text_en` TEXT DEFAULT NULL COMMENT ''نص CTA بالإنجليزية'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'cta_button_text';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_button_text` VARCHAR(100) DEFAULT NULL COMMENT ''نص الزر بالعربية'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'cta_button_text_en';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_button_text_en` VARCHAR(100) DEFAULT NULL COMMENT ''نص الزر بالإنجليزية'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'cta_button_link';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_button_link` VARCHAR(500) DEFAULT NULL COMMENT ''رابط الزر'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'cta_is_active';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `tenants` ADD COLUMN `cta_is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT ''تفعيل قسم CTA'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- ============================================
-- تم! جميع الجداول والأعمدة جاهزة
-- ============================================
