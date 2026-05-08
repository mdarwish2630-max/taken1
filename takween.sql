-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2026 at 07:39 PM
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
(11, 5, 'نظافة لا مثيل لها', NULL, 'خدمة تنظيف احترافية', NULL, 'نحول مساحتك إلى مكان نظيف وصحي', NULL, '', NULL, 'احجز الآن', NULL, 'hero', 1, 'active', '2026-03-18 09:01:55', '2026-03-18 09:01:55');

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
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) UNSIGNED NOT NULL,
  `tenant_id` int(11) UNSIGNED NOT NULL,
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

INSERT INTO `subscriptions` (`id`, `tenant_id`, `plan_name`, `amount`, `currency`, `start_date`, `end_date`, `status`, `payment_method`, `payment_reference`, `auto_renew`, `created_at`, `updated_at`) VALUES
(1, 6, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(2, 7, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(3, 9, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(4, 10, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(5, 6, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(6, 7, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(7, 9, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(8, 10, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:29:57', '2026-03-16 19:29:57'),
(9, 6, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(10, 7, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(11, 9, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(12, 10, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:32:28', '2026-03-16 19:32:28'),
(13, 6, 'احترافي', 99.00, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1, '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(14, 7, 'احترافي', 99.00, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1, '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(15, 9, 'المؤسسات', 199.00, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1, '2026-03-16 19:38:27', '2026-03-16 19:38:27'),
(16, 10, 'أساسي', 49.00, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0, '2026-03-16 19:38:27', '2026-03-16 19:38:27');

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
  `features` text DEFAULT NULL COMMENT 'JSON array of features',
  `max_pages` int(11) DEFAULT -1 COMMENT '-1 = unlimited',
  `max_services` int(11) DEFAULT -1,
  `max_gallery` int(11) DEFAULT -1,
  `max_banners` int(11) DEFAULT -1,
  `custom_domain` tinyint(1) DEFAULT 0,
  `remove_branding` tinyint(1) DEFAULT 0,
  `analytics_access` tinyint(1) DEFAULT 0,
  `priority_support` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_popular` tinyint(1) DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `name`, `slug`, `description`, `price_monthly`, `price_yearly`, `currency`, `features`, `max_pages`, `max_services`, `max_gallery`, `max_banners`, `custom_domain`, `remove_branding`, `analytics_access`, `priority_support`, `is_active`, `is_popular`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'مجاني', 'free', 'للتجربة والاستكشاف', 0.00, 0.00, 'SAR', '[\"5 صفحات\", \"3 خدمات\", \"10 صور\", \"دعم فني أساسي\"]', 5, 3, 10, 2, 0, 0, 0, 0, 1, 0, 1, '2026-03-15 14:04:12', '2026-03-15 14:04:12'),
(2, 'أساسي', 'basic', 'للمشاريع الصغيرة', 49.00, 470.00, 'SAR', '[\"15 صفحة\", \"10 خدمات\", \"50 صورة\", \"دعم فني\", \"إحصائيات أساسية\"]', 15, 10, 50, 5, 0, 0, 1, 0, 1, 0, 2, '2026-03-15 14:04:12', '2026-03-15 14:04:12'),
(3, 'احترافي', 'professional', 'للمشاريع المتوسطة - الأكثر طلباً', 99.00, 950.00, 'SAR', '[\"صفحات غير محدودة\", \"خدمات غير محدودة\", \"صور غير محدودة\", \"دومين مخصص\", \"بدون إعلانات\", \"إحصائيات متقدمة\"]', -1, -1, -1, -1, 1, 1, 1, 0, 1, 1, 3, '2026-03-15 14:04:12', '2026-03-15 14:04:12'),
(4, 'المؤسسات', 'enterprise', 'للمؤسسات الكبيرة', 199.00, 1900.00, 'SAR', '[\"كل مميزات الاحترافي\", \"دعم أولوية 24/7\", \"مدير حساب مخصص\", \"تخصيص متقدم\"]', -1, -1, -1, -1, 1, 1, 1, 1, 1, 0, 4, '2026-03-15 14:04:12', '2026-03-15 14:04:12'),
(5, 'sdsds', 'sdsd', 'sdsds', 0.00, NULL, 'SAR', NULL, 10, 10, -1, 3, 0, 0, 0, 0, 1, 0, 0, '2026-04-12 20:37:33', '2026-04-12 20:37:33'),
(6, 'ب', '', '', 0.00, NULL, 'SAR', NULL, 10, 10, -1, 3, 0, 0, 0, 0, 1, 0, 0, '2026-04-12 20:37:46', '2026-04-12 20:37:46'),
(7, 'بداية', 'about11', 'يبي يب يب', 0.00, NULL, 'SAR', NULL, 10, 10, -1, 3, 0, 0, 0, 0, 1, 0, 0, '2026-04-12 20:38:06', '2026-04-12 20:38:06');

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
  `theme_id` int(11) UNSIGNED NOT NULL DEFAULT 1,
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

INSERT INTO `tenants` (`id`, `user_id`, `site_name`, `site_name_en`, `slug`, `subdomain`, `custom_domain`, `custom_domain_status`, `custom_domain_purchased`, `theme_id`, `subscription_plan_id`, `subscription_status`, `subscription_start`, `subscription_end`, `trial_ends_at`, `auto_renew`, `last_payment_date`, `next_payment_date`, `site_status`, `logo`, `favicon`, `contact_email`, `contact_phone`, `contact_phone2`, `contact_whatsapp`, `address`, `working_hours`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `tiktok`, `meta_title`, `meta_description`, `meta_description_en`, `meta_keywords`, `primary_color`, `secondary_color`, `accent_color`, `text_color`, `background_color`, `settings`, `default_language`, `created_at`, `updated_at`, `cta_title`, `cta_title_en`, `cta_text`, `cta_text_en`, `cta_button_text`, `cta_button_text_en`, `cta_button_link`, `cta_is_active`) VALUES
(1, 1, 'شركة البقاع الشامخة للمقاولات', NULL, 'شركة-البقاع-الشامخة-للمقاولات', NULL, NULL, 'none', 0, 1, NULL, 'trial', NULL, NULL, '2026-03-28 16:58:45', 0, NULL, NULL, 'draft', NULL, NULL, 'admin@cms-platform.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-14 16:58:45', '2026-03-14 16:58:45', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(2, 1, 'شركة البقاع الشامخة للمقاولات', NULL, 'شركة-البقاع-الشامخة-للمقاولات-1', NULL, NULL, 'none', 0, 1, NULL, 'trial', NULL, NULL, '2026-03-28 17:01:51', 0, NULL, NULL, 'draft', NULL, NULL, 'admin@cms-platform.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-14 17:01:51', '2026-03-14 17:01:51', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(3, 1, 'شركة البقاع الشامخة للمقاولات', NULL, 'شركة-البقاع-الشامخة-للمقاولات-2', NULL, NULL, 'none', 0, 1, NULL, 'trial', NULL, NULL, '2026-03-28 17:01:59', 0, NULL, NULL, 'draft', NULL, NULL, 'admin@cms-platform.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-14 17:01:59', '2026-03-14 17:01:59', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(4, 1, 'متجر زينون للرجال', NULL, 'متجر-زينون-للرجال', NULL, NULL, 'none', 0, 2, NULL, 'trial', NULL, NULL, '2026-03-28 17:02:20', 0, NULL, NULL, 'draft', NULL, NULL, 'admin@cms-platform.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-14 17:02:20', '2026-03-14 17:02:20', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(5, 2, 'Sahara', NULL, 'sahara', NULL, NULL, 'none', 0, 2, NULL, 'trial', NULL, NULL, '2026-03-28 21:48:05', 0, NULL, NULL, 'draft', '5/abraj_20260315131638_a7620bfe.png', NULL, 'muthannadarwish20@gmail.com', '05345746030', '', '51254565455', 'fd fd fd', 'fd fd fdيب ي', 'https://face.coom', 'https://face.coom', 'https://face.coom', 'https://face.coom', 'https://face.coom', 'https://face.coom', 'يبيب', 'يبيب', NULL, '', '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-14 21:48:05', '2026-04-12 00:36:41', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(6, 3, 'شركة الصيانة الذهبية', NULL, 'golden-maintenance', 'golden-maintenance', NULL, 'none', 0, 1, 3, 'active', '2024-01-01', '2025-01-01', '2024-01-15 00:00:00', 1, NULL, NULL, 'published', NULL, NULL, 'info@golden-maintenance.com', '0501234567', '0112345678', '966501234567', 'الرياض - حي النزهة، شارع الأمير سلطان', 'السبت - الخميس: 8 صباحاً - 10 مساءً', 'https://facebook.com/goldenmaintenance', NULL, 'https://instagram.com/goldenmaintenance', NULL, NULL, NULL, 'شركة الصيانة الذهبية | صيانة منزلية شاملة', 'شركة رائدة في خدمات الصيانة المنزلية بالرياض. صيانة مكيفات، سباكة، كهرباء، وأكثر.', NULL, NULL, '#ea580c', '#1e3a5f', '#3b82f6', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(7, 4, 'محترفو الكهرباء', NULL, 'electric-pro', 'electric-pro', NULL, 'none', 0, 3, 3, 'active', '2024-02-01', '2025-02-01', '2024-02-15 00:00:00', 0, NULL, NULL, 'published', NULL, NULL, 'info@electric-pro.com', '0502345678', NULL, '966502345678', 'جدة - حي الروضة، شارع التحلية', '24 ساعة - 7 أيام', NULL, NULL, NULL, NULL, NULL, NULL, 'محترفو الكهرباء | تمديدات وصيانة كهربائية', 'خدمات كهربائية احترافية. تمديدات، صيانة، إصلاح أعطال، تركيب إضاءة.', NULL, NULL, '#fbbf24', '#d97706', '#1f2937', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(8, 5, 'بيت نظيف', NULL, 'clean-home', 'clean-home', NULL, 'none', 0, 5, NULL, 'trial', NULL, NULL, '2026-03-30 19:17:17', 0, NULL, NULL, 'published', NULL, NULL, 'info@clean-home.com', '0503456789', NULL, '966503456789', 'الدمام - حي الفيصلية', 'السبت - الخميس: 7 صباحاً - 9 مساءً', NULL, NULL, NULL, NULL, NULL, NULL, 'بيت نظيف | خدمات تنظيف منزلية', 'خدمات تنظيف منزلية احترافية. تنظيف فلل، شقق، مكاتب، موكيت وسجاد.', NULL, NULL, '#10b981', '#059669', '#fbbf24', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(9, 6, 'أناقة الديكور', NULL, 'decor-style', 'decor-style', NULL, 'none', 0, 2, 4, 'active', '2024-01-15', '2025-01-15', '2024-01-30 00:00:00', 0, NULL, NULL, 'published', NULL, NULL, 'info@decor-style.com', '0504567890', NULL, '966504567890', 'الرياض - حي العليا، برج المملكة', 'الأحد - الخميس: 10 صباحاً - 10 مساءً', 'https://facebook.com/decorstyle', NULL, 'https://instagram.com/decorstyle', NULL, NULL, NULL, 'أناقة الديكور | تصميم داخلي وديكور', 'شركة تصميم داخلي رائدة. تشطيبات فاخرة، تصميمات عصرية، استشارات مجانية.', NULL, NULL, '#8b5cf6', '#6d28d9', '#fbbf24', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(10, 7, 'خبير السباكة', NULL, 'plumbing-expert', 'plumbing-expert', NULL, 'none', 0, 4, NULL, 'expired', '2023-06-01', '2024-01-01', '2023-06-15 00:00:00', 0, NULL, NULL, 'draft', NULL, NULL, 'info@plumbing-expert.com', '0505678901', NULL, '966505678901', 'مكة المكرمة - حي العزيزية', '24 ساعة - 7 أيام', NULL, NULL, NULL, NULL, NULL, NULL, 'خبير السباكة | خدمات سباكة احترافية', 'خدمات سباكة شاملة. تمديدات، إصلاح تسربات، تركيب صحية.', NULL, NULL, '#0ea5e9', '#0284c7', '#fbbf24', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1),
(11, 8, 'خدمات الأمان', NULL, 'aman-services', 'aman-services', NULL, 'none', 0, 6, NULL, 'trial', NULL, NULL, '2026-03-23 19:17:17', 0, NULL, NULL, 'draft', NULL, NULL, 'info@aman-services.com', '0506789012', NULL, '966506789012', 'المدينة المنورة - حي قباء', 'السبت - الخميس: 8 صباحاً - 8 مساءً', NULL, NULL, NULL, NULL, NULL, NULL, 'خدمات الأمان | خدمات منزلية متكاملة', 'خدمات منزلية شاملة. صيانة، نظافة، نقل عفش، وأكثر.', NULL, NULL, '#2563eb', '#1e40af', '#f59e0b', '#1f2937', '#ffffff', NULL, 'ar', '2026-03-16 19:17:17', '2026-03-16 19:17:17', NULL, NULL, NULL, NULL, NULL, NULL, '#contact', 1);

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
(1, 5, 7, 1, 120.00, 'SAR', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-09 20:42:46', '2026-04-09 20:42:46'),
(2, 5, 1, 1, 50.00, 'SAR', 'pending', NULL, NULL, NULL, NULL, NULL, '2027-04-09 20:42:50', NULL, '2026-04-09 20:42:50', '2026-04-09 20:42:50'),
(3, 5, 1, 1, 50.00, 'SAR', 'pending', NULL, NULL, NULL, NULL, NULL, '2027-04-09 20:44:06', NULL, '2026-04-09 20:44:06', '2026-04-09 20:44:06'),
(4, 5, 1, 1, 50.00, 'SAR', 'pending', NULL, NULL, NULL, NULL, '2026-04-09 21:03:35', '2027-04-09 21:03:35', NULL, '2026-04-09 21:03:35', '2026-04-09 21:03:35'),
(5, 5, 3, 1, 100.00, 'SAR', 'pending', NULL, NULL, NULL, NULL, '2026-04-12 09:40:01', NULL, NULL, '2026-04-12 09:40:01', '2026-04-12 09:40:01');

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
  `name` varchar(100) NOT NULL,
  `name_en` varchar(100) DEFAULT NULL COMMENT 'اسم القالب بالإنجليزية',
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `description_en` text DEFAULT NULL COMMENT 'وصف القالب بالإنجليزية',
  `category` enum('maintenance','decor','electric','plumbing','cleaning','general','other') NOT NULL DEFAULT 'general',
  `preview_image` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_premium` tinyint(1) NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'هل القالب مدفوع 0=مجاني 1=مدفوع',
  `price` decimal(10,2) DEFAULT 0.00 COMMENT 'سعر القالب المدفوع',
  `currency` varchar(10) DEFAULT 'SAR' COMMENT 'عملة السعر',
  `payment_link` varchar(500) DEFAULT NULL COMMENT 'رابط الدفع للقالب المدفوع',
  `sort_order` int(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب العرض',
  `version` varchar(20) DEFAULT '1.0.0',
  `settings_schema` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `name_en`, `slug`, `description`, `description_en`, `category`, `preview_image`, `thumbnail`, `is_active`, `is_premium`, `is_paid`, `price`, `currency`, `payment_link`, `sort_order`, `version`, `settings_schema`, `created_at`, `updated_at`) VALUES
(1, 'خدمات الصيانة', 'Maintenance Services', 'maintenance', 'قالب متخصص لشركات الصيانة والإصلاحات المنزلية', 'Specialized template for maintenance and home repair companies', 'maintenance', 'maintenance-preview.jpg', NULL, 1, 0, 1, 15.00, 'USD', 'https://inmotionhosting.com', 2, '1.0.0', NULL, '2026-04-10 17:37:50', '2026-04-10 17:46:27'),
(2, 'خدمات الديكور', 'Decor & Design', 'decor', 'قالب أنيق لشركات الديكور والتصميم الداخلي', 'Elegant template for interior design and decoration companies', 'decor', 'decor-preview.jpg', NULL, 1, 0, 0, 0.00, 'SAR', NULL, 3, '1.0.0', NULL, '2026-04-10 17:37:50', '2026-04-10 17:37:50'),
(3, 'خدمات الكهرباء', 'Electrical Services', 'electric', 'قالب احترافي للكهربائيين وشركات الكهرباء', 'Professional template for electricians and electrical companies', 'electric', 'electric-preview.jpg', NULL, 1, 0, 0, 0.00, 'SAR', NULL, 4, '1.0.0', NULL, '2026-04-10 17:37:50', '2026-04-10 17:37:50'),
(4, 'خدمات السباكة', 'Plumbing Services', 'plumbing', 'قالب متخصص للسباكين وشركات السباكة', 'Specialized template for plumbers and plumbing companies', 'plumbing', 'plumbing-preview.jpg', NULL, 1, 0, 0, 0.00, 'SAR', NULL, 5, '1.0.0', NULL, '2026-04-10 17:37:50', '2026-04-10 17:37:50'),
(5, 'خدمات التنظيف', 'Cleaning Services', 'cleaning', 'قالب منعش لشركات التنظيف', 'Fresh template for cleaning companies', 'cleaning', 'cleaning-preview.jpg', NULL, 1, 0, 0, 0.00, 'SAR', NULL, 6, '1.0.0', NULL, '2026-04-10 17:37:50', '2026-04-10 17:37:50'),
(6, 'خدمات عامة', 'General Services', 'general', 'قالب عام مناسب لجميع أنواع الخدمات', 'General template suitable for all types of services', 'general', 'general-preview.jpg', NULL, 1, 0, 0, 0.00, 'SAR', NULL, 7, '1.0.0', NULL, '2026-04-10 17:37:50', '2026-04-10 17:37:50'),
(7, 'قالب طبي', 'Medical Theme', 'medical', 'قالب احترافي للعيادات والمستشفيات والمراكز الصحية بتصميم نظيف وموثوق', 'Professional template for clinics, hospitals, and healthcare centers with clean trustworthy design', 'other', 'themes/previews/medical-preview.png', 'themes/previews/medical-preview.png', 1, 1, 1, 149.00, 'SAR', NULL, 10, '1.0.0', NULL, '2026-04-10 18:51:28', '2026-04-10 22:25:34'),
(8, 'قالب عقارات', 'Real Estate Theme', 'realestate', 'قالب فاخر لشركات العقارات والوساطة العقارية بتصميم ذهبي راقي', 'Luxurious template for real estate companies and property agencies with elegant gold design', 'other', 'themes/previews/realestate-preview.png', 'themes/previews/realestate-preview.png', 1, 1, 1, 199.00, 'SAR', NULL, 11, '1.0.0', NULL, '2026-04-10 18:51:28', '2026-04-10 22:25:34'),
(9, 'قالب مطاعم', 'Restaurant Theme', 'restaurant', 'قالب أنيق للمطاعم والكافيهات بتصميم دافئ وشهي يعزف على شهية الزوار', 'Elegant template for restaurants and cafes with warm appetizing design that whets the appetite', 'other', 'themes/previews/restaurant-preview.png', 'themes/previews/restaurant-preview.png', 1, 1, 1, 149.00, 'SAR', NULL, 12, '1.0.0', NULL, '2026-04-10 18:51:28', '2026-04-10 22:25:34'),
(10, 'قالب تعليم', 'Education Theme', 'education', 'قالب أكاديمي احترافي للمدارس والجامعات ومراكز التدريب بتصميم حديث وعصري', 'Professional academic template for schools, universities, and training centers with modern design', 'other', 'themes/previews/education-preview.png', 'themes/previews/education-preview.png', 1, 1, 1, 149.00, 'SAR', NULL, 13, '1.0.0', NULL, '2026-04-10 18:51:28', '2026-04-10 22:25:34'),
(11, 'قالب محاماة', 'Legal Theme', 'legal', 'قالب رسمي فاخر لمكاتب المحاماة واستشارات قانونية بألوان كحلي وذهبي', 'Premium formal template for law firms and legal consultancy with navy blue and gold colors', 'other', 'themes/previews/legal-preview.png', 'themes/previews/legal-preview.png', 1, 1, 1, 199.00, 'SAR', NULL, 14, '1.0.0', NULL, '2026-04-10 18:51:28', '2026-04-10 22:25:34'),
(12, 'قالب رياضة', 'Fitness Theme', 'fitness', 'قالب رياضي قوي للنوادي الرياضية وصالات الجيم بتصميم طاقة وحماس', 'Powerful sports template for gyms and fitness clubs with energetic bold design', 'other', 'themes/previews/fitness-preview.png', 'themes/previews/fitness-preview.png', 1, 1, 1, 149.00, 'SAR', NULL, 15, '1.0.0', NULL, '2026-04-10 18:51:28', '2026-04-10 22:25:34');

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
(1, 5, 'hero', 'hero_title', 'صيانة احترافية لممتلكاتك', 'Professional Maintenance for Your Property', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(2, 5, 'hero', 'hero_subtitle', 'فريق متخصص متاح على مدار الساعة لخدمتكم', 'Specialized team available 24/7 to serve you', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(3, 5, 'hero', 'hero_description', 'نقدم خدمات صيانة شاملة للمنازل والمباني التجارية بأعلى معايير الجودة والاحترافية', 'We provide comprehensive maintenance services for homes and commercial buildings with the highest quality standards', 3, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(4, 5, 'hero', 'hero_button_text', 'اتصل الآن', 'Call Now', 4, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(5, 5, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(6, 5, 'about', 'about_text', 'شركة متخصصة في تقديم خدمات الصيانة المنزلية والتجارية بأعلى مستويات الجودة. نمتلك فريقاً من الفنيين المتخصصين ذوي الخبرة الواسعة في جميع مجالات الصيانة.', 'A specialized company providing residential and commercial maintenance services of the highest quality. We have a team of expert technicians with extensive experience in all maintenance fields.', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(7, 5, 'services', 'service_1', '{\"title_ar\":\"صيانة شاملة\",\"title_en\":\"Comprehensive Maintenance\",\"description_ar\":\"خدمات صيانة متكاملة للمباني السكنية والتجارية\",\"description_en\":\"Integrated maintenance services for residential and commercial buildings\",\"icon\":\"fas fa-tools\",\"show_on_home\":1}', '{\"title_ar\":\"صيانة شاملة\",\"title_en\":\"Comprehensive Maintenance\",\"description_ar\":\"خدمات صيانة متكاملة للمباني السكنية والتجارية\",\"description_en\":\"Integrated maintenance services for residential and commercial buildings\",\"icon\":\"fas fa-tools\",\"show_on_home\":1}', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(8, 5, 'services', 'service_2', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة دورية وطوارئ لجميع أنواع المكيفات\",\"description_en\":\"Regular and emergency maintenance for all AC types\",\"icon\":\"fas fa-fan\",\"show_on_home\":1}', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة دورية وطوارئ لجميع أنواع المكيفات\",\"description_en\":\"Regular and emergency maintenance for all AC types\",\"icon\":\"fas fa-fan\",\"show_on_home\":1}', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(9, 5, 'services', 'service_3', '{\"title_ar\":\"نجارة عامة\",\"title_en\":\"Carpentry\",\"description_ar\":\"أعمال نجارة متنوعة من تركيب أبواب وخزائن\",\"description_en\":\"Various carpentry work including doors and cabinets\",\"icon\":\"fas fa-hammer\",\"show_on_home\":1}', '{\"title_ar\":\"نجارة عامة\",\"title_en\":\"Carpentry\",\"description_ar\":\"أعمال نجارة متنوعة من تركيب أبواب وخزائن\",\"description_en\":\"Various carpentry work including doors and cabinets\",\"icon\":\"fas fa-hammer\",\"show_on_home\":1}', 3, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(10, 5, 'services', 'service_4', '{\"title_ar\":\"صيانة الكهرباء\",\"title_en\":\"Electrical Maintenance\",\"description_ar\":\"فحص وإصلاح الأعطال الكهربائية\",\"description_en\":\"Electrical inspection and repair\",\"icon\":\"fas fa-bolt\",\"show_on_home\":1}', '{\"title_ar\":\"صيانة الكهرباء\",\"title_en\":\"Electrical Maintenance\",\"description_ar\":\"فحص وإصلاح الأعطال الكهربائية\",\"description_en\":\"Electrical inspection and repair\",\"icon\":\"fas fa-bolt\",\"show_on_home\":1}', 4, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(11, 5, 'testimonials', 'testimonial_1', '{\"client_name\":\"عبدالرحمن المالكي\",\"client_title\":\"صاحب عمارة\",\"content\":\"اتفقنا معهم على صيانة دورية لعمارتنا وخدمتهم ممتازة\",\"rating\":5}', '{\"client_name\":\"Abdulrahman Al-Maliki\",\"client_title\":\"Building Owner\",\"content\":\"We agreed on regular maintenance for our building and their service is excellent\",\"rating\":5}', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(12, 5, 'testimonials', 'testimonial_2', '{\"client_name\":\"مجمع الفجر\",\"client_title\":\"مجمع تجاري\",\"content\":\"فريق صيانة محترف ومتجاوب مع جميع الطلبات\",\"rating\":4}', '{\"client_name\":\"Al-Fajr Complex\",\"client_title\":\"Commercial Complex\",\"content\":\"Professional and responsive maintenance team for all requests\",\"rating\":4}', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(13, 5, 'contact', 'contact_info', '{\"phone\":\"966500000000\",\"whatsapp\":\"966500000000\",\"email\":\"info@maintenance.com\",\"address\":\"الرياض - المملكة العربية السعودية\"}', '{\"phone\":\"966500000000\",\"whatsapp\":\"966500000000\",\"email\":\"info@maintenance.com\",\"address\":\"Riyadh - Saudi Arabia\"}', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(14, 4, 'hero', 'hero_title', 'حول منزلك إلى تحفة فنية', 'Transform Your Home into a Masterpiece', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(15, 4, 'hero', 'hero_subtitle', 'تصاميم داخلية فاخرة تعكس ذوقك', 'Luxury Interior Designs That Reflect Your Taste', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(16, 4, 'hero', 'hero_description', 'نقدم خدمات تصميم داخلي وديكور متكاملة بأحدث الاتجاهات العالمية', 'We provide comprehensive interior design and decoration services with the latest global trends', 3, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(17, 4, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(18, 4, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(19, 4, 'about', 'about_text', 'استوديو تصميم داخلي متخصص في تحويل المساحات العادية إلى أماكن استثنائية. نؤمن بأن كل مساحة لها روح ونحن نعمل على إبرازها.', 'An interior design studio specializing in transforming ordinary spaces into exceptional places. We believe every space has a soul and we work to bring it out.', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(20, 4, 'services', 'service_1', '{\"title_ar\":\"تصميم داخلي\",\"title_en\":\"Interior Design\",\"description_ar\":\"تصاميم داخلية عصرية وكلاسيكية تتناسب مع ذوقك\",\"description_en\":\"Modern and classic interior designs that match your taste\",\"icon\":\"fas fa-pencil-ruler\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(21, 4, 'services', 'service_2', '{\"title_ar\":\"ديكور غرف المعيشة\",\"title_en\":\"Living Room Decor\",\"description_ar\":\"تصميم وتنفيذ ديكور غرف المعيشة بأحدث الأنماط\",\"description_en\":\"Design and implement living room decor with latest styles\",\"icon\":\"fas fa-couch\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(22, 4, 'services', 'service_3', '{\"title_ar\":\"تصميم المطابخ\",\"title_en\":\"Kitchen Design\",\"description_ar\":\"مطابخ عصرية بتصاميم عملية وجمالية\",\"description_en\":\"Modern kitchens with practical and aesthetic designs\",\"icon\":\"fas fa-utensils\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(23, 4, 'testimonials', 'testimonial_1', '{\"client_name\":\"منى الخالد\",\"client_title\":\"ربة منزل\",\"content\":\"صمموا لي منزلي بشكل رائع! أحببت كل زاوية فيه\",\"rating\":5}', NULL, 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(24, 2, 'hero', 'hero_title', 'خدمات كهربائية متكاملة', 'Integrated Electrical Services', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(25, 2, 'hero', 'hero_subtitle', 'أمان وجودة في كل التفاصيل', 'Safety and Quality in Every Detail', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(26, 2, 'hero', 'hero_button_text', 'اطلب الخدمة', 'Request Service', 4, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(27, 2, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(28, 2, 'about', 'about_text', 'شركة رائدة في مجال الخدمات الكهربائية مع أكثر من 10 سنوات خبرة. نلتزم بأعلى معايير السلامة والجودة.', 'A leading electrical services company with over 10 years of experience. We adhere to the highest safety and quality standards.', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(29, 2, 'services', 'service_1', '{\"title_ar\":\"تمديدات كهربائية\",\"title_en\":\"Electrical Wiring\",\"description_ar\":\"تمديدات كهربائية جديدة للمباني السكنية والتجارية\",\"description_en\":\"New electrical wiring for residential and commercial buildings\",\"icon\":\"fas fa-plug\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(30, 2, 'services', 'service_2', '{\"title_ar\":\"إصلاح الأعطال\",\"title_en\":\"Fault Repair\",\"description_ar\":\"تشخيص وإصلاح جميع الأعطال الكهربائية بسرعة\",\"description_en\":\"Diagnose and repair all electrical faults quickly\",\"icon\":\"fas fa-bolt\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(31, 2, 'testimonials', 'testimonial_1', '{\"client_name\":\"عبدالله الشمري\",\"client_title\":\"صاحب منزل\",\"content\":\"تم تركيب تمديدات كهربائية كاملة لمنزلي الجديد\",\"rating\":5}', NULL, 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(32, 6, 'hero', 'hero_title', 'خدمات سباكة احترافية', 'Professional Plumbing Services', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(33, 6, 'hero', 'hero_subtitle', 'حلول سريعة وموثوقة لجميع مشاكل السباكة', 'Fast and reliable solutions for all plumbing problems', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(34, 6, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(35, 6, 'services', 'service_1', '{\"title_ar\":\"صيانة السباكة العامة\",\"title_en\":\"General Plumbing\",\"description_ar\":\"نقدم خدمات صيانة سباكة شاملة لجميع أنواع المنازل\",\"description_en\":\"Comprehensive plumbing maintenance for all types of homes\",\"icon\":\"fas fa-wrench\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(36, 6, 'services', 'service_2', '{\"title_ar\":\"إصلاح التسريبات\",\"title_en\":\"Leak Repair\",\"description_ar\":\"نكشف ونصلح جميع أنواع التسريبات بأحدث الأجهزة\",\"description_en\":\"We detect and repair all types of leaks with latest equipment\",\"icon\":\"fas fa-tint-slash\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(37, 3, 'hero', 'hero_title', 'نظافة لا مثيل لها', 'Unmatched Cleanliness', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(38, 3, 'hero', 'hero_subtitle', 'خدمة تنظيف احترافية بمعايير عالمية', 'Professional cleaning service with international standards', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(39, 3, 'hero', 'hero_button_text', 'احجز الآن', 'Book Now', 4, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(40, 3, 'services', 'service_1', '{\"title_ar\":\"تنظيف المنازل\",\"title_en\":\"Home Cleaning\",\"description_ar\":\"خدمة تنظيف منزلية شاملة تشمل جميع الغرف\",\"description_en\":\"Comprehensive home cleaning covering all rooms\",\"icon\":\"fas fa-home\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(41, 3, 'services', 'service_2', '{\"title_ar\":\"تنظيف المكاتب\",\"title_en\":\"Office Cleaning\",\"description_ar\":\"تنظيف احترافي للمكاتب والشركات\",\"description_en\":\"Professional cleaning for offices and companies\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(42, 1, 'hero', 'hero_title', 'مرحباً بكم في موقعنا', 'Welcome to Our Website', 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(43, 1, 'hero', 'hero_subtitle', 'نسعى لخدمتكم بأعلى معايير الجودة', 'We strive to serve you with the highest quality standards', 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(44, 1, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(45, 1, 'services', 'service_1', '{\"title_ar\":\"خدماتنا المميزة\",\"title_en\":\"Our Services\",\"description_ar\":\"نقدم مجموعة واسعة من الخدمات عالية الجودة\",\"description_en\":\"We offer a wide range of high-quality services\",\"icon\":\"fas fa-star\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(46, 1, 'services', 'service_2', '{\"title_ar\":\"استشارات متخصصة\",\"title_en\":\"Expert Consulting\",\"description_ar\":\"نقدم استشارات مهنية متخصصة\",\"description_en\":\"We provide specialized professional consulting\",\"icon\":\"fas fa-comments\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 17:18:50', '2026-04-10 17:18:50'),
(47, 7, 'hero', 'hero_title', 'رعاية صحية استثنائية', 'Exceptional Health Care', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(48, 7, 'hero', 'hero_subtitle', 'فريق طبي متخصص يضع صحتك أولاً', 'Specialized medical team putting your health first', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(49, 7, 'hero', 'hero_description', 'نوفر خدمات طبية شاملة بأحدث التقنيات وأفضل الأطباء المتخصصين في جميع المجالات الطبية. نلتزم بأعلى معايير الجودة والسلامة.', 'We provide comprehensive medical services with the latest technology and the best specialized doctors in all medical fields. We adhere to the highest quality and safety standards.', 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(50, 7, 'hero', 'hero_button_text', 'احجز موعد', 'Book Appointment', 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(51, 7, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(52, 7, 'about', 'about_text', 'مركز طبي متكامل يقدم خدمات الرعاية الصحية بأعلى المعايير العالمية. نضم فريقاً من أمهر الأطباء والاستشاريين في مختلف التخصصات الطبية مع أحدث الأجهزة والتقنيات الطبية المتطورة. نحرص على تقديم تجربة علاجية مريحة وآمنة لجميع مرضانا.', 'An integrated medical center providing healthcare services to the highest international standards. We have a team of the most skilled doctors and consultants across various medical specialties with the latest advanced medical equipment and technologies.', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(53, 7, 'services', 'service_1', '{\"title_ar\":\"فحص طبي شامل\",\"title_en\":\"Comprehensive Medical Checkup\",\"description_ar\":\"فحص طبي شامل يشمل جميع الفحوصات اللازمة للتأكد من سلامتك الصحية مع تقارير مفصلة\",\"description_en\":\"Comprehensive medical examination including all necessary tests to ensure your health with detailed reports\",\"icon\":\"fas fa-stethoscope\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(54, 7, 'services', 'service_2', '{\"title_ar\":\"طب الأسنان\",\"title_en\":\"Dental Care\",\"description_ar\":\"خدمات طب أسنان متكاملة من تنظيف وعلاج وتجميل باستخدام أحدث التقنيات\",\"description_en\":\"Integrated dental services from cleaning, treatment, and cosmetics using the latest technologies\",\"icon\":\"fas fa-tooth\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(55, 7, 'services', 'service_3', '{\"title_ar\":\"استشارات طبية\",\"title_en\":\"Medical Consultations\",\"description_ar\":\"استشارات طبية متخصصة مع أفضل الأطباء والاستشاريين في جميع التخصصات\",\"description_en\":\"Specialized medical consultations with the best doctors and consultants in all specialties\",\"icon\":\"fas fa-user-md\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(56, 7, 'services', 'service_4', '{\"title_ar\":\"مختبر تحاليل\",\"title_en\":\"Laboratory\",\"description_ar\":\"مختبر تحاليل مجهز بأحدث الأجهزة مع نتائج دقيقة وسريعة\",\"description_en\":\"Laboratory equipped with the latest devices with accurate and fast results\",\"icon\":\"fas fa-flask\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(57, 7, 'testimonials', 'testimonial_1', '{\"client_name\":\"سارة العتيبي\",\"client_title\":\"مريضة\",\"content\":\"تجربة رائعة مع فريق الطبيب محمد. كان شديد الاحترافية والاهتمام بالتفاصيل.\",\"rating\":5}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(58, 7, 'testimonials', 'testimonial_2', '{\"client_name\":\"خالد المطيري\",\"client_title\":\"تاجر\",\"content\":\"من أفضل المراكز الطبية التي تعاملت معها. النظافة والترتيب ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(59, 7, 'testimonials', 'testimonial_3', '{\"client_name\":\"نورة القحطاني\",\"client_title\":\"معلمة\",\"content\":\"أنصح الجميع بالتعامل معهم. خدمة مميزة وأسعار معقولة.\",\"rating\":4}', NULL, 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(60, 7, 'contact', 'contact_info', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"الرياض - حي العليا - شارع التحلية\"}', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"Riyadh - Olaya District - Tahliya Street\"}', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(61, 8, 'hero', 'hero_title', 'عقاراتك الفاخرة تنتظرك', 'Your Luxury Properties Await', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(62, 8, 'hero', 'hero_subtitle', 'اكتشف أفضل العقارات السكنية والتجارية', 'Discover the best residential and commercial properties', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(63, 8, 'hero', 'hero_description', 'وكالة عقارية متخصصة في تقديم أفضل الحلول العقارية. نوفر لك مجموعة واسعة من العقارات السكنية والتجارية بأسعار تنافسية وأفضل المواقع.', 'A specialized real estate agency providing the best property solutions. We offer a wide range of residential and commercial properties at competitive prices and prime locations.', 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(64, 8, 'hero', 'hero_button_text', 'تصفح العقارات', 'Browse Properties', 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(65, 8, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(66, 8, 'about', 'about_text', 'شركة عقارية رائدة في السوق مع خبرة تتجاوز 15 عاماً في مجال الوساطة العقارية. نقدم خدمات شاملة تشمل البيع والشراء والتأجير وإدارة الأملاك مع فريق من الخبراء المتخصصين.', 'A leading real estate company with over 15 years of experience in property brokerage. We offer comprehensive services including sales, purchases, leasing, and property management with a team of specialized experts.', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(67, 8, 'services', 'service_1', '{\"title_ar\":\"فلل فاخرة\",\"title_en\":\"Luxury Villas\",\"description_ar\":\"مجموعة حصرية من الفلل الفاخرة بأفضل المناطق السكنية مع تصميمات عصرية\",\"description_en\":\"Exclusive collection of luxury villas in the best residential areas with modern designs\",\"icon\":\"fas fa-home\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(68, 8, 'services', 'service_2', '{\"title_ar\":\"شقق سكنية\",\"title_en\":\"Residential Apartments\",\"description_ar\":\"شقق بتصاميم حديثة في مواقع استراتيجية مناسبة للعائلات والأفراد\",\"description_en\":\"Modern apartments in strategic locations suitable for families and individuals\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(69, 8, 'services', 'service_3', '{\"title_ar\":\"إدارة أملاك\",\"title_en\":\"Property Management\",\"description_ar\":\"خدمات إدارة أملاك شاملة تشمل الصيانة وتحصيل الإيجارات والتعاقدات\",\"description_en\":\"Comprehensive property management services including maintenance, rent collection, and contracts\",\"icon\":\"fas fa-key\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(70, 8, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الدوسري\",\"client_title\":\"رجل أعمال\",\"content\":\"ساعدوني في العثور على فيلا أحلامي بسرعة ممتازة ومهنية عالية.\",\"rating\":5}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(71, 8, 'testimonials', 'testimonial_2', '{\"client_name\":\"ريم الشهري\",\"client_title\":\"مهندسة\",\"content\":\"تجربة شراء شقة سلسة ومريحة. الفريق متعاون ومحترف جداً.\",\"rating\":5}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(72, 8, 'contact', 'contact_info', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"جدة - حي الحمراء - شارع الملك فهد\"}', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"Jeddah - Al Hamra District - King Fahd Road\"}', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(73, 9, 'hero', 'hero_title', 'أشهى المأكولات في مكان واحد', 'The Finest Cuisine in One Place', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(74, 9, 'hero', 'hero_subtitle', 'تجربة طعام استثنائية تأخذك في رحلة من الذواقة', 'An exceptional dining experience that takes you on a culinary journey', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(75, 9, 'hero', 'hero_description', 'مطعم فاخر يقدم أشهى الأطباق العربية والعالمية المحضرة بعناية من قبل أفضل الطهاة باستخدام أجود المكونات الطبيعية الطازجة.', 'A luxury restaurant serving the finest Arabic and international dishes carefully prepared by the best chefs using the finest natural fresh ingredients.', 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(76, 9, 'hero', 'hero_button_text', 'اطلب الآن', 'Order Now', 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(77, 9, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(78, 9, 'about', 'about_text', 'مطعمنا الفاخر يجمع بين الأصالة والحداثة في تقديم أشهى المأكولات. يمتلك فريقنا من الطهاة الحائزين على جوائز عالمية خبرة واسعة في فن الطبخ. نحرص على اختيار مكوناتنا من أفضل المزارع المحلية لتقديم تجربة طعام لا تُنسى.', 'Our luxury restaurant combines authenticity and modernity in serving the finest cuisine. Our award-winning chef team has extensive experience in the culinary arts. We carefully select our ingredients from the best local farms to deliver an unforgettable dining experience.', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(79, 9, 'services', 'service_1', '{\"title_ar\":\"عشاء فاخر\",\"title_en\":\"Fine Dining\",\"description_ar\":\"قائمة طعام متنوعة من الأطباق العربية والعالمية المحضرة بأيدي طهاة محترفين\",\"description_en\":\"Diverse menu of Arabic and international dishes prepared by professional chefs\",\"icon\":\"fas fa-utensils\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(80, 9, 'services', 'service_2', '{\"title_ar\":\"تموين مناسبات\",\"title_en\":\"Event Catering\",\"description_ar\":\"خدمات تموين احترافية للمناسبات والحفلات بجميع أنواعها وأحجامها\",\"description_en\":\"Professional catering services for events and parties of all types and sizes\",\"icon\":\"fas fa-glass-cheers\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(81, 9, 'services', 'service_3', '{\"title_ar\":\"خدمة التوصيل\",\"title_en\":\"Delivery Service\",\"description_ar\":\"خدمة توصيل سريعة لجميع الطلبات مع الحفاظ على جودة الطعام\",\"description_en\":\"Fast delivery service for all orders while maintaining food quality\",\"icon\":\"fas fa-motorcycle\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(82, 9, 'services', 'service_4', '{\"title_ar\":\"حجز طاولات\",\"title_en\":\"Table Reservation\",\"description_ar\":\"احجز طاولتك مسبقاً واستمتع بتجربة عشاء مميزة في أجواء راقية\",\"description_en\":\"Reserve your table in advance and enjoy a distinguished dinner experience in an elegant atmosphere\",\"icon\":\"fas fa-calendar-check\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(83, 9, 'testimonials', 'testimonial_1', '{\"client_name\":\"محمد السبيعي\",\"client_title\":\"مدير تنفيذي\",\"content\":\"أفضل مطعم في المدينة بلا منازع. الأكل لذيذ والخدمة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(84, 9, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند العنزي\",\"client_title\":\"مدونة طعام\",\"content\":\"جربت العديد من المطاعم لكن هذا المطعم في مستوى آخر تماماً.\",\"rating\":5}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(85, 9, 'contact', 'contact_info', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير محمد بن عبدالعزيز\"}', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"Riyadh - Al Malqa District - Prince Mohammed bin Abdulaziz Road\"}', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(86, 10, 'hero', 'hero_title', 'استثمر في مستقبلك التعليمي', 'Invest in Your Educational Future', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(87, 10, 'hero', 'hero_subtitle', 'تعليم متميز يبني أجيالاً واعية ومبدعة', 'Distinguished education building aware and creative generations', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(88, 10, 'hero', 'hero_description', 'أكاديمية تعليمية رائدة تقدم برامج تعليمية وتدريبية متطورة بأحدث الأساليب التعليمية مع نخبة من أفضل المدربين والمتخصصين.', 'A leading educational academy offering advanced educational and training programs using the latest teaching methods with a selection of the best trainers and specialists.', 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(89, 10, 'hero', 'hero_button_text', 'سجل الآن', 'Register Now', 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(90, 10, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(91, 10, 'about', 'about_text', 'أكاديمية تعليمية متخصصة تأسست بهدف تقديم تعليم عالي الجودة يواكب أحدث التطورات. نقدم برامج متنوعة تشمل الدورات التأهيلية والشهادات المهنية والتدريب العملي مع بيئة تعليمية محفزة.', 'A specialized educational academy established to provide high-quality education aligned with the latest developments. We offer diverse programs including qualification courses, professional certificates, and practical training in a motivating learning environment.', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(92, 10, 'services', 'service_1', '{\"title_ar\":\"دورات حضورية\",\"title_en\":\"Classroom Courses\",\"description_ar\":\"دورات تدريبية حضورية بفصول مجهزة بأحدث التقنيات مع مدربين محترفين\",\"description_en\":\"Classroom training courses in fully equipped halls with the latest technology and professional trainers\",\"icon\":\"fas fa-chalkboard-teacher\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(93, 10, 'services', 'service_2', '{\"title_ar\":\"تعليم عن بعد\",\"title_en\":\"Online Learning\",\"description_ar\":\"برامج تعليمية إلكترونية متكاملة يمكنك التعلم منها في أي وقت ومن أي مكان\",\"description_en\":\"Integrated e-learning programs you can study anytime and anywhere\",\"icon\":\"fas fa-laptop\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(94, 10, 'services', 'service_3', '{\"title_ar\":\"تدريب مهني\",\"title_en\":\"Professional Training\",\"description_ar\":\"برامج تدريب مهني معتمدة لتطوير المهارات ورفع الكفاءة المهنية\",\"description_en\":\"Accredited professional training programs to develop skills and enhance professional competence\",\"icon\":\"fas fa-graduation-cap\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(95, 10, 'services', 'service_4', '{\"title_ar\":\"استشارات تعليمية\",\"title_en\":\"Educational Consulting\",\"description_ar\":\"استشارات متخصصة لاختيار المسار التعليمي المناسب وتخطيط المستقبل الأكاديمي\",\"description_en\":\"Specialized consulting for choosing the right educational path and academic future planning\",\"icon\":\"fas fa-route\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(96, 10, 'testimonials', 'testimonial_1', '{\"client_name\":\"أحمد الحربي\",\"client_title\":\"طالب جامعي\",\"content\":\"الدورات هنا ساعدتني كثيراً في تطوير مهاراتي والحصول على وظيفة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(97, 10, 'testimonials', 'testimonial_2', '{\"client_name\":\"لمى الزهراني\",\"client_title\":\"مصممة جرافيك\",\"content\":\"تعلمت هنا أساسيات التصميم بشكل احترافي. المدربون رائعون والمحتوى ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(98, 10, 'contact', 'contact_info', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"الدمام - حي الفيصلية - شارع الأمير سلطان\"}', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"Dammam - Al Faisaliyah District - Prince Sultan Road\"}', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(99, 11, 'hero', 'hero_title', 'ابدأ رحلتك نحو اللياقة', 'Start Your Fitness Journey', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(100, 11, 'hero', 'hero_subtitle', 'نادي رياضي متكامل بأحدث المعدات و best المدربين', 'Fully equipped gym with the latest equipment and best trainers', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(101, 11, 'hero', 'hero_description', 'نادي رياضي متكامل يوفر بيئة محفزة لتحقيق أهدافك اللياقية مع فريق من المدربين المعتمدين وأحدث الأجهزة الرياضية العالمية.', 'A fully equipped gym providing a motivating environment to achieve your fitness goals with a team of certified trainers and the latest international sports equipment.', 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(102, 11, 'hero', 'hero_button_text', 'اشترك الآن', 'Join Now', 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(103, 11, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(104, 11, 'about', 'about_text', 'نادي رياضي رائد يهدف إلى نشر ثقافة اللياقة البدنية والحياة الصحية. نوفر مرافق عصرية تشمل صالة أوزان حرة وآلات، قاعات لليوغا والبيلاتس، مسبح أولمبي، وملاعب رياضية متعددة.', 'A leading sports club aiming to spread fitness culture and healthy living. We provide modern facilities including free weights and machines, yoga and pilates studios, Olympic pool, and multi-sport courts.', 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(105, 11, 'services', 'service_1', '{\"title_ar\":\"تدريب شخصي\",\"title_en\":\"Personal Training\",\"description_ar\":\"جلسات تدريب شخصي مع مدربين معتمديين لتصميم برامج مخصصة حسب أهدافك\",\"description_en\":\"Personal training sessions with certified trainers to design programs tailored to your goals\",\"icon\":\"fas fa-dumbbell\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(106, 11, 'services', 'service_2', '{\"title_ar\":\"يوجا وبيلاتس\",\"title_en\":\"Yoga and Pilates\",\"description_ar\":\"فصول يوجا وبيلاتس يومية لتحسين المرونة والاسترخاء الذهني\",\"description_en\":\"Daily yoga and pilates classes to improve flexibility and mental relaxation\",\"icon\":\"fas fa-spa\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(107, 11, 'services', 'service_3', '{\"title_ar\":\"برامج لياقة\",\"title_en\":\"Fitness Programs\",\"description_ar\":\"برامج لياقة متنوعة تشمل كارديو وقوة وتخسيس وزن وبناء عضلات\",\"description_en\":\"Diverse fitness programs including cardio, strength, weight loss, and muscle building\",\"icon\":\"fas fa-running\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(108, 11, 'services', 'service_4', '{\"title_ar\":\"تغذية صحية\",\"title_en\":\"Healthy Nutrition\",\"description_ar\":\"استشارات تغذية متخصصة مع خطط غذائية مخصصة لتحقيق أهدافك\",\"description_en\":\"Specialized nutrition consultations with custom meal plans to achieve your goals\",\"icon\":\"fas fa-apple-alt\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(109, 11, 'testimonials', 'testimonial_1', '{\"client_name\":\"عمر العتيبي\",\"client_title\":\"مهندس\",\"content\":\"خلال 3 أشهر فقط حققت هدفي في خسارة الوزن بفضل المدربين المحترفين هنا.\",\"rating\":5}', NULL, 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(110, 11, 'testimonials', 'testimonial_2', '{\"client_name\":\"سارة الغامدي\",\"client_title\":\"محاسبة\",\"content\":\"النادي نظيف جداً والأجهزة حديثة. أنصح الجميع بالاشتراك.\",\"rating\":5}', NULL, 2, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(111, 11, 'contact', 'contact_info', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"الرياض - حي النرجس - شارع أنس بن مالك\"}', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"Riyadh - Al Narjis District - Anas bin Malik Road\"}', 1, 1, '2026-04-10 20:03:51', '2026-04-10 20:03:51'),
(112, 12, 'hero', 'hero_title', 'حقوقك محمية بقوة القانون', 'Your Rights Protected by Law', 1, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(113, 12, 'hero', 'hero_subtitle', 'محامون متخصصون يضعون خبرتهم في خدمة عدالتك', 'Specialized lawyers putting their expertise at the service of your justice', 2, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(114, 12, 'hero', 'hero_description', 'مكتب محاماة متخصص يقدم خدمات قانونية شاملة بأعلى معايير المهنية والسرية. نمتلك فريقاً من المحامين والاستشاريين القانونيين ذوي الخبرة الواسعة في مختلف فروع القانون.', 'A specialized law firm providing comprehensive legal services to the highest professional and confidential standards. We have a team of lawyers and legal consultants with extensive experience in various branches of law.', 3, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(115, 12, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(116, 12, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(117, 12, 'about', 'about_text', 'مكتب محاماة راسخ يقدم خدمات قانونية متميزة منذ أكثر من 20 عاماً. نتعامل مع جميع أنواع القضايا المدنية والتجارية والعقارية والجنائية مع الالتزام بأعلى معايير السرية والأمانة المهنية.', 'An established law firm providing distinguished legal services for over 20 years. We handle all types of civil, commercial, real estate, and criminal cases while maintaining the highest standards of confidentiality and professional ethics.', 2, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(118, 12, 'services', 'service_1', '{\"title_ar\":\"استشارات قانونية\",\"title_en\":\"Legal Consultations\",\"description_ar\":\"استشارات قانونية متخصصة في جميع المجالات مع تحليل شامل للموقف القانوني\",\"description_en\":\"Specialized legal consultations in all fields with comprehensive legal situation analysis\",\"icon\":\"fas fa-gavel\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(119, 12, 'services', 'service_2', '{\"title_ar\":\"قانون الشركات\",\"title_en\":\"Corporate Law\",\"description_ar\":\"خدمات قانونية للشركات تشمل التأسيس والعقود والتحكيم التجاري\",\"description_en\":\"Legal services for companies including incorporation, contracts, and commercial arbitration\",\"icon\":\"fas fa-briefcase\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(120, 12, 'services', 'service_3', '{\"title_ar\":\"قضايا عقارية\",\"title_en\":\"Real Estate Cases\",\"description_ar\":\"تمثيل قانوني في القضايا العقارية ونزاعات الملكية وصياغة العقود\",\"description_en\":\"Legal representation in real estate cases, property disputes, and contract drafting\",\"icon\":\"fas fa-landmark\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(121, 12, 'services', 'service_4', '{\"title_ar\":\"قانون الأسرة\",\"title_en\":\"Family Law\",\"description_ar\":\"معالجة قضايا الأحوال الشخصية والطلاق والحضانة والنفقة\",\"description_en\":\"Handling personal status cases, divorce, custody, and alimony\",\"icon\":\"fas fa-users\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(122, 12, 'testimonials', 'testimonial_1', '{\"client_name\":\"ناصر العمري\",\"client_title\":\"رجل أعمال\",\"content\":\"محامون محترفون جداً. ساعدوني في حل نزاع تجاري معقد بنجاح.\",\"rating\":5}', NULL, 1, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(123, 12, 'testimonials', 'testimonial_2', '{\"client_name\":\"منال السلمي\",\"client_title\":\"سيدة أعمال\",\"content\":\"مكتب محترف ويتميز بالسرية التامة. أنصح أي شخص يحتاج مساعدة قانونية بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(124, 12, 'contact', 'contact_info', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"الرياض - حي العليا - برج المملكة - الطابق 15\"}', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"Riyadh - Olaya District - Kingdom Tower - 15th Floor\"}', 1, 1, '2026-04-10 20:03:52', '2026-04-10 20:03:52'),
(125, 7, 'hero', 'hero_title', 'رعاية صحية استثنائية', 'Exceptional Health Care', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(126, 7, 'hero', 'hero_subtitle', 'فريق طبي متخصص يضع صحتك أولاً', 'Specialized medical team putting your health first', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(127, 7, 'hero', 'hero_description', 'نوفر خدمات طبية شاملة بأحدث التقنيات وأفضل الأطباء المتخصصين في جميع المجالات الطبية. نلتزم بأعلى معايير الجودة والسلامة.', 'We provide comprehensive medical services with the latest technology and the best specialized doctors in all medical fields. We adhere to the highest quality and safety standards.', 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(128, 7, 'hero', 'hero_button_text', 'احجز موعد', 'Book Appointment', 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(129, 7, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(130, 7, 'about', 'about_text', 'مركز طبي متكامل يقدم خدمات الرعاية الصحية بأعلى المعايير العالمية. نضم فريقاً من أمهر الأطباء والاستشاريين في مختلف التخصصات الطبية مع أحدث الأجهزة والتقنيات الطبية المتطورة. نحرص على تقديم تجربة علاجية مريحة وآمنة لجميع مرضانا.', 'An integrated medical center providing healthcare services to the highest international standards. We have a team of the most skilled doctors and consultants across various medical specialties with the latest advanced medical equipment and technologies.', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(131, 7, 'services', 'service_1', '{\"title_ar\":\"فحص طبي شامل\",\"title_en\":\"Comprehensive Medical Checkup\",\"description_ar\":\"فحص طبي شامل يشمل جميع الفحوصات اللازمة للتأكد من سلامتك الصحية مع تقارير مفصلة\",\"description_en\":\"Comprehensive medical examination including all necessary tests to ensure your health with detailed reports\",\"icon\":\"fas fa-stethoscope\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(132, 7, 'services', 'service_2', '{\"title_ar\":\"طب الأسنان\",\"title_en\":\"Dental Care\",\"description_ar\":\"خدمات طب أسنان متكاملة من تنظيف وعلاج وتجميل باستخدام أحدث التقنيات\",\"description_en\":\"Integrated dental services from cleaning, treatment, and cosmetics using the latest technologies\",\"icon\":\"fas fa-tooth\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(133, 7, 'services', 'service_3', '{\"title_ar\":\"استشارات طبية\",\"title_en\":\"Medical Consultations\",\"description_ar\":\"استشارات طبية متخصصة مع أفضل الأطباء والاستشاريين في جميع التخصصات\",\"description_en\":\"Specialized medical consultations with the best doctors and consultants in all specialties\",\"icon\":\"fas fa-user-md\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(134, 7, 'services', 'service_4', '{\"title_ar\":\"مختبر تحاليل\",\"title_en\":\"Laboratory\",\"description_ar\":\"مختبر تحاليل مجهز بأحدث الأجهزة مع نتائج دقيقة وسريعة\",\"description_en\":\"Laboratory equipped with the latest devices with accurate and fast results\",\"icon\":\"fas fa-flask\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(135, 7, 'testimonials', 'testimonial_1', '{\"client_name\":\"سارة العتيبي\",\"client_title\":\"مريضة\",\"content\":\"تجربة رائعة مع فريق الطبيب محمد. كان شديد الاحترافية والاهتمام بالتفاصيل.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(136, 7, 'testimonials', 'testimonial_2', '{\"client_name\":\"خالد المطيري\",\"client_title\":\"تاجر\",\"content\":\"من أفضل المراكز الطبية التي تعاملت معها. النظافة والترتيب ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(137, 7, 'testimonials', 'testimonial_3', '{\"client_name\":\"نورة القحطاني\",\"client_title\":\"معلمة\",\"content\":\"أنصح الجميع بالتعامل معهم. خدمة مميزة وأسعار معقولة.\",\"rating\":4}', NULL, 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(138, 7, 'contact', 'contact_info', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"الرياض - حي العليا - شارع التحلية\"}', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"Riyadh - Olaya District - Tahliya Street\"}', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(139, 8, 'hero', 'hero_title', 'عقاراتك الفاخرة تنتظرك', 'Your Luxury Properties Await', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(140, 8, 'hero', 'hero_subtitle', 'اكتشف أفضل العقارات السكنية والتجارية', 'Discover the best residential and commercial properties', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(141, 8, 'hero', 'hero_description', 'وكالة عقارية متخصصة في تقديم أفضل الحلول العقارية. نوفر لك مجموعة واسعة من العقارات السكنية والتجارية بأسعار تنافسية وأفضل المواقع.', 'A specialized real estate agency providing the best property solutions. We offer a wide range of residential and commercial properties at competitive prices and prime locations.', 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(142, 8, 'hero', 'hero_button_text', 'تصفح العقارات', 'Browse Properties', 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(143, 8, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(144, 8, 'about', 'about_text', 'شركة عقارية رائدة في السوق مع خبرة تتجاوز 15 عاماً في مجال الوساطة العقارية. نقدم خدمات شاملة تشمل البيع والشراء والتأجير وإدارة الأملاك مع فريق من الخبراء المتخصصين.', 'A leading real estate company with over 15 years of experience in property brokerage. We offer comprehensive services including sales, purchases, leasing, and property management with a team of specialized experts.', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(145, 8, 'services', 'service_1', '{\"title_ar\":\"فلل فاخرة\",\"title_en\":\"Luxury Villas\",\"description_ar\":\"مجموعة حصرية من الفلل الفاخرة بأفضل المناطق السكنية مع تصميمات عصرية\",\"description_en\":\"Exclusive collection of luxury villas in the best residential areas with modern designs\",\"icon\":\"fas fa-home\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(146, 8, 'services', 'service_2', '{\"title_ar\":\"شقق سكنية\",\"title_en\":\"Residential Apartments\",\"description_ar\":\"شقق بتصاميم حديثة في مواقع استراتيجية مناسبة للعائلات والأفراد\",\"description_en\":\"Modern apartments in strategic locations suitable for families and individuals\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(147, 8, 'services', 'service_3', '{\"title_ar\":\"إدارة أملاك\",\"title_en\":\"Property Management\",\"description_ar\":\"خدمات إدارة أملاك شاملة تشمل الصيانة وتحصيل الإيجارات والتعاقدات\",\"description_en\":\"Comprehensive property management services including maintenance, rent collection, and contracts\",\"icon\":\"fas fa-key\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(148, 8, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الدوسري\",\"client_title\":\"رجل أعمال\",\"content\":\"ساعدوني في العثور على فيلا أحلامي بسرعة ممتازة ومهنية عالية.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(149, 8, 'testimonials', 'testimonial_2', '{\"client_name\":\"ريم الشهري\",\"client_title\":\"مهندسة\",\"content\":\"تجربة شراء شقة سلسة ومريحة. الفريق متعاون ومحترف جداً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(150, 8, 'contact', 'contact_info', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"جدة - حي الحمراء - شارع الملك فهد\"}', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"Jeddah - Al Hamra District - King Fahd Road\"}', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(151, 9, 'hero', 'hero_title', 'أشهى المأكولات في مكان واحد', 'The Finest Cuisine in One Place', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(152, 9, 'hero', 'hero_subtitle', 'تجربة طعام استثنائية تأخذك في رحلة من الذواقة', 'An exceptional dining experience that takes you on a culinary journey', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(153, 9, 'hero', 'hero_description', 'مطعم فاخر يقدم أشهى الأطباق العربية والعالمية المحضرة بعناية من قبل أفضل الطهاة باستخدام أجود المكونات الطبيعية الطازجة.', 'A luxury restaurant serving the finest Arabic and international dishes carefully prepared by the best chefs using the finest natural fresh ingredients.', 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(154, 9, 'hero', 'hero_button_text', 'اطلب الآن', 'Order Now', 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(155, 9, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(156, 9, 'about', 'about_text', 'مطعمنا الفاخر يجمع بين الأصالة والحداثة في تقديم أشهى المأكولات. يمتلك فريقنا من الطهاة الحائزين على جوائز عالمية خبرة واسعة في فن الطبخ. نحرص على اختيار مكوناتنا من أفضل المزارع المحلية لتقديم تجربة طعام لا تُنسى.', 'Our luxury restaurant combines authenticity and modernity in serving the finest cuisine. Our award-winning chef team has extensive experience in the culinary arts. We carefully select our ingredients from the best local farms to deliver an unforgettable dining experience.', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(157, 9, 'services', 'service_1', '{\"title_ar\":\"عشاء فاخر\",\"title_en\":\"Fine Dining\",\"description_ar\":\"قائمة طعام متنوعة من الأطباق العربية والعالمية المحضرة بأيدي طهاة محترفين\",\"description_en\":\"Diverse menu of Arabic and international dishes prepared by professional chefs\",\"icon\":\"fas fa-utensils\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(158, 9, 'services', 'service_2', '{\"title_ar\":\"تموين مناسبات\",\"title_en\":\"Event Catering\",\"description_ar\":\"خدمات تموين احترافية للمناسبات والحفلات بجميع أنواعها وأحجامها\",\"description_en\":\"Professional catering services for events and parties of all types and sizes\",\"icon\":\"fas fa-glass-cheers\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(159, 9, 'services', 'service_3', '{\"title_ar\":\"خدمة التوصيل\",\"title_en\":\"Delivery Service\",\"description_ar\":\"خدمة توصيل سريعة لجميع الطلبات مع الحفاظ على جودة الطعام\",\"description_en\":\"Fast delivery service for all orders while maintaining food quality\",\"icon\":\"fas fa-motorcycle\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(160, 9, 'services', 'service_4', '{\"title_ar\":\"حجز طاولات\",\"title_en\":\"Table Reservation\",\"description_ar\":\"احجز طاولتك مسبقاً واستمتع بتجربة عشاء مميزة في أجواء راقية\",\"description_en\":\"Reserve your table in advance and enjoy a distinguished dinner experience in an elegant atmosphere\",\"icon\":\"fas fa-calendar-check\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(161, 9, 'testimonials', 'testimonial_1', '{\"client_name\":\"محمد السبيعي\",\"client_title\":\"مدير تنفيذي\",\"content\":\"أفضل مطعم في المدينة بلا منازع. الأكل لذيذ والخدمة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(162, 9, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند العنزي\",\"client_title\":\"مدونة طعام\",\"content\":\"جربت العديد من المطاعم لكن هذا المطعم في مستوى آخر تماماً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(163, 9, 'contact', 'contact_info', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير محمد بن عبدالعزيز\"}', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"Riyadh - Al Malqa District - Prince Mohammed bin Abdulaziz Road\"}', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(164, 10, 'hero', 'hero_title', 'استثمر في مستقبلك التعليمي', 'Invest in Your Educational Future', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(165, 10, 'hero', 'hero_subtitle', 'تعليم متميز يبني أجيالاً واعية ومبدعة', 'Distinguished education building aware and creative generations', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(166, 10, 'hero', 'hero_description', 'أكاديمية تعليمية رائدة تقدم برامج تعليمية وتدريبية متطورة بأحدث الأساليب التعليمية مع نخبة من أفضل المدربين والمتخصصين.', 'A leading educational academy offering advanced educational and training programs using the latest teaching methods with a selection of the best trainers and specialists.', 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(167, 10, 'hero', 'hero_button_text', 'سجل الآن', 'Register Now', 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(168, 10, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(169, 10, 'about', 'about_text', 'أكاديمية تعليمية متخصصة تأسست بهدف تقديم تعليم عالي الجودة يواكب أحدث التطورات. نقدم برامج متنوعة تشمل الدورات التأهيلية والشهادات المهنية والتدريب العملي مع بيئة تعليمية محفزة.', 'A specialized educational academy established to provide high-quality education aligned with the latest developments. We offer diverse programs including qualification courses, professional certificates, and practical training in a motivating learning environment.', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01');
INSERT INTO `theme_contents` (`id`, `theme_id`, `section_type`, `content_key`, `content_ar`, `content_en`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(170, 10, 'services', 'service_1', '{\"title_ar\":\"دورات حضورية\",\"title_en\":\"Classroom Courses\",\"description_ar\":\"دورات تدريبية حضورية بفصول مجهزة بأحدث التقنيات مع مدربين محترفين\",\"description_en\":\"Classroom training courses in fully equipped halls with the latest technology and professional trainers\",\"icon\":\"fas fa-chalkboard-teacher\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(171, 10, 'services', 'service_2', '{\"title_ar\":\"تعليم عن بعد\",\"title_en\":\"Online Learning\",\"description_ar\":\"برامج تعليمية إلكترونية متكاملة يمكنك التعلم منها في أي وقت ومن أي مكان\",\"description_en\":\"Integrated e-learning programs you can study anytime and anywhere\",\"icon\":\"fas fa-laptop\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(172, 10, 'services', 'service_3', '{\"title_ar\":\"تدريب مهني\",\"title_en\":\"Professional Training\",\"description_ar\":\"برامج تدريب مهني معتمدة لتطوير المهارات ورفع الكفاءة المهنية\",\"description_en\":\"Accredited professional training programs to develop skills and enhance professional competence\",\"icon\":\"fas fa-graduation-cap\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(173, 10, 'services', 'service_4', '{\"title_ar\":\"استشارات تعليمية\",\"title_en\":\"Educational Consulting\",\"description_ar\":\"استشارات متخصصة لاختيار المسار التعليمي المناسب وتخطيط المستقبل الأكاديمي\",\"description_en\":\"Specialized consulting for choosing the right educational path and academic future planning\",\"icon\":\"fas fa-route\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(174, 10, 'testimonials', 'testimonial_1', '{\"client_name\":\"أحمد الحربي\",\"client_title\":\"طالب جامعي\",\"content\":\"الدورات هنا ساعدتني كثيراً في تطوير مهاراتي والحصول على وظيفة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(175, 10, 'testimonials', 'testimonial_2', '{\"client_name\":\"لمى الزهراني\",\"client_title\":\"مصممة جرافيك\",\"content\":\"تعلمت هنا أساسيات التصميم بشكل احترافي. المدربون رائعون والمحتوى ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(176, 10, 'contact', 'contact_info', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"الدمام - حي الفيصلية - شارع الأمير سلطان\"}', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"Dammam - Al Faisaliyah District - Prince Sultan Road\"}', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(177, 11, 'hero', 'hero_title', 'ابدأ رحلتك نحو اللياقة', 'Start Your Fitness Journey', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(178, 11, 'hero', 'hero_subtitle', 'نادي رياضي متكامل بأحدث المعدات و best المدربين', 'Fully equipped gym with the latest equipment and best trainers', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(179, 11, 'hero', 'hero_description', 'نادي رياضي متكامل يوفر بيئة محفزة لتحقيق أهدافك اللياقية مع فريق من المدربين المعتمدين وأحدث الأجهزة الرياضية العالمية.', 'A fully equipped gym providing a motivating environment to achieve your fitness goals with a team of certified trainers and the latest international sports equipment.', 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(180, 11, 'hero', 'hero_button_text', 'اشترك الآن', 'Join Now', 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(181, 11, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(182, 11, 'about', 'about_text', 'نادي رياضي رائد يهدف إلى نشر ثقافة اللياقة البدنية والحياة الصحية. نوفر مرافق عصرية تشمل صالة أوزان حرة وآلات، قاعات لليوغا والبيلاتس، مسبح أولمبي، وملاعب رياضية متعددة.', 'A leading sports club aiming to spread fitness culture and healthy living. We provide modern facilities including free weights and machines, yoga and pilates studios, Olympic pool, and multi-sport courts.', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(183, 11, 'services', 'service_1', '{\"title_ar\":\"تدريب شخصي\",\"title_en\":\"Personal Training\",\"description_ar\":\"جلسات تدريب شخصي مع مدربين معتمديين لتصميم برامج مخصصة حسب أهدافك\",\"description_en\":\"Personal training sessions with certified trainers to design programs tailored to your goals\",\"icon\":\"fas fa-dumbbell\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(184, 11, 'services', 'service_2', '{\"title_ar\":\"يوجا وبيلاتس\",\"title_en\":\"Yoga and Pilates\",\"description_ar\":\"فصول يوجا وبيلاتس يومية لتحسين المرونة والاسترخاء الذهني\",\"description_en\":\"Daily yoga and pilates classes to improve flexibility and mental relaxation\",\"icon\":\"fas fa-spa\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(185, 11, 'services', 'service_3', '{\"title_ar\":\"برامج لياقة\",\"title_en\":\"Fitness Programs\",\"description_ar\":\"برامج لياقة متنوعة تشمل كارديو وقوة وتخسيس وزن وبناء عضلات\",\"description_en\":\"Diverse fitness programs including cardio, strength, weight loss, and muscle building\",\"icon\":\"fas fa-running\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(186, 11, 'services', 'service_4', '{\"title_ar\":\"تغذية صحية\",\"title_en\":\"Healthy Nutrition\",\"description_ar\":\"استشارات تغذية متخصصة مع خطط غذائية مخصصة لتحقيق أهدافك\",\"description_en\":\"Specialized nutrition consultations with custom meal plans to achieve your goals\",\"icon\":\"fas fa-apple-alt\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(187, 11, 'testimonials', 'testimonial_1', '{\"client_name\":\"عمر العتيبي\",\"client_title\":\"مهندس\",\"content\":\"خلال 3 أشهر فقط حققت هدفي في خسارة الوزن بفضل المدربين المحترفين هنا.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(188, 11, 'testimonials', 'testimonial_2', '{\"client_name\":\"سارة الغامدي\",\"client_title\":\"محاسبة\",\"content\":\"النادي نظيف جداً والأجهزة حديثة. أنصح الجميع بالاشتراك.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(189, 11, 'contact', 'contact_info', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"الرياض - حي النرجس - شارع أنس بن مالك\"}', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"Riyadh - Al Narjis District - Anas bin Malik Road\"}', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(190, 12, 'hero', 'hero_title', 'حقوقك محمية بقوة القانون', 'Your Rights Protected by Law', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(191, 12, 'hero', 'hero_subtitle', 'محامون متخصصون يضعون خبرتهم في خدمة عدالتك', 'Specialized lawyers putting their expertise at the service of your justice', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(192, 12, 'hero', 'hero_description', 'مكتب محاماة متخصص يقدم خدمات قانونية شاملة بأعلى معايير المهنية والسرية. نمتلك فريقاً من المحامين والاستشاريين القانونيين ذوي الخبرة الواسعة في مختلف فروع القانون.', 'A specialized law firm providing comprehensive legal services to the highest professional and confidential standards. We have a team of lawyers and legal consultants with extensive experience in various branches of law.', 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(193, 12, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(194, 12, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(195, 12, 'about', 'about_text', 'مكتب محاماة راسخ يقدم خدمات قانونية متميزة منذ أكثر من 20 عاماً. نتعامل مع جميع أنواع القضايا المدنية والتجارية والعقارية والجنائية مع الالتزام بأعلى معايير السرية والأمانة المهنية.', 'An established law firm providing distinguished legal services for over 20 years. We handle all types of civil, commercial, real estate, and criminal cases while maintaining the highest standards of confidentiality and professional ethics.', 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(196, 12, 'services', 'service_1', '{\"title_ar\":\"استشارات قانونية\",\"title_en\":\"Legal Consultations\",\"description_ar\":\"استشارات قانونية متخصصة في جميع المجالات مع تحليل شامل للموقف القانوني\",\"description_en\":\"Specialized legal consultations in all fields with comprehensive legal situation analysis\",\"icon\":\"fas fa-gavel\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(197, 12, 'services', 'service_2', '{\"title_ar\":\"قانون الشركات\",\"title_en\":\"Corporate Law\",\"description_ar\":\"خدمات قانونية للشركات تشمل التأسيس والعقود والتحكيم التجاري\",\"description_en\":\"Legal services for companies including incorporation, contracts, and commercial arbitration\",\"icon\":\"fas fa-briefcase\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(198, 12, 'services', 'service_3', '{\"title_ar\":\"قضايا عقارية\",\"title_en\":\"Real Estate Cases\",\"description_ar\":\"تمثيل قانوني في القضايا العقارية ونزاعات الملكية وصياغة العقود\",\"description_en\":\"Legal representation in real estate cases, property disputes, and contract drafting\",\"icon\":\"fas fa-landmark\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(199, 12, 'services', 'service_4', '{\"title_ar\":\"قانون الأسرة\",\"title_en\":\"Family Law\",\"description_ar\":\"معالجة قضايا الأحوال الشخصية والطلاق والحضانة والنفقة\",\"description_en\":\"Handling personal status cases, divorce, custody, and alimony\",\"icon\":\"fas fa-users\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(200, 12, 'testimonials', 'testimonial_1', '{\"client_name\":\"ناصر العمري\",\"client_title\":\"رجل أعمال\",\"content\":\"محامون محترفون جداً. ساعدوني في حل نزاع تجاري معقد بنجاح.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(201, 12, 'testimonials', 'testimonial_2', '{\"client_name\":\"منال السلمي\",\"client_title\":\"سيدة أعمال\",\"content\":\"مكتب محترف ويتميز بالسرية التامة. أنصح أي شخص يحتاج مساعدة قانونية بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(202, 12, 'contact', 'contact_info', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"الرياض - حي العليا - برج المملكة - الطابق 15\"}', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"Riyadh - Olaya District - Kingdom Tower - 15th Floor\"}', 1, 1, '2026-04-11 00:56:01', '2026-04-11 00:56:01'),
(203, 1, 'hero', 'hero_title', 'حلول احترافية لنجاح أعمالك', 'Professional Solutions for Your Business Success', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(204, 1, 'hero', 'hero_subtitle', 'شريكك الموثوق في عالم الأعمال الرقمية', 'Your Trusted Partner in the Digital Business World', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(205, 1, 'hero', 'hero_description', 'نقدم حلولاً متكاملة تساعدك على تطوير أعمالك وتحقيق أهدافك بكفاءة عالية. فريقنا المتخصص يضع خبراته في خدمتك لتقديم أفضل النتائج.', 'We provide integrated solutions to help you grow your business and achieve your goals efficiently. Our expert team puts their expertise at your service to deliver the best results.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(206, 1, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(207, 1, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(208, 1, 'about', 'about_text', 'شركة رائدة في تقديم الحلول الرقمية المتميزة. نمتلك فريقاً من الخبراء والمتخصصين الذين يعملون بشغف لتقديم خدمات عالية الجودة تلبي احتياجات عملائنا المتنوعة.', 'A leading company in providing outstanding digital solutions. We have a team of experts and specialists who work passionately to deliver high-quality services that meet our clients diverse needs.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(209, 1, 'services', 'service_1', '{\"title_ar\":\"استشارات الأعمال\",\"title_en\":\"Business Consulting\",\"description_ar\":\"استشارات متخصصة لتطوير أعمالك وزيادة الإنتاجية مع خطط استراتيجية مخصصة\",\"description_en\":\"Specialized consulting to develop your business and increase productivity with custom strategic plans\",\"icon\":\"fas fa-chart-line\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(210, 1, 'services', 'service_2', '{\"title_ar\":\"تطوير المواقع\",\"title_en\":\"Web Development\",\"description_ar\":\"تصميم وتطوير مواقع إلكترونية احترافية متجاوبة مع جميع الأجهزة\",\"description_en\":\"Professional responsive website design and development for all devices\",\"icon\":\"fas fa-code\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(211, 1, 'services', 'service_3', '{\"title_ar\":\"التسويق الرقمي\",\"title_en\":\"Digital Marketing\",\"description_ar\":\"استراتيجيات تسويق رقمي متكاملة لزيادة الوعي بعلامتك التجارية\",\"description_en\":\"Integrated digital marketing strategies to increase brand awareness\",\"icon\":\"fas fa-bullhorn\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(212, 1, 'services', 'service_4', '{\"title_ar\":\"الدعم الفني\",\"title_en\":\"Technical Support\",\"description_ar\":\"دعم فني على مدار الساعة لضمان سير عملك بدون انقطاع\",\"description_en\":\"24/7 technical support to ensure your business runs without interruption\",\"icon\":\"fas fa-headset\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(213, 1, 'testimonials', 'testimonial_1', '{\"client_name\":\"عبدالله السعيد\",\"client_title\":\"مدير شركة\",\"content\":\"خدمة ممتازة وفريق محترف. ساعدونا في تحقيق أهدافنا بشكل أسرع من المتوقع.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(214, 1, 'testimonials', 'testimonial_2', '{\"client_name\":\"مريم الحربي\",\"client_title\":\"رائدة أعمال\",\"content\":\"من أفضل الشركات التي تعاملت معها. الجودة والاحترافية في كل تفصيل.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(215, 1, 'contact', 'contact_info', '{\"phone\":\"966500000100\",\"whatsapp\":\"966500000100\",\"email\":\"info@generic-company.com\",\"address\":\"الرياض - حي العليا - شارع الملك فهد\"}', '{\"phone\":\"966500000100\",\"whatsapp\":\"966500000100\",\"email\":\"info@generic-company.com\",\"address\":\"Riyadh - Olaya District - King Fahd Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(216, 2, 'hero', 'hero_title', 'حلول كهربائية متكاملة', 'Integrated Electrical Solutions', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(217, 2, 'hero', 'hero_subtitle', 'فنيون معتمدون بخبرة تفوق 15 عاماً في جميع الأعمال الكهربائية', 'Certified technicians with over 15 years of experience in all electrical work', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(218, 2, 'hero', 'hero_description', 'شركة متخصصة في تقديم جميع الخدمات الكهربائية للمنازل والمنشآت التجارية والصناعية. نلتزم بأعلى معايير السلامة والجودة مع ضمان على جميع أعمالنا.', 'A company specializing in providing all electrical services for homes, commercial, and industrial facilities. We adhere to the highest safety and quality standards with warranty on all our work.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(219, 2, 'hero', 'hero_button_text', 'اطلب فني', 'Request Technician', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(220, 2, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(221, 2, 'about', 'about_text', 'شركة كهربائية رائدة تقدم خدماتها منذ أكثر من 15 عاماً. نمتلك فريقاً من الفنيين والمهندسين المعتمدين المتخصصين في جميع مجالات الأعمال الكهربائية مع استخدام أجود المواد والمعدات.', 'A leading electrical company serving for over 15 years. We have a team of certified technicians and engineers specialized in all areas of electrical work using the finest materials and equipment.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(222, 2, 'services', 'service_1', '{\"title_ar\":\"تمديدات كهربائية\",\"title_en\":\"Electrical Wiring\",\"description_ar\":\"تمديدات كهربائية احترافية للمنازل والمباني التجارية بمعايير السلامة الدولية\",\"description_en\":\"Professional electrical wiring for homes and commercial buildings to international safety standards\",\"icon\":\"fas fa-bolt\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(223, 2, 'services', 'service_2', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة وتركيب جميع أنواع المكيفات مع ضمان شامل على القطع والعمل\",\"description_en\":\"Maintenance and installation of all AC types with comprehensive warranty on parts and labor\",\"icon\":\"fas fa-snowflake\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(224, 2, 'services', 'service_3', '{\"title_ar\":\"لوحات التحكم\",\"title_en\":\"Control Panels\",\"description_ar\":\"تصميم وتركيب لوحات التحكم الكهربائية للمباني والمصانع\",\"description_en\":\"Design and installation of electrical control panels for buildings and factories\",\"icon\":\"fas fa-sliders-h\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(225, 2, 'services', 'service_4', '{\"title_ar\":\"طوارئ كهربائية\",\"title_en\":\"Emergency Electrical\",\"description_ar\":\"خدمة طوارئ على مدار الساعة لحل جميع المشاكل الكهربائية العاجلة\",\"description_en\":\"24/7 emergency service to resolve all urgent electrical problems\",\"icon\":\"fas fa-exclamation-triangle\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(226, 2, 'testimonials', 'testimonial_1', '{\"client_name\":\"سعد القحطاني\",\"client_title\":\"مهندس\",\"content\":\"فريق محترف وسريع في الاستجابة. أنجزوا المشروع قبل الموعد المحدد.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(227, 2, 'testimonials', 'testimonial_2', '{\"client_name\":\"فاطمة الشمري\",\"client_title\":\"ربة منزل\",\"content\":\"خدمة ممتازة وأسعار معقولة. أنصح الجميع بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(228, 2, 'contact', 'contact_info', '{\"phone\":\"966500000102\",\"whatsapp\":\"966500000102\",\"email\":\"info@electric-services.com\",\"address\":\"جدة - حي الصفا - شارع فلسطين\"}', '{\"phone\":\"966500000102\",\"whatsapp\":\"966500000102\",\"email\":\"info@electric-services.com\",\"address\":\"Jeddah - Al Safa District - Palestine Street\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(229, 3, 'hero', 'hero_title', 'نظافة مثالية بلمسة احترافية', 'Perfect Cleanliness with a Professional Touch', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(230, 3, 'hero', 'hero_subtitle', 'خدمات تنظيف شاملة للمنازل والمكاتب والمنشآت التجارية', 'Comprehensive cleaning services for homes, offices, and commercial facilities', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(231, 3, 'hero', 'hero_description', 'شركة تنظيف متخصصة تقدم خدمات شاملة باستخدام أحدث المعدات ومواد التنظيف الآمنة والصديقة للبيئة. نضمن لك بيئة نظيفة وصحية.', 'A specialized cleaning company offering comprehensive services using the latest equipment and eco-friendly cleaning products. We guarantee a clean and healthy environment.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(232, 3, 'hero', 'hero_button_text', 'احجز الآن', 'Book Now', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(233, 3, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(234, 3, 'about', 'about_text', 'شركة تنظيف رائدة تتميز بخبرة واسعة في تقديم خدمات تنظيف عالية الجودة. نستخدم أحدث التقنيات ومواد تنظيف آمنة مع فريق مدرب على أعلى مستوى.', 'A leading cleaning company distinguished by extensive experience in delivering high-quality cleaning services. We use the latest technologies and safe cleaning products with a highly trained team.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(235, 3, 'services', 'service_1', '{\"title_ar\":\"تنظيف عميق\",\"title_en\":\"Deep Cleaning\",\"description_ar\":\"تنظيف عميق شامل لجميع أنحاء المنزل أو المكتب باستخدام أحدث المعدات\",\"description_en\":\"Comprehensive deep cleaning for the entire home or office using the latest equipment\",\"icon\":\"fas fa-broom\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(236, 3, 'services', 'service_2', '{\"title_ar\":\"تنظيف المكاتب\",\"title_en\":\"Office Cleaning\",\"description_ar\":\"خدمات تنظيف يومية وأسبوعية للمكاتب والمنشآت التجارية\",\"description_en\":\"Daily and weekly cleaning services for offices and commercial facilities\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(237, 3, 'services', 'service_3', '{\"title_ar\":\"تنظيف السجاد\",\"title_en\":\"Carpet Cleaning\",\"description_ar\":\"تنظيف احترافي للسجاد والموكيت بجميع أنواعه وأحجامه\",\"description_en\":\"Professional carpet and rug cleaning of all types and sizes\",\"icon\":\"fas fa-rug\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(238, 3, 'services', 'service_4', '{\"title_ar\":\"تنظيف بعد البناء\",\"title_en\":\"Post-Construction\",\"description_ar\":\"تنظيف شامل بعد أعمال البناء والتشطيبات لإعداد المكان للاستخدام\",\"description_en\":\"Comprehensive cleaning after construction and finishing work to prepare the space for use\",\"icon\":\"fas fa-hard-hat\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(239, 3, 'testimonials', 'testimonial_1', '{\"client_name\":\"نوف العتيبي\",\"client_title\":\"سيدة أعمال\",\"content\":\"منظفون محترفون والنتيجة ممتازة. البيئة أصبحت نظيفة ومعطرة بشكل رائع.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(240, 3, 'testimonials', 'testimonial_2', '{\"client_name\":\"مازن الدوسري\",\"client_title\":\"مدير مكتب\",\"content\":\"نتعامل معهم لتنظيف مكاتبنا أسبوعياً ولم نختبر يوماً أي تقصير.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(241, 3, 'contact', 'contact_info', '{\"phone\":\"966500000103\",\"whatsapp\":\"966500000103\",\"email\":\"info@cleaning-services.com\",\"address\":\"الرياض - حي النسيم - شارع الحسن\"}', '{\"phone\":\"966500000103\",\"whatsapp\":\"966500000103\",\"email\":\"info@cleaning-services.com\",\"address\":\"Riyadh - Al Naseem District - Al Hassan Street\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(242, 4, 'hero', 'hero_title', 'تصاميم ديكور فاخرة', 'Luxury Interior Design', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(243, 4, 'hero', 'hero_subtitle', 'نحول رؤيتك إلى واقع بلمسات فنية استثنائية', 'We turn your vision into reality with exceptional artistic touches', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(244, 4, 'hero', 'hero_description', 'استوديو ديكور متخصص يقدم خدمات تصميم داخلي وتنسيق ديكور احترافية للمنازل والمكاتب والفنادق والمساحات التجارية بأحدث الاتجاهات العالمية.', 'A specialized decor studio offering professional interior design and decor coordination services for homes, offices, hotels, and commercial spaces with the latest global trends.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(245, 4, 'hero', 'hero_button_text', 'شاهد أعمالنا', 'View Our Work', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(246, 4, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(247, 4, 'about', 'about_text', 'استوديو ديكور تأسس على يد فريق من المصممين المبدعين الذين يجمعون بين الفن والوظيفة. نقدم تصاميم فريدة تعكس ذوقك الشخصي وتلبي احتياجاتك العملية مع الالتزام بالميزانية.', 'A decor studio founded by a team of creative designers who combine art and function. We deliver unique designs that reflect your personal taste and meet your practical needs while staying within budget.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(248, 4, 'services', 'service_1', '{\"title_ar\":\"تصميم داخلي\",\"title_en\":\"Interior Design\",\"description_ar\":\"تصميم داخلي متكامل يراعي الجمال والوظيفة والراحة في كل تفصيل\",\"description_en\":\"Complete interior design balancing beauty, function, and comfort in every detail\",\"icon\":\"fas fa-couch\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(249, 4, 'services', 'service_2', '{\"title_ar\":\"تنسيق المساحات\",\"title_en\":\"Space Planning\",\"description_ar\":\"تنسيق المساحات بشكل ذكي لتحقيق أقصى استفادة من كل متر مربع\",\"description_en\":\"Smart space planning to maximize the use of every square meter\",\"icon\":\"fas fa-drafting-compass\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(250, 4, 'services', 'service_3', '{\"title_ar\":\"دهانات احترافية\",\"title_en\":\"Professional Painting\",\"description_ar\":\"خدمات دهانات احترافية بأحدث الألوان والتقنيات مع تشطيبات فاخرة\",\"description_en\":\"Professional painting services with the latest colors and techniques plus luxury finishes\",\"icon\":\"fas fa-paint-roller\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(251, 4, 'services', 'service_4', '{\"title_ar\":\"إضاءة وتجهيز\",\"title_en\":\"Lighting & Furnishing\",\"description_ar\":\"اختيار وتنسيق الإضاءة والأثاث لإضفاء لمسة فاخرة على المكان\",\"description_en\":\"Selection and coordination of lighting and furniture to add a luxurious touch to the space\",\"icon\":\"fas fa-lightbulb\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(252, 4, 'testimonials', 'testimonial_1', '{\"client_name\":\"لمياء العمري\",\"client_title\":\"ربة منزل\",\"content\":\"حولوا بيتنا إلى قصر. التصميم أكثر من رائع والتنفيذ دقيق جداً.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(253, 4, 'testimonials', 'testimonial_2', '{\"client_name\":\"تركي العنزي\",\"client_title\":\"رجل أعمال\",\"content\":\"تعاملنا معهم في تصميم مكاتبنا والنتيجة فاقت كل التوقعات.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(254, 4, 'contact', 'contact_info', '{\"phone\":\"966500000104\",\"whatsapp\":\"966500000104\",\"email\":\"info@decor-studio.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير سعد بن عبدالرحمن\"}', '{\"phone\":\"966500000104\",\"whatsapp\":\"966500000104\",\"email\":\"info@decor-studio.com\",\"address\":\"Riyadh - Al Malqa District - Prince Saad bin Abdulrahman Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(255, 5, 'hero', 'hero_title', 'صيانة شاملة بمعايير عالمية', 'Comprehensive Maintenance with International Standards', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(256, 5, 'hero', 'hero_subtitle', 'فريق فنيون متخصصون لحل جميع مشاكل المنزل والمكتب', 'Specialized technical team to solve all home and office problems', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(257, 5, 'hero', 'hero_description', 'شركة صيانة متكاملة تقدم خدماتها للمنازل والمكاتب والمنشآت التجارية. نمتلك فريقاً من الفنيين المعتمدين في جميع التخصصات مع ضمان شامل على جميع أعمالنا.', 'An integrated maintenance company serving homes, offices, and commercial facilities. We have a team of certified technicians across all specialties with a comprehensive warranty on all our work.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(258, 5, 'hero', 'hero_button_text', 'اطلب صيانة', 'Request Service', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(259, 5, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(260, 5, 'about', 'about_text', 'شركة صيانة رائدة تقدم حلولاً شاملة وموثوقة لجميع احتياجات الصيانة. نحرص على الالتزام بالمواعيد وتقديم خدمات عالية الجودة بأسعار تنافسية مع ضمان على كل عمل نقوم به.', 'A leading maintenance company providing comprehensive and reliable solutions for all maintenance needs. We are committed to punctuality and delivering high-quality services at competitive prices with warranty on every job.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(261, 5, 'services', 'service_1', '{\"title_ar\":\"كهرباء المنازل\",\"title_en\":\"Home Electrical\",\"description_ar\":\"صيانة كهربائية شاملة للمنازل من تمديدات وإصلاحات وتركيبات\",\"description_en\":\"Comprehensive home electrical maintenance from wiring, repairs, and installations\",\"icon\":\"fas fa-plug\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(262, 5, 'services', 'service_2', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة وتركيب وغسيل مكيفات جميع الأنواع مع ضمان الخدمة\",\"description_en\":\"AC maintenance, installation, and cleaning of all types with service warranty\",\"icon\":\"fas fa-fan\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(263, 5, 'services', 'service_3', '{\"title_ar\":\"خدمات الدهان\",\"title_en\":\"Painting Services\",\"description_ar\":\"دهانات داخلية وخارجية بجميع الألوان والتقنيات الحديثة\",\"description_en\":\"Interior and exterior painting with all colors and modern techniques\",\"icon\":\"fas fa-paint-brush\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(264, 5, 'services', 'service_4', '{\"title_ar\":\"سباكة وإصلاحات\",\"title_en\":\"Plumbing & Repairs\",\"description_ar\":\"خدمات سباكة شاملة من تركيب وإصلاح وصيانة جميع الأنابيب والصحيات\",\"description_en\":\"Comprehensive plumbing services from installation, repair, and maintenance of all pipes and fixtures\",\"icon\":\"fas fa-wrench\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(265, 5, 'testimonials', 'testimonial_1', '{\"client_name\":\"سلطان المطيري\",\"client_title\":\"مدير مدرسة\",\"content\":\"صيانة ممتازة وسريعة. الفنيون محترفون والأسعار معقولة جداً.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(266, 5, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند الزهراني\",\"client_title\":\"ربة منزل\",\"content\":\"أنقذونا في مشكلة السباكة الطارئة. وصلوا خلال ساعة وأصلحوا المشكلة.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(267, 5, 'contact', 'contact_info', '{\"phone\":\"966500000105\",\"whatsapp\":\"966500000105\",\"email\":\"info@maintenance-services.com\",\"address\":\"الدمام - حي الشاطئ - شارع الأمير محمد\"}', '{\"phone\":\"966500000105\",\"whatsapp\":\"966500000105\",\"email\":\"info@maintenance-services.com\",\"address\":\"Dammam - Al Sahati District - Prince Mohammed Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(268, 6, 'hero', 'hero_title', 'حلول سباكة موثوقة وسريعة', 'Reliable and Fast Plumbing Solutions', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(269, 6, 'hero', 'hero_subtitle', 'سباكون معتمدون بخبرة تفوق 10 سنوات في جميع أعمال السباكة', 'Certified plumbers with over 10 years of experience in all plumbing work', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(270, 6, 'hero', 'hero_description', 'شركة سباكة متخصصة تقدم خدمات شاملة من الإصلاحات الطارئة إلى التركيبات الجديدة. نستخدم أجود القطع والمواد مع ضمان شامل على جميع أعمالنا وخدمة على مدار الساعة.', 'A specialized plumbing company offering comprehensive services from emergency repairs to new installations. We use the finest parts and materials with a comprehensive warranty on all our work and 24/7 service.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(271, 6, 'hero', 'hero_button_text', 'اتصل الآن', 'Call Now', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(272, 6, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(273, 6, 'about', 'about_text', 'شركة سباكة متخصصة تتميز بفريق من الفنيين المعتمدين ذوي الخبرة الواسعة. نقدم حلولاً سريعة ودائمة لمشاكل السباكة مع الالتزام بأعلى معايير الجودة والنظافة.', 'A specialized plumbing company featuring a team of certified technicians with extensive experience. We provide fast and permanent solutions to plumbing problems while adhering to the highest quality and cleanliness standards.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(274, 6, 'services', 'service_1', '{\"title_ar\":\"إصلاح السباكة\",\"title_en\":\"Plumbing Repair\",\"description_ar\":\"إصلاح سريع ودقيق لجميع أعطال السباكة مع ضمان على العمل\",\"description_en\":\"Fast and accurate repair of all plumbing failures with work warranty\",\"icon\":\"fas fa-wrench\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(275, 6, 'services', 'service_2', '{\"title_ar\":\"تركيب الصحيات\",\"title_en\":\"Fixture Installation\",\"description_ar\":\"تركيب جميع أنواع الصحيات والمعدات بأعلى معايير الجودة\",\"description_en\":\"Installation of all types of fixtures and equipment to the highest quality standards\",\"icon\":\"fas fa-faucet\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(276, 6, 'services', 'service_3', '{\"title_ar\":\"كشف التسريبات\",\"title_en\":\"Leak Detection\",\"description_ar\":\"كشف وإصلاح تسريبات المياه بأحدث التقنيات دون تكسير\",\"description_en\":\"Leak detection and repair using the latest technologies without demolition\",\"icon\":\"fas fa-tint\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(277, 6, 'services', 'service_4', '{\"title_ar\":\"صيانة مجاري\",\"title_en\":\"Drain Maintenance\",\"description_ar\":\"تنظيف وصيانة المجاري والبالوعات بأحدث المعدات المتخصصة\",\"description_en\":\"Drain and sewer cleaning and maintenance with the latest specialized equipment\",\"icon\":\"fas fa-water\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(278, 6, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الشمري\",\"client_title\":\"مالك فيلا\",\"content\":\"وصلوا خلال نصف ساعة وأصلحوا الانفجار بسرعة واحترافية ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(279, 6, 'testimonials', 'testimonial_2', '{\"client_name\":\"أم سلطان\",\"client_title\":\"ربة منزل\",\"content\":\"تعاملت معهم عدة مرات ودائماً خدمة ممتازة وأسعار مناسبة.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(280, 6, 'contact', 'contact_info', '{\"phone\":\"966500000106\",\"whatsapp\":\"966500000106\",\"email\":\"info@plumbing-services.com\",\"address\":\"الرياض - حي الروضة - شارع الإمام تركي\"}', '{\"phone\":\"966500000106\",\"whatsapp\":\"966500000106\",\"email\":\"info@plumbing-services.com\",\"address\":\"Riyadh - Al Rawdah District - Imam Turki Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(281, 7, 'hero', 'hero_title', 'رعاية صحية استثنائية', 'Exceptional Health Care', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(282, 7, 'hero', 'hero_subtitle', 'فريق طبي متخصص يضع صحتك أولاً', 'Specialized medical team putting your health first', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(283, 7, 'hero', 'hero_description', 'نوفر خدمات طبية شاملة بأحدث التقنيات وأفضل الأطباء المتخصصين في جميع المجالات الطبية. نلتزم بأعلى معايير الجودة والسلامة.', 'We provide comprehensive medical services with the latest technology and the best specialized doctors in all medical fields. We adhere to the highest quality and safety standards.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(284, 7, 'hero', 'hero_button_text', 'احجز موعد', 'Book Appointment', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(285, 7, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(286, 7, 'about', 'about_text', 'مركز طبي متكامل يقدم خدمات الرعاية الصحية بأعلى المعايير العالمية. نضم فريقاً من أمهر الأطباء والاستشاريين في مختلف التخصصات الطبية مع أحدث الأجهزة والتقنيات الطبية المتطورة. نحرص على تقديم تجربة علاجية مريحة وآمنة لجميع مرضانا.', 'An integrated medical center providing healthcare services to the highest international standards. We have a team of the most skilled doctors and consultants across various medical specialties with the latest advanced medical equipment and technologies.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(287, 7, 'services', 'service_1', '{\"title_ar\":\"فحص طبي شامل\",\"title_en\":\"Comprehensive Medical Checkup\",\"description_ar\":\"فحص طبي شامل يشمل جميع الفحوصات اللازمة للتأكد من سلامتك الصحية مع تقارير مفصلة\",\"description_en\":\"Comprehensive medical examination including all necessary tests to ensure your health with detailed reports\",\"icon\":\"fas fa-stethoscope\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(288, 7, 'services', 'service_2', '{\"title_ar\":\"طب الأسنان\",\"title_en\":\"Dental Care\",\"description_ar\":\"خدمات طب أسنان متكاملة من تنظيف وعلاج وتجميل باستخدام أحدث التقنيات\",\"description_en\":\"Integrated dental services from cleaning, treatment, and cosmetics using the latest technologies\",\"icon\":\"fas fa-tooth\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(289, 7, 'services', 'service_3', '{\"title_ar\":\"استشارات طبية\",\"title_en\":\"Medical Consultations\",\"description_ar\":\"استشارات طبية متخصصة مع أفضل الأطباء والاستشاريين في جميع التخصصات\",\"description_en\":\"Specialized medical consultations with the best doctors and consultants in all specialties\",\"icon\":\"fas fa-user-md\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(290, 7, 'services', 'service_4', '{\"title_ar\":\"مختبر تحاليل\",\"title_en\":\"Laboratory\",\"description_ar\":\"مختبر تحاليل مجهز بأحدث الأجهزة مع نتائج دقيقة وسريعة\",\"description_en\":\"Laboratory equipped with the latest devices with accurate and fast results\",\"icon\":\"fas fa-flask\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(291, 7, 'testimonials', 'testimonial_1', '{\"client_name\":\"سارة العتيبي\",\"client_title\":\"مريضة\",\"content\":\"تجربة رائعة مع فريق الطبيب محمد. كان شديد الاحترافية والاهتمام بالتفاصيل.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(292, 7, 'testimonials', 'testimonial_2', '{\"client_name\":\"خالد المطيري\",\"client_title\":\"تاجر\",\"content\":\"من أفضل المراكز الطبية التي تعاملت معها. النظافة والترتيب ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(293, 7, 'testimonials', 'testimonial_3', '{\"client_name\":\"نورة القحطاني\",\"client_title\":\"معلمة\",\"content\":\"أنصح الجميع بالتعامل معهم. خدمة مميزة وأسعار معقولة.\",\"rating\":4}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(294, 7, 'contact', 'contact_info', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"الرياض - حي العليا - شارع التحلية\"}', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"Riyadh - Olaya District - Tahliya Street\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(295, 8, 'hero', 'hero_title', 'عقاراتك الفاخرة تنتظرك', 'Your Luxury Properties Await', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(296, 8, 'hero', 'hero_subtitle', 'اكتشف أفضل العقارات السكنية والتجارية', 'Discover the best residential and commercial properties', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(297, 8, 'hero', 'hero_description', 'وكالة عقارية متخصصة في تقديم أفضل الحلول العقارية. نوفر لك مجموعة واسعة من العقارات السكنية والتجارية بأسعار تنافسية وأفضل المواقع.', 'A specialized real estate agency providing the best property solutions. We offer a wide range of residential and commercial properties at competitive prices and prime locations.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(298, 8, 'hero', 'hero_button_text', 'تصفح العقارات', 'Browse Properties', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(299, 8, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(300, 8, 'about', 'about_text', 'شركة عقارية رائدة في السوق مع خبرة تتجاوز 15 عاماً في مجال الوساطة العقارية. نقدم خدمات شاملة تشمل البيع والشراء والتأجير وإدارة الأملاك مع فريق من الخبراء المتخصصين.', 'A leading real estate company with over 15 years of experience in property brokerage. We offer comprehensive services including sales, purchases, leasing, and property management with a team of specialized experts.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(301, 8, 'services', 'service_1', '{\"title_ar\":\"فلل فاخرة\",\"title_en\":\"Luxury Villas\",\"description_ar\":\"مجموعة حصرية من الفلل الفاخرة بأفضل المناطق السكنية مع تصميمات عصرية\",\"description_en\":\"Exclusive collection of luxury villas in the best residential areas with modern designs\",\"icon\":\"fas fa-home\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(302, 8, 'services', 'service_2', '{\"title_ar\":\"شقق سكنية\",\"title_en\":\"Residential Apartments\",\"description_ar\":\"شقق بتصاميم حديثة في مواقع استراتيجية مناسبة للعائلات والأفراد\",\"description_en\":\"Modern apartments in strategic locations suitable for families and individuals\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(303, 8, 'services', 'service_3', '{\"title_ar\":\"إدارة أملاك\",\"title_en\":\"Property Management\",\"description_ar\":\"خدمات إدارة أملاك شاملة تشمل الصيانة وتحصيل الإيجارات والتعاقدات\",\"description_en\":\"Comprehensive property management services including maintenance, rent collection, and contracts\",\"icon\":\"fas fa-key\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(304, 8, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الدوسري\",\"client_title\":\"رجل أعمال\",\"content\":\"ساعدوني في العثور على فيلا أحلامي بسرعة ممتازة ومهنية عالية.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(305, 8, 'testimonials', 'testimonial_2', '{\"client_name\":\"ريم الشهري\",\"client_title\":\"مهندسة\",\"content\":\"تجربة شراء شقة سلسة ومريحة. الفريق متعاون ومحترف جداً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(306, 8, 'contact', 'contact_info', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"جدة - حي الحمراء - شارع الملك فهد\"}', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"Jeddah - Al Hamra District - King Fahd Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(307, 9, 'hero', 'hero_title', 'أشهى المأكولات في مكان واحد', 'The Finest Cuisine in One Place', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(308, 9, 'hero', 'hero_subtitle', 'تجربة طعام استثنائية تأخذك في رحلة من الذواقة', 'An exceptional dining experience that takes you on a culinary journey', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(309, 9, 'hero', 'hero_description', 'مطعم فاخر يقدم أشهى الأطباق العربية والعالمية المحضرة بعناية من قبل أفضل الطهاة باستخدام أجود المكونات الطبيعية الطازجة.', 'A luxury restaurant serving the finest Arabic and international dishes carefully prepared by the best chefs using the finest natural fresh ingredients.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(310, 9, 'hero', 'hero_button_text', 'اطلب الآن', 'Order Now', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(311, 9, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(312, 9, 'about', 'about_text', 'مطعمنا الفاخر يجمع بين الأصالة والحداثة في تقديم أشهى المأكولات. يمتلك فريقنا من الطهاة الحائزين على جوائز عالمية خبرة واسعة في فن الطبخ. نحرص على اختيار مكوناتنا من أفضل المزارع المحلية لتقديم تجربة طعام لا تُنسى.', 'Our luxury restaurant combines authenticity and modernity in serving the finest cuisine. Our award-winning chef team has extensive experience in the culinary arts. We carefully select our ingredients from the best local farms to deliver an unforgettable dining experience.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(313, 9, 'services', 'service_1', '{\"title_ar\":\"عشاء فاخر\",\"title_en\":\"Fine Dining\",\"description_ar\":\"قائمة طعام متنوعة من الأطباق العربية والعالمية المحضرة بأيدي طهاة محترفين\",\"description_en\":\"Diverse menu of Arabic and international dishes prepared by professional chefs\",\"icon\":\"fas fa-utensils\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(314, 9, 'services', 'service_2', '{\"title_ar\":\"تموين مناسبات\",\"title_en\":\"Event Catering\",\"description_ar\":\"خدمات تموين احترافية للمناسبات والحفلات بجميع أنواعها وأحجامها\",\"description_en\":\"Professional catering services for events and parties of all types and sizes\",\"icon\":\"fas fa-glass-cheers\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(315, 9, 'services', 'service_3', '{\"title_ar\":\"خدمة التوصيل\",\"title_en\":\"Delivery Service\",\"description_ar\":\"خدمة توصيل سريعة لجميع الطلبات مع الحفاظ على جودة الطعام\",\"description_en\":\"Fast delivery service for all orders while maintaining food quality\",\"icon\":\"fas fa-motorcycle\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(316, 9, 'services', 'service_4', '{\"title_ar\":\"حجز طاولات\",\"title_en\":\"Table Reservation\",\"description_ar\":\"احجز طاولتك مسبقاً واستمتع بتجربة عشاء مميزة في أجواء راقية\",\"description_en\":\"Reserve your table in advance and enjoy a distinguished dinner experience in an elegant atmosphere\",\"icon\":\"fas fa-calendar-check\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(317, 9, 'testimonials', 'testimonial_1', '{\"client_name\":\"محمد السبيعي\",\"client_title\":\"مدير تنفيذي\",\"content\":\"أفضل مطعم في المدينة بلا منازع. الأكل لذيذ والخدمة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(318, 9, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند العنزي\",\"client_title\":\"مدونة طعام\",\"content\":\"جربت العديد من المطاعم لكن هذا المطعم في مستوى آخر تماماً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(319, 9, 'contact', 'contact_info', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير محمد بن عبدالعزيز\"}', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"Riyadh - Al Malqa District - Prince Mohammed bin Abdulaziz Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(320, 10, 'hero', 'hero_title', 'استثمر في مستقبلك التعليمي', 'Invest in Your Educational Future', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(321, 10, 'hero', 'hero_subtitle', 'تعليم متميز يبني أجيالاً واعية ومبدعة', 'Distinguished education building aware and creative generations', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(322, 10, 'hero', 'hero_description', 'أكاديمية تعليمية رائدة تقدم برامج تعليمية وتدريبية متطورة بأحدث الأساليب التعليمية مع نخبة من أفضل المدربين والمتخصصين.', 'A leading educational academy offering advanced educational and training programs using the latest teaching methods with a selection of the best trainers and specialists.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(323, 10, 'hero', 'hero_button_text', 'سجل الآن', 'Register Now', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(324, 10, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(325, 10, 'about', 'about_text', 'أكاديمية تعليمية متخصصة تأسست بهدف تقديم تعليم عالي الجودة يواكب أحدث التطورات. نقدم برامج متنوعة تشمل الدورات التأهيلية والشهادات المهنية والتدريب العملي مع بيئة تعليمية محفزة.', 'A specialized educational academy established to provide high-quality education aligned with the latest developments. We offer diverse programs including qualification courses, professional certificates, and practical training in a motivating learning environment.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(326, 10, 'services', 'service_1', '{\"title_ar\":\"دورات حضورية\",\"title_en\":\"Classroom Courses\",\"description_ar\":\"دورات تدريبية حضورية بفصول مجهزة بأحدث التقنيات مع مدربين محترفين\",\"description_en\":\"Classroom training courses in fully equipped halls with the latest technology and professional trainers\",\"icon\":\"fas fa-chalkboard-teacher\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(327, 10, 'services', 'service_2', '{\"title_ar\":\"تعليم عن بعد\",\"title_en\":\"Online Learning\",\"description_ar\":\"برامج تعليمية إلكترونية متكاملة يمكنك التعلم منها في أي وقت ومن أي مكان\",\"description_en\":\"Integrated e-learning programs you can study anytime and anywhere\",\"icon\":\"fas fa-laptop\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(328, 10, 'services', 'service_3', '{\"title_ar\":\"تدريب مهني\",\"title_en\":\"Professional Training\",\"description_ar\":\"برامج تدريب مهني معتمدة لتطوير المهارات ورفع الكفاءة المهنية\",\"description_en\":\"Accredited professional training programs to develop skills and enhance professional competence\",\"icon\":\"fas fa-graduation-cap\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(329, 10, 'services', 'service_4', '{\"title_ar\":\"استشارات تعليمية\",\"title_en\":\"Educational Consulting\",\"description_ar\":\"استشارات متخصصة لاختيار المسار التعليمي المناسب وتخطيط المستقبل الأكاديمي\",\"description_en\":\"Specialized consulting for choosing the right educational path and academic future planning\",\"icon\":\"fas fa-route\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(330, 10, 'testimonials', 'testimonial_1', '{\"client_name\":\"أحمد الحربي\",\"client_title\":\"طالب جامعي\",\"content\":\"الدورات هنا ساعدتني كثيراً في تطوير مهاراتي والحصول على وظيفة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43');
INSERT INTO `theme_contents` (`id`, `theme_id`, `section_type`, `content_key`, `content_ar`, `content_en`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(331, 10, 'testimonials', 'testimonial_2', '{\"client_name\":\"لمى الزهراني\",\"client_title\":\"مصممة جرافيك\",\"content\":\"تعلمت هنا أساسيات التصميم بشكل احترافي. المدربون رائعون والمحتوى ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(332, 10, 'contact', 'contact_info', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"الدمام - حي الفيصلية - شارع الأمير سلطان\"}', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"Dammam - Al Faisaliyah District - Prince Sultan Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(333, 11, 'hero', 'hero_title', 'ابدأ رحلتك نحو اللياقة', 'Start Your Fitness Journey', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(334, 11, 'hero', 'hero_subtitle', 'نادي رياضي متكامل بأحدث المعدات وأفضل المدربين', 'Fully equipped gym with the latest equipment and best trainers', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(335, 11, 'hero', 'hero_description', 'نادي رياضي متكامل يوفر بيئة محفزة لتحقيق أهدافك اللياقية مع فريق من المدربين المعتمدين وأحدث الأجهزة الرياضية العالمية.', 'A fully equipped gym providing a motivating environment to achieve your fitness goals with a team of certified trainers and the latest international sports equipment.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(336, 11, 'hero', 'hero_button_text', 'اشترك الآن', 'Join Now', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(337, 11, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(338, 11, 'about', 'about_text', 'نادي رياضي رائد يهدف إلى نشر ثقافة اللياقة البدنية والحياة الصحية. نوفر مرافق عصرية تشمل صالة أوزان حرة وآلات، قاعات لليوغا والبيلاتس، مسبح أولمبي، وملاعب رياضية متعددة.', 'A leading sports club aiming to spread fitness culture and healthy living. We provide modern facilities including free weights and machines, yoga and pilates studios, Olympic pool, and multi-sport courts.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(339, 11, 'services', 'service_1', '{\"title_ar\":\"تدريب شخصي\",\"title_en\":\"Personal Training\",\"description_ar\":\"جلسات تدريب شخصي مع مدربين معتمدين لتصميم برامج مخصصة حسب أهدافك\",\"description_en\":\"Personal training sessions with certified trainers to design programs tailored to your goals\",\"icon\":\"fas fa-dumbbell\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(340, 11, 'services', 'service_2', '{\"title_ar\":\"يوجا وبيلاتس\",\"title_en\":\"Yoga and Pilates\",\"description_ar\":\"فصول يوجا وبيلاتس يومية لتحسين المرونة والاسترخاء الذهني\",\"description_en\":\"Daily yoga and pilates classes to improve flexibility and mental relaxation\",\"icon\":\"fas fa-spa\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(341, 11, 'services', 'service_3', '{\"title_ar\":\"برامج لياقة\",\"title_en\":\"Fitness Programs\",\"description_ar\":\"برامج لياقة متنوعة تشمل كارديو وقوة وتخسيس وزن وبناء عضلات\",\"description_en\":\"Diverse fitness programs including cardio, strength, weight loss, and muscle building\",\"icon\":\"fas fa-running\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(342, 11, 'services', 'service_4', '{\"title_ar\":\"تغذية صحية\",\"title_en\":\"Healthy Nutrition\",\"description_ar\":\"استشارات تغذية متخصصة مع خطط غذائية مخصصة لتحقيق أهدافك\",\"description_en\":\"Specialized nutrition consultations with custom meal plans to achieve your goals\",\"icon\":\"fas fa-apple-alt\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(343, 11, 'testimonials', 'testimonial_1', '{\"client_name\":\"عمر العتيبي\",\"client_title\":\"مهندس\",\"content\":\"خلال 3 أشهر فقط حققت هدفي في خسارة الوزن بفضل المدربين المحترفين هنا.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(344, 11, 'testimonials', 'testimonial_2', '{\"client_name\":\"سارة الغامدي\",\"client_title\":\"محاسبة\",\"content\":\"النادي نظيف جداً والأجهزة حديثة. أنصح الجميع بالاشتراك.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(345, 11, 'contact', 'contact_info', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"الرياض - حي النرجس - شارع أنس بن مالك\"}', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"Riyadh - Al Narjis District - Anas bin Malik Road\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(346, 12, 'hero', 'hero_title', 'حقوقك محمية بقوة القانون', 'Your Rights Protected by Law', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(347, 12, 'hero', 'hero_subtitle', 'محامون متخصصون يضعون خبرتهم في خدمة عدالتك', 'Specialized lawyers putting their expertise at the service of your justice', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(348, 12, 'hero', 'hero_description', 'مكتب محاماة متخصص يقدم خدمات قانونية شاملة بأعلى معايير المهنية والسرية. نمتلك فريقاً من المحامين والاستشاريين القانونيين ذوي الخبرة الواسعة في مختلف فروع القانون.', 'A specialized law firm providing comprehensive legal services to the highest professional and confidential standards. We have a team of lawyers and legal consultants with extensive experience in various branches of law.', 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(349, 12, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(350, 12, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(351, 12, 'about', 'about_text', 'مكتب محاماة راسخ يقدم خدمات قانونية متميزة منذ أكثر من 20 عاماً. نتعامل مع جميع أنواع القضايا المدنية والتجارية والعقارية والجنائية مع الالتزام بأعلى معايير السرية والأمانة المهنية.', 'An established law firm providing distinguished legal services for over 20 years. We handle all types of civil, commercial, real estate, and criminal cases while maintaining the highest standards of confidentiality and professional ethics.', 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(352, 12, 'services', 'service_1', '{\"title_ar\":\"استشارات قانونية\",\"title_en\":\"Legal Consultations\",\"description_ar\":\"استشارات قانونية متخصصة في جميع المجالات مع تحليل شامل للموقف القانوني\",\"description_en\":\"Specialized legal consultations in all fields with comprehensive legal situation analysis\",\"icon\":\"fas fa-gavel\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(353, 12, 'services', 'service_2', '{\"title_ar\":\"قانون الشركات\",\"title_en\":\"Corporate Law\",\"description_ar\":\"خدمات قانونية للشركات تشمل التأسيس والعقود والتحكيم التجاري\",\"description_en\":\"Legal services for companies including incorporation, contracts, and commercial arbitration\",\"icon\":\"fas fa-briefcase\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(354, 12, 'services', 'service_3', '{\"title_ar\":\"قضايا عقارية\",\"title_en\":\"Real Estate Cases\",\"description_ar\":\"تمثيل قانوني في القضايا العقارية ونزاعات الملكية وصياغة العقود\",\"description_en\":\"Legal representation in real estate cases, property disputes, and contract drafting\",\"icon\":\"fas fa-landmark\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(355, 12, 'services', 'service_4', '{\"title_ar\":\"قانون الأسرة\",\"title_en\":\"Family Law\",\"description_ar\":\"معالجة قضايا الأحوال الشخصية والطلاق والحضانة والنفقة\",\"description_en\":\"Handling personal status cases, divorce, custody, and alimony\",\"icon\":\"fas fa-users\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(356, 12, 'testimonials', 'testimonial_1', '{\"client_name\":\"ناصر العمري\",\"client_title\":\"رجل أعمال\",\"content\":\"محامون محترفون جداً. ساعدوني في حل نزاع تجاري معقد بنجاح.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(357, 12, 'testimonials', 'testimonial_2', '{\"client_name\":\"منال السلمي\",\"client_title\":\"سيدة أعمال\",\"content\":\"مكتب محترف ويتميز بالسرية التامة. أنصح أي شخص يحتاج مساعدة قانونية بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(358, 12, 'contact', 'contact_info', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"الرياض - حي العليا - برج المملكة - الطابق 15\"}', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"Riyadh - Olaya District - Kingdom Tower - 15th Floor\"}', 1, 1, '2026-04-11 05:53:43', '2026-04-11 05:53:43'),
(359, 1, 'hero', 'hero_title', 'حلول احترافية لنجاح أعمالك', 'Professional Solutions for Your Business Success', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(360, 1, 'hero', 'hero_subtitle', 'شريكك الموثوق في عالم الأعمال الرقمية', 'Your Trusted Partner in the Digital Business World', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(361, 1, 'hero', 'hero_description', 'نقدم حلولاً متكاملة تساعدك على تطوير أعمالك وتحقيق أهدافك بكفاءة عالية. فريقنا المتخصص يضع خبراته في خدمتك لتقديم أفضل النتائج.', 'We provide integrated solutions to help you grow your business and achieve your goals efficiently. Our expert team puts their expertise at your service to deliver the best results.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(362, 1, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(363, 1, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(364, 1, 'about', 'about_text', 'شركة رائدة في تقديم الحلول الرقمية المتميزة. نمتلك فريقاً من الخبراء والمتخصصين الذين يعملون بشغف لتقديم خدمات عالية الجودة تلبي احتياجات عملائنا المتنوعة.', 'A leading company in providing outstanding digital solutions. We have a team of experts and specialists who work passionately to deliver high-quality services that meet our clients diverse needs.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(365, 1, 'services', 'service_1', '{\"title_ar\":\"استشارات الأعمال\",\"title_en\":\"Business Consulting\",\"description_ar\":\"استشارات متخصصة لتطوير أعمالك وزيادة الإنتاجية مع خطط استراتيجية مخصصة\",\"description_en\":\"Specialized consulting to develop your business and increase productivity with custom strategic plans\",\"icon\":\"fas fa-chart-line\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(366, 1, 'services', 'service_2', '{\"title_ar\":\"تطوير المواقع\",\"title_en\":\"Web Development\",\"description_ar\":\"تصميم وتطوير مواقع إلكترونية احترافية متجاوبة مع جميع الأجهزة\",\"description_en\":\"Professional responsive website design and development for all devices\",\"icon\":\"fas fa-code\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(367, 1, 'services', 'service_3', '{\"title_ar\":\"التسويق الرقمي\",\"title_en\":\"Digital Marketing\",\"description_ar\":\"استراتيجيات تسويق رقمي متكاملة لزيادة الوعي بعلامتك التجارية\",\"description_en\":\"Integrated digital marketing strategies to increase brand awareness\",\"icon\":\"fas fa-bullhorn\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(368, 1, 'services', 'service_4', '{\"title_ar\":\"الدعم الفني\",\"title_en\":\"Technical Support\",\"description_ar\":\"دعم فني على مدار الساعة لضمان سير عملك بدون انقطاع\",\"description_en\":\"24/7 technical support to ensure your business runs without interruption\",\"icon\":\"fas fa-headset\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(369, 1, 'testimonials', 'testimonial_1', '{\"client_name\":\"عبدالله السعيد\",\"client_title\":\"مدير شركة\",\"content\":\"خدمة ممتازة وفريق محترف. ساعدونا في تحقيق أهدافنا بشكل أسرع من المتوقع.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(370, 1, 'testimonials', 'testimonial_2', '{\"client_name\":\"مريم الحربي\",\"client_title\":\"رائدة أعمال\",\"content\":\"من أفضل الشركات التي تعاملت معها. الجودة والاحترافية في كل تفصيل.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(371, 1, 'contact', 'contact_info', '{\"phone\":\"966500000100\",\"whatsapp\":\"966500000100\",\"email\":\"info@generic-company.com\",\"address\":\"الرياض - حي العليا - شارع الملك فهد\"}', '{\"phone\":\"966500000100\",\"whatsapp\":\"966500000100\",\"email\":\"info@generic-company.com\",\"address\":\"Riyadh - Olaya District - King Fahd Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(372, 2, 'hero', 'hero_title', 'حلول كهربائية متكاملة', 'Integrated Electrical Solutions', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(373, 2, 'hero', 'hero_subtitle', 'فنيون معتمدون بخبرة تفوق 15 عاماً في جميع الأعمال الكهربائية', 'Certified technicians with over 15 years of experience in all electrical work', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(374, 2, 'hero', 'hero_description', 'شركة متخصصة في تقديم جميع الخدمات الكهربائية للمنازل والمنشآت التجارية والصناعية. نلتزم بأعلى معايير السلامة والجودة مع ضمان على جميع أعمالنا.', 'A company specializing in providing all electrical services for homes, commercial, and industrial facilities. We adhere to the highest safety and quality standards with warranty on all our work.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(375, 2, 'hero', 'hero_button_text', 'اطلب فني', 'Request Technician', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(376, 2, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(377, 2, 'about', 'about_text', 'شركة كهربائية رائدة تقدم خدماتها منذ أكثر من 15 عاماً. نمتلك فريقاً من الفنيين والمهندسين المعتمدين المتخصصين في جميع مجالات الأعمال الكهربائية مع استخدام أجود المواد والمعدات.', 'A leading electrical company serving for over 15 years. We have a team of certified technicians and engineers specialized in all areas of electrical work using the finest materials and equipment.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(378, 2, 'services', 'service_1', '{\"title_ar\":\"تمديدات كهربائية\",\"title_en\":\"Electrical Wiring\",\"description_ar\":\"تمديدات كهربائية احترافية للمنازل والمباني التجارية بمعايير السلامة الدولية\",\"description_en\":\"Professional electrical wiring for homes and commercial buildings to international safety standards\",\"icon\":\"fas fa-bolt\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(379, 2, 'services', 'service_2', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة وتركيب جميع أنواع المكيفات مع ضمان شامل على القطع والعمل\",\"description_en\":\"Maintenance and installation of all AC types with comprehensive warranty on parts and labor\",\"icon\":\"fas fa-snowflake\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(380, 2, 'services', 'service_3', '{\"title_ar\":\"لوحات التحكم\",\"title_en\":\"Control Panels\",\"description_ar\":\"تصميم وتركيب لوحات التحكم الكهربائية للمباني والمصانع\",\"description_en\":\"Design and installation of electrical control panels for buildings and factories\",\"icon\":\"fas fa-sliders-h\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(381, 2, 'services', 'service_4', '{\"title_ar\":\"طوارئ كهربائية\",\"title_en\":\"Emergency Electrical\",\"description_ar\":\"خدمة طوارئ على مدار الساعة لحل جميع المشاكل الكهربائية العاجلة\",\"description_en\":\"24/7 emergency service to resolve all urgent electrical problems\",\"icon\":\"fas fa-exclamation-triangle\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(382, 2, 'testimonials', 'testimonial_1', '{\"client_name\":\"سعد القحطاني\",\"client_title\":\"مهندس\",\"content\":\"فريق محترف وسريع في الاستجابة. أنجزوا المشروع قبل الموعد المحدد.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(383, 2, 'testimonials', 'testimonial_2', '{\"client_name\":\"فاطمة الشمري\",\"client_title\":\"ربة منزل\",\"content\":\"خدمة ممتازة وأسعار معقولة. أنصح الجميع بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(384, 2, 'contact', 'contact_info', '{\"phone\":\"966500000102\",\"whatsapp\":\"966500000102\",\"email\":\"info@electric-services.com\",\"address\":\"جدة - حي الصفا - شارع فلسطين\"}', '{\"phone\":\"966500000102\",\"whatsapp\":\"966500000102\",\"email\":\"info@electric-services.com\",\"address\":\"Jeddah - Al Safa District - Palestine Street\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(385, 3, 'hero', 'hero_title', 'نظافة مثالية بلمسة احترافية', 'Perfect Cleanliness with a Professional Touch', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(386, 3, 'hero', 'hero_subtitle', 'خدمات تنظيف شاملة للمنازل والمكاتب والمنشآت التجارية', 'Comprehensive cleaning services for homes, offices, and commercial facilities', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(387, 3, 'hero', 'hero_description', 'شركة تنظيف متخصصة تقدم خدمات شاملة باستخدام أحدث المعدات ومواد التنظيف الآمنة والصديقة للبيئة. نضمن لك بيئة نظيفة وصحية.', 'A specialized cleaning company offering comprehensive services using the latest equipment and eco-friendly cleaning products. We guarantee a clean and healthy environment.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(388, 3, 'hero', 'hero_button_text', 'احجز الآن', 'Book Now', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(389, 3, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(390, 3, 'about', 'about_text', 'شركة تنظيف رائدة تتميز بخبرة واسعة في تقديم خدمات تنظيف عالية الجودة. نستخدم أحدث التقنيات ومواد تنظيف آمنة مع فريق مدرب على أعلى مستوى.', 'A leading cleaning company distinguished by extensive experience in delivering high-quality cleaning services. We use the latest technologies and safe cleaning products with a highly trained team.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(391, 3, 'services', 'service_1', '{\"title_ar\":\"تنظيف عميق\",\"title_en\":\"Deep Cleaning\",\"description_ar\":\"تنظيف عميق شامل لجميع أنحاء المنزل أو المكتب باستخدام أحدث المعدات\",\"description_en\":\"Comprehensive deep cleaning for the entire home or office using the latest equipment\",\"icon\":\"fas fa-broom\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(392, 3, 'services', 'service_2', '{\"title_ar\":\"تنظيف المكاتب\",\"title_en\":\"Office Cleaning\",\"description_ar\":\"خدمات تنظيف يومية وأسبوعية للمكاتب والمنشآت التجارية\",\"description_en\":\"Daily and weekly cleaning services for offices and commercial facilities\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(393, 3, 'services', 'service_3', '{\"title_ar\":\"تنظيف السجاد\",\"title_en\":\"Carpet Cleaning\",\"description_ar\":\"تنظيف احترافي للسجاد والموكيت بجميع أنواعه وأحجامه\",\"description_en\":\"Professional carpet and rug cleaning of all types and sizes\",\"icon\":\"fas fa-rug\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(394, 3, 'services', 'service_4', '{\"title_ar\":\"تنظيف بعد البناء\",\"title_en\":\"Post-Construction\",\"description_ar\":\"تنظيف شامل بعد أعمال البناء والتشطيبات لإعداد المكان للاستخدام\",\"description_en\":\"Comprehensive cleaning after construction and finishing work to prepare the space for use\",\"icon\":\"fas fa-hard-hat\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(395, 3, 'testimonials', 'testimonial_1', '{\"client_name\":\"نوف العتيبي\",\"client_title\":\"سيدة أعمال\",\"content\":\"منظفون محترفون والنتيجة ممتازة. البيئة أصبحت نظيفة ومعطرة بشكل رائع.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(396, 3, 'testimonials', 'testimonial_2', '{\"client_name\":\"مازن الدوسري\",\"client_title\":\"مدير مكتب\",\"content\":\"نتعامل معهم لتنظيف مكاتبنا أسبوعياً ولم نختبر يوماً أي تقصير.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(397, 3, 'contact', 'contact_info', '{\"phone\":\"966500000103\",\"whatsapp\":\"966500000103\",\"email\":\"info@cleaning-services.com\",\"address\":\"الرياض - حي النسيم - شارع الحسن\"}', '{\"phone\":\"966500000103\",\"whatsapp\":\"966500000103\",\"email\":\"info@cleaning-services.com\",\"address\":\"Riyadh - Al Naseem District - Al Hassan Street\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(398, 4, 'hero', 'hero_title', 'تصاميم ديكور فاخرة', 'Luxury Interior Design', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(399, 4, 'hero', 'hero_subtitle', 'نحول رؤيتك إلى واقع بلمسات فنية استثنائية', 'We turn your vision into reality with exceptional artistic touches', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(400, 4, 'hero', 'hero_description', 'استوديو ديكور متخصص يقدم خدمات تصميم داخلي وتنسيق ديكور احترافية للمنازل والمكاتب والفنادق والمساحات التجارية بأحدث الاتجاهات العالمية.', 'A specialized decor studio offering professional interior design and decor coordination services for homes, offices, hotels, and commercial spaces with the latest global trends.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(401, 4, 'hero', 'hero_button_text', 'شاهد أعمالنا', 'View Our Work', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(402, 4, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(403, 4, 'about', 'about_text', 'استوديو ديكور تأسس على يد فريق من المصممين المبدعين الذين يجمعون بين الفن والوظيفة. نقدم تصاميم فريدة تعكس ذوقك الشخصي وتلبي احتياجاتك العملية مع الالتزام بالميزانية.', 'A decor studio founded by a team of creative designers who combine art and function. We deliver unique designs that reflect your personal taste and meet your practical needs while staying within budget.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(404, 4, 'services', 'service_1', '{\"title_ar\":\"تصميم داخلي\",\"title_en\":\"Interior Design\",\"description_ar\":\"تصميم داخلي متكامل يراعي الجمال والوظيفة والراحة في كل تفصيل\",\"description_en\":\"Complete interior design balancing beauty, function, and comfort in every detail\",\"icon\":\"fas fa-couch\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(405, 4, 'services', 'service_2', '{\"title_ar\":\"تنسيق المساحات\",\"title_en\":\"Space Planning\",\"description_ar\":\"تنسيق المساحات بشكل ذكي لتحقيق أقصى استفادة من كل متر مربع\",\"description_en\":\"Smart space planning to maximize the use of every square meter\",\"icon\":\"fas fa-drafting-compass\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(406, 4, 'services', 'service_3', '{\"title_ar\":\"دهانات احترافية\",\"title_en\":\"Professional Painting\",\"description_ar\":\"خدمات دهانات احترافية بأحدث الألوان والتقنيات مع تشطيبات فاخرة\",\"description_en\":\"Professional painting services with the latest colors and techniques plus luxury finishes\",\"icon\":\"fas fa-paint-roller\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(407, 4, 'services', 'service_4', '{\"title_ar\":\"إضاءة وتجهيز\",\"title_en\":\"Lighting & Furnishing\",\"description_ar\":\"اختيار وتنسيق الإضاءة والأثاث لإضفاء لمسة فاخرة على المكان\",\"description_en\":\"Selection and coordination of lighting and furniture to add a luxurious touch to the space\",\"icon\":\"fas fa-lightbulb\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(408, 4, 'testimonials', 'testimonial_1', '{\"client_name\":\"لمياء العمري\",\"client_title\":\"ربة منزل\",\"content\":\"حولوا بيتنا إلى قصر. التصميم أكثر من رائع والتنفيذ دقيق جداً.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(409, 4, 'testimonials', 'testimonial_2', '{\"client_name\":\"تركي العنزي\",\"client_title\":\"رجل أعمال\",\"content\":\"تعاملنا معهم في تصميم مكاتبنا والنتيجة فاقت كل التوقعات.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(410, 4, 'contact', 'contact_info', '{\"phone\":\"966500000104\",\"whatsapp\":\"966500000104\",\"email\":\"info@decor-studio.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير سعد بن عبدالرحمن\"}', '{\"phone\":\"966500000104\",\"whatsapp\":\"966500000104\",\"email\":\"info@decor-studio.com\",\"address\":\"Riyadh - Al Malqa District - Prince Saad bin Abdulrahman Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(411, 5, 'hero', 'hero_title', 'صيانة شاملة بمعايير عالمية', 'Comprehensive Maintenance with International Standards', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(412, 5, 'hero', 'hero_subtitle', 'فريق فنيون متخصصون لحل جميع مشاكل المنزل والمكتب', 'Specialized technical team to solve all home and office problems', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(413, 5, 'hero', 'hero_description', 'شركة صيانة متكاملة تقدم خدماتها للمنازل والمكاتب والمنشآت التجارية. نمتلك فريقاً من الفنيين المعتمدين في جميع التخصصات مع ضمان شامل على جميع أعمالنا.', 'An integrated maintenance company serving homes, offices, and commercial facilities. We have a team of certified technicians across all specialties with a comprehensive warranty on all our work.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(414, 5, 'hero', 'hero_button_text', 'اطلب صيانة', 'Request Service', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(415, 5, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(416, 5, 'about', 'about_text', 'شركة صيانة رائدة تقدم حلولاً شاملة وموثوقة لجميع احتياجات الصيانة. نحرص على الالتزام بالمواعيد وتقديم خدمات عالية الجودة بأسعار تنافسية مع ضمان على كل عمل نقوم به.', 'A leading maintenance company providing comprehensive and reliable solutions for all maintenance needs. We are committed to punctuality and delivering high-quality services at competitive prices with warranty on every job.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(417, 5, 'services', 'service_1', '{\"title_ar\":\"كهرباء المنازل\",\"title_en\":\"Home Electrical\",\"description_ar\":\"صيانة كهربائية شاملة للمنازل من تمديدات وإصلاحات وتركيبات\",\"description_en\":\"Comprehensive home electrical maintenance from wiring, repairs, and installations\",\"icon\":\"fas fa-plug\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(418, 5, 'services', 'service_2', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة وتركيب وغسيل مكيفات جميع الأنواع مع ضمان الخدمة\",\"description_en\":\"AC maintenance, installation, and cleaning of all types with service warranty\",\"icon\":\"fas fa-fan\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(419, 5, 'services', 'service_3', '{\"title_ar\":\"خدمات الدهان\",\"title_en\":\"Painting Services\",\"description_ar\":\"دهانات داخلية وخارجية بجميع الألوان والتقنيات الحديثة\",\"description_en\":\"Interior and exterior painting with all colors and modern techniques\",\"icon\":\"fas fa-paint-brush\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(420, 5, 'services', 'service_4', '{\"title_ar\":\"سباكة وإصلاحات\",\"title_en\":\"Plumbing & Repairs\",\"description_ar\":\"خدمات سباكة شاملة من تركيب وإصلاح وصيانة جميع الأنابيب والصحيات\",\"description_en\":\"Comprehensive plumbing services from installation, repair, and maintenance of all pipes and fixtures\",\"icon\":\"fas fa-wrench\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(421, 5, 'testimonials', 'testimonial_1', '{\"client_name\":\"سلطان المطيري\",\"client_title\":\"مدير مدرسة\",\"content\":\"صيانة ممتازة وسريعة. الفنيون محترفون والأسعار معقولة جداً.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(422, 5, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند الزهراني\",\"client_title\":\"ربة منزل\",\"content\":\"أنقذونا في مشكلة السباكة الطارئة. وصلوا خلال ساعة وأصلحوا المشكلة.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(423, 5, 'contact', 'contact_info', '{\"phone\":\"966500000105\",\"whatsapp\":\"966500000105\",\"email\":\"info@maintenance-services.com\",\"address\":\"الدمام - حي الشاطئ - شارع الأمير محمد\"}', '{\"phone\":\"966500000105\",\"whatsapp\":\"966500000105\",\"email\":\"info@maintenance-services.com\",\"address\":\"Dammam - Al Sahati District - Prince Mohammed Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(424, 6, 'hero', 'hero_title', 'حلول سباكة موثوقة وسريعة', 'Reliable and Fast Plumbing Solutions', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(425, 6, 'hero', 'hero_subtitle', 'سباكون معتمدون بخبرة تفوق 10 سنوات في جميع أعمال السباكة', 'Certified plumbers with over 10 years of experience in all plumbing work', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(426, 6, 'hero', 'hero_description', 'شركة سباكة متخصصة تقدم خدمات شاملة من الإصلاحات الطارئة إلى التركيبات الجديدة. نستخدم أجود القطع والمواد مع ضمان شامل على جميع أعمالنا وخدمة على مدار الساعة.', 'A specialized plumbing company offering comprehensive services from emergency repairs to new installations. We use the finest parts and materials with a comprehensive warranty on all our work and 24/7 service.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(427, 6, 'hero', 'hero_button_text', 'اتصل الآن', 'Call Now', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(428, 6, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(429, 6, 'about', 'about_text', 'شركة سباكة متخصصة تتميز بفريق من الفنيين المعتمدين ذوي الخبرة الواسعة. نقدم حلولاً سريعة ودائمة لمشاكل السباكة مع الالتزام بأعلى معايير الجودة والنظافة.', 'A specialized plumbing company featuring a team of certified technicians with extensive experience. We provide fast and permanent solutions to plumbing problems while adhering to the highest quality and cleanliness standards.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(430, 6, 'services', 'service_1', '{\"title_ar\":\"إصلاح السباكة\",\"title_en\":\"Plumbing Repair\",\"description_ar\":\"إصلاح سريع ودقيق لجميع أعطال السباكة مع ضمان على العمل\",\"description_en\":\"Fast and accurate repair of all plumbing failures with work warranty\",\"icon\":\"fas fa-wrench\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(431, 6, 'services', 'service_2', '{\"title_ar\":\"تركيب الصحيات\",\"title_en\":\"Fixture Installation\",\"description_ar\":\"تركيب جميع أنواع الصحيات والمعدات بأعلى معايير الجودة\",\"description_en\":\"Installation of all types of fixtures and equipment to the highest quality standards\",\"icon\":\"fas fa-faucet\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(432, 6, 'services', 'service_3', '{\"title_ar\":\"كشف التسريبات\",\"title_en\":\"Leak Detection\",\"description_ar\":\"كشف وإصلاح تسريبات المياه بأحدث التقنيات دون تكسير\",\"description_en\":\"Leak detection and repair using the latest technologies without demolition\",\"icon\":\"fas fa-tint\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(433, 6, 'services', 'service_4', '{\"title_ar\":\"صيانة مجاري\",\"title_en\":\"Drain Maintenance\",\"description_ar\":\"تنظيف وصيانة المجاري والبالوعات بأحدث المعدات المتخصصة\",\"description_en\":\"Drain and sewer cleaning and maintenance with the latest specialized equipment\",\"icon\":\"fas fa-water\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(434, 6, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الشمري\",\"client_title\":\"مالك فيلا\",\"content\":\"وصلوا خلال نصف ساعة وأصلحوا الانفجار بسرعة واحترافية ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(435, 6, 'testimonials', 'testimonial_2', '{\"client_name\":\"أم سلطان\",\"client_title\":\"ربة منزل\",\"content\":\"تعاملت معهم عدة مرات ودائماً خدمة ممتازة وأسعار مناسبة.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(436, 6, 'contact', 'contact_info', '{\"phone\":\"966500000106\",\"whatsapp\":\"966500000106\",\"email\":\"info@plumbing-services.com\",\"address\":\"الرياض - حي الروضة - شارع الإمام تركي\"}', '{\"phone\":\"966500000106\",\"whatsapp\":\"966500000106\",\"email\":\"info@plumbing-services.com\",\"address\":\"Riyadh - Al Rawdah District - Imam Turki Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(437, 7, 'hero', 'hero_title', 'رعاية صحية استثنائية', 'Exceptional Health Care', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(438, 7, 'hero', 'hero_subtitle', 'فريق طبي متخصص يضع صحتك أولاً', 'Specialized medical team putting your health first', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(439, 7, 'hero', 'hero_description', 'نوفر خدمات طبية شاملة بأحدث التقنيات وأفضل الأطباء المتخصصين في جميع المجالات الطبية. نلتزم بأعلى معايير الجودة والسلامة.', 'We provide comprehensive medical services with the latest technology and the best specialized doctors in all medical fields. We adhere to the highest quality and safety standards.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(440, 7, 'hero', 'hero_button_text', 'احجز موعد', 'Book Appointment', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(441, 7, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(442, 7, 'about', 'about_text', 'مركز طبي متكامل يقدم خدمات الرعاية الصحية بأعلى المعايير العالمية. نضم فريقاً من أمهر الأطباء والاستشاريين في مختلف التخصصات الطبية مع أحدث الأجهزة والتقنيات الطبية المتطورة. نحرص على تقديم تجربة علاجية مريحة وآمنة لجميع مرضانا.', 'An integrated medical center providing healthcare services to the highest international standards. We have a team of the most skilled doctors and consultants across various medical specialties with the latest advanced medical equipment and technologies.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(443, 7, 'services', 'service_1', '{\"title_ar\":\"فحص طبي شامل\",\"title_en\":\"Comprehensive Medical Checkup\",\"description_ar\":\"فحص طبي شامل يشمل جميع الفحوصات اللازمة للتأكد من سلامتك الصحية مع تقارير مفصلة\",\"description_en\":\"Comprehensive medical examination including all necessary tests to ensure your health with detailed reports\",\"icon\":\"fas fa-stethoscope\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(444, 7, 'services', 'service_2', '{\"title_ar\":\"طب الأسنان\",\"title_en\":\"Dental Care\",\"description_ar\":\"خدمات طب أسنان متكاملة من تنظيف وعلاج وتجميل باستخدام أحدث التقنيات\",\"description_en\":\"Integrated dental services from cleaning, treatment, and cosmetics using the latest technologies\",\"icon\":\"fas fa-tooth\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(445, 7, 'services', 'service_3', '{\"title_ar\":\"استشارات طبية\",\"title_en\":\"Medical Consultations\",\"description_ar\":\"استشارات طبية متخصصة مع أفضل الأطباء والاستشاريين في جميع التخصصات\",\"description_en\":\"Specialized medical consultations with the best doctors and consultants in all specialties\",\"icon\":\"fas fa-user-md\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(446, 7, 'services', 'service_4', '{\"title_ar\":\"مختبر تحاليل\",\"title_en\":\"Laboratory\",\"description_ar\":\"مختبر تحاليل مجهز بأحدث الأجهزة مع نتائج دقيقة وسريعة\",\"description_en\":\"Laboratory equipped with the latest devices with accurate and fast results\",\"icon\":\"fas fa-flask\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(447, 7, 'testimonials', 'testimonial_1', '{\"client_name\":\"سارة العتيبي\",\"client_title\":\"مريضة\",\"content\":\"تجربة رائعة مع فريق الطبيب محمد. كان شديد الاحترافية والاهتمام بالتفاصيل.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(448, 7, 'testimonials', 'testimonial_2', '{\"client_name\":\"خالد المطيري\",\"client_title\":\"تاجر\",\"content\":\"من أفضل المراكز الطبية التي تعاملت معها. النظافة والترتيب ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(449, 7, 'testimonials', 'testimonial_3', '{\"client_name\":\"نورة القحطاني\",\"client_title\":\"معلمة\",\"content\":\"أنصح الجميع بالتعامل معهم. خدمة مميزة وأسعار معقولة.\",\"rating\":4}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(450, 7, 'contact', 'contact_info', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"الرياض - حي العليا - شارع التحلية\"}', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"Riyadh - Olaya District - Tahliya Street\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(451, 8, 'hero', 'hero_title', 'عقاراتك الفاخرة تنتظرك', 'Your Luxury Properties Await', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(452, 8, 'hero', 'hero_subtitle', 'اكتشف أفضل العقارات السكنية والتجارية', 'Discover the best residential and commercial properties', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(453, 8, 'hero', 'hero_description', 'وكالة عقارية متخصصة في تقديم أفضل الحلول العقارية. نوفر لك مجموعة واسعة من العقارات السكنية والتجارية بأسعار تنافسية وأفضل المواقع.', 'A specialized real estate agency providing the best property solutions. We offer a wide range of residential and commercial properties at competitive prices and prime locations.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(454, 8, 'hero', 'hero_button_text', 'تصفح العقارات', 'Browse Properties', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(455, 8, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(456, 8, 'about', 'about_text', 'شركة عقارية رائدة في السوق مع خبرة تتجاوز 15 عاماً في مجال الوساطة العقارية. نقدم خدمات شاملة تشمل البيع والشراء والتأجير وإدارة الأملاك مع فريق من الخبراء المتخصصين.', 'A leading real estate company with over 15 years of experience in property brokerage. We offer comprehensive services including sales, purchases, leasing, and property management with a team of specialized experts.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(457, 8, 'services', 'service_1', '{\"title_ar\":\"فلل فاخرة\",\"title_en\":\"Luxury Villas\",\"description_ar\":\"مجموعة حصرية من الفلل الفاخرة بأفضل المناطق السكنية مع تصميمات عصرية\",\"description_en\":\"Exclusive collection of luxury villas in the best residential areas with modern designs\",\"icon\":\"fas fa-home\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(458, 8, 'services', 'service_2', '{\"title_ar\":\"شقق سكنية\",\"title_en\":\"Residential Apartments\",\"description_ar\":\"شقق بتصاميم حديثة في مواقع استراتيجية مناسبة للعائلات والأفراد\",\"description_en\":\"Modern apartments in strategic locations suitable for families and individuals\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(459, 8, 'services', 'service_3', '{\"title_ar\":\"إدارة أملاك\",\"title_en\":\"Property Management\",\"description_ar\":\"خدمات إدارة أملاك شاملة تشمل الصيانة وتحصيل الإيجارات والتعاقدات\",\"description_en\":\"Comprehensive property management services including maintenance, rent collection, and contracts\",\"icon\":\"fas fa-key\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(460, 8, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الدوسري\",\"client_title\":\"رجل أعمال\",\"content\":\"ساعدوني في العثور على فيلا أحلامي بسرعة ممتازة ومهنية عالية.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(461, 8, 'testimonials', 'testimonial_2', '{\"client_name\":\"ريم الشهري\",\"client_title\":\"مهندسة\",\"content\":\"تجربة شراء شقة سلسة ومريحة. الفريق متعاون ومحترف جداً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(462, 8, 'contact', 'contact_info', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"جدة - حي الحمراء - شارع الملك فهد\"}', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"Jeddah - Al Hamra District - King Fahd Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(463, 9, 'hero', 'hero_title', 'أشهى المأكولات في مكان واحد', 'The Finest Cuisine in One Place', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(464, 9, 'hero', 'hero_subtitle', 'تجربة طعام استثنائية تأخذك في رحلة من الذواقة', 'An exceptional dining experience that takes you on a culinary journey', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(465, 9, 'hero', 'hero_description', 'مطعم فاخر يقدم أشهى الأطباق العربية والعالمية المحضرة بعناية من قبل أفضل الطهاة باستخدام أجود المكونات الطبيعية الطازجة.', 'A luxury restaurant serving the finest Arabic and international dishes carefully prepared by the best chefs using the finest natural fresh ingredients.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(466, 9, 'hero', 'hero_button_text', 'اطلب الآن', 'Order Now', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(467, 9, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(468, 9, 'about', 'about_text', 'مطعمنا الفاخر يجمع بين الأصالة والحداثة في تقديم أشهى المأكولات. يمتلك فريقنا من الطهاة الحائزين على جوائز عالمية خبرة واسعة في فن الطبخ. نحرص على اختيار مكوناتنا من أفضل المزارع المحلية لتقديم تجربة طعام لا تُنسى.', 'Our luxury restaurant combines authenticity and modernity in serving the finest cuisine. Our award-winning chef team has extensive experience in the culinary arts. We carefully select our ingredients from the best local farms to deliver an unforgettable dining experience.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(469, 9, 'services', 'service_1', '{\"title_ar\":\"عشاء فاخر\",\"title_en\":\"Fine Dining\",\"description_ar\":\"قائمة طعام متنوعة من الأطباق العربية والعالمية المحضرة بأيدي طهاة محترفين\",\"description_en\":\"Diverse menu of Arabic and international dishes prepared by professional chefs\",\"icon\":\"fas fa-utensils\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(470, 9, 'services', 'service_2', '{\"title_ar\":\"تموين مناسبات\",\"title_en\":\"Event Catering\",\"description_ar\":\"خدمات تموين احترافية للمناسبات والحفلات بجميع أنواعها وأحجامها\",\"description_en\":\"Professional catering services for events and parties of all types and sizes\",\"icon\":\"fas fa-glass-cheers\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(471, 9, 'services', 'service_3', '{\"title_ar\":\"خدمة التوصيل\",\"title_en\":\"Delivery Service\",\"description_ar\":\"خدمة توصيل سريعة لجميع الطلبات مع الحفاظ على جودة الطعام\",\"description_en\":\"Fast delivery service for all orders while maintaining food quality\",\"icon\":\"fas fa-motorcycle\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(472, 9, 'services', 'service_4', '{\"title_ar\":\"حجز طاولات\",\"title_en\":\"Table Reservation\",\"description_ar\":\"احجز طاولتك مسبقاً واستمتع بتجربة عشاء مميزة في أجواء راقية\",\"description_en\":\"Reserve your table in advance and enjoy a distinguished dinner experience in an elegant atmosphere\",\"icon\":\"fas fa-calendar-check\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(473, 9, 'testimonials', 'testimonial_1', '{\"client_name\":\"محمد السبيعي\",\"client_title\":\"مدير تنفيذي\",\"content\":\"أفضل مطعم في المدينة بلا منازع. الأكل لذيذ والخدمة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(474, 9, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند العنزي\",\"client_title\":\"مدونة طعام\",\"content\":\"جربت العديد من المطاعم لكن هذا المطعم في مستوى آخر تماماً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(475, 9, 'contact', 'contact_info', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير محمد بن عبدالعزيز\"}', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"Riyadh - Al Malqa District - Prince Mohammed bin Abdulaziz Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(476, 10, 'hero', 'hero_title', 'استثمر في مستقبلك التعليمي', 'Invest in Your Educational Future', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(477, 10, 'hero', 'hero_subtitle', 'تعليم متميز يبني أجيالاً واعية ومبدعة', 'Distinguished education building aware and creative generations', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(478, 10, 'hero', 'hero_description', 'أكاديمية تعليمية رائدة تقدم برامج تعليمية وتدريبية متطورة بأحدث الأساليب التعليمية مع نخبة من أفضل المدربين والمتخصصين.', 'A leading educational academy offering advanced educational and training programs using the latest teaching methods with a selection of the best trainers and specialists.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(479, 10, 'hero', 'hero_button_text', 'سجل الآن', 'Register Now', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(480, 10, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(481, 10, 'about', 'about_text', 'أكاديمية تعليمية متخصصة تأسست بهدف تقديم تعليم عالي الجودة يواكب أحدث التطورات. نقدم برامج متنوعة تشمل الدورات التأهيلية والشهادات المهنية والتدريب العملي مع بيئة تعليمية محفزة.', 'A specialized educational academy established to provide high-quality education aligned with the latest developments. We offer diverse programs including qualification courses, professional certificates, and practical training in a motivating learning environment.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(482, 10, 'services', 'service_1', '{\"title_ar\":\"دورات حضورية\",\"title_en\":\"Classroom Courses\",\"description_ar\":\"دورات تدريبية حضورية بفصول مجهزة بأحدث التقنيات مع مدربين محترفين\",\"description_en\":\"Classroom training courses in fully equipped halls with the latest technology and professional trainers\",\"icon\":\"fas fa-chalkboard-teacher\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(483, 10, 'services', 'service_2', '{\"title_ar\":\"تعليم عن بعد\",\"title_en\":\"Online Learning\",\"description_ar\":\"برامج تعليمية إلكترونية متكاملة يمكنك التعلم منها في أي وقت ومن أي مكان\",\"description_en\":\"Integrated e-learning programs you can study anytime and anywhere\",\"icon\":\"fas fa-laptop\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(484, 10, 'services', 'service_3', '{\"title_ar\":\"تدريب مهني\",\"title_en\":\"Professional Training\",\"description_ar\":\"برامج تدريب مهني معتمدة لتطوير المهارات ورفع الكفاءة المهنية\",\"description_en\":\"Accredited professional training programs to develop skills and enhance professional competence\",\"icon\":\"fas fa-graduation-cap\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(485, 10, 'services', 'service_4', '{\"title_ar\":\"استشارات تعليمية\",\"title_en\":\"Educational Consulting\",\"description_ar\":\"استشارات متخصصة لاختيار المسار التعليمي المناسب وتخطيط المستقبل الأكاديمي\",\"description_en\":\"Specialized consulting for choosing the right educational path and academic future planning\",\"icon\":\"fas fa-route\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(486, 10, 'testimonials', 'testimonial_1', '{\"client_name\":\"أحمد الحربي\",\"client_title\":\"طالب جامعي\",\"content\":\"الدورات هنا ساعدتني كثيراً في تطوير مهاراتي والحصول على وظيفة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(487, 10, 'testimonials', 'testimonial_2', '{\"client_name\":\"لمى الزهراني\",\"client_title\":\"مصممة جرافيك\",\"content\":\"تعلمت هنا أساسيات التصميم بشكل احترافي. المدربون رائعون والمحتوى ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(488, 10, 'contact', 'contact_info', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"الدمام - حي الفيصلية - شارع الأمير سلطان\"}', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"Dammam - Al Faisaliyah District - Prince Sultan Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(489, 11, 'hero', 'hero_title', 'ابدأ رحلتك نحو اللياقة', 'Start Your Fitness Journey', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(490, 11, 'hero', 'hero_subtitle', 'نادي رياضي متكامل بأحدث المعدات وأفضل المدربين', 'Fully equipped gym with the latest equipment and best trainers', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(491, 11, 'hero', 'hero_description', 'نادي رياضي متكامل يوفر بيئة محفزة لتحقيق أهدافك اللياقية مع فريق من المدربين المعتمدين وأحدث الأجهزة الرياضية العالمية.', 'A fully equipped gym providing a motivating environment to achieve your fitness goals with a team of certified trainers and the latest international sports equipment.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(492, 11, 'hero', 'hero_button_text', 'اشترك الآن', 'Join Now', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(493, 11, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41');
INSERT INTO `theme_contents` (`id`, `theme_id`, `section_type`, `content_key`, `content_ar`, `content_en`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(494, 11, 'about', 'about_text', 'نادي رياضي رائد يهدف إلى نشر ثقافة اللياقة البدنية والحياة الصحية. نوفر مرافق عصرية تشمل صالة أوزان حرة وآلات، قاعات لليوغا والبيلاتس، مسبح أولمبي، وملاعب رياضية متعددة.', 'A leading sports club aiming to spread fitness culture and healthy living. We provide modern facilities including free weights and machines, yoga and pilates studios, Olympic pool, and multi-sport courts.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(495, 11, 'services', 'service_1', '{\"title_ar\":\"تدريب شخصي\",\"title_en\":\"Personal Training\",\"description_ar\":\"جلسات تدريب شخصي مع مدربين معتمدين لتصميم برامج مخصصة حسب أهدافك\",\"description_en\":\"Personal training sessions with certified trainers to design programs tailored to your goals\",\"icon\":\"fas fa-dumbbell\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(496, 11, 'services', 'service_2', '{\"title_ar\":\"يوجا وبيلاتس\",\"title_en\":\"Yoga and Pilates\",\"description_ar\":\"فصول يوجا وبيلاتس يومية لتحسين المرونة والاسترخاء الذهني\",\"description_en\":\"Daily yoga and pilates classes to improve flexibility and mental relaxation\",\"icon\":\"fas fa-spa\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(497, 11, 'services', 'service_3', '{\"title_ar\":\"برامج لياقة\",\"title_en\":\"Fitness Programs\",\"description_ar\":\"برامج لياقة متنوعة تشمل كارديو وقوة وتخسيس وزن وبناء عضلات\",\"description_en\":\"Diverse fitness programs including cardio, strength, weight loss, and muscle building\",\"icon\":\"fas fa-running\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(498, 11, 'services', 'service_4', '{\"title_ar\":\"تغذية صحية\",\"title_en\":\"Healthy Nutrition\",\"description_ar\":\"استشارات تغذية متخصصة مع خطط غذائية مخصصة لتحقيق أهدافك\",\"description_en\":\"Specialized nutrition consultations with custom meal plans to achieve your goals\",\"icon\":\"fas fa-apple-alt\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(499, 11, 'testimonials', 'testimonial_1', '{\"client_name\":\"عمر العتيبي\",\"client_title\":\"مهندس\",\"content\":\"خلال 3 أشهر فقط حققت هدفي في خسارة الوزن بفضل المدربين المحترفين هنا.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(500, 11, 'testimonials', 'testimonial_2', '{\"client_name\":\"سارة الغامدي\",\"client_title\":\"محاسبة\",\"content\":\"النادي نظيف جداً والأجهزة حديثة. أنصح الجميع بالاشتراك.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(501, 11, 'contact', 'contact_info', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"الرياض - حي النرجس - شارع أنس بن مالك\"}', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"Riyadh - Al Narjis District - Anas bin Malik Road\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(502, 12, 'hero', 'hero_title', 'حقوقك محمية بقوة القانون', 'Your Rights Protected by Law', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(503, 12, 'hero', 'hero_subtitle', 'محامون متخصصون يضعون خبرتهم في خدمة عدالتك', 'Specialized lawyers putting their expertise at the service of your justice', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(504, 12, 'hero', 'hero_description', 'مكتب محاماة متخصص يقدم خدمات قانونية شاملة بأعلى معايير المهنية والسرية. نمتلك فريقاً من المحامين والاستشاريين القانونيين ذوي الخبرة الواسعة في مختلف فروع القانون.', 'A specialized law firm providing comprehensive legal services to the highest professional and confidential standards. We have a team of lawyers and legal consultants with extensive experience in various branches of law.', 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(505, 12, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(506, 12, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(507, 12, 'about', 'about_text', 'مكتب محاماة راسخ يقدم خدمات قانونية متميزة منذ أكثر من 20 عاماً. نتعامل مع جميع أنواع القضايا المدنية والتجارية والعقارية والجنائية مع الالتزام بأعلى معايير السرية والأمانة المهنية.', 'An established law firm providing distinguished legal services for over 20 years. We handle all types of civil, commercial, real estate, and criminal cases while maintaining the highest standards of confidentiality and professional ethics.', 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(508, 12, 'services', 'service_1', '{\"title_ar\":\"استشارات قانونية\",\"title_en\":\"Legal Consultations\",\"description_ar\":\"استشارات قانونية متخصصة في جميع المجالات مع تحليل شامل للموقف القانوني\",\"description_en\":\"Specialized legal consultations in all fields with comprehensive legal situation analysis\",\"icon\":\"fas fa-gavel\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(509, 12, 'services', 'service_2', '{\"title_ar\":\"قانون الشركات\",\"title_en\":\"Corporate Law\",\"description_ar\":\"خدمات قانونية للشركات تشمل التأسيس والعقود والتحكيم التجاري\",\"description_en\":\"Legal services for companies including incorporation, contracts, and commercial arbitration\",\"icon\":\"fas fa-briefcase\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(510, 12, 'services', 'service_3', '{\"title_ar\":\"قضايا عقارية\",\"title_en\":\"Real Estate Cases\",\"description_ar\":\"تمثيل قانوني في القضايا العقارية ونزاعات الملكية وصياغة العقود\",\"description_en\":\"Legal representation in real estate cases, property disputes, and contract drafting\",\"icon\":\"fas fa-landmark\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(511, 12, 'services', 'service_4', '{\"title_ar\":\"قانون الأسرة\",\"title_en\":\"Family Law\",\"description_ar\":\"معالجة قضايا الأحوال الشخصية والطلاق والحضانة والنفقة\",\"description_en\":\"Handling personal status cases, divorce, custody, and alimony\",\"icon\":\"fas fa-users\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(512, 12, 'testimonials', 'testimonial_1', '{\"client_name\":\"ناصر العمري\",\"client_title\":\"رجل أعمال\",\"content\":\"محامون محترفون جداً. ساعدوني في حل نزاع تجاري معقد بنجاح.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(513, 12, 'testimonials', 'testimonial_2', '{\"client_name\":\"منال السلمي\",\"client_title\":\"سيدة أعمال\",\"content\":\"مكتب محترف ويتميز بالسرية التامة. أنصح أي شخص يحتاج مساعدة قانونية بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(514, 12, 'contact', 'contact_info', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"الرياض - حي العليا - برج المملكة - الطابق 15\"}', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"Riyadh - Olaya District - Kingdom Tower - 15th Floor\"}', 1, 1, '2026-04-11 07:19:41', '2026-04-11 07:19:41'),
(515, 1, 'hero', 'hero_title', 'حلول احترافية لنجاح أعمالك', 'Professional Solutions for Your Business Success', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(516, 1, 'hero', 'hero_subtitle', 'شريكك الموثوق في عالم الأعمال الرقمية', 'Your Trusted Partner in the Digital Business World', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(517, 1, 'hero', 'hero_description', 'نقدم حلولاً متكاملة تساعدك على تطوير أعمالك وتحقيق أهدافك بكفاءة عالية. فريقنا المتخصص يضع خبراته في خدمتك لتقديم أفضل النتائج.', 'We provide integrated solutions to help you grow your business and achieve your goals efficiently. Our expert team puts their expertise at your service to deliver the best results.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(518, 1, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(519, 1, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(520, 1, 'about', 'about_text', 'شركة رائدة في تقديم الحلول الرقمية المتميزة. نمتلك فريقاً من الخبراء والمتخصصين الذين يعملون بشغف لتقديم خدمات عالية الجودة تلبي احتياجات عملائنا المتنوعة.', 'A leading company in providing outstanding digital solutions. We have a team of experts and specialists who work passionately to deliver high-quality services that meet our clients diverse needs.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(521, 1, 'services', 'service_1', '{\"title_ar\":\"استشارات الأعمال\",\"title_en\":\"Business Consulting\",\"description_ar\":\"استشارات متخصصة لتطوير أعمالك وزيادة الإنتاجية مع خطط استراتيجية مخصصة\",\"description_en\":\"Specialized consulting to develop your business and increase productivity with custom strategic plans\",\"icon\":\"fas fa-chart-line\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(522, 1, 'services', 'service_2', '{\"title_ar\":\"تطوير المواقع\",\"title_en\":\"Web Development\",\"description_ar\":\"تصميم وتطوير مواقع إلكترونية احترافية متجاوبة مع جميع الأجهزة\",\"description_en\":\"Professional responsive website design and development for all devices\",\"icon\":\"fas fa-code\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(523, 1, 'services', 'service_3', '{\"title_ar\":\"التسويق الرقمي\",\"title_en\":\"Digital Marketing\",\"description_ar\":\"استراتيجيات تسويق رقمي متكاملة لزيادة الوعي بعلامتك التجارية\",\"description_en\":\"Integrated digital marketing strategies to increase brand awareness\",\"icon\":\"fas fa-bullhorn\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(524, 1, 'services', 'service_4', '{\"title_ar\":\"الدعم الفني\",\"title_en\":\"Technical Support\",\"description_ar\":\"دعم فني على مدار الساعة لضمان سير عملك بدون انقطاع\",\"description_en\":\"24/7 technical support to ensure your business runs without interruption\",\"icon\":\"fas fa-headset\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(525, 1, 'testimonials', 'testimonial_1', '{\"client_name\":\"عبدالله السعيد\",\"client_title\":\"مدير شركة\",\"content\":\"خدمة ممتازة وفريق محترف. ساعدونا في تحقيق أهدافنا بشكل أسرع من المتوقع.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(526, 1, 'testimonials', 'testimonial_2', '{\"client_name\":\"مريم الحربي\",\"client_title\":\"رائدة أعمال\",\"content\":\"من أفضل الشركات التي تعاملت معها. الجودة والاحترافية في كل تفصيل.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(527, 1, 'contact', 'contact_info', '{\"phone\":\"966500000100\",\"whatsapp\":\"966500000100\",\"email\":\"info@generic-company.com\",\"address\":\"الرياض - حي العليا - شارع الملك فهد\"}', '{\"phone\":\"966500000100\",\"whatsapp\":\"966500000100\",\"email\":\"info@generic-company.com\",\"address\":\"Riyadh - Olaya District - King Fahd Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(528, 2, 'hero', 'hero_title', 'حلول كهربائية متكاملة', 'Integrated Electrical Solutions', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(529, 2, 'hero', 'hero_subtitle', 'فنيون معتمدون بخبرة تفوق 15 عاماً في جميع الأعمال الكهربائية', 'Certified technicians with over 15 years of experience in all electrical work', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(530, 2, 'hero', 'hero_description', 'شركة متخصصة في تقديم جميع الخدمات الكهربائية للمنازل والمنشآت التجارية والصناعية. نلتزم بأعلى معايير السلامة والجودة مع ضمان على جميع أعمالنا.', 'A company specializing in providing all electrical services for homes, commercial, and industrial facilities. We adhere to the highest safety and quality standards with warranty on all our work.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(531, 2, 'hero', 'hero_button_text', 'اطلب فني', 'Request Technician', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(532, 2, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(533, 2, 'about', 'about_text', 'شركة كهربائية رائدة تقدم خدماتها منذ أكثر من 15 عاماً. نمتلك فريقاً من الفنيين والمهندسين المعتمدين المتخصصين في جميع مجالات الأعمال الكهربائية مع استخدام أجود المواد والمعدات.', 'A leading electrical company serving for over 15 years. We have a team of certified technicians and engineers specialized in all areas of electrical work using the finest materials and equipment.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(534, 2, 'services', 'service_1', '{\"title_ar\":\"تمديدات كهربائية\",\"title_en\":\"Electrical Wiring\",\"description_ar\":\"تمديدات كهربائية احترافية للمنازل والمباني التجارية بمعايير السلامة الدولية\",\"description_en\":\"Professional electrical wiring for homes and commercial buildings to international safety standards\",\"icon\":\"fas fa-bolt\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(535, 2, 'services', 'service_2', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة وتركيب جميع أنواع المكيفات مع ضمان شامل على القطع والعمل\",\"description_en\":\"Maintenance and installation of all AC types with comprehensive warranty on parts and labor\",\"icon\":\"fas fa-snowflake\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(536, 2, 'services', 'service_3', '{\"title_ar\":\"لوحات التحكم\",\"title_en\":\"Control Panels\",\"description_ar\":\"تصميم وتركيب لوحات التحكم الكهربائية للمباني والمصانع\",\"description_en\":\"Design and installation of electrical control panels for buildings and factories\",\"icon\":\"fas fa-sliders-h\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(537, 2, 'services', 'service_4', '{\"title_ar\":\"طوارئ كهربائية\",\"title_en\":\"Emergency Electrical\",\"description_ar\":\"خدمة طوارئ على مدار الساعة لحل جميع المشاكل الكهربائية العاجلة\",\"description_en\":\"24/7 emergency service to resolve all urgent electrical problems\",\"icon\":\"fas fa-exclamation-triangle\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(538, 2, 'testimonials', 'testimonial_1', '{\"client_name\":\"سعد القحطاني\",\"client_title\":\"مهندس\",\"content\":\"فريق محترف وسريع في الاستجابة. أنجزوا المشروع قبل الموعد المحدد.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(539, 2, 'testimonials', 'testimonial_2', '{\"client_name\":\"فاطمة الشمري\",\"client_title\":\"ربة منزل\",\"content\":\"خدمة ممتازة وأسعار معقولة. أنصح الجميع بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(540, 2, 'contact', 'contact_info', '{\"phone\":\"966500000102\",\"whatsapp\":\"966500000102\",\"email\":\"info@electric-services.com\",\"address\":\"جدة - حي الصفا - شارع فلسطين\"}', '{\"phone\":\"966500000102\",\"whatsapp\":\"966500000102\",\"email\":\"info@electric-services.com\",\"address\":\"Jeddah - Al Safa District - Palestine Street\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(541, 3, 'hero', 'hero_title', 'نظافة مثالية بلمسة احترافية', 'Perfect Cleanliness with a Professional Touch', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(542, 3, 'hero', 'hero_subtitle', 'خدمات تنظيف شاملة للمنازل والمكاتب والمنشآت التجارية', 'Comprehensive cleaning services for homes, offices, and commercial facilities', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(543, 3, 'hero', 'hero_description', 'شركة تنظيف متخصصة تقدم خدمات شاملة باستخدام أحدث المعدات ومواد التنظيف الآمنة والصديقة للبيئة. نضمن لك بيئة نظيفة وصحية.', 'A specialized cleaning company offering comprehensive services using the latest equipment and eco-friendly cleaning products. We guarantee a clean and healthy environment.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(544, 3, 'hero', 'hero_button_text', 'احجز الآن', 'Book Now', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(545, 3, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(546, 3, 'about', 'about_text', 'شركة تنظيف رائدة تتميز بخبرة واسعة في تقديم خدمات تنظيف عالية الجودة. نستخدم أحدث التقنيات ومواد تنظيف آمنة مع فريق مدرب على أعلى مستوى.', 'A leading cleaning company distinguished by extensive experience in delivering high-quality cleaning services. We use the latest technologies and safe cleaning products with a highly trained team.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(547, 3, 'services', 'service_1', '{\"title_ar\":\"تنظيف عميق\",\"title_en\":\"Deep Cleaning\",\"description_ar\":\"تنظيف عميق شامل لجميع أنحاء المنزل أو المكتب باستخدام أحدث المعدات\",\"description_en\":\"Comprehensive deep cleaning for the entire home or office using the latest equipment\",\"icon\":\"fas fa-broom\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(548, 3, 'services', 'service_2', '{\"title_ar\":\"تنظيف المكاتب\",\"title_en\":\"Office Cleaning\",\"description_ar\":\"خدمات تنظيف يومية وأسبوعية للمكاتب والمنشآت التجارية\",\"description_en\":\"Daily and weekly cleaning services for offices and commercial facilities\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(549, 3, 'services', 'service_3', '{\"title_ar\":\"تنظيف السجاد\",\"title_en\":\"Carpet Cleaning\",\"description_ar\":\"تنظيف احترافي للسجاد والموكيت بجميع أنواعه وأحجامه\",\"description_en\":\"Professional carpet and rug cleaning of all types and sizes\",\"icon\":\"fas fa-rug\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(550, 3, 'services', 'service_4', '{\"title_ar\":\"تنظيف بعد البناء\",\"title_en\":\"Post-Construction\",\"description_ar\":\"تنظيف شامل بعد أعمال البناء والتشطيبات لإعداد المكان للاستخدام\",\"description_en\":\"Comprehensive cleaning after construction and finishing work to prepare the space for use\",\"icon\":\"fas fa-hard-hat\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(551, 3, 'testimonials', 'testimonial_1', '{\"client_name\":\"نوف العتيبي\",\"client_title\":\"سيدة أعمال\",\"content\":\"منظفون محترفون والنتيجة ممتازة. البيئة أصبحت نظيفة ومعطرة بشكل رائع.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(552, 3, 'testimonials', 'testimonial_2', '{\"client_name\":\"مازن الدوسري\",\"client_title\":\"مدير مكتب\",\"content\":\"نتعامل معهم لتنظيف مكاتبنا أسبوعياً ولم نختبر يوماً أي تقصير.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(553, 3, 'contact', 'contact_info', '{\"phone\":\"966500000103\",\"whatsapp\":\"966500000103\",\"email\":\"info@cleaning-services.com\",\"address\":\"الرياض - حي النسيم - شارع الحسن\"}', '{\"phone\":\"966500000103\",\"whatsapp\":\"966500000103\",\"email\":\"info@cleaning-services.com\",\"address\":\"Riyadh - Al Naseem District - Al Hassan Street\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(554, 4, 'hero', 'hero_title', 'تصاميم ديكور فاخرة', 'Luxury Interior Design', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(555, 4, 'hero', 'hero_subtitle', 'نحول رؤيتك إلى واقع بلمسات فنية استثنائية', 'We turn your vision into reality with exceptional artistic touches', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(556, 4, 'hero', 'hero_description', 'استوديو ديكور متخصص يقدم خدمات تصميم داخلي وتنسيق ديكور احترافية للمنازل والمكاتب والفنادق والمساحات التجارية بأحدث الاتجاهات العالمية.', 'A specialized decor studio offering professional interior design and decor coordination services for homes, offices, hotels, and commercial spaces with the latest global trends.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(557, 4, 'hero', 'hero_button_text', 'شاهد أعمالنا', 'View Our Work', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(558, 4, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(559, 4, 'about', 'about_text', 'استوديو ديكور تأسس على يد فريق من المصممين المبدعين الذين يجمعون بين الفن والوظيفة. نقدم تصاميم فريدة تعكس ذوقك الشخصي وتلبي احتياجاتك العملية مع الالتزام بالميزانية.', 'A decor studio founded by a team of creative designers who combine art and function. We deliver unique designs that reflect your personal taste and meet your practical needs while staying within budget.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(560, 4, 'services', 'service_1', '{\"title_ar\":\"تصميم داخلي\",\"title_en\":\"Interior Design\",\"description_ar\":\"تصميم داخلي متكامل يراعي الجمال والوظيفة والراحة في كل تفصيل\",\"description_en\":\"Complete interior design balancing beauty, function, and comfort in every detail\",\"icon\":\"fas fa-couch\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(561, 4, 'services', 'service_2', '{\"title_ar\":\"تنسيق المساحات\",\"title_en\":\"Space Planning\",\"description_ar\":\"تنسيق المساحات بشكل ذكي لتحقيق أقصى استفادة من كل متر مربع\",\"description_en\":\"Smart space planning to maximize the use of every square meter\",\"icon\":\"fas fa-drafting-compass\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(562, 4, 'services', 'service_3', '{\"title_ar\":\"دهانات احترافية\",\"title_en\":\"Professional Painting\",\"description_ar\":\"خدمات دهانات احترافية بأحدث الألوان والتقنيات مع تشطيبات فاخرة\",\"description_en\":\"Professional painting services with the latest colors and techniques plus luxury finishes\",\"icon\":\"fas fa-paint-roller\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(563, 4, 'services', 'service_4', '{\"title_ar\":\"إضاءة وتجهيز\",\"title_en\":\"Lighting & Furnishing\",\"description_ar\":\"اختيار وتنسيق الإضاءة والأثاث لإضفاء لمسة فاخرة على المكان\",\"description_en\":\"Selection and coordination of lighting and furniture to add a luxurious touch to the space\",\"icon\":\"fas fa-lightbulb\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(564, 4, 'testimonials', 'testimonial_1', '{\"client_name\":\"لمياء العمري\",\"client_title\":\"ربة منزل\",\"content\":\"حولوا بيتنا إلى قصر. التصميم أكثر من رائع والتنفيذ دقيق جداً.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(565, 4, 'testimonials', 'testimonial_2', '{\"client_name\":\"تركي العنزي\",\"client_title\":\"رجل أعمال\",\"content\":\"تعاملنا معهم في تصميم مكاتبنا والنتيجة فاقت كل التوقعات.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(566, 4, 'contact', 'contact_info', '{\"phone\":\"966500000104\",\"whatsapp\":\"966500000104\",\"email\":\"info@decor-studio.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير سعد بن عبدالرحمن\"}', '{\"phone\":\"966500000104\",\"whatsapp\":\"966500000104\",\"email\":\"info@decor-studio.com\",\"address\":\"Riyadh - Al Malqa District - Prince Saad bin Abdulrahman Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(567, 5, 'hero', 'hero_title', 'صيانة شاملة بمعايير عالمية', 'Comprehensive Maintenance with International Standards', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(568, 5, 'hero', 'hero_subtitle', 'فريق فنيون متخصصون لحل جميع مشاكل المنزل والمكتب', 'Specialized technical team to solve all home and office problems', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(569, 5, 'hero', 'hero_description', 'شركة صيانة متكاملة تقدم خدماتها للمنازل والمكاتب والمنشآت التجارية. نمتلك فريقاً من الفنيين المعتمدين في جميع التخصصات مع ضمان شامل على جميع أعمالنا.', 'An integrated maintenance company serving homes, offices, and commercial facilities. We have a team of certified technicians across all specialties with a comprehensive warranty on all our work.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(570, 5, 'hero', 'hero_button_text', 'اطلب صيانة', 'Request Service', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(571, 5, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(572, 5, 'about', 'about_text', 'شركة صيانة رائدة تقدم حلولاً شاملة وموثوقة لجميع احتياجات الصيانة. نحرص على الالتزام بالمواعيد وتقديم خدمات عالية الجودة بأسعار تنافسية مع ضمان على كل عمل نقوم به.', 'A leading maintenance company providing comprehensive and reliable solutions for all maintenance needs. We are committed to punctuality and delivering high-quality services at competitive prices with warranty on every job.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(573, 5, 'services', 'service_1', '{\"title_ar\":\"كهرباء المنازل\",\"title_en\":\"Home Electrical\",\"description_ar\":\"صيانة كهربائية شاملة للمنازل من تمديدات وإصلاحات وتركيبات\",\"description_en\":\"Comprehensive home electrical maintenance from wiring, repairs, and installations\",\"icon\":\"fas fa-plug\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(574, 5, 'services', 'service_2', '{\"title_ar\":\"صيانة التكييف\",\"title_en\":\"AC Maintenance\",\"description_ar\":\"صيانة وتركيب وغسيل مكيفات جميع الأنواع مع ضمان الخدمة\",\"description_en\":\"AC maintenance, installation, and cleaning of all types with service warranty\",\"icon\":\"fas fa-fan\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(575, 5, 'services', 'service_3', '{\"title_ar\":\"خدمات الدهان\",\"title_en\":\"Painting Services\",\"description_ar\":\"دهانات داخلية وخارجية بجميع الألوان والتقنيات الحديثة\",\"description_en\":\"Interior and exterior painting with all colors and modern techniques\",\"icon\":\"fas fa-paint-brush\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(576, 5, 'services', 'service_4', '{\"title_ar\":\"سباكة وإصلاحات\",\"title_en\":\"Plumbing & Repairs\",\"description_ar\":\"خدمات سباكة شاملة من تركيب وإصلاح وصيانة جميع الأنابيب والصحيات\",\"description_en\":\"Comprehensive plumbing services from installation, repair, and maintenance of all pipes and fixtures\",\"icon\":\"fas fa-wrench\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(577, 5, 'testimonials', 'testimonial_1', '{\"client_name\":\"سلطان المطيري\",\"client_title\":\"مدير مدرسة\",\"content\":\"صيانة ممتازة وسريعة. الفنيون محترفون والأسعار معقولة جداً.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(578, 5, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند الزهراني\",\"client_title\":\"ربة منزل\",\"content\":\"أنقذونا في مشكلة السباكة الطارئة. وصلوا خلال ساعة وأصلحوا المشكلة.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(579, 5, 'contact', 'contact_info', '{\"phone\":\"966500000105\",\"whatsapp\":\"966500000105\",\"email\":\"info@maintenance-services.com\",\"address\":\"الدمام - حي الشاطئ - شارع الأمير محمد\"}', '{\"phone\":\"966500000105\",\"whatsapp\":\"966500000105\",\"email\":\"info@maintenance-services.com\",\"address\":\"Dammam - Al Sahati District - Prince Mohammed Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(580, 6, 'hero', 'hero_title', 'حلول سباكة موثوقة وسريعة', 'Reliable and Fast Plumbing Solutions', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(581, 6, 'hero', 'hero_subtitle', 'سباكون معتمدون بخبرة تفوق 10 سنوات في جميع أعمال السباكة', 'Certified plumbers with over 10 years of experience in all plumbing work', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(582, 6, 'hero', 'hero_description', 'شركة سباكة متخصصة تقدم خدمات شاملة من الإصلاحات الطارئة إلى التركيبات الجديدة. نستخدم أجود القطع والمواد مع ضمان شامل على جميع أعمالنا وخدمة على مدار الساعة.', 'A specialized plumbing company offering comprehensive services from emergency repairs to new installations. We use the finest parts and materials with a comprehensive warranty on all our work and 24/7 service.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(583, 6, 'hero', 'hero_button_text', 'اتصل الآن', 'Call Now', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(584, 6, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(585, 6, 'about', 'about_text', 'شركة سباكة متخصصة تتميز بفريق من الفنيين المعتمدين ذوي الخبرة الواسعة. نقدم حلولاً سريعة ودائمة لمشاكل السباكة مع الالتزام بأعلى معايير الجودة والنظافة.', 'A specialized plumbing company featuring a team of certified technicians with extensive experience. We provide fast and permanent solutions to plumbing problems while adhering to the highest quality and cleanliness standards.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(586, 6, 'services', 'service_1', '{\"title_ar\":\"إصلاح السباكة\",\"title_en\":\"Plumbing Repair\",\"description_ar\":\"إصلاح سريع ودقيق لجميع أعطال السباكة مع ضمان على العمل\",\"description_en\":\"Fast and accurate repair of all plumbing failures with work warranty\",\"icon\":\"fas fa-wrench\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(587, 6, 'services', 'service_2', '{\"title_ar\":\"تركيب الصحيات\",\"title_en\":\"Fixture Installation\",\"description_ar\":\"تركيب جميع أنواع الصحيات والمعدات بأعلى معايير الجودة\",\"description_en\":\"Installation of all types of fixtures and equipment to the highest quality standards\",\"icon\":\"fas fa-faucet\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(588, 6, 'services', 'service_3', '{\"title_ar\":\"كشف التسريبات\",\"title_en\":\"Leak Detection\",\"description_ar\":\"كشف وإصلاح تسريبات المياه بأحدث التقنيات دون تكسير\",\"description_en\":\"Leak detection and repair using the latest technologies without demolition\",\"icon\":\"fas fa-tint\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(589, 6, 'services', 'service_4', '{\"title_ar\":\"صيانة مجاري\",\"title_en\":\"Drain Maintenance\",\"description_ar\":\"تنظيف وصيانة المجاري والبالوعات بأحدث المعدات المتخصصة\",\"description_en\":\"Drain and sewer cleaning and maintenance with the latest specialized equipment\",\"icon\":\"fas fa-water\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(590, 6, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الشمري\",\"client_title\":\"مالك فيلا\",\"content\":\"وصلوا خلال نصف ساعة وأصلحوا الانفجار بسرعة واحترافية ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(591, 6, 'testimonials', 'testimonial_2', '{\"client_name\":\"أم سلطان\",\"client_title\":\"ربة منزل\",\"content\":\"تعاملت معهم عدة مرات ودائماً خدمة ممتازة وأسعار مناسبة.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(592, 6, 'contact', 'contact_info', '{\"phone\":\"966500000106\",\"whatsapp\":\"966500000106\",\"email\":\"info@plumbing-services.com\",\"address\":\"الرياض - حي الروضة - شارع الإمام تركي\"}', '{\"phone\":\"966500000106\",\"whatsapp\":\"966500000106\",\"email\":\"info@plumbing-services.com\",\"address\":\"Riyadh - Al Rawdah District - Imam Turki Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(593, 7, 'hero', 'hero_title', 'رعاية صحية استثنائية', 'Exceptional Health Care', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(594, 7, 'hero', 'hero_subtitle', 'فريق طبي متخصص يضع صحتك أولاً', 'Specialized medical team putting your health first', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(595, 7, 'hero', 'hero_description', 'نوفر خدمات طبية شاملة بأحدث التقنيات وأفضل الأطباء المتخصصين في جميع المجالات الطبية. نلتزم بأعلى معايير الجودة والسلامة.', 'We provide comprehensive medical services with the latest technology and the best specialized doctors in all medical fields. We adhere to the highest quality and safety standards.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(596, 7, 'hero', 'hero_button_text', 'احجز موعد', 'Book Appointment', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(597, 7, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(598, 7, 'about', 'about_text', 'مركز طبي متكامل يقدم خدمات الرعاية الصحية بأعلى المعايير العالمية. نضم فريقاً من أمهر الأطباء والاستشاريين في مختلف التخصصات الطبية مع أحدث الأجهزة والتقنيات الطبية المتطورة. نحرص على تقديم تجربة علاجية مريحة وآمنة لجميع مرضانا.', 'An integrated medical center providing healthcare services to the highest international standards. We have a team of the most skilled doctors and consultants across various medical specialties with the latest advanced medical equipment and technologies.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(599, 7, 'services', 'service_1', '{\"title_ar\":\"فحص طبي شامل\",\"title_en\":\"Comprehensive Medical Checkup\",\"description_ar\":\"فحص طبي شامل يشمل جميع الفحوصات اللازمة للتأكد من سلامتك الصحية مع تقارير مفصلة\",\"description_en\":\"Comprehensive medical examination including all necessary tests to ensure your health with detailed reports\",\"icon\":\"fas fa-stethoscope\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(600, 7, 'services', 'service_2', '{\"title_ar\":\"طب الأسنان\",\"title_en\":\"Dental Care\",\"description_ar\":\"خدمات طب أسنان متكاملة من تنظيف وعلاج وتجميل باستخدام أحدث التقنيات\",\"description_en\":\"Integrated dental services from cleaning, treatment, and cosmetics using the latest technologies\",\"icon\":\"fas fa-tooth\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(601, 7, 'services', 'service_3', '{\"title_ar\":\"استشارات طبية\",\"title_en\":\"Medical Consultations\",\"description_ar\":\"استشارات طبية متخصصة مع أفضل الأطباء والاستشاريين في جميع التخصصات\",\"description_en\":\"Specialized medical consultations with the best doctors and consultants in all specialties\",\"icon\":\"fas fa-user-md\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(602, 7, 'services', 'service_4', '{\"title_ar\":\"مختبر تحاليل\",\"title_en\":\"Laboratory\",\"description_ar\":\"مختبر تحاليل مجهز بأحدث الأجهزة مع نتائج دقيقة وسريعة\",\"description_en\":\"Laboratory equipped with the latest devices with accurate and fast results\",\"icon\":\"fas fa-flask\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(603, 7, 'testimonials', 'testimonial_1', '{\"client_name\":\"سارة العتيبي\",\"client_title\":\"مريضة\",\"content\":\"تجربة رائعة مع فريق الطبيب محمد. كان شديد الاحترافية والاهتمام بالتفاصيل.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(604, 7, 'testimonials', 'testimonial_2', '{\"client_name\":\"خالد المطيري\",\"client_title\":\"تاجر\",\"content\":\"من أفضل المراكز الطبية التي تعاملت معها. النظافة والترتيب ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(605, 7, 'testimonials', 'testimonial_3', '{\"client_name\":\"نورة القحطاني\",\"client_title\":\"معلمة\",\"content\":\"أنصح الجميع بالتعامل معهم. خدمة مميزة وأسعار معقولة.\",\"rating\":4}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(606, 7, 'contact', 'contact_info', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"الرياض - حي العليا - شارع التحلية\"}', '{\"phone\":\"966920000111\",\"whatsapp\":\"966920000111\",\"email\":\"info@medical-clinic.com\",\"address\":\"Riyadh - Olaya District - Tahliya Street\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(607, 8, 'hero', 'hero_title', 'عقاراتك الفاخرة تنتظرك', 'Your Luxury Properties Await', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(608, 8, 'hero', 'hero_subtitle', 'اكتشف أفضل العقارات السكنية والتجارية', 'Discover the best residential and commercial properties', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(609, 8, 'hero', 'hero_description', 'وكالة عقارية متخصصة في تقديم أفضل الحلول العقارية. نوفر لك مجموعة واسعة من العقارات السكنية والتجارية بأسعار تنافسية وأفضل المواقع.', 'A specialized real estate agency providing the best property solutions. We offer a wide range of residential and commercial properties at competitive prices and prime locations.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(610, 8, 'hero', 'hero_button_text', 'تصفح العقارات', 'Browse Properties', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(611, 8, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(612, 8, 'about', 'about_text', 'شركة عقارية رائدة في السوق مع خبرة تتجاوز 15 عاماً في مجال الوساطة العقارية. نقدم خدمات شاملة تشمل البيع والشراء والتأجير وإدارة الأملاك مع فريق من الخبراء المتخصصين.', 'A leading real estate company with over 15 years of experience in property brokerage. We offer comprehensive services including sales, purchases, leasing, and property management with a team of specialized experts.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(613, 8, 'services', 'service_1', '{\"title_ar\":\"فلل فاخرة\",\"title_en\":\"Luxury Villas\",\"description_ar\":\"مجموعة حصرية من الفلل الفاخرة بأفضل المناطق السكنية مع تصميمات عصرية\",\"description_en\":\"Exclusive collection of luxury villas in the best residential areas with modern designs\",\"icon\":\"fas fa-home\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(614, 8, 'services', 'service_2', '{\"title_ar\":\"شقق سكنية\",\"title_en\":\"Residential Apartments\",\"description_ar\":\"شقق بتصاميم حديثة في مواقع استراتيجية مناسبة للعائلات والأفراد\",\"description_en\":\"Modern apartments in strategic locations suitable for families and individuals\",\"icon\":\"fas fa-building\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(615, 8, 'services', 'service_3', '{\"title_ar\":\"إدارة أملاك\",\"title_en\":\"Property Management\",\"description_ar\":\"خدمات إدارة أملاك شاملة تشمل الصيانة وتحصيل الإيجارات والتعاقدات\",\"description_en\":\"Comprehensive property management services including maintenance, rent collection, and contracts\",\"icon\":\"fas fa-key\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(616, 8, 'testimonials', 'testimonial_1', '{\"client_name\":\"فهد الدوسري\",\"client_title\":\"رجل أعمال\",\"content\":\"ساعدوني في العثور على فيلا أحلامي بسرعة ممتازة ومهنية عالية.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(617, 8, 'testimonials', 'testimonial_2', '{\"client_name\":\"ريم الشهري\",\"client_title\":\"مهندسة\",\"content\":\"تجربة شراء شقة سلسة ومريحة. الفريق متعاون ومحترف جداً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(618, 8, 'contact', 'contact_info', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"جدة - حي الحمراء - شارع الملك فهد\"}', '{\"phone\":\"966500000222\",\"whatsapp\":\"966500000222\",\"email\":\"info@realestate.com\",\"address\":\"Jeddah - Al Hamra District - King Fahd Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(619, 9, 'hero', 'hero_title', 'أشهى المأكولات في مكان واحد', 'The Finest Cuisine in One Place', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(620, 9, 'hero', 'hero_subtitle', 'تجربة طعام استثنائية تأخذك في رحلة من الذواقة', 'An exceptional dining experience that takes you on a culinary journey', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(621, 9, 'hero', 'hero_description', 'مطعم فاخر يقدم أشهى الأطباق العربية والعالمية المحضرة بعناية من قبل أفضل الطهاة باستخدام أجود المكونات الطبيعية الطازجة.', 'A luxury restaurant serving the finest Arabic and international dishes carefully prepared by the best chefs using the finest natural fresh ingredients.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(622, 9, 'hero', 'hero_button_text', 'اطلب الآن', 'Order Now', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(623, 9, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(624, 9, 'about', 'about_text', 'مطعمنا الفاخر يجمع بين الأصالة والحداثة في تقديم أشهى المأكولات. يمتلك فريقنا من الطهاة الحائزين على جوائز عالمية خبرة واسعة في فن الطبخ. نحرص على اختيار مكوناتنا من أفضل المزارع المحلية لتقديم تجربة طعام لا تُنسى.', 'Our luxury restaurant combines authenticity and modernity in serving the finest cuisine. Our award-winning chef team has extensive experience in the culinary arts. We carefully select our ingredients from the best local farms to deliver an unforgettable dining experience.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(625, 9, 'services', 'service_1', '{\"title_ar\":\"عشاء فاخر\",\"title_en\":\"Fine Dining\",\"description_ar\":\"قائمة طعام متنوعة من الأطباق العربية والعالمية المحضرة بأيدي طهاة محترفين\",\"description_en\":\"Diverse menu of Arabic and international dishes prepared by professional chefs\",\"icon\":\"fas fa-utensils\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(626, 9, 'services', 'service_2', '{\"title_ar\":\"تموين مناسبات\",\"title_en\":\"Event Catering\",\"description_ar\":\"خدمات تموين احترافية للمناسبات والحفلات بجميع أنواعها وأحجامها\",\"description_en\":\"Professional catering services for events and parties of all types and sizes\",\"icon\":\"fas fa-glass-cheers\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(627, 9, 'services', 'service_3', '{\"title_ar\":\"خدمة التوصيل\",\"title_en\":\"Delivery Service\",\"description_ar\":\"خدمة توصيل سريعة لجميع الطلبات مع الحفاظ على جودة الطعام\",\"description_en\":\"Fast delivery service for all orders while maintaining food quality\",\"icon\":\"fas fa-motorcycle\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(628, 9, 'services', 'service_4', '{\"title_ar\":\"حجز طاولات\",\"title_en\":\"Table Reservation\",\"description_ar\":\"احجز طاولتك مسبقاً واستمتع بتجربة عشاء مميزة في أجواء راقية\",\"description_en\":\"Reserve your table in advance and enjoy a distinguished dinner experience in an elegant atmosphere\",\"icon\":\"fas fa-calendar-check\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(629, 9, 'testimonials', 'testimonial_1', '{\"client_name\":\"محمد السبيعي\",\"client_title\":\"مدير تنفيذي\",\"content\":\"أفضل مطعم في المدينة بلا منازع. الأكل لذيذ والخدمة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(630, 9, 'testimonials', 'testimonial_2', '{\"client_name\":\"هند العنزي\",\"client_title\":\"مدونة طعام\",\"content\":\"جربت العديد من المطاعم لكن هذا المطعم في مستوى آخر تماماً.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(631, 9, 'contact', 'contact_info', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"الرياض - حي الملقا - شارع الأمير محمد بن عبدالعزيز\"}', '{\"phone\":\"966500000333\",\"whatsapp\":\"966500000333\",\"email\":\"info@restaurant.com\",\"address\":\"Riyadh - Al Malqa District - Prince Mohammed bin Abdulaziz Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(632, 10, 'hero', 'hero_title', 'استثمر في مستقبلك التعليمي', 'Invest in Your Educational Future', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(633, 10, 'hero', 'hero_subtitle', 'تعليم متميز يبني أجيالاً واعية ومبدعة', 'Distinguished education building aware and creative generations', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(634, 10, 'hero', 'hero_description', 'أكاديمية تعليمية رائدة تقدم برامج تعليمية وتدريبية متطورة بأحدث الأساليب التعليمية مع نخبة من أفضل المدربين والمتخصصين.', 'A leading educational academy offering advanced educational and training programs using the latest teaching methods with a selection of the best trainers and specialists.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(635, 10, 'hero', 'hero_button_text', 'سجل الآن', 'Register Now', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(636, 10, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(637, 10, 'about', 'about_text', 'أكاديمية تعليمية متخصصة تأسست بهدف تقديم تعليم عالي الجودة يواكب أحدث التطورات. نقدم برامج متنوعة تشمل الدورات التأهيلية والشهادات المهنية والتدريب العملي مع بيئة تعليمية محفزة.', 'A specialized educational academy established to provide high-quality education aligned with the latest developments. We offer diverse programs including qualification courses, professional certificates, and practical training in a motivating learning environment.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(638, 10, 'services', 'service_1', '{\"title_ar\":\"دورات حضورية\",\"title_en\":\"Classroom Courses\",\"description_ar\":\"دورات تدريبية حضورية بفصول مجهزة بأحدث التقنيات مع مدربين محترفين\",\"description_en\":\"Classroom training courses in fully equipped halls with the latest technology and professional trainers\",\"icon\":\"fas fa-chalkboard-teacher\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(639, 10, 'services', 'service_2', '{\"title_ar\":\"تعليم عن بعد\",\"title_en\":\"Online Learning\",\"description_ar\":\"برامج تعليمية إلكترونية متكاملة يمكنك التعلم منها في أي وقت ومن أي مكان\",\"description_en\":\"Integrated e-learning programs you can study anytime and anywhere\",\"icon\":\"fas fa-laptop\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(640, 10, 'services', 'service_3', '{\"title_ar\":\"تدريب مهني\",\"title_en\":\"Professional Training\",\"description_ar\":\"برامج تدريب مهني معتمدة لتطوير المهارات ورفع الكفاءة المهنية\",\"description_en\":\"Accredited professional training programs to develop skills and enhance professional competence\",\"icon\":\"fas fa-graduation-cap\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(641, 10, 'services', 'service_4', '{\"title_ar\":\"استشارات تعليمية\",\"title_en\":\"Educational Consulting\",\"description_ar\":\"استشارات متخصصة لاختيار المسار التعليمي المناسب وتخطيط المستقبل الأكاديمي\",\"description_en\":\"Specialized consulting for choosing the right educational path and academic future planning\",\"icon\":\"fas fa-route\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(642, 10, 'testimonials', 'testimonial_1', '{\"client_name\":\"أحمد الحربي\",\"client_title\":\"طالب جامعي\",\"content\":\"الدورات هنا ساعدتني كثيراً في تطوير مهاراتي والحصول على وظيفة ممتازة.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(643, 10, 'testimonials', 'testimonial_2', '{\"client_name\":\"لمى الزهراني\",\"client_title\":\"مصممة جرافيك\",\"content\":\"تعلمت هنا أساسيات التصميم بشكل احترافي. المدربون رائعون والمحتوى ممتاز.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(644, 10, 'contact', 'contact_info', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"الدمام - حي الفيصلية - شارع الأمير سلطان\"}', '{\"phone\":\"966500000444\",\"whatsapp\":\"966500000444\",\"email\":\"info@academy.com\",\"address\":\"Dammam - Al Faisaliyah District - Prince Sultan Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(645, 11, 'hero', 'hero_title', 'ابدأ رحلتك نحو اللياقة', 'Start Your Fitness Journey', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(646, 11, 'hero', 'hero_subtitle', 'نادي رياضي متكامل بأحدث المعدات وأفضل المدربين', 'Fully equipped gym with the latest equipment and best trainers', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(647, 11, 'hero', 'hero_description', 'نادي رياضي متكامل يوفر بيئة محفزة لتحقيق أهدافك اللياقية مع فريق من المدربين المعتمدين وأحدث الأجهزة الرياضية العالمية.', 'A fully equipped gym providing a motivating environment to achieve your fitness goals with a team of certified trainers and the latest international sports equipment.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(648, 11, 'hero', 'hero_button_text', 'اشترك الآن', 'Join Now', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(649, 11, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(650, 11, 'about', 'about_text', 'نادي رياضي رائد يهدف إلى نشر ثقافة اللياقة البدنية والحياة الصحية. نوفر مرافق عصرية تشمل صالة أوزان حرة وآلات، قاعات لليوغا والبيلاتس، مسبح أولمبي، وملاعب رياضية متعددة.', 'A leading sports club aiming to spread fitness culture and healthy living. We provide modern facilities including free weights and machines, yoga and pilates studios, Olympic pool, and multi-sport courts.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(651, 11, 'services', 'service_1', '{\"title_ar\":\"تدريب شخصي\",\"title_en\":\"Personal Training\",\"description_ar\":\"جلسات تدريب شخصي مع مدربين معتمدين لتصميم برامج مخصصة حسب أهدافك\",\"description_en\":\"Personal training sessions with certified trainers to design programs tailored to your goals\",\"icon\":\"fas fa-dumbbell\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(652, 11, 'services', 'service_2', '{\"title_ar\":\"يوجا وبيلاتس\",\"title_en\":\"Yoga and Pilates\",\"description_ar\":\"فصول يوجا وبيلاتس يومية لتحسين المرونة والاسترخاء الذهني\",\"description_en\":\"Daily yoga and pilates classes to improve flexibility and mental relaxation\",\"icon\":\"fas fa-spa\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(653, 11, 'services', 'service_3', '{\"title_ar\":\"برامج لياقة\",\"title_en\":\"Fitness Programs\",\"description_ar\":\"برامج لياقة متنوعة تشمل كارديو وقوة وتخسيس وزن وبناء عضلات\",\"description_en\":\"Diverse fitness programs including cardio, strength, weight loss, and muscle building\",\"icon\":\"fas fa-running\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22');
INSERT INTO `theme_contents` (`id`, `theme_id`, `section_type`, `content_key`, `content_ar`, `content_en`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(654, 11, 'services', 'service_4', '{\"title_ar\":\"تغذية صحية\",\"title_en\":\"Healthy Nutrition\",\"description_ar\":\"استشارات تغذية متخصصة مع خطط غذائية مخصصة لتحقيق أهدافك\",\"description_en\":\"Specialized nutrition consultations with custom meal plans to achieve your goals\",\"icon\":\"fas fa-apple-alt\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(655, 11, 'testimonials', 'testimonial_1', '{\"client_name\":\"عمر العتيبي\",\"client_title\":\"مهندس\",\"content\":\"خلال 3 أشهر فقط حققت هدفي في خسارة الوزن بفضل المدربين المحترفين هنا.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(656, 11, 'testimonials', 'testimonial_2', '{\"client_name\":\"سارة الغامدي\",\"client_title\":\"محاسبة\",\"content\":\"النادي نظيف جداً والأجهزة حديثة. أنصح الجميع بالاشتراك.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(657, 11, 'contact', 'contact_info', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"الرياض - حي النرجس - شارع أنس بن مالك\"}', '{\"phone\":\"966500000555\",\"whatsapp\":\"966500000555\",\"email\":\"info@fitness-club.com\",\"address\":\"Riyadh - Al Narjis District - Anas bin Malik Road\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(658, 12, 'hero', 'hero_title', 'حقوقك محمية بقوة القانون', 'Your Rights Protected by Law', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(659, 12, 'hero', 'hero_subtitle', 'محامون متخصصون يضعون خبرتهم في خدمة عدالتك', 'Specialized lawyers putting their expertise at the service of your justice', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(660, 12, 'hero', 'hero_description', 'مكتب محاماة متخصص يقدم خدمات قانونية شاملة بأعلى معايير المهنية والسرية. نمتلك فريقاً من المحامين والاستشاريين القانونيين ذوي الخبرة الواسعة في مختلف فروع القانون.', 'A specialized law firm providing comprehensive legal services to the highest professional and confidential standards. We have a team of lawyers and legal consultants with extensive experience in various branches of law.', 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(661, 12, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(662, 12, 'about', 'about_title', 'من نحن', 'About Us', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(663, 12, 'about', 'about_text', 'مكتب محاماة راسخ يقدم خدمات قانونية متميزة منذ أكثر من 20 عاماً. نتعامل مع جميع أنواع القضايا المدنية والتجارية والعقارية والجنائية مع الالتزام بأعلى معايير السرية والأمانة المهنية.', 'An established law firm providing distinguished legal services for over 20 years. We handle all types of civil, commercial, real estate, and criminal cases while maintaining the highest standards of confidentiality and professional ethics.', 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(664, 12, 'services', 'service_1', '{\"title_ar\":\"استشارات قانونية\",\"title_en\":\"Legal Consultations\",\"description_ar\":\"استشارات قانونية متخصصة في جميع المجالات مع تحليل شامل للموقف القانوني\",\"description_en\":\"Specialized legal consultations in all fields with comprehensive legal situation analysis\",\"icon\":\"fas fa-gavel\",\"show_on_home\":1}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(665, 12, 'services', 'service_2', '{\"title_ar\":\"قانون الشركات\",\"title_en\":\"Corporate Law\",\"description_ar\":\"خدمات قانونية للشركات تشمل التأسيس والعقود والتحكيم التجاري\",\"description_en\":\"Legal services for companies including incorporation, contracts, and commercial arbitration\",\"icon\":\"fas fa-briefcase\",\"show_on_home\":1}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(666, 12, 'services', 'service_3', '{\"title_ar\":\"قضايا عقارية\",\"title_en\":\"Real Estate Cases\",\"description_ar\":\"تمثيل قانوني في القضايا العقارية ونزاعات الملكية وصياغة العقود\",\"description_en\":\"Legal representation in real estate cases, property disputes, and contract drafting\",\"icon\":\"fas fa-landmark\",\"show_on_home\":1}', NULL, 3, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(667, 12, 'services', 'service_4', '{\"title_ar\":\"قانون الأسرة\",\"title_en\":\"Family Law\",\"description_ar\":\"معالجة قضايا الأحوال الشخصية والطلاق والحضانة والنفقة\",\"description_en\":\"Handling personal status cases, divorce, custody, and alimony\",\"icon\":\"fas fa-users\",\"show_on_home\":1}', NULL, 4, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(668, 12, 'testimonials', 'testimonial_1', '{\"client_name\":\"ناصر العمري\",\"client_title\":\"رجل أعمال\",\"content\":\"محامون محترفون جداً. ساعدوني في حل نزاع تجاري معقد بنجاح.\",\"rating\":5}', NULL, 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(669, 12, 'testimonials', 'testimonial_2', '{\"client_name\":\"منال السلمي\",\"client_title\":\"سيدة أعمال\",\"content\":\"مكتب محترف ويتميز بالسرية التامة. أنصح أي شخص يحتاج مساعدة قانونية بالتعامل معهم.\",\"rating\":5}', NULL, 2, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22'),
(670, 12, 'contact', 'contact_info', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"الرياض - حي العليا - برج المملكة - الطابق 15\"}', '{\"phone\":\"966500000666\",\"whatsapp\":\"966500000666\",\"email\":\"info@lawfirm.com\",\"address\":\"Riyadh - Olaya District - Kingdom Tower - 15th Floor\"}', 1, 1, '2026-04-11 19:27:22', '2026-04-11 19:27:22');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_media`
--

INSERT INTO `theme_media` (`id`, `theme_id`, `media_type`, `file_path`, `file_name`, `alt_text_ar`, `alt_text_en`, `section_ref`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 5, 'logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'شعار شركة الصيانة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(2, 5, 'banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'بانر خدمات الصيانة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(3, 5, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 1, 1, '2026-04-10 20:03:51'),
(4, 5, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'صيانة السباكة', NULL, 'service_4', 2, 1, '2026-04-10 20:03:51'),
(5, 5, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'خدمات الدهان', NULL, 'service_3', 3, 1, '2026-04-10 20:03:51'),
(6, 4, 'logo', 'logos/decor-logo.png', 'decor-logo.png', 'شعار استوديو الديكور', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(7, 4, 'banner', 'banners/decor-hero.jpg', 'decor-hero.jpg', 'بانر خدمات الديكور', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(8, 4, 'service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'تصميم داخلي', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(9, 4, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'دهانات احترافية', NULL, 'service_3', 2, 1, '2026-04-10 20:03:51'),
(10, 2, 'logo', 'logos/electric-logo.png', 'electric-logo.png', 'شعار شركة الكهرباء', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(11, 2, 'banner', 'banners/electric-hero.jpg', 'electric-hero.jpg', 'بانر خدمات الكهرباء', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(12, 2, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(13, 2, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(14, 6, 'logo', 'logos/plumbing-logo.png', 'plumbing-logo.png', 'شعار شركة السباكة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(15, 6, 'banner', 'banners/plumbing-hero.jpg', 'plumbing-hero.jpg', 'بانر خدمات السباكة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(16, 6, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح السباكة', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(17, 6, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف شامل', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(18, 3, 'logo', 'logos/cleaning-logo.png', 'cleaning-logo.png', 'شعار شركة التنظيف', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(19, 3, 'banner', 'banners/cleaning-hero.jpg', 'cleaning-hero.jpg', 'بانر خدمات التنظيف', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(20, 3, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف عميق', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(21, 3, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'تنظيف المكاتب', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(22, 1, 'logo', 'logos/general-logo.png', 'general-logo.png', 'شعار الشركة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(23, 1, 'banner', 'banners/general-hero.jpg', 'general-hero.jpg', 'بانر الموقع العام', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(24, 1, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'خدمات عامة', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(25, 1, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'استشارات', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(26, 7, 'logo', 'logos/medical-logo.png', 'medical-logo.png', 'شعار العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(27, 7, 'banner', 'banners/medical-hero.jpg', 'medical-hero.jpg', 'بانر العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(28, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'فحص شامل', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(29, 7, 'service_image', 'services/medical-dental.jpg', 'medical-dental.jpg', 'طب الأسنان', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(30, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'استشارات طبية', NULL, 'service_3', 3, 1, '2026-04-10 20:03:51'),
(31, 8, 'logo', 'logos/realestate-logo.png', 'realestate-logo.png', 'شعار شركة العقارات', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(32, 8, 'banner', 'banners/realestate-hero.jpg', 'realestate-hero.jpg', 'بانر العقارات الفاخرة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(33, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'فلل فاخرة', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(34, 8, 'service_image', 'services/realestate-apartment.jpg', 'realestate-apartment.jpg', 'شقق سكنية', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(35, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'إدارة أملاك', NULL, 'service_3', 3, 1, '2026-04-10 20:03:51'),
(36, 9, 'logo', 'logos/restaurant-logo.png', 'restaurant-logo.png', 'شعار المطعم', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(37, 9, 'banner', 'banners/restaurant-hero.jpg', 'restaurant-hero.jpg', 'بانر المطعم الفاخر', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(38, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'عشاء فاخر', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(39, 9, 'service_image', 'services/restaurant-catering.jpg', 'restaurant-catering.jpg', 'تموين مناسبات', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(40, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'توصيل طلبات', NULL, 'service_3', 3, 1, '2026-04-10 20:03:51'),
(41, 10, 'logo', 'logos/education-logo.png', 'education-logo.png', 'شعار الأكاديمية', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(42, 10, 'banner', 'banners/education-hero.jpg', 'education-hero.jpg', 'بانر الأكاديمية التعليمية', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(43, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'دورات حضورية', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(44, 10, 'service_image', 'services/education-online.jpg', 'education-online.jpg', 'تعليم عن بعد', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(45, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'تدريب مهني', NULL, 'service_3', 3, 1, '2026-04-10 20:03:51'),
(46, 11, 'logo', 'logos/fitness-logo.png', 'fitness-logo.png', 'شعار النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(47, 11, 'banner', 'banners/fitness-hero.jpg', 'fitness-hero.jpg', 'بانر النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(48, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'تدريب شخصي', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(49, 11, 'service_image', 'services/fitness-yoga.jpg', 'fitness-yoga.jpg', 'يوجا وبيلاتس', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(50, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'برامج لياقة', NULL, 'service_3', 3, 1, '2026-04-10 20:03:51'),
(51, 12, 'logo', 'logos/legal-logo.png', 'legal-logo.png', 'شعار مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(52, 12, 'banner', 'banners/legal-hero.jpg', 'legal-hero.jpg', 'بانر مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-10 20:03:51'),
(53, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'استشارات قانونية', NULL, 'service_1', 1, 1, '2026-04-10 20:03:51'),
(54, 12, 'service_image', 'services/legal-corporate.jpg', 'legal-corporate.jpg', 'قانون الشركات', NULL, 'service_2', 2, 1, '2026-04-10 20:03:51'),
(55, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'قضايا عقارية', NULL, 'service_3', 3, 1, '2026-04-10 20:03:51'),
(56, 5, 'logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'شعار شركة الصيانة', NULL, 'hero', 1, 1, '2026-04-11 00:56:00'),
(57, 5, 'banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'بانر خدمات الصيانة', NULL, 'hero', 1, 1, '2026-04-11 00:56:00'),
(58, 5, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 1, 1, '2026-04-11 00:56:00'),
(59, 5, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'صيانة السباكة', NULL, 'service_4', 2, 1, '2026-04-11 00:56:00'),
(60, 5, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'خدمات الدهان', NULL, 'service_3', 3, 1, '2026-04-11 00:56:00'),
(61, 4, 'logo', 'logos/decor-logo.png', 'decor-logo.png', 'شعار استوديو الديكور', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(62, 4, 'banner', 'banners/decor-hero.jpg', 'decor-hero.jpg', 'بانر خدمات الديكور', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(63, 4, 'service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'تصميم داخلي', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(64, 4, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'دهانات احترافية', NULL, 'service_3', 2, 1, '2026-04-11 00:56:01'),
(65, 2, 'logo', 'logos/electric-logo.png', 'electric-logo.png', 'شعار شركة الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(66, 2, 'banner', 'banners/electric-hero.jpg', 'electric-hero.jpg', 'بانر خدمات الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(67, 2, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(68, 2, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(69, 6, 'logo', 'logos/plumbing-logo.png', 'plumbing-logo.png', 'شعار شركة السباكة', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(70, 6, 'banner', 'banners/plumbing-hero.jpg', 'plumbing-hero.jpg', 'بانر خدمات السباكة', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(71, 6, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح السباكة', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(72, 6, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف شامل', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(73, 3, 'logo', 'logos/cleaning-logo.png', 'cleaning-logo.png', 'شعار شركة التنظيف', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(74, 3, 'banner', 'banners/cleaning-hero.jpg', 'cleaning-hero.jpg', 'بانر خدمات التنظيف', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(75, 3, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف عميق', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(76, 3, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'تنظيف المكاتب', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(77, 1, 'logo', 'logos/general-logo.png', 'general-logo.png', 'شعار الشركة', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(78, 1, 'banner', 'banners/general-hero.jpg', 'general-hero.jpg', 'بانر الموقع العام', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(79, 1, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'خدمات عامة', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(80, 1, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'استشارات', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(81, 7, 'logo', 'logos/medical-logo.png', 'medical-logo.png', 'شعار العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(82, 7, 'banner', 'banners/medical-hero.jpg', 'medical-hero.jpg', 'بانر العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(83, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'فحص شامل', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(84, 7, 'service_image', 'services/medical-dental.jpg', 'medical-dental.jpg', 'طب الأسنان', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(85, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'استشارات طبية', NULL, 'service_3', 3, 1, '2026-04-11 00:56:01'),
(86, 8, 'logo', 'logos/realestate-logo.png', 'realestate-logo.png', 'شعار شركة العقارات', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(87, 8, 'banner', 'banners/realestate-hero.jpg', 'realestate-hero.jpg', 'بانر العقارات الفاخرة', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(88, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'فلل فاخرة', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(89, 8, 'service_image', 'services/realestate-apartment.jpg', 'realestate-apartment.jpg', 'شقق سكنية', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(90, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'إدارة أملاك', NULL, 'service_3', 3, 1, '2026-04-11 00:56:01'),
(91, 9, 'logo', 'logos/restaurant-logo.png', 'restaurant-logo.png', 'شعار المطعم', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(92, 9, 'banner', 'banners/restaurant-hero.jpg', 'restaurant-hero.jpg', 'بانر المطعم الفاخر', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(93, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'عشاء فاخر', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(94, 9, 'service_image', 'services/restaurant-catering.jpg', 'restaurant-catering.jpg', 'تموين مناسبات', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(95, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'توصيل طلبات', NULL, 'service_3', 3, 1, '2026-04-11 00:56:01'),
(96, 10, 'logo', 'logos/education-logo.png', 'education-logo.png', 'شعار الأكاديمية', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(97, 10, 'banner', 'banners/education-hero.jpg', 'education-hero.jpg', 'بانر الأكاديمية التعليمية', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(98, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'دورات حضورية', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(99, 10, 'service_image', 'services/education-online.jpg', 'education-online.jpg', 'تعليم عن بعد', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(100, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'تدريب مهني', NULL, 'service_3', 3, 1, '2026-04-11 00:56:01'),
(101, 11, 'logo', 'logos/fitness-logo.png', 'fitness-logo.png', 'شعار النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(102, 11, 'banner', 'banners/fitness-hero.jpg', 'fitness-hero.jpg', 'بانر النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(103, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'تدريب شخصي', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(104, 11, 'service_image', 'services/fitness-yoga.jpg', 'fitness-yoga.jpg', 'يوجا وبيلاتس', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(105, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'برامج لياقة', NULL, 'service_3', 3, 1, '2026-04-11 00:56:01'),
(106, 12, 'logo', 'logos/legal-logo.png', 'legal-logo.png', 'شعار مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(107, 12, 'banner', 'banners/legal-hero.jpg', 'legal-hero.jpg', 'بانر مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 00:56:01'),
(108, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'استشارات قانونية', NULL, 'service_1', 1, 1, '2026-04-11 00:56:01'),
(109, 12, 'service_image', 'services/legal-corporate.jpg', 'legal-corporate.jpg', 'قانون الشركات', NULL, 'service_2', 2, 1, '2026-04-11 00:56:01'),
(110, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'قضايا عقارية', NULL, 'service_3', 3, 1, '2026-04-11 00:56:01'),
(111, 1, 'logo', 'logos/general-logo.png', 'general-logo.png', 'شعار الشركة', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(112, 1, 'banner', 'banners/general-hero.jpg', 'general-hero.jpg', 'بانر الموقع العام', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(113, 1, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'خدمات عامة', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(114, 1, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'استشارات', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(115, 2, 'logo', 'logos/electric-logo.png', 'electric-logo.png', 'شعار شركة الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(116, 2, 'banner', 'banners/electric-hero.jpg', 'electric-hero.jpg', 'بانر خدمات الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(117, 2, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(118, 2, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(119, 3, 'logo', 'logos/cleaning-logo.png', 'cleaning-logo.png', 'شعار شركة التنظيف', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(120, 3, 'banner', 'banners/cleaning-hero.jpg', 'cleaning-hero.jpg', 'بانر خدمات التنظيف', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(121, 3, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف عميق', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(122, 3, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'تنظيف المكاتب', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(123, 4, 'logo', 'logos/decor-logo.png', 'decor-logo.png', 'شعار استوديو الديكور', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(124, 4, 'banner', 'banners/decor-hero.jpg', 'decor-hero.jpg', 'بانر خدمات الديكور', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(125, 4, 'service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'تصميم داخلي', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(126, 4, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'دهانات احترافية', NULL, 'service_3', 2, 1, '2026-04-11 05:53:42'),
(127, 5, 'logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'شعار شركة الصيانة', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(128, 5, 'banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'بانر خدمات الصيانة', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(129, 5, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 1, 1, '2026-04-11 05:53:42'),
(130, 5, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'صيانة السباكة', NULL, 'service_4', 2, 1, '2026-04-11 05:53:42'),
(131, 5, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'خدمات الدهان', NULL, 'service_3', 3, 1, '2026-04-11 05:53:42'),
(132, 6, 'logo', 'logos/plumbing-logo.png', 'plumbing-logo.png', 'شعار شركة السباكة', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(133, 6, 'banner', 'banners/plumbing-hero.jpg', 'plumbing-hero.jpg', 'بانر خدمات السباكة', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(134, 6, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح السباكة', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(135, 6, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف شامل', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(136, 7, 'logo', 'logos/medical-logo.png', 'medical-logo.png', 'شعار العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(137, 7, 'banner', 'banners/medical-hero.jpg', 'medical-hero.jpg', 'بانر العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(138, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'فحص شامل', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(139, 7, 'service_image', 'services/medical-dental.jpg', 'medical-dental.jpg', 'طب الأسنان', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(140, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'استشارات طبية', NULL, 'service_3', 3, 1, '2026-04-11 05:53:42'),
(141, 8, 'logo', 'logos/realestate-logo.png', 'realestate-logo.png', 'شعار شركة العقارات', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(142, 8, 'banner', 'banners/realestate-hero.jpg', 'realestate-hero.jpg', 'بانر العقارات الفاخرة', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(143, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'فلل فاخرة', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(144, 8, 'service_image', 'services/realestate-apartment.jpg', 'realestate-apartment.jpg', 'شقق سكنية', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(145, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'إدارة أملاك', NULL, 'service_3', 3, 1, '2026-04-11 05:53:42'),
(146, 9, 'logo', 'logos/restaurant-logo.png', 'restaurant-logo.png', 'شعار المطعم', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(147, 9, 'banner', 'banners/restaurant-hero.jpg', 'restaurant-hero.jpg', 'بانر المطعم الفاخر', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(148, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'عشاء فاخر', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(149, 9, 'service_image', 'services/restaurant-catering.jpg', 'restaurant-catering.jpg', 'تموين مناسبات', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(150, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'توصيل طلبات', NULL, 'service_3', 3, 1, '2026-04-11 05:53:42'),
(151, 10, 'logo', 'logos/education-logo.png', 'education-logo.png', 'شعار الأكاديمية', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(152, 10, 'banner', 'banners/education-hero.jpg', 'education-hero.jpg', 'بانر الأكاديمية التعليمية', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(153, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'دورات حضورية', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(154, 10, 'service_image', 'services/education-online.jpg', 'education-online.jpg', 'تعليم عن بعد', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(155, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'تدريب مهني', NULL, 'service_3', 3, 1, '2026-04-11 05:53:42'),
(156, 11, 'logo', 'logos/fitness-logo.png', 'fitness-logo.png', 'شعار النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(157, 11, 'banner', 'banners/fitness-hero.jpg', 'fitness-hero.jpg', 'بانر النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 05:53:42'),
(158, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'تدريب شخصي', NULL, 'service_1', 1, 1, '2026-04-11 05:53:42'),
(159, 11, 'service_image', 'services/fitness-yoga.jpg', 'fitness-yoga.jpg', 'يوجا وبيلاتس', NULL, 'service_2', 2, 1, '2026-04-11 05:53:42'),
(160, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'برامج لياقة', NULL, 'service_3', 3, 1, '2026-04-11 05:53:42'),
(161, 12, 'logo', 'logos/legal-logo.png', 'legal-logo.png', 'شعار مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 05:53:43'),
(162, 12, 'banner', 'banners/legal-hero.jpg', 'legal-hero.jpg', 'بانر مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 05:53:43'),
(163, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'استشارات قانونية', NULL, 'service_1', 1, 1, '2026-04-11 05:53:43'),
(164, 12, 'service_image', 'services/legal-corporate.jpg', 'legal-corporate.jpg', 'قانون الشركات', NULL, 'service_2', 2, 1, '2026-04-11 05:53:43'),
(165, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'قضايا عقارية', NULL, 'service_3', 3, 1, '2026-04-11 05:53:43'),
(166, 1, 'logo', 'logos/general-logo.png', 'general-logo.png', 'شعار الشركة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(167, 1, 'banner', 'banners/general-hero.jpg', 'general-hero.jpg', 'بانر الموقع العام', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(168, 1, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'خدمات عامة', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(169, 1, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'استشارات', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(170, 2, 'logo', 'logos/electric-logo.png', 'electric-logo.png', 'شعار شركة الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(171, 2, 'banner', 'banners/electric-hero.jpg', 'electric-hero.jpg', 'بانر خدمات الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(172, 2, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(173, 2, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(174, 3, 'logo', 'logos/cleaning-logo.png', 'cleaning-logo.png', 'شعار شركة التنظيف', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(175, 3, 'banner', 'banners/cleaning-hero.jpg', 'cleaning-hero.jpg', 'بانر خدمات التنظيف', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(176, 3, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف عميق', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(177, 3, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'تنظيف المكاتب', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(178, 4, 'logo', 'logos/decor-logo.png', 'decor-logo.png', 'شعار استوديو الديكور', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(179, 4, 'banner', 'banners/decor-hero.jpg', 'decor-hero.jpg', 'بانر خدمات الديكور', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(180, 4, 'service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'تصميم داخلي', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(181, 4, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'دهانات احترافية', NULL, 'service_3', 2, 1, '2026-04-11 07:19:41'),
(182, 5, 'logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'شعار شركة الصيانة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(183, 5, 'banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'بانر خدمات الصيانة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(184, 5, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 1, 1, '2026-04-11 07:19:41'),
(185, 5, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'صيانة السباكة', NULL, 'service_4', 2, 1, '2026-04-11 07:19:41'),
(186, 5, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'خدمات الدهان', NULL, 'service_3', 3, 1, '2026-04-11 07:19:41'),
(187, 6, 'logo', 'logos/plumbing-logo.png', 'plumbing-logo.png', 'شعار شركة السباكة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(188, 6, 'banner', 'banners/plumbing-hero.jpg', 'plumbing-hero.jpg', 'بانر خدمات السباكة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(189, 6, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح السباكة', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(190, 6, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف شامل', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(191, 7, 'logo', 'logos/medical-logo.png', 'medical-logo.png', 'شعار العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(192, 7, 'banner', 'banners/medical-hero.jpg', 'medical-hero.jpg', 'بانر العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(193, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'فحص شامل', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(194, 7, 'service_image', 'services/medical-dental.jpg', 'medical-dental.jpg', 'طب الأسنان', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(195, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'استشارات طبية', NULL, 'service_3', 3, 1, '2026-04-11 07:19:41'),
(196, 8, 'logo', 'logos/realestate-logo.png', 'realestate-logo.png', 'شعار شركة العقارات', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(197, 8, 'banner', 'banners/realestate-hero.jpg', 'realestate-hero.jpg', 'بانر العقارات الفاخرة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(198, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'فلل فاخرة', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(199, 8, 'service_image', 'services/realestate-apartment.jpg', 'realestate-apartment.jpg', 'شقق سكنية', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(200, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'إدارة أملاك', NULL, 'service_3', 3, 1, '2026-04-11 07:19:41'),
(201, 9, 'logo', 'logos/restaurant-logo.png', 'restaurant-logo.png', 'شعار المطعم', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(202, 9, 'banner', 'banners/restaurant-hero.jpg', 'restaurant-hero.jpg', 'بانر المطعم الفاخر', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(203, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'عشاء فاخر', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(204, 9, 'service_image', 'services/restaurant-catering.jpg', 'restaurant-catering.jpg', 'تموين مناسبات', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(205, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'توصيل طلبات', NULL, 'service_3', 3, 1, '2026-04-11 07:19:41'),
(206, 10, 'logo', 'logos/education-logo.png', 'education-logo.png', 'شعار الأكاديمية', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(207, 10, 'banner', 'banners/education-hero.jpg', 'education-hero.jpg', 'بانر الأكاديمية التعليمية', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(208, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'دورات حضورية', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(209, 10, 'service_image', 'services/education-online.jpg', 'education-online.jpg', 'تعليم عن بعد', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(210, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'تدريب مهني', NULL, 'service_3', 3, 1, '2026-04-11 07:19:41'),
(211, 11, 'logo', 'logos/fitness-logo.png', 'fitness-logo.png', 'شعار النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(212, 11, 'banner', 'banners/fitness-hero.jpg', 'fitness-hero.jpg', 'بانر النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(213, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'تدريب شخصي', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(214, 11, 'service_image', 'services/fitness-yoga.jpg', 'fitness-yoga.jpg', 'يوجا وبيلاتس', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(215, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'برامج لياقة', NULL, 'service_3', 3, 1, '2026-04-11 07:19:41'),
(216, 12, 'logo', 'logos/legal-logo.png', 'legal-logo.png', 'شعار مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(217, 12, 'banner', 'banners/legal-hero.jpg', 'legal-hero.jpg', 'بانر مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 07:19:41'),
(218, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'استشارات قانونية', NULL, 'service_1', 1, 1, '2026-04-11 07:19:41'),
(219, 12, 'service_image', 'services/legal-corporate.jpg', 'legal-corporate.jpg', 'قانون الشركات', NULL, 'service_2', 2, 1, '2026-04-11 07:19:41'),
(220, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'قضايا عقارية', NULL, 'service_3', 3, 1, '2026-04-11 07:19:41'),
(221, 1, 'logo', 'logos/general-logo.png', 'general-logo.png', 'شعار الشركة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(222, 1, 'banner', 'banners/general-hero.jpg', 'general-hero.jpg', 'بانر الموقع العام', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(223, 1, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'خدمات عامة', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(224, 1, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'استشارات', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(225, 2, 'logo', 'logos/electric-logo.png', 'electric-logo.png', 'شعار شركة الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(226, 2, 'banner', 'banners/electric-hero.jpg', 'electric-hero.jpg', 'بانر خدمات الكهرباء', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(227, 2, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(228, 2, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(229, 3, 'logo', 'logos/cleaning-logo.png', 'cleaning-logo.png', 'شعار شركة التنظيف', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(230, 3, 'banner', 'banners/cleaning-hero.jpg', 'cleaning-hero.jpg', 'بانر خدمات التنظيف', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(231, 3, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف عميق', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(232, 3, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'تنظيف المكاتب', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(233, 4, 'logo', 'logos/decor-logo.png', 'decor-logo.png', 'شعار استوديو الديكور', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(234, 4, 'banner', 'banners/decor-hero.jpg', 'decor-hero.jpg', 'بانر خدمات الديكور', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(235, 4, 'service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'تصميم داخلي', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(236, 4, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'دهانات احترافية', NULL, 'service_3', 2, 1, '2026-04-11 19:27:22'),
(237, 5, 'logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'شعار شركة الصيانة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(238, 5, 'banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'بانر خدمات الصيانة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(239, 5, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', NULL, 'service_2', 1, 1, '2026-04-11 19:27:22'),
(240, 5, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'صيانة السباكة', NULL, 'service_4', 2, 1, '2026-04-11 19:27:22'),
(241, 5, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'خدمات الدهان', NULL, 'service_3', 3, 1, '2026-04-11 19:27:22'),
(242, 6, 'logo', 'logos/plumbing-logo.png', 'plumbing-logo.png', 'شعار شركة السباكة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(243, 6, 'banner', 'banners/plumbing-hero.jpg', 'plumbing-hero.jpg', 'بانر خدمات السباكة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(244, 6, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح السباكة', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(245, 6, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف شامل', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(246, 7, 'logo', 'logos/medical-logo.png', 'medical-logo.png', 'شعار العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(247, 7, 'banner', 'banners/medical-hero.jpg', 'medical-hero.jpg', 'بانر العيادة الطبية', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(248, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'فحص شامل', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(249, 7, 'service_image', 'services/medical-dental.jpg', 'medical-dental.jpg', 'طب الأسنان', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(250, 7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'استشارات طبية', NULL, 'service_3', 3, 1, '2026-04-11 19:27:22'),
(251, 8, 'logo', 'logos/realestate-logo.png', 'realestate-logo.png', 'شعار شركة العقارات', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(252, 8, 'banner', 'banners/realestate-hero.jpg', 'realestate-hero.jpg', 'بانر العقارات الفاخرة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(253, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'فلل فاخرة', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(254, 8, 'service_image', 'services/realestate-apartment.jpg', 'realestate-apartment.jpg', 'شقق سكنية', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(255, 8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'إدارة أملاك', NULL, 'service_3', 3, 1, '2026-04-11 19:27:22'),
(256, 9, 'logo', 'logos/restaurant-logo.png', 'restaurant-logo.png', 'شعار المطعم', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(257, 9, 'banner', 'banners/restaurant-hero.jpg', 'restaurant-hero.jpg', 'بانر المطعم الفاخر', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(258, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'عشاء فاخر', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(259, 9, 'service_image', 'services/restaurant-catering.jpg', 'restaurant-catering.jpg', 'تموين مناسبات', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(260, 9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'توصيل طلبات', NULL, 'service_3', 3, 1, '2026-04-11 19:27:22'),
(261, 10, 'logo', 'logos/education-logo.png', 'education-logo.png', 'شعار الأكاديمية', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(262, 10, 'banner', 'banners/education-hero.jpg', 'education-hero.jpg', 'بانر الأكاديمية التعليمية', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(263, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'دورات حضورية', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(264, 10, 'service_image', 'services/education-online.jpg', 'education-online.jpg', 'تعليم عن بعد', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(265, 10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'تدريب مهني', NULL, 'service_3', 3, 1, '2026-04-11 19:27:22'),
(266, 11, 'logo', 'logos/fitness-logo.png', 'fitness-logo.png', 'شعار النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(267, 11, 'banner', 'banners/fitness-hero.jpg', 'fitness-hero.jpg', 'بانر النادي الرياضي', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(268, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'تدريب شخصي', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(269, 11, 'service_image', 'services/fitness-yoga.jpg', 'fitness-yoga.jpg', 'يوجا وبيلاتس', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(270, 11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'برامج لياقة', NULL, 'service_3', 3, 1, '2026-04-11 19:27:22'),
(271, 12, 'logo', 'logos/legal-logo.png', 'legal-logo.png', 'شعار مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(272, 12, 'banner', 'banners/legal-hero.jpg', 'legal-hero.jpg', 'بانر مكتب المحاماة', NULL, 'hero', 1, 1, '2026-04-11 19:27:22'),
(273, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'استشارات قانونية', NULL, 'service_1', 1, 1, '2026-04-11 19:27:22'),
(274, 12, 'service_image', 'services/legal-corporate.jpg', 'legal-corporate.jpg', 'قانون الشركات', NULL, 'service_2', 2, 1, '2026-04-11 19:27:22'),
(275, 12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'قضايا عقارية', NULL, 'service_3', 3, 1, '2026-04-11 19:27:22');

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
  `admin_notes` text DEFAULT NULL COMMENT 'ملاحظات الأدمن عند القبول/الرفض',
  `tenant_notes` text DEFAULT NULL COMMENT 'ملاحظات المشترك',
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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `tenant_id`, `font_primary`, `font_secondary`, `font_size_base`, `border_radius`, `header_style`, `footer_style`, `hero_style`, `custom_css`, `custom_js`, `header_logo_height`, `footer_logo_height`, `button_style`, `card_style`, `animation_enabled`, `created_at`, `updated_at`) VALUES
(1, 5, 'Tajawal', 'Tajawal', '16px', '8px', 'default', 'default', 'default', NULL, NULL, '50px', '40px', 'rounded', 'shadow', 1, '2026-03-15 20:20:08', '2026-03-15 20:20:08'),
(2, 6, 'Tajawal', 'Tajawal', '16px', '8', 'default', 'expanded', 'default', '/* Custom styles */\n.hero-title { font-weight: 800; }', NULL, '50px', '40px', 'rounded', 'shadow', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(3, 9, 'Cairo', 'Tajawal', '16px', '12', 'centered', 'minimal', 'default', '/* Elegant styles */\n.card { border-radius: 16px; }', NULL, '50px', '40px', 'rounded', 'shadow', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(4, 7, 'Tajawal', 'Tajawal', '16px', '4', '', 'default', 'default', NULL, NULL, '50px', '40px', 'rounded', 'shadow', 1, '2026-03-16 19:17:17', '2026-03-16 19:17:17');

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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`, `verification_token`, `reset_token`, `reset_token_expires`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin@cms-platform.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدير النظام', NULL, 'admin', 'active', 1, NULL, NULL, NULL, '2026-04-12 20:33:18', '2026-03-14 12:12:42', '2026-04-12 20:33:18'),
(2, 'muthannadarwish20@gmail.com', '$2y$12$.E6sARkmRj.Qab0eFfBv7eKM6BYZE4oFbFEuwpHtIl6fAkJPzlT2W', 'muthanna muthanna', '05345746030', 'customer', 'active', 1, 'a6c22872d270ffbfd431f38257e8425961947176c87dcf97e054f38bec5eb16cfe5c37697e322c6fe6c3d4e65e0d36716debbd51ba5fbc657de3729470d46e2e', NULL, NULL, '2026-04-12 20:34:04', '2026-03-14 21:47:17', '2026-04-12 20:34:04'),
(3, 'ahmed@maintenance-sa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'أحمد الصيانة', '0501234567', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(4, 'mohammed@electric-pro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'محمد الكهربائي', '0502345678', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(5, 'fatima@clean-home.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'فاطمة التنظيف', '0503456789', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(6, 'sara@decor-style.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'سارة الديكور', '0504567890', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(7, 'khalid@plumbing-expert.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'خالد السباك', '0505678901', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17'),
(8, 'omar@general-services.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'عمر الخدمات', '0506789012', 'customer', 'active', 1, NULL, NULL, NULL, NULL, '2026-03-16 19:17:17', '2026-03-16 19:17:17');

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
-- Indexes for table `site_stats`
--
ALTER TABLE `site_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tenant_id` (`tenant_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

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
  ADD UNIQUE KEY `slug` (`slug`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT for table `sections_config`
--
ALTER TABLE `sections_config`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `site_features`
--
ALTER TABLE `site_features`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_stats`
--
ALTER TABLE `site_stats`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `theme_contents`
--
ALTER TABLE `theme_contents`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=671;

--
-- AUTO_INCREMENT for table `theme_media`
--
ALTER TABLE `theme_media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT for table `theme_requests`
--
ALTER TABLE `theme_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
