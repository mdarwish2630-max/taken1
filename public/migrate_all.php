<?php
/**
 * ============================================================================
 * سكربت ترقية شامل لنظام الثيمات - ملف واحد يعمل كل شيء
 * ============================================================================
 * الاستخدام: ارفع هذا الملف إلى مجلد public/
 * ثم زره: http://localhost/takweenweb/migrate_all.php
 * بعد الانتهاء احذف الملف!
 * ============================================================================
 */

require_once __DIR__ . '/../app/config/config.php';

header('Content-Type: text/html; charset=utf-8');

$steps = [];
$allOk = true;

function runSQL($pdo, $sql, $stepName, &$steps, &$allOk) {
    try {
        $pdo->exec($sql);
        $steps[] = ['name' => $stepName, 'status' => 'ok', 'msg' => 'تم بنجاح'];
    } catch (Exception $e) {
        $allOk = false;
        $steps[] = ['name' => $stepName, 'status' => 'error', 'msg' => $e->getMessage()];
    }
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="UTF-8">
<title>ترقية نظام الثيمات</title>
<style>
*{font-family:'Segoe UI',Tahoma,sans-serif;direction:rtl}
body{background:#0f172a;color:#e2e8f0;padding:20px;margin:0}
.box{max-width:850px;margin:20px auto;background:#1e293b;border-radius:16px;padding:30px;box-shadow:0 8px 32px rgba(0,0,0,.3)}
h1{color:#38bdf8;margin:0 0 5px;font-size:22px}
h2{color:#94a3b8;font-size:14px;margin:0 0 25px;font-weight:400}
.step{padding:14px 18px;border-radius:10px;margin:8px 0;font-size:14px;line-height:1.7;border-right:4px solid transparent}
.step-ok{background:#052e16;border-color:#22c55e;color:#86efac}
.step-err{background:#450a0a;border-color:#ef4444;color:#fca5a5}
.step-info{background:#0c1929;border-color:#3b82f6;color:#93c5fd}
.step .label{font-weight:700;font-size:15px}
.step .detail{color:#94a3b8;font-size:12px;margin-top:4px}
.badge{display:inline-block;padding:1px 10px;border-radius:12px;font-size:11px;font-weight:700}
.badge-ok{background:#166534;color:#bbf7d0}
.badge-err{background:#991b1b;color:#fecaca}
.final{margin-top:30px;padding:20px;border-radius:12px;text-align:center;font-size:16px;font-weight:700}
.final-ok{background:#052e16;color:#4ade80;border:2px solid #22c55e}
.final-err{background:#450a0a;color:#f87171;border:2px solid #ef4444}
.footer{text-align:center;color:#475569;font-size:12px;margin-top:20px}
table{width:100%;border-collapse:collapse;margin:15px 0}
th,td{padding:8px 12px;text-align:right;border-bottom:1px solid #334155;font-size:13px}
th{color:#94a3b8}
code{background:#0f172a;padding:2px 8px;border-radius:4px;font-size:12px}
</style>
</head>
<body>
<div class="box">
<h1>ترقية نظام الثيمات - تكوين CMS</h1>
<h2>سكربت شامل: يعيد بناء الثيمات + يضيف الأعمدة المفقودة + مزامنة البيانات</h2>

<?php
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    echo '<div class="step step-err"><span class="label">فشل الاتصال بقاعدة البيانات</span><div class="detail">' . htmlspecialchars($e->getMessage()) . '</div></div>';
    echo '</div></body></html>';
    exit;
}

echo '<div class="step step-ok"><span class="label">الاتصال بقاعدة البيانات</span> - <code>' . DB_NAME . '</code> &nbsp;<span class="badge badge-ok">متصل</span></div>';

// ========== الخطوة 1: تعطيل فحص المفاتيح الأجنبية ==========
runSQL($pdo, "SET FOREIGN_KEY_CHECKS = 0", 'تعطيل فحص المفاتيح الأجنبية', $steps, $allOk);

// ========== الخطوة 2: تحديث معرفات الثيمات في tenants ==========
$mappings = [
    [6, 1], // general: كان 6، أصبح 1
    [3, 2], // electric: كان 3، أصبح 2
    [5, 3], // cleaning: كان 5، أصبح 3
    [2, 4], // decor: كان 2، أصبح 4
    [1, 5], // maintenance: كان 1، أصبح 5
    [4, 6], // plumbing: كان 4، أصبح 6
];

foreach ($mappings as $m) {
    try {
        $pdo->exec("UPDATE IGNORE `tenants` SET `theme_id` = {$m[1]} WHERE `theme_id` = {$m[0]}");
    } catch (Exception $e) {
        // تجاهل إذا الجدول غير موجود
    }
}
$steps[] = ['name' => 'تحديث معرفات الثيمات في جدول tenants', 'status' => 'ok', 'msg' => 'تم تحديث 6 تعيينات'];

// ========== الخطوة 3: حذف وإعادة بناء جدول themes ==========
runSQL($pdo, "DROP TABLE IF EXISTS `themes`", 'حذف جدول themes القديم', $steps, $allOk);

$createThemes = "CREATE TABLE `themes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL COMMENT 'اسم القالب بالعربية',
    `name_en` VARCHAR(100) DEFAULT NULL COMMENT 'اسم القالب بالإنجليزية',
    `slug` VARCHAR(100) NOT NULL COMMENT 'معرف القالب الفريد',
    `description` TEXT DEFAULT NULL,
    `description_en` TEXT DEFAULT NULL,
    `category` ENUM('general','maintenance','decor','electric','plumbing','cleaning','medical','realestate','restaurant','education','fitness','legal','other') NOT NULL DEFAULT 'general',
    `preview_image` VARCHAR(255) DEFAULT NULL,
    `thumbnail` VARCHAR(500) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_premium` TINYINT(1) NOT NULL DEFAULT 0,
    `is_paid` TINYINT(1) NOT NULL DEFAULT 0,
    `price` DECIMAL(10,2) DEFAULT 0.00,
    `currency` VARCHAR(10) DEFAULT 'SAR',
    `payment_link` VARCHAR(500) DEFAULT NULL,
    `sort_order` INT(11) NOT NULL DEFAULT 0,
    `version` VARCHAR(20) DEFAULT '1.0.0',
    `settings_schema` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `category` (`category`),
    KEY `is_active` (`is_active`),
    KEY `is_paid` (`is_paid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

runSQL($pdo, $createThemes, 'إنشاء جدول themes جديد', $steps, $allOk);

// ========== الخطوة 4: إدخال الثيمات الـ12 ==========
$themes = [
    [1, 'خدمات عامة', 'General Services', 'general', 'قالب متعدد الاستخدامات مناسب لجميع أنواع الخدمات', 'Versatile template for all types of services', 'general', 0, 0.00, 1],
    [2, 'كهرباء الموثوق', 'Reliable Electric', 'electric', 'قالب احترافي متخصص لشركات الكهرباء', 'Professional template for electrical companies', 'electric', 0, 0.00, 2],
    [3, 'نضارة', 'CleanSpark', 'cleaning', 'قالب منعش ومشرق لشركات التنظيف', 'Fresh template for cleaning companies', 'cleaning', 0, 0.00, 3],
    [4, 'أثر الديكور', 'Decor Mark', 'decor', 'قالب أنيق وفاخر لشركات الديكور', 'Elegant template for interior design', 'decor', 0, 0.00, 4],
    [5, 'الصيانة الأولى', 'First Maintenance', 'maintenance', 'قالب عملي وموثوق لشركات الصيانة', 'Practical template for maintenance', 'maintenance', 0, 0.00, 5],
    [6, 'سباكة الضمان', 'Warranty Plumbing', 'plumbing', 'قالب متخصص لشركات السباكة', 'Specialized template for plumbing', 'plumbing', 0, 0.00, 6],
    [7, 'طبيبروف', 'MediPro', 'medical', 'قالب طبي احترافي للعيادات والمستشفيات', 'Professional medical template', 'medical', 1, 149.00, 7],
    [8, 'عقار الخليج', 'Gulf Estates', 'realestate', 'قالب فاخر لشركات العقارات', 'Luxurious real estate template', 'realestate', 1, 199.00, 8],
    [9, 'مائدة شهية', 'Feast Table', 'restaurant', 'قالب أنيق للمطاعم والكافيهات', 'Elegant restaurant template', 'restaurant', 1, 149.00, 9],
    [10, 'مسار المعرفة', 'Knowledge Path Academy', 'education', 'قالب أكاديمي للمدارس ومراكز التدريب', 'Academic template for schools', 'education', 1, 149.00, 10],
    [11, 'العدل للمحاماة', 'Al-Adal Legal', 'legal', 'قالب رسمي فاخر لمكاتب المحاماة', 'Premium template for law firms', 'legal', 1, 199.00, 11],
    [12, 'أبطال الصحة', 'Health Champions', 'fitness', 'قالب رياضي للنوادي وصالات الجيم', 'Sports template for gyms', 'fitness', 1, 149.00, 12],
];

$inserted = 0;
foreach ($themes as $t) {
    try {
        $stmt = $pdo->prepare("INSERT INTO `themes` (`id`,`name`,`name_en`,`slug`,`description`,`description_en`,`category`,`preview_image`,`thumbnail`,`is_active`,`is_premium`,`is_paid`,`price`,`currency`,`sort_order`,`version`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $t[0], $t[1], $t[2], $t[3], $t[4], $t[5], $t[6],
            'uploads/themes/previews/' . $t[3] . '-preview.png',
            'uploads/themes/previews/' . $t[3] . '-preview.png',
            1, $t[7], $t[7], $t[8], 'SAR', $t[9], '1.0.0'
        ]);
        $inserted++;
    } catch (Exception $e) {
        $steps[] = ['name' => "إدخال ثيم: {$t[1]}", 'status' => 'error', 'msg' => $e->getMessage()];
        $allOk = false;
    }
}
$steps[] = ['name' => 'إدخال الثيمات الـ12', 'status' => 'ok', 'msg' => "تم إدخال {$inserted} ثيم"];

// ========== الخطوة 5: إعادة بناء جدول theme_requests ==========
runSQL($pdo, "DROP TABLE IF EXISTS `theme_requests`", 'حذف جدول theme_requests القديم', $steps, $allOk);

$createRequests = "CREATE TABLE IF NOT EXISTS `theme_requests` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tenant_id` INT(11) UNSIGNED NOT NULL,
    `theme_id` INT(11) UNSIGNED NOT NULL,
    `status` ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
    `amount` DECIMAL(10,2) DEFAULT 0.00,
    `currency` VARCHAR(10) DEFAULT 'SAR',
    `payment_method` VARCHAR(100) DEFAULT NULL,
    `payment_ref` VARCHAR(255) DEFAULT NULL,
    `admin_notes` TEXT DEFAULT NULL,
    `tenant_notes` TEXT DEFAULT NULL,
    `approved_at` DATETIME DEFAULT NULL,
    `rejected_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tenant_id` (`tenant_id`),
    KEY `theme_id` (`theme_id`),
    KEY `status` (`status`),
    CONSTRAINT `theme_requests_tenant_fk` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `theme_requests_theme_fk` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

runSQL($pdo, $createRequests, 'إنشاء جدول theme_requests', $steps, $allOk);

// ========== الخطوة 6: إعادة تفعيل فحص المفاتيح الأجنبية ==========
runSQL($pdo, "SET FOREIGN_KEY_CHECKS = 1", 'تفعيل فحص المفاتيح الأجنبية', $steps, $allOk);

// ========== الخطوة 7: إضافة الأعمدة المفقودة إلى theme_settings ==========
$newColumns = [
    'primary_font'       => "VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الرئيسي'",
    'secondary_font'     => "VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الثانوي'",
    'base_font_size'     => "VARCHAR(10) DEFAULT '16' COMMENT 'حجم الخط الأساسي'",
    'heading_font_weight'=> "VARCHAR(10) DEFAULT '700' COMMENT 'سمك خطوط العناوين'",
    'body_font_weight'   => "VARCHAR(10) DEFAULT '400' COMMENT 'سمك خطوط النص'",
    'primary_color'      => "VARCHAR(7) DEFAULT '#2563eb' COMMENT 'اللون الرئيسي'",
    'secondary_color'    => "VARCHAR(7) DEFAULT '#1e40af' COMMENT 'اللون الثانوي'",
    'accent_color'       => "VARCHAR(7) DEFAULT '#f59e0b' COMMENT 'لون التمييز'",
    'text_color'         => "VARCHAR(7) DEFAULT '#1f2937' COMMENT 'لون النص الرئيسي'",
    'text_muted_color'   => "VARCHAR(7) DEFAULT '#6b7280' COMMENT 'لون النص الثانوي'",
    'background_color'   => "VARCHAR(7) DEFAULT '#ffffff' COMMENT 'لون الخلفية'",
    'card_background'    => "VARCHAR(7) DEFAULT '#ffffff' COMMENT 'لون خلفية البطاقات'",
    'border_color'       => "VARCHAR(7) DEFAULT '#e5e7eb' COMMENT 'لون الحدود'",
    'button_radius'      => "VARCHAR(10) DEFAULT '8' COMMENT 'استدارة الأزرار'",
    'card_radius'        => "VARCHAR(10) DEFAULT '12' COMMENT 'استدارة البطاقات'",
    'button_shadow'      => "TINYINT(1) DEFAULT 0 COMMENT 'ظل الأزرار'",
    'card_hover_effect'  => "VARCHAR(20) DEFAULT 'lift' COMMENT 'تأثير تمرير البطاقات'",
    'enable_animations'  => "TINYINT(1) DEFAULT 1 COMMENT 'تفعيل الرسوم المتحركة'",
    'animation_type'     => "VARCHAR(20) DEFAULT 'fade' COMMENT 'نوع الرسوم المتحركة'",
    'container_width'    => "VARCHAR(10) DEFAULT '1200' COMMENT 'عرض الحاوية'",
    'header_fixed'       => "TINYINT(1) DEFAULT 0 COMMENT 'ثبات الرأس'",
    'sidebar_position'   => "VARCHAR(10) DEFAULT 'right' COMMENT 'موضع الشريط الجانبي'",
];

// جلب الأعمدة الموجودة
try {
    $stmt = $pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'theme_settings'");
    $existing = [];
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        $existing[] = $row->COLUMN_NAME;
    }
} catch (Exception $e) {
    $existing = [];
}

$colAdded = 0;
$colSkipped = 0;
$colErrors = [];

foreach ($newColumns as $colName => $colDef) {
    if (in_array($colName, $existing)) {
        $colSkipped++;
    } else {
        try {
            $pdo->exec("ALTER TABLE `theme_settings` ADD COLUMN `{$colName}` {$colDef}");
            $colAdded++;
        } catch (Exception $e) {
            $colErrors[] = $colName . ': ' . $e->getMessage();
            $allOk = false;
        }
    }
}

$steps[] = [
    'name' => 'إضافة أعمدة theme_settings',
    'status' => empty($colErrors) ? 'ok' : 'error',
    'msg' => "أضيف: {$colAdded} | موجودة: {$colSkipped}" . (empty($colErrors) ? '' : ' | أخطاء: ' . count($colErrors))
];

// ========== الخطوة 8: مزامنة الأعمدة القديمة ==========
$syncs = [];
if (in_array('font_primary', $existing)) {
    try {
        $pdo->exec("UPDATE `theme_settings` SET `primary_font` = `font_primary` WHERE `primary_font` = 'Tajawal' AND `font_primary` IS NOT NULL AND `font_primary` != 'Tajawal'");
        $syncs[] = 'font_primary → primary_font';
    } catch (Exception $e) {}
}
if (in_array('font_secondary', $existing)) {
    try {
        $pdo->exec("UPDATE `theme_settings` SET `secondary_font` = `font_secondary` WHERE `secondary_font` = 'Tajawal' AND `font_secondary` IS NOT NULL AND `font_secondary` != 'Tajawal'");
        $syncs[] = 'font_secondary → secondary_font';
    } catch (Exception $e) {}
}
if (in_array('font_size_base', $existing)) {
    try {
        $pdo->exec("UPDATE `theme_settings` SET `base_font_size` = REPLACE(`font_size_base`, 'px', '') WHERE `font_size_base` IS NOT NULL AND `font_size_base` != '16px'");
        $syncs[] = 'font_size_base → base_font_size';
    } catch (Exception $e) {}
}
if (in_array('animation_enabled', $existing)) {
    try {
        $pdo->exec("UPDATE `theme_settings` SET `enable_animations` = `animation_enabled` WHERE `animation_enabled` IS NOT NULL");
        $syncs[] = 'animation_enabled → enable_animations';
    } catch (Exception $e) {}
}

if (!empty($syncs)) {
    $steps[] = ['name' => 'مزامنة الأعمدة القديمة', 'status' => 'ok', 'msg' => implode(', ', $syncs)];
}

// ========== عرض النتائج ==========
echo '<hr style="border-color:#334155;margin:25px 0">';
echo '<h1 style="color:#38bdf8">نتائج الترقية</h1>';

foreach ($steps as $s) {
    $cls = $s['status'] === 'ok' ? 'step-ok' : 'step-err';
    $badge = $s['status'] === 'ok' ? '<span class="badge badge-ok">تم</span>' : '<span class="badge badge-err">خطأ</span>';
    echo '<div class="step ' . $cls . '">';
    echo '<span class="label">' . $s['name'] . '</span> ' . $badge;
    echo '<div class="detail">' . htmlspecialchars($s['msg']) . '</div>';
    echo '</div>';
}

// عرض الثيمات في جدول
try {
    $stmt = $pdo->query("SELECT id, name, name_en, slug, category, is_paid, price FROM themes ORDER BY id");
    $themes = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (count($themes) > 0) {
        echo '<hr style="border-color:#334155;margin:25px 0">';
        echo '<h1 style="color:#38bdf8">الثيمات المثبتة (' . count($themes) . ')</h1>';
        echo '<table>';
        echo '<tr><th>ID</th><th>الاسم</th><th>English</th><th>التصنيف</th><th>النوع</th><th>السعر</th></tr>';
        foreach ($themes as $t) {
            $type = $t->is_paid ? '<span style="color:#fbbf24">مدفوع</span>' : '<span style="color:#4ade80">مجاني</span>';
            echo '<tr>';
            echo '<td>' . $t->id . '</td>';
            echo '<td>' . htmlspecialchars($t->name) . '</td>';
            echo '<td>' . htmlspecialchars($t->name_en) . '</td>';
            echo '<td><code>' . $t->category . '</code></td>';
            echo '<td>' . $type . '</td>';
            echo '<td>' . ($t->is_paid ? $t->price . ' ر.س' : '-') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
} catch (Exception $e) {}

// عرض أعمدة theme_settings
try {
    $stmt = $pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'theme_settings' ORDER BY ORDINAL_POSITION");
    $cols = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo '<hr style="border-color:#334155;margin:25px 0">';
    echo '<h1 style="color:#38bdf8">أعمدة theme_settings (' . count($cols) . ' عمود)</h1>';
    echo '<table><tr><th>#</th><th>اسم العمود</th></tr>';
    $i = 1;
    foreach ($cols as $c) {
        $isNew = in_array($c->COLUMN_NAME, array_keys($newColumns));
        $extra = $isNew ? ' <span class="badge badge-ok">جديد</span>' : '';
        echo '<tr><td>' . $i++ . '</td><td><code>' . $c->COLUMN_NAME . '</code>' . $extra . '</td></tr>';
    }
    echo '</table>';
} catch (Exception $e) {}

// النتيجة النهائية
if ($allOk && empty($colErrors)) {
    echo '<div class="final final-ok">تمت الترقية بنجاح! جميع التعديلات طبقت.</div>';
} else {
    echo '<div class="final final-err">تمت الترقية مع بعض الأخطاء - راجع التفاصيل أعلاه</div>';
    if (!empty($colErrors)) {
        echo '<div class="step step-err"><span class="label">أخطاء الأعمدة:</span><div class="detail">';
        foreach ($colErrors as $err) { echo htmlspecialchars($err) . '<br>'; }
        echo '</div></div>';
    }
}

?>

<div class="footer">
    <strong>مهم:</strong> احذف هذا الملف الآن!<br>
    <code>public/migrate_all.php</code>
</div>
</div>
</body>
</html>
