-- Create Database
CREATE DATABASE IF NOT EXISTS `jewelry_shop_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `jewelry_shop_db`;

-- --------------------------------------------------------

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Default Admin User (Password: admin123)
INSERT INTO `users` (`username`, `password`, `full_name`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator');

-- --------------------------------------------------------

-- Table structure for table `categories`
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Sample Categories
INSERT INTO `categories` (`name`, `description`) VALUES
('Rings', 'Gold, diamond, and platinum rings'),
('Necklaces', 'Pendants, chains, and choker necklaces'),
('Earrings', 'Studs, hoops, and drop earrings'),
('Bracelets', 'Bangles, tennis bracelets, and charm bracelets');

-- --------------------------------------------------------

-- Table structure for table `products`
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `sku` VARCHAR(50) NOT NULL UNIQUE,
  `price` DECIMAL(10, 2) NOT NULL,
  `stock_quantity` INT NOT NULL DEFAULT 0,
  `min_stock_level` INT NOT NULL DEFAULT 5,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Sample Products
INSERT INTO `products` (`category_id`, `name`, `sku`, `price`, `stock_quantity`, `min_stock_level`) VALUES
(1, 'Diamond Solitaire Ring 18K', 'RNG-001', 145000.00, 8, 3),
(1, 'Classic Gold Band', 'RNG-002', 45000.00, 15, 5),
(2, 'Pearl Drop Necklace', 'NCK-001', 85000.00, 4, 2),
(2, 'Diamond Tennis Necklace', 'NCK-002', 320000.00, 2, 2),
(3, 'Sapphire Stud Earrings', 'ERN-001', 95000.00, 10, 4),
(4, 'Gold Charm Bracelet', 'BRC-001', 110000.00, 6, 3);

-- --------------------------------------------------------

-- Table structure for table `customers`
CREATE TABLE IF NOT EXISTS `customers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Sample Customers
INSERT INTO `customers` (`name`, `phone`, `email`, `address`) VALUES
('Nethmi Perera', '0771234567', 'nethmi@gmail.com', 'No 45, Galle Road, Colombo 03'),
('Kasun Silva', '0719876543', 'kasun.s@yahoo.com', 'No 12, Main Street, Kandy');

-- --------------------------------------------------------

-- Table structure for table `sales`
CREATE TABLE IF NOT EXISTS `sales` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT DEFAULT NULL,
  `user_id` INT NOT NULL,
  `total_amount` DECIMAL(10, 2) NOT NULL,
  `sale_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `sale_items`
CREATE TABLE IF NOT EXISTS `sale_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sale_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `unit_price` DECIMAL(10, 2) NOT NULL,
  `subtotal` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`sale_id`) REFERENCES `sales`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;