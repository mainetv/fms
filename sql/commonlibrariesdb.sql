-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 04:16 AM
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
-- Database: `commonlibrariesdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `allotment_fund`
--

CREATE TABLE `allotment_fund` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fund_code` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `request_status_type_id` bigint(20) UNSIGNED NOT NULL,
  `tags` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank` varchar(250) DEFAULT NULL,
  `bank_acronym` varchar(20) DEFAULT NULL,
  `short_name` varchar(30) DEFAULT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank`, `bank_acronym`, `short_name`, `bank_code`, `remarks`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Landbank of the Philippines', 'LBP', 'LBP', NULL, NULL, 1, 0, '2022-07-11 03:09:36', '2022-07-11 03:09:36'),
(2, 'Bank of the Philippine Islands', 'BPI', 'BPI', NULL, NULL, 1, 0, '2022-07-11 03:09:36', '2022-07-11 03:09:36'),
(3, 'Development Bank of the Philippines', 'DBP', 'DBP', NULL, NULL, 1, 0, '2022-07-11 03:10:14', '2022-07-11 03:10:14'),
(4, 'Philippine National Bank', 'PNB', 'PNB', NULL, NULL, 1, 0, '2022-07-11 03:10:30', '2022-07-11 03:10:30'),
(5, 'Asia United Bank', 'AUB', 'AUB', NULL, NULL, 1, 0, '2022-07-11 03:10:42', '2022-07-11 03:10:42'),
(6, 'Banco de Oro', 'BDO', 'BDO', NULL, NULL, 1, 0, '2022-07-11 03:11:21', '2022-07-11 03:11:21'),
(7, 'Bank of the Philippine Islands Family', 'BPIF', 'BPI Family', NULL, NULL, 1, 0, '2022-07-11 03:11:40', '2022-07-11 03:11:40'),
(8, 'China Banking Corporation', 'CBC', 'China Bank', NULL, NULL, 1, 0, '2022-07-11 03:12:38', '2022-07-11 03:12:38'),
(9, 'East West Banking Corporation', 'EWB', 'EastWest Bank', NULL, NULL, 1, 0, '2022-07-11 03:12:54', '2022-07-11 03:12:54'),
(10, 'Luzon Development Bank', 'LDB', 'Luzon Development Bank', NULL, NULL, 1, 0, '2022-07-11 03:13:24', '2022-07-11 03:13:24'),
(11, 'Malayan Banking Berhad', 'MayBank', 'MayBank', NULL, NULL, 1, 0, '2022-07-11 03:13:56', '2022-07-11 03:13:56'),
(12, 'Metropolitan Bank', 'Metrobank', 'Metrobank', NULL, NULL, 1, 0, '2022-07-11 03:14:43', '2022-07-11 03:14:43'),
(13, 'Philippine Veterans Bank', 'PVB', 'Philippine Veterans', NULL, NULL, 1, 0, '2022-07-11 03:15:11', '2022-07-11 03:15:11'),
(14, 'Philippine Savings Bank', 'PSB', 'PSBank', NULL, NULL, 1, 0, '2022-07-11 03:15:42', '2022-07-11 03:15:42'),
(15, 'Rizal Commercial Banking Corporation', 'RCBC', 'RCBC', NULL, NULL, 1, 0, '2022-07-11 03:16:04', '2022-07-11 03:16:04'),
(16, 'Security Bank Corporation', 'SBC', 'Security Bank', NULL, NULL, 1, 0, '2022-07-11 03:16:51', '2022-07-11 03:16:51'),
(17, 'United Coconut Planters Bank', 'UCPB', 'UCPB', NULL, NULL, 1, 0, '2022-07-11 03:17:12', '2022-07-11 03:17:12'),
(18, 'Union Bank of the Philippines', 'UBP', 'UnionBank', NULL, NULL, 1, 0, '2022-07-11 03:17:36', '2022-07-11 03:17:36'),
(19, 'Standard Chartered Bank', 'SCB', 'Standard Chartered', NULL, NULL, 1, 0, '2022-07-11 03:33:21', '2022-07-11 03:33:21'),
(20, 'Philippine Business Bank', 'PBB', 'Philippine Business Bank', NULL, NULL, 1, 0, '2022-07-11 03:39:51', '2022-07-11 03:39:51'),
(21, 'Bank of Makati, Inc.', 'BMI', 'Bank of Makati', NULL, NULL, 1, 0, '2022-07-11 03:40:13', '2022-07-11 03:40:13'),
(22, 'Bank of Commerce', 'BOC', 'Bank of Commerce', NULL, NULL, 1, 0, '2022-07-11 05:15:30', '2022-07-11 05:15:30'),
(23, 'Planters Bank', 'Planters Bank', 'Planters Bank', NULL, NULL, 1, 0, '2022-07-11 05:16:21', '2022-07-11 05:16:21'),
(24, 'Citibank', 'Citibank', 'Citibank', NULL, NULL, 1, 0, '2022-07-11 05:17:35', '2022-07-11 05:17:35'),
(25, 'Intesa Sanpaolo S.p.A', 'Intesa Sanpaolo', 'Intesa Sanpaolo', NULL, NULL, 1, 0, '2022-07-11 05:18:56', '2022-07-11 05:18:56'),
(26, 'Philippine Veterans Bank', 'PVB', 'Philippine Veterans Bank', NULL, NULL, 1, 0, '2023-07-30 04:32:46', '2023-07-30 04:32:46'),
(27, 'China Savings Bank', 'CSB', 'China Savings Bank', NULL, NULL, 1, 0, '2023-08-11 02:01:33', NULL),
(28, 'China Bank Savings', 'China Bank Savings', 'China Bank Savings', NULL, NULL, 1, 0, '2023-12-28 01:47:10', NULL),
(29, 'SeaBank Philippines, Inc.', 'SeaBank', 'SeaBank', NULL, NULL, 1, 0, '2024-02-13 00:58:32', NULL),
(30, 'Banco de Oro, Unibank', 'BDO Unibank', 'BDO Unibank', NULL, NULL, 1, 0, '2024-02-26 07:25:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fund` varchar(255) DEFAULT NULL,
  `fund_prefix` varchar(5) DEFAULT NULL,
  `destination` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `fund`, `fund_prefix`, `destination`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '101', '01', NULL, 1, 0, '2022-07-06 07:43:28', '2022-07-06 07:43:28'),
(2, '184', '07', NULL, 1, 0, '2022-07-06 07:43:28', '2022-07-06 07:43:28'),
(3, '184-C', '07', NULL, 1, 0, '2023-07-03 01:11:09', NULL),
(4, '164', NULL, NULL, 0, 0, '2023-07-03 01:11:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pcaarrd_divisions`
--

CREATE TABLE `pcaarrd_divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_acronym` varchar(15) NOT NULL,
  `division_code` varchar(6) DEFAULT NULL,
  `division_id` varchar(5) NOT NULL,
  `division` varchar(500) NOT NULL,
  `is_section` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes 	',
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `cluster_id` bigint(20) UNSIGNED NOT NULL,
  `is_cluster` tinyint(1) NOT NULL DEFAULT 0,
  `tags` varchar(500) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0-no, 1-yes',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_status_types`
--

CREATE TABLE `request_status_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_status_type` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `fund_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rs` varchar(20) DEFAULT NULL,
  `notice_adjustment` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_status_types`
--

INSERT INTO `request_status_types` (`id`, `request_status_type`, `description`, `fund_id`, `rs`, `notice_adjustment`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'ORS', 'Obligation Request and Status', 1, 'Obligation', 'NORSA', 1, 0, '2022-07-06 08:07:47', '2022-07-06 08:07:47'),
(2, 'BURS', 'Budget Utilization Request and Status', 2, 'Budget Utilization', 'NBURSA', 1, 0, '2022-07-06 08:07:47', '2022-07-06 08:07:47'),
(3, 'BURS-CFITF', 'Budget Utilization Request and Status - CFITF', 3, 'Budget Utilization', 'NBURSA', 1, 0, '2023-05-25 07:19:09', '2023-05-25 07:24:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allotment_fund`
--
ALTER TABLE `allotment_fund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pcaarrd_divisions`
--
ALTER TABLE `pcaarrd_divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `division` (`division_id`) USING BTREE,
  ADD KEY `FK_pcaarrd_divisions_parent_idx` (`parent_id`),
  ADD KEY `FK_pcaarrd_divisions_cluster_idx` (`cluster_id`);

--
-- Indexes for table `request_status_types`
--
ALTER TABLE `request_status_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allotment_fund`
--
ALTER TABLE `allotment_fund`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pcaarrd_divisions`
--
ALTER TABLE `pcaarrd_divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_status_types`
--
ALTER TABLE `request_status_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



CREATE TABLE `retirement_laws` (
  `id` bigint UNSIGNED NOT NULL,
  `ra_no` varchar(30) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `retirement_laws`
--

INSERT INTO `retirement_laws` (`id`, `ra_no`, `description`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'RA No. 1616', NULL, 1, 0, '2023-02-16 06:04:42', '2023-02-16 06:04:42'),
(2, 'RA 8291', NULL, 1, 0, '2023-02-16 06:05:17', '2023-02-16 06:05:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `retirement_laws`
--
ALTER TABLE `retirement_laws`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `retirement_laws`
--
ALTER TABLE `retirement_laws`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;