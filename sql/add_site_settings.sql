-- =============================================
-- Site Settings for Main Platform
-- إعدادات الموقع الرئيسي
-- =============================================

-- 1. إنشاء جدول إعدادات الموقع الرئيسي
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    
    -- الشعار والأيقونة
    `logo` VARCHAR(255) DEFAULT NULL,
    `logo_white` VARCHAR(255) DEFAULT NULL COMMENT 'شعار أبيض للخلفيات الداكنة',
    `favicon` VARCHAR(255) DEFAULT NULL,
    
    -- البانر الرئيسي
    `hero_title` VARCHAR(255) DEFAULT NULL,
    `hero_subtitle` TEXT DEFAULT NULL,
    `hero_image` VARCHAR(255) DEFAULT NULL,
    `hero_button_text` VARCHAR(100) DEFAULT NULL,
    `hero_button_link` VARCHAR(255) DEFAULT NULL,
    
    -- قسم المميزات
    `features_title` VARCHAR(255) DEFAULT NULL,
    `features_subtitle` TEXT DEFAULT NULL,
    `show_features` TINYINT(1) NOT NULL DEFAULT 1,
    
    -- قسم الثيمات
    `show_themes_section` TINYINT(1) NOT NULL DEFAULT 1,
    
    -- قسم خطط الأسعار
    `show_pricing_section` TINYINT(1) NOT NULL DEFAULT 1,
    `pricing_title` VARCHAR(255) DEFAULT NULL,
    `pricing_subtitle` TEXT DEFAULT NULL,
    
    -- قسم العملاء/الشهادات
    `testimonials_title` VARCHAR(255) DEFAULT NULL,
    `show_testimonials` TINYINT(1) NOT NULL DEFAULT 1,
    
    -- قسم التواصل
    `contact_title` VARCHAR(255) DEFAULT NULL,
    `contact_subtitle` TEXT DEFAULT NULL,
    `show_contact_form` TINYINT(1) NOT NULL DEFAULT 1,
    
    -- معلومات التواصل
    `contact_email` VARCHAR(255) DEFAULT NULL,
    `contact_phone` VARCHAR(50) DEFAULT NULL,
    `contact_whatsapp` VARCHAR(50) DEFAULT NULL,
    `contact_address` TEXT DEFAULT NULL,
    
    -- السوشال ميديا
    `facebook` VARCHAR(255) DEFAULT NULL,
    `twitter` VARCHAR(255) DEFAULT NULL,
    `instagram` VARCHAR(255) DEFAULT NULL,
    `linkedin` VARCHAR(255) DEFAULT NULL,
    `youtube` VARCHAR(255) DEFAULT NULL,
    
    -- SEO
    `meta_title` VARCHAR(255) DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `meta_keywords` TEXT DEFAULT NULL,
    
    -- الفوتر
    `footer_text` TEXT DEFAULT NULL,
    `copyright_text` VARCHAR(255) DEFAULT NULL,
    
    -- سكريبتات
    `head_scripts` TEXT DEFAULT NULL COMMENT 'أكواد في head',
    `body_scripts` TEXT DEFAULT NULL COMMENT 'أكواد قبل إغلاق body',
    
    -- حالة الصيانة
    `maintenance_mode` TINYINT(1) NOT NULL DEFAULT 0,
    `maintenance_message` TEXT DEFAULT NULL,
    
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. إدراج الإعدادات الافتراضية
INSERT INTO `site_settings` 
(`hero_title`, `hero_subtitle`, `hero_button_text`, `hero_button_link`,
 `features_title`, `features_subtitle`,
 `pricing_title`, `pricing_subtitle`,
 `testimonials_title`, `contact_title`,
 `contact_email`, `contact_phone`,
 `meta_title`, `meta_description`,
 `footer_text`, `copyright_text`) 
VALUES
('أنشئ موقعك الإلكتروني الاحترافي', 
 'منصة سهلة ومرنة لإنشاء مواقع احترافية بدون حاجة لخبرة تقنية. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.',
 'ابدأ الآن مجاناً', '/register',
'لماذا تختارنا؟', 'نوفر لك كل ما تحتاجه لبناء حضور رقمي مميز',
'خطط الأسعار', 'اختر الخطة المناسبة لاحتياجاتك',
'ماذا يقول عملاؤنا', 'تواصل معنا',
'info@cms-platform.com', '+966 50 000 0000',
'منصة المواقع - أنشئ موقعك بسهولة', 
 'منصة متكاملة لإنشاء المواقع الإلكترونية بسهولة وبدون حاجة لخبرة تقنية.',
 'منصة المواقع - نساعدك في بناء حضورك الرقمي',
 '© 2024 منصة المواقع. جميع الحقوق محفوظة.');

-- 3. جدول شهادات/آراء العملاء للموقع الرئيسي
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

-- 4. جدول المميزات للموقع الرئيسي
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

-- 5. إدراج مميزات افتراضية
INSERT INTO `site_features` (`icon`, `title`, `description`, `display_order`) VALUES
('fas fa-palette', 'قوالب احترافية', 'اختر من بين مجموعة متنوعة من القوالب الجاهزة والمصممة باحترافية', 1),
('fas fa-magic', 'تخصيص سهل', 'عدّل الألوان والخطوط والمحتوى بسهولة بدون حاجة لخبرة تقنية', 2),
('fas fa-mobile-alt', 'متجاوب مع جميع الأجهزة', 'مواقعك تعمل بشكل مثالي على الجوال والتابلت والكمبيوتر', 3),
('fas fa-bolt', 'سرعة فائقة', 'مواقع سريعة التحميل ومحسنة لمحركات البحث', 4),
('fas fa-headset', 'دعم فني متواصل', 'فريق دعم متخصص جاهز لمساعدتك في أي وقت', 5),
('fas fa-shield-alt', 'آمن ومحمي', 'حماية متقدمة وشهادات SSL مجانية لجميع المواقع', 6);
