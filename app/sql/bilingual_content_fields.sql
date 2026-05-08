-- =============================================
-- CMS Platform - Bilingual Content Fields Migration
-- إضافة حقول المحتوى الإنجليزية - إدخال بيانات ثنائية اللغة
-- =============================================
-- شغل هذا الملف مرة واحدة بعد database.sql
-- =============================================

-- 1. خدمات - حقول الإنجليزية
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `description_en` TEXT DEFAULT NULL AFTER `description`;
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `content_en` LONGTEXT DEFAULT NULL AFTER `content`;

-- 2. البانرات - حقول الإنجليزية
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `subtitle_en` VARCHAR(255) DEFAULT NULL AFTER `subtitle`;
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `description_en` TEXT DEFAULT NULL AFTER `description`;
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `button_text_en` VARCHAR(255) DEFAULT NULL AFTER `button_text`;

-- 3. معرض الأعمال - حقول الإنجليزية
ALTER TABLE `gallery` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;

-- 4. آراء العملاء - حقول الإنجليزية
ALTER TABLE `testimonials` ADD COLUMN IF NOT EXISTS `content_en` TEXT DEFAULT NULL AFTER `content`;
ALTER TABLE `testimonials` ADD COLUMN IF NOT EXISTS `client_title_en` VARCHAR(255) DEFAULT NULL AFTER `client_title`;

-- 5. الصفحات - حقول الإنجليزية
ALTER TABLE `pages` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `pages` ADD COLUMN IF NOT EXISTS `content_en` LONGTEXT DEFAULT NULL AFTER `content`;

-- 6. المستأجرين - حقول الإنجليزية
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `site_name_en` VARCHAR(255) DEFAULT NULL AFTER `site_name`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `meta_description_en` TEXT DEFAULT NULL AFTER `meta_description`;

SELECT '✅ تم إضافة جميع حقول الترجمة الإنجليزية بنجاح!' as message;
