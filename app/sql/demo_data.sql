-- إنشاء جدول لتتبع استيراد البيانات التجريبية
CREATE TABLE IF NOT EXISTS `demo_imports` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tenant_id` INT NOT NULL,
    `imported_at` DATETIME NOT NULL,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_tenant` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
