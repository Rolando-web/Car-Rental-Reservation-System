-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2025 at 01:59 PM
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
-- Database: `car-rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_model` varchar(100) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `car_type` varchar(50) NOT NULL,
  `rental_rate` decimal(10,2) NOT NULL,
  `status` enum('Available','Rented','Maintenance') NOT NULL DEFAULT 'Available',
  `car_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_model`, `plate_number`, `car_type`, `rental_rate`, `status`, `car_image`) VALUES
(4, 'Honda', 'LKT232', 'Sports Car', 2500.00, 'Available', 'uploads/cars/691dad7e92ef7_Screenshot 2025-11-19 114142.png'),
(5, 'Ferrari', 'LDHR23', 'FRI', 4500.00, 'Available', 'uploads/cars/691dada3c4aaf_Screenshot 2025-11-18 162047.png'),
(6, 'Honda', 'UYHT12', 'Sports Car', 2000.00, 'Available', 'uploads/cars/691dadbda68fb_Screenshot 2025-11-19 113858.png'),
(7, 'GTR', 'HYTO54', 'Sports Car', 6000.00, 'Available', 'uploads/cars/691dadd984221_Screenshot 2025-11-19 114119.png'),
(8, 'RTXQ', 'RXCQS5', 'Sports Car', 4000.00, 'Available', 'uploads/cars/691dadfb61360_Screenshot 2025-11-19 113841.png'),
(9, 'LAMBO', 'QWE2FS', 'Sports Car', 1000.00, 'Available', 'uploads/cars/691dae25af514_Screenshot 2025-11-19 113932.png'),
(10, 'Arduino', 'HJ123JW', 'FRI', 1000.00, 'Available', 'uploads/cars/691f245095e26_Screenshot 2025-11-20 140046.png');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `contact_number`, `email`, `password`, `role`) VALUES
(1, 'marvin', '09454564', 'user@gmail.com', '$2y$10$XA6Ef8CJTX2euU3E9vKAneQj5/pYG5sp3Oj1pG/MCWIE3J1297N1C', 'admin'),
(3, 'Test User', '09454564232', 'wew@gmail.com', '$2y$10$HlDDszCcn8aaMqfE2d1PIO0hyeYBHixMTQJNPzT.TC9iQDpLz/bR2', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `customer_id`, `is_admin`, `message`, `is_read`, `created_at`) VALUES
(11, 3, 0, 'Your reservation #15 has been approved.', 0, '2025-11-20 15:41:03'),
(12, 3, 0, 'Your reservation #16 has been approved.', 0, '2025-11-20 16:02:27'),
(13, 3, 0, 'Your reservation #17 has been approved.', 0, '2025-11-20 16:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `rental_date` date NOT NULL,
  `return_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `id`, `car_id`, `rental_date`, `return_date`, `total_amount`, `status`) VALUES
(15, 3, 6, '2025-11-20', '2025-11-22', 0.00, ''),
(16, 3, 4, '2025-11-20', '2025-11-21', 0.00, ''),
(17, 3, 6, '2025-11-21', '2025-11-22', 0.00, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
