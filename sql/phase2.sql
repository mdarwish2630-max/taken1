-- =============================================
-- CMS Platform - Phase 2 Database Updates
-- الاشتراكات، المدونة، النماذج، الإحصائيات
-- =============================================

-- =============================================
-- 1. SUBSCRIPTION_PLANS TABLE - خطط الاشتراك
-- =============================================
CREATE TABLE IF NOT EXISTS `subscription_plans` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `price_monthly` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `price_yearly` DECIMAL(10,2) DEFAULT NULL,
    `currency` VARCHAR(10) NOT NULL DEFAULT 'SAR',
    `features` TEXT DEFAULT NULL COMMENT 'JSON array of features',
    `max_pages` INT(11) DEFAULT -1 COMMENT '-1 = unlimited',
    `max_services` INT(11) DEFAULT -1,
    `max_gallery` INT(11) DEFAULT -1,
    `max_banners` INT(11) DEFAULT -1,
    `custom_domain` TINYINT(1) DEFAULT 0,
    `remove_branding` TINYINT(1) DEFAULT 0,
    `analytics_access` TINYINT(1) DEFAULT 0,
    `priority_support` TINYINT(1) DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_popular` TINYINT(1) DEFAULT 0,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. BLOG_POSTS TABLE - مقالات المدونة
-- =============================================
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `excerpt` TEXT DEFAULT NULL,
    `content` LONGTEXT DEFAULT NULL,
    `featured_image` VARCHAR(255) DEFAULT NULL,
    `category` VARCHAR(100) DEFAULT NULL,
    `tags` TEXT DEFAULT NULL COMMENT 'JSON array',
    `author_name` VARCHAR(255) DEFAULT NULL,
    `meta_title` VARCHAR(255) DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `status` ENUM('draft', 'published', 'scheduled') NOT NULL DEFAULT 'draft',
    `published_at` DATETIME DEFAULT NULL,
    `views` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `show_on_home` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    KEY `slug` (`slug`),
    KEY `status` (`status`),
    KEY `published_at` (`published_at`),
    CONSTRAINT `blog_posts_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 3. BLOG_CATEGORIES TABLE - تصنيفات المدونة
-- =============================================
CREATE TABLE IF NOT EXISTS `blog_categories` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `blog_categories_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 4. CUSTOM_FORMS TABLE - النماذج المخصصة
-- =============================================
CREATE TABLE IF NOT EXISTS `custom_forms` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `fields` TEXT NOT NULL COMMENT 'JSON array of form fields',
    `submit_button_text` VARCHAR(100) DEFAULT 'إرسال',
    `success_message` VARCHAR(255) DEFAULT 'تم الإرسال بنجاح',
    `redirect_url` VARCHAR(255) DEFAULT NULL,
    `send_email_notification` TINYINT(1) DEFAULT 1,
    `email_recipients` TEXT DEFAULT NULL COMMENT 'JSON array of emails',
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    UNIQUE KEY `tenant_slug` (`tenant_id`, `slug`),
    CONSTRAINT `custom_forms_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 5. FORM_SUBMISSIONS TABLE - استجابات النماذج
-- =============================================
CREATE TABLE IF NOT EXISTS `form_submissions` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `form_id` INT(11) UNSIGNED NOT NULL,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `data` TEXT NOT NULL COMMENT 'JSON object of submitted data',
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` VARCHAR(500) DEFAULT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `form_id` (`form_id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `form_submissions_form_fk` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`) ON DELETE CASCADE,
    CONSTRAINT `form_submissions_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 6. ANALYTICS TABLE - الإحصائيات
-- =============================================
CREATE TABLE IF NOT EXISTS `analytics` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `visitor_id` VARCHAR(64) DEFAULT NULL COMMENT 'Anonymous visitor identifier',
    `session_id` VARCHAR(64) DEFAULT NULL,
    `page_url` VARCHAR(500) NOT NULL,
    `page_title` VARCHAR(255) DEFAULT NULL,
    `referrer` VARCHAR(500) DEFAULT NULL,
    `user_agent` VARCHAR(500) DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `country` VARCHAR(100) DEFAULT NULL,
    `city` VARCHAR(100) DEFAULT NULL,
    `device_type` ENUM('desktop', 'tablet', 'mobile') DEFAULT 'desktop',
    `browser` VARCHAR(100) DEFAULT NULL,
    `os` VARCHAR(100) DEFAULT NULL,
    `time_spent` INT(11) DEFAULT 0 COMMENT 'Seconds spent on page',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    KEY `visitor_id` (`visitor_id`),
    KEY `session_id` (`session_id`),
    KEY `created_at` (`created_at`),
    CONSTRAINT `analytics_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 7. PAGE_VIEWS TABLE - مشاهدات الصفحات (ملخص يومي)
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
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `page_views_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 8. SEO_SETTINGS TABLE - إعدادات SEO
-- =============================================
CREATE TABLE IF NOT EXISTS `seo_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `google_analytics_id` VARCHAR(50) DEFAULT NULL,
    `google_tag_manager_id` VARCHAR(50) DEFAULT NULL,
    `facebook_pixel_id` VARCHAR(100) DEFAULT NULL,
    `google_site_verification` VARCHAR(255) DEFAULT NULL,
    `bing_site_verification` VARCHAR(255) DEFAULT NULL,
    `robots_txt` TEXT DEFAULT NULL,
    `schema_org` TEXT DEFAULT NULL COMMENT 'JSON-LD schema',
    `canonical_url` VARCHAR(255) DEFAULT NULL,
    `og_image` VARCHAR(255) DEFAULT NULL,
    `twitter_card_type` ENUM('summary', 'summary_large_image') DEFAULT 'summary_large_image',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `seo_settings_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 9. THEME_SETTINGS TABLE - إعدادات الثيم
-- =============================================
CREATE TABLE IF NOT EXISTS `theme_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `font_primary` VARCHAR(100) DEFAULT 'Tajawal',
    `font_secondary` VARCHAR(100) DEFAULT 'Tajawal',
    `font_size_base` VARCHAR(10) DEFAULT '16px',
    `border_radius` VARCHAR(10) DEFAULT '8px',
    `header_style` ENUM('default', 'centered', 'transparent') DEFAULT 'default',
    `footer_style` ENUM('default', 'minimal', 'expanded') DEFAULT 'default',
    `hero_style` ENUM('default', 'fullwidth', 'split', 'video') DEFAULT 'default',
    `custom_css` TEXT DEFAULT NULL,
    `custom_js` TEXT DEFAULT NULL,
    `header_logo_height` VARCHAR(10) DEFAULT '50px',
    `footer_logo_height` VARCHAR(10) DEFAULT '40px',
    `button_style` ENUM('rounded', 'square', 'pill') DEFAULT 'rounded',
    `card_style` ENUM('shadow', 'border', 'flat') DEFAULT 'shadow',
    `animation_enabled` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `theme_settings_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 10. NOTIFICATIONS TABLE - الإشعارات
-- =============================================
CREATE TABLE IF NOT EXISTS `notifications` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `type` VARCHAR(50) NOT NULL COMMENT 'subscription, payment, system, etc.',
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT DEFAULT NULL,
    `data` TEXT DEFAULT NULL COMMENT 'JSON additional data',
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `notifications_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- UPDATE TENANTS TABLE
-- =============================================
ALTER TABLE `tenants` 
ADD COLUMN `subscription_plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `theme_id`,
ADD COLUMN `auto_renew` TINYINT(1) NOT NULL DEFAULT 0 AFTER `trial_ends_at`,
ADD COLUMN `last_payment_date` DATETIME DEFAULT NULL AFTER `auto_renew`,
ADD COLUMN `next_payment_date` DATETIME DEFAULT NULL AFTER `last_payment_date`;

-- =============================================
-- SEED DATA - البيانات الأولية للمرحلة 2
-- =============================================

-- خطط الاشتراك
INSERT INTO `subscription_plans` (`name`, `slug`, `description`, `price_monthly`, `price_yearly`, `features`, `max_pages`, `max_services`, `max_gallery`, `max_banners`, `custom_domain`, `remove_branding`, `analytics_access`, `priority_support`, `is_active`, `is_popular`, `display_order`) VALUES
('مجاني', 'free', 'للتجربة والاستكشاف', 0, 0, '["5 صفحات", "3 خدمات", "10 صور", "دعم فني أساسي"]', 5, 3, 10, 2, 0, 0, 0, 0, 1, 0, 1),
('أساسي', 'basic', 'للمشاريع الصغيرة', 49, 470, '["15 صفحة", "10 خدمات", "50 صورة", "دعم فني", "إحصائيات أساسية"]', 15, 10, 50, 5, 0, 0, 1, 0, 1, 0, 2),
('احترافي', 'professional', 'للمشاريع المتوسطة - الأكثر طلباً', 99, 950, '["صفحات غير محدودة", "خدمات غير محدودة", "صور غير محدودة", "دومين مخصص", "بدون إعلانات", "إحصائيات متقدمة"]', -1, -1, -1, -1, 1, 1, 1, 0, 1, 1, 3),
('المؤسسات', 'enterprise', 'للمؤسسات الكبيرة', 199, 1900, '["كل مميزات الاحترافي", "دعم أولوية 24/7", "مدير حساب مخصص", "تخصيص متقدم"]', -1, -1, -1, -1, 1, 1, 1, 1, 1, 0, 4);
