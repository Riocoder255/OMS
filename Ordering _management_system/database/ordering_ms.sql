-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 12:03 PM
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
-- Database: `ordering_ms`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `Branch_name` varchar(55) NOT NULL,
  `map_image` varchar(255) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `Branch_name`, `map_image`, `created_date`) VALUES
(3, 'Koronadal', 'map.jfif', '2024-11-26'),
(4, 'Gensan', 'gensan.jfif', '2024-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `size_id`, `color_id`, `quantity`, `created_at`) VALUES
(23, 4, 80, 3, 4, 3, '2024-07-07 10:42:31'),
(24, 4, 81, 4, 1, 3, '2024-07-07 10:46:01'),
(30, 4, 82, 3, 2, 3, '2024-07-07 12:06:48'),
(41, 3, 105, 1, 5, 2, '2024-07-13 13:26:39'),
(43, 2, 104, 2, 0, 0, '2024-11-21 01:31:13'),
(44, 2, 103, 4, 0, 3, '2024-11-21 01:32:21'),
(45, 2, 101, 2, 0, 0, '2024-11-21 05:59:38'),
(46, 23, 109, 0, 0, 0, '2024-11-25 23:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `age_type` varchar(255) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `age_type`, `created`) VALUES
(2, 'Adult', '2024-07-06'),
(3, 'Kids', '2024-07-06');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `color_name` varchar(50) DEFAULT NULL,
  `color_code` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color_name`, `color_code`) VALUES
(1, 'selver', '#dddd'),
(2, 'Black', '#ffff'),
(3, 'red', '#f45778'),
(4, 'blue', '#rrgg'),
(5, 'white', '#F5F7F8'),
(6, 'green', '#059212'),
(7, 'brown', '#6B8A7A'),
(8, 'magente', '#430A5D');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `otp` varchar(6) DEFAULT NULL,
  `is_verified` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`user_id`, `name`, `lname`, `email`, `password`, `created`, `otp`, `is_verified`) VALUES
(23, 'Oscar', 'BACK', 'romelbialaromeltbiala@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-11-22', '618599', '0'),
(24, 'Lian', 'sioting', 'siotingclyvelian@gmail.com', '99da6083fbe32d03e44c8ffe1ade2b67', '2024-11-22', '972176', '0');

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`id`, `firstname`, `email`, `phone`, `branch_id`) VALUES
(71, 'Cat Bee', 'catbee@123', '191991', 1),
(72, 'Cat Bee', 'catbee@123', '191991', 2),
(73, 'Cat Bee', 'catbee@123', '191991', 1),
(74, 'Cat Bee', 'catbee@123', '191991', 1),
(75, 'Cat Bee', 'catbee@123', '191991', 1),
(76, 'Cat Bee', 'catbee@123', '191991', 2),
(77, 'Cat Bee', 'catbee@123', '191991', 1),
(78, 'rooom', 'catbee@123', '191991', 1),
(79, 'rooom', 'catbee@123', '191991', 1),
(80, 'rooom', 'catbee@123', '191991', 1),
(81, 'Cat Bee', 'catbee@123', '191991', 2),
(82, 'created _at', 'mel@gmail.com', '09300303', 1),
(83, 'created _at', 'mel@gmail.com', '09300303', 2),
(84, 'romel biala', 'rio@gmail.com', '09100', 1),
(85, 'exceriel mae ragunton', 'ragunton12@gmail.com', '191991', 1),
(86, 'anime max', 'max1@gmail.com', '09099090', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL DEFAULT current_timestamp(),
  `end_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_orders`
--

CREATE TABLE `item_orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_orders`
--

INSERT INTO `item_orders` (`id`, `order_id`, `product_id`, `quantity`, `date`, `customer_id`) VALUES
(144, 63, 76, 4, '2024-07-07', 0),
(145, 64, 80, 3, '2024-07-07', 0),
(146, 64, 81, 3, '2024-07-07', 0),
(147, 64, 76, 4, '2024-07-07', 0),
(148, 65, 77, 2, '2024-07-07', 0),
(149, 65, 78, 2, '2024-07-07', 0),
(150, 66, 80, 3, '2024-07-07', 0),
(151, 66, 81, 3, '2024-07-07', 0),
(152, 67, 80, 10, '2024-07-07', 0),
(153, 67, 81, 3, '2024-07-07', 0),
(154, 67, 82, 3, '2024-07-07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `down_payment` decimal(10,2) NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `balance` decimal(10,2) GENERATED ALWAYS AS (`total_amount` - `down_payment`) STORED,
  `payment_status` varchar(50) DEFAULT 'Incomplete',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total_amount`, `down_payment`, `order_status`, `date`, `customer_id`, `payment_id`, `pickup_date`, `payment_status`, `user_id`) VALUES
(63, 2000.00, 0.00, 'Pending', '2024-07-07', 82, 2, NULL, 'not fully paid', 4),
(64, 1350.00, 500.00, 'Pending', '2024-07-07', 83, 2, NULL, 'not fully paid', 4),
(65, 600.00, 600.00, 'Pending', '2024-07-07', 84, 2, '2024-07-01', 'complete', 3),
(67, 6370.00, 0.00, 'Pending', '2024-07-07', 86, 2, NULL, 'not fully paid', 4);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `payment_name` varchar(255) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `payment_name`, `created`) VALUES
(1, 'online', '2024-06-16'),
(2, 'over_the_counter', '2024-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE `pricing` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `freebie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`product_id`, `product_name`, `category_id`, `size_id`, `cover`, `created`) VALUES
(109, 'GU,MMM', 2, 1, 'durr.jfif', '2024-11-21'),
(110, 'Dota2', 2, 0, 'dota2.jfif', '2024-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `color_id` int(11) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`id`, `product_id`, `size_id`, `created`, `color_id`, `images`) VALUES
(187, 95, 2, '2024-07-08 20:24:55', 1, '1720441495-dt3.jpg'),
(188, 95, 2, '2024-07-08 20:24:55', 1, '1720441495-dt2.jpg'),
(189, 95, 2, '2024-07-08 20:24:55', 2, '1720441495-dt3.jpg'),
(190, 95, 2, '2024-07-08 20:24:55', 2, '1720441495-dt2.jpg'),
(191, 95, 3, '2024-07-08 20:24:55', 1, '1720441495-dt3.jpg'),
(192, 95, 3, '2024-07-08 20:24:55', 1, '1720441495-dt2.jpg'),
(193, 95, 3, '2024-07-08 20:24:55', 2, '1720441495-dt3.jpg'),
(194, 95, 3, '2024-07-08 20:24:55', 2, '1720441495-dt2.jpg'),
(195, 96, 2, '2024-07-08 20:26:22', 1, '1720441582-mobile3.jpg'),
(196, 96, 2, '2024-07-08 20:26:22', 1, '1720441582-mobile2.jpg'),
(197, 96, 2, '2024-07-08 20:26:22', 1, '1720441582-mobile.jpg'),
(198, 96, 2, '2024-07-08 20:26:22', 2, '1720441582-mobile3.jpg'),
(199, 96, 2, '2024-07-08 20:26:22', 2, '1720441582-mobile2.jpg'),
(200, 96, 2, '2024-07-08 20:26:22', 2, '1720441582-mobile.jpg'),
(201, 96, 2, '2024-07-08 20:26:22', 3, '1720441582-mobile3.jpg'),
(202, 96, 2, '2024-07-08 20:26:22', 3, '1720441582-mobile2.jpg'),
(203, 96, 2, '2024-07-08 20:26:22', 3, '1720441582-mobile.jpg'),
(204, 96, 3, '2024-07-08 20:26:22', 1, '1720441582-mobile3.jpg'),
(205, 96, 3, '2024-07-08 20:26:22', 1, '1720441582-mobile2.jpg'),
(206, 96, 3, '2024-07-08 20:26:22', 1, '1720441582-mobile.jpg'),
(207, 96, 3, '2024-07-08 20:26:22', 2, '1720441582-mobile3.jpg'),
(208, 96, 3, '2024-07-08 20:26:22', 2, '1720441582-mobile2.jpg'),
(209, 96, 3, '2024-07-08 20:26:22', 2, '1720441582-mobile.jpg'),
(210, 96, 3, '2024-07-08 20:26:22', 3, '1720441582-mobile3.jpg'),
(211, 96, 3, '2024-07-08 20:26:22', 3, '1720441582-mobile2.jpg'),
(212, 96, 3, '2024-07-08 20:26:22', 3, '1720441582-mobile.jpg'),
(213, 97, 1, '2024-07-08 20:32:32', 4, '1720441952-mobile3.jpg'),
(214, 97, 1, '2024-07-08 20:32:32', 4, '1720441952-mobile2.jpg'),
(215, 97, 1, '2024-07-08 20:32:32', 4, '1720441952-mobile.jpg'),
(216, 97, 1, '2024-07-08 20:32:32', 6, '1720441952-mobile3.jpg'),
(217, 97, 1, '2024-07-08 20:32:32', 6, '1720441952-mobile2.jpg'),
(218, 97, 1, '2024-07-08 20:32:32', 6, '1720441952-mobile.jpg'),
(219, 97, 2, '2024-07-08 20:32:32', 4, '1720441952-mobile3.jpg'),
(220, 97, 2, '2024-07-08 20:32:32', 4, '1720441952-mobile2.jpg'),
(221, 97, 2, '2024-07-08 20:32:32', 4, '1720441952-mobile.jpg'),
(222, 97, 2, '2024-07-08 20:32:32', 6, '1720441952-mobile3.jpg'),
(223, 97, 2, '2024-07-08 20:32:32', 6, '1720441952-mobile2.jpg'),
(224, 97, 2, '2024-07-08 20:32:32', 6, '1720441952-mobile.jpg'),
(225, 97, 3, '2024-07-08 20:32:32', 4, '1720441952-mobile3.jpg'),
(226, 97, 3, '2024-07-08 20:32:32', 4, '1720441952-mobile2.jpg'),
(227, 97, 3, '2024-07-08 20:32:32', 4, '1720441952-mobile.jpg'),
(228, 97, 3, '2024-07-08 20:32:32', 6, '1720441952-mobile3.jpg'),
(229, 97, 3, '2024-07-08 20:32:32', 6, '1720441952-mobile2.jpg'),
(230, 97, 3, '2024-07-08 20:32:32', 6, '1720441952-mobile.jpg'),
(231, 98, 1, '2024-07-08 20:34:28', 4, '1720442068-mobile3.jpg'),
(232, 98, 1, '2024-07-08 20:34:28', 4, '1720442068-mobile2.jpg'),
(233, 98, 1, '2024-07-08 20:34:28', 6, '1720442068-mobile3.jpg'),
(234, 98, 1, '2024-07-08 20:34:28', 6, '1720442068-mobile2.jpg'),
(235, 98, 3, '2024-07-08 20:34:28', 4, '1720442068-mobile3.jpg'),
(236, 98, 3, '2024-07-08 20:34:28', 4, '1720442068-mobile2.jpg'),
(237, 98, 3, '2024-07-08 20:34:28', 6, '1720442068-mobile3.jpg'),
(238, 98, 3, '2024-07-08 20:34:28', 6, '1720442068-mobile2.jpg'),
(239, 98, 4, '2024-07-08 20:34:28', 4, '1720442068-mobile3.jpg'),
(240, 98, 4, '2024-07-08 20:34:28', 4, '1720442068-mobile2.jpg'),
(241, 98, 4, '2024-07-08 20:34:28', 6, '1720442068-mobile3.jpg'),
(242, 98, 4, '2024-07-08 20:34:28', 6, '1720442068-mobile2.jpg'),
(243, 99, 1, '2024-07-08 20:38:50', 3, '1720442330-dt3.jpg'),
(244, 99, 1, '2024-07-08 20:38:50', 3, '1720442330-dt2.jpg'),
(245, 99, 1, '2024-07-08 20:38:50', 5, '1720442330-dt3.jpg'),
(246, 99, 1, '2024-07-08 20:38:50', 5, '1720442330-dt2.jpg'),
(247, 99, 2, '2024-07-08 20:38:50', 3, '1720442330-dt3.jpg'),
(248, 99, 2, '2024-07-08 20:38:50', 3, '1720442330-dt2.jpg'),
(249, 99, 2, '2024-07-08 20:38:50', 5, '1720442330-dt3.jpg'),
(250, 99, 2, '2024-07-08 20:38:50', 5, '1720442330-dt2.jpg'),
(251, 100, 1, '2024-07-08 20:41:32', 2, '1720442492-hunter2.jpg'),
(252, 100, 1, '2024-07-08 20:41:32', 2, '1720442492-im1.jpg'),
(253, 100, 1, '2024-07-08 20:41:32', 2, '1720442492-im2.jpg'),
(254, 100, 1, '2024-07-08 20:41:32', 2, '1720442492-im3.jpg'),
(255, 100, 1, '2024-07-08 20:41:32', 5, '1720442492-hunter2.jpg'),
(256, 100, 1, '2024-07-08 20:41:32', 5, '1720442492-im1.jpg'),
(257, 100, 1, '2024-07-08 20:41:32', 5, '1720442492-im2.jpg'),
(258, 100, 1, '2024-07-08 20:41:32', 5, '1720442492-im3.jpg'),
(259, 101, 1, '2024-07-08 20:44:28', 3, '1720442668-dt2.jpg'),
(260, 101, 1, '2024-07-08 20:44:28', 3, '1720442668-dt3.jpg'),
(261, 101, 1, '2024-07-08 20:44:28', 5, '1720442668-dt2.jpg'),
(262, 101, 1, '2024-07-08 20:44:28', 5, '1720442668-dt3.jpg'),
(263, 101, 2, '2024-07-08 20:44:28', 3, '1720442668-dt2.jpg'),
(264, 101, 2, '2024-07-08 20:44:28', 3, '1720442668-dt3.jpg'),
(265, 101, 2, '2024-07-08 20:44:28', 5, '1720442668-dt2.jpg'),
(266, 101, 2, '2024-07-08 20:44:28', 5, '1720442668-dt3.jpg'),
(267, 102, 1, '2024-07-08 20:48:06', 4, '1720442886-mobile3.jpg'),
(268, 102, 1, '2024-07-08 20:48:06', 4, '1720442886-mobile2.jpg'),
(269, 102, 1, '2024-07-08 20:48:06', 4, '1720442886-mobile.jpg'),
(270, 102, 1, '2024-07-08 20:48:06', 6, '1720442886-mobile3.jpg'),
(271, 102, 1, '2024-07-08 20:48:06', 6, '1720442886-mobile2.jpg'),
(272, 102, 1, '2024-07-08 20:48:06', 6, '1720442886-mobile.jpg'),
(273, 102, 3, '2024-07-08 20:48:06', 4, '1720442886-mobile3.jpg'),
(274, 102, 3, '2024-07-08 20:48:06', 4, '1720442886-mobile2.jpg'),
(275, 102, 3, '2024-07-08 20:48:06', 4, '1720442886-mobile.jpg'),
(276, 102, 3, '2024-07-08 20:48:06', 6, '1720442886-mobile3.jpg'),
(277, 102, 3, '2024-07-08 20:48:06', 6, '1720442886-mobile2.jpg'),
(278, 102, 3, '2024-07-08 20:48:06', 6, '1720442886-mobile.jpg'),
(279, 103, 1, '2024-07-08 20:49:52', 2, '1720442992-f4.jpg'),
(280, 103, 1, '2024-07-08 20:49:52', 2, '1720442992-f3.jpg'),
(281, 103, 1, '2024-07-08 20:49:52', 2, '1720442992-f2.jpg'),
(282, 103, 1, '2024-07-08 20:49:52', 2, '1720442992-fubo.jpg'),
(283, 103, 1, '2024-07-08 20:49:52', 4, '1720442992-f4.jpg'),
(284, 103, 1, '2024-07-08 20:49:52', 4, '1720442992-f3.jpg'),
(285, 103, 1, '2024-07-08 20:49:52', 4, '1720442992-f2.jpg'),
(286, 103, 1, '2024-07-08 20:49:52', 4, '1720442992-fubo.jpg'),
(287, 103, 2, '2024-07-08 20:49:52', 2, '1720442992-f4.jpg'),
(288, 103, 2, '2024-07-08 20:49:52', 2, '1720442992-f3.jpg'),
(289, 103, 2, '2024-07-08 20:49:52', 2, '1720442992-f2.jpg'),
(290, 103, 2, '2024-07-08 20:49:52', 2, '1720442992-fubo.jpg'),
(291, 103, 2, '2024-07-08 20:49:52', 4, '1720442992-f4.jpg'),
(292, 103, 2, '2024-07-08 20:49:52', 4, '1720442992-f3.jpg'),
(293, 103, 2, '2024-07-08 20:49:52', 4, '1720442992-f2.jpg'),
(294, 103, 2, '2024-07-08 20:49:52', 4, '1720442992-fubo.jpg'),
(295, 103, 4, '2024-07-08 20:49:52', 2, '1720442992-f4.jpg'),
(296, 103, 4, '2024-07-08 20:49:52', 2, '1720442992-f3.jpg'),
(297, 103, 4, '2024-07-08 20:49:52', 2, '1720442992-f2.jpg'),
(298, 103, 4, '2024-07-08 20:49:52', 2, '1720442992-fubo.jpg'),
(299, 103, 4, '2024-07-08 20:49:52', 4, '1720442992-f4.jpg'),
(300, 103, 4, '2024-07-08 20:49:52', 4, '1720442992-f3.jpg'),
(301, 103, 4, '2024-07-08 20:49:52', 4, '1720442992-f2.jpg'),
(302, 103, 4, '2024-07-08 20:49:52', 4, '1720442992-fubo.jpg'),
(303, 104, 1, '2024-07-08 20:50:59', 2, '1720443059-hunter2.jpg'),
(304, 104, 1, '2024-07-08 20:50:59', 2, '1720443059-hunter.jpg'),
(305, 104, 1, '2024-07-08 20:50:59', 5, '1720443059-hunter2.jpg'),
(306, 104, 1, '2024-07-08 20:50:59', 5, '1720443059-hunter.jpg'),
(307, 104, 2, '2024-07-08 20:50:59', 2, '1720443059-hunter2.jpg'),
(308, 104, 2, '2024-07-08 20:50:59', 2, '1720443059-hunter.jpg'),
(309, 104, 2, '2024-07-08 20:50:59', 5, '1720443059-hunter2.jpg'),
(310, 104, 2, '2024-07-08 20:50:59', 5, '1720443059-hunter.jpg'),
(311, 105, 1, '2024-07-08 20:52:52', 2, '1720443172-imrr.jpg'),
(312, 105, 1, '2024-07-08 20:52:52', 2, '1720443172-im3.jpg'),
(313, 105, 1, '2024-07-08 20:52:52', 2, '1720443172-im2.jpg'),
(314, 105, 1, '2024-07-08 20:52:52', 2, '1720443172-im1.jpg'),
(315, 105, 1, '2024-07-08 20:52:52', 5, '1720443172-imrr.jpg'),
(316, 105, 1, '2024-07-08 20:52:52', 5, '1720443172-im3.jpg'),
(317, 105, 1, '2024-07-08 20:52:52', 5, '1720443172-im2.jpg'),
(318, 105, 1, '2024-07-08 20:52:52', 5, '1720443172-im1.jpg'),
(319, 105, 3, '2024-07-08 20:52:52', 2, '1720443172-imrr.jpg'),
(320, 105, 3, '2024-07-08 20:52:52', 2, '1720443172-im3.jpg'),
(321, 105, 3, '2024-07-08 20:52:52', 2, '1720443172-im2.jpg'),
(322, 105, 3, '2024-07-08 20:52:52', 2, '1720443172-im1.jpg'),
(323, 105, 3, '2024-07-08 20:52:52', 5, '1720443172-imrr.jpg'),
(324, 105, 3, '2024-07-08 20:52:52', 5, '1720443172-im3.jpg'),
(325, 105, 3, '2024-07-08 20:52:52', 5, '1720443172-im2.jpg'),
(326, 105, 3, '2024-07-08 20:52:52', 5, '1720443172-im1.jpg'),
(327, 105, 4, '2024-07-08 20:52:52', 2, '1720443172-imrr.jpg'),
(328, 105, 4, '2024-07-08 20:52:52', 2, '1720443172-im3.jpg'),
(329, 105, 4, '2024-07-08 20:52:52', 2, '1720443172-im2.jpg'),
(330, 105, 4, '2024-07-08 20:52:52', 2, '1720443172-im1.jpg'),
(331, 105, 4, '2024-07-08 20:52:52', 5, '1720443172-imrr.jpg'),
(332, 105, 4, '2024-07-08 20:52:52', 5, '1720443172-im3.jpg'),
(333, 105, 4, '2024-07-08 20:52:52', 5, '1720443172-im2.jpg'),
(334, 105, 4, '2024-07-08 20:52:52', 5, '1720443172-im1.jpg'),
(335, 106, 1, '2024-07-08 20:54:13', 5, '1720443253-lo2.jpg'),
(336, 106, 1, '2024-07-08 20:54:13', 5, '1720443253-log.jpg'),
(337, 106, 1, '2024-07-08 20:54:13', 7, '1720443253-lo2.jpg'),
(338, 106, 1, '2024-07-08 20:54:13', 7, '1720443253-log.jpg'),
(339, 106, 2, '2024-07-08 20:54:13', 5, '1720443253-lo2.jpg'),
(340, 106, 2, '2024-07-08 20:54:13', 5, '1720443253-log.jpg'),
(341, 106, 2, '2024-07-08 20:54:13', 7, '1720443253-lo2.jpg'),
(342, 106, 2, '2024-07-08 20:54:13', 7, '1720443253-log.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sizing`
--

CREATE TABLE `sizing` (
  `id` int(11) NOT NULL,
  `Size` varchar(255) NOT NULL,
  `matric` varchar(255) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizing`
--

INSERT INTO `sizing` (`id`, `Size`, `matric`, `created`) VALUES
(1, 'xl', '20', '2024-06-16'),
(2, 'small', '12', '2024-06-16'),
(3, 'x-small', '21-20', '2024-06-16'),
(4, 'xxl', '30', '2024-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `cat_name`, `created`) VALUES
(1, 'JERSEY', '2024-06-16'),
(2, 'TSHIRT -ONLY', '2024-06-16'),
(3, 'Pants', '2024-06-16'),
(4, 'T-shirt Print', '2024-07-06');

-- --------------------------------------------------------

--
-- Table structure for table `upload_reciep`
--

CREATE TABLE `upload_reciep` (
  `id` int(11) NOT NULL,
  `uplaod` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upload_reciep`
--

INSERT INTO `upload_reciep` (`id`, `uplaod`, `order_id`) VALUES
(11, 'gcahs.jpg', 0),
(12, 'jersey-kids.jpg', 0),
(13, '13.jpg', 0),
(14, 'gcahs.jpg', 0),
(15, 'gcahs.jpg', 0),
(16, 'romel.png', 0),
(17, 'gcahs.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `verification_code` text NOT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles_as` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_ban` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'active=0,deactive=1;',
  `created` date NOT NULL DEFAULT current_timestamp(),
  `otp` varchar(255) DEFAULT NULL,
  `expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `fname`, `lname`, `phone`, `branch_id`, `email`, `password`, `roles_as`, `image`, `is_ban`, `created`, `otp`, `expiry`) VALUES
(5, 'tyou', 'koiii', '+09993993', 3, 'romelbialaromeltbiala@gmail.com', '$2y$10$JEfnXSyFimW6v.AslxNvXOQXjoZlmEgxesJsEvcRP8q8jNu7.CZZ6', 'admin', 'ptogilr.png', 0, '2024-11-21', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_orders`
--
ALTER TABLE `item_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `orders_ibfk_1` (`customer_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricing`
--
ALTER TABLE `pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizing`
--
ALTER TABLE `sizing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_reciep`
--
ALTER TABLE `upload_reciep`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `item_orders`
--
ALTER TABLE `item_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pricing`
--
ALTER TABLE `pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `sizing`
--
ALTER TABLE `sizing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `upload_reciep`
--
ALTER TABLE `upload_reciep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payment_method` (`id`);

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payment_history_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payment_method` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
