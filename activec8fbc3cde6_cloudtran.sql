-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 05, 2024 at 01:11 PM
-- Server version: 8.0.36
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `activec8fbc3cde6_cloudtran`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `type`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'adsense-header', '', 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(2, 'adsense-download-top-728x90', '', 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(3, 'adsense-download-bottom-728x90', '', 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(4, 'adsense-download-300x250', '', 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(5, 'adsense-frontend-features-728x90', '', 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(6, 'adsense-frontend-blogs-728x90', '', 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `created_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_05_28_072458_create_notifications_table', 1),
(6, '2021_05_30_175055_create_payments_table', 1),
(7, '2021_06_13_112953_create_plans_table', 1),
(8, '2021_06_19_223019_create_payment_platforms_table', 1),
(9, '2021_06_23_222150_create_subscribers_table', 1),
(10, '2021_07_14_091057_create_settings_table', 1),
(11, '2021_08_07_140304_create_referrals_table', 1),
(12, '2021_08_08_210440_create_payouts_table', 1),
(13, '2021_08_19_232502_create_blogs_table', 1),
(14, '2021_10_01_092825_create_faqs_table', 1),
(15, '2022_03_22_231714_create_reviews_table', 1),
(16, '2022_03_23_182403_create_pages_table', 1),
(17, '2022_05_13_231416_create_permission_tables', 1),
(18, '2022_05_19_103655_create_transfers_table', 1),
(19, '2022_12_14_173003_create_support_tickets_table', 1),
(20, '2022_12_14_173040_create_support_messages_table', 1),
(21, '2023_01_01_195603_create_advertisements_table', 1),
(22, '2023_01_24_112201_create_temporary_files_table', 1),
(23, '2021_07_24_003854_create_sessions_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(4, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`name`, `value`) VALUES
('privacy', ''),
('terms', '');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `frequency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'monthly|yearly|lifetime',
  `order_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'completed|cancelled|declined|failed|pending',
  `plan_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_total` int NOT NULL,
  `valid_until` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_platforms`
--

CREATE TABLE `payment_platforms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `subscriptions_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_platforms`
--

INSERT INTO `payment_platforms` (`id`, `name`, `image`, `enabled`, `subscriptions_enabled`, `created_at`, `updated_at`) VALUES
(1, 'PayPal', 'img/payments/paypal.svg', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(2, 'Stripe', 'img/payments/stripe.svg', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(3, 'BankTransfer', 'img/payments/bank-transfer.png', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(4, 'Paystack', 'img/payments/paystack.svg', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(5, 'Razorpay', 'img/payments/razorpay.svg', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(6, 'Braintree', 'img/payments/braintree.svg', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(7, 'Mollie', 'img/payments/mollie.svg', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(8, 'Coinbase', 'img/payments/coinbase.svg', 0, 0, '2024-03-29 20:59:29', '2024-03-29 20:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` bigint UNSIGNED NOT NULL,
  `request_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `total` double(8,2) NOT NULL,
  `gateway` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `plan_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) UNSIGNED NOT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'active|closed',
  `storage_total` int NOT NULL,
  `parallel_transfers` int NOT NULL,
  `download_limit` int NOT NULL,
  `available_days` int NOT NULL,
  `transfer_size` int NOT NULL,
  `payment_frequency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'monthly|yearly|lifetime',
  `primary_heading` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `free` tinyint(1) DEFAULT '0',
  `password_protection` tinyint(1) DEFAULT '0',
  `custom_expiration` tinyint(1) DEFAULT '0',
  `plan_features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `paypal_gateway_plan_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_gateway_plan_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paystack_gateway_plan_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_gateway_plan_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint UNSIGNED NOT NULL,
  `referrer_id` int DEFAULT NULL,
  `referrer_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referred_id` int DEFAULT NULL,
  `referred_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage` int DEFAULT NULL,
  `rate` int DEFAULT NULL,
  `order_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` double(8,2) DEFAULT NULL,
  `commission` double(8,2) DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user', 'web', '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(2, 'subscriber', 'web', '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(3, 'guest', 'web', '2024-03-29 20:59:29', '2024-03-29 20:59:29'),
(4, 'admin', 'web', '2024-03-29 20:59:29', '2024-03-29 20:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1yU1jwnFjOfgrNuKeAPw0vbIjS0bOHvcGeu0PXYR', NULL, '157.245.129.10', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMlFvcGMwUWdWMWZmVFZqdENBODM0N29FN1RqNUVOOXRWNXFOaTlkOSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cHM6Ly9tc2ZlZC5hdXRoc2NlLXNlYy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712298402),
('6cbDrdmsgJdTzXKKxv04F6ecIBWtNwx0kt10uP9T', NULL, '199.45.154.66', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT1ExUmN1cGhibWdGME5qblpBR2ptYU1IblpIVnExWHBueGE4ektSRiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NzoiaHR0cHM6Ly9hdXRoLmFjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712278615),
('6IIjknOvZULntv0Xp0JNefsRP2IpOwrRCcrcQCva', NULL, '52.59.53.155', 'BrightSign/9.0.97 (XD235) Mozilla/5.0 (X11; Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) QtWebEngine/5.15.2 Chrome/87.0.4280.144 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkhCTDIzRHdjNFc4enRPS2VCWUNFUG9JbkFvYTg3RW9pNjhxczE0NSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712265254),
('8QglQYLLN9OvWFjmohJYgn4o69X2JmaeI9Enb9Lb', NULL, '34.248.137.227', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUmkzWFg5OWZXV1FZbVM5MHRuVk91cXVYOWFTR21Mb2ZPSUV2YzhIZiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712263501),
('awhArX0TDfUgTLZtUclqRXY9OCgU1CbvILTuEGMx', NULL, '176.105.207.252', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZklxVnpMVzFHbDY4S3BQTzNiM0U1akhPdHhzbzZwY2g5MUJodjFCTiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cHM6Ly85MS4xMDguMTIxLjI4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712266983),
('Bn1VULPW6QpUj82iseI09GlI9fbqwEGmvWz11Oek', NULL, '104.166.80.17', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR21MOXdSZjJjZkZ3QjJ0T2ZnbUtaTFNoSURzWVBLSHo5UEZRNWc3TyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly9pcHY2LnNydjQ5MTgxMi5oc3Rnci5jbG91ZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712263384),
('BT1O0WvTpUWSXDaK1sorhAlxxeO6n3rSTZyNYF45', NULL, '199.45.154.66', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoienJhSmlVaUR6U3J5c3dPS0NSYVUxeWhSdWdjSDZSSWM4ZHM3QTlKQSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cHM6Ly9zc28uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712284936),
('bTJVntjoxLh7691Z72HGxLFL3m6ltSdshy6S8kdh', NULL, '199.45.154.50', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRVdqQTBOaGdtSnRxN3R2akJkbXZNbTk0VkttWVF1OVk2c1VRaEV3TCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MToiaHR0cHM6Ly9kb3Rmb29kcy5hY3RpdmVjOGZiYzNjZGU2ZWNhYjU5NTVjZGFkMDAuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712276340),
('C0cS1gxxnrImjqVKlEQZy9emUtWAVzMP4WniuUvI', NULL, '89.248.171.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicG5LWGNjd1ZRR0FDdmdQUXJEdWxNQzRtV284OExjUmM5aWNiWElTRCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712264390),
('CYndzjVgr9GjxirnzzRAVQmGBgjC90geWsUXP1v0', NULL, '104.166.80.177', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiejQyV2RGaW91VXpMSFpUNHRvbTVMaHVZMkh4YlpEczhheWRSZ0xESiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMzoiaHR0cHM6Ly93d3cuc3J2NDkxODEyLmhzdGdyLmNsb3VkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712263553),
('DIhCggwU8mbVKjGlkn42Bbg2Yaq7Gld0ByqyKazm', NULL, '181.41.206.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVm5lM2NtTWc4WlBuenVUQVVFU2N0REpJR1hSc0pLWENGWEpPekxKMyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712264272),
('dXSLcMYCcgffT12zR0yzXgbDI8SrxQX4VuBKAdaN', NULL, '78.126.224.90', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnptUndNb1hCUmJibWg5RzBUN1NaOUZsWEZUVWNONE44SG1wZmxYTCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cHM6Ly85MS4xMDguMTIxLjI4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712262066),
('eAAiZ7TFdeZKDfwCqmHAlZJpIOoqWvt6ElQnMEM4', NULL, '96.9.249.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXYxOHVWdkd1WTR3SHl0aUhrUUN5eENZNkxTNU5MS2s2R0NOT0czViI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712264245),
('F2I9PVCzbYjcDzzBkFfLfPL2q2y9HqG1OIOAYfPO', NULL, '37.156.216.140', 'Mozilla/5.0 Autopliuslt/8.7.0 EmbeddedBrowser (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 DeviceUID:  VendorUID:  AppPkgID: lt.plius.auto', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib1dMNjNwU0JCcTB3Zk91ZDY3MHB0NERhWW5FYXlxS3JhZ1dQWTVOZCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712265255),
('f2QmhvEsOviWCLAGSWYydm74SF5DrXhnxC3cExYG', NULL, '38.95.13.133', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU2R4WTlLUEVSTG1KT055UHpxZzNXNGZvdEJHOHowVTk5cExhMkpSSyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712265255),
('fKjPXYLzIzfGtelq6wOAFDFuxmfMKjzCnYihYvdH', NULL, '95.217.18.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVm5JOXlPUGJkOUNYTDlOaGY4dG1hRDFrUTVHZUw0Yjd1aWxKSnJJcCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712287398),
('FRWIguxbEbKIDVodnJ0rQjCmZvNKLkGTJhF7DgCu', NULL, '69.132.73.189', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUU9sdE45VDk0YWg0bjA2Z010cEo3d2Yxb21EN1ZuU2lsTHpTYnpDdyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712264515),
('fTuAu1tnh7DQHj1WNj0IPF4dwQy3MWLHwIhDVta7', NULL, '142.93.236.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXJncHF1WDlMRDNBanVEeFg1NUdmSHQ2VkV6VXFsQ29BT085M04wciI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712314159),
('G92MkMwBqufg1rLl3LOOv5JZxLJiUHqfjukljtl0', NULL, '34.211.6.132', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3k4UDFvelVsU1h5UnVSaUhJbHVha2ZueW5tSmE5U21QdDY5VW9tYSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly9hY3RpdmVjOGZiYzNjZGU2ZWNhYjU5NTVjZGFkMDAuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712320450),
('gD21LnTGAMdz0ah0EArDGflali5gXkZznUQ5JUCO', NULL, '104.166.80.77', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGtpVVhLSnpUcGxIaXBNRzJvUEE2U25RWTJVYTkzRDNUM21QWDhyRyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly9hdXRvZGlzY292ZXIuc3J2NDkxODEyLmhzdGdyLmNsb3VkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712263506),
('hBChF9y9ywuWM2Tn9xusP6jpvKBvp1pCEskadoCf', NULL, '162.142.125.221', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFIwSnNwRzVrQ1lNemQxT3FibHdLc2ZsSlpjMVVnbTJNZmFlODNpMCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cHM6Ly85MS4xMDguMTIxLjI4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712292383),
('I2E7srqCLsLCy0JaGASJ3Il2ZeIKEjB9Cf2Hs26a', NULL, '38.132.193.168', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM1VlenFvMlF2WWxnWnRaVEtNb3pJUXVXS3hDNWE4cTJ1eVBjeDBIMCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712264464),
('I2nqtd2OTCoFfXAOM2YjCxi8HYOIsttGYaQdv78t', NULL, '54.176.91.0', 'Opera/9.80 (Linux i686; Opera Mobi/1040; U; en) Presto/2.5.24 Version/10.00', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic0hDU0o3RU1JVVJSYXBuQzVDYmg1d0ZRRjFHTHRsZ3JPZFI4TTBEciI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly9hY3RpdmVjOGZiYzNjZGU2ZWNhYjU5NTVjZGFkMDAuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712292111),
('I5bzQwnBVbBdFe6sYVj0h78JqG7QXXilBzMYoeU1', NULL, '35.226.234.179', 'amphp/http-client @ v5.x', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVWVNQ2RqbnFQRVJZNHNzczNKWXI0bVZsMzE2QktXSGZEejA0VGxlVSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712294697),
('iGzIaH8vGCIKMZUH8gOzh1AncgxonLVNOrjpjLqM', NULL, '104.164.195.116', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR255YWcyRWttWE1MZ2hjQXRPMFlzVWdNa2hOQWRoenhOeWJIVUw4aiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712264440),
('ip95MvoxtK35MCSjsxyB9xJTRWsjgz63a8EBGVrW', NULL, '103.120.162.170', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEQ1cFpFdVZCWXA2eTBxYWZaU2tib1p4Sk5hOTVNT1ZQcWVEQmZUeSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cHM6Ly93d3cuYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712298390),
('ixLkTkAowJPBvNGnpRWTQ7d5YPY3kApRTTMgYBRn', NULL, '104.166.80.164', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUVIaW11NVVoNmZhbjlFb3RYaHZmSWFqQk1FMTNkeHQzTXd2VFY0SyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MjoiaHR0cHM6Ly93d3cuYXV0aHNjZS1zZWMuY29tLmFjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712265045),
('jEJolcQVd81NKVCDmMrIvov8g5HZotlxnjBEK33X', NULL, '34.248.137.227', 'Mozilla/5.0 (X11; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOE1jMjRlNEkycXRoVVNnZnN1Nm5Hd1k5NG9ma0VnblNLbzN4WW5NRCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MjoiaHR0cHM6Ly93d3cuYXV0aHNjZS1zZWMuY29tLmFjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712263515),
('k4iVbVeBWo5IZNZ0XAUhiJmamOGCnpDDH8mZkFsJ', NULL, '34.248.137.227', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQVBwUnJmVFVXWmw1ZXl4eVdJb2xyNVNBUE1wb2x5RHhiU0t0SXdUZiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MjoiaHR0cHM6Ly93d3cuYXV0aHNjZS1zZWMuY29tLmFjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712263519),
('kd3GoZYkfiMY4gPkCBnL02FcbBeKu6jQQLXg6lL6', NULL, '35.226.234.179', 'amphp/http-client @ v5.x', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUlExVlNuaTh3Z2htZ2FocDBZNUhwalFsbmZFMTl5bTdYaTZuN0pVcCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly9hY3RpdmVjOGZiYzNjZGU2ZWNhYjU5NTVjZGFkMDAuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712294698),
('KjdQ0EZF5CYDmcXWBPOU0fJFSZmIbEawl7J7oUz6', NULL, '104.166.80.164', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMURYazhqY3lOV01lYlBTTk9LanE1bXd2dTJZVGxpTko5THdpVEwyeSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MjoiaHR0cHM6Ly93d3cuYXV0aHNjZS1zZWMuY29tLmFjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712265051),
('Lng4DOhZjPSiHqRapAUEL89qnSKFo7dn38I9Sn3Y', NULL, '104.166.80.245', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQnJoUElNR052QzFKd0FMMUhiTHpRWE5HdmdFZ29aUUpBY0dRZnc5WiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712265585),
('MkEFZ2JNzUCuqZB9VDbS4aCa3LNXU6uydEdLeotA', NULL, '34.248.137.227', 'Mozilla/5.0 (X11; Ubuntu; Linux aarch64; rv:122.0) Gecko/20100101 Firefox/122.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUnVHcmRNSXgxdWdDRGYyU1MwNEpqdk93SVRvWlUzRVkyNm9jMjJhQyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712263500),
('Mt2BNPTxQxCFFFA5Hkyn6GYPolzFaZzTVahzYPLa', NULL, '34.248.137.227', 'Mozilla/5.0 (X11; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVZvdlB6SktlcHN1dW84WElWYk9wNDRCSE5zc2JhRmlYWkpRc1hxdSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712263498),
('mzx00vX3tooOl6gV5DYhc1AUsrVrO1thlKDzPQHM', NULL, '105.247.38.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:122.0) Gecko/20100101 Firefox/122.0 GLS/100.10.9491.95', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZFM1U1A2b0IyeGd3ZjV0cTlSWUVLcTRabzZYV0VRWEVkM09LQmxTdSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712302530),
('NaiiFfCI5WsQ8Ouk0KVEQNfyVAemglZPh9wlCkOO', NULL, '34.220.85.73', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXo4T09YSVpGN09kVTNKZFd1ZnA5U1pNNkRJV244S24wT0xSa1FnQSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly9hY3RpdmVjOGZiYzNjZGU2ZWNhYjU5NTVjZGFkMDAuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712320439),
('NaxuSZcnNwv1taPZAATlE83sfmQuqGkEpM8OVFDi', NULL, '89.208.29.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicGhTYVBOcGgyT1Nyc3FGb0Y3RjVNeXcwYkxhelNGNGxVR3I2NFVLUSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712270223),
('NCkb32PJzEjPBXXMkYRlqMlFURjmSNb6u4Qn18fC', NULL, '129.222.252.117', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaEJGR0lCM3ZyamdYeTd5YXRuZWMxaHJZaWFxd3hORWZOSDE4SEhMTyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712276036),
('nf2VwqRxNAzy9NeVWEYBrhtD1rBIC7M2rqiHXN0Z', NULL, '96.9.249.42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieFhMUHNUYUVhYTVoM3dZYmJuYmdSS1VvZFdQNFU1cUdaWGw5akhjRyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MjoiaHR0cHM6Ly93d3cuYXV0aHNjZS1zZWMuY29tLmFjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712266777),
('OoEsvykb783rowFutaqu2dkwP1F8rFRUb8YvX0zI', NULL, '104.166.80.104', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib1FxMU9UeVAyd2Vna2RzVUdYRHh1UEFxTXVqWW42TTF0c2pXTXhvayI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly9hY3RpdmVjOGZiYzNjZGU2ZWNhYjU5NTVjZGFkMDAuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712317593),
('OWXbrZDuiS4UtxQkywXU5g61J6U8rw9sZqiTz04X', NULL, '199.45.154.50', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieWtGV1VYWk1FWXkybG1UUDlDWWRTSWQ3d0RxY2JtMENjalIzZjdKaiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cHM6Ly85MS4xMDguMTIxLjI4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712276329),
('PixSSQ5zs3gYmmD71ItMDhPvkdXxCpMOgkPSorFw', NULL, '34.248.137.227', 'Mozilla/5.0 (X11; Ubuntu; Linux aarch64; rv:122.0) Gecko/20100101 Firefox/122.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWx1ZHo1MmRNZ01PenhwY0pNc3U2VUh6eE9HWDQyQVdTa1ZBNXE2ViI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MjoiaHR0cHM6Ly93d3cuYXV0aHNjZS1zZWMuY29tLmFjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712263518),
('q1nws4EqMXlUWkDOOB2gGPeEwlBNoB3f5XTiIIE7', NULL, '45.154.35.141', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.9 Safari/536.5', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiblNJTUUwbGU2VXRHdXlmd3U3R1k1Mk5XVnRCZDUyY0NPeGxUbFhNNiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712268108),
('RfyAG5kzLpaA1aqG4k69b9dBOhFPZkW5OG3t1uMO', NULL, '199.45.154.66', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicnFWdk10VE85UGxYSjUyMjRkWFdJbEZSa1p4YWtiendldFIwc1pvdiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cHM6Ly85MS4xMDguMTIxLjI4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712284928),
('t3t1SGe6ubzAkXmLa15dhHOSEZvqrxChcW8foPCr', NULL, '104.166.80.175', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUpTSndkQXRCSkpoU29qbkJ6cXBmNFJkZ29ydWdYT0JQeVRNakx2RSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MDoiaHR0cHM6Ly9hdXRvY29uZmlnLnNydjQ5MTgxMi5oc3Rnci5jbG91ZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712263678),
('TA7IPjFhp3RN8cIVpl34kR9kKqaYVOeKhy6wf8hd', NULL, '105.244.197.73', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:122.0) Gecko/20100101 Firefox/122.0 Trailer/92.3.3161.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNVU1UElKNE1ZbmM3dXh5NzgxUzhoWmNYUXNHOE43b2I2dVBBZ0w3QiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712266917),
('U48zAAHcMwkZQbW1b06PK6NLo9hPfRMZLg9xIW6U', NULL, '199.45.154.66', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2lCTzlBYXlrMmZrQ3d6T1lYTjdjY3dQMGQ5NU82U3ZVcG1HUHBERCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cHM6Ly85MS4xMDguMTIxLjI4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1712278605),
('uyoqF7XtBp8lmDAasnBxDWMoG53NOTvaz1UD7MQq', NULL, '104.166.80.245', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTBwQWhrQzFrVmp6UFA4Nm9aekxxWXA1TTBTRU9qeG8zTU9jSnlTSiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712265580),
('WMMJVQela8EjqHW5BGRB0CwN9lZS3HHXBc82ZVRu', NULL, '92.101.18.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXhKbmRXdkJlek9hVVk3NWZIUEhtUnVaMElPUmptZWtQRHdDT3BPMiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712316837),
('xTjRrYn3bdys2L5WB46K4FPMNuaUfqVNdx9EbBp4', NULL, '164.90.241.135', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHM1T1oxNnpuVUVvZG9NZVlOY1NGTnh1VUtpRmdWYUY5OTJ0NXBnOCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cHM6Ly9hdXRoc2NlLXNlYy5jb20uYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712265257),
('xVQsjXJLf1kbd6BS2NYgOfRGI4srU08OlDOhIzoU', NULL, '104.166.80.55', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWjBpSUVIazBjYWNTSDBXYTdPVzAwZnBLVkxlWmR2d2lTUWFxQ1h3cyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly9tYWlsLnNydjQ5MTgxMi5oc3Rnci5jbG91ZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712263604),
('ZnRkYLcBBwYM9ymUelyjzXBa8tefJ5n6s523zrJo', NULL, '103.111.88.231', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU1Z0OUFXbW0xWW9RWkJieElUUEpXekJuZDlia1pObHRzTldpTU9vWCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cHM6Ly93d3cuYWN0aXZlYzhmYmMzY2RlNmVjYWI1OTU1Y2RhZDAwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712322267),
('ZUi7vQxQP4bcDCSs4oddm1im1rdeUAwkCru7gKgZ', NULL, '193.122.155.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidmN2ek85UjZwQUJOZERWaEZMa1NpcUhDbFZnMENTZmJaWDh1Y3I3SSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2FjdGl2ZWM4ZmJjM2NkZTZlY2FiNTk1NWNkYWQwMC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1712312405);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('author', 'Berkine'),
('bank_instructions', 'Make your payment directly into our bank account. Please use your Order ID Number as the payment reference. Text to Speech Credits will not be allocated to your account until the funds have cleared in our bank account. Thank you.'),
('bank_requisites', 'Bank Name: \n                                Account Name:\n                                Account Number/IBAN:\n                                BIC/Swift:\n                                Routing Number:'),
('css', ''),
('description', 'Cloud File Transfer - File Share and File Transfer Service'),
('disclaimer', 'Cras nec dolor vehicula, vulputate diam id, imperdiet urna. Donec non ante massa. Proin sagittis nulla a sapien porta, et convallis nisl posuere. Mauris nec leo id turpis gravida viverra eu nec mi. Mauris tortor quam, commodo eget est sit amet, vestibulum semper sem. Proin porttitor odio ac dolor faucibus vehicula lacinia id ligula. Curabitur tempor vehicula turpis, id vulputate enim ultrices at. Duis mollis eu nibh quis lacinia. Nam semper aliquam consectetur. Proin pulvinar mauris a arcu viverra fermentum. Nullam pulvinar porta augue, vel dignissim ipsum. Mauris tortor quam, commodo eget est sit amet, vestibulum semper sem. Proin porttitor odio ac dolor faucibus vehicula lacinia id ligula.'),
('invoice_address', ''),
('invoice_city', ''),
('invoice_country', ''),
('invoice_currency', 'USD'),
('invoice_language', 'en'),
('invoice_phone', ''),
('invoice_postal_code', ''),
('invoice_state', ''),
('invoice_vat_number', ''),
('invoice_vendor', 'Cloud File Transfer'),
('invoice_vendor_website', ''),
('js', ''),
('keywords', 'cloud, file transfer'),
('legal_privacy_url', ''),
('legal_terms_url', ''),
('license', 'f4b4717d-d597-4b24-9175-d77eb6c8f27a'),
('referral_guideline', '1. Share your referral link with your friends to register\n                                2. For their subscription, you will receive a commissions\n                                3. Include your Bank Requisites or Paypal ID in My Gateway tab to receive your commissions\n                                4. Request payouts under My Payouts tab\n                                5. Checkout all your referrals under My Referrals tab'),
('referral_headline', 'Invite your friends, and when they subscribe, you can get a commission of their purchase(s).'),
('title', 'Cloud File Transfer - File Share and File Transfer Service'),
('username', 'f4b4717d');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `active_until` datetime DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_total` int DEFAULT NULL,
  `paystack_customer_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paystack_authorization_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paystack_email_token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `priority` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'open|resolved|declined|replied',
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resolved_on` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_files`
--

CREATE TABLE `temporary_files` (
  `id` bigint UNSIGNED NOT NULL,
  `folder` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temporary_files`
--

INSERT INTO `temporary_files` (`id`, `folder`, `file`, `size`, `created_at`, `updated_at`) VALUES
(1, '6607dfe80f2e0', 'index.html', 4471, '2024-03-29 21:48:24', '2024-03-29 21:48:24'),
(4, '6607ea0955aaa', 'index.html', 4471, '2024-03-29 22:31:37', '2024-03-29 22:31:37'),
(5, '6607f6e884cb8', 'banner_search.jpg', 196818, '2024-03-29 23:26:32', '2024-03-29 23:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `file_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `protected` tinyint(1) DEFAULT '0',
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_url` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `object_key` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `downloads` int DEFAULT NULL,
  `views` int DEFAULT NULL,
  `file_ext` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` decimal(25,2) DEFAULT NULL,
  `share_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email|link',
  `storage` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'local|aws|wasabi|gcp|storj',
  `plan_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free' COMMENT 'free|paid',
  `file_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'zip|document|image|media|other',
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `user_id`, `file_name`, `protected`, `password`, `sent_from`, `sent_to`, `message`, `transfer_id`, `transfer_url`, `object_key`, `downloads`, `views`, `file_ext`, `size`, `share_type`, `storage`, `plan_type`, `file_type`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'index.html', 0, NULL, NULL, NULL, NULL, 'GSPPNACHBY', 'transfers/6607e19fddd76/index.html', '6607e19fddd76/index.html', NULL, NULL, 'html', 4471.00, 'link', 'local', 'free', 'other', '2024-04-03 20:55:49', '2024-03-29 21:55:49', '2024-03-29 21:55:49'),
(2, 2, 'index.html', 0, NULL, '33rd3d@gmail.com', '33rd3d@gmail.com', 'test', '9TB7UQ2LDQ', 'transfers/6607e1ce8f3b1/index.html', '6607e1ce8f3b1/index.html', NULL, NULL, 'html', 4471.00, 'email', 'local', 'free', 'other', '2024-04-03 20:56:40', '2024-03-29 21:56:40', '2024-03-29 21:56:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_id` int DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage_total` int NOT NULL DEFAULT '0',
  `download_limit` int NOT NULL DEFAULT '0',
  `downloaded` int NOT NULL DEFAULT '0',
  `profile_photo_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `oauth_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oauth_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `google2fa_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `google2fa_enabled` tinyint(1) DEFAULT '0',
  `referral_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referred_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_paypal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_bank_requisites` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `job_role`, `email`, `email_verified_at`, `password`, `status`, `group`, `plan_id`, `company`, `website`, `phone_number`, `address`, `city`, `postal_code`, `country`, `storage_total`, `download_limit`, `downloaded`, `profile_photo_path`, `oauth_id`, `oauth_type`, `last_seen`, `google2fa_secret`, `google2fa_enabled`, `referral_id`, `referred_by`, `referral_payment_method`, `referral_paypal`, `referral_bank_requisites`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Administrator', 'admin@example.com', '2024-03-29 21:01:18', '$2y$10$Qw5ZlPuZqeCgDTb9CaDlluWtkyuYgmVvqaC8flTwfpT5.kIyDpzNS', 'active', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100000, 0, 0, NULL, NULL, NULL, '2024-03-31 19:39:41', NULL, 0, 'Y1JRETCQBPWTRSK', NULL, NULL, NULL, NULL, NULL, '2024-03-29 21:01:18', '2024-03-31 19:39:41'),
(2, 'guest', 'Guest', 'guest@example.com', '2024-03-29 21:01:19', '$2y$10$pJx5drWixt2Zm73w1fJqTOxFba61QAmWIgV.0F8SLJmfAg6Wsx9Vi', 'active', 'user', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100000, 0, 0, NULL, NULL, NULL, '2024-03-31 19:43:48', NULL, 0, 'N4BOTMMPOWNQZQM', NULL, NULL, NULL, NULL, NULL, '2024-03-29 21:01:19', '2024-03-31 19:43:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `payment_platforms`
--
ALTER TABLE `payment_platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `support_tickets_ticket_id_unique` (`ticket_id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `temporary_files`
--
ALTER TABLE `temporary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_platforms`
--
ALTER TABLE `payment_platforms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `support_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
