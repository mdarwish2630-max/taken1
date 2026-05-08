<?php
/**
 * تشخيص صفحة الخطط - يجرب الكود نفسه اللي بيجري عند الأدمن
 * http://localhost/takweenweb/diag_plans.php
 * ⚠️ احذفه بعد الانتهاء
 */

// نحمّل Framework نفسه
define('SKIP_ROUTING', true);
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/core/Session.php';
require_once __DIR__ . '/app/core/Model.php';
require_once __DIR__ . '/app/models/SubscriptionPlan.php';

echo "<style>
body { font-family: 'Segoe UI', Tahoma, sans-serif; max-width: 900px; margin: 40px auto; padding: 20px; background: #f8fafc; }
h1 { color: #1e293b; }
h2 { color: #334155; margin-top: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }
.ok { color: #16a34a; font-weight: bold; }
.err { color: #dc2626; font-weight: bold; }
.warn { color: #d97706; }
.box { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin: 12px 0; }
.sql { background: #1e293b; color: #a5f3fc; padding: 12px; border-radius: 6px; font-family: monospace; direction: ltr; text-align: left; white-space: pre-wrap; word-break: break-all; }
table { width: 100%; border-collapse: collapse; margin: 12px 0; }
th { background: #4f46e5; color: white; padding: 10px; text-align: left; }
td { padding: 8px 10px; border-bottom: 1px solid #e2e8f0; }
</style>";

echo "<h1>🔍 تشخيص صفحة خطط الاشتراك</h1>";

// ===== الخطوة 1: الاتصال بالداتابيز =====
echo "<h2>1️⃣ الاتصال بقاعدة البيانات</h2>";
try {
    $db = Database::getInstance();
    echo "<div class='box'><span class='ok'>✅ تم الاتصال بنجاح</span> — القاعدة: <strong>" . DB_NAME . "</strong></div>";
} catch (Exception $e) {
    echo "<div class='box'><span class='err'>❌ فشل الاتصال:</span> " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}

// ===== الخطوة 2: فحص جدول subscription_plans =====
echo "<h2>2️⃣ فحص جدول subscription_plans</h2>";
try {
    $cols = $db->query("SHOW COLUMNS FROM subscription_plans")->results();
    echo "<div class='box'>";
    echo "<span class='ok'>✅ الجدول موجود</span> — " . count($cols) . " أعمدة<br>";
    foreach ($cols as $c) {
        echo "<code style='background:#f1f5f9;padding:2px 6px;border-radius:4px;margin:2px;display:inline-block;font-size:13px;'>" . $c->Field . "</code> ";
    }
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='box'><span class='err'>❌ خطأ:</span> " . htmlspecialchars($e->getMessage()) . "</div>";
}

// ===== الخطوة 3: فحص عمود plan_id في tenants =====
echo "<h2>3️⃣ فحص جدول tenants (عمود plan_id)</h2>";
$tenantCols = [];
try {
    $tc = $db->query("SHOW COLUMNS FROM tenants")->results();
    foreach ($tc as $c) $tenantCols[] = $c->Field;
} catch (Exception $e) {
    echo "<div class='box'><span class='err'>❌ جدول tenants غير موجود:</span> " . htmlspecialchars($e->getMessage()) . "</div>";
}

if (in_array('plan_id', $tenantCols)) {
    echo "<div class='box'><span class='ok'>✅ عمود plan_id موجود في tenants</span></div>";
} else {
    echo "<div class='box'>";
    echo "<span class='err'>❌ عمود plan_id غير موجود في tenants!</span><br>";
    echo "<span class='warn'>⚠️ هذا هو سبب المشكلة!</span><br>";
    echo "الاستعلام الفرعي <code>(SELECT COUNT(*) FROM tenants WHERE plan_id = sp.id)</code> بيفشل لأن العمود غير موجود<br><br>";
    echo "<strong>جاري الإصلاح...</strong><br>";
    try {
        $db->query("ALTER TABLE tenants ADD COLUMN plan_id INT(11) UNSIGNED DEFAULT NULL AFTER theme_id");
        echo "<span class='ok'>✅ تم إضافة عمود plan_id بنجاح!</span>";
    } catch (Exception $e2) {
        echo "<span class='err'>فشل الإصلاح:</span> " . htmlspecialchars($e2->getMessage());
    }
    echo "</div>";
}

// ===== الخطوة 4: تجربة استعلام getAllPlans() =====
echo "<h2>4️⃣ تجربة استعلام getAllPlans() (نفس الكود في الأدمن)</h2>";

$sql = "SELECT sp.*, 
        (SELECT COUNT(*) FROM tenants WHERE plan_id = sp.id) as subscribers_count 
        FROM subscription_plans sp 
        ORDER BY sp.display_order ASC, sp.price_monthly ASC";

echo "<div class='box'>";
echo "<strong>الاستعلام:</strong>";
echo "<div class='sql'>" . $sql . "</div>";

try {
    $result = $db->query($sql);
    $plans = $result->results();
    
    if ($result->error()) {
        echo "<span class='err'>❌ الاستعلام فشل!</span> (تم تجاهل الخطأ بصمت)<br>";
        echo "<span class='warn'>المشكلة: الداتابيز يرجع خطأ بس الكود ما بيلتقطه</span>";
    } elseif ($plans === null || empty($plans)) {
        echo "<span class='warn'>⚠️ الاستعلام نجح بس لا توجد نتائج</span><br>";
        echo "عدد النتائج: " . count($plans ?? []);
    } else {
        echo "<span class='ok'>✅ الاستعلام نجح!</span> — عدد الخطط: <strong>" . count($plans) . "</strong>";
        
        echo "<table>";
        echo "<tr><th>الاسم</th><th>السعر الشهري</th><th>الخدمات</th><th>الصفحات</th><th>نشط</th><th>المشتركون</th></tr>";
        foreach ($plans as $p) {
            echo "<tr>";
            echo "<td><strong>" . htmlspecialchars($p->name ?? '') . "</strong></td>";
            echo "<td>" . number_format($p->price_monthly ?? 0, 0) . " " . htmlspecialchars($p->currency ?? '') . "</td>";
            echo "<td>" . (($p->max_services ?? -1) == -1 ? '∞' : $p->max_services) . "</td>";
            echo "<td>" . (($p->max_pages ?? -1) == -1 ? '∞' : $p->max_pages) . "</td>";
            echo "<td>" . ($p->is_active ? '✅' : '❌') . "</td>";
            echo "<td>" . ($p->subscribers_count ?? 0) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<span class='err'>❌ خطأ:</span> " . htmlspecialchars($e->getMessage());
}
echo "</div>";

// ===== الخطوة 5: تجربة الـ Model مباشرة =====
echo "<h2>5️⃣ تجربة SubscriptionPlan Model (من خلال الكود)</h2>";
echo "<div class='box'>";
try {
    $planModel = new SubscriptionPlan();
    $plansFromModel = $planModel->getAllPlans();
    
    if ($plansFromModel === null) {
        echo "<span class='err'>❌ Model أرجع null!</span> — الاستعلام فشل بصمت في Database::query()";
    } elseif (empty($plansFromModel)) {
        echo "<span class='warn'>⚠️ Model أرجع مصفوفة فاضية</span>";
    } else {
        echo "<span class='ok'>✅ Model أرجع " . count($plansFromModel) . " خطط!</span><br>";
        echo "هذا يعني صفحة الأدمن لازم تشتغل الآن!";
    }
} catch (Exception $e) {
    echo "<span class='err'>❌ خطأ في Model:</span> " . htmlspecialchars($e->getMessage());
}
echo "</div>";

// ===== الخطوة 6: فحص DEBUG_MODE =====
echo "<h2>6️⃣ إعدادات مهمة</h2>";
echo "<div class='box'>";
echo "DEBUG_MODE: <strong>" . (DEBUG_MODE ? '<span class="ok">مفعّل ✅</span>' : '<span class="err">معطّل ❌ (الأخطاء مخفية)</span>') . "</strong><br><br>";
echo "<span class='warn'>⚠️ إذا DEBUG_MODE معطّل، أخطاء الداتابيز بتنخفي وما بتظهر!</span><br>";
echo "تأكد إنه مفعّل في ملف config.php عشان تشوف الأخطاء الحقيقية";
echo "</div>";

echo "<hr>";
echo "<p style='color:red;font-weight:bold;'>⚠️ احذف هذا الملف بعد الانتهاء!</p>";
echo "<p><a href='/admin/plans' style='font-size:1.2em;'>👉 افتح صفحة الخطط عند الأدمن</a></p>";
?>
