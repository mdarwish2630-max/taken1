-- =============================================
-- CMS Platform - Demo Data Part 4
-- بيانات تجريبية - الجزء الرابع: اشتراكات وإعدادات
-- =============================================

-- =============================================
-- اشتراكات تجريبية
-- =============================================

INSERT INTO `subscriptions` (`tenant_id`, `plan_name`, `amount`, `currency`, `start_date`, `end_date`, `status`, `payment_method`, `payment_reference`, `auto_renew`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'احترافي', 99, 'SAR', '2024-01-01', '2025-01-01', 'active', 'bank_transfer', 'TRX-2024-001', 1),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'احترافي', 99, 'SAR', '2024-02-01', '2025-02-01', 'active', 'mada', 'MD-2024-002', 1),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'المؤسسات', 199, 'SAR', '2024-01-15', '2025-01-15', 'active', 'bank_transfer', 'TRX-2024-003', 1),
( (SELECT id FROM tenants WHERE slug = 'plumbing-expert'), 'أساسي', 49, 'SAR', '2023-06-01', '2024-01-01', 'expired', 'apple_pay', 'AP-2023-004', 0);

-- =============================================
-- إعدادات SEO تجريبية
-- =============================================

-- استخدام INSERT IGNORE لتجنب خطأ التكرار
INSERT IGNORE INTO `seo_settings` (`tenant_id`, `google_analytics_id`, `google_tag_manager_id`, `facebook_pixel_id`, `canonical_url`, `twitter_card_type`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'G-XXXXXX001', 'GTM-XXXX01', '123456789012345', 'https://golden-maintenance.com', 'summary_large_image'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'G-XXXXXX002', 'GTM-XXXX02', '123456789012346', 'https://decor-style.com', 'summary_large_image'),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'G-XXXXXX003', 'GTM-XXXX03', NULL, 'https://electric-pro.com', 'summary_large_image');

-- =============================================
-- إعدادات الثيم تجريبية
-- =============================================

INSERT IGNORE INTO `theme_settings` (`tenant_id`, `font_primary`, `font_secondary`, `border_radius`, `header_style`, `footer_style`, `custom_css`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'Tajawal', 'Tajawal', '8', 'default', 'expanded', '/* Custom styles */\n.hero-title { font-weight: 800; }'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'Cairo', 'Tajawal', '12', 'centered', 'minimal', '/* Elegant styles */\n.card { border-radius: 16px; }'),
( (SELECT id FROM tenants WHERE slug = 'electric-pro'), 'Tajawal', 'Tajawal', '4', 'minimal', 'default', NULL);

-- =============================================
-- صفحات إضافية
-- =============================================

-- صفحات موقع الصيانة الذهبية
INSERT INTO `pages` (`tenant_id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `template`, `is_home`, `show_in_menu`, `menu_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'لماذا نحن', 'why-us', '<h2>لماذا تختارنا؟</h2><p>نحن شركة رائدة في مجال الصيانة المنزلية منذ أكثر من 10 سنوات. نتميز بـ:</p><ul><li><strong>فريق فني متخصص ومعتمد</strong> - جميع فنيينا حاصلون على شهادات معتمدة</li><li><strong>استخدام أحدث المعدات والتقنيات</strong> - نستخدم أجهزة كشف متطورة</li><li><strong>ضمان على جميع الأعمال</strong> - نقدم ضمان يصل إلى سنة</li><li><strong>أسعار تنافسية وشفافة</strong> - لا رسوم مخفية</li><li><strong>خدمة عملاء متميزة 24/7</strong> - فريق متاح على مدار الساعة</li></ul><h3>أرقام تتحدث</h3><p>أكثر من <strong>5000 عميل راضي</strong> و <strong>15000 عملية صيانة</strong> ناجحة منذ تأسيسنا.</p>', 'لماذا تختار شركة الصيانة الذهبية', 'أسباب تجعلنا الخيار الأفضل لخدمات الصيانة المنزلية', 'default', 0, 1, 5, 'published'),
( (SELECT id FROM tenants WHERE slug = 'golden-maintenance'), 'الأسئلة الشائعة', 'faq', '<h2>الأسئلة الشائعة</h2><h3>ما هي مناطق التغطية؟</h3><p>نغطي جميع أحياء الرياض ونخدم المناطق المجاورة.</p><h3>هل تقدمون ضمان؟</h3><p>نعم، نقدم ضمان على جميع الأعمال يتراوح من 3 أشهر إلى سنة حسب نوع الخدمة.</p><h3>ما هي طرق الدفع؟</h3><p>نقبل الدفع نقداً، تحويل بنكي، مدى، أبل باي.</p><h3>هل تعملون في العطل؟</h3><p>نعم، نعمل 7 أيام في الأسبوع بما في ذلك العطل.</p>', 'أسئلة شائعة - الصيانة الذهبية', 'إجابات على أكثر الأسئلة شيوعاً', 'default', 0, 1, 6, 'published');

-- صفحات موقع أناقة الديكور
INSERT INTO `pages` (`tenant_id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `template`, `is_home`, `show_in_menu`, `menu_order`, `status`) VALUES
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'مشاريعنا', 'projects', '<h2>مشاريعنا المميزة</h2><p>نفخر بأننا نفذنا أكثر من <strong>500 مشروع</strong> في جميع أنحاء المملكة:</p><div class="row"><div class="col-md-6"><h3>فلل سكنية</h3><p>أكثر من 200 فيلا بتصاميم فاخرة</p></div><div class="col-md-6"><h3>شقق فندقية</h3><p>تشطيبات بمعايير خمس نجوم</p></div></div><div class="row"><div class="col-md-6"><h3>مكاتب وشركات</h3><p>تصاميم مهنية عصرية</p></div><div class="col-md-6"><h3>محلات تجارية</h3><p>واجهات جذابة وتصاميم عملية</p></div></div>', 'مشاريع أناقة الديكور', 'استعرض أحدث مشاريعنا في التصميم الداخلي', 'default', 0, 1, 5, 'published'),
( (SELECT id FROM tenants WHERE slug = 'decor-style'), 'عملية العمل', 'process', '<h2>كيف نعمل؟</h2><ol><li><strong>الاستشارة المجانية</strong> - نستمع لرؤيتك ومتطلباتك</li><li><strong>التصميم 3D</strong> - نقدم لك تصور واقعي للمشروع</li><li><strong>الموافقة والميزانية</strong> - نتفق على التفاصيل والتكلفة</li><li><strong>التنفيذ</strong> - فريقنا يبدأ العمل بجدول زمني محدد</li><li><strong>التسليم</strong> - نسلمك المشروع جاهزاً مع الضمان</li></ol>', 'عملية العمل - أناقة الديكور', 'تعرف على خطوات تنفيذ مشروعك معنا', 'default', 0, 1, 6, 'published');

-- =============================================
-- تحديث الأعمدة في جدول themes
-- =============================================

-- أضف الأعمدة إذا لم تكن موجودة (إذا ظهر خطأ تجاهله)
-- ALTER TABLE `themes` ADD COLUMN `primary_color` VARCHAR(7) DEFAULT '#2563eb';
-- ALTER TABLE `themes` ADD COLUMN `secondary_color` VARCHAR(7) DEFAULT '#1e40af';
-- ALTER TABLE `themes` ADD COLUMN `accent_color` VARCHAR(7) DEFAULT '#f59e0b';

-- تحديث وصف الثيمات
UPDATE `themes` SET `description` = 'قالب متخصص لشركات الصيانة والإصلاحات المنزلية' WHERE `slug` = 'maintenance';
UPDATE `themes` SET `description` = 'قالب أنيق لشركات الديكور والتصميم الداخلي' WHERE `slug` = 'decor';
UPDATE `themes` SET `description` = 'قالب احترافي للكهربائيين وشركات الكهرباء' WHERE `slug` = 'electric';
UPDATE `themes` SET `description` = 'قالب متخصص للسباكين وشركات السباكة' WHERE `slug` = 'plumbing';
UPDATE `themes` SET `description` = 'قالب منعش لشركات التنظيف' WHERE `slug` = 'cleaning';
UPDATE `themes` SET `description` = 'قالب عام مناسب لجميع أنواع الخدمات' WHERE `slug` = 'general';

SELECT 'تم إضافة الاشتراكات والإعدادات والصفحات بنجاح!' as message;
SELECT 'تم تحميل جميع البيانات التجريبية بنجاح!' as final_message;
