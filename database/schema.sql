-- Create the database (if it doesn't exist) and use it
CREATE DATABASE IF NOT EXISTS `webyault_schooldesk`;
USE `webyault_schooldesk`;

-- Roles Table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) UNIQUE NOT NULL
) ENGINE=InnoDB;

INSERT IGNORE INTO `roles` (`id`, `name`) VALUES 
(1, 'Admin'), (2, 'Teacher'), (3, 'Parent'), (4, 'Student');

-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `role_id` TINYINT UNSIGNED NOT NULL,
  `username` VARCHAR(50) UNIQUE NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`)
) ENGINE=InnoDB;

-- Insert Default Admin Account (Username: admin, Password: password123)
INSERT IGNORE INTO `users` (`role_id`, `username`, `email`, `password_hash`) VALUES 
(1, 'admin', 'admin@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
