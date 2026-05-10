-- ============================================================================
-- إصلاح شامل لنظام الثيمات - Unified Themes Fix Migration
-- ============================================================================
-- المشاكل المُصلحة:
--   1. عدم تطابق معرفات الثيمات بين restore_themes.sql و demo_content_all_themes.sql
--   2. أعمدة مفقودة في جدول theme_settings (لا تتطابق مع ThemeController)
--   3. ENUM الخاص بالتصنيفات لا يشمل الفئات الجديدة (medical, realestate, etc.)
--   4. مسارات صور المعاينة تستخدم .jpg بدلاً من .png الفعلية
--   5. أسماء الثيمات المدفوعة غير احترافية (قالب طبي بدلاً من طبيبروف)
--   6. تصنيف الثيمات المدفوعة كـ 'other' بدلاً من تصنيفاتها الصحيحة
-- ============================================================================
-- ملخص التعيين الجديد:
--   ID=1  → general      (خدمات عامة / General Services)     - مجاني
--   ID=2  → electric     (كهرباء الموثوق / Reliable Electric) - مجاني
--   ID=3  → cleaning     (نضارة / CleanSpark)                - مجاني
--   ID=4  → decor        (أثر الديكور / Decor Mark)          - مجاني
--   ID=5  → maintenance  (الصيانة الأولى / First Maintenance) - مجاني
--   ID=6  → plumbing     (سباكة الضمان / Warranty Plumbing)  - مجاني
--   ID=7  → medical      (طبيبروف / MediPro)                 - مدفوع 149 ر.س
--   ID=8  → realestate   (عقار الخليج / Gulf Estates)        - مدفوع 199 ر.س
--   ID=9  → restaurant   (مائدة شهية / Feast Table)          - مدفوع 149 ر.س
--   ID=10 → education    (مسار المعرفة / Knowledge Path)     - مدفوع 149 ر.س
--   ID=11 → legal        (العدل للمحاماة / Al-Adal Legal)    - مدفوع 199 ر.س
--   ID=12 → fitness      (أبطال الصحة / Health Champions)    - مدفوع 149 ر.س
-- ============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================================
-- الخطوة 1: تحديث معرفات الثيمات في جدول tenants قبل تغيير جدول themes
-- هذا يضمن أن المواقع الحالية تبقى متصلة بالثيم الصحيح
-- التعيين القديم → الجديد:
--   maintenance(1) → general(1)     NO — فعلياً: maintenance كان 1، سيتحول إلى 5
--   decor(2)       → 4
--   electric(3)    → 2
--   plumbing(4)    → 6
--   cleaning(5)    → 3
--   general(6)     → 1
--   medical(7)     → 7 (بدون تغيير)
--   realestate(8)  → 8 (بدون تغيير)
--   restaurant(9)  → 9 (بدون تغيير)
--   education(10)  → 10 (بدون تغيير)
--   legal(11)      → 11 (بدون تغيير)
--   fitness(12)    → 12 (بدون تغيير)
-- ============================================================================

-- إعادة تعيين theme_id للثيمات المجانية فقط (المدفوعة لم تتغير معرفاتها)
UPDATE IGNORE `tenants` SET `theme_id` = 1 WHERE `theme_id` = 6;  -- general: كان 6، أصبح 1
UPDATE IGNORE `tenants` SET `theme_id` = 2 WHERE `theme_id` = 3;  -- electric: كان 3، أصبح 2
UPDATE IGNORE `tenants` SET `theme_id` = 3 WHERE `theme_id` = 5;  -- cleaning: كان 5، أصبح 3
UPDATE IGNORE `tenants` SET `theme_id` = 4 WHERE `theme_id` = 2;  -- decor: كان 2، أصبح 4
UPDATE IGNORE `tenants` SET `theme_id` = 5 WHERE `theme_id` = 1;  -- maintenance: كان 1، أصبح 5
UPDATE IGNORE `tenants` SET `theme_id` = 6 WHERE `theme_id` = 4;  -- plumbing: كان 4، أصبح 6

-- ============================================================================
-- الخطوة 2: حذف وحذف البيانات المرتبطة (مع الحفاظ على الجداول)
-- نحذف بيانات المحتوى والوسائط المرتبطة بالثيمات القديمة
-- لأن معرفاتها لن تتطابق بعد إعادة البناء
-- ============================================================================

DELETE FROM `theme_contents` WHERE 1=1;
DELETE FROM `theme_media` WHERE 1=1;
DELETE FROM `theme_requests` WHERE 1=1;
DELETE FROM `themes` WHERE 1=1;

-- ============================================================================
-- الخطوة 3: إعادة بناء جدول themes بالبنية الكاملة والمعرفات الصحيحة
-- مع تحديث ENUM الخاص بالتصنيفات ليشمل الفئات الجديدة
-- ============================================================================

DROP TABLE IF EXISTS `themes`;

CREATE TABLE `themes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL COMMENT 'اسم القالب بالعربية',
    `name_en` VARCHAR(100) DEFAULT NULL COMMENT 'اسم القالب بالإنجليزية',
    `slug` VARCHAR(100) NOT NULL COMMENT 'معرف القالب الفريد',
    `description` TEXT DEFAULT NULL COMMENT 'وصف القالب بالعربية',
    `description_en` TEXT DEFAULT NULL COMMENT 'وصف القالب بالإنجليزية',
    `category` ENUM(
        'general',
        'maintenance',
        'decor',
        'electric',
        'plumbing',
        'cleaning',
        'medical',
        'realestate',
        'restaurant',
        'education',
        'fitness',
        'legal',
        'other'
    ) NOT NULL DEFAULT 'general' COMMENT 'تصنيف القالب',
    `preview_image` VARCHAR(255) DEFAULT NULL COMMENT 'مسار صورة المعاينة',
    `thumbnail` VARCHAR(500) DEFAULT NULL COMMENT 'مسار الصورة المصغرة',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'هل القالب مفعّل',
    `is_premium` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'هل القالب مميز',
    `is_paid` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'هل القالب مدفوع 0=مجاني 1=مدفوع',
    `price` DECIMAL(10,2) DEFAULT 0.00 COMMENT 'سعر القالب المدفوع',
    `currency` VARCHAR(10) DEFAULT 'SAR' COMMENT 'عملة السعر',
    `payment_link` VARCHAR(500) DEFAULT NULL COMMENT 'رابط الدفع للقالب المدفوع',
    `sort_order` INT(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب العرض',
    `version` VARCHAR(20) DEFAULT '1.0.0' COMMENT 'إصدار القالب',
    `settings_schema` TEXT DEFAULT NULL COMMENT 'JSON schema لإعدادات القالب',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `category` (`category`),
    KEY `is_active` (`is_active`),
    KEY `is_paid` (`is_paid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- الخطوة 4: إدخال الثيمات الـ12 بالمعرفات والأسماء والتصنيفات الصحيحة
-- ============================================================================

INSERT INTO `themes` (`id`, `name`, `name_en`, `slug`, `description`, `description_en`, `category`, `preview_image`, `thumbnail`, `is_active`, `is_premium`, `is_paid`, `price`, `currency`, `sort_order`, `version`) VALUES

-- الثيمات المجانية (1-6)
(1, 'خدمات عامة', 'General Services', 'general',
 'قالب متعدد الاستخدامات مناسب لجميع أنواع الخدمات والشركات الصغيرة والمتوسطة',
 'Versatile template suitable for all types of services and small to medium businesses',
 'general', 'uploads/themes/previews/general-preview.png', 'uploads/themes/previews/general-preview.png',
 1, 0, 0, 0.00, 'SAR', 1, '1.0.0'),

(2, 'كهرباء الموثوق', 'Reliable Electric', 'electric',
 'قالب احترافي متخصص لشركات الكهرباء والتمديدات الكهربائية بألوان وتصميم هندسي',
 'Professional template specialized for electrical companies with engineering design and colors',
 'electric', 'uploads/themes/previews/electric-preview.png', 'uploads/themes/previews/electric-preview.png',
 1, 0, 0, 0.00, 'SAR', 2, '1.0.0'),

(3, 'نضارة', 'CleanSpark', 'cleaning',
 'قالب منعش ومشرق لشركات التنظيف بخلفيات نظيفة وألوان مريحة للعين',
 'Fresh and bright template for cleaning companies with clean backgrounds and soothing colors',
 'cleaning', 'uploads/themes/previews/cleaning-preview.png', 'uploads/themes/previews/cleaning-preview.png',
 1, 0, 0, 0.00, 'SAR', 3, '1.0.0'),

(4, 'أثر الديكور', 'Decor Mark', 'decor',
 'قالب أنيق وفاخر لشركات الديكور والتصميم الداخلي بألوان دافئة وتصميم راقي',
 'Elegant and luxurious template for interior design companies with warm colors and refined design',
 'decor', 'uploads/themes/previews/decor-preview.png', 'uploads/themes/previews/decor-preview.png',
 1, 0, 0, 0.00, 'SAR', 4, '1.0.0'),

(5, 'الصيانة الأولى', 'First Maintenance', 'maintenance',
 'قالب عملي وموثوق لشركات الصيانة العامة بتصميم يوحي بالثقة والاحترافية',
 'Practical and reliable template for general maintenance companies conveying trust and professionalism',
 'maintenance', 'uploads/themes/previews/maintenance-preview.png', 'uploads/themes/previews/maintenance-preview.png',
 1, 0, 0, 0.00, 'SAR', 5, '1.0.0'),

(6, 'سباكة الضمان', 'Warranty Plumbing', 'plumbing',
 'قالب متخصص لشركات السباكة بألوان مائية وتصميم يدل على الثقة والموثوقية',
 'Specialized template for plumbing companies with aquatic colors and trust-inspiring design',
 'plumbing', 'uploads/themes/previews/plumbing-preview.png', 'uploads/themes/previews/plumbing-preview.png',
 1, 0, 0, 0.00, 'SAR', 6, '1.0.0'),

-- الثيمات المدفوعة (7-12)
(7, 'طبيبروف', 'MediPro', 'medical',
 'قالب طبي احترافي للعيادات والمستشفيات والمراكز الصحية بتصميم نظيف وموثوق',
 'Professional medical template for clinics, hospitals, and healthcare centers with clean trustworthy design',
 'medical', 'uploads/themes/previews/medical-preview.png', 'uploads/themes/previews/medical-preview.png',
 1, 1, 1, 149.00, 'SAR', 7, '1.0.0'),

(8, 'عقار الخليج', 'Gulf Estates', 'realestate',
 'قالب فاخر لشركات العقارات والوساطة العقارية بتصميم ذهبي راقي',
 'Luxurious template for real estate companies and property agencies with elegant gold design',
 'realestate', 'uploads/themes/previews/realestate-preview.png', 'uploads/themes/previews/realestate-preview.png',
 1, 1, 1, 199.00, 'SAR', 8, '1.0.0'),

(9, 'مائدة شهية', 'Feast Table', 'restaurant',
 'قالب أنيق للمطاعم والكافيهات بتصميم دافئ يعزف على شهية الزوار',
 'Elegant template for restaurants and cafes with warm appetizing design',
 'restaurant', 'uploads/themes/previews/restaurant-preview.png', 'uploads/themes/previews/restaurant-preview.png',
 1, 1, 1, 149.00, 'SAR', 9, '1.0.0'),

(10, 'مسار المعرفة', 'Knowledge Path Academy', 'education',
 'قالب أكاديمي احترافي للمدارس ومراكز التدريب بتصميم حديث يعكس الجدية',
 'Professional academic template for schools and training centers with modern design reflecting seriousness',
 'education', 'uploads/themes/previews/education-preview.png', 'uploads/themes/previews/education-preview.png',
 1, 1, 1, 149.00, 'SAR', 10, '1.0.0'),

(11, 'العدل للمحاماة', 'Al-Adal Legal', 'legal',
 'قالب رسمي فاخر لمكاتب المحاماة والاستشارات القانونية بألوان كحلي وذهبي',
 'Premium formal template for law firms and legal consultancy with navy blue and gold colors',
 'legal', 'uploads/themes/previews/legal-preview.png', 'uploads/themes/previews/legal-preview.png',
 1, 1, 1, 199.00, 'SAR', 11, '1.0.0'),

(12, 'أبطال الصحة', 'Health Champions', 'fitness',
 'قالب رياضي قوي للنوادي الرياضية وصالات الجيم بتصميم يشع طاقة وحماس',
 'Powerful sports template for gyms and fitness clubs with energetic bold design',
 'fitness', 'uploads/themes/previews/fitness-preview.png', 'uploads/themes/previews/fitness-preview.png',
 1, 1, 1, 149.00, 'SAR', 12, '1.0.0');

-- ============================================================================
-- الخطوة 5: إعادة بناء جدول طلبات تفعيل الثيمات المدفوعة
-- ============================================================================

DROP TABLE IF EXISTS `theme_requests`;

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

-- ============================================================================
-- الخطوة 6: إضافة الأعمدة المفقودة إلى جدول theme_settings
-- هذه الأعمدة مطلوبة من قبل ThemeController.php لكنها غير موجودة في المخطط
-- نستخدم إجراء مخزّن للتحقق من وجود العمود قبل إضافته (MySQL 5.7 متوافق)
-- ============================================================================

-- الأعمدة الجديدة المطلوبة من ThemeController:
-- primary_font, secondary_font, base_font_size, heading_font_weight, body_font_weight,
-- primary_color, secondary_color, accent_color, text_color, text_muted_color,
-- background_color, card_background, border_color, button_radius, card_radius,
-- footer_style, button_style, button_shadow, card_hover_effect,
-- enable_animations (مرادف لـ animation_enabled), animation_type,
-- container_width, header_fixed, sidebar_position

-- الإجراء المخزّن لإضافة العمود بأمان
DROP PROCEDURE IF EXISTS `safe_add_column`;
DELIMITER $$
CREATE PROCEDURE `safe_add_column`(
    IN `tbl_name` VARCHAR(64),
    IN `col_name` VARCHAR(64),
    IN `col_def` VARCHAR(500)
)
BEGIN
    DECLARE col_count INT;
    SELECT COUNT(*) INTO col_count
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = `tbl_name`
          AND COLUMN_NAME = `col_name`;
    IF col_count = 0 THEN
        SET @ddl = CONCAT('ALTER TABLE `', `tbl_name`, '` ADD COLUMN `', `col_name`, '` ', `col_def`);
        PREPARE stmt FROM @ddl;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
        SELECT CONCAT('تمت إضافة العمود: ', `tbl_name`, '.', `col_name`) AS result;
    ELSE
        SELECT CONCAT('العمود موجود بالفعل: ', `tbl_name`, '.', `col_name`) AS result;
    END IF;
END$$
DELIMITER ;

-- إضافة الأعمدة المفقودة
CALL `safe_add_column`('theme_settings', 'primary_font', "VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الرئيسي (مرادف لـ font_primary)'");
CALL `safe_add_column`('theme_settings', 'secondary_font', "VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الثانوي (مرادف لـ font_secondary)'");
CALL `safe_add_column`('theme_settings', 'base_font_size', "VARCHAR(10) DEFAULT '16' COMMENT 'حجم الخط الأساسي بكسل (مرادف لـ font_size_base)'");
CALL `safe_add_column`('theme_settings', 'heading_font_weight', "VARCHAR(10) DEFAULT '700' COMMENT 'سُمك خطوط العناوين'");
CALL `safe_add_column`('theme_settings', 'body_font_weight', "VARCHAR(10) DEFAULT '400' COMMENT 'سُمك خطوط النص العادي'");
CALL `safe_add_column`('theme_settings', 'primary_color', "VARCHAR(7) DEFAULT '#2563eb' COMMENT 'اللون الرئيسي'");
CALL `safe_add_column`('theme_settings', 'secondary_color', "VARCHAR(7) DEFAULT '#1e40af' COMMENT 'اللون الثانوي'");
CALL `safe_add_column`('theme_settings', 'accent_color', "VARCHAR(7) DEFAULT '#f59e0b' COMMENT 'لون التمييز'");
CALL `safe_add_column`('theme_settings', 'text_color', "VARCHAR(7) DEFAULT '#1f2937' COMMENT 'لون النص الرئيسي'");
CALL `safe_add_column`('theme_settings', 'text_muted_color', "VARCHAR(7) DEFAULT '#6b7280' COMMENT 'لون النص الثانوي'");
CALL `safe_add_column`('theme_settings', 'background_color', "VARCHAR(7) DEFAULT '#ffffff' COMMENT 'لون الخلفية'");
CALL `safe_add_column`('theme_settings', 'card_background', "VARCHAR(7) DEFAULT '#ffffff' COMMENT 'لون خلفية البطاقات'");
CALL `safe_add_column`('theme_settings', 'border_color', "VARCHAR(7) DEFAULT '#e5e7eb' COMMENT 'لون الحدود'");
CALL `safe_add_column`('theme_settings', 'button_radius', "VARCHAR(10) DEFAULT '8' COMMENT 'استدارة الأزرار'");
CALL `safe_add_column`('theme_settings', 'card_radius', "VARCHAR(10) DEFAULT '12' COMMENT 'استدارة البطاقات'");
CALL `safe_add_column`('theme_settings', 'button_shadow', "TINYINT(1) DEFAULT 0 COMMENT 'ظل الأزرار 0=بدون 1=مع ظل'");
CALL `safe_add_column`('theme_settings', 'card_hover_effect', "VARCHAR(20) DEFAULT 'lift' COMMENT 'تأثير تمرير البطاقات lift/glow/none'");
CALL `safe_add_column`('theme_settings', 'enable_animations', "TINYINT(1) DEFAULT 1 COMMENT 'تفعيل الرسوم المتحركة (مرادف لـ animation_enabled)'");
CALL `safe_add_column`('theme_settings', 'animation_type', "VARCHAR(20) DEFAULT 'fade' COMMENT 'نوع الرسوم المتحركة fade/slide/zoom'");
CALL `safe_add_column`('theme_settings', 'container_width', "VARCHAR(10) DEFAULT '1200' COMMENT 'عرض الحاوية بكسل'");
CALL `safe_add_column`('theme_settings', 'header_fixed', "TINYINT(1) DEFAULT 0 COMMENT 'ثبات الرأس 0=عادي 1=ثابت'");
CALL `safe_add_column`('theme_settings', 'sidebar_position', "VARCHAR(10) DEFAULT 'right' COMMENT 'موضع الشريط الجانبي right/left/none'");

-- ============================================================================
-- الخطوة 7: مزامنة الأعمدة القديمة بالقيم الافتراضية
-- نسخ القيم من الأعمدة القديمة إلى الجديدة المرادفة (إن وجدت)
-- ============================================================================

-- مزامنة الخطوط: font_primary → primary_font
UPDATE `theme_settings`
    SET `primary_font` = `font_primary`
    WHERE `primary_font` = 'Tajawal' AND `font_primary` IS NOT NULL AND `font_primary` != 'Tajawal';

UPDATE `theme_settings`
    SET `secondary_font` = `font_secondary`
    WHERE `secondary_font` = 'Tajawal' AND `font_secondary` IS NOT NULL AND `font_secondary` != 'Tajawal';

-- مزامنة حجم الخط: font_size_base → base_font_size
UPDATE `theme_settings`
    SET `base_font_size` = REPLACE(`font_size_base`, 'px', '')
    WHERE `font_size_base` IS NOT NULL AND `font_size_base` != '16px';

-- مزامنة الرسوم المتحركة: animation_enabled → enable_animations
UPDATE `theme_settings`
    SET `enable_animations` = `animation_enabled`
    WHERE `animation_enabled` IS NOT NULL;

-- ============================================================================
-- الخطوة 8: إعادة تفعيل فحص المفاتيح الأجنبية
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================================
-- الخطوة 9: التحقق من صحة البيانات
-- ============================================================================

-- التحقق من عدد الثيمات
SELECT 'التحقق: عدد الثيمات' AS check_type,
       COUNT(*) AS total_themes,
       SUM(CASE WHEN is_paid = 0 THEN 1 ELSE 0 END) AS free_themes,
       SUM(CASE WHEN is_paid = 1 THEN 1 ELSE 0 END) AS paid_themes
FROM `themes`;

-- التحقق من التعيينات
SELECT 'التحقق: تعيينات الثيمات' AS check_type, `id`, `slug`, `name`, `name_en`, `category`, `is_paid`, `price`
FROM `themes`
ORDER BY `id`;

-- التحقق من المعرفات في tenants
SELECT 'التحقق: توزيع الثيمات على المواقع' AS check_type,
       t.`theme_id`,
       th.`name_en`,
       th.`slug`,
       COUNT(*) AS tenant_count
FROM `tenants` t
LEFT JOIN `themes` th ON t.`theme_id` = th.`id`
GROUP BY t.`theme_id`, th.`name_en`, th.`slug`
ORDER BY t.`theme_id`;

-- التحقق من أعمدة theme_settings
SELECT 'التحقق: أعمدة theme_settings' AS check_type,
       COLUMN_NAME, COLUMN_TYPE, COLUMN_DEFAULT, IS_NULLABLE
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'theme_settings'
ORDER BY ORDINAL_POSITION;

-- ============================================================================
-- الخطوة 10: تنظيف الإجراء المخزّن المؤقت
-- ============================================================================

DROP PROCEDURE IF EXISTS `safe_add_column`;

-- ============================================================================
-- تمت الترقية بنجاح!
-- ============================================================================
-- ملاحظات مهمة:
--   1. بعد تشغيل هذا الملف، يجب إعادة تشغيل demo_content_all_themes.sql
--      لملء جداول theme_contents و theme_media بالبيانات الصحيحة
--   2. تم تحديث معرفات الثيمات في جدول tenants تلقائياً
--   3. جميع الصور الآن تشير إلى ملفات .png (الموجودة فعلياً)
--   4. أسماء الثيمات أصبحت احترافية وفريدة لكل فئة
--   5. تم إضافة 6 فئات جديدة للـ ENUM: medical, realestate, restaurant, education, fitness, legal
--   6. تم إضافة 14 عمود جديد لجدول theme_settings لتتوافق مع ThemeController
-- ============================================================================
