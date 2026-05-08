<?php
/**
 * Routes Additions for Sections Management
 * إضافة المسارات الخاصة بالأقسام
 * 
 * HOW TO APPLY:
 * Add these routes to your routes configuration file (routes/web.php or index.php routes section)
 * 
 * Add AFTER existing dashboard routes:
 */

// ===== Sections Management Routes =====

// صفحة إدارة الأقسام
$routes['dashboard/sections'] = [
    'controller' => 'Dashboard',
    'method' => 'sections',
    'middleware' => 'auth'
];

// حفظ إعدادات الأقسام
$routes['dashboard/sections/save'] = [
    'controller' => 'Dashboard',
    'method' => 'saveSections',
    'middleware' => 'auth',
    'post' => true
];

// تفعيل/تعطيل قسم (AJAX)
$routes['dashboard/sections/toggle'] = [
    'controller' => 'Dashboard',
    'method' => 'toggleSection',
    'middleware' => 'auth',
    'post' => true
];

/*
 * NOTE: If your routes are defined differently, add these entries in the same pattern.
 * The key is: 
 *   GET  /dashboard/sections     -> DashboardController::sections()
 *   POST /dashboard/sections/save -> DashboardController::saveSections()
 *   POST /dashboard/sections/toggle -> DashboardController::toggleSection()
 */
