<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = __DIR__;
$log = [];

// اذا الضغط على الزر
if (isset($_POST['go'])) {

    // ========== 1. Security.php ==========
    $sec = $baseDir . '/app/core/Security.php';
    if (file_exists($sec)) {
        $c = file_get_contents($sec);
        $old = $c;
        // تغيير كل trim($var) إلى trim((string)($var ?? ''))
        $c = preg_replace('/trim\s*\(\s*\$(\w+)\s*\)/', 'trim((string)($$1 ?? \'\'))', $c);
        if ($c !== $old) {
            file_put_contents($sec, $c);
            $log[] = 'OK: Security.php تم إصلاح';
        } else {
            $log[] = 'SKIP: Security.php مصلح مسبقا';
        }
    } else {
        $log[] = 'ERR: Security.php غير موجود في ' . $sec;
    }

    // ========== 2. AdminController.php ==========
    $ctrl = $baseDir . '/app/controllers/AdminController.php';
    if (!file_exists($ctrl)) {
        $log[] = 'ERR: AdminController.php غير موجود في ' . $ctrl;
    } else {
        $orig = file_get_contents($ctrl);

        // === البحث عن storePlan ===
        if (strpos($orig, 'public function storePlan') === false) {
            $log[] = 'ERR: لم أجد دالة storePlan في AdminController';
        } else {
            // أوجد بداية ونهاية storePlan
            $storeStart = strpos($orig, 'public function storePlan');
            // أرجع لسطر السابق
            while ($storeStart > 0 && $orig[$storeStart - 1] !== "\n") $storeStart--;
            
            // أوجد أول { بعد البداية
            $bracePos = strpos($orig, '{', $storeStart);
            $depth = 0;
            $storeEnd = -1;
            for ($i = $bracePos; $i < strlen($orig); $i++) {
                if ($orig[$i] === '{') $depth++;
                if ($orig[$i] === '}') {
                    $depth--;
                    if ($depth === 0) { $storeEnd = $i; break; }
                }
            }

            if ($storeEnd === -1) {
                $log[] = 'ERR: لم أجد نهاية storePlan';
            } else {
                // الدالة الجديدة
                $newStore = '
    public function storePlan()
    {
        $this->verifyCsrf();

        $data = [
            \'name\'             => $this->input(\'name\'),
            \'slug\'             => $this->input(\'slug\') ?: $this->generatePlanSlug($this->input(\'name\')),
            \'description\'      => $this->input(\'description\'),
            \'price_monthly\'    => (float) $this->input(\'price\', 0),
            \'price_yearly\'     => null,
            \'currency\'         => $this->input(\'currency\', \'SAR\'),
            \'max_pages\'        => (int) $this->input(\'max_pages\', -1),
            \'max_services\'     => (int) $this->input(\'max_services\', -1),
            \'max_gallery\'      => (int) $this->input(\'max_gallery_images\', -1),
            \'max_banners\'      => (int) $this->input(\'max_banners\', -1),
            \'custom_domain\'    => $this->input(\'has_custom_domain\') ? 1 : 0,
            \'remove_branding\'  => 0,
            \'analytics_access\' => $this->input(\'has_analytics\') ? 1 : 0,
            \'priority_support\' => 0,
            \'is_active\'        => $this->input(\'is_active\') ? 1 : 0,
            \'is_popular\'       => $this->input(\'is_popular\') ? 1 : 0,
            \'display_order\'    => (int) $this->input(\'sort_order\', 0),
        ];

        $extra = [];
        if ($this->input(\'has_ssl\'))           $extra[] = \'ssl\';
        if ($this->input(\'has_custom_colors\')) $extra[] = \'custom_colors\';
        if ($this->input(\'has_gallery\'))       $extra[] = \'gallery\';
        if ($this->input(\'has_testimonials\'))  $extra[] = \'testimonials\';
        if ($this->input(\'has_banners\'))       $extra[] = \'banners\';
        if ($this->input(\'has_blog\'))          $extra[] = \'blog\';
        if ($this->input(\'has_forms\'))         $extra[] = \'forms\';
        if ($this->input(\'has_seo\'))           $extra[] = \'seo\';
        if ($this->input(\'is_free\'))           $extra[] = \'free\';
        $data[\'features\'] = !empty($extra) ? json_encode($extra, JSON_UNESCAPED_UNICODE) : null;

        $filtered = array_filter($data, fn($v) => $v !== null);

        $planModel = $this->model(\'SubscriptionPlan\');
        try {
            if (method_exists($planModel, \'createPlan\')) {
                $result = $planModel->createPlan($filtered);
            } else {
                $db = Database::getInstance();
                $cols = implode(\', \', array_keys($filtered));
                $vals = implode(\', \', array_fill(0, count($filtered), \'?\'));
                $db->query("INSERT INTO subscription_plans ({$cols}) VALUES ({$vals})", array_values($filtered));
                $result = true;
            }
            if ($result) {
                Session::success(lang(\'plan_created\') ?? \'تم إنشاء الخطة بنجاح\');
                $this->redirect(\'/admin/plans\');
            } else {
                Session::error(lang(\'plan_error\') ?? \'حدث خطأ أثناء إنشاء الخطة\');
                $this->redirect(\'/admin/plans/add\');
            }
        } catch (\Exception $e) {
            Session::error(\'خطأ: \' . $e->getMessage());
            $this->redirect(\'/admin/plans/add\');
        }
    }
';

                $orig = substr($orig, 0, $storeStart) . $newStore . substr($orig, $storeEnd + 1);
                $log[] = 'OK: storePlan() تم استبدال';
            }
        }

        // === البحث عن updatePlan ===
        if (strpos($orig, 'public function updatePlan') === false) {
            $log[] = 'ERR: لم أجد دالة updatePlan في AdminController';
        } else {
            $updateStart = strpos($orig, 'public function updatePlan');
            while ($updateStart > 0 && $orig[$updateStart - 1] !== "\n") $updateStart--;
            $bracePos = strpos($orig, '{', $updateStart);
            $depth = 0;
            $updateEnd = -1;
            for ($i = $bracePos; $i < strlen($orig); $i++) {
                if ($orig[$i] === '{') $depth++;
                if ($orig[$i] === '}') {
                    $depth--;
                    if ($depth === 0) { $updateEnd = $i; break; }
                }
            }

            if ($updateEnd === -1) {
                $log[] = 'ERR: لم أجد نهاية updatePlan';
            } else {
                $newUpdate = '
    public function updatePlan($id)
    {
        $this->verifyCsrf();

        $data = [
            \'name\'             => $this->input(\'name\'),
            \'slug\'             => $this->input(\'slug\'),
            \'description\'      => $this->input(\'description\'),
            \'price_monthly\'    => (float) $this->input(\'price\', 0),
            \'price_yearly\'     => null,
            \'currency\'         => $this->input(\'currency\', \'SAR\'),
            \'max_pages\'        => (int) $this->input(\'max_pages\', -1),
            \'max_services\'     => (int) $this->input(\'max_services\', -1),
            \'max_gallery\'      => (int) $this->input(\'max_gallery_images\', -1),
            \'max_banners\'      => (int) $this->input(\'max_banners\', -1),
            \'custom_domain\'    => $this->input(\'has_custom_domain\') ? 1 : 0,
            \'remove_branding\'  => 0,
            \'analytics_access\' => $this->input(\'has_analytics\') ? 1 : 0,
            \'priority_support\' => 0,
            \'is_active\'        => $this->input(\'is_active\') ? 1 : 0,
            \'is_popular\'       => $this->input(\'is_popular\') ? 1 : 0,
            \'display_order\'    => (int) $this->input(\'sort_order\', 0),
        ];

        $extra = [];
        if ($this->input(\'has_ssl\'))           $extra[] = \'ssl\';
        if ($this->input(\'has_custom_colors\')) $extra[] = \'custom_colors\';
        if ($this->input(\'has_gallery\'))       $extra[] = \'gallery\';
        if ($this->input(\'has_testimonials\'))  $extra[] = \'testimonials\';
        if ($this->input(\'has_banners\'))       $extra[] = \'banners\';
        if ($this->input(\'has_blog\'))          $extra[] = \'blog\';
        if ($this->input(\'has_forms\'))         $extra[] = \'forms\';
        if ($this->input(\'has_seo\'))           $extra[] = \'seo\';
        if ($this->input(\'is_free\'))           $extra[] = \'free\';
        $data[\'features\'] = !empty($extra) ? json_encode($extra, JSON_UNESCAPED_UNICODE) : null;

        $filtered = array_filter($data, fn($v) => $v !== null);

        $planModel = $this->model(\'SubscriptionPlan\');
        try {
            if (method_exists($planModel, \'updatePlan\')) {
                $result = $planModel->updatePlan($id, $filtered);
            } else {
                $db = Database::getInstance();
                $set = []; $vals = [];
                foreach ($filtered as $k => $v) { $set[] = "{$k} = ?"; $vals[] = $v; }
                $vals[] = $id;
                $db->query("UPDATE subscription_plans SET " . implode(\', \', $set) . " WHERE id = ?", $vals);
                $result = true;
            }
            if ($result) {
                Session::success(lang(\'plan_updated\') ?? \'تم تحديث الخطة بنجاح\');
            } else {
                Session::error(lang(\'plan_error\') ?? \'حدث خطأ أثناء تحديث الخطة\');
            }
        } catch (\Exception $e) {
            Session::error(\'خطأ: \' . $e->getMessage());
        }
        $this->redirect(\'/admin/plans\');
    }
';

                $orig = substr($orig, 0, $updateStart) . $newUpdate . substr($orig, $updateEnd + 1);
                $log[] = 'OK: updatePlan() تم استبدال';
            }
        }

        // === إصلاح approveSubscriptionRequest - sp.price ===
        $orig = str_replace('sp.price as plan_price', 'sp.price_monthly as plan_price', $orig);
        $log[] = 'OK: approveSubscriptionRequest - sp.price_monthly';

        file_put_contents($ctrl, $orig);
        $log[] = 'OK: AdminController.php تم حفظ';
    }

    // ========== 3. admin/plans.php ==========
    $plansView = $baseDir . '/app/views/admin/plans.php';
    if (!file_exists($plansView)) {
        $log[] = 'ERR: admin/plans.php غير موجود';
    } else {
        // استبدال الأعمدة الخاطئة بالصحيحة
        $pv = file_get_contents($plansView);

        // الجدول الأساسي - استبدال الأعمدة
        $pv = str_replace('$plan->price,', '$plan->price_monthly ?? 0,', $pv);
        $pv = str_replace('$plan->duration_days', '$plan->display_order ?? 0', $pv);
        $pv = str_replace('$plan->trial_days', '$plan->priority_support ?? 0', $pv);
        $pv = str_replace('$plan->has_custom_domain', '$plan->custom_domain', $pv);
        $pv = str_replace('$plan->has_ssl', '$plan->remove_branding', $pv);
        $pv = str_replace('$plan->has_analytics', '$plan->analytics_access', $pv);
        $pv = str_replace('$plan->has_blog', '$plan->max_pages ?? -1', $pv);
        $pv = str_replace('$plan->has_forms', '$plan->max_gallery ?? -1', $pv);
        $pv = str_replace('$plan->storage_limit_mb', '$plan->max_banners ?? -1', $pv);
        $pv = str_replace('$plan->subscribers_count', '$plan->display_order', $pv);
        $pv = str_replace('!($plan->subscribers_count > 0)', 'true', $pv);

        // جدول المقارنة
        $pv = str_replace('$plan->has_custom_domain', '$plan->custom_domain', $pv);
        $pv = str_replace('$plan->max_services == -1', '($plan->max_services ?? -1) == -1', $pv);
        $pv = str_replace('$plan->max_services ?? 0', '$plan->max_services ?? 0', $pv);
        $pv = str_replace('$plan->storage_limit_mb ?? 0', '$plan->max_banners ?? 0', $pv);

        file_put_contents($plansView, $pv);
        $log[] = 'OK: admin/plans.php تم إصلاح الأعمدة';
    }
}
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
<meta charset="UTF-8">
<title>إصلاح</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Tahoma;background:#f0f0f0;padding:30px}
.box{max-width:550px;margin:20px auto;background:#fff;border-radius:10px;padding:25px;box-shadow:0 2px 8px rgba(0,0,0,.1)}
h2{text-align:center;margin-bottom:8px;color:#333}
p{text-align:center;color:#777;margin-bottom:18px;font-size:14px}
.log{margin:15px 0;font-family:monospace;font-size:13px}
.log div{padding:8px 12px;margin:4px 0;border-radius:6px}
.ok{background:#dcfce7;color:#166534;border:1px solid #86efac}
.err{background:#fee2e2;color:#991b1b;border:1px solid #fca5a5}
.skip{background:#f3f4f6;color:#4b5563;border:1px solid #d1d5db}
input[type=submit]{display:block;margin:0 auto;padding:12px 50px;font-size:16px;background:#4f46e5;color:#fff;border:none;border-radius:8px;cursor:pointer}
input[type=submit]:hover{background:#4338ca}
.warn{text-align:center;margin-top:15px;font-size:12px;color:#92400e;background:#fef3c7;padding:8px;border-radius:6px}
</style>
</head>
<body>
<div class="box">
    <h2>🔧 إصلاح نظام الخطط</h2>
    <p>يصلح AdminController + Security.php + صفحة عرض الخطط</p>

    <?php if (empty($log)): ?>
    <form method="POST">
        <input type="submit" name="go" value="تطبيق الإصلاح">
    </form>
    <?php else: ?>
    <div class="log">
    <?php foreach($log as $l): ?>
        <?php 
        if (strpos($l, 'OK:') === 0) $cls = 'ok';
        elseif (strpos($l, 'ERR:') === 0) $cls = 'err';
        else $cls = 'skip';
        ?>
        <div class="<?= $cls ?>"><?= htmlspecialchars($l) ?></div>
    <?php endforeach; ?>
    </div>
    <div class="warn">⚠️ احذف الملف fix_plans.php الآن</div>
    <?php endif; ?>
</div>
</body>
</html>
