-- =============================================
-- CMS Platform - Safe English Translations Update
-- تحديث الترجمات الإنجليزية (آمن)
-- =============================================

-- =============================================
-- تحديث الخدمات بالترجمات الإنجليزية
-- =============================================

UPDATE `services` SET 
    `title_en` = 'AC Maintenance',
    `description_en` = 'Comprehensive maintenance for all types of air conditioners, split and window units. Professional cleaning, refrigerant refill, and filter replacement.'
WHERE `title` = 'صيانة المكيفات';

UPDATE `services` SET 
    `title_en` = 'Home Plumbing',
    `description_en` = 'Professional leak repairs, bathroom fixtures installation, and water pipe installations. Fast and reliable service.'
WHERE `title` = 'سباكة منزلية';

UPDATE `services` SET 
    `title_en` = 'Home Electrical',
    `description_en` = 'Electrical wiring, fault repairs, and lighting installation by certified electricians.'
WHERE `title` = 'كهرباء منزلية';

UPDATE `services` SET 
    `title_en` = 'Appliance Repair',
    `description_en` = 'Professional repair of washing machines, refrigerators, ovens, and water heaters.'
WHERE `title` = 'صيانة الأجهزة';

UPDATE `services` SET 
    `title_en` = 'Electrical Wiring',
    `description_en` = 'New electrical wiring for homes and offices with high-quality standards.'
WHERE `title` = 'تمديدات كهربائية';

UPDATE `services` SET 
    `title_en` = 'Fault Repairs',
    `description_en` = 'Professional repair of all electrical faults quickly and safely.'
WHERE `title` = 'إصلاح أعطال';

UPDATE `services` SET 
    `title_en` = 'LED Lighting',
    `description_en` = 'Indoor and outdoor LED lighting installation for modern spaces.'
WHERE `title` = 'إضاءة LED';

UPDATE `services` SET 
    `title_en` = '24/7 Emergency',
    `description_en` = 'Round-the-clock emergency electrical service. Fast response guaranteed.'
WHERE `title` = 'طوارئ 24 ساعة';

UPDATE `services` SET 
    `title_en` = 'Villa Cleaning',
    `description_en` = 'Comprehensive cleaning for villas and palaces. Deep cleaning and sanitization.'
WHERE `title` = 'تنظيف فلل';

UPDATE `services` SET 
    `title_en` = 'Apartment Cleaning',
    `description_en` = 'Complete apartment cleaning services. Fast and thorough.'
WHERE `title` = 'تنظيف شقق';

UPDATE `services` SET 
    `title_en` = 'Carpet & Rug Cleaning',
    `description_en` = 'Professional carpet and rug washing with steam cleaning technology.'
WHERE `title` = 'تنظيف موكيت وسجاد';

UPDATE `services` SET 
    `title_en` = 'Office Cleaning',
    `description_en` = 'Corporate and office cleaning services with flexible schedules.'
WHERE `title` = 'تنظيف مكاتب';

UPDATE `services` SET 
    `title_en` = 'Interior Design',
    `description_en` = 'Modern and luxurious interior designs with 3D visualization.'
WHERE `title` = 'تصميم داخلي';

UPDATE `services` SET 
    `title_en` = 'Villa Finishing',
    `description_en` = 'Premium villa finishing works with high-quality materials.'
WHERE `title` = 'تشطيب فلل';

UPDATE `services` SET 
    `title_en` = 'Bedroom Decor',
    `description_en` = 'Elegant bedroom design and execution for comfort and style.'
WHERE `title` = 'ديكور غرف نوم';

UPDATE `services` SET 
    `title_en` = 'Kitchen Decor',
    `description_en` = 'Modern kitchen design and installation with premium materials.'
WHERE `title` = 'ديكور مطابخ';

UPDATE `services` SET 
    `title_en` = 'Leak Detection',
    `description_en` = 'Advanced leak detection using latest thermal and camera equipment.'
WHERE `title` = 'كشف تسربات';

UPDATE `services` SET 
    `title_en` = 'Sanitary Installation',
    `description_en` = 'Professional installation of all sanitary fixtures and water heaters.'
WHERE `title` = 'تركيب صحية';

UPDATE `services` SET 
    `title_en` = 'Drain Cleaning',
    `description_en` = 'Professional drain cleaning and unclogging with guaranteed results.'
WHERE `title` = 'تسليك مجاري';

UPDATE `services` SET 
    `title_en` = 'Moving Services',
    `description_en` = 'Safe furniture moving and relocation with professional packing.'
WHERE `title` = 'نقل عفش';

UPDATE `services` SET 
    `title_en` = 'Pest Control',
    `description_en` = 'Professional pest control for all insects. Safe and effective.'
WHERE `title` = 'مكافحة حشرات';

UPDATE `services` SET 
    `title_en` = 'Roof Insulation',
    `description_en` = 'Water and thermal roof insulation with 10-year warranty.'
WHERE `title` = 'عزل أسطح';

-- =============================================
-- تحديث البنرات بالترجمات الإنجليزية
-- =============================================

UPDATE `banners` SET 
    `title_en` = 'Professional Home Maintenance Services',
    `subtitle_en` = 'We provide the best maintenance services for your home with guaranteed quality and competitive prices. Fast response and professional work.'
WHERE `title` LIKE '%صيانة%' OR `title` LIKE '%منزلية%';

UPDATE `banners` SET 
    `title_en` = 'Expert Electrical Solutions',
    `subtitle_en` = 'Licensed electricians with years of experience. 24/7 emergency service available.'
WHERE `title` LIKE '%كهرب%' OR `title` LIKE '%تمديدات%';

UPDATE `banners` SET 
    `title_en` = 'Sparkling Clean Spaces',
    `subtitle_en` = 'Professional cleaning services for homes and offices. We make your spaces shine!'
WHERE `title` LIKE '%تنظيف%' OR `title` LIKE '%نظاف%';

UPDATE `banners` SET 
    `title_en` = 'Creating Beautiful Spaces',
    `subtitle_en` = 'Transform your space into a masterpiece with our expert interior design services.'
WHERE `title` LIKE '%ديكور%' OR `title` LIKE '%تصميم%';

UPDATE `banners` SET 
    `title_en` = 'Expert Plumbing Solutions',
    `subtitle_en` = 'Professional plumbing services for your home and business. Fast, reliable, and affordable.'
WHERE `title` LIKE '%سباك%' OR `title` LIKE '%مياه%';

UPDATE `banners` SET 
    `title_en` = 'Professional Home Services',
    `subtitle_en` = 'Quality work, affordable prices for all your home service needs.'
WHERE `title` LIKE '%خدمات%' OR `title` LIKE '%عامة%';

-- =============================================
-- تحديث آراء العملاء بالترجمات الإنجليزية
-- =============================================

UPDATE `testimonials` SET 
    `content_en` = 'Excellent service! The team was professional and completed the work quickly. Highly recommend them.',
    `client_title_en` = 'Homeowner'
WHERE `content` IS NOT NULL AND (`content` LIKE '%ممتاز%' OR `content` LIKE '%خدمة%');

UPDATE `testimonials` SET 
    `content_en` = 'Great experience with this company. Fair prices and high quality work.',
    `client_title_en` = 'Business Owner'
WHERE `content` IS NOT NULL AND (`content` LIKE '%رائع%' OR `content` LIKE '%تجربة%');

UPDATE `testimonials` SET 
    `content_en` = 'The cleaning service was amazing. My house looks brand new!',
    `client_title_en` = 'Happy Customer'
WHERE `content` IS NOT NULL AND (`content` LIKE '%نظاف%' OR `content` LIKE '%منزل%');

-- تحديث بقية آراء العملاء
UPDATE `testimonials` SET 
    `content_en` = 'Very professional team. They arrived on time and did an excellent job.',
    `client_title_en` = 'Satisfied Customer'
WHERE `content_en` IS NULL AND `content` IS NOT NULL;

-- =============================================
-- تحديث معرض الأعمال بالترجمات الإنجليزية
-- =============================================

UPDATE `gallery` SET `title_en` = 'AC Maintenance Project' WHERE `title` LIKE '%مكيف%';
UPDATE `gallery` SET `title_en` = 'Electrical Work' WHERE `title` LIKE '%كهرب%';
UPDATE `gallery` SET `title_en` = 'Cleaning Project' WHERE `title` LIKE '%تنظيف%';
UPDATE `gallery` SET `title_en` = 'Interior Design Project' WHERE `title` LIKE '%ديكور%';
UPDATE `gallery` SET `title_en` = 'Plumbing Work' WHERE `title` LIKE '%سباك%';
UPDATE `gallery` SET `title_en` = 'Before & After' WHERE `title` LIKE '%قبل%';

-- تحديث بقية المعرض
UPDATE `gallery` SET `title_en` = 'Project Photo' WHERE `title_en` IS NULL;

-- =============================================
-- تحديث الصفحات بالترجمات الإنجليزية
-- =============================================

UPDATE `pages` SET 
    `title_en` = 'About Us',
    `content_en` = 'We are a professional team dedicated to providing high-quality services. With years of experience, we ensure customer satisfaction and deliver exceptional results.'
WHERE `title` = 'من نحن' OR `title` LIKE '%من نحن%';

UPDATE `pages` SET 
    `title_en` = 'Contact Us',
    `content_en` = 'Get in touch with us for any inquiries or to request our services. We are available 24/7 to serve you.'
WHERE `title` = 'تواصل معنا' OR `title` LIKE '%تواصل%';

UPDATE `pages` SET 
    `title_en` = 'Our Services',
    `content_en` = 'We offer a wide range of professional services to meet all your needs. Quality work guaranteed.'
WHERE `title` = 'خدماتنا' OR `title` LIKE '%خدماتنا%';

SELECT 'تم تحديث جميع الترجمات الإنجليزية بنجاح!' as message;
