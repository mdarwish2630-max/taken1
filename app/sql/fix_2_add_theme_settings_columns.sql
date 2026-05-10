-- ============================================================================
-- الجزء الثاني: إضافة الأعمدة المفقودة إلى جدول theme_settings
-- ============================================================================
-- ملاحظة: إذا ظهر خطأ "Duplicate column name" عند أي سطر فهذا يعني
-- أن العمود موجود مسبقاً - تجاهل الخطأ واستمر
-- ============================================================================

ALTER TABLE `theme_settings` ADD COLUMN `primary_font` VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الرئيسي';

ALTER TABLE `theme_settings` ADD COLUMN `secondary_font` VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الثانوي';

ALTER TABLE `theme_settings` ADD COLUMN `base_font_size` VARCHAR(10) DEFAULT '16' COMMENT 'حجم الخط الأساسي بكسل';

ALTER TABLE `theme_settings` ADD COLUMN `heading_font_weight` VARCHAR(10) DEFAULT '700' COMMENT 'سمك خطوط العناوين';

ALTER TABLE `theme_settings` ADD COLUMN `body_font_weight` VARCHAR(10) DEFAULT '400' COMMENT 'سمك خطوط النص';

ALTER TABLE `theme_settings` ADD COLUMN `primary_color` VARCHAR(7) DEFAULT '#2563eb' COMMENT 'اللون الرئيسي';

ALTER TABLE `theme_settings` ADD COLUMN `secondary_color` VARCHAR(7) DEFAULT '#1e40af' COMMENT 'اللون الثانوي';

ALTER TABLE `theme_settings` ADD COLUMN `accent_color` VARCHAR(7) DEFAULT '#f59e0b' COMMENT 'لون التمييز';

ALTER TABLE `theme_settings` ADD COLUMN `text_color` VARCHAR(7) DEFAULT '#1f2937' COMMENT 'لون النص الرئيسي';

ALTER TABLE `theme_settings` ADD COLUMN `text_muted_color` VARCHAR(7) DEFAULT '#6b7280' COMMENT 'لون النص الثانوي';

ALTER TABLE `theme_settings` ADD COLUMN `background_color` VARCHAR(7) DEFAULT '#ffffff' COMMENT 'لون الخلفية';

ALTER TABLE `theme_settings` ADD COLUMN `card_background` VARCHAR(7) DEFAULT '#ffffff' COMMENT 'لون خلفية البطاقات';

ALTER TABLE `theme_settings` ADD COLUMN `border_color` VARCHAR(7) DEFAULT '#e5e7eb' COMMENT 'لون الحدود';

ALTER TABLE `theme_settings` ADD COLUMN `button_radius` VARCHAR(10) DEFAULT '8' COMMENT 'استدارة الأزرار';

ALTER TABLE `theme_settings` ADD COLUMN `card_radius` VARCHAR(10) DEFAULT '12' COMMENT 'استدارة البطاقات';

ALTER TABLE `theme_settings` ADD COLUMN `button_shadow` TINYINT(1) DEFAULT 0 COMMENT 'ظل الأزرار';

ALTER TABLE `theme_settings` ADD COLUMN `card_hover_effect` VARCHAR(20) DEFAULT 'lift' COMMENT 'تأثير تمرير البطاقات';

ALTER TABLE `theme_settings` ADD COLUMN `enable_animations` TINYINT(1) DEFAULT 1 COMMENT 'تفعيل الرسوم المتحركة';

ALTER TABLE `theme_settings` ADD COLUMN `animation_type` VARCHAR(20) DEFAULT 'fade' COMMENT 'نوع الرسوم المتحركة';

ALTER TABLE `theme_settings` ADD COLUMN `container_width` VARCHAR(10) DEFAULT '1200' COMMENT 'عرض الحاوية بكسل';

ALTER TABLE `theme_settings` ADD COLUMN `header_fixed` TINYINT(1) DEFAULT 0 COMMENT 'ثبات الرأس';

ALTER TABLE `theme_settings` ADD COLUMN `sidebar_position` VARCHAR(10) DEFAULT 'right' COMMENT 'موضع الشريط الجانبي';

-- ============================================================================
-- مزامنة الأعمدة القديمة بالقيم الافتراضية (إن وجدت)
-- ============================================================================

UPDATE `theme_settings` SET `primary_font` = `font_primary` WHERE `primary_font` = 'Tajawal' AND `font_primary` IS NOT NULL AND `font_primary` != 'Tajawal';

UPDATE `theme_settings` SET `secondary_font` = `font_secondary` WHERE `secondary_font` = 'Tajawal' AND `font_secondary` IS NOT NULL AND `font_secondary` != 'Tajawal';

UPDATE `theme_settings` SET `base_font_size` = REPLACE(`font_size_base`, 'px', '') WHERE `font_size_base` IS NOT NULL AND `font_size_base` != '16px';

UPDATE `theme_settings` SET `enable_animations` = `animation_enabled` WHERE `animation_enabled` IS NOT NULL;
