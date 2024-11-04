-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 04:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pho_order`
--
CREATE DATABASE IF NOT EXISTS `pho_order` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pho_order`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(250) NOT NULL,
  `admin_email` text NOT NULL,
  `admin_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'admin', 'admin@admin.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_cost` decimal(15,0) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'on_hold',
  `paypal_order_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `shipping_method` varchar(255) DEFAULT 'standard',
  `shipping_cost` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(15,0) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(250) NOT NULL,
  `payment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(15,0) NOT NULL,
  `product_weight` decimal(5,2) NOT NULL,
  `product_special_offer` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_description`, `product_image`, `product_price`, `product_weight`, `product_special_offer`) VALUES
(1, 'Phở Tái', 'phở', 'Phở Tái - Tinh hoa ẩm thực Việt Nam, hòa quyện giữa sợi phở mềm dai, nước dùng thanh ngọt được ninh từ xương bò, và những lát thịt bò tái mỏng, mềm tan trong miệng. Thêm chút hành lá, ngò rí, cùng vài giọt chanh tươi và tương ớt cay nồng, món ăn trở thành', 'phobo.png', 30000, 300.00, 0),
(2, 'Phở Gà', 'phở', 'Phở Gà - Tinh hoa ẩm thực Việt Nam, hòa quyện giữa sợi phở mềm dai, nước dùng thanh ngọt được ninh từ xương bò, và những lát thịt gà tái mỏng, mềm tan trong miệng. Thêm chút hành lá, ngò rí, cùng vài giọt chanh tươi và tương ớt cay nồng, món ăn trở thàn', 'phoga.png', 30000, 0.00, 0),
(3, 'Phở Xào Lăn', 'phở', 'Phở Xào Lăn- Tinh hoa ẩm thực Việt Nam, hòa quyện giữa sợi phở mềm dai, nước dùng thanh ngọt được ninh từ xương bò, và những lát thịt bò tái mỏng, mềm tan trong miệng. Thêm chút hành lá, ngò rí, cùng vài giọt chanh tươi và tương ớt cay nồng, món ăn trở th', 'phoxaolan.png', 30000, 0.00, 0),
(4, 'Phở Tái Nạm', 'phở', 'Phở Tái Nạm- Tinh hoa ẩm thực Việt Nam, hòa quyện giữa sợi phở mềm dai, nước dùng thanh ngọt được ninh từ xương bò, và những lát thịt bò tái mỏng, mềm tan trong miệng. Thêm chút hành lá, ngò rí, cùng vài giọt chanh tươi và tương ớt cay nồng, món ăn trở th', 'phobonam.png', 30000, 0.00, 0),
(5, 'Phở Bò Hầm', 'phở', 'Phở Bò Hầm - Tinh hoa ẩm thực Việt Nam, hòa quyện giữa sợi phở mềm dai, nước dùng thanh ngọt được ninh từ xương bò, và những lát thịt bò tái mỏng, mềm tan trong miệng. Thêm chút hành lá, ngò rí, cùng vài giọt chanh tươi và tương ớt cay nồng, món ăn trở th', 'phoboham.png', 30000, 0.00, 0),
(6, 'Phở Bò Viên', 'Phở', 'Phở Bò Viên - Tinh hoa ẩm thực Việt Nam, hòa quyện giữa sợi phở mềm dai, nước dùng thanh ngọt được ninh từ xương bò, và những lát thịt bò tái mỏng, mềm tan trong miệng. Thêm chút hành lá, ngò rí, cùng vài giọt chanh tươi và tương ớt cay nồng, món ăn trở t', 'phobovien.png', 30000, 0.00, 0),
(7, 'Phở Sate', 'Phở', 'Phở Sate - Tinh hoa ẩm thực Việt Nam, hòa quyện giữa sợi phở mềm dai, nước dùng thanh ngọt được ninh từ xương bò, và những lát thịt bò tái mỏng, mềm tan trong miệng. Thêm chút hành lá, ngò rí, cùng vài giọt chanh tươi và tương ớt cay nồng, món ăn trở thàn', 'phosate.png', 30000, 0.00, 0),
(8, 'Phở Cuốn', 'Thức ăn kèm', 'Phở Cuốn - Thức ăn kèm hoặc ăn chính mới được quan ra mắt', 'phocuon.png', 10000, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `email_verification_code` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UX_Constraint` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
