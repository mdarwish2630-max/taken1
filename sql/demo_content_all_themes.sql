-- ============================================
-- محتوى ديمو احترافي لكل الـ12 قالب
-- يشمل: نصوص + صور (شعار، بانر، صور خدمات)
-- ============================================

-- ============================================
-- 1. وسائط الثيمات (Theme Media)
-- إضافة شعارات وبانرات وصور خدمات لكل ثيم
-- ============================================

-- ثيم عام (general) - ID=1
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(1, 'logo', 'logos/general-logo.png', 'general-logo.png', 'شعار الشركة', 'hero', 1),
(1, 'banner', 'banners/general-hero.jpg', 'general-hero.jpg', 'بانر الموقع العام', 'hero', 1),
(1, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'خدمات عامة', 'service_1', 1),
(1, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'استشارات', 'service_2', 2);

-- ثيم الكهرباء (electric) - ID=2
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(2, 'logo', 'logos/electric-logo.png', 'electric-logo.png', 'شعار شركة الكهرباء', 'hero', 1),
(2, 'banner', 'banners/electric-hero.jpg', 'electric-hero.jpg', 'بانر خدمات الكهرباء', 'hero', 1),
(2, 'service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية', 'service_1', 1),
(2, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', 'service_2', 2);

-- ثيم التنظيف (cleaning) - ID=3
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(3, 'logo', 'logos/cleaning-logo.png', 'cleaning-logo.png', 'شعار شركة التنظيف', 'hero', 1),
(3, 'banner', 'banners/cleaning-hero.jpg', 'cleaning-hero.jpg', 'بانر خدمات التنظيف', 'hero', 1),
(3, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف عميق', 'service_1', 1),
(3, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'تنظيف المكاتب', 'service_2', 2);

-- ثيم الديكور (decor) - ID=4
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(4, 'logo', 'logos/decor-logo.png', 'decor-logo.png', 'شعار استوديو الديكور', 'hero', 1),
(4, 'banner', 'banners/decor-hero.jpg', 'decor-hero.jpg', 'بانر خدمات الديكور', 'hero', 1),
(4, 'service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'تصميم داخلي', 'service_1', 1),
(4, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'دهانات احترافية', 'service_3', 2);

-- ثيم الصيانة (maintenance) - ID=5
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(5, 'logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'شعار شركة الصيانة', 'hero', 1),
(5, 'banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'بانر خدمات الصيانة', 'hero', 1),
(5, 'service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة التكييف', 'service_2', 1),
(5, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'صيانة السباكة', 'service_4', 2),
(5, 'service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'خدمات الدهان', 'service_3', 3);

-- ثيم السباكة (plumbing) - ID=6
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(6, 'logo', 'logos/plumbing-logo.png', 'plumbing-logo.png', 'شعار شركة السباكة', 'hero', 1),
(6, 'banner', 'banners/plumbing-hero.jpg', 'plumbing-hero.jpg', 'بانر خدمات السباكة', 'hero', 1),
(6, 'service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح السباكة', 'service_1', 1),
(6, 'service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تنظيف شامل', 'service_2', 2);

-- ثيم الطبي (medical) - ID=7
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(7, 'logo', 'logos/medical-logo.png', 'medical-logo.png', 'شعار العيادة الطبية', 'hero', 1),
(7, 'banner', 'banners/medical-hero.jpg', 'medical-hero.jpg', 'بانر العيادة الطبية', 'hero', 1),
(7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'فحص شامل', 'service_1', 1),
(7, 'service_image', 'services/medical-dental.jpg', 'medical-dental.jpg', 'طب الأسنان', 'service_2', 2),
(7, 'service_image', 'services/medical-checkup.jpg', 'medical-checkup.jpg', 'استشارات طبية', 'service_3', 3);

-- ثيم العقارات (realestate) - ID=8
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(8, 'logo', 'logos/realestate-logo.png', 'realestate-logo.png', 'شعار شركة العقارات', 'hero', 1),
(8, 'banner', 'banners/realestate-hero.jpg', 'realestate-hero.jpg', 'بانر العقارات الفاخرة', 'hero', 1),
(8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'فلل فاخرة', 'service_1', 1),
(8, 'service_image', 'services/realestate-apartment.jpg', 'realestate-apartment.jpg', 'شقق سكنية', 'service_2', 2),
(8, 'service_image', 'services/realestate-villa.jpg', 'realestate-villa.jpg', 'إدارة أملاك', 'service_3', 3);

-- ثيم المطاعم (restaurant) - ID=9
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(9, 'logo', 'logos/restaurant-logo.png', 'restaurant-logo.png', 'شعار المطعم', 'hero', 1),
(9, 'banner', 'banners/restaurant-hero.jpg', 'restaurant-hero.jpg', 'بانر المطعم الفاخر', 'hero', 1),
(9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'عشاء فاخر', 'service_1', 1),
(9, 'service_image', 'services/restaurant-catering.jpg', 'restaurant-catering.jpg', 'تموين مناسبات', 'service_2', 2),
(9, 'service_image', 'services/restaurant-dining.jpg', 'restaurant-dining.jpg', 'توصيل طلبات', 'service_3', 3);

-- ثيم التعليم (education) - ID=10
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(10, 'logo', 'logos/education-logo.png', 'education-logo.png', 'شعار الأكاديمية', 'hero', 1),
(10, 'banner', 'banners/education-hero.jpg', 'education-hero.jpg', 'بانر الأكاديمية التعليمية', 'hero', 1),
(10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'دورات حضورية', 'service_1', 1),
(10, 'service_image', 'services/education-online.jpg', 'education-online.jpg', 'تعليم عن بعد', 'service_2', 2),
(10, 'service_image', 'services/education-classroom.jpg', 'education-classroom.jpg', 'تدريب مهني', 'service_3', 3);

-- ثيم الرياضة (fitness) - ID=11
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(11, 'logo', 'logos/fitness-logo.png', 'fitness-logo.png', 'شعار النادي الرياضي', 'hero', 1),
(11, 'banner', 'banners/fitness-hero.jpg', 'fitness-hero.jpg', 'بانر النادي الرياضي', 'hero', 1),
(11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'تدريب شخصي', 'service_1', 1),
(11, 'service_image', 'services/fitness-yoga.jpg', 'fitness-yoga.jpg', 'يوجا وبيلاتس', 'service_2', 2),
(11, 'service_image', 'services/fitness-training.jpg', 'fitness-training.jpg', 'برامج لياقة', 'service_3', 3);

-- ثيم المحاماة (legal) - ID=12
INSERT IGNORE INTO theme_media (theme_id, media_type, file_path, file_name, alt_text_ar, section_ref, sort_order) VALUES
(12, 'logo', 'logos/legal-logo.png', 'legal-logo.png', 'شعار مكتب المحاماة', 'hero', 1),
(12, 'banner', 'banners/legal-hero.jpg', 'legal-hero.jpg', 'بانر مكتب المحاماة', 'hero', 1),
(12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'استشارات قانونية', 'service_1', 1),
(12, 'service_image', 'services/legal-corporate.jpg', 'legal-corporate.jpg', 'قانون الشركات', 'service_2', 2),
(12, 'service_image', 'services/legal-consultation.jpg', 'legal-consultation.jpg', 'قضايا عقارية', 'service_3', 3);


-- ============================================
-- 2. محتوى نصي لجميع الثيمات الـ 12
-- ============================================

-- ثيم عام (general) - ID=1
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(1, 'hero', 'hero_title', 'حلول احترافية لنجاح أعمالك', 'Professional Solutions for Your Business Success', 1),
(1, 'hero', 'hero_subtitle', 'شريكك الموثوق في عالم الأعمال الرقمية', 'Your Trusted Partner in the Digital Business World', 2),
(1, 'hero', 'hero_description', 'نقدم حلولاً متكاملة تساعدك على تطوير أعمالك وتحقيق أهدافك بكفاءة عالية. فريقنا المتخصص يضع خبراته في خدمتك لتقديم أفضل النتائج.', 'We provide integrated solutions to help you grow your business and achieve your goals efficiently. Our expert team puts their expertise at your service to deliver the best results.', 3),
(1, 'hero', 'hero_button_text', 'تواصل معنا', 'Contact Us', 4),
(1, 'about', 'about_title', 'من نحن', 'About Us', 1),
(1, 'about', 'about_text', 'شركة رائدة في تقديم الحلول الرقمية المتميزة. نمتلك فريقاً من الخبراء والمتخصصين الذين يعملون بشغف لتقديم خدمات عالية الجودة تلبي احتياجات عملائنا المتنوعة.', 'A leading company in providing outstanding digital solutions. We have a team of experts and specialists who work passionately to deliver high-quality services that meet our clients diverse needs.', 2),
(1, 'services', 'service_1', '{"title_ar":"استشارات الأعمال","title_en":"Business Consulting","description_ar":"استشارات متخصصة لتطوير أعمالك وزيادة الإنتاجية مع خطط استراتيجية مخصصة","description_en":"Specialized consulting to develop your business and increase productivity with custom strategic plans","icon":"fas fa-chart-line","show_on_home":1}', NULL, 1),
(1, 'services', 'service_2', '{"title_ar":"تطوير المواقع","title_en":"Web Development","description_ar":"تصميم وتطوير مواقع إلكترونية احترافية متجاوبة مع جميع الأجهزة","description_en":"Professional responsive website design and development for all devices","icon":"fas fa-code","show_on_home":1}', NULL, 2),
(1, 'services', 'service_3', '{"title_ar":"التسويق الرقمي","title_en":"Digital Marketing","description_ar":"استراتيجيات تسويق رقمي متكاملة لزيادة الوعي بعلامتك التجارية","description_en":"Integrated digital marketing strategies to increase brand awareness","icon":"fas fa-bullhorn","show_on_home":1}', NULL, 3),
(1, 'services', 'service_4', '{"title_ar":"الدعم الفني","title_en":"Technical Support","description_ar":"دعم فني على مدار الساعة لضمان سير عملك بدون انقطاع","description_en":"24/7 technical support to ensure your business runs without interruption","icon":"fas fa-headset","show_on_home":1}', NULL, 4),
(1, 'testimonials', 'testimonial_1', '{"client_name":"عبدالله السعيد","client_title":"مدير شركة","content":"خدمة ممتازة وفريق محترف. ساعدونا في تحقيق أهدافنا بشكل أسرع من المتوقع.","rating":5}', NULL, 1),
(1, 'testimonials', 'testimonial_2', '{"client_name":"مريم الحربي","client_title":"رائدة أعمال","content":"من أفضل الشركات التي تعاملت معها. الجودة والاحترافية في كل تفصيل.","rating":5}', NULL, 2),
(1, 'contact', 'contact_info', '{"phone":"966500000100","whatsapp":"966500000100","email":"info@generic-company.com","address":"الرياض - حي العليا - شارع الملك فهد"}', '{"phone":"966500000100","whatsapp":"966500000100","email":"info@generic-company.com","address":"Riyadh - Olaya District - King Fahd Road"}', 1);

-- ثيم الكهرباء (electric) - ID=2
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(2, 'hero', 'hero_title', 'حلول كهربائية متكاملة', 'Integrated Electrical Solutions', 1),
(2, 'hero', 'hero_subtitle', 'فنيون معتمدون بخبرة تفوق 15 عاماً في جميع الأعمال الكهربائية', 'Certified technicians with over 15 years of experience in all electrical work', 2),
(2, 'hero', 'hero_description', 'شركة متخصصة في تقديم جميع الخدمات الكهربائية للمنازل والمنشآت التجارية والصناعية. نلتزم بأعلى معايير السلامة والجودة مع ضمان على جميع أعمالنا.', 'A company specializing in providing all electrical services for homes, commercial, and industrial facilities. We adhere to the highest safety and quality standards with warranty on all our work.', 3),
(2, 'hero', 'hero_button_text', 'اطلب فني', 'Request Technician', 4),
(2, 'about', 'about_title', 'من نحن', 'About Us', 1),
(2, 'about', 'about_text', 'شركة كهربائية رائدة تقدم خدماتها منذ أكثر من 15 عاماً. نمتلك فريقاً من الفنيين والمهندسين المعتمدين المتخصصين في جميع مجالات الأعمال الكهربائية مع استخدام أجود المواد والمعدات.', 'A leading electrical company serving for over 15 years. We have a team of certified technicians and engineers specialized in all areas of electrical work using the finest materials and equipment.', 2),
(2, 'services', 'service_1', '{"title_ar":"تمديدات كهربائية","title_en":"Electrical Wiring","description_ar":"تمديدات كهربائية احترافية للمنازل والمباني التجارية بمعايير السلامة الدولية","description_en":"Professional electrical wiring for homes and commercial buildings to international safety standards","icon":"fas fa-bolt","show_on_home":1}', NULL, 1),
(2, 'services', 'service_2', '{"title_ar":"صيانة التكييف","title_en":"AC Maintenance","description_ar":"صيانة وتركيب جميع أنواع المكيفات مع ضمان شامل على القطع والعمل","description_en":"Maintenance and installation of all AC types with comprehensive warranty on parts and labor","icon":"fas fa-snowflake","show_on_home":1}', NULL, 2),
(2, 'services', 'service_3', '{"title_ar":"لوحات التحكم","title_en":"Control Panels","description_ar":"تصميم وتركيب لوحات التحكم الكهربائية للمباني والمصانع","description_en":"Design and installation of electrical control panels for buildings and factories","icon":"fas fa-sliders-h","show_on_home":1}', NULL, 3),
(2, 'services', 'service_4', '{"title_ar":"طوارئ كهربائية","title_en":"Emergency Electrical","description_ar":"خدمة طوارئ على مدار الساعة لحل جميع المشاكل الكهربائية العاجلة","description_en":"24/7 emergency service to resolve all urgent electrical problems","icon":"fas fa-exclamation-triangle","show_on_home":1}', NULL, 4),
(2, 'testimonials', 'testimonial_1', '{"client_name":"سعد القحطاني","client_title":"مهندس","content":"فريق محترف وسريع في الاستجابة. أنجزوا المشروع قبل الموعد المحدد.","rating":5}', NULL, 1),
(2, 'testimonials', 'testimonial_2', '{"client_name":"فاطمة الشمري","client_title":"ربة منزل","content":"خدمة ممتازة وأسعار معقولة. أنصح الجميع بالتعامل معهم.","rating":5}', NULL, 2),
(2, 'contact', 'contact_info', '{"phone":"966500000102","whatsapp":"966500000102","email":"info@electric-services.com","address":"جدة - حي الصفا - شارع فلسطين"}', '{"phone":"966500000102","whatsapp":"966500000102","email":"info@electric-services.com","address":"Jeddah - Al Safa District - Palestine Street"}', 1);

-- ثيم التنظيف (cleaning) - ID=3
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(3, 'hero', 'hero_title', 'نظافة مثالية بلمسة احترافية', 'Perfect Cleanliness with a Professional Touch', 1),
(3, 'hero', 'hero_subtitle', 'خدمات تنظيف شاملة للمنازل والمكاتب والمنشآت التجارية', 'Comprehensive cleaning services for homes, offices, and commercial facilities', 2),
(3, 'hero', 'hero_description', 'شركة تنظيف متخصصة تقدم خدمات شاملة باستخدام أحدث المعدات ومواد التنظيف الآمنة والصديقة للبيئة. نضمن لك بيئة نظيفة وصحية.', 'A specialized cleaning company offering comprehensive services using the latest equipment and eco-friendly cleaning products. We guarantee a clean and healthy environment.', 3),
(3, 'hero', 'hero_button_text', 'احجز الآن', 'Book Now', 4),
(3, 'about', 'about_title', 'من نحن', 'About Us', 1),
(3, 'about', 'about_text', 'شركة تنظيف رائدة تتميز بخبرة واسعة في تقديم خدمات تنظيف عالية الجودة. نستخدم أحدث التقنيات ومواد تنظيف آمنة مع فريق مدرب على أعلى مستوى.', 'A leading cleaning company distinguished by extensive experience in delivering high-quality cleaning services. We use the latest technologies and safe cleaning products with a highly trained team.', 2),
(3, 'services', 'service_1', '{"title_ar":"تنظيف عميق","title_en":"Deep Cleaning","description_ar":"تنظيف عميق شامل لجميع أنحاء المنزل أو المكتب باستخدام أحدث المعدات","description_en":"Comprehensive deep cleaning for the entire home or office using the latest equipment","icon":"fas fa-broom","show_on_home":1}', NULL, 1),
(3, 'services', 'service_2', '{"title_ar":"تنظيف المكاتب","title_en":"Office Cleaning","description_ar":"خدمات تنظيف يومية وأسبوعية للمكاتب والمنشآت التجارية","description_en":"Daily and weekly cleaning services for offices and commercial facilities","icon":"fas fa-building","show_on_home":1}', NULL, 2),
(3, 'services', 'service_3', '{"title_ar":"تنظيف السجاد","title_en":"Carpet Cleaning","description_ar":"تنظيف احترافي للسجاد والموكيت بجميع أنواعه وأحجامه","description_en":"Professional carpet and rug cleaning of all types and sizes","icon":"fas fa-rug","show_on_home":1}', NULL, 3),
(3, 'services', 'service_4', '{"title_ar":"تنظيف بعد البناء","title_en":"Post-Construction","description_ar":"تنظيف شامل بعد أعمال البناء والتشطيبات لإعداد المكان للاستخدام","description_en":"Comprehensive cleaning after construction and finishing work to prepare the space for use","icon":"fas fa-hard-hat","show_on_home":1}', NULL, 4),
(3, 'testimonials', 'testimonial_1', '{"client_name":"نوف العتيبي","client_title":"سيدة أعمال","content":"منظفون محترفون والنتيجة ممتازة. البيئة أصبحت نظيفة ومعطرة بشكل رائع.","rating":5}', NULL, 1),
(3, 'testimonials', 'testimonial_2', '{"client_name":"مازن الدوسري","client_title":"مدير مكتب","content":"نتعامل معهم لتنظيف مكاتبنا أسبوعياً ولم نختبر يوماً أي تقصير.","rating":5}', NULL, 2),
(3, 'contact', 'contact_info', '{"phone":"966500000103","whatsapp":"966500000103","email":"info@cleaning-services.com","address":"الرياض - حي النسيم - شارع الحسن"}', '{"phone":"966500000103","whatsapp":"966500000103","email":"info@cleaning-services.com","address":"Riyadh - Al Naseem District - Al Hassan Street"}', 1);

-- ثيم الديكور (decor) - ID=4
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(4, 'hero', 'hero_title', 'تصاميم ديكور فاخرة', 'Luxury Interior Design', 1),
(4, 'hero', 'hero_subtitle', 'نحول رؤيتك إلى واقع بلمسات فنية استثنائية', 'We turn your vision into reality with exceptional artistic touches', 2),
(4, 'hero', 'hero_description', 'استوديو ديكور متخصص يقدم خدمات تصميم داخلي وتنسيق ديكور احترافية للمنازل والمكاتب والفنادق والمساحات التجارية بأحدث الاتجاهات العالمية.', 'A specialized decor studio offering professional interior design and decor coordination services for homes, offices, hotels, and commercial spaces with the latest global trends.', 3),
(4, 'hero', 'hero_button_text', 'شاهد أعمالنا', 'View Our Work', 4),
(4, 'about', 'about_title', 'من نحن', 'About Us', 1),
(4, 'about', 'about_text', 'استوديو ديكور تأسس على يد فريق من المصممين المبدعين الذين يجمعون بين الفن والوظيفة. نقدم تصاميم فريدة تعكس ذوقك الشخصي وتلبي احتياجاتك العملية مع الالتزام بالميزانية.', 'A decor studio founded by a team of creative designers who combine art and function. We deliver unique designs that reflect your personal taste and meet your practical needs while staying within budget.', 2),
(4, 'services', 'service_1', '{"title_ar":"تصميم داخلي","title_en":"Interior Design","description_ar":"تصميم داخلي متكامل يراعي الجمال والوظيفة والراحة في كل تفصيل","description_en":"Complete interior design balancing beauty, function, and comfort in every detail","icon":"fas fa-couch","show_on_home":1}', NULL, 1),
(4, 'services', 'service_2', '{"title_ar":"تنسيق المساحات","title_en":"Space Planning","description_ar":"تنسيق المساحات بشكل ذكي لتحقيق أقصى استفادة من كل متر مربع","description_en":"Smart space planning to maximize the use of every square meter","icon":"fas fa-drafting-compass","show_on_home":1}', NULL, 2),
(4, 'services', 'service_3', '{"title_ar":"دهانات احترافية","title_en":"Professional Painting","description_ar":"خدمات دهانات احترافية بأحدث الألوان والتقنيات مع تشطيبات فاخرة","description_en":"Professional painting services with the latest colors and techniques plus luxury finishes","icon":"fas fa-paint-roller","show_on_home":1}', NULL, 3),
(4, 'services', 'service_4', '{"title_ar":"إضاءة وتجهيز","title_en":"Lighting & Furnishing","description_ar":"اختيار وتنسيق الإضاءة والأثاث لإضفاء لمسة فاخرة على المكان","description_en":"Selection and coordination of lighting and furniture to add a luxurious touch to the space","icon":"fas fa-lightbulb","show_on_home":1}', NULL, 4),
(4, 'testimonials', 'testimonial_1', '{"client_name":"لمياء العمري","client_title":"ربة منزل","content":"حولوا بيتنا إلى قصر. التصميم أكثر من رائع والتنفيذ دقيق جداً.","rating":5}', NULL, 1),
(4, 'testimonials', 'testimonial_2', '{"client_name":"تركي العنزي","client_title":"رجل أعمال","content":"تعاملنا معهم في تصميم مكاتبنا والنتيجة فاقت كل التوقعات.","rating":5}', NULL, 2),
(4, 'contact', 'contact_info', '{"phone":"966500000104","whatsapp":"966500000104","email":"info@decor-studio.com","address":"الرياض - حي الملقا - شارع الأمير سعد بن عبدالرحمن"}', '{"phone":"966500000104","whatsapp":"966500000104","email":"info@decor-studio.com","address":"Riyadh - Al Malqa District - Prince Saad bin Abdulrahman Road"}', 1);

-- ثيم الصيانة (maintenance) - ID=5
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(5, 'hero', 'hero_title', 'صيانة شاملة بمعايير عالمية', 'Comprehensive Maintenance with International Standards', 1),
(5, 'hero', 'hero_subtitle', 'فريق فنيون متخصصون لحل جميع مشاكل المنزل والمكتب', 'Specialized technical team to solve all home and office problems', 2),
(5, 'hero', 'hero_description', 'شركة صيانة متكاملة تقدم خدماتها للمنازل والمكاتب والمنشآت التجارية. نمتلك فريقاً من الفنيين المعتمدين في جميع التخصصات مع ضمان شامل على جميع أعمالنا.', 'An integrated maintenance company serving homes, offices, and commercial facilities. We have a team of certified technicians across all specialties with a comprehensive warranty on all our work.', 3),
(5, 'hero', 'hero_button_text', 'اطلب صيانة', 'Request Service', 4),
(5, 'about', 'about_title', 'من نحن', 'About Us', 1),
(5, 'about', 'about_text', 'شركة صيانة رائدة تقدم حلولاً شاملة وموثوقة لجميع احتياجات الصيانة. نحرص على الالتزام بالمواعيد وتقديم خدمات عالية الجودة بأسعار تنافسية مع ضمان على كل عمل نقوم به.', 'A leading maintenance company providing comprehensive and reliable solutions for all maintenance needs. We are committed to punctuality and delivering high-quality services at competitive prices with warranty on every job.', 2),
(5, 'services', 'service_1', '{"title_ar":"كهرباء المنازل","title_en":"Home Electrical","description_ar":"صيانة كهربائية شاملة للمنازل من تمديدات وإصلاحات وتركيبات","description_en":"Comprehensive home electrical maintenance from wiring, repairs, and installations","icon":"fas fa-plug","show_on_home":1}', NULL, 1),
(5, 'services', 'service_2', '{"title_ar":"صيانة التكييف","title_en":"AC Maintenance","description_ar":"صيانة وتركيب وغسيل مكيفات جميع الأنواع مع ضمان الخدمة","description_en":"AC maintenance, installation, and cleaning of all types with service warranty","icon":"fas fa-fan","show_on_home":1}', NULL, 2),
(5, 'services', 'service_3', '{"title_ar":"خدمات الدهان","title_en":"Painting Services","description_ar":"دهانات داخلية وخارجية بجميع الألوان والتقنيات الحديثة","description_en":"Interior and exterior painting with all colors and modern techniques","icon":"fas fa-paint-brush","show_on_home":1}', NULL, 3),
(5, 'services', 'service_4', '{"title_ar":"سباكة وإصلاحات","title_en":"Plumbing & Repairs","description_ar":"خدمات سباكة شاملة من تركيب وإصلاح وصيانة جميع الأنابيب والصحيات","description_en":"Comprehensive plumbing services from installation, repair, and maintenance of all pipes and fixtures","icon":"fas fa-wrench","show_on_home":1}', NULL, 4),
(5, 'testimonials', 'testimonial_1', '{"client_name":"سلطان المطيري","client_title":"مدير مدرسة","content":"صيانة ممتازة وسريعة. الفنيون محترفون والأسعار معقولة جداً.","rating":5}', NULL, 1),
(5, 'testimonials', 'testimonial_2', '{"client_name":"هند الزهراني","client_title":"ربة منزل","content":"أنقذونا في مشكلة السباكة الطارئة. وصلوا خلال ساعة وأصلحوا المشكلة.","rating":5}', NULL, 2),
(5, 'contact', 'contact_info', '{"phone":"966500000105","whatsapp":"966500000105","email":"info@maintenance-services.com","address":"الدمام - حي الشاطئ - شارع الأمير محمد"}', '{"phone":"966500000105","whatsapp":"966500000105","email":"info@maintenance-services.com","address":"Dammam - Al Sahati District - Prince Mohammed Road"}', 1);

-- ثيم السباكة (plumbing) - ID=6
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(6, 'hero', 'hero_title', 'حلول سباكة موثوقة وسريعة', 'Reliable and Fast Plumbing Solutions', 1),
(6, 'hero', 'hero_subtitle', 'سباكون معتمدون بخبرة تفوق 10 سنوات في جميع أعمال السباكة', 'Certified plumbers with over 10 years of experience in all plumbing work', 2),
(6, 'hero', 'hero_description', 'شركة سباكة متخصصة تقدم خدمات شاملة من الإصلاحات الطارئة إلى التركيبات الجديدة. نستخدم أجود القطع والمواد مع ضمان شامل على جميع أعمالنا وخدمة على مدار الساعة.', 'A specialized plumbing company offering comprehensive services from emergency repairs to new installations. We use the finest parts and materials with a comprehensive warranty on all our work and 24/7 service.', 3),
(6, 'hero', 'hero_button_text', 'اتصل الآن', 'Call Now', 4),
(6, 'about', 'about_title', 'من نحن', 'About Us', 1),
(6, 'about', 'about_text', 'شركة سباكة متخصصة تتميز بفريق من الفنيين المعتمدين ذوي الخبرة الواسعة. نقدم حلولاً سريعة ودائمة لمشاكل السباكة مع الالتزام بأعلى معايير الجودة والنظافة.', 'A specialized plumbing company featuring a team of certified technicians with extensive experience. We provide fast and permanent solutions to plumbing problems while adhering to the highest quality and cleanliness standards.', 2),
(6, 'services', 'service_1', '{"title_ar":"إصلاح السباكة","title_en":"Plumbing Repair","description_ar":"إصلاح سريع ودقيق لجميع أعطال السباكة مع ضمان على العمل","description_en":"Fast and accurate repair of all plumbing failures with work warranty","icon":"fas fa-wrench","show_on_home":1}', NULL, 1),
(6, 'services', 'service_2', '{"title_ar":"تركيب الصحيات","title_en":"Fixture Installation","description_ar":"تركيب جميع أنواع الصحيات والمعدات بأعلى معايير الجودة","description_en":"Installation of all types of fixtures and equipment to the highest quality standards","icon":"fas fa-faucet","show_on_home":1}', NULL, 2),
(6, 'services', 'service_3', '{"title_ar":"كشف التسريبات","title_en":"Leak Detection","description_ar":"كشف وإصلاح تسريبات المياه بأحدث التقنيات دون تكسير","description_en":"Leak detection and repair using the latest technologies without demolition","icon":"fas fa-tint","show_on_home":1}', NULL, 3),
(6, 'services', 'service_4', '{"title_ar":"صيانة مجاري","title_en":"Drain Maintenance","description_ar":"تنظيف وصيانة المجاري والبالوعات بأحدث المعدات المتخصصة","description_en":"Drain and sewer cleaning and maintenance with the latest specialized equipment","icon":"fas fa-water","show_on_home":1}', NULL, 4),
(6, 'testimonials', 'testimonial_1', '{"client_name":"فهد الشمري","client_title":"مالك فيلا","content":"وصلوا خلال نصف ساعة وأصلحوا الانفجار بسرعة واحترافية ممتازة.","rating":5}', NULL, 1),
(6, 'testimonials', 'testimonial_2', '{"client_name":"أم سلطان","client_title":"ربة منزل","content":"تعاملت معهم عدة مرات ودائماً خدمة ممتازة وأسعار مناسبة.","rating":5}', NULL, 2),
(6, 'contact', 'contact_info', '{"phone":"966500000106","whatsapp":"966500000106","email":"info@plumbing-services.com","address":"الرياض - حي الروضة - شارع الإمام تركي"}', '{"phone":"966500000106","whatsapp":"966500000106","email":"info@plumbing-services.com","address":"Riyadh - Al Rawdah District - Imam Turki Road"}', 1);

-- ثيم الطبي (medical) - ID=7
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(7, 'hero', 'hero_title', 'رعاية صحية استثنائية', 'Exceptional Health Care', 1),
(7, 'hero', 'hero_subtitle', 'فريق طبي متخصص يضع صحتك أولاً', 'Specialized medical team putting your health first', 2),
(7, 'hero', 'hero_description', 'نوفر خدمات طبية شاملة بأحدث التقنيات وأفضل الأطباء المتخصصين في جميع المجالات الطبية. نلتزم بأعلى معايير الجودة والسلامة.', 'We provide comprehensive medical services with the latest technology and the best specialized doctors in all medical fields. We adhere to the highest quality and safety standards.', 3),
(7, 'hero', 'hero_button_text', 'احجز موعد', 'Book Appointment', 4),
(7, 'about', 'about_title', 'من نحن', 'About Us', 1),
(7, 'about', 'about_text', 'مركز طبي متكامل يقدم خدمات الرعاية الصحية بأعلى المعايير العالمية. نضم فريقاً من أمهر الأطباء والاستشاريين في مختلف التخصصات الطبية مع أحدث الأجهزة والتقنيات الطبية المتطورة. نحرص على تقديم تجربة علاجية مريحة وآمنة لجميع مرضانا.', 'An integrated medical center providing healthcare services to the highest international standards. We have a team of the most skilled doctors and consultants across various medical specialties with the latest advanced medical equipment and technologies.', 2),
(7, 'services', 'service_1', '{"title_ar":"فحص طبي شامل","title_en":"Comprehensive Medical Checkup","description_ar":"فحص طبي شامل يشمل جميع الفحوصات اللازمة للتأكد من سلامتك الصحية مع تقارير مفصلة","description_en":"Comprehensive medical examination including all necessary tests to ensure your health with detailed reports","icon":"fas fa-stethoscope","show_on_home":1}', NULL, 1),
(7, 'services', 'service_2', '{"title_ar":"طب الأسنان","title_en":"Dental Care","description_ar":"خدمات طب أسنان متكاملة من تنظيف وعلاج وتجميل باستخدام أحدث التقنيات","description_en":"Integrated dental services from cleaning, treatment, and cosmetics using the latest technologies","icon":"fas fa-tooth","show_on_home":1}', NULL, 2),
(7, 'services', 'service_3', '{"title_ar":"استشارات طبية","title_en":"Medical Consultations","description_ar":"استشارات طبية متخصصة مع أفضل الأطباء والاستشاريين في جميع التخصصات","description_en":"Specialized medical consultations with the best doctors and consultants in all specialties","icon":"fas fa-user-md","show_on_home":1}', NULL, 3),
(7, 'services', 'service_4', '{"title_ar":"مختبر تحاليل","title_en":"Laboratory","description_ar":"مختبر تحاليل مجهز بأحدث الأجهزة مع نتائج دقيقة وسريعة","description_en":"Laboratory equipped with the latest devices with accurate and fast results","icon":"fas fa-flask","show_on_home":1}', NULL, 4),
(7, 'testimonials', 'testimonial_1', '{"client_name":"سارة العتيبي","client_title":"مريضة","content":"تجربة رائعة مع فريق الطبيب محمد. كان شديد الاحترافية والاهتمام بالتفاصيل.","rating":5}', NULL, 1),
(7, 'testimonials', 'testimonial_2', '{"client_name":"خالد المطيري","client_title":"تاجر","content":"من أفضل المراكز الطبية التي تعاملت معها. النظافة والترتيب ممتاز.","rating":5}', NULL, 2),
(7, 'testimonials', 'testimonial_3', '{"client_name":"نورة القحطاني","client_title":"معلمة","content":"أنصح الجميع بالتعامل معهم. خدمة مميزة وأسعار معقولة.","rating":4}', NULL, 3),
(7, 'contact', 'contact_info', '{"phone":"966920000111","whatsapp":"966920000111","email":"info@medical-clinic.com","address":"الرياض - حي العليا - شارع التحلية"}', '{"phone":"966920000111","whatsapp":"966920000111","email":"info@medical-clinic.com","address":"Riyadh - Olaya District - Tahliya Street"}', 1);

-- ثيم العقارات (realestate) - ID=8
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(8, 'hero', 'hero_title', 'عقاراتك الفاخرة تنتظرك', 'Your Luxury Properties Await', 1),
(8, 'hero', 'hero_subtitle', 'اكتشف أفضل العقارات السكنية والتجارية', 'Discover the best residential and commercial properties', 2),
(8, 'hero', 'hero_description', 'وكالة عقارية متخصصة في تقديم أفضل الحلول العقارية. نوفر لك مجموعة واسعة من العقارات السكنية والتجارية بأسعار تنافسية وأفضل المواقع.', 'A specialized real estate agency providing the best property solutions. We offer a wide range of residential and commercial properties at competitive prices and prime locations.', 3),
(8, 'hero', 'hero_button_text', 'تصفح العقارات', 'Browse Properties', 4),
(8, 'about', 'about_title', 'من نحن', 'About Us', 1),
(8, 'about', 'about_text', 'شركة عقارية رائدة في السوق مع خبرة تتجاوز 15 عاماً في مجال الوساطة العقارية. نقدم خدمات شاملة تشمل البيع والشراء والتأجير وإدارة الأملاك مع فريق من الخبراء المتخصصين.', 'A leading real estate company with over 15 years of experience in property brokerage. We offer comprehensive services including sales, purchases, leasing, and property management with a team of specialized experts.', 2),
(8, 'services', 'service_1', '{"title_ar":"فلل فاخرة","title_en":"Luxury Villas","description_ar":"مجموعة حصرية من الفلل الفاخرة بأفضل المناطق السكنية مع تصميمات عصرية","description_en":"Exclusive collection of luxury villas in the best residential areas with modern designs","icon":"fas fa-home","show_on_home":1}', NULL, 1),
(8, 'services', 'service_2', '{"title_ar":"شقق سكنية","title_en":"Residential Apartments","description_ar":"شقق بتصاميم حديثة في مواقع استراتيجية مناسبة للعائلات والأفراد","description_en":"Modern apartments in strategic locations suitable for families and individuals","icon":"fas fa-building","show_on_home":1}', NULL, 2),
(8, 'services', 'service_3', '{"title_ar":"إدارة أملاك","title_en":"Property Management","description_ar":"خدمات إدارة أملاك شاملة تشمل الصيانة وتحصيل الإيجارات والتعاقدات","description_en":"Comprehensive property management services including maintenance, rent collection, and contracts","icon":"fas fa-key","show_on_home":1}', NULL, 3),
(8, 'testimonials', 'testimonial_1', '{"client_name":"فهد الدوسري","client_title":"رجل أعمال","content":"ساعدوني في العثور على فيلا أحلامي بسرعة ممتازة ومهنية عالية.","rating":5}', NULL, 1),
(8, 'testimonials', 'testimonial_2', '{"client_name":"ريم الشهري","client_title":"مهندسة","content":"تجربة شراء شقة سلسة ومريحة. الفريق متعاون ومحترف جداً.","rating":5}', NULL, 2),
(8, 'contact', 'contact_info', '{"phone":"966500000222","whatsapp":"966500000222","email":"info@realestate.com","address":"جدة - حي الحمراء - شارع الملك فهد"}', '{"phone":"966500000222","whatsapp":"966500000222","email":"info@realestate.com","address":"Jeddah - Al Hamra District - King Fahd Road"}', 1);

-- ثيم المطاعم (restaurant) - ID=9
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(9, 'hero', 'hero_title', 'أشهى المأكولات في مكان واحد', 'The Finest Cuisine in One Place', 1),
(9, 'hero', 'hero_subtitle', 'تجربة طعام استثنائية تأخذك في رحلة من الذواقة', 'An exceptional dining experience that takes you on a culinary journey', 2),
(9, 'hero', 'hero_description', 'مطعم فاخر يقدم أشهى الأطباق العربية والعالمية المحضرة بعناية من قبل أفضل الطهاة باستخدام أجود المكونات الطبيعية الطازجة.', 'A luxury restaurant serving the finest Arabic and international dishes carefully prepared by the best chefs using the finest natural fresh ingredients.', 3),
(9, 'hero', 'hero_button_text', 'اطلب الآن', 'Order Now', 4),
(9, 'about', 'about_title', 'من نحن', 'About Us', 1),
(9, 'about', 'about_text', 'مطعمنا الفاخر يجمع بين الأصالة والحداثة في تقديم أشهى المأكولات. يمتلك فريقنا من الطهاة الحائزين على جوائز عالمية خبرة واسعة في فن الطبخ. نحرص على اختيار مكوناتنا من أفضل المزارع المحلية لتقديم تجربة طعام لا تُنسى.', 'Our luxury restaurant combines authenticity and modernity in serving the finest cuisine. Our award-winning chef team has extensive experience in the culinary arts. We carefully select our ingredients from the best local farms to deliver an unforgettable dining experience.', 2),
(9, 'services', 'service_1', '{"title_ar":"عشاء فاخر","title_en":"Fine Dining","description_ar":"قائمة طعام متنوعة من الأطباق العربية والعالمية المحضرة بأيدي طهاة محترفين","description_en":"Diverse menu of Arabic and international dishes prepared by professional chefs","icon":"fas fa-utensils","show_on_home":1}', NULL, 1),
(9, 'services', 'service_2', '{"title_ar":"تموين مناسبات","title_en":"Event Catering","description_ar":"خدمات تموين احترافية للمناسبات والحفلات بجميع أنواعها وأحجامها","description_en":"Professional catering services for events and parties of all types and sizes","icon":"fas fa-glass-cheers","show_on_home":1}', NULL, 2),
(9, 'services', 'service_3', '{"title_ar":"خدمة التوصيل","title_en":"Delivery Service","description_ar":"خدمة توصيل سريعة لجميع الطلبات مع الحفاظ على جودة الطعام","description_en":"Fast delivery service for all orders while maintaining food quality","icon":"fas fa-motorcycle","show_on_home":1}', NULL, 3),
(9, 'services', 'service_4', '{"title_ar":"حجز طاولات","title_en":"Table Reservation","description_ar":"احجز طاولتك مسبقاً واستمتع بتجربة عشاء مميزة في أجواء راقية","description_en":"Reserve your table in advance and enjoy a distinguished dinner experience in an elegant atmosphere","icon":"fas fa-calendar-check","show_on_home":1}', NULL, 4),
(9, 'testimonials', 'testimonial_1', '{"client_name":"محمد السبيعي","client_title":"مدير تنفيذي","content":"أفضل مطعم في المدينة بلا منازع. الأكل لذيذ والخدمة ممتازة.","rating":5}', NULL, 1),
(9, 'testimonials', 'testimonial_2', '{"client_name":"هند العنزي","client_title":"مدونة طعام","content":"جربت العديد من المطاعم لكن هذا المطعم في مستوى آخر تماماً.","rating":5}', NULL, 2),
(9, 'contact', 'contact_info', '{"phone":"966500000333","whatsapp":"966500000333","email":"info@restaurant.com","address":"الرياض - حي الملقا - شارع الأمير محمد بن عبدالعزيز"}', '{"phone":"966500000333","whatsapp":"966500000333","email":"info@restaurant.com","address":"Riyadh - Al Malqa District - Prince Mohammed bin Abdulaziz Road"}', 1);

-- ثيم التعليم (education) - ID=10
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(10, 'hero', 'hero_title', 'استثمر في مستقبلك التعليمي', 'Invest in Your Educational Future', 1),
(10, 'hero', 'hero_subtitle', 'تعليم متميز يبني أجيالاً واعية ومبدعة', 'Distinguished education building aware and creative generations', 2),
(10, 'hero', 'hero_description', 'أكاديمية تعليمية رائدة تقدم برامج تعليمية وتدريبية متطورة بأحدث الأساليب التعليمية مع نخبة من أفضل المدربين والمتخصصين.', 'A leading educational academy offering advanced educational and training programs using the latest teaching methods with a selection of the best trainers and specialists.', 3),
(10, 'hero', 'hero_button_text', 'سجل الآن', 'Register Now', 4),
(10, 'about', 'about_title', 'من نحن', 'About Us', 1),
(10, 'about', 'about_text', 'أكاديمية تعليمية متخصصة تأسست بهدف تقديم تعليم عالي الجودة يواكب أحدث التطورات. نقدم برامج متنوعة تشمل الدورات التأهيلية والشهادات المهنية والتدريب العملي مع بيئة تعليمية محفزة.', 'A specialized educational academy established to provide high-quality education aligned with the latest developments. We offer diverse programs including qualification courses, professional certificates, and practical training in a motivating learning environment.', 2),
(10, 'services', 'service_1', '{"title_ar":"دورات حضورية","title_en":"Classroom Courses","description_ar":"دورات تدريبية حضورية بفصول مجهزة بأحدث التقنيات مع مدربين محترفين","description_en":"Classroom training courses in fully equipped halls with the latest technology and professional trainers","icon":"fas fa-chalkboard-teacher","show_on_home":1}', NULL, 1),
(10, 'services', 'service_2', '{"title_ar":"تعليم عن بعد","title_en":"Online Learning","description_ar":"برامج تعليمية إلكترونية متكاملة يمكنك التعلم منها في أي وقت ومن أي مكان","description_en":"Integrated e-learning programs you can study anytime and anywhere","icon":"fas fa-laptop","show_on_home":1}', NULL, 2),
(10, 'services', 'service_3', '{"title_ar":"تدريب مهني","title_en":"Professional Training","description_ar":"برامج تدريب مهني معتمدة لتطوير المهارات ورفع الكفاءة المهنية","description_en":"Accredited professional training programs to develop skills and enhance professional competence","icon":"fas fa-graduation-cap","show_on_home":1}', NULL, 3),
(10, 'services', 'service_4', '{"title_ar":"استشارات تعليمية","title_en":"Educational Consulting","description_ar":"استشارات متخصصة لاختيار المسار التعليمي المناسب وتخطيط المستقبل الأكاديمي","description_en":"Specialized consulting for choosing the right educational path and academic future planning","icon":"fas fa-route","show_on_home":1}', NULL, 4),
(10, 'testimonials', 'testimonial_1', '{"client_name":"أحمد الحربي","client_title":"طالب جامعي","content":"الدورات هنا ساعدتني كثيراً في تطوير مهاراتي والحصول على وظيفة ممتازة.","rating":5}', NULL, 1),
(10, 'testimonials', 'testimonial_2', '{"client_name":"لمى الزهراني","client_title":"مصممة جرافيك","content":"تعلمت هنا أساسيات التصميم بشكل احترافي. المدربون رائعون والمحتوى ممتاز.","rating":5}', NULL, 2),
(10, 'contact', 'contact_info', '{"phone":"966500000444","whatsapp":"966500000444","email":"info@academy.com","address":"الدمام - حي الفيصلية - شارع الأمير سلطان"}', '{"phone":"966500000444","whatsapp":"966500000444","email":"info@academy.com","address":"Dammam - Al Faisaliyah District - Prince Sultan Road"}', 1);

-- ثيم الرياضة (fitness) - ID=11
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(11, 'hero', 'hero_title', 'ابدأ رحلتك نحو اللياقة', 'Start Your Fitness Journey', 1),
(11, 'hero', 'hero_subtitle', 'نادي رياضي متكامل بأحدث المعدات وأفضل المدربين', 'Fully equipped gym with the latest equipment and best trainers', 2),
(11, 'hero', 'hero_description', 'نادي رياضي متكامل يوفر بيئة محفزة لتحقيق أهدافك اللياقية مع فريق من المدربين المعتمدين وأحدث الأجهزة الرياضية العالمية.', 'A fully equipped gym providing a motivating environment to achieve your fitness goals with a team of certified trainers and the latest international sports equipment.', 3),
(11, 'hero', 'hero_button_text', 'اشترك الآن', 'Join Now', 4),
(11, 'about', 'about_title', 'من نحن', 'About Us', 1),
(11, 'about', 'about_text', 'نادي رياضي رائد يهدف إلى نشر ثقافة اللياقة البدنية والحياة الصحية. نوفر مرافق عصرية تشمل صالة أوزان حرة وآلات، قاعات لليوغا والبيلاتس، مسبح أولمبي، وملاعب رياضية متعددة.', 'A leading sports club aiming to spread fitness culture and healthy living. We provide modern facilities including free weights and machines, yoga and pilates studios, Olympic pool, and multi-sport courts.', 2),
(11, 'services', 'service_1', '{"title_ar":"تدريب شخصي","title_en":"Personal Training","description_ar":"جلسات تدريب شخصي مع مدربين معتمدين لتصميم برامج مخصصة حسب أهدافك","description_en":"Personal training sessions with certified trainers to design programs tailored to your goals","icon":"fas fa-dumbbell","show_on_home":1}', NULL, 1),
(11, 'services', 'service_2', '{"title_ar":"يوجا وبيلاتس","title_en":"Yoga and Pilates","description_ar":"فصول يوجا وبيلاتس يومية لتحسين المرونة والاسترخاء الذهني","description_en":"Daily yoga and pilates classes to improve flexibility and mental relaxation","icon":"fas fa-spa","show_on_home":1}', NULL, 2),
(11, 'services', 'service_3', '{"title_ar":"برامج لياقة","title_en":"Fitness Programs","description_ar":"برامج لياقة متنوعة تشمل كارديو وقوة وتخسيس وزن وبناء عضلات","description_en":"Diverse fitness programs including cardio, strength, weight loss, and muscle building","icon":"fas fa-running","show_on_home":1}', NULL, 3),
(11, 'services', 'service_4', '{"title_ar":"تغذية صحية","title_en":"Healthy Nutrition","description_ar":"استشارات تغذية متخصصة مع خطط غذائية مخصصة لتحقيق أهدافك","description_en":"Specialized nutrition consultations with custom meal plans to achieve your goals","icon":"fas fa-apple-alt","show_on_home":1}', NULL, 4),
(11, 'testimonials', 'testimonial_1', '{"client_name":"عمر العتيبي","client_title":"مهندس","content":"خلال 3 أشهر فقط حققت هدفي في خسارة الوزن بفضل المدربين المحترفين هنا.","rating":5}', NULL, 1),
(11, 'testimonials', 'testimonial_2', '{"client_name":"سارة الغامدي","client_title":"محاسبة","content":"النادي نظيف جداً والأجهزة حديثة. أنصح الجميع بالاشتراك.","rating":5}', NULL, 2),
(11, 'contact', 'contact_info', '{"phone":"966500000555","whatsapp":"966500000555","email":"info@fitness-club.com","address":"الرياض - حي النرجس - شارع أنس بن مالك"}', '{"phone":"966500000555","whatsapp":"966500000555","email":"info@fitness-club.com","address":"Riyadh - Al Narjis District - Anas bin Malik Road"}', 1);

-- ثيم المحاماة (legal) - ID=12
INSERT IGNORE INTO theme_contents (theme_id, section_type, content_key, content_ar, content_en, sort_order) VALUES
(12, 'hero', 'hero_title', 'حقوقك محمية بقوة القانون', 'Your Rights Protected by Law', 1),
(12, 'hero', 'hero_subtitle', 'محامون متخصصون يضعون خبرتهم في خدمة عدالتك', 'Specialized lawyers putting their expertise at the service of your justice', 2),
(12, 'hero', 'hero_description', 'مكتب محاماة متخصص يقدم خدمات قانونية شاملة بأعلى معايير المهنية والسرية. نمتلك فريقاً من المحامين والاستشاريين القانونيين ذوي الخبرة الواسعة في مختلف فروع القانون.', 'A specialized law firm providing comprehensive legal services to the highest professional and confidential standards. We have a team of lawyers and legal consultants with extensive experience in various branches of law.', 3),
(12, 'hero', 'hero_button_text', 'احجز استشارة', 'Book Consultation', 4),
(12, 'about', 'about_title', 'من نحن', 'About Us', 1),
(12, 'about', 'about_text', 'مكتب محاماة راسخ يقدم خدمات قانونية متميزة منذ أكثر من 20 عاماً. نتعامل مع جميع أنواع القضايا المدنية والتجارية والعقارية والجنائية مع الالتزام بأعلى معايير السرية والأمانة المهنية.', 'An established law firm providing distinguished legal services for over 20 years. We handle all types of civil, commercial, real estate, and criminal cases while maintaining the highest standards of confidentiality and professional ethics.', 2),
(12, 'services', 'service_1', '{"title_ar":"استشارات قانونية","title_en":"Legal Consultations","description_ar":"استشارات قانونية متخصصة في جميع المجالات مع تحليل شامل للموقف القانوني","description_en":"Specialized legal consultations in all fields with comprehensive legal situation analysis","icon":"fas fa-gavel","show_on_home":1}', NULL, 1),
(12, 'services', 'service_2', '{"title_ar":"قانون الشركات","title_en":"Corporate Law","description_ar":"خدمات قانونية للشركات تشمل التأسيس والعقود والتحكيم التجاري","description_en":"Legal services for companies including incorporation, contracts, and commercial arbitration","icon":"fas fa-briefcase","show_on_home":1}', NULL, 2),
(12, 'services', 'service_3', '{"title_ar":"قضايا عقارية","title_en":"Real Estate Cases","description_ar":"تمثيل قانوني في القضايا العقارية ونزاعات الملكية وصياغة العقود","description_en":"Legal representation in real estate cases, property disputes, and contract drafting","icon":"fas fa-landmark","show_on_home":1}', NULL, 3),
(12, 'services', 'service_4', '{"title_ar":"قانون الأسرة","title_en":"Family Law","description_ar":"معالجة قضايا الأحوال الشخصية والطلاق والحضانة والنفقة","description_en":"Handling personal status cases, divorce, custody, and alimony","icon":"fas fa-users","show_on_home":1}', NULL, 4),
(12, 'testimonials', 'testimonial_1', '{"client_name":"ناصر العمري","client_title":"رجل أعمال","content":"محامون محترفون جداً. ساعدوني في حل نزاع تجاري معقد بنجاح.","rating":5}', NULL, 1),
(12, 'testimonials', 'testimonial_2', '{"client_name":"منال السلمي","client_title":"سيدة أعمال","content":"مكتب محترف ويتميز بالسرية التامة. أنصح أي شخص يحتاج مساعدة قانونية بالتعامل معهم.","rating":5}', NULL, 2),
(12, 'contact', 'contact_info', '{"phone":"966500000666","whatsapp":"966500000666","email":"info@lawfirm.com","address":"الرياض - حي العليا - برج المملكة - الطابق 15"}', '{"phone":"966500000666","whatsapp":"966500000666","email":"info@lawfirm.com","address":"Riyadh - Olaya District - Kingdom Tower - 15th Floor"}', 1);


-- ============================================
-- 3. تحديث حقل description_en للثيمات في جدول themes
-- ============================================

UPDATE themes SET description_en = 'Multi-purpose professional website template' WHERE slug = 'general' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Integrated electrical services with safety standards' WHERE slug = 'electric' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Professional cleaning services for homes and offices' WHERE slug = 'cleaning' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Luxury interior design and decoration services' WHERE slug = 'decor' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Professional maintenance services for homes and commercial buildings' WHERE slug = 'maintenance' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Professional plumbing and drainage services' WHERE slug = 'plumbing' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Medical clinic and healthcare website template' WHERE slug = 'medical' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Real estate and property management template' WHERE slug = 'realestate' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Restaurant and fine dining website template' WHERE slug = 'restaurant' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Education academy and training center template' WHERE slug = 'education' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Fitness gym and sports club template' WHERE slug = 'fitness' AND (description_en IS NULL OR description_en = '');
UPDATE themes SET description_en = 'Law firm and legal services template' WHERE slug = 'legal' AND (description_en IS NULL OR description_en = '');
