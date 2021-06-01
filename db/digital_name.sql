-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2021 at 10:20 PM
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

--
-- Dumping data for table `affiliates`
--

INSERT INTO `affiliates` (`id`, `title`, `clicks`, `signups`, `link`, `affiliate_string`, `domain`, `sale_percentage`) VALUES
(1, 'Hakuna', 0, 0, 'http://hakuna.com/?R=720865', '720865', 'http://hakuna.com/', '0.00'),
(2, 'toyota', 0, 0, 'https://www.toyota.com/?R=37debf', '37debf', 'https://www.toyota.com/', '0.00'),
(5, 'Roleda', 0, 0, 'https://roleda.com/?R=f61e5c', 'f61e5c', 'https://roleda.com/', '0.00'),
(6, 'margura', 0, 0, 'http://margura.com/?R=d00aea', 'd00aea', 'http://margura.com/', '0.00'),
(11, 'Corola', 0, 0, 'https://www.corola.com/?R=05ksbm', '05ksbm', 'https://www.corola.com/', '0.00'),
(12, 'Muskan', 0, 0, 'http://muskan.com/?R=nbhLSu', 'nbhLSu', 'http://muskan.com/', '0.00'),
(13, 'Ristro', 0, 0, NULL, 'hb6gUx', 'https://ristro.com/', '0.00'),
(14, 'Royex', 0, 0, NULL, 'u2bxH7', 'https://royex.com/', '10.03');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_comers`
--

CREATE TABLE `affiliate_comers` (
  `id` int(15) NOT NULL,
  `mac_id` varchar(30) DEFAULT NULL,
  `affiliate_id` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affiliate_comers`
--

INSERT INTO `affiliate_comers` (`id`, `mac_id`, `affiliate_id`) VALUES
(2, 'A6-4B-F5-80-59-47', 11),
(3, 'A6-4B-85-50-59-47', 2),
(4, 'B6-CB-35-50-59-47', 5),
(5, 'C6-41-85-O0-59-47', 2),
(6, 'B6-CB-35-60-59-47', 5),
(7, 'B6-MB-35-60-59-47', 5),
(8, 'B6-6B-35-60-59-47', 6),
(9, 'B6-2B-35-60-59-47', 5),
(10, 'L6-9B-35-60-59-47', 11),
(11, 'K6-CB-35-60-59-47', 5),
(12, 'BM-GB-35-60-59-47', 6),
(13, 'B6-8B-35-60-59-47', 2),
(14, 'BH-XB-35-60-59-47', 1),
(15, 'C6-41-85-O0-59-97', 6),
(16, 'B6-CB-3H-60-59-47', 6),
(17, 'B6-MB-A5-60-59-47', 12),
(18, 'B6-6B-F5-60-59-47', 12),
(19, 'B6-2B-W5-60-59-47', 13),
(20, 'L6-9B-V5-60-59-47', 11),
(21, 'K6-CB-35-Q0-59-47', 5),
(22, 'BM-GB-35-S0-59-47', 6),
(23, 'B6-8B-35-C0-59-47', 2),
(24, 'BH-XB-35-D0-59-47', 1),
(26, '::1', 14);

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

--
-- Dumping data for table `affiliate_name_portions`
--

INSERT INTO `affiliate_name_portions` (`id`, `name_id`, `customer_id`, `affiliate_id`, `affiliate_portion_price`, `original_price`, `current_percentage`) VALUES
(1, 53, 11, 11, '3.09', '19.95', '15.50'),
(2, 54, 11, 11, '3.09', '19.95', '15.50'),
(3, 55, 12, 2, '3.09', '19.95', '15.50'),
(4, 56, 12, 2, '3.09', '19.95', '15.50'),
(5, 57, 12, 2, '3.09', '19.95', '15.50'),
(8, 64, 16, 14, '2.00', '19.95', '10.03'),
(9, 65, 16, 14, '2.00', '19.95', '10.03'),
(10, 75, 16, 14, '2.00', '19.95', '10.03'),
(11, 77, 13, 2, '0.00', '19.95', '0.00');

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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `login_token`, `cc`, `api_key`, `registered_at`, `affiliate_id`) VALUES
(1, 'Mohammad Arif', 'baki@yahoo.com', 'baki123', '09484948', '932e63f8470b485b0d87da5d40bd75f4a0f656999f462481340acbab705554676227a3675209369454a73f59afeb192939e1c838c42401abf2b02dd7a94d3a34cebfe866d7d5', '148w70aB', 'k4b1a7f2', '2021-04-09 15:10:00', 0),
(6, 'Masari Molari', 'masari@yahoo.com', 'masari123', '6869898', '00d401e421db81e2234649b57f741cdcf562787cf58f50a8cdaf4e4174368e2bef5bf608b8f3458335e4a2d8eb9801e5691412c91098274c7580561cce77105d7287aee23c03', NULL, NULL, '0000-00-00 00:00:00', 0),
(7, 'Md. Rakib', 'rakib@yahoo.com', 'rakib123', '689389', '22f677b12924d66cd25ff77d5553d4993fe5270b766af4f074f5edfb1e032e478dd484a0e76de546870b00e764522cb4cf4bc5e9d83da70e15000751de076b62aff65ac105f3', NULL, NULL, '0000-00-00 00:00:00', 0),
(9, 'Mondira', 'mondira@yahoo.com', 'mondira123', '5895869', 'bb441e700238f96ed3274063cd867c679ad7f1f82d6b7076898147bd983479b24ad2c60b440e250d36c9a19a8f539419f4839fbd64243d704ed47917b52c988981f354faa030', NULL, NULL, '0000-00-00 00:00:00', 0),
(11, 'Tumar', 'tumar@yahoo.com', 'tumar123', '4895869989', '29b3f513d11316327f20aceddca3cc26b46cfffdbab2dabdf672c392b5191578108180845b257476d3dcd08d7ad255f5932272bb52536c88ca91eda939f9a9f32e010267a4e7', NULL, NULL, '0000-00-00 00:00:00', 11),
(12, 'Tumari', 'tumari@yahoo.com', 'tumari123', '4895864889989', 'b98b2d961262eb73f87d937781842b4ff9114755b605877a4b71127cc950e0fbd0d16e99e8f19691137d30a3da82bd412591d37aaca5f03703bd841b66f501e6214b4978d687', NULL, NULL, '2021-04-25 01:43:18', 2),
(13, 'Kumari', 'kumari@yahoo.com', 'kumari123', '4895864889989', '3a7068845e3e13eb04aa700513fa66266a25df892f38fd9ebc4281ec397666ced36d4bb6733e2ab178d440949ce9af1a2fe498274954684227a4ab3422a4d8b0d27f24b654dc', NULL, NULL, '2021-04-25 01:43:18', 2),
(15, 'Solima', 'solima@yahoo.com', 'solima123', '4895898', 'b99116e9a128477b6b18e61289f75c6de4352602a2f8df42e46ad314fc179eec5214bd3f3b5cc85c5a89f37970821d33d441fbf508e628ad985148511c8160c5034ed6040777', NULL, NULL, '2021-05-05 08:07:44', 0),
(16, 'Morga', 'morga@yahoo.com', 'morga123', '2928958598', 'd66f3e6d6b2c7bc4ac21a6034eeaaaa12606bd1da9124f5d9a5dc7014c4e5e3f9df3655e01cfa6f8e2d9461a83b315cc491399100f7da19f24cead370afe246d979a293dc53d', NULL, NULL, '2021-05-05 08:31:42', 14);

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

--
-- Dumping data for table `customer_packages`
--

INSERT INTO `customer_packages` (`id`, `name`, `package_price`, `customer_id`) VALUES
(1, '', '45.95', 1),
(2, '', '45.95', 1),
(3, '', '45.95', 1),
(4, '', '45.95', 1),
(5, 'Speculator Package', '45.95', 1),
(6, 'Speculator Package', '45.95', 16),
(7, 'Developer Package', '45.95', 15),
(8, 'Developer Package', '45.95', 13),
(9, 'Speculator Package', '45.95', 13),
(10, 'Speculator Package', '45.95', 15);

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

--
-- Dumping data for table `names`
--

INSERT INTO `names` (`id`, `name`, `name_price`, `customer_id`) VALUES
(1, '$Mokra', '0.00', 1),
(2, '$rahel', '0.00', 1),
(3, '$489', '0.00', 1),
(28, '$motiar', '0.00', 1),
(37, '$Bolar', '0.00', 1),
(38, '$Bolar', '0.00', 1),
(39, '$Bolar', '0.00', 1),
(40, '$Bolar', '0.00', 1),
(41, '$Smuel', '0.00', 7),
(42, '$Orisa', '0.00', 7),
(43, '$Hamasadi', '0.00', 7),
(44, '$sneul', '0.00', 1),
(45, '$Morcha', '0.00', 1),
(46, '$kurulla', '16.86', 11),
(47, '$Iliana', '16.86', 11),
(48, '$Kors', '16.86', 11),
(49, '$Roton', '16.86', 11),
(50, '$Bohola', '16.86', 11),
(51, '$Morkora', '16.86', 11),
(52, '$Conola', '16.86', 11),
(53, '$Mehena', '16.86', 11),
(54, '$Loris', '16.86', 11),
(55, '$Osthir', '16.86', 12),
(56, '$Odhora', '16.86', 12),
(57, '$Mursila', '16.86', 12),
(58, '$darham', '19.95', 1),
(59, '$kongra', '19.95', 1),
(60, '$Mudara', '19.95', 1),
(61, '$Lurala', '19.95', 1),
(62, '$Mundu', '19.95', 15),
(63, '$Pundu', '19.95', 15),
(64, '$Pardos', '17.95', 16),
(65, '$Disman', '17.95', 16),
(66, '$johona', '19.95', 1),
(67, '$oradha', '19.95', 1),
(68, '$bernal', '19.95', 1),
(69, '$orala', '19.95', 1),
(70, 'null', '19.95', 1),
(71, 'null', '19.95', 1),
(72, 'null', '19.95', 1),
(73, 'null', '19.95', 1),
(74, 'null', '19.95', 1),
(75, 'null', '17.95', 16),
(76, 'null', '19.95', 15),
(77, 'null', '19.95', 13),
(78, '$Morda', '19.95', 15),
(79, '$Shorda', '19.95', 15),
(80, '$shrema', '19.95', 15),
(81, '$trikta', '19.95', 15);

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
(1, '30.00', '19.95', 'AetbYdmlLyFqHYn3mlgmZi129Lrndxo81ORs1gtcWYxJjKW97V2Xm-WRKO7yDrm9-Zny5rLjJhiUCPMn', 'Admin is out of credits. Contact with him immediately ', 'kjd42989fm', 'http://test.api.com/', 'tns', '4893kvmmvm', '15.50', 'Digital Name test1', '<script type=\"text/javascript\"\r\n\r\n    src=\"https://www.jgt2trk.com/scripts/sdk/everflow.js\"></script>', '<script type=\"text/javascript\"\r\n\r\n    src=\"https://www.jgt2trk.com/scripts/sdk/everflow.js\"></script>\r\n\r\n \r\n\r\n<script type=\"text/javascript\">\r\n\r\nEF.conversion({\r\n\r\n    aid: 1,\r\n\r\n    adv1: \'optional\',\r\n\r\n    adv2: \'optional\',\r\n\r\n    adv3: \'optional\',\r\n\r\n    adv4: \'optional\',\r\n\r\n    adv5: \'optional\',\r\n\r\n    amount: AMOUNT,\r\n\r\n    email: \'EMAIL\',\r\n\r\n    coupon_code: \'CC\',\r\n\r\n    order_id: \'optional\',\r\n\r\n});\r\n\r\n</script>', 159);

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
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `affiliate_comers`
--
ALTER TABLE `affiliate_comers`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `affiliate_name_portions`
--
ALTER TABLE `affiliate_name_portions`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customer_packages`
--
ALTER TABLE `customer_packages`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `names`
--
ALTER TABLE `names`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
