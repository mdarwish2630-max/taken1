-- =============================================
-- Subscription Plans System
-- نظام خطط الاشتراك
-- =============================================

-- 1. إنشاء جدول خطط الاشتراك
CREATE TABLE IF NOT EXISTS `subscription_plans` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `currency` VARCHAR(10) NOT NULL DEFAULT 'SAR',
    `duration_days` INT(11) NOT NULL DEFAULT 30,
    `trial_days` INT(11) NOT NULL DEFAULT 0,
    
    -- الميزات
    `has_custom_domain` TINYINT(1) NOT NULL DEFAULT 0,
    `has_ssl` TINYINT(1) NOT NULL DEFAULT 1,
    `has_analytics` TINYINT(1) NOT NULL DEFAULT 0,
    `has_custom_colors` TINYINT(1) NOT NULL DEFAULT 1,
    `has_gallery` TINYINT(1) NOT NULL DEFAULT 1,
    `has_testimonials` TINYINT(1) NOT NULL DEFAULT 1,
    `has_banners` TINYINT(1) NOT NULL DEFAULT 1,
    `has_blog` TINYINT(1) NOT NULL DEFAULT 0,
    `has_forms` TINYINT(1) NOT NULL DEFAULT 0,
    `has_seo` TINYINT(1) NOT NULL DEFAULT 1,
    
    -- الحدود
    `max_services` INT(11) NOT NULL DEFAULT -1,
    `max_gallery_images` INT(11) NOT NULL DEFAULT -1,
    `max_banners` INT(11) NOT NULL DEFAULT -1,
    `max_pages` INT(11) NOT NULL DEFAULT -1,
    `max_testimonials` INT(11) NOT NULL DEFAULT -1,
    `max_forms` INT(11) NOT NULL DEFAULT 0,
    `storage_limit_mb` INT(11) NOT NULL DEFAULT 100,
    
    -- إعدادات
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_free` TINYINT(1) NOT NULL DEFAULT 0,
    `is_popular` TINYINT(1) NOT NULL DEFAULT 0,
    `sort_order` INT(11) NOT NULL DEFAULT 0,
    
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. إضافة حقل plan_id لجدول tenants
ALTER TABLE `tenants` 
ADD COLUMN `plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `theme_id`,
ADD COLUMN `trial_ends_at` DATETIME DEFAULT NULL AFTER `subscription_end`,
ADD COLUMN `plan_features` TEXT DEFAULT NULL COMMENT 'JSON snapshot of plan features at subscription time' AFTER `sections_config`;

-- إضافة مفتاح أجنبي
ALTER TABLE `tenants`
ADD CONSTRAINT `tenants_plan_fk` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE SET NULL;

-- 3. إضافة الخطط الافتراضية
INSERT INTO `subscription_plans` 
(`name`, `slug`, `description`, `price`, `duration_days`, `trial_days`, 
`has_custom_domain`, `has_ssl`, `has_analytics`, `has_custom_colors`, 
`has_gallery`, `has_testimonials`, `has_banners`, `has_blog`, `has_forms`, `has_seo`,
`max_services`, `max_gallery_images`, `max_banners`, `max_pages`, `max_testimonials`,
`storage_limit_mb`, `is_active`, `is_free`, `is_popular`, `sort_order`) 
VALUES

-- الخطة المجانية (تجريبية)
('الخطة المجانية', 'free', 'تجربة مجانية لمدة 7 أيام مع ميزات محدودة', 
0.00, 7, 7, 
0, 0, 0, 1, 
1, 1, 1, 0, 0, 0, 
5, 10, 2, 5, 5, 
50, 1, 1, 0, 1),

-- الخطة الأساسية
('الخطة الأساسية', 'basic', 'مناسبة للمشاريع الصغيرة', 
99.00, 30, 7, 
0, 1, 0, 1, 
1, 1, 1, 0, 0, 1, 
10, 20, 3, 10, 10, 
100, 1, 0, 0, 2),

-- الخطة الاحترافية
('الخطة الاحترافية', 'professional', 'مناسبة للشركات المتوسطة', 
199.00, 30, 7, 
1, 1, 1, 1, 
1, 1, 1, 1, 1, 1, 
25, 50, 5, 25, 25, 
500, 1, 0, 1, 3),

-- الخطة المؤسسية
('الخطة المؤسسية', 'enterprise', 'للشركات الكبيرة مع ميزات متقدمة', 
399.00, 30, 14, 
1, 1, 1, 1, 
1, 1, 1, 1, 1, 1, 
-1, -1, -1, -1, -1, 
2000, 1, 0, 0, 4);

-- 4. تحديث جدول subscriptions للربط بالخطط
ALTER TABLE `subscriptions` 
ADD COLUMN `plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `tenant_id`;

ALTER TABLE `subscriptions`
ADD CONSTRAINT `subscriptions_plan_fk` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE SET NULL;
