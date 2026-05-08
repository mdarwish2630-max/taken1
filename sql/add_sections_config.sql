-- =============================================
-- Add sections_config column to tenants table
-- إضافة حقل إعدادات الأقسام لجدول المواقع
-- =============================================

ALTER TABLE `tenants` 
ADD COLUMN `sections_config` TEXT DEFAULT NULL 
COMMENT 'JSON configuration for section visibility' 
AFTER `settings`;

-- Default sections config:
-- {"hero": true, "services": true, "gallery": true, "testimonials": true, "contact": true}
