-- Create domain_history table if not exists
CREATE TABLE IF NOT EXISTS `domain_history` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tenant_id` INT NOT NULL,
    `domain_type` VARCHAR(50) DEFAULT 'custom',
    `old_value` VARCHAR(255) DEFAULT NULL,
    `new_value` VARCHAR(255) DEFAULT NULL,
    `status` VARCHAR(50) DEFAULT 'added',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
