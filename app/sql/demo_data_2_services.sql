-- =============================================
-- CMS Platform - Demo Data Part 2
-- بيانات تجريبية - الجزء الثاني: الخدمات
-- =============================================

-- =============================================
-- خدمات موقع الصيانة الذهبية
-- =============================================
INSERT INTO `services` (`tenant_id`, `title`, `slug`, `description`, `content`, `icon`, `price_text`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'صيانة المكيفات', 'ac-maintenance', 'صيانة شاملة لجميع أنواع المكيفات سبليت وشباك', '<h3>خدمة صيانة المكيفات</h3><p>نقدم خدمة صيانة شاملة للمكيفات تشمل:</p><ul><li>تنظيف الوحدة الداخلية والخارجية</li><li>فحص الفريون وإعادة تعبئته</li><li>فحص الأسلاك والتمديدات</li><li>تغيير الفلاتر</li></ul><p>نوفر خدمة صيانة دورية بأسعار مخفضة.</p>', 'fas fa-snowflake', 'يبدأ من 150 ريال', 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'سباكة منزلية', 'plumbing', 'إصلاح تسربات، تركيب صحية، تمديدات مياه', '<h3>خدمات السباكة</h3><p>فريق متخصص في جميع أعمال السباكة:</p><ul><li>كشف وإصلاح التسربات</li><li>تركيب وصيانة الصحية</li><li>تمديدات مياه ساخنة وباردة</li><li>تسليك مجاري</li></ul>', 'fas fa-wrench', 'حسب المعاينة', 1, 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'كهرباء منزلية', 'electricity', 'تمديدات كهربائية، إصلاح أعطال، تركيب إضاءة', '<h3>خدمات الكهرباء</h3><p>كهربائيون معتمدون لجميع الأعمال:</p><ul><li>تمديدات كهربائية جديدة</li><li>إصلاح دوائر قصر</li><li>تركيب إضاءة LED</li><li>صيانة لوحات كهربائية</li></ul>', 'fas fa-bolt', 'يبدأ من 100 ريال', 1, 3, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'صيانة الأجهزة', 'appliances', 'إصلاح غسالات، ثلاجات، أفران', '<h3>صيانة الأجهزة المنزلية</h3><p>نصلح جميع الأجهزة:</p><ul><li>غسالات ملابس وصحون</li><li>ثلاجات ومجمدات</li><li>أفران وميكروويف</li><li>سخانات مياه</li></ul>', 'fas fa-tools', 'حسب نوع العطل', 1, 4, 'active');

-- =============================================
-- خدمات موقع محترفو الكهرباء
-- =============================================
INSERT INTO `services` (`tenant_id`, `title`, `slug`, `description`, `content`, `icon`, `price_text`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'تمديدات كهربائية', 'wiring', 'تمديدات كهربائية جديدة للمنازل والمكاتب', '<h3>تمديدات كهربائية</h3><p>تمديدات احترافية بمعايير عالية:</p><ul><li>تخطيط وتصميم الشبكة</li><li>تركيب الأسلاك المعتمدة</li><li>تركيب المفاتيح والمآخذ</li><li>اختبار وتشغيل</li></ul>', 'fas fa-plug', 'يبدأ من 500 ريال', 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'إصلاح أعطال', 'repairs', 'إصلاح جميع الأعطال الكهربائية بسرعة واحتراف', '<h3>إصلاح الأعطال</h3><p>خدمة سريعة لإصلاح:</p><ul><li>دوائر قصر</li><li>انقطاع التيار</li><li>ارتفاع درجة الحرارة</li><li>مشاكل المفاتيح</li></ul>', 'fas fa-exclamation-triangle', 'يبدأ من 150 ريال', 1, 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'إضاءة LED', 'led-lighting', 'تركيب إضاءة LED داخلية وخارجية', '<h3>إضاءة LED</h3><p>حلول إضاءة حديثة:</p><ul><li>إضاءة داكنة (Dimmable)</li><li>إضاءة ذكية</li><li>سبوت لايت</li><li>إضاءة خارجية</li></ul>', 'fas fa-lightbulb', 'حسب المساحة', 1, 3, 'active'),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'طوارئ 24 ساعة', 'emergency', 'خدمة طوارئ على مدار الساعة', '<h3>خدمة الطوارئ</h3><p>متاحون 24 ساعة:</p><ul><li>استجابة سريعة</li><li>فريق متاح دائماً</li><li>تغطية كافة المناطق</li></ul>', 'fas fa-ambulance', 'اتصل الآن', 1, 4, 'active');

-- =============================================
-- خدمات موقع بيت نظيف
-- =============================================
INSERT INTO `services` (`tenant_id`, `title`, `slug`, `description`, `content`, `icon`, `price_text`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'تنظيف فلل', 'villa-cleaning', 'تنظيف شامل للفلل والقصور', '<h3>تنظيف الفلل</h3><p>خدمة تنظيف شاملة:</p><ul><li>تنظيف جميع الغرف</li><li>تنظيف الحمامات والمطبخ</li><li>تنظيف الزجاج والنوافذ</li><li>تعقيم وتطهير</li></ul>', 'fas fa-home', 'يبدأ من 300 ريال', 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'تنظيف شقق', 'apartment-cleaning', 'تنظيف شامل للشقق', '<h3>تنظيف الشقق</h3><p>خدمة سريعة ومميزة:</p><ul><li>تنظيف الغرف والصالات</li><li>تنظيف المطبخ</li><li>تنظيف الحمامات</li><li>كنس ومسح الأرضيات</li></ul>', 'fas fa-building', 'يبدأ من 150 ريال', 1, 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'تنظيف موكيت وسجاد', 'carpet-cleaning', 'غسيل وتنظيف الموكيت والسجاد', '<h3>تنظيف الموكيت والسجاد</h3><p>أحدث التقنيات:</p><ul><li>غسيل بالبخار</li><li>إزالة البقع</li><li>تعقيم من الجراثيم</li><li>تجفيف سريع</li></ul>', 'fas fa-square', '50 ريال/متر', 1, 3, 'active'),
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'تنظيف مكاتب', 'office-cleaning', 'تنظيف المكاتب والشركات', '<h3>تنظيف المكاتب</h3><p>خدمة مؤسسية:</p><ul><li>تنظيف يومي/أسبوعي</li><li>تعقيم الأسطح</li><li>تنظيف الزجاج</li><li>تفريغ سلال المهملات</li></ul>', 'fas fa-briefcase', 'عقد شهري', 1, 4, 'active');

-- =============================================
-- خدمات موقع أناقة الديكور
-- =============================================
INSERT INTO `services` (`tenant_id`, `title`, `slug`, `description`, `content`, `icon`, `price_text`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'تصميم داخلي', 'interior-design', 'تصاميم داخلية عصرية وفاخرة', '<h3>التصميم الداخلي</h3><p>رؤية فنية مميزة:</p><ul><li>تصميم 3D</li><li>اختيار الألوان والمواد</li><li>توزيع الفراغات</li><li>استشارة مجانية</li></ul>', 'fas fa-drafting-compass', 'يبدأ من 3000 ريال', 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'تشطيب فلل', 'villa-finishing', 'تشطيبات فاخرة للفلل', '<h3>تشطيب الفلل</h3><p>جودة عالية:</p><ul><li>أعمال الدهانات</li><li>تركيب الأرضيات</li><li>أعمال الجبس بورد</li><li>تركيب الأسقف المعلقة</li></ul>', 'fas fa-paint-roller', 'حسب المساحة', 1, 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'ديكور غرف نوم', 'bedroom-decor', 'تصميم وتنفيذ غرف نوم أنيقة', '<h3>ديكور غرف النوم</h3><p>راحة وأناقة:</p><ul><li>تصميم الأسرة</li><li>خزائن ملابس</li><li>إضاءة ناعمة</li><li>ستائر متناسقة</li></ul>', 'fas fa-bed', 'يبدأ من 5000 ريال', 1, 3, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'ديكور مطابخ', 'kitchen-decor', 'تصميم وتنفيذ مطابخ عصرية', '<h3>ديكور المطابخ</h3><p>وظائف وجمال:</p><ul><li>خزائن مودرن</li><li>رخام صناعي</li><li>إضاءة LED</li><li>أجهزة مدمجة</li></ul>', 'fas fa-utensils', 'يبدأ من 15000 ريال', 1, 4, 'active');

-- =============================================
-- خدمات موقع خبير السباكة
-- =============================================
INSERT INTO `services` (`tenant_id`, `title`, `slug`, `description`, `content`, `icon`, `price_text`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'plumbing-expert'), 'كشف تسربات', 'leak-detection', 'كشف التسربات بأحدث الأجهزة', '<h3>كشف التسربات</h3><p>تقنية متطورة:</p><ul><li>أجهزة كشف حرارية</li><li>كاميرات فحص</li><li>تحديد دقيق للعطل</li><li>تقرير مفصل</li></ul>', 'fas fa-search', 'يبدأ من 200 ريال', 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'plumbing-expert'), 'تركيب صحية', 'sanitary-installation', 'تركيب جميع أنواع الصحية', '<h3>تركيب الصحية</h3><p>أعمال احترافية:</p><ul><li>مراحيض ومغاسل</li><li>بانيو وجاكوزي</li><li>خلاطات</li><li>سخانات مياه</li></ul>', 'fas fa-toilet', 'يبدأ من 100 ريال', 1, 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'plumbing-expert'), 'تسليك مجاري', 'drainage', 'تسليك وتنظيف المجاري', '<h3>تسليك المجاري</h3><p>حلول سريعة:</p><ul><li>ماكينات تسليك</li><li>تنظيف بالضغط</li><li>صيانة دورية</li><li>ضمان على العمل</li></ul>', 'fas fa-water', 'يبدأ من 150 ريال', 1, 3, 'active');

-- =============================================
-- خدمات موقع خدمات الأمان
-- =============================================
INSERT INTO `services` (`tenant_id`, `title`, `slug`, `description`, `content`, `icon`, `price_text`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'aman-services'), 'نقل عفش', 'moving', 'نقل الأثاث والأعفة بأمان', '<h3>نقل العفش</h3><p>خدمة شاملة:</p><ul><li>تغليف احترافي</li><li>فك وتركيب</li><li>سيارات مغلقة</li><li>تأمين على الممتلكات</li></ul>', 'fas fa-truck', 'يبدأ من 500 ريال', 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'aman-services'), 'مكافحة حشرات', 'pest-control', 'مكافحة جميع أنواع الحشرات', '<h3>مكافحة الحشرات</h3><p>مواد آمنة:</p><ul><li>رش مبيدات</li><li>فخاخ الفئران</li><li>علاج النمل الأبيض</li><li>ضمان 6 أشهر</li></ul>', 'fas fa-bug', 'يبدأ من 200 ريال', 1, 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'aman-services'), 'عزل أسطح', 'roof-insulation', 'عزل مائي وحراري للأسطح', '<h3>عزل الأسطح</h3><p>حماية شاملة:</p><ul><li>عزل مائي</li><li>عزل حراري</li><li>مواد عالية الجودة</li><li>ضمان 10 سنوات</li></ul>', 'fas fa-shield-alt', 'حسب المساحة', 1, 3, 'active');

SELECT 'تم إضافة الخدمات بنجاح!' as message;
