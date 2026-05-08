# CMS Platform - هيكل المشروع الكامل

## 📂 هيكل المجلدات والملفات

```
cms-platform/
├── 📁 public/                    # المجلد العام
│   ├── 📁 assets/               # الملفات الثابتة
│   │   ├── 📁 css/              # أنماط CSS
│   │   │   └── style.css
│   │   └── 📁 js/               # JavaScript
│   │       └── app.js
│   ├── 📁 uploads/              # الملفات المرفوعة
│   └── index.php               # نقطة الدخول
│
├── 📁 app/                       # التطبيق الرئيسي
│   ├── 📁 config/               # الإعدادات
│   │   └── config.php
│   ├── 📁 core/                # النواة الأساسية
│   │   ├── Auth.php
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   ├── Language.php
│   │   ├── Model.php
│   │   ├── Router.php
│   │   ├── Security.php
│   │   ├── Session.php
│   │   └── View.php
│   ├── 📁 controllers/         # المتحكمات
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── LanguageController.php
│   │   ├── PageController.php
│   │   ├── SiteController.php
│   │   ├── SiteCreateController.php
│   │   └── SubscriptionController.php
│   ├── 📁 helpers/              # المساعدات
│   │   └── functions.php
│   ├── 📁 lang/                # اللغات
│   │   ├── ar.php              # العربية
│   │   └── en.php              # الإنجليزية
│   ├── 📁 models/               # النماذج
│   │   ├── Banner.php
│   │   ├── DemoData.php
│   │   ├── Gallery.php
│   │   ├── Page.php
│   │   ├── Service.php
│   │   ├── SiteFeature.php      # ✨ جديد
│   │   ├── SiteSetting.php      # ✨ جديد
│   │   ├── SiteTestimonial.php  # ✨ جديد
│   │   ├── SubscriptionPlan.php # ✨ جديد
│   │   ├── Tenant.php
│   │   ├── Testimonial.php
│   │   ├── Theme.php
│   │   └── User.php
│   ├── 📁 views/                # العروض
│   │   ├── 📁 admin/            # لوحة الأدمن
│   │   │   ├── index.php
│   │   │   ├── plan-form.php
│   │   │   ├── plans.php        # ✨ جديد
│   │   │   ├── site-features.php # ✨ جديد
│   │   │   ├── site-settings.php # ✨ جديد
│   │   │   ├── site-testimonials.php # ✨ جديد
│   │   │   ├── tenants.php
│   │   │   ├── themes.php
│   │   │   └── users.php
│   │   ├── 📁 auth/             # المصادقة
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   ├── 📁 dashboard/         # لوحة التحكم
│   │   │   ├── banners.php
│   │   │   ├── gallery.php
│   │   │   ├── index.php
│   │   │   ├── messages.php
│   │   │   ├── page-form.php
│   │   │   ├── pages.php
│   │   │   ├── service-form.php
│   │   │   ├── services.php
│   │   │   ├── settings.php     # ✨ محدث
│   │   │   ├── subscription.php
│   │   │   ├── testimonials.php
│   │   │   └── themes-selection.php
│   │   ├── 📁 errors/
│   │   │   └── 404.php
│   │   ├── 📁 layouts/
│   │   │   └── dashboard.php
│   │   └── 📁 site/
│   │       ├── create.php
│   │       └── maintenance.php
│   └── routes.php               # المسارات
│
├── 📁 sql/                       # ملفات قاعدة البيانات
│   ├── database.sql             # الهيكل الأساسي
│   ├── add_sections_config.sql   # ✨ التحكم بالأقسام
│   ├── add_site_settings.sql    # ✨ إعدادات الموقع الرئيسي
│   ├── add_subscription_plans.sql # ✨ خطط الاشتراك
│   ├── demo_data.sql
│   └── update_language.sql
│
├── 📁 themes/                   # القوالب (6 ثيمات)
│   ├── 📁 cleaning/
│   │   ├── about.php
│   │   ├── contact.php
│   │   ├── default.php
│   │   ├── gallery.php
│   │   ├── service.php
│   │   └── services.php
│   ├── 📁 decor/
│   │   └── ... (نفس الملفات)
│   ├── 📁 electric/
│   │   └── ... (نفس الملفات)
│   ├── 📁 general/
│   │   └── ... (نفس الملفات)
│   ├── 📁 maintenance/
│   │   └── ... (نفس الملفات)
│   └── 📁 plumbing/
│       └── ... (نفس الملفات)
│
├── .htaccess
├── INSTALL.md
├── README.md
└── start.sh
```

## 📊 إحصائيات المشروع

| الفئة | العدد |
|------|------|
| **النماذج (Models)** | 13 |
| **المتحكمات (Controllers)** | 8 |
| **العروض (Views)** | 25+ |
| **الثيمات (Themes)** | 6 |
| **ملفات SQL** | 6 |
| **ملفات اللغة** | 2 |

## ✨ الميزات الجديدة المضافة

1. **التحكم بظهور الأقسام** - إظهار/إخفاء أقسام الموقع
2. **خطط الاشتراك** - 4 خطط مع فترة تجريبية
3. **إعدادات الموقع الرئيسي** - تحكم الأدمن بالمحتوى

4. **شهادات الموقع الرئيسي** - آراء العملاء
5. **مميزات الموقع الرئيسي** - عرض المميزات
