<?php
/**
 * ============================================================================
 * سكربت إضافة الأعمدة المفقودة إلى جدول theme_settings
 * ============================================================================
 * الاستخدام: ارفع هذا الملف إلى مجلد public/
 * ثم زره من المتصفح: http://localhost/takweenweb/migrate_theme_settings.php
 * بعد الانتهاء، احذف هذا الملف فوراً!
 * ============================================================================
 */

// تحميل الإعدادات (نفس طريقة public/index.php)
require_once __DIR__ . '/../app/config/config.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ترقية theme_settings</title>
    <style>
        * { font-family: 'Tajawal', 'Segoe UI', Tahoma, sans-serif; direction: rtl; }
        body { background: #f3f4f6; padding: 40px; margin: 0; }
        .container { max-width: 800px; margin: 0 auto; background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h1 { color: #1e40af; font-size: 24px; margin-top: 0; }
        .status { padding: 16px 20px; border-radius: 10px; margin: 12px 0; font-size: 15px; line-height: 1.8; }
        .success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .info { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
        .warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
        .error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .skip { background: #f9fafb; border: 1px solid #e5e7eb; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px 14px; text-align: right; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { background: #f9fafb; font-weight: 700; color: #374151; }
        .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-ok { background: #dcfce7; color: #166534; }
        .badge-add { background: #dbeafe; color: #1e40af; }
        .badge-skip { background: #f3f4f6; color: #6b7280; }
        code { background: #f3f4f6; padding: 2px 8px; border-radius: 6px; font-size: 13px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>
<div class="container">
    <h1>ترقية جدول theme_settings</h1>
    <p>هذا السكربت يضيف الأعمدة المفقودة بأمان (بدون تكرار أو حذف بيانات)</p>

<?php
try {
    // استخدام PDO مباشرة من إعدادات المشروع
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // الأعمدة المطلوبة: اسم العمود => التعريف
    $columns = [
        'primary_font'       => "VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الرئيسي'",
        'secondary_font'     => "VARCHAR(100) DEFAULT 'Tajawal' COMMENT 'الخط الثانوي'",
        'base_font_size'     => "VARCHAR(10) DEFAULT '16' COMMENT 'حجم الخط الأساسي بكسل'",
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
        'container_width'    => "VARCHAR(10) DEFAULT '1200' COMMENT 'عرض الحاوية بكسل'",
        'header_fixed'       => "TINYINT(1) DEFAULT 0 COMMENT 'ثبات الرأس'",
        'sidebar_position'   => "VARCHAR(10) DEFAULT 'right' COMMENT 'موضع الشريط الجانبي'",
    ];

    // جلب الأعمدة الموجودة حالياً
    $stmt = $pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'theme_settings'");
    $existing = [];
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        $existing[] = $row->COLUMN_NAME;
    }

    $added = 0;
    $skipped = 0;
    $results = [];

    foreach ($columns as $colName => $colDef) {
        if (in_array($colName, $existing)) {
            $results[] = ['name' => $colName, 'def' => $colDef, 'status' => 'skip'];
            $skipped++;
        } else {
            $sql = "ALTER TABLE `theme_settings` ADD COLUMN `{$colName}` {$colDef}";
            $pdo->exec($sql);
            $results[] = ['name' => $colName, 'def' => $colDef, 'status' => 'added'];
            $added++;
        }
    }

    // مزامنة الأعمدة القديمة (إن وجدت)
    $syncs = 0;

    if (in_array('font_primary', $existing)) {
        $pdo->exec("UPDATE `theme_settings` SET `primary_font` = `font_primary` WHERE `primary_font` = 'Tajawal' AND `font_primary` IS NOT NULL AND `font_primary` != 'Tajawal'");
        $syncs++;
    }

    if (in_array('font_secondary', $existing)) {
        $pdo->exec("UPDATE `theme_settings` SET `secondary_font` = `font_secondary` WHERE `secondary_font` = 'Tajawal' AND `font_secondary` IS NOT NULL AND `font_secondary` != 'Tajawal'");
        $syncs++;
    }

    if (in_array('font_size_base', $existing)) {
        $pdo->exec("UPDATE `theme_settings` SET `base_font_size` = REPLACE(`font_size_base`, 'px', '') WHERE `font_size_base` IS NOT NULL AND `font_size_base` != '16px'");
        $syncs++;
    }

    if (in_array('animation_enabled', $existing)) {
        $pdo->exec("UPDATE `theme_settings` SET `enable_animations` = `animation_enabled` WHERE `animation_enabled` IS NOT NULL");
        $syncs++;
    }

    // عرض النتائج
    echo '<div class="status success">تم الاتصال بقاعدة البيانات بنجاح - <strong>' . DB_NAME . '</strong></div>';
    echo '<div class="status info">الأعمدة الموجودة مسبقاً: <strong>' . count($existing) . '</strong> | الأعمدة المطلوبة: <strong>' . count($columns) . '</strong></div>';

    if ($added > 0) {
        echo '<div class="status success"><strong>تمت إضافة ' . $added . ' عمود جديد بنجاح</strong></div>';
    } else {
        echo '<div class="status info">جميع الأعمدة موجودة مسبقاً - لا حاجة للتحديث</div>';
    }

    if ($skipped > 0) {
        echo '<div class="status skip">تم تخطي <strong>' . $skipped . '</strong> عمود (موجودة مسبقاً)</div>';
    }

    if ($syncs > 0) {
        echo '<div class="status info">تمت مزامنة <strong>' . $syncs . '</strong> أعمدة من القديمة إلى الجديدة</div>';
    }

    // جدول التفاصيل
    echo '<table>';
    echo '<tr><th>#</th><th>اسم العمود</th><th>التعريف</th><th>الحالة</th></tr>';

    $i = 1;
    foreach ($results as $r) {
        $badge = $r['status'] === 'added'
            ? '<span class="badge badge-add">تمت الإضافة</span>'
            : '<span class="badge badge-skip">موجود مسبقاً</span>';
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td><code>' . $r['name'] . '</code></td>';
        echo '<td style="font-size:12px; color:#6b7280;">' . htmlspecialchars($r['def']) . '</td>';
        echo '<td>' . $badge . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    echo '<div class="status success" style="margin-top:30px;">تمت الترقية بنجاح! يمكنك الآن حذف هذا الملف.</div>';

} catch (Exception $e) {
    echo '<div class="status error"><strong>خطأ:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
}
?>

    <div class="footer">
        <strong>تنبيه:</strong> احذف هذا الملف (<code>public/migrate_theme_settings.php</code>) فور الانتهاء من الترقية!
    </div>
</div>
</body>
</html>
