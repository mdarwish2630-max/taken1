-- ============================================================
-- SQL Migration: Partners Table + CTA Columns on Tenants
-- تاريخ: 2026-04-12
-- ============================================================

-- 1. إنشاء جدول الشركاء
CREATE TABLE IF NOT EXISTS `partners` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tenant_id` INT NOT NULL,
    `name` VARCHAR(255) NOT NULL COMMENT 'اسم الشريك بالعربية',
    `name_en` VARCHAR(255) DEFAULT NULL COMMENT 'اسم الشريك بالإنجليزية',
    `logo` VARCHAR(500) DEFAULT NULL COMMENT 'مسار شعار الشريك',
    `link` VARCHAR(500) DEFAULT NULL COMMENT 'رابط موقع الشريك',
    `sort_order` INT DEFAULT 0 COMMENT 'ترتيب العرض',
    `is_active` TINYINT(1) DEFAULT 1 COMMENT 'مفعل/معطل',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_partner_tenant` (`tenant_id`),
    INDEX `idx_partner_active` (`tenant_id`, `is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. إضافة أعمدة CTA لجدول المستأجرين (إذا لم تكن موجودة)
ALTER TABLE `tenants`
    ADD COLUMN IF NOT EXISTS `cta_title` VARCHAR(255) DEFAULT NULL COMMENT 'عنوان قسم CTA',
    ADD COLUMN IF NOT EXISTS `cta_title_en` VARCHAR(255) DEFAULT NULL COMMENT 'عنوان CTA بالإنجليزية',
    ADD COLUMN IF NOT EXISTS `cta_text` VARCHAR(500) DEFAULT NULL COMMENT 'نص قسم CTA',
    ADD COLUMN IF NOT EXISTS `cta_text_en` VARCHAR(500) DEFAULT NULL COMMENT 'نص CTA بالإنجليزية',
    ADD COLUMN IF NOT EXISTS `cta_button_text` VARCHAR(255) DEFAULT NULL COMMENT 'نص زر CTA',
    ADD COLUMN IF NOT EXISTS `cta_button_text_en` VARCHAR(255) DEFAULT NULL COMMENT 'نص زر CTA بالإنجليزية',
    ADD COLUMN IF NOT EXISTS `cta_button_link` VARCHAR(500) DEFAULT '#contact' COMMENT 'رابط زر CTA',
    ADD COLUMN IF NOT EXISTS `cta_is_active` TINYINT(1) DEFAULT 1 COMMENT 'تفعيل قسم CTA';

-- 3. إضافة قسم CTA لإعدادات الأقسام الافتراضية (تحديثات على existing tenants)
-- ملاحظة: sections_config هو JSON، يمكن تحديثه لاحقاً من الداشبورد
