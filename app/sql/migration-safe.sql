-- =============================================
-- TakweenWeb — Migration آمن (للقواعد الموجودة مسبقاً)
-- يعمل على قاعدة بيانات تحتوي جداول بالفعل
-- كل شيء يستخدم IF NOT EXISTS / ADD COLUMN IF NOT EXISTS
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- =============================================
-- 1. إنشاء الجداول الناقصة فقط (IF NOT EXISTS)
-- =============================================

CREATE TABLE IF NOT EXISTS `page_views` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `page_slug` VARCHAR(255) NOT NULL,
    `view_date` DATE NOT NULL,
    `views` INT(11) UNSIGNED NOT NULL DEFAULT 1,
    `unique_visitors` INT(11) UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenant_page_date` (`tenant_id`, `page_slug`, `view_date`),
    KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `notifications` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `type` VARCHAR(50) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT DEFAULT NULL,
    `data` TEXT DEFAULT NULL,
    `link` VARCHAR(500) DEFAULT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `is_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `subscription_requests` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) NOT NULL,
    `plan_id` INT(11) NOT NULL,
    `request_type` ENUM('new','upgrade','renew') NOT NULL DEFAULT 'new',
    `status` ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
    `notes` TEXT DEFAULT NULL,
    `admin_notes` TEXT DEFAULT NULL,
    `reviewed_by` INT(11) DEFAULT NULL,
    `reviewed_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_tenant_status` (`tenant_id`, `status`),
    KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog_categories` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sections_config` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `section_key` VARCHAR(50) NOT NULL,
    `section_label_ar` VARCHAR(100) DEFAULT NULL,
    `section_label_en` VARCHAR(100) DEFAULT NULL,
    `is_enabled` TINYINT(1) NOT NULL DEFAULT 1,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `section_icon` VARCHAR(50) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenant_section` (`tenant_id`, `section_key`),
    KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `domain_history` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `domain_type` ENUM('subdomain', 'custom') NOT NULL,
    `old_value` VARCHAR(255) DEFAULT NULL,
    `new_value` VARCHAR(255) NOT NULL,
    `changed_by` INT(11) UNSIGNED DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. إضافة الأعمدة الناقصة (IF NOT EXISTS)
-- =============================================

-- tenants
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `theme_id`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `subscription_plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `plan_id`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `auto_renew` TINYINT(1) NOT NULL DEFAULT 0 AFTER `trial_ends_at`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `last_payment_date` DATETIME DEFAULT NULL AFTER `auto_renew`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `next_payment_date` DATETIME DEFAULT NULL AFTER `last_payment_date`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `default_language` VARCHAR(10) DEFAULT 'ar' AFTER `settings`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `sections_config` TEXT DEFAULT NULL AFTER `default_language`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `plan_features` TEXT DEFAULT NULL AFTER `sections_config`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_status` ENUM('none','pending','active','rejected') DEFAULT 'none' AFTER `custom_domain`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_purchased` TINYINT(1) DEFAULT 0 AFTER `custom_domain_status`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_verified` TINYINT(1) DEFAULT 0 AFTER `custom_domain_purchased`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_verification_token` VARCHAR(64) NULL AFTER `custom_domain_verified`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `domain_status` ENUM('pending','active','failed') DEFAULT 'pending' AFTER `custom_domain_verification_token`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `site_name_en` VARCHAR(255) DEFAULT NULL AFTER `site_name`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `meta_description_en` TEXT DEFAULT NULL AFTER `meta_description`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_title` VARCHAR(255) DEFAULT NULL AFTER `plan_features`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_title_en` VARCHAR(255) DEFAULT NULL AFTER `cta_title`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_text` TEXT DEFAULT NULL AFTER `cta_title_en`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_text_en` TEXT DEFAULT NULL AFTER `cta_text`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_button_text` VARCHAR(255) DEFAULT NULL AFTER `cta_text_en`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_button_text_en` VARCHAR(255) DEFAULT NULL AFTER `cta_button_text`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_button_link` VARCHAR(255) DEFAULT NULL AFTER `cta_button_text_en`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `cta_is_active` TINYINT(1) DEFAULT 0 AFTER `cta_button_link`;

-- subscriptions
ALTER TABLE `subscriptions` ADD COLUMN IF NOT EXISTS `plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `tenant_id`;
ALTER TABLE `subscriptions` ADD COLUMN IF NOT EXISTS `request_id` INT(11) UNSIGNED DEFAULT NULL AFTER `plan_id`;

-- subscription_plans
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `price_monthly` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `price`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `price_yearly` DECIMAL(10,2) DEFAULT NULL AFTER `price_monthly`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `features` TEXT DEFAULT NULL AFTER `price_yearly`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `custom_domain` TINYINT(1) DEFAULT 0 AFTER `is_popular`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `remove_branding` TINYINT(1) DEFAULT 0 AFTER `custom_domain`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `analytics_access` TINYINT(1) DEFAULT 0 AFTER `remove_branding`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `priority_support` TINYINT(1) DEFAULT 0 AFTER `analytics_access`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `display_order` INT(11) NOT NULL DEFAULT 0 AFTER `priority_support`;
ALTER TABLE `subscription_plans` ADD COLUMN IF NOT EXISTS `max_forms` INT(11) NOT NULL DEFAULT 0 AFTER `max_testimonials`;

-- services
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `description_en` TEXT DEFAULT NULL AFTER `description`;

-- pages
ALTER TABLE `pages` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `pages` ADD COLUMN IF NOT EXISTS `content_en` LONGTEXT DEFAULT NULL AFTER `content`;

-- banners
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `subtitle_en` VARCHAR(255) DEFAULT NULL AFTER `subtitle`;

-- site_settings
ALTER TABLE `site_settings` ADD COLUMN IF NOT EXISTS `hero_title_en` VARCHAR(255) DEFAULT NULL AFTER `hero_title`;
ALTER TABLE `site_settings` ADD COLUMN IF NOT EXISTS `hero_subtitle_en` TEXT DEFAULT NULL AFTER `hero_subtitle`;
ALTER TABLE `site_settings` ADD COLUMN IF NOT EXISTS `hero_button_text_en` VARCHAR(255) DEFAULT NULL AFTER `hero_button_text`;

-- theme_settings
ALTER TABLE `theme_settings` ADD COLUMN IF NOT EXISTS `font_size_base` VARCHAR(10) DEFAULT '16px' AFTER `font_secondary`;
ALTER TABLE `theme_settings` ADD COLUMN IF NOT EXISTS `footer_style` ENUM('default','minimal','expanded') DEFAULT 'default' AFTER `header_style`;
ALTER TABLE `theme_settings` ADD COLUMN IF NOT EXISTS `header_logo_height` VARCHAR(10) DEFAULT '50px' AFTER `custom_js`;
ALTER TABLE `theme_settings` ADD COLUMN IF NOT EXISTS `footer_logo_height` VARCHAR(10) DEFAULT '40px' AFTER `header_logo_height`;
ALTER TABLE `theme_settings` ADD COLUMN IF NOT EXISTS `button_style` ENUM('rounded','square','pill') DEFAULT 'rounded' AFTER `footer_logo_height`;
ALTER TABLE `theme_settings` ADD COLUMN IF NOT EXISTS `card_style` ENUM('shadow','border','flat') DEFAULT 'shadow' AFTER `button_style`;
ALTER TABLE `theme_settings` ADD COLUMN IF NOT EXISTS `animation_enabled` TINYINT(1) DEFAULT 1 AFTER `card_style`;

-- seo_settings
ALTER TABLE `seo_settings` ADD COLUMN IF NOT EXISTS `google_tag_manager_id` VARCHAR(50) DEFAULT NULL AFTER `google_analytics_id`;
ALTER TABLE `seo_settings` ADD COLUMN IF NOT EXISTS `facebook_pixel_id` VARCHAR(100) DEFAULT NULL AFTER `google_tag_manager_id`;
ALTER TABLE `seo_settings` ADD COLUMN IF NOT EXISTS `google_site_verification` VARCHAR(255) DEFAULT NULL AFTER `facebook_pixel_id`;
ALTER TABLE `seo_settings` ADD COLUMN IF NOT EXISTS `bing_site_verification` VARCHAR(255) DEFAULT NULL AFTER `google_site_verification`;
ALTER TABLE `seo_settings` ADD COLUMN IF NOT EXISTS `twitter_card_type` ENUM('summary','summary_large_image') DEFAULT 'summary_large_image' AFTER `og_image`;

-- custom_forms
ALTER TABLE `custom_forms` ADD COLUMN IF NOT EXISTS `email_recipients` TEXT DEFAULT NULL AFTER `send_email_notification`;

-- =============================================
-- 3. مزامنة البيانات
-- =============================================

-- مزامنة price_monthly إذا كان 0 والـ price موجود
UPDATE IGNORE `subscription_plans` SET `price_monthly` = `price` WHERE `price_monthly` = 0 AND `price` > 0;

-- مزامنة plan_id مع subscription_plan_id في tenants
UPDATE IGNORE `tenants` SET `subscription_plan_id` = `plan_id` WHERE `subscription_plan_id` IS NULL AND `plan_id` IS NOT NULL;
UPDATE IGNORE `tenants` SET `plan_id` = `subscription_plan_id` WHERE `plan_id` IS NULL AND `subscription_plan_id` IS NOT NULL;

-- =============================================
-- تم بنجاح! لا يوجد أخطاء متوقعة
-- =============================================
