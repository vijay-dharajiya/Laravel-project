-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2026 at 02:52 PM
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
  `airline_code` varchar(10) NOT NULL,
  `flight_number` varchar(20) NOT NULL,
  `aircraft_type` varchar(255) DEFAULT NULL,
  `airline_logo` varchar(255) DEFAULT NULL,
  `from_city` varchar(255) NOT NULL,
  `from_airport` varchar(255) NOT NULL,
  `from_airport_code` varchar(10) NOT NULL,
  `to_city` varchar(255) NOT NULL,
  `to_airport` varchar(255) NOT NULL,
  `to_airport_code` varchar(10) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `overnight_arrival` tinyint(4) NOT NULL DEFAULT 0,
  `stops` tinyint(4) NOT NULL DEFAULT 0,
  `stopover_cities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stopover_cities`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `airline_name`, `airline_code`, `flight_number`, `aircraft_type`, `airline_logo`, `from_city`, `from_airport`, `from_airport_code`, `to_city`, `to_airport`, `to_airport_code`, `departure_time`, `arrival_time`, `overnight_arrival`, `stops`, `stopover_cities`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Air India', 'AI', 'AI-202', 'Airbus A320', 'airline_logos/1777643615_logo.jpg', 'Ahmedabad', 'Sardar Vallabhbhai Patel International Airport', 'AMD', 'Delhi', 'Indira Gandhi International Airport', 'DEL', '09:30:00', '11:10:00', 0, 1, '[\"Jaipur\"]', 1, '2026-05-01 08:09:35', '2026-05-01 08:24:57'),
(2, 'IndiGo', '6E', '6E-1456', 'Airbus A321', 'airline_logos/1777643026_logo.jpg', 'Mumbai', 'Chhatrapati Shivaji Maharaj International Airport', 'BOM', 'Dubai', 'Dubai International Airport', 'DBX', '22:15:00', '04:30:00', 1, 1, '[\"Delhi\"]', 1, '2026-05-01 08:13:46', '2026-05-01 08:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `flight_classes`
--

CREATE TABLE `flight_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `class_type` enum('Economy','Premium Economy','Business','First') NOT NULL,
  `total_seats` int(11) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `booked_seats` int(11) NOT NULL DEFAULT 0,
  `base_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'INR',
  `cabin_baggage_kg` int(11) NOT NULL DEFAULT 7,
  `checkin_baggage_kg` int(11) NOT NULL DEFAULT 15,
  `is_refundable` tinyint(1) NOT NULL DEFAULT 0,
  `cancellation_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flight_classes`
--

INSERT INTO `flight_classes` (`id`, `flight_id`, `class_type`, `total_seats`, `available_seats`, `booked_seats`, `base_price`, `tax`, `total_price`, `currency`, `cabin_baggage_kg`, `checkin_baggage_kg`, `is_refundable`, `cancellation_charge`, `created_at`, `updated_at`) VALUES
(1, 1, 'Economy', 70, 70, 0, 4500.00, 250.00, 4750.00, 'INR', 7, 15, 0, 0.00, '2026-05-02 00:09:04', '2026-05-02 00:09:04'),
(2, 1, 'Premium Economy', 30, 30, 0, 8000.00, 400.00, 8400.00, 'INR', 7, 20, 0, 0.00, '2026-05-02 00:09:04', '2026-05-02 00:09:04'),
(3, 1, 'Business', 30, 30, 0, 15000.00, 2700.00, 17700.00, 'INR', 10, 25, 0, 0.00, '2026-05-02 00:09:04', '2026-05-02 00:09:04'),
(4, 1, 'First', 20, 20, 0, 35000.00, 6300.00, 41300.00, 'INR', 10, 30, 0, 0.00, '2026-05-02 00:09:04', '2026-05-02 00:09:04'),
(5, 2, 'Economy', 150, 150, 0, 4500.00, 450.00, 4950.00, 'INR', 7, 15, 1, 3000.00, '2026-05-02 07:02:18', '2026-05-02 07:02:18'),
(6, 2, 'Premium Economy', 40, 40, 0, 8000.00, 800.00, 8800.00, 'INR', 7, 20, 0, 0.00, '2026-05-02 07:02:18', '2026-05-02 07:02:18'),
(7, 2, 'Business', 20, 20, 0, 15000.00, 1500.00, 16500.00, 'INR', 10, 30, 0, 0.00, '2026-05-02 07:02:18', '2026-05-02 07:02:18'),
(8, 2, 'First', 10, 10, 0, 35000.00, 3500.00, 38500.00, 'INR', 10, 40, 0, 0.00, '2026-05-02 07:02:19', '2026-05-02 07:02:19');

-- --------------------------------------------------------

--
-- Table structure for table `flight_schedules`
--

CREATE TABLE `flight_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `journey_date` date NOT NULL,
  `status` enum('Scheduled','On Time','Delayed','Cancelled','Boarding','Departed','Landed') NOT NULL DEFAULT 'Scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flight_schedules`
--

INSERT INTO `flight_schedules` (`id`, `flight_id`, `journey_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-05-02', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(2, 1, '2026-05-03', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(3, 1, '2026-05-04', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(4, 1, '2026-05-05', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(5, 1, '2026-05-06', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(6, 1, '2026-05-07', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(7, 1, '2026-05-08', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(8, 1, '2026-05-09', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(9, 1, '2026-05-10', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(10, 1, '2026-05-11', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(11, 1, '2026-05-12', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(12, 1, '2026-05-13', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(13, 1, '2026-05-14', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(14, 1, '2026-05-15', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(15, 1, '2026-05-16', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(16, 1, '2026-05-17', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(17, 1, '2026-05-18', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(18, 1, '2026-05-19', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(19, 1, '2026-05-20', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(20, 1, '2026-05-21', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(21, 1, '2026-05-22', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(22, 1, '2026-05-23', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(23, 1, '2026-05-24', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(24, 1, '2026-05-25', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(25, 1, '2026-05-26', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(26, 1, '2026-05-27', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(27, 1, '2026-05-28', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(28, 1, '2026-05-29', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(29, 1, '2026-05-30', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(30, 1, '2026-05-31', 'Scheduled', '2026-05-02 00:38:40', '2026-05-02 00:38:40'),
(31, 2, '2026-05-02', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(32, 2, '2026-05-03', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(33, 2, '2026-05-04', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(34, 2, '2026-05-05', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(35, 2, '2026-05-06', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(36, 2, '2026-05-07', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(37, 2, '2026-05-08', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(38, 2, '2026-05-09', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(39, 2, '2026-05-10', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(40, 2, '2026-05-11', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(41, 2, '2026-05-12', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(42, 2, '2026-05-13', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(43, 2, '2026-05-14', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(44, 2, '2026-05-15', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(45, 2, '2026-05-16', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(46, 2, '2026-05-17', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(47, 2, '2026-05-18', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(48, 2, '2026-05-19', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(49, 2, '2026-05-20', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(50, 2, '2026-05-21', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(51, 2, '2026-05-22', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(52, 2, '2026-05-23', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(53, 2, '2026-05-24', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(54, 2, '2026-05-25', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(55, 2, '2026-05-26', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(56, 2, '2026-05-27', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(57, 2, '2026-05-28', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(58, 2, '2026-05-29', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(59, 2, '2026-05-30', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55'),
(60, 2, '2026-05-31', 'Scheduled', '2026-05-02 06:58:55', '2026-05-02 06:58:55');

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
(1, 1, '1777471781_69f21125d72d1.jpg', '2026-04-29 08:39:41', '2026-04-29 08:39:41'),
(2, 1, '1777471781_69f21125d94a3.jpg', '2026-04-29 08:39:41', '2026-04-29 08:39:41'),
(3, 1, '1777471781_69f21125da497.jpg', '2026-04-29 08:39:41', '2026-04-29 08:39:41'),
(4, 1, '1777471886_69f2118e04e30.jpg', '2026-04-29 08:41:26', '2026-04-29 08:41:26'),
(5, 2, '1777525124_69f2e184837fb.jpg', '2026-04-29 23:28:44', '2026-04-29 23:28:44'),
(6, 2, '1777525124_69f2e18487dfc.jpeg', '2026-04-29 23:28:44', '2026-04-29 23:28:44'),
(7, 2, '1777525124_69f2e1848930f.jpg', '2026-04-29 23:28:44', '2026-04-29 23:28:44');

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
(1, 'Taj Palace', 'Luxury 5-star hotel with premium amenities, rooftop dining, and city view rooms.', 'taj-palace-1777471751', 'Ahmedabad', 'Gujarat', 'India', 'Near SG Highway, Ahmedabad', 23.0707000, 72.5175000, '079-12345678', 'info@tajpalace.com', 'https://www.tajhotels.com/', 5, 8500.00, 120, 1, 1, 1, 1, 1, 1, '1777471751.jpg', 'active', '2026-04-29 08:39:11', '2026-04-29 08:39:11'),
(2, 'Novotel Mumbai Airport', 'Modern hotel near airport with comfortable stay and business facilities.', 'novotel-mumbai-airport-1777524771', 'Mumbai', 'Maharashtra', 'India', 'Andheri East, Mumbai', 19.1197000, 72.8464000, '022-98765432', 'contact@novotel.com', 'https://all.accor.com/', 4, 7200.00, 200, 1, 1, 1, 0, 1, 1, '1777524771.jpg', 'active', '2026-04-29 23:22:51', '2026-04-29 23:22:51');

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
(6, '2026_04_27_114333_create_hotels_table', 1),
(7, '2026_04_28_053302_create_hotelimages_table', 1),
(8, '2026_04_28_113130_create_rooms_table', 1),
(9, '2026_04_28_132656_create_roomimages_table', 1),
(10, '2026_04_29_051726_create_room_types_table', 1),
(13, '2026_04_21_055151_create_flights_table', 2),
(14, '2026_05_01_124435_create_flight_classes_table', 3),
(16, '2026_05_01_124943_create_flight_schedules_table', 4);

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
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `roomimages` (`id`, `hotel_id`, `room_id`, `image`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1777528651_69f2ef4b001fd.jpg', 1, 0, '2026-04-30 00:27:31', '2026-04-30 00:27:31'),
(2, 1, 1, '1777528651_69f2ef4b03ffb.jpg', 0, 1, '2026-04-30 00:27:31', '2026-04-30 00:27:31'),
(3, 1, 2, '1777528714_69f2ef8a9c941.webp', 1, 0, '2026-04-30 00:28:34', '2026-04-30 00:28:34'),
(4, 1, 2, '1777528714_69f2ef8a9ea51.jpg', 0, 1, '2026-04-30 00:28:34', '2026-04-30 00:28:34'),
(5, 2, 5, '1777528768_69f2efc022759.webp', 1, 0, '2026-04-30 00:29:28', '2026-04-30 00:29:28'),
(6, 2, 5, '1777528768_69f2efc025868.jpg', 0, 1, '2026-04-30 00:29:28', '2026-04-30 00:29:28');

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
(1, 1, '1', 2, 3500.00, 27, 'Comfortable room with WiFi, AC, Work Desk', 1, '2026-04-29 08:54:40', '2026-04-29 08:54:40'),
(2, 1, '2', 2, 4500.00, 20, 'AC, WiFi, LED TV, Mini Bar, City View', 1, '2026-04-29 08:55:40', '2026-04-29 08:55:40'),
(3, 1, '3', 3, 6500.00, 43, 'Spacious room with premium interior and minibar', 1, '2026-04-29 08:59:46', '2026-04-29 08:59:46'),
(4, 1, '4', 4, 9000.00, 30, 'Luxury suite with living area and premium services', 1, '2026-04-29 09:00:33', '2026-04-29 09:00:33'),
(5, 2, '1', 2, 2800.00, 80, 'Budget friendly room with AC and WiFi', 1, '2026-04-29 23:31:32', '2026-04-29 23:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Standard', 'A comfortable and budget-friendly room with basic amenities such as a bed, bathroom, TV, and Wi-Fi. Ideal for short stays and solo travelers.', 1, '2026-04-29 14:20:05', '2026-04-29 14:20:05'),
(2, 'Deluxe', 'A spacious room with upgraded interiors, better furnishings, and additional amenities like air conditioning, mini fridge, and a city view.', 1, '2026-04-29 14:20:05', '2026-04-29 14:20:05'),
(3, 'Super Deluxe', 'A premium room offering luxurious interiors, larger space, premium bedding, smart TV, minibar, and enhanced comfort for a relaxing stay.', 1, '2026-04-29 14:20:05', '2026-04-29 14:20:05'),
(4, 'Suite', 'A high-end luxury room with separate living and sleeping areas, premium services, elegant decor, and top-class facilities for an elite experience.', 1, '2026-04-29 14:20:05', '2026-04-29 14:20:05');

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
('HFgwJoj7RxjFWZaCcPKvjpa7nbF9pVbxirJ2p0g6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibks1WlIxQzlodVVVZVBYMEx6eHVtSXJhOFhVY2dPWWg1a05CNVlKQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo1OiJpbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777717942),
('u86NI8t5rK2dq2CfIlFzl9bqC08N65x4lISKV6dX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQUhJSkphZVp1S0pyeTB5UmlITUI2R2ZMSklSRDZpUmtJQVlwRVhDWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo1OiJpbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1777726299);

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
(1, 'Vijay Dharajiya', 'vijay123@gmail.com', 'admin', NULL, '$2y$12$eDsyedhK.pWAuaLmjzzyt.H//BspCBrkV.OlJcQ2AOTpF5oxkqdLi', NULL, '2026-04-29 08:17:30', '2026-04-29 08:17:30'),
(2, 'Rohit Dharajiya', 'dharajiyarohit123@gmail.com', 'user', NULL, '$2y$12$.2/dWsHhWVTDduv7Vy0xgu/DRnDyaehmhg/YNt6xx0H5F93xW3b7S', NULL, '2026-04-29 08:18:11', '2026-04-29 08:18:11'),
(3, 'Nevil Donga', 'nevildonga@gmail.com', 'admin', NULL, '$2y$12$cNDgB709olV3vdFbw2usp.O4FSM1NhAujMeMIeIZ5aTG1HwQiPmMO', NULL, '2026-04-30 05:03:35', '2026-04-30 05:03:35');

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `flights_flight_number_unique` (`flight_number`);

--
-- Indexes for table `flight_classes`
--
ALTER TABLE `flight_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flight_classes_flight_id_foreign` (`flight_id`);

--
-- Indexes for table `flight_schedules`
--
ALTER TABLE `flight_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `flight_schedules_flight_id_journey_date_unique` (`flight_id`,`journey_date`);

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
  ADD KEY `roomimages_hotel_id_foreign` (`hotel_id`),
  ADD KEY `roomimages_room_id_foreign` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `flight_classes`
--
ALTER TABLE `flight_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `flight_schedules`
--
ALTER TABLE `flight_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `hotelimages`
--
ALTER TABLE `hotelimages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roomimages`
--
ALTER TABLE `roomimages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight_classes`
--
ALTER TABLE `flight_classes`
  ADD CONSTRAINT `flight_classes_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `flight_schedules`
--
ALTER TABLE `flight_schedules`
  ADD CONSTRAINT `flight_schedules_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotelimages`
--
ALTER TABLE `hotelimages`
  ADD CONSTRAINT `hotelimages_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roomimages`
--
ALTER TABLE `roomimages`
  ADD CONSTRAINT `roomimages_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
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
