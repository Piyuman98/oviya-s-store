-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 03:15 PM
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
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `User_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `name`, `price`, `image`, `quantity`, `User_id`, `product_id`) VALUES
(8, 'Women', '850', 'WhatsApp Image 2024-07-16 at 15.28.56_538af2d6.jpg', 1, 2, 2),
(9, 'shoe', '2000', '4.jfif', 1, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `pin_code` varchar(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `name`, `number`, `email`, `method`, `flat`, `street`, `city`, `state`, `country`, `pin_code`, `total_products`, `total_price`, `user_id`) VALUES
(3, 'Piyuman kumara', '0701121468', 'dilmanthakumara@gmail.com', 'credit card', '159/1, nugagahalanda, mandawala', 'nugagahalanda', 'dompe', 'westan', 'Sri Lanka', '11601', 'Women (1)', '850', 1),
(4, 'Piyuman kumara', '14625', 'dilmanthakumara@gmail.com', 'cash on delivery', '159/1, nugagahalanda, mandawala', 'sl', 'dompe', 'westan', 'Sri Lanka', '11601', 'shoe (1), shoe (1)', '4000', 1),
(5, 'Piyuman kumara', '14625', 'dilmanthakumara@gmail.com', 'cash on delivery', '159/1, nugagahalanda, mandawala', 'sl', 'dompe', 'westan', 'Sri Lanka', '11601', '', '0', 1),
(6, 'Piyuman kumara', '14625', 'dilmanthakumara@gmail.com', 'cash on delivery', '159/1, nugagahalanda, mandawala', 'sl', 'dompe', 'westan', 'Sri Lanka', '11601', '', '0', 1),
(7, 'Piyuman kumara', '0701121468', 'dilmanthakumara@gmail.com', 'cash on delivery', '159/1, nugagahalanda, mandawala', 'nugagahalanda', 'dompe', 'westan', 'Sri Lanka', '11601', 'shoe (1)', '2000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category`) VALUES
(2, 'Women', '850', 'WhatsApp Image 2024-07-16 at 15.28.56_538af2d6.jpg', ''),
(3, 'shoe', '2000', '4.jfif', ''),
(4, 'shoe', '2000', '4.jfif', 'newIn'),
(5, 'shoe', '2000', '2.jpg', 'sale'),
(6, 'Women', '1200', 'p1.jpg', 'sale');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Piyuman kumara', 'dilmanthakumara@gmail.com', '$2y$10$/lxG0r2q7iSA9tQ8WDwfKOGcSlIyt8OFHeMTACev.WTUx4Xx21cEa', '2024-07-21 19:10:56'),
(2, 'as', 'as@gmial.com', '$2y$10$.iqROn0o3QCLifeB9ypsMepnrGs7iT8Zmwl0AFWhGkPf8AztfJMeO', '2024-08-03 19:00:16'),
(3, 'Piyuman', 'dilmanthakumar@gmail.com', '$2y$10$R1dy6zh2Cd7Q25EMG2072O3zLQXiTzMZ47GdI2G.7xYYPpQEDTqoC', '2024-08-04 09:14:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
