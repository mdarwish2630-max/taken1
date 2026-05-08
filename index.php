<?php
/**
 * CMS Platform - Entry Point
 * نقطة الدخول الرئيسية
 */

// تحميل الإعدادات
require_once __DIR__ . '/app/config/config.php';

// تحميل النماذج (Models)
$models = glob(ROOT_PATH . '/app/models/*.php');
foreach ($models as $model) {
    require_once $model;
}

// تحميل المتحكمات
$controllers = glob(ROOT_PATH . '/app/controllers/*.php');
foreach ($controllers as $controller) {
    require_once $controller;
}

// تحميل المسارات
require_once ROOT_PATH . '/app/routes.php';

// تنفيذ التوجيه
Router::dispatch();
