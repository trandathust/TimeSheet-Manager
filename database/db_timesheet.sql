-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 03, 2020 lúc 06:31 AM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_timesheet`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_05_15_012019_create_projects_table', 1),
(5, '2020_05_15_012059_create_settings_table', 1),
(6, '2020_05_18_065931_create_project_users_table', 1),
(7, '2020_05_19_011935_create_timesheets_table', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`id`, `name`, `start_time`, `end_time`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'TensorRT', NULL, NULL, 'TensorRT', 1, NULL, '2020-05-22 07:20:41', '2020-05-22 10:32:50'),
(2, 'Water area', NULL, NULL, 'Water area', 1, NULL, '2020-05-22 07:20:48', '2020-05-22 09:44:32'),
(3, 'Tree counting', NULL, NULL, 'Tree counting', 1, NULL, '2020-05-22 07:20:55', '2020-05-22 07:20:55'),
(4, 'Facebook', NULL, NULL, 'Test', 0, NULL, '2020-05-22 07:21:07', '2020-05-22 07:21:07'),
(5, 'OS Light', NULL, NULL, 'Test 2', 1, NULL, '2020-05-22 07:22:31', '2020-05-22 07:22:31'),
(6, 'Twitter', '2020-05-01', '2020-05-31', 'Demo Dự Án', 1, NULL, '2020-05-22 09:25:49', '2020-05-22 09:25:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `project_users`
--

CREATE TABLE `project_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `project_users`
--

INSERT INTO `project_users` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(6, 2, 1, '2020-05-22 07:22:01', '2020-05-22 07:22:01'),
(7, 2, 2, '2020-05-22 07:22:01', '2020-05-22 07:22:01'),
(8, 2, 3, '2020-05-22 07:22:01', '2020-05-22 07:22:01'),
(9, 3, 1, '2020-05-22 07:23:14', '2020-05-22 07:23:14'),
(10, 3, 2, '2020-05-22 07:23:14', '2020-05-22 07:23:14'),
(11, 3, 3, '2020-05-22 07:23:14', '2020-05-22 07:23:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `name`, `config_key`, `config_value`, `created_at`, `updated_at`) VALUES
(1, 'Thời Gian Cộng Tác Viên', 'date_ctv', '3', NULL, '2020-05-31 20:52:52'),
(2, 'Thời Gian Quản Lý', 'date_manager', '3', NULL, NULL),
(3, 'Ngày Tính Lương', 'date_salary', '5', NULL, '2020-05-31 20:52:52'),
(4, 'Chân Trang', 'footer', 'Copyright © 2014-2019 SkymapGlobal. All rights reserved.', NULL, '2020-05-31 20:52:52'),
(5, 'Logo', 'logo', '/storage/logo/1/VAAo1avNqEYXRY2VHcfn.png', NULL, '2020-05-31 20:52:52'),
(6, 'Hệ Số Lương', 'salary', '44000', NULL, '2020-05-31 20:52:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `timesheets`
--

CREATE TABLE `timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `date_work` date NOT NULL,
  `ctv_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effective` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_hour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_effective` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_manager` tinyint(1) NOT NULL DEFAULT 0,
  `user_last_change` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `timesheets`
--

INSERT INTO `timesheets` (`id`, `project_id`, `date_work`, `ctv_id`, `manager_id`, `start_time`, `end_time`, `total_hour`, `effective`, `description`, `confirm_hour`, `confirm_effective`, `status_manager`, `user_last_change`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-05-01', 3, 2, '08:00:00', '17:30:00', '8', '80', 'Setup TensorRT client', '8', '90', 0, 'ctv', NULL, '2020-05-22 07:28:28', '2020-05-22 07:28:28'),
(2, 1, '2020-05-02', 3, 2, '10:30:00', '12:00:00', '1.5', '80', 'Write inference module', '1', '80', 0, 'ctv', NULL, '2020-05-22 07:29:27', '2020-05-22 07:29:27'),
(3, 1, '2020-05-03', 3, 2, '08:00:00', '17:30:00', '8', '90', 'Write inference module for bingbf model', NULL, NULL, 0, 'ctv', NULL, '2020-05-22 07:29:55', '2020-05-22 07:29:55'),
(4, 1, '2020-05-04', 3, 2, '08:30:00', '12:00:00', '3.5', '80', 'Write inference module for bingbf model', NULL, NULL, 0, 'ctv', NULL, '2020-05-22 07:30:26', '2020-05-22 07:30:26'),
(5, 1, '2020-05-05', 3, 2, '10:30:00', '12:00:00', '1.5', '70', 'Write inference module for bingbf model', '1.5', '70', 0, 'manager', NULL, '2020-05-22 07:31:01', '2020-05-22 08:41:35'),
(6, 1, '2020-05-06', 3, 2, '08:30:00', '12:30:00', '3.5', '90', 'Refactoring inference module', '3.5', '80', 0, 'manager', NULL, '2020-05-22 07:31:42', '2020-05-22 08:41:41'),
(7, 1, '2020-05-07', 3, 2, '08:00:00', '17:30:00', '8', '100', 'Refactoring inference module', '7', '100', 0, 'manager', NULL, '2020-05-22 07:32:11', '2020-05-22 08:41:43'),
(8, 1, '2020-05-08', 3, 2, '08:00:00', '12:00:00', '3.5', '90', 'Refactoring inference module', '3.5', '90', 0, 'manager', NULL, '2020-05-22 07:32:31', '2020-05-22 08:41:45'),
(9, 1, '2020-05-09', 3, 2, '08:00:00', '17:30:00', '8', '90', 'Write async inference module for bingbf model', '8', '80', 0, 'manager', NULL, '2020-05-22 07:33:00', '2020-05-22 08:41:47'),
(10, 1, '2020-05-10', 3, 2, '08:00:00', '14:30:00', '5', '70', 'Write async inference module for bingbf model', '5', '70', 0, 'manager', NULL, '2020-05-22 07:33:26', '2020-05-22 08:41:50'),
(11, 1, '2020-05-11', 3, 2, '08:00:00', '12:30:00', '4', '90', 'Refactoring inference module', '4', '90', 0, 'manager', NULL, '2020-05-22 07:34:04', '2020-05-22 08:41:52'),
(12, 1, '2020-05-12', 3, 2, '08:00:00', '12:30:00', '4.5', '90', 'Refactoring inference module', '4', '90', 0, 'manager', NULL, '2020-05-22 07:34:43', '2020-05-22 08:41:54'),
(13, 1, '2020-05-13', 3, 2, '08:00:00', '17:30:00', '8', '90', 'Refactoring inference module', '8', '100', 0, 'manager', NULL, '2020-05-22 07:35:10', '2020-05-22 08:41:57'),
(14, 2, '2020-05-14', 3, 2, '09:00:00', '12:00:00', '2.5', '100', 'Refactoring inference module', '2.5', '90', 0, 'manager', NULL, '2020-05-22 07:35:37', '2020-05-22 08:41:59'),
(15, 2, '2020-05-15', 3, 2, '08:00:00', '17:30:00', '8', '90', 'Prepare dataset', '8', '90', 0, 'manager', NULL, '2020-05-22 07:36:01', '2020-05-22 08:42:00'),
(16, 2, '2020-05-16', 3, 2, '08:00:00', '14:00:00', '4', '90', 'Prepare dataset', '4', '90', 0, 'manager', NULL, '2020-05-22 07:36:22', '2020-05-22 08:42:02'),
(17, 2, '2020-05-17', 3, 2, '09:00:00', '16:36:00', '7', '100', 'Prepare dataset', '6', '90', 0, 'manager', NULL, '2020-05-22 07:36:43', '2020-05-22 09:42:37'),
(18, 1, '2020-05-18', 3, 2, '08:00:00', '12:00:00', '4', '90', 'Prepare dataset', '4', '80', 0, 'manager', NULL, '2020-05-22 07:37:05', '2020-05-22 08:42:07'),
(19, 3, '2020-05-19', 3, 2, '08:00:00', '17:30:00', '8', '90', 'Prepare dataset', '8', '100', 0, 'manager', NULL, '2020-05-22 07:37:29', '2020-05-22 08:51:47'),
(20, 3, '2020-05-20', 3, 2, '10:30:00', '17:00:00', '4', '80', 'Prepare dataset', '4', '70', 0, 'manager', NULL, '2020-05-22 07:37:58', '2020-05-22 08:11:10'),
(21, 3, '2020-05-21', 3, 2, '08:00:00', '15:30:00', '5', '60', 'Prepare dataset', NULL, NULL, 0, 'manager', NULL, '2020-05-22 07:38:18', '2020-05-22 08:42:19'),
(22, 1, '2020-05-22', 3, 2, '08:00:00', '22:38:00', '2', '100', 'Prepare dataset', '2', '100', 0, 'manager', NULL, '2020-05-22 07:38:35', '2020-06-02 21:00:15'),
(23, 3, '2020-05-23', 3, 2, '08:00:00', '12:33:00', '3', '90', 'Xếp Hạng Dự Án', NULL, NULL, 1, 'manager', NULL, '2020-05-22 10:33:45', '2020-05-28 22:37:29'),
(27, 1, '2020-05-29', 3, 2, '08:00:00', '12:34:00', '3', '90', 'Setup modul', NULL, NULL, 0, 'ctv', NULL, '2020-05-28 22:36:13', '2020-05-28 22:41:19'),
(28, 2, '2020-06-01', 3, 2, '08:00:00', '10:53:00', '2', '90', 'setup', NULL, NULL, 0, 'ctv', NULL, '2020-05-31 20:54:12', '2020-05-31 20:54:12'),
(29, 2, '2020-06-03', 3, 2, '08:00:00', '10:50:00', '2.5', '90', 'fix bug', '2', '100', 0, 'manager', NULL, '2020-06-02 20:52:57', '2020-06-02 20:53:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ctv',
  `manager_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `birthday`, `email_verified_at`, `password`, `avatar_name`, `avatar_path`, `role`, `manager_id`, `status`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Giám Đốc', 'giamdoc@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$S0Z4pEnllKtm50w1hfCLq.k1axYZ8ODL4q0EIFOCW2c66SheARXeO', NULL, NULL, 'president', NULL, 1, NULL, NULL, NULL, NULL),
(2, 'Quản Lý', 'quanly@gmail.com', '0352888056', 'Số 23, ngách 77, ngõ 211 Khương Trung', NULL, NULL, '$2y$10$/OFmsZr0GDmeEtegIAofpOzazSpPavge/liuwY1Ts3xQObLxB0I/i', NULL, NULL, 'manager', NULL, 1, NULL, NULL, NULL, '2020-05-22 07:22:01'),
(3, 'Cộng Tác Viên', 'congtacvien@gmail.com', '035288805', 'Số 23, ngách 77, ngõ 211 Khương Trung', NULL, NULL, '$2y$10$f2DKIIpRoAJJ7W1qkpEvsuJMDtZ/Wxqeu3skM38yQwNcQoxHZEfia', NULL, NULL, 'ctv', 2, 1, NULL, NULL, NULL, '2020-05-22 07:23:14');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `project_users`
--
ALTER TABLE `project_users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `project_users`
--
ALTER TABLE `project_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
