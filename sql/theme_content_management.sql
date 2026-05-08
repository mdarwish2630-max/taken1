-- ============================================
-- نظام إدارة محتوى القوالب (Theme Content Management)
-- يتيح للأدمن تعديل محتوى كل ثيم (نصوص، صور، بنرات، شعارات)
-- وعند تفعيل الثيم يتم نسخ الداتا ديمو للعميل
-- ============================================

-- التحقق من وجود الجداول قبل إنشائها (MySQL 5.7 Compatible)

-- جداول محتوى الثيم: نصوص وأقسام قابلة للتخصيص
SET @table_theme_contents = (SELECT COUNT(*) FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'theme_contents');
SET @sql_theme_contents = IF(@table_theme_contents = 0,
    'CREATE TABLE theme_contents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        theme_id INT NOT NULL,
        section_type VARCHAR(50) NOT NULL COMMENT ''hero, about, services, testimonials, contact, footer, custom'',
        content_key VARCHAR(100) DEFAULT NULL COMMENT ''مفتاح المحتوى مثل: hero_title, hero_subtitle, about_text'',
        content_ar TEXT COMMENT ''المحتوى بالعربية (نص أو JSON)'',
        content_en TEXT COMMENT ''المحتوى بالإنجليزية'',
        sort_order INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_theme_section (theme_id, section_type),
        INDEX idx_theme_active (theme_id, is_active),
        FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci',
    'SELECT 1');
PREPARE stmt FROM @sql_theme_contents;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- جدول وسائط الثيم: صور، بنرات، شعارات
SET @table_theme_media = (SELECT COUNT(*) FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'theme_media');
SET @sql_theme_media = IF(@table_theme_media = 0,
    'CREATE TABLE theme_media (
        id INT AUTO_INCREMENT PRIMARY KEY,
        theme_id INT NOT NULL,
        media_type VARCHAR(50) NOT NULL COMMENT ''logo, banner, service_icon, gallery, icon, favicon'',
        file_path VARCHAR(500) NOT NULL COMMENT ''مسار الملف'',
        file_name VARCHAR(255) DEFAULT NULL COMMENT ''اسم الملف الأصلي'',
        alt_text_ar VARCHAR(255) DEFAULT NULL,
        alt_text_en VARCHAR(255) DEFAULT NULL,
        section_ref VARCHAR(50) DEFAULT NULL COMMENT ''مرجع القسم مثل: hero, about, service_1'',
        sort_order INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_theme_media (theme_id, media_type),
        INDEX idx_theme_media_active (theme_id, media_type, is_active),
        FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci',
    'SELECT 1');
PREPARE stmt FROM @sql_theme_media;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ============================================
-- بيانات تجريبية لمحتوى الثيمات الافتراضية
-- ============================================

-- ثيم الصيانة (maintenance)
INSERT INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(5, 'hero', 'hero_title', 'صيانة احترافية لممتلكاتك', 'Professional Maintenance for Your Property', 1),
(5, 'hero', 'hero_subtitle', 'فريق متخصص متاح على مدار الساعة لخدمتكم', 'Specialized team available 24/7 to serve you', 2),
(5, 'hero', 'hero_description', 'نقدم خدمات صيانة شاملة للمنازل والمباني التجارية بأعلى معايير الجودة والاحترافية', 'We provide comprehensive maintenance services for homes and commercial buildings with the highest quality standards', 3),
(5, 'hero', 'hero_button_text', 'اتصل الآن', 'Call Now', 4),
(5, 'about', 'about_title', 'من نحن', 'About Us', 1),
(5, 'about', 'about_text', 'شركة متخصصة في تقديم خدمات الصيانة المنزلية والتجارية بأعلى مستويات الجودة. نمتلك فريقاً من الفنيين المتخصصين ذوي الخبرة الواسعة في جميع مجالات الصيانة.', 'A specialized company providing residential and commercial maintenance services of the highest quality. We have a team of expert technicians with extensive experience in all maintenance fields.', 2),
(5, 'services', 'service_1', '{"title_ar":"صيانة شاملة","title_en":"Comprehensive Maintenance","description_ar":"خدمات صيانة متكاملة للمباني السكنية والتجارية","description_en":"Integrated maintenance services for residential and commercial buildings","icon":"fas fa-tools","show_on_home":1}', '{"title_ar":"صيانة شاملة","title_en":"Comprehensive Maintenance","description_ar":"خدمات صيانة متكاملة للمباني السكنية والتجارية","description_en":"Integrated maintenance services for residential and commercial buildings","icon":"fas fa-tools","show_on_home":1}', 1),
(5, 'services', 'service_2', '{"title_ar":"صيانة التكييف","title_en":"AC Maintenance","description_ar":"صيانة دورية وطوارئ لجميع أنواع المكيفات","description_en":"Regular and emergency maintenance for all AC types","icon":"fas fa-fan","show_on_home":1}', '{"title_ar":"صيانة التكييف","title_en":"AC Maintenance","description_ar":"صيانة دورية وطوارئ لجميع أنواع المكيفات","description_en":"Regular and emergency maintenance for all AC types","icon":"fas fa-fan","show_on_home":1}', 2),
(5, 'services', 'service_3', '{"title_ar":"نجارة عامة","title_en":"Carpentry","description_ar":"أعمال نجارة متنوعة من تركيب أبواب وخزائن","description_en":"Various carpentry work including doors and cabinets","icon":"fas fa-hammer","show_on_home":1}', '{"title_ar":"نجارة عامة","title_en":"Carpentry","description_ar":"أعمال نجارة متنوعة من تركيب أبواب وخزائن","description_en":"Various carpentry work including doors and cabinets","icon":"fas fa-hammer","show_on_home":1}', 3),
(5, 'services', 'service_4', '{"title_ar":"صيانة الكهرباء","title_en":"Electrical Maintenance","description_ar":"فحص وإصلاح الأعطال الكهربائية","description_en":"Electrical inspection and repair","icon":"fas fa-bolt","show_on_home":1}', '{"title_ar":"صيانة الكهرباء","title_en":"Electrical Maintenance","description_ar":"فحص وإصلاح الأعطال الكهربائية","description_en":"Electrical inspection and repair","icon":"fas fa-bolt","show_on_home":1}', 4),
(5, 'testimonials', 'testimonial_1', '{"client_name":"عبدالرحمن المالكي","client_title":"صاحب عمارة","content":"اتفقنا معهم على صيانة دورية لعمارتنا وخدمتهم ممتازة","rating":5}', '{"client_name":"Abdulrahman Al-Maliki","client_title":"Building Owner","content":"We agreed on regular maintenance for our building and their service is excellent","rating":5}', 1),
(5, 'testimonials', 'testimonial_2', '{"client_name":"مجمع الفجر","client_title":"مجمع تجاري","content":"فريق صيانة محترف ومتجاوب مع جميع الطلبات","rating":4}', '{"client_name":"Al-Fajr Complex","client_title":"Commercial Complex","content":"Professional and responsive maintenance team for all requests","rating":4}', 2),
(5, 'contact', 'contact_info', '{"phone":"966500000000","whatsapp":"966500000000","email":"info@maintenance.com","address":"الرياض - المملكة العربية السعودية"}', '{"phone":"966500000000","whatsapp":"966500000000","email":"info@maintenance.com","address":"Riyadh - Saudi Arabia"}', 1);

-- ثيم الديكور (decor) 
INSERT INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(4, 'hero', 'hero_title', 'حول منزلك إلى تحفة فنية', 'Transform Your Home into a Masterpiece', 1),
(4, 'hero', 'hero_subtitle', 'تصاميم داخلية فاخرة تعكس ذوقك', 'Luxury Interior Designs That Reflect Your Taste', 2),
(4, 'hero', 'hero_description', 'نقدم خدمات تصميم داخلي وديكور متكاملة بأحدث الاتجاهات العالمية', 'We provide comprehensive interior design and decoration services with the latest global trends', 3),
(4, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4),
(4, 'about', 'about_title', 'من نحن', 'About Us', 1),
(4, 'about', 'about_text', 'استوديو تصميم داخلي متخصص في تحويل المساحات العادية إلى أماكن استثنائية. نؤمن بأن كل مساحة لها روح ونحن نعمل على إبرازها.', 'An interior design studio specializing in transforming ordinary spaces into exceptional places. We believe every space has a soul and we work to bring it out.', 2),
(4, 'services', 'service_1', '{"title_ar":"تصميم داخلي","title_en":"Interior Design","description_ar":"تصاميم داخلية عصرية وكلاسيكية تتناسب مع ذوقك","description_en":"Modern and classic interior designs that match your taste","icon":"fas fa-pencil-ruler","show_on_home":1}', NULL, 1),
(4, 'services', 'service_2', '{"title_ar":"ديكور غرف المعيشة","title_en":"Living Room Decor","description_ar":"تصميم وتنفيذ ديكور غرف المعيشة بأحدث الأنماط","description_en":"Design and implement living room decor with latest styles","icon":"fas fa-couch","show_on_home":1}', NULL, 2),
(4, 'services', 'service_3', '{"title_ar":"تصميم المطابخ","title_en":"Kitchen Design","description_ar":"مطابخ عصرية بتصاميم عملية وجمالية","description_en":"Modern kitchens with practical and aesthetic designs","icon":"fas fa-utensils","show_on_home":1}', NULL, 3),
(4, 'testimonials', 'testimonial_1', '{"client_name":"منى الخالد","client_title":"ربة منزل","content":"صمموا لي منزلي بشكل رائع! أحببت كل زاوية فيه","rating":5}', NULL, 1);

-- ثيم الكهرباء (electric)
INSERT INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(2, 'hero', 'hero_title', 'خدمات كهربائية متكاملة', 'Integrated Electrical Services', 1),
(2, 'hero', 'hero_subtitle', 'أمان وجودة في كل التفاصيل', 'Safety and Quality in Every Detail', 2),
(2, 'hero', 'hero_button_text', 'اطلب الخدمة', 'Request Service', 4),
(2, 'about', 'about_title', 'من نحن', 'About Us', 1),
(2, 'about', 'about_text', 'شركة رائدة في مجال الخدمات الكهربائية مع أكثر من 10 سنوات خبرة. نلتزم بأعلى معايير السلامة والجودة.', 'A leading electrical services company with over 10 years of experience. We adhere to the highest safety and quality standards.', 2),
(2, 'services', 'service_1', '{"title_ar":"تمديدات كهربائية","title_en":"Electrical Wiring","description_ar":"تمديدات كهربائية جديدة للمباني السكنية والتجارية","description_en":"New electrical wiring for residential and commercial buildings","icon":"fas fa-plug","show_on_home":1}', NULL, 1),
(2, 'services', 'service_2', '{"title_ar":"إصلاح الأعطال","title_en":"Fault Repair","description_ar":"تشخيص وإصلاح جميع الأعطال الكهربائية بسرعة","description_en":"Diagnose and repair all electrical faults quickly","icon":"fas fa-bolt","show_on_home":1}', NULL, 2),
(2, 'testimonials', 'testimonial_1', '{"client_name":"عبدالله الشمري","client_title":"صاحب منزل","content":"تم تركيب تمديدات كهربائية كاملة لمنزلي الجديد","rating":5}', NULL, 1);

-- ثيم السباكة (plumbing)
INSERT INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(6, 'hero', 'hero_title', 'خدمات سباكة احترافية', 'Professional Plumbing Services', 1),
(6, 'hero', 'hero_subtitle', 'حلول سريعة وموثوقة لجميع مشاكل السباكة', 'Fast and reliable solutions for all plumbing problems', 2),
(6, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4),
(6, 'services', 'service_1', '{"title_ar":"صيانة السباكة العامة","title_en":"General Plumbing","description_ar":"نقدم خدمات صيانة سباكة شاملة لجميع أنواع المنازل","description_en":"Comprehensive plumbing maintenance for all types of homes","icon":"fas fa-wrench","show_on_home":1}', NULL, 1),
(6, 'services', 'service_2', '{"title_ar":"إصلاح التسريبات","title_en":"Leak Repair","description_ar":"نكشف ونصلح جميع أنواع التسريبات بأحدث الأجهزة","description_en":"We detect and repair all types of leaks with latest equipment","icon":"fas fa-tint-slash","show_on_home":1}', NULL, 2);

-- ثيم التنظيف (cleaning)
INSERT INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(3, 'hero', 'hero_title', 'نظافة لا مثيل لها', 'Unmatched Cleanliness', 1),
(3, 'hero', 'hero_subtitle', 'خدمة تنظيف احترافية بمعايير عالمية', 'Professional cleaning service with international standards', 2),
(3, 'hero', 'hero_button_text', 'احجز الآن', 'Book Now', 4),
(3, 'services', 'service_1', '{"title_ar":"تنظيف المنازل","title_en":"Home Cleaning","description_ar":"خدمة تنظيف منزلية شاملة تشمل جميع الغرف","description_en":"Comprehensive home cleaning covering all rooms","icon":"fas fa-home","show_on_home":1}', NULL, 1),
(3, 'services', 'service_2', '{"title_ar":"تنظيف المكاتب","title_en":"Office Cleaning","description_ar":"تنظيف احترافي للمكاتب والشركات","description_en":"Professional cleaning for offices and companies","icon":"fas fa-building","show_on_home":1}', NULL, 2);

-- ثيم عام (general)
INSERT INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(1, 'hero', 'hero_title', 'مرحباً بكم في موقعنا', 'Welcome to Our Website', 1),
(1, 'hero', 'hero_subtitle', 'نسعى لخدمتكم بأعلى معايير الجودة', 'We strive to serve you with the highest quality standards', 2),
(1, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4),
(1, 'services', 'service_1', '{"title_ar":"خدماتنا المميزة","title_en":"Our Services","description_ar":"نقدم مجموعة واسعة من الخدمات عالية الجودة","description_en":"We offer a wide range of high-quality services","icon":"fas fa-star","show_on_home":1}', NULL, 1),
(1, 'services', 'service_2', '{"title_ar":"استشارات متخصصة","title_en":"Expert Consulting","description_ar":"نقدم استشارات مهنية متخصصة","description_en":"We provide specialized professional consulting","icon":"fas fa-comments","show_on_home":1}', NULL, 2);

-- ============================================
-- إضافة رابط في صفحة القوالب لإدارة المحتوى
-- يتم ذلك من خلال واجهة الأدمن
-- ============================================

-- إشعار نجاح
SELECT 'تم إنشاء جداول إدارة محتوى الثيمات بنجاح!' AS message;
SELECT 'theme_contents' AS table_name, COUNT(*) AS records_count FROM theme_contents
UNION ALL
SELECT 'theme_media' AS table_name, COUNT(*) AS records_count FROM theme_media;
