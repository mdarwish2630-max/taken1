-- ============================================================
-- TakPro Theme SQL - تثبيت ثيم تك برو
-- Run this file after the main database.sql
-- ============================================================

-- 1. إضافة الثيم إلى جدول themes
INSERT INTO `themes` (
    `name`, `name_en`, `slug`, `description`, `description_en`,
    `category`, `preview_image`, `is_active`, `is_premium`, `is_paid`,
    `price`, `currency`, `sort_order`, `version`, `created_at`
) VALUES (
    'تك برو',
    'TakPro',
    'takpro',
    'ثيم احترافي بألوان برتقالية دافئة، مصمم لقطاع الخدمات مع تصميم عصري وجذاب يدعم ثنائية اللغة والتصميم المتجاوب.',
    'A professional theme with warm orange colors, designed for the services sector with a modern and attractive responsive design with bilingual support.',
    'general',
    'themes/takpro/preview.png',
    1,
    0,
    0,
    0.00,
    'SAR',
    0,
    '1.0.0',
    NOW()
);

-- الحصول على معرف الثيم المُدخل
SET @takpro_theme_id = LAST_INSERT_ID();

-- 2. إضافة محتوى تجريبي للثيم (theme_contents)
INSERT INTO `theme_contents` (`theme_id`, `section_type`, `content_key`, `content_ar`, `content_en`, `sort_order`, `is_active`) VALUES

-- Hero Section
(@takpro_theme_id, 'hero', 'hero_title', 'خلّي بيتك يلمع كل يوم', 'Make Your Home Shine Every Day', 1, 1),
(@takpro_theme_id, 'hero', 'hero_subtitle', 'أكثر من 5000 عميل يثق بنا', 'Trusted by over 5,000 clients', 2, 1),
(@takpro_theme_id, 'hero', 'hero_description', 'خدمات تنظيف سريعة وموثوقة للمنازل والشركات بأعلى جودة وأسعار مناسبة.', 'Fast and reliable cleaning services for homes and companies with the highest quality and reasonable prices.', 3, 1),
(@takpro_theme_id, 'hero', 'hero_button_text', 'ابدأ الآن', 'Start Now', 4, 1),

-- About Section
(@takpro_theme_id, 'about', 'about_title', 'خدمات احترافية نقدمها لعملائنا', 'Professional Services We Provide to Our Clients', 1, 1),
(@takpro_theme_id, 'about', 'about_description', 'نقدم حلول تنظيف متكاملة للمنازل والمكاتب والسجاد والمرافق التجارية. فريقنا مدرب، موادنا آمنة، وخدمتنا سريعة ومتاحة على مدار الأسبوع.', 'We provide integrated cleaning solutions for homes, offices, carpets, and commercial facilities. Our team is trained, our materials are safe, and our service is fast and available throughout the week.', 2, 1),

-- Why Us Section
(@takpro_theme_id, 'features', 'feature_1_title', 'أسعار مناسبة', 'Affordable Prices', 1, 1),
(@takpro_theme_id, 'features', 'feature_1_description', 'أسعار تنافسية تناسب الجميع', 'Competitive prices for everyone', 2, 1),
(@takpro_theme_id, 'features', 'feature_2_title', 'خدمة في نفس اليوم', 'Same-Day Service', 3, 1),
(@takpro_theme_id, 'features', 'feature_2_description', 'استجابة سريعة خلال ساعات', 'Fast response within hours', 4, 1),
(@takpro_theme_id, 'features', 'feature_3_title', 'مواد آمنة', 'Safe Materials', 5, 1),
(@takpro_theme_id, 'features', 'feature_3_description', 'منتجات صديقة للبيئة', 'Eco-friendly products', 6, 1),
(@takpro_theme_id, 'features', 'feature_4_title', 'فريق محترف', 'Expert Team', 7, 1),
(@takpro_theme_id, 'features', 'feature_4_description', 'فنيون معتمدون ومدربون', 'Certified & trained technicians', 8, 1),
(@takpro_theme_id, 'features', 'feature_5_title', 'نتائج مضمونة', 'Guaranteed Results', 9, 1),
(@takpro_theme_id, 'features', 'feature_5_description', 'جودة عالية مع ضمان الخدمة', 'High quality with service guarantee', 10, 1),

-- Pricing Section
(@takpro_theme_id, 'pricing', 'pricing_title', 'أسعار واضحة', 'Transparent Prices', 1, 1),
(@takpro_theme_id, 'pricing', 'pricing_description', 'نحدد السعر بوضوح حسب نوع الخدمة والمساحة، ونلتزم بالجودة والوقت المتفق عليه.', 'We set the price clearly based on service type and area, and we are committed to quality and the agreed time.', 2, 1),

-- Stats
(@takpro_theme_id, 'stats', 'stat_1_value', '8000+', '', 1, 1),
(@takpro_theme_id, 'stats', 'stat_1_label', 'عميل سعيد', 'Happy Clients', 2, 1),
(@takpro_theme_id, 'stats', 'stat_2_value', '5000+', '', 3, 1),
(@takpro_theme_id, 'stats', 'stat_2_label', 'مشروع منجز', 'Projects Done', 4, 1),
(@takpro_theme_id, 'stats', 'stat_3_value', '98%', '', 5, 1),
(@takpro_theme_id, 'stats', 'stat_3_label', 'نسبة الرضا', 'Satisfaction Rate', 6, 1);

-- 3. إضافة وسائط تجريبية للثيم (theme_media)
INSERT INTO `theme_media` (`theme_id`, `media_type`, `file_path`, `file_name`, `alt_text_ar`, `alt_text_en`, `section_ref`, `sort_order`, `is_active`) VALUES
(@takpro_theme_id, 'banner', 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1800&auto=format&fit=crop', 'hero-bg.jpg', 'صورة الهيرو الرئيسية', 'Main hero background', 'hero', 1, 1),
(@takpro_theme_id, 'service_image', 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop', 'service-1.jpg', 'الدعم التقني', 'Technical Support', 'service_1', 1, 1),
(@takpro_theme_id, 'service_image', 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=900&auto=format&fit=crop', 'service-2.jpg', 'حلول الشبكات', 'Network Solutions', 'service_2', 2, 1),
(@takpro_theme_id, 'service_image', 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=900&auto=format&fit=crop', 'service-3.jpg', 'صيانة الأنظمة', 'System Maintenance', 'service_3', 3, 1),
(@takpro_theme_id, 'service_image', 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=900&auto=format&fit=crop', 'service-4.jpg', 'تعقيم كامل', 'Full Sanitization', 'service_4', 4, 1),
(@takpro_theme_id, 'service_image', 'https://images.unsplash.com/photo-1528744598421-b7b93e12df54?q=80&w=900&auto=format&fit=crop', 'service-5.jpg', 'تنظيف الزجاج', 'Glass Cleaning', 'service_5', 5, 1),
(@takpro_theme_id, 'service_image', 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=900&auto=format&fit=crop', 'service-6.jpg', 'تنظيف بعد البناء', 'Post-Construction', 'service_6', 6, 1),
(@takpro_theme_id, 'gallery', 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=900&auto=format&fit=crop', 'gallery-1.jpg', 'معرض الصور 1', 'Gallery 1', 'gallery', 1, 1),
(@takpro_theme_id, 'gallery', 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=900&auto=format&fit=crop', 'gallery-2.jpg', 'معرض الصور 2', 'Gallery 2', 'gallery', 2, 1);
