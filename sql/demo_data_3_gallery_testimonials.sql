-- =============================================
-- CMS Platform - Demo Data Part 3
-- بيانات تجريبية - الجزء الثالث: معرض، آراء، بانرات
-- =============================================

-- =============================================
-- صور المعرض
-- =============================================

-- صور موقع الصيانة الذهبية
INSERT INTO `gallery` (`tenant_id`, `title`, `description`, `image`, `category`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'صيانة مكيف سبليت', 'صيانة شاملة لمكيف سبليت', 'uploads/gallery/ac-1.jpg', 'مكيفات', 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'تصليح تسريب مياه', 'كشف وإصلاح تسريب', 'uploads/gallery/plumbing-1.jpg', 'سباكة', 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'تركيب لوحة كهربائية', 'تركيب لوحة جديدة', 'uploads/gallery/electric-1.jpg', 'كهرباء', 3, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'فريق العمل', 'فريقنا المتخصص', 'uploads/gallery/team-1.jpg', 'فريق', 4, 'active');

-- صور موقع أناقة الديكور
INSERT INTO `gallery` (`tenant_id`, `title`, `description`, `image`, `category`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'غرفة نوم رئيسية', 'تصميم فاخر لغرفة نوم', 'uploads/gallery/bedroom-1.jpg', 'غرف نوم', 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'مطبخ عصري', 'مطبخ بتصميم مودرن', 'uploads/gallery/kitchen-1.jpg', 'مطابخ', 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'صالة استقبال', 'صالة أنيقة', 'uploads/gallery/living-1.jpg', 'صالات', 3, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'حمام فاخر', 'تصميم حمام راقي', 'uploads/gallery/bathroom-1.jpg', 'حمامات', 4, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'غرفة أطفال', 'تصميم مميز للأطفال', 'uploads/gallery/kids-1.jpg', 'غرف أطفال', 5, 'active');

-- صور موقع بيت نظيف
INSERT INTO `gallery` (`tenant_id`, `title`, `description`, `image`, `category`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'تنظيف فيلا', 'قبل وبعد التنظيف', 'uploads/gallery/clean-1.jpg', 'فلل', 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'غسيل موكيت', 'غسيل بالبخار', 'uploads/gallery/carpet-1.jpg', 'موكيت', 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'تنظيف مكتب', 'خدمة تنظيف مكاتب', 'uploads/gallery/office-1.jpg', 'مكاتب', 3, 'active');

-- =============================================
-- آراء العملاء
-- =============================================

-- آراء موقع الصيانة الذهبية
INSERT INTO `testimonials` (`tenant_id`, `client_name`, `client_title`, `content`, `rating`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'عبدالله محمد', 'مالك فيلا', 'خدمة ممتازة وسريعة. جاءوا في الموعد وأصلحوا المكيف بكفاءة عالية. أنصح الجميع بالتعامل معهم.', 5, 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'نورة السالم', 'ربة منزل', 'تعاملت معهم لإصلاح تسريب في المطبخ. عمل نظيف وسعر معقول. شكراً لفريق العمل.', 5, 1, 2, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'فهد العتيبي', 'صاحب شركة', 'تعاقدنا معهم للصيانة الدورية لمكاتبنا. خدمة احترافية والتزام بالموعد.', 4, 1, 3, 'active');

-- آراء موقع أناقة الديكور
INSERT INTO `testimonials` (`tenant_id`, `client_name`, `client_title`, `content`, `rating`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'منى الغامدي', 'مالكة فيلا', 'صمموا لي فيلتي بالكامل. ذوق رائع والتزام بالميزانية. شكراً سارة وفريقك.', 5, 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'خالد العمري', 'رجل أعمال', 'شركة محترفة جداً. التصميم 3D كان مطابق للواقع 100%. أنصح بهم.', 5, 1, 2, 'active');

-- آراء موقع بيت نظيف
INSERT INTO `testimonials` (`tenant_id`, `client_name`, `client_title`, `content`, `rating`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'أم محمد', 'ربة منزل', 'شركة التنظيف هذه رائعة! الفلية صارت نظيفة جداً والأسعار معقولة.', 5, 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'سعود الشمري', 'موظف', 'نظفوا شقتي بشكل ممتاز. فريق محترم ومنظم. سأتكرر معهم.', 4, 1, 2, 'active');

-- آراء موقع محترفو الكهرباء
INSERT INTO `testimonials` (`tenant_id`, `client_name`, `client_title`, `content`, `rating`, `show_on_home`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'يوسف الحربي', 'مالك عقار', 'خدمة 24 ساعة حقيقية! جاءوا منتصف الليل وأصلحوا العطل. شكراً لكم.', 5, 1, 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'هند القحطاني', 'صاحبة منزل', 'ركبوا لي إضاءة LED في البيت كله. عمل ممتاز وفاتورة الكهرباء قلت 40%!', 5, 1, 2, 'active');

-- =============================================
-- البانرات
-- =============================================

-- بانرات موقع الصيانة الذهبية
INSERT INTO `banners` (`tenant_id`, `title`, `subtitle`, `description`, `image`, `link`, `button_text`, `position`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'خدمة صيانة متميزة', 'نحن هنا لخدمتك', 'صيانة منزلية شاملة بأيدي خبراء معتمدين. اتصل الآن واحصل على خصم 20%', 'uploads/banners/hero-1.jpg', '/services', 'احجز الآن', 'hero', 1, 'active'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'عرض الصيف', 'خصم 30% على صيانة المكيفات', 'استعد للصيف مع عرض خاص على صيانة المكيفات', 'uploads/banners/offer-1.jpg', '/service/ac-maintenance', 'اطلب العرض', 'slider', 2, 'active');

-- بانرات موقع أناقة الديكور
INSERT INTO `banners` (`tenant_id`, `title`, `subtitle`, `description`, `image`, `link`, `button_text`, `position`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'حول منزلك إلى تحفة فنية', 'تصاميم داخلية فاخرة', 'نحول أحلامك إلى واقع. استشارة مجانية لأول مرة', 'uploads/banners/decor-hero.jpg', '/services', 'احجز استشارة', 'hero', 1, 'active');

-- بانرات موقع بيت نظيف
INSERT INTO `banners` (`tenant_id`, `title`, `subtitle`, `description`, `image`, `link`, `button_text`, `position`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'بيت نظيف = حياة صحية', 'خدمات تنظيف احترافية', 'نظافة شاملة لمنزلك بأحدث المعدات وأجود المنظفات', 'uploads/banners/clean-hero.jpg', '/services', 'احجز الآن', 'hero', 1, 'active');

-- بانرات موقع محترفو الكهرباء
INSERT INTO `banners` (`tenant_id`, `title`, `subtitle`, `description`, `image`, `link`, `button_text`, `position`, `display_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'خدمة طوارئ 24 ساعة', 'نحن متاحون دائماً', 'فريقنا جاهز للتعامل مع أي طوارئ كهربائية على مدار الساعة', 'uploads/banners/electric-hero.jpg', '/service/emergency', 'اتصل الآن', 'hero', 1, 'active');

-- =============================================
-- رسائل التواصل
-- =============================================

INSERT INTO `contact_messages` (`tenant_id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'محمد أحمد', 'mohmed@email.com', '0512345678', 'استفسار عن صيانة مكيف', 'مرحباً، أريد الاستفسار عن سعر صيانة مكيف سبليت. هل يوجد ضمان على العمل؟', 0),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'سارة علي', 'sara@email.com', '0523456789', 'طلب خدمة سباكة', 'عندي تسريب في المطبخ وأحتاج فني سباكة بأسرع وقت.', 1),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'فاطمة خالد', 'fatima@email.com', '0534567890', 'تصميم داخلي لفيلا', 'أريد تصميم داخلي لفيلا جديدة 400 متر. هل يمكن جدولة موعد للمعاينة؟', 0),
( (SELECT id FROM tenants WHERE slug = 'clean-home'), 'عبدالرحمن', 'abdulrahman@email.com', '0545678901', 'تنظيف شقة', 'أحتاج تنظيف شقة 3 غرف. ما هي الأسعار وطريقة الحجز؟', 1),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'خالد سعد', 'khalid@email.com', '0556789012', 'تمديدات جديدة', 'أريد عمل تمديدات كهربائية لمبنى جديد. أرجو التواصل للتفاصيل.', 0);

SELECT 'تم إضافة المعرض وآراء العملاء والبانرات بنجاح!' as message;
