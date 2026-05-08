-- =============================================
-- CMS Platform - Demo Data Part 1
-- بيانات تجريبية - الجزء الأول
-- =============================================

-- =============================================
-- 1. مستخدمين تجريبيين
-- =============================================

-- مستخدم 1: شركة صيانة
INSERT INTO `users` (`email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`) VALUES
('ahmed@maintenance-sa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'أحمد الصيانة', '0501234567', 'customer', 'active', 1);

-- مستخدم 2: كهربائي
INSERT INTO `users` (`email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`) VALUES
('mohammed@electric-pro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'محمد الكهربائي', '0502345678', 'customer', 'active', 1);

-- مستخدم 3: شركة تنظيف
INSERT INTO `users` (`email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`) VALUES
('fatima@clean-home.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'فاطمة التنظيف', '0503456789', 'customer', 'active', 1);

-- مستخدم 4: ديكور
INSERT INTO `users` (`email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`) VALUES
('sara@decor-style.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'سارة الديكور', '0504567890', 'customer', 'active', 1);

-- مستخدم 5: سباكة
INSERT INTO `users` (`email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`) VALUES
('khalid@plumbing-expert.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'خالد السباك', '0505678901', 'customer', 'active', 1);

-- مستخدم 6: خدمات عامة
INSERT INTO `users` (`email`, `password`, `full_name`, `phone`, `role`, `status`, `email_verified`) VALUES
('omar@general-services.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'عمر الخدمات', '0506789012', 'customer', 'active', 1);

-- =============================================
-- 2. مواقع تجريبية (Tenants)
-- =============================================

-- موقع 1: صيانة
INSERT INTO `tenants` (`user_id`, `site_name`, `slug`, `subdomain`, `theme_id`, `subscription_status`, `subscription_start`, `subscription_end`, `trial_ends_at`, `site_status`, `contact_email`, `contact_phone`, `contact_whatsapp`, `address`, `working_hours`, `facebook`, `instagram`, `meta_title`, `meta_description`, `primary_color`, `secondary_color`, `accent_color`, `subscription_plan_id`, `auto_renew`) VALUES
( (SELECT id FROM users WHERE email = 'ahmed@maintenance-sa.com'),
  'شركة الصيانة الذهبية', 'golden-maintenance', 'golden-maintenance', 1, 'active', '2024-01-01', '2025-01-01', '2024-01-15', 'published',
  'info@golden-maintenance.com', '0501234567', '966501234567', 'الرياض - حي النزهة', 'السبت - الخميس: 8 ص - 10 م',
  'https://facebook.com/goldenmaintenance', 'https://instagram.com/goldenmaintenance',
  'شركة الصيانة الذهبية | صيانة منزلية شاملة', 'شركة رائدة في خدمات الصيانة المنزلية بالرياض',
  '#ea580c', '#1e3a5f', '#3b82f6', 3, 1);

-- موقع 2: كهرباء
INSERT INTO `tenants` (`user_id`, `site_name`, `slug`, `subdomain`, `theme_id`, `subscription_status`, `subscription_start`, `subscription_end`, `trial_ends_at`, `site_status`, `contact_email`, `contact_phone`, `contact_whatsapp`, `address`, `working_hours`, `meta_title`, `meta_description`, `primary_color`, `secondary_color`, `accent_color`, `subscription_plan_id`) VALUES
( (SELECT id FROM users WHERE email = 'mohammed@electric-pro.com'),
  'محترفو الكهرباء', 'electric-pro', 'electric-pro', 3, 'active', '2024-02-01', '2025-02-01', '2024-02-15', 'published',
  'info@electric-pro.com', '0502345678', '966502345678', 'جدة - حي الروضة',
  '24 ساعة - 7 أيام',
  'محترفو الكهرباء | تمديدات وصيانة كهربائية', 'خدمات كهربائية احترافية',
  '#fbbf24', '#d97706', '#1f2937', 3);

-- موقع 3: تنظيف (تجريبي)
INSERT INTO `tenants` (`user_id`, `site_name`, `slug`, `subdomain`, `theme_id`, `subscription_status`, `trial_ends_at`, `site_status`, `contact_email`, `contact_phone`, `contact_whatsapp`, `address`, `working_hours`, `meta_title`, `meta_description`, `primary_color`, `secondary_color`, `accent_color`) VALUES
( (SELECT id FROM users WHERE email = 'fatima@clean-home.com'),
  'بيت نظيف', 'clean-home', 'clean-home', 5, 'trial', DATE_ADD(NOW(), INTERVAL 14 DAY), 'published',
  'info@clean-home.com', '0503456789', '966503456789', 'الدمام - حي الفيصلية',
  'السبت - الخميس: 7 ص - 9 م',
  'بيت نظيف | خدمات تنظيف منزلية', 'خدمات تنظيف منزلية احترافية',
  '#10b981', '#059669', '#fbbf24');

-- موقع 4: ديكور
INSERT INTO `tenants` (`user_id`, `site_name`, `slug`, `subdomain`, `theme_id`, `subscription_status`, `subscription_start`, `subscription_end`, `trial_ends_at`, `site_status`, `contact_email`, `contact_phone`, `contact_whatsapp`, `address`, `working_hours`, `facebook`, `instagram`, `meta_title`, `meta_description`, `primary_color`, `secondary_color`, `accent_color`, `subscription_plan_id`) VALUES
( (SELECT id FROM users WHERE email = 'sara@decor-style.com'),
  'أناقة الديكور', 'decor-style', 'decor-style', 2, 'active', '2024-01-15', '2025-01-15', '2024-01-30', 'published',
  'info@decor-style.com', '0504567890', '966504567890', 'الرياض - حي العليا',
  'الأحد - الخميس: 10 ص - 10 م',
  'https://facebook.com/decorstyle', 'https://instagram.com/decorstyle',
  'أناقة الديكور | تصميم داخلي وديكور', 'شركة تصميم داخلي رائدة',
  '#8b5cf6', '#6d28d9', '#fbbf24', 4);

-- موقع 5: سباكة (منتهي)
INSERT INTO `tenants` (`user_id`, `site_name`, `slug`, `subdomain`, `theme_id`, `subscription_status`, `subscription_start`, `subscription_end`, `trial_ends_at`, `site_status`, `contact_email`, `contact_phone`, `contact_whatsapp`, `address`, `working_hours`, `meta_title`, `meta_description`, `primary_color`, `secondary_color`, `accent_color`) VALUES
( (SELECT id FROM users WHERE email = 'khalid@plumbing-expert.com'),
  'خبير السباكة', 'plumbing-expert', 'plumbing-expert', 4, 'expired', '2023-06-01', '2024-01-01', '2023-06-15', 'draft',
  'info@plumbing-expert.com', '0505678901', '966505678901', 'مكة المكرمة - حي العزيزية',
  '24 ساعة - 7 أيام',
  'خبير السباكة | خدمات سباكة احترافية', 'خدمات سباكة شاملة',
  '#0ea5e9', '#0284c7', '#fbbf24');

-- موقع 6: خدمات عامة (تجريبي)
INSERT INTO `tenants` (`user_id`, `site_name`, `slug`, `subdomain`, `theme_id`, `subscription_status`, `trial_ends_at`, `site_status`, `contact_email`, `contact_phone`, `contact_whatsapp`, `address`, `working_hours`, `meta_title`, `meta_description`, `primary_color`, `secondary_color`, `accent_color`) VALUES
( (SELECT id FROM users WHERE email = 'omar@general-services.com'),
  'خدمات الأمان', 'aman-services', 'aman-services', 6, 'trial', DATE_ADD(NOW(), INTERVAL 7 DAY), 'draft',
  'info@aman-services.com', '0506789012', '966506789012', 'المدينة المنورة - حي قباء',
  'السبت - الخميس: 8 ص - 8 م',
  'خدمات الأمان | خدمات منزلية متكاملة', 'خدمات منزلية شاملة',
  '#2563eb', '#1e40af', '#f59e0b');

SELECT 'تم إضافة المستخدمين والمواقع بنجاح!' as message;
