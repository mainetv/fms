-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 04:17 AM
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
-- Database: `hrmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `designation_desc` varchar(255) DEFAULT NULL,
  `designation_abbr` varchar(255) DEFAULT NULL,
  `designation_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `division_id` varchar(10) DEFAULT NULL,
  `division_acro` varchar(20) DEFAULT NULL,
  `division_desc` varchar(100) DEFAULT NULL,
  `cluster` char(3) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `code` char(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_addinfos`
--

CREATE TABLE `employee_addinfos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `empcode` varchar(50) DEFAULT NULL,
  `empcode_id` varchar(50) DEFAULT NULL,
  `addinfo_pagibig` varchar(255) DEFAULT NULL,
  `addinfo_philhealth` varchar(255) DEFAULT NULL,
  `addinfo_sss` varchar(255) DEFAULT NULL,
  `addinfo_tin` varchar(255) DEFAULT NULL,
  `addinfo_gsis_id` varchar(255) DEFAULT NULL,
  `addinfo_gsis_policy` varchar(255) DEFAULT NULL,
  `addinfo_gsis_bp` varchar(255) DEFAULT NULL,
  `addinfo_partner` varchar(255) DEFAULT NULL,
  `addinfo_landbank` varchar(50) DEFAULT NULL,
  `addinfo_atm` varchar(50) DEFAULT NULL,
  `addinfo_gov` varchar(255) DEFAULT NULL,
  `addinfo_gov_id` varchar(255) DEFAULT NULL,
  `addinfo_gov_place_date` varchar(255) DEFAULT NULL,
  `addinfo_ctc` varchar(255) DEFAULT NULL,
  `addinfo_ctc_date` varchar(255) DEFAULT NULL,
  `addinfo_ctc_place` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_basicinfos`
--

CREATE TABLE `employee_basicinfos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `empcode` varchar(50) DEFAULT NULL,
  `basicinfo_placeofbirth` text DEFAULT NULL,
  `basicinfo_sex` enum('Male','Female') DEFAULT NULL,
  `basicinfo_civilstatus` varchar(255) DEFAULT NULL,
  `basicinfo_citizenship` varchar(255) DEFAULT NULL,
  `basicinfo_citizentype` varchar(255) DEFAULT NULL,
  `basicinfo_height` float DEFAULT NULL,
  `basicinfo_weight` float DEFAULT NULL,
  `basicinfo_bloodtype` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employments`
--

CREATE TABLE `employments` (
  `employment_id` bigint(20) UNSIGNED NOT NULL,
  `employment_desc` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plantillas`
--

CREATE TABLE `plantillas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `plantilla_division` varchar(10) DEFAULT NULL,
  `plantilla_item_number` varchar(100) DEFAULT NULL,
  `position_id` varchar(10) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `plantilla_step` int(11) DEFAULT NULL,
  `employment_id` int(11) DEFAULT NULL,
  `plantilla_salary` double DEFAULT NULL,
  `salary_grade` float DEFAULT NULL,
  `plantilla_date_from` date DEFAULT NULL,
  `plantilla_date_to` date DEFAULT NULL,
  `plantilla_special` int(11) DEFAULT NULL,
  `plantilla_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ehrms_plantilla_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position_id` varchar(10) DEFAULT NULL,
  `position_abbr` varchar(50) DEFAULT NULL,
  `position_desc` varchar(255) DEFAULT NULL,
  `position_class` enum('Technical','Administrative') DEFAULT NULL,
  `stepincrement_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dtr_exe` int(11) DEFAULT NULL,
  `oic` int(11) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `exname` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` text DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `rfid` varchar(255) DEFAULT NULL,
  `usertype` enum('Administrator','Director','Marshal','Staff','COS Admin') DEFAULT NULL,
  `division` varchar(10) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `employment_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `fldservice` datetime DEFAULT NULL,
  `pickup` text DEFAULT NULL,
  `cellnum` varchar(15) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `payroll` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`designation_id`),
  ADD KEY `designation_id` (`designation_id`),
  ADD KEY `designation_abbr` (`designation_abbr`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indexes for table `employee_addinfos`
--
ALTER TABLE `employee_addinfos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `empcode` (`empcode`);

--
-- Indexes for table `employee_basicinfos`
--
ALTER TABLE `employee_basicinfos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employments`
--
ALTER TABLE `employments`
  ADD PRIMARY KEY (`employment_id`),
  ADD KEY `employment_desc` (`employment_desc`),
  ADD KEY `employment_id` (`employment_id`);

--
-- Indexes for table `plantillas`
--
ALTER TABLE `plantillas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantilla_item_number` (`plantilla_item_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `designation_id` (`designation_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `designation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_addinfos`
--
ALTER TABLE `employee_addinfos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_basicinfos`
--
ALTER TABLE `employee_basicinfos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employments`
--
ALTER TABLE `employments`
  MODIFY `employment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plantillas`
--
ALTER TABLE `plantillas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
