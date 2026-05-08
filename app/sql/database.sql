-- =============================================
-- CMS Platform Database Schema
-- Multi-tenant Website Builder
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- =============================================
-- 1. USERS TABLE - المستخدمين (Admin & Customers)
-- =============================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50) DEFAULT NULL,
    `role` ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
    `email_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `verification_token` VARCHAR(255) DEFAULT NULL,
    `reset_token` VARCHAR(255) DEFAULT NULL,
    `reset_token_expires` DATETIME DEFAULT NULL,
    `last_login` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. TENANTS TABLE - المواقع (العملاء)
-- =============================================
CREATE TABLE IF NOT EXISTS `tenants` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `site_name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `subdomain` VARCHAR(100) DEFAULT NULL,
    `custom_domain` VARCHAR(255) DEFAULT NULL,
    `theme_id` INT(11) UNSIGNED NOT NULL DEFAULT 1,
    
    -- حالة الاشتراك
    `subscription_status` ENUM('trial', 'active', 'expired', 'suspended') NOT NULL DEFAULT 'trial',
    `subscription_start` DATE DEFAULT NULL,
    `subscription_end` DATE DEFAULT NULL,
    `trial_ends_at` DATETIME DEFAULT NULL,
    
    -- إعدادات الموقع
    `site_status` ENUM('draft', 'published', 'maintenance') NOT NULL DEFAULT 'draft',
    `logo` VARCHAR(255) DEFAULT NULL,
    `favicon` VARCHAR(255) DEFAULT NULL,
    
    -- معلومات التواصل
    `contact_email` VARCHAR(255) DEFAULT NULL,
    `contact_phone` VARCHAR(50) DEFAULT NULL,
    `contact_phone2` VARCHAR(50) DEFAULT NULL,
    `contact_whatsapp` VARCHAR(50) DEFAULT NULL,
    `address` TEXT DEFAULT NULL,
    `working_hours` VARCHAR(255) DEFAULT NULL,
    
    -- السوشال ميديا
    `facebook` VARCHAR(255) DEFAULT NULL,
    `twitter` VARCHAR(255) DEFAULT NULL,
    `instagram` VARCHAR(255) DEFAULT NULL,
    `linkedin` VARCHAR(255) DEFAULT NULL,
    `youtube` VARCHAR(255) DEFAULT NULL,
    `tiktok` VARCHAR(255) DEFAULT NULL,
    
    -- إعدادات SEO
    `meta_title` VARCHAR(255) DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `meta_keywords` TEXT DEFAULT NULL,
    
    -- إعدادات الألوان
    `primary_color` VARCHAR(7) DEFAULT '#2563eb',
    `secondary_color` VARCHAR(7) DEFAULT '#1e40af',
    `accent_color` VARCHAR(7) DEFAULT '#f59e0b',
    `text_color` VARCHAR(7) DEFAULT '#1f2937',
    `background_color` VARCHAR(7) DEFAULT '#ffffff',
    
    -- إعدادات إضافية (JSON)
    `settings` TEXT DEFAULT NULL,
    
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    UNIQUE KEY `subdomain` (`subdomain`),
    KEY `user_id` (`user_id`),
    KEY `theme_id` (`theme_id`),
    KEY `subscription_status` (`subscription_status`),
    
    CONSTRAINT `tenants_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 3. THEMES TABLE - القوالب
-- =============================================
CREATE TABLE IF NOT EXISTS `themes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `name_en` VARCHAR(100) DEFAULT NULL COMMENT 'اسم القالب بالإنجليزية',
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `description_en` TEXT DEFAULT NULL COMMENT 'وصف القالب بالإنجليزية',
    `category` ENUM('maintenance', 'decor', 'electric', 'plumbing', 'cleaning', 'general', 'other') NOT NULL DEFAULT 'general',
    `preview_image` VARCHAR(255) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_premium` TINYINT(1) NOT NULL DEFAULT 0,
    `is_paid` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'هل القالب مدفوع 0=مجاني 1=مدفوع',
    `price` DECIMAL(10,2) DEFAULT 0.00 COMMENT 'سعر القالب المدفوع',
    `currency` VARCHAR(10) DEFAULT 'SAR' COMMENT 'عملة السعر',
    `payment_link` VARCHAR(500) DEFAULT NULL COMMENT 'رابط الدفع للقالب المدفوع',
    `sort_order` INT(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب العرض',
    `version` VARCHAR(20) DEFAULT '1.0.0',
    `settings_schema` TEXT DEFAULT NULL, -- JSON schema for theme settings
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 3B. THEME REQUESTS TABLE - طلبات تفعيل الثيمات المدفوعة
-- =============================================
CREATE TABLE IF NOT EXISTS `theme_requests` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `theme_id` INT(11) UNSIGNED NOT NULL,
    `status` ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
    `amount` DECIMAL(10,2) DEFAULT 0.00,
    `currency` VARCHAR(10) DEFAULT 'SAR',
    `payment_method` VARCHAR(100) DEFAULT NULL,
    `payment_ref` VARCHAR(255) DEFAULT NULL,
    `admin_notes` TEXT DEFAULT NULL COMMENT 'ملاحظات الأدمن عند القبول/الرفض',
    `tenant_notes` TEXT DEFAULT NULL COMMENT 'ملاحظات المشترك',
    `approved_at` DATETIME DEFAULT NULL,
    `rejected_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    KEY `theme_id` (`theme_id`),
    KEY `status` (`status`),
    CONSTRAINT `theme_requests_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `theme_requests_theme_fk` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 4. PAGES TABLE - الصفحات
-- =============================================
CREATE TABLE IF NOT EXISTS `pages` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `content` LONGTEXT DEFAULT NULL,
    `meta_title` VARCHAR(255) DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `template` VARCHAR(100) DEFAULT 'default',
    `is_home` TINYINT(1) NOT NULL DEFAULT 0,
    `show_in_menu` TINYINT(1) NOT NULL DEFAULT 1,
    `menu_order` INT(11) NOT NULL DEFAULT 0,
    `status` ENUM('draft', 'published') NOT NULL DEFAULT 'published',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    KEY `slug` (`slug`),
    CONSTRAINT `pages_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 5. SERVICES TABLE - الخدمات
-- =============================================
CREATE TABLE IF NOT EXISTS `services` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `content` LONGTEXT DEFAULT NULL,
    `image` VARCHAR(255) DEFAULT NULL,
    `icon` VARCHAR(100) DEFAULT NULL,
    `price` DECIMAL(10,2) DEFAULT NULL,
    `price_text` VARCHAR(100) DEFAULT NULL,
    `show_on_home` TINYINT(1) NOT NULL DEFAULT 1,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `services_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 6. BANNERS TABLE - البانرات
-- =============================================
CREATE TABLE IF NOT EXISTS `banners` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `title` VARCHAR(255) DEFAULT NULL,
    `subtitle` VARCHAR(255) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `image` VARCHAR(255) NOT NULL,
    `link` VARCHAR(255) DEFAULT NULL,
    `button_text` VARCHAR(100) DEFAULT NULL,
    `position` VARCHAR(50) DEFAULT 'hero',
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `banners_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 7. GALLERY TABLE - معرض الصور
-- =============================================
CREATE TABLE IF NOT EXISTS `gallery` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `title` VARCHAR(255) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `image` VARCHAR(255) NOT NULL,
    `category` VARCHAR(100) DEFAULT NULL,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `gallery_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 8. TESTIMONIALS TABLE - آراء العملاء
-- =============================================
CREATE TABLE IF NOT EXISTS `testimonials` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `client_name` VARCHAR(255) NOT NULL,
    `client_title` VARCHAR(255) DEFAULT NULL,
    `client_image` VARCHAR(255) DEFAULT NULL,
    `content` TEXT NOT NULL,
    `rating` TINYINT(1) DEFAULT 5,
    `show_on_home` TINYINT(1) NOT NULL DEFAULT 1,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `testimonials_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 9. CONTACT_MESSAGES TABLE - رسائل التواصل
-- =============================================
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50) DEFAULT NULL,
    `subject` VARCHAR(255) DEFAULT NULL,
    `message` TEXT NOT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `contact_messages_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 10. MEDIA TABLE - الوسائط
-- =============================================
CREATE TABLE IF NOT EXISTS `media` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `filename` VARCHAR(255) NOT NULL,
    `original_name` VARCHAR(255) NOT NULL,
    `filepath` VARCHAR(500) NOT NULL,
    `filesize` INT(11) NOT NULL,
    `filetype` VARCHAR(100) NOT NULL,
    `alt_text` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `media_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 11. SUBSCRIPTIONS TABLE - الاشتراكات
-- =============================================
CREATE TABLE IF NOT EXISTS `subscriptions` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `plan_name` VARCHAR(100) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `currency` VARCHAR(10) NOT NULL DEFAULT 'SAR',
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `status` ENUM('active', 'expired', 'cancelled', 'pending') NOT NULL DEFAULT 'pending',
    `payment_method` VARCHAR(50) DEFAULT NULL,
    `payment_reference` VARCHAR(255) DEFAULT NULL,
    `auto_renew` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `subscriptions_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 12. SETTINGS TABLE - إعدادات النظام
-- =============================================
CREATE TABLE IF NOT EXISTS `settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `setting_key` VARCHAR(100) NOT NULL,
    `setting_value` TEXT DEFAULT NULL,
    `setting_type` VARCHAR(50) DEFAULT 'string',
    `description` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 13. DEMO_IMPORTS TABLE - سجلات استيراد البيانات التجريبية
-- =============================================
CREATE TABLE IF NOT EXISTS `demo_imports` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `imported_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_tenant` (`tenant_id`),
    CONSTRAINT `demo_imports_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- SEED DATA - البيانات الأولية
-- =============================================

-- إضافة القالب الوحيد (نوفا)
INSERT INTO `themes` (`name`, `name_en`, `slug`, `description`, `description_en`, `category`, `preview_image`, `is_active`, `is_premium`, `is_paid`, `price`, `sort_order`, `version`) VALUES
('نوفا - احترافي', 'Nova - Professional', 'nova', 'قالب عصري واحترافي متوافق مع جميع الأجهزة', 'Modern and professional template, fully responsive', 'general', 'themes/previews/nova-preview.png', 1, 0, 0, 0.00, 1, '2.0');

-- إضافة إعدادات النظام
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('site_name', 'منصة المواقع', 'string', 'اسم المنصة'),
('site_email', 'info@cms-platform.com', 'string', 'بريد المنصة'),
('trial_days', '14', 'integer', 'عدد أيام التجربة المجانية'),
('monthly_price', '99', 'decimal', 'سعر الاشتراك الشهري'),
('currency', 'SAR', 'string', 'العملة'),
('max_upload_size', '5242880', 'integer', 'أقصى حجم للرفع بالبايت (5MB)'),
('allowed_file_types', 'jpg,jpeg,png,gif,webp,pdf,doc,docx', 'string', 'أنواع الملفات المسموحة'),
('default_language', 'ar', 'string', 'اللغة الافتراضية');

-- إضافة مدير النظام الافتراضي
-- كلمة المرور: admin123 (مشفرة بـ password_hash)
INSERT INTO `users` (`email`, `password`, `full_name`, `role`, `status`, `email_verified`) VALUES
('admin@cms-platform.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدير النظام', 'admin', 'active', 1);

-- =============================================
-- 14. SUBSCRIPTION_PLANS TABLE - خطط الاشتراك
-- =============================================
CREATE TABLE IF NOT EXISTS `subscription_plans` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `currency` VARCHAR(10) NOT NULL DEFAULT 'SAR',
    `duration_days` INT(11) NOT NULL DEFAULT 30,
    `trial_days` INT(11) NOT NULL DEFAULT 0,
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
    `max_services` INT(11) NOT NULL DEFAULT -1,
    `max_gallery` INT(11) NOT NULL DEFAULT -1,
    `max_banners` INT(11) NOT NULL DEFAULT -1,
    `max_pages` INT(11) NOT NULL DEFAULT -1,
    `max_testimonials` INT(11) NOT NULL DEFAULT -1,
    `max_forms` INT(11) NOT NULL DEFAULT 0,
    `storage_limit_mb` INT(11) NOT NULL DEFAULT 100,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_free` TINYINT(1) NOT NULL DEFAULT 0,
    `is_popular` TINYINT(1) NOT NULL DEFAULT 0,
    `sort_order` INT(11) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 15. PAID_SERVICES TABLE - الخدمات المدفوعة
-- =============================================
CREATE TABLE IF NOT EXISTS `paid_services` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) NOT NULL DEFAULT 'SAR',
  `icon` varchar(100) DEFAULT 'fa-cube',
  `category` varchar(100) NOT NULL DEFAULT 'general',
  `payment_link` varchar(500) DEFAULT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `recurring_period` varchar(50) DEFAULT NULL COMMENT 'monthly, yearly, onetime',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `max_quantity` int(11) NOT NULL DEFAULT 1 COMMENT 'أقصى عدد يمكن شراؤه لكل مستأجر',
  `requires_approval` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'هل يحتاج موافقة الأدمن',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category` (`category`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 16. TENANT_PURCHASES TABLE - مشتريات المستأجرين
-- =============================================
CREATE TABLE IF NOT EXISTS `tenant_purchases` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `service_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) NOT NULL DEFAULT 'SAR',
  `status` enum('pending','paid','approved','cancelled','refunded','expired') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_ref` varchar(255) DEFAULT NULL,
  `admin_notes` text,
  `tenant_notes` text,
  `purchased_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `service_id` (`service_id`),
  KEY `status` (`status`),
  CONSTRAINT `tenant_purchases_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tenant_purchases_service_fk` FOREIGN KEY (`service_id`) REFERENCES `paid_services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 17. BLOG_POSTS TABLE - مقالات المدونة
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
    `tags` TEXT DEFAULT NULL,
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
    CONSTRAINT `blog_posts_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 18. CUSTOM_FORMS TABLE - النماذج المخصصة
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
    `email_recipients` TEXT DEFAULT NULL,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    UNIQUE KEY `tenant_slug` (`tenant_id`, `slug`),
    CONSTRAINT `custom_forms_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 19. FORM_SUBMISSIONS TABLE - استجابات النماذج
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
-- 20. SEO_SETTINGS TABLE - إعدادات SEO
-- =============================================
CREATE TABLE IF NOT EXISTS `seo_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `google_analytics_id` VARCHAR(50) DEFAULT NULL,
    `robots_txt` TEXT DEFAULT NULL,
    `schema_org` TEXT DEFAULT NULL,
    `canonical_url` VARCHAR(255) DEFAULT NULL,
    `og_image` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `seo_settings_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 21. THEME_SETTINGS TABLE - إعدادات الثيم
-- =============================================
CREATE TABLE IF NOT EXISTS `theme_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `font_primary` VARCHAR(100) DEFAULT 'Tajawal',
    `font_secondary` VARCHAR(100) DEFAULT 'Tajawal',
    `border_radius` VARCHAR(10) DEFAULT '8px',
    `header_style` ENUM('default', 'centered', 'transparent') DEFAULT 'default',
    `hero_style` ENUM('default', 'fullwidth', 'split') DEFAULT 'default',
    `custom_css` TEXT DEFAULT NULL,
    `custom_js` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `tenant_id` (`tenant_id`),
    CONSTRAINT `theme_settings_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 22. SITE_SETTINGS TABLE - إعدادات الموقع الرئيسي
-- =============================================
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `logo` VARCHAR(255) DEFAULT NULL,
    `favicon` VARCHAR(255) DEFAULT NULL,
    `hero_title` VARCHAR(255) DEFAULT NULL,
    `hero_subtitle` TEXT DEFAULT NULL,
    `hero_image` VARCHAR(255) DEFAULT NULL,
    `hero_button_text` VARCHAR(100) DEFAULT NULL,
    `hero_button_link` VARCHAR(255) DEFAULT NULL,
    `features_title` VARCHAR(255) DEFAULT NULL,
    `features_subtitle` TEXT DEFAULT NULL,
    `show_features` TINYINT(1) NOT NULL DEFAULT 1,
    `show_themes_section` TINYINT(1) NOT NULL DEFAULT 1,
    `show_pricing_section` TINYINT(1) NOT NULL DEFAULT 1,
    `show_testimonials` TINYINT(1) NOT NULL DEFAULT 1,
    `show_contact_form` TINYINT(1) NOT NULL DEFAULT 1,
    `contact_email` VARCHAR(255) DEFAULT NULL,
    `contact_phone` VARCHAR(50) DEFAULT NULL,
    `contact_whatsapp` VARCHAR(50) DEFAULT NULL,
    `contact_address` TEXT DEFAULT NULL,
    `facebook` VARCHAR(255) DEFAULT NULL,
    `twitter` VARCHAR(255) DEFAULT NULL,
    `instagram` VARCHAR(255) DEFAULT NULL,
    `linkedin` VARCHAR(255) DEFAULT NULL,
    `youtube` VARCHAR(255) DEFAULT NULL,
    `meta_title` VARCHAR(255) DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `footer_text` TEXT DEFAULT NULL,
    `copyright_text` VARCHAR(255) DEFAULT NULL,
    `head_scripts` TEXT DEFAULT NULL,
    `body_scripts` TEXT DEFAULT NULL,
    `maintenance_mode` TINYINT(1) NOT NULL DEFAULT 0,
    `maintenance_message` TEXT DEFAULT NULL,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 23. SITE_TESTIMONIALS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS `site_testimonials` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `client_name` VARCHAR(255) NOT NULL,
    `client_title` VARCHAR(255) DEFAULT NULL,
    `client_company` VARCHAR(255) DEFAULT NULL,
    `client_image` VARCHAR(255) DEFAULT NULL,
    `content` TEXT NOT NULL,
    `rating` TINYINT(1) DEFAULT 5,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 24. SITE_FEATURES TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS `site_features` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `icon` VARCHAR(100) DEFAULT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- إضافة أعمدة إضافية لجدول tenants
-- =============================================
-- هذه الأعمدة قد تكون موجودة بالفعل، لذلك نستخدم IF NOT EXISTS عبر إدراج تجاهل الأخطاء
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `theme_id`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `subscription_plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `theme_id`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `auto_renew` TINYINT(1) NOT NULL DEFAULT 0 AFTER `trial_ends_at`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `last_payment_date` DATETIME DEFAULT NULL AFTER `auto_renew`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `next_payment_date` DATETIME DEFAULT NULL AFTER `last_payment_date`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `default_language` VARCHAR(10) DEFAULT 'ar' AFTER `settings`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `sections_config` TEXT DEFAULT NULL AFTER `default_language`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `plan_features` TEXT DEFAULT NULL AFTER `sections_config`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_status` enum('none','pending','active','rejected') DEFAULT 'none' AFTER `custom_domain`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_purchased` tinyint(1) DEFAULT 0 AFTER `custom_domain_status`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_verified` TINYINT(1) DEFAULT 0 AFTER `custom_domain_purchased`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_verification_token` VARCHAR(64) NULL AFTER `custom_domain_verified`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `domain_status` ENUM('pending', 'active', 'failed') DEFAULT 'pending' AFTER `custom_domain_verification_token`;

-- =============================================
-- إضافة أعمدة إضافية لجدول subscriptions
-- =============================================
ALTER TABLE `subscriptions` ADD COLUMN IF NOT EXISTS `plan_id` INT(11) UNSIGNED DEFAULT NULL AFTER `tenant_id`;

-- =============================================
-- بيانات تجريبية - خطط الاشتراك
-- =============================================
INSERT IGNORE INTO `subscription_plans` 
(`name`, `slug`, `description`, `price`, `duration_days`, `trial_days`, 
`has_custom_domain`, `has_ssl`, `has_analytics`, `has_custom_colors`, 
`has_gallery`, `has_testimonials`, `has_banners`, `has_blog`, `has_forms`, `has_seo`,
`max_services`, `max_gallery`, `max_banners`, `max_pages`, `max_testimonials`,
`storage_limit_mb`, `is_active`, `is_free`, `is_popular`, `sort_order`) 
VALUES
('الخطة المجانية', 'free', 'تجربة مجانية لمدة 7 أيام مع ميزات محدودة', 
0.00, 7, 7, 
0, 0, 0, 1, 
1, 1, 1, 0, 0, 0, 
5, 10, 2, 5, 5, 
50, 1, 1, 0, 1),
('الخطة الأساسية', 'basic', 'مناسبة للمشاريع الصغيرة', 
99.00, 30, 7, 
0, 1, 0, 1, 
1, 1, 1, 0, 0, 1, 
10, 20, 3, 10, 10, 
100, 1, 0, 0, 2),
('الخطة الاحترافية', 'professional', 'مناسبة للشركات المتوسطة', 
199.00, 30, 7, 
1, 1, 1, 1, 
1, 1, 1, 1, 1, 1, 
25, 50, 5, 25, 25, 
500, 1, 0, 1, 3),
('الخطة المؤسسية', 'enterprise', 'للشركات الكبيرة مع ميزات متقدمة', 
399.00, 30, 14, 
1, 1, 1, 1, 
1, 1, 1, 1, 1, 1, 
-1, -1, -1, -1, -1, 
2000, 1, 0, 0, 4);

-- =============================================
-- بيانات تجريبية - خدمات مدفوعة
-- =============================================
INSERT IGNORE INTO `paid_services` (`id`, `title`, `slug`, `description`, `price`, `icon`, `category`, `payment_link`, `is_recurring`, `recurring_period`, `is_active`, `sort_order`, `max_quantity`, `requires_approval`) VALUES
(1, 'نطاق مخصص (دومين)', 'custom-domain', 'احصل على دومين مخصص لموقعك بدلاً من النطاق الفرعي المجاني. يشمل إعداد DNS وربط الموقع.', 50.00, 'fa-globe', 'domains', NULL, 1, 'yearly', 1, 1, 1, 1),
(2, 'شهادة SSL', 'ssl-certificate', 'تشفير موقعك بشهادة SSL لتحسين الأمان والحصول على HTTPS.', 30.00, 'fa-shield-alt', 'domains', NULL, 1, 'yearly', 1, 2, 1, 0),
(3, 'إضافة لغة ثانية', 'extra-language', 'إضافة لغة ثانية لموقعك (عربي/إنجليزي) مع زر تبديل اللغات في الموقع.', 100.00, 'fa-language', 'features', NULL, 0, 'onetime', 1, 3, 1, 1),
(4, 'حملة تسويقية', 'marketing-campaign', 'إدارة حملة تسويقية شاملة لموقعك تشمل إعداد الإعلانات وتحسين الظهور في محركات البحث.', 200.00, 'fa-bullhorn', 'marketing', NULL, 0, 'onetime', 1, 4, 3, 1),
(5, 'كتابة محتوى احترافي', 'content-writing', 'كتابة محتوى احترافي لجميع صفحات موقعك بما يتوافق مع معايير SEO.', 150.00, 'fa-pen-fancy', 'content', NULL, 0, 'onetime', 1, 5, 5, 1),
(6, 'تحسين SEO المتقدم', 'advanced-seo', 'تحسين متقدم لمحركات البحث يشمل تحليل الكلمات المفتاحية وتهيئة الصفحات.', 80.00, 'fa-search', 'marketing', NULL, 0, 'onetime', 1, 6, 2, 0),
(7, 'تصميم شعار احترافي', 'logo-design', 'تصميم شعار احترافي فريد لموقعك بأعلى جودة.', 120.00, 'fa-paint-brush', 'design', NULL, 0, 'onetime', 1, 7, 1, 1),
(8, 'كشف إحصائيات متقدم', 'advanced-analytics', 'لوحة إحصائيات متقدمة تعرض تفاصيل الزوار والصفحات ومصادر الزيارات.', 60.00, 'fa-chart-line', 'features', NULL, 1, 'monthly', 1, 8, 1, 0),
(9, 'إزالة علامة التجارة', 'remove-branding', 'إزالة شعار المنصة و"مدعوم بواسطة" من موقعك.', 40.00, 'fa-eye-slash', 'features', NULL, 1, 'monthly', 1, 9, 1, 0),
(10, 'نسخة احتياطية يومية', 'daily-backup', 'نسخ احتياطية يومية لموقعك مع إمكانية الاستعادة في أي وقت.', 20.00, 'fa-database', 'features', NULL, 1, 'monthly', 1, 10, 1, 0),
(11, 'دعم فني أولوية 24/7', 'priority-support', 'دعم فني على مدار الساعة مع استجابة سريعة وأولوية في معالجة المشاكل.', 100.00, 'fa-headset', 'support', NULL, 1, 'monthly', 1, 11, 1, 0),
(12, 'زيادة مساحة التخزين', 'extra-storage', 'زيادة مساحة تخزين الملفات والصور على موقعك.', 30.00, 'fa-hdd', 'features', NULL, 1, 'monthly', 1, 12, 10, 0);

-- =============================================
-- بيانات تجريبية - مميزات الموقع الرئيسي
-- =============================================
INSERT IGNORE INTO `site_features` (`icon`, `title`, `description`, `display_order`) VALUES
('fas fa-palette', 'قوالب احترافية', 'اختر من بين مجموعة متنوعة من القوالب الجاهزة والمصممة باحترافية', 1),
('fas fa-magic', 'تخصيص سهل', 'عدّل الألوان والخطوط والمحتوى بسهولة بدون حاجة لخبرة تقنية', 2),
('fas fa-mobile-alt', 'متجاوب مع جميع الأجهزة', 'مواقعك تعمل بشكل مثالي على الجوال والتابلت والكمبيوتر', 3),
('fas fa-bolt', 'سرعة فائقة', 'مواقع سريعة التحميل ومحسنة لمحركات البحث', 4),
('fas fa-headset', 'دعم فني متواصل', 'فريق دعم متخصص جاهز لمساعدتك في أي وقت', 5),
('fas fa-shield-alt', 'آمن ومحمي', 'حماية متقدمة وشهادات SSL مجانية لجميع المواقع', 6);

-- =============================================
-- بيانات تجريبية - إعدادات الموقع الرئيسي
-- =============================================
INSERT IGNORE INTO `site_settings` 
(`hero_title`, `hero_subtitle`, `hero_button_text`, `hero_button_link`,
 `features_title`, `features_subtitle`,
 `copyright_text`) 
VALUES
('أنشئ موقعك الإلكتروني الاحترافي', 
 'منصة سهلة ومرنة لإنشاء مواقع احترافية بدون حاجة لخبرة تقنية. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.',
 'ابدأ الآن مجاناً', '/register',
'لماذا تختارنا؟', 'نوفر لك كل ما تحتاجه لبناء حضور رقمي مميز',
 '© 2024 منصة المواقع. جميع الحقوق محفوظة.');
