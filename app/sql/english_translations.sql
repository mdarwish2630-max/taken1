-- =============================================
-- CMS Platform - English Translations Update
-- تحديث الترجمات الإنجليزية
-- =============================================

-- =============================================
-- 1. إضافة حقول الترجمة لجدول services
-- =============================================
ALTER TABLE `services` 
ADD COLUMN `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`,
ADD COLUMN `description_en` TEXT DEFAULT NULL AFTER `description`,
ADD COLUMN `content_en` LONGTEXT DEFAULT NULL AFTER `content`;

-- =============================================
-- 2. إضافة حقول الترجمة لجدول banners
-- =============================================
ALTER TABLE `banners` 
ADD COLUMN `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`,
ADD COLUMN `subtitle_en` VARCHAR(255) DEFAULT NULL AFTER `subtitle`,
ADD COLUMN `description_en` TEXT DEFAULT NULL AFTER `description`;

-- =============================================
-- 3. إضافة حقول الترجمة لجدول gallery
-- =============================================
ALTER TABLE `gallery` 
ADD COLUMN `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`,
ADD COLUMN `description_en` TEXT DEFAULT NULL AFTER `description`;

-- =============================================
-- 4. إضافة حقول الترجمة لجدول testimonials
-- =============================================
ALTER TABLE `testimonials` 
ADD COLUMN `content_en` TEXT DEFAULT NULL AFTER `content`,
ADD COLUMN `client_title_en` VARCHAR(255) DEFAULT NULL AFTER `client_title`;

-- =============================================
-- 5. إضافة حقول الترجمة لجدول pages
-- =============================================
ALTER TABLE `pages` 
ADD COLUMN `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`,
ADD COLUMN `content_en` LONGTEXT DEFAULT NULL AFTER `content`;

-- =============================================
-- 6. تحديث ترجمات الخدمات - موقع الصيانة الذهبية
-- =============================================
UPDATE `services` SET 
    `title_en` = 'AC Maintenance',
    `description_en` = 'Comprehensive maintenance for all types of air conditioners, split and window units'
WHERE `slug` = 'ac-maintenance';

UPDATE `services` SET 
    `title_en` = 'Plumbing Services',
    `description_en` = 'Leak repairs, bathroom fixtures, water pipe installations'
WHERE `slug` = 'plumbing';

UPDATE `services` SET 
    `title_en` = 'Electrical Services',
    `description_en` = 'Electrical wiring, fault repairs, lighting installation'
WHERE `slug` = 'electricity';

UPDATE `services` SET 
    `title_en` = 'Appliance Repair',
    `description_en` = 'Repair of washing machines, refrigerators, ovens'
WHERE `slug` = 'appliances';

-- =============================================
-- 7. تحديث ترجمات الخدمات - موقع محترفو الكهرباء
-- =============================================
UPDATE `services` SET 
    `title_en` = 'Electrical Wiring',
    `description_en` = 'New electrical wiring for homes and offices'
WHERE `slug` = 'wiring';

UPDATE `services` SET 
    `title_en` = 'Fault Repairs',
    `description_en` = 'Professional repair of all electrical faults'
WHERE `slug` = 'repairs';

UPDATE `services` SET 
    `title_en` = 'LED Lighting',
    `description_en` = 'Indoor and outdoor LED lighting installation'
WHERE `slug` = 'led-lighting';

UPDATE `services` SET 
    `title_en` = '24/7 Emergency',
    `description_en` = 'Round-the-clock emergency service'
WHERE `slug` = 'emergency';

-- =============================================
-- 8. تحديث ترجمات الخدمات - موقع بيت نظيف
-- =============================================
UPDATE `services` SET 
    `title_en` = 'Villa Cleaning',
    `description_en` = 'Comprehensive cleaning for villas and palaces'
WHERE `slug` = 'villa-cleaning';

UPDATE `services` SET 
    `title_en` = 'Apartment Cleaning',
    `description_en` = 'Complete apartment cleaning services'
WHERE `slug` = 'apartment-cleaning';

UPDATE `services` SET 
    `title_en` = 'Carpet & Rug Cleaning',
    `description_en` = 'Professional carpet and rug washing'
WHERE `slug` = 'carpet-cleaning';

UPDATE `services` SET 
    `title_en` = 'Office Cleaning',
    `description_en` = 'Corporate and office cleaning services'
WHERE `slug` = 'office-cleaning';

-- =============================================
-- 9. تحديث ترجمات الخدمات - موقع أناقة الديكور
-- =============================================
UPDATE `services` SET 
    `title_en` = 'Interior Design',
    `description_en` = 'Modern and luxurious interior designs'
WHERE `slug` = 'interior-design';

UPDATE `services` SET 
    `title_en` = 'Villa Finishing',
    `description_en` = 'Premium villa finishing works'
WHERE `slug` = 'villa-finishing';

UPDATE `services` SET 
    `title_en` = 'Bedroom Decor',
    `description_en` = 'Elegant bedroom design and execution'
WHERE `slug` = 'bedroom-decor';

UPDATE `services` SET 
    `title_en` = 'Kitchen Decor',
    `description_en` = 'Modern kitchen design and installation'
WHERE `slug` = 'kitchen-decor';

-- =============================================
-- 10. تحديث ترجمات الخدمات - موقع خبير السباكة
-- =============================================
UPDATE `services` SET 
    `title_en` = 'Leak Detection',
    `description_en` = 'Advanced leak detection using latest equipment'
WHERE `slug` = 'leak-detection';

UPDATE `services` SET 
    `title_en` = 'Sanitary Installation',
    `description_en` = 'Professional installation of all sanitary fixtures'
WHERE `slug` = 'sanitary-installation';

UPDATE `services` SET 
    `title_en` = 'Drain Cleaning',
    `description_en` = 'Professional drain cleaning and unclogging'
WHERE `slug` = 'drainage';

-- =============================================
-- 11. تحديث ترجمات الخدمات - موقع خدمات الأمان
-- =============================================
UPDATE `services` SET 
    `title_en` = 'Moving Services',
    `description_en` = 'Safe furniture moving and relocation'
WHERE `slug` = 'moving';

UPDATE `services` SET 
    `title_en` = 'Pest Control',
    `description_en` = 'Professional pest control for all insects'
WHERE `slug` = 'pest-control';

UPDATE `services` SET 
    `title_en` = 'Roof Insulation',
    `description_en` = 'Water and thermal roof insulation'
WHERE `slug` = 'roof-insulation';

-- =============================================
-- 12. تحديث ترجمات البنرات
-- =============================================
UPDATE `banners` SET 
    `title_en` = 'Professional Home Maintenance Services',
    `subtitle_en` = 'We provide the best maintenance services for your home with guaranteed quality and competitive prices'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'golden-maintenance');

UPDATE `banners` SET 
    `title_en` = 'Expert Electrical Solutions',
    `subtitle_en` = 'Licensed electricians with years of experience for all your electrical needs'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'electric-pro');

UPDATE `banners` SET 
    `title_en` = 'Sparkling Clean Spaces',
    `subtitle_en` = 'Professional cleaning services for homes and offices. We make your spaces shine!'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'clean-home');

UPDATE `banners` SET 
    `title_en` = 'Creating Beautiful Spaces',
    `subtitle_en` = 'Transform your space into a masterpiece with our expert interior design services'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'decor-style');

UPDATE `banners` SET 
    `title_en` = 'Expert Plumbing Solutions',
    `subtitle_en` = 'Professional plumbing services for your home and business. Fast, reliable, and affordable.'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'plumbing-expert');

UPDATE `banners` SET 
    `title_en` = 'Professional Home Services You Can Trust',
    `subtitle_en` = 'Quality work, affordable prices for all your home service needs'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'aman-services');

-- =============================================
-- 13. تحديث ترجمات آراء العملاء
-- =============================================
UPDATE `testimonials` SET 
    `content_en` = 'Excellent service! The team was professional and completed the work quickly. I highly recommend them.'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'golden-maintenance') LIMIT 1;

UPDATE `testimonials` SET 
    `content_en` = 'Great experience with this company. Fair prices and high quality work.'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'electric-pro') LIMIT 1;

UPDATE `testimonials` SET 
    `content_en` = 'The cleaning service was amazing. My house looks brand new!'
WHERE `tenant_id` = (SELECT id FROM tenants WHERE slug = 'clean-home') LIMIT 1;

-- =============================================
-- 14. تحديث ترجمات معرض الأعمال
-- =============================================
UPDATE `gallery` SET 
    `title_en` = 'AC Maintenance Project'
WHERE `title` LIKE '%مكيف%' OR `title` LIKE '%تكييف%';

UPDATE `gallery` SET 
    `title_en` = 'Electrical Work'
WHERE `title` LIKE '%كهرب%' OR `title` LIKE '%تمديد%';

UPDATE `gallery` SET 
    `title_en` = 'Cleaning Project'
WHERE `title` LIKE '%تنظيف%' OR `title` LIKE '%نظاف%';

UPDATE `gallery` SET 
    `title_en` = 'Interior Design Project'
WHERE `title` LIKE '%ديكور%' OR `title` LIKE '%تصميم%';

UPDATE `gallery` SET 
    `title_en` = 'Plumbing Work'
WHERE `title` LIKE '%سباك%' OR `title` LIKE '%مياه%';

-- =============================================
-- 15. تحديث معلومات المواقع الأساسية
-- =============================================
UPDATE `tenants` SET 
    `meta_description` = 'Professional home maintenance services. AC repair, plumbing, electrical work, and appliance repair with guaranteed quality.'
WHERE `slug` = 'golden-maintenance';

UPDATE `tenants` SET 
    `meta_description` = 'Expert electrical services. Wiring, fault repairs, LED lighting, and 24/7 emergency service by licensed electricians.'
WHERE `slug` = 'electric-pro';

UPDATE `tenants` SET 
    `meta_description` = 'Professional cleaning services for homes and offices. Villa cleaning, apartment cleaning, carpet cleaning, and office cleaning.'
WHERE `slug` = 'clean-home';

UPDATE `tenants` SET 
    `meta_description` = 'Premium interior design and decoration services. Villa finishing, bedroom decor, and kitchen design.'
WHERE `slug` = 'decor-style';

UPDATE `tenants` SET 
    `meta_description` = 'Professional plumbing services. Leak detection, sanitary installation, and drain cleaning by expert plumbers.'
WHERE `slug` = 'plumbing-expert';

UPDATE `tenants` SET 
    `meta_description` = 'Comprehensive home services. Moving, pest control, and roof insulation with quality guarantee.'
WHERE `slug` = 'aman-services';

SELECT 'تم إضافة الترجمات الإنجليزية بنجاح!' as message;
