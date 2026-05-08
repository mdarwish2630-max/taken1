-- =============================================
-- CMS Platform - Add English Fields to Tenants
-- إضافة حقول اللغة الإنجليزية لجدول المستأجرين
-- =============================================

-- إضافة حقول الترجمة لجدول tenants
ALTER TABLE `tenants` ADD COLUMN `site_name_en` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `tenants` ADD COLUMN `meta_description_en` TEXT DEFAULT NULL;

SELECT 'تم إضافة حقول الترجمة الإنجليزية للمستأجرين بنجاح!' as message;
