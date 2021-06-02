-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2021 at 02:34 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digital_name`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `login_token` varchar(200) DEFAULT NULL,
  `registered_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`, `login_token`, `registered_at`) VALUES
(1, 'admin', 'admin@email.com', 'password', '94858398998', '97a9b3027a3d427bd2c26339624dabe85099c8d37b09ca89646194fb42b7f42042cf7effda04161e41e5dd2d10713a20a391581581f95a3cca41358718bcd48a5e419bb79cdd', '2021-04-14 14:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE `affiliates` (
  `id` int(15) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `clicks` int(15) NOT NULL DEFAULT 0,
  `signups` int(15) NOT NULL DEFAULT 0,
  `link` varchar(250) DEFAULT NULL,
  `affiliate_string` varchar(10) DEFAULT NULL,
  `domain` varchar(250) DEFAULT NULL,
  `sale_percentage` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_comers`
--

CREATE TABLE `affiliate_comers` (
  `id` int(15) NOT NULL,
  `mac_id` varchar(30) DEFAULT NULL,
  `affiliate_id` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_name_portions`
--

CREATE TABLE `affiliate_name_portions` (
  `id` int(15) NOT NULL,
  `name_id` int(15) NOT NULL,
  `customer_id` int(15) NOT NULL,
  `affiliate_id` int(15) NOT NULL,
  `affiliate_portion_price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `current_percentage` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `login_token` varchar(200) DEFAULT NULL,
  `cc` varchar(20) DEFAULT NULL,
  `api_key` varchar(50) DEFAULT NULL,
  `registered_at` datetime NOT NULL,
  `affiliate_id` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_packages`
--

CREATE TABLE `customer_packages` (
  `id` int(15) NOT NULL,
  `name` varchar(200) NOT NULL,
  `package_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `customer_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `names`
--

CREATE TABLE `names` (
  `id` int(15) NOT NULL,
  `name` varchar(200) NOT NULL,
  `name_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `customer_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `warning_credit` decimal(10,2) NOT NULL,
  `name_price` decimal(10,2) NOT NULL,
  `paypal_client_id` varchar(250) DEFAULT NULL,
  `out_of_credits_message` text DEFAULT NULL,
  `api_key` varchar(250) DEFAULT NULL,
  `api_url` varchar(250) DEFAULT NULL,
  `affiliate_program_type` varchar(50) DEFAULT NULL,
  `everflow_code` varchar(100) DEFAULT NULL,
  `sale_percentage` decimal(10,2) NOT NULL DEFAULT 0.00,
  `company_name` varchar(200) DEFAULT NULL,
  `everflow_js_sdk_code` text DEFAULT NULL,
  `brand_id_conversion_code` text DEFAULT NULL,
  `unknown_click` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `warning_credit`, `name_price`, `paypal_client_id`, `out_of_credits_message`, `api_key`, `api_url`, `affiliate_program_type`, `everflow_code`, `sale_percentage`, `company_name`, `everflow_js_sdk_code`, `brand_id_conversion_code`, `unknown_click`) VALUES
(1, '30.00', '19.95', 'AetbYdmlLyFqHYn3mlgmZi129Lrndxo81ORs1gtcWYxJjKW97V2Xm-WRKO7yDrm9-Zny5rLjJhiUCPMn', 'Admin is out of credits. Contact with him immediately ', 'kjd42989fm', 'http://test.api.com/', 'tns', '4893kvmmvm', '15.50', 'Company Name', '<script type=\"text/javascript\"\r\n\r\n    src=\"https://www.jgt2trk.com/scripts/sdk/everflow.js\"></script>', '<script type=\"text/javascript\"\r\n\r\n    src=\"https://www.jgt2trk.com/scripts/sdk/everflow.js\"></script>\r\n\r\n \r\n\r\n<script type=\"text/javascript\">\r\n\r\nEF.conversion({\r\n\r\n    aid: 1,\r\n\r\n    adv1: \'optional\',\r\n\r\n    adv2: \'optional\',\r\n\r\n    adv3: \'optional\',\r\n\r\n    adv4: \'optional\',\r\n\r\n    adv5: \'optional\',\r\n\r\n    amount: AMOUNT,\r\n\r\n    email: \'EMAIL\',\r\n\r\n    coupon_code: \'CC\',\r\n\r\n    order_id: \'optional\',\r\n\r\n});\r\n\r\n</script>', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_comers`
--
ALTER TABLE `affiliate_comers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_name_portions`
--
ALTER TABLE `affiliate_name_portions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_packages`
--
ALTER TABLE `customer_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `names`
--
ALTER TABLE `names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_comers`
--
ALTER TABLE `affiliate_comers`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_name_portions`
--
ALTER TABLE `affiliate_name_portions`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_packages`
--
ALTER TABLE `customer_packages`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `names`
--
ALTER TABLE `names`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
