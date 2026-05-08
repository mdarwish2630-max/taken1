-- =============================================
-- CMS Platform - Bilingual Demo Data
-- بيانات تجريبية ثنائية اللغة
-- شغل هذا الملف بعد database.sql
-- =============================================

-- =============================================
-- 1. إضافة حقول الترجمة (إذا لم تكن موجودة)
-- =============================================

-- خدمات
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `description_en` TEXT DEFAULT NULL AFTER `description`;
ALTER TABLE `services` ADD COLUMN IF NOT EXISTS `content_en` LONGTEXT DEFAULT NULL AFTER `content`;

-- البنرات
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `banners` ADD COLUMN IF NOT EXISTS `subtitle_en` VARCHAR(255) DEFAULT NULL AFTER `subtitle`;

-- المعرض
ALTER TABLE `gallery` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;

-- آراء العملاء
ALTER TABLE `testimonials` ADD COLUMN IF NOT EXISTS `content_en` TEXT DEFAULT NULL AFTER `content`;
ALTER TABLE `testimonials` ADD COLUMN IF NOT EXISTS `client_title_en` VARCHAR(255) DEFAULT NULL AFTER `client_title`;

-- الصفحات
ALTER TABLE `pages` ADD COLUMN IF NOT EXISTS `title_en` VARCHAR(255) DEFAULT NULL AFTER `title`;
ALTER TABLE `pages` ADD COLUMN IF NOT EXISTS `content_en` LONGTEXT DEFAULT NULL AFTER `content`;


-- =============================================
-- 2. بيانات ثنائية اللغة للخدمات
-- =============================================

-- خدمات موقع الصيانة الذهبية
UPDATE services SET 
    title_en = 'AC Maintenance',
    description_en = 'Comprehensive maintenance for all types of air conditioners, split and window units'
WHERE slug = 'ac-maintenance' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Home Plumbing',
    description_en = 'Leak repairs, bathroom fixtures, water pipe installations'
WHERE slug = 'plumbing' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Home Electrical',
    description_en = 'Electrical wiring, fault repairs, lighting installation'
WHERE slug = 'electricity' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Appliance Repair',
    description_en = 'Repair of washing machines, refrigerators, ovens'
WHERE slug = 'appliances' AND title_en IS NULL;

-- خدمات موقع محترفو الكهرباء  
UPDATE services SET 
    title_en = 'Electrical Wiring',
    description_en = 'New electrical wiring for homes and offices'
WHERE slug = 'wiring' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Fault Repairs',
    description_en = 'Professional repair of all electrical faults'
WHERE slug = 'repairs' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'LED Lighting',
    description_en = 'Indoor and outdoor LED lighting installation'
WHERE slug = 'led-lighting' AND title_en IS NULL;

UPDATE services SET 
    title_en = '24/7 Emergency',
    description_en = 'Round-the-clock emergency service'
WHERE slug = 'emergency' AND title_en IS NULL;

-- خدمات موقع بيت نظيف
UPDATE services SET 
    title_en = 'Villa Cleaning',
    description_en = 'Comprehensive cleaning for villas and palaces'
WHERE slug = 'villa-cleaning' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Apartment Cleaning',
    description_en = 'Complete apartment cleaning services'
WHERE slug = 'apartment-cleaning' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Carpet & Rug Cleaning',
    description_en = 'Professional carpet and rug washing'
WHERE slug = 'carpet-cleaning' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Office Cleaning',
    description_en = 'Corporate and office cleaning services'
WHERE slug = 'office-cleaning' AND title_en IS NULL;

-- خدمات موقع أناقة الديكور
UPDATE services SET 
    title_en = 'Interior Design',
    description_en = 'Modern and luxurious interior designs'
WHERE slug = 'interior-design' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Villa Finishing',
    description_en = 'Premium villa finishing works'
WHERE slug = 'villa-finishing' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Bedroom Decor',
    description_en = 'Elegant bedroom design and execution'
WHERE slug = 'bedroom-decor' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Kitchen Decor',
    description_en = 'Modern kitchen design and installation'
WHERE slug = 'kitchen-decor' AND title_en IS NULL;

-- خدمات موقع خبير السباكة
UPDATE services SET 
    title_en = 'Leak Detection',
    description_en = 'Advanced leak detection using latest equipment'
WHERE slug = 'leak-detection' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Sanitary Installation',
    description_en = 'Professional installation of all sanitary fixtures'
WHERE slug = 'sanitary-installation' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Drain Cleaning',
    description_en = 'Professional drain cleaning and unclogging'
WHERE slug = 'drainage' AND title_en IS NULL;

-- خدمات موقع خدمات الأمان
UPDATE services SET 
    title_en = 'Moving Services',
    description_en = 'Safe furniture moving and relocation'
WHERE slug = 'moving' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Pest Control',
    description_en = 'Professional pest control for all insects'
WHERE slug = 'pest-control' AND title_en IS NULL;

UPDATE services SET 
    title_en = 'Roof Insulation',
    description_en = 'Water and thermal roof insulation'
WHERE slug = 'roof-insulation' AND title_en IS NULL;


-- =============================================
-- 3. بيانات ثنائية اللغة للبنرات
-- =============================================

UPDATE banners SET 
    title_en = 'Professional Home Maintenance Services',
    subtitle_en = 'We provide the best maintenance services for your home with guaranteed quality'
WHERE tenant_id IN (SELECT id FROM tenants WHERE slug = 'golden-maintenance') AND title_en IS NULL;

UPDATE banners SET 
    title_en = 'Expert Electrical Solutions',
    subtitle_en = 'Licensed electricians with years of experience'
WHERE tenant_id IN (SELECT id FROM tenants WHERE slug = 'electric-pro') AND title_en IS NULL;

UPDATE banners SET 
    title_en = 'Sparkling Clean Spaces',
    subtitle_en = 'Professional cleaning services for homes and offices'
WHERE tenant_id IN (SELECT id FROM tenants WHERE slug = 'clean-home') AND title_en IS NULL;

UPDATE banners SET 
    title_en = 'Creating Beautiful Spaces',
    subtitle_en = 'Transform your space with expert interior design'
WHERE tenant_id IN (SELECT id FROM tenants WHERE slug = 'decor-style') AND title_en IS NULL;

UPDATE banners SET 
    title_en = 'Expert Plumbing Solutions',
    subtitle_en = 'Professional plumbing services with fast response'
WHERE tenant_id IN (SELECT id FROM tenants WHERE slug = 'plumbing-expert') AND title_en IS NULL;

UPDATE banners SET 
    title_en = 'Professional Home Services',
    subtitle_en = 'Quality work, affordable prices for all your needs'
WHERE tenant_id IN (SELECT id FROM tenants WHERE slug = 'aman-services') AND title_en IS NULL;


-- =============================================
-- 4. بيانات ثنائية اللغة لآراء العملاء
-- =============================================

UPDATE testimonials SET 
    content_en = 'Excellent service! The team was professional and completed the work quickly. Highly recommended!',
    client_title_en = 'Homeowner'
WHERE content_en IS NULL LIMIT 10;


-- =============================================
-- 5. بيانات ثنائية اللغة لمعرض الأعمال
-- =============================================

UPDATE gallery SET 
    title_en = 'Before and After'
WHERE title LIKE '%قبل%' AND title_en IS NULL;

UPDATE gallery SET 
    title_en = 'AC Maintenance'
WHERE title LIKE '%مكيف%' AND title_en IS NULL;

UPDATE gallery SET 
    title_en = 'Electrical Work'
WHERE title LIKE '%كهرب%' AND title_en IS NULL;

UPDATE gallery SET 
    title_en = 'Cleaning Project'
WHERE title LIKE '%تنظيف%' AND title_en IS NULL;

UPDATE gallery SET 
    title_en = 'Interior Design'
WHERE title LIKE '%ديكور%' AND title_en IS NULL;

UPDATE gallery SET 
    title_en = 'Plumbing Work'
WHERE title LIKE '%سباك%' AND title_en IS NULL;


SELECT 'تم تحديث الترجمات بنجاح!' as message;
