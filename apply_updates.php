<?php
/**
 * Quick Apply Script - تسريع التثبيت
 * 
 * شغّل: php apply_updates.php
 * هذا السكربت ينسخ كل الملفات تلقائياً إلى مواقعها الصحيحة
 */

$projectRoot = __DIR__;
$updatesDir = $projectRoot . '/updates';

echo "=== TakweenWeb Update Installer ===\n\n";

// 1. Copy SectionsConfig Model
$src = "$updatesDir/app/models/SectionsConfig.php";
$dst = "$projectRoot/app/models/SectionsConfig.php";
if (file_exists($src)) {
    copy($src, $dst);
    echo "[OK] SectionsConfig.php -> app/models/\n";
} else {
    echo "[SKIP] SectionsConfig.php not found\n";
}

// 2. Copy Sections Dashboard View
$src = "$updatesDir/app/views/dashboard/sections.php";
$dst = "$projectRoot/app/views/dashboard/sections.php";
if (file_exists($src)) {
    copy($src, $dst);
    echo "[OK] sections.php -> app/views/dashboard/\n";
} else {
    echo "[SKIP] sections.php not found\n";
}

// 3. Copy Enhanced Service Form
$src = "$updatesDir/app/views/dashboard/service-form.php";
$dst = "$projectRoot/app/views/dashboard/service-form.php";
if (file_exists($src)) {
    copy($src, $dst);
    echo "[OK] service-form.php -> app/views/dashboard/\n";
} else {
    echo "[SKIP] service-form.php not found\n";
}

// 4. Copy Service Detail Page to ALL themes
$themes = ['cleaning', 'maintenance', 'medical', 'restaurant', 'realestate', 'decor', 'electric', 'fitness', 'general', 'legal', 'plumbing'];
foreach ($themes as $theme) {
    $src = "$updatesDir/themes/$theme/service.php";
    $dst = "$projectRoot/themes/$theme/service.php";
    if (file_exists($src)) {
        @mkdir("$projectRoot/themes/$theme", 0755, true);
        copy($src, $dst);
        echo "[OK] service.php -> themes/$theme/\n";
    }
}

echo "\n=== Files Copied Successfully ===\n";
echo "\nNext Steps:\n";
echo "1. Import SQL: updates/sql/sections_config.sql in phpMyAdmin\n";
echo "2. Add routes from: updates/routes_additions.php\n";
echo "3. Add controller methods from: updates/app/controllers/DashboardController_sections_additions.php\n";
echo "4. Add sidebar link in dashboard layout\n";
echo "\nSee updates/INSTALL.txt for detailed instructions.\n";
