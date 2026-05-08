<?php
/**
 * سكريبت إعداد جداول الصفحة الرئيسية
 * ينشئ الجداول المطلوبة ويدخل البيانات الافتراضية
 * 
 * التعليمة: انسخ هذا الملف إلى مجلد takweenweb الرئيسي
 * C:\xampp\htdocs\takweenweb\
 * ثم افتحه في المتصفح: http://localhost/takweenweb/setup_home_page.php
 */

require_once __DIR__ . '/app/config/config.php';

$db = Database::getInstance();
$messages = [];
$year = date('Y');

// ============ 1. جدول site_settings ============
$messages[] = "=== إنشاء جداول الصفحة الرئيسية ===\n";

try {
    // التحقق من وجود الجدول
    $result = $db->query("SHOW TABLES LIKE 'site_settings'");
    
    if ($result->count() > 0) {
        // تحقق إذا في بيانات
        $check = $db->query("SELECT COUNT(*) as c FROM site_settings")->first();
        if ($check->c > 0) {
            $messages[] = "[OK] جدول site_settings موجود وفيه بيانات (" . $check->c . " سجل)";
        } else {
            $messages[] = "[!] جدول site_settings موجود لكن فارغ - جاري إدخال بيانات افتراضية...";
            insertDefaultSettings($db, $year);
            $messages[] = "[OK] تم إدخال البيانات الافتراضية";
        }
    } else {
        $messages[] = "[*] إنشاء جدول site_settings...";
        
        $db->query("CREATE TABLE IF NOT EXISTS site_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            logo VARCHAR(500) DEFAULT NULL,
            logo_white VARCHAR(500) DEFAULT NULL,
            favicon VARCHAR(500) DEFAULT NULL,
            hero_title VARCHAR(255) DEFAULT NULL,
            hero_subtitle TEXT DEFAULT NULL,
            hero_image VARCHAR(500) DEFAULT NULL,
            hero_button_text VARCHAR(255) DEFAULT NULL,
            hero_button_link VARCHAR(500) DEFAULT NULL,
            features_title VARCHAR(255) DEFAULT NULL,
            features_subtitle VARCHAR(255) DEFAULT NULL,
            show_features TINYINT(1) DEFAULT 1,
            show_themes_section TINYINT(1) DEFAULT 1,
            show_pricing_section TINYINT(1) DEFAULT 1,
            pricing_title VARCHAR(255) DEFAULT NULL,
            pricing_subtitle VARCHAR(255) DEFAULT NULL,
            testimonials_title VARCHAR(255) DEFAULT NULL,
            show_testimonials TINYINT(1) DEFAULT 1,
            contact_title VARCHAR(255) DEFAULT NULL,
            contact_subtitle VARCHAR(255) DEFAULT NULL,
            show_contact_form TINYINT(1) DEFAULT 0,
            contact_email VARCHAR(255) DEFAULT NULL,
            contact_phone VARCHAR(50) DEFAULT NULL,
            contact_whatsapp VARCHAR(50) DEFAULT NULL,
            contact_address TEXT DEFAULT NULL,
            facebook VARCHAR(500) DEFAULT NULL,
            twitter VARCHAR(500) DEFAULT NULL,
            instagram VARCHAR(500) DEFAULT NULL,
            linkedin VARCHAR(500) DEFAULT NULL,
            youtube VARCHAR(500) DEFAULT NULL,
            meta_title VARCHAR(255) DEFAULT NULL,
            meta_description TEXT DEFAULT NULL,
            meta_keywords TEXT DEFAULT NULL,
            footer_text TEXT DEFAULT NULL,
            copyright_text VARCHAR(255) DEFAULT NULL,
            head_scripts TEXT DEFAULT NULL,
            body_scripts TEXT DEFAULT NULL,
            maintenance_mode TINYINT(1) DEFAULT 0,
            maintenance_message TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $messages[] = "[OK] تم إنشاء الجدول";
        
        insertDefaultSettings($db, $year);
        $messages[] = "[OK] تم إدخال البيانات الافتراضية";
    }
} catch (Exception $e) {
    $messages[] = "[خطأ] site_settings: " . $e->getMessage();
}

$messages[] = "";

// ============ 2. جدول site_testimonials ============
try {
    $result = $db->query("SHOW TABLES LIKE 'site_testimonials'");
    
    if ($result->count() > 0) {
        $check = $db->query("SELECT COUNT(*) as c FROM site_testimonials")->first();
        $messages[] = "[OK] جدول site_testimonials موجود وفيه " . $check->c . " شهادة";
    } else {
        $messages[] = "[*] إنشاء جدول site_testimonials...";
        
        $db->query("CREATE TABLE IF NOT EXISTS site_testimonials (
            id INT AUTO_INCREMENT PRIMARY KEY,
            client_name VARCHAR(255) NOT NULL,
            client_title VARCHAR(255) DEFAULT NULL,
            client_company VARCHAR(255) DEFAULT NULL,
            client_image VARCHAR(500) DEFAULT NULL,
            content TEXT NOT NULL,
            rating INT DEFAULT 5,
            display_order INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $messages[] = "[OK] تم إنشاء الجدول";
        
        // إدخال بيانات تجريبية
        $db->query("INSERT INTO site_testimonials (client_name, client_title, client_company, content, rating, display_order, is_active) VALUES 
            (?, ?, ?, ?, 5, 1, 1)",
            ['أحمد محمد', 'صاحب شركة مقاولات', 'شركة البناء الحديث', 'منصة رائعة وسهلة الاستخدام، استطعت إنشاء موقعي خلال ساعات فقط. القوالب احترافية والتخصيص ممتع جداً.']
        );
        $db->query("INSERT INTO site_testimonials (client_name, client_title, client_company, content, rating, display_order, is_active) VALUES 
            (?, ?, ?, ?, 5, 2, 1)",
            ['سارة العتيبي', 'مصممة ديكور', 'مكتب التصميم الإبداعي', 'الدعم الفني ممتاز والاستجابة سريعة. أنصح بهذه المنصة لكل من يريد موقعاً احترافياً بأسعار معقولة.']
        );
        $db->query("INSERT INTO site_testimonials (client_name, client_title, client_company, content, rating, display_order, is_active) VALUES 
            (?, ?, ?, ?, 5, 3, 1)",
            ['خالد الشمري', 'مقدم خدمات كهربائية', 'شركة الطاقة المتقدمة', 'أفضل منصة عربية لإنشاء المواقع. واجهة سهلة وقوالب متنوعة تناسب جميع المجالات.']
        );
        
        $messages[] = "[OK] تم إدخال 3 شهادات تجريبية";
    }
} catch (Exception $e) {
    $messages[] = "[خطأ] site_testimonials: " . $e->getMessage();
}

$messages[] = "";

// ============ 3. جدول site_features ============
try {
    $result = $db->query("SHOW TABLES LIKE 'site_features'");
    
    if ($result->count() > 0) {
        // تحقق من وجود عمود tenant_id
        $columns = $db->query("SHOW COLUMNS FROM site_features LIKE 'tenant_id'");
        $hasTenantId = $columns->count() > 0;
        
        if ($hasTenantId) {
            $check = $db->query("SELECT COUNT(*) as c FROM site_features WHERE tenant_id IS NULL AND is_active = 1")->first();
            $messages[] = "[OK] جدول site_features موجود (مع tenant_id) وفيه " . $check->c . " مميزات عامة";
        } else {
            $check = $db->query("SELECT COUNT(*) as c FROM site_features WHERE is_active = 1")->first();
            $messages[] = "[OK] جدول site_features موجود وفيه " . $check->c . " مميزات";
        }
    } else {
        $messages[] = "[*] إنشاء جدول site_features...";
        
        $db->query("CREATE TABLE IF NOT EXISTS site_features (
            id INT AUTO_INCREMENT PRIMARY KEY,
            tenant_id INT DEFAULT NULL,
            icon VARCHAR(100) DEFAULT 'fas fa-star',
            title VARCHAR(255) NOT NULL,
            title_en VARCHAR(255) DEFAULT NULL,
            description TEXT DEFAULT NULL,
            description_en TEXT DEFAULT NULL,
            display_order INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $messages[] = "[OK] تم إنشاء الجدول";
        
        // إدخال مميزات افتراضية (عامة - بدون tenant_id)
        $defaultFeatures = [
            ['fas fa-palette', 'قوالب احترافية', 'Professional Templates', 'اختر من بين مجموعة واسعة من القوالب المتنوعة المصممة خصيصاً لكل مجال عمل', 'Choose from a wide variety of templates designed for every field'],
            ['fas fa-mobile-alt', 'تصميم متجاوب', 'Responsive Design', 'مواقع متوافقة مع جميع الأجهزة والشاشات بشكل تلقائي', 'Sites compatible with all devices and screens automatically'],
            ['fas fa-globe', 'نطاق مخصص', 'Custom Domain', 'احصل على نطاق خاص بموقعك يعكس هوية عملك بشكل احترافي', 'Get a custom domain that reflects your business identity'],
            ['fas fa-paint-brush', 'ألوان مخصصة', 'Custom Colors', 'خصص ألوان موقعك لتناسب هوية علامتك التجارية', 'Customize site colors to match your brand identity'],
            ['fas fa-language', 'ثنائي اللغة', 'Bilingual', 'دعم كامل للعربية والإنجليزية مع تبديل سهل بين اللغات', 'Full Arabic and English support with easy language switching'],
            ['fas fa-headset', 'دعم فني متواصل', '24/7 Support', 'فريق دعم فني متخصص جاهز لمساعدتك على مدار الساعة', 'Expert support team ready to help you 24/7'],
        ];
        
        foreach ($defaultFeatures as $i => $f) {
            $db->query("INSERT INTO site_features (icon, title, title_en, description, description_en, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)",
                [$f[0], $f[1], $f[2], $f[3], $f[4], $i + 1]);
        }
        
        $messages[] = "[OK] تم إدخال 6 مميزات افتراضية";
    }
} catch (Exception $e) {
    $messages[] = "[خطأ] site_features: " . $e->getMessage();
}

$messages[] = "";

// ============ 4. فحص subscription_plans ============
try {
    $count = $db->query("SELECT COUNT(*) as c FROM subscription_plans WHERE is_active = 1")->first()->c;
    $messages[] = "[OK] جدول subscription_plans - عدد الخطط النشطة: " . $count;
    
    if ($count > 0) {
        $plans = $db->query("SELECT name, slug, price_monthly, is_free, is_popular, features FROM subscription_plans WHERE is_active = 1 ORDER BY display_order ASC")->results();
        foreach ($plans as $p) {
            $featured = !empty($p->is_popular) ? ' (مميزة)' : '';
            $free = !empty($p->is_free) ? ' (مجانية)' : '';
            $messages[] = "  - " . $p->name . " - " . ($p->price_monthly ?? 0) . " SAR" . $free . $featured;
        }
    } else {
        $messages[] = "  [!] ما في خطط نشطة - يمكنك إضافتها من صفحة الأدمن /admin/plans/add";
    }
} catch (Exception $e) {
    $messages[] = "[خطأ] subscription_plans: " . $e->getMessage();
}

$messages[] = "\n=== تم الانتهاء ===";
$messages[] = "افتح الصفحة الرئيسية الآن وشوف النتيجة!";
$messages[] = "للتعديل على المحتوى: /admin/site-settings";
$messages[] = "لإدارة الخطط: /admin/plans";
$messages[] = "لإدارة الشهادات: /admin/site-testimonials";
$messages[] = "لإدارة المميزات: /admin/site-features";

// ============ عرض النتائج ============
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إعداد الصفحة الرئيسية</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f0f2f5; padding: 30px; line-height: 1.8; }
        .container { max-width: 800px; margin: 0 auto; background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #4f46e5; border-bottom: 3px solid #4f46e5; padding-bottom: 10px; }
        .msg { padding: 6px 12px; margin: 4px 0; border-radius: 6px; font-family: 'Courier New', monospace; font-size: 14px; }
        .ok { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .warn { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .err { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .links { margin-top: 20px; padding: 15px; background: #f8fafc; border-radius: 8px; }
        .links a { display: inline-block; margin: 5px 10px 5px 0; padding: 8px 16px; background: #4f46e5; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .links a:hover { background: #3730a3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>إعداد الصفحة الرئيسية</h1>
        <?php foreach ($messages as $msg): ?>
            <?php 
                if (strpos($msg, '[OK]') !== false || strpos($msg, 'تم') !== false) {
                    $class = 'ok';
                } elseif (strpos($msg, '[خطأ]') !== false || strpos($msg, 'Error') !== false) {
                    $class = 'err';
                } elseif (strpos($msg, '[!]') !== false || strpos($msg, '[*]') !== false) {
                    $class = 'warn';
                } elseif (strpos($msg, '===') !== false) {
                    $class = 'info';
                } else {
                    $class = '';
                }
            ?>
            <?php if (strpos($msg, '===') !== false): ?>
                <h3 style="margin: 15px 0 5px; color: #4f46e5;"><?= htmlspecialchars($msg) ?></h3>
            <?php else: ?>
                <div class="msg <?= $class ?>"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <div class="links">
            <strong>روابط سريعة:</strong><br><br>
            <a href="/">الصفحة الرئيسية</a>
            <a href="/admin/site-settings">إعدادات الموقع</a>
            <a href="/admin/plans">إدارة الخطط</a>
            <a href="/admin/site-testimonials">إدارة الشهادات</a>
            <a href="/admin/site-features">إدارة المميزات</a>
        </div>
    </div>
</body>
</html>

<?php

function insertDefaultSettings($db, $year) {
    $copyrightText = "© " . $year . " منصة المواقع. جميع الحقوق محفوظة";
    
    $db->query("INSERT INTO site_settings 
        (hero_title, hero_subtitle, hero_button_text, hero_button_link,
         features_title, features_subtitle,
         pricing_title, pricing_subtitle,
         testimonials_title, contact_title,
         contact_email, contact_phone,
         meta_title, meta_description,
         footer_text, copyright_text,
         show_pricing_section, show_features, show_testimonials)
        VALUES 
        ('أنشئ موقعك الإلكتروني الاحترافي', 
         'منصة سهلة ومرنة لإنشاء مواقع احترافية بدون حاجة لخبرة تقنية. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.',
         'ابدأ الآن مجاناً', '/register',
         'لماذا تختارنا؟', 'نوفر لك كل ما تحتاجه لبناء حضور رقمي مميز',
         'خطط الأسعار', 'اختر الخطة المناسبة لاحتياجاتك',
         'ماذا يقول عملاؤنا', 'تواصل معنا',
         'info@cms-platform.com', '+966 50 000 0000',
         'منصة المواقع - أنشئ موقعك بسهولة', 
         'منصة متكاملة لإنشاء المواقع الإلكترونية بسهولة وبدون حاجة لخبرة تقنية.',
         'منصة المواقع - نساعدك في بناء حضورك الرقمي',
         ?,
         1, 1, 1)",
        [$copyrightText]
    );
}
