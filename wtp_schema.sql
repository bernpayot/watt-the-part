-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 02:07 PM
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
-- Database: `wtp_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `component_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `ctype_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `component_img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`component_id`, `brand_id`, `ctype_id`, `name`, `price`, `component_img`) VALUES
(1, 1, 1, 'Intel Core i9-14900K', 590, ''),
(2, 2, 1, 'AMD Ryzen 9 7950X', 600, ''),
(3, 4, 2, 'ASUS ROG Strix Z790-E Gaming', 380, ''),
(4, 5, 2, 'MSI MPG B650 Carbon WiFi', 250, ''),
(5, 8, 3, 'Corsair Vengeance LPX 32GB (2x16GB) DDR4-3200', 90, ''),
(6, 9, 3, 'G.Skill Trident Z5 RGB 32GB (2x16GB) DDR5-6000', 130, ''),
(7, 12, 4, 'Samsung 980 PRO 1TB NVMe SSD', 110, ''),
(8, 13, 4, 'WD Black SN850X 2TB NVMe SSD', 150, ''),
(9, 3, 5, 'NVIDIA GeForce RTX 4090 Founders Edition', 1600, ''),
(10, 15, 5, 'EVGA GeForce RTX 3080 FTW3 Ultra', 800, ''),
(11, 8, 6, 'Corsair RM850x 850W 80+ Gold', 140, ''),
(12, 20, 6, 'Thermaltake Toughpower GF1 750W', 110, ''),
(13, 17, 7, 'NZXT H510 Flow Mid Tower Case', 90, ''),
(14, 21, 7, 'Fractal Design Meshify C', 100, ''),
(15, 16, 8, 'Cooler Master Hyper 212 Black Edition', 45, ''),
(16, 18, 8, 'Noctua NH-D15 Chromax.Black', 110, ''),
(17, 30, 10, 'LG UltraGear 27GN950-B 27\" 4K 144Hz', 750, ''),
(18, 29, 10, 'Acer Predator X27 27\" 4K 144Hz', 1000, '');

-- --------------------------------------------------------

--
-- Table structure for table `component_brand`
--

CREATE TABLE `component_brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `component_brand`
--

INSERT INTO `component_brand` (`brand_id`, `brand_name`) VALUES
(1, 'Intel'),
(2, 'AMD'),
(3, 'NVIDIA'),
(4, 'ASUS'),
(5, 'MSI'),
(6, 'Gigabyte'),
(7, 'ASRock'),
(8, 'Corsair'),
(9, 'G.Skill'),
(10, 'Kingston'),
(11, 'Crucial'),
(12, 'Samsung'),
(13, 'Western Digital'),
(14, 'Seagate'),
(15, 'EVGA'),
(16, 'Cooler Master'),
(17, 'NZXT'),
(18, 'Noctua'),
(19, 'be quiet!'),
(20, 'Thermaltake'),
(21, 'Fractal Design'),
(22, 'Lian Li'),
(23, 'DeepCool'),
(24, 'Razer'),
(25, 'Logitech'),
(26, 'SteelSeries'),
(27, 'HyperX'),
(28, 'Dell'),
(29, 'Acer'),
(30, 'LG'),
(31, 'BenQ');

-- --------------------------------------------------------

--
-- Table structure for table `component_type`
--

CREATE TABLE `component_type` (
  `ctype_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `component_type`
--

INSERT INTO `component_type` (`ctype_id`, `type_name`) VALUES
(1, 'CPU'),
(2, 'Motherboard'),
(3, 'RAM'),
(4, 'Storage'),
(5, 'GPU'),
(6, 'Power Supply'),
(7, 'Case'),
(8, 'CPU Cooler'),
(9, 'Case Fan'),
(10, 'Monitor'),
(11, 'Keyboard'),
(12, 'Mouse'),
(13, 'Operating System'),
(14, 'Thermal Paste'),
(15, 'Optical Drive'),
(16, 'Sound Card'),
(17, 'Network Card');

-- --------------------------------------------------------

--
-- Table structure for table `pc_build`
--

CREATE TABLE `pc_build` (
  `build_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `build_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','purchased') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pc_build_component`
--

CREATE TABLE `pc_build_component` (
  `build_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `transaction_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_item`
--

CREATE TABLE `transaction_item` (
  `ti_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `build_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `registered_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role_id`, `registered_at`) VALUES
(5, 'test12', 'test12@test.com', 'test12', 1, '2025-06-05 12:33:07'),
(6, 'bern123', 'bern123@gmail.com', '$2y$10$xRDrhcw5CXdGHLmqhNpY7eP0FE1LUsMPoKU1VhGev16Yv1vX2gtK.', 2, '2025-06-05 13:35:39'),
(7, 'testing', 'testing123@test.com', '$2y$10$Ns134QHOTTA6R7LuKVsFwen9Uo6wXXeneQTV3QMlakFO6dF0bsY8S', 2, '2025-06-05 13:57:57'),
(8, 'jonahtan_pogi', 'jonathan_pogi@test.com', '$2y$10$woel2/j9DBVr7j7nlIHG8OWSLOsdwlojDJLv9Ay7C6ob9/39EsqP2', 2, '2025-06-05 21:03:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`component_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `ctype_id` (`ctype_id`);

--
-- Indexes for table `component_brand`
--
ALTER TABLE `component_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `component_type`
--
ALTER TABLE `component_type`
  ADD PRIMARY KEY (`ctype_id`);

--
-- Indexes for table `pc_build`
--
ALTER TABLE `pc_build`
  ADD PRIMARY KEY (`build_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pc_build_component`
--
ALTER TABLE `pc_build_component`
  ADD UNIQUE KEY `build_id_2` (`build_id`),
  ADD KEY `build_id` (`build_id`,`component_id`),
  ADD KEY `component_id` (`component_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_item`
--
ALTER TABLE `transaction_item`
  ADD PRIMARY KEY (`ti_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `build_id` (`build_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `component_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `component_brand`
--
ALTER TABLE `component_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `component_type`
--
ALTER TABLE `component_type`
  MODIFY `ctype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pc_build`
--
ALTER TABLE `pc_build`
  MODIFY `build_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_item`
--
ALTER TABLE `transaction_item`
  MODIFY `ti_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `components_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `component_brand` (`brand_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `components_ibfk_2` FOREIGN KEY (`ctype_id`) REFERENCES `component_type` (`ctype_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `pc_build`
--
ALTER TABLE `pc_build`
  ADD CONSTRAINT `pc_build_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pc_build_ibfk_2` FOREIGN KEY (`build_id`) REFERENCES `pc_build_component` (`build_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pc_build_component`
--
ALTER TABLE `pc_build_component`
  ADD CONSTRAINT `pc_build_component_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `components` (`component_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction_item` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_item`
--
ALTER TABLE `transaction_item`
  ADD CONSTRAINT `transaction_item_ibfk_1` FOREIGN KEY (`ti_id`) REFERENCES `pc_build` (`build_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;