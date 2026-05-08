-- ==========================================
-- نظام الخدمات المدفوعة (متجر الإضافات)
-- Paid Services / Addons Marketplace
-- ==========================================

-- جدول الخدمات المدفوعة (يضيفها الأدمن)
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

-- جدول مشتريات المستأجرين
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

-- ==========================================
-- بيانات تجريبية - خدمات مدفوعة مقترحة
-- ==========================================

INSERT INTO `paid_services` (`id`, `title`, `slug`, `description`, `price`, `icon`, `category`, `payment_link`, `is_recurring`, `recurring_period`, `is_active`, `sort_order`, `max_quantity`, `requires_approval`) VALUES
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

-- تحديث جدول tenants لدعم ربط الدومين المخصص
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_status` enum('none','pending','active','rejected') DEFAULT 'none' AFTER `custom_domain`;
ALTER TABLE `tenants` ADD COLUMN IF NOT EXISTS `custom_domain_purchased` tinyint(1) DEFAULT 0 AFTER `custom_domain_status`;
