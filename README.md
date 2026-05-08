# 🚀 منصة إنشاء المواقع - CMS Platform

منصة متكاملة لإنشاء مواقع الخدمات مع دعم تعدد المستأجرين (Multi-tenant)

## ✨ المميزات

### النظام الأساسي
- ✅ نظام Multi-tenant (كل عميل له موقع مستقل)
- ✅ لوحة تحكم كاملة لكل عميل
- ✅ 6 ثيمات جاهزة لقطاع الخدمات
- ✅ دعم ثنائي اللغة (عربي + إنجليزي)
- ✅ نظام اشتراكات (تجربة مجانية + اشتراك شهري)

### لوحة التحكم
- ✅ إدارة الخدمات
- ✅ إدارة البانرات
- ✅ معرض الصور
- ✅ آراء العملاء
- ✅ الصفحات (من نحن، اتصل بنا)
- ✅ الرسائل
- ✅ إعدادات الموقع (اللوجو، الألوان، الثيم)

### الثيمات
1. **General** - خدمات عامة (أزرق)
2. **Maintenance** - خدمات الصيانة (برتقالي)
3. **Decor** - خدمات الديكور (ذهبي)
4. **Electric** - خدمات الكهرباء (أصفر)
5. **Plumbing** - خدمات السباكة (سماوي)
6. **Cleaning** - خدمات التنظيف (أخضر)

## 📁 هيكل المشروع

```
cms-platform/
├── app/
│   ├── config/           # الإعدادات
│   ├── core/             # الكلاسات الأساسية
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── Auth.php
│   │   ├── Language.php
│   │   ├── Security.php
│   │   └── ...
│   ├── controllers/      # المتحكمات
│   ├── models/           # النماذج
│   ├── views/            # الواجهات
│   ├── helpers/          # الدوال المساعدة
│   └── lang/             # ملفات الترجمة
├── public/
│   ├── index.php         # نقطة الدخول
│   ├── .htaccess
│   └── assets/           # CSS, JS, Images
├── themes/               # القوالب
└── sql/                  # قاعدة البيانات
```

## ⚙️ التثبيت

### 1. متطلبات الخادم
- PHP 7.4 أو أحدث
- MySQL 5.7 أو أحدث
- Apache مع mod_rewrite

### 2. خطوات التثبيت

```bash
# 1. رفع الملفات للسيرفر

# 2. إنشاء قاعدة البيانات
CREATE DATABASE cms_platform;

# 3. استيراد قاعدة البيانات
mysql -u root -p cms_platform < sql/database.sql
mysql -u root -p cms_platform < sql/update_language.sql

# 4. تعديل الإعدادات
# عدّل app/config/config.php
DB_HOST = 'localhost'
DB_NAME = 'cms_platform'
DB_USER = 'your_username'
DB_PASS = 'your_password'

# 5. إعطاء صلاحيات للمجلدات
chmod -R 755 public/uploads
```

### 3. بيانات الدخول الافتراضية

**مدير النظام:**
- البريد: `admin@cms-platform.com`
- كلمة المرور: `admin123`

## 🔧 التكوين

### تعديل إعدادات قاعدة البيانات
```php
// app/config/config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cms_platform');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### تعديل URL الموقع
```php
define('SITE_URL', 'https://your-domain.com');
```

### تعديل مسار التثبيت
إذا كان المشروع في مجلد فرعي:
```apache
# public/.htaccess
RewriteBase /your-folder/public
```

## 🌐 URLs

| الصفحة | URL |
|--------|-----|
| الرئيسية | `/` |
| تسجيل الدخول | `/auth/login` |
| التسجيل | `/auth/register` |
| لوحة التحكم | `/dashboard` |
| موقع العميل | `/site/{slug}` |
| لوحة المدير | `/admin` |

## 📱 الاستخدام

### للعملاء
1. التسجيل في المنصة
2. إنشاء الموقع الأول (اختيار الاسم والثيم)
3. تخصيص الموقع من لوحة التحكم
4. إضافة الخدمات والصور
5. نشر الموقع

### للمدير
- إدارة المستخدمين
- إدارة المواقع
- إدارة الاشتراكات
- إعدادات النظام

## 🔐 الأمان

- ✅ CSRF Protection
- ✅ XSS Protection
- ✅ SQL Injection Protection (Prepared Statements)
- ✅ Password Hashing (bcrypt)
- ✅ File Upload Validation
- ✅ Session Security

## 📞 الدعم

للمساعدة أو الاستفسارات:
- البريد: support@cms-platform.com

## 📄 الترخيص

MIT License

---

**تم التطوير بـ ❤️**
