-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2025 at 02:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffe_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` enum('pending','processing','completed') DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `total_price`) VALUES
(1, 2, '2025-05-22 08:08:24', 'pending', 25000.00),
(2, 2, '2025-05-22 08:09:31', 'pending', 25000.00),
(3, 2, '2025-05-22 08:14:29', 'pending', 25000.00),
(4, 2, '2025-05-22 08:16:56', 'pending', 25000.00),
(5, 2, '2025-05-22 08:17:08', 'pending', 25000.00),
(6, 2, '2025-05-22 08:20:19', 'pending', 30000.00),
(7, 2, '2025-05-22 10:23:37', 'pending', 90000.00),
(8, 2, '2025-05-22 10:38:49', 'pending', 450000.00),
(9, 2, '2025-05-25 23:31:10', 'pending', 30000.00),
(10, 2, '2025-05-25 23:59:27', 'pending', 25000.00),
(11, 2, '2025-05-26 09:32:26', 'pending', 140000.00),
(12, 2, '2025-05-26 14:06:47', 'pending', 25000.00),
(13, 2, '2025-05-27 16:14:51', 'pending', 28000.00),
(14, 3, '2025-05-27 16:23:24', 'pending', 25000.00),
(15, 4, '2025-05-28 11:50:28', 'pending', 30000.00),
(16, 2, '2025-06-02 10:33:11', 'pending', 25000.00),
(17, 2, '2025-06-02 10:49:56', 'pending', 28000.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(10, 10, 18, 1, 25000.00),
(15, 15, 2, 1, 30000.00),
(16, 16, 1, 1, 25000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category` enum('Coffee','Non-Coffee','Food','Dessert') NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category`, `image`, `created_at`) VALUES
(1, 'Espresso', 'Strong black coffee', 25000.00, 40, 'Coffee', 'espresso.jpg', '2025-05-21 00:27:32'),
(2, 'Latte', 'Espresso with steamed milk', 30000.00, 43, 'Coffee', 'latte.jpg', '2025-05-21 00:27:32'),
(3, 'Cappuccino', 'Espresso with foamed milk', 32000.00, 40, 'Coffee', 'cappuccino.jpg', '2025-05-21 00:27:32'),
(4, 'Americano', 'Espresso with hot water', 28000.00, 53, 'Coffee', 'americano.jpg', '2025-05-21 00:27:32'),
(5, 'Mocha', 'Chocolate-flavored latte', 35000.00, 31, 'Coffee', 'mocha.jpg', '2025-05-21 00:27:32'),
(6, 'Matcha Latte', 'Green tea with milk', 33000.00, 40, 'Non-Coffee', 'matcha.jpg', '2025-05-21 00:27:32'),
(7, 'Chocolate', 'Hot chocolate drink', 28000.00, 50, 'Non-Coffee', 'chocolate.jpg', '2025-05-21 00:27:32'),
(8, 'Red Velvet', 'Creamy red velvet drink', 35000.00, 30, 'Non-Coffee', 'redvelvet.jpg', '2025-05-21 00:27:32'),
(9, 'Thai Tea', 'Authentic Thai tea', 30000.00, 45, 'Non-Coffee', 'thaitea.jpg', '2025-05-21 00:27:32'),
(10, 'Lemon Tea', 'Refreshing lemon tea', 25000.00, 60, 'Non-Coffee', 'lemontea.jpg', '2025-05-21 00:27:32'),
(11, 'Croissant', 'Buttery French pastry', 28000.00, 30, 'Food', 'croissant.jpg', '2025-05-21 00:27:32'),
(12, 'Sandwich', 'Chicken sandwich', 35000.00, 25, 'Food', 'sandwich.jpg', '2025-05-21 00:27:32'),
(14, 'Muffin', 'Blueberry muffin', 20000.00, 40, 'Food', 'muffin.jpg', '2025-05-21 00:27:32'),
(15, 'Toast', 'Avocado toast', 30000.00, 19, 'Food', 'toast.jpg', '2025-05-21 00:27:32'),
(16, 'Cheesecake', 'New York cheesecake', 40000.00, 20, 'Dessert', 'cheesecake.jpg', '2025-05-21 00:27:32'),
(17, 'Tiramisu', 'Classic Italian dessert', 45000.00, 15, 'Dessert', 'tiramisu.jpg', '2025-05-21 00:27:32'),
(18, 'Brownie', 'Chocolate brownie', 25000.00, 29, 'Dessert', 'brownie.jpg', '2025-05-21 00:27:32'),
(19, 'Pancake', 'Stack of fluffy pancakes', 38000.00, 25, 'Dessert', 'pancake.jpg', '2025-05-21 00:27:32'),
(29, 'Salad', 'healthy food', 25000.00, 20, 'Coffee', '68381fd2b5bfc.jpg', '2025-05-29 08:50:26'),
(30, 'Sushi', 'Japanese Sushi', 45000.00, 30, 'Coffee', '683820316771f.jpg', '2025-05-29 08:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$ZrLTKzjS/X9kwRDYREGiJeL8wQnALMCGik.Tp5iqdccBwfSF/9JQa', 'admin', '2025-05-20 19:21:26'),
(2, 'user1', '$2y$10$FH41WhgKEFUoLMX8sT1lR.DUb2y8x4vXM.gk.LEnaiB6pH07uejyC', 'user', '2025-05-20 19:21:26'),
(3, 'Chris', '$2y$10$QW/ktoryK5xkPIMrL3DOxuon/UkTmvwqrekOQBxeQIehragIA6VZC', 'user', '2025-05-27 08:23:06'),
(4, 'KevinK', '$2y$10$tvehSM2VBY.2IjdcJtLaNOvk9I3ma5ZiV.TmJp5/lDvfgj9fn3tLq', 'user', '2025-05-28 03:47:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
