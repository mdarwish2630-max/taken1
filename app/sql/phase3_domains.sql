-- =====================================================
-- CMS Platform - Phase 3: Domains & Subdomains
-- المرحلة الثالثة: النطاقات والنطاقات الفرعية
-- =====================================================

-- 1. إضافة حقول النطاقات لجدول tenants
ALTER TABLE `tenants` ADD COLUMN `subdomain` VARCHAR(100) NULL UNIQUE AFTER `slug`;
ALTER TABLE `tenants` ADD COLUMN `custom_domain` VARCHAR(255) NULL UNIQUE AFTER `subdomain`;
ALTER TABLE `tenants` ADD COLUMN `custom_domain_verified` TINYINT(1) DEFAULT 0 AFTER `custom_domain`;
ALTER TABLE `tenants` ADD COLUMN `custom_domain_verification_token` VARCHAR(64) NULL AFTER `custom_domain_verified`;
ALTER TABLE `tenants` ADD COLUMN `domain_status` ENUM('pending', 'active', 'failed') DEFAULT 'pending' AFTER `custom_domain_verification_token`;

-- 2. إضافة فهارس للبحث السريع
CREATE INDEX `idx_tenants_subdomain` ON `tenants`(`subdomain`);
CREATE INDEX `idx_tenants_custom_domain` ON `tenants`(`custom_domain`);

-- 3. إنشاء جدول سجل النطاقات
CREATE TABLE IF NOT EXISTS `domain_history` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `tenant_id` INT UNSIGNED NOT NULL,
    `domain_type` ENUM('subdomain', 'custom') NOT NULL,
    `old_value` VARCHAR(255) NULL,
    `new_value` VARCHAR(255) NULL,
    `status` ENUM('added', 'verified', 'removed', 'failed') NOT NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. إنشاء جدول تحقق النطاقات
CREATE TABLE IF NOT EXISTS `domain_verifications` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `tenant_id` INT UNSIGNED NOT NULL,
    `domain` VARCHAR(255) NOT NULL,
    `verification_method` ENUM('dns_txt', 'dns_cname', 'file') DEFAULT 'dns_txt',
    `verification_token` VARCHAR(64) NOT NULL,
    `verification_content` TEXT NULL,
    `verified_at` TIMESTAMP NULL,
    `expires_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. تحديث جدول خطط الاشتراك - إضافة ميزة النطاق المخصص
ALTER TABLE `subscription_plans` ADD COLUMN `allow_custom_domain` TINYINT(1) DEFAULT 0 AFTER `features`;
ALTER TABLE `subscription_plans` ADD COLUMN `allow_subdomain` TINYINT(1) DEFAULT 1 AFTER `allow_custom_domain`;

-- 6. تحديث الخطط الحالية
UPDATE `subscription_plans` SET `allow_subdomain` = 1, `allow_custom_domain` = 0 WHERE `slug` = 'basic';
UPDATE `subscription_plans` SET `allow_subdomain` = 1, `allow_custom_domain` = 1 WHERE `slug` = 'pro';
UPDATE `subscription_plans` SET `allow_subdomain` = 1, `allow_custom_domain` = 1 WHERE `slug` = 'enterprise';

-- 7. إضافة إعدادات النطاق في الإعدادات العامة
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`) VALUES
('main_domain', 'takweenweb.com', 'string'),
('enable_subdomains', '1', 'boolean'),
('enable_custom_domains', '1', 'boolean'),
('subdomain_blacklist', 'www,mail,ftp,admin,api,app,blog,shop,store,support,help,demo,test,dev,staging', 'text'),
('dns_verification_instructions', 'أضف سجل TXT في إعدادات DNS الخاص بنطاقك', 'text');

-- 8. إضافة صلاحيات النطاقات للأدوار
-- (إذا كان هناك جدول صلاحيات)
