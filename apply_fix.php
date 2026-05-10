<?php
/**
 * ═══════════════════════════════════════════════════════════════════
 * RAKAZ THEME FIX v3 - تطبيق الإصلاحات الشاملة
 * ═══════════════════════════════════════════════════════════════════
 *
 * الإصلاحات:
 * 1. إضافة الدالة المفقودة previewDemoService() في SiteController.php
 * 2. إصلاح جميع روابط ثيم ركاز لاستخدام دالة url() مثل ثيم ماستر
 *
 * طريقة الاستخدام:
 * - انسخ مجلد rakaz-fix-v3 بالكامل إلى: C:\xampp\htdocs\takweenweb\
 * - افتح المتصفح: http://localhost/takweenweb/rakaz-fix-v3/apply_fix.php
 * - بعد التأكد من نجاح الإصلاح، احذف مجلد rakaz-fix-v3 من السيرفر
 *
 * ═══════════════════════════════════════════════════════════════════
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$results = [];
$errors = [];
$baseDir = dirname(__DIR__); // Parent directory = takweenweb root

// ═══════════════════════════════════════════════════════════════════
// STEP 1: Add previewDemoService() to SiteController.php
// ═══════════════════════════════════════════════════════════════════

$controllerPath = $baseDir . '/app/controllers/SiteController.php';

if (!file_exists($controllerPath)) {
    $errors[] = "SiteController.php غير موجود في: $controllerPath";
} else {
    $controllerContent = file_get_contents($controllerPath);
    
    if (strpos($controllerContent, 'function previewDemoService(') !== false) {
        $results[] = "previewDemoService() موجودة بالفعل — تم تخطي هذه الخطوة";
    } else {
        $newMethod = <<<'PHP'

    /**
     * ✅ صفحة معاينة ديمو - تفاصيل خدمة واحدة
     */
    public function previewDemoService($themeSlug, $serviceSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'service');

        // البحث عن الخدمة المطلوبة من قائمة الخدمات التجريبية
        $foundService = null;
        if (!empty($data['services'])) {
            foreach ($data['services'] as $svc) {
                if (($svc->slug ?? '') === $serviceSlug) {
                    $foundService = $svc;
                    break;
                }
            }
        }

        if (!$foundService) {
            $this->redirect('/theme-preview/' . $themeSlug . '/services');
            return;
        }

        $data['service'] = $foundService;
        $data['title'] = $foundService->title . ' - ' . $theme->name . ' (معاينة)';

        $this->renderTheme($themeSlug, 'service', $data);
    }

PHP;

        // Find insertion point: after previewDemoBooking() method, before service() method
        $marker = "    public function service(\$slug, \$serviceSlug)";
        $pos = strpos($controllerContent, $marker);
        
        if ($pos === false) {
            $errors[] = "لم يتم العثور على نقطة الإدراج في SiteController.php";
        } else {
            $controllerContent = substr($controllerContent, 0, $pos) . $newMethod . substr($controllerContent, $pos);
            
            if (file_put_contents($controllerPath, $controllerContent)) {
                $results[] = "تمت إضافة previewDemoService() في SiteController.php";
            } else {
                $errors[] = "فشل في الكتابة إلى SiteController.php — تحقق من الصلاحيات";
            }
        }
    }
}

// ═══════════════════════════════════════════════════════════════════
// STEP 2: Copy fixed theme files
// ═══════════════════════════════════════════════════════════════════

$srcDir = __DIR__ . '/themes/rakaz';
$dstDir = $baseDir . '/themes/rakaz';

$themeFiles = [
    'partials/_head.php',
    'partials/_navbar.php',
    'partials/_footer.php',
    'partials/_scripts.php',
    'default.php',
    'services.php',
    'service.php',
    'about.php',
    'contact.php',
    'gallery.php',
    'faq.php',
    'partners.php',
    'booking.php',
    '_navbar.php',
    '_footer.php',
    '_scripts.php',
];

foreach ($themeFiles as $file) {
    $src = $srcDir . '/' . $file;
    $dst = $dstDir . '/' . $file;
    
    if (!file_exists($src)) {
        $errors[] = "ملف المصدر غير موجود: themes/rakaz/$file";
        continue;
    }
    
    // Create directory if needed
    $dir = dirname($dst);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    if (copy($src, $dst)) {
        $results[] = "تم تحديث: themes/rakaz/$file";
    } else {
        $errors[] = "فشل نسخ: themes/rakaz/$file — تحقق من الصلاحيات";
    }
}

// ═══════════════════════════════════════════════════════════════════
// RESULTS
// ═══════════════════════════════════════════════════════════════════
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إصلاح ثيم ركاز v3</title>
    <style>
        * { font-family: 'Segoe UI', Tahoma, sans-serif; box-sizing: border-box; }
        body { background: #0f172a; color: #e2e8f0; padding: 40px 20px; margin: 0; }
        .container { max-width: 650px; margin: 0 auto; }
        h1 { color: #22d3ee; margin: 0 0 5px; font-size: 22px; }
        .subtitle { color: #64748b; font-size: 13px; margin-bottom: 30px; }
        .section-title { color: #94a3b8; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin: 24px 0 10px; padding-bottom: 6px; border-bottom: 1px solid #1e293b; }
        .item { padding: 8px 14px; border-radius: 6px; margin-bottom: 4px; font-size: 13px; font-family: 'Cascadia Code', 'Fira Code', monospace; }
        .ok { background: #064e3b; border-right: 3px solid #10b981; }
        .err { background: #7f1d1d; border-right: 3px solid #ef4444; }
        .warn { background: #78350f; border-right: 3px solid #f59e0b; }
        .box { background: #1e293b; border: 1px solid #334155; border-radius: 10px; padding: 16px; margin-top: 24px; font-size: 13px; line-height: 1.8; color: #94a3b8; }
        .box code { background: #0f172a; padding: 2px 6px; border-radius: 4px; font-size: 12px; color: #22d3ee; }
        .box .danger { color: #f87171; font-weight: bold; }
        .count { display: inline-block; background: #22d3ee; color: #0f172a; padding: 1px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; margin-right: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ إصلاح ثيم ركاز v3</h1>
        <div class="subtitle"><?= date('Y-m-d H:i:s') ?></div>

        <?php if (!empty($results)): ?>
            <div class="section-title">
                <span class="count"><?= count($results) ?></span>
                نجحت
            </div>
            <?php foreach ($results as $r): ?>
                <div class="item ok">✅ <?= htmlspecialchars($r) ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="section-title">
                <span class="count" style="background:#ef4444;color:#fff"><?= count($errors) ?></span>
                أخطاء
            </div>
            <?php foreach ($errors as $e): ?>
                <div class="item err">❌ <?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="box">
            <strong>ما تم إصلاحه:</strong><br>
            • إضافة الدالة المفقودة <code>previewDemoService()</code> — تحل خطأ 500 عند فتح صفحة خدمة<br>
            • لف جميع روابط التنقل بدالة <code>url()</code> — مثل ثيم ماستر الذي يعمل بشكل صحيح<br><br>
            <span class="danger">⚠️ احذف مجلد rakaz-fix-v3 من السيرفر بعد التأكد من عمل الإصلاحات.</span>
        </div>
    </div>
</body>
</html>
