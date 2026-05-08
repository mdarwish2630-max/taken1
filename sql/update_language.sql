-- =============================================
-- Database Update - Add Language Support
-- تحديث قاعدة البيانات - إضافة دعم اللغة
-- =============================================

-- إضافة حقل اللغة الافتراضية للمواقع
ALTER TABLE `tenants` ADD COLUMN `default_language` VARCHAR(5) NOT NULL DEFAULT 'ar' AFTER `settings`;

-- إضافة إعدادات اللغة للنظام
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('default_language', 'ar', 'string', 'اللغة الافتراضية للمنصة'),
('supported_languages', 'ar,en', 'string', 'اللغات المدعومة');

-- إضافة جدول للترجمات المخصصة (اختياري للمستقبل)
CREATE TABLE IF NOT EXISTS `translations` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED DEFAULT NULL COMMENT 'NULL للترجمات العامة',
    `lang` VARCHAR(5) NOT NULL DEFAULT 'ar',
    `key` VARCHAR(255) NOT NULL,
    `value` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_translation` (`tenant_id`, `lang`, `key`),
    KEY `tenant_id` (`tenant_id`),
    KEY `lang` (`lang`),
    CONSTRAINT `translations_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
