-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for gym_management
CREATE DATABASE IF NOT EXISTS `gym_management` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `gym_management`;

-- Dumping structure for table gym_management.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.cart: ~0 rows (approximately)

-- Dumping structure for table gym_management.membership
CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `starting_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `membership_plan_id` varchar(50) NOT NULL DEFAULT '',
  `membership_code` varchar(50) NOT NULL,
  `membership_status` tinyint(4) NOT NULL COMMENT '0: newly 1: renewal ',
  `payment_status` tinyint(4) NOT NULL COMMENT '0: unpaid, 1:validation, 2: paid',
  `is_expired_flg` tinyint(4) NOT NULL COMMENT '0: ongoing 1:expired',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.membership: ~1 rows (approximately)
REPLACE INTO `membership` (`id`, `user_id`, `starting_date`, `expiration_date`, `membership_plan_id`, `membership_code`, `membership_status`, `payment_status`, `is_expired_flg`, `created`, `updated`) VALUES
	(17, 3, NULL, NULL, 'MBR_PLN_C62947', 'MBRSHP_501183', 0, 0, 0, '2024-12-06 23:05:03', '2024-12-06 23:05:03');

-- Dumping structure for table gym_management.membership_plan
CREATE TABLE IF NOT EXISTS `membership_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` varchar(50) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `entry_days` varchar(50) NOT NULL DEFAULT '',
  `entry_time` varchar(50) NOT NULL,
  `days_duration` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL COMMENT '0: unoffered, 1: offered',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.membership_plan: ~1 rows (approximately)
REPLACE INTO `membership_plan` (`id`, `plan_id`, `title`, `description`, `entry_days`, `entry_time`, `days_duration`, `price`, `status`, `created`) VALUES
	(1, 'MBR_PLN_C62947', 'ATZ Membership Plan', 'Join our membership plan today!', 'MON~FRI', '08:00~17:00', 31, 699, 1, '2024-12-06 20:56:30');

-- Dumping structure for table gym_management.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `order_code` varchar(50) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL COMMENT '1: checkout, 2: For Pickup, 3: Completed, 4: Cancelled',
  `payment_status` tinyint(4) DEFAULT NULL COMMENT '0: unpaid, 1:validation, 2: paid',
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.orders: ~8 rows (approximately)
REPLACE INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `price`, `order_code`, `order_status`, `payment_status`, `created`, `updated`) VALUES
	(11, 3, 1, 1, 1499, 'PRDCT_ORD_4092514', 3, 2, '2024-12-06 22:09:54', '2024-12-06 22:09:54'),
	(12, 3, 1, 1, 1499, 'PRDCT_ORD_7203996', 3, 2, '2024-12-06 22:16:24', '2024-12-06 22:16:24'),
	(13, 3, 1, 1, 1499, 'PRDCT_ORD_0000635', 3, 2, '2024-12-06 22:16:26', '2024-12-06 22:16:26'),
	(14, 3, 1, 1, 1499, 'PRDCT_ORD_0000510', 3, 2, '2024-12-06 22:17:38', '2024-12-06 22:17:38'),
	(15, 3, 1, 1, 1499, 'PRDCT_ORD_0495975', 3, 2, '2024-12-06 22:17:43', '2024-12-06 22:17:43'),
	(16, 3, 1, 1, 1499, 'PRDCT_ORD_0005729', 3, 2, '2024-12-06 22:18:02', '2024-12-06 22:18:02'),
	(17, 3, 1, 1, 1499, 'PRDCT_ORD_3540674', 1, 0, '2024-12-06 23:05:21', '2024-12-06 23:05:21'),
	(18, 3, 1, 1, 1499, 'PRDCT_ORD_2002229', 1, 1, '2024-12-06 23:05:36', '2024-12-06 23:05:36');

-- Dumping structure for table gym_management.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.products: ~1 rows (approximately)
REPLACE INTO `products` (`id`, `category_id`, `product_code`, `title`, `description`, `quantity`, `price`, `status`, `created`, `updated`) VALUES
	(1, 5, '37BS1206', 'Home Gym Multifunctional Full', 'The same frame as JXL/SCM-1150, remove the weight cover, new can add weight plates hanging bar. Although the self-contained weight is reduced to 80LB, the weight stack has more room to move and the weight ceiling can reach 270LBS.', 296, 1499, 1, '2024-12-06 20:59:45', '2024-12-06 20:59:45');

-- Dumping structure for table gym_management.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.product_category: ~6 rows (approximately)
REPLACE INTO `product_category` (`id`, `name`, `created`) VALUES
	(1, 'Fitness Accessories', '2024-10-23 20:59:34'),
	(2, 'Yoga and Pilates Equipment', '2024-10-23 21:02:27'),
	(3, 'Athletic Apparel', '2024-10-23 21:02:38'),
	(4, 'Nutrition and Supplements', '2024-10-23 21:02:45'),
	(5, 'Training Equipment', '2024-10-23 21:03:29'),
	(6, 'Essentials', '2024-11-13 20:22:48');

-- Dumping structure for table gym_management.tmp_uploads
CREATE TABLE IF NOT EXISTS `tmp_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resources_id` int(11) DEFAULT NULL,
  `resources` enum('profile','product','receipt') DEFAULT NULL,
  `filename` varchar(150) DEFAULT NULL,
  `org_name` varchar(150) DEFAULT NULL,
  `org_type` varchar(150) DEFAULT NULL,
  `org_size` varchar(150) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.tmp_uploads: ~4 rows (approximately)
REPLACE INTO `tmp_uploads` (`id`, `resources_id`, `resources`, `filename`, `org_name`, `org_type`, `org_size`, `created`, `updated`) VALUES
	(1, 1, 'product', '6752f54125c54_ph-11134207-7r98t-luiwuttu5yvu7d.jpg', 'ph-11134207-7r98t-luiwuttu5yvu7d.jpg', 'image/jpeg', '26582', '2024-12-06 20:59:45', '2024-12-06 20:59:45'),
	(2, 3, 'profile', '6752f61876b8b_images.jpg', 'images.jpg', 'image/jpeg', '8247', '2024-12-06 21:03:20', '2024-12-06 21:03:20'),
	(3, 1, 'receipt', '6752f63f693ee_GCASH_RECEIPT_.jpg', 'GCASH_RECEIPT_.jpg', 'image/jpeg', '21991', '2024-12-06 21:03:59', '2024-12-06 21:03:59'),
	(4, 400, 'receipt', '675305b29ea17_GCASH_RECEIPT_.jpg', 'GCASH_RECEIPT_.jpg', 'image/jpeg', '21991', '2024-12-06 22:09:54', '2024-12-06 22:09:54');

-- Dumping structure for table gym_management.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(4) NOT NULL DEFAULT 0,
  `transaction_code` varchar(50) DEFAULT NULL,
  `order_code` varchar(50) DEFAULT NULL,
  `order_type` varchar(50) DEFAULT NULL COMMENT 'membership, products',
  `payment_type` tinyint(4) DEFAULT NULL COMMENT '0: pay at counter 1:gcash',
  `payment_status` tinyint(4) DEFAULT NULL COMMENT '0: unpaid, 1:validation, 2: paid',
  `receipt_img` text DEFAULT NULL,
  `reference_no` text DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `amount_received` double DEFAULT NULL,
  `gcash_no` varchar(11) DEFAULT NULL,
  `received_by` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.transactions: ~9 rows (approximately)
REPLACE INTO `transactions` (`id`, `user_id`, `transaction_code`, `order_code`, `order_type`, `payment_type`, `payment_status`, `receipt_img`, `reference_no`, `amount`, `amount_received`, `gcash_no`, `received_by`, `created`, `updated`) VALUES
	(12, 3, 'TRNSCTN_11F0055', 'PRDCT_ORD_4092514', 'product', 1, 2, '675305b29ea17_GCASH_RECEIPT_.jpg', '', 1499, 1499, '09873123456', '1', '2024-12-06 22:09:54', '2024-12-06 22:09:54'),
	(13, 3, 'TRNSCTN_70F0395', 'PRDCT_ORD_7203996', 'product', 0, 2, '', '', 1499, 1499, '', '1', '2024-12-06 22:16:24', '2024-12-06 22:16:24'),
	(14, 3, 'TRNSCTN_3B30811', 'PRDCT_ORD_0000635', 'product', 0, 2, '', '', 1499, 1499, '', '1', '2024-12-06 22:16:26', '2024-12-06 22:16:26'),
	(15, 3, 'TRNSCTN_93B0879', 'PRDCT_ORD_0000510', 'product', 0, 2, '', '', 1499, 1499, '', '1', '2024-12-06 22:17:38', '2024-12-06 22:17:38'),
	(16, 3, 'TRNSCTN_BBE0773', 'PRDCT_ORD_0495975', 'product', 0, 2, '', '', 1499, 1499, '', '1', '2024-12-06 22:17:43', '2024-12-06 22:17:43'),
	(17, 3, 'TRNSCTN_58D0044', 'PRDCT_ORD_0005729', 'product', 1, 2, '', '213213213213', 1499, 1499, '3123213', '1', '2024-12-06 22:18:02', '2024-12-06 22:18:02'),
	(30, 3, 'TRNSCTN_DAB0897', '17', 'membership', 0, 0, '', '', 699, NULL, '', NULL, '2024-12-06 23:05:03', '2024-12-06 23:05:03'),
	(31, 3, 'TRNSCTN_A970945', 'PRDCT_ORD_3540674', 'product', 0, 0, '', '', 1499, NULL, '', NULL, '2024-12-06 23:05:21', '2024-12-06 23:05:21'),
	(32, 3, 'TRNSCTN_AF20897', 'PRDCT_ORD_2002229', 'product', 1, 1, '', '3213213', 1499, NULL, '21321321321', NULL, '2024-12-06 23:05:36', '2024-12-06 23:05:36');

-- Dumping structure for table gym_management.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` tinytext DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `last_active` datetime NOT NULL,
  `is_online_flg` tinyint(4) NOT NULL DEFAULT 0,
  `is_verify_flg` tinyint(4) NOT NULL DEFAULT 0,
  `is_membership_flg` tinyint(4) NOT NULL DEFAULT 0,
  `is_profile_flg` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL COMMENT '0: inactive 1:active',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.users: ~7 rows (approximately)
REPLACE INTO `users` (`id`, `type_id`, `fname`, `lname`, `gender`, `bday`, `address`, `contact`, `email`, `password`, `last_active`, `is_online_flg`, `is_verify_flg`, `is_membership_flg`, `is_profile_flg`, `status`, `created`, `updated`) VALUES
	(1, 1, 'ATZ', 'Admin', NULL, NULL, NULL, NULL, 'atz_admin@gmail.com', '$2y$10$b0.WAAhHqjf9y37Raq.yZ./jQSxHkpH7mMeJ64zWQpugX77.vr0Wy', '2024-12-06 20:24:38', 1, 1, 0, 0, 1, '2024-11-26 20:39:42', '2024-11-26 20:39:42'),
	(2, 2, 'Stephen', 'Curry', 'male', '1993-01-01', 'Ibabao, Cordova, Cebu 6017', '09876532145', 'stephen_curry@gmail.com', '$2y$10$dbOepApj3OKUjtTU3cB5le8I9YDYSok.DdxATyktZRTKOD.IbEpBq', '2024-11-26 22:12:07', 0, 1, 1, 1, 1, '2024-11-26 20:40:48', '2024-11-26 20:40:48'),
	(3, 2, 'Lebron', 'James', 'male', '1989-06-12', 'Gabi, Cordova, Cebu 6017', '09831736762', 'lebron_james@gmail.com', '$2y$10$SgXoWjRmwDrEDeZFCWQmz.UjD8EvloqEBpismly2KD2tgpB26OVCO', '2024-12-06 20:25:18', 1, 1, 1, 1, 1, '2024-11-26 20:41:07', '2024-11-26 20:41:07'),
	(4, 2, 'Kevin', 'Durant', NULL, NULL, NULL, NULL, 'kevin_durant@gmail.com', '$2y$10$8NOe51LLDZyJJR.kRv1QEuRhxRoEtSuVKFMxaEJlm2uv/M8OS5Wke', '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2024-11-26 20:41:24', '2024-11-26 20:41:24'),
	(5, 2, 'Juan', 'Gomez', NULL, NULL, NULL, NULL, 'juan_gomez@gmail.com', '$2y$10$rA7PIaztSy5HR.DbLBYtQex9LNhbyxOTPZaphynKetvMDZCjzP6M.', '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2024-11-26 20:43:53', '2024-11-26 20:43:53'),
	(6, 2, 'Marga', 'Zamora', NULL, NULL, NULL, NULL, 'marga@gmail.com', '$2y$10$DLTxk.srnY5CwaWmIFGEqulZvTvV/DHbuVzFf0Mmx9S1X9wlWouy.', '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2024-11-26 20:44:19', '2024-11-26 20:44:19'),
	(7, 2, 'Christine Mae', 'Palanao', NULL, NULL, NULL, NULL, 'christine@gmail.com', '$2y$10$iaIP2JsgxrPWEqX1wMlFIePD3FEU76Rctdu8pC.kQd859qQ/7h54K', '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2024-11-26 20:44:37', '2024-11-26 20:44:37');

-- Dumping structure for table gym_management.user_type
CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table gym_management.user_type: ~2 rows (approximately)
REPLACE INTO `user_type` (`id`, `type`) VALUES
	(1, 'admin'),
	(2, 'member');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
