<?php
/**
 * إصلاح جدول خطط الاشتراك - ملف تشغيل واحد
 * ضع هذا الملف في مجلد المشروع الرئيسي وافتحه بالمتصفح:
 * http://localhost/takweenweb/setup_plans.php
 * بعد الانتهاء احذف هذا الملف
 */

// تحميل الإعدادات
require_once __DIR__ . '/app/config/config.php';

// الاتصال بقاعدة البيانات
try {
    // قراءة إعدادات الداتابيز من config
    $config = require __DIR__ . '/app/config/config.php';
    
    // محاولة الاتصال المباشر
    $host = 'localhost';
    $dbname = 'takweenweb'; // غيّر هذا إذا اسم قاعدة البيانات مختلف عندك
    $user = 'root';
    $pass = '';
    
    // محاولة قراءة القيم من ملف config
    if (defined('DB_HOST')) $host = DB_HOST;
    if (defined('DB_NAME')) $dbname = DB_NAME;
    if (defined('DB_USER')) $user = DB_USER;
    if (defined('DB_PASS')) $pass = DB_PASS;
    if (defined('DB_DATABASE')) $dbname = DB_DATABASE;
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "<h2>تم الاتصال بقاعدة البيانات بنجاح ✅</h2>";
    echo "<p>القاعدة: <strong>$dbname</strong></p><hr>";
    
} catch (PDOException $e) {
    echo "<h2 style='color:red;'>خطأ في الاتصال بقاعدة البيانات ❌</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>تأكد من تعديل اسم قاعدة البيانات في الملف</strong></p>";
    echo "<p>ابحث عن السطر: <code>\$dbname = 'takweenweb';</code> وغيّره لاسم قاعدة البيانات الصحيح عندك</p>";
    exit;
}

// الخطوة 1: فحص الأعمدة الحالية
echo "<h3>الخطوة 1: فحص الجدول الحالي</h3>";

$columns = [];
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM subscription_plans");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $columns[] = $row['Field'];
    }
    echo "<p>عدد الأعمدة الحالية: " . count($columns) . "</p>";
    echo "<p style='color:gray;'>" . implode(', ', $columns) . "</p>";
} catch (Exception $e) {
    echo "<p style='color:orange;'>الجدول غير موجود - سيتم إنشاؤه</p>";
}

// الأعمدة الصحيحة
$requiredColumns = [
    'price_monthly', 'price_yearly', 'features', 'custom_domain', 
    'remove_branding', 'analytics_access', 'priority_support', 
    'max_gallery', 'display_order'
];

$oldColumns = [
    'price', 'duration_days', 'trial_days', 'has_custom_domain',
    'has_ssl', 'has_analytics', 'has_custom_colors', 'has_gallery',
    'has_testimonials', 'has_banners', 'has_blog', 'has_forms',
    'has_seo', 'max_gallery_images', 'max_testimonials', 'max_forms',
    'storage_limit_mb', 'is_free', 'sort_order'
];

$hasNew = false;
$hasOld = false;
foreach ($requiredColumns as $col) {
    if (in_array($col, $columns)) $hasNew = true;
}
foreach ($oldColumns as $col) {
    if (in_array($col, $columns)) $hasOld = true;
}

// الخطوة 2: الإصلاح
echo "<h3>الخطوة 2: إصلاح الجدول</h3>";

if ($hasNew && !$hasOld) {
    echo "<p style='color:green;font-weight:bold;'>✅ الجدول صحيح بالفعل! لا حاجة لأي تعديل.</p>";
} else {
    try {
        // حفظ البيانات القديمة إن وجدت
        $oldData = [];
        if (count($columns) > 0) {
            $stmt = $pdo->query("SELECT * FROM subscription_plans ORDER BY id");
            $oldData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<p>تم حفظ " . count($oldData) . " خطط قديمة</p>";
        }
        
        // حذف الجدول القديم
        $pdo->exec("DROP TABLE IF EXISTS subscription_plans");
        echo "<p>تم حذف الجدول القديم</p>";
        
        // إنشاء الجدول الجديد بالأعمدة الصحيحة
        $pdo->exec("CREATE TABLE `subscription_plans` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL,
            `slug` VARCHAR(100) NOT NULL,
            `description` TEXT DEFAULT NULL,
            `price_monthly` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            `price_yearly` DECIMAL(10,2) DEFAULT NULL,
            `currency` VARCHAR(10) NOT NULL DEFAULT 'SAR',
            `features` TEXT DEFAULT NULL,
            `max_pages` INT(11) NOT NULL DEFAULT -1,
            `max_services` INT(11) NOT NULL DEFAULT -1,
            `max_gallery` INT(11) NOT NULL DEFAULT -1,
            `max_banners` INT(11) NOT NULL DEFAULT -1,
            `custom_domain` TINYINT(1) NOT NULL DEFAULT 0,
            `remove_branding` TINYINT(1) NOT NULL DEFAULT 0,
            `analytics_access` TINYINT(1) NOT NULL DEFAULT 0,
            `priority_support` TINYINT(1) NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `is_popular` TINYINT(1) NOT NULL DEFAULT 0,
            `display_order` INT(11) NOT NULL DEFAULT 0,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `slug` (`slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "<p style='color:green;'>✅ تم إنشاء الجدول الجديد بالأعمدة الصحيحة</p>";
        
        // نقل الخطط القديمة مع تحويل الأعمدة
        if (count($oldData) > 0) {
            $insert = $pdo->prepare("INSERT INTO subscription_plans 
                (name, slug, description, price_monthly, currency, max_pages, max_services, max_gallery, max_banners,
                 custom_domain, is_active, is_popular, display_order, features) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            foreach ($oldData as $old) {
                $priceMonthly = $old['price_monthly'] ?? $old['price'] ?? 0;
                $customDomain = $old['custom_domain'] ?? $old['has_custom_domain'] ?? 0;
                $analytics = $old['analytics_access'] ?? $old['has_analytics'] ?? 0;
                $maxGallery = $old['max_gallery'] ?? $old['max_gallery_images'] ?? -1;
                $displayOrder = $old['display_order'] ?? $old['sort_order'] ?? 0;
                
                // تجميع المميزات
                $feats = [];
                if (!empty($old['has_ssl'])) $feats[] = 'SSL';
                if (!empty($old['has_blog'])) $feats[] = 'مدونة';
                if (!empty($old['has_forms'])) $feats[] = 'نماذج';
                if (!empty($old['has_seo'])) $feats[] = 'SEO';
                if (!empty($old['remove_branding'])) $feats[] = 'إزالة العلامة التجارية';
                if (!empty($old['priority_support'])) $feats[] = 'دعم ذو أولوية';
                $featuresJson = !empty($feats) ? json_encode($feats, JSON_UNESCAPED_UNICODE) : null;
                
                $insert->execute([
                    $old['name'],
                    $old['slug'],
                    $old['description'] ?? null,
                    $priceMonthly,
                    $old['currency'] ?? 'SAR',
                    $old['max_pages'] ?? -1,
                    $old['max_services'] ?? -1,
                    $maxGallery,
                    $old['max_banners'] ?? -1,
                    $customDomain,
                    $old['is_active'] ?? 1,
                    $old['is_popular'] ?? 0,
                    $displayOrder,
                    $featuresJson
                ]);
            }
            echo "<p style='color:green;'>✅ تم نقل " . count($oldData) . " خطط قديمة بنجاح</p>";
        } else {
            // إضافة خطط تجريبية
            $demoPlans = [
                ['الخطة المجانية', 'free', 'تجربة مجانية مع ميزات محدودة', 0, -1, -1, 5, 3, 2, 0, 1, 0, 0, 1],
                ['الخطة الأساسية', 'basic', 'مناسبة للمشاريع الصغيرة', 99, 199, null, 10, 10, 3, 0, 1, 0, 1, null],
                ['الخطة الاحترافية', 'professional', 'مناسبة للشركات المتوسطة', 299, 599, null, 25, 25, 5, 1, 1, 1, 2, null],
                ['الخطة المتقدمة', 'premium', 'ميزات متقدمة للشركات', 499, 999, null, -1, 50, 10, 1, 1, 1, 3, null],
                ['الخطة المؤسسية', 'enterprise', 'للشركات الكبيرة - كل الميزات', 799, 1499, null, -1, -1, -1, 1, 1, 1, 4, null],
            ];
            
            $insert = $pdo->prepare("INSERT INTO subscription_plans 
                (name, slug, description, price_monthly, price_yearly, currency, max_pages, max_services, max_gallery, max_banners,
                 custom_domain, remove_branding, analytics_access, priority_support, is_active, is_popular, display_order) 
                VALUES (?, ?, ?, ?, ?, 'SAR', ?, ?, ?, ?, 0, 0, 0, ?, ?, ?)");
            
            foreach ($demoPlans as $p) {
                $insert->execute([
                    $p[0], $p[1], $p[2], $p[3], $p[4],
                    $p[5], $p[6], $p[7], $p[8], $p[9], $p[10], $p[11], $p[12]
                ]);
            }
            echo "<p style='color:green;'>✅ تم إضافة 5 خطط تجريبية</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ خطأ: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// الخطوة 3: التحقق النهائي
echo "<h3>الخطوة 3: التحقق النهائي</h3>";

try {
    $stmt = $pdo->query("SELECT * FROM subscription_plans ORDER BY display_order ASC, price_monthly ASC");
    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>عدد الخطط: <strong>" . count($plans) . "</strong></p>";
    
    if (count($plans) > 0) {
        echo "<table border='1' cellpadding='8' style='border-collapse:collapse; margin-top:10px;'>";
        echo "<tr style='background:#4f46e5;color:white;'>";
        echo "<th>الاسم</th><th>السعر الشهري</th><th>الخدمات</th><th>الصفحات</th><th>نشط</th>";
        echo "</tr>";
        foreach ($plans as $p) {
            echo "<tr>";
            echo "<td><strong>" . htmlspecialchars($p['name']) . "</strong></td>";
            echo "<td>" . number_format($p['price_monthly'], 0) . " " . htmlspecialchars($p['currency']) . "</td>";
            echo "<td>" . ($p['max_services'] == -1 ? '∞' : $p['max_services']) . "</td>";
            echo "<td>" . ($p['max_pages'] == -1 ? '∞' : $p['max_pages']) . "</td>";
            echo "<td>" . ($p['is_active'] ? '✅' : '❌') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<br><p style='color:green;font-size:1.2em;font-weight:bold;'>✅ تم بنجاح! الآن ادخل على صفحة خطط الاشتراك عند الأدمن</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>خطأ في القراءة: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<p style='color:red;'><strong>⚠️ احذف هذا الملف بعد الانتهاء!</strong></p>";
echo "<p><a href='/admin/plans'>👉 الذهاب لصفحة الخطط</a></p>";
?>
