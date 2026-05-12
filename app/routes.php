<?php
/**
 * CMS Platform - Routes
 * تعريف المسارات
 */

// ==================== الصفحات الرئيسية ====================
Router::get('/', 'SiteController@index');

// ==================== تغيير اللغة ====================
Router::get('/lang/{lang}', 'LanguageController@change');
Router::get('/lang/current', 'LanguageController@current');
Router::post('/dashboard/settings/language', 'LanguageController@changeSiteLanguage');

// ==================== المصادقة ====================
Router::get('/login', 'AuthController@login');
Router::post('/login', 'AuthController@doLogin');
Router::get('/register', 'AuthController@register');
Router::post('/register', 'AuthController@doRegister');
Router::get('/logout', 'AuthController@logout');
Router::get('/forgot-password', 'AuthController@forgotPassword');
Router::post('/forgot-password', 'AuthController@sendResetLink');
Router::get('/reset-password/{token}', 'AuthController@resetPassword');
Router::post('/reset-password', 'AuthController@updatePassword');
Router::get('/verify-email/{token}', 'AuthController@verifyEmail');
Router::post('/resend-verification', 'AuthController@resendVerification');

// صفحة انتظار تأكيد البريد الإلكتروني
Router::get('/verification-pending', 'AuthController@verificationPending');
// إعادة إرسال تأكيد البريد بدون تسجيل دخول
Router::post('/resend-verification-public', 'AuthController@resendVerificationPublic');

// تحديث كابتشا (AJAX)
Router::get('/captcha/refresh', function() {
    header('Content-Type: application/json; charset=utf-8');
    $captcha = Security::generateCaptcha();
    echo json_encode(['question' => $captcha['question']]);
    exit;
});

// مسارات بديلة للتوافق
Router::get('/auth/login', 'AuthController@login');
Router::get('/auth/register', 'AuthController@register');
Router::get('/auth/logout', 'AuthController@logout');

// ==================== إنشاء موقع جديد ====================
Router::group(['middleware' => 'auth'], function() {
    // ✅ معاينة ديمو الثيم (قالب واحد - نوفا)

    Router::get('/site/create', 'SiteCreateController@index');
    Router::post('/site/create', 'SiteCreateController@store');
});

// ==================== عرض مواقع المستأجرين مع /site/ ====================
Router::get('/site/{slug}', 'SiteController@show');
Router::post('/site/{slug}/contact', 'SiteController@contact');
Router::get('/site/{slug}/service/{serviceSlug}', 'SiteController@service');
Router::get('/site/{slug}/services', 'SiteController@services');
Router::get('/site/{slug}/gallery', 'SiteController@gallery');
Router::get('/site/{slug}/contact', 'SiteController@contactPage');
Router::get('/site/{slug}/about', 'SiteController@about');
Router::get('/site/{slug}/faq', 'SiteController@faq');
Router::get('/site/{slug}/partners', 'SiteController@partners');
Router::get('/site/{slug}/booking', 'SiteController@booking');
Router::get('/site/{slug}/blog', 'BlogController@list');
Router::get('/site/{slug}/blog/{postSlug}', 'BlogController@show');

// ==================== لوحة تحكم العميل ====================
Router::group(['middleware' => 'customer'], function() {
    // الرئيسية
    Router::get('/dashboard', 'DashboardController@index');
    
    // الإعدادات
    Router::get('/dashboard/settings', 'DashboardController@settings');
    Router::post('/dashboard/settings', 'DashboardController@updateSettings');
    Router::post('/dashboard/settings/colors', 'DashboardController@updateColors');
    Router::post('/dashboard/settings/logo', 'DashboardController@updateLogo');
    // تغيير الثيم (قالب واحد - توجيه للإعدادات)
    Router::post('/dashboard/settings/theme', 'DashboardController@changeTheme');
    Router::post('/dashboard/settings/import-demo', 'DashboardController@importDemo');
    Router::post('/dashboard/settings/sections', 'DashboardController@updateSections');
    // صفحة القوالب (قالب واحد - توجيه للإعدادات)
    Router::get('/dashboard/themes', 'DashboardController@themes');
    // طلب القالب المدفوع (قالب واحد مجاني - توجيه للإعدادات)
    Router::post('/dashboard/themes/request-paid', 'DashboardController@requestPaidTheme');
    Router::get('/dashboard/subscription', 'SubscriptionController@overview');
    Router::post('/dashboard/publish', 'DashboardController@publish');
    
    // متجر الخدمات المدفوعة
    Router::get('/dashboard/services-store', 'ServicesStoreController@index');
    Router::post('/dashboard/services-store/purchase/{id}', 'ServicesStoreController@purchase');
    Router::get('/dashboard/my-purchases', 'ServicesStoreController@myPurchases');
    
    // الخدمات
    Router::get('/dashboard/services', 'DashboardController@services');
    Router::get('/dashboard/services/add', 'DashboardController@addService');
    Router::post('/dashboard/services/add', 'DashboardController@storeService');
    Router::get('/dashboard/services/edit/{id}', 'DashboardController@editService');
    Router::post('/dashboard/services/edit/{id}', 'DashboardController@updateService');
    Router::post('/dashboard/services/delete/{id}', 'DashboardController@deleteService');
    
    // البانرات
    Router::get('/dashboard/banners', 'DashboardController@banners');
    Router::post('/dashboard/banners', 'DashboardController@storeBanner');
    Router::post('/dashboard/banners/edit/{id}', 'DashboardController@updateBanner');
    Router::post('/dashboard/banners/delete/{id}', 'DashboardController@deleteBanner');
    
    // المعرض
    Router::get('/dashboard/gallery', 'DashboardController@gallery');
    Router::post('/dashboard/gallery', 'DashboardController@uploadGallery');
    Router::post('/dashboard/gallery/edit/{id}', 'DashboardController@editGalleryImage');
    Router::post('/dashboard/gallery/delete/{id}', 'DashboardController@deleteGalleryImage');
    
    // آراء العملاء
    Router::get('/dashboard/testimonials', 'DashboardController@testimonials');
    Router::post('/dashboard/testimonials', 'DashboardController@storeTestimonial');
    Router::post('/dashboard/testimonials/delete/{id}', 'DashboardController@deleteTestimonial');
    
    // الأسئلة الشائعة
    Router::get('/dashboard/faq', 'DashboardController@faq');
    Router::post('/dashboard/faq', 'DashboardController@storeFaq');
    Router::post('/dashboard/faq/edit/{id}', 'DashboardController@updateFaq');
    Router::post('/dashboard/faq/delete/{id}', 'DashboardController@deleteFaq');
    Router::post('/dashboard/faq/toggle/{id}', 'DashboardController@toggleFaq');
    
    // الإحصائيات (العداد)
    Router::get('/dashboard/stats', 'DashboardController@stats');
    Router::post('/dashboard/stats', 'DashboardController@storeStat');
    Router::post('/dashboard/stats/edit/{id}', 'DashboardController@updateStat');
    Router::post('/dashboard/stats/delete/{id}', 'DashboardController@deleteStat');
    Router::post('/dashboard/stats/toggle/{id}', 'DashboardController@toggleStat');
    
    // مميزات "لماذا نحن"
    Router::get('/dashboard/features', 'DashboardController@features');
    Router::post('/dashboard/features', 'DashboardController@storeFeature');
    Router::post('/dashboard/features/edit/{id}', 'DashboardController@updateFeature');
    Router::post('/dashboard/features/delete/{id}', 'DashboardController@deleteFeature');
    Router::post('/dashboard/features/toggle/{id}', 'DashboardController@toggleFeature');
    
    // الشركاء
    Router::get('/dashboard/partners', 'DashboardController@partners');
    Router::post('/dashboard/partners', 'DashboardController@storePartner');
    Router::post('/dashboard/partners/edit/{id}', 'DashboardController@updatePartner');
    Router::post('/dashboard/partners/delete/{id}', 'DashboardController@deletePartner');
    Router::post('/dashboard/partners/toggle/{id}', 'DashboardController@togglePartner');

    // إعدادات CTA
    Router::post('/dashboard/settings/cta', 'DashboardController@updateCta');
    
    // الرسائل
    Router::get('/dashboard/messages', 'DashboardController@messages');
    Router::post('/dashboard/messages/read/{id}', 'DashboardController@markMessageRead');
    
    // الصفحات
    Router::get('/dashboard/pages', 'PageController@index');
    Router::get('/dashboard/pages/add', 'PageController@add');
    Router::post('/dashboard/pages/add', 'PageController@store');
    Router::get('/dashboard/pages/edit/{id}', 'PageController@edit');
    Router::post('/dashboard/pages/edit/{id}', 'PageController@update');
    Router::post('/dashboard/pages/delete/{id}', 'PageController@delete');

    // Blog
    Router::get('/dashboard/blog', 'BlogController@index');
    Router::get('/dashboard/blog/add', 'BlogController@add');
    Router::post('/dashboard/blog/add', 'BlogController@store');
    Router::get('/dashboard/blog/edit/{id}', 'BlogController@edit');
    Router::post('/dashboard/blog/edit/{id}', 'BlogController@update');
    Router::post('/dashboard/blog/delete/{id}', 'BlogController@delete');
    Router::get('/dashboard/blog/show/{id}', 'BlogController@show');

    // SEO
    Router::get('/dashboard/seo', 'SeoController@index');
    Router::post('/dashboard/seo', 'SeoController@update');
    Router::get('/dashboard/seo/sitemap', 'SeoController@generateSitemap');
    Router::post('/dashboard/seo/robots', 'SeoController@updateRobots');

    // Analytics
    Router::get('/dashboard/analytics', 'AnalyticsController@index');
    Router::get('/dashboard/analytics/details', 'AnalyticsController@details');
    Router::get('/dashboard/analytics/export', 'AnalyticsController@export');

    // Theme
    Router::get('/dashboard/theme', 'ThemeController@index');
    Router::post('/dashboard/theme', 'ThemeController@update');
    Router::post('/dashboard/theme/reset', 'ThemeController@reset');

    // Subscription
    Router::get('/dashboard/subscription-plans', 'SubscriptionController@plans');
    Router::post('/dashboard/subscription/plans/{id}', 'SubscriptionController@selectPlan');
    Router::get('/dashboard/subscription/payment', 'SubscriptionController@payment');
    Router::post('/dashboard/subscription/payment', 'SubscriptionController@processPayment');
    Router::get('/dashboard/subscription/renew', 'SubscriptionController@renew');
    Router::post('/dashboard/subscription/cancel', 'SubscriptionController@cancel');
    Router::get('/dashboard/subscription/upgrade', 'SubscriptionController@upgrade');
    Router::get('/dashboard/invoices', 'SubscriptionController@invoices');

    // Domains
    Router::get('/dashboard/domains', 'DomainController@index');
    Router::post('/dashboard/domains/subdomain', 'DomainController@updateSubdomain');
    Router::post('/dashboard/domains/custom', 'DomainController@addCustomDomain');
    Router::post('/dashboard/domains/verify', 'DomainController@verifyDomain');
    Router::post('/dashboard/domains/remove', 'DomainController@removeCustomDomain');

    // Forms
    Router::get('/dashboard/forms', 'FormController@index');
    Router::get('/dashboard/forms/add', 'FormController@add');
    Router::post('/dashboard/forms/add', 'FormController@store');
    Router::get('/dashboard/forms/edit/{id}', 'FormController@edit');
    Router::post('/dashboard/forms/edit/{id}', 'FormController@update');
    Router::post('/dashboard/forms/delete/{id}', 'FormController@delete');
    Router::get('/dashboard/forms/submissions/{id}', 'FormController@submissions');

    // Notifications API
    Router::get('/dashboard/notifications', 'NotificationController@list');
    Router::get('/dashboard/notifications/unread', 'NotificationController@unreadCount');
    Router::post('/dashboard/notifications/read/{id}', 'NotificationController@markRead');
    Router::post('/dashboard/notifications/read-all', 'NotificationController@markAllRead');
    Router::post('/dashboard/notifications/delete/{id}', 'NotificationController@delete');
});

// ==================== مسارات عامة (بدون مصادقة) ====================
// تتبع الإحصائيات (API عام)
Router::post('/api/analytics/track', 'AnalyticsController@track');

// استقبال بيانات النماذج (عام)
Router::post('/forms/submit', 'FormController@submit');

// تضمين النماذج (عام)
Router::get('/forms/embed/{slug}', 'FormController@embed');

// ==================== لوحة تحكم المدير ====================
Router::group(['middleware' => 'admin'], function() {
    Router::get('/admin', 'AdminController@index');
    Router::get('/admin/users', 'AdminController@users');
    Router::get('/admin/users/edit/{id}', 'AdminController@editUser');
    Router::post('/admin/users/edit/{id}', 'AdminController@updateUser');
    Router::post('/admin/users/delete/{id}', 'AdminController@deleteUser');
    Router::get('/admin/sites', 'AdminController@sites');
    Router::get('/admin/sites/view/{id}', 'AdminController@viewSite');
    Router::post('/admin/sites/status', 'AdminController@changeSubscriptionStatus');
    Router::get('/admin/sites/renew/{id}', 'AdminController@renewSubscription');
    Router::get('/admin/settings', 'AdminController@settings');
    Router::post('/admin/settings', 'AdminController@updateSettings');
    Router::get('/admin/analytics', 'AdminController@analytics');
    
    // إدارة الخطط
    Router::get('/admin/plans', 'AdminController@plans');
    Router::get('/admin/plans/add', 'AdminController@addPlan');
    Router::post('/admin/plans/add', 'AdminController@storePlan');
    Router::get('/admin/plans/edit/{id}', 'AdminController@editPlan');
    Router::post('/admin/plans/edit/{id}', 'AdminController@updatePlan');
    Router::post('/admin/plans/delete/{id}', 'AdminController@deletePlan');
    
    // إدارة إعدادات الموقع الرئيسي
    Router::get('/admin/site-settings', 'AdminController@siteSettings');
    Router::post('/admin/site-settings', 'AdminController@updateSiteSettings');
    Router::post('/admin/site-settings/logo', 'AdminController@updateSiteLogo');
    Router::post('/admin/site-settings/hero-image', 'AdminController@updateHeroImage');
    
    // إدارة شهادات الموقع الرئيسي
    Router::get('/admin/site-testimonials', 'AdminController@siteTestimonials');
    Router::post('/admin/site-testimonials', 'AdminController@storeSiteTestimonial');
    Router::post('/admin/site-testimonials/delete/{id}', 'AdminController@deleteSiteTestimonial');
    
    // إدارة مميزات الموقع الرئيسي
    Router::get('/admin/site-features', 'AdminController@siteFeatures');
    Router::post('/admin/site-features', 'AdminController@storeSiteFeature');
    Router::post('/admin/site-features/delete/{id}', 'AdminController@deleteSiteFeature');
    
    // إدارة الاشتراكات
    Router::get('/admin/subscriptions', 'AdminController@subscriptions');
    
    // إدارة طلبات الاشتراك والترقية
    Router::get('/admin/subscription-requests', 'AdminController@subscriptionRequests');
    Router::post('/admin/subscription-requests/approve/{id}', 'AdminController@approveSubscriptionRequest');
    Router::post('/admin/subscription-requests/reject/{id}', 'AdminController@rejectSubscriptionRequest');
    
    // إدارة القوالب
    Router::get('/admin/themes', 'AdminController@themes');
    Router::post('/admin/themes/toggle', 'AdminController@toggleTheme');
    Router::post('/admin/themes/update', 'AdminController@updateTheme');
    
    // استيراد وحذف البيانات التجريبية للقوالب
    Router::post('/admin/themes/import-demo', 'AdminController@importAllDemoData');
    Router::post('/admin/themes/clear-demo', 'AdminController@clearAllDemoData');
    
    // إدارة محتوى القوالب (نصوص، صور، بنرات، شعارات)
    Router::get('/admin/themes/content/{id}', 'AdminController@themeContent');
    Router::post('/admin/themes/content/{id}', 'AdminController@saveThemeContent');
    Router::post('/admin/themes/media/upload/{id}', 'AdminController@uploadThemeMedia');
    Router::post('/admin/themes/media/delete/{id}', 'AdminController@deleteThemeMedia');
    Router::post('/admin/themes/content-item/delete/{id}', 'AdminController@deleteThemeContentItem');
    
    // طلبات تفعيل الثيمات المدفوعة
    Router::get('/admin/theme-requests', 'AdminController@themeRequests');
    Router::post('/admin/theme-requests/approve/{id}', 'AdminController@approveThemeRequest');
    Router::post('/admin/theme-requests/reject/{id}', 'AdminController@rejectThemeRequest');
    
    // إدارة الخدمات المدفوعة
    Router::get('/admin/services-store', 'AdminServicesController@services');
    Router::get('/admin/services-store/add', 'AdminServicesController@addService');
    Router::post('/admin/services-store/add', 'AdminServicesController@storeService');
    Router::get('/admin/services-store/edit/{id}', 'AdminServicesController@editService');
    Router::post('/admin/services-store/edit/{id}', 'AdminServicesController@updateService');
    Router::post('/admin/services-store/delete/{id}', 'AdminServicesController@deleteService');
    
    // إدارة المشتريات
    Router::get('/admin/purchases', 'AdminServicesController@purchases');
    Router::post('/admin/purchases/approve/{id}', 'AdminServicesController@approvePurchase');
    Router::post('/admin/purchases/reject/{id}', 'AdminServicesController@rejectPurchase');
    
    // إعدادات SMTP
    Router::get('/admin/email-settings', 'AdminController@emailSettings');
    Router::post('/admin/email-settings', 'AdminController@updateEmailSettings');
    Router::post('/admin/email-settings/test', 'AdminController@testEmailSettings');
});

// ==================== معاينة القوالب (Theme Preview) ====================
Router::get('/theme-preview/{slug}', 'SiteController@previewDemo');
Router::get('/theme-preview/{slug}/about', 'SiteController@previewDemoAbout');
Router::get('/theme-preview/{slug}/services', 'SiteController@previewDemoServices');
Router::get('/theme-preview/{slug}/contact', 'SiteController@previewDemoContact');
Router::get('/theme-preview/{slug}/gallery', 'SiteController@previewDemoGallery');
Router::get('/theme-preview/{slug}/faq', 'SiteController@previewDemoFaq');
Router::get('/theme-preview/{slug}/partners', 'SiteController@previewDemoPartners');
Router::get('/theme-preview/{slug}/booking', 'SiteController@previewDemoBooking');
Router::get('/theme-preview/{slug}/service/{serviceSlug}', 'SiteController@previewDemoService');

// ==================== عرض مواقع المستأجرين (المسارات المختصرة - يجب أن تكون الأخيرة) ====================
Router::get('/{slug}', 'SiteController@show');
Router::post('/{slug}/contact', 'SiteController@contact');
Router::get('/{slug}/service/{serviceSlug}', 'SiteController@service');
Router::get('/{slug}/services', 'SiteController@services');
Router::get('/{slug}/gallery', 'SiteController@gallery');
Router::get('/{slug}/contact', 'SiteController@contactPage');
Router::get('/{slug}/about', 'SiteController@about');
Router::get('/{slug}/faq', 'SiteController@faq');
Router::get('/{slug}/partners', 'SiteController@partners');
Router::get('/{slug}/booking', 'SiteController@booking');
Router::get('/{slug}/blog', 'BlogController@list');
Router::get('/{slug}/blog/{postSlug}', 'BlogController@show');