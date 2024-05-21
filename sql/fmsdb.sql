-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2024 at 04:34 PM
-- Server version: 8.0.35
-- PHP Version: 8.0.30

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ada`
--

CREATE TABLE `ada` (
  `id` bigint UNSIGNED NOT NULL,
  `ada_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ada_date` date DEFAULT NULL,
  `fund_id` bigint UNSIGNED DEFAULT NULL,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_ps_amount` double NOT NULL DEFAULT '0',
  `total_mooe_amount` double NOT NULL DEFAULT '0',
  `total_co_amount` double NOT NULL DEFAULT '0',
  `date_transferred` date DEFAULT NULL,
  `signatory1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory1_position` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2_position` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3_position` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4_position` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5_position` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ada_lddap`
--

CREATE TABLE `ada_lddap` (
  `id` bigint UNSIGNED NOT NULL,
  `ada_id` bigint UNSIGNED DEFAULT NULL,
  `lddap_id` bigint UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ps_amount` double NOT NULL DEFAULT '0',
  `mooe_amount` double NOT NULL DEFAULT '0',
  `co_amount` double NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adjustment`
--

CREATE TABLE `adjustment` (
  `id` bigint NOT NULL,
  `allotment_id` bigint UNSIGNED NOT NULL,
  `adjustment_type_id` bigint UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `reference_no` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q1_adjustment` double NOT NULL DEFAULT '0',
  `q2_adjustment` double NOT NULL DEFAULT '0',
  `q3_adjustment` double NOT NULL DEFAULT '0',
  `q4_adjustment` double NOT NULL DEFAULT '0',
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allotment`
--

CREATE TABLE `allotment` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `reference_qop_id` bigint UNSIGNED DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rs_type_id` bigint UNSIGNED DEFAULT NULL,
  `allotment_fund_id` bigint UNSIGNED DEFAULT NULL,
  `pap_id` bigint UNSIGNED DEFAULT NULL,
  `activity_id` bigint UNSIGNED DEFAULT NULL,
  `subactivity_id` bigint UNSIGNED DEFAULT NULL,
  `expense_account_id` bigint UNSIGNED DEFAULT NULL,
  `object_expenditure_id` bigint UNSIGNED DEFAULT NULL,
  `object_specific_id` bigint UNSIGNED DEFAULT NULL,
  `pooled_at_division_id` bigint UNSIGNED DEFAULT NULL,
  `q1_allotment` double NOT NULL DEFAULT '0',
  `q2_allotment` double NOT NULL DEFAULT '0',
  `q3_allotment` double NOT NULL DEFAULT '0',
  `q4_allotment` double NOT NULL DEFAULT '0',
  `q1_nca` double NOT NULL DEFAULT '0',
  `q2_nca` double NOT NULL DEFAULT '0',
  `q3_nca` double NOT NULL DEFAULT '0',
  `q4_nca` double NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint UNSIGNED NOT NULL,
  `old_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `new_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_comments`
--

CREATE TABLE `bp_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget_proposal_id` bigint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `comment_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_by_user_id` bigint UNSIGNED NOT NULL,
  `is_resolved` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form3`
--

CREATE TABLE `bp_form3` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tier` tinyint(1) NOT NULL DEFAULT '1',
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `area_sqm` int DEFAULT NULL,
  `location` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `years_completion` int DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  `justification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form4`
--

CREATE TABLE `bp_form4` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tier` tinyint(1) NOT NULL DEFAULT '1',
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `area_sqm` int DEFAULT NULL,
  `location` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `num_years_completion` int DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  `justification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form5`
--

CREATE TABLE `bp_form5` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tier` tinyint(1) NOT NULL,
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `quantity` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  `organizational_deployment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `justification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form6`
--

CREATE TABLE `bp_form6` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tier` tinyint(1) DEFAULT '1',
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `quantity` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  `organizational_deployment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `justification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form7`
--

CREATE TABLE `bp_form7` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `project` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `location_id` bigint DEFAULT NULL,
  `beneficiaries` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_project_cost` double DEFAULT NULL,
  `implementing_agency_id` bigint DEFAULT NULL,
  `monitoring_agency_id` bigint DEFAULT NULL,
  `fund_allocation_fiscal_year1` double DEFAULT NULL,
  `fund_allocation_fiscal_year2` double DEFAULT NULL,
  `fund_allocation_fiscal_year3` double DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form8`
--

CREATE TABLE `bp_form8` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `proposed_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `destination` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` double DEFAULT NULL,
  `purpose_travel` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form9`
--

CREATE TABLE `bp_form9` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `quantity` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  `organizational_deployment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `justification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_form205`
--

CREATE TABLE `bp_form205` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fiscal_year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retirement_law_id` bigint UNSIGNED NOT NULL,
  `emp_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_id_at_retirement_date` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highest_monthly_salary` double DEFAULT NULL,
  `sl_credits_earned` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vl_credits_earned` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leave_amount` double DEFAULT NULL,
  `total_creditable_service` double DEFAULT NULL,
  `num_gratuity_months` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gratuity_amount` double DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_gsis` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bp_status`
--

CREATE TABLE `bp_status` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `status_by_user_id` bigint UNSIGNED NOT NULL,
  `status_by_user_role_id` bigint UNSIGNED NOT NULL,
  `status_by_user_division_id` bigint UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_proposals`
--

CREATE TABLE `budget_proposals` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pap_id` bigint UNSIGNED DEFAULT NULL,
  `activity_id` bigint UNSIGNED DEFAULT NULL,
  `subactivity_id` bigint UNSIGNED DEFAULT NULL,
  `expense_account_id` bigint UNSIGNED DEFAULT NULL,
  `object_expenditure_id` bigint UNSIGNED DEFAULT NULL,
  `object_specific_id` bigint UNSIGNED DEFAULT NULL,
  `pooled_at_division_id` bigint UNSIGNED DEFAULT NULL,
  `fy1_amount` double DEFAULT NULL,
  `fy2_amount` double DEFAULT NULL,
  `fy3_amount` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checks`
--

CREATE TABLE `checks` (
  `id` bigint UNSIGNED NOT NULL,
  `dv_id` bigint UNSIGNED DEFAULT NULL,
  `check_date` date DEFAULT NULL,
  `check_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fund_id` bigint UNSIGNED DEFAULT NULL,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `acic_id` bigint UNSIGNED DEFAULT NULL,
  `date_released` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_comments`
--

CREATE TABLE `cp_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `cash_program_id` bigint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `comment_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_resolved` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_status`
--

CREATE TABLE `cp_status` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `status_by_user_id` bigint UNSIGNED NOT NULL,
  `status_by_user_role_id` bigint UNSIGNED NOT NULL,
  `status_by_user_division_id` bigint UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disbursement_vouchers`
--

CREATE TABLE `disbursement_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `fais_id` bigint UNSIGNED DEFAULT NULL,
  `lddap_id` bigint UNSIGNED DEFAULT NULL,
  `check_id` bigint UNSIGNED DEFAULT NULL,
  `dv_no` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dv_date` date DEFAULT NULL,
  `dv_date1` date DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `fund_id` bigint UNSIGNED DEFAULT NULL,
  `payee_id` bigint UNSIGNED DEFAULT NULL,
  `total_dv_gross_amount` double NOT NULL DEFAULT '0',
  `total_dv_net_amount` double NOT NULL DEFAULT '0',
  `particulars` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `signatory1` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory1_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_type_id` bigint UNSIGNED DEFAULT NULL,
  `pay_type_id` bigint UNSIGNED DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `out_to` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_from` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_returned` date DEFAULT NULL,
  `po_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `invoice_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `jobcon_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jobcon_date` date DEFAULT NULL,
  `or_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `or_date` date DEFAULT NULL,
  `cod_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_at` datetime DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dv_rs`
--

CREATE TABLE `dv_rs` (
  `id` bigint UNSIGNED NOT NULL,
  `dv_id` bigint UNSIGNED NOT NULL,
  `rs_id` bigint UNSIGNED NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dv_rs_net`
--

CREATE TABLE `dv_rs_net` (
  `id` bigint UNSIGNED NOT NULL,
  `dv_id` bigint UNSIGNED NOT NULL,
  `rs_id` bigint UNSIGNED NOT NULL,
  `gross_amount` double NOT NULL DEFAULT '0',
  `tax_one` double NOT NULL DEFAULT '0',
  `tax_two` double NOT NULL DEFAULT '0',
  `tax_twob` double NOT NULL DEFAULT '0',
  `tax_three` double NOT NULL DEFAULT '0',
  `tax_four` double NOT NULL DEFAULT '0',
  `tax_five` double NOT NULL DEFAULT '0',
  `tax_six` double NOT NULL DEFAULT '0',
  `wtax` double NOT NULL DEFAULT '0',
  `other_tax` double NOT NULL DEFAULT '0',
  `liquidated_damages` double NOT NULL DEFAULT '0',
  `other_deductions` double NOT NULL DEFAULT '0',
  `net_amount` double NOT NULL DEFAULT '0',
  `allotment_class_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dv_transaction_type`
--

CREATE TABLE `dv_transaction_type` (
  `id` bigint UNSIGNED NOT NULL,
  `dv_id` bigint UNSIGNED DEFAULT NULL,
  `dv_transaction_type_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fiscal_year`
--

CREATE TABLE `fiscal_year` (
  `id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fiscal_year1` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fiscal_year2` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fiscal_year3` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `open_date_from` date DEFAULT NULL,
  `open_date_to` date DEFAULT NULL,
  `filename` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_locked` tinyint(1) DEFAULT '1' COMMENT '0-no, 1-yes',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-no, 1-yes',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-no, 1-yes',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `form` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desription` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lddap`
--

CREATE TABLE `lddap` (
  `id` bigint UNSIGNED NOT NULL,
  `ada_id` bigint UNSIGNED DEFAULT NULL,
  `lddap_no` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lddap_date` date DEFAULT NULL,
  `payment_mode_id` bigint DEFAULT NULL,
  `fund_id` bigint UNSIGNED NOT NULL,
  `nca_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `check_no` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acic_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_lddap_gross_amount` double NOT NULL DEFAULT '0',
  `total_lddap_net_amount` double NOT NULL DEFAULT '0',
  `signatory1` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory1_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lddap_dv`
--

CREATE TABLE `lddap_dv` (
  `id` bigint UNSIGNED NOT NULL,
  `lddap_id` bigint UNSIGNED DEFAULT NULL,
  `dv_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_activity`
--

CREATE TABLE `library_activity` (
  `id` bigint UNSIGNED NOT NULL,
  `old_id` bigint UNSIGNED DEFAULT NULL,
  `activity` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `appropriation_id` bigint UNSIGNED DEFAULT NULL,
  `request_status_type_id` bigint UNSIGNED NOT NULL,
  `tags` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_program` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_adjustment_types`
--

CREATE TABLE `library_adjustment_types` (
  `id` bigint NOT NULL,
  `adjustment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_adjustment_types`
--

INSERT INTO `library_adjustment_types` (`id`, `adjustment_type`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Sub-allotment', 1, 0, '2023-02-22 05:23:29', '2023-02-22 05:23:29'),
(2, 'Debit Memo', 1, 0, '2023-02-22 05:23:29', '2023-02-22 05:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `library_allotment_class`
--

CREATE TABLE `library_allotment_class` (
  `id` bigint UNSIGNED NOT NULL,
  `allotment_class` varchar(100) DEFAULT NULL,
  `allotment_class_acronym` varchar(20) DEFAULT NULL,
  `allotment_number` varchar(20) DEFAULT NULL,
  `allotment_class_number` varchar(20) DEFAULT NULL,
  `tags` text,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `library_allotment_class`
--

INSERT INTO `library_allotment_class` (`id`, `allotment_class`, `allotment_class_acronym`, `allotment_number`, `allotment_class_number`, `tags`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Personnel Services', 'PS', '5-01', '01', NULL, 1, 0, '2022-07-06 00:03:28', NULL),
(2, 'Maintenance and Other Operating Expenses', 'MOOE', '5-02', '02', NULL, 1, 0, '2022-07-06 00:03:59', NULL),
(3, 'Capital Outlay', 'CO', '5-06', '06', NULL, 1, 0, '2022-07-06 00:03:28', NULL),
(4, 'Financial Expenses', 'FinEx', NULL, NULL, NULL, 1, 0, '2023-02-02 02:13:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `library_bank_accounts`
--

CREATE TABLE `library_bank_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `bank_id` bigint UNSIGNED DEFAULT NULL,
  `bank_branch` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fund_id` bigint UNSIGNED NOT NULL,
  `is_collection` tinyint(1) NOT NULL,
  `is_disbursement` tinyint(1) NOT NULL,
  `cash_fund_id` bigint UNSIGNED DEFAULT NULL,
  `fund_cluster` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_dv_document`
--

CREATE TABLE `library_dv_document` (
  `id` bigint NOT NULL,
  `document` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dv_transaction_type_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_dv_document`
--

INSERT INTO `library_dv_document` (`id`, `document`, `dv_transaction_type_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Copy of Appointment', 74, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(2, 'Oath of Office/Panunumpa', 74, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(3, 'Daily Time Record (DTR)', 74, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(4, 'Copy of Report for Duty', 74, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(5, 'Copy of Latest Statement of Assets & Liabilities', 74, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(6, 'Copy of Appointment', 75, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(7, 'Copy of Report for Duty', 75, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(8, 'Notice of Salary Adjustment', 76, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(9, 'Approved Application for Maternity Leave', 70, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(10, 'Medical Certificate', 70, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(11, 'Clearance from Money & Property Acountabilities', 70, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(12, 'Approved Request', 69, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(13, 'Approved Application for Leave', 69, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(14, 'Computation of Leave Money Value (c/o Personnel)', 69, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(15, 'Approved Application for Terminal Leave', 77, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(16, 'Copy of Last Appointment', 77, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(17, 'Clearance from Money & Property Accountabilities', 77, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(18, 'Copy of Latest Statement of Assets & Liabilities', 77, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(19, 'Copy of Approved Resignation/Retirement Letter', 77, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(20, 'Payroll Request & Certificate of Service Rendered', 71, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(21, 'Notice of GC Meeting', 71, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(22, 'Certified List of Attendance', 71, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(23, 'Copy of Appointment/Special Order (for first payment)', 73, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(24, 'Certification of Services Rendered signed by the Division Director concerned and duly approved by the Deputy Executive Director for R&D', 73, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(25, 'Copy of Appointment/Special Order', 72, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(26, 'Payroll Request & Certification of Service Rendered', 72, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(27, 'Travel Order (TO)/Trip Ticket', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(28, 'Itinerary of Travel', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(29, 'Certificate of Travel Completion', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(30, 'Certificate of Appearance, if travel is outside Metro Manila', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(31, 'Waiver of Claim for Travelling Expenses (for non-PCARRD but government employee)', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(32, 'If claiming actual expenses—Certification that Actual Travel Expenses were Incurred in the Performance of the Assignment, duly signed by the Executive Director', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(33, 'Official Receipts (OR), Toll Tickets, if applicable (original and xerox if tape or fax paper)', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(34, 'Copy of e-Ticket, Boarding Pass and Terminal Fee Ticket (when applicable)', 46, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(35, 'Travel Order (TO)/Trip Ticket (2 copies)', 45, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(36, 'Itinerary of Travel (2 copies)', 45, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(37, 'Liquidation Report (2 copies)', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(38, 'Actual Itinerary of Travel/Copy of Approved Itinerary of Travel', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(39, 'Certificate of Travel Completion', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(40, 'Official Receipts (OR), Toll Tickets, if applicable (original and xerox if tape or fax paper)', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(41, 'Copy of e-Ticket, Boarding Pass and Terminal Fee Ticket (when applicable)', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(42, 'Certificate of Appearance, if travel is outside Metro Manila', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(43, 'Waiver of Claim for Travelling Expenses (for non-PCARRD but government employee)', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(44, 'If claiming actual expenses—Certification that Actual Travel Expenses were Incurred in the Performance of the Assignment, duly signed by the Executive Director', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(45, 'Copy of Trip Ticket and/or Travel Order (TO)', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(46, 'Copy of Previous DV and IT for Cash Advance', 44, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(47, 'Copy of Liquidation Report', 47, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(48, 'Authority to Travel', 50, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(49, 'Itinerary of Travel', 50, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(50, 'Certificate of Travel Completion', 50, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(51, 'Certificate of Participation or Equivalent', 50, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(52, 'Copy of/or clippings from a newspaper re: Exchange Rate on the date of actual travel', 50, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(53, 'Waiver of Claim for Travelling Expenses (for non-PCARRD but government employee)', 50, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(54, 'Authority to Travel', 49, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(55, 'Itinerary of Travel (2 copies)', 49, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(56, 'Copy of/or clippings from a newspaper re: Exchange Rate on the date of actual travel', 49, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(57, 'Liquidation Report', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(58, 'Actual Itinerary of Travel/Copy of Approved Itinerary of Travel', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(59, 'Certificate of Travel Completion', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(60, 'Official Receipts (OR), Toll Tickets, if applicable (original and xerox if tape or fax paper)', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(61, 'Copy of e-Ticket, Boarding Pass and Terminal Fee Ticket (when applicable)', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(62, 'Certificate of Attendance/Participation or Equivalent', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(63, 'Waiver of Claim for Travelling Expenses (for non-PCARRD but government employee)', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(64, 'If claiming actual expenses—Certification that Actual Travel Expenses were Incurred in the Performance of the Assignment, duly signed by the Executive Director', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(65, 'Copy of Previous DV and IT for Cash Advance', 48, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(66, 'Request for Reloading', 11, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(67, 'Statement of Utilization & Balances', 11, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(68, 'Statement of Account', 26, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(69, 'Copy of e-Ticket', 26, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(70, 'Boarding Pass', 26, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(71, 'Job Contract (for first payment)', 43, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(72, 'Statement of Account', 43, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(73, 'Copy of Trip Tickets', 43, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(74, 'Copy of Contract (for first payment)', 27, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(75, 'Daily Time Record (DTR)', 27, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(76, 'Copy of Supplementary/Amended Contract', 24, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(77, 'Daily Time Record (DTR)', 24, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(78, 'Bill', 8, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(79, 'Statement of Postage Usage and Balances', 7, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(80, 'Official Receipt (OR)', 9, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(81, 'Approved Request for Mailing', 9, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(82, 'Official Receipt (OR)', 10, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(83, 'Approved Request for the Availment (for initial claim)', 10, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(84, 'Copy of Contract', 19, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(85, 'Statement of Account', 19, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(86, 'Certification of Services Rendered for the Period', 19, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(87, 'Copy of Performance Bond', 19, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(88, 'Statement of Account', 20, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(89, 'Certification of Services Rendered for the Period', 20, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(90, 'Copy of Contract', 39, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(91, 'Statement of Account', 39, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(92, 'Certification of Services Rendered for the Period', 39, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(93, 'Copy of Performance Bond', 39, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(94, 'Statement of Account', 40, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(95, 'Certification of Services Rendered for the Period', 40, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(96, 'Invoice', 28, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(97, 'Inspection and Acceptance Report (IAR)', 28, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(98, 'Contract or Letter Order', 28, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(99, 'Job Request for Printing', 28, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(100, 'Canvasses & Abstract of Canvasses', 28, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(101, 'Performance Bond, if applicable', 28, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(102, 'Invoice/Statement of Account', 13, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(103, 'Inspection and Acceptance Report (IAR)', 13, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(104, 'Attendance Sheet', 13, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(105, 'Job Request for Food Services', 13, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(106, 'Certification for Emergency Purchase', 13, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(107, 'Approved Request for Holding the Activity (for seminars, workshops, and similar activities)', 13, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(108, 'Canvasses & Abstract of Canvasses (if other than PMPC)', 13, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(109, 'Official Receipt (OR)', 14, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(110, 'Inspection and Acceptance Report (IAR)', 14, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(111, 'Attendance Sheet', 14, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(112, 'Certification for Emergency Purchase', 14, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(113, 'Job Request for Food Services', 14, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(114, 'Approved Request for Holding the Activity (for seminars, workshops, and similar activities)', 14, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(115, 'Canvasses & Abstract of Canvasses (if other than PMPC)', 14, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(116, 'Invoice', 23, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(117, 'Contract', 23, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(118, 'Approved Request for Holding the Activity', 23, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(119, 'Canvasses/Abstract of Canvasses', 23, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(120, 'Attendance Sheet', 23, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(121, 'Invoice', 22, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(122, 'Inspection and Acceptance Report (IAR)', 22, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(123, 'Certification for Emergency Purchase', 22, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(124, 'Purchase Request', 22, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(125, 'Approved Request (for initial payment)', 22, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(126, 'Official Receipt (OR)', 6, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(127, 'Inspection and Acceptance Report (IAR)', 6, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(128, 'Job Request', 6, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(129, 'Certificate of Emergency', 6, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(130, 'Copy of Newspaper Clippings', 6, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(131, 'Canvasses & Abstract of Canvasses', 6, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(132, 'Bill (if payment to LTO)', 29, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(133, 'Official Receipt (OR), if for reimbursement', 29, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(134, 'Bill', 18, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(135, 'Copy of Notice of Renewal', 18, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(136, 'List of Bonded Officials', 17, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(137, 'Invoice', 25, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(138, 'Inspection and Acceptance Report (IAR)', 25, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(139, 'ARE/ICS, whichever is applicable', 25, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(140, 'Purchase Order (PO)', 25, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(141, 'Purchase Request/Copy of Approved DPPMP', 25, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(142, 'Canvasses & Abstract of Canvasses or Certificate of Exclusive Distributorship', 25, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(143, 'Waste Material Report, if applicable', 25, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(144, 'Official Receipt (OR)', 32, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(145, 'Inspection and Acceptance Report (IAR)', 32, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(146, 'Certification for Emergency Purchase', 32, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(147, 'Purchase Request', 32, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(148, 'Job Request, if applicable', 32, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(149, 'Canvasses & Abstract of Canvasses', 32, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(150, 'Invoice', 34, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(151, 'Inspection and Acceptance Report (IAR)', 34, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(152, 'Waste Material Report, if applicable', 34, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(153, 'Job Contract', 34, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(154, 'Job Request', 34, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(155, 'Canvasses & Abstract of Canvasses', 34, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(156, 'Official Receipt (OR)/Cash Invoice', 31, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(157, 'Inspection and Acceptance Report (IAR)', 31, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(158, 'Waste Material Report, if applicable', 31, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(159, 'Job Request', 31, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(160, 'Canvasses & Abstract of Canvasses', 31, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(161, 'Certification for Emergency Purchase', 31, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(162, 'Maintenance Agreement (for first payment)', 21, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(163, 'Invoice/Statement of Account', 21, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(164, 'Inspection and Acceptance Report (IAR)', 21, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(165, 'Canvasses/Abstract of Canvasses', 21, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(166, 'Waste Material Report, if applicable', 21, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(167, 'Official Receipt (OR)/Cash Invoice', 30, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(168, 'Inspection and Acceptance Report (IAR)', 30, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(169, 'Waste Material Report, if applicable', 30, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(170, 'Job Request', 30, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(171, 'Canvasses & Abstract of Canvasses', 30, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(172, 'Certification for Emergency Purchase', 30, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(173, 'Capsule Proposal', 15, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(174, 'Budget Breakdown', 15, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(175, 'Approval of Project Proposal', 15, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(176, 'Financial Report', 16, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(177, 'Budget Breakdown', 16, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(178, 'Approved Request to Attend/Participate', 42, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(179, 'Copy of Invitation/Announcement', 42, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(180, 'Certificate of Attendance (to be submitted to Cash Section after the attendance)', 42, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(181, 'Official Receipt (OR)', 41, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(182, 'Approved Request to Attend/Participate', 41, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(183, 'Copy of Invitation/Announcement', 41, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(184, 'Copy of Certificate of Attendance/Participation', 41, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(185, 'Approved Request for Thesis Support', 37, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(186, 'List of Scholars Certified by IDD', 35, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(187, 'Statement of Account from the School', 38, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(188, 'Itinerary of Travel', 36, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(189, 'Official Receipt (OR)/Tickets', 36, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(190, 'Approved Request', 12, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(191, 'Bill/Statement of Account', 51, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(192, 'Official Receipt (OR)/Cash Invoice', 33, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(193, 'Inspection and Acceptance Report (IAR)', 33, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(194, 'Job Request', 33, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(195, 'Canvasses & Abstract of Canvasses', 33, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(196, 'Certification for Emergency Purchase', 33, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(197, 'Contract', 3, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(198, 'Invoice/Request for Payment', 3, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(199, 'Inspection Report', 3, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(200, 'Accomplishment Report', 3, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(201, 'Notice to Proceed (NTP)', 3, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(202, 'Performance Bond', 3, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(203, 'Invoice/Statement of Account', 5, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(204, 'Progress Accomplishment Report', 5, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(205, 'Inspection Report', 5, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(206, 'Invoice/Statement of Account', 1, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(207, 'Inspection Report', 1, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(208, 'Progress Accomplishment Report', 1, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(209, 'Certificate of Completion and Final Acceptance', 1, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(210, 'Certificate of Turn-Over', 1, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(211, 'Contractor’s Affidavit on Payment of Laborers and Materials', 1, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(212, 'Surety/Guaranty Bond', 1, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(213, 'Approved Change/Extra Work Order', 2, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(214, 'Additional Performance Bond', 2, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(215, 'Certification from the Project Engineer/Property Officer to the Effect that the work has been completed & accepted without any defect and recommended for release', 4, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(216, 'Letter from the Contractor Requesting the Release of the 10% Retention', 4, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(217, 'Surety Bond', 4, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(218, 'For Salaries/Benefits—Payroll Register', 52, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(219, 'Expenses for Workshops/Seminars/Trainings', 52, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(220, 'For Cell Card', 52, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(221, 'Report of Disbursements', 61, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(222, 'Liquidation Report with the Summary of Disbursements & Supporting Documents', 60, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(223, 'Report of Disbursements', 60, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(224, 'Liquidation Report', 59, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(225, 'Report of Utilization', 59, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(226, 'For Initial Cash Advance—Approved Request', 53, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(227, 'Copy of Designation as Disbursing Officer', 53, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(228, 'Report of Disbursements', 67, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(229, 'Petty Cash Replenishment Report', 68, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(230, 'Petty Cash Vouchers with Supporting Documents', 68, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(231, 'Schedule of Remittances', 66, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(232, 'Certification for the Delivery/Completion of the Project and Recommendation for the Release by the Project-in-charge/Property Officer', 65, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(233, 'Copy of Official Receipt (OR) for the Deposit Made', 65, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(234, 'Approved Recommendation', 56, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(235, 'BAC Resolution', 55, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(236, 'Notice of Award (NOA)', 55, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(237, 'Job Request, if applicable', 55, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(238, 'Job Request, if applicable', 54, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(239, 'Canvasses & Abstract of Canvasses', 54, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(240, 'BAC Resolution', 64, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(241, 'Notice of Award (NOA)', 64, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(242, 'Stock Position Sheet for Expendable Items Worth P1,000.00 and Above', 62, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(243, 'Purchase Request, if applicable', 63, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(244, 'Stock Position Sheet for Expendable Items Worth P1,000.00 and Above', 63, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(245, 'Canvasses & Abstract of Canvasses', 63, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(246, 'BAC Resolution', 58, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(247, 'Notice of Award (NOA)', 58, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(248, 'Job Request', 58, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(249, 'Job Request', 57, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(250, 'Canvasses & Abstract of Canvasses', 57, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(251, 'One Exit Report for Short-Term Engagement of Fifteen (15) Days to One Month', 78, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(252, 'Monthly Report for Short-Term Engagement of More than One Month up to Six Months of Engagement, and for Medium-Term Engagement', 78, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(253, 'Local Bank Accounts or International Bank Accounts with SWIFT/BAN Number (ready for wire transfer transactions)', 78, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(254, 'Transmittal Letter of Submitted Contract with Supporting Documents to COA (with stamped received by COA)', 78, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(255, 'Billing Statement', 79, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(256, 'Letter of Authority from Insurance', 79, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(257, 'Police Report', 79, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(258, 'Obligation Request and Status (ORS)', 80, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(259, 'Certificate of Availability of Funds (CAF)', 80, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(260, 'Approved and Notarized MOA/Trust Agreement (original)', 80, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(261, 'DOST-Approved Line-Item Budget (Original/Certified True Copy)', 80, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(262, 'Work Plan/Proposal', 80, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(263, 'Approval Letter by the Directors’ Council (DC)/Executive Committee (EXECOM)', 80, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(264, 'Obligation Request and Status (ORS)/Copy of the ORS, if already obligated', 81, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(265, 'Work Plan/Proposal', 81, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(266, 'DOST-Approved Line-Item Budget (LIB) for Succeeding Year', 81, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(267, 'Approved Conforme Letter (for succeeding implementation years)', 81, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(268, 'Financial Reports and Other Supporting Documents', 81, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(269, 'Certification from the Accountant that funds previously transferred to the implementing agency (IA) has been liquidated', 81, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(270, 'Certificate of Registration from Securities and Exchange Commission (SEC), Cooperative Development Authority (CDA), or Department of Labor and Employment, as the case may be', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(271, 'Authenticated Copy of the Latest Articles of Incorporation or Articles of Cooperation, as the case may be, showing the Original Incorporators/Organizers and the Secretary’s Certificate for Incumbent Officers, together with the Certificate for Filing with the SEC/Certificate of Approval by the CDA', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(272, 'Audited Financial Reports for the past 3 years preceding the date of project implementation; for NGO/PO, which has been in operation for less than 3 years, financial reports for the past years in operation and proof of previous implementation of similar projects', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(273, 'Disclosure of Other Related Business, if any', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(274, 'Work and Financial Plan (WFP), and Sources and Details of Proponent’s Equity Participation in the Project', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(275, 'Complete Project Proposal, approved and signed by the officers', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(276, 'List of Photographs and/or Similar Projects Previously Completed, if any, indicating the source of funds for Implementation', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(277, 'Sworn Affidavit of the Secretary of the NGO/PO that none of its incorporators, organizers, directors or officers is an agent of or related by consanguinity or affinity up to the fourth (4th) civil degree to the official of the agency authorized to process and/or approved proposed MOA, and release funds.', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(278, 'Document showing that NGO/PO has equity equivalent to 20% of the total project cost, which shall be in the form of labor, land for the project site, facilities, equipment and the like, to be used in the project.', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(279, 'Certification from the Accountant that funds previously transferred to the implementing agency (IA) has been liquidated', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(280, 'Memorandum of Agreement (MOA)', 82, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(281, 'Obligation Request and Status (ORS)/Copy of the ORS, if already obligated', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(282, 'Duly Approved Schedule of Release to NGO/PO', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(283, 'Interim Fund Utilization Report on the Previous Release, certified by the NGO/PO’s Accountant, approved by its President/Chairman', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(284, 'Approved Memorandum of Agreement (MOA)', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(285, 'PCAARRD-Approved Line-Item Budget (LIB) for succeeding year', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(286, 'Work Plan/Proposal', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(287, 'Approval Letter by the Directors’ Council (DC)/Executive Committee (EXECOM)', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(288, 'Financial Reports and Other Supporting Documents for prior year’s releases', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(289, 'Certification from the Accountant that funds previously transferred to the implementing agency (IA) has been liquidated', 83, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(290, 'Obligation Request and Status (ORS)', 84, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(291, 'Certificate of Availability of Funds (CAF)', 84, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(292, 'Approved and Notarized MOA/Trust Agreement (original)', 84, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(293, 'DOST-Approved Line-Item Budget (LIB) (original/certified true copy)', 84, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(294, 'Work Plan/Proposal', 84, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(295, 'Approval Letter by the Directors’ Council (DC)/Executive Committee (EXECOM)', 84, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(296, 'Certification/Accreditation from the Commission on Higher Education (CHED)', 84, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(297, 'Obligation Request and Status (ORS)/Copy of the ORS, if already obligated', 85, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(298, 'Copy of Approved MOA/Trust Agreement', 85, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(299, 'Work Plan/Proposal', 85, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(300, 'PCAARRD-Approved Line-Item Budget (LIB) for succeeding year', 85, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(301, 'Approved Conforme Letter (for succeeding implementation years)', 85, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(302, 'Financial Reports and Other Supporting Documents', 85, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(303, 'Certification from the Accountant that funds previously transferred to the implementing agency (IA) has been liquidated', 85, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(304, 'Inspection and Acceptance Report (IAR)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(305, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(306, 'Warranty Security for a minimum period of 3 months, in case of expendable supplies, or a minimum period of one year in case of non—expendable supplies, after acceptance', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(307, 'ORS/BURS', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(308, 'Original Sales Invoice/Billing Statement/Statement of Account', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(309, 'Contract Agreement', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(310, 'Notice to Proceed (NTP)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(311, 'Notice of Award (NOA)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(312, 'BAC Resolution', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(313, 'Abstract of Bids', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(314, 'Bid Evaluation Report', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(315, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(316, 'Ranking of Short-listed Bidders for Consulting Services', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(317, 'Post Qualification Evaluation Report', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(318, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(319, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(320, 'Legal Documents—SEC/DTI/CDA', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(321, 'Legal Documents—Mayor’s/Business Permit', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(322, 'Legal Documents—Tax Clearance', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(323, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(324, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(325, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(326, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(327, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(328, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(329, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(330, 'PhilGeps Certificate of Registration and Membership', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(331, 'Joint Venture Agreement (JVA), if applicable', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(332, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(333, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(334, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(335, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(336, 'Bids Security', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(337, 'Performance Security', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(338, 'Omnibus Sworn Statement', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(339, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(340, 'Pictures of Program/Project/Activity, if applicable', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(341, 'Purchase Request', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(342, 'Waste Material Report, if applicable', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(343, 'Original Delivery Receipt, if applicable', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(344, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 86, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(345, 'Request for Payment from Service Provider', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(346, 'Contractor’s Bill', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(347, 'Certificate of Service Acceptance', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(348, 'Accomplishment Report', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(349, 'Record of Attendance/Service, if applicable', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(350, 'Proof of Remittance (to BIR/SSS/Pagibig), if applicable', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(351, 'ORS/BURS', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(352, 'Original Sales Invoice/Billing Statement/Statement of Account', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(353, 'Contract Agreement', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(354, 'Notice to Proceed (NTP)', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(355, 'Notice of Award (NOA)', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(356, 'BAC Resolution', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(357, 'Abstract of Bids', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(358, 'Bid Evaluation Report', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(359, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(360, 'Ranking of Short-listed Bidders for Consulting Services', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(361, 'Post Qualification Evaluation Report', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(362, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(363, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(364, 'Legal Documents—SEC/DTI/CDA', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(365, 'Legal Documents—Mayor’s/Business Permit', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(366, 'Legal Documents—Tax Clearance', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(367, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(368, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(369, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(370, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(371, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(372, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(373, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(374, 'PhilGeps Certificate of Registration and Membership', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(375, 'Joint Venture Agreement (JVA), if applicable', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(376, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(377, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 87, 1, 0, '2023-07-10 05:48:40', '2023-07-10 05:48:40'),
(378, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(379, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(380, 'Bids Security', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(381, 'Performance Security', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(382, 'Omnibus Sworn Statement', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(383, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(384, 'Pictures of Program/Project/Activity, if applicable', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(385, 'Purchase Request', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(386, 'Waste Material Report, if applicable', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(387, 'Original Delivery Receipt, if applicable', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(388, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 87, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(389, 'Letter Request from Contractor for the Payment of Progress/Final Billing', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(390, 'Statement of Work Accomplished/Progress Billing', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(391, 'Inspection Report by PCAARRD’s authorized engineer', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(392, 'Results of Test Analysis, if applicable', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(393, 'Statement of Time Elapsed', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(394, 'Monthly Certificate of Payment', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(395, 'Contractor’s Affidavit on Payment of Laborers and Materials', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(396, 'Pictures of Before, During, and After Construction of Items of Work especially the embedded items', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(397, 'Photocopy of Vouchers of All Previous Payments', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(398, 'Certificate of Completion', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(399, 'Certificate of Turn-Over (final payment)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(400, 'As-built Plans (final payment)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(401, 'Warranty Security (final payment)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(402, 'ORS/BURS', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(403, 'Original Sales Invoice/Billing Statement/Statement of Account', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(404, 'Contract Agreement', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(405, 'Notice to Proceed (NTP)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(406, 'Notice of Award (NOA)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(407, 'BAC Resolution', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(408, 'Abstract of Bids', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(409, 'Bid Evaluation Report', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(410, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(411, 'Ranking of Short-listed Bidders for Consulting Services', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(412, 'Post Qualification Evaluation Report', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(413, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(414, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(415, 'Legal Documents—SEC/DTI/CDA', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(416, 'Legal Documents—Mayor’s/Business Permit', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(417, 'Legal Documents—Tax Clearance', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(418, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(419, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(420, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(421, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(422, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(423, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(424, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(425, 'PhilGeps Certificate of Registration and Membership', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(426, 'Joint Venture Agreement (JVA), if applicable', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(427, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(428, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41');
INSERT INTO `library_dv_document` (`id`, `document`, `dv_transaction_type_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(429, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(430, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(431, 'Bids Security', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(432, 'Performance Security', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(433, 'Omnibus Sworn Statement', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(434, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(435, 'Pictures of Program/Project/Activity, if applicable', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(436, 'Purchase Request', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(437, 'Waste Material Report, if applicable', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(438, 'Original Delivery Receipt, if applicable', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(439, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 88, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(440, 'Approved Change/Extra Work Order', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(441, 'Additional Performance Bond', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(442, 'Letter Request from Contractor for the Payment of Progress/Final Billing', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(443, 'Statement of Work Accomplished/Progress Billing', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(444, 'Inspection Report by PCAARRD’s authorized engineer', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(445, 'Results of Test Analysis, if applicable\n', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(446, 'Statement of Time Elapsed', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(447, 'Monthly Certificate of Payment', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(448, 'Contractor’s Affidavit on Payment of Laborers and Materials', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(449, 'Pictures of Before, During, and After Construction of Items of Work especially the embedded items\n', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(450, 'Photocopy of Vouchers of all previous payments', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(451, 'Certificate of Completion', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(452, 'Certificate of Turn-Over (final payment)\n', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(453, 'As-built Plans (final payment)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(454, 'Warranty Security (final payment)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(455, 'ORS/BURS', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(456, 'Original Sales Invoice/Billing Statement/Statement of Account', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(457, 'Contract Agreement', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(458, 'Notice to Proceed (NTP)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(459, 'Notice of Award (NOA)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(460, 'BAC Resolution', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(461, 'Abstract of Bids', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(462, 'Bid Evaluation Report', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(463, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(464, 'Ranking of Short—listed Bidders for Consulting Services', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(465, 'Post Qualification Evaluation Report', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(466, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(467, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(468, 'Legal Documents—SEC/DTI/CDA', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(469, 'Legal Documents—Mayor’s/Business Permit', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(470, 'Legal Documents—Tax Clearance', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(471, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(472, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(473, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(474, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(475, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(476, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(477, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(478, 'PhilGeps Certificate of Registration and Membership', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(479, 'Joint Venture Agreement (JVA), if applicable', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(480, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(481, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(482, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(483, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(484, 'Bids Security', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(485, 'Performance Security', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(486, 'Omnibus Sworn Statement', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(487, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(488, 'Pictures of Program/Project/Activity, if applicable', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(489, 'Purchase Request', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(490, 'Waste Material Report, if applicable', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(491, 'Original Delivery Receipt, if applicable', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(492, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 89, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(493, 'Letter Request from Contractors for Advance Payment', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(494, 'Irrevocable Standby Letter of Credit/Security Bond/Bank Guarantee', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(495, 'ORS/BURS', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(496, 'Original Sales Invoice/Billing Statement/Statement of Account', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(497, 'Contract Agreement', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(498, 'Notice to Proceed (NTP)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(499, 'Notice of Award (NOA)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(500, 'BAC Resolution', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(501, 'Abstract of Bids', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(502, 'Bid Evaluation Report', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(503, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(504, 'Ranking of Short—listed Bidders for Consulting Services', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(505, 'Post Qualification Evaluation Report', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(506, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(507, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(508, 'Legal Documents—SEC/DTI/CDA', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(509, 'Legal Documents—Mayor’s/Business Permit', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(510, 'Legal Documents—Tax Clearance', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(511, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(512, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(513, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(514, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(515, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(516, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(517, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(518, 'PhilGeps Certificate of Registration and Membership', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(519, 'Joint Venture Agreement (JVA), if applicable', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(520, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(521, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(522, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(523, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(524, 'Bids Security', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(525, 'Performance Security', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(526, 'Omnibus Sworn Statement', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(527, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(528, 'Pictures of Program/Project/Activity, if applicable', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(529, 'Purchase Request', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(530, 'Waste Material Report, if applicable', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(531, 'Original Delivery Receipt, if applicable', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(532, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 90, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(533, 'Any security in the form of cash, Bank Guarantee, Irrevocable Standby Letter of Credit from commercial bank, GSIS or Surety Bond Callable on Demand', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(534, 'Certificate of Completion and Final Acceptance', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(535, 'Inspection Report by PCAARRD’s Authorized Engineer', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(536, 'ORS/BURS', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(537, 'Original Sales Invoice/Billing Statement/Statement of Account', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(538, 'Contract Agreement', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(539, 'Notice to Proceed (NTP)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(540, 'Notice of Award (NOA)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(541, 'BAC Resolution', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(542, 'Abstract of Bids', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(543, 'Bid Evaluation Report', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(544, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(545, 'Ranking of Short—listed Bidders for Consulting Services', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(546, 'Post Qualification Evaluation Report', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(547, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(548, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(549, 'Legal Documents—SEC/DTI/CDA', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(550, 'Legal Documents—Mayor’s/Business Permit', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(551, 'Legal Documents—Tax Clearance', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(552, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(553, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(554, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(555, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(556, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(557, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(558, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(559, 'PhilGeps Certificate of Registration and Membership', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(560, 'Joint Venture Agreement (JVA), if applicable', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(561, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(562, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(563, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(564, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(565, 'Bids Security', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(566, 'Performance Security', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(567, 'Omnibus Sworn Statement', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(568, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(569, 'Pictures of Program/Project/Activity, if applicable', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(570, 'Purchase Request', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(571, 'Waste Material Report, if applicable', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(572, 'Original Delivery Receipt, if applicable', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(573, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 91, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(574, 'Request for Payment from Service Provider', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(575, 'Terms of Reference (TOR) or Approved Documents indicating the Expected Output/Deliverables', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(576, 'Copy of Approved Manning Schedule indicating the names and positions of the consultants and staff and the extent of their participation in the project', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(577, 'Copy of Curriculum Vitae of consultants and staff', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(578, 'Approved Consultancy Progress/Final Report and/or Output required under the Contract', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(579, 'Progress/Final Billing', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(580, 'ORS/BURS', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(581, 'Original Sales Invoice/Billing Statement/Statement of Account', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(582, 'Contract Agreement', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(583, 'Notice to Proceed (NTP)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(584, 'Notice of Award (NOA)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(585, 'BAC Resolution', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(586, 'Abstract of Bids', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(587, 'Bid Evaluation Report', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(588, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(589, 'Ranking of Short—listed Bidders for Consulting Services', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(590, 'Post Qualification Evaluation Report', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(591, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(592, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(593, 'Legal Documents—SEC/DTI/CDA', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(594, 'Legal Documents—Mayor’s/Business Permit', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(595, 'Legal Documents—Tax Clearance', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(596, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(597, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(598, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(599, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(600, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(601, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(602, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(603, 'PhilGeps Certificate of Registration and Membership', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(604, 'Joint Venture Agreement (JVA), if applicable', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(605, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(606, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(607, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(608, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(609, 'Bids Security', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(610, 'Performance Security', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(611, 'Omnibus Sworn Statement', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(612, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(613, 'Pictures of Program/Project/Activity, if applicable', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(614, 'Purchase Request', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(615, 'Waste Material Report, if applicable', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(616, 'Original Delivery Receipt, if applicable', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(617, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 92, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(618, 'Request for Payment from Service Provider', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(619, 'Pre- and Post-Inspection and Acceptance Report', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(620, 'Warranty Certificate (of vehicle), if applicable', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(621, 'ORS/BURS', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(622, 'Original Sales Invoice/Billing Statement/Statement of Account', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(623, 'Contract Agreement', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(624, 'Notice to Proceed (NTP)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(625, 'Notice of Award (NOA)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(626, 'BAC Resolution', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(627, 'Abstract of Bids', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(628, 'Bid Evaluation Report', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(629, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(630, 'Ranking of Short-listed Bidders for Consulting Services', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(631, 'Post Qualification Evaluation Report', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(632, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(633, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(634, 'Legal Documents—SEC/DTI/CDA', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(635, 'Legal Documents—Mayor’s/Business Permit', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(636, 'Legal Documents—Tax Clearance', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(637, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(638, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(639, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(640, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(641, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(642, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(643, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(644, 'PhilGeps Certificate of Registration and Membership', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(645, 'Joint Venture Agreement (JVA), if applicable', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(646, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(647, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(648, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(649, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(650, 'Bids Security', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(651, 'Performance Security', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(652, 'Omnibus Sworn Statement', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(653, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(654, 'Pictures of Program/Project/Activity, if applicable', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(655, 'Purchase Request', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(656, 'Waste Material Report, if applicable', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(657, 'Original Delivery Receipt, if applicable', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(658, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 93, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(659, 'Request for Payment from Service Provider', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(660, 'Copy of Newspaper Clippings Evidencing Publication and/or CD in case of TV/Radio Commercial\n', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(661, 'ORS/BURS', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(662, 'Original Sales Invoice/Billing Statement/Statement of Account', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(663, 'Contract Agreement', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(664, 'Notice to Proceed (NTP)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(665, 'Notice of Award (NOA)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(666, 'BAC Resolution', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(667, 'Abstract of Bids', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(668, 'Bid Evaluation Report', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(669, 'Minutes of Pre-procurement Conference (for Approved Budget for the Contract (ABC) above Php 5M for infrastructure, Php 2M and above for goods, and Php 1M and above for consulting services)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(670, 'Ranking of Short—listed Bidders for Consulting Services', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(671, 'Post Qualification Evaluation Report', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(672, 'Evidence of Invitation of Three (3) Observers in all stages of the procurement process', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(673, 'Copy of Advertisement of Invitation to Bid/Request for Expression of Interest', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(674, 'Legal Documents—SEC/DTI/CDA', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(675, 'Legal Documents—Mayor’s/Business Permit', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(676, 'Legal Documents—Tax Clearance', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(677, 'Legal Documents—BIR Certificate of Registration (for withholding tax purposes on the first payment of the new supplier/payee)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(678, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(679, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(680, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(681, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(682, 'Financial Documents—Latest Audited Financial Statements stamped received by BIR', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(683, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(684, 'PhilGeps Certificate of Registration and Membership', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(685, 'Joint Venture Agreement (JVA), if applicable', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(686, 'Technical Specifications (production/delivery schedule, manpower requirements, after sales service/parts for procurement of goods, and workplan and schedules for consulting services)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(687, 'Project Requirements—Organizational Chart for the Contract to be Bid (for infrastructure works and consulting services)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(688, 'Project Requirements—List of Contractor’s Personnel to be assigned to the Contract to be Bid, with complete data on their qualifications and experience (for infrastructure works and consulting services)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(689, 'Project Requirements—List of Contractor’s Major Equipment Units, which are owned, leased and/or under purchase agreement, supported by Proof of Ownership or Certification of Availability of Equipment from equipment lessor/vendor for the duration of the project, as the case may be (for infrastructure works)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(690, 'Bids Security', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(691, 'Performance Security', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(692, 'Omnibus Sworn Statement', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(693, 'Printout copy of posting Notice of Award (NOA), Notice to Proceed (NTP), and Contract of Award in the PhilGEPS', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(694, 'Pictures of Program/Project/Activity, if applicable', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(695, 'Purchase Request', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(696, 'Waste Material Report, if applicable', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(697, 'Original Delivery Receipt, if applicable', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(698, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 94, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(699, 'Bid Security', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(700, 'Legal Documents—Securities and Exchange Commission (SEC)/ Department of Trade and Industry (DTI)/ Cooperative Development Authority (CDA)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(701, 'Legal Documents—Mayor’s/Business Permit', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(702, 'Legal Documents—Tax Clearance', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(703, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(704, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(705, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(706, 'Technical Documents—Additional documents for consulting services', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(707, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(708, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(709, 'Financial Documents—Latest Audited Financial Statements stamped received by the Bureau of Internal Revenue (BIR)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(710, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(711, 'Notice of Award (NOA)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(712, 'Abstract of Bids', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(713, 'Copy of Direct Invitation to Bid (Pre-selected manufacturers/suppliers/distributors with known experience and proven capability on the requirements of the particular contract)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(714, 'Price Quotations/Offers/Proposals', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(715, 'Performance Security', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(716, 'Warranty Security (required for highly specialized goods)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(717, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(718, 'Original Sales Invoice/Billing Statement/Statement of Account', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(719, 'Purchase Order (for goods)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(720, 'Job Contract (for services)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(721, 'Inspection and Acceptance Report (for goods)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(722, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(723, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(724, 'Waste Material Report, if applicable', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(725, 'Original Delivery Receipt, if applicable', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(726, 'Pictures of Program/Project/Activity, if applicable', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(727, 'Purchase Request', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(728, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(729, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(730, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(731, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(732, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 95, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(733, 'Copy of Letter to Selected Manufacturer/Supplier/Distributor to submit a price quotation and condition of sale', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(734, 'Certificate of Exclusive Distributorship', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(735, 'Certification from the Agency Authorized Official that there are no sub—dealers selling at lower prices and for which no suitable substitute can be obtained at more advantageous terms to the government', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(736, 'Certification from the Bids and Awards Committee (BAC) in case of procurement of critical plant components and/or maintain certain standards', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(737, 'Study/Survey done to determine that there are no sub—dealers selling at lower prices and for which no suitable substitute can be obtained at more advantageous terms to the government.', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(738, 'Warranty Security', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(739, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(740, 'Original Sales Invoice/Billing Statement/Statement of Account', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(741, 'Purchase Order (for goods)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(742, 'Job Contract (for services)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(743, 'Inspection and Acceptance Report (for goods)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(744, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(745, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(746, 'Waste Material Report, if applicable', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(747, 'Original Delivery Receipt, if applicable', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(748, 'Pictures of Program/Project/Activity, if applicable', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(749, 'Purchase Request', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(750, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(751, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(752, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(753, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(754, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 96, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(755, 'Copy of Original Contract used as basis for repeat order indicating that the original contract was awarded through public bidding', 97, 1, 0, '2023-07-10 05:48:41', '2023-07-10 05:48:41'),
(756, 'Certification from the Purchasing Department/Office that the supplier has complied with all the requirements under the original contract', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(757, 'Warranty Security', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(758, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(759, 'Original Sales Invoice/Billing Statement/Statement of Account', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(760, 'Purchase Order (for goods)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(761, 'Job Contract (for services)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(762, 'Inspection and Acceptance Report (for goods)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(763, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(764, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(765, 'Waste Material Report, if applicable', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(766, 'Original Delivery Receipt, if applicable', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(767, 'Pictures of Program/Project/Activity, if applicable', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(768, 'Purchase Request', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(769, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(770, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(771, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(772, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(773, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 97, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(774, 'Price Quotations from at least three (3) bona fide and reputable manufacturers/suppliers/distributors', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(775, 'Abstract of Canvass', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(776, 'Justification of the Unforeseen Contingency Requiring Immediate Purchase approved by the Head of Procuring Entity (HoPE)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(777, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(778, 'Original Sales Invoice/Billing Statement/Statement of Account', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(779, 'Purchase Order (for goods)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(780, 'Job Contract (for services)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(781, 'Inspection and Acceptance Report (for goods)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42');
INSERT INTO `library_dv_document` (`id`, `document`, `dv_transaction_type_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(782, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(783, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(784, 'Waste Material Report, if applicable', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(785, 'Original Delivery Receipt, if applicable', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(786, 'Pictures of Program/Project/Activity, if applicable', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(787, 'Purchase Request', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(788, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(789, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(790, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(791, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(792, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 98, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(793, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(794, 'Abstract of Price Quotation', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(795, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(796, 'Agency’s Offer for Negotiation with selected suppliers, contractors, or consultants', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(797, 'Bids and Awards Committee (BAC) Certification on the failure of competitive bidding for the second time', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(798, 'Evidence of Invitation of Observers in all stages of the negotiation', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(799, 'Performance Security', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(800, 'Warranty Security (for goods and infrastructure projects)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(801, 'Mayor’s/Business Permit (in case of infrastructure projects)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(802, 'Tax Clearance (in case of infrastructure projects)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(803, 'Philippine Contractors Accreditation Board (PCAB) License and Registration, in case of infrastructure projects Latest Audited Financial Statements (in case of infrastructure projects)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(804, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(805, 'Original Sales Invoice/Billing Statement/Statement of Account', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(806, 'Purchase Order (for goods)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(807, 'Job Contract (for services)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(808, 'Inspection and Acceptance Report (for goods)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(809, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(810, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(811, 'Waste Material Report, if applicable', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(812, 'Original Delivery Receipt, if applicable', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(813, 'Pictures of Program/Project/Activity, if applicable', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(814, 'Purchase Request', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(815, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(816, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(817, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(818, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(819, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 99, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(820, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(821, 'Abstract of Price Quotation', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(822, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(823, 'Justification as to the Necessity of Purchase', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(824, 'Performance Security (depends on the nature of the project but required for infrastructure projects)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(825, 'Warranty Security (depends on the nature of the project but not required for consulting services)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(826, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(827, 'Original Sales Invoice/Billing Statement/Statement of Account', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(828, 'Purchase Order (for goods)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(829, 'Job Contract (for services)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(830, 'Inspection and Acceptance Report (for goods)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(831, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(832, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(833, 'Waste Material Report, if applicable', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(834, 'Original Delivery Receipt, if applicable', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(835, 'Pictures of Program/Project/Activity, if applicable', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(836, 'Purchase Request', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(837, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(838, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(839, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(840, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(841, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 100, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(842, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(843, 'Abstract of Price Quotation', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(844, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(845, 'Copy of Terminated Contract', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(846, 'Reasons for the Termination', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(847, 'Negotiation Documents with the Second Lowest Calculated Bidder, or the Third Lowest Calculated Bidder in case of failure of negotiation with the second lowest bidder; If the negotiation still fails, invitation to at least three (3) eligible contractors', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(848, 'Approval by the Head of Procuring Entity (HoPE) to negotiate contracts of projects under exceptional cases', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(849, 'Performance Security', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(850, 'Warranty Security', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(851, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(852, 'Original Sales Invoice/Billing Statement/Statement of Account', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(853, 'Purchase Order (for goods)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(854, 'Job Contract (for services)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(855, 'Inspection and Acceptance Report (for goods)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(856, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(857, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(858, 'Waste Material Report, if applicable', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(859, 'Original Delivery Receipt, if applicable', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(860, 'Pictures of Program/Project/Activity, if applicable', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(861, 'Purchase Request', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(862, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(863, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(864, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(865, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(866, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 101, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(867, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(868, 'Abstract of Price Quotation', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(869, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(870, 'Letter/Invitation to Submit Proposals', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(871, 'Performance Security (depends on the nature of the project but required for infrastructure projects)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(872, 'Warranty Security (depends on the nature of the project but not required for consulting services)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(873, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(874, 'Original Sales Invoice/Billing Statement/Statement of Account', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(875, 'Purchase Order (for goods)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(876, 'Job Contract (for services)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(877, 'Inspection and Acceptance Report (for goods)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(878, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(879, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(880, 'Waste Material Report, if applicable', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(881, 'Original Delivery Receipt, if applicable', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(882, 'Pictures of Program/Project/Activity, if applicable', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(883, 'Purchase Request', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(884, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(885, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(886, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(887, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(888, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 102, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(889, 'Original Contract', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(890, 'Scope of Work (related or similar to the original contract)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(891, 'Latest Accomplishment Report of the original contract showing that there was no negative slippage/delay', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(892, 'Performance Security', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(893, 'Warranty Security (required for infrastructure project)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(894, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(895, 'Original Sales Invoice/Billing Statement/Statement of Account', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(896, 'Purchase Order (for goods)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(897, 'Job Contract (for services)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(898, 'Inspection and Acceptance Report (for goods)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(899, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(900, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(901, 'Waste Material Report, if applicable', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(902, 'Original Delivery Receipt, if applicable', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(903, 'Pictures of Program/Project/Activity, if applicable', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(904, 'Purchase Request', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(905, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(906, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(907, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(908, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(909, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 103, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(910, 'Justification for the Need to Procure through this negotiated modality', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(911, 'Market Study done to determine the probable sources and confirm that the supplier, contractor or consultant could undertake the project at more advantageous terms', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(912, 'Terms of Reference (ToR) or Scope of Work', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(913, 'Bids and Awards Committee (BAC) Resolution recommending award of contract to the Head of Procuring Entity (HoPE)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(914, 'Supplier, contractor or consultant’s Professional License/Curriculum Vitae', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(915, 'Notice of Award (NOA)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(916, 'Contract', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(917, 'Accomplishment/Progress/Final Report and other required output as stipulated in the contract', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(918, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(919, 'Original Sales Invoice/Billing Statement/Statement of Account', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(920, 'Purchase Order (for goods)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(921, 'Job Contract (for services)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(922, 'Inspection and Acceptance Report (for goods)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(923, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(924, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(925, 'Waste Material Report, if applicable', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(926, 'Original Delivery Receipt, if applicable', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(927, 'Pictures of Program/Project/Activity, if applicable', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(928, 'Purchase Request', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(929, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(930, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(931, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(932, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(933, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 104, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(934, 'Justification for the Need to Procure through this negotiated modality', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(935, 'Market Study done to determine the probable sources and confirm that the supplier, contractor or consultant could undertake the project at more advantageous terms', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(936, 'Terms of Reference (ToR)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(937, 'Bids and Awards Committee (BAC) Resolution recommending award of contract to the Head of Procuring Entity (HoPE)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(938, 'Supplier, contractor or consultant’s Professional License/Curriculum Vitae', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(939, 'Notice of Award (NOA)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(940, 'Contract (duration: maximum of 6 months)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(941, 'Accomplishment/Progress/Final Report and other required output as stipulated in the contract', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(942, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(943, 'Original Sales Invoice/Billing Statement/Statement of Account', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(944, 'Purchase Order (for goods)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(945, 'Job Contract (for services)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(946, 'Inspection and Acceptance Report (for goods)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(947, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(948, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(949, 'Waste Material Report, if applicable', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(950, 'Original Delivery Receipt, if applicable', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(951, 'Pictures of Program/Project/Activity, if applicable', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(952, 'Purchase Request', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(953, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(954, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(955, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(956, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(957, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 105, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(958, 'Justification to the Bids and Awards Committee (BAC) that the resort to an Agency—to—Agency Agreement is more efficient and economical to the government', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(959, 'Certification from the Servicing Agency that it complies with all the foregoing conditions', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(960, 'Bids and Awards Committee (BAC) Resolution recommending the use of Agency—to—Agency Agreement to the Head of Procuring Entity (HoPE)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(961, 'Memorandum of Agreement between the Head of Procuring Entity (HoPE) and Servicing Agency', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(962, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(963, 'Original Sales Invoice/Billing Statement/Statement of Account', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(964, 'Purchase Order (for goods)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(965, 'Job Contract (for services)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(966, 'Inspection and Acceptance Report (for goods)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(967, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(968, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(969, 'Waste Material Report, if applicable', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(970, 'Original Delivery Receipt, if applicable', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(971, 'Pictures of Program/Project/Activity, if applicable', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(972, 'Purchase Request', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(973, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(974, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(975, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(976, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(977, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 106, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(978, 'Budget Estimates approved by the Head of Agency', 107, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(979, 'Same requirements under procurement depending on the nature of expense and the mode of procurement adopted', 107, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(980, 'Budget Estimates approved by the Head of Agency', 108, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(981, 'Schedule of Training approved by the Head of Agency', 108, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(982, 'Statement of Account/Bill (Pre-audit)', 109, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(983, 'Invoice/Official Receipt or machine validated Statement of Account/Bill (Post-audit)', 109, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(984, 'Statement of Account/Bill (Pre-audit)', 110, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(985, 'Invoice/Official Receipt or machine validated Statement of Account/Bill (Post-audit)', 110, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(986, 'Certification by Agency Head or his authorized representative that all National Direct Dial (NDD), National Operator Assisted Calls, and International Operator Assisted Calls are official calls', 110, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(987, 'Receipts and/or Other Documents evidencing Disbursement or Certification executed by the Executive Director that the expenses sought to be reimbursed have been incurred', 111, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(988, 'Original Sales Invoice/Billing Statement/Statement of Account', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(989, 'Invitation to Participants/Notice of Meeting', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(990, 'Course Outline/Program of Activities/Agenda', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(991, 'Minutes of Meeting, if applicable', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(992, 'Attendance Sheet with signatures of attendees', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(993, 'Photographs during the event', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(994, 'Approved Request to Conduct the Activity', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(995, 'Inspection and Acceptance Report', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(996, 'Food Request', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(997, 'Project Procurement Management Plan (PPMP)', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(998, 'Other supporting documents depending on the mode of procurement', 112, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(999, 'Original Sales Invoice/Billing Statement/Statement of Account', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1000, 'Invitation to participants/Notice of Meeting', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1001, 'Course Outline/Program of Activities/Agenda', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1002, 'Minutes of Meeting, if applicable', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1003, 'Attendance Sheet with signatures of attendees', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1004, 'Photographs during the event', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1005, 'Approved Request to Conduct the Activity', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1006, 'Inspection and Acceptance Report', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1007, 'Food Request', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1008, 'Project Procurement Management Plan (PPMP)', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1009, 'Other supporting documents depending on the mode of procurement', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1010, 'Pre-attendance with set deadline for withdrawal (to get the number of tentative participants)', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1011, 'In the event of sudden withdrawal of attendance by a participant on the day of the event, a Formal Letter Justifying the Reason of Non-attendance shall be submitted', 113, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1012, 'Original Sales Invoice/Billing Statement/Statement of Account', 114, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1013, 'Copy of Travel Order', 114, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1014, 'Copy of e-Ticket', 114, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1015, 'Copy of Boarding Pass', 114, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1016, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 115, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1017, 'Approved Travel Order (TO)/Authority to Travel (signature of traveling permanent staff not required)', 115, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1018, 'Approved Itinerary of Travel', 115, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1019, 'Promissory Note', 115, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1020, 'Certification from the Accountant that the previous Cash Advance (CA) has been liquidated (to be attached by the Accounting Section)', 115, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1021, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 116, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1022, 'Approved Travel Order (TO)/Authority to Travel of Permanent Staff', 116, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1023, 'Approved Itinerary of Travel of Permanent Staff', 116, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1024, 'Promissory Note of Permanent Staff', 116, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1025, 'Certification from the Accountant that the previous Cash Advance (CA) has been liquidated by the Permanent Staff (to be attached by the Accounting Section)', 116, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1026, 'Approved Travel Order of Contract of Service (COS) Staff\nItinerary of Travel of Contract of Service (COS) Staff', 116, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1027, 'Payroll for Travel Expense signed by both Permanent and Contract of Service (COS) Staff', 116, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1028, 'Liquidation Report', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1029, 'Report of Cash Disbursements', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1030, 'For contract of service (COS) staff, Certification for Travel Expenses Incurred', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1031, 'Paper/Electronic Plane or Bus Tickets, original Boarding Pass, Terminal Fee', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1032, 'Certificate of Appearance/Attendance', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1033, 'Copy of previously approved Itinerary of Travel', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1034, 'Revised or Supplemental Office Order or any proof supporting the Change of Schedule', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1035, 'Revised Itinerary of Travel, if the previous approved itinerary was not followed', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1036, 'Official Receipts (OR)/Acknowledgement Receipts', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1037, 'Reimbursement Expenses Receipts (RER), if applicable', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1038, 'Certification of Expenses not requiring receipts, if applicable (Annex A of AO#286 S. 2022)', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1039, 'If claiming actual expenses, Certification by the Agency Head or Authorized Representative that the travel is absolutely necessary in the performance of the assignment, together with the corresponding Bills and Official Receipts; Affidavit of Loss shall not be considered as replacement to the bills and receipts (Annex C of AO#286 S. 2022)', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1040, 'Certificate of Travel Completed', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1041, 'Waiver of Claim for Travelling Expenses for non-PCAARRD staff but government employee, if applicable', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1042, 'Official Receipt (OR), in case of refund of excess cash advance (CA)', 117, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1043, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1044, 'Approved Travel Order (TO)/Authority to Travel from DOST', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1045, 'Approved Itinerary of Travel', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1046, 'Promissory Note', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1047, 'Forex Rate (BSP website)', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1048, 'Daily Subsistence Allowance (DSA) Rate (ICSC/UN/DFA website)—*DSA will start upon arrival at the country of destination and cease upon departure.', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1049, 'Letter of invitation of Host/Sponsoring Country/Agency/Organization', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1050, 'Acceptance of the Nominees as Participants', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1051, 'Program Agenda and Logistics Information', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1052, 'Certification from the Accountant that the previous cash advance (CA) has been liquidated (to be attached by Accounting Section)', 118, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1053, 'Liquidation Report', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1054, 'Paper/Electronic Plane, Boat, or Bus Tickets, original Boarding Pass, Terminal Fee', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1055, 'Certificate of Appearance/Attendance/Participation', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1056, 'Copy of previously approved Itinerary of Travel', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1057, 'Revised or Supplemental Office Order or any proof supporting the Change of Schedule, if applicable', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1058, 'Revised Itinerary of Travel, if the previous approved itinerary was not followed', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1059, 'If claiming actual Accommodation Expenses, this shall not exceed 30% of accommodation daily subsistence allowance (DSA): There should be a Certification by the Agency Head as absolutely necessary in the performance of the assignment, together with the corresponding Bills and Official Receipts (OR); Affidavit of Loss, however, shall not be considered as replacement to the bills and receipts. This shall be approved by DOST Secretary.', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1060, 'Certificate of Travel Completed', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1061, 'Narrative Report on Trip Undertaken/Report on Participation', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1062, 'Waiver of Claim for Travelling Expenses for non-PCAARRD staff but government employee, if applicable', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1063, 'Official Receipt (OR), in case of refund of excess cash advance (CA)—*Refund of excess CA may be in US$ if allowed by the Department Secretary, or in Php computed at the prevailing bank rate at the day of refund.', 119, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1064, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1065, 'Purchase Order/Job Contract', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1066, 'Approved Request to Conduct the Activity', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1067, 'Administrative Order of the Special Disbursing Officer (SDO), indicating the purpose of cash advance (CA) and maximum accountability (for initial CA and if there are any changes in the scope of their authority)', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1068, 'Confirmation Letter from the Bureau of the Treasury (BTr) for the Application of Bond (for initial cash advance and if there are any changes in the scope of their authority)', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1069, 'Promissory Note', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1070, 'Activity Proposal', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1071, 'Budgetary Requirements', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1072, 'Activity Workplan', 120, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1073, 'Liquidation Report', 121, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1074, 'Report of Cash Disbursements', 121, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1075, 'Official Receipt/s (OR)', 121, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1076, 'Official Receipt (OR), in case of refund of excess cash advance (CA)', 121, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1077, 'Other Documents peculiar to the Contract or Nature of Expense and Mode of Procurement adopted', 121, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1078, 'Obligation Request Status (ORS)', 122, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1079, 'Approved Estimates of Petty Expenses for one month', 122, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1080, 'Administrative Order of the Special Disbursing Officer (SDO), indicating the purpose of cash advance (CA) and maximum accountability (for initial CA and if there’s any changes in the scope of their authority)', 122, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1081, 'Confirmation letter from the Bureau of the Treasury (BTr) for the Application of Bond (for initial cash advance and if there are any changes in the scope of their authority)', 122, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1082, 'Summary of Petty Cash Vouchers', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1083, 'Report of Disbursements', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1084, 'Petty Cash Replenishment Report', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1085, 'Approved PR with Certificate of Emergency Purchase, if necessary', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1086, 'Bills, Receipts, Sales Invoices', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1087, 'Certificate of Inspection and Acceptance', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1088, 'Report of Waste Materials, in case of replacement/repair', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1089, 'Approved Trip Ticket and Toll Receipts, for gasoline and toll expenses', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1090, 'Canvass from at least three (3) suppliers for purchases involving Php 1,000.00 and above, except for purchases made while on official travel', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1091, 'Summary/Abstract of Canvass', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1092, 'Petty Cash Vouchers duly accomplished and signed', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1093, 'Official Receipt (OR), in case of refund', 123, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1094, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1095, 'Approved Travel Order/Authority to Travel (signature of traveling permanent staff not required)', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1096, 'Approved Itinerary of Travel', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1097, 'For contract of service (COS) staff, Certification for Travel Expenses Incurred', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1098, 'Official Receipts, if applicable', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1099, 'Toll Tickets, Paper/Electronic Plane or Bus Tickets, original Boarding Pass, Terminal Fee, if applicable', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1100, 'Certificate of Appearance/Attendance', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1101, 'Reimbursement Expenses Receipts (RER), if applicable', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1102, 'Certification of Expenses not requiring receipts, if applicable (Annex A of AO#286 S. 2022)', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1103, 'Certificate of Travel Completed', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1104, 'Waiver of Claim for Travelling Expenses for non-PCAARRD staff but government employee, if applicable', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1105, 'If claiming actual expenses, Certification by the Agency Head or Authorized Representative that travel is absolutely necessary in the performance of the assignment, together with the corresponding Bills and Official Receipts (OR); Affidavit of Loss, however, shall not be considered as replacement to the bills and receipts (Annex C of AO#286 S. 2022)', 124, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1106, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1107, 'Copy of Liquidation Report', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1108, 'Copy of Report of Cash Disbursements', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1109, 'Copy of Certification for Travel Expenses incurred by the contract of service (COS) staff', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1110, 'Copy of Paper/Electronic Plane or Bus Tickets, Boarding Pass, and/or Terminal Fee', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1111, 'Copy of Certificate of Appearance/Attendance', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1112, 'Copy of previously approved Itinerary of Travel', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1113, 'Copy of Revised or Supplemental Office Order or any proof supporting the Change of Schedule', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1114, 'Copy of Revised Itinerary of Travel, if the previous approved itinerary was not followed', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1115, 'Copy of Official Receipts/Acknowledgement Receipts', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1116, 'Copy of Reimbursement Expenses Receipts (RER), if applicable', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1117, 'Copy of Certification of Expenses not requiring receipts, if applicable (Annex A of AO#286 S. 2022)', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1118, 'Copy of Waiver of Claim for Travelling Expenses for non-PCAARRD staff but government employee, if applicable', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1119, 'Copy of Certification by the Agency Head or Authorized Representative that travel is absolutely necessary in the performance of the assignment together with the corresponding Bills and Official Receipts (OR); affidavit of loss, however, shall not be considered as replacement to the bills and receipts, if applicable (Annex C of AO#286 S. 2022)', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1120, 'Copy of Certificate of Travel Completed', 125, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1121, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1122, 'Approved Travel Order (TO)/Authority to Travel from DOST', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1123, 'Approved Itinerary of Travel', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1124, 'Forex Rate (BSP website)', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1125, 'Daily Subsistence Allowance (DSA) Rate (ICSC/UN/DFA website)', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1126, 'Letter of invitation of Host/Sponsoring Country/Agency/Organization', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1127, 'Acceptance of the Nominees as Participants', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1128, 'Program Agenda and Logistics Information', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1129, 'Paper/Electronic Plane, Boat, or Bus Tickets, original Boarding Pass, Terminal Fee', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1130, 'Certificate of Appearance/Attendance/Participation', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42');
INSERT INTO `library_dv_document` (`id`, `document`, `dv_transaction_type_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1131, 'If claiming actual accommodation expenses, this shall not exceed 30% of accommodation daily subsistence allowance (DSA): Certification by the Agency Head as absolutely necessary in the performance of the assignment together with the corresponding Bills and Official Receipts (OR); Affidavit of Loss shall not be considered as replacement to the bills and receipts. This shall be approved by DOST Secretary.', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1132, 'Certificate of Travel Completed', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1133, 'Waiver of Claim for Travelling Expenses for non-PCAARRD staff but government employee, if applicable', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1134, 'Narrative Report on Trip Undertaken/Report on Participation', 126, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1135, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1136, 'Copy of Liquidation Report', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1137, 'Copy of Approved Travel Order/Authority to Travel from DOST', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1138, 'Copy of Approved Itinerary of Travel', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1139, 'Copy of Forex rate (BSP website)', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1140, 'Copy of Daily Subsistence Allowance (DSA) Rate (ICSC/UN/DFA website)', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1141, 'Copy of Letter of invitation of Host/Sponsoring Country/Agency/Organization', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1142, 'Copy of Acceptance of the Nominees as Participants', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1143, 'Copy of Program Agenda and Logistics Information', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1144, 'Copy of Waiver of Claim for Travelling Expenses for non-PCAARRD staff but government employee, if applicable', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1145, 'Copy of Paper/Electronic plane, boat, or bus tickets, boarding pass, terminal fee', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1146, 'Copy of Certificate of Appearance/Attendance/Participation', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1147, 'Copy of Previously Approved Itinerary of Travel', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1148, 'Copy of Revised or Supplemental Office Order or any proof supporting the Change of Schedule, if applicable', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1149, 'Copy of Revised Itinerary of Travel, if the previous approved itinerary was not followed', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1150, 'Copy of Certification by the Agency Head that travel is absolutely necessary in the performance of the assignment, together with the corresponding Bills and Official Receipts (OR), if claiming actual accommodation expenses (shall not exceed 30% of accommodation daily subsistence allowance (DSA). Affidavit of Loss, however, shall not be considered as replacement to the bills and receipts. This shall be approved by the DOST Secretary.', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1151, 'Copy of Certificate of Travel Completed', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1152, 'Copy of Narrative Report on Trip Undertaken/Report on Participation', 127, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1153, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1154, 'Official Receipt/s (OR)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1155, 'Purchase Order, for goods, with deduction of Withholding Tax (BIR 2307 to be provided by the Accounting Section)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1156, 'Job Contract, for services, with deduction of Withholding Tax (BIR 2307 to be provided by the Accounting Section)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1157, 'Inspection and Acceptance Report, if applicable (for goods)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1158, 'Property Acknowledgement Receipt (PAR), if applicable (for equipment amounting to P50,000 and above)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1159, 'Pre- and Post-Inspection and Acceptance Report, if applicable (for repair and maintenance expenses)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1160, 'Waste Material Report, if applicable', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1161, 'Original Delivery Receipt, if applicable', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1162, 'Pictures of Program/Project/Activity, if applicable', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1163, 'Purchase Request', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1164, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1165, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1166, 'Statement of the prospective bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1167, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1168, 'Approved Request to Conduct the Activity with Budgetary Requirements, if applicable', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1169, 'Other Documents peculiar to the Contract or Nature of Expense and Mode of Procurement adopted', 128, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1170, 'Certified True Copy of Duly Approved Appointment', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1171, 'Assignment Order, if applicable', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1172, 'Certified True Copy of Oath of Office', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1173, 'Certificate of Assumption', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1174, 'Statement of Assets, Liabilities and Net Worth (SALN)', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1175, 'Approved Daily Time Record (DTR)', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1176, 'Bureau of Internal Revenue (BIR) Withholding Certificates (Forms 1902 and 2305)', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1177, 'Payroll Information on New Employee (PINE) (for Agencies with Computerized Payroll Systems)', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1178, 'Authority from the Claimant and Identification Documents, if claimed by person other than the payee', 129, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1179, 'Certified True Copy of Duly Approved Appointment', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1180, 'Assignment Order, if applicable', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1181, 'Certified True Copy of Oath of Office', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1182, 'Certificate of Assumption', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1183, 'Statement of Assets, Liabilities and Net Worth (SALN)', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1184, 'Approved Daily Time Record (DTR)', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1185, 'Bureau of Internal Revenue (BIR) Withholding Certificates (Forms 1902 and 2305)', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1186, 'Payroll Information on New Employee (PINE) (for agencies with computerized payroll systems)', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1187, 'Authority from the Claimant and Identification Documents, if claimed by person other than the payee', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1188, 'Clearance from Money, Property and Legal Accountabilities from the Previous Office', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1189, 'Certified True Copy of Pre-audited Disbursement Voucher of Last Salary from Previous Agency and/or Certification by the Chief Accountant of Last Salary Received from Previous Office duly verified by the assigned auditor thereat', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1190, 'Bureau of Internal Revenue (BIR) Form 2316 (Certificate of Compensation Payment/Tax Withheld)', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1191, 'Certificate of Available Leave Credits', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1192, 'Service Record', 130, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1193, 'Approved Daily Time Record (DTR)', 131, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1194, 'Notice of Assumption', 131, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1195, 'Approved Application for Leave, Clearances, and Medical Certificate, if on sick leave for five days or more', 131, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1196, 'Certified True Copy of Approved Appointment, in case of promotion or', 132, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1197, 'Notice of Salary Adjustment, in case of step increment/salary increase', 132, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1198, 'Certificate of Assumption', 132, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1199, 'Approved Daily Time Record (DTR) or Certification that the employee has not incurred leave without pay', 132, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1200, 'Clearance from Money, Property and Legal Accountabilities', 133, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1201, 'Approved Daily Time Record (DTR)', 133, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1202, 'Clearance from Money, Property and Legal Accountabilities', 134, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1203, 'Approved Daily Time Record (DTR)', 134, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1204, 'Death Certificate authenticated by the National Statistics Office (NSO)', 134, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1205, 'Marriage Contract authenticated by the National Statistics Office (NSO), if applicable', 134, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1206, 'Birth Certificates of Surviving Legal Heirs authenticated by the National Statistics Office (NSO)', 134, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1207, 'Designation of Next-of-Kin', 134, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1208, 'Waiver of Right of children 18 years old and above', 134, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1209, 'Salary Payroll', 135, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1210, 'Payroll Register', 135, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1211, 'Salary Payroll', 136, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1212, 'Payroll Register', 136, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1213, 'Approved Daily Time Record (DTR)', 136, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1214, 'Accomplishment Report', 136, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1215, 'Certified True Copy of the pertinent Contract/Appointment/Job Order (for first claim)', 136, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1216, 'Copy of the Record of Processing Activities (ROPA) of the pertinent Contract/Appointment marked received by the Civil Service Commission (CSC) (for first claim)', 136, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1217, 'Certification by the Personnel Officer that the activities/services cannot be provided by a regular or permanent personnel of the agency (for first claim)', 136, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1218, 'Copy of Office Order/Appointment (first payment)', 137, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1219, 'Certificate of Assumption (first payment)', 137, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1220, 'Certification that the Official/Employee did Not Use Government Vehicle and is Not Assigned any Government Vehicle', 137, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1221, 'Certificate or Evidence of Service Rendered or Approved Daily Time Record (DTR)', 137, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1222, 'Certified True Copy of Approved Appointment of New Employees', 138, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1223, 'Certificate of Assumption of New Employees', 138, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1224, 'Certificate of Non—Payment from Previous Agency, for transferees', 138, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1225, 'Payroll of Personnel Entitled to Claim Subsistence, Laundry and Quarters Allowance', 139, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1226, 'Approved Daily Time Record (DTR)', 139, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1227, 'Authority to Collect (for initial claim)', 139, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1228, 'Service Record', 140, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1229, 'Certification Issued by the Personnel Officer that the claimant has not incurred more than 15 days of vacation leave without pay', 140, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1230, 'Certification by the Secretary of the Department of Science and Technology (DOST)/Department of Health (DOH)/Department of National Defense (DND)/Director of the Philippine Institute of Volcanology and Seismology that the place of assignment/travel is a strife-torn/embattled/disease­infested/distresses or isolated areas/stations, or areas declared under a state of calamity or emergency, or with volcanic activity and/or eruption', 141, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1231, 'Duly Accomplished Time Record of Employees or Travel Report', 141, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1232, 'Copy of Special Order from the Agency/Department Head covering the assignment of employee to hazardous/difficult areas', 141, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1233, 'Approved Daily Time Record (DTR)/Service Report', 141, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1234, 'Certification that the Performance Ratings for the Two Semesters given to the personnel of the concerned division/office is at least satisfactory', 142, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1235, 'Certification from the Legal Office that the employee has no administrative charge', 142, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1236, 'Productivity Incentive Allowance (PIB) Payroll', 143, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1237, 'List of Personnel who were Suspended either preventively or as a penalty resulting from an administrative charge within the year for which Productivity Incentive Allowance (PIB) is paid, regardless of the duration (except if the penalty meted out is only a reprimand)', 143, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1238, 'List of Personnel Dismissed within the Year', 143, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1239, 'List of Personnel on Absent Without Official Leave (AWOL)', 143, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1240, 'Certification that the Performance Ratings for the Two Semesters given to the personnel of the concerned division/office is at least satisfactory', 143, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1241, 'Payroll Register', 143, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1242, 'Office Order creating and designating the Bids and Awards Committee (BAC) composition and authorizing the members to collect honoraria', 144, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1243, 'Minutes of Bids and Awards Committee (BAC) Meeting', 144, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1244, 'Notice of Award (NOA) to the winning bidder of the procurement activity being claimed', 144, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1245, 'Certification that the Procurement Involves Competitive Bidding', 144, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1246, 'Attendance Sheet listing names of attendees to the Bids and Awards Committee (BAC) Meeting', 144, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1247, 'Office Order', 145, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1248, 'Coordinator\'s Report on Lecturer\'s Schedule', 145, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1249, 'Course Syllabus/Program of Lectures', 145, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1250, 'Duly approved Daily Time Record (DTR) in case of claims by the coordinator and facilitators', 145, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1251, 'Performance Evaluation Plan formulated by the project management used as a basis for rating the performance of members', 146, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1252, 'Office Order designating members of the special project', 146, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1253, 'Terms of Reference (TOR)', 146, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1254, 'Certificate of Completion of project deliverables', 146, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1255, 'Special Project Plan', 146, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1256, 'Authority to Collect Honoraria', 146, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1257, 'Certificate of Acceptance by the Agency Head of the deliverables per project component', 146, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1258, 'Office Order', 147, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1259, 'Plan/Program of Activities', 147, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1260, 'Accomplishment Report/Certificate of Completion of Programmed Activities', 147, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1261, 'Authority to Collect Honoraria', 147, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1262, 'Certificate of Acceptance by the Agency Head of the deliverables/project output', 147, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1263, 'Clearance from Money, Property and Legal Accountabilities', 148, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1264, 'Certification from the Head of Office that the employee is qualified to receive the Year-end Bonus (YEB) and Cash Gift (CG) benefits pursuant to the Department of Budget Management (DBM) Budget Circular No. 2003-2 dated May 9, 2003', 148, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1265, 'Year-end Bonus (YEB) and Cash Gift (CG) Payroll', 149, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1266, 'Payroll Register (hard and softcopy)', 149, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1267, 'Updated Service Record indicating the number of days on leave without pay and/or Certification issued by the Human Resource Office (HRO) that the retiree did not incur any leave of absence without pay', 150, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1268, 'Retirement Application', 150, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1269, 'Office Clearance from Money/Property Accountability & Administrative/Criminal Liability', 150, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1270, 'Statement of Assets, Liabilities, and Net Worth (SALN)', 150, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1271, 'Retirement Gratuity Computation', 150, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1272, 'Affidavit of Undertaking for Authority to Deduct Accountabilities', 150, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1273, 'Affidavit of Applicant that there is no pending criminal investigation or prosecution against him/her (Anti-Graft RA No. 3019)', 150, 1, 0, '2023-07-10 05:48:42', '2023-07-10 05:48:42'),
(1274, 'Employee\'s Letter of Resignation duly accepted by the Agency Head', 150, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1275, 'Updated Service Record indicating the number of days on leave without pay and/or Certification issued by the Human Resource Office (HRO) that the retiree did not incur any leave of absence without pay', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1276, 'Retirement Application', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1277, 'Office Clearance from Money/Property Accountability & Administrative/Criminal Liability', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1278, 'Statement of Assets, Liabilities, and Net Worth (SALN)', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1279, 'Retirement Gratuity Computation', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1280, 'Affidavit of Undertaking for Authority to Deduct Accountabilities', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1281, 'Affidavit of Applicant that there is no pending criminal investigation or prosecution against him/her (Anti-Graft RA No. 3019)', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1282, 'Employee\'s Letter of Resignation duly accepted by the Agency Head', 151, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1283, 'Updated Service Record indicating the number of days on leave without pay and/or Certification issued by the Human Resource Office (HRO) that the retiree did not incur any leave of absence without pay', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1284, 'Retirement Application', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1285, 'Office Clearance from Money/Property Accountability & Administrative/Criminal Liability', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1286, 'Statement of Assets, Liabilities, and Net Worth (SALN)', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1287, 'Retirement Gratuity Computation', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1288, 'Affidavit of Undertaking for Authority to Deduct Accountabilities', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1289, 'Affidavit of Applicant that there is no pending criminal investigation or prosecution against him/her (Anti-Graft RA No. 3019)', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1290, 'Employee\'s Letter of Resignation duly accepted by the Agency Head', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1291, 'Death Certificate authenticated by the National Statistics Office (NSO)', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1292, 'Marriage Contract authenticated by the National Statistics Office (NSO)', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1293, 'Birth Certificates of All Surviving Legal Heirs authenticated by the National Statistics Office (NSO)', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1294, 'Designation of Next-of-Kin', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1295, 'Waiver of Rights of children 18 years old and above', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1296, 'Affidavit of Two Disinterested Parties that the deceased is survived by legitimate and illegitimate children (if any), natural, adopted or children of prior marriage', 152, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1297, 'Clearance from Money, Property and Legal Accountability from the Central Office and from the Regional Office of last assignment', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1298, 'Certified Photocopy of Employees’ Leave Card as of the last date of service, duly audited by the Personnel Division and the Commission on Audit (COA)/Certificate of Leave Credits issued by the Administration/Human Resource Management Office (HRMO)', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1299, 'Approved Leave Application', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1300, 'Complete Service Record', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1301, 'Statement of Assets, Liabilities and Net Worth (SALN)', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1302, 'Certified Photocopy of Appointment/Notice of Salary Adjustment (NOSA) showing the highest salary received if the salary under the last appointment is not the highest', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1303, 'Computation of terminal leave benefits duly signed/certified by the accountant', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1304, 'Applicant\'s Authorization (in affidavit form) to deduct all financial obligations with the employer/agency/LGU', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1305, 'Affidavit of Applicant that there is no pending criminal investigation or prosecution against him/her (RA No. 3019)', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1306, 'In case of resignation, Employee\'s Letter of Resignation duly accepted by the Head of the Agency', 153, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1307, 'Death Certificate authenticated by the National Statistics Office (NSO)', 154, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1308, 'Marriage Contract authenticated by the National Statistics Office (NSO)', 154, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1309, 'Birth Certificates of All Surviving Legal Heirs authenticated by the National Statistics Office (NSO)', 154, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1310, 'Designation of Next-of-Kin', 154, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1311, 'Waiver of Rights of children 18 years old and above', 154, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1312, 'Approved Leave Application (ten days) with Leave Credit Balance certified by the Human Resource Office', 155, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1313, 'Request for Leave Covering More than Ten Days duly approved by the Head of Agency', 155, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1314, 'Clinical Abstract/Medical Procedures to be Undertaken in case of health, medical and hospital needs', 156, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1315, 'Barangay Certification in case of need for financial assistance brought about by calamities, typhoons, fire, etc.', 156, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1316, 'Service Record', 157, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1317, 'Certificate of Non—payment from Previous Office (for transferee)', 157, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1318, 'Certification from the HRO that the claimant has not incurred more than 50 days authorized vacation leave without pay within the 10—year period or aggregate of more than 25 days authorized vacation leave without pay within the 5—year period, as the case may be', 157, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1319, 'Loyalty Cash Award/Incentive Payroll', 158, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1320, 'Payroll Register', 158, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1321, 'Resolution signed by both parties incorporating the Guidelines/Criteria for Granting Collective Negotiation Agreement (CAN) Incentive', 159, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1322, 'Comparative Statement of the Department of Budget and Management (DBM) Approved Level of Operating Expenses and Actual Operating Expenses', 159, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1323, 'Copy of Collective Negotiation Agreement (CAN)', 159, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1324, 'Certificate issued by the Head of the Agency on the Total Amount of Unencumbered Savings Generated from Cost—cutting Measures identified in the Collective Negotiation Agreement (CAN) which resulted from the joint efforts of labor and management and systems/productivity/income improvement', 159, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1325, 'Proof that the Planned Programs/Activities/Projects have been Implemented and Completed in accordance with targets for the year', 159, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1326, 'Bid Security', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1327, 'Legal Documents—Securities and Exchange Commission (SEC)/ Department of Trade and Industry (DTI)/ Cooperative Development Authority (CDA)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1328, 'Legal Documents—Mayor’s/Business Permit', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1329, 'Legal Documents—Tax Clearance', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1330, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1331, 'Technical Documents—Statement of Bidder’s Single Largest Completed Contract (SLCC) similar to the contract to be bid', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1332, 'Technical Documents—Philippine Contractors Accreditation Board (PCAB) License', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1333, 'Technical Documents—Additional documents for consulting services', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1334, 'Technical Documents—Statement of Bidder of all its ongoing, completed, and awarded government and private contracts', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1335, 'Technical Documents—For consulting services, Statement of the Consultant specifying its nationality and confirming that those who will actually perform the service are registered professionals', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1336, 'Financial Documents—Latest Audited Financial Statements stamped received by the Bureau of Internal Revenue (BIR)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1337, 'Financial Documents—Bidder’s Computation of Net Financial Contracting Capacity (NFCC) or a committed line of credit from a universal or commercial bank', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1338, 'Notice of Award (NOA)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1339, 'Abstract of Bids', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1340, 'Copy of Direct Invitation to Bid (Pre-selected manufacturers/suppliers/distributors with known experience and proven capability on the requirements of the particular contract)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1341, 'Price Quotations/Offers/Proposals', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1342, 'Performance Security', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1343, 'Warranty Security (required for highly specialized goods)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1344, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1345, 'Original Sales Invoice/Billing Statement/Statement of Account', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1346, 'Purchase Order (for goods)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1347, 'Job Contract (for services)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1348, 'Inspection and Acceptance Report (for goods)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1349, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1350, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1351, 'Waste Material Report, if applicable', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1352, 'Original Delivery Receipt, if applicable', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1353, 'Pictures of Program/Project/Activity, if applicable', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1354, 'Purchase Request', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1355, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1356, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1357, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1358, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1359, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 160, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1360, 'Copy of Letter to Selected Manufacturer/Supplier/Distributor to submit a price quotation and condition of sale', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1361, 'Certificate of Exclusive Distributorship', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1362, 'Certification from the Agency Authorized Official that there are no sub—dealers selling at lower prices and for which no suitable substitute can be obtained at more advantageous terms to the government', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1363, 'Certification from the Bids and Awards Committee (BAC) in case of procurement of critical plant components and/or maintain certain standards', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1364, 'Study/Survey done to determine that there are no sub—dealers selling at lower prices and for which no suitable substitute can be obtained at more advantageous terms to the government.', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1365, 'Warranty Security', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1366, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1367, 'Original Sales Invoice/Billing Statement/Statement of Account', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1368, 'Purchase Order (for goods)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1369, 'Job Contract (for services)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1370, 'Inspection and Acceptance Report (for goods)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1371, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1372, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1373, 'Waste Material Report, if applicable', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1374, 'Original Delivery Receipt, if applicable', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1375, 'Pictures of Program/Project/Activity, if applicable', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1376, 'Purchase Request', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1377, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1378, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1379, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1380, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1381, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 161, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1382, 'Copy of Original Contract used as basis for repeat order indicating that the original contract was awarded through public bidding', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1383, 'Certification from the Purchasing Department/Office that the supplier has complied with all the requirements under the original contract', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1384, 'Warranty Security', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1385, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1386, 'Original Sales Invoice/Billing Statement/Statement of Account', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1387, 'Purchase Order (for goods)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1388, 'Job Contract (for services)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1389, 'Inspection and Acceptance Report (for goods)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1390, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1391, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1392, 'Waste Material Report, if applicable', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1393, 'Original Delivery Receipt, if applicable', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1394, 'Pictures of Program/Project/Activity, if applicable', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1395, 'Purchase Request', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1396, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1397, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1398, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1399, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1400, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 162, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1401, 'Price Quotations from at least three (3) bona fide and reputable manufacturers/suppliers/distributors', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1402, 'Abstract of Canvass', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1403, 'Justification of the Unforeseen Contingency Requiring Immediate Purchase approved by the Head of Procuring Entity (HoPE)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1404, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1405, 'Original Sales Invoice/Billing Statement/Statement of Account', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1406, 'Purchase Order (for goods)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1407, 'Job Contract (for services)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1408, 'Inspection and Acceptance Report (for goods)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1409, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1410, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1411, 'Waste Material Report, if applicable', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1412, 'Original Delivery Receipt, if applicable', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1413, 'Pictures of Program/Project/Activity, if applicable', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1414, 'Purchase Request', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1415, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1416, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1417, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1418, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1419, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 163, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1420, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1421, 'Abstract of Price Quotation', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1422, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1423, 'Agency’s Offer for Negotiation with selected suppliers, contractors, or consultants', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1424, 'Bids and Awards Committee (BAC) Certification on the failure of competitive bidding for the second time', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1425, 'Evidence of Invitation of Observers in all stages of the negotiation', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1426, 'Performance Security', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1427, 'Warranty Security (for goods and infrastructure projects)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1428, 'Mayor’s/Business Permit (in case of infrastructure projects)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1429, 'Tax Clearance (in case of infrastructure projects)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1430, 'Philippine Contractors Accreditation Board (PCAB) License and Registration, in case of infrastructure projects Latest Audited Financial Statements (in case of infrastructure projects)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1431, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1432, 'Original Sales Invoice/Billing Statement/Statement of Account', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1433, 'Purchase Order (for goods)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1434, 'Job Contract (for services)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1435, 'Inspection and Acceptance Report (for goods)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1436, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1437, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1438, 'Waste Material Report, if applicable', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1439, 'Original Delivery Receipt, if applicable', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1440, 'Pictures of Program/Project/Activity, if applicable', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1441, 'Purchase Request', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1442, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1443, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1444, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1445, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1446, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 164, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1447, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1448, 'Abstract of Price Quotation', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1449, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1450, 'Justification as to the Necessity of Purchase', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1451, 'Performance Security (depends on the nature of the project but required for infrastructure projects)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1452, 'Warranty Security (depends on the nature of the project but not required for consulting services)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1453, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1454, 'Original Sales Invoice/Billing Statement/Statement of Account', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1455, 'Purchase Order (for goods)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1456, 'Job Contract (for services)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1457, 'Inspection and Acceptance Report (for goods)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1458, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1459, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1460, 'Waste Material Report, if applicable', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1461, 'Original Delivery Receipt, if applicable', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1462, 'Pictures of Program/Project/Activity, if applicable', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1463, 'Purchase Request', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1464, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1465, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1466, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1467, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50');
INSERT INTO `library_dv_document` (`id`, `document`, `dv_transaction_type_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1468, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 165, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1469, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1470, 'Abstract of Price Quotation', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1471, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1472, 'Copy of Terminated Contract', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1473, 'Reasons for the Termination', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1474, 'Negotiation Documents with the Second Lowest Calculated Bidder, or the Third Lowest Calculated Bidder in case of failure of negotiation with the second lowest bidder; If the negotiation still fails, invitation to at least three (3) eligible contractors', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1475, 'Approval by the Head of Procuring Entity (HoPE) to negotiate contracts of projects under exceptional cases', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1476, 'Performance Security', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1477, 'Warranty Security', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1478, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1479, 'Original Sales Invoice/Billing Statement/Statement of Account', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1480, 'Purchase Order (for goods)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1481, 'Job Contract (for services)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1482, 'Inspection and Acceptance Report (for goods)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1483, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1484, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1485, 'Waste Material Report, if applicable', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1486, 'Original Delivery Receipt, if applicable', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1487, 'Pictures of Program/Project/Activity, if applicable', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1488, 'Purchase Request', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1489, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1490, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1491, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1492, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1493, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 166, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1494, 'Price Quotations/Bids/Final Offers from at least three (3) invited suppliers', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1495, 'Abstract of Price Quotation', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1496, 'Bids and Awards Committee (BAC) Resolution recommending award of contract', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1497, 'Letter/Invitation to Submit Proposals', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1498, 'Performance Security (depends on the nature of the project but required for infrastructure projects)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1499, 'Warranty Security (depends on the nature of the project but not required for consulting services)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1500, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1501, 'Original Sales Invoice/Billing Statement/Statement of Account', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1502, 'Purchase Order (for goods)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1503, 'Job Contract (for services)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1504, 'Inspection and Acceptance Report (for goods)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1505, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1506, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1507, 'Waste Material Report, if applicable', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1508, 'Original Delivery Receipt, if applicable', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1509, 'Pictures of Program/Project/Activity, if applicable', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1510, 'Purchase Request', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1511, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1512, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1513, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1514, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1515, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 167, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1516, 'Original Contract', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1517, 'Scope of Work (related or similar to the original contract)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1518, 'Latest Accomplishment Report of the original contract showing that there was no negative slippage/delay', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1519, 'Performance Security', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1520, 'Warranty Security (required for infrastructure project)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1521, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1522, 'Original Sales Invoice/Billing Statement/Statement of Account', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1523, 'Purchase Order (for goods)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1524, 'Job Contract (for services)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1525, 'Inspection and Acceptance Report (for goods)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1526, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1527, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1528, 'Waste Material Report, if applicable', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1529, 'Original Delivery Receipt, if applicable', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1530, 'Pictures of Program/Project/Activity, if applicable', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1531, 'Purchase Request', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1532, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1533, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1534, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1535, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1536, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 168, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1537, 'Justification for the Need to Procure through this negotiated modality', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1538, 'Market Study done to determine the probable sources and confirm that the supplier, contractor or consultant could undertake the project at more advantageous terms', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1539, 'Terms of Reference (ToR) or Scope of Work', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1540, 'Bids and Awards Committee (BAC) Resolution recommending award of contract to the Head of Procuring Entity (HoPE)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1541, 'Supplier, contractor or consultant’s Professional License/Curriculum Vitae', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1542, 'Notice of Award (NOA)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1543, 'Contract', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1544, 'Accomplishment/Progress/Final Report and other required output as stipulated in the contract', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1545, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1546, 'Original Sales Invoice/Billing Statement/Statement of Account', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1547, 'Purchase Order (for goods)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1548, 'Job Contract (for services)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1549, 'Inspection and Acceptance Report (for goods)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1550, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1551, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1552, 'Waste Material Report, if applicable', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1553, 'Original Delivery Receipt, if applicable', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1554, 'Pictures of Program/Project/Activity, if applicable', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1555, 'Purchase Request', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1556, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1557, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1558, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1559, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1560, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 169, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1561, 'Justification for the Need to Procure through this negotiated modality', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1562, 'Market Study done to determine the probable sources and confirm that the supplier, contractor or consultant could undertake the project at more advantageous terms', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1563, 'Terms of Reference (ToR)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1564, 'Bids and Awards Committee (BAC) Resolution recommending award of contract to the Head of Procuring Entity (HoPE)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1565, 'Supplier, contractor or consultant’s Professional License/Curriculum Vitae', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1566, 'Notice of Award (NOA)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1567, 'Contract (duration: maximum of 6 months)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1568, 'Accomplishment/Progress/Final Report and other required output as stipulated in the contract', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1569, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1570, 'Original Sales Invoice/Billing Statement/Statement of Account', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1571, 'Purchase Order (for goods)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1572, 'Job Contract (for services)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1573, 'Inspection and Acceptance Report (for goods)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1574, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1575, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1576, 'Waste Material Report, if applicable', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1577, 'Original Delivery Receipt, if applicable', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1578, 'Pictures of Program/Project/Activity, if applicable', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1579, 'Purchase Request', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1580, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1581, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1582, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1583, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1584, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 170, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1585, 'Justification to the Bids and Awards Committee (BAC) that the resort to an Agency—to—Agency Agreement is more efficient and economical to the government', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1586, 'Certification from the Servicing Agency that it complies with all the foregoing conditions', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1587, 'Bids and Awards Committee (BAC) Resolution recommending the use of Agency—to—Agency Agreement to the Head of Procuring Entity (HoPE)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1588, 'Memorandum of Agreement between the Head of Procuring Entity (HoPE) and Servicing Agency', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1589, 'Obligation Request and Status (ORS)/Budget Utilization Request and Status (BURS)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1590, 'Original Sales Invoice/Billing Statement/Statement of Account', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1591, 'Purchase Order (for goods)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1592, 'Job Contract (for services)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1593, 'Inspection and Acceptance Report (for goods)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1594, 'Property Acknowledgement Receipt (for equipment amounting to P50,000 and above), if applicable', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1595, 'Pre- and Post-Inspection and Acceptance Report (for repair and maintenance expenses)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1596, 'Waste Material Report, if applicable', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1597, 'Original Delivery Receipt, if applicable', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1598, 'Pictures of Program/Project/Activity, if applicable', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1599, 'Purchase Request', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1600, 'Approved Project Procurement Management Plan (PPMP) or supplemental PPMP and/or Annual Procurement Plan (APP)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1601, 'Approval by Head of Procuring Entity (HoPE) or his duly authorized representative on the use of alternative modes of procurement, as recommended by the Bids and Awards Committee (BAC)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1602, 'Statement of the Prospective Bidder that it is not blacklisted or barred from bidding by the Government or any of its agencies, offices, corporation, or LGUs', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1603, 'Sworn Affidavit of the Bidder that it is not related to the Head of Procuring Entity (HoPE) by consanguinity or affinity up to the third civil degree', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1604, 'Bureau of Internal Revenue (BIR) Certificate of Registration (for withholding tax purposes of the first payment to the new supplier/payee)', 171, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1605, 'Official Receipt (OR)', 172, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1606, 'Certified True Copy of the pertinent Contract/Appointment/GSS approved Job Order (for first claim)', 172, 1, 0, '2023-07-10 06:40:50', '2023-07-10 06:40:50'),
(1607, 'Statement of Bill', 175, 1, 0, '2024-01-31 01:20:57', '2024-01-31 01:20:57'),
(1608, 'Certification of Official Calls', 175, 1, 0, '2024-01-31 01:21:03', '2024-01-31 01:21:03'),
(1609, 'Official Receipt (OR)', 175, 1, 0, '2024-01-31 01:21:16', '2024-01-31 01:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `library_dv_transaction_types`
--

CREATE TABLE `library_dv_transaction_types` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_type` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allotment_class_id` bigint DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_dv_transaction_types`
--

INSERT INTO `library_dv_transaction_types` (`id`, `transaction_type`, `allotment_class_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Infrastructure Projects—Final Payment', 3, 1, 0, '2023-03-29 05:13:56', '2023-03-29 05:13:56'),
(2, 'Infrastructure Projects—Final Payment, if with Change Order', 3, 1, 0, '2023-03-29 05:13:56', '2023-03-29 05:13:56'),
(3, 'Infrastructure Projects—First Payment', 3, 1, 0, '2023-03-29 05:13:56', '2023-03-29 05:13:56'),
(4, 'Infrastructure Projects—Release of 10% Retention Fee for Construction/Repair of Project', 3, 1, 0, '2023-03-29 05:13:56', '2023-03-29 05:13:56'),
(5, 'Infrastructure Projects—Succeeding Payment', 3, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(6, 'Advertisement—Reimbursement', 2, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(7, 'Communication Expenses—Payment to Supplier-Postage (for reloading)', 2, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(8, 'Communication Expenses—Payment to Supplier-Telephone', 2, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(9, 'Communication Expenses—Reimbursement for Mailing', 2, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(10, 'Communication Expenses—Reimbursement for Prepaid Cell Card', 2, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(11, 'E-Pass—Toll Fees', 2, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(12, 'Financial Support (to associations, etc.)', 2, 1, 0, '2023-03-29 05:13:57', '2023-03-29 05:13:57'),
(13, 'Food Expenses—Payment (to PMPC, etc.)', 2, 1, 0, '2023-03-29 05:13:58', '2023-03-29 05:13:58'),
(14, 'Food Expenses—Reimbursement', 2, 1, 0, '2023-03-29 05:13:58', '2023-03-29 05:13:58'),
(15, 'Grants-in-Aid (GIA)—Initial Release', 2, 1, 0, '2023-03-29 05:13:58', '2023-03-29 05:13:58'),
(16, 'Grants-in-Aid (GIA)—Subsequent Release', 2, 1, 0, '2023-03-29 05:13:58', '2023-03-29 05:13:58'),
(17, 'Insurance Premium—For Fidelity Bond Premium', 2, 1, 0, '2023-03-29 05:13:58', '2023-03-29 05:13:58'),
(18, 'Insurance Premium—For Vehicle and Properties', 2, 1, 0, '2023-03-29 05:13:58', '2023-03-29 05:13:58'),
(19, 'Janitorial Services—Initial Payment', 2, 1, 0, '2023-03-29 05:13:58', '2023-03-29 05:13:58'),
(20, 'Janitorial Services—Succeeding Payment', 2, 1, 0, '2023-03-29 05:13:59', '2023-03-29 05:13:59'),
(21, 'Maintenance of Equipment', 2, 1, 0, '2023-03-29 05:13:59', '2023-03-29 05:13:59'),
(22, 'Newspaper Subscription', 2, 1, 0, '2023-03-29 05:13:59', '2023-03-29 05:13:59'),
(23, 'Payment for Accommodation/Venue', 2, 1, 0, '2023-03-29 05:13:59', '2023-03-29 05:13:59'),
(24, 'Payment of Compensation Differential for Contractual', 2, 1, 0, '2023-03-29 05:13:59', '2023-03-29 05:13:59'),
(25, 'Payment of Office/Computer/Semi-Expendable & Other Supplies', 2, 1, 0, '2023-03-29 05:13:59', '2023-03-29 05:13:59'),
(26, 'Payment of Plane Fare to Travel Agent', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(27, 'Payment of Services for Contractual', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(28, 'Printing of Publications', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(29, 'Registration of Motor Vehicle', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(30, 'Minor Repairs of Equipment—Reimbursement', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(31, 'Minor Repairs of Vehicles—Reimbursement', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(32, 'Emergency Purchase of Supplies Expense—Reimbursement ', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(33, 'Xerox/Binding/Printing of Tarpaulin and Similar Expense—Reimbursement ', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(34, 'Repair of Motor Vehicle', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(35, 'Scholars\' Benefits—Payment of Stipend (direct to Land Bank account of scholars)', 2, 1, 0, '2023-03-29 05:14:00', '2023-03-29 05:14:00'),
(36, 'Scholars\' Benefits—Reimbursement of Travel Expenses (for incoming and outgoing scholars)', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(37, 'Scholars\' Benefits—Thesis Support', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(38, 'Scholars\' Benefits—Tuition Fees', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(39, 'Security Services—Initial Payment', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(40, 'Security Services—Succeeding Payment', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(41, 'Training/Seminar/Convention/Conference Registration Fee—Reimbursement', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(42, 'Training/Seminar/Convention/Conference Registration Fee—Payment to Organizer', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(43, 'Transportation Services—Vehicle Rental', 2, 1, 0, '2023-03-29 05:14:01', '2023-03-29 05:14:01'),
(44, 'Travelling Expenses (Domestic Travel)—Liquidation of Cash Advance for Itinerary of Travel', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(45, 'Travelling Expenses (Domestic Travel)—Payment of Itinerary of Travel (Cash Advance)', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(46, 'Travelling Expenses (Domestic Travel)—Reimbursement', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(47, 'Travelling Expenses (Domestic Travel)—Reimbursement of Travel Expenses in Excess of Cash Advance', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(48, 'Travelling Expenses (Foreign Travel)—Liquidation of Cash Advance for Itinerary of Travel', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(49, 'Travelling Expenses (Foreign Travel)—Payment of Itinerary of Travel (Cash Advance)', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(50, 'Travelling Expenses (Foreign Travel)—Reimbursement', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(51, 'Water & Electricity', 2, 1, 0, '2023-03-29 05:14:02', '2023-03-29 05:14:02'),
(52, 'Cash Advance (for Petty Cash Fund?) by Regular Disbursing Officer (RDO)', 0, 1, 0, '2023-03-29 05:14:03', '2023-03-29 05:14:03'),
(53, 'Cash Advance for Petty Cash Fund by Special Disbursing Officer (SDO)', 0, 1, 0, '2023-03-29 05:14:03', '2023-03-29 05:14:03'),
(54, 'Contract for Civil Works/Infrastructures—If thru Canvass', 0, 1, 0, '2023-03-29 05:14:03', '2023-03-29 05:14:03'),
(55, 'Contract for Civil Works/Infrastructures—If thru Public Bidding', 0, 1, 0, '2023-03-29 05:14:03', '2023-03-29 05:14:03'),
(56, 'Contract for Services', 0, 1, 0, '2023-03-29 05:14:03', '2023-03-29 05:14:03'),
(57, 'Letter Order for Publications—If thru Canvass', 0, 1, 0, '2023-03-29 05:14:03', '2023-03-29 05:14:03'),
(58, 'Letter Order for Publications—If thru Public Bidding', 0, 1, 0, '2023-03-29 05:14:03', '2023-03-29 05:14:03'),
(59, 'Liquidation of Cash Advances (by RDO)—Expenses for Cell Cards', 0, 1, 0, '2023-03-29 05:14:04', '2023-03-29 05:14:04'),
(60, 'Liquidation of Cash Advances (by RDO)—Expenses for Workshops/Seminars/Trainings', 0, 1, 0, '2023-03-29 05:14:04', '2023-03-29 05:14:04'),
(61, 'Liquidation of Cash Advances (by RDO)—For Salaries/Benefits', 0, 1, 0, '2023-03-29 05:14:04', '2023-03-29 05:14:04'),
(62, 'Purchase Order (PO) for Office/Computer/Semi-Expendable & Other Supplies', 0, 1, 0, '2023-03-29 05:14:04', '2023-03-29 05:14:04'),
(63, 'Purchase Order (PO) for Office/Computer/Semi-Expendable & Other Supplies—If thru Canvass', 0, 1, 0, '2023-03-29 05:14:04', '2023-03-29 05:14:04'),
(64, 'Purchase Order (PO) for Office/Computer/Semi-Expendable & Other Supplies—If thru Public Bidding', 0, 1, 0, '2023-03-29 05:14:04', '2023-03-29 05:14:04'),
(65, 'Release of Performance Bond', 0, 1, 0, '2023-03-29 05:14:04', '2023-03-29 05:14:04'),
(66, 'Remittances of Deductions (to BIR, Pag-Ibig, GSIS, HDMF, PMPC, UPLB-CDC, etc.)', 0, 1, 0, '2023-03-29 05:14:05', '2023-03-29 05:14:05'),
(67, 'Replenishment of Cash Advance for MOOE by Regular Disbursing Officer (RDO)', 0, 1, 0, '2023-03-29 05:14:05', '2023-03-29 05:14:05'),
(68, 'Replenishment of Petty Cash Fund by Special Disbursing Officer (SDO)', 0, 1, 0, '2023-03-29 05:14:05', '2023-03-29 05:14:05'),
(69, 'Commutation of Leave Credits', 1, 1, 0, '2023-03-29 05:14:05', '2023-03-29 05:14:05'),
(70, 'Commutation of Maternity Leave', 1, 1, 0, '2023-03-29 05:14:05', '2023-03-29 05:14:05'),
(71, 'Honorarium—For Governing Council (GC) Members', 1, 1, 0, '2023-03-29 05:14:05', '2023-03-29 05:14:05'),
(72, 'Honorarium—For Others', 1, 1, 0, '2023-03-29 05:14:05', '2023-03-29 05:14:05'),
(73, 'Honorarium—For Team Leaders', 1, 1, 0, '2023-03-29 05:14:06', '2023-03-29 05:14:06'),
(74, 'Salary—First Payment', 1, 1, 0, '2023-03-29 05:14:06', '2023-03-29 05:14:06'),
(75, 'Salary Differential—Due to Promotion', 1, 1, 0, '2023-03-29 05:14:06', '2023-03-29 05:14:06'),
(76, 'Salary Differential—Due to Step Increment/Salary Adjustment', 1, 1, 0, '2023-03-29 05:14:06', '2023-03-29 05:14:06'),
(77, 'Terminal Leave', 1, 1, 0, '2023-03-29 05:14:06', '2023-03-29 05:14:06'),
(78, 'Balik Scientist Daily Subsistence Allowance (DSA)', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(79, 'Participation Fee for Vehicular Accidents', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(80, 'GIA Initial Release of Funds to Implementing Agency (NGAs/SUCs/Other Government Agencies)', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(81, 'GIA Succeeding Release of Funds to Implementing Agency (NGAs/SUCs/Other Government Agencies) for Multi-Year Projects', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(82, 'GIA Initial Release of Funds to Implementing Agency (NGOs/POs)', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(83, 'GIA Succeeding Release of Funds to Implementing Agency (NGOs/POs) for Multi-Year Projects', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(84, 'GIA Initial Release of Funds to Private Institutions', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(85, 'GIA Succeeding Release of Funds to Private Institutions for Multi-Year Projects', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(86, 'Public Bidding Payment for Goods', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(87, 'Public Bidding Payment for General Services', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(88, 'Public Bidding Payment for Infrastructure Works', 3, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(89, 'Public Bidding Payment for Infrastructure with Change/Extra Work Order', 3, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(90, 'Public Bidding Payment for Infrastructure with Advance Payment', 3, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(91, 'Public Bidding Payment for Infrastructure Release of Retention Money', 3, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(92, 'Public Bidding Payment for Consulting Services', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(93, 'Public Bidding Payment for Repairs and Maintenance Services', 2, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(94, 'Public Bidding Payment for Advertising/Publication Services', 3, 1, 0, '2023-07-10 05:39:33', '2023-07-10 05:39:33'),
(95, 'Alternative Mode of Procurement—Limited Source Bidding', 2, 1, 0, '2023-07-10 05:41:18', '2023-07-10 05:41:18'),
(96, 'Alternative Mode of Procurement—Direct Contracting', 2, 1, 0, '2023-07-10 05:43:05', '2023-07-10 05:43:05'),
(97, 'Alternative Mode of Procurement—Repeat Order', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(98, 'Alternative Mode of Procurement—Shopping (Off-the-Shelf Goods)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(99, 'Alternative Mode of Procurement—Negotiated Procurement-Two Failed Biddings', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(100, 'Alternative Mode of Procurement—Negotiated Procurement-Emergency Cases', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(101, 'Alternative Mode of Procurement—Negotiated Procurement-Take Over Contracts', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(102, 'Alternative Mode of Procurement—Negotiated Procurement-Small Value Procurement', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(103, 'Alternative Mode of Procurement—Negotiated Procurement-Adjacent or Contiguous Projects', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(104, 'Alternative Mode of Procurement—Negotiated Procurement-Scientific, Scholarly or Artistic Work, Exclusive Technology & Media Services', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(105, 'Alternative Mode of Procurement—Negotiated Procurement-Highly Technical Consultant', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(106, 'Alternative Mode of Procurement—Negotiated Procurement-Agency to Agency', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(107, 'Cultural and Athletic Activities (annual amount not exceeding 1,200 PhP per employee)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(108, 'Human Resource Development and Training Program (take note of National Budget Circular (NBC) #563, Php 2,000 per day)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(109, 'Payment of Utilities', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(110, 'Telephone/Communication Services', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(111, 'Extraordinary Miscellaneous Expense (PCAARRD Executive Director)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(112, 'Food Expenses for Conducted Events/Trainings/Workshops with Visitors (for meetings and divisional activities, this shall be charged to the Representation Allowance of the Divisional Directors)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(113, 'Food Expenses for Conducted Events/Trainings/Workshops without Visitor/s—Snacks only (for meetings and divisional activities, this shall be charged to the Representation Allowance of the Divisional Directors)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(114, 'Payment of Plane Fare to Travel Agent', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(115, 'Cash Advance (CA) for Local Travel—Permanent/Regular Staff', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(116, 'Cash Advance (CA) for Local Travel—Contract of Service (COS) Staff—*COS staff who intends to request CA for official travel shall be drawn by a regular staff and the latter shall be accountable for the CA of COS staff', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(117, 'Liquidation of Cash Advance (CA) for Local Travel', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(118, 'Cash Advance (CA) for Foreign Travel—*Pre-departure expenses up to P3,500 only (e.g. taxicab fare, passport/visa processing, immunization and medical laboratory fees, photographs, porterage, airport terminal fees, and other related expenses)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(119, 'Liquidation of Cash Advance (CA) for Foreign Travel', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(120, 'Cash Advance (CA) for Special Purpose (e.g. purchase of supplies, vehicle related expenses/ repair and maintenance/ Training/ courier/ project monitoring expenses/ Divisional Expenses/ ICT Equipment and supplies/ Software and Licenses)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(121, 'Liquidation of Cash Advance (CA) for Special Purpose', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(122, 'Setting-up of Petty Cash Fund', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(123, 'Replenishment of Petty Cash Fund', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(124, 'Reimbursement of Local Travel Expenses', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(125, 'Reimbursement of Local Travel Expenses in Excess of Cash Advance (CA)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(126, 'Reimbursement of Foreign Travel Expenses', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(127, 'Reimbursement of Foreign Travel Expenses in Excess of Cash Advance (CA)', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(128, 'Other Reimbursement of Expenses', 2, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(129, 'First Salary of New Government Employee', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(130, 'First Salary of Transferees (from one government agency to another)', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(131, 'Succeeding Salary (if deleted from the payroll)', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(132, 'Salary Differentials due to Promotion and/or Step Increment', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(133, 'Last Salary', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(134, 'Salary due to Heirs of Deceased Employee', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(135, 'Salary of Regular Employees thru the Payroll System (with allowances)', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(136, 'Salary of Casual/Contractual Personnel', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(137, 'Representation and Transportation Allowance (RATA)—Individual Claims', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(138, 'Clothing/Uniform—Individual Claims', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(139, 'Subsistence, Laundry and Quarters Allowances', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(140, 'Longevity Pay', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(141, 'Hazard Duty Pay', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(142, 'Productivity Incentive Allowance (PIB)—Individual Claims', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(143, 'Productivity Incentive Allowance (PIB)—General Claims', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(144, 'Honoraria of Government Personnel Involved in Government Procurement', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(145, 'Honoraria of Lecturer/Coordinator', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(146, 'Honoraria for Special Projects', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(147, 'Honoraria for Science and Technological Activities', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(148, 'Year-End Bonus (YEB) and Cash Gift (CG)—Individual Requirement', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(149, 'Year-End Bonus (YEB) and Cash Gift (CG)—General Claims', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(150, 'Retirement Benefits—General Requirements', 1, 1, 0, '2023-07-10 05:51:06', '2023-07-10 05:51:06'),
(151, 'Retirement Benefits—Additional Requirement in case of Resignation', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(152, 'Retirement Benefits—Additional Requirements in case of Death of Claimant', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(153, 'Terminal Leave Benefits—General Requirements', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(154, 'Terminal Leave Benefits—Additional Requirements in case of Death of Claimant', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(155, 'Monetization—General Requirements', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(156, 'Monetization—Additional Requirements for Monetization of 50 percent or More', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(157, 'Loyalty Cash Award/Incentive—For Individual Claims', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(158, 'Loyalty Cash Award/Incentive—For General Claims', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(159, 'Collective Negotiation Agreement (CNA) Incentive', 1, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(160, 'Alternative Mode of Procurement—Limited Source Bidding', 3, 1, 0, '2023-07-10 06:39:34', '2023-07-10 06:39:34'),
(161, 'Alternative Mode of Procurement—Direct Contracting', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(162, 'Alternative Mode of Procurement—Repeat Order', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(163, 'Alternative Mode of Procurement—Shopping (Off-the-Shelf Goods)', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(164, 'Alternative Mode of Procurement—Negotiated Procurement-Two Failed Biddings', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(165, 'Alternative Mode of Procurement—Negotiated Procurement-Emergency Cases', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(166, 'Alternative Mode of Procurement—Negotiated Procurement-Take Over Contracts', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(167, 'Alternative Mode of Procurement—Negotiated Procurement-Small Value Procurement', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(168, 'Alternative Mode of Procurement—Negotiated Procurement-Adjacent or Contiguous Projects', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(169, 'Alternative Mode of Procurement—Negotiated Procurement-Scientific, Scholarly or Artistic Work, Exclusive Technology & Media Services', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(170, 'Alternative Mode of Procurement—Negotiated Procurement-Highly Technical Consultant', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(171, 'Alternative Mode of Procurement—Negotiated Procurement-Agency to Agency', 3, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(172, 'Legal Services-Notarization–Reimbursement', 2, 1, 0, '2023-07-10 06:39:35', '2023-07-10 06:39:35'),
(173, 'Cash Award - Best Research & Development (R&D) Paper', 2, 1, 0, '2023-10-25 05:09:56', '2023-10-25 05:09:56'),
(174, 'Cash Award - Elvira O. Tan Award', 2, 1, 0, '2023-10-25 05:10:02', '2023-10-25 05:10:02'),
(175, 'Communication Expenses—Reimbursement of Mobile Expenses', 2, 1, 0, '2024-01-31 01:20:28', '2024-01-31 01:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `library_expense_account`
--

CREATE TABLE `library_expense_account` (
  `id` bigint UNSIGNED NOT NULL,
  `expense_account` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_account_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_id` bigint UNSIGNED DEFAULT NULL,
  `subactivity_id` bigint UNSIGNED DEFAULT NULL,
  `request_status_type_id` bigint UNSIGNED DEFAULT NULL,
  `allotment_class_id` bigint UNSIGNED NOT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_expense_account`
--

INSERT INTO `library_expense_account` (`id`, `expense_account`, `expense_account_code`, `activity_id`, `subactivity_id`, `request_status_type_id`, `allotment_class_id`, `tags`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Awards/Rewards and Prizes', '50206000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:49', '2022-09-20 01:16:49'),
(2, 'Communication Expenses', '50205000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:49', '2022-09-20 01:16:49'),
(3, 'Confidential, Intelligence and Extraordinary Expenses', '50210000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:50', '2022-09-20 01:16:50'),
(4, 'Financial Assistance/Subsidy', '50214000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:50', '2022-09-20 01:16:50'),
(5, 'General Services', '50212000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:50', '2022-09-20 01:16:50'),
(6, 'Other Compensation', '50102000 00', NULL, NULL, 1, 1, NULL, 1, 0, '2022-09-20 01:16:50', '2022-09-20 01:16:50'),
(7, 'Other Maintenance and Operating Expenses', '50299000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:50', '2022-09-20 01:16:50'),
(8, 'Other Personnel Benefits', '50104000 00', NULL, NULL, 1, 1, NULL, 1, 0, '2022-09-20 01:16:50', '2022-09-20 01:16:50'),
(9, 'Personnel Benefit Contributions', '50103000 00', NULL, NULL, 1, 1, NULL, 1, 0, '2022-09-20 01:16:50', '2022-09-20 01:16:50'),
(10, 'Professional Services', '50211000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:51', '2022-09-20 01:16:51'),
(11, 'Property, Plant and Equipment Outlay', '50604000 00', NULL, NULL, 1, 3, NULL, 1, 0, '2022-09-20 01:16:51', '2022-09-20 01:16:51'),
(12, 'Repairs and Maintenance', '50213000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:51', '2022-09-20 01:16:51'),
(13, 'Salaries and Wages', '50101000 00', NULL, NULL, 1, 1, NULL, 1, 0, '2022-09-20 01:16:51', '2022-09-20 01:16:51'),
(14, 'Supplies and Materials Expenses', '50203000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:51', '2022-09-20 01:16:51'),
(15, 'Taxes, Insurance Premiums and Other Fees', '50215000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:52', '2022-09-20 01:16:52'),
(16, 'Training and Scholarship Expenses', '50202000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:52', '2022-09-20 01:16:52'),
(17, 'Traveling Expenses', '50201000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:52', '2022-09-20 01:16:52'),
(18, 'Utility Expenses', '50204000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-09-20 01:16:52', '2022-09-20 01:16:52'),
(19, 'Survey, Research, Exploration and Development Expenses', '50207000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2022-10-11 13:05:05', '2022-10-11 13:05:05'),
(20, 'Interest Expenses', '50301020 00', NULL, NULL, 1, 4, NULL, 1, 0, '2023-05-24 09:01:25', '2023-05-24 09:01:25'),
(21, 'Intangible Assets Outlay ', '50606000 00', NULL, NULL, 1, 2, NULL, 1, 0, '2023-05-29 07:48:13', '2023-05-29 07:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `library_fund_check`
--

CREATE TABLE `library_fund_check` (
  `id` bigint NOT NULL,
  `fund` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_object_expenditure`
--

CREATE TABLE `library_object_expenditure` (
  `id` bigint UNSIGNED NOT NULL,
  `old_id` bigint UNSIGNED DEFAULT NULL,
  `object_expenditure` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_code` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_account_id` bigint UNSIGNED DEFAULT NULL,
  `allotment_class_id` bigint UNSIGNED DEFAULT NULL,
  `is_gia` tinyint(1) NOT NULL DEFAULT '0',
  `request_status_type_id` bigint UNSIGNED DEFAULT NULL,
  `remarks` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_object_expenditure`
--

INSERT INTO `library_object_expenditure` (`id`, `old_id`, `object_expenditure`, `object_code`, `expense_account_id`, `allotment_class_id`, `is_gia`, `request_status_type_id`, `remarks`, `tags`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1305, 'Advertising Expenses', '5029901000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(2, 1314, 'Auditing Services', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(3, 1312, 'Awards/Rewards Expenses', '5020601001', 1, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(4, 1340, 'Subsidies - Others', '5021499000', 4, 2, 1, 1, NULL, NULL, 1, 0, NULL, NULL),
(5, 1802, 'Buildings and Other Structures - Buildings', '5060404001', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(6, 1325, 'Buildings and Other Structures - Other Structures', '5060404099', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(7, 1876, 'Cash Gift - Civilian', '5010215001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(8, 1868, 'Clothing/Uniform Allowance - Civilian', '5010204001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(9, 1315, 'Consultancy Services', '5021103002', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(10, 1297, 'Electricity Expenses', '5020402000', 18, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(11, 1879, 'Employees Compensation Insurance Premiums (ECIP)', '5010304001', 9, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(12, 1316, 'Environment/Sanitary Services', '5021201000', 5, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(13, 1343, 'Extraordinary Expenses', '5021003000', 3, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(14, 1345, 'Fidelity Bond Premiums', '5021502000', 15, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(15, 1334, 'Financial Assistance to NGAs', '5021402000', 4, 2, 1, 1, NULL, NULL, 1, 0, NULL, NULL),
(16, 1873, 'Hazard Pay (HP) - Magna Carta Benefits for Science and Technology under R.A. 8439', '5010211004', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(17, 1872, 'Honoraria - Civilian ', '5010210001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(18, NULL, 'Honoraria - Magna Carta Benefits for Science and Technology under R.A. 8439', '5010210003', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(19, 1992, 'ICT Consultancy Services', '5021103001', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(20, 1346, 'Insurance Expenses', '5021503000', 15, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(21, 1318, 'Janitorial Services', '5021202000', 5, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(22, NULL, 'Land Improvements Outlay - Other Land Improvements', '5060402099', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(23, 1870, 'Laundry Allowance  ( LA ) - Magna Carta Benefits for Science and Technology under R.A. 8439', '5010206003', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(24, 1313, 'Legal Services', '5021101000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(25, 1874, 'Longevity Pay (LP) - Magna Carta Benefits for Science and Technology under R.A. 8439', '5010212003', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(26, 1920, 'Machinery and Equipment Outlay - ICT Equipment', '5060405003', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(27, 1991, 'Machinery and Equipment Outlay - ICT Software', '5060405015', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(28, 1887, 'Machinery and Equipment Outlay - Machinery', '5060405001', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(29, 1801, 'Machinery and Equipment Outlay - Office Equipment', '5060405002', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(30, 2030, 'Machinery and Equipment Outlay - Other Machinery and Equipment', '5060405099', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(31, 1989, 'Other Bonuses and Allowances - Mid-Year Bonus - Civilian', '5010216001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(32, 1282, 'Office Supplies Expenses', '5020301002', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(33, 1283, 'Office Supplies Expenses - Accountable Forms Expenses', '5020302000', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(34, 1996, 'Office Supplies Expenses - ICT Office Supplies', '5020301001', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(35, 2034, 'Other Bonuses and Allowances - Anniversary Bonus - Civilian', '5010299038', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(36, 1922, 'Other Bonuses and Allowances - Collective Negotiation Agreement Incentive - Civilian', '5010299011', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(37, 1923, 'Other Bonuses and Allowances - Performance Based Bonus - Civilian', '5010299014', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(38, NULL, 'Other Bonuses and Allowances - Per Diems - Civilian', '5010299001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(39, 1918, 'Other Bonuses and Allowances - Productivity Enhancement Incentive - Civilian', '5010299012', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(40, 1304, 'Other Maintenance and Operating Expenses', '5029999099', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(41, 1320, 'Other Professional Services', '5021199000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(42, 1294, 'Other Supplies and Materials Expenses', '5020399000', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(43, 1877, 'Pag-IBIG Contributions', '5010302001', 9, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(44, 1867, 'Personal Economic Relief  Allowance  (PERA) - Civilian', '5010201001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(45, 1255, 'Representation Allowance (RA)', '5010202000', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(46, 1256, 'Transportation Allowance (TA)', '5010203001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(47, 1878, 'PhilHealth Contributions', '5010303001', 9, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(48, 1298, 'Postage and Courier Expenses', '5020501000', 2, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(49, 1306, 'Printing and Publication Expenses', '5029902000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(50, 1871, 'Productivity Incentive Allowance (PIA) - Productivity Incentive Allowance - Civilian', '5010208001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(51, 1307, 'Rent/Lease Expenses - ICT Machinery and Equipment', '5029905008', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(52, 1302, 'Membership Dues and Contributions to Organizations', '5029906000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(53, 1886, 'Rent/Lease Expenses - Motor Vehicles', '5029905003', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(54, NULL, 'Repairs and Maintenance-Buildings and Other Structures - Buildings', '5021304001', 12, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(55, 1881, 'Repairs and Maintenance-Buildings and Other Structures - Other Structures', '5021304099', 12, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(56, 1883, 'Repairs and Maintenance-Machinery and Equipment - ICT Equipment', '5021305003', 12, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(57, 2028, 'Repairs and Maintenance-Machinery and Equipment - Machinery', '5021305001', 12, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(58, 1882, 'Repairs and Maintenance-Machinery and Equipment - Office Equipment', '5021305002', 12, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(59, NULL, 'Repairs and Maintenance-Machinery and Equipment - Other Machinery and Equipment', '5021305099', 12, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(60, 1884, 'Repairs and Maintenance-Transportation Equipment - Motor Vehicles', '5021306001', 12, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(61, 1308, 'Representation Expenses', '5029903000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(62, 1270, 'Retirement and Life Insurance Premiums', '5010301000', 9, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(63, 1921, 'Retirement Gratuity - Civilian', '5010402001', 8, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(64, 1866, 'Salaries and Wages - Regular - Basic Salary - Civilian', '5010101001', 13, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(65, 1319, 'Security Services', '5021203000', 5, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(66, 2037, 'Semi-Expendable Machinery and Equipment Expenses - ICT Equipment', '5020321003', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(67, NULL, 'Semi-Expendable Machinery and Equipment Expenses - Machinery', '5020321001', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(68, 2036, 'Semi-Expendable Machinery and Equipment Expenses - Office Equipment', '5020321002', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(69, NULL, 'Semi-Expendable Machinery and Equipment Expenses - Other Machinery and Equipment', '5020321099', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(70, NULL, 'Subscription Expenses - ICT Software Subscription', '5029907001', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(71, 2012, 'Subscription Expenses - Other Subscription Expenses', '5029907099', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(72, NULL, 'Subscription Expenses - Website Maintenance', '5029999001', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(73, 1869, 'Subsistence  Allowance  (SA) -  Magna Carta Benefits for Science and Technology under R.A. 8439', '5010205002', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(74, 1885, 'Taxes, Duties and Licenses', '5021501001', 15, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(75, 1300, 'Telephone Expenses - Internet Subscription Expenses', '5020503000', 2, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(76, 1299, 'Telephone Expenses - Landline', '5020502002', 2, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(77, 1800, 'Telephone Expenses - Mobile', '5020502001', 2, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(78, 1880, 'Terminal Leave Benefits -  Civilian', '5010403001', 8, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(79, 1990, 'Loyalty Award - Civilian', '5010499015', 8, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(80, NULL, 'Terminal Leave Benefits - Other Personnel Benefits', '5010499099', 8, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(81, 1280, 'Training Expenses', '5020201002', 16, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(82, NULL, 'ICT Training Expenses', '5020201001', 16, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(83, 1309, 'Transportation and Delivery Expenses', '5029904000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(84, 1931, 'Transportation Equipment Outlay - Motor Vehicles', '5060406001', 11, 3, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(85, 1279, 'Traveling Expenses-Foreign', '5020102000', 17, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(86, 1278, 'Traveling Expenses-Local', '5020101000', 17, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(87, 1296, 'Water Expenses', '5020401000', 18, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(88, 1290, 'Fuel, Oil and Lubricants Expenses', '5020309000', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(89, 1875, 'Year End Bonus - Civilian', '5010214001', 6, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(90, 1281, 'Scholarship Grants/Expenses', '5020202000', 16, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(91, NULL, 'Rewards and Incentives', '5020601002', 1, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(92, 1303, 'Prizes ', '5020602000', 1, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(93, 1311, 'Survey Expenses', '5020701000', 19, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(94, NULL, 'Research, Exploration and ICT Development Expenses', '5020702001', 19, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(95, NULL, 'Research, Exploration and Development Expenses', '5020702002', 19, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(96, 1900, 'Miscellaneous Expenses', '5021003000', 3, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(97, NULL, 'Semi-Expendable Furniture, Fixtures and Books Expenses - Books', '5020322002', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(98, 1898, 'Representation Expenses - Accommodation', '5029903000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(99, 1899, 'Representation Expenses - Food', '5029903000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(100, 1919, 'Representation Expenses - Registration Fee', '5029903000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(101, 1941, 'Representation Expenses - Token', '5029903000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(102, NULL, 'Representation Expenses - Venue/Use of Facilities with Food', '5029903000', 7, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(103, 1933, 'Auditing Services - Traveling Expenses-Local', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(104, 1934, 'Auditing Services - Postage and Courier Expenses', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(105, 1935, 'Auditing Services - Repairs and Maintenance-Machinery and Equipment - ICT Equipment', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(106, NULL, 'Auditing Services - Repairs and Maintenance-Machinery and Equipment - Office Equipment', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(107, NULL, 'Auditing Services - Training Expenses', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(108, NULL, 'Auditing Services - Fuel, Oil and Lubricants Expenses', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(109, NULL, 'Auditing Services - Other Supplies and Materials Expenses', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(110, NULL, 'Auditing Services - Legal Services', '5021102000', 10, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(111, 1253, 'Salaries and Wages - Casual/Contractual', '5010102000', 13, 1, 0, 2, NULL, NULL, 1, 0, NULL, NULL),
(112, 1945, 'Other Supplies and Materials Expenses', '5020399000', 14, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(113, NULL, 'Semi-Expendable Machinery and Equipment Expenses - ICT Equipment', '5020321003', 14, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(114, NULL, 'Semi-Expendable Machinery and Equipment Expenses - Office Equipment', '5020321002', 14, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(115, 2038, 'Semi-Expendable Furniture, Fixtures and Books Expenses - Furniture and Fixtures', '5020322001', 14, 2, 0, 2, NULL, NULL, 1, 0, NULL, NULL),
(116, 1946, 'Telephone Expenses - Mobile', '5020502001', 2, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(117, 2039, 'Consultancy Services', '5021103002', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(118, 1948, 'Other Professional Services', '5021199000', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(119, NULL, 'Machinery and Equipment Outlay - ICT Software', '5060405015', 11, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(120, 2022, 'Other Maintenance and Operating Expenses', '5029999099', 7, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(121, 1317, 'Other General Services ', '5021299099', 5, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(122, NULL, 'Repairs and Maintenance-Buildings and Other Structures - Other Structures', '5021304099', 12, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(123, 1301, 'Cable, Satellite, Telegraph and Radio Expenses ', '5020504000', 2, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(124, 1330, 'Repairs and Maintenance-Transportation Equipment - Motor Vehicles', '5021306001', 12, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(125, 1338, 'Financial Assistance to NGOs/POs', '5021405000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(126, 1339, 'Donations', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(127, 1344, 'Taxes, Duties and Licenses', '5021501001', 15, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(128, 1377, 'Bank Charges', '5030104000', 20, 4, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(129, 1897, 'Rents - Equipment', '5029905004', 7, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(130, 1924, 'Donations - Representation Expenses - Registration Fee', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(131, 1925, 'Donations - Other Supplies and Materials Expenses', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(132, 1930, 'Donations - Legal Services', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(133, 2020, 'Mid-Year Bonus - Civilian', '5010216001', 6, 1, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(134, NULL, 'Other Bonuses and Allowances - Anniversary Bonus - Civilian', '5010299038', 6, 1, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(135, NULL, 'Terminal Leave Benefits - Loyalty Award - Civilian', '5010499015', 8, 1, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(136, 1937, 'Training Expenses - Fuel, Oil and Lubricants Expenses', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(137, 1999, 'Training Expenses - Other Professional Services', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(138, 1938, 'Training Expenses - Other Supplies and Materials Expenses', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(139, 1940, 'Training Expenses - Rent/Lease Expenses - Motor Vehicles', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(140, 2001, 'Training Expenses - Rent/Lease Expenses - Motor Vehicles', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(141, 1995, 'Training Expenses - Representation Expenses - Food and Accommodation', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(142, 2000, 'Training Expenses - Representation Expenses - Token', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(143, 2014, 'Training Expenses - Representation Expenses - Venue/Use of Facilities with Food', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(144, 1994, 'Training Expenses - Traveling Expenses-Local', '5020201002', 16, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(145, 1947, 'Electricity Expenses', '5020402000', 18, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(146, 1958, 'Auditing Services - Legal Services', '5021102000', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(147, 2013, 'Auditing Services - Printing and Publication Expenses', '5021102000', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(148, 2029, 'Auditing Services - Repairs and Maintenance-Machinery and Equipment - Office Equipment', '5021102000', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(149, 2003, 'Auditing Services - Telephone Expenses - Mobile', '5021102000', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(150, 1957, 'Auditing Services - Training Expenses', '5021102000', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(151, NULL, 'ICT Consultancy Services', '5021103001', 10, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(152, NULL, 'Repairs and Maintenance-Machinery and Equipment - Machinery', '5021305001', 12, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(153, 1955, 'Repairs and Maintenance-Machinery and Equipment - Other Machinery and Equipment', '5021305099', 12, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(154, 1980, 'Financial Assistance to NGAs - Fuel, Oil and Lubricants Expenses', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(155, 1967, 'Financial Assistance to NGAs - Honoraria', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(156, 1984, 'Financial Assistance to NGAs - Legal Services', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(157, 1977, 'Financial Assistance to NGAs - Machinery and Equipment Outlay - Other Machinery and Equipment', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(158, 1978, 'Financial Assistance to NGAs - Office Supplies Expenses', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(159, 1966, 'Financial Assistance to NGAs - Other Professional Services', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(160, 1983, 'Financial Assistance to NGAs - Other Supplies and Materials Expenses', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(161, 1971, 'Financial Assistance to NGAs - Postage and Courier Expenses', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(162, 1972, 'Financial Assistance to NGAs - Printing and Publication Expenses', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(163, 1973, 'Financial Assistance to NGAs - Rent/Lease Expenses - Motor Vehicles', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(164, 1976, 'Financial Assistance to NGAs - Representation Expenses - Accommodation', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(165, 1975, 'Financial Assistance to NGAs - Representation Expenses - Food', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(166, 1982, 'Financial Assistance to NGAs - Representation Expenses - Registration Fee', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(167, 1963, 'Financial Assistance to NGAs - Salaries and Wages - Casual/Contractual', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(168, 1981, 'Financial Assistance to NGAs - Telephone Expenses - Mobile', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(169, 1969, 'Financial Assistance to NGAs - Traveling Expenses-Foreign', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(170, 1968, 'Financial Assistance to NGAs - Traveling Expenses-Local', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(171, 1997, 'Financial Assistance to NGAs - Water Expenses', '5021402000', 4, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(172, 1956, 'Representation Expenses', '5029903000', 7, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(173, 2009, 'Subscription Expenses - ICT Software Subscription', '5029907001', 7, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(174, NULL, 'Subscription Expenses - Other Subscription Expenses', '5029907099', 7, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(175, NULL, 'Machinery and Equipment Outlay - Other Machinery and Equipment', '5060405099', 11, 3, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(176, NULL, 'Other Bonuses and Allowances - Mid-Year Bonus - Civilian', '5010299036', 6, 1, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(177, 1929, 'Lump-sum for Step Increments - Meritorious Performance', '5010499011', 8, 1, 0, 2, NULL, NULL, 1, 0, NULL, NULL),
(178, NULL, 'Office Supplies Expenses - ICT Office Supplies', '5020301001', 14, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(179, 1953, 'Donations - Consultancy Services', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(180, 1950, 'Donations - Electricity Expenses', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(181, 1954, 'Donations - Financial Assistance to NGAs', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(182, 1951, 'Donations - Water Expenses', '5029908000', 7, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL),
(183, 2031, 'Furniture, Fixtures and Books Outlay - Furniture and Fixtures', '5060407001', 11, 2, 0, 2, NULL, NULL, 0, 0, NULL, NULL),
(184, 2005, 'Computer Software ', '5060602000', 21, 2, 0, NULL, NULL, NULL, 0, 0, NULL, NULL),
(185, NULL, 'Retirement Gratuity - Civilian', '5010402001', 8, 1, 0, NULL, NULL, NULL, 0, 0, NULL, NULL),
(186, 1985, 'Financial Assistance to NGAs - Electricity Expenses', '5010402001', 8, 2, 0, NULL, NULL, NULL, 0, 0, NULL, NULL),
(187, 993, 'Semi-Expendable Machinery and Equipment Expenses - Agricultural and Forestry Equipment', '5020321004', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(188, 996, 'Semi-Expendable Machinery and Equipment Expenses - Marine and Fishery Equipment', '5020321005', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(189, 2040, 'Semi-Expendable Machinery and Equipment Expenses - Communications Equipment', '5020321007', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(190, 1008, 'Semi-Expendable Machinery and Equipment Expenses - Disaster Response and Rescue Equipment', '5020321008', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(191, 1293, 'Semi-Expendable Machinery and Equipment Expenses - Military Police and Security Equipment', '5020321009', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(192, 1289, 'Semi-Expendable Machinery and Equipment Expenses - Medical Equipment', '5020321010', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(193, 990, 'Semi-Expendable Machinery and Equipment Expenses - Printing Equipment', '5020321011', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(194, 1019, 'Semi-Expendable Machinery and Equipment Expenses - Sports Equipment', '5020321012', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(195, 1022, 'Semi-Expendable Machinery and Equipment Expenses - Technical and Scientific Equipment', '5020321013', 14, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(196, NULL, 'Machinery and Equipment Outlay - Agricultural and Forestry Equipment', '5060405004', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(197, NULL, 'Machinery and Equipment Outlay - Marine and Fishery Equipment', '5060405005', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(198, NULL, 'Machinery and Equipment Outlay - Communication Equipment', '5060405007', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(199, NULL, 'Machinery and Equipment Outlay - Construction and Heavy Equipment', '5060405008', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(200, NULL, 'Machinery and Equipment Outlay - Disaster Response and Rescue Equipment', '5060405009', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(201, NULL, 'Machinery and Equipment Outlay - Military, Police and Security Equipment', '5060405010', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(202, NULL, 'Machinery and Equipment Outlay - Medical Equipment', '5060405011', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(203, NULL, 'Machinery and Equipment Outlay - Printing Equipment', '5060405012', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(204, NULL, 'Machinery and Equipment Outlay - Sports Equipment', '5060405013', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(205, NULL, 'Machinery and Equipment Outlay - Technical and Scientific Equipment', '5060405014', 11, 3, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(206, NULL, 'Rent/Lease Expenses', '5029905000', 7, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(207, 1310, 'Subscription Expenses', '5029907000', 7, 2, 0, NULL, NULL, NULL, 1, 0, NULL, NULL),
(208, NULL, 'Accountable Forms', '5020302000', 14, 2, 0, 1, NULL, NULL, 1, 0, NULL, NULL),
(209, NULL, 'Service Recognition Incentive', '5010499099', 8, 1, 0, 1, NULL, NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `library_object_specific`
--

CREATE TABLE `library_object_specific` (
  `id` bigint UNSIGNED NOT NULL,
  `object_specific` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_expenditure_id` bigint UNSIGNED NOT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_object_specific`
--

INSERT INTO `library_object_specific` (`id`, `object_specific`, `object_expenditure_id`, `tags`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Accommodation', 61, NULL, 0, 0, '2022-09-20 02:22:55', '2022-09-20 02:22:55'),
(2, 'Acquisition of Computer Peripherals', 66, NULL, 1, 0, '2022-09-20 02:22:55', '2022-09-20 02:22:55'),
(3, 'Annual Medical Examination', 41, NULL, 0, 0, '2022-09-20 02:22:55', '2022-09-20 02:22:55'),
(4, 'Attendance to Conference, Symposium, Convention, etc.', 81, NULL, 0, 0, '2022-09-20 02:22:55', '2022-09-20 02:22:55'),
(5, 'Brand Ambassador', 41, NULL, 1, 0, '2022-09-20 02:22:55', '2022-09-20 02:22:55'),
(6, 'Building Insurance', 20, NULL, 1, 0, '2022-09-20 02:22:55', '2022-09-20 02:22:55'),
(7, '16-Personal Development Award-Cash Award (fully self-financed)-Completed Doctoral Degree', 40, NULL, 1, 0, '2022-09-20 02:22:55', '2022-09-20 02:22:55'),
(8, '17-Personal Development Award-Cash Award (fully self-financed)-Completed Masteral Degree', 40, NULL, 1, 0, '2022-09-20 02:22:56', '2022-09-20 02:22:56'),
(9, '18-Personal Development Award-Cash Award (partially self-financed)-Completed Doctoral Degree', 40, NULL, 1, 0, '2022-09-20 02:22:56', '2022-09-20 02:22:56'),
(10, '19-Personal Development Award-Cash Award (partially self-financed)-Completed Masteral Degree', 40, NULL, 1, 0, '2022-09-20 02:22:56', '2022-09-20 02:22:56'),
(11, 'CCTV Maintenance', 56, NULL, 1, 0, '2022-09-20 02:22:56', '2022-09-20 02:22:56'),
(12, 'ISO Certification', 9, NULL, 1, 0, '2022-09-20 02:22:56', '2022-09-20 02:22:56'),
(13, 'Clearing of Grassess (near Sports Complex)', 55, NULL, 1, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(14, 'Common-Use Office Supplies', 32, NULL, 0, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(15, 'Common-use Supplies Pooled at FAD-Property', 32, NULL, 1, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(16, 'Competency-Based HRM Training (remaining module)', 81, NULL, 0, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(17, 'Consortia Led Non-degree Trainings for the NARRDN', 81, NULL, 0, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(18, 'Consultancy, Voice Over, etc.', 41, NULL, 0, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(19, 'Contract of Service (COS)', 41, NULL, 1, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(20, 'Contract Services-Project Administrative Aide VI, Project Assistant I, Project Assistant II, and Project Administrative Assistant III (Psychometrician)', 41, NULL, 1, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(21, 'Contract Services-Project Administrative Assistant II', 41, NULL, 1, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(22, 'Contract Services-Project Technical Aide II', 41, NULL, 1, 0, '2022-09-20 02:22:57', '2022-09-20 02:22:57'),
(23, 'Contract Services-Project Technical Assistant IV', 41, NULL, 1, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(24, 'Contract Services-Project Technical Assistant IV/SRS I', 41, NULL, 1, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(25, 'Contract Services-Project Technical Specialist I/SRS II', 41, NULL, 1, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(26, 'Copier, etc.', 58, NULL, 0, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(27, 'Copier/Duplicating Machine', 58, NULL, 1, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(28, 'GREAT', 81, NULL, 0, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(29, 'Re-entry Grant - MS', 81, NULL, 0, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(30, 'Sandwich Program', 81, NULL, 0, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(31, 'Thesis Support - MS', 90, NULL, 1, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(32, 'Donations for the S&T Awards', 4, NULL, 1, 0, '2022-09-20 02:22:58', '2022-09-20 02:22:58'),
(33, 'Employees Group Insurance', 20, NULL, 1, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(34, 'Enhanced PABX/IP-PBX', 76, NULL, 1, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(35, 'Evaluation of Awards Honorarium', 41, NULL, 1, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(36, 'Fabrication of Exhibit Materials', 42, NULL, 1, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(37, 'Fabrication of Plaques', 42, NULL, 1, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(38, 'Financial Support/Support to Professional & Scientific Organizations (c/o OED-ARMSS)', 4, NULL, 0, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(39, 'First Aid Supplies & Medicines', 42, NULL, 0, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(40, 'Food', 61, NULL, 0, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(41, 'Venue', 61, NULL, 0, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(42, '11-Gintong Butil Award-1st Runner Up - Junior Administrative', 40, NULL, 1, 0, '2022-09-20 02:22:59', '2022-09-20 02:22:59'),
(43, '09-Gintong Butil Award-1st Runner Up - Junior Technical', 40, NULL, 1, 0, '2022-09-20 02:23:00', '2022-09-20 02:23:00'),
(44, '10-Gintong Butil Award-1st Runner Up - Senior Administrative', 40, NULL, 1, 0, '2022-09-20 02:23:00', '2022-09-20 02:23:00'),
(45, '08-Gintong Butil Award-1st Runner Up - Senior Technical', 40, NULL, 1, 0, '2022-09-20 02:23:00', '2022-09-20 02:23:00'),
(46, '15-Gintong Butil Award-2nd Runner Up - Junior Administrative', 40, NULL, 1, 0, '2022-09-20 02:23:00', '2022-09-20 02:23:00'),
(47, '13-Gintong Butil Award-2nd Runner Up - Junior Technical', 40, NULL, 1, 0, '2022-09-20 02:23:00', '2022-09-20 02:23:00'),
(48, '14-Gintong Butil Award-2nd Runner Up - Senior Administrative', 40, NULL, 1, 0, '2022-09-20 02:23:00', '2022-09-20 02:23:00'),
(49, '12-Gintong Butil Award-2nd Runner Up - Senior Technical', 40, NULL, 1, 0, '2022-09-20 02:23:01', '2022-09-20 02:23:01'),
(50, 'Grammarly', 71, NULL, 1, 0, '2022-09-20 02:23:01', '2022-09-20 02:23:01'),
(51, 'Group Non-degree Trainings for the Secretariat', 81, NULL, 0, 0, '2022-09-20 02:23:01', '2022-09-20 02:23:01'),
(52, 'Honorarium', 41, NULL, 1, 0, '2022-09-20 02:23:01', '2022-09-20 02:23:01'),
(53, 'ICT Software', 70, NULL, 1, 0, '2022-09-20 02:23:01', '2022-09-20 02:23:01'),
(54, 'Evaluator\'s Honorarium for Program/Project Review', 41, NULL, 1, 0, '2022-09-20 02:23:01', '2022-09-20 02:23:01'),
(55, 'Prepaid Mobile Load/Cellcard/Data', 77, NULL, 1, 0, '2022-09-20 02:23:01', '2022-09-20 02:23:01'),
(56, 'Including Data', 77, NULL, 0, 0, '2022-09-20 02:23:02', '2022-09-20 02:23:02'),
(57, 'Lights & Sounds', 51, NULL, 1, 0, '2022-09-20 02:23:02', '2022-09-20 02:23:02'),
(58, 'Individual (Local)', 81, NULL, 0, 0, '2022-09-20 02:23:02', '2022-09-20 02:23:02'),
(59, 'Individual (Proposed International Trainings)', 81, NULL, 0, 0, '2022-09-20 02:23:02', '2022-09-20 02:23:02'),
(60, 'Individual Non-degree Trainings for the Secretariat - Local', 81, NULL, 0, 0, '2022-09-20 02:23:02', '2022-09-20 02:23:02'),
(61, 'Individual Non-degree Trainings for the Secretariat - Proposed International Trainings', 81, NULL, 0, 0, '2022-09-20 02:23:02', '2022-09-20 02:23:02'),
(62, 'Building Maintenance (Laundry Services)', 54, NULL, 1, 0, '2022-09-20 02:23:02', '2022-09-20 02:23:02'),
(63, 'Mailing of Publications', 48, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(64, 'Major and Minor Vehicle Repair', 60, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(65, 'Managed Print Services', 51, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(66, '02-Management Award-1st Runner Up - MEA', 40, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(67, '03-Management Award-2nd Runner Up - MEA', 40, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(68, '01-Management Award-Management Excellence Award (MEA)', 40, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(69, 'Membership to APAFRI', 52, NULL, 0, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(70, 'Membership to FORESPI', 52, NULL, 0, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(71, 'Metered Stamps (Loading of Postage)', 48, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(72, '07-Most Outstanding Employee Award-Junior Non-Supervisory/ Administrative', 40, NULL, 1, 0, '2022-09-20 02:23:03', '2022-09-20 02:23:03'),
(73, '05-Most Outstanding Employee Award-Junior Technical', 40, NULL, 1, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(74, '06-Most Outstanding Employee Award-Senior Administrative', 40, NULL, 1, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(75, '04-Most Outstanding Employee Award-Senior Technical', 40, NULL, 1, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(76, 'Network Infrastructure', 56, NULL, 1, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(77, 'Newspaper', 71, NULL, 1, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(78, 'Non-Degree Trainings for the NARRDN', 81, NULL, 0, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(79, 'Non-Degree Trainings for the Secretariat-Attendance to Conferences/Seminars/Conventions', 81, NULL, 0, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(80, 'Non-Structural Pest Control Services', 54, NULL, 1, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(81, 'Notarization', 24, NULL, 1, 0, '2022-09-20 02:23:04', '2022-09-20 02:23:04'),
(82, 'Other Awards (on-the-spot incentives)', 40, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(83, 'Aircoolers, Grass Cutters, etc.', 58, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(84, 'Other Sports Supplies', 42, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(85, 'Others Contract Services', 41, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(86, 'Parts, Materials, Lubricants & Mechanical Supplies', 60, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(87, 'PCAARRD-wide Team Building', 86, NULL, 0, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(88, 'PCAARRD-wide Team Building-Other Supplies Expenses', 42, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(89, 'PO Box Rental', 48, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(90, 'Improvement of Streetlight Electrical Sectioning', 42, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(91, 'Computer Supplies Expenses', 34, NULL, 1, 0, '2022-09-20 02:23:05', '2022-09-20 02:23:05'),
(92, 'Other Supplies Expenses', 42, NULL, 1, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(93, 'Postage and Deliveries', 48, NULL, 1, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(94, 'Preventive Maintenance of Computers', 56, NULL, 1, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(95, 'Printing of PCAARRD Publications', 49, NULL, 1, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(96, 'Provision of Incentives Toward Publishing Scientific Work in Refereed Journals ', 49, NULL, 0, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(97, 'Refill of Fire Extinguishers', 42, NULL, 1, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(98, 'Registration Fee', 61, NULL, 0, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(99, 'Registration/ License Fee - IP Filing', 74, NULL, 1, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(100, 'Regular and Procurement Trips', 86, NULL, 0, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(101, 'Repair and Maintenance of Audio-Visual Equipment', 56, NULL, 1, 0, '2022-09-20 02:23:06', '2022-09-20 02:23:06'),
(102, 'Repair and Upgrade of Audio-Visual Production Facilities', 56, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(103, 'Honorarium (Resource Speakers/Interviewees)', 41, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(104, 'Shuttle Service', 88, NULL, 0, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(105, 'SMTP', 70, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(106, 'Sports Uniform/Singlets', 42, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(107, 'SSL with 4 domains', 72, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(108, 'Streamyard', 41, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(109, 'Supplies for Building Maintenance', 42, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(110, 'Supplies for Mailing of PCAARRD Publications', 32, NULL, 1, 0, '2022-09-20 02:23:07', '2022-09-20 02:23:07'),
(111, 'Support to PCAARRD Operations in the Region', 4, NULL, 0, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(112, 'Support to Regional R&D and S&T Services', 4, NULL, 0, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(113, 'Support to Regional S&T Week (RSTW)', 4, NULL, 0, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(114, 'Support to S&T Events - Regional FIESTA', 4, NULL, 0, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(115, 'Token (NSTW, LBSC, Virtual Exhibit, T2P, etc.)', 101, NULL, 1, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(116, 'Structural Pest Control Services', 54, NULL, 0, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(117, 'Towing Services', 60, NULL, 1, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(118, 'Traveling Expenses for the ICOS', 86, NULL, 0, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(119, 'Trophy', 42, NULL, 1, 0, '2022-09-20 02:23:08', '2022-09-20 02:23:08'),
(120, 'T-shirts (Official Uniform)', 42, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(121, 'Vehicle Accessories', 60, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(122, 'Vehicle Insurance', 20, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(123, 'Vehicle Registration', 60, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(124, 'Voice Over', 41, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(125, 'Wired Connectivity (DPITC)', 75, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(126, 'Wired Connectivity (iGate)', 75, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(127, 'Wired Connectivity (Local Loop)', 75, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(128, 'Wired Connectivity (Postpaid)', 75, NULL, 1, 0, '2022-09-20 02:23:09', '2022-09-20 02:23:09'),
(129, 'Acquisition of Computer Peripherals', 56, NULL, 1, 0, '2022-09-20 03:17:12', '2022-09-20 03:17:12'),
(130, 'Contract of Service (COS)', 19, NULL, 0, 0, '2022-09-20 03:49:01', '2022-09-20 03:49:01'),
(131, 'Computer Rentals', 51, NULL, 1, 0, '2022-09-20 05:02:02', '2022-09-20 05:02:02'),
(132, 'Balik Scientist Program (BSP)', 15, NULL, 0, 0, '2022-09-21 02:19:58', '2022-09-21 02:19:58'),
(133, 'PLDT', 76, NULL, 1, 0, '2022-09-27 03:22:45', '2022-09-27 03:22:45'),
(134, 'Contract Services-Project Administrative Aide VI', 41, NULL, 1, 0, '2022-09-28 16:07:54', '2022-09-28 16:07:54'),
(135, 'Honorarium (Technoforum)', 41, NULL, 1, 0, '2022-09-28 16:11:04', '2022-09-28 16:11:04'),
(136, 'Giveaways/Tokens', 42, NULL, 1, 0, '2022-09-28 16:39:51', '2022-09-28 16:39:51'),
(137, 'Fabrication (Branding for Exhibit Materials)', 42, NULL, 1, 0, '2022-09-29 08:49:01', '2022-09-29 08:49:01'),
(138, 'Video Premier, 2T Google Storage, Canva, Envato, YouTube Boost', 70, NULL, 1, 0, '2022-09-29 08:51:17', '2022-09-29 08:51:17'),
(139, 'Web Developer for Virtual Exhibit', 19, NULL, 1, 0, '2022-09-29 08:51:32', '2022-09-29 08:51:32'),
(140, 'Honorarium (Saribuhay)', 41, NULL, 1, 0, '2022-09-29 08:51:47', '2022-09-29 08:51:47'),
(141, 'Printing of Posters/Tarpauline', 49, NULL, 1, 0, '2022-09-29 11:16:00', '2022-09-29 11:16:00'),
(142, 'Extraordinary Expenses', 13, NULL, 0, 0, '2022-10-03 15:50:19', '2022-10-03 15:50:19'),
(143, 'Miscellaneous Expenses', 13, NULL, 0, 0, '2022-10-03 15:50:19', '2022-10-03 15:50:19'),
(144, 'iGREAT', 81, NULL, 1, 0, '2022-10-05 11:14:26', '2022-10-05 11:14:26'),
(145, 'Attendance to Conference, Symposium, Convention, etc.', 81, NULL, 0, 0, '2022-10-06 13:11:56', '2022-10-06 13:11:56'),
(146, 'Honorarium', 41, NULL, 1, 0, '2022-10-09 16:36:34', '2022-10-09 16:36:34'),
(147, 'Overtime Services of Drivers', 41, NULL, 1, 0, '2022-10-09 16:38:14', '2022-10-09 16:38:14'),
(148, 'Thesis Support - PhD', 90, NULL, 1, 0, '2022-10-10 16:25:33', '2022-10-10 16:25:33'),
(149, 'Re-entry Grant - PhD', 81, NULL, 0, 0, '2022-10-10 16:33:27', '2022-10-10 16:33:27'),
(150, 'Stipend - MS - Scheme 2', 90, NULL, 1, 0, '2022-10-10 16:37:26', '2022-10-10 16:37:26'),
(151, 'Stipend - PhD -Scheme 2', 90, NULL, 1, 0, '2022-10-10 16:37:26', '2022-10-10 16:37:26'),
(152, 'Assistantship - MS-Scheme 1 and 3', 90, NULL, 1, 0, '2022-10-10 16:37:38', '2022-10-10 16:37:38'),
(153, 'Assistantship - PhD-Scheme 1 and 3', 90, NULL, 1, 0, '2022-10-10 16:37:38', '2022-10-10 16:37:38'),
(154, 'Book Allowance', 90, NULL, 1, 0, '2022-10-10 16:37:52', '2022-10-10 16:37:52'),
(155, 'Tuition', 90, NULL, 1, 0, '2022-10-10 16:37:52', '2022-10-10 16:37:52'),
(156, 'Thesis Grant', 90, NULL, 1, 0, '2022-10-10 16:38:05', '2022-10-10 16:38:05'),
(157, 'Dissertation Grant', 90, NULL, 1, 0, '2022-10-10 16:38:05', '2022-10-10 16:38:05'),
(158, 'Additional Dissertation Grant', 90, NULL, 1, 0, '2022-10-10 16:38:10', '2022-10-10 16:38:10'),
(159, 'Foreign Travel Grant', 85, NULL, 1, 0, '2022-10-10 16:38:38', '2022-10-10 16:38:38'),
(160, 'Insurance', 20, NULL, 1, 0, '2022-10-10 16:40:54', '2022-10-10 16:40:54'),
(161, 'Publication Fee', 90, NULL, 1, 0, '2022-10-10 16:41:58', '2022-10-10 16:41:58'),
(162, 'Travel Expenses - Scholars', 86, NULL, 0, 0, '2022-10-11 09:44:09', '2022-10-11 09:44:09'),
(163, 'Travel Expenses - PCAARRD Staff', 86, NULL, 0, 0, '2022-10-11 09:44:09', '2022-10-11 09:44:09'),
(164, 'Graduation Fee - MS', 90, NULL, 1, 0, '2022-10-11 09:44:28', '2022-10-11 09:44:28'),
(165, 'Graduation Fee - PhD', 90, NULL, 1, 0, '2022-10-11 09:44:28', '2022-10-11 09:44:28'),
(166, 'GREAT Convention', 81, NULL, 0, 0, '2022-10-11 09:44:34', '2022-10-11 09:44:34'),
(167, 'Contract Services - Science Research Assistant', 41, NULL, 1, 0, '2022-10-11 09:46:17', '2022-10-11 09:46:17'),
(168, 'iGREAT Assistantship at P100,000 per Scholar', 90, NULL, 0, 0, '2022-10-11 09:52:44', '2022-10-11 09:52:44'),
(169, 'iGREAT Assistantship at P150,000 per Scholar', 90, NULL, 0, 0, '2022-10-11 09:52:44', '2022-10-11 09:52:44'),
(170, 'iGREAT Assistantship at P1,000,000 per Scholar', 90, NULL, 0, 0, '2022-10-11 09:52:55', '2022-10-11 09:52:55'),
(171, 'iGREAT Assistantship at P10,000,000 per Scholar', 90, NULL, 0, 0, '2022-10-11 09:52:55', '2022-10-11 09:52:55'),
(172, 'Research Fee', 95, NULL, 1, 0, '2022-10-11 09:53:24', '2022-10-11 09:53:24'),
(173, 'Travel Expenses', 90, NULL, 1, 0, '2022-10-11 09:53:43', '2022-10-11 09:53:43'),
(174, 'Stipend', 90, NULL, 1, 0, '2022-10-11 09:53:57', '2022-10-11 09:53:57'),
(175, 'Non-Degree Trainings - Face to Face', 81, NULL, 1, 0, '2022-10-11 09:54:41', '2022-10-11 09:54:41'),
(176, 'Non-Degree Trainings - Online (Synchronous)', 81, NULL, 1, 0, '2022-10-11 09:54:41', '2022-10-11 09:54:41'),
(177, 'Non-Degree Trainings - Online (Asynchronous)', 81, NULL, 1, 0, '2022-10-11 09:54:46', '2022-10-11 09:54:46'),
(178, 'Travel Expenses (Foreign Universities/Research Institutes)', 85, NULL, 1, 0, '2022-10-11 13:38:56', '2022-10-11 13:38:56'),
(179, 'Publication Incentives at 60,000 PhP per Article', 91, NULL, 1, 0, '2022-10-11 13:41:41', '2022-10-11 13:41:41'),
(180, 'Publication Incentives at 25,000 PhP per Article', 91, NULL, 1, 0, '2022-10-11 13:41:57', '2022-10-11 13:41:57'),
(181, 'Publication Incentives at 70,000 PhP per Article', 91, NULL, 1, 0, '2022-10-11 13:41:57', '2022-10-11 13:41:57'),
(182, 'Publication Incentives at 80,000 PhP per Article', 91, NULL, 1, 0, '2022-10-11 13:42:01', '2022-10-11 13:42:01'),
(183, 'Short-Term Awardees 30 days ', 90, NULL, 1, 0, '2022-10-11 13:42:43', '2022-10-11 13:42:43'),
(184, 'Short-Term Awardees 40 days ', 90, NULL, 1, 0, '2022-10-11 13:42:43', '2022-10-11 13:42:43'),
(185, 'Short-Term Awardees 60 days ', 90, NULL, 1, 0, '2022-10-11 13:42:55', '2022-10-11 13:42:55'),
(186, 'Short-Term Awardees 90 days ', 90, NULL, 1, 0, '2022-10-11 13:42:55', '2022-10-11 13:42:55'),
(187, 'Short-Term Awardee 120 days ', 90, NULL, 1, 0, '2022-10-11 13:43:08', '2022-10-11 13:43:08'),
(188, 'Short-Term Awardee 180 days ', 90, NULL, 1, 0, '2022-10-11 13:43:08', '2022-10-11 13:43:08'),
(189, 'Continuing Short-Term Awardees 95 days ', 90, NULL, 1, 0, '2022-10-11 13:43:19', '2022-10-11 13:43:19'),
(190, 'Long-Term Awardees (budget for Y1 only)', 90, NULL, 1, 0, '2022-10-11 13:43:19', '2022-10-11 13:43:19'),
(191, 'Continuing Long-Term Awardees (budget for 12 months)', 90, NULL, 1, 0, '2022-10-11 13:43:32', '2022-10-11 13:43:32'),
(192, 'One Time Incentive', 90, NULL, 1, 0, '2022-10-11 13:43:32', '2022-10-11 13:43:32'),
(193, 'Other Benefits', 90, NULL, 1, 0, '2022-10-11 13:43:36', '2022-10-11 13:43:36'),
(194, 'Airfare (New Short-Term Awardee)', 85, NULL, 1, 0, '2022-10-11 13:44:03', '2022-10-11 13:44:03'),
(195, 'Airfare (New Long-Term Awardee)', 85, NULL, 1, 0, '2022-10-11 13:44:03', '2022-10-11 13:44:03'),
(196, 'Excess Baggage', 85, NULL, 1, 0, '2022-10-11 13:44:07', '2022-10-11 13:44:07'),
(197, 'Repair and Improvement of GSS Building', 54, NULL, 1, 0, '2022-10-11 13:47:18', '2022-10-11 13:47:18'),
(198, 'Repair and Repainting of PSF Building', 54, NULL, 1, 0, '2022-10-11 13:47:18', '2022-10-11 13:47:18'),
(199, 'Repair and Improvement of CRD and LRD Office', 54, NULL, 1, 0, '2022-10-11 13:47:25', '2022-10-11 13:47:25'),
(200, 'Repair and Repainting of Backyard Fence', 55, NULL, 1, 0, '2022-10-11 13:48:48', '2022-10-11 13:48:48'),
(201, 'Repair and Repainting of Basketball, Volleyball, and Tennis Courts', 55, NULL, 1, 0, '2022-10-11 13:48:48', '2022-10-11 13:48:48'),
(202, 'Repair and Improvement of Emergency Fire Protection Water Lines Phase 2', 55, NULL, 1, 0, '2022-10-11 13:49:09', '2022-10-11 13:49:09'),
(203, 'Improvement of LED Wall Cover', 55, NULL, 1, 0, '2022-10-11 13:49:09', '2022-10-11 13:49:09'),
(204, 'Improvement of Streetlight Electrical Sectioning', 55, NULL, 1, 0, '2022-10-11 13:49:25', '2022-10-11 13:49:25'),
(205, 'Emergency Repair Works and Variation Work Orders (VWO) ', 55, NULL, 1, 0, '2022-10-11 13:49:25', '2022-10-11 13:49:25'),
(206, 'Airconditioner', 58, NULL, 1, 0, '2022-10-11 13:50:28', '2022-10-11 13:50:28'),
(207, 'Fire Alarm', 58, NULL, 1, 0, '2022-10-11 13:50:28', '2022-10-11 13:50:28'),
(208, 'Generator', 58, NULL, 1, 0, '2022-10-11 13:50:34', '2022-10-11 13:50:34'),
(209, 'Elevator', 58, NULL, 1, 0, '2022-10-11 13:51:42', '2022-10-11 13:51:42'),
(210, 'Switchgear', 58, NULL, 1, 0, '2022-10-11 13:52:06', '2022-10-11 13:52:06'),
(211, 'Water Distribution System ', 58, NULL, 1, 0, '2022-10-11 13:52:06', '2022-10-11 13:52:06'),
(212, 'Content Creation and Production', 82, NULL, 1, 0, '2022-10-11 14:44:55', '2022-10-11 14:44:55'),
(213, 'Crops R&D', 95, NULL, 0, 0, '2022-11-03 08:53:18', '2022-11-03 08:53:18'),
(214, 'Livestock R&D', 95, NULL, 0, 0, '2022-11-03 08:53:24', '2022-11-03 08:53:24'),
(215, 'Inland Aquatic R&D', 95, NULL, 0, 0, '2022-11-03 08:54:53', '2022-11-03 08:54:53'),
(216, 'Marine Resources R&D', 95, NULL, 0, 0, '2022-11-03 08:55:11', '2022-11-03 08:55:11'),
(217, 'Forestry and Environment R&D', 95, NULL, 0, 0, '2022-11-03 08:55:19', '2022-11-03 08:55:19'),
(218, 'Agricultural Resources Management R&D', 95, NULL, 0, 0, '2022-11-03 08:55:25', '2022-11-03 08:55:25'),
(219, 'Socio-Economic R&D', 95, NULL, 0, 0, '2022-11-03 08:55:33', '2022-11-03 08:55:33'),
(220, 'Technology Transfer & Promotion', 95, NULL, 0, 0, '2022-11-03 08:55:39', '2022-11-03 08:55:39'),
(221, 'Contract Services-Clerk III', 41, NULL, 1, 0, '2023-02-01 13:54:49', '2023-02-01 13:54:49'),
(222, 'Contract Services-Science Research Analyst', 41, NULL, 1, 0, '2023-02-02 09:44:55', '2023-02-02 09:44:55'),
(223, 'Gasoline, etc.', 88, NULL, 1, 0, '2023-05-07 15:39:16', '2023-05-07 15:39:16'),
(224, 'Ads', 1, NULL, 1, 0, '2023-05-07 15:39:22', '2023-05-07 15:39:22'),
(225, 'Mailing of Publications', 83, NULL, 1, 0, '2023-05-08 09:04:42', '2023-05-08 09:04:42'),
(226, 'Mailing of Publications', 24, NULL, 1, 0, '2023-06-09 01:04:44', '2023-06-09 01:04:44'),
(227, 'Fabrication of Exhibit Materials', 41, NULL, 1, 0, '2023-09-18 05:29:05', '2023-09-18 05:29:05'),
(228, 'Software Licenses', 42, NULL, 1, 0, '2024-01-16 01:57:31', '2024-01-16 01:57:31'),
(229, 'Copier, etc.', 57, NULL, 1, 0, '2024-01-16 06:28:31', '2024-01-16 06:28:31'),
(230, 'Copier/Duplicating Machine', 57, NULL, 1, 0, '2024-01-16 06:28:43', '2024-01-16 06:28:43'),
(231, 'Aircoolers, Grass Cutters, etc.', 57, NULL, 1, 0, '2024-01-16 06:29:16', '2024-01-16 06:29:16'),
(232, 'Airconditioner', 57, NULL, 1, 0, '2024-01-16 06:29:16', '2024-01-16 06:29:16'),
(233, 'Fire Alarm', 57, NULL, 1, 0, '2024-01-16 06:29:16', '2024-01-16 06:29:16'),
(234, 'Generator', 57, NULL, 1, 0, '2024-01-16 06:29:16', '2024-01-16 06:29:16'),
(235, 'Elevator', 57, NULL, 1, 0, '2024-01-16 06:29:39', '2024-01-16 06:29:39'),
(236, 'Switchgear', 57, NULL, 1, 0, '2024-01-16 06:29:39', '2024-01-16 06:29:39'),
(237, 'Water Distribution System ', 57, NULL, 1, 0, '2024-01-16 06:29:39', '2024-01-16 06:29:39'),
(238, 'Repair and Maintenance of Audio-Visual Equipment', 58, NULL, 1, 0, '2024-01-17 00:55:25', '2024-01-17 00:55:25'),
(239, 'Lights & Sounds', 206, NULL, 1, 0, '2024-01-17 01:50:56', '2024-01-17 01:50:56'),
(240, 'ICT Consultancy (Web Developer)', 41, NULL, 1, 0, '2024-01-17 01:51:55', '2024-01-17 01:51:55'),
(241, 'Contract Services-Project Administrative Aide V', 41, NULL, 1, 0, '2024-02-02 00:47:11', '2024-02-02 00:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `library_pap`
--

CREATE TABLE `library_pap` (
  `id` bigint UNSIGNED NOT NULL,
  `old_id` bigint UNSIGNED DEFAULT NULL,
  `pap` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pap_code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `request_status_type_id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `default_all` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_pap`
--

INSERT INTO `library_pap` (`id`, `old_id`, `pap`, `pap_code`, `description`, `parent_id`, `request_status_type_id`, `division_id`, `default_all`, `remarks`, `tags`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'General Administration and Support', '100000000000000', NULL, NULL, 1, 0, 0, NULL, NULL, 0, 0, '2023-01-29 13:56:42', '2023-03-14 18:56:22'),
(2, 2, 'General Management and Supervision', '100000100001000', NULL, 1, 1, 0, 1, NULL, NULL, 1, 0, '2023-01-29 13:56:44', '2023-03-14 18:56:22'),
(3, 15, 'Administration of Personnel Benefits', '100000100002000', NULL, 1, 1, 13, 0, NULL, NULL, 1, 0, '2023-01-29 13:56:45', '2023-03-14 18:56:22'),
(4, 3, 'Operations', '300000000000000', NULL, NULL, 1, 0, 0, NULL, NULL, 0, 0, '2023-01-29 13:56:56', '2023-03-14 18:56:22'),
(5, 24, 'OO:  Increased benefits to Filipinos from science-based know-how and tools for agricultural productivity in the agriculture, aquatic and natural resources (AANR) Sectors', '310000000000000', NULL, 4, 1, 0, 0, NULL, NULL, 0, 0, '2023-01-29 13:56:55', '2023-03-14 18:56:22'),
(6, 25, 'National AANR Sector R&D Program', '310100000000000', NULL, 4, 1, 0, 0, NULL, NULL, 0, 0, '2023-01-29 13:56:59', '2023-03-14 18:56:22'),
(7, 26, 'Development, integration and coordination of the National Research System for the AANR Sector', '310100100001000', NULL, 4, 1, 0, 0, NULL, NULL, 1, 0, '2023-01-29 14:00:02', '2023-03-14 18:56:22'),
(8, 17, '308601', '308601', NULL, NULL, 2, 0, 1, NULL, NULL, 1, 0, '2023-05-15 16:48:58', '2023-05-15 16:48:58'),
(9, 18, '308602', '308602', NULL, NULL, 2, 0, 1, NULL, NULL, 1, 0, '2023-05-15 16:49:40', '2023-05-15 16:49:40'),
(10, 19, '308603', '308603', NULL, NULL, 2, 0, 1, NULL, NULL, 1, 0, '2023-05-15 18:30:01', '2023-05-15 18:30:01'),
(11, 27, '308601-C', '308601-C', NULL, NULL, 3, 0, 1, NULL, NULL, 1, 0, '2023-05-15 18:30:40', '2023-05-15 18:30:40'),
(12, 14, 'Conversion of PCAMRD', '4010500001', NULL, NULL, 1, 28, 0, NULL, NULL, 1, 0, '2024-05-14 05:27:50', '2024-05-14 05:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `library_payees`
--

CREATE TABLE `library_payees` (
  `id` bigint UNSIGNED NOT NULL,
  `old_id` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `payee_type_id` bigint UNSIGNED DEFAULT NULL,
  `organization_type_id` bigint UNSIGNED DEFAULT NULL,
  `payee` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previously_named` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organization_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organization_acronym` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_initial` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_id` bigint UNSIGNED DEFAULT NULL,
  `bank_branch` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `for_remit` tinyint(1) NOT NULL DEFAULT '0',
  `bg_color` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_lbp_enrolled` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_payee_type`
--

CREATE TABLE `library_payee_type` (
  `id` bigint UNSIGNED NOT NULL,
  `payee_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_payee_type`
--

INSERT INTO `library_payee_type` (`id`, `payee_type`, `tags`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Individual', NULL, 1, 0, '2022-07-11 02:15:23', '2022-07-11 02:15:23'),
(2, 'Company', NULL, 1, 0, '2022-07-11 02:15:23', '2022-07-11 02:15:23');

-- --------------------------------------------------------

--
-- Table structure for table `library_payment_mode`
--

CREATE TABLE `library_payment_mode` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_mode` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_payment_mode`
--

INSERT INTO `library_payment_mode` (`id`, `payment_mode`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'LDDAP', 1, 0, '2023-06-11 07:17:06', NULL),
(2, 'Check', 1, 0, '2023-06-11 07:17:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `library_pay_types`
--

CREATE TABLE `library_pay_types` (
  `id` bigint UNSIGNED NOT NULL,
  `pay_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_pay_types`
--

INSERT INTO `library_pay_types` (`id`, `pay_type`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Services', 1, 0, '2023-05-19 01:57:46', NULL),
(2, 'Supplies', 1, 0, '2023-05-19 01:57:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `library_reports_signatory`
--

CREATE TABLE `library_reports_signatory` (
  `id` bigint NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `signatory1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory1_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_rs_document`
--

CREATE TABLE `library_rs_document` (
  `id` bigint NOT NULL,
  `document` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rs_transaction_type_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_rs_document`
--

INSERT INTO `library_rs_document` (`id`, `document`, `rs_transaction_type_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Copy of Appointment', 1, 1, 0, '2023-03-29 05:19:00', '2023-03-29 05:19:00'),
(2, 'Daily Time Record (DTR)', 1, 1, 0, '2023-03-29 05:19:00', '2023-03-29 05:19:00'),
(3, 'Copy of Report for Duty                                                                                                                               ', 1, 1, 0, '2023-03-29 05:19:00', '2023-03-29 05:19:00'),
(4, 'Copy of Appointment                                                                                                                                   ', 4, 1, 0, '2023-03-29 05:19:00', '2023-03-29 05:19:00'),
(5, 'Copy of Report for Duty                                                                                                                               ', 4, 1, 0, '2023-03-29 05:19:00', '2023-03-29 05:19:00'),
(6, 'Notice of Salary Adjustment                                                                                                                           ', 6, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(7, 'Approved Application for Maternity Leave', 7, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(8, 'Medical Certificate', 7, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(9, 'Approved Request /Justification', 9, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(10, 'Approved Application for Leave', 9, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(11, 'Computation of Leave Money Value (c/o Personnel)', 9, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(12, 'Approved Application for Terminal Leave', 12, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(13, 'Copy of Approved Resignation/Retirement Letter', 12, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(14, 'Computation                                                                                                                                           ', 12, 1, 0, '2023-03-29 05:19:01', '2023-03-29 05:19:01'),
(15, 'Payroll Request & Certificate of Service Rendered', 15, 1, 0, '2023-03-29 05:19:02', '2023-03-29 05:19:02'),
(16, 'Appointment                                                                                                                                           ', 15, 1, 0, '2023-03-29 05:19:02', '2023-03-29 05:19:02'),
(17, 'Copy of Appointment/Special Order (for first payment)', 17, 1, 0, '2023-03-29 05:19:02', '2023-03-29 05:19:02'),
(18, 'Certification of Services Rendered signed by the Division Director concerned and duly approved by the Deputy Executive Director for R&D', 17, 1, 0, '2023-03-29 05:19:02', '2023-03-29 05:19:02'),
(19, 'Copy of Appointment/Special Order', 19, 1, 0, '2023-03-29 05:19:02', '2023-03-29 05:19:02'),
(20, 'Payroll request & certification of service rendered                                                                                                   Payroll Request & Certification of Service Rendered', 19, 1, 0, '2023-03-29 05:19:03', '2023-03-29 05:19:03'),
(21, 'Approved Travel Order (TO)/Trip Ticket', 21, 1, 0, '2023-03-29 05:19:03', '2023-03-29 05:19:03'),
(22, 'Approved Itinerary of Travel', 21, 1, 0, '2023-03-29 05:19:03', '2023-03-29 05:19:03'),
(23, 'Official Receipts, Toll Tickets, if applicable (original & xerox, if tape or fax paper)', 21, 1, 0, '2023-03-29 05:19:03', '2023-03-29 05:19:03'),
(24, 'Copy of e-Ticket, Boarding Pass, and Terminal Fee Ticket (when applicable)', 21, 1, 0, '2023-03-29 05:19:03', '2023-03-29 05:19:03'),
(25, 'Travel Order (TO)/Trip Ticket', 25, 1, 0, '2023-03-29 05:19:04', '2023-03-29 05:19:04'),
(26, 'Itinerary of Travel', 25, 1, 0, '2023-03-29 05:19:04', '2023-03-29 05:19:04'),
(27, 'Approval for the Conduct of Activity (when applicable)', 25, 1, 0, '2023-03-29 05:19:04', '2023-03-29 05:19:04'),
(28, 'Copy of Liquidation Report                                                                                                                            ', 28, 1, 0, '2023-03-29 05:19:04', '2023-03-29 05:19:04'),
(29, 'Authority to Travel', 29, 1, 0, '2023-03-29 05:19:04', '2023-03-29 05:19:04'),
(30, 'Itinerary of Travel', 29, 1, 0, '2023-03-29 05:19:04', '2023-03-29 05:19:04'),
(31, 'Official Receipts (if applicable)                                                                                                                     ', 29, 1, 0, '2023-03-29 05:19:04', '2023-03-29 05:19:04'),
(32, 'Authority to Travel', 32, 1, 0, '2023-03-29 05:19:05', '2023-03-29 05:19:05'),
(33, 'Itinerary of Travel', 32, 1, 0, '2023-03-29 05:19:05', '2023-03-29 05:19:05'),
(34, 'Statement of Utilization and Balances', 34, 1, 0, '2023-03-29 05:19:05', '2023-03-29 05:19:05'),
(35, 'Statement of Account                                                                                                                                  ', 35, 1, 0, '2023-03-29 05:19:05', '2023-03-29 05:19:05'),
(36, 'Statement of Account', 36, 1, 0, '2023-03-29 05:19:05', '2023-03-29 05:19:05'),
(37, 'Copy of Contract (for first payment)', 37, 1, 0, '2023-03-29 05:19:06', '2023-03-29 05:19:06'),
(38, 'Daily Time Record (DTR)', 37, 1, 0, '2023-03-29 05:19:06', '2023-03-29 05:19:06'),
(39, 'Copy of Supplementary/Amended Contract                                                                                                                ', 39, 1, 0, '2023-03-29 05:19:06', '2023-03-29 05:19:06'),
(40, 'Statement of Account                                                                                                                                  ', 40, 1, 0, '2023-03-29 05:19:06', '2023-03-29 05:19:06'),
(41, 'Statement of Postage Usage and Balances', 41, 1, 0, '2023-03-29 05:19:06', '2023-03-29 05:19:06'),
(42, 'Official Receipt (OR)', 42, 1, 0, '2023-03-29 05:19:06', '2023-03-29 05:19:06'),
(43, 'Approved Request for Mailing', 42, 1, 0, '2023-03-29 05:19:06', '2023-03-29 05:19:06'),
(44, 'Official Receipt (OR)', 44, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(45, 'Approved Request for the Availment (for initial claim)', 44, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(46, 'List of Entitled Staff', 44, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(47, 'Copy of Contract', 47, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(48, 'Copy of Contract', 48, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(49, 'Contract or Letter Order                                                                                                                              ', 49, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(50, 'Invoice/Statement of Account                                                                                                                          ', 50, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(51, 'Official Receipt (OR)', 51, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(52, 'Approved Request for Holding the Activity (for seminars, workshops, and similar activities)', 51, 1, 0, '2023-03-29 05:19:07', '2023-03-29 05:19:07'),
(53, 'Invoice                                                                                                                                               ', 53, 1, 0, '2023-03-29 05:19:08', '2023-03-29 05:19:08'),
(54, 'Approved Request for Holding the Activity (for seminars, workshops, and similar activities)', 53, 1, 0, '2023-03-29 05:19:08', '2023-03-29 05:19:08'),
(55, 'Invoice                                                                                                                                               ', 55, 1, 0, '2023-03-29 05:19:08', '2023-03-29 05:19:08'),
(56, 'Official Receipt (OR)', 56, 1, 0, '2023-03-29 05:19:09', '2023-03-29 05:19:09'),
(57, 'Bill (if payment to LTO)                                                                                                                              ', 57, 1, 0, '2023-03-29 05:19:09', '2023-03-29 05:19:09'),
(58, 'Official Receipt (if reimbursement)                                                                                                                   ', 57, 1, 0, '2023-03-29 05:19:09', '2023-03-29 05:19:09'),
(59, 'Bill                                                                                                                                                  ', 59, 1, 0, '2023-03-29 05:19:09', '2023-03-29 05:19:09'),
(60, 'Copy of Notice of Renewal', 59, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(61, 'List of Bonded Officials                                                                                                                              ', 61, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(62, 'Official Receipt (if reimbursement)                                                                                                                   ', 61, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(63, 'Official Receipt (OR)', 63, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(64, 'Purchase Request', 63, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(65, 'Invoice                                                                                                                                               ', 65, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(66, 'Job Contract', 65, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(67, 'Official Receipt (OR)/Cash Invoice', 67, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(68, 'Maintenance Agreement (for first payment)', 68, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(69, 'Invoice/Statement of Account', 68, 1, 0, '2023-03-29 05:19:10', '2023-03-29 05:19:10'),
(70, 'Official Receipt (OR)/Cash Invoice', 70, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(71, 'Budget Breakdown', 71, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(72, 'Approval of Project Proposal                                                                                                                          ', 71, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(73, 'Budget Breakdown', 73, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(74, 'Approved Request to Attend/Participate                                                                                                                ', 74, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(75, 'Copy of invitation/Announcement', 74, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(76, 'Official Receipt (OR)', 76, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(77, 'Approved Request to Attend/Participate                                                                                                                ', 76, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(78, 'Copy of invitation/Announcement', 76, 1, 0, '2023-03-29 05:19:11', '2023-03-29 05:19:11'),
(79, 'Approved Request for Thesis Support', 79, 1, 0, '2023-03-29 05:19:12', '2023-03-29 05:19:12'),
(80, 'Itinerary of Travel', 80, 1, 0, '2023-03-29 05:19:12', '2023-03-29 05:19:12'),
(81, 'Official Receipts (OR)/Tickets', 80, 1, 0, '2023-03-29 05:19:12', '2023-03-29 05:19:12'),
(82, 'Approved Request', 82, 1, 0, '2023-03-29 05:19:12', '2023-03-29 05:19:12'),
(83, 'Bill/Statement of Account', 83, 1, 0, '2023-03-29 05:19:12', '2023-03-29 05:19:12'),
(84, 'Official Receipt (OR)/Cash Invoice', 84, 1, 0, '2023-03-29 05:19:12', '2023-03-29 05:19:12'),
(85, 'Approved Contract                                                                                                                                     ', 85, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(86, 'Payroll Register', 86, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(87, 'Legal Basis (for benefits when applicable)                                                                                                            ', 86, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(88, 'Approved Request for Holding the Activity (for seminars, workshops, and similar activities)', 88, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(89, 'For Initial Cash Advance (CA)—Approved Request', 89, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(90, 'Report of Disbursements', 90, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(91, 'Petty Cash Replenishment Report                                                                                                                       ', 91, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(92, 'Petty Cash Vouchers with Supporting Documents', 91, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(93, 'Schedule of Remittances', 93, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(94, 'Approved Recommendation                                                                                                                               ', 94, 1, 0, '2023-03-29 05:19:13', '2023-03-29 05:19:13'),
(95, 'Approved Contract                                                                                                                                     ', 95, 1, 0, '2023-03-29 05:19:14', '2023-03-29 05:19:14'),
(96, 'Duly Signed Purchase Order                                                                                                                            ', 96, 1, 0, '2023-03-29 05:19:14', '2023-03-29 05:19:14'),
(97, 'Duly Signed Letter Order                                                                                                                              ', 97, 1, 0, '2023-03-29 05:19:14', '2023-03-29 05:19:14'),
(98, 'Letter of Recommendation', 98, 1, 0, '2023-03-29 05:19:14', '2023-03-29 05:19:14'),
(99, 'Service Record', 98, 1, 0, '2023-03-29 05:19:14', '2023-03-29 05:19:14'),
(100, 'Appointment', 98, 1, 0, '2023-03-29 05:19:14', '2023-03-29 05:19:14'),
(101, 'Official Receipt (OR)', 2, 1, 0, '2023-07-10 05:24:55', '2023-07-10 05:24:55'),
(102, 'Certified True Copy of the pertinent Contract/Appointment/GSS approved Job Order (for first claim)', 2, 1, 0, '2023-07-10 05:25:02', '2023-07-10 05:25:02'),
(103, 'Statement of Bill', 101, 1, 0, '2024-01-31 01:15:32', '2024-01-31 01:15:32'),
(104, 'Certification of Official Calls', 101, 1, 0, '2024-01-31 01:15:38', '2024-01-31 01:15:38'),
(105, 'Official Receipt (OR)', 101, 1, 0, '2024-01-31 01:15:46', '2024-01-31 01:15:46');

-- --------------------------------------------------------

--
-- Table structure for table `library_rs_transaction_types`
--

CREATE TABLE `library_rs_transaction_types` (
  `id` bigint NOT NULL,
  `transaction_type` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allotment_class_id` bigint DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_rs_transaction_types`
--

INSERT INTO `library_rs_transaction_types` (`id`, `transaction_type`, `allotment_class_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Salary—First Payment', 1, 1, 0, '2023-03-29 05:17:58', '2023-03-29 05:17:58'),
(2, 'Legal Services-Notarization–Reimbursement', 2, 1, 0, '2023-07-10 05:25:24', '2023-07-10 05:25:24'),
(4, 'Salary Differential—Due to Promotion', 1, 1, 0, '2023-03-29 05:17:58', '2023-03-29 05:17:58'),
(6, 'Salary Differential-Due to Salary Adjustment                                                        ', 1, 1, 0, '2023-03-29 05:17:58', '2023-03-29 05:17:58'),
(7, 'Commutation of Maternity Leave                                                                      ', 1, 1, 0, '2023-03-29 05:17:58', '2023-03-29 05:17:58'),
(9, 'Commutation of Leave Credits                                                                        ', 1, 1, 0, '2023-03-29 05:17:58', '2023-03-29 05:17:58'),
(12, 'Terminal Leave                                                                                      ', 1, 1, 0, '2023-03-29 05:17:59', '2023-03-29 05:17:59'),
(15, 'Honorarium—For Governing Council (GC) Members', 1, 1, 0, '2023-03-29 05:17:59', '2023-03-29 05:17:59'),
(17, 'Honorarium—For Team Leaders', 1, 1, 0, '2023-03-29 05:17:59', '2023-03-29 05:17:59'),
(19, 'Honorarium—For Others', 1, 1, 0, '2023-03-29 05:17:59', '2023-03-29 05:17:59'),
(21, 'Travelling Expenses (Domestic Travel)—Reimbursement', 2, 1, 0, '2023-03-29 05:17:59', '2023-03-29 05:17:59'),
(25, 'Travelling Expenses (Domestic Travel)—Payment of Itinerary of Travel (Cash Advance) ', 2, 1, 0, '2023-03-29 05:17:59', '2023-03-29 05:17:59'),
(28, 'Travelling Expenses (Domestic Travel)—Reimbursement of Travel Expenses in Excess of Cash Advance', 2, 1, 0, '2023-03-29 05:18:00', '2023-03-29 05:18:00'),
(29, 'Travelling Expenses (Foreign Travel)—Reimbursement', 2, 1, 0, '2023-03-29 05:18:00', '2023-03-29 05:18:00'),
(32, 'Travelling Expenses (Foreign Travel)—Payment of Itinerary of Travel (Cash Advance)', 2, 1, 0, '2023-03-29 05:18:00', '2023-03-29 05:18:00'),
(34, 'E-Pass—Toll Fees', 2, 1, 0, '2023-03-29 05:18:00', '2023-03-29 05:18:00'),
(35, 'Payment of Plane Fare to Travel Agent', 2, 1, 0, '2023-03-29 05:18:00', '2023-03-29 05:18:00'),
(36, 'Transportation Services—Vehicle Rental', 2, 1, 0, '2023-03-29 05:18:00', '2023-03-29 05:18:00'),
(37, 'Payment of Services for Contractual                                                                 ', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(39, 'Payment of Compensation Differential for Contractual                                                ', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(40, 'Communication Expenses—Payment to Supplier-Telephone', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(41, 'Communication Expenses—Payment to Supplier-Postage (for reloading)', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(42, 'Communication Expenses—Reimbursement for Mailing', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(44, 'Communication Expenses—Reimbursement for Prepaid Cell Card', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(47, 'Janitorial Services                                                                                 ', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(48, 'Security Services', 2, 1, 0, '2023-03-29 05:18:01', '2023-03-29 05:18:01'),
(49, 'Printing of Publications                                                                            ', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(50, 'Food Expenses—Payment (to PMPC, etc.)', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(51, 'Food Expenses—Reimbursement', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(53, 'Payment for Accommodation/Venue', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(55, 'Newspaper Subscription', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(56, 'Advertisement—Reimbursement', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(57, 'Registration of Motor Vehicle', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(59, 'Insurance Premium—For Vehicle and Properties', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(61, 'Insurance Premium—For Fidelity Bond Premium', 2, 1, 0, '2023-03-29 05:18:02', '2023-03-29 05:18:02'),
(63, 'Emergency Purchase of Supplies Expense—Reimbursement', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(65, 'Repair of Motor Vehicle                                                                             ', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(67, 'Minor Repairs of Vehicles—Reimbursement', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(68, 'Maintenance of Equipment', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(70, 'Minor Repairs of Equipment—Reimbursement', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(71, 'Grants-in-Aid (GIA)—Initial Release', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(73, 'Grants-in-Aid (GIA)—Subsequent Release', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(74, 'Training/Seminar/Convention/Conference Registration Fee—Payment to Organizer', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(76, 'Training/Seminar/Convention/Conference Registration Fee—Reimbursement', 2, 1, 0, '2023-03-29 05:18:03', '2023-03-29 05:18:03'),
(79, 'Scholars\' Benefits—Thesis Support', 2, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(80, 'Scholars\' Benefits—Reimbursement of Travel Expenses (for incoming and outgoing scholars)', 2, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(82, 'Financial Support (to associations, etc.)', 2, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(83, 'Water & Electricity', 2, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(84, 'Xerox/Binding/Printing of Tarpaulin and Similar Expense—Reimbursement ', 2, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(85, 'Infrastructure Projects', 3, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(86, 'Salaries/Benefits', 0, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(88, 'Expenses for Workshops/Seminars/Trainings', 0, 1, 0, '2023-03-29 05:18:04', '2023-03-29 05:18:04'),
(89, 'Cash Advance for Petty Cash Fund by Special Disbursing Officer (SDO)', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(90, 'Replenishment of Cash Advance for MOOE by Regular Disbursing Officer (RDO)', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(91, 'Replenishment of Petty Cash Fund by Special Disbursing Officer (SDO)', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(93, 'Remittances of Deductions (to BIR, Pag-Ibig, GSIS, HDMF, PMPC, UPLB-CDC, etc.)', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(94, 'Contract for Services                                                                               ', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(95, 'Civil Works/Infrastructures                                                                         ', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(96, 'Payment of Office/Computer/Semi-Expendable & Other Supplies', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(97, 'Publications                                                                                        ', 0, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(98, 'Payment of Professional Fee', 2, 1, 0, '2023-03-29 05:18:05', '2023-03-29 05:18:05'),
(99, 'Cash Award - Best Research & Development (R&D) Paper', 2, 1, 0, '2023-10-25 05:08:42', '2023-10-25 05:08:42'),
(100, 'Cash Award - Elvira O. Tan Award', 2, 1, 0, '2023-10-25 05:09:32', '2023-10-25 05:09:32'),
(101, 'Communication Expenses—Reimbursement of Mobile Expenses', 2, 1, 0, '2024-01-31 01:14:50', '2024-01-31 01:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `library_signatories`
--

CREATE TABLE `library_signatories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `module_id` bigint UNSIGNED DEFAULT NULL,
  `signatory_no` tinyint(1) DEFAULT NULL,
  `form_id` bigint UNSIGNED DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_statuses`
--

CREATE TABLE `library_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `status` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `module_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id_from` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id_to` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_subactivity`
--

CREATE TABLE `library_subactivity` (
  `id` bigint UNSIGNED NOT NULL,
  `old_id` bigint UNSIGNED DEFAULT NULL,
  `subactivity` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subactivity_code` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_id` bigint UNSIGNED DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `tier` tinyint(1) NOT NULL,
  `tags` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_tax_types`
--

CREATE TABLE `library_tax_types` (
  `id` bigint UNSIGNED NOT NULL,
  `tax_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_tax_types`
--

INSERT INTO `library_tax_types` (`id`, `tax_type`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Vatable', 1, 0, '2023-05-29 01:26:15', NULL),
(2, 'Non-vatable', 1, 0, '2023-05-29 01:26:15', NULL),
(3, 'Exempted', 1, 0, '2023-05-29 01:26:28', NULL),
(4, 'Franchise', 1, 0, '2023-05-29 01:26:28', NULL),
(5, 'Prof. Fee', 1, 0, '2023-05-29 01:26:50', NULL),
(6, 'Salary', 1, 0, '2023-05-29 01:26:50', NULL),
(7, 'Honoraium', 1, 0, '2024-02-02 02:17:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_user_roles`
--

CREATE TABLE `model_has_user_roles` (
  `role_id` bigint UNSIGNED NOT NULL COMMENT 'user_role_id',
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL COMMENT 'user_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint UNSIGNED NOT NULL,
  `module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_cash_programs`
--

CREATE TABLE `monthly_cash_programs` (
  `id` bigint UNSIGNED NOT NULL,
  `reference_allotment_id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pap_id` bigint UNSIGNED DEFAULT NULL,
  `activity_id` bigint UNSIGNED DEFAULT NULL,
  `subactivity_id` bigint UNSIGNED DEFAULT NULL,
  `expense_account_id` bigint UNSIGNED DEFAULT NULL,
  `object_expenditure_id` bigint UNSIGNED DEFAULT NULL,
  `object_specific_id` bigint UNSIGNED DEFAULT NULL,
  `pooled_at_division_id` bigint UNSIGNED DEFAULT NULL,
  `jan_amount` double DEFAULT NULL,
  `feb_amount` double DEFAULT NULL,
  `mar_amount` double DEFAULT NULL,
  `apr_amount` double DEFAULT NULL,
  `may_amount` double DEFAULT NULL,
  `jun_amount` double DEFAULT NULL,
  `jul_amount` double DEFAULT NULL,
  `aug_amount` double DEFAULT NULL,
  `sep_amount` double DEFAULT NULL,
  `oct_amount` double DEFAULT NULL,
  `nov_amount` double DEFAULT NULL,
  `dec_amount` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nca`
--

CREATE TABLE `nca` (
  `id` bigint UNSIGNED NOT NULL,
  `fund_id` bigint UNSIGNED NOT NULL,
  `year` int NOT NULL,
  `jan_nca` double NOT NULL DEFAULT '0',
  `feb_nca` double NOT NULL DEFAULT '0',
  `mar_nca` double NOT NULL DEFAULT '0',
  `apr_nca` double NOT NULL DEFAULT '0',
  `may_nca` double NOT NULL DEFAULT '0',
  `jun_nca` double NOT NULL DEFAULT '0',
  `jul_nca` double NOT NULL DEFAULT '0',
  `aug_nca` double NOT NULL DEFAULT '0',
  `sep_nca` double NOT NULL DEFAULT '0',
  `oct_nca` double NOT NULL DEFAULT '0',
  `nov_nca` double NOT NULL DEFAULT '0',
  `dec_nca` double NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `record_id` bigint UNSIGNED DEFAULT NULL,
  `module_id` bigint UNSIGNED DEFAULT NULL,
  `link` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `division_id_from` bigint UNSIGNED DEFAULT NULL,
  `division_id_to` bigint UNSIGNED DEFAULT NULL,
  `user_id_from` bigint UNSIGNED DEFAULT NULL,
  `user_id_to` bigint UNSIGNED DEFAULT NULL,
  `user_role_id_from` bigint UNSIGNED DEFAULT NULL,
  `user_role_id_to` bigint UNSIGNED DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `particulars_template`
--

CREATE TABLE `particulars_template` (
  `id` bigint UNSIGNED NOT NULL,
  `rs_type_id` bigint UNSIGNED NOT NULL,
  `transaction_type` text CHARACTER SET latin1 COLLATE latin1_bin,
  `transaction_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `particulars` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_number`
--

CREATE TABLE `prefix_number` (
  `id` bigint NOT NULL,
  `prefix_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rs_type_id` bigint UNSIGNED DEFAULT NULL,
  `fund_id` bigint UNSIGNED DEFAULT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qop_comments`
--

CREATE TABLE `qop_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `qop_id` bigint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `comment_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_resolved` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qop_status`
--

CREATE TABLE `qop_status` (
  `id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `status_by_user_id` bigint UNSIGNED NOT NULL,
  `status_by_user_role_id` bigint UNSIGNED NOT NULL,
  `status_by_user_division_id` bigint NOT NULL,
  `date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quarterly_obligation_programs`
--

CREATE TABLE `quarterly_obligation_programs` (
  `id` bigint UNSIGNED NOT NULL,
  `reference_allotment_id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pap_id` bigint UNSIGNED DEFAULT NULL,
  `activity_id` bigint UNSIGNED DEFAULT NULL,
  `subactivity_id` bigint UNSIGNED DEFAULT NULL,
  `expense_account_id` bigint UNSIGNED DEFAULT NULL,
  `object_expenditure_id` bigint UNSIGNED DEFAULT NULL,
  `object_specific_id` bigint UNSIGNED DEFAULT NULL,
  `pooled_at_division_id` bigint UNSIGNED DEFAULT NULL,
  `q1_amount` double DEFAULT NULL,
  `q2_amount` double DEFAULT NULL,
  `q3_amount` double DEFAULT NULL,
  `q4_amount` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radai`
--

CREATE TABLE `radai` (
  `id` bigint NOT NULL,
  `radai_date` date DEFAULT NULL,
  `radai_no` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fund_id` bigint UNSIGNED DEFAULT NULL,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rci`
--

CREATE TABLE `rci` (
  `id` bigint UNSIGNED NOT NULL,
  `rci_date` date DEFAULT NULL,
  `rci_no` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fund_id` bigint UNSIGNED DEFAULT NULL,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_status`
--

CREATE TABLE `request_status` (
  `id` bigint UNSIGNED NOT NULL,
  `fais_id` bigint UNSIGNED DEFAULT NULL,
  `rs_type_id` bigint UNSIGNED DEFAULT NULL,
  `rs_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rs_date` date DEFAULT NULL,
  `rs_date1` date DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `fund_id` bigint UNSIGNED DEFAULT NULL,
  `payee_id` bigint UNSIGNED DEFAULT NULL,
  `particulars` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_rs_activity_amount` double NOT NULL DEFAULT '0',
  `total_rs_pap_amount` double NOT NULL DEFAULT '0',
  `showall` tinyint(1) NOT NULL DEFAULT '0',
  `signatory1` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory1_position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory1b` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory1b_position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory2_position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory3_position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory4_position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signatory5_position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `locked_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rs_activity`
--

CREATE TABLE `rs_activity` (
  `id` bigint NOT NULL,
  `rs_id` bigint UNSIGNED DEFAULT NULL,
  `allotment_id` bigint UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rs_pap`
--

CREATE TABLE `rs_pap` (
  `id` bigint NOT NULL,
  `rs_id` bigint UNSIGNED DEFAULT NULL,
  `allotment_id` bigint UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `notice_adjustment_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notice_adjustment_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rs_transaction_type`
--

CREATE TABLE `rs_transaction_type` (
  `id` bigint UNSIGNED NOT NULL,
  `rs_id` bigint UNSIGNED DEFAULT NULL,
  `rs_transaction_type_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_has_user_roles`
--

CREATE TABLE `users_has_user_roles` (
  `role_id` bigint UNSIGNED NOT NULL COMMENT 'user_role_id',
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL COMMENT 'user_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ada`
--
ALTER TABLE `ada`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ada_lddap`
--
ALTER TABLE `ada_lddap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adjustment`
--
ALTER TABLE `adjustment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_adjustment_allotment_idx` (`allotment_id`);

--
-- Indexes for table `allotment`
--
ALTER TABLE `allotment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_allotment_allotment_fund_idx` (`allotment_fund_id`),
  ADD KEY `FK_allotment_pcaarrd_divisions_idx` (`division_id`),
  ADD KEY `FK_allotment_fiscal_year_idx` (`year`),
  ADD KEY `FK_allotment_library_activity_idx` (`activity_id`),
  ADD KEY `FK_allotment_library_expense_account_idx` (`expense_account_id`),
  ADD KEY `FK_allotment_library_object_expenditure_idx` (`object_expenditure_id`),
  ADD KEY `FK_allotment_library_object_specific_idx` (`object_specific_id`),
  ADD KEY `FK_allotment_library_pap_idx` (`pap_id`),
  ADD KEY `FK_allotment_library_subactivity_idx` (`subactivity_id`),
  ADD KEY `FK_allotment_pcaarrd_divisions_pooled_idx` (`pooled_at_division_id`),
  ADD KEY `FK_allotment_request_status_types_idx` (`rs_type_id`);

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `bp_comments`
--
ALTER TABLE `bp_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_expenditure_comments_budget_proposal_expenditure_idx` (`budget_proposal_id`);

--
-- Indexes for table `bp_form3`
--
ALTER TABLE `bp_form3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form3_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_form4`
--
ALTER TABLE `bp_form4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form4_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_form5`
--
ALTER TABLE `bp_form5`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form5_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_form6`
--
ALTER TABLE `bp_form6`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form6_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_form7`
--
ALTER TABLE `bp_form7`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form7_location_idx` (`location_id`),
  ADD KEY `FK_bp_form7_monitoring_agency_idx` (`monitoring_agency_id`),
  ADD KEY `FK_bp_form7_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_form8`
--
ALTER TABLE `bp_form8`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form8_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_form9`
--
ALTER TABLE `bp_form9`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form9_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_form205`
--
ALTER TABLE `bp_form205`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_form3_fiscal_year_idx` (`year`),
  ADD KEY `FK_bp_form3_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `bp_status`
--
ALTER TABLE `bp_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_status_library_statuses_idx` (`status_id`),
  ADD KEY `FK_bp_status_pcaarrd_divisions_idx` (`division_id`),
  ADD KEY `FK_bp_status_user_roles_idx` (`status_by_user_role_id`),
  ADD KEY `FK_bp_status_users_idx` (`status_by_user_id`);

--
-- Indexes for table `budget_proposals`
--
ALTER TABLE `budget_proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bp_items_pcaarrd_divisions_idx` (`division_id`),
  ADD KEY `FK_bp_items_fiscal_year_idx` (`year`),
  ADD KEY `FK_bp_items_library_pap_idx` (`pap_id`),
  ADD KEY `FK_bp_items_library_activity_idx` (`activity_id`),
  ADD KEY `FK_bp_items_library_subactivity_idx` (`subactivity_id`),
  ADD KEY `FK_bp_items_library_object_expenditure_idx` (`object_expenditure_id`),
  ADD KEY `FK_bp_items_library_object_specific_idx` (`object_specific_id`),
  ADD KEY `FK_bp_items_pcaarrd_divisions_pooled_idx` (`pooled_at_division_id`),
  ADD KEY `FK_bp_items_library_expense_account_idx` (`expense_account_id`);

--
-- Indexes for table `checks`
--
ALTER TABLE `checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_comments`
--
ALTER TABLE `cp_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_expenditure_comments_budget_proposal_expenditure_idx` (`cash_program_id`);

--
-- Indexes for table `cp_status`
--
ALTER TABLE `cp_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cp_status_pcaarrd_divisions_idx` (`division_id`),
  ADD KEY `FK_cp_status_library_statuses_idx` (`status_id`),
  ADD KEY `FK_cp_status_user_roles_idx` (`status_by_user_role_id`),
  ADD KEY `FK_cp_status_users_idx` (`status_by_user_id`);

--
-- Indexes for table `disbursement_vouchers`
--
ALTER TABLE `disbursement_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_dv_payee_idx` (`payee_id`),
  ADD KEY `FK_dv_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `dv_rs`
--
ALTER TABLE `dv_rs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dv_rs_net`
--
ALTER TABLE `dv_rs_net`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dv_transaction_type`
--
ALTER TABLE `dv_transaction_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_dv_transaction_type_id` (`dv_transaction_type_id`);

--
-- Indexes for table `fiscal_year`
--
ALTER TABLE `fiscal_year`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year` (`year`) USING BTREE;

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lddap`
--
ALTER TABLE `lddap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lddap_dv`
--
ALTER TABLE `lddap_dv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_activity`
--
ALTER TABLE `library_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_library_activity_request_status_types_idx` (`request_status_type_id`),
  ADD KEY `FK_library_activity_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `library_adjustment_types`
--
ALTER TABLE `library_adjustment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_allotment_class`
--
ALTER TABLE `library_allotment_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_bank_accounts`
--
ALTER TABLE `library_bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_dv_document`
--
ALTER TABLE `library_dv_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_dv_transaction_types`
--
ALTER TABLE `library_dv_transaction_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_expense_account`
--
ALTER TABLE `library_expense_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_library_expense_account_library_activity_idx` (`activity_id`),
  ADD KEY `FK_library_expense_account_library_subactivity_idx` (`subactivity_id`);

--
-- Indexes for table `library_fund_check`
--
ALTER TABLE `library_fund_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_object_expenditure`
--
ALTER TABLE `library_object_expenditure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_library_object_expenditure_library_expense_account_idx` (`expense_account_id`),
  ADD KEY `FK_library_object_expenditure_library_allotment_class_idx` (`allotment_class_id`);

--
-- Indexes for table `library_object_specific`
--
ALTER TABLE `library_object_specific`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_library_object_specifics_library_object_expenditure_idx` (`object_expenditure_id`);

--
-- Indexes for table `library_pap`
--
ALTER TABLE `library_pap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pap_code` (`pap_code`) USING BTREE,
  ADD KEY `FK_library_pap_idx` (`parent_id`),
  ADD KEY `FK_library_pap_request_status_types_idx` (`request_status_type_id`);

--
-- Indexes for table `library_payees`
--
ALTER TABLE `library_payees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_payees_library_payee_type_idx` (`payee_type_id`),
  ADD KEY `FK_payees_payee_banks_idx` (`bank_id`);

--
-- Indexes for table `library_payee_type`
--
ALTER TABLE `library_payee_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_payment_mode`
--
ALTER TABLE `library_payment_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_pay_types`
--
ALTER TABLE `library_pay_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_reports_signatory`
--
ALTER TABLE `library_reports_signatory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_rs_document`
--
ALTER TABLE `library_rs_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_rs_transaction_types`
--
ALTER TABLE `library_rs_transaction_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_signatories`
--
ALTER TABLE `library_signatories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_signatories_forms_idx` (`form_id`),
  ADD KEY `FK_signatories_users_idx` (`user_id`);

--
-- Indexes for table `library_statuses`
--
ALTER TABLE `library_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_subactivity`
--
ALTER TABLE `library_subactivity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_library_subactivity_library_activity_idx` (`activity_id`),
  ADD KEY `FK_library_subactivity_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `library_tax_types`
--
ALTER TABLE `library_tax_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_user_roles`
--
ALTER TABLE `model_has_user_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_cash_programs`
--
ALTER TABLE `monthly_cash_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nca`
--
ALTER TABLE `nca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_notifications_from_pcaarrd_divisions_idx` (`division_id_from`),
  ADD KEY `FK_notifications_to_pcaarrd_divisions_idx` (`division_id_to`),
  ADD KEY `FK_notifications_from_user_roles_idx` (`user_role_id_from`),
  ADD KEY `FK_notifications_to_users_idx` (`user_id_to`),
  ADD KEY `FK_notifications_from_users_idx` (`user_id_from`) USING BTREE,
  ADD KEY `FK_notifications_to_user_roles_idx` (`user_role_id_to`) USING BTREE,
  ADD KEY `FK_notifications_pcaarrd_divisions_idx` (`division_id`);

--
-- Indexes for table `particulars_template`
--
ALTER TABLE `particulars_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prefix_number`
--
ALTER TABLE `prefix_number`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_prefix_number_request_status_types_idx` (`rs_type_id`);

--
-- Indexes for table `qop_comments`
--
ALTER TABLE `qop_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_expenditure_comments_budget_proposal_expenditure_idx` (`qop_id`);

--
-- Indexes for table `qop_status`
--
ALTER TABLE `qop_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_qop_status_users_idx` (`status_by_user_id`),
  ADD KEY `FK_qop_status_user_roles_idx` (`status_by_user_role_id`),
  ADD KEY `FK_qop_status_pcaarrd_divisions_idx` (`division_id`),
  ADD KEY `FK_qop_status_library_statuses_idx` (`status_id`);

--
-- Indexes for table `quarterly_obligation_programs`
--
ALTER TABLE `quarterly_obligation_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radai`
--
ALTER TABLE `radai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rcidate` (`radai_date`,`fund_id`,`bank_account_id`) USING BTREE,
  ADD KEY `rci_date` (`radai_date`) USING BTREE,
  ADD KEY `bank_account_id` (`bank_account_id`) USING BTREE,
  ADD KEY `radai_no` (`radai_no`) USING BTREE,
  ADD KEY `fund_id` (`fund_id`) USING BTREE;

--
-- Indexes for table `rci`
--
ALTER TABLE `rci`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rcidate` (`rci_date`,`fund_id`,`bank_account_id`) USING BTREE,
  ADD KEY `rci_no` (`rci_no`) USING BTREE,
  ADD KEY `fund_id` (`fund_id`) USING BTREE,
  ADD KEY `bank_account_id` (`bank_account_id`) USING BTREE,
  ADD KEY `rci_date` (`rci_date`) USING BTREE;

--
-- Indexes for table `request_status`
--
ALTER TABLE `request_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_request_and_status_funds_idx` (`fund_id`),
  ADD KEY `FK_request_and_status_pcaarrd_divisions_idx` (`division_id`),
  ADD KEY `FK_request_and_status_request_status_types_idx` (`rs_type_id`),
  ADD KEY `FK_request_and_status_library_payees_idx` (`payee_id`);

--
-- Indexes for table `rs_activity`
--
ALTER TABLE `rs_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_rs_pap_allotment_idx` (`allotment_id`),
  ADD KEY `FK_rs_pap_request_status_idx` (`rs_id`);

--
-- Indexes for table `rs_pap`
--
ALTER TABLE `rs_pap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_rs_pap_request_status_idx` (`rs_id`),
  ADD KEY `FK_rs_pap_allotment_idx` (`allotment_id`);

--
-- Indexes for table `rs_transaction_type`
--
ALTER TABLE `rs_transaction_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `FK_users_user_roles_idx` (`user_role_id`),
  ADD KEY `FK_users_hrms_users_idx` (`emp_code`);

--
-- Indexes for table `users_has_user_roles`
--
ALTER TABLE `users_has_user_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ada`
--
ALTER TABLE `ada`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ada_lddap`
--
ALTER TABLE `ada_lddap`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adjustment`
--
ALTER TABLE `adjustment`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allotment`
--
ALTER TABLE `allotment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_comments`
--
ALTER TABLE `bp_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form3`
--
ALTER TABLE `bp_form3`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form4`
--
ALTER TABLE `bp_form4`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form5`
--
ALTER TABLE `bp_form5`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form6`
--
ALTER TABLE `bp_form6`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form7`
--
ALTER TABLE `bp_form7`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form8`
--
ALTER TABLE `bp_form8`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form9`
--
ALTER TABLE `bp_form9`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_form205`
--
ALTER TABLE `bp_form205`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_status`
--
ALTER TABLE `bp_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_proposals`
--
ALTER TABLE `budget_proposals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checks`
--
ALTER TABLE `checks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_comments`
--
ALTER TABLE `cp_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_status`
--
ALTER TABLE `cp_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disbursement_vouchers`
--
ALTER TABLE `disbursement_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dv_rs`
--
ALTER TABLE `dv_rs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dv_rs_net`
--
ALTER TABLE `dv_rs_net`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dv_transaction_type`
--
ALTER TABLE `dv_transaction_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fiscal_year`
--
ALTER TABLE `fiscal_year`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lddap`
--
ALTER TABLE `lddap`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lddap_dv`
--
ALTER TABLE `lddap_dv`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_activity`
--
ALTER TABLE `library_activity`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_adjustment_types`
--
ALTER TABLE `library_adjustment_types`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `library_allotment_class`
--
ALTER TABLE `library_allotment_class`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `library_bank_accounts`
--
ALTER TABLE `library_bank_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_dv_document`
--
ALTER TABLE `library_dv_document`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1610;

--
-- AUTO_INCREMENT for table `library_dv_transaction_types`
--
ALTER TABLE `library_dv_transaction_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `library_expense_account`
--
ALTER TABLE `library_expense_account`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `library_fund_check`
--
ALTER TABLE `library_fund_check`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_object_expenditure`
--
ALTER TABLE `library_object_expenditure`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `library_object_specific`
--
ALTER TABLE `library_object_specific`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `library_pap`
--
ALTER TABLE `library_pap`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `library_payees`
--
ALTER TABLE `library_payees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_payee_type`
--
ALTER TABLE `library_payee_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `library_payment_mode`
--
ALTER TABLE `library_payment_mode`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `library_pay_types`
--
ALTER TABLE `library_pay_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `library_reports_signatory`
--
ALTER TABLE `library_reports_signatory`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_rs_document`
--
ALTER TABLE `library_rs_document`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `library_rs_transaction_types`
--
ALTER TABLE `library_rs_transaction_types`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `library_signatories`
--
ALTER TABLE `library_signatories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_statuses`
--
ALTER TABLE `library_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_subactivity`
--
ALTER TABLE `library_subactivity`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_tax_types`
--
ALTER TABLE `library_tax_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_cash_programs`
--
ALTER TABLE `monthly_cash_programs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nca`
--
ALTER TABLE `nca`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `particulars_template`
--
ALTER TABLE `particulars_template`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prefix_number`
--
ALTER TABLE `prefix_number`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qop_comments`
--
ALTER TABLE `qop_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qop_status`
--
ALTER TABLE `qop_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quarterly_obligation_programs`
--
ALTER TABLE `quarterly_obligation_programs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radai`
--
ALTER TABLE `radai`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rci`
--
ALTER TABLE `rci`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_status`
--
ALTER TABLE `request_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rs_activity`
--
ALTER TABLE `rs_activity`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rs_pap`
--
ALTER TABLE `rs_pap`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rs_transaction_type`
--
ALTER TABLE `rs_transaction_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjustment`
--
ALTER TABLE `adjustment`
  ADD CONSTRAINT `FK_adjustment_allotment_idx` FOREIGN KEY (`allotment_id`) REFERENCES `allotment` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `allotment`
--
ALTER TABLE `allotment`
  ADD CONSTRAINT `FK_allotment_allotment_fund_idx` FOREIGN KEY (`allotment_fund_id`) REFERENCES `commonlibrariesdb`.`allotment_fund` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_fiscal_year_idx` FOREIGN KEY (`year`) REFERENCES `fiscal_year` (`year`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_library_activity_idx` FOREIGN KEY (`activity_id`) REFERENCES `library_activity` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_library_expense_account_idx` FOREIGN KEY (`expense_account_id`) REFERENCES `library_expense_account` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_library_object_expenditure_idx` FOREIGN KEY (`object_expenditure_id`) REFERENCES `library_object_expenditure` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_library_object_specific_idx` FOREIGN KEY (`object_specific_id`) REFERENCES `library_object_specific` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_library_pap_idx` FOREIGN KEY (`pap_id`) REFERENCES `library_pap` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_library_subactivity_idx` FOREIGN KEY (`subactivity_id`) REFERENCES `library_subactivity` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_pcaarrd_divisions_pooled_idx` FOREIGN KEY (`pooled_at_division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_allotment_request_status_types_idx` FOREIGN KEY (`rs_type_id`) REFERENCES `commonlibrariesdb`.`request_status_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bp_comments`
--
ALTER TABLE `bp_comments`
  ADD CONSTRAINT `FK_bp_comments_budget_proposals_idx` FOREIGN KEY (`budget_proposal_id`) REFERENCES `budget_proposals` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bp_form3`
--
ALTER TABLE `bp_form3`
  ADD CONSTRAINT `FK_bp_form3_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `bp_form4`
--
ALTER TABLE `bp_form4`
  ADD CONSTRAINT `FK_bp_form4_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `bp_form5`
--
ALTER TABLE `bp_form5`
  ADD CONSTRAINT `FK_bp_form5_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `bp_form6`
--
ALTER TABLE `bp_form6`
  ADD CONSTRAINT `FK_bp_form6_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `bp_form7`
--
ALTER TABLE `bp_form7`
  ADD CONSTRAINT `FK_bp_form7_location_idx` FOREIGN KEY (`location_id`) REFERENCES `commonlibrariesdb`.`location` (`id`),
  ADD CONSTRAINT `FK_bp_form7_monitoring_agency_idx` FOREIGN KEY (`monitoring_agency_id`) REFERENCES `commonlibrariesdb`.`agency` (`id`),
  ADD CONSTRAINT `FK_bp_form7_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `bp_form8`
--
ALTER TABLE `bp_form8`
  ADD CONSTRAINT `FK_bp_form8_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `bp_form9`
--
ALTER TABLE `bp_form9`
  ADD CONSTRAINT `FK_bp_form9_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `bp_status`
--
ALTER TABLE `bp_status`
  ADD CONSTRAINT `FK_bp_status_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_bp_status_statuses_idx` FOREIGN KEY (`status_id`) REFERENCES `library_statuses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_bp_status_user_roles_idx` FOREIGN KEY (`status_by_user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_bp_status_users_idx` FOREIGN KEY (`status_by_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `budget_proposals`
--
ALTER TABLE `budget_proposals`
  ADD CONSTRAINT `FK_bp_items_fiscal_year_idx` FOREIGN KEY (`year`) REFERENCES `fiscal_year` (`year`),
  ADD CONSTRAINT `FK_bp_items_library_activity_idx` FOREIGN KEY (`activity_id`) REFERENCES `library_activity` (`id`),
  ADD CONSTRAINT `FK_bp_items_library_expense_account_idx` FOREIGN KEY (`expense_account_id`) REFERENCES `library_expense_account` (`id`),
  ADD CONSTRAINT `FK_bp_items_library_object_expenditure_idx` FOREIGN KEY (`object_expenditure_id`) REFERENCES `library_object_expenditure` (`id`),
  ADD CONSTRAINT `FK_bp_items_library_object_specific_idx` FOREIGN KEY (`object_specific_id`) REFERENCES `library_object_specific` (`id`),
  ADD CONSTRAINT `FK_bp_items_library_pap_idx` FOREIGN KEY (`pap_id`) REFERENCES `library_pap` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_bp_items_library_subactivity_idx` FOREIGN KEY (`subactivity_id`) REFERENCES `library_subactivity` (`id`),
  ADD CONSTRAINT `FK_bp_items_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`),
  ADD CONSTRAINT `FK_bp_items_pcaarrd_divisions_pooled_idx` FOREIGN KEY (`pooled_at_division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `cp_comments`
--
ALTER TABLE `cp_comments`
  ADD CONSTRAINT `FK_cp_comments_monthly_cash_program_idx` FOREIGN KEY (`cash_program_id`) REFERENCES `monthly_cash_programs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `cp_status`
--
ALTER TABLE `cp_status`
  ADD CONSTRAINT `FK_cp_status_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_cp_status_user_roles_idx` FOREIGN KEY (`status_by_user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_cp_status_users_idx` FOREIGN KEY (`status_by_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `disbursement_vouchers`
--
ALTER TABLE `disbursement_vouchers`
  ADD CONSTRAINT `FK_dv_payee_idx` FOREIGN KEY (`payee_id`) REFERENCES `library_payees` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_dv_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dv_transaction_type`
--
ALTER TABLE `dv_transaction_type`
  ADD CONSTRAINT `FK_dv_transaction_type_id` FOREIGN KEY (`dv_transaction_type_id`) REFERENCES `library_dv_transaction_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `library_activity`
--
ALTER TABLE `library_activity`
  ADD CONSTRAINT `FK_library_activity_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `library_expense_account`
--
ALTER TABLE `library_expense_account`
  ADD CONSTRAINT `FK_library_expense_account_library_activity_idx` FOREIGN KEY (`activity_id`) REFERENCES `library_activity` (`id`),
  ADD CONSTRAINT `FK_library_expense_account_library_subactivity_idx` FOREIGN KEY (`subactivity_id`) REFERENCES `library_subactivity` (`id`);

--
-- Constraints for table `library_object_expenditure`
--
ALTER TABLE `library_object_expenditure`
  ADD CONSTRAINT `FK_library_object_expenditure_library_allotment_class_idx` FOREIGN KEY (`allotment_class_id`) REFERENCES `library_allotment_class` (`id`),
  ADD CONSTRAINT `FK_library_object_expenditure_library_expense_account_idx` FOREIGN KEY (`expense_account_id`) REFERENCES `library_expense_account` (`id`);

--
-- Constraints for table `library_object_specific`
--
ALTER TABLE `library_object_specific`
  ADD CONSTRAINT `FK_library_object_specifics_library_object_expenditure_idx` FOREIGN KEY (`object_expenditure_id`) REFERENCES `library_object_expenditure` (`id`);

--
-- Constraints for table `library_pap`
--
ALTER TABLE `library_pap`
  ADD CONSTRAINT `FK_library_pap_idx` FOREIGN KEY (`parent_id`) REFERENCES `library_pap` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_library_pap_request_status_types_idx` FOREIGN KEY (`request_status_type_id`) REFERENCES `commonlibrariesdb`.`request_status_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `library_payees`
--
ALTER TABLE `library_payees`
  ADD CONSTRAINT `FK_payees_bank_idx` FOREIGN KEY (`bank_id`) REFERENCES `commonlibrariesdb`.`banks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_payees_library_payee_type_idx` FOREIGN KEY (`payee_type_id`) REFERENCES `library_payee_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `library_signatories`
--
ALTER TABLE `library_signatories`
  ADD CONSTRAINT `FK_signatories_users_idx` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `library_subactivity`
--
ALTER TABLE `library_subactivity`
  ADD CONSTRAINT `FK_library_subactivity_library_activity_idx` FOREIGN KEY (`activity_id`) REFERENCES `library_activity` (`id`),
  ADD CONSTRAINT `FK_library_subactivity_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`);

--
-- Constraints for table `model_has_user_roles`
--
ALTER TABLE `model_has_user_roles`
  ADD CONSTRAINT `model_has_user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `model_has_user_roles_user_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_notifications_from_pcaarrd_divisions_idx` FOREIGN KEY (`division_id_from`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_notifications_from_user_roles_idx` FOREIGN KEY (`user_role_id_from`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_notifications_from_users_idx` FOREIGN KEY (`user_id_from`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_notifications_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_notifications_to_pcaarrd_divisions_idx` FOREIGN KEY (`division_id_to`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_notifications_to_user_roles_idx` FOREIGN KEY (`user_role_id_to`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_notifications_to_users_idx` FOREIGN KEY (`user_id_to`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `prefix_number`
--
ALTER TABLE `prefix_number`
  ADD CONSTRAINT `FK_prefix_number_request_status_types_idx` FOREIGN KEY (`rs_type_id`) REFERENCES `commonlibrariesdb`.`request_status_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `qop_status`
--
ALTER TABLE `qop_status`
  ADD CONSTRAINT `FK_qop_status_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_qop_status_user_roles_idx` FOREIGN KEY (`status_by_user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_qop_status_users_idx` FOREIGN KEY (`status_by_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `request_status`
--
ALTER TABLE `request_status`
  ADD CONSTRAINT `FK_request_and_status_funds_idx` FOREIGN KEY (`fund_id`) REFERENCES `commonlibrariesdb`.`funds` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_request_and_status_library_payees_idx` FOREIGN KEY (`payee_id`) REFERENCES `library_payees` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_request_and_status_pcaarrd_divisions_idx` FOREIGN KEY (`division_id`) REFERENCES `commonlibrariesdb`.`pcaarrd_divisions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_request_and_status_request_status_types_idx` FOREIGN KEY (`rs_type_id`) REFERENCES `commonlibrariesdb`.`request_status_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `rs_activity`
--
ALTER TABLE `rs_activity`
  ADD CONSTRAINT `FK_rs_allotment_idx` FOREIGN KEY (`allotment_id`) REFERENCES `allotment` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `rs_pap`
--
ALTER TABLE `rs_pap`
  ADD CONSTRAINT `FK_rs_pap_allotment_idx` FOREIGN KEY (`allotment_id`) REFERENCES `allotment` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_user_roles_idx` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
