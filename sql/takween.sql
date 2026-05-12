-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 08:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `takween`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `safe_add_column` (IN `tbl_name` VARCHAR(64), IN `col_name` VARCHAR(64), IN `col_def` VARCHAR(500))   BEGIN
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

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `visitor_id` varchar(64) DEFAULT NULL COMMENT 'Anonymous visitor identifier',
  `session_id` varchar(64) DEFAULT NULL,
  `page_url` varchar(500) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `referrer` varchar(500) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `device_type` enum('desktop','tablet','mobile') DEFAULT 'desktop',
  `browser` varchar(100) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL,
  `time_spent` int(11) DEFAULT 0 COMMENT 'Seconds spent on page',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `subtitle_en` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_text_en` varchar(100) DEFAULT NULL,
  `position` varchar(50) DEFAULT 'hero',
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `tenant_id`, `title`, `title_en`, `subtitle`, `subtitle_en`, `description`, `description_en`, `image`, `link`, `button_text`, `button_text_en`, `position`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 6, 'خدمة صيانة متميزة', 'Professional Home Maintenance Services', 'نحن هنا لخدمتك', 'We provide the best maintenance services for your home with guaranteed quality and competitive prices. Fast response and professional work.', 'صيانة منزلية شاملة بأيدي خبراء معتمدين. اتصل الآن واحصل على خصم 20%', NULL, 'banners/maintenance-hero.jpg', '/services', 'احجز الآن', NULL, 'hero', 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(3, 6, 'عرض الصيف', NULL, 'خصم 30% على صيانة المكيفات', NULL, 'استعد للصيف مع عرض خاص على صيانة المكيفات', NULL, 'banners/ac-offer.jpg', '/service/ac-maintenance', 'اطلب العرض', NULL, 'slider', 2, 'active', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(4, 9, 'حول منزلك إلى تحفة فنية', NULL, 'تصاميم داخلية فاخرة', NULL, 'نحول أحلامك إلى واقع. استشارة مجانية لأول مرة', NULL, 'banners/decor-hero.jpg', '/services', 'احجز استشارة', NULL, 'hero', 1, 'active', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(5, 8, 'بيت نظيف = حياة صحية', NULL, 'خدمات تنظيف احترافية', NULL, 'نظافة شاملة لمنزلك بأحدث المعدات وأجود المنظفات', NULL, 'banners/clean-hero.jpg', '/services', 'احجز الآن', NULL, 'hero', 1, 'active', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(6, 6, 'خدمة صيانة متميزة', 'Professional Home Maintenance Services', 'نحن هنا لخدمتك', 'We provide the best maintenance services for your home with guaranteed quality and competitive prices. Fast response and professional work.', 'صيانة منزلية شاملة بأيدي خبراء معتمدين. اتصل الآن واحصل على خصم 20%', NULL, 'uploads/banners/hero-1.jpg', '/services', 'احجز الآن', NULL, 'hero', 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(7, 6, 'عرض الصيف', NULL, 'خصم 30% على صيانة المكيفات', NULL, 'استعد للصيف مع عرض خاص على صيانة المكيفات', NULL, 'uploads/banners/offer-1.jpg', '/service/ac-maintenance', 'اطلب العرض', NULL, 'slider', 2, 'active', '2026-03-16 19:31:47', '2026-03-16 19:31:47'),
(8, 9, 'حول منزلك إلى تحفة فنية', NULL, 'تصاميم داخلية فاخرة', NULL, 'نحول أحلامك إلى واقع. استشارة مجانية لأول مرة', NULL, 'uploads/banners/decor-hero.jpg', '/services', 'احجز استشارة', NULL, 'hero', 1, 'active', '2026-03-16 19:31:47', '2026-03-16 19:31:47'),
(9, 8, 'بيت نظيف = حياة صحية', NULL, 'خدمات تنظيف احترافية', NULL, 'نظافة شاملة لمنزلك بأحدث المعدات وأجود المنظفات', NULL, 'uploads/banners/clean-hero.jpg', '/services', 'احجز الآن', NULL, 'hero', 1, 'active', '2026-03-16 19:31:47', '2026-03-16 19:31:47'),
(10, 7, 'خدمة طوارئ 24 ساعة', NULL, 'نحن متاحون دائماً', NULL, 'فريقنا جاهز للتعامل مع أي طوارئ كهربائية على مدار الساعة', NULL, 'uploads/banners/electric-hero.jpg', '/service/emergency', 'اتصل الآن', NULL, 'hero', 1, 'active', '2026-03-16 19:31:47', '2026-03-16 19:31:47'),
(12, 5, 'gfg fg f', 'fg fgf', 'fgfgf', 'fgfgf', 'fg fg f', 'g f gf', '5/banners/Whisk_730d5bede6a67db8ccd4f813736d47cedr_20260512185143_2ccb51b2.jpeg', '#', 'fg f', 'fg fg', 'hero', 1, 'active', '2026-05-12 18:51:43', '2026-05-12 18:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` text DEFAULT NULL COMMENT 'JSON array',
  `author_name` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` enum('draft','published','scheduled') NOT NULL DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `views` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `show_on_home` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `tenant_id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 6, 'محمد أحمد', 'mohmed@email.com', '0512345678', 'استفسار عن صيانة مكيف', 'مرحباً، أريد الاستفسار عن سعر صيانة مكيف سبليت. هل يوجد ضمان على العمل؟', 0, '2026-03-16 19:17:17'),
(2, 6, 'سارة علي', 'sara@email.com', '0523456789', 'طلب خدمة سباكة', 'عندي تسريب في المطبخ وأحتاج فني سباكة بأسرع وقت.', 1, '2026-03-16 19:17:17'),
(3, 9, 'فاطمة خالد', 'fatima@email.com', '0534567890', 'تصميم داخلي لفيلا', 'أريد تصميم داخلي لفيلا جديدة 400 متر. هل يمكن جدولة موعد للمعاينة؟', 0, '2026-03-16 19:17:17'),
(4, 8, 'عبدالرحمن', 'abdulrahman@email.com', '0545678901', 'تنظيف شقة', 'أحتاج تنظيف شقة 3 غرف. ما هي الأسعار وطريقة الحجز؟', 1, '2026-03-16 19:17:17'),
(5, 6, 'محمد أحمد', 'mohmed@email.com', '0512345678', 'استفسار عن صيانة مكيف', 'مرحباً، أريد الاستفسار عن سعر صيانة مكيف سبليت. هل يوجد ضمان على العمل؟', 0, '2026-03-16 19:31:47'),
(6, 6, 'سارة علي', 'sara@email.com', '0523456789', 'طلب خدمة سباكة', 'عندي تسريب في المطبخ وأحتاج فني سباكة بأسرع وقت.', 1, '2026-03-16 19:31:47'),
(7, 9, 'فاطمة خالد', 'fatima@email.com', '0534567890', 'تصميم داخلي لفيلا', 'أريد تصميم داخلي لفيلا جديدة 400 متر. هل يمكن جدولة موعد للمعاينة؟', 0, '2026-03-16 19:31:47'),
(8, 8, 'عبدالرحمن', 'abdulrahman@email.com', '0545678901', 'تنظيف شقة', 'أحتاج تنظيف شقة 3 غرف. ما هي الأسعار وطريقة الحجز؟', 1, '2026-03-16 19:31:47'),
(9, 7, 'خالد سعد', 'khalid@email.com', '0556789012', 'تمديدات جديدة', 'أريد عمل تمديدات كهربائية لمبنى جديد. أرجو التواصل للتفاصيل.', 0, '2026-03-16 19:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `custom_forms`
--

CREATE TABLE `custom_forms` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `fields` text NOT NULL COMMENT 'JSON array of form fields',
  `submit_button_text` varchar(100) DEFAULT 'إرسال',
  `success_message` varchar(255) DEFAULT 'تم الإرسال بنجاح',
  `redirect_url` varchar(255) DEFAULT NULL,
  `send_email_notification` tinyint(1) DEFAULT 1,
  `email_recipients` text DEFAULT NULL COMMENT 'JSON array of emails',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_imports`
--

CREATE TABLE `demo_imports` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `imported_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domain_history`
--

CREATE TABLE `domain_history` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `domain_type` enum('subdomain','custom') NOT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) NOT NULL,
  `changed_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `question` varchar(500) NOT NULL COMMENT 'السؤال بالعربية',
  `question_en` varchar(500) DEFAULT NULL COMMENT 'السؤال بالإنجليزية',
  `answer` text NOT NULL COMMENT 'الإجابة بالعربية',
  `answer_en` text DEFAULT NULL COMMENT 'الإجابة بالإنجليزية',
  `category` varchar(100) DEFAULT 'general' COMMENT 'تصنيف السؤال: general, pricing, services',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

CREATE TABLE `form_submissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `form_id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `data` text NOT NULL COMMENT 'JSON object of submitted data',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `tenant_id`, `title`, `title_en`, `description`, `description_en`, `image`, `category`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'WhatsApp Image 2026-03-14 at 1.14.06 PM (1)', 'Project Photo', NULL, NULL, '5/gallery/WhatsAppImage2026-03-14at11406PM1_20260315130448_d71a4bd4.jpeg', '', 1, 'active', '2026-03-15 13:04:48', '2026-03-16 20:35:13'),
(2, 6, 'صيانة مكيف سبليت', 'AC Maintenance Project', 'صيانة شاملة لمكيف سبليت', NULL, 'gallery/ac-1.jpg', 'مكيفات', 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(3, 6, 'تصليح تسريب مياه', 'Project Photo', 'كشف وإصلاح تسريب', NULL, 'gallery/plumbing-1.jpg', 'سباكة', 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(4, 6, 'تركيب لوحة كهربائية', 'Electrical Work', 'تركيب لوحة جديدة', NULL, 'gallery/electric-1.jpg', 'كهرباء', 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(5, 6, 'فريق العمل', 'Project Photo', 'فريقنا المتخصص', NULL, 'gallery/team-1.jpg', 'فريق', 4, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(6, 9, 'غرفة نوم رئيسية', 'Project Photo', 'تصميم فاخر لغرفة نوم', NULL, 'gallery/bedroom-1.jpg', 'غرف نوم', 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(7, 9, 'مطبخ عصري', 'Project Photo', 'مطبخ بتصميم مودرن', NULL, 'gallery/kitchen-1.jpg', 'مطابخ', 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(8, 9, 'صالة استقبال', 'Project Photo', 'صالة أنيقة', NULL, 'gallery/living-1.jpg', 'صالات', 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(9, 9, 'حمام فاخر', 'Project Photo', 'تصميم حمام راقي', NULL, 'gallery/bathroom-1.jpg', 'حمامات', 4, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(10, 9, 'غرفة أطفال', 'Project Photo', 'تصميم مميز للأطفال', NULL, 'gallery/kids-1.jpg', 'غرف أطفال', 5, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(11, 8, 'تنظيف فيلا', 'Cleaning Project', 'قبل وبعد التنظيف', NULL, 'gallery/clean-1.jpg', 'فلل', 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(12, 8, 'غسيل موكيت', 'Project Photo', 'غسيل بالبخار', NULL, 'gallery/carpet-1.jpg', 'موكيت', 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(13, 8, 'تنظيف مكتب', 'Cleaning Project', 'خدمة تنظيف مكاتب', NULL, 'gallery/office-1.jpg', 'مكاتب', 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(14, 6, 'صيانة مكيف سبليت', 'AC Maintenance Project', 'صيانة شاملة لمكيف سبليت', NULL, 'uploads/gallery/ac-1.jpg', 'مكيفات', 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(15, 6, 'تصليح تسريب مياه', 'Project Photo', 'كشف وإصلاح تسريب', NULL, 'uploads/gallery/plumbing-1.jpg', 'سباكة', 2, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(16, 6, 'تركيب لوحة كهربائية', 'Electrical Work', 'تركيب لوحة جديدة', NULL, 'uploads/gallery/electric-1.jpg', 'كهرباء', 3, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(17, 6, 'فريق العمل', 'Project Photo', 'فريقنا المتخصص', NULL, 'uploads/gallery/team-1.jpg', 'فريق', 4, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(18, 9, 'غرفة نوم رئيسية', 'Project Photo', 'تصميم فاخر لغرفة نوم', NULL, 'uploads/gallery/bedroom-1.jpg', 'غرف نوم', 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(19, 9, 'مطبخ عصري', 'Project Photo', 'مطبخ بتصميم مودرن', NULL, 'uploads/gallery/kitchen-1.jpg', 'مطابخ', 2, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(20, 9, 'صالة استقبال', 'Project Photo', 'صالة أنيقة', NULL, 'uploads/gallery/living-1.jpg', 'صالات', 3, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(21, 9, 'حمام فاخر', 'Project Photo', 'تصميم حمام راقي', NULL, 'uploads/gallery/bathroom-1.jpg', 'حمامات', 4, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(22, 9, 'غرفة أطفال', 'Project Photo', 'تصميم مميز للأطفال', NULL, 'uploads/gallery/kids-1.jpg', 'غرف أطفال', 5, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(23, 8, 'تنظيف فيلا', 'Cleaning Project', 'قبل وبعد التنظيف', NULL, 'uploads/gallery/clean-1.jpg', 'فلل', 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(24, 8, 'غسيل موكيت', 'Project Photo', 'غسيل بالبخار', NULL, 'uploads/gallery/carpet-1.jpg', 'موكيت', 2, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(25, 8, 'تنظيف مكتب', 'Cleaning Project', 'خدمة تنظيف مكاتب', NULL, 'uploads/gallery/office-1.jpg', 'مكاتب', 3, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `filepath` varchar(500) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL COMMENT 'subscription, payment, system, etc.',
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `data` text DEFAULT NULL COMMENT 'JSON additional data',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `content_en` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_description_en` text DEFAULT NULL,
  `template` varchar(100) DEFAULT 'default',
  `is_home` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 1,
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('draft','published') NOT NULL DEFAULT 'published',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `tenant_id`, `title`, `title_en`, `slug`, `content`, `content_en`, `meta_title`, `meta_title_en`, `meta_description`, `meta_description_en`, `template`, `is_home`, `show_in_menu`, `menu_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'الرئيسية', NULL, 'home', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 0, 'published', '2026-03-14 17:01:51', '2026-03-14 17:01:51'),
(2, 2, 'من نحن', 'About Us', 'about', '<h2>من نحن</h2><p>أضف محتوى صفحة من نحن هنا</p>', 'We are a professional team dedicated to providing high-quality services. With years of experience, we ensure customer satisfaction and deliver exceptional results.', NULL, NULL, NULL, NULL, 'default', 0, 1, 1, 'published', '2026-03-14 17:01:51', '2026-03-16 20:35:13'),
(3, 2, 'خدماتنا', 'Our Services', 'services', '', 'We offer a wide range of professional services to meet all your needs. Quality work guaranteed.', NULL, NULL, NULL, NULL, 'default', 0, 1, 2, 'published', '2026-03-14 17:01:51', '2026-03-16 20:35:13'),
(4, 2, 'معرض الأعمال', NULL, 'gallery', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 3, 'published', '2026-03-14 17:01:51', '2026-03-14 17:01:51'),
(5, 2, 'اتصل بنا', NULL, 'contact', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 4, 'published', '2026-03-14 17:01:51', '2026-03-14 17:01:51'),
(6, 3, 'الرئيسية', NULL, 'home', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 0, 'published', '2026-03-14 17:01:59', '2026-03-14 17:01:59'),
(7, 3, 'من نحن', 'About Us', 'about', '<h2>من نحن</h2><p>أضف محتوى صفحة من نحن هنا</p>', 'We are a professional team dedicated to providing high-quality services. With years of experience, we ensure customer satisfaction and deliver exceptional results.', NULL, NULL, NULL, NULL, 'default', 0, 1, 1, 'published', '2026-03-14 17:01:59', '2026-03-16 20:35:13'),
(8, 3, 'خدماتنا', 'Our Services', 'services', '', 'We offer a wide range of professional services to meet all your needs. Quality work guaranteed.', NULL, NULL, NULL, NULL, 'default', 0, 1, 2, 'published', '2026-03-14 17:01:59', '2026-03-16 20:35:13'),
(9, 3, 'معرض الأعمال', NULL, 'gallery', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 3, 'published', '2026-03-14 17:01:59', '2026-03-14 17:01:59'),
(10, 3, 'اتصل بنا', NULL, 'contact', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 4, 'published', '2026-03-14 17:01:59', '2026-03-14 17:01:59'),
(11, 4, 'الرئيسية', NULL, 'home', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 0, 'published', '2026-03-14 17:02:20', '2026-03-14 17:02:20'),
(12, 4, 'من نحن', 'About Us', 'about', '<h2>من نحن</h2><p>أضف محتوى صفحة من نحن هنا</p>', 'We are a professional team dedicated to providing high-quality services. With years of experience, we ensure customer satisfaction and deliver exceptional results.', NULL, NULL, NULL, NULL, 'default', 0, 1, 1, 'published', '2026-03-14 17:02:20', '2026-03-16 20:35:13'),
(13, 4, 'خدماتنا', 'Our Services', 'services', '', 'We offer a wide range of professional services to meet all your needs. Quality work guaranteed.', NULL, NULL, NULL, NULL, 'default', 0, 1, 2, 'published', '2026-03-14 17:02:20', '2026-03-16 20:35:13'),
(14, 4, 'معرض الأعمال', NULL, 'gallery', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 3, 'published', '2026-03-14 17:02:20', '2026-03-14 17:02:20'),
(15, 4, 'اتصل بنا', NULL, 'contact', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 4, 'published', '2026-03-14 17:02:20', '2026-03-14 17:02:20'),
(16, 5, 'الرئيسية', NULL, 'home', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 0, 'published', '2026-03-14 21:48:05', '2026-03-14 21:48:05'),
(17, 5, 'من نحن', 'About Us', 'about', '<h2>من نحن</h2><p>أضف محتوى صفحة من نحن هنا</p>', 'We are a professional team dedicated to providing high-quality services. With years of experience, we ensure customer satisfaction and deliver exceptional results.', NULL, NULL, NULL, NULL, 'default', 0, 1, 1, 'published', '2026-03-14 21:48:05', '2026-03-16 20:35:13'),
(18, 5, 'خدماتنا', 'Our Services', 'خدماتنا', '', 'We offer a wide range of professional services to meet all your needs. Quality work guaranteed.', '', NULL, '', NULL, 'fullwidth', 0, 1, 2, 'published', '2026-03-14 21:48:05', '2026-04-11 04:02:13'),
(19, 5, 'معرض الأعمال', NULL, 'gallery', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 3, 'published', '2026-03-14 21:48:05', '2026-03-14 21:48:05'),
(20, 5, 'اتصل بنا', NULL, 'contact', '', NULL, NULL, NULL, NULL, NULL, 'default', 0, 1, 4, 'published', '2026-03-14 21:48:05', '2026-03-14 21:48:05'),
(21, 5, 'يبيبي', NULL, 'يبيبي', '&lt;p&gt;يبيبيبي&lt;/p&gt;', NULL, 'يبي', NULL, 'بيبي', NULL, 'default', 0, 1, 5, 'published', '2026-03-14 21:57:55', '2026-03-14 21:57:55'),
(22, 6, 'لماذا نحن', NULL, 'why-us', '<h2>لماذا تختارنا؟</h2><p>نحن شركة رائدة في مجال الصيانة المنزلية منذ أكثر من 10 سنوات. نتميز بـ:</p><ul><li>فريق فني متخصص ومعتمد</li><li>استخدام أحدث المعدات والتقنيات</li><li>ضمان على جميع الأعمال</li><li>أسعار تنافسية وشفافة</li><li>خدمة عملاء متميزة 24/7</li></ul>', NULL, 'لماذا تختار شركة الصيانة الذهبية', NULL, 'أسباب تجعلنا الخيار الأفضل لخدمات الصيانة المنزلية', NULL, 'default', 0, 1, 5, 'published', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(23, 9, 'مشاريعنا', NULL, 'projects', '<h2>مشاريعنا المميزة</h2><p>تفخر بأنها نفذت أكثر من 500 مشروع في جميع أنحاء المملكة:</p><ul><li>فلل سكنية</li><li>شقق فندقية</li><li>مكاتب وشركات</li><li>محلات تجارية</li></ul>', NULL, 'مشاريع أناقة الديكور', NULL, 'استعرض أحدث مشاريعنا في التصميم الداخلي والتشطيب', NULL, 'default', 0, 1, 5, 'published', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(24, 9, 'الأسئلة الشائعة', NULL, 'faq', '<h2>الأسئلة الشائعة</h2><h3>كم يستغرق التصميم؟</h3><p>يعتمد على حجم المشروع، لكن عادةً من 2-4 أسابيع.</p><h3>هل تقدمون ضمان؟</h3><p>نعم، نقدم ضمان سنتين على جميع أعمال التشطيب.</p>', NULL, 'أسئلة شائعة عن خدماتنا', NULL, 'إجابات على أكثر الأسئلة شيوعاً حول خدمات التصميم الداخلي', NULL, 'default', 0, 1, 6, 'published', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(25, 6, 'الرئيسية', NULL, 'الرئيسية', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 6, 'published', '2026-03-16 19:33:21', '2026-03-16 19:33:21'),
(26, 6, 'لماذا نحن', NULL, 'why-us', '<h2>لماذا تختارنا؟</h2><p>نحن شركة رائدة في مجال الصيانة المنزلية منذ أكثر من 10 سنوات. نتميز بـ:</p><ul><li><strong>فريق فني متخصص ومعتمد</strong> - جميع فنيينا حاصلون على شهادات معتمدة</li><li><strong>استخدام أحدث المعدات والتقنيات</strong> - نستخدم أجهزة كشف متطورة</li><li><strong>ضمان على جميع الأعمال</strong> - نقدم ضمان يصل إلى سنة</li><li><strong>أسعار تنافسية وشفافة</strong> - لا رسوم مخفية</li><li><strong>خدمة عملاء متميزة 24/7</strong> - فريق متاح على مدار الساعة</li></ul><h3>أرقام تتحدث</h3><p>أكثر من <strong>5000 عميل راضي</strong> و <strong>15000 عملية صيانة</strong> ناجحة منذ تأسيسنا.</p>', NULL, 'لماذا تختار شركة الصيانة الذهبية', NULL, 'أسباب تجعلنا الخيار الأفضل لخدمات الصيانة المنزلية', NULL, 'default', 0, 1, 5, 'published', '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(27, 6, 'الأسئلة الشائعة', NULL, 'faq', '<h2>الأسئلة الشائعة</h2><h3>ما هي مناطق التغطية؟</h3><p>نغطي جميع أحياء الرياض ونخدم المناطق المجاورة.</p><h3>هل تقدمون ضمان؟</h3><p>نعم، نقدم ضمان على جميع الأعمال يتراوح من 3 أشهر إلى سنة حسب نوع الخدمة.</p><h3>ما هي طرق الدفع؟</h3><p>نقبل الدفع نقداً، تحويل بنكي، مدى، أبل باي.</p><h3>هل تعملون في العطل؟</h3><p>نعم، نعمل 7 أيام في الأسبوع بما في ذلك العطل.</p>', NULL, 'أسئلة شائعة - الصيانة الذهبية', NULL, 'إجابات على أكثر الأسئلة شيوعاً', NULL, 'default', 0, 1, 6, 'published', '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(28, 9, 'مشاريعنا', NULL, 'projects', '<h2>مشاريعنا المميزة</h2><p>نفخر بأننا نفذنا أكثر من <strong>500 مشروع</strong> في جميع أنحاء المملكة:</p><div class=\"row\"><div class=\"col-md-6\"><h3>فلل سكنية</h3><p>أكثر من 200 فيلا بتصاميم فاخرة</p></div><div class=\"col-md-6\"><h3>شقق فندقية</h3><p>تشطيبات بمعايير خمس نجوم</p></div></div><div class=\"row\"><div class=\"col-md-6\"><h3>مكاتب وشركات</h3><p>تصاميم مهنية عصرية</p></div><div class=\"col-md-6\"><h3>محلات تجارية</h3><p>واجهات جذابة وتصاميم عملية</p></div></div>', NULL, 'مشاريع أناقة الديكور', NULL, 'استعرض أحدث مشاريعنا في التصميم الداخلي', NULL, 'default', 0, 1, 5, 'published', '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(29, 9, 'عملية العمل', NULL, 'process', '<h2>كيف نعمل؟</h2><ol><li><strong>الاستشارة المجانية</strong> - نستمع لرؤيتك ومتطلباتك</li><li><strong>التصميم 3D</strong> - نقدم لك تصور واقعي للمشروع</li><li><strong>الموافقة والميزانية</strong> - نتفق على التفاصيل والتكلفة</li><li><strong>التنفيذ</strong> - فريقنا يبدأ العمل بجدول زمني محدد</li><li><strong>التسليم</strong> - نسلمك المشروع جاهزاً مع الضمان</li></ol>', NULL, 'عملية العمل - أناقة الديكور', NULL, 'تعرف على خطوات تنفيذ مشروعك معنا', NULL, 'default', 0, 1, 6, 'published', '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(30, 7, 'الرئيسية', NULL, 'الرئيسية-1', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 1, 'published', '2026-03-16 19:39:33', '2026-03-16 19:39:33'),
(31, 10, 'الرئيسية', NULL, 'الرئيسية-2', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 1, 'published', '2026-03-17 09:21:53', '2026-03-17 09:21:53'),
(32, 8, 'الرئيسية', NULL, 'الرئيسية-3', '', NULL, NULL, NULL, NULL, NULL, 'default', 1, 0, 1, 'published', '2026-03-17 09:24:03', '2026-03-17 09:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE `page_views` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `view_date` date NOT NULL,
  `views` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `unique_visitors` int(11) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paid_services`
--

CREATE TABLE `paid_services` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paid_services`
--

INSERT INTO `paid_services` (`id`, `title`, `slug`, `description`, `price`, `currency`, `icon`, `category`, `payment_link`, `is_recurring`, `recurring_period`, `is_active`, `sort_order`, `max_quantity`, `requires_approval`, `created_at`, `updated_at`) VALUES
(1, 'نطاق مخصص (دومين)', 'custom-domain', 'احصل على دومين مخصص لموقعك بدلاً من النطاق الفرعي المجاني. يشمل إعداد DNS وربط الموقع.', 50.00, 'SAR', 'fa-globe', 'domains', 'https://inmotionhosting.com', 1, 'yearly', 1, 1, 1, 1, '2026-04-09 20:27:06', '2026-04-09 20:43:56'),
(2, 'شهادة SSL', 'ssl-certificate', 'تشفير موقعك بشهادة SSL لتحسين الأمان والحصول على HTTPS.', 30.00, 'SAR', 'fa-shield-alt', 'domains', NULL, 1, 'yearly', 1, 2, 1, 0, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(3, 'إضافة لغة ثانية', 'extra-language', 'إضافة لغة ثانية لموقعك (عربي/إنجليزي) مع زر تبديل اللغات في الموقع.', 100.00, 'SAR', 'fa-language', 'features', NULL, 0, 'onetime', 1, 3, 1, 1, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(4, 'حملة تسويقية', 'marketing-campaign', 'إدارة حملة تسويقية شاملة لموقعك تشمل إعداد الإعلانات وتحسين الظهور في محركات البحث.', 200.00, 'SAR', 'fa-bullhorn', 'marketing', NULL, 0, 'onetime', 1, 4, 3, 1, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(5, 'كتابة محتوى احترافي', 'content-writing', 'كتابة محتوى احترافي لجميع صفحات موقعك بما يتوافق مع معايير SEO.', 150.00, 'SAR', 'fa-pen-fancy', 'content', NULL, 0, 'onetime', 1, 5, 5, 1, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(6, 'تحسين SEO المتقدم', 'advanced-seo', 'تحسين متقدم لمحركات البحث يشمل تحليل الكلمات المفتاحية وتهيئة الصفحات.', 80.00, 'SAR', 'fa-search', 'marketing', NULL, 0, 'onetime', 1, 6, 2, 0, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(7, 'تصميم شعار احترافي', 'logo-design', 'تصميم شعار احترافي فريد لموقعك بأعلى جودة.', 120.00, 'SAR', 'fa-paint-brush', 'design', NULL, 0, 'onetime', 1, 7, 1, 1, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(8, 'كشف إحصائيات متقدم', 'advanced-analytics', 'لوحة إحصائيات متقدمة تعرض تفاصيل الزوار والصفحات ومصادر الزيارات.', 60.00, 'SAR', 'fa-chart-line', 'features', NULL, 1, 'monthly', 1, 8, 1, 0, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(9, 'إزالة علامة التجارة', 'remove-branding', 'إزالة شعار المنصة و\"مدعوم بواسطة\" من موقعك.', 40.00, 'SAR', 'fa-eye-slash', 'features', NULL, 1, 'monthly', 1, 9, 1, 0, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(10, 'نسخة احتياطية يومية', 'daily-backup', 'نسخ احتياطية يومية لموقعك مع إمكانية الاستعادة في أي وقت.', 20.00, 'SAR', 'fa-database', 'features', NULL, 1, 'monthly', 1, 10, 1, 0, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(11, 'دعم فني أولوية 24/7', 'priority-support', 'دعم فني على مدار الساعة مع استجابة سريعة وأولوية في معالجة المشاكل.', 100.00, 'SAR', 'fa-headset', 'support', NULL, 1, 'monthly', 1, 11, 1, 0, '2026-04-09 20:27:06', '2026-04-09 20:27:06'),
(12, 'زيادة مساحة التخزين', 'extra-storage', 'زيادة مساحة تخزين الملفات والصور على موقعك.', 30.00, 'SAR', 'fa-hdd', 'features', NULL, 1, 'monthly', 1, 12, 10, 0, '2026-04-09 20:27:06', '2026-04-09 20:27:06');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'اسم الشريك بالعربية',
  `name_en` varchar(255) DEFAULT NULL COMMENT 'اسم الشريك بالإنجليزية',
  `logo` varchar(500) DEFAULT NULL COMMENT 'مسار شعار الشريك',
  `link` varchar(500) DEFAULT NULL COMMENT 'رابط موقع الشريك',
  `sort_order` int(11) DEFAULT 0 COMMENT 'ترتيب العرض',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'مفعل/معطل',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platform_blog_posts`
--

CREATE TABLE `platform_blog_posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `author_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `views` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platform_blog_posts`
--

INSERT INTO `platform_blog_posts` (`id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `category`, `tags`, `meta_title`, `meta_description`, `status`, `views`, `published_at`, `created_at`, `updated_at`) VALUES
(6, NULL, 'أهمية تصميم المواقع الإلكترونية لنجاح أعمالك في 2025', 'importance-of-web-design-for-business-success', 'اكتشف لماذا يعتبر تصميم الموقع الإلكتروني استثماراً حاسماً لنجاح أي مشروع تجاري في العصر الرقمي، وكيف يؤثر على مصداقية علامتك التجارية وزيادة مبيعاتك.', '<h2>لماذا الموقع الإلكتروني هو واجهة أعمالك الرقمية؟</h2>\r\n\r\n<p>في عالم أصبحت فيه الإنترنت هي السوق الأول للبحث عن الخدمات والمنتجات، لم يعد امتلاك موقع إلكتروني مجرد خيار ترفيهي، بل أصبح ضرورة حتمية لكل مشروع يسعى للنمو والاستمرار. فالموقع الإلكتروني هو الانطباع الأول الذي يأخذه العميل المحتمل عن علامتك التجارية، وهو الوسيط الذي يعمل على مدار الساعة دون توقف لتقديم خدماتك للعملاء في كل أنحاء العالم. الدراسات الحديثة تؤكد أن أكثر من 75٪ من المستهلكين يحكمون على مصداقية الشركة من خلال تصميم موقعها الإلكتروني، مما يجعل الاستثمار في تصميم احترافي أمراً لا غنى عنه.</p>\r\n\r\n<h2>المصداقية والثقة هما الأساس</h2>\r\n\r\n<p>عندما يبحث عميل محتمل عن خدمة معينة ويجد موقعك الإلكتروني، فإن التصميم هو أول ما يلفت انتباهه. موقع بتصميم عصري ومنظم يبعث رسالة فورية بالاحترافية والجودة، بينما الموقع المشتت أو البطيء يدفع الزائر إلى مغادرة الصفحة خلال ثوانٍ معدودة. تُظهر الإحصائيات أن مستخدمي الإنترنت يتخذون قراراً بشأن مصداقية الموقع خلال أول 50 مليثانية من التصفح. هذا يعني أن التصميم البصري، والألوان المستخدمة، وتوزيع المحتوى، وسهولة التصفح، كلها عناصر تؤثر بشكل مباشر على قرار الزائر بالبقاء أو المغادرة.</p>\r\n\r\n<h2>تحسين تجربة المستخدم يعني زيادة التحويلات</h2>\r\n\r\n<p>تجربة المستخدم أو ما يُعرف بـ UX هي العامل الحاسم الذي يحول الزائر إلى عميل فعلي. الموقع المصمم بشكل جيد يسهّل على الزائر إيجاد ما يبحث عنه بسرعة وسلاسة، سواء كان ذلك معلومات عن منتج، أو نموذج تواصل، أو زر شراء. المواقع التي تهتم بتجربة المستخدم تشهد معدلات تحويل أعلى بنسبة تصل إلى 400٪ مقارنة بالمواقع التي تتجاهل هذا الجانب. يشمل ذلك سرعة تحميل الصفحات، والتوافق مع الأجهزة المحمولة، والتنقل السلس بين الصفحات، ووجود مكالمات واضحة للعمل Call to Action توجه الزائر نحو الخطوة التالية.</p>\r\n\r\n<h2>التوافق مع محركات البحث SEO</h2>\r\n\r\n<p>تصميم الموقع لا يقتصر على الجانب الجمالي فقط، بل يمتد ليشمل البنية التقنية التي تساعد محركات البحث مثل جوجل على فهرسة موقعك بشكل صحيح. الموقع المصمم وفق معايير SEO يتمتع ببنية عنوانية واضحة، وسرعة تحميل عالية، وتوافق كامل مع الأجهزة المحمولة، وهي جميعها عوامل يأخذها محرك بحث جوجل في الاعتبار عند ترتيب النتائج. الموقع المتوافق مع SEO يضمن ظهورك في النتائج الأولى عندما يبحث العملاء المحتملون عن الخدمات التي تقدمها، مما يزيد من حركة المرور العضوية ويقلل الحاجة إلى الإنفاق على الإعلانات المدفوعة.</p>\r\n\r\n<h2>كيف تساعدك منصة تكوين في إنشاء موقع احترافي؟</h2>\r\n\r\n<p>إذا كنت تعتقد أن إنشاء موقع إلكتروني احترافي يتطلب ميزانية ضخمة ومعرفة تقنية متعمقة، فمنصة <strong>تكوين</strong> هنا لتغير هذه القناعة تماماً. توفر منصة تكوين حلولاً مجانية لإنشاء مواقع إلكترونية احترافية دون الحاجة إلى كتابة أي سطر كود. تتميز المنصة بتوفير قوالب تصميمية عصرية ومتجاوبة مع جميع الأجهزة، مع إمكانية تخصيص الألوان والخطوط والصور لتناسب هوية علامتك التجارية. كما تقدم أدوات سهلة لإدارة المحتوى والمدونة والمعرض الصوري ونماذج التواصل، مما يتيح لك بناء وتشغيل موقعك بالكامل من لوحة تحكم بسيطة وحدائق.</p>\r\n\r\n<h2>خلاصة</h2>\r\n\r\n<p>استثمارك في تصميم موقع إلكتروني احترافي ليس مصروفاً، بل هو رأسمال يعمل على مدار الساعة لتعزيز حضورك الرقمي وجذب عملاء جدد. سواء كنت صاحب مشروع صغير أو شركة متوسطة أو مؤسسة كبيرة، فإن الإنترنت يمنحك فرصة متساوية للوصول إلى جمهورك المستهدف. ابدأ اليوم بإنشاء موقعك مجاناً عبر منصة تكوين وانطلق في رحلتك الرقمية بثقة واحترافية.</p>', NULL, 'تصميم مواقع', 'تصميم مواقع, إنشاء موقع, تطوير ويب, تكوين, SEO, تجربة مستخدم', 'أهمية تصميم المواقع الإلكترونية لنجاح أعمالك', 'تعرف على أهمية تصميم المواقع الإلكترونية لنجاح مشروعك وكيف يؤثر التصميم على مصداقية علامتك التجارية وزيادة مبيعاتك', 'published', 0, '2026-05-11 03:07:08', '2026-05-11 03:07:08', '2026-05-11 03:07:08'),
(7, NULL, 'كيف تصمم موقع احترافي مجاناً خطوة بخطوة', 'how-to-design-professional-website-free-step-by-step', 'دليل شامل خطوة بخطوة لتصميم وإنشاء موقع إلكتروني احترافي مجاناً باستخدام منصة تكوين، دون الحاجة لأي خبرة تقنية سابقة.', '<h2>الخطوة الأولى: حدد هدف موقعك وجمهورك المستهدف</h2>\r\n\r\n<p>قبل أن تبدأ في تصميم أي موقع إلكتروني، يجب أن تجيب على سؤالين أساسيين: ما هو الهدف من هذا الموقع؟ ومن هو الجمهور المستهدف؟ الهدف قد يكون عرض خدماتك، أو بيع منتجات، أو بناء علامة شخصية، أو نشر المحتوى التعليمي. أما الجمهور المستهدف فهو الفئة التي ترغب في الوصول إليها. تحديد هذين العنصرين بدقة سيساعدك على اتخاذ القرارات الصحيحة في كل خطوة لاحقة، من اختيار القالب المناسب إلى كتابة المحتوى الذي يجذب زوارك.</p>\r\n\r\n<h2>الخطوة الثانية: اختر القالب المناسب لمشروعك</h2>\r\n\r\n<p>القالب هو الهيكل التصميمي الذي يحدد شكل ومظهر موقعك. منصة تكوين توفر مجموعة متنوعة من القوالب الاحترافية المصممة خصيصاً لمجالات مختلفة مثل الشركات، والمتاجر، والم portfolios، والمدونات، والخدمات المهنية. عند اختيار القالب، انتبه إلى أن يكون متجاوباً مع الأجهزة المحمولة، وسريع التحميل، وأن يدعم التخصيص الكامل للألوان والخطوط والتخطيطات. الأفضل أن تختار قالباً قريباً من رؤيتك النهائية لتقليل التعديلات المطلوبة لاحقاً.</p>\r\n\r\n<h2>الخطوة الثالثة: خصّص الهوية البصرية لموقعك</h2>\r\n\r\n<p>الهوية البصرية هي ما يميز موقعك عن غيره ويجعله memorable في ذهن الزائر. تبدأ الهوية باختيار لوحة ألوان متناسقة تعكس طبيعة نشاطك. على سبيل المثال، الألوان الزرقاء تبعث على الثقة والاحترافية وتناسب الشركات التقنية والمصرفية، بينما الألوان الدافئة كالبرتقالي والأحمر تناسب المطاعم والمتاجر. بعد الألوان، اختر خطوطاً واضحة وسهلة القراءة، ثم ارفع شعار علامتك التجارية. منصة تكوين تتيح لك تخصيص كل هذه العناصر بسهولة من خلال لوحة تحكم بديهية دون الحاجة لأي معرفة بالتصميم.</p>\r\n\r\n<h2>الخطوة الرابعة: أنشئ الصفحات الأساسية</h2>\r\n\r\n<p>كل موقع احترافي يحتاج إلى مجموعة من الصفحات الأساسية التي لا غنى عنها. الصفحة الرئيسية هي واجهة موقعك وتجمع أبرز ما تقدمه بطريقة جذابة. صفحة من نحن تروي قصة علامتك وتبني الثقة مع الزوار. صفحة الخدمات أو المنتجات تعرض ما تقدمه بالتفصيل. صفحة المدونة تنشر محتوى مفيداً يجذب زواراً جدداً من محركات البحث. صفحة اتصل بنا توفر وسائل تواصل متعددة. منصة تكوين تتيح لك إنشاء جميع هذه الصفحات بسحب وإفلات العناصر وترتيبها كما تريد، مع إمكانية إضافة أقسام البانرات والمعارض والشهادات والأسئلة الشائعة والمزيد.</p>\r\n\r\n<h2>الخطوة الخامسة: أضف محتوى قيماً ومتوافقاً مع SEO</h2>\r\n\r\n<p>المحتوى هو ملك الإنترنت، وهو العامل الأهم في جذب الزوار والحفاظ عليهم. اكتب محتوى واضحاً ومفيداً يعالج احتياجات جمهورك المستهدف. استخدم العناوين الفرعية لتقسيم المحتوى، وأضف صوراً عالية الجودة تعزز الرسالة المراد إيصالها. لا تنسَ تحسين المحتوى لمحركات البحث من خلال استخدام الكلمات المفتاحية بشكل طبيعي، وكتابة عناوين صفحات جذابة، وإضافة وصف meta لكل صفحة. منصة تكوين توفر أدوات SEO مدمجة تساعدك في تحسين ظهور موقعك في نتائج البحث دون الحاجة لخبرة تقنية.</p>\r\n\r\n<h2>الخطوة السادسة: اختبر موقعك وابدأ بالنشر</h2>\r\n\r\n<p>قبل نشر موقعك، اختبره على مختلف الأجهزة والمتصفحات للتأكد من ظهوره بشكل مثالي. تحقق من سرعة التحميل، واختبر جميع الروابط والأزرار، وتأكد من أن النماذج تعمل بشكل صحيح. بعد التأكد من كل شيء، اضغط على زر النشر واجعل موقعك متاحاً للعالم. مع منصة تكوين، يمكنك إنشاء ونشر موقعك الإلكتروني احترافياً مجاناً خلال دقائق معدودة، والبدء في بناء حضورك الرقمي فوراً دون أي تكاليف.</p>\r\n\r\n<h2>نصائح إضافية للنجاح</h2>\r\n\r\n<p>بعد نشر الموقع، استمر في تحديث المحتوى بشكل دوري، وراقب إحصائيات الزوار لفهم سلوك جمهورك، واستجب لتعليقات واستفسارات الزوار بسرعة. تذكر أن الموقع الإلكتروني ليس مشروعاً لمرة واحدة، بل هو كائن حي يحتاج إلى رعاية وتطوير مستمر. ابدأ رحلتك الرقمية اليوم مجاناً مع منصة تكوين واكتشف الإمكانيات اللامحدودة التي تنتظرك.</p>', NULL, 'دليل تصميم', 'تصميم موقع مجاني, إنشاء موقع, تكوين, خطوات تصميم, قوالب مواقع, SEO', 'كيف تصمم موقع احترافي مجاناً خطوة بخطوة', 'دليل عملي خطوة بخطوة لتصميم موقع إلكتروني احترافي مجاناً بدون خبرة تقنية باستخدام منصة تكوين', 'published', 0, '2026-05-11 03:07:08', '2026-05-11 03:07:08', '2026-05-11 03:07:08'),
(8, NULL, 'لماذا تحتاج موقع إلكتروني في 2025؟ 8 أسباب لا يمكنك تجاهلها', 'why-you-need-a-website-in-2025', 'اكتشف 8 أسباب قوية تجعل امتلاك موقع إلكتروني أمراً ضرورياً في 2025، وكيف يمكنك البدء مجاناً مع منصة تكوين لإنشاء موقعك الاحترافي.', '<h2>1. الإنترنت هو المتجر الأول للعالم</h2>\r\n\r\n<p>في عام 2025، يتجاوز عدد مستخدمي الإنترنت globally حاجز 5.5 مليار مستخدم، أي ما يقارب ثلثي سكان العالم. هؤلاء المستخدمون يعتمدون على الإنترنت في كل جوانب حياتهم اليومية، من البحث عن المعلومات والتواصل الاجتماعي إلى التسوق والتعليم والعمل. إذا لم يكن لديك موقع إلكتروني، فأنت ببساطة غير موجود في أكبر سوق عالمي. الموقع الإلكتروني يمنحك نافذة رقمية يعثر عليها العملاء المحتملون في أي وقت ومن أي مكان، سواء كانوا يبحثون في جوجل أو يتصفحون وسائل التواصل الاجتماعي أو يتلقون توصيات من أصدقائهم.</p>\r\n\r\n<h2>2. الثقة والمصداقية الرقمية</h2>\r\n\r\n<p>في العصر الرقمي، لا يكفي أن تكون جيداً في ما تقدمه، بل يجب أن تبدو جيداً أيضاً. الموقع الإلكتروني الاحترافي يعمل كشهادة مصداقية رقمية تؤكد للعملاء أنك مشروع حقيقي وجاد. الدراسات تُظهر أن 84٪ من المستهلكين يعتقدون أن الشركة التي تمتلك موقعاً إلكترونياً أكثر مصداقية من تلك التي لا تمتلك موقعاً. حتى لو كنت تعتمد على وسائل التواصل الاجتماعي فقط، فإن وجود موقع إلكتروني يعزز ثقة العملاء ويعطي انطباعاً بأنك مؤسسة راسخة وليس مجرد حساب عابر.</p>\r\n\r\n<h2>3. التواجد على مدار الساعة 24/7</h2>\r\n\r\n<p>أحد أعظم مزايا الموقع الإلكتروني أنه يعمل نيابة عنك على مدار الساعة، 7 أيام في الأسبوع، 365 يوماً في السنة. بينما المتجر التقليدي يغلق أبوابه في نهاية يوم العمل، يبقى موقعك متاحاً لاستقبال الزوار وتقديم المعلومات ومعالجة الطلبات في أي وقت. هذا يعني أن عميلاً من دولة أخرى في منطقة زمنية مختلفة يمكنه تصفح خدماتك والتواصل معك حتى وأنت نائم. هذه المتاحة المستمرة تضاعف فرص الحصول على عملاء جدد بشكل كبير.</p>\r\n\r\n<h2>4. الوصول إلى سوق أوسع</h2>\r\n\r\n<p>الموقع الإلكتروني يحطم الحدود الجغرافية التي تقيد الأعمال التقليدية. بدلاً من الاعتماد على المارة في شارعك أو سكان مدينتك، يمكنك الوصول إلى جمهور في كل أنحاء العالم. هذا ينطبق بشكل خاص على المشاريع التي تقدم خدمات رقمية أو منتجات قابلة للشحن. حتى المشاريع المحلية كالمطاعم والعيادات والصالونات تستفيد من الموقع الإلكتروني من خلال جذب العملاء من المناطق المجاورة الذين يبحثون عن خدمات قريبة منهم عبر جوجل خرائط ومحركات البحث المحلية.</p>\r\n\r\n<h2>5. التسويق الرقمي الفعال من حيث التكلفة</h2>\r\n\r\n<p>مقارنة بأساليب التسويق التقليدية كالإعلانات المطبوعة واللوحات الإعلانية والإعلانات التلفزيونية، يوفر التسويق الرقمي عبر الموقع الإلكتروني عائداً أعلى على الاستثمار بجزء بسيط من التكلفة. من خلال تحسين محركات البحث SEO، يمكنك جذب زوار مجانيين وذوي جودة عالية من محركات البحث. كما يمكنك دمج الموقع مع حملات البريد الإلكتروني والتسويق عبر المحتوى والإعلانات المدفوعة المستهدفة لبناء استراتيجية تسويقية شاملة ومتكاملة.</p>\r\n\r\n<h2>6. جمع البيانات وفهم العملاء</h2>\r\n\r\n<p>الموقع الإلكتروني يمنحك أدوات قوية لفهم سلوك زوارك واحتياجاتهم. من خلال أدوات التحليلات، يمكنك معرفة من أين يأتي زوارك، وأي الصفحات يتصفحون أكثر، وكم الوقت يقضونه في موقعك، وأي المحتوى يجذب انتباههم. هذه البيانات الثمينة تساعدك على اتخاذ قرارات مبنية على الأدلة بدلاً من التخمين، وتحسين خدماتك ومنتجاتك بناءً على احتياجات عملائك الفعلية. فهم جمهورك هو مفتاح تقديم قيمة فريدة وبناء علاقات طويلة الأمد مع عملائك.</p>\r\n\r\n<h2>7. المنافسة مع الشركات الكبرى</h2>\r\n\r\n<p>الموقع الإلكتروني المصمم بشكل احترافي يمنحك فرصة متساوية للمنافسة مع الشركات الكبرى في السوق الرقمي. في العالم التقليدي، قد تتفوق الشركة الكبرى بموقعها الفاخر وميزانيتها الضخمة، لكن في العالم الرقمي، الموقع الجيد والمحسن لمحركات البحث يمكن أن يتفوق على مواقع الشركات الكبرى في نتائج البحث. منصة تكوين تمكّن أصحاب المشاريع الصغيرة والمتوسطة من إنشاء مواقع بجودة احترافية منافسة مجاناً، مما يقلل الفجوة بين المشاريع الناشئة والشركات الراسخة.</p>\r\n\r\n<h2>8. التحكم الكامل بعلامتك التجارية</h2>\r\n\r\n<p>عندما تعتمد فقط على منصات التواصل الاجتماعي، فإنك لا تملك المحتوى الذي تنشره ولا البيانات التي تجمعها، ويمكن أن تتغير سياسات المنصة أو حتى يتم إغلاق حسابك في أي لحظة. أما الموقع الإلكتروني الخاص بك فهو مساحة ملك لك بالكامل، تتحكم فيها بكل التفاصيل من التصميم والمحتوى إلى البيانات والسياسات. هذا الاستقلال الرقمي يمنحك أماناً واستقراراً لا توفره أي منصة خارجية.</p>\r\n\r\n<h2>ابدأ مجاناً مع منصة تكوين</h2>\r\n\r\n<p>لا داعي لتأجيل إنشاء موقعك الإلكتروني بسبب التكاليف أو التعقيد التقني. منصة <strong>تكوين</strong> تتيح لك إنشاء موقع احترافي متكامل مجاناً خلال دقائق. مع قوالب عصرية جاهزة، وأدوات تخصيص سهلة، واستضافة مجانية، وميزات احترافية كاملة، كل ما عليك فعله هو التسجيل واختيار القالب المناسب والبدء ببناء موقعك. انضم إلى آلاف المستخدمين الذين وثقوا بمنصة تكوين لبناء حضورهم الرقمي وابدأ رحلتك اليوم.</p>', NULL, 'تسويق رقمي', 'موقع إلكتروني, 2025, إنشاء موقع مجاني, تكوين, تسويق رقمي, SEO, حضور رقمي', 'لماذا تحتاج موقع إلكتروني في 2025 - 8 أسباب ضرورية', '8 أسباب قوية تجعل امتلاك موقع إلكتروني ضرورياً في 2025 مع شرح كيفية إنشاء موقع مجاني عبر منصة تكوين', 'published', 0, '2026-05-11 03:07:08', '2026-05-11 03:07:08', '2026-05-11 03:07:08'),
(9, NULL, 'مقارنة شاملة: أفضل منصات إنشاء المواقع الإلكترونية في 2025', 'best-website-builders-comparison-2025', 'مقارنة مفصلة بين أبرز منصات إنشاء المواقع مثل ووردبريس وويكس وشوبيفاي وتكوين، لمعرفة أيها الأنسب لاحتياجاتك وميزانيتك.', '<h2>مقدمة: لماذا تحتاج لاختيار المنصة المناسبة؟</h2>\r\n\r\n<p>اختيار منصة إنشاء المواقع المناسبة هو أحد أهم القرارات التي ستتخذها عند بناء حضورك الرقمي. المنصة الخاطئة قد تكلفك الوقت والمال والإحباط، بينما المنصة المناسبة تجعل عملية بناء وإدارة موقعك متعة حقيقية. في هذه المقارنة الشاملة، سنستعرض أبرز المنصات المتاحة في السوق مع نقاط القوة والضعف لكل منها، مع تسليط الضوء على منصة <strong>تكوين</strong> كخيار مجاني واعداً للمشاريع العربية.</p>\r\n\r\n<h2>1. ووردبريس WordPress</h2>\r\n\r\n<p><strong>نقاط القوة:</strong></p>\r\n<p>ووردبريس هو أقدم وأشهر منصة إنشاء مواقع في العالم، حيث يشغل أكثر من 43٪ من مواقع الإنترنت globally. يتميز بمرونة هائلة بفضل آلاف القوالب والإضافات المتاحة، ويدعم جميع أنواع المواقع من المدونات البسيطة إلى المتاجر الكبرى. يوفر تحكماً كاملاً في الكود والتصميم للمستخدمين المتقدمين.</p>\r\n\r\n<p><strong>نقاط الضعف:</strong></p>\r\n<p>ووردبريس يتطلب معرفة تقنية لا بأس بها، خاصة فيما يتعلق بالاستضافة وإدارة السيرفر وتحديثات الأمان. الإضافات قد تتعارض مع بعضها وتسبب بطء الموقع. كما أن التكلفة الفعلية قد تكون مرتفعة عند احتساب سعر الاستضافة والقوالب المميزة والإضافات المدفوعة. الدعم التقني ليس مركزياً بل يعتمد على مجتمع المستخدمين ومطوري الإضافات.</p>\r\n\r\n<h2>2. ويمكس Wix</h2>\r\n\r\n<p><strong>نقاط القوة:</strong></p>\r\n<p>ويمكس منصة سحابية سهلة الاستخدام تعتمد على نظام السحب والإفلات. توفر واجهة بصرية بسيطة تجعل تصميم الموقع ممتعاً حتى للمبتدئين. تقدم قوالب جذابة ومتنوعة مع إمكانية التخصيص الكامل. تتضمن استضافة مجانية ونطاق فرعي مجاني في الباقة الأساسية.</p>\r\n\r\n<p><strong>نقاط الضعف:</strong></p>\r\n<p>الباقة المجانية تعرض إعلانات ويمكس على موقعك وتستخدم نطاقاً فرعياً. سرعة تحميل المواقع على ويمكس أبطأ مقارنة بالمنصات الأخرى بسبب الكود الثقيل. النسخة المجانية محدودة جداً في المميزات، والباقات المدفوعة تبدأ من أسعار مرتفعة نسبياً. لا يمكنك نقل موقعك بسهولة إلى منصة أخرى إذا قررت المغادرة.</p>\r\n\r\n<h2>3. شوبيفاي Shopify</h2>\r\n\r\n<p><strong>نقاط القوة:</strong></p>\r\n<p>شوبيفاي هو الحل الأمثل للمتاجر الإلكترونية بلا منازع. يوفر كل ما تحتاجه لبيع المنتجات عبر الإنترنت من بوابة دفع متكاملة وإدارة مخزون وشحن إلى تحليلات المبيعات. يتميز بأمان عالي واستقرار ممتاز وقدرة على التعامل مع أحجام مبيعات كبيرة. واجهته سهلة حتى لمن ليس لديهم خبرة تقنية.</p>\r\n\r\n<p><strong>نقاط الضعف:</strong></p>\r\n<p>شوبيفاي مخصص للمتاجر الإلكترونية فقط، وليس خياراً جيداً للمواقع الأخرى. الاشتراك الشهري مكلف نسبياً ويبدأ من حدود معينة، بالإضافة إلى رسوم على كل معاملة. التخصيص محدود مقارنة بووردبريس، والقوالب المدفوعة غالية الثمن. أنت مقيد بنظام شوبيفاي البيئي ولا تستطيع تغيير الاستضافة أو إضافة أكواد خارجية بحرية.</p>\r\n\r\n<h2>4. منصة تكوين TakweenWeb</h2>\r\n\r\n<p><strong>نقاط القوة:</strong></p>\r\n<p>منصة تكوين هي الحل العربي الأول المتكامل لإنشاء مواقع إلكترونية احترافية مجاناً. تتميز بعدة مزايا فريدة تجعلها الخيار المثالي للمشاريع العربية:</p>\r\n\r\n<p><strong>مجانية بالكامل:</strong> يمكنك إنشاء موقعك واستضافته مجاناً دون أي تكاليف مخفية. لا حاجة للدفع مقابل القوالب أو الاستضافة أو النطاق الفرعي. هذا يجعل تكوين الخيار الأمثل للمشاريع الناشئة والميزانيات المحدودة.</p>\r\n\r\n<p><strong>واجهة عربية بالكامل:</strong> على عكس المنصات الأجنبية التي تترجم واجهتها بشكل جزئي إلى العربية، منصة تكوين مبنية من الأساس باللغة العربية مع دعم كامل لاتجاه RTL. كل شيء من لوحة التحكم إلى القوالب والأدوات مصمم بالعربية لتجربة مستخدم سلسة وطبيعية.</p>\r\n\r\n<p><strong>قوالب احترافية ومتجاوبة:</strong> توفر المنصة مجموعة قوالب عصرية مصممة خصيصاً للسوق العربي، مع توافق كامل مع الأجهزة المحمولة وتحسين لمحركات البحث العربية.</p>\r\n\r\n<p><strong>أدوات إدارة متكاملة:</strong> من لوحة تحكم واحدة، يمكنك إدارة كل شيء: الصفحات، والمدونة، والمعرض، والخدمات، ونماذج التواصل، والإعدادات، وSEO، والإحصائيات. كل شيء مدمج ومتاح دون الحاجة لإضافات خارجية.</p>\r\n\r\n<p><strong>دعم فني عربي:</strong> فريق الدعم الفني متوفر باللغة العربية لمساعدتك في أي استفسار أو مشكلة تقنية، مما يوفر عليك عناء البحث عن حلول بلغة أجنبية.</p>\r\n\r\n<p><strong>تحديثات مستمرة:</strong> فريق تطوير منصة تكوين يعمل على مدار الساعة لإضافة قوالب وميزات جديدة بشكل دوري، مما يعني أن المنصة تتطور وتتحسن باستمرار لتلبية احتياجات المستخدمين المتغيرة. كل تحديث يجلب معه تحسينات في الأداء والأمان وتجربة المستخدم، مما يجعل تكوين منصة تنمو مع نمو مشروعك.</p>\r\n\r\n<h2>جدول مقارنة سريع</h2>\r\n\r\n<p><strong>التكلفة:</strong> تكوين مجاني بالكامل / ووردبريس يحتاج استضافة / ويمكس مجاني محدود / شوبيفاي مدفوع<br>\r\n<strong>سهولة الاستخدام:</strong> تكوين سهل جداً / ويمكس سهل / شوبيفاي سهل / ووردبريس يحتاج خبرة<br>\r\n<strong>الدعم العربي:</strong> تكوين دعم كامل / البقية دعم محدود أو مترجم<br>\r\n<strong>التخصيص:</strong> ووردبريس الأعلى / ثم تكوين وويمكس / شوبيفاي محدود<br>\r\n<strong>الملاءمة للسوق العربي:</strong> تكوين الأنسب / البقية عامة</p>\r\n\r\n<h2>الخلاصة: لماذا تكوين هي الأفضل؟</h2>\r\n\r\n<p>بعد هذه المقارنة، يتضح أن منصة <strong>تكوين</strong> تتفوق على جميع المنافسين من حيث التكلفة (مجانية بالكامل)، وسهولة الاستخدام (واجهة عربية بديهية)، والدعم (فريق عربي متخصص)، والملاءمة للسوق العربي (تصميم مخصص بالعربية مع دعم RTL كامل). بينما المنصات الأخرى إما مكلفة أو معقدة أو لا تدعم العربية بشكل حقيقي، توفر تكوين حلاً متكاملاً ومجانياً يجمع بين الاحترافية والبساطة. لا تضيع وقتك وميزانيتك مع منصات لا تناسب احتياجاتك - سجّل مجاناً في منصة تكوين الآن وابدأ ببناء موقعك الاحترافي خلال دقائق.</p>', NULL, 'مقارنات', 'مقارنة منصات, ووردبريس, ويمكس, شوبيفاي, تكوين, إنشاء موقع مجاني, أفضل منصة', 'مقارنة أفضل منصات إنشاء المواقع 2025 - تكوين vs ووردبريس vs ويمكس', 'مقارنة شاملة بين ووردبريس وويكس وشوبيفاي ومنصة تكوين لإنشاء المواقع. اكتشف أي منصة تناسب مشروعك مع مميزات تكوين المجانية', 'published', 0, '2026-05-11 03:07:08', '2026-05-11 03:07:08', '2026-05-11 03:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `sections_config`
--

CREATE TABLE `sections_config` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `section_key` varchar(50) NOT NULL COMMENT 'hero, services, about, why_us, testimonials, gallery, faq, contact, booking, partners',
  `section_label_ar` varchar(100) NOT NULL,
  `section_label_en` varchar(100) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `section_icon` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections_config`
--

INSERT INTO `sections_config` (`id`, `tenant_id`, `section_key`, `section_label_ar`, `section_label_en`, `is_enabled`, `display_order`, `section_icon`, `created_at`, `updated_at`) VALUES
(1, 1, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(2, 1, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(3, 1, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(4, 1, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(5, 1, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(6, 1, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(7, 1, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(8, 1, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(9, 1, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(10, 1, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(11, 2, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(12, 2, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(13, 2, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(14, 2, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(15, 2, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(16, 2, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(17, 2, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(18, 2, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(19, 2, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(20, 2, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(21, 3, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(22, 3, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(23, 3, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(24, 3, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(25, 3, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(26, 3, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(27, 3, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(28, 3, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(29, 3, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(30, 3, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(31, 4, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(32, 4, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(33, 4, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(34, 4, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(35, 4, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(36, 4, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(37, 4, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(38, 4, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(39, 4, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(40, 4, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(41, 5, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(42, 5, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(43, 5, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(44, 5, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(45, 5, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(46, 5, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(47, 5, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(48, 5, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(49, 5, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(50, 5, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(51, 8, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(52, 8, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(53, 8, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(54, 8, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(55, 8, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(56, 8, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(57, 8, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(58, 8, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(59, 8, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(60, 8, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(61, 11, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(62, 11, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(63, 11, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(64, 11, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(65, 11, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(66, 11, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(67, 11, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(68, 11, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(69, 11, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(70, 11, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(71, 6, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(72, 6, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(73, 6, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(74, 6, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(75, 6, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(76, 6, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(77, 6, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(78, 6, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(79, 6, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(80, 6, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(81, 7, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(82, 7, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(83, 7, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(84, 7, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(85, 7, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(86, 7, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(87, 7, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(88, 7, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(89, 7, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(90, 7, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(91, 9, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(92, 9, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(93, 9, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(94, 9, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(95, 9, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(96, 9, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(97, 9, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(98, 9, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(99, 9, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(100, 9, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(101, 10, 'hero', 'القسم الرئيسي (Hero)', 'Hero Section', 1, 1, 'fas fa-home', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(102, 10, 'services', 'خدماتنا', 'Our Services', 1, 2, 'fas fa-concierge-bell', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(103, 10, 'about', 'من نحن', 'About Us', 1, 3, 'fas fa-building', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(104, 10, 'why_us', 'لماذا نحن', 'Why Choose Us', 1, 4, 'fas fa-star', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(105, 10, 'testimonials', 'آراء العملاء', 'Testimonials', 1, 5, 'fas fa-comments', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(106, 10, 'gallery', 'معرض الأعمال', 'Gallery', 1, 6, 'fas fa-images', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(107, 10, 'faq', 'الأسئلة الشائعة', 'FAQ', 1, 7, 'fas fa-question-circle', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(108, 10, 'contact', 'اتصل بنا', 'Contact Us', 1, 8, 'fas fa-envelope', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(109, 10, 'booking', 'حجز موعد', 'Book Appointment', 1, 9, 'fas fa-calendar-check', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(110, 10, 'partners', 'شركاؤنا', 'Our Partners', 1, 10, 'fas fa-handshake', '2026-04-12 00:59:54', '2026-04-12 00:59:54'),
(128, 1, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(129, 2, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(130, 3, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(131, 4, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(132, 5, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(133, 8, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(134, 11, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(135, 6, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(136, 7, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(137, 9, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16'),
(138, 10, 'stats', 'شريط الإحصائيات', 'Statistics Bar', 1, 11, 'fas fa-chart-bar', '2026-04-12 11:15:16', '2026-04-12 11:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

CREATE TABLE `seo_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `google_analytics_id` varchar(50) DEFAULT NULL,
  `google_tag_manager_id` varchar(50) DEFAULT NULL,
  `facebook_pixel_id` varchar(100) DEFAULT NULL,
  `google_site_verification` varchar(255) DEFAULT NULL,
  `bing_site_verification` varchar(255) DEFAULT NULL,
  `robots_txt` text DEFAULT NULL,
  `schema_org` text DEFAULT NULL COMMENT 'JSON-LD schema',
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `twitter_card_type` enum('summary','summary_large_image') DEFAULT 'summary_large_image',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `tenant_id`, `google_analytics_id`, `google_tag_manager_id`, `facebook_pixel_id`, `google_site_verification`, `bing_site_verification`, `robots_txt`, `schema_org`, `canonical_url`, `og_image`, `twitter_card_type`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'summary_large_image', '2026-03-16 19:00:41', '2026-03-16 19:00:41'),
(2, 6, 'G-XXXXXX001', 'GTM-XXXX01', '123456789012345', NULL, NULL, NULL, NULL, 'https://golden-maintenance.com', NULL, 'summary_large_image', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(3, 9, 'G-XXXXXX002', 'GTM-XXXX02', '123456789012346', NULL, NULL, NULL, NULL, 'https://decor-style.com', NULL, 'summary_large_image', '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(4, 7, 'G-XXXXXX003', 'GTM-XXXX03', NULL, NULL, NULL, NULL, NULL, 'https://electric-pro.com', NULL, 'summary_large_image', '2026-03-16 19:17:17', '2026-03-16 19:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `content_en` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_text` varchar(100) DEFAULT NULL,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `tenant_id`, `title`, `title_en`, `slug`, `description`, `description_en`, `content`, `content_en`, `image`, `icon`, `price`, `price_text`, `show_on_home`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(3, 6, 'صيانة المكيفات', 'AC Maintenance', 'ac-maintenance', 'صيانة شاملة لجميع أنواع المكيفات سبليت وشباك', 'Comprehensive maintenance for all types of air conditioners, split and window units. Professional cleaning, refrigerant refill, and filter replacement.', '<h3>خدمة صيانة المكيفات</h3><p>نقدم خدمة صيانة شاملة للمكيفات تشمل:</p><ul><li>تنظيف الوحدة الداخلية والخارجية</li><li>فحص الفريون وإعادة تعبئته</li><li>فحص الأسلاك والتمديدات</li><li>تغيير الفلاتر</li></ul>', NULL, NULL, 'fas fa-snowflake', NULL, 'يبدأ من 150 ريال', 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(4, 6, 'سباكة منزلية', 'Home Plumbing', 'plumbing', 'إصلاح تسربات، تركيب صحية، تمديدات مياه', 'Professional leak repairs, bathroom fixtures installation, and water pipe installations. Fast and reliable service.', '<h3>خدمات السباكة</h3><p>فريق متخصص في جميع أعمال السباكة:</p><ul><li>كشف وإصلاح التسربات</li><li>تركيب وصيانة الصحية</li><li>تمديدات مياه ساخنة وباردة</li><li>تسليك مجاري</li></ul>', NULL, NULL, 'fas fa-wrench', NULL, 'حسب المعاينة', 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(5, 6, 'كهرباء منزلية', 'Home Electrical', 'electricity', 'تمديدات كهربائية، إصلاح أعطال، تركيب إضاءة', 'Electrical wiring, fault repairs, and lighting installation by certified electricians.', '<h3>خدمات الكهرباء</h3><p>كهربائيون معتمدون لجميع الأعمال:</p><ul><li>تمديدات كهربائية جديدة</li><li>إصلاح دوائر قصر</li><li>تركيب إضاءة LED</li><li>صيانة لوحات كهربائية</li></ul>', NULL, NULL, 'fas fa-bolt', NULL, 'يبدأ من 100 ريال', 1, 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(6, 6, 'صيانة الأجهزة', 'Appliance Repair', 'appliances', 'إصلاح غسالات، ثلاجات، أفران', 'Professional repair of washing machines, refrigerators, ovens, and water heaters.', '<h3>صيانة الأجهزة المنزلية</h3><p>نصلح جميع الأجهزة:</p><ul><li>غسالات ملابس وصحون</li><li>ثلاجات ومجمدات</li><li>أفران وميكروويف</li><li>سخانات مياه</li></ul>', NULL, NULL, 'fas fa-tools', NULL, 'حسب نوع العطل', 1, 4, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(7, 7, 'تمديدات كهربائية', 'Electrical Wiring', 'wiring', 'تمديدات كهربائية جديدة للمنازل والمكاتب', 'New electrical wiring for homes and offices with high-quality standards.', '<h3>تمديدات كهربائية</h3><p>تمديدات احترافية بمعايير عالية:</p><ul><li>تخطيط وتصميم الشبكة</li><li>تركيب الأسلاك المعتمدة</li><li>تركيب المفاتيح والمآخذ</li><li>اختبار وتشغيل</li></ul>', NULL, NULL, 'fas fa-plug', NULL, 'يبدأ من 500 ريال', 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(8, 7, 'إصلاح أعطال', 'Fault Repairs', 'repairs', 'إصلاح جميع الأعطال الكهربائية بسرعة واحتراف', 'Professional repair of all electrical faults quickly and safely.', '<h3>إصلاح الأعطال</h3><p>خدمة سريعة لإصلاح:</p><ul><li>دوائر قصر</li><li>انقطاع التيار</li><li>ارتفاع درجة الحرارة</li><li>مشاكل المفاتيح</li></ul>', NULL, NULL, 'fas fa-exclamation-triangle', NULL, 'يبدأ من 150 ريال', 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(9, 7, 'إضاءة LED', 'LED Lighting', 'led-lighting', 'تركيب إضاءة LED داخلية وخارجية', 'Indoor and outdoor LED lighting installation for modern spaces.', '<h3>إضاءة LED</h3><p>حلول إضاءة حديثة:</p><ul><li>إضاءة داكنة (Dimmable)</li><li>إضاءة ذكية</li><li>سبوت لايت</li><li>إضاءة خارجية</li></ul>', NULL, NULL, 'fas fa-lightbulb', NULL, 'حسب المساحة', 1, 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(10, 7, 'طوارئ 24 ساعة', '24/7 Emergency', 'emergency', 'خدمة طوارئ على مدار الساعة', 'Round-the-clock emergency electrical service. Fast response guaranteed.', '<h3>خدمة الطوارئ</h3><p>متاحون 24 ساعة:</p><ul><li>استجابة سريعة</li><li>فريق متاح دائماً</li><li>تغطية كافة المناطق</li></ul>', NULL, NULL, 'fas fa-ambulance', NULL, 'اتصل الآن', 1, 4, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(11, 8, 'تنظيف فلل', 'Villa Cleaning', 'villa-cleaning', 'تنظيف شامل للفلل والقصور', 'Comprehensive cleaning for villas and palaces. Deep cleaning and sanitization.', '<h3>تنظيف الفلل</h3><p>خدمة تنظيف شاملة:</p><ul><li>تنظيف جميع الغرف</li><li>تنظيف الحمامات والمطبخ</li><li>تنظيف الزجاج والنوافذ</li><li>تعقيم وتطهير</li></ul>', NULL, NULL, 'fas fa-home', NULL, 'يبدأ من 300 ريال', 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(12, 8, 'تنظيف شقق', 'Apartment Cleaning', 'apartment-cleaning', 'تنظيف شامل للشقق', 'Complete apartment cleaning services. Fast and thorough.', '<h3>تنظيف الشقق</h3><p>خدمة سريعة ومميزة:</p><ul><li>تنظيف الغرف والصالات</li><li>تنظيف المطبخ</li><li>تنظيف الحمامات</li><li>كنس ومسح الأرضيات</li></ul>', NULL, NULL, 'fas fa-building', NULL, 'يبدأ من 150 ريال', 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(13, 8, 'تنظيف موكيت وسجاد', 'Carpet & Rug Cleaning', 'carpet-cleaning', 'غسيل وتنظيف الموكيت والسجاد', 'Professional carpet and rug washing with steam cleaning technology.', '<h3>تنظيف الموكيت والسجاد</h3><p>أحدث التقنيات:</p><ul><li>غسيل بالبخار</li><li>إزالة البقع</li><li>تعقيم من الجراثيم</li><li>تجفيف سريع</li></ul>', NULL, NULL, 'fas fa-square', NULL, '50 ريال/متر', 1, 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(14, 8, 'تنظيف مكاتب', 'Office Cleaning', 'office-cleaning', 'تنظيف المكاتب والشركات', 'Corporate and office cleaning services with flexible schedules.', '<h3>تنظيف المكاتب</h3><p>خدمة مؤسسية:</p><ul><li>تنظيف يومي/أسبوعي</li><li>تعقيم الأسطح</li><li>تنظيف الزجاج</li><li>تفريغ سلال المهملات</li></ul>', NULL, NULL, 'fas fa-briefcase', NULL, 'عقد شهري', 1, 4, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(15, 9, 'تصميم داخلي', 'Interior Design', 'interior-design', 'تصاميم داخلية عصرية وفاخرة', 'Modern and luxurious interior designs with 3D visualization.', '<h3>التصميم الداخلي</h3><p>رؤية فنية مميزة:</p><ul><li>تصميم 3D</li><li>اختيار الألوان والمواد</li><li>توزيع الفراغات</li><li>استشارة مجانية</li></ul>', NULL, NULL, 'fas fa-drafting-compass', NULL, 'يبدأ من 3000 ريال', 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(16, 9, 'تشطيب فلل', 'Villa Finishing', 'villa-finishing', 'تشطيبات فاخرة للفلل', 'Premium villa finishing works with high-quality materials.', '<h3>تشطيب الفلل</h3><p>جودة عالية:</p><ul><li>أعمال الدهانات</li><li>تركيب الأرضيات</li><li>أعمال الجبس بورد</li><li>تركيب الأسقف المعلقة</li></ul>', NULL, NULL, 'fas fa-paint-roller', NULL, 'حسب المساحة', 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(17, 9, 'ديكور غرف نوم', 'Bedroom Decor', 'bedroom-decor', 'تصميم وتنفيذ غرف نوم أنيقة', 'Elegant bedroom design and execution for comfort and style.', '<h3>ديكور غرف النوم</h3><p>راحة وأناقة:</p><ul><li>تصميم الأسرة</li><li>خزائن ملابس</li><li>إضاءة ناعمة</li><li>ستائر متناسقة</li></ul>', NULL, NULL, 'fas fa-bed', NULL, 'يبدأ من 5000 ريال', 1, 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(18, 9, 'ديكور مطابخ', 'Kitchen Decor', 'kitchen-decor', 'تصميم وتنفيذ مطابخ عصرية', 'Modern kitchen design and installation with premium materials.', '<h3>ديكور المطابخ</h3><p>وظائف وجمال:</p><ul><li>خزائن مودرن</li><li>رخام صناعي</li><li>إضاءة LED</li><li>أجهزة مدمجة</li></ul>', NULL, NULL, 'fas fa-utensils', NULL, 'يبدأ من 15000 ريال', 1, 4, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(19, 10, 'كشف تسربات', 'Leak Detection', 'leak-detection', 'كشف التسربات بأحدث الأجهزة', 'Advanced leak detection using latest thermal and camera equipment.', '<h3>كشف التسربات</h3><p>تقنية متطورة:</p><ul><li>أجهزة كشف حرارية</li><li>كاميرات فحص</li><li>تحديد دقيق للعطل</li><li>تقرير مفصل</li></ul>', NULL, NULL, 'fas fa-search', NULL, 'يبدأ من 200 ريال', 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(20, 10, 'تركيب صحية', 'Sanitary Installation', 'sanitary-installation', 'تركيب جميع أنواع الصحية', 'Professional installation of all sanitary fixtures and water heaters.', '<h3>تركيب الصحية</h3><p>أعمال احترافية:</p><ul><li>مراحيض ومغاسل</li><li>بانيو وجاكوزي</li><li>خلاطات</li><li>سخانات مياه</li></ul>', NULL, NULL, 'fas fa-toilet', NULL, 'يبدأ من 100 ريال', 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(21, 10, 'تسليك مجاري', 'Drain Cleaning', 'drainage', 'تسليك وتنظيف المجاري', 'Professional drain cleaning and unclogging with guaranteed results.', '<h3>تسليك المجاري</h3><p>حلول سريعة:</p><ul><li>ماكينات تسليك</li><li>تنظيف بالضغط</li><li>صيانة دورية</li><li>ضمان على العمل</li></ul>', NULL, NULL, 'fas fa-water', NULL, 'يبدأ من 150 ريال', 1, 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(22, 11, 'نقل عفش', 'Moving Services', 'moving', 'نقل الأثاث والأعفة بأمان', 'Safe furniture moving and relocation with professional packing.', '<h3>نقل العفش</h3><p>خدمة شاملة:</p><ul><li>تغليف احترافي</li><li>فك وتركيب</li><li>سيارات مغلقة</li><li>تأمين على الممتلكات</li></ul>', NULL, NULL, 'fas fa-truck', NULL, 'يبدأ من 500 ريال', 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(23, 11, 'مكافحة حشرات', 'Pest Control', 'pest-control', 'مكافحة جميع أنواع الحشرات', 'Professional pest control for all insects. Safe and effective.', '<h3>مكافحة الحشرات</h3><p>مواد آمنة:</p><ul><li>رش مبيدات</li><li>فخاخ الفئران</li><li>علاج النمل الأبيض</li><li>ضمان 6 أشهر</li></ul>', NULL, NULL, 'fas fa-bug', NULL, 'يبدأ من 200 ريال', 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(24, 11, 'عزل أسطح', 'Roof Insulation', 'roof-insulation', 'عزل مائي وحراري للأسطح', 'Water and thermal roof insulation with 10-year warranty.', '<h3>عزل الأسطح</h3><p>حماية شاملة:</p><ul><li>عزل مائي</li><li>عزل حراري</li><li>مواد عالية الجودة</li><li>ضمان 10 سنوات</li></ul>', NULL, NULL, 'fas fa-shield-alt', NULL, 'حسب المساحة', 1, 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(25, 6, 'صيانة المكيفات', 'AC Maintenance', 'ac-maintenance', 'صيانة شاملة لجميع أنواع المكيفات سبليت وشباك', 'Comprehensive maintenance for all types of air conditioners, split and window units. Professional cleaning, refrigerant refill, and filter replacement.', '<h3>خدمة صيانة المكيفات</h3><p>نقدم خدمة صيانة شاملة للمكيفات تشمل:</p><ul><li>تنظيف الوحدة الداخلية والخارجية</li><li>فحص الفريون وإعادة تعبئته</li><li>فحص الأسلاك والتمديدات</li><li>تغيير الفلاتر</li></ul><p>نوفر خدمة صيانة دورية بأسعار مخفضة.</p>', NULL, NULL, 'fas fa-snowflake', NULL, 'يبدأ من 150 ريال', 1, 1, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(26, 6, 'سباكة منزلية', 'Home Plumbing', 'plumbing', 'إصلاح تسربات، تركيب صحية، تمديدات مياه', 'Professional leak repairs, bathroom fixtures installation, and water pipe installations. Fast and reliable service.', '<h3>خدمات السباكة</h3><p>فريق متخصص في جميع أعمال السباكة:</p><ul><li>كشف وإصلاح التسربات</li><li>تركيب وصيانة الصحية</li><li>تمديدات مياه ساخنة وباردة</li><li>تسليك مجاري</li></ul>', NULL, NULL, 'fas fa-wrench', NULL, 'حسب المعاينة', 1, 2, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(27, 6, 'كهرباء منزلية', 'Home Electrical', 'electricity', 'تمديدات كهربائية، إصلاح أعطال، تركيب إضاءة', 'Electrical wiring, fault repairs, and lighting installation by certified electricians.', '<h3>خدمات الكهرباء</h3><p>كهربائيون معتمدون لجميع الأعمال:</p><ul><li>تمديدات كهربائية جديدة</li><li>إصلاح دوائر قصر</li><li>تركيب إضاءة LED</li><li>صيانة لوحات كهربائية</li></ul>', NULL, NULL, 'fas fa-bolt', NULL, 'يبدأ من 100 ريال', 1, 3, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(28, 6, 'صيانة الأجهزة', 'Appliance Repair', 'appliances', 'إصلاح غسالات، ثلاجات، أفران', 'Professional repair of washing machines, refrigerators, ovens, and water heaters.', '<h3>صيانة الأجهزة المنزلية</h3><p>نصلح جميع الأجهزة:</p><ul><li>غسالات ملابس وصحون</li><li>ثلاجات ومجمدات</li><li>أفران وميكروويف</li><li>سخانات مياه</li></ul>', NULL, NULL, 'fas fa-tools', NULL, 'حسب نوع العطل', 1, 4, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(29, 7, 'تمديدات كهربائية', 'Electrical Wiring', 'wiring', 'تمديدات كهربائية جديدة للمنازل والمكاتب', 'New electrical wiring for homes and offices with high-quality standards.', '<h3>تمديدات كهربائية</h3><p>تمديدات احترافية بمعايير عالية:</p><ul><li>تخطيط وتصميم الشبكة</li><li>تركيب الأسلاك المعتمدة</li><li>تركيب المفاتيح والمآخذ</li><li>اختبار وتشغيل</li></ul>', NULL, NULL, 'fas fa-plug', NULL, 'يبدأ من 500 ريال', 1, 1, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(30, 7, 'إصلاح أعطال', 'Fault Repairs', 'repairs', 'إصلاح جميع الأعطال الكهربائية بسرعة واحتراف', 'Professional repair of all electrical faults quickly and safely.', '<h3>إصلاح الأعطال</h3><p>خدمة سريعة لإصلاح:</p><ul><li>دوائر قصر</li><li>انقطاع التيار</li><li>ارتفاع درجة الحرارة</li><li>مشاكل المفاتيح</li></ul>', NULL, NULL, 'fas fa-exclamation-triangle', NULL, 'يبدأ من 150 ريال', 1, 2, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(31, 7, 'إضاءة LED', 'LED Lighting', 'led-lighting', 'تركيب إضاءة LED داخلية وخارجية', 'Indoor and outdoor LED lighting installation for modern spaces.', '<h3>إضاءة LED</h3><p>حلول إضاءة حديثة:</p><ul><li>إضاءة داكنة (Dimmable)</li><li>إضاءة ذكية</li><li>سبوت لايت</li><li>إضاءة خارجية</li></ul>', NULL, NULL, 'fas fa-lightbulb', NULL, 'حسب المساحة', 1, 3, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(32, 7, 'طوارئ 24 ساعة', '24/7 Emergency', 'emergency', 'خدمة طوارئ على مدار الساعة', 'Round-the-clock emergency electrical service. Fast response guaranteed.', '<h3>خدمة الطوارئ</h3><p>متاحون 24 ساعة:</p><ul><li>استجابة سريعة</li><li>فريق متاح دائماً</li><li>تغطية كافة المناطق</li></ul>', NULL, NULL, 'fas fa-ambulance', NULL, 'اتصل الآن', 1, 4, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(33, 8, 'تنظيف فلل', 'Villa Cleaning', 'villa-cleaning', 'تنظيف شامل للفلل والقصور', 'Comprehensive cleaning for villas and palaces. Deep cleaning and sanitization.', '<h3>تنظيف الفلل</h3><p>خدمة تنظيف شاملة:</p><ul><li>تنظيف جميع الغرف</li><li>تنظيف الحمامات والمطبخ</li><li>تنظيف الزجاج والنوافذ</li><li>تعقيم وتطهير</li></ul>', NULL, NULL, 'fas fa-home', NULL, 'يبدأ من 300 ريال', 1, 1, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(34, 8, 'تنظيف شقق', 'Apartment Cleaning', 'apartment-cleaning', 'تنظيف شامل للشقق', 'Complete apartment cleaning services. Fast and thorough.', '<h3>تنظيف الشقق</h3><p>خدمة سريعة ومميزة:</p><ul><li>تنظيف الغرف والصالات</li><li>تنظيف المطبخ</li><li>تنظيف الحمامات</li><li>كنس ومسح الأرضيات</li></ul>', NULL, NULL, 'fas fa-building', NULL, 'يبدأ من 150 ريال', 1, 2, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(35, 8, 'تنظيف موكيت وسجاد', 'Carpet & Rug Cleaning', 'carpet-cleaning', 'غسيل وتنظيف الموكيت والسجاد', 'Professional carpet and rug washing with steam cleaning technology.', '<h3>تنظيف الموكيت والسجاد</h3><p>أحدث التقنيات:</p><ul><li>غسيل بالبخار</li><li>إزالة البقع</li><li>تعقيم من الجراثيم</li><li>تجفيف سريع</li></ul>', NULL, NULL, 'fas fa-square', NULL, '50 ريال/متر', 1, 3, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(36, 8, 'تنظيف مكاتب', 'Office Cleaning', 'office-cleaning', 'تنظيف المكاتب والشركات', 'Corporate and office cleaning services with flexible schedules.', '<h3>تنظيف المكاتب</h3><p>خدمة مؤسسية:</p><ul><li>تنظيف يومي/أسبوعي</li><li>تعقيم الأسطح</li><li>تنظيف الزجاج</li><li>تفريغ سلال المهملات</li></ul>', NULL, NULL, 'fas fa-briefcase', NULL, 'عقد شهري', 1, 4, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(37, 9, 'تصميم داخلي', 'Interior Design', 'interior-design', 'تصاميم داخلية عصرية وفاخرة', 'Modern and luxurious interior designs with 3D visualization.', '<h3>التصميم الداخلي</h3><p>رؤية فنية مميزة:</p><ul><li>تصميم 3D</li><li>اختيار الألوان والمواد</li><li>توزيع الفراغات</li><li>استشارة مجانية</li></ul>', NULL, NULL, 'fas fa-drafting-compass', NULL, 'يبدأ من 3000 ريال', 1, 1, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(38, 9, 'تشطيب فلل', 'Villa Finishing', 'villa-finishing', 'تشطيبات فاخرة للفلل', 'Premium villa finishing works with high-quality materials.', '<h3>تشطيب الفلل</h3><p>جودة عالية:</p><ul><li>أعمال الدهانات</li><li>تركيب الأرضيات</li><li>أعمال الجبس بورد</li><li>تركيب الأسقف المعلقة</li></ul>', NULL, NULL, 'fas fa-paint-roller', NULL, 'حسب المساحة', 1, 2, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(39, 9, 'ديكور غرف نوم', 'Bedroom Decor', 'bedroom-decor', 'تصميم وتنفيذ غرف نوم أنيقة', 'Elegant bedroom design and execution for comfort and style.', '<h3>ديكور غرف النوم</h3><p>راحة وأناقة:</p><ul><li>تصميم الأسرة</li><li>خزائن ملابس</li><li>إضاءة ناعمة</li><li>ستائر متناسقة</li></ul>', NULL, NULL, 'fas fa-bed', NULL, 'يبدأ من 5000 ريال', 1, 3, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(40, 9, 'ديكور مطابخ', 'Kitchen Decor', 'kitchen-decor', 'تصميم وتنفيذ مطابخ عصرية', 'Modern kitchen design and installation with premium materials.', '<h3>ديكور المطابخ</h3><p>وظائف وجمال:</p><ul><li>خزائن مودرن</li><li>رخام صناعي</li><li>إضاءة LED</li><li>أجهزة مدمجة</li></ul>', NULL, NULL, 'fas fa-utensils', NULL, 'يبدأ من 15000 ريال', 1, 4, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(41, 10, 'كشف تسربات', 'Leak Detection', 'leak-detection', 'كشف التسربات بأحدث الأجهزة', 'Advanced leak detection using latest thermal and camera equipment.', '<h3>كشف التسربات</h3><p>تقنية متطورة:</p><ul><li>أجهزة كشف حرارية</li><li>كاميرات فحص</li><li>تحديد دقيق للعطل</li><li>تقرير مفصل</li></ul>', NULL, NULL, 'fas fa-search', NULL, 'يبدأ من 200 ريال', 1, 1, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(42, 10, 'تركيب صحية', 'Sanitary Installation', 'sanitary-installation', 'تركيب جميع أنواع الصحية', 'Professional installation of all sanitary fixtures and water heaters.', '<h3>تركيب الصحية</h3><p>أعمال احترافية:</p><ul><li>مراحيض ومغاسل</li><li>بانيو وجاكوزي</li><li>خلاطات</li><li>سخانات مياه</li></ul>', NULL, NULL, 'fas fa-toilet', NULL, 'يبدأ من 100 ريال', 1, 2, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(43, 10, 'تسليك مجاري', 'Drain Cleaning', 'drainage', 'تسليك وتنظيف المجاري', 'Professional drain cleaning and unclogging with guaranteed results.', '<h3>تسليك المجاري</h3><p>حلول سريعة:</p><ul><li>ماكينات تسليك</li><li>تنظيف بالضغط</li><li>صيانة دورية</li><li>ضمان على العمل</li></ul>', NULL, NULL, 'fas fa-water', NULL, 'يبدأ من 150 ريال', 1, 3, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(44, 11, 'نقل عفش', 'Moving Services', 'moving', 'نقل الأثاث والأعفة بأمان', 'Safe furniture moving and relocation with professional packing.', '<h3>نقل العفش</h3><p>خدمة شاملة:</p><ul><li>تغليف احترافي</li><li>فك وتركيب</li><li>سيارات مغلقة</li><li>تأمين على الممتلكات</li></ul>', NULL, NULL, 'fas fa-truck', NULL, 'يبدأ من 500 ريال', 1, 1, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(45, 11, 'مكافحة حشرات', 'Pest Control', 'pest-control', 'مكافحة جميع أنواع الحشرات', 'Professional pest control for all insects. Safe and effective.', '<h3>مكافحة الحشرات</h3><p>مواد آمنة:</p><ul><li>رش مبيدات</li><li>فخاخ الفئران</li><li>علاج النمل الأبيض</li><li>ضمان 6 أشهر</li></ul>', NULL, NULL, 'fas fa-bug', NULL, 'يبدأ من 200 ريال', 1, 2, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(46, 11, 'عزل أسطح', 'Roof Insulation', 'roof-insulation', 'عزل مائي وحراري للأسطح', 'Water and thermal roof insulation with 10-year warranty.', '<h3>عزل الأسطح</h3><p>حماية شاملة:</p><ul><li>عزل مائي</li><li>عزل حراري</li><li>مواد عالية الجودة</li><li>ضمان 10 سنوات</li></ul>', NULL, NULL, 'fas fa-shield-alt', NULL, 'حسب المساحة', 1, 3, 'active', '2026-03-16 19:31:26', '2026-03-16 20:35:13'),
(47, 5, 'تنظيف المنازل', NULL, 'تنظيف-المنازل', 'خدمة تنظيف منزلية شاملة تشمل جميع الغرف والمطبخ والحمامات.', NULL, '', NULL, '5/services/Whisk_5a29348fb14e2b3b9344454becce8de6dr_20260409085438_1a19c6f4.jpeg', 'fas fa-home', NULL, '', 1, 1, 'active', '2026-03-18 09:01:55', '2026-04-09 08:54:38'),
(48, 5, 'تنظيف المكاتب', NULL, 'تنظيف-المكاتب', 'تنظيف احترافي للمكاتب والشركات مع جدولة منتظمة.', NULL, NULL, NULL, NULL, 'fas fa-building', NULL, NULL, 1, 2, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55'),
(49, 5, 'تنظيف السجاد', NULL, 'تنظيف-السجاد', 'تنظيف عميق للسجاد والموكيت باستخدام أجهزة بخار متطورة.', NULL, NULL, NULL, NULL, 'fas fa-couch', NULL, NULL, 1, 3, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55'),
(50, 5, 'تنظيف بعد البناء', NULL, 'تنظيف-بعد-البناء', 'تنظيف شامل بعد انتهاء أعمال البناء والترميم.', NULL, NULL, NULL, NULL, 'fas fa-hard-hat', NULL, NULL, 1, 4, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55'),
(51, 5, 'تنظيف الواجهات', NULL, 'تنظيف-الواجهات', 'تنظيف واجهات المباني الزجاجية والحجرية.', NULL, '', NULL, '5/services/realestate-villa_20260411040304_f9c620b1.jpg', 'fas fa-city', NULL, 'السعر', 1, 5, 'active', '2026-03-18 09:01:55', '2026-04-11 04:03:04'),
(52, 5, 'تعقيم وتطهير', NULL, 'تعقيم-وتطهير', 'خدمات تعقيم وتطهير شاملة.', NULL, NULL, NULL, NULL, 'fas fa-shield-virus', NULL, NULL, 0, 6, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'string',
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'منصة المواقع', 'string', 'اسم المنصة', '2026-03-14 12:12:42', '2026-03-14 12:12:42'),
(2, 'site_email', 'info@cms-platform.com', 'string', 'بريد المنصة', '2026-03-14 12:12:42', '2026-03-14 12:12:42'),
(3, 'trial_days', '14', 'integer', 'عدد أيام التجربة المجانية', '2026-03-14 12:12:42', '2026-03-14 12:12:42'),
(4, 'monthly_price', '99', 'decimal', 'سعر الاشتراك الشهري', '2026-03-14 12:12:42', '2026-03-14 12:12:42'),
(5, 'currency', 'SAR', 'string', 'العملة', '2026-03-14 12:12:42', '2026-03-14 12:12:42'),
(6, 'max_upload_size', '5242880', 'integer', 'أقصى حجم للرفع بالبايت (5MB)', '2026-03-14 12:12:42', '2026-03-14 12:12:42'),
(7, 'allowed_file_types', 'jpg,jpeg,png,gif,webp,pdf,doc,docx', 'string', 'أنواع الملفات المسموحة', '2026-03-14 12:12:42', '2026-03-14 12:12:42'),
(8, 'default_language', 'ar', 'string', 'اللغة الافتراضية', '2026-03-14 12:12:42', '2026-03-14 12:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `site_features`
--

CREATE TABLE `site_features` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_features`
--

INSERT INTO `site_features` (`id`, `tenant_id`, `icon`, `title`, `title_en`, `description`, `description_en`, `display_order`, `is_active`, `created_at`) VALUES
(1, NULL, 'fas fa-palette', 'قوالب احترافية', NULL, 'اختر من بين مجموعة متنوعة من القوالب الجاهزة والمصممة باحترافية', NULL, 1, 1, '2026-05-10 23:13:34'),
(2, NULL, 'fas fa-magic', 'تخصيص سهل', NULL, 'عدّل الألوان والخطوط والمحتوى بسهولة بدون حاجة لخبرة تقنية', NULL, 2, 1, '2026-05-10 23:13:34'),
(3, NULL, 'fas fa-mobile-alt', 'متجاوب مع جميع الأجهزة', NULL, 'مواقعك تعمل بشكل مثالي على الجوال والتابلت والكمبيوتر', NULL, 3, 1, '2026-05-10 23:13:34'),
(4, NULL, 'fas fa-bolt', 'سرعة فائقة', NULL, 'مواقع سريعة التحميل ومحسنة لمحركات البحث', NULL, 4, 1, '2026-05-10 23:13:34'),
(5, NULL, 'fas fa-headset', 'دعم فني متواصل', NULL, 'فريق دعم متخصص جاهز لمساعدتك في أي وقت', NULL, 5, 1, '2026-05-10 23:13:34'),
(6, NULL, 'fas fa-shield-alt', 'آمن ومحمي', NULL, 'حماية متقدمة وشهادات SSL مجانية لجميع المواقع', NULL, 6, 1, '2026-05-10 23:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `logo_white` varchar(500) DEFAULT NULL,
  `favicon` varchar(500) DEFAULT NULL,
  `hero_title` varchar(500) DEFAULT NULL,
  `hero_title_en` varchar(255) DEFAULT NULL,
  `hero_subtitle` text DEFAULT NULL,
  `hero_subtitle_en` text DEFAULT NULL,
  `hero_image` varchar(500) DEFAULT NULL,
  `hero_button_text` varchar(200) DEFAULT NULL,
  `hero_button_text_en` varchar(255) DEFAULT NULL,
  `hero_button_link` varchar(500) DEFAULT NULL,
  `features_title` varchar(200) DEFAULT NULL,
  `features_subtitle` varchar(200) DEFAULT NULL,
  `show_features` tinyint(1) DEFAULT 1,
  `show_themes_section` tinyint(1) DEFAULT 1,
  `show_pricing_section` tinyint(1) DEFAULT 1,
  `pricing_title` varchar(200) DEFAULT NULL,
  `pricing_subtitle` varchar(200) DEFAULT NULL,
  `testimonials_title` varchar(200) DEFAULT NULL,
  `show_testimonials` tinyint(1) DEFAULT 1,
  `contact_title` varchar(200) DEFAULT NULL,
  `contact_subtitle` varchar(200) DEFAULT NULL,
  `show_contact_form` tinyint(1) DEFAULT 1,
  `contact_email` varchar(200) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `contact_whatsapp` varchar(50) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `facebook` varchar(500) DEFAULT NULL,
  `twitter` varchar(500) DEFAULT NULL,
  `instagram` varchar(500) DEFAULT NULL,
  `linkedin` varchar(500) DEFAULT NULL,
  `youtube` varchar(500) DEFAULT NULL,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `copyright_text` varchar(500) DEFAULT NULL,
  `head_scripts` text DEFAULT NULL,
  `body_scripts` text DEFAULT NULL,
  `maintenance_mode` tinyint(1) DEFAULT 0,
  `maintenance_message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `logo`, `logo_white`, `favicon`, `hero_title`, `hero_title_en`, `hero_subtitle`, `hero_subtitle_en`, `hero_image`, `hero_button_text`, `hero_button_text_en`, `hero_button_link`, `features_title`, `features_subtitle`, `show_features`, `show_themes_section`, `show_pricing_section`, `pricing_title`, `pricing_subtitle`, `testimonials_title`, `show_testimonials`, `contact_title`, `contact_subtitle`, `show_contact_form`, `contact_email`, `contact_phone`, `contact_whatsapp`, `contact_address`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `meta_title`, `meta_description`, `meta_keywords`, `footer_text`, `copyright_text`, `head_scripts`, `body_scripts`, `maintenance_mode`, `maintenance_message`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'أنشئ موقعك الإلكتروني الاحترافي', NULL, 'منصة سهلة ومرنة لإنشاء مواقع احترافية بدون حاجة لخبرة تقنية. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.', NULL, NULL, 'ابدأ الآن مجاناً', NULL, '/register', 'لماذا تختارنا؟', 'نوفر لك كل ما تحتاجه لبناء حضور رقمي مميز', 1, 1, 1, 'خطط الأسعار', 'اختر الخطة المناسبة لاحتياجاتك', 'ماذا يقول عملاؤنا', 1, 'تواصل معنا', NULL, 1, 'info@cms-platform.com', '+966 50 000 0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'منصة المواقع - أنشئ موقعك بسهولة', 'منصة متكاملة لإنشاء المواقع الإلكترونية بسهولة وبدون حاجة لخبرة تقنية.', NULL, 'منصة المواقع - نساعدك في بناء حضورك الرقمي', '© 2026 منصة المواقع. جميع الحقوق محفوظة', NULL, NULL, 0, NULL, '2026-04-13 05:46:59', '2026-04-13 05:46:59'),
(2, NULL, NULL, NULL, 'أنشئ موقعك الإلكتروني الاحترافي', NULL, 'منصة سهلة ومرنة لإنشاء مواقع احترافية بدون حاجة لخبرة تقنية. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.', NULL, NULL, 'ابدأ الآن مجاناً', NULL, '/register', 'لماذا تختارنا؟', 'نوفر لك كل ما تحتاجه لبناء حضور رقمي مميز', 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '© 2024 منصة المواقع. جميع الحقوق محفوظة.', NULL, NULL, 0, NULL, '2026-05-10 23:13:34', '2026-05-10 23:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `site_stats`
--

CREATE TABLE `site_stats` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `label` varchar(100) NOT NULL COMMENT 'الوصف بالعربية',
  `label_en` varchar(100) DEFAULT NULL COMMENT 'الوصف بالإنجليزية',
  `value` varchar(50) NOT NULL COMMENT 'الرقم أو القيمة',
  `suffix` varchar(20) DEFAULT '+' COMMENT 'لاحقة مثل + أو %',
  `icon` varchar(100) DEFAULT 'fas fa-star' COMMENT 'أيقونة Font Awesome',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_testimonials`
--

CREATE TABLE `site_testimonials` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_title` varchar(255) DEFAULT NULL,
  `client_company` varchar(255) DEFAULT NULL,
  `client_image` varchar(500) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_testimonials`
--

INSERT INTO `site_testimonials` (`id`, `client_name`, `client_title`, `client_company`, `client_image`, `content`, `rating`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'أحمد محمد', 'صاحب شركة مقاولات', 'شركة البناء الحديث', NULL, 'منصة رائعة وسهلة الاستخدام، استطعت إنشاء موقعي خلال ساعات فقط. القوالب احترافية والتخصيص ممتع جداً.', 5, 1, 1, '2026-04-13 05:46:59', '2026-04-13 05:46:59'),
(2, 'سارة العتيبي', 'مصممة ديكور', 'مكتب التصميم الإبداعي', NULL, 'الدعم الفني ممتاز والاستجابة سريعة. أنصح بهذه المنصة لكل من يريد موقعاً احترافياً بأسعار معقولة.', 5, 2, 1, '2026-04-13 05:46:59', '2026-04-13 05:46:59'),
(3, 'خالد الشمري', 'مقدم خدمات كهربائية', 'شركة الطاقة المتقدمة', NULL, 'أفضل منصة عربية لإنشاء المواقع. واجهة سهلة وقوالب متنوعة تناسب جميع المجالات.', 5, 3, 1, '2026-04-13 05:46:59', '2026-04-13 05:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `plan_id` int(11) UNSIGNED DEFAULT NULL,
  `request_id` int(11) UNSIGNED DEFAULT NULL,
  `plan_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'SAR',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','expired','cancelled','pending') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `tenant_id`, `plan_id`, `request_id`, `plan_name`, `amount`, `currency`, `start_date`, `end_date`, `status`, `payment_method`, `payment_reference`, `auto_renew`, `created_at`, `updated_at`) VALUES
(1, 6, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(2, 7, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(3, 9, NULL, NULL, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(4, 10, NULL, NULL, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(5, 6, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(6, 7, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(7, 9, NULL, NULL, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(8, 10, NULL, NULL, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(9, 6, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(10, 7, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(11, 9, NULL, NULL, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(12, 10, NULL, NULL, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(13, 6, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(14, 7, NULL, NULL, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(15, 9, NULL, NULL, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(16, 10, NULL, NULL, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:38:27', '2026-03-16 19:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price_monthly` decimal(10,2) NOT NULL DEFAULT 0.00,
  `price_yearly` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'SAR',
  `features` text DEFAULT NULL,
  `max_pages` int(11) NOT NULL DEFAULT -1,
  `max_services` int(11) NOT NULL DEFAULT -1,
  `max_gallery` int(11) NOT NULL DEFAULT -1,
  `max_banners` int(11) NOT NULL DEFAULT -1,
  `custom_domain` tinyint(1) NOT NULL DEFAULT 0,
  `remove_branding` tinyint(1) NOT NULL DEFAULT 0,
  `analytics_access` tinyint(1) NOT NULL DEFAULT 0,
  `priority_support` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `max_forms` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `name`, `slug`, `description`, `price_monthly`, `price_yearly`, `currency`, `features`, `max_pages`, `max_services`, `max_gallery`, `max_banners`, `custom_domain`, `remove_branding`, `analytics_access`, `priority_support`, `is_active`, `is_popular`, `display_order`, `created_at`, `updated_at`, `max_forms`) VALUES
(1, 'مجاني', 'free', 'خطة مجانية مثالية للبدء وإنشاء موقعك الإلكتروني الأساسي مع ميزات محدودة تناسب المشاريع الصغيرة والأفراد الذين يريدون تجربة المنصة قبل الالتزام بخطة مدفوعة.', 0.00, 0.00, 'SAR', '[\"إنشاء موقع إلكتروني واحد\",\"قالب مجاني\",\"3 صفحات\",\"خدمة واحدة\",\"10 صور في المعرض\",\"بانر واحد\",\"دعم عبر البريد الإلكتروني\",\"HTTPS مجاني\",\"استجابة سريعة للجوال\"]', 3, 1, 10, 1, 0, 0, 0, 0, 1, 0, 1, '2026-05-10 14:53:38', '2026-05-10 14:53:38', 0),
(2, 'احترافي', 'professional', 'الخطة الاحترافية مصممة للشركات الصغيرة والمتوسطة التي تحتاج لموقع متكامل مع ميزات متقدمة وداومين مخصص ودعم أولوية لضمان أفضل أداء لموقعك.', 49.00, 490.00, 'SAR', '[\"كل مميزات الخطة المجانية\",\"20 صفحة\",\"10 خدمات\",\"100 صورة في المعرض\",\"5 بانرات\",\"نطاق مخصص (دومين)\",\"إزالة شعار المنصة\",\"تحليلات الزوار\",\"دعم أولوية على مدار الساعة\",\"قالب مدفوع مجاناً\",\"شهادة SSL مجانية\",\"نسخ احتياطي يومي\"]', 20, 10, 100, 5, 1, 1, 1, 1, 1, 1, 2, '2026-05-10 14:53:38', '2026-05-10 14:53:38', 0),
(3, 'مؤسسات', 'enterprise', 'خطة المؤسسات هي الحل الأمثل للشركات الكبيرة والمشاريع المتقدمة التي تحتاج لموقع بلا حدود مع كل الميزات المتقدمة ودعم مخصص ومدير حساب خاص.', 149.00, 1490.00, 'SAR', '[\"كل مميزات الخطة الاحترافية\",\"صفحات غير محدودة\",\"خدمات غير محدودة\",\"معرض غير محدود\",\"بانرات غير محدودة\",\"نطاق مخصص (دومين)\",\"إزالة شعار المنصة\",\"تحليلات متقدمة\",\"دعم مخصص ومدير حساب\",\"جميع القوالب مجاناً\",\"شهادة SSL متقدمة\",\"نسخ احتياطي كل 6 ساعات\",\"تقرير SEO شهري\",\"تحسين سرعة الموقع\",\"أولوية في التحديثات الجديدة\"]', -1, -1, -1, -1, 1, 1, 1, 1, 1, 0, 3, '2026-05-10 14:53:38', '2026-05-10 14:53:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_requests`
--

CREATE TABLE `subscription_requests` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `plan_id` int(11) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `business_name` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `reviewed_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_requests`
--

INSERT INTO `subscription_requests` (`id`, `tenant_id`, `plan_id`, `status`, `business_name`, `contact_name`, `contact_email`, `contact_phone`, `notes`, `admin_notes`, `payment_method`, `payment_reference`, `reviewed_at`, `reviewed_by`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'approved', NULL, NULL, NULL, NULL, '', 'تمت الموافقة', NULL, NULL, '2026-05-10 15:19:31', 1, '2026-05-10 14:56:38', '2026-05-10 15:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_name_en` varchar(255) DEFAULT NULL,
  `slug` varchar(100) NOT NULL,
  `subdomain` varchar(100) DEFAULT NULL,
  `custom_domain` varchar(255) DEFAULT NULL,
  `custom_domain_status` enum('none','pending','active','rejected') DEFAULT 'none',
  `custom_domain_purchased` tinyint(1) DEFAULT 0,
  `custom_domain_verified` tinyint(1) DEFAULT 0,
  `custom_domain_verification_token` varchar(64) DEFAULT NULL,
  `domain_status` enum('pending','active','failed') DEFAULT 'pending',
  `theme_id` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `plan_id` int(11) UNSIGNED DEFAULT NULL,
  `subscription_plan_id` int(11) UNSIGNED DEFAULT NULL,
  `subscription_status` enum('trial','active','expired','suspended') NOT NULL DEFAULT 'trial',
  `subscription_start` date DEFAULT NULL,
  `subscription_end` date DEFAULT NULL,
  `trial_ends_at` datetime DEFAULT NULL,
  `auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `last_payment_date` datetime DEFAULT NULL,
  `next_payment_date` datetime DEFAULT NULL,
  `site_status` enum('draft','published','maintenance') NOT NULL DEFAULT 'draft',
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `contact_phone2` varchar(50) DEFAULT NULL,
  `contact_whatsapp` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `working_hours` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_description_en` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `primary_color` varchar(7) DEFAULT '#2563eb',
  `secondary_color` varchar(7) DEFAULT '#1e40af',
  `accent_color` varchar(7) DEFAULT '#f59e0b',
  `text_color` varchar(7) DEFAULT '#1f2937',
  `background_color` varchar(7) DEFAULT '#ffffff',
  `settings` text DEFAULT NULL,
  `default_language` varchar(5) NOT NULL DEFAULT 'ar',
  `sections_config` text DEFAULT NULL,
  `plan_features` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cta_title` varchar(255) DEFAULT NULL COMMENT 'عنوان قسم CTA',
  `cta_title_en` varchar(255) DEFAULT NULL COMMENT 'عنوان CTA بالإنجليزية',
  `cta_text` varchar(500) DEFAULT NULL COMMENT 'نص قسم CTA',
  `cta_text_en` varchar(500) DEFAULT NULL COMMENT 'نص CTA بالإنجليزية',
  `cta_button_text` varchar(255) DEFAULT NULL COMMENT 'نص زر CTA',
  `cta_button_text_en` varchar(255) DEFAULT NULL COMMENT 'نص زر CTA بالإنجليزية',
  `cta_button_link` varchar(500) DEFAULT '#contact' COMMENT 'رابط زر CTA',
  `cta_is_active` tinyint(1) DEFAULT 1 COMMENT 'تفعيل قسم CTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `user_id`, `site_name`, `site_name_en`, `slug`, `subdomain`, `custom_domain`, `custom_domain_status`, `custom_domain_purchased`, `custom_domain_verified`, `custom_domain_verification_token`, `domain_status`, `theme_id`, `plan_id`, `subscription_plan_id`, `subscription_status`, `subscription_start`, `subscription_end`, `trial_ends_at`, `auto_renew`, `last_payment_date`, `next_payment_date`, `site_status`, `logo`, `favicon`, `contact_email`, `contact_phone`, `contact_phone2`, `contact_whatsapp`, `address`, `working_hours`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `tiktok`, `meta_title`, `meta_description`, `meta_description_en`, `meta_keywords`, `primary_color`, `secondary_color`, `accent_color`, `text_color`, `background_color`, `settings`, `default_language`, `sections_config`, `plan_features`, `created_at`, `updated_at`, `cta_title`, `cta_title_en`, `cta_text`, `cta_text_en`, `cta_button_text`, `cta_button_text_en`, `cta_button_link`, `cta_is_active`) VALUES
(1, 1, 'ماستر فيكس', 'Master Fix', 'شركة-البقاع-الشامخة-للمقاولات', NULL, NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'trial', NULL, NULL, '2026-03-28 16:58:45', 0, NULL, NULL, 'draft', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-14 16:58:45', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(2, 1, 'ماستر فيكس', 'Master Fix', 'شركة-البقاع-الشامخة-للمقاولات-1', NULL, NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'trial', NULL, NULL, '2026-03-28 17:01:51', 0, NULL, NULL, 'draft', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-14 17:01:51', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(3, 1, 'ماستر فيكس', 'Master Fix', 'شركة-البقاع-الشامخة-للمقاولات-2', NULL, NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'trial', NULL, NULL, '2026-03-28 17:01:59', 0, NULL, NULL, 'draft', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-14 17:01:59', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(4, 1, 'ماستر فيكس', 'Master Fix', 'متجر-زينون-للرجال', NULL, NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'trial', NULL, NULL, '2026-03-28 17:02:20', 0, NULL, NULL, 'draft', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-14 17:02:20', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(5, 2, 'ماستر فيكس 1', 'Master Fix', 'sahara', NULL, NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'trial', NULL, NULL, '2026-03-28 21:48:05', 0, NULL, NULL, 'published', '5/abraj_20260315131638_a7620bfe.png', NULL, 'info@masterfix.com', '+90 555 000 000', '', '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-14 21:48:05', '2026-05-12 18:50:50', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(6, 3, 'ماستر فيكس', 'Master Fix', 'golden-maintenance', 'golden-maintenance', NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, 3, 'active', '2024-01-01', '2025-01-01', '2024-01-15 00:00:00', 1, NULL, NULL, 'published', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', '0112345678', '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#ea580c', '#1e3a5f', '#3b82f6', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-16 19:17:17', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(7, 4, 'ماستر فيكس', 'Master Fix', 'electric-pro', 'electric-pro', NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, 3, 'active', '2024-02-01', '2025-02-01', '2024-02-15 00:00:00', 0, NULL, NULL, 'published', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#fbbf24', '#d97706', '#1f2937', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-16 19:17:17', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(8, 5, 'ماستر فيكس', 'Master Fix', 'clean-home', 'clean-home', NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'trial', NULL, NULL, '2026-03-30 19:17:17', 0, NULL, NULL, 'published', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#10b981', '#059669', '#fbbf24', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-16 19:17:17', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(9, 6, 'ماستر فيكس', 'Master Fix', 'decor-style', 'decor-style', NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, 4, 'active', '2024-01-15', '2025-01-15', '2024-01-30 00:00:00', 0, NULL, NULL, 'published', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#8b5cf6', '#6d28d9', '#fbbf24', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-16 19:17:17', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(10, 7, 'ماستر فيكس', 'Master Fix', 'plumbing-expert', 'plumbing-expert', NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'expired', '2023-06-01', '2024-01-01', '2023-06-15 00:00:00', 0, NULL, NULL, 'draft', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#0ea5e9', '#0284c7', '#fbbf24', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-16 19:17:17', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1),
(11, 8, 'ماستر فيكس', 'Master Fix', 'aman-services', 'aman-services', NULL, 'none', 0, 0, NULL, 'pending', 1, NULL, NULL, 'trial', NULL, NULL, '2026-03-23 19:17:17', 0, NULL, NULL, 'draft', NULL, NULL, 'info@masterfix.com', '+90 555 000 000', NULL, '+90 555 000 000', 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3', 'السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7', 'https://facebook.com/masterfix', 'https://twitter.com/masterfix', 'https://instagram.com/masterfix', 'https://linkedin.com/company/masterfix', 'https://youtube.com/@masterfix', 'https://tiktok.com/@masterfix', 'ماستر فيكس — خدمات صيانة احترافية', 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.', NULL, 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا', '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', NULL, NULL, '2026-03-16 19:17:17', '2026-05-09 03:29:29', 'تحتاج إلى صيانة احترافية؟', 'Need Professional Maintenance?', 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.', 'Contact our team now and get fast, professional services with the highest quality.', 'اطلب الخدمة الآن', 'Request Service Now', '/site/demo/contact', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_purchases`
--

CREATE TABLE `tenant_purchases` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `service_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) NOT NULL DEFAULT 'SAR',
  `status` enum('pending','paid','approved','cancelled','refunded','expired') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_ref` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `tenant_notes` text DEFAULT NULL,
  `purchased_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenant_purchases`
--

INSERT INTO `tenant_purchases` (`id`, `tenant_id`, `service_id`, `quantity`, `amount`, `currency`, `status`, `payment_method`, `payment_ref`, `admin_notes`, `tenant_notes`, `purchased_at`, `expires_at`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 5, 7, 1, 120.00, 'SAR', 'cancelled', NULL, NULL, 'بلبلبلب', NULL, NULL, NULL, NULL, '2026-04-09 20:42:46', '2026-05-11 00:39:11'),
(2, 5, 1, 1, 50.00, 'SAR', 'cancelled', NULL, NULL, 'بلبلبلب', NULL, NULL, '2027-04-09 20:42:50', NULL, '2026-04-09 20:42:50', '2026-05-11 00:39:01'),
(3, 5, 1, 1, 50.00, 'SAR', 'cancelled', NULL, NULL, 'بلبلب', NULL, NULL, '2027-04-09 20:44:06', NULL, '2026-04-09 20:44:06', '2026-05-11 00:38:54'),
(4, 5, 1, 1, 50.00, 'SAR', 'cancelled', NULL, NULL, 'لالبلب', NULL, '2026-04-09 21:03:35', '2027-04-09 21:03:35', NULL, '2026-04-09 21:03:35', '2026-05-11 00:38:39'),
(5, 5, 3, 1, 100.00, 'SAR', 'approved', NULL, NULL, '', NULL, '2026-04-12 09:40:01', NULL, '2026-05-10 23:20:10', '2026-04-12 09:40:01', '2026-05-10 23:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_title` varchar(255) DEFAULT NULL,
  `client_title_en` varchar(255) DEFAULT NULL,
  `client_image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `content_en` text DEFAULT NULL,
  `rating` tinyint(1) DEFAULT 5,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `tenant_id`, `client_name`, `client_title`, `client_title_en`, `client_image`, `content`, `content_en`, `rating`, `show_on_home`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'عبدالله محمد', 'مالك فيلا', 'Homeowner', NULL, 'خدمة ممتازة وسريعة. جاءوا في الموعد وأصلحوا المكيف بكفاءة عالية. أنصح الجميع بالتعامل معهم.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 5, 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(2, 6, 'نورة السالم', 'ربة منزل', 'Satisfied Customer', NULL, 'تعاملت معهم لإصلاح تسريب في المطبخ. عمل نظيف وسعر معقول. شكراً لفريق العمل.', 'Very professional team. They arrived on time and did an excellent job.', 5, 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(3, 6, 'فهد العتيبي', 'صاحب شركة', 'Homeowner', NULL, 'تعاقدنا معهم للصيانة الدورية لمكاتبنا. خدمة احترافية والتزام بالموعد.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 4, 1, 3, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(4, 9, 'منى الغامدي', 'مالكة فيلا', 'Business Owner', NULL, 'صمموا لي فيلتي بالكامل. ذوق رائع والتزام بالميزانية. شكراً سارة وفريقك.', 'Great experience with this company. Fair prices and high quality work.', 5, 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(5, 9, 'خالد العمري', 'رجل أعمال', 'Satisfied Customer', NULL, 'شركة محترفة جداً. التصميم 3D كان مطابق للواقع 100%. أنصح بهم.', 'Very professional team. They arrived on time and did an excellent job.', 5, 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(6, 8, 'أم محمد', 'ربة منزل', 'Business Owner', NULL, 'شركة التنظيف هذه رائعة! الفلية صارت نظيفة جداً والأسعار معقولة.', 'Great experience with this company. Fair prices and high quality work.', 5, 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(7, 8, 'سعود الشمري', 'موظف', 'Homeowner', NULL, 'نظفوا شقتي بشكل ممتاز. فريق محترم ومنظم. سأتكرر معهم.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 4, 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(8, 7, 'يوسف الحربي', 'مالك عقار', 'Homeowner', NULL, 'خدمة 24 ساعة حقيقية! جاءوا منتصف الليل وأصلحوا العطل. شكراً لكم.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 5, 1, 1, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(9, 7, 'هند القحطاني', 'صاحبة منزل', 'Homeowner', NULL, 'ركبوا لي إضاءة LED في البيت كله. عمل ممتاز وفاتورة الكهرباء قلت 40%!', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 5, 1, 2, 'active', '2026-03-16 19:17:17', '2026-03-16 20:35:13'),
(10, 6, 'عبدالله محمد', 'مالك فيلا', 'Homeowner', NULL, 'خدمة ممتازة وسريعة. جاءوا في الموعد وأصلحوا المكيف بكفاءة عالية. أنصح الجميع بالتعامل معهم.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 5, 1, 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(11, 6, 'نورة السالم', 'ربة منزل', 'Satisfied Customer', NULL, 'تعاملت معهم لإصلاح تسريب في المطبخ. عمل نظيف وسعر معقول. شكراً لفريق العمل.', 'Very professional team. They arrived on time and did an excellent job.', 5, 1, 2, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(12, 6, 'فهد العتيبي', 'صاحب شركة', 'Homeowner', NULL, 'تعاقدنا معهم للصيانة الدورية لمكاتبنا. خدمة احترافية والتزام بالموعد.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 4, 1, 3, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(13, 9, 'منى الغامدي', 'مالكة فيلا', 'Business Owner', NULL, 'صمموا لي فيلتي بالكامل. ذوق رائع والتزام بالميزانية. شكراً سارة وفريقك.', 'Great experience with this company. Fair prices and high quality work.', 5, 1, 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(14, 9, 'خالد العمري', 'رجل أعمال', 'Satisfied Customer', NULL, 'شركة محترفة جداً. التصميم 3D كان مطابق للواقع 100%. أنصح بهم.', 'Very professional team. They arrived on time and did an excellent job.', 5, 1, 2, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(15, 8, 'أم محمد', 'ربة منزل', 'Business Owner', NULL, 'شركة التنظيف هذه رائعة! الفلية صارت نظيفة جداً والأسعار معقولة.', 'Great experience with this company. Fair prices and high quality work.', 5, 1, 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(16, 8, 'سعود الشمري', 'موظف', 'Homeowner', NULL, 'نظفوا شقتي بشكل ممتاز. فريق محترم ومنظم. سأتكرر معهم.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 4, 1, 2, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(17, 7, 'يوسف الحربي', 'مالك عقار', 'Homeowner', NULL, 'خدمة 24 ساعة حقيقية! جاءوا منتصف الليل وأصلحوا العطل. شكراً لكم.', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 5, 1, 1, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(18, 7, 'هند القحطاني', 'صاحبة منزل', 'Homeowner', NULL, 'ركبوا لي إضاءة LED في البيت كله. عمل ممتاز وفاتورة الكهرباء قلت 40%!', 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.', 5, 1, 2, 'active', '2026-03-16 19:31:47', '2026-03-16 20:35:13'),
(19, 5, 'نورة الحسن', 'ربة منزل', NULL, NULL, 'خدمة تنظيف ممتازة! المنزل أصبح نظيفاً جداً.', NULL, 5, 1, 1, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55'),
(20, 5, 'مؤسسة النور', 'شركة', NULL, NULL, 'نتعامل معهم بشكل أسبوعي لتنظيف مكاتبنا.', NULL, 5, 1, 2, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55'),
(21, 5, 'فهد القحطاني', 'صاحب عقار', NULL, NULL, 'قاموا بتنظيف شققتي بعد التشطيب.', NULL, 4, 1, 3, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'اسم القالب بالعربية',
  `name_en` varchar(100) DEFAULT NULL COMMENT 'اسم القالب بالإنجليزية',
  `slug` varchar(100) NOT NULL COMMENT 'معرف القالب الفريد',
  `description` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `category` enum('general','maintenance','decor','electric','plumbing','cleaning','medical','realestate','restaurant','education','fitness','legal','other') NOT NULL DEFAULT 'general',
  `preview_image` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_premium` tinyint(1) NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `price` decimal(10,2) DEFAULT 0.00,
  `currency` varchar(10) DEFAULT 'SAR',
  `payment_link` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `version` varchar(20) DEFAULT '1.0.0',
  `settings_schema` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `name_en`, `slug`, `description`, `description_en`, `category`, `preview_image`, `thumbnail`, `is_active`, `is_premium`, `is_paid`, `price`, `currency`, `payment_link`, `sort_order`, `version`, `settings_schema`, `created_at`, `updated_at`) VALUES
(1, 'ماستر فيكس', 'Master Fix', 'master', 'ثيم احترافي عصري — خلفية داكنة مع لون سيان — مثالي لشركات الصيانة والخدمات', NULL, 'maintenance', NULL, NULL, 1, 0, 0, 0.00, 'SAR', NULL, 0, '1.0.0', NULL, '2026-05-09 15:51:05', '2026-05-09 15:51:05'),
(2, 'ركاز للصيانة', 'Rakaz Maintenance', 'rakaz', 'ثيم احترافي بألوان نحاسية دافئة لشركات الصيانة والخدمات المنزلية', 'Professional warm copper theme for maintenance and home services companies', 'maintenance', NULL, NULL, 1, 0, 0, 0.00, 'SAR', NULL, 2, '1.0.0', NULL, '2026-05-09 14:28:27', '2026-05-09 14:28:27'),
(4, 'لمعة كلين - نوف', 'Nove Clean', 'nove', 'ثيم برتقالي جريء — مثالي لشركات التنظيف', 'Bold orange theme — ideal for cleaning companies', 'cleaning', 'uploads/themes/previews/nove-preview.png', 'uploads/themes/previews/nove-preview.png', 1, 0, 0, 0.00, 'SAR', NULL, 4, '1.0.0', NULL, '2026-05-09 22:28:11', '2026-05-09 22:28:11'),
(13, 'تك برو', 'TechPro', 'techpro', 'ثيم احترافي بألوان بنفسجية تقنية عصرية', 'Professional theme with modern violet tech colors', '', NULL, NULL, 1, 0, 0, 0.00, 'SAR', NULL, 0, '1.0.0', NULL, '2026-05-10 05:59:52', '2026-05-10 05:59:52'),
(14, 'كلين برو', 'CleanPro', 'cleanpro', 'قالب احترافي لشركات تنظيف السجاد والمفروشات بتصميم أزرق أنيق', 'Professional carpet cleaning template with elegant blue design', 'cleaning', NULL, NULL, 1, 0, 0, 0.00, 'SAR', NULL, 10, '1.0.0', NULL, '2026-05-10 10:55:36', '2026-05-10 10:55:36'),
(15, 'تك برو', 'TakPro', 'takpro', 'ثيم احترافي بألوان برتقالية دافئة، مصمم لقطاع الخدمات مع تصميم عصري وجذاب يدعم ثنائية اللغة والتصميم المتجاوب.', 'A professional theme with warm orange colors, designed for the services sector with a modern and attractive responsive design with bilingual support.', 'general', 'themes/takpro/preview.png', NULL, 1, 0, 0, 0.00, 'SAR', NULL, 0, '1.0.0', NULL, '2026-05-10 13:25:23', '2026-05-10 13:25:23'),
(16, 'نوفا - احترافي', 'Nova - Professional', 'nova', 'قالب عصري واحترافي متوافق مع جميع الأجهزة', 'Modern and professional template, fully responsive', 'general', 'themes/previews/nova-preview.png', NULL, 1, 0, 0, 0.00, 'SAR', NULL, 1, '2.0', NULL, '2026-05-10 23:09:44', '2026-05-10 23:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `theme_contents`
--

CREATE TABLE `theme_contents` (
  `id` int(11) UNSIGNED NOT NULL,
  `theme_id` int(11) UNSIGNED NOT NULL,
  `section_type` varchar(50) NOT NULL COMMENT 'hero, about, services, testimonials, contact, footer, custom',
  `content_key` varchar(100) DEFAULT NULL COMMENT 'مفتاح المحتوى مثل: hero_title, hero_subtitle, about_text',
  `content_ar` text DEFAULT NULL COMMENT 'المحتوى بالعربية (نص أو JSON)',
  `content_en` text DEFAULT NULL COMMENT 'المحتوى بالإنجليزية',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_contents`
--

INSERT INTO `theme_contents` (`id`, `theme_id`, `section_type`, `content_key`, `content_ar`, `content_en`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1181, 1, 'hero', 'hero_title', 'خدمات <span style=\"color:#06b6d4\">الصيانة</span> الحديثة باحترافية عالية', 'Professional <span style=\"color:#06b6d4\">Maintenance</span> Services with Excellence', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1182, 1, 'hero', 'hero_subtitle', 'أكثر من 5000 عميل يثق بنا', 'Trusted by over 5,000 clients', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1183, 1, 'hero', 'hero_description', 'نقدم حلول صيانة متكاملة للمنازل والشركات بأحدث التقنيات، سرعة استجابة، وفريق متخصص لضمان أفضل النتائج. نعمل على مدار الساعة لتوفير خدمات موثوقة تلبي جميع احتياجاتكم.', 'We deliver integrated maintenance solutions for homes and companies with the latest technologies, fast response, and a specialized team to ensure the best results. We operate around the clock to provide reliable services.', 3, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1184, 1, 'hero', 'hero_button_text', 'احجز خدمة', 'Book Now', 4, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1185, 1, 'services', 'svc_electric', '{\"title_ar\":\"صيانة الكهرباء\",\"title_en\":\"Electrical Services\",\"description_ar\":\"تمديدات كهربائية، صيانة، تركيب وفحص كامل للمنازل والمكاتب. فريق معتمد بخبرة تتجاوز 10 سنوات في جميع أنواع الأعمال الكهربائية.\",\"description_en\":\"Electrical wiring, maintenance, installation and full inspection for homes and offices. Certified team with 10+ years of experience.\",\"icon\":\"fas fa-bolt\",\"price\":\"150 ₺\",\"price_text\":\"150 ₺\",\"show_on_home\":1}', '{\"title_en\":\"Electrical Services\",\"description_en\":\"Electrical wiring, maintenance, installation and full inspection for homes and offices. Certified team with 10+ years of experience.\",\"price\":\"150 TL\"}', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1186, 1, 'services', 'svc_plumbing', '{\"title_ar\":\"خدمات السباكة\",\"title_en\":\"Plumbing Services\",\"description_ar\":\"إصلاح التسريبات وصيانة وتركيب الأنابيب بأحدث التقنيات. نقدم خدمات طوارئ على مدار الساعة مع ضمان على جميع أعمالنا.\",\"description_en\":\"Leak repair, pipe maintenance and installation with latest technology. 24\\/7 emergency service with warranty on all work.\",\"icon\":\"fas fa-faucet-drip\",\"price\":\"100 ₺\",\"price_text\":\"100 ₺\",\"show_on_home\":1}', '{\"title_en\":\"Plumbing Services\",\"description_en\":\"Leak repair, pipe maintenance and installation with latest technology. 24\\/7 emergency service with warranty on all work.\",\"price\":\"100 TL\"}', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1187, 1, 'services', 'svc_ac', '{\"title_ar\":\"التكييف والتبريد\",\"title_en\":\"AC & Cooling\",\"description_ar\":\"صيانة التكييف وحلول تبريد ذكية. تشمل الخدمة التنظيف، تعبئة الغاز، فحص الضغط، وتركيب الأجهزة الجديدة.\",\"description_en\":\"AC maintenance and smart cooling solutions. Services include cleaning, gas refill, pressure testing, and new unit installation.\",\"icon\":\"fas fa-snowflake\",\"price\":\"200 ₺\",\"price_text\":\"200 ₺\",\"show_on_home\":1}', '{\"title_en\":\"AC & Cooling\",\"description_en\":\"AC maintenance and smart cooling solutions. Services include cleaning, gas refill, pressure testing, and new unit installation.\",\"price\":\"200 TL\"}', 3, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1188, 1, 'services', 'svc_home', '{\"title_ar\":\"إصلاح المنازل\",\"title_en\":\"Home Repair\",\"description_ar\":\"خدمات احترافية لمعالجة جميع أعطال المنزل من دهان ونجارة وبلاط وأعمال سباكة خفيفة. فريق شامل تحت سقف واحد.\",\"description_en\":\"Professional services for all home repairs including painting, carpentry, tiling, and light plumbing. Complete team under one roof.\",\"icon\":\"fas fa-house-chimney\",\"price\":\"80 ₺\",\"price_text\":\"80 ₺\",\"show_on_home\":1}', '{\"title_en\":\"Home Repair\",\"description_en\":\"Professional services for all home repairs including painting, carpentry, tiling, and light plumbing. Complete team under one roof.\",\"price\":\"80 TL\"}', 4, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1189, 1, 'services', 'svc_painting', '{\"title_ar\":\"الدهانات والديكور\",\"title_en\":\"Painting & Decor\",\"description_ar\":\"دهانات داخلية وخارجية بأفضل أنواع الطلاء. تشمل الخدمة التحضير والتنظيف والتشطيب مع ضمان نظافة المكان.\",\"description_en\":\"Interior and exterior painting with premium materials. Includes surface preparation, cleaning, and finishing with site cleanliness guarantee.\",\"icon\":\"fas fa-paint-roller\",\"price\":\"120 ₺\",\"price_text\":\"120 ₺\",\"show_on_home\":1}', '{\"title_en\":\"Painting & Decor\",\"description_en\":\"Interior and exterior painting with premium materials. Includes surface preparation, cleaning, and finishing with site cleanliness guarantee.\",\"price\":\"120 TL\"}', 5, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1190, 1, 'services', 'svc_lock', '{\"title_ar\":\"أقفال وأبواب\",\"title_en\":\"Locks & Doors\",\"description_ar\":\"تركيب وإصلاح الأقفال والأبواب بكل أنواعها. نتعامل مع جميع الماركات العالمية ونوفر قطع الغيار الأصلية.\",\"description_en\":\"Installation and repair of all lock and door types. We work with all major brands and provide genuine spare parts.\",\"icon\":\"fas fa-lock\",\"price\":\"90 ₺\",\"price_text\":\"90 ₺\",\"show_on_home\":1}', '{\"title_en\":\"Locks & Doors\",\"description_en\":\"Installation and repair of all lock and door types. We work with all major brands and provide genuine spare parts.\",\"price\":\"90 TL\"}', 6, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1191, 1, 'testimonials', 'testimonial_1', '{\"client_name\":\"أحمد محمد\",\"client_name_en\":\"Ahmed Mohammed\",\"client_title\":\"مدير شركة\",\"client_title_en\":\"Company Manager\",\"content\":\"خدمة ممتازة وسريعة. الفريق محترف جداً وأنصح الجميع بالتعامل معهم. وصلوا خلال ساعة وخلصوا الشغل بإتقان.\",\"content_en\":\"Excellent and fast service. Very professional team, I recommend them to everyone. Arrived within an hour and completed the work perfectly.\",\"rating\":5}', '{\"client_name\":\"Ahmed Mohammed\",\"client_title\":\"Company Manager\",\"content\":\"Excellent and fast service. Very professional team, I recommend them to everyone. Arrived within an hour and completed the work perfectly.\",\"rating\":5}', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1192, 1, 'testimonials', 'testimonial_2', '{\"client_name\":\"سارة عبدالله\",\"client_name_en\":\"Sara Abdullah\",\"client_title\":\"ربة منزل\",\"client_title_en\":\"Homeowner\",\"content\":\"تجربة رائعة من البداية للنهاية. العمل تم بإتقان ونظافة عالية. السعر كان معقول جداً مقارنة بالجودة المقدمة.\",\"content_en\":\"Amazing experience from start to finish. The work was done with perfection and high cleanliness. Very reasonable price for the quality.\",\"rating\":5}', '{\"client_name\":\"Sara Abdullah\",\"client_title\":\"Homeowner\",\"content\":\"Amazing experience from start to finish. The work was done with perfection and high cleanliness. Very reasonable price for the quality.\",\"rating\":5}', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1193, 1, 'testimonials', 'testimonial_3', '{\"client_name\":\"خالد العمري\",\"client_name_en\":\"Khaled Al-Omari\",\"client_title\":\"مؤسس\",\"client_title_en\":\"Founder\",\"content\":\"تعاملت معهم عدة مرات وفي كل مرة أكون سعيد بالنتائج. أسعار منافسة وجودة عالية. أنصح بهم لأي مشروع صيانة.\",\"content_en\":\"Dealt with them multiple times, always happy with results. Competitive prices and high quality. I recommend them for any maintenance project.\",\"rating\":5}', '{\"client_name\":\"Khaled Al-Omari\",\"client_title\":\"Founder\",\"content\":\"Dealt with them multiple times, always happy with results. Competitive prices and high quality. I recommend them for any maintenance project.\",\"rating\":5}', 3, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1194, 1, 'testimonials', 'testimonial_4', '{\"client_name\":\"نورة السعيد\",\"client_name_en\":\"Noura Al-Saeed\",\"client_title\":\"مهندسة\",\"client_title_en\":\"Engineer\",\"content\":\"احترافية عالية والتزام بالمواعيد. فريق عمل منظم ونظيف. النتيجة فاقت توقعاتي وسأكرر التجربة بالتأكيد.\",\"content_en\":\"Highly professional and punctual. Organized and clean team. Results exceeded my expectations and I will definitely use them again.\",\"rating\":5}', '{\"client_name\":\"Noura Al-Saeed\",\"client_title\":\"Engineer\",\"content\":\"Highly professional and punctual. Organized and clean team. Results exceeded my expectations and I will definitely use them again.\",\"rating\":5}', 4, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1195, 1, 'features', 'feature_1', '{\"title_ar\":\"استجابة سريعة ودعم طوارئ\",\"title_en\":\"Fast Response & Emergency\",\"description_ar\":\"نصل إليكم بسرعة مع فريق مجهز وجاهز لأي حالة طوارئ. متاحون على مدار الساعة 7 أيام في الأسبوع.\",\"description_en\":\"Quick arrival with equipped team for any emergency. Available 24\\/7, 7 days a week.\",\"icon\":\"fas fa-bolt\"}', '{\"title_en\":\"Fast Response & Emergency\",\"description_en\":\"Quick arrival with equipped team for any emergency. Available 24\\/7, 7 days a week.\"}', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1196, 1, 'features', 'feature_2', '{\"title_ar\":\"فنيون محترفون ومعتمدون\",\"title_en\":\"Expert Certified Technicians\",\"description_ar\":\"فريق معتمد بخبرة عملية واسعة في جميع المجالات. جميع الفنيين حاصلون على شهادات معتمدة.\",\"description_en\":\"Certified team with extensive practical experience in all fields. All technicians hold accredited certificates.\",\"icon\":\"fas fa-id-badge\"}', '{\"title_en\":\"Expert Certified Technicians\",\"description_en\":\"Certified team with extensive practical experience in all fields. All technicians hold accredited certificates.\"}', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1197, 1, 'features', 'feature_3', '{\"title_ar\":\"أسعار مناسبة وجودة عالية\",\"title_en\":\"Competitive Prices & High Quality\",\"description_ar\":\"جودة عالية بأسعار مناسبة للجميع مع ضمان الخدمة. أسعار شفافة بدون مفاجآت.\",\"description_en\":\"High quality at affordable prices with service guarantee. Transparent pricing with no surprises.\",\"icon\":\"fas fa-tags\"}', '{\"title_en\":\"Competitive Prices & High Quality\",\"description_en\":\"High quality at affordable prices with service guarantee. Transparent pricing with no surprises.\"}', 3, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1198, 1, 'features', 'feature_4', '{\"title_ar\":\"معدات حديثة وفحص ذكي\",\"title_en\":\"Modern Equipment & Smart Inspection\",\"description_ar\":\"نستخدم أحدث الأدوات والتقنيات مع فحص ذكي شامل بعد كل خدمة. تقرير مفصل بالحالة.\",\"description_en\":\"Latest tools and technology with comprehensive smart inspection after each service. Detailed status report.\",\"icon\":\"fas fa-tools\"}', '{\"title_en\":\"Modern Equipment & Smart Inspection\",\"description_en\":\"Latest tools and technology with comprehensive smart inspection after each service. Detailed status report.\"}', 4, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1199, 1, 'stats', 'stat_1', '{\"label_ar\":\"10+ سنوات خبرة\",\"label_en\":\"10+ Years Exp.\",\"value\":\"10+\",\"icon\":\"fas fa-clock\"}', '{\"label_en\":\"10+ Years Exp.\",\"value\":\"10+\"}', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1200, 1, 'stats', 'stat_2', '{\"label_ar\":\"500+ مشروع منجز\",\"label_en\":\"500+ Projects Done\",\"value\":\"500+\",\"icon\":\"fas fa-project-diagram\"}', '{\"label_en\":\"500+ Projects Done\",\"value\":\"500+\"}', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1201, 1, 'stats', 'stat_3', '{\"label_ar\":\"5,000+ عميل سعيد\",\"label_en\":\"5,000+ Happy Clients\",\"value\":\"5K+\",\"icon\":\"fas fa-users\"}', '{\"label_en\":\"5,000+ Happy Clients\",\"value\":\"5K+\"}', 3, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1202, 1, 'stats', 'stat_4', '{\"label_ar\":\"98% نسبة الرضا\",\"label_en\":\"98% Satisfaction\",\"value\":\"98%\",\"icon\":\"fas fa-chart-line\"}', '{\"label_en\":\"98% Satisfaction\",\"value\":\"98%\"}', 4, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1203, 1, 'faq', 'faq_1', '{\"question_ar\":\"ما هي خدماتكم؟\",\"question_en\":\"What are your services?\",\"answer_ar\":\"نقدم خدمات صيانة شاملة تشمل الكهرباء، السباكة، التكييف، الدهانات، إصلاح المنازل، والأقفال والأبواب. كل خدمة يقدمها فني متخصص ومعتمد.\",\"answer_en\":\"We offer comprehensive maintenance including electrical, plumbing, AC, painting, home repair, and locks & doors. Each service is provided by a specialized certified technician.\",\"category\":\"services\"}', '{\"question_en\":\"What are your services?\",\"answer_en\":\"We offer comprehensive maintenance including electrical, plumbing, AC, painting, home repair, and locks & doors. Each service is provided by a specialized certified technician.\",\"category\":\"services\"}', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1204, 1, 'faq', 'faq_2', '{\"question_ar\":\"ما هي أوقات العمل؟\",\"question_en\":\"What are your working hours?\",\"answer_ar\":\"فريقنا متاح 24\\/7 للطوارئ، وخدمات المواعيد العادية من السبت إلى الخميس من 8 صباحاً حتى 8 مساءً. الجمعة عطلة رسمية.\",\"answer_en\":\"Our team is available 24\\/7 for emergencies. Regular appointments: Saturday to Thursday, 8 AM to 8 PM. Friday is an official day off.\",\"category\":\"general\"}', '{\"question_en\":\"What are your working hours?\",\"answer_en\":\"Our team is available 24\\/7 for emergencies. Regular appointments: Saturday to Thursday, 8 AM to 8 PM. Friday is an official day off.\",\"category\":\"general\"}', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1205, 1, 'faq', 'faq_3', '{\"question_ar\":\"كيف أحجز موعد؟\",\"question_en\":\"How do I book an appointment?\",\"answer_ar\":\"يمكنك الحجز عبر الموقع من صفحة \\\"احجز الآن\\\"، أو الاتصال المباشر على الرقم +90 555 000 000، أو الواتساب. سيتواصل معك فريقنا خلال 15 دقيقة لتأكيد الموعد.\",\"answer_en\":\"You can book via our website \\\"Book Now\\\" page, direct call at +90 555 000 000, or WhatsApp. Our team will contact you within 15 minutes to confirm.\",\"category\":\"booking\"}', '{\"question_en\":\"How do I book an appointment?\",\"answer_en\":\"You can book via our website \\\"Book Now\\\" page, direct call at +90 555 000 000, or WhatsApp. Our team will contact you within 15 minutes to confirm.\",\"category\":\"booking\"}', 3, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1206, 1, 'faq', 'faq_4', '{\"question_ar\":\"هل تقدمون ضماناً على الخدمات؟\",\"question_en\":\"Do you offer service warranty?\",\"answer_ar\":\"نعم، نقدم ضماناً على جميع أعمال الصيانة لمدة تصل إلى 6 أشهر حسب نوع الخدمة. في حالة تكرار العطل يتم الإصلاح مجاناً خلال فترة الضمان.\",\"answer_en\":\"Yes, we provide warranty on all maintenance work for up to 6 months depending on service type. Recurring issues are fixed for free during warranty.\",\"category\":\"services\"}', '{\"question_en\":\"Do you offer service warranty?\",\"answer_en\":\"Yes, we provide warranty on all maintenance work for up to 6 months depending on service type. Recurring issues are fixed for free during warranty.\",\"category\":\"services\"}', 4, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1207, 1, 'faq', 'faq_5', '{\"question_ar\":\"ما هي مناطق التغطية؟\",\"question_en\":\"What are your coverage areas?\",\"answer_ar\":\"نغطي جميع مناطق إسطنبول وضواحيها. بالنسبة للمناطق البعيدة يرجى التواصل معنا للتأكد من إمكانية الوصول والتكلفة.\",\"answer_en\":\"We cover all areas of Istanbul and suburbs. For remote areas, please contact us to confirm availability and any additional travel costs.\",\"category\":\"general\"}', '{\"question_en\":\"What are your coverage areas?\",\"answer_en\":\"We cover all areas of Istanbul and suburbs. For remote areas, please contact us to confirm availability and any additional travel costs.\",\"category\":\"general\"}', 5, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1208, 1, 'faq', 'faq_6', '{\"question_ar\":\"كيف يتم تسعير الخدمات؟\",\"question_en\":\"How are services priced?\",\"answer_ar\":\"نعمل على أساس تسعير عادل وشفاف. بعد الفحص الأولي المجاني يتم إبلاغك بالتكلفة النهائية قبل بدء العمل بدون أي رسوم مخفية أو مفاجآت.\",\"answer_en\":\"We work on fair and transparent pricing. After a free initial inspection, you will be informed of the final cost before work starts with no hidden fees.\",\"category\":\"pricing\"}', '{\"question_en\":\"How are services priced?\",\"answer_en\":\"We work on fair and transparent pricing. After a free initial inspection, you will be informed of the final cost before work starts with no hidden fees.\",\"category\":\"pricing\"}', 6, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1209, 1, 'about', 'about_content', '<p>نحن فريق محترف متخصص في تقديم أعلى مستويات الخدمة في مجال الصيانة المنزلية والتجارية. بخبرة تتجاوز 10 سنوات في السوق التركي، وشغف مستمر بالتميز والابتكار.</p><p>نعمل بأحدث المعدات والتقنيات المتطورة لضمان نتائج تفوق التوقعات في كل مرة. فريقنا المكون من أكثر من 25 فنياً معتمداً جاهز لخدمتكم على مدار الساعة، في أي وقت وفي أي مكان.</p><p>نؤمن بأن الجودة ليست خياراً بل معياراً أساسياً لكل عمل نقوم به. لذلك نقدم ضماناً شاملاً على جميع خدماتنا ونسعى دائماً لبناء علاقات طويلة الأمد مع عملائنا المميزين.</p>', '<p>We are a professional team dedicated to providing top-quality home and commercial maintenance services. With over 10 years of experience in the Turkish market and a passion for excellence and innovation.</p><p>We use the latest equipment and cutting-edge technology to ensure results that exceed expectations every time. Our team of 25+ certified technicians is ready to serve you 24/7, anytime, anywhere.</p><p>We believe quality is not an option but a fundamental standard for every job we do. That is why we offer comprehensive warranty on all our services and strive to build lasting relationships with our valued clients.</p>', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1210, 1, 'contact', 'contact_info', '{\"phone\":\"+90 555 000 000\",\"email\":\"info@masterfix.com\",\"whatsapp\":\"+90 555 000 000\",\"address\":\"إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3\",\"working_hours\":\"السبت - الخميس: 8 صباحاً - 8 مساءً\\nالجمعة: مغلق\\nالطوارئ: 24\\/7\"}', '{\"phone\":\"+90 555 000 000\",\"email\":\"info@masterfix.com\",\"whatsapp\":\"+90 555 000 000\",\"address\":\"Istanbul, Turkey, Istiklal Street, Business Building, Floor 3\",\"working_hours\":\"Sat - Thu: 8 AM - 8 PM\\nFriday: Closed\\nEmergency: 24\\/7\"}', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1211, 1, 'partners', 'partner_1', '{\"name_ar\":\"شركة الأبنية المتقدمة\",\"name_en\":\"Advanced Buildings Co.\",\"website\":\"https:\\/\\/advanced-buildings.com\",\"icon\":\"fas fa-building\"}', '{\"name_en\":\"Advanced Buildings Co.\",\"website\":\"https:\\/\\/advanced-buildings.com\"}', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1212, 1, 'partners', 'partner_2', '{\"name_ar\":\"مؤسسة الطاقة الذكية\",\"name_en\":\"Smart Energy Corp.\",\"website\":\"https:\\/\\/smart-energy.com\",\"icon\":\"fas fa-building\"}', '{\"name_en\":\"Smart Energy Corp.\",\"website\":\"https:\\/\\/smart-energy.com\"}', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1213, 1, 'partners', 'partner_3', '{\"name_ar\":\"شركة الديكور الملكي\",\"name_en\":\"Royal Decor Co.\",\"website\":\"https:\\/\\/royal-decor.com\",\"icon\":\"fas fa-building\"}', '{\"name_en\":\"Royal Decor Co.\",\"website\":\"https:\\/\\/royal-decor.com\"}', 3, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1214, 1, 'partners', 'partner_4', '{\"name_ar\":\"مجموعة الأمن والحماية\",\"name_en\":\"Security Group\",\"website\":\"https:\\/\\/security-group.com\",\"icon\":\"fas fa-building\"}', '{\"name_en\":\"Security Group\",\"website\":\"https:\\/\\/security-group.com\"}', 4, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1215, 1, 'partners', 'partner_5', '{\"name_ar\":\"شركة الأنابيب الأولى\",\"name_en\":\"First Pipes Co.\",\"website\":\"https:\\/\\/first-pipes.com\",\"icon\":\"fas fa-building\"}', '{\"name_en\":\"First Pipes Co.\",\"website\":\"https:\\/\\/first-pipes.com\"}', 5, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1216, 1, 'partners', 'partner_6', '{\"name_ar\":\"مؤسسة التبريد المتطور\",\"name_en\":\"Advanced Cooling Corp.\",\"website\":\"https:\\/\\/advanced-cooling.com\",\"icon\":\"fas fa-building\"}', '{\"name_en\":\"Advanced Cooling Corp.\",\"website\":\"https:\\/\\/advanced-cooling.com\"}', 6, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1217, 1, 'booking', 'booking_title', 'احجز موعدك بسهولة', 'Book Your Appointment Easily', 1, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1218, 1, 'booking', 'booking_description', 'اختر الخدمة المناسبة لك واحجز موعدك في الوقت المفضل. فريقنا المحترف سيتواصل معك لتأكيد الحجز خلال 15 دقيقة.', 'Choose the right service and book your appointment at your preferred time. Our professional team will contact you to confirm within 15 minutes.', 2, 1, '2026-05-09 22:51:05', '2026-05-09 22:51:05'),
(1219, 2, 'hero', 'hero_title', 'حلول صيانة <span style=\"color:#c97b47\">موثوقة</span> لمنزلك', 'Reliable <span style=\"color:#c97b47\">Maintenance</span> Solutions for Your Home', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1220, 2, 'hero', 'hero_subtitle', 'أكثر من 5000 عميل يثق بنا', 'Trusted by over 5,000 clients', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1221, 2, 'hero', 'hero_description', 'شركة ركاز للصيانة هي الشريك الأمثل لجميع احتياجاتك من الصيانة المنزلية والتجارية. نعمل بأحدث التقنيات وأعلى معايير الجودة لنضمن رضاكم الكامل. خبرة تتجاوز 15 عاماً في تقديم خدمات صيانة احترافية.', 'Rakaz Maintenance is your ideal partner for all home and commercial maintenance needs. We work with the latest technologies and highest quality standards.', 3, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1222, 2, 'hero', 'hero_button_text', 'احجز خدمة الآن', 'Book Now', 4, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1223, 2, 'services', 'svc_ac', '{\"title_ar\":\"صيانة المكيفات\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"خدمة صيانة وتنظيف المكيفات بأنواعها المختلفة. نقوم بالكشف عن الأعطال وإصلاحها، وتنظيف الفلاتر والفريون، وضمان كفاءة التبريد.\",\"description_en\":\"AC maintenance and cleaning for all types.\",\"icon\":\"fas fa-snowflake\",\"price_text\":\"ابدأ من 150 ر.س\",\"show_on_home\":1}', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1224, 2, 'services', 'svc_plumbing', '{\"title_ar\":\"سباكة منزلية\",\"title_en\":\"Plumbing\",\"description_ar\":\"حلول سباكة متكاملة تشمل إصلاح التسريبات، تركيب الأنابيب، صيانة الحمامات والمطابخ، وتنظيف المجاري.\",\"description_en\":\"Complete plumbing solutions.\",\"icon\":\"fas fa-wrench\",\"price_text\":\"ابدأ من 100 ر.س\",\"show_on_home\":1}', '', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1225, 2, 'services', 'svc_electric', '{\"title_ar\":\"كهرباء المنازل\",\"title_en\":\"Electrical\",\"description_ar\":\"خدمات كهربائية شاملة: تمديدات كهربائية، إصلاح الأعطال، تركيب الإضاءة، وصيانة لوحات التوزيع.\",\"description_en\":\"Complete electrical services.\",\"icon\":\"fas fa-bolt\",\"price_text\":\"ابدأ من 150 ر.س\",\"show_on_home\":1}', '', 3, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1226, 2, 'services', 'svc_painting', '{\"title_ar\":\"دهانات وتشطيبات\",\"title_en\":\"Painting\",\"description_ar\":\"خدمات دهان احترافية للمنازل والمكاتب. نستخدم أجود أنواع الدهانات مع فريق فنيين متخصصين.\",\"description_en\":\"Professional painting services.\",\"icon\":\"fas fa-paint-roller\",\"price_text\":\"ابدأ من 120 ر.س\",\"show_on_home\":1}', '', 4, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1227, 2, 'services', 'svc_carpentry', '{\"title_ar\":\"أعمال النجارة\",\"title_en\":\"Carpentry\",\"description_ar\":\"خدمات نجارة متخصصة تشمل إصلاح الأثاث، تركيب الأبواب والنوافذ، وصناعة المطابخ والأرفف.\",\"description_en\":\"Specialized carpentry services.\",\"icon\":\"fas fa-hammer\",\"price_text\":\"ابدأ من 130 ر.س\",\"show_on_home\":1}', '', 5, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1228, 2, 'services', 'svc_cleaning', '{\"title_ar\":\"تنظيف شامل\",\"title_en\":\"Cleaning\",\"description_ar\":\"خدمات تنظيف شاملة للمنازل والمكاتب بأحدث المعدات والمواد الآمنة.\",\"description_en\":\"Comprehensive cleaning services.\",\"icon\":\"fas fa-broom\",\"price_text\":\"ابدأ من 80 ر.س\",\"show_on_home\":1}', '', 6, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1229, 2, 'services', 'svc_general', '{\"title_ar\":\"صيانة عامة\",\"title_en\":\"General Maintenance\",\"description_ar\":\"خدمة صيانة عامة تشمل إصلاح الأبواب، النوافذ، الأثاث، والأجهزة المنزلية.\",\"description_en\":\"General maintenance service.\",\"icon\":\"fas fa-tools\",\"price_text\":\"ابدأ من 90 ر.س\",\"show_on_home\":1}', '', 7, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1230, 2, 'services', 'svc_install', '{\"title_ar\":\"تركيبات متنوعة\",\"title_en\":\"Installations\",\"description_ar\":\"خدمات تركيب احترافية للأجهزة المنزلية، الستائر، المرايا، والأرفف.\",\"description_en\":\"Professional installation services.\",\"icon\":\"fas fa-cog\",\"price_text\":\"ابدأ من 70 ر.س\",\"show_on_home\":1}', '', 8, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1231, 2, 'testimonials', 'testimonial_1', '{\"client_name\":\"أحمد الراشد\",\"content\":\"خدمة ممتازة وسريعة. فريق ركاز محترف جداً وأنصح الجميع بالتعامل معهم.\",\"rating\":5}', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1232, 2, 'testimonials', 'testimonial_2', '{\"client_name\":\"فاطمة العمري\",\"content\":\"تعاملت معهم في صيانة المكيفات وكنت سعيدة بالنتيجة. أسعار معقولة وجودة عالية.\",\"rating\":5}', '', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1233, 2, 'testimonials', 'testimonial_3', '{\"client_name\":\"خالد السعيد\",\"content\":\"صيانة كهرباء احترافية. الفريق وصل في الوقت المحدد وأنهى العمل بكفاءة عالية.\",\"rating\":5}', '', 3, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1234, 2, 'testimonials', 'testimonial_4', '{\"client_name\":\"نورة الحربي\",\"content\":\"خدمة تنظيف شاملة ممتازة. المنزل أصبح نظيفاً كأنه جديد.\",\"rating\":5}', '', 4, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1235, 2, 'features', 'feature_1', '{\"title_ar\":\"فنيون معتمدون\",\"description_ar\":\"جميع فنيينا حاصلون على شهادات مهنية معتمدة وخبرة واسعة.\",\"icon\":\"fas fa-certificate\"}', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1236, 2, 'features', 'feature_2', '{\"title_ar\":\"أسعار تنافسية\",\"description_ar\":\"نقدم أسعاراً منافسة مع شفافية كاملة في التكاليف.\",\"icon\":\"fas fa-tags\"}', '', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1237, 2, 'features', 'feature_3', '{\"title_ar\":\"ضمان شامل\",\"description_ar\":\"ضمان 3 أشهر على جميع أعمال الصيانة مع خدمة متابعة.\",\"icon\":\"fas fa-shield-alt\"}', '', 3, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1238, 2, 'features', 'feature_4', '{\"title_ar\":\"خدمة 24/7\",\"description_ar\":\"فريق الدعم والخدمة الطارئة متاح على مدار الساعة.\",\"icon\":\"fas fa-clock\"}', '', 4, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1239, 2, 'features', 'feature_5', '{\"title_ar\":\"مواد أصلية\",\"description_ar\":\"نستخدم قطع غيار ومواد أصلية من أفضل الشركات المصنعة.\",\"icon\":\"fas fa-gem\"}', '', 5, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1240, 2, 'features', 'feature_6', '{\"title_ar\":\"التزام بالمواعيد\",\"description_ar\":\"نحترم وقتكم ونلتزم بالمواعيد المحددة بدقة.\",\"icon\":\"fas fa-calendar-check\"}', '', 6, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1241, 2, 'stats', 'stat_1', '{\"label_ar\":\"+15 سنة خبرة\",\"value\":\"+15\",\"icon\":\"fas fa-calendar-alt\"}', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1242, 2, 'stats', 'stat_2', '{\"label_ar\":\"+5000 عميل سعيد\",\"value\":\"+5K\",\"icon\":\"fas fa-smile\"}', '', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1243, 2, 'stats', 'stat_3', '{\"label_ar\":\"+12000 خدمة مكتملة\",\"value\":\"+12K\",\"icon\":\"fas fa-check-circle\"}', '', 3, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1244, 2, 'stats', 'stat_4', '{\"label_ar\":\"+50 فني متخصص\",\"value\":\"+50\",\"icon\":\"fas fa-user-tie\"}', '', 4, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1245, 2, 'faq', 'faq_1', '{\"question_ar\":\"ما هي المناطق التي تغطونها؟\",\"answer_ar\":\"نغطي جميع مناطق الرياض والمناطق المحيطة بها. يمكنكم الاستفسار عن تغطية منطقتكم عبر الاتصال بنا.\",\"category\":\"general\"}', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1246, 2, 'faq', 'faq_2', '{\"question_ar\":\"هل تقدمون ضماناً على الخدمات؟\",\"answer_ar\":\"نعم، نقدم ضماناً شاملاً لمدة 3 أشهر على جميع خدمات الصيانة. يشمل الضمان إصلاح أي عيوب في العمل المنجز.\",\"category\":\"services\"}', '', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1247, 2, 'faq', 'faq_3', '{\"question_ar\":\"كيف يمكنني حجز موعد؟\",\"answer_ar\":\"يمكنكم حجز موعد عبر نموذج الحجز في موقعنا، أو الاتصال المباشر على الرقم 966501234567+، أو عبر الواتساب.\",\"category\":\"booking\"}', '', 3, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1248, 2, 'faq', 'faq_4', '{\"question_ar\":\"ما هي طرق الدفع المتاحة؟\",\"answer_ar\":\"نقبل الدفع النقدي، التحويل البنكي، وشبكة مدى. يمكن الاتفاق على خطة دفع مرنة للمشاريع الكبيرة.\",\"category\":\"pricing\"}', '', 4, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1249, 2, 'faq', 'faq_5', '{\"question_ar\":\"هل تقدمون خدمات طارئة؟\",\"answer_ar\":\"نعم، لدينا خدمة صيانة طارئة متاحة على مدار الساعة. يمكنكم الاتصال بنا مباشرة للحالات الطارئة.\",\"category\":\"general\"}', '', 5, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1250, 2, 'about', 'about_content', '<p>تأسست شركة ركاز للصيانة عام 2010 بهدف تقديم خدمات صيانة احترافية وموثوقة. نمتلك فريقاً من الفنيين المتخصصين والحاصلين على أعلى الشهادات المهنية.</p><p>نؤمن بأن الصيانة الجيدة هي أساس الراحة والسلامة في المنزل والمكتب. لذلك نحرص على تقديم خدمات عالية الجودة مع ضمان شامل على جميع أعمالنا.</p>', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1251, 2, 'contact', 'contact_info', '{\"phone\":\"+966 50 123 4567\",\"email\":\"info@rakaz-maintenance.com\",\"whatsapp\":\"+966 50 123 4567\",\"address\":\"الرياض، المملكة العربية السعودية\",\"working_hours\":\"السبت - الخميس: 8 صباحاً - 8 مساءً\\nالطوارئ: 24/7\"}', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1252, 2, 'partners', 'partner_1', '{\"name_ar\":\"شركة الأفق للعقارات\",\"icon\":\"fas fa-building\"}', '', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1253, 2, 'partners', 'partner_2', '{\"name_ar\":\"مجموعة الرياض للتطوير\",\"icon\":\"fas fa-city\"}', '', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1254, 2, 'partners', 'partner_3', '{\"name_ar\":\"شركة النور للمقاولات\",\"icon\":\"fas fa-hard-hat\"}', '', 3, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1255, 2, 'partners', 'partner_4', '{\"name_ar\":\"مؤسسة السلامة للخدمات\",\"icon\":\"fas fa-hands-helping\"}', '', 4, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1256, 2, 'partners', 'partner_5', '{\"name_ar\":\"شركة الإبداع للتصميم\",\"icon\":\"fas fa-pencil-ruler\"}', '', 5, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1257, 2, 'booking', 'booking_title', 'احجز موعدك الآن', 'Book Your Appointment', 1, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1258, 2, 'booking', 'booking_description', 'اختر الخدمة المناسبة لك واحجز موعدك في الوقت المفضل. فريقنا المحترف سيتواصل معك لتأكيد الحجز خلال 15 دقيقة.', '', 2, 1, '2026-05-09 21:28:27', '2026-05-09 21:28:27'),
(1259, 15, 'hero', 'hero_title', 'خلّي بيتك يلمع كل يوم', 'Make Your Home Shine Every Day', 1, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1260, 15, 'hero', 'hero_subtitle', 'أكثر من 5000 عميل يثق بنا', 'Trusted by over 5,000 clients', 2, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1261, 15, 'hero', 'hero_description', 'خدمات تنظيف سريعة وموثوقة للمنازل والشركات بأعلى جودة وأسعار مناسبة.', 'Fast and reliable cleaning services for homes and companies with the highest quality and reasonable prices.', 3, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1262, 15, 'hero', 'hero_button_text', 'ابدأ الآن', 'Start Now', 4, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1263, 15, 'about', 'about_title', 'خدمات احترافية نقدمها لعملائنا', 'Professional Services We Provide to Our Clients', 1, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1264, 15, 'about', 'about_description', 'نقدم حلول تنظيف متكاملة للمنازل والمكاتب والسجاد والمرافق التجارية. فريقنا مدرب، موادنا آمنة، وخدمتنا سريعة ومتاحة على مدار الأسبوع.', 'We provide integrated cleaning solutions for homes, offices, carpets, and commercial facilities. Our team is trained, our materials are safe, and our service is fast and available throughout the week.', 2, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1265, 15, 'features', 'feature_1_title', 'أسعار مناسبة', 'Affordable Prices', 1, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1266, 15, 'features', 'feature_1_description', 'أسعار تنافسية تناسب الجميع', 'Competitive prices for everyone', 2, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1267, 15, 'features', 'feature_2_title', 'خدمة في نفس اليوم', 'Same-Day Service', 3, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1268, 15, 'features', 'feature_2_description', 'استجابة سريعة خلال ساعات', 'Fast response within hours', 4, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1269, 15, 'features', 'feature_3_title', 'مواد آمنة', 'Safe Materials', 5, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1270, 15, 'features', 'feature_3_description', 'منتجات صديقة للبيئة', 'Eco-friendly products', 6, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1271, 15, 'features', 'feature_4_title', 'فريق محترف', 'Expert Team', 7, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1272, 15, 'features', 'feature_4_description', 'فنيون معتمدون ومدربون', 'Certified & trained technicians', 8, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1273, 15, 'features', 'feature_5_title', 'نتائج مضمونة', 'Guaranteed Results', 9, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1274, 15, 'features', 'feature_5_description', 'جودة عالية مع ضمان الخدمة', 'High quality with service guarantee', 10, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1275, 15, 'pricing', 'pricing_title', 'أسعار واضحة', 'Transparent Prices', 1, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1276, 15, 'pricing', 'pricing_description', 'نحدد السعر بوضوح حسب نوع الخدمة والمساحة، ونلتزم بالجودة والوقت المتفق عليه.', 'We set the price clearly based on service type and area, and we are committed to quality and the agreed time.', 2, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1277, 15, 'stats', 'stat_1_value', '8000+', '', 1, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1278, 15, 'stats', 'stat_1_label', 'عميل سعيد', 'Happy Clients', 2, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1279, 15, 'stats', 'stat_2_value', '5000+', '', 3, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1280, 15, 'stats', 'stat_2_label', 'مشروع منجز', 'Projects Done', 4, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1281, 15, 'stats', 'stat_3_value', '98%', '', 5, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23'),
(1282, 15, 'stats', 'stat_3_label', 'نسبة الرضا', 'Satisfaction Rate', 6, 1, '2026-05-10 20:25:23', '2026-05-10 20:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `theme_media`
--

CREATE TABLE `theme_media` (
  `id` int(11) UNSIGNED NOT NULL,
  `theme_id` int(11) UNSIGNED NOT NULL,
  `media_type` varchar(50) NOT NULL COMMENT 'logo, banner, service_icon, gallery, icon, favicon',
  `file_path` varchar(500) NOT NULL COMMENT 'مسار الملف',
  `file_name` varchar(255) DEFAULT NULL COMMENT 'اسم الملف الأصلي',
  `alt_text_ar` varchar(255) DEFAULT NULL,
  `alt_text_en` varchar(255) DEFAULT NULL,
  `section_ref` varchar(50) DEFAULT NULL COMMENT 'مرجع القسم مثل: hero, about, service_1',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_media`
--

INSERT INTO `theme_media` (`id`, `theme_id`, `media_type`, `file_path`, `file_name`, `alt_text_ar`, `alt_text_en`, `section_ref`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(540, 1, 'banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'صيانة احترافية', 'Professional Maintenance', 'hero', 1, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(541, 1, 'logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'ماستر فيكس', 'Master Fix', NULL, 1, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(542, 1, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'صيانة كهرباء', 'Electrical Services', 'svc_electric', 1, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(543, 1, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'السباكة', 'Plumbing', 'svc_plumbing', 2, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(544, 1, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'التكييف', 'AC Repair', 'svc_ac', 3, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(545, 1, 'service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'إصلاح المنازل', 'Home Repair', 'svc_home', 4, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(546, 1, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'الدهانات', 'Painting', 'svc_painting', 5, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(547, 1, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'أقفال وأبواب', 'Locks & Doors', 'svc_lock', 6, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(548, 1, 'gallery', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'مشروع صيانة كهرباء شامل', 'Full electrical maintenance project', 'كهرباء', 1, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(549, 1, 'gallery', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية حديثة', 'Modern electrical wiring', 'كهرباء', 2, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(550, 1, 'gallery', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح تسريب مياه', 'Water leak repair', 'سباكة', 3, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(551, 1, 'gallery', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة مكيف مركزي', 'Central AC maintenance', 'تبريد', 4, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(552, 1, 'gallery', 'services/interior-design.jpg', 'interior-design.jpg', 'تشطيب داخلي فاخر', 'Luxury interior finishing', 'ديكور', 5, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(553, 1, 'gallery', 'services/painting-service.jpg', 'painting-service.jpg', 'دهان واجهات خارجية', 'Exterior painting', 'ديكور', 6, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(554, 1, 'gallery', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تركيب أقفال ذكية', 'Smart lock installation', 'كهرباء', 7, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(555, 1, 'gallery', 'banners/maintenance-hero.jpg', 'maintenance-hero-2.jpg', 'مشروع سباكة كامل', 'Complete plumbing project', 'سباكة', 8, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(556, 1, 'gallery', 'services/electrical-wiring.jpg', 'electrical-2.jpg', 'لوحة تحكم كهربائية', 'Electrical control panel', 'كهرباء', 9, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(557, 1, 'gallery', 'services/ac-repair.jpg', 'ac-2.jpg', 'تركيب وحدة تكييف جديدة', 'New AC unit installation', 'تبريد', 10, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(558, 1, 'partner', 'logos/maintenance-logo.png', 'advanced-buildings.png', 'شركة الأبنية المتقدمة', 'Advanced Buildings Co.', 'partner_1', 1, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(559, 1, 'partner', 'logos/cleaning-logo.png', 'smart-energy.png', 'مؤسسة الطاقة الذكية', 'Smart Energy Corp.', 'partner_2', 2, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(560, 1, 'partner', 'logos/electric-logo.png', 'royal-decor.png', 'شركة الديكور الملكي', 'Royal Decor Co.', 'partner_3', 3, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(561, 1, 'partner', 'logos/general-logo.png', 'security-group.png', 'مجموعة الأمن والحماية', 'Security Group', 'partner_4', 4, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(562, 1, 'partner', 'logos/maintenance-logo.png', 'first-pipes.png', 'شركة الأنابيب الأولى', 'First Pipes Co.', 'partner_5', 5, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(563, 1, 'partner', 'logos/cleaning-logo.png', 'advanced-cooling.png', 'مؤسسة التبريد المتطور', 'Advanced Cooling Corp.', 'partner_6', 6, 1, '2026-05-09 22:51:05', '2026-05-09 15:51:05'),
(564, 15, 'banner', 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1800&auto=format&fit=crop', 'hero-bg.jpg', 'صورة الهيرو الرئيسية', 'Main hero background', 'hero', 1, 1, '2026-05-10 20:25:23', NULL),
(565, 15, 'service_image', 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop', 'service-1.jpg', 'الدعم التقني', 'Technical Support', 'service_1', 1, 1, '2026-05-10 20:25:23', NULL),
(566, 15, 'service_image', 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=900&auto=format&fit=crop', 'service-2.jpg', 'حلول الشبكات', 'Network Solutions', 'service_2', 2, 1, '2026-05-10 20:25:23', NULL),
(567, 15, 'service_image', 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=900&auto=format&fit=crop', 'service-3.jpg', 'صيانة الأنظمة', 'System Maintenance', 'service_3', 3, 1, '2026-05-10 20:25:23', NULL),
(568, 15, 'service_image', 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=900&auto=format&fit=crop', 'service-4.jpg', 'تعقيم كامل', 'Full Sanitization', 'service_4', 4, 1, '2026-05-10 20:25:23', NULL),
(569, 15, 'service_image', 'https://images.unsplash.com/photo-1528744598421-b7b93e12df54?q=80&w=900&auto=format&fit=crop', 'service-5.jpg', 'تنظيف الزجاج', 'Glass Cleaning', 'service_5', 5, 1, '2026-05-10 20:25:23', NULL),
(570, 15, 'service_image', 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=900&auto=format&fit=crop', 'service-6.jpg', 'تنظيف بعد البناء', 'Post-Construction', 'service_6', 6, 1, '2026-05-10 20:25:23', NULL),
(571, 15, 'gallery', 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=900&auto=format&fit=crop', 'gallery-1.jpg', 'معرض الصور 1', 'Gallery 1', 'gallery', 1, 1, '2026-05-10 20:25:23', NULL),
(572, 15, 'gallery', 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=900&auto=format&fit=crop', 'gallery-2.jpg', 'معرض الصور 2', 'Gallery 2', 'gallery', 2, 1, '2026-05-10 20:25:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `theme_requests`
--

CREATE TABLE `theme_requests` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `theme_id` int(11) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) DEFAULT 0.00,
  `currency` varchar(10) DEFAULT 'SAR',
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_ref` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `tenant_notes` text DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
  `font_primary` varchar(100) DEFAULT 'Tajawal',
  `font_secondary` varchar(100) DEFAULT 'Tajawal',
  `font_size_base` varchar(10) DEFAULT '16px',
  `border_radius` varchar(10) DEFAULT '8px',
  `header_style` enum('default','centered','transparent') DEFAULT 'default',
  `footer_style` enum('default','minimal','expanded') DEFAULT 'default',
  `hero_style` enum('default','fullwidth','split','video') DEFAULT 'default',
  `custom_css` text DEFAULT NULL,
  `custom_js` text DEFAULT NULL,
  `header_logo_height` varchar(10) DEFAULT '50px',
  `footer_logo_height` varchar(10) DEFAULT '40px',
  `button_style` enum('rounded','square','pill') DEFAULT 'rounded',
  `card_style` enum('shadow','border','flat') DEFAULT 'shadow',
  `animation_enabled` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `primary_font` varchar(100) DEFAULT 'Tajawal' COMMENT 'الخط الرئيسي (مرادف لـ font_primary)',
  `secondary_font` varchar(100) DEFAULT 'Tajawal' COMMENT 'الخط الثانوي',
  `base_font_size` varchar(10) DEFAULT '16' COMMENT 'حجم الخط الأساسي',
  `heading_font_weight` varchar(10) DEFAULT '700' COMMENT 'سمك خطوط العناوين',
  `body_font_weight` varchar(10) DEFAULT '400' COMMENT 'سمك خطوط النص',
  `primary_color` varchar(7) DEFAULT '#2563eb' COMMENT 'اللون الرئيسي',
  `secondary_color` varchar(7) DEFAULT '#1e40af' COMMENT 'اللون الثانوي',
  `accent_color` varchar(7) DEFAULT '#f59e0b' COMMENT 'لون التمييز',
  `text_color` varchar(7) DEFAULT '#1f2937' COMMENT 'لون النص الرئيسي',
  `text_muted_color` varchar(7) DEFAULT '#6b7280' COMMENT 'لون النص الثانوي',
  `background_color` varchar(7) DEFAULT '#ffffff' COMMENT 'لون الخلفية',
  `card_background` varchar(7) DEFAULT '#ffffff' COMMENT 'لون خلفية البطاقات',
  `border_color` varchar(7) DEFAULT '#e5e7eb' COMMENT 'لون الحدود',
  `button_radius` varchar(10) DEFAULT '8' COMMENT 'استدارة الأزرار',
  `card_radius` varchar(10) DEFAULT '12' COMMENT 'استدارة البطاقات',
  `button_shadow` tinyint(1) DEFAULT 0 COMMENT 'ظل الأزرار',
  `card_hover_effect` varchar(20) DEFAULT 'lift' COMMENT 'تأثير تمرير البطاقات',
  `enable_animations` tinyint(1) DEFAULT 1 COMMENT 'تفعيل الرسوم المتحركة',
  `animation_type` varchar(20) DEFAULT 'fade' COMMENT 'نوع الرسوم المتحركة',
  `container_width` varchar(10) DEFAULT '1200' COMMENT 'عرض الحاوية',
  `header_fixed` tinyint(1) DEFAULT 0 COMMENT 'ثبات الرأس',
  `sidebar_position` varchar(10) DEFAULT 'right' COMMENT 'موضع الشريط الجانبي',
  `theme_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `tenant_id`, `font_primary`, `font_secondary`, `font_size_base`, `border_radius`, `header_style`, `footer_style`, `hero_style`, `custom_css`, `custom_js`, `header_logo_height`, `footer_logo_height`, `button_style`, `card_style`, `animation_enabled`, `created_at`, `updated_at`, `primary_font`, `secondary_font`, `base_font_size`, `heading_font_weight`, `body_font_weight`, `primary_color`, `secondary_color`, `accent_color`, `text_color`, `text_muted_color`, `background_color`, `card_background`, `border_color`, `button_radius`, `card_radius`, `button_shadow`, `card_hover_effect`, `enable_animations`, `animation_type`, `container_width`, `header_fixed`, `sidebar_position`, `theme_id`) VALUES
(50, 1, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(51, 2, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(52, 3, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(53, 4, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(54, 5, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(55, 8, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(56, 11, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(57, 6, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(58, 7, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(59, 9, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL),
(60, 10, 'Tajawal', 'Tajawal', '16px', '16', 'default', 'default', 'split', '', '', '50px', '40px', 'rounded', '', 1, '2026-05-09 15:51:05', '2026-05-09 15:51:05', 'Tajawal', 'Tajawal', '16', '800', '400', '#06b6d4', '#0f172a', '#22d3ee', '#ffffff', '#94a3b8', '#0f172a', '#111827', 'rgba(25', '16', '24', 1, 'glow', 1, 'fade', '1200', 1, 'none', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`, `verification_token`, `reset_token`, `reset_token_expires`, `last_login`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'admin@cms-platform.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدير النظام', NULL, 'admin', 'active', 1, NULL, NULL, NULL, '2026-05-12 10:53:16', '2026-03-14 12:12:42', '2026-05-12 10:53:16', NULL),
(2, 'muthannadarwish20@gmail.com', '$2y$12$ctGqMfGzYmQ3aP.D791wk.6Pz1g9HlSG55Kw/gu68MnfJ3LCkfcaS', 'muthanna muthanna', '05345746030', 'customer', 'active', 1, 'a6c22872d270ffbfd431f38257e8425961947176c87dcf97e054f38bec5eb16cfe5c37697e322c6fe6c3d4e65e0d36716debbd51ba5fbc657de3729470d46e2e', NULL, NULL, '2026-05-12 08:50:12', '2026-03-14 21:47:17', '2026-05-12 08:50:12', NULL),
(3, 'ahmed@maintenance-sa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'أحمد الصيانة', '0501234567', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL),
(4, 'mohammed@electric-pro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'محمد الكهربائي', '0502345678', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL),
(5, 'fatima@clean-home.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'فاطمة التنظيف', '0503456789', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL),
(6, 'sara@decor-style.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'سارة الديكور', '0504567890', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL),
(7, 'khalid@plumbing-expert.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'خالد السباك', '0505678901', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL),
(8, 'omar@general-services.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'عمر الخدمات', '0506789012', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL),
(12, 'muthannadarwish201@gmail.com', '$2y$12$TBCF32KGhfhPmND5AUT/munuFrlloI7ynJIzCze8UbeScAUg9XW0C', 'ADADA', '555555555', 'customer', 'active', 0, '3d6a5e5039b0d889dae90e1d66f51d8a4947e6ed10ed502b16da6ef4d429ac5c431225e1a4551dc0c892890b22ebbe90c40d6999cce71521bb4c5c6cae155204', NULL, NULL, NULL, '2026-05-12 20:49:48', '2026-05-12 20:49:48', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `visitor_id` (`visitor_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `slug` (`slug`),
  ADD KEY `status` (`status`),
  ADD KEY `published_at` (`published_at`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `custom_forms`
--
ALTER TABLE `custom_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenant_slug` (`tenant_id`,`slug`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `demo_imports`
--
ALTER TABLE `demo_imports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tenant` (`tenant_id`);

--
-- Indexes for table `domain_history`
--
ALTER TABLE `domain_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tenant_id` (`tenant_id`),
  ADD KEY `idx_tenant_category` (`tenant_id`,`category`);

--
-- Indexes for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenant_page_date` (`tenant_id`,`page_slug`,`view_date`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `paid_services`
--
ALTER TABLE `paid_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category` (`category`),
  ADD KEY `is_active` (`is_active`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_partner_tenant` (`tenant_id`),
  ADD KEY `idx_partner_active` (`tenant_id`,`is_active`);

--
-- Indexes for table `platform_blog_posts`
--
ALTER TABLE `platform_blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `status` (`status`),
  ADD KEY `published_at` (`published_at`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `sections_config`
--
ALTER TABLE `sections_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tenant_section` (`tenant_id`,`section_key`),
  ADD KEY `idx_tenant_id` (`tenant_id`);

--
-- Indexes for table `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `site_features`
--
ALTER TABLE `site_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tenant_id` (`tenant_id`),
  ADD KEY `idx_tenant_active` (`tenant_id`,`is_active`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_stats`
--
ALTER TABLE `site_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tenant_id` (`tenant_id`);

--
-- Indexes for table `site_testimonials`
--
ALTER TABLE `site_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `subscriptions_plan_fk` (`plan_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `subscription_requests`
--
ALTER TABLE `subscription_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tenant_id` (`tenant_id`),
  ADD KEY `idx_plan_id` (`plan_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `subdomain` (`subdomain`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `subscription_status` (`subscription_status`);

--
-- Indexes for table `tenant_purchases`
--
ALTER TABLE `tenant_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category` (`category`),
  ADD KEY `is_active` (`is_active`),
  ADD KEY `is_paid` (`is_paid`);

--
-- Indexes for table `theme_contents`
--
ALTER TABLE `theme_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_theme_section` (`theme_id`,`section_type`),
  ADD KEY `idx_theme_active` (`theme_id`,`is_active`);

--
-- Indexes for table `theme_media`
--
ALTER TABLE `theme_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_theme_media` (`theme_id`,`media_type`),
  ADD KEY `idx_theme_media_active` (`theme_id`,`media_type`,`is_active`);

--
-- Indexes for table `theme_requests`
--
ALTER TABLE `theme_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `custom_forms`
--
ALTER TABLE `custom_forms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_imports`
--
ALTER TABLE `demo_imports`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `domain_history`
--
ALTER TABLE `domain_history`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paid_services`
--
ALTER TABLE `paid_services`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platform_blog_posts`
--
ALTER TABLE `platform_blog_posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sections_config`
--
ALTER TABLE `sections_config`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `seo_settings`
--
ALTER TABLE `seo_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `site_features`
--
ALTER TABLE `site_features`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_stats`
--
ALTER TABLE `site_stats`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_testimonials`
--
ALTER TABLE `site_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription_requests`
--
ALTER TABLE `subscription_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tenant_purchases`
--
ALTER TABLE `tenant_purchases`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `theme_contents`
--
ALTER TABLE `theme_contents`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1283;

--
-- AUTO_INCREMENT for table `theme_media`
--
ALTER TABLE `theme_media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=573;

--
-- AUTO_INCREMENT for table `theme_requests`
--
ALTER TABLE `theme_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analytics`
--
ALTER TABLE `analytics`
  ADD CONSTRAINT `analytics_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_forms`
--
ALTER TABLE `custom_forms`
  ADD CONSTRAINT `custom_forms_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `demo_imports`
--
ALTER TABLE `demo_imports`
  ADD CONSTRAINT `demo_imports_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD CONSTRAINT `form_submissions_form_fk` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `form_submissions_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_views`
--
ALTER TABLE `page_views`
  ADD CONSTRAINT `page_views_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD CONSTRAINT `seo_settings_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_plan_fk` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subscriptions_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenant_purchases`
--
ALTER TABLE `tenant_purchases`
  ADD CONSTRAINT `tenant_purchases_service_fk` FOREIGN KEY (`service_id`) REFERENCES `paid_services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tenant_purchases_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `theme_contents`
--
ALTER TABLE `theme_contents`
  ADD CONSTRAINT `theme_contents_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `theme_media`
--
ALTER TABLE `theme_media`
  ADD CONSTRAINT `theme_media_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `theme_requests`
--
ALTER TABLE `theme_requests`
  ADD CONSTRAINT `theme_requests_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `theme_requests_theme_fk` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD CONSTRAINT `theme_settings_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
