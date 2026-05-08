-- ============================================
-- إضافة جداول الأسئلة الشائعة والإحصائيات
-- ============================================

-- جدول الأسئلة الشائعة
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `question` varchar(500) NOT NULL COMMENT 'السؤال بالعربية',
  `question_en` varchar(500) DEFAULT NULL COMMENT 'السؤال بالإنجليزية',
  `answer` text NOT NULL COMMENT 'الإجابة بالعربية',
  `answer_en` text DEFAULT NULL COMMENT 'الإجابة بالإنجليزية',
  `category` varchar(100) DEFAULT 'general' COMMENT 'تصنيف السؤال: general, pricing, services',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_tenant_id` (`tenant_id`),
  KEY `idx_tenant_category` (`tenant_id`, `category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- جدول إحصائيات الموقع (العداد)
CREATE TABLE IF NOT EXISTS `site_stats` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `label` varchar(100) NOT NULL COMMENT 'الوصف بالعربية',
  `label_en` varchar(100) DEFAULT NULL COMMENT 'الوصف بالإنجليزية',
  `value` varchar(50) NOT NULL COMMENT 'الرقم أو القيمة',
  `suffix` varchar(20) DEFAULT '+' COMMENT 'لاحقة مثل + أو %',
  `icon` varchar(100) DEFAULT 'fas fa-star' COMMENT 'أيقونة Font Awesome',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- إضافة قسم الإحصائيات لأقسام الموقع القابلة للتحكم
-- يتم تنفيذها لكل مستأجر موجود
INSERT IGNORE INTO `sections_config` (`tenant_id`, `section_key`, `section_label_ar`, `section_label_en`, `is_enabled`, `display_order`, `section_icon`)
SELECT `id`, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar'
FROM `tenants`
WHERE `id` NOT IN (SELECT `tenant_id` FROM `sections_config` WHERE `section_key` = 'stats');
