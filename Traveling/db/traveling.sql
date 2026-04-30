-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 06:55 AM
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
-- Database: `traveling`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `travel_date` date NOT NULL,
  `adults` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `flight_id`, `name`, `email`, `phone`, `travel_date`, `adults`, `children`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'manak turkhiya', 'manak123@gmail.com', '9847856898', '2026-04-30', 1, 1, 3000.00, '2026-04-27 01:07:52', '2026-04-27 01:07:52'),
(2, 4, 7, 'Dharajiya Vikram', 'dharajiyavikram123@gmail.com', '9568745865', '2026-04-30', 1, 0, 1500.00, '2026-04-27 05:45:53', '2026-04-27 05:45:53'),
(3, 4, 5, 'Dharajiya Vikram', 'dharajiyavikram123@gmail.com', '9584565788', '2026-04-29', 1, 0, 15999.00, '2026-04-27 05:48:35', '2026-04-27 05:48:35');

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
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airline_name` varchar(255) NOT NULL,
  `flight_name` varchar(255) DEFAULT NULL,
  `flight_no` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `from_city` varchar(255) NOT NULL,
  `to_city` varchar(255) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `stops` varchar(255) NOT NULL DEFAULT 'Non-stop',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `airline_name`, `flight_name`, `flight_no`, `image`, `from_city`, `to_city`, `departure_time`, `arrival_time`, `stops`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Air india', 'Air India Express', 'AI202', '1777011742.jpg', 'Kolkata', 'ahmedabad', '10:00:00', '11:50:00', 'Non-Stop', 1500.00, '2026-04-24 00:00:31', '2026-04-24 01:00:47'),
(2, 'IndiGo', 'IndiGo Express', '6E101', '1777011753.jpg', 'Ahmedabad', 'Mumbai', '10:30:00', '12:00:00', 'Non-stop', 3999.00, '2026-04-24 00:29:46', '2026-04-24 00:52:33'),
(3, 'SpiceJet', 'Spice Saver', 'SG303', '1777011765.jpg', 'Jaipur', 'Kolkata', '06:00:00', '10:30:00', '1 Stop (Delhi)', 5599.00, '2026-04-24 00:31:32', '2026-04-24 00:52:45'),
(5, 'Vistara', 'Vistara Premium', 'UK404', '1777011984.jpg', 'mumbai', 'Dubai', '22:00:00', '02:55:00', 'Non-stop', 15999.00, '2026-04-24 00:56:24', '2026-04-24 00:56:24'),
(6, 'United Airline', 'United Global', 'UA215', '1777287805.avif', 'San Francisco (SFO)', 'Tokyo (NRT)', '13:15:00', '05:45:00', 'Non-stop', 1200.00, '2026-04-27 05:33:25', '2026-04-27 05:33:25'),
(7, 'Emirates', 'Emirates Skywards', 'EK202', '1777288256.webp', 'Dubai (DXB)', 'New York (JFK)', '20:30:00', '14:25:00', '1 Stop (London (LHR))', 1500.00, '2026-04-27 05:40:56', '2026-04-27 05:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `hotelimages`
--

CREATE TABLE `hotelimages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotelimages`
--

INSERT INTO `hotelimages` (`id`, `hotel_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, '1777374954_69f096ea6b53d.jpg', '2026-04-28 05:45:54', '2026-04-28 05:45:54'),
(2, 1, '1777374954_69f096ea72f6f.jpg', '2026-04-28 05:45:54', '2026-04-28 05:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `star_rating` int(11) DEFAULT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `total_rooms` int(11) NOT NULL DEFAULT 0,
  `wifi` tinyint(1) NOT NULL DEFAULT 0,
  `parking` tinyint(1) NOT NULL DEFAULT 0,
  `pool` tinyint(1) NOT NULL DEFAULT 0,
  `gym` tinyint(1) NOT NULL DEFAULT 0,
  `restaurant` tinyint(1) NOT NULL DEFAULT 0,
  `ac` tinyint(1) NOT NULL DEFAULT 1,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `description`, `slug`, `city`, `state`, `country`, `address`, `latitude`, `longitude`, `phone`, `email`, `website`, `star_rating`, `price_per_night`, `total_rooms`, `wifi`, `parking`, `pool`, `gym`, `restaurant`, `ac`, `thumbnail`, `status`, `created_at`, `updated_at`) VALUES
(1, 'The Taj Mahal Palace', 'The Taj Mahal Palace, Mumbai is a historic luxury hotel overlooking the Gateway of India. \r\nBuilt in 1903, it is one of India’s most iconic hotels, known for royal architecture, world-class hospitality, and premium sea-facing rooms. \r\nIt offers luxury dining, spa services, swimming pool, fitness center, and premium suites for global travelers.', 'the-taj-mahal-palace-1777296261', 'Mumbai', 'Maharashtra', 'India', 'Apollo Bunder, Colaba, Mumbai, Maharashtra 400001, India', 18.9218000, 72.8331000, '+91 22 6665 3366', 'info.tajmumbai@tajhotels.com', 'https://www.tajhotels.com/en-in', 5, 25000.00, 550, 1, 1, 1, 1, 1, 1, '1777296261.jpg', 'active', '2026-04-27 07:54:21', '2026-04-27 23:08:58'),
(2, 'Taj Palace Hotel', 'Luxury 5-star hotel with premium rooms, sea view suites, spa, and fine dining.', 'taj-palace-hotel-1777436950', 'Ahmedabad', 'Gujarat', 'India', 'SG Highway, Ahmedabad', 23.0225000, 72.5714000, '9876543210', 'taj@hotel.com', 'http://www.tajpalace.com', 5, 7500.00, 120, 1, 1, 1, 1, 1, 1, '1777436950.jpg', 'active', '2026-04-28 22:59:10', '2026-04-28 22:59:10'),
(3, 'Grand Imperial Hotel', 'Comfortable business hotel with modern rooms and conference facilities.', 'grand-imperial-hotel-1777437207', 'Surat', 'Gujarat', 'India', 'Ring Road, Surat', 21.1702000, 72.8311000, '9123456780', 'info@grandimperial.com', 'http://www.grandimperial.com', 4, 3500.00, 80, 1, 1, 0, 0, 1, 1, '1777437207.jpg', 'active', '2026-04-28 23:03:27', '2026-04-28 23:03:27');

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
(9, '2026_04_21_055151_create_flights_table', 2),
(13, '2026_04_24_125232_create_bookings_table', 3),
(14, '2026_04_27_114333_create_hotels_table', 4),
(19, '2026_04_28_053302_create_hotelimages_table', 5),
(20, '2026_04_28_113130_create_rooms_table', 6),
(21, '2026_04_28_132656_create_roomimages_table', 7);

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
-- Table structure for table `roomimages`
--

CREATE TABLE `roomimages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roomimages`
--

INSERT INTO `roomimages` (`id`, `room_id`, `image`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, '1777436017_69f18571c9417.jpg', 0, 0, '2026-04-28 22:43:37', '2026-04-28 22:43:37'),
(2, 1, '1777436017_69f18571dd054.jpg', 0, 0, '2026-04-28 22:43:37', '2026-04-28 22:43:37'),
(3, 1, '1777436017_69f18571de939.jpg', 0, 0, '2026-04-28 22:43:37', '2026-04-28 22:43:37'),
(4, 2, '1777436274_69f1867258835.jpg', 0, 0, '2026-04-28 22:47:54', '2026-04-28 22:47:54'),
(5, 2, '1777436274_69f186725f329.jpg', 0, 0, '2026-04-28 22:47:54', '2026-04-28 22:47:54'),
(6, 2, '1777436274_69f1867260dba.jpg', 0, 0, '2026-04-28 22:47:54', '2026-04-28 22:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_rooms` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hotel_id`, `room_type`, `capacity`, `price`, `total_rooms`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Suite', 3, 9000.00, 120, 'Luxury suite with living area, premium services', 1, '2026-04-28 06:47:37', '2026-04-28 06:47:37'),
(2, 1, 'Super Deluxe', 3, 5500.00, 120, 'Premium room with balcony, king-size bed, all amenities', 1, '2026-04-28 06:50:25', '2026-04-28 06:50:25'),
(3, 1, 'Deluxe', 2, 4000.00, 198, 'Spacious room with city view, AC, TV, WiFi, minibar', 1, '2026-04-28 06:52:07', '2026-04-28 06:52:07'),
(4, 1, 'Standard', 2, 2500.00, 110, 'Basic room with AC, TV, free WiFi', 1, '2026-04-28 06:54:01', '2026-04-28 06:54:01'),
(5, 2, 'Standard', 2, 3000.00, 40, 'Budget-friendly clean standard room', 1, '2026-04-28 23:17:34', '2026-04-28 23:17:34'),
(6, 2, 'Deluxe', 2, 5000.00, 40, 'Luxury deluxe room with city view', 1, '2026-04-28 23:18:46', '2026-04-28 23:18:46'),
(7, 2, 'Super Deluxe', 3, 6500.00, 28, 'Spacious room with king bed and balcony', 1, '2026-04-28 23:19:52', '2026-04-28 23:19:52'),
(8, 2, 'Suite', 4, 9000.00, 12, 'Premium suite with living area and jacuzzi', 1, '2026-04-28 23:21:05', '2026-04-28 23:21:05');

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
('Cr0HU83oGB8JqbSxr3HXOj0DmCPbcLdnHtwlbbJ6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGtIVVV5YmJmT0x4cnZuTGpBR1ZESDE2eVB5STdiZG90YUp2RDZLMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yb29tc19pbWFnZXMiO3M6NToicm91dGUiO3M6MTY6ImFkbWluLnJvb21pbWFnZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1777438283),
('vTkGZumrgYbnXsf1zPymfcl2vk1gORFyf4GypWto', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoielN0R3pLTFVGV2x6Rmw3dUZickllUW12ZkNGMTJMbDNGcHFYZFZmYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yb29tX2ltYWdlcyI7czo1OiJyb3V0ZSI7czoxNjoiYWRtaW4ucm9vbWltYWdlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1777386075);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `usertype`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Vijay Dharajiya', 'vijay123@gmail.com', 'admin', NULL, '$2y$12$1jnaS5MbMfmblLOWmC0NgOHZHKF171wsiUG0/SzQsAECqGoiRkEoK', NULL, '2026-04-20 22:52:39', '2026-04-20 22:52:39'),
(2, 'Rohit Dharajiya', 'dharajiyarohit123@gmail.com', 'user', NULL, '$2y$12$CNUgu//5WWaNDQ0AyraMcOw4eiYR02bQvSG4FRoh7fpfqIskyCyKq', NULL, '2026-04-20 22:53:17', '2026-04-20 22:53:17'),
(3, 'manak turkhiya', 'manak123@gmail.com', 'user', NULL, '$2y$12$g0rj.eO3dB6oQxuPTnYgjuD47KG6sBI3ljMyOZftz26cD.HMTAJYm', NULL, '2026-04-21 23:50:39', '2026-04-21 23:50:39'),
(4, 'vikram Bhai Dharajiya', 'dharajiyavikram123@gmail.com', 'user', NULL, '$2y$12$in9PeAVNmFzG4eoSilf/LO5LtWjsCorI9nu241XhIqWoPRTK.w22G', NULL, '2026-04-21 23:55:14', '2026-04-21 23:55:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_flight_id_foreign` (`flight_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `flights_flight_no_unique` (`flight_no`);

--
-- Indexes for table `hotelimages`
--
ALTER TABLE `hotelimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotelimages_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hotels_slug_unique` (`slug`);

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
-- Indexes for table `roomimages`
--
ALTER TABLE `roomimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roomimages_room_id_foreign` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_hotel_id_foreign` (`hotel_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hotelimages`
--
ALTER TABLE `hotelimages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `roomimages`
--
ALTER TABLE `roomimages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotelimages`
--
ALTER TABLE `hotelimages`
  ADD CONSTRAINT `hotelimages_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roomimages`
--
ALTER TABLE `roomimages`
  ADD CONSTRAINT `roomimages_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
