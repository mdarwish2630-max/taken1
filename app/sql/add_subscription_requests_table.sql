-- ============================================================
-- جدول طلبات الاشتراك - subscription_requests
-- يُستخدم لحفظ طلبات الترقية والاشتراك الجديد
-- حتى يقوم الأدمن بالمراجعة والقبول/الرفض
-- ============================================================

CREATE TABLE IF NOT EXISTS `subscription_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `request_type` enum('new','upgrade','renew') NOT NULL DEFAULT 'new' COMMENT 'نوع الطلب: جديد، ترقية، تجديد',
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending' COMMENT 'حالة الطلب',
  `notes` text DEFAULT NULL COMMENT 'ملاحظات المستخدم',
  `admin_notes` text DEFAULT NULL COMMENT 'ملاحظات الأدمن',
  `reviewed_by` int(11) DEFAULT NULL COMMENT 'الذي راجع الطلب',
  `reviewed_at` datetime DEFAULT NULL COMMENT 'تاريخ المراجعة',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tenant_status` (`tenant_id`, `status`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول طلبات الاشتراك والترقية';
