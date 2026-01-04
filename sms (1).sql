-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 10:12 AM
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
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('Present','Absent','Late','Excused') NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `marked_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `class_id`, `student_id`, `attendance_date`, `status`, `remarks`, `marked_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 04:23:09', '2025-11-22 04:23:09'),
(2, 1, 4, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 04:23:09', '2025-11-22 04:23:09'),
(3, 2, 6, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 04:29:24', '2025-11-22 04:29:24'),
(4, 13, 3, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 04:31:45', '2025-11-22 04:31:45'),
(5, 15, 2, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:12:22', '2025-11-22 05:12:22'),
(6, 15, 7, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:12:22', '2025-11-22 05:12:22'),
(7, 15, 8, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:12:22', '2025-11-22 05:12:22'),
(8, 15, 9, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:12:22', '2025-11-22 05:12:22'),
(9, 15, 10, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:12:22', '2025-11-22 05:12:22'),
(10, 15, 11, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:12:22', '2025-11-22 05:12:22'),
(11, 15, 2, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:13:29', '2025-11-22 05:13:29'),
(12, 15, 7, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:13:29', '2025-11-22 05:13:29'),
(13, 15, 8, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:13:29', '2025-11-22 05:13:29'),
(14, 15, 9, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:13:29', '2025-11-22 05:13:29'),
(15, 15, 10, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:13:29', '2025-11-22 05:13:29'),
(16, 15, 11, '2025-11-22', 'Present', NULL, 'mayank pawar', '2025-11-22 05:13:29', '2025-11-22 05:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `class_type` enum('Nursery','Primary','Secondary','Higher Secondary') NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `short_name`, `class_type`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nursery', 'Nur', 'Nursery', 'Nursery level class', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(2, 'Lower Kindergarten', 'LKG', 'Nursery', 'Lower Kindergarten class', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(3, 'Upper Kindergarten', 'UKG', 'Nursery', 'Upper Kindergarten class', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(5, '2nd Grade', '2', 'Primary', 'Grade 2', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(6, '3rd Grade', '3', 'Primary', 'Grade 3', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(7, '4th Grade', '4', 'Primary', 'Grade 4', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(8, '5th Grade', '5', 'Primary', 'Grade 5', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(9, '6th Grade', '6', 'Secondary', 'Grade 6', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(10, '7th Grade', '7', 'Secondary', 'Grade 7', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(11, '8th Grade', '8', 'Secondary', 'Grade 8', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(12, '9th Grade', '9', 'Secondary', 'Grade 9', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(13, '10th Grade', '10', 'Secondary', 'Grade 10', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(14, '11th Grade', '11', 'Higher Secondary', 'Grade 11', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(15, '12th Grade', '12', 'Higher Secondary', 'Grade 12', 'Active', '2025-11-10 11:39:06', '2025-11-10 11:39:06'),
(16, 'demo', 'de', 'Secondary', 'demo lorem', 'Active', '2025-12-02 01:24:59', '2025-12-02 01:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `student_fee_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_mode` enum('Cash','UPI','Card','Bank','Cheque') NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `receipt_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_payments`
--

INSERT INTO `fee_payments` (`id`, `student_id`, `student_fee_id`, `payment_date`, `amount_paid`, `payment_mode`, `transaction_id`, `bank_name`, `cheque_no`, `remarks`, `received_by`, `receipt_file`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-10-27', 5000.00, 'Cash', NULL, NULL, NULL, 'dfgdgdfgdfg', 'Raveena', NULL, '2025-11-10 05:49:34', '2025-11-19 05:28:56'),
(2, 1, 2, '2025-10-31', 8900.00, 'Cheque', 'gfyfytygf', 'idbi', '67657hgfh', 'hjhgjhgjghjg', 'Shilpa', NULL, '2025-11-10 06:29:25', '2025-11-19 05:28:36'),
(3, 3, 3, '2025-10-27', 7000.00, 'Cash', NULL, NULL, NULL, NULL, 'Amrita Roa', NULL, '2025-11-12 06:03:43', '2025-11-19 05:30:10'),
(4, 7, 2, '2025-11-15', 5000.00, 'Cheque', NULL, 'sbi', '67657hgfhfg', NULL, 'Pooja', NULL, '2025-11-15 05:53:17', '2025-11-19 05:28:17'),
(5, 1, 4, '2025-11-21', 100.00, 'Cash', NULL, NULL, NULL, NULL, 'mayank pawar', NULL, '2025-11-21 06:31:45', '2025-11-21 06:31:45'),
(6, 1, 4, '2025-11-21', 100.00, 'Cash', NULL, NULL, NULL, NULL, 'mayank pawar', NULL, '2025-11-21 06:32:00', '2025-11-21 06:32:00'),
(7, 1, 4, '2025-11-21', 100.00, 'Cash', NULL, NULL, NULL, NULL, 'mayank pawar', NULL, '2025-11-21 06:32:51', '2025-11-21 06:32:51'),
(8, 1, 4, '2025-11-21', 100.00, 'Cash', NULL, NULL, NULL, NULL, 'mayank pawar', NULL, '2025-11-21 06:33:06', '2025-11-21 06:33:06'),
(9, 1, 4, '2025-11-21', 69.00, 'Cash', NULL, NULL, NULL, NULL, 'mayank pawar', NULL, '2025-11-21 06:35:00', '2025-11-21 06:35:00'),
(10, 1, 4, '2025-11-21', 10.00, 'Cash', NULL, NULL, NULL, NULL, 'mayank pawar', NULL, '2025-11-21 06:38:57', '2025-11-21 06:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `fee_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_structures`
--

INSERT INTO `fee_structures` (`id`, `course_id`, `academic_year`, `semester`, `fee_type`, `amount`, `due_date`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, '2025-2026', NULL, 'Admission', 60000.00, NULL, NULL, 'Active', '2025-11-10 06:14:20', '2025-11-19 03:32:54'),
(2, 1, '2025-2026', NULL, 'Security', 2000.00, NULL, NULL, 'Active', '2025-11-19 01:21:31', '2025-11-19 01:21:31'),
(3, 15, '2025-2026', NULL, 'Security', 5000.00, NULL, NULL, 'Active', '2025-11-19 03:16:31', '2025-11-19 03:16:31');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_10_070255_create_staff_table', 2),
(5, '2025_11_10_073113_create_student_admissions_table', 3),
(6, '2025_11_10_110341_create_courses_table', 4),
(7, '2025_11_10_104630_create_fee_structures_table', 5),
(8, '2025_11_12_120620_add_role_to_users_table', 6),
(9, '2025_11_13_081327_add_phone_and_role_to_users_table', 7),
(10, '2025_11_15_061119_add_course_name_to_students_table', 8),
(11, '2025_11_17_062242_whats_app_templates', 9),
(12, '2025_11_19_080719_add_course_id_to_student_admissions_table', 10),
(13, '2025_11_22_092459_add_class_to_attendances_table', 11),
(14, '2025_11_22_094640_create_attendances_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `class_name` varchar(20) NOT NULL,
  `teacher_incharge` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `class_id`, `name`, `class_name`, `teacher_incharge`, `capacity`, `created_at`, `updated_at`) VALUES
(7, 16, 'A', 'demo', NULL, NULL, '2025-12-02 01:56:12', '2025-12-02 01:56:12'),
(8, 16, 'B', 'demo', NULL, NULL, '2025-12-02 01:56:12', '2025-12-02 01:56:12'),
(13, 1, 'A', 'Nursery', NULL, NULL, '2025-12-02 01:59:44', '2025-12-02 01:59:44'),
(14, 1, 'B', 'Nursery', NULL, NULL, '2025-12-02 01:59:44', '2025-12-02 01:59:44'),
(15, 2, 'A', 'Lower Kindergarten', NULL, NULL, '2025-12-02 02:00:00', '2025-12-02 02:00:00'),
(16, 2, 'B', 'Lower Kindergarten', NULL, NULL, '2025-12-02 02:00:00', '2025-12-02 02:00:00'),
(17, 15, 'A', '12th Grade', NULL, NULL, '2025-12-02 02:00:50', '2025-12-02 02:00:50'),
(18, 15, 'B', '12th Grade', NULL, NULL, '2025-12-02 02:00:50', '2025-12-02 02:00:50'),
(19, 15, 'C', '12th Grade', NULL, NULL, '2025-12-02 02:00:50', '2025-12-02 02:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('a6wrxfVHvca6HoTlRopFJUrlX7L84YdmlxYmA2nA', 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYm93Y1BTUTNHTTNLakhwaFJERWFncktPTFpIb29DcVZrTFhjUG1tWSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL2xvY2FsaG9zdC9zbXMvYWRtaXNzaW9ucyI7czo1OiJyb3V0ZSI7czoxNjoiYWRtaXNzaW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1764756783),
('Aw1Zgksqza9neSUljP74t2dsyQa1oCJ6sBpOgUab', 11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN0NscmF5RWpUSzVTcDNYa21OUlhyVFp4V2pxZlZTUmJZOU83ZmpsSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Qvc21zMS9zbXMvaG9tZSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7fQ==', 1767516145),
('S3ht3tsn5n8T69KYN13Vqjt29YLdstjW550DOHEG', 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUHlzaFdBZWdOaGtkeU9BZzVPWlp5NldKVkJIZDY5TEhJTTlzcGhFUyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwczovL2xvY2FsaG9zdC9zbXMvc3RhZmYiO3M6NToicm91dGUiO3M6MTE6InN0YWZmLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1764756967),
('UMGO17joo6KdoqUfBAUVHiATw8FOKpbZ7jMWqP4x', 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVmZBb1ZyNXp0QVoxeHpxbDQ0c0lOYUxCNTl1ZVVPZFBuYnR0MTRvYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vbG9jYWxob3N0L3Ntcy9zeWxsYWJ1cyI7czo1OiJyb3V0ZSI7czoxNDoic3lsbGFidXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1764754318),
('vzZlw2l63YlJT7ryoxFrJFZfdapYprRIP6AtmYGw', 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmUwSldJNFNwdmtwZDZOYTVLTm9VMUswZldjS3pwSHkwTXFiUnY3SSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vbG9jYWxob3N0L3Ntcy9zdGFmZiI7czo1OiJyb3V0ZSI7czoxMToic3RhZmYuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1764757187);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `aadhaar_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `alternate_mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `address_line1` varchar(255) DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) NOT NULL,
  `joining_date` date DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `employment_type` varchar(255) DEFAULT NULL,
  `shift_timing` varchar(255) DEFAULT NULL,
  `reporting_to` varchar(255) DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `allowances` decimal(10,2) DEFAULT NULL,
  `deductions` decimal(10,2) DEFAULT NULL,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `aadhaar_file` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `qualification_certificates` varchar(255) DEFAULT NULL,
  `experience_certificate` varchar(255) DEFAULT NULL,
  `appointment_letter` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Teacher',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `dob`, `blood_group`, `marital_status`, `nationality`, `aadhaar_number`, `pan_number`, `mobile`, `alternate_mobile`, `email`, `address_line1`, `address_line2`, `city`, `state`, `pincode`, `country`, `staff_id`, `joining_date`, `department`, `designation`, `qualification`, `experience`, `specialization`, `employment_type`, `shift_timing`, `reporting_to`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `payment_mode`, `bank_name`, `account_number`, `ifsc_code`, `photo`, `aadhaar_file`, `resume`, `qualification_certificates`, `experience_certificate`, `appointment_letter`, `username`, `password`, `role`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'mayank', NULL, 'pawar', 'Male', '2025-10-26', 'o+', 'Single', 'indian', '45544353', 'ffdsd345345', '01313131314', NULL, 'mayank@gmail.com', 'edjfjnf44', 'bfbfcxb', 'delhi', 'Delhi', '122212', 'India', '67', '2025-10-26', 'non-med', 'Hod', 'phd', 6, 'cover drive', 'Permanent', NULL, NULL, 1000000.00, 1000.00, 6999.00, 6575675.00, 'UPI', 'idbi', '657657657567', '657657yuhj', 'staff_docs/7jdaYbf2mb9JDmvl6nwVeSQmn5HxKBhq7P9z7wDM.jpg', 'staff_docs/aoENOsgGOsoB9ra4ePElPHcG2d1MVKFPP0Jc0mBN.avif', 'staff_docs/YAUfYfkPI5w3gFpIUSTMeY0SowSrtJzCEIvuNDAT.jpg', NULL, NULL, NULL, 'mayank pawar', '$2y$12$eCx3092tBiiNhazglhd/rOj1hLwSXEpO2hcDusIBPjXdm4.fRBOpm', 'Teacher', 'Active', 'rtgdfggdf', '2025-11-10 02:23:26', '2025-11-10 02:23:26'),
(2, 'Ashok', NULL, 'rawat', 'Female', NULL, 'b+', 'Married', 'nepali', '45435345', '345646gfhf', '02121212121', NULL, 'ashok@gmail.com', 'nirman vihar', 'nirman vihar 22', 'delhi', 'Delhi', '122212', 'India', '546', NULL, 'safai', 'peon', '10 fail', 9, 'broom', 'Temporary', NULL, NULL, 5000.00, 10.00, 600.00, 5600.00, 'Cash', NULL, NULL, NULL, 'staff_docs/UB9EKIQJrzF5DLJ4tjO22vm1YlfQdWI7PUp0PIdb.jpg', NULL, NULL, NULL, NULL, NULL, 'ashok', '$2y$12$AePZ9lesxo2t0SF6ygCro.qgoQLnnOx87y0rdUAJz41LIlumE9SfC', 'Librarian', 'Active', NULL, '2025-11-10 03:23:52', '2025-11-10 03:23:52'),
(3, 'john', NULL, 'cena', 'Male', '2025-10-26', 'b+', 'Single', 'American', '435345453454', 'GHHFT6545G', '1313131314', NULL, 'johncena@gmail.com', 'edjfjnf44', 'bfbfcxb', 'delhi', 'Delhi', '122212', 'India', '35', NULL, 'General', 'Pt Teacher', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'staff_files/aDj6zseRsJAlC1pz0ypANnzMqlaKiSwmqQj201ib.jpg', NULL, NULL, NULL, NULL, NULL, 'johncena', '$2y$12$gmJVfIRkq86I.PeUVuSkouMIpd85N8aNdSfu2YQmDWJtUvXm/kgZW', 'Teacher', 'Active', NULL, '2025-11-11 07:48:02', '2025-11-21 00:38:01'),
(4, 'mayank', NULL, 'pawar', 'Male', '2025-11-11', 'o+', NULL, 'Indian', '565465464565', 'DFTRG6545J', '5465465654', NULL, 'ghfghfg@gmail.com', NULL, NULL, NULL, NULL, NULL, 'India', '654', NULL, 'Commerce', 'Principal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'staff_files/YSATVDDv4WJMSOSGHGjPvlulQrQo0NR1xuR8aOpH.jpg', NULL, NULL, NULL, NULL, NULL, 'gfhg', '$2y$12$ONSLYomVnX3sNoETz.F6.OZzZPZ3WpOolmsphowG5lodGtTjU2OtW', 'Teacher', 'Active', NULL, '2025-11-11 07:56:34', '2025-11-21 00:36:24'),
(5, 'binod', NULL, 'Chopra', 'Other', '2025-10-26', NULL, NULL, 'Indian', '565465464565', 'FGHHG5665G', '8989898989', NULL, 'jhgjghj@gmail.com', 'edjfjnf44', 'bfbfcxb', 'Delhi', 'Delhi', '122212', 'India', 'STFMP6629', NULL, 'Medical', 'Teacher', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'staff_files/hoX4oteI9mw7Vg2HE8yDKizKLcXo6PNdNioHV2tX.png', 'staff_files/EmIeui7UtpqQrNVRVbsNAaTGN3bGwwGgK1dawXJk.png', NULL, NULL, NULL, NULL, 'mayank.pawar', '$2y$12$U7aOIlx/tQgxik.BRiheh.S79cP7TMrEswElkJD0YopSrebaRaZP2', 'Teacher', 'Active', NULL, '2025-11-15 02:45:53', '2025-11-22 01:50:21'),
(7, 'Cody', NULL, 'Rhodes', 'Male', '2025-10-26', NULL, NULL, 'Indian', '234234234342', 'SDERF3234D', '4343434343', NULL, 'cody@gmail.com', NULL, NULL, NULL, NULL, '234213', 'India', 'STFCR2920', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'staff_files/4beouIvUx0uev0SSgWhOcl1pCNpJQGdoe7UGQVT2.jpg', NULL, NULL, NULL, NULL, NULL, 'cody.rhodes', '$2y$12$hUQ3nqyzaWY2ILldngtkxuSnK.z2mVXzIbP83ienNh1cjDPJPoQa2', 'Teacher', 'Inactive', NULL, '2025-11-22 01:44:47', '2025-11-22 01:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `student_admissions`
--

CREATE TABLE `student_admissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `aadhaar_no` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `alt_mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_line1` text NOT NULL,
  `address_line2` text DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'India',
  `father_name` varchar(255) NOT NULL,
  `father_occupation` varchar(255) DEFAULT NULL,
  `father_contact` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) NOT NULL,
  `mother_occupation` varchar(255) DEFAULT NULL,
  `mother_contact` varchar(255) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_relation` varchar(255) DEFAULT NULL,
  `guardian_contact` varchar(255) DEFAULT NULL,
  `admission_no` varchar(255) NOT NULL,
  `admission_date` date NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `roll_no` varchar(255) DEFAULT NULL,
  `previous_school_name` varchar(255) DEFAULT NULL,
  `previous_school_marks` varchar(255) DEFAULT NULL,
  `transfer_certificate` varchar(255) DEFAULT NULL,
  `admission_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tuition_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `fee_receipt` varchar(255) DEFAULT NULL,
  `student_photo` varchar(255) DEFAULT NULL,
  `birth_certificate` varchar(255) DEFAULT NULL,
  `id_proof` varchar(255) DEFAULT NULL,
  `marksheet` varchar(255) DEFAULT NULL,
  `caste_certificate` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_admissions`
--

INSERT INTO `student_admissions` (`id`, `course_name`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `blood_group`, `nationality`, `religion`, `category`, `aadhaar_no`, `mobile_no`, `alt_mobile_no`, `email`, `address_line1`, `address_line2`, `city`, `state`, `pincode`, `country`, `father_name`, `father_occupation`, `father_contact`, `mother_name`, `mother_occupation`, `mother_contact`, `guardian_name`, `guardian_relation`, `guardian_contact`, `admission_no`, `admission_date`, `academic_year`, `class`, `section`, `roll_no`, `previous_school_name`, `previous_school_marks`, `transfer_certificate`, `admission_fee`, `tuition_fee`, `payment_mode`, `transaction_id`, `fee_receipt`, `student_photo`, `birth_certificate`, `id_proof`, `marksheet`, `caste_certificate`, `status`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `course_id`) VALUES
(1, 'Nursery', 'Aarav', NULL, 'Sharma', 'Male', '2015-06-15', 'O+', 'Indian', 'Hindu', 'General', '123456789012', '9876543210', NULL, 'aarav.sharma@email.com', '123 Maple Street', NULL, 'Delhi', 'Delhi', '110001', 'India', 'Rajesh Sharma', 'Engineer', '9876501234', 'Sita Sharma', 'Teacher', '9876505678', NULL, NULL, NULL, 'ADM001', '2025-04-01', '2025-2026', '1', 'A', '1', NULL, NULL, NULL, 5000.00, 2000.00, 'Cash', 'TXN001', 'FR001', 'path/to/photo1.jpg', 'path/to/birth1.pdf', 'path/to/id1.pdf', NULL, NULL, 'Active', NULL, 0, 0, '2025-04-01 03:30:00', '2025-11-15 01:08:19', NULL),
(2, '12th Grade', 'Anaya', 'R.', 'Verma', 'Female', '2014-09-20', 'A+', 'Indian', 'Hindu', 'OBC', '123456789013', '9876543211', NULL, 'anaya.verma@email.com', '45 Rose Avenue', NULL, 'Mumbai', 'Maharashtra', '400001', 'India', 'Sunil Verma', 'Doctor', '9876501235', 'Meera Verma', 'Home Maker', '9876505679', NULL, NULL, NULL, 'ADM002', '2025-04-02', '2025-2026', '15', 'B', '2', NULL, NULL, NULL, 5000.00, 2000.00, 'Card', 'TXN002', 'FR002', 'path/to/photo2.jpg', 'path/to/birth2.pdf', 'path/to/id2.pdf', NULL, NULL, 'Active', NULL, 0, 0, '2025-04-02 03:30:00', '2025-11-15 01:08:10', NULL),
(3, '10th Grade', 'Vihaan', NULL, 'Mehta', 'Male', '2013-03-10', 'B+', 'Indian', 'Hindu', 'SC', '123456789014', '9876543212', NULL, 'vihaan.mehta@email.com', '78 Oak Street', NULL, 'Kolkata', 'West Bengal', '700001', 'India', 'Ramesh Mehta', 'Businessman', '9876501236', 'Sunita Mehta', 'Teacher', '9876505680', NULL, NULL, NULL, 'ADM003', '2025-04-03', '2025-2026', '13', 'A', '3', NULL, NULL, NULL, 5000.00, 2000.00, NULL, 'TXN003', 'FR003', 'path/to/photo3.jpg', 'path/to/birth3.pdf', 'path/to/id3.pdf', NULL, NULL, 'Active', NULL, 0, 0, '2025-04-03 03:30:00', '2025-11-15 01:05:13', NULL),
(4, 'Nursery', 'Ishita', 'K.', 'Patel', 'Female', '2012-12-05', 'AB+', 'Indian', 'Hindu', 'General', '123456789015', '9876543213', NULL, 'ishita.patel@email.com', '90 Pine Road', NULL, 'Ahmedabad', 'Gujarat', '380001', 'India', 'Hitesh Patel', 'Engineer', '9876501237', 'Neha Patel', 'Home Maker', '9876505681', NULL, NULL, NULL, 'ADM004', '2025-04-04', '2025-2026', '1', 'A', '4', NULL, NULL, NULL, 5000.00, 2000.00, 'Cash', 'TXN004', 'FR004', 'path/to/photo4.jpg', 'path/to/birth4.pdf', 'path/to/id4.pdf', NULL, NULL, 'Active', NULL, 0, 0, '2025-04-04 03:30:00', '2025-11-15 01:08:04', NULL),
(5, '8th Grade', 'Mayank', NULL, 'Pawar', 'Male', '2025-11-10', NULL, 'Indian', NULL, NULL, NULL, '9090909090', NULL, 'mayank@gmail.com', 'edjfjnf44', 'bfbfcxb', 'Delhi', 'Delhi', '122212', 'India', 'Abc', NULL, '7878787878', 'Fsdfsdf', NULL, NULL, NULL, NULL, NULL, 'ADM005', '2025-11-14', '2025-2026', '11', NULL, NULL, NULL, NULL, NULL, 56456.00, 566.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, '2025-11-14 06:59:29', '2025-11-15 01:01:31', NULL),
(6, 'Lower Kindergarten', 'Mayank', NULL, 'Pawar', 'Male', '2025-10-26', NULL, 'Indian', NULL, NULL, NULL, '8295138791', NULL, 'mayank4555@gmail.com', 'edjfjnf44', 'bfbfcxb', 'Delhi', 'Delhi', '122212', 'India', 'Dgfg', NULL, '8989897878', 'Hjh', NULL, NULL, NULL, NULL, NULL, 'ADM006', '2025-11-14', '2025-2026', '2', 'A', NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, '2025-11-14 07:05:08', '2025-11-24 02:23:14', NULL),
(7, '12th Grade', 'Ashok', NULL, 'Rawat', 'Female', '2025-11-02', NULL, 'Indian', NULL, NULL, NULL, '6969696969', NULL, 'ashok69@gmail.com', 'edjfjnf44', NULL, 'Delhi', 'Haryana', '122212', 'India', 'Abc', NULL, '7878787878', 'Abc', NULL, NULL, NULL, NULL, NULL, 'ADM007', '2025-11-15', '2025-2026', '15', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 'student_docs/1763205645_student_photo_6918620d0d329.jpg', NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, '2025-11-15 05:50:45', '2025-11-15 05:50:45', NULL),
(8, '12th Grade', 'Ajay', NULL, 'Devgn', 'Male', '2007-04-02', NULL, 'Indian', NULL, NULL, NULL, '2323232323', NULL, 'ajay@gmail.com', 'nirman vihar', 'nirman vihar 22', 'Delhi', 'Delhi', '122212', 'India', 'Abc', NULL, '7878787878', 'Fsdfsdf', NULL, NULL, NULL, NULL, NULL, 'ADM008', '2025-11-22', '2025-2026', '15', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, '2025-11-22 05:00:04', '2025-11-22 05:00:04', NULL),
(9, '12th Grade', 'Shreya', NULL, 'Verma', 'Female', '2009-02-23', NULL, 'Indian', NULL, NULL, NULL, '3434343434', NULL, 'shreya@gmail.com', 'edjfjnf44', 'bfbfcxb', 'Delhi', 'Delhi', '122212', 'India', 'Abc', NULL, '7878787878', 'Abc', NULL, NULL, NULL, NULL, NULL, 'ADM009', '2025-11-22', '2025-2026', '15', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, '2025-11-22 05:01:18', '2025-11-22 05:01:18', NULL),
(10, '12th Grade', 'Virat', NULL, 'Kohli', 'Male', '2005-05-11', NULL, 'Indian', NULL, NULL, NULL, '6767676767', NULL, 'virat@gmail.com', 'edjfjnf44', NULL, 'Delhi', 'Haryana', '122212', 'India', 'Abc', NULL, '7878787878', 'Abc', NULL, NULL, NULL, NULL, NULL, 'ADM018', '2025-11-22', '2025-2026', '15', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, '2025-11-22 05:02:05', '2025-11-22 05:02:05', NULL),
(11, '12th Grade', 'Rohit', NULL, 'Sharma', 'Male', '2008-04-29', NULL, 'Indian', NULL, NULL, NULL, '5656565656', NULL, 'rohit@gmail.com', 'edjfjnf44', NULL, 'Delhi', 'Haryana', '122212', 'India', 'Abc', NULL, '7878787878', 'Abc', NULL, NULL, NULL, NULL, NULL, 'ADM045', '2025-11-22', '2025-2026', '15', NULL, NULL, NULL, NULL, 'student_docs/1764653930_transfer_certificate_692e7b6a7025f.jpg', 0.00, 0.00, NULL, NULL, NULL, 'student_docs/1764653929_student_photo_692e7b6931034.jpg', 'student_docs/1764653930_birth_certificate_692e7b6a6e273.jpg', 'student_docs/1764653930_id_proof_692e7b6a6f31c.jpg', 'student_docs/1764653930_marksheet_692e7b6a6f887.jpg', 'student_docs/1764653930_caste_certificate_692e7b6a6fe3f.jpg', 'Active', NULL, NULL, NULL, '2025-11-22 05:02:59', '2025-12-02 00:08:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE `student_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `fee_structure_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('Paid','Partial','Unpaid') NOT NULL DEFAULT 'Unpaid',
  `due_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_fees`
--

INSERT INTO `student_fees` (`id`, `student_id`, `fee_structure_id`, `total_amount`, `paid_amount`, `balance_amount`, `payment_status`, `due_date`, `remarks`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 50505.00, 559.00, 49946.00, 'Partial', NULL, NULL, '2025-11-10 06:48:39', '2025-11-21 06:38:57'),
(6, 6, 1, 60000.00, 60000.00, 59920.00, 'Paid', NULL, NULL, '2025-11-15 02:39:40', '2025-11-19 04:31:46'),
(7, 5, 2, 2000.00, 2000.00, 2000.00, 'Paid', NULL, NULL, '2025-11-19 01:22:33', '2025-11-19 04:31:24'),
(8, 4, 2, 2000.00, 1500.00, 500.00, 'Partial', '2025-11-19', NULL, '2025-11-19 01:26:17', '2025-11-19 01:27:01'),
(9, 3, 2, 2000.00, 1500.00, 500.00, 'Unpaid', '2025-11-28', NULL, '2025-11-19 01:27:19', '2025-11-19 01:27:19'),
(10, 1, 2, 2000.00, 1500.00, 500.00, 'Unpaid', '2025-11-20', NULL, '2025-11-19 02:59:38', '2025-11-19 02:59:38'),
(11, 4, 2, 2000.00, 1500.00, 1000.00, 'Partial', NULL, NULL, '2025-11-19 03:05:39', '2025-11-19 03:15:27'),
(12, 3, 1, 60000.00, 500.00, 59500.00, 'Partial', NULL, NULL, '2025-11-19 03:15:56', '2025-11-19 03:15:56'),
(13, 7, 3, 5000.00, 788.00, 4212.00, 'Partial', NULL, NULL, '2025-11-21 05:24:54', '2025-11-21 05:24:54');

-- --------------------------------------------------------

--
-- Table structure for table `syllabus`
--

CREATE TABLE `syllabus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `academic_year` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `syllabus`
--

INSERT INTO `syllabus` (`id`, `class_id`, `section_id`, `title`, `description`, `file_path`, `file_name`, `file_size`, `file_type`, `academic_year`, `start_date`, `end_date`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'english', 'fdgdfgfd', 'syllabus/1763532916_APK_LetterHead.pdf', 'APK_LetterHead.pdf', '30064', 'pdf', '2024-2025', '2025-10-27', '2025-12-06', 1, 5, '2025-11-19 00:45:16', '2025-11-19 00:45:16'),
(2, 15, 5, 'Maths', 'ghghfgh', 'syllabus/1763967104_demo_pdf.pdf', 'demo_pdf.pdf', '308935', 'pdf', '2024-2025', '2025-11-19', '2026-11-25', 1, 5, '2025-11-19 01:11:38', '2025-11-24 01:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Panel', 'adminpanel@gmail.com', NULL, 'student', NULL, '$2y$12$8wO7AQvI7cQneeCj456.N.OkF3XJysSMIlgp6LV3LWBZnCfcLF7mO', NULL, NULL, NULL),
(4, 'Test User', 'test@example.com', NULL, 'student', '2025-09-18 07:04:24', '$2y$12$brv7FMBL7z3KQK4cPz/VD.HkPuDpulK6pCWNGw/jtbAOt61A3E2Im', 'pSnAwv9htm', '2025-09-18 07:04:25', '2025-09-18 07:04:25'),
(5, 'mayank pawar', 'mayank@gmail.com', '01313131314', 'admin', NULL, '$2y$12$0q2SL5BUj63vqlOxNvAYhuqdEY5O4/dWleGGxjc/0p0LB3vp83U3G', NULL, '2025-11-13 02:48:33', '2025-11-13 02:48:33'),
(6, 'mayank pawar', 'mayank4555@gmail.com', '6767676767676', 'admin', NULL, '$2y$12$qSawaPtdNWCkp7OIRKLyeuXhK2sA1TlA9a3YYeQDb38le9QUQzU3C', NULL, '2025-11-14 05:20:28', '2025-11-14 05:20:28'),
(9, 'mayank pawar', 'mayank123@gmail.com', '7878787878', 'admin', NULL, '$2y$12$6GXM0N9iOPNPwLH3UplEX.rstYdAJxATTFEgNlRhJhTFJwU3PeJ.y', NULL, '2025-11-23 23:44:24', '2025-11-23 23:44:24'),
(10, 'Ashok rawat', 'ashok12@gmail.com', '02121212121', 'admin', NULL, '$2y$12$siRA5jQZVQcc4k4naSluPekxZI/N3I5pD7YfKz0wuXMEnRMsDMUzu', NULL, '2025-11-26 00:03:54', '2025-11-26 00:03:54'),
(11, 'mayank pawar', 'abc@gmail.com', '12312312321', 'admin', NULL, '$2y$12$gT2gWKtZKT.9fwZ2R7jL6u0OIkKAu5llbSlw59H7q99c9M5jD.UvO', NULL, '2026-01-04 03:12:03', '2026-01-04 03:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `whats_app_logs`
--

CREATE TABLE `whats_app_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameters`)),
  `status` varchar(255) NOT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `whats_app_logs`
--

INSERT INTO `whats_app_logs` (`id`, `student_id`, `template_name`, `message`, `parameters`, `status`, `response`, `created_at`, `updated_at`) VALUES
(1, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-15\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'messages\' does not exist, cannot be loaded due to missing (truncated...)\\n\"}', '2025-11-15 07:05:35', '2025-11-15 07:05:36'),
(2, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-15\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'messages\' does not exist, cannot be loaded due to missing (truncated...)\\n\"}', '2025-11-15 07:08:32', '2025-11-15 07:08:32'),
(3, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-15\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'123456789012345\' does not exist, cannot be loaded due to  (truncated...)\\n\"}', '2025-11-15 07:19:04', '2025-11-15 07:19:05'),
(4, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-15\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'123456789012345\' does not exist, cannot be loaded due to  (truncated...)\\n\"}', '2025-11-15 07:20:07', '2025-11-15 07:20:08'),
(5, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"dfgdfg\",\"2025-11-26\",\"Present\",\"ghjghj\"]', 'failed', '{\"error\":\"cURL error 6: Could not resolve host: graph.facebook.com (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages\"}', '2025-11-17 00:19:22', '2025-11-17 00:19:22'),
(6, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"dfgdfg\",\"2025-11-26\",\"Present\",\"ghjghj\"]', 'failed', '{\"error\":\"cURL error 6: Could not resolve host: graph.facebook.com (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages\"}', '2025-11-17 00:19:22', '2025-11-17 00:19:22'),
(7, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"fgdg\",\"2025-10-28\",\"Present\",\"fdgfg\"]', 'failed', '{\"error\":\"cURL error 6: Could not resolve host: graph.facebook.com (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages\"}', '2025-11-17 00:19:49', '2025-11-17 00:19:49'),
(8, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"fgdg\",\"2025-10-28\",\"Present\",\"fdgfg\"]', 'failed', '{\"error\":\"cURL error 6: Could not resolve host: graph.facebook.com (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages\"}', '2025-11-17 00:19:49', '2025-11-17 00:19:49'),
(9, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-17\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"cURL error 6: Could not resolve host: graph.facebook.com (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages\"}', '2025-11-17 00:24:21', '2025-11-17 00:24:21'),
(10, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-17\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"cURL error 6: Could not resolve host: graph.facebook.com (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages\"}', '2025-11-17 00:24:24', '2025-11-17 00:24:24'),
(11, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"fgdg\",\"2025-10-28\",\"Present\",\"fghjjh\"]', 'failed', '{\"error\":\"cURL error 6: Could not resolve host: graph.facebook.com (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages\"}', '2025-11-17 00:57:57', '2025-11-17 00:57:58'),
(12, 4, 'attendance_update', 'Sending template: attendance_update to 919876543213', '[\"dfgdfg\",\"2025-11-19\",\"Present\",\"dfdsf\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'123456789012345\' does not exist, cannot be loaded due to  (truncated...)\\n\"}', '2025-11-17 05:38:51', '2025-11-17 05:38:54'),
(13, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-17\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'123456789012345\' does not exist, cannot be loaded due to  (truncated...)\\n\"}', '2025-11-17 05:39:30', '2025-11-17 05:39:31'),
(14, 1, 'attendance_update', 'Sending template: attendance_update to 919876543210', '[\"Aarav Sharma\",\"2025-11-19\",\"Present\",\"Test message from debug\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'123456789012345\' does not exist, cannot be loaded due to  (truncated...)\\n\"}', '2025-11-19 00:18:55', '2025-11-19 00:18:58'),
(15, 7, 'fee_reminder', 'Sending template: fee_reminder to 916969696969', '[\"Ashok Rawat\",\"1500.00\",\"2025-11-29\"]', 'failed', '{\"error\":\"Client error: `POST https:\\/\\/graph.facebook.com\\/v18.0\\/123456789012345\\/messages` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"message\\\":\\\"Unsupported post request. Object with ID \'123456789012345\' does not exist, cannot be loaded due to  (truncated...)\\n\"}', '2025-11-22 04:43:17', '2025-11-22 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `whats_app_templates`
--

CREATE TABLE `whats_app_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `variables` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`variables`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `whats_app_templates`
--

INSERT INTO `whats_app_templates` (`id`, `name`, `category`, `template_name`, `body`, `variables`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Attendance Update', 'ATTENDANCE', 'attendance_update', 'Hello {{1}}, your attendance for {{2}} has been marked as {{3}}. Remarks: {{4}}', '[\"student_name\",\"date\",\"status\",\"remarks\"]', 1, '2025-11-17 00:56:27', '2025-11-17 00:56:27'),
(2, 'Fee Reminder', 'FEE', 'fee_reminder', 'Hello {{1}}, fee payment reminder. Amount: {{2}}, Due Date: {{3}}, Invoice: {{4}}', '[\"student_name\",\"amount\",\"due_date\",\"invoice_number\"]', 1, '2025-11-17 00:56:27', '2025-11-17 00:56:27'),
(3, 'Exam Result', 'ACADEMIC', 'exam_result', 'Hello {{1}}, result for {{2}}: Marks: {{3}}, Percentage: {{4}}, Grade: {{5}}', '[\"student_name\",\"exam_name\",\"marks\",\"percentage\",\"grade\"]', 1, '2025-11-17 00:56:27', '2025-11-17 00:56:27'),
(4, 'School Announcement', 'GENERAL', 'school_announcement', 'Hello {{1}}, Announcement: {{2}}. Details: {{3}}. Date: {{4}}', '[\"student_name\",\"title\",\"message\",\"date\"]', 1, '2025-11-17 00:56:27', '2025-11-17 00:56:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_structures_course_id_foreign` (`course_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`),
  ADD UNIQUE KEY `staff_staff_id_unique` (`staff_id`),
  ADD UNIQUE KEY `staff_username_unique` (`username`);

--
-- Indexes for table `student_admissions`
--
ALTER TABLE `student_admissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_admissions_admission_no_unique` (`admission_no`),
  ADD KEY `student_admissions_course_id_foreign` (`course_id`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `syllabus`
--
ALTER TABLE `syllabus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `whats_app_logs`
--
ALTER TABLE `whats_app_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whats_app_templates`
--
ALTER TABLE `whats_app_templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_admissions`
--
ALTER TABLE `student_admissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `syllabus`
--
ALTER TABLE `syllabus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `whats_app_logs`
--
ALTER TABLE `whats_app_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `whats_app_templates`
--
ALTER TABLE `whats_app_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD CONSTRAINT `fee_structures_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_admissions`
--
ALTER TABLE `student_admissions`
  ADD CONSTRAINT `student_admissions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
