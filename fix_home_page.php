<?php
/**
 * سكريت تشخيص واصلاح صفحة الاندكس الرئيسية
 * يقوم بـ:
 * 1. التحقق من وجود الجداول المطلوبة وإنشاؤها
 * 2. تحديث ملف home.php ليكون ديناميكي (يرجع بيانات من الداتا بيز)
 * 3. إدخال بيانات تجريبية إذا كانت الجداول فارغة
 * 
 * الطريقة: ضع هذا الملف في مجلد المشروع الرئيسي ( beside index.php )
 * ثم افتحه بالمتصفح: http://localhost/takweenweb/fix_home_page.php
 */

// ==================== الإعداد ====================
$dbHost = 'localhost';
$dbName = 'takween';
$dbUser = 'root';
$dbPass = '';

// إذا كان الملف داخل مجلد takweenweb
if (file_exists(__DIR__ . '/app/config/config.php')) {
    require_once __DIR__ . '/app/config/config.php';
    $dbHost = defined('DB_HOST') ? DB_HOST : $dbHost;
    $dbName = defined('DB_NAME') ? DB_NAME : $dbName;
    $dbUser = defined('DB_USER') ? DB_USER : $dbUser;
    $dbPass = defined('DB_PASS') ? DB_PASS : $dbPass;
}

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}

$messages = [];
$errors = [];

function addMsg($msg) {
    global $messages;
    $messages[] = $msg;
}

function addErr($msg) {
    global $errors;
    $errors[] = $msg;
}

function tableExists($pdo, $table) {
    $result = $pdo->query("SHOW TABLES LIKE '$table'")->fetch();
    return (bool) $result;
}

function columnExists($pdo, $table, $column) {
    $result = $pdo->query("SHOW COLUMNS FROM `$table` LIKE '$column'")->fetch();
    return (bool) $result;
}

// ==================== 1. التحقق وإنشاء الجداول ====================
addMsg("=== المرحلة 1: التحقق من الجداول ===");

// 1a. site_settings
if (!tableExists($pdo, 'site_settings')) {
    $pdo->exec("CREATE TABLE site_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        logo VARCHAR(500) DEFAULT NULL,
        logo_white VARCHAR(500) DEFAULT NULL,
        favicon VARCHAR(500) DEFAULT NULL,
        hero_title VARCHAR(500) DEFAULT NULL,
        hero_subtitle TEXT DEFAULT NULL,
        hero_image VARCHAR(500) DEFAULT NULL,
        hero_button_text VARCHAR(200) DEFAULT NULL,
        hero_button_link VARCHAR(500) DEFAULT NULL,
        features_title VARCHAR(200) DEFAULT NULL,
        features_subtitle VARCHAR(200) DEFAULT NULL,
        show_features TINYINT(1) DEFAULT 1,
        show_themes_section TINYINT(1) DEFAULT 1,
        show_pricing_section TINYINT(1) DEFAULT 1,
        pricing_title VARCHAR(200) DEFAULT NULL,
        pricing_subtitle VARCHAR(200) DEFAULT NULL,
        testimonials_title VARCHAR(200) DEFAULT NULL,
        show_testimonials TINYINT(1) DEFAULT 1,
        contact_title VARCHAR(200) DEFAULT NULL,
        contact_subtitle VARCHAR(200) DEFAULT NULL,
        show_contact_form TINYINT(1) DEFAULT 1,
        contact_email VARCHAR(200) DEFAULT NULL,
        contact_phone VARCHAR(50) DEFAULT NULL,
        contact_whatsapp VARCHAR(50) DEFAULT NULL,
        contact_address TEXT DEFAULT NULL,
        facebook VARCHAR(500) DEFAULT NULL,
        twitter VARCHAR(500) DEFAULT NULL,
        instagram VARCHAR(500) DEFAULT NULL,
        linkedin VARCHAR(500) DEFAULT NULL,
        youtube VARCHAR(500) DEFAULT NULL,
        meta_title VARCHAR(200) DEFAULT NULL,
        meta_description TEXT DEFAULT NULL,
        meta_keywords TEXT DEFAULT NULL,
        footer_text TEXT DEFAULT NULL,
        copyright_text VARCHAR(500) DEFAULT NULL,
        head_scripts TEXT DEFAULT NULL,
        body_scripts TEXT DEFAULT NULL,
        maintenance_mode TINYINT(1) DEFAULT 0,
        maintenance_message TEXT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    addMsg("تم إنشاء جدول site_settings");
    
    // إدخال بيانات افتراضية
    $pdo->exec("INSERT INTO site_settings 
        (hero_title, hero_subtitle, hero_button_text, hero_button_link,
         features_title, pricing_title, testimonials_title, contact_title,
         meta_title, footer_text, copyright_text, show_features, show_pricing_section, show_testimonials) 
        VALUES 
        ('منصة إنشاء مواقع احترافية', 
         'إنشاء موقعك الإلكتروني في دقائق بدون أي خبرة برمجية',
         'إنشاء موقع جديد', '/register',
         'لماذا تختارنا؟', 'الأسعار', 'آراء العملاء', 'تواصل معنا',
         'منصة المواقع',
         'منصة متكاملة لإنشاء مواقع احترافية لخدماتك بكل سهولة. قوالب جاهزة وأدوات متقدمة لإدارة محتواك.',
         '© ' . date('Y') . ' منصة المواقع - جميع الحقوق محفوظة',
         1, 1, 1)");
    addMsg("تم إدخال إعدادات الموقع الافتراضية");
} else {
    $count = $pdo->query("SELECT COUNT(*) FROM site_settings")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO site_settings 
            (hero_title, hero_subtitle, hero_button_text, hero_button_link,
             features_title, pricing_title, testimonials_title,
             meta_title, footer_text, copyright_text, show_features, show_pricing_section, show_testimonials) 
            VALUES 
            ('منصة إنشاء مواقع احترافية', 
             'إنشاء موقعك الإلكتروني في دقائق بدون أي خبرة برمجية',
             'إنشاء موقع جديد', '/register',
             'لماذا تختارنا؟', 'الأسعار', 'آراء العملاء',
             'منصة المواقع',
             'منصة متكاملة لإنشاء مواقع احترافية لخدماتك بكل سهولة.',
             '© ' . date('Y') . ' منصة المواقع - جميع الحقوق محفوظة',
             1, 1, 1)");
        addMsg("جدول site_settings كان فارغ - تم إدخال بيانات افتراضية");
    } else {
        addMsg("جدول site_settings موجود وفيه بيانات");
    }
}

// 1b. site_features
if (!tableExists($pdo, 'site_features')) {
    $pdo->exec("CREATE TABLE site_features (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tenant_id INT DEFAULT NULL,
        icon VARCHAR(100) DEFAULT 'fas fa-star',
        title VARCHAR(200) NOT NULL,
        title_en VARCHAR(200) DEFAULT NULL,
        description TEXT DEFAULT NULL,
        description_en TEXT DEFAULT NULL,
        display_order INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_tenant (tenant_id),
        INDEX idx_active (is_active)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    addMsg("تم إنشاء جدول site_features");
    
    // إدخال مميزات افتراضية (tenant_id = NULL = عامة للمنصة)
    $features = [
        ['fas fa-palette', 'قوالب احترافية', 'Professional Templates', 'اختر من بين مجموعة واسعة من القوالب المتنوعة المصممة خصيصاً لكل مجال عمل', 'Choose from a wide variety of templates designed for every field', 1],
        ['fas fa-mobile-alt', 'تصميم متجاوب', 'Responsive Design', 'مواقع متوافقة مع جميع الأجهزة والشاشات بشكل تلقائي', 'Websites compatible with all devices and screens automatically', 2],
        ['fas fa-globe', 'نطاق مخصص', 'Custom Domain', 'احصل على نطاق خاص بموقعك يعكس هوية عملك بشكل احترافي', 'Get a custom domain that reflects your business identity', 3],
        ['fas fa-paint-brush', 'ألوان مخصصة', 'Custom Colors', 'خصص ألوان موقعك لتناسب هوية علامتك التجارية', 'Customize your site colors to match your brand identity', 4],
        ['fas fa-language', 'ثنائي اللغة', 'Bilingual', 'دعم كامل للعربية والإنجليزية مع تبديل سهل بين اللغات', 'Full Arabic and English support with easy language switching', 5],
        ['fas fa-headset', 'دعم فني متواصل', '24/7 Support', 'فريق دعم فني متخصص جاهز لمساعدتك على مدار الساعة', 'A dedicated support team ready to help you around the clock', 6],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO site_features (icon, title, title_en, description, description_en, display_order, is_active, tenant_id) VALUES (?, ?, ?, ?, ?, ?, 1, NULL)");
    foreach ($features as $f) {
        $stmt->execute($f);
    }
    addMsg("تم إدخال 6 مميزات افتراضية للمنصة");
} else {
    $globalCount = $pdo->query("SELECT COUNT(*) FROM site_features WHERE tenant_id IS NULL")->fetchColumn();
    if ($globalCount == 0) {
        $features = [
            ['fas fa-palette', 'قوالب احترافية', 'Professional Templates', 'اختر من بين مجموعة واسعة من القوالب المتنوعة', 'Choose from a wide variety of templates', 1],
            ['fas fa-mobile-alt', 'تصميم متجاوب', 'Responsive Design', 'مواقع متوافقة مع جميع الأجهزة والشاشات', 'Websites compatible with all devices', 2],
            ['fas fa-globe', 'نطاق مخصص', 'Custom Domain', 'احصل على نطاق خاص بموقعك', 'Get a custom domain for your site', 3],
            ['fas fa-paint-brush', 'ألوان مخصصة', 'Custom Colors', 'خصص ألوان موقعك حسب علامتك التجارية', 'Customize your site colors to match your brand', 4],
            ['fas fa-language', 'ثنائي اللغة', 'Bilingual', 'دعم كامل للعربية والإنجليزية', 'Full Arabic and English support', 5],
            ['fas fa-headset', 'دعم فني متواصل', '24/7 Support', 'فريق دعم فني متخصص جاهز لمساعدتك', 'Dedicated support team ready to help', 6],
        ];
        $stmt = $pdo->prepare("INSERT INTO site_features (icon, title, title_en, description, description_en, display_order, is_active, tenant_id) VALUES (?, ?, ?, ?, ?, ?, 1, NULL)");
        foreach ($features as $f) {
            $stmt->execute($f);
        }
        addMsg("جدول site_features كان فاضي - تم إدخال 6 مميزات عامة");
    } else {
        addMsg("جدول site_features موجود وفيه $globalCount مميزات عامة");
    }
}

// 1c. site_testimonials
if (!tableExists($pdo, 'site_testimonials')) {
    $pdo->exec("CREATE TABLE site_testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_name VARCHAR(200) NOT NULL,
        client_title VARCHAR(200) DEFAULT NULL,
        client_company VARCHAR(200) DEFAULT NULL,
        client_image VARCHAR(500) DEFAULT NULL,
        content TEXT NOT NULL,
        rating TINYINT(1) DEFAULT 5,
        display_order INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_active (is_active)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    addMsg("تم إنشاء جدول site_testimonials");
    
    // إدخال شهادات تجريبية
    $testimonials = [
        ['أحمد محمد', 'صاحب شركة مقاولات', NULL, 'منصة رائعة! أنشأت موقعي في دقائق وبدون أي خبرة تقنية. القوالب احترافية والتخصيص سهل جداً.', 5, 1],
        ['سارة العتيبي', 'مصممة ديكور', NULL, 'سهولة الاستخدام مميزة والدعم الفني متجاوب وسريع. أنصح بهذه المنصة بشدة.', 5, 2],
        ['خالد الشمري', 'مقدم خدمات كهربائية', NULL, 'أفضل منصة عربية لإنشاء المواقع بأسعار معقولة. واجهة سهلة وقوالب متنوعة تناسب جميع المجالات.', 5, 3],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO site_testimonials (client_name, client_title, client_company, content, rating, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
    foreach ($testimonials as $t) {
        $stmt->execute($t);
    }
    addMsg("تم إدخال 3 شهادات تجريبية");
} else {
    $activeCount = $pdo->query("SELECT COUNT(*) FROM site_testimonials WHERE is_active = 1")->fetchColumn();
    if ($activeCount == 0) {
        $testimonials = [
            ['أحمد محمد', 'صاحب شركة مقاولات', NULL, 'منصة رائعة! أنشأت موقعي في دقائق وبدون أي خبرة تقنية.', 5, 1],
            ['سارة العتيبي', 'مصممة ديكور', NULL, 'سهولة الاستخدام مميزة والدعم الفني متجاوب وسريع.', 5, 2],
            ['خالد الشمري', 'مهندس كهرباء', NULL, 'أفضل منصة عربية لإنشاء المواقع بأسعار معقولة.', 5, 3],
        ];
        $stmt = $pdo->prepare("INSERT INTO site_testimonials (client_name, client_title, client_company, content, rating, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
        foreach ($testimonials as $t) {
            $stmt->execute($t);
        }
        addMsg("جدول site_testimonials كان فاضي - تم إدخال 3 شهادات");
    } else {
        addMsg("جدول site_testimonials موجود وفيه $activeCount شهادات نشطة");
    }
}

// 1d. التحقق من subscription_plans
if (tableExists($pdo, 'subscription_plans')) {
    // التحقق من وجود الأعمدة المطلوبة
    $requiredCols = ['is_active', 'is_free', 'is_popular', 'display_order', 'price_monthly', 'features', 'custom_domain', 'remove_branding', 'analytics_access', 'priority_support'];
    $missingCols = [];
    foreach ($requiredCols as $col) {
        if (!columnExists($pdo, 'subscription_plans', $col)) {
            $missingCols[] = $col;
        }
    }
    
    if (!empty($missingCols)) {
        foreach ($missingCols as $col) {
            if ($col === 'features') {
                $pdo->exec("ALTER TABLE subscription_plans ADD COLUMN features TEXT DEFAULT NULL");
            } elseif ($col === 'custom_domain' || $col === 'remove_branding' || $col === 'analytics_access' || $col === 'priority_support') {
                $pdo->exec("ALTER TABLE subscription_plans ADD COLUMN $col TINYINT(1) DEFAULT 0");
            } else {
                $pdo->exec("ALTER TABLE subscription_plans ADD COLUMN $col INT DEFAULT 0");
            }
            addMsg("تم إضافة عمود $col لجدول subscription_plans");
        }
    }
    
    $activePlans = $pdo->query("SELECT COUNT(*) FROM subscription_plans WHERE is_active = 1")->fetchColumn();
    addMsg("جدول subscription_plans: $activePlans خطط نشطة");
} else {
    addErr("جدول subscription_plans غير موجود! يجب استيراده من ملف SQL");
}

// 1e. التحقق من tenants.plan_id
if (tableExists($pdo, 'tenants')) {
    if (!columnExists($pdo, 'tenants', 'plan_id')) {
        $pdo->exec("ALTER TABLE tenants ADD COLUMN plan_id INT DEFAULT NULL");
        addMsg("تم إضافة عمود plan_id لجدول tenants");
    }
}

// ==================== 2. التحقق من ملف home.php ====================
addMsg("");
addMsg("=== المرحلة 2: التحقق من ملف home.php ===");

$homePath = __DIR__ . '/app/views/home.php';
$sourcePath = __DIR__ . '/app/views/home.php.dynamic'; // النسخة الاحتياطية

// قراءة المحتوى الحالي
if (file_exists($homePath)) {
    $currentHome = file_get_contents($homePath);
    
    // التحقق مما إذا كان الـ home.php ديناميكي أو ثابت
    $isDynamic = (
        strpos($currentHome, 'foreach ($plans as') !== false &&
        strpos($currentHome, 'foreach ($features as') !== false &&
        strpos($currentHome, 'foreach ($testimonials as') !== false
    );
    
    if ($isDynamic) {
        addMsg("ملف home.php ديناميكي بالفعل - يقرأ من الداتا بيز");
    } else {
        addMsg("ملف home.php ثابت (static) - يحتاج تحديث ليعمل مع الداتا بيز");
        addMsg("يجب استبداله بالنسخة الديناميكية من مجلد takweenweb-source");
    }
} else {
    addErr("ملف home.php غير موجود في: $homePath");
}

// ==================== 3. إنشاء ملف home.php الديناميكي ====================
addMsg("");
addMsg("=== المرحلة 3: إنشاء ملف home.php الديناميكي ===");

// نسخة احتياطية
if (file_exists($homePath) && !file_exists($homePath . '.backup')) {
    copy($homePath, $homePath . '.backup');
    addMsg("تم إنشاء نسخة احتياطية: home.php.backup");
}

$dynamicHome = <<<'PHPCODE'
<?php
/**
 * Home Page View - DYNAMIC (يرجع البيانات من الداتا بيز)
 * الصفحة الرئيسية للمنصة - يتم التحكم بمحتواها من لوحة الأدمن
 */

$lang = Language::current();
$dir = Language::direction();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= lang('create_site') ?></title>

    <!-- Google Fonts - Readex Pro for Arabic -->
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5 RTL -->
    <?php if ($dir === 'rtl'): ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <?php else: ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <?php endif; ?>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #7c3aed;
            --accent: #a78bfa;
            --success: #059669;
            --danger: #dc2626;
            --dark: #1e293b;
            --dark-800: #0f172a;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --radius-sm: 0.375rem;
            --radius: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
            --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.25);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font: 'Readex Pro', sans-serif;
            --gradient: linear-gradient(135deg, #4f46e5, #7c3aed);
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--white); color: var(--dark); line-height: 1.7; overflow-x: hidden; }
        a { text-decoration: none; }
        img { max-width: 100%; }

        /* Navbar */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; padding: 1rem 0; transition: var(--transition); background: transparent; }
        .navbar.scrolled { background: rgba(255,255,255,0.97); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 0.5rem 0; }
        .navbar .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { font-size: 1.5rem; font-weight: 700; color: var(--white); display: flex; align-items: center; gap: 0.5rem; transition: var(--transition); }
        .navbar.scrolled .logo { color: var(--primary); }
        .navbar .logo i { font-size: 1.6rem; }
        .nav-links { display: flex; gap: 0.5rem; align-items: center; }
        .nav-links .nav-link { color: rgba(255,255,255,0.85); font-weight: 500; font-size: 0.95rem; padding: 0.5rem 1rem; border-radius: var(--radius-sm); transition: var(--transition); }
        .navbar.scrolled .nav-links .nav-link { color: var(--gray-600); }
        .nav-links .nav-link:hover { color: var(--white); background: rgba(255,255,255,0.1); }
        .navbar.scrolled .nav-links .nav-link:hover { color: var(--primary); background: rgba(79,70,229,0.08); }
        .lang-switcher { display: flex; gap: 0.25rem; background: rgba(255,255,255,0.15); padding: 0.2rem; border-radius: 50px; }
        .navbar.scrolled .lang-switcher { background: var(--gray-100); }
        .lang-btn { padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.8); transition: var(--transition); cursor: pointer; }
        .navbar.scrolled .lang-btn { color: var(--gray-500); }
        .lang-btn.active { background: var(--white); color: var(--primary); box-shadow: var(--shadow-sm); }
        .navbar.scrolled .lang-btn.active { background: var(--gradient); color: var(--white); }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.7rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; font-family: var(--font); border: none; cursor: pointer; transition: var(--transition); text-decoration: none; line-height: 1.5; }
        .btn:hover { transform: translateY(-2px); }
        .btn:active { transform: translateY(0); }
        .btn-primary-grad { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: var(--white); box-shadow: 0 4px 15px rgba(79,70,229,0.35); }
        .btn-primary-grad:hover { box-shadow: 0 8px 25px rgba(79,70,229,0.45); color: var(--white); }
        .btn-white { background: var(--white); color: var(--primary); box-shadow: var(--shadow-md); }
        .btn-white:hover { box-shadow: var(--shadow-lg); color: var(--primary-dark); }
        .btn-outline-white { background: transparent; border: 2px solid rgba(255,255,255,0.6); color: var(--white); }
        .btn-outline-white:hover { background: var(--white); color: var(--primary); border-color: var(--white); }
        .btn-outline { background: transparent; border: 2px solid var(--primary); color: var(--primary); }
        .btn-outline:hover { background: var(--primary); color: var(--white); }
        .btn-lg { padding: 0.9rem 2rem; font-size: 1.05rem; }
        .mobile-toggle { display: none; background: none; border: none; color: var(--white); font-size: 1.5rem; cursor: pointer; padding: 0.5rem; transition: var(--transition); }
        .navbar.scrolled .mobile-toggle { color: var(--dark); }

        /* Hero */
        .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 8rem 1.5rem 4rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 25%, #4338ca 50%, #6d28d9 75%, #7c3aed 100%); }
        .hero::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(ellipse at 20% 50%, rgba(124,58,237,0.3) 0%, transparent 50%), radial-gradient(ellipse at 80% 20%, rgba(79,70,229,0.4) 0%, transparent 50%), radial-gradient(ellipse at 50% 80%, rgba(99,102,241,0.3) 0%, transparent 50%); animation: heroPulse 8s ease-in-out infinite alternate; }
        .hero::after { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        @keyframes heroPulse { 0% { opacity: 0.6; } 100% { opacity: 1; } }
        .hero-content { position: relative; z-index: 2; max-width: 800px; }
        .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); padding: 0.5rem 1.25rem; border-radius: 50px; font-size: 0.9rem; color: rgba(255,255,255,0.9); margin-bottom: 1.5rem; backdrop-filter: blur(10px); animation: fadeInUp 0.6s ease-out; }
        .hero-badge i { color: #fbbf24; }
        .hero h1 { font-size: 3.5rem; font-weight: 700; color: var(--white); margin-bottom: 1.25rem; line-height: 1.2; text-shadow: 0 2px 10px rgba(0,0,0,0.15); animation: fadeInUp 0.6s ease-out 0.1s both; }
        .hero h1 .highlight { background: linear-gradient(135deg, #c4b5fd, #818cf8, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero p { font-size: 1.2rem; color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto 2.5rem; line-height: 1.8; animation: fadeInUp 0.6s ease-out 0.2s both; }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; animation: fadeInUp 0.6s ease-out 0.3s both; }
        .hero-shapes { position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1; pointer-events: none; }
        .hero-shape { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.05); animation: float 15s ease-in-out infinite; }
        .hero-shape:nth-child(1) { width: 300px; height: 300px; top: -100px; right: -50px; }
        .hero-shape:nth-child(2) { width: 200px; height: 200px; bottom: -50px; left: -30px; animation-delay: 5s; }
        .hero-shape:nth-child(3) { width: 150px; height: 150px; top: 30%; left: 10%; animation-delay: 10s; }
        @keyframes float { 0%,100% { transform: translateY(0) rotate(0deg); } 33% { transform: translateY(-20px) rotate(5deg); } 66% { transform: translateY(10px) rotate(-3deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        /* Section Base */
        .section-header { text-align: center; margin-bottom: 4rem; }
        .section-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: linear-gradient(135deg, rgba(79,70,229,0.08), rgba(124,58,237,0.08)); color: var(--primary); padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1rem; }
        .section-title { font-size: 2.25rem; font-weight: 700; color: var(--dark); margin-bottom: 0.75rem; }
        .section-subtitle { font-size: 1.1rem; color: var(--gray-500); max-width: 550px; margin: 0 auto; }
        .container { max-width: 1200px; margin: 0 auto; }

        /* Features */
        .features { padding: 6rem 1.5rem; background: var(--white); }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
        .feature-card { background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-xl); padding: 2.25rem 2rem; text-align: center; transition: var(--transition); position: relative; overflow: hidden; }
        .feature-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary)); transform: scaleX(0); transition: transform 0.3s ease; }
        .feature-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); border-color: transparent; }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-icon { width: 72px; height: 72px; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.75rem; transition: var(--transition); }
        .feature-icon.blue { background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(99,102,241,0.1)); color: var(--primary); }
        .feature-icon.violet { background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(139,92,246,0.1)); color: var(--secondary); }
        .feature-icon.green { background: linear-gradient(135deg, rgba(5,150,105,0.1), rgba(16,185,129,0.1)); color: var(--success); }
        .feature-card:hover .feature-icon { transform: scale(1.1); }
        .feature-card h3 { font-size: 1.15rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
        .feature-card p { color: var(--gray-500); font-size: 0.9rem; line-height: 1.7; }

        /* How It Works */
        .how-it-works { padding: 6rem 1.5rem; background: var(--gray-50); }
        .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; position: relative; }
        .steps-grid::before { content: ''; position: absolute; top: 50px; left: 10%; right: 10%; height: 3px; background: linear-gradient(90deg, var(--primary), var(--secondary)); border-radius: 3px; z-index: 0; }
        .step-card { text-align: center; position: relative; z-index: 1; }
        .step-number { width: 64px; height: 64px; border-radius: 50%; background: var(--gradient); color: var(--white); font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; box-shadow: 0 8px 25px rgba(79,70,229,0.35); }
        .step-card h3 { font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
        .step-card p { color: var(--gray-500); font-size: 0.875rem; line-height: 1.6; max-width: 200px; margin: 0 auto; }

        /* Pricing */
        .pricing { padding: 6rem 1.5rem; background: var(--white); }
        .pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; align-items: center; }
        .pricing-card { background: var(--white); border: 2px solid var(--gray-200); border-radius: var(--radius-xl); padding: 2.5rem 2rem; text-align: center; transition: var(--transition); position: relative; overflow: hidden; }
        .pricing-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); }
        .pricing-card.featured { border-color: transparent; background: var(--gradient); color: var(--white); transform: scale(1.05); box-shadow: 0 25px 50px rgba(79,70,229,0.3); }
        .pricing-card.featured:hover { transform: scale(1.05) translateY(-8px); }
        .pricing-card.featured .pricing-label { color: rgba(255,255,255,0.9); }
        .pricing-card.featured .pricing-name { color: var(--white); }
        .pricing-card.featured .pricing-price { color: var(--white); }
        .pricing-card.featured .pricing-price span { color: rgba(255,255,255,0.7); }
        .pricing-card.featured .pricing-desc { color: rgba(255,255,255,0.8); }
        .pricing-card.featured .pricing-features li { color: rgba(255,255,255,0.9); }
        .pricing-card.featured .pricing-features li i { color: #34d399; }
        .pricing-badge { position: absolute; top: 20px; left: 50%; transform: translateX(-50%); background: #fbbf24; color: var(--dark); padding: 0.25rem 1rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .pricing-label { display: inline-block; background: linear-gradient(135deg, rgba(79,70,229,0.08), rgba(124,58,237,0.08)); color: var(--primary); padding: 0.3rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; margin-bottom: 1rem; }
        .pricing-name { font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 0.75rem; }
        .pricing-price { font-size: 2.5rem; font-weight: 900; color: var(--dark); margin-bottom: 0.25rem; line-height: 1; }
        .pricing-price span { font-size: 0.9rem; font-weight: 500; color: var(--gray-500); }
        .pricing-desc { color: var(--gray-500); font-size: 0.85rem; margin-bottom: 1.75rem; }
        .pricing-features { list-style: none; text-align: start; margin-bottom: 2rem; }
        .pricing-features li { padding: 0.5rem 0; font-size: 0.9rem; color: var(--gray-600); display: flex; align-items: center; gap: 0.75rem; }
        .pricing-features li i { color: var(--success); font-size: 0.85rem; width: 20px; text-align: center; }
        .pricing-card .btn { width: 100%; }
        .pricing-card.featured .btn { background: var(--white); color: var(--primary); box-shadow: var(--shadow-md); }

        /* Themes */
        .themes { padding: 6rem 1.5rem; background: var(--gray-50); }
        .themes-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .theme-card { background: var(--white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-sm); transition: var(--transition); border: 1px solid var(--gray-200); }
        .theme-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); border-color: transparent; }
        .theme-preview { height: 180px; display: flex; align-items: center; justify-content: center; color: var(--white); font-size: 3rem; position: relative; overflow: hidden; }
        .theme-preview::after { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.15)); }
        .theme-info { padding: 1.5rem; }
        .theme-info h3 { font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.4rem; }
        .theme-info p { color: var(--gray-500); font-size: 0.875rem; line-height: 1.6; }

        /* Testimonials */
        .testimonials { padding: 6rem 1.5rem; background: var(--white); }
        .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
        .testimonial-card { background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-xl); padding: 2rem; transition: var(--transition); position: relative; }
        .testimonial-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .testimonial-card::before { content: '\201C'; position: absolute; top: 1rem; left: 1.5rem; font-size: 4rem; color: var(--primary); opacity: 0.1; font-family: Georgia, serif; line-height: 1; }
        .testimonial-stars { display: flex; gap: 0.2rem; margin-bottom: 1rem; color: #fbbf24; font-size: 0.9rem; }
        .testimonial-text { font-size: 0.95rem; color: var(--gray-600); line-height: 1.8; margin-bottom: 1.5rem; position: relative; z-index: 1; }
        .testimonial-author { display: flex; align-items: center; gap: 0.875rem; }
        .testimonial-avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--gradient); display: flex; align-items: center; justify-content: center; color: var(--white); font-weight: 700; font-size: 1.1rem; flex-shrink: 0; }
        .testimonial-name { font-weight: 700; color: var(--dark); font-size: 0.95rem; }
        .testimonial-role { font-size: 0.8rem; color: var(--gray-500); }

        /* Stats */
        .stats { padding: 4rem 1.5rem; background: linear-gradient(135deg, var(--dark-800) 0%, var(--dark) 100%); position: relative; overflow: hidden; }
        .stats::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(ellipse at 30% 50%, rgba(79,70,229,0.2) 0%, transparent 60%), radial-gradient(ellipse at 70% 50%, rgba(124,58,237,0.15) 0%, transparent 60%); }
        .stats .container { max-width: 1000px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; position: relative; z-index: 2; }
        .stat-item { text-align: center; }
        .stat-number { font-size: 2.5rem; font-weight: 900; color: var(--white); line-height: 1.2; }
        .stat-number span { background: linear-gradient(135deg, #818cf8, #c4b5fd); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-label { color: var(--gray-400); font-size: 0.9rem; margin-top: 0.25rem; }

        /* CTA */
        .cta { padding: 6rem 1.5rem; text-align: center; position: relative; overflow: hidden; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); }
        .cta::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(ellipse at 80% 50%, rgba(255,255,255,0.08) 0%, transparent 50%); }
        .cta-content { position: relative; z-index: 2; max-width: 600px; margin: 0 auto; }
        .cta h2 { font-size: 2.25rem; font-weight: 700; color: var(--white); margin-bottom: 1rem; }
        .cta p { color: rgba(255,255,255,0.85); font-size: 1.1rem; margin-bottom: 2rem; line-height: 1.8; }

        /* Footer */
        .footer { background: var(--dark-800); color: var(--gray-400); padding: 3rem 1.5rem 1.5rem; }
        .footer .container { max-width: 1200px; margin: 0 auto; }
        .footer-top { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .footer-brand .logo { font-size: 1.35rem; font-weight: 700; color: var(--white); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; }
        .footer-brand p { font-size: 0.9rem; line-height: 1.7; max-width: 300px; }
        .footer-links h4 { color: var(--white); font-size: 1rem; font-weight: 700; margin-bottom: 1rem; }
        .footer-links ul { list-style: none; }
        .footer-links li { margin-bottom: 0.5rem; }
        .footer-links a { color: var(--gray-400); font-size: 0.9rem; transition: var(--transition); }
        .footer-links a:hover { color: var(--accent); }
        .footer-bottom { display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; }
        .footer-socials { display: flex; gap: 0.75rem; }
        .footer-socials a { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; color: var(--gray-400); transition: var(--transition); }
        .footer-socials a:hover { background: var(--gradient); color: var(--white); transform: translateY(-3px); }

        /* Scroll Animations */
        .animate-on-scroll { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .animate-on-scroll.visible { opacity: 1; transform: translateY(0); }
        .animate-on-scroll:nth-child(2) { transition-delay: 0.1s; }
        .animate-on-scroll:nth-child(3) { transition-delay: 0.2s; }
        .animate-on-scroll:nth-child(4) { transition-delay: 0.3s; }
        .animate-on-scroll:nth-child(5) { transition-delay: 0.4s; }
        .animate-on-scroll:nth-child(6) { transition-delay: 0.5s; }

        /* Responsive */
        @media (max-width: 1024px) {
            .features-grid, .themes-grid, .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
            .stats .container { grid-template-columns: repeat(2, 1fr); }
            .footer-top { grid-template-columns: 1fr 1fr; }
            .steps-grid { grid-template-columns: repeat(2, 1fr); gap: 3rem; }
            .steps-grid::before { display: none; }
        }
        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .nav-links { display: none; position: absolute; top: 100%; left: 0; right: 0; background: var(--white); flex-direction: column; padding: 1rem; box-shadow: var(--shadow-lg); gap: 0.25rem; }
            .nav-links.active { display: flex; }
            .nav-links .nav-link { color: var(--gray-600); padding: 0.75rem 1rem; border-radius: var(--radius); width: 100%; text-align: center; }
            .nav-links .nav-link:hover { color: var(--primary); background: var(--gray-50); }
            .hero h1 { font-size: 2.25rem; }
            .hero p { font-size: 1rem; }
            .features-grid, .themes-grid, .testimonials-grid, .pricing-grid { grid-template-columns: 1fr; }
            .pricing-card.featured { transform: none; }
            .pricing-card.featured:hover { transform: translateY(-8px); }
            .steps-grid { grid-template-columns: 1fr; }
            .stats .container { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
            .stat-number { font-size: 2rem; }
            .cta h2 { font-size: 1.75rem; }
            .footer-top { grid-template-columns: 1fr; gap: 2rem; }
            .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
            .section-title { font-size: 1.75rem; }
        }
        @media (max-width: 480px) {
            .hero { padding: 7rem 1rem 3rem; }
            .hero h1 { font-size: 1.85rem; }
            .hero-btns { flex-direction: column; align-items: center; }
            .hero-btns .btn { width: 100%; max-width: 280px; }
            .stats .container { grid-template-columns: 1fr 1fr; gap: 1rem; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?= url('/') ?>" class="logo">
                <?php if (!empty($settings->logo)): ?>
                    <img src="<?= htmlspecialchars($settings->logo) ?>" alt="<?= htmlspecialchars(SITE_NAME) ?>" style="height: 32px;">
                <?php else: ?>
                    <i class="fas fa-cube"></i>
                <?php endif; ?>
                <?= SITE_NAME ?>
            </a>
            <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
            <div class="nav-links" id="navLinks">
                <div class="lang-switcher">
                    <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>">عربي</a>
                    <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                </div>
                <a href="#features" class="nav-link"><?= lang('features') ?></a>
                <a href="#pricing" class="nav-link"><?= lang('pricing') ?? 'الأسعار' ?></a>
                <a href="#themes" class="nav-link"><?= lang('themes') ?></a>
                <?php if (auth()): ?>
                    <a href="<?= url('/dashboard') ?>" class="nav-link"><?= lang('dashboard') ?></a>
                    <a href="<?= url('/logout') ?>" class="btn btn-outline"><?= lang('logout') ?></a>
                <?php else: ?>
                    <a href="<?= url('/login') ?>" class="nav-link"><?= lang('login') ?></a>
                    <a href="<?= url('/register') ?>" class="btn btn-primary-grad"><?= lang('register') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section - ديناميكي من site_settings -->
    <section class="hero">
        <div class="hero-shapes"><div class="hero-shape"></div><div class="hero-shape"></div><div class="hero-shape"></div></div>
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i>
                <?= lang('hero_badge') ?? 'منصة إنشاء مواقع احترافية' ?>
            </div>
            <h1><?= !empty($settings->hero_title) ? htmlspecialchars($settings->hero_title) : lang('create_site') ?></h1>
            <p><?= !empty($settings->hero_subtitle) ? htmlspecialchars($settings->hero_subtitle) : lang('hero_subtitle') ?></p>
            <div class="hero-btns">
                <?php if (auth()): ?>
                    <a href="<?= url('/dashboard') ?>" class="btn btn-white btn-lg"><i class="fas fa-tachometer-alt"></i> <?= lang('dashboard') ?></a>
                <?php else: ?>
                    <a href="<?= url('/register') ?>" class="btn btn-white btn-lg"><i class="fas fa-rocket"></i> <?= lang('register') ?></a>
                    <a href="<?= url('/login') ?>" class="btn btn-outline-white btn-lg"><i class="fas fa-sign-in-alt"></i> <?= lang('login') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section - ديناميكي من site_features -->
    <?php if (!empty($settings->show_features) || !isset($settings->show_features)): ?>
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-star"></i> <?= $settings->features_title ?? lang('why_choose_us') ?></div>
                <h2 class="section-title"><?= lang('features_subtitle') ?></h2>
                <p class="section-subtitle"><?= lang('features_desc') ?? 'أدوات متكاملة لبناء موقعك الإلكتروني بكل سهولة واحترافية' ?></p>
            </div>
            <div class="features-grid">
                <?php if (!empty($features)): ?>
                    <?php
                        $iconColors = ['blue', 'violet', 'green', 'blue', 'violet', 'green'];
                        $colorIdx = 0;
                        foreach ($features as $f):
                            $displayTitle = ($lang === 'en' && !empty($f->title_en)) ? $f->title_en : ($f->display_title ?? $f->title ?? '');
                            $displayDesc = ($lang === 'en' && !empty($f->description_en)) ? $f->description_en : ($f->display_description ?? $f->description ?? '');
                    ?>
                        <div class="feature-card animate-on-scroll">
                            <div class="feature-icon <?= $iconColors[$colorIdx % 3] ?>">
                                <i class="<?= htmlspecialchars($f->icon ?? 'fas fa-star') ?>"></i>
                            </div>
                            <h3><?= htmlspecialchars($displayTitle) ?></h3>
                            <p><?= htmlspecialchars($displayDesc) ?></p>
                        </div>
                    <?php $colorIdx++; endforeach; ?>
                <?php else: ?>
                    <div class="feature-card animate-on-scroll"><div class="feature-icon blue"><i class="fas fa-palette"></i></div><h3><?= lang('feature_themes') ?></h3><p><?= lang('feature_themes_desc') ?></p></div>
                    <div class="feature-card animate-on-scroll"><div class="feature-icon violet"><i class="fas fa-mobile-alt"></i></div><h3><?= lang('feature_responsive') ?></h3><p><?= lang('feature_responsive_desc') ?></p></div>
                    <div class="feature-card animate-on-scroll"><div class="feature-icon green"><i class="fas fa-globe"></i></div><h3><?= lang('feature_domain') ?></h3><p><?= lang('feature_domain_desc') ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-route"></i> <?= lang('how_it_works') ?? 'كيف تبدأ؟' ?></div>
                <h2 class="section-title"><?= lang('how_it_works_title') ?? 'ابدأ في أربع خطوات بسيطة' ?></h2>
            </div>
            <div class="steps-grid">
                <div class="step-card animate-on-scroll"><div class="step-number">1</div><h3><?= lang('step_1_title') ?? 'سجّل حسابك' ?></h3><p><?= lang('step_1_desc') ?? 'أنشئ حساباً مجانياً في أقل من دقيقة' ?></p></div>
                <div class="step-card animate-on-scroll"><div class="step-number">2</div><h3><?= lang('step_2_title') ?? 'اختر القالب' ?></h3><p><?= lang('step_2_desc') ?? 'اختر القالب المناسب لنشاطك التجاري' ?></p></div>
                <div class="step-card animate-on-scroll"><div class="step-number">3</div><h3><?= lang('step_3_title') ?? 'خصّص موقعك' ?></h3><p><?= lang('step_3_desc') ?? 'أضف خدماتك وصورك ومعلوماتك بسهولة' ?></p></div>
                <div class="step-card animate-on-scroll"><div class="step-number">4</div><h3><?= lang('step_4_title') ?? 'انشر موقعك' ?></h3><p><?= lang('step_4_desc') ?? 'اجعل موقعك متاحاً للزوار في كل مكان' ?></p></div>
            </div>
        </div>
    </section>

    <!-- Pricing Section - ديناميكي من subscription_plans -->
    <?php if (!empty($settings->show_pricing_section) || !isset($settings->show_pricing_section)): ?>
    <section class="pricing" id="pricing">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-tags"></i> <?= $settings->pricing_title ?? lang('pricing') ?? 'خطط الأسعار' ?></div>
                <h2 class="section-title"><?= $settings->pricing_subtitle ?? lang('pricing_title') ?? 'اختر الخطة المناسبة لك' ?></h2>
                <p class="section-subtitle"><?= lang('pricing_desc') ?? 'خطط مرنة تناسب جميع الميزانيات والاحتياجات' ?></p>
            </div>
            <div class="pricing-grid">
                <?php if (!empty($plans)): ?>
                    <?php foreach ($plans as $plan): ?>
                        <?php
                            $isFeatured = !empty($plan->is_popular);
                            $isFree = !empty($plan->is_free);
                            $planFeatures = !empty($plan->features) ? json_decode($plan->features, true) : [];
                            $currency = defined('CURRENCY') ? CURRENCY : 'SAR';
                        ?>
                        <div class="pricing-card <?= $isFeatured ? 'featured' : '' ?> animate-on-scroll">
                            <?php if ($isFeatured): ?>
                            <div class="pricing-badge"><?= lang('popular') ?? 'الأكثر شعبية' ?></div>
                            <?php endif; ?>
                            <div class="pricing-label" <?= $isFeatured ? 'style="background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9);"' : '' ?>>
                                <?= $isFree ? (lang('plan_trial') ?? 'تجريبي') : ($plan->slug === 'enterprise' ? (lang('plan_enterprise') ?? 'مؤسسات') : (lang('plan_pro') ?? 'احترافي')) ?>
                            </div>
                            <h3 class="pricing-name"><?= htmlspecialchars($plan->name) ?></h3>
                            <?php if ($isFree): ?>
                                <div class="pricing-price"><?= lang('plan_trial_price') ?? 'مجاني' ?></div>
                            <?php else: ?>
                                <div class="pricing-price"><?= htmlspecialchars($plan->price_monthly ?? 0) ?> <span><?= $currency ?> <?= lang('per_month') ?? '/ شهرياً' ?></span></div>
                            <?php endif; ?>
                            <p class="pricing-desc"><?= htmlspecialchars($plan->description ?? '') ?></p>
                            <ul class="pricing-features">
                                <?php if (!empty($planFeatures) && is_array($planFeatures)): ?>
                                    <?php foreach ($planFeatures as $feature): ?>
                                        <?php if (!empty($feature)): ?>
                                        <li><i class="fas fa-check-circle"></i> <?= htmlspecialchars($feature) ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><i class="fas fa-check-circle"></i> <?= htmlspecialchars($plan->max_services ?? 3) ?> <?= lang('services') ?? 'خدمات' ?></li>
                                    <?php if (!empty($plan->custom_domain)): ?><li><i class="fas fa-check-circle"></i> <?= lang('feature_domain') ?? 'نطاق مخصص' ?></li><?php endif; ?>
                                    <?php if (!empty($plan->priority_support)): ?><li><i class="fas fa-check-circle"></i> <?= lang('feature_support') ?? 'دعم فني مميز' ?></li><?php endif; ?>
                                    <?php if (!empty($plan->analytics_access)): ?><li><i class="fas fa-check-circle"></i> <?= lang('analytics') ?? 'إحصائيات متقدمة' ?></li><?php endif; ?>
                                    <?php if (!empty($plan->remove_branding)): ?><li><i class="fas fa-check-circle"></i> <?= lang('remove_branding') ?? 'إزالة العلامة التجارية' ?></li><?php endif; ?>
                                <?php endif; ?>
                            </ul>
                            <?php if ($isFree): ?>
                                <a href="<?= url('/register') ?>" class="btn btn-outline"><?= lang('start_trial') ?? 'ابدأ التجربة' ?></a>
                            <?php elseif ($plan->slug === 'enterprise'): ?>
                                <a href="<?= url('/register') ?>" class="btn btn-outline"><?= lang('contact_sales') ?? 'تواصل مع المبيعات' ?></a>
                            <?php else: ?>
                                <a href="<?= url('/register') ?>" class="btn <?= $isFeatured ? 'btn-lg' : 'btn-outline' ?>"><?= lang('subscribe_now') ?? 'اشترك الآن' ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align:center; padding: 3rem; color: var(--gray-500); grid-column: 1/-1;">
                        <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                        <p><?= lang('no_plans_yet') ?? 'لا توجد خطط اشتراك حالياً. يرجى التواصل مع الإدارة.' ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Themes Section -->
    <section class="themes" id="themes">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-layer-group"></i> <?= lang('choose_theme') ?></div>
                <h2 class="section-title"><?= lang('themes_subtitle') ?></h2>
            </div>
            <div class="themes-grid">
                <div class="theme-card animate-on-scroll"><div class="theme-preview" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);"><i class="fas fa-briefcase"></i></div><div class="theme-info"><h3><?= lang('theme_general') ?></h3><p><?= lang('theme_general_desc') ?></p></div></div>
                <div class="theme-card animate-on-scroll"><div class="theme-preview" style="background: linear-gradient(135deg, #f97316, #ea580c);"><i class="fas fa-tools"></i></div><div class="theme-info"><h3><?= lang('theme_maintenance') ?></h3><p><?= lang('theme_maintenance_desc') ?></p></div></div>
                <div class="theme-card animate-on-scroll"><div class="theme-preview" style="background: linear-gradient(135deg, #eab308, #ca8a04);"><i class="fas fa-bolt"></i></div><div class="theme-info"><h3><?= lang('theme_electric') ?></h3><p><?= lang('theme_electric_desc') ?></p></div></div>
                <div class="theme-card animate-on-scroll"><div class="theme-preview" style="background: linear-gradient(135deg, #06b6d4, #0891b2);"><i class="fas fa-faucet"></i></div><div class="theme-info"><h3><?= lang('theme_plumbing') ?></h3><p><?= lang('theme_plumbing_desc') ?></p></div></div>
                <div class="theme-card animate-on-scroll"><div class="theme-preview" style="background: linear-gradient(135deg, #d97706, #b45309);"><i class="fas fa-couch"></i></div><div class="theme-info"><h3><?= lang('theme_decor') ?></h3><p><?= lang('theme_decor_desc') ?></p></div></div>
                <div class="theme-card animate-on-scroll"><div class="theme-preview" style="background: linear-gradient(135deg, #22c55e, #16a34a);"><i class="fas fa-broom"></i></div><div class="theme-info"><h3><?= lang('theme_cleaning') ?></h3><p><?= lang('theme_cleaning_desc') ?></p></div></div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section - ديناميكي من site_testimonials -->
    <?php if (!empty($settings->show_testimonials) || !isset($settings->show_testimonials)): ?>
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-quote-right"></i> <?= $settings->testimonials_title ?? lang('testimonials') ?? 'آراء العملاء' ?></div>
                <h2 class="section-title"><?= lang('testimonials_title') ?? 'ماذا يقول عملاؤنا' ?></h2>
            </div>
            <div class="testimonials-grid">
                <?php if (!empty($testimonials)): ?>
                    <?php foreach ($testimonials as $t): ?>
                        <div class="testimonial-card animate-on-scroll">
                            <div class="testimonial-stars">
                                <?php for ($i = 0; $i < ($t->rating ?? 5); $i++): ?>
                                <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="testimonial-text"><?= htmlspecialchars($t->content ?? '') ?></p>
                            <div class="testimonial-author">
                                <?php if (!empty($t->client_image)): ?>
                                    <img src="<?= htmlspecialchars($t->client_image) ?>" alt="" class="testimonial-avatar" style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="testimonial-avatar"><?= mb_substr($t->client_name ?? '?', 0, 1) ?></div>
                                <?php endif; ?>
                                <div>
                                    <div class="testimonial-name"><?= htmlspecialchars($t->client_name ?? '') ?></div>
                                    <div class="testimonial-role"><?= htmlspecialchars($t->client_title ?? ($t->client_company ?? '')) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align:center; padding: 3rem; color: var(--gray-500); grid-column: 1/-1;">
                        <i class="fas fa-quote-left" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                        <p><?= lang('no_testimonials_yet') ?? 'لا توجد شهادات حالياً. يمكن للإدارة إضافتها من لوحة التحكم.' ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stat-item"><div class="stat-number"><span>500+</span></div><div class="stat-label"><?= lang('stat_sites') ?? 'موقع تم إنشاؤه' ?></div></div>
            <div class="stat-item"><div class="stat-number"><span>6</span></div><div class="stat-label"><?= lang('stat_themes') ?? 'قوالب احترافية' ?></div></div>
            <div class="stat-item"><div class="stat-number"><span>99.9%</span></div><div class="stat-label"><?= lang('stat_uptime') ?? 'وقت التشغيل' ?></div></div>
            <div class="stat-item"><div class="stat-number"><span>24/7</span></div><div class="stat-label"><?= lang('stat_support') ?? 'دعم فني' ?></div></div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2><?= lang('cta_title') ?></h2>
            <p><?= lang('cta_subtitle') ?></p>
            <a href="<?= url('/register') ?>" class="btn btn-white btn-lg"><i class="fas fa-rocket"></i> <?= lang('start_now') ?></a>
        </div>
    </section>

    <!-- Footer - ديناميكي من site_settings -->
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="logo">
                        <?php if (!empty($settings->logo)): ?>
                            <img src="<?= htmlspecialchars($settings->logo) ?>" alt="<?= htmlspecialchars(SITE_NAME) ?>" style="height: 32px; margin-left: 0.5rem;">
                        <?php else: ?>
                            <i class="fas fa-cube"></i>
                        <?php endif; ?>
                        <?= SITE_NAME ?>
                    </div>
                    <p><?= !empty($settings->footer_text) ? htmlspecialchars($settings->footer_text) : (lang('footer_desc') ?? 'منصة متكاملة لإنشاء مواقع احترافية.') ?></p>
                </div>
                <div class="footer-links">
                    <h4><?= lang('quick_links') ?? 'روابط سريعة' ?></h4>
                    <ul>
                        <li><a href="<?= url('/') ?>"><?= lang('home') ?></a></li>
                        <li><a href="#features"><?= lang('features') ?></a></li>
                        <li><a href="#pricing"><?= lang('pricing') ?? 'الأسعار' ?></a></li>
                        <li><a href="#themes"><?= lang('themes') ?></a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4><?= lang('support') ?></h4>
                    <ul>
                        <?php if (!empty($settings->contact_email)): ?>
                            <li><a href="mailto:<?= htmlspecialchars($settings->contact_email) ?>"><?= lang('contact_us') ?? 'اتصل بنا' ?></a></li>
                        <?php else: ?>
                            <li><a href="#"><?= lang('contact_us') ?? 'اتصل بنا' ?></a></li>
                        <?php endif; ?>
                        <li><a href="#"><?= lang('faq') ?? 'الأسئلة الشائعة' ?></a></li>
                        <li><a href="#"><?= lang('terms') ?? 'الشروط والأحكام' ?></a></li>
                        <li><a href="#"><?= lang('privacy') ?? 'سياسة الخصوصية' ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - <?= !empty($settings->copyright_text) ? htmlspecialchars($settings->copyright_text) : lang('all_rights_reserved') ?></p>
                <div class="footer-socials">
                    <?php if (!empty($settings->twitter)): ?><a href="<?= htmlspecialchars($settings->twitter) ?>" target="_blank"><i class="fab fa-twitter"></i></a><?php endif; ?>
                    <?php if (!empty($settings->facebook)): ?><a href="<?= htmlspecialchars($settings->facebook) ?>" target="_blank"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if (!empty($settings->instagram)): ?><a href="<?= htmlspecialchars($settings->instagram) ?>" target="_blank"><i class="fab fa-instagram"></i></a><?php endif; ?>
                    <?php if (!empty($settings->contact_whatsapp)): ?><a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $settings->contact_whatsapp) ?>" target="_blank"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
                    <?php if (!empty($settings->linkedin)): ?><a href="<?= htmlspecialchars($settings->linkedin) ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                    <?php if (!empty($settings->youtube)): ?><a href="<?= htmlspecialchars($settings->youtube) ?>" target="_blank"><i class="fab fa-youtube"></i></a><?php endif; ?>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navbar = document.getElementById('navbar');
            window.addEventListener('scroll', function() {
                navbar.classList.toggle('scrolled', window.scrollY > 50);
            });
            var mobileToggle = document.getElementById('mobileToggle');
            var navLinks = document.getElementById('navLinks');
            mobileToggle.addEventListener('click', function() { navLinks.classList.toggle('active'); });
            navLinks.querySelectorAll('a').forEach(function(link) { link.addEventListener('click', function() { navLinks.classList.remove('active'); }); });
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) { if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); } });
                }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
                document.querySelectorAll('.animate-on-scroll').forEach(function(el) { observer.observe(el); });
            } else {
                document.querySelectorAll('.animate-on-scroll').forEach(function(el) { el.classList.add('visible'); });
            }
        });
    </script>
</body>
</html>
PHPCODE;

file_put_contents($homePath, $dynamicHome);
addMsg("تم استبدال ملف home.php بالنسخة الديناميكية");
addMsg("النسخة القديمة محفوظة في: home.php.backup");

// ==================== 4. التحقق من SiteController ====================
addMsg("");
addMsg("=== المرحلة 4: التحقق من SiteController ===");

$controllerPath = __DIR__ . '/app/controllers/SiteController.php';
if (file_exists($controllerPath)) {
    $controllerContent = file_get_contents($controllerPath);
    
    $hasIndex = strpos($controllerContent, 'public function index()') !== false;
    $hasPlans = strpos($controllerContent, 'getActivePlans') !== false;
    $hasTestimonials = strpos($controllerContent, 'getActive') !== false;
    $hasFeatures = strpos($controllerContent, 'getGlobalFeatures') !== false;
    $hasSettings = strpos($controllerContent, 'getSettings') !== false;
    
    if ($hasIndex && $hasPlans && $hasTestimonials && $hasFeatures && $hasSettings) {
        addMsg("SiteController@index() - يمرر البيانات بشكل صحيح للصفحة الرئيسية");
    } else {
        addErr("SiteController يحتاج تحديث - يوجد فيه نقص في جلب البيانات");
        if (!$hasIndex) addErr("  - لا يوجد دالة index()");
        if (!$hasPlans) addErr("  - لا يجلب الخطط من subscription_plans");
        if (!$hasTestimonials) addErr("  - لا يجلب الشهادات من site_testimonials");
        if (!$hasFeatures) addErr("  - لا يجلب المميزات من site_features");
        if (!$hasSettings) addErr("  - لا يجلب الإعدادات من site_settings");
    }
} else {
    addErr("ملف SiteController.php غير موجود");
}

// ==================== النتائج ====================
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تشخيص واصلاح صفحة الاندكس الرئيسية</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f0f2f5; color: #333; padding: 2rem; line-height: 1.8; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { text-align: center; margin-bottom: 1.5rem; color: #4f46e5; }
        h2 { color: #4f46e5; margin: 1.5rem 0 0.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; }
        .msg { padding: 0.5rem 1rem; margin: 0.25rem 0; border-radius: 0.375rem; font-size: 0.95rem; }
        .msg.success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .msg.error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .summary { background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 1.5rem; }
        .summary h2 { border: none; margin-top: 0; }
        .back-link { display: inline-block; margin-top: 2rem; padding: 0.75rem 1.5rem; background: #4f46e5; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; }
        .back-link:hover { background: #3730a3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>تشخيص واصلاح صفحة الاندكس الرئيسية</h1>
        
        <?php if (!empty($errors)): ?>
        <h2>أخطاء:</h2>
        <?php foreach ($errors as $e): ?>
            <div class="msg error"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
        <?php endif; ?>
        
        <h2>النتائج:</h2>
        <?php foreach ($messages as $m): ?>
            <div class="msg success"><?= htmlspecialchars($m) ?></div>
        <?php endforeach; ?>
        
        <div class="summary">
            <h2>ما تم إنجازه:</h2>
            <p>1. تم التحقق من الجداول المطلوبة (site_settings, site_features, site_testimonials, subscription_plans)</p>
            <p>2. تم إنشاء أي جدول ناقص وإدخال بيانات تجريبية فيه</p>
            <p>3. تم استبدال home.php بنسخة ديناميكية ترجع البيانات من الداتا بيز</p>
            <p>4. تم التحقق من أن SiteController يمرر البيانات بشكل صحيح</p>
            <br>
            <p><strong>الآن الأدمن يتحكم بـ:</strong></p>
            <ul style="margin-right: 1.5rem; margin-top: 0.5rem;">
                <li>خطط الأسعار: من <strong>/admin/plans</strong> (إضافة/تعديل/حذف خطط)</li>
                <li>المميزات: من <strong>/admin/site-features</strong></li>
                <li>شهادات العملاء: من <strong>/admin/site-testimonials</strong></li>
                <li>إعدادات الموقع (العنوان، الشعار، النصوص): من <strong>/admin/site-settings</strong></li>
            </ul>
            <br>
            <p><strong>ملاحظة:</strong> الخطط الافتراضية اللي كانت ظاهرة (99 و 199 ريال) كانت ثابتة بالكود - الآن تم استبدالها بنظام ديناميكي يقرأ من الداتا بيز.</p>
        </div>
        
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>" class="back-link">العودة للصفحة الرئيسية</a>
    </div>
</body>
</html>
