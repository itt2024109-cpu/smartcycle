-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2026 at 01:56 PM
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
-- Database: `smartcycle`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `title`, `category`, `price`, `description`, `image`, `created_at`) VALUES
(3, 1, 'Hp Use Laptop', 'computers', 80000.00, 'Selling my HP laptop. [Mention any details here, e.g., \"The laptop powers on and works well for daily tasks, office work, and browsing. Comes with the original charger. Battery holds a charge well.\" OR \"Selling as e-waste / for spare parts because the motherboard/screen is damaged.\"]', '1789120294_8a805eec3782708f0f52f24d3a3295f3.jpg', '2026-09-11 09:51:34'),
(4, 1, 'HP Pavilion 15 Used -Laptop - For Parts', 'computers', 12000.00, 'HP Pavilion laptop. The motherboard is faulty and it won\'t turn on, but the screen, keyboard, 8GB RAM, and 500GB HDD are in good condition. Ideal for spare parts or repair. Original charger included.', '1789120518_7331e6cd3ebfede25cb5acaee0ca3d65.jpg', '2026-09-11 09:55:18'),
(5, 1, 'Samsung Galaxy A50 - Broken Display', 'mobiles', 6500.00, 'Phone turns on and receives calls, but the LCD/touch display is completely cracked and needs replacement. Body is neat. Battery and motherboard are fully functional. Selling as e-waste/repairable.', '1789120620_46322ef69332b2da170aee7ff675f232.jpg', '2026-09-11 09:57:00'),
(6, 1, 'Intel Core i3 3rd Gen Processor with Motherboard', 'computers', 4000.00, 'Removed from a working desktop setup during an upgrade. Includes an Intel Core i3 (3rd Generation) processor attached to an LGA1155 motherboard. Working condition, tested before removal.', '1789120781_1f82d91ec0b1a265b6ff59417a0c28b5.jpg', '2026-09-11 09:59:41'),
(7, 1, 'Old Automatic Rice Cooker - For Parts / Repair', 'appliances', 1500.00, 'A used electric rice cooker. The heating element works, but the thermal fuse or automatic switch has issues. Suitable for spare parts, repair, or scrap recycling.', '1789120955_cd9d05d336b1a9b2d40e355bb320541e.jpg', '2026-09-11 10:02:35'),
(8, 1, 'Defective Microwave Oven (Samsung)', 'appliances', 3500.00, 'Samsung microwave oven that currently does not heat up or turn on properly (likely a transformer or fuse fault). Outer body and glass plate are intact. Good for electronics repair technicians or e-waste recycling.', '1789121072_4f3e105a11ee55f808ce0af7544cb73f.jpg', '2026-09-11 10:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_method` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'P.R. S.A.Udayanthi', 'itt2024109@tec.rjt.ac.lk', '$2y$10$55KdCE/O.u8Hr5PJl0Ciw.leC95W0cJcw3u7AVkt0eYAMAkQJwwWi', '2026-09-11 06:14:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
