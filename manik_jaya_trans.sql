-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 29, 2026 at 08:57 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manik_jaya_trans`
--

-- --------------------------------------------------------

--
-- Table structure for table `airport_transfers`
--

CREATE TABLE `airport_transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dropoff_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `estimated_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airport_transfers`
--

INSERT INTO `airport_transfers` (`id`, `route_name`, `pickup_location`, `dropoff_location`, `price`, `estimated_duration`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bandara ke Kuta / Legian', 'Bandara Ngurah Rai (DPS)', 'Kuta / Legian Area', 150000.00, '30 Menit', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(2, 'Bandara ke Seminyak', 'Bandara Ngurah Rai (DPS)', 'Seminyak Area', 200000.00, '45 Menit', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(3, 'Bandara ke Canggu', 'Bandara Ngurah Rai (DPS)', 'Canggu Area', 250000.00, '60 Menit', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(4, 'Bandara ke Ubud', 'Bandara Ngurah Rai (DPS)', 'Ubud Center', 350000.00, '90 Menit', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(5, 'Ubud ke Bandara', 'Ubud Center', 'Bandara Ngurah Rai (DPS)', 350000.00, '90 Menit', 'inactive', '2026-05-28 21:58:15', '2026-05-28 21:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('available','on_trip','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `phone`, `license_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Wayan Sudiana', '081112223334', 'B1-12345678', 'available', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(2, 'Made Artawan', '082223334445', 'A-87654321', 'available', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(3, 'Nyoman Parta', '083334445556', 'B1-11223344', 'available', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(4, 'Ketut Suardika', '084445556667', 'A-55667788', 'on_trip', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(5, 'Gede Mahardika', '085556667778', 'B1-99887766', 'inactive', '2026-05-28 21:58:15', '2026-05-28 21:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_shuttles`
--

CREATE TABLE `hotel_shuttles` (
  `id` bigint UNSIGNED NOT NULL,
  `hotel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dropoff_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `schedule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotel_shuttles`
--

INSERT INTO `hotel_shuttles` (`id`, `hotel_name`, `pickup_location`, `dropoff_location`, `price`, `schedule`, `status`, `created_at`, `updated_at`) VALUES
(1, 'The Westin Resort Nusa Dua', 'Lobby Westin', 'Bali Collection Nusa Dua', 50000.00, 'Setiap 2 jam sekali (08:00 - 20:00)', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(2, 'Padma Resort Legian', 'Lobby Padma', 'Beachwalk Shopping Center', 40000.00, 'Sesuai permintaan (On Demand)', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(3, 'Hard Rock Hotel Bali', 'Lobby Hard Rock', 'Discovery Shopping Mall', 30000.00, 'Setiap jam (10:00 - 22:00)', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(4, 'AYANA Resort Jimbaran', 'Lobby AYANA', 'Jimbaran Seafood Cafes', 60000.00, 'Setiap sore (15:00 - 21:00)', 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(5, 'The Apurva Kempinski', 'Lobby Kempinski', 'Nusa Dua Beach', 55000.00, 'Sesuai permintaan (On Demand)', 'inactive', '2026-05-28 21:58:15', '2026-05-28 21:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_29_000001_create_vehicles_table', 1),
(5, '2026_05_29_000002_create_drivers_table', 1),
(6, '2026_05_29_000003_create_tour_packages_table', 1),
(7, '2026_05_29_000004_create_airport_transfers_table', 1),
(8, '2026_05_29_000005_create_hotel_shuttles_table', 1),
(9, '2026_05_29_000006_create_rental_bookings_table', 1),
(10, '2026_05_29_000007_create_tour_bookings_table', 1),
(11, '2026_05_29_000008_create_transfer_bookings_table', 1),
(12, '2026_05_29_000009_create_shuttle_bookings_table', 1),
(13, '2026_05_29_000010_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `payable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payable_id` bigint UNSIGNED NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gross_amount` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','failed','expired','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `raw_response` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_bookings`
--

CREATE TABLE `rental_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED DEFAULT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rental_type` enum('full_day','half_day') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `total_price` decimal(12,2) NOT NULL,
  `booking_status` enum('pending','approved','on_trip','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','pending','paid','failed','expired','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shuttle_bookings`
--

CREATE TABLE `shuttle_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `hotel_shuttle_id` bigint UNSIGNED NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `passenger_count` int UNSIGNED NOT NULL,
  `pickup_time` time DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `total_price` decimal(12,2) NOT NULL,
  `booking_status` enum('pending','approved','on_trip','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','pending','paid','failed','expired','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_bookings`
--

CREATE TABLE `tour_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tour_package_id` bigint UNSIGNED NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `participant_count` int UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `total_price` decimal(12,2) NOT NULL,
  `booking_status` enum('pending','approved','on_trip','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','pending','paid','failed','expired','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_packages`
--

CREATE TABLE `tour_packages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `itinerary` text COLLATE utf8mb4_unicode_ci,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_packages`
--

INSERT INTO `tour_packages` (`id`, `name`, `description`, `itinerary`, `duration`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ubud Cultural Tour', 'Eksplorasi budaya dan keindahan alam Ubud, termasuk Monkey Forest, Tegalalang Rice Terrace, dan Pura Tirta Empul.', '08:00 - Penjemputan di hotel\n09:30 - Tegalalang Rice Terrace\n11:30 - Kintamani Volcano View (Makan Siang)\n14:00 - Pura Tirta Empul\n16:00 - Ubud Monkey Forest\n18:00 - Kembali ke hotel', '10 Jam', 650000.00, NULL, 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(2, 'Uluwatu Sunset Tour', 'Perjalanan ke selatan Bali menikmati sunset di Pura Uluwatu, pertunjukan Tari Kecak, dan makan malam seafood di Jimbaran.', '14:00 - Penjemputan di hotel\n15:30 - Pantai Pandawa / Melasti\n17:00 - Pura Uluwatu\n18:00 - Pertunjukan Tari Kecak\n19:30 - Jimbaran Seafood Dinner\n21:30 - Kembali ke hotel', '8 Jam', 550000.00, NULL, 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(3, 'Bedugul & Tanah Lot Tour', 'Kunjungi ikon wisata Bali: Pura Ulun Danu Beratan di Bedugul dan sunset magis di Pura Tanah Lot.', '09:00 - Penjemputan di hotel\n10:30 - Pura Taman Ayun\n12:30 - Pura Ulun Danu Beratan (Makan Siang)\n15:00 - Alas Kedaton Monkey Forest\n17:00 - Pura Tanah Lot (Sunset)\n19:00 - Kembali ke hotel', '10 Jam', 600000.00, NULL, 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(4, 'Nusa Penida West Trip (One Day)', 'Jelajahi pulau Nusa Penida bagian barat: Kelingking Beach, Broken Beach, Angel Billabong, dan Crystal Bay.', '06:30 - Penjemputan di hotel\n07:30 - Menyeberang dari Sanur\n09:00 - Tiba di Nusa Penida & Tour dimulai\n15:00 - Kembali ke pelabuhan\n17:00 - Tiba kembali di hotel', '11 Jam', 850000.00, NULL, 'inactive', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(5, 'Lempuyang & East Bali Tour', 'Berkunjung ke Gerbang Surga (Pura Lempuyang), Tirta Gangga, dan Taman Ujung Water Palace.', '06:00 - Penjemputan di hotel (pagi buta)\n08:30 - Pura Lempuyang\n11:30 - Tirta Gangga\n13:30 - Makan Siang\n15:00 - Taman Ujung\n18:00 - Kembali ke hotel', '12 Jam', 700000.00, NULL, 'active', '2026-05-28 21:58:15', '2026-05-28 21:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_bookings`
--

CREATE TABLE `transfer_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `airport_transfer_id` bigint UNSIGNED NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `passenger_count` int UNSIGNED NOT NULL,
  `flight_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `total_price` decimal(12,2) NOT NULL,
  `booking_status` enum('pending','approved','on_trip','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','pending','paid','failed','expired','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin@manikjaya.test', '2026-05-28 21:58:15', '$2y$12$QsNb3.GGdkko11AjONfe0e1UWqwT8UxbXvzxgIvbqVXL8FUQZ12vm', 'admin', '081234567890', 'Jl. Manik Jaya No. 1, Denpasar, Bali', NULL, '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(2, 'Budi Santoso', 'budi@example.com', '2026-05-28 21:58:15', '$2y$12$FENNqQHW59ViFX4tQMtBxOCxyx4pquhaOGepPeK5oOLLXTB87gVUm', 'customer', '081112223334', 'Jl. Sudirman, Jakarta', NULL, '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(3, 'Siti Aminah', 'siti@example.com', '2026-05-28 21:58:15', '$2y$12$avbEvK3kNj7byBcW1Bh4KO7eXp9LoCRFcPJcRyAioairuZyhpiThW', 'customer', '085556667778', 'Jl. Malioboro, Yogyakarta', NULL, '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(4, 'Andi Wijaya', 'andi@example.com', '2026-05-28 21:58:15', '$2y$12$dfAweIRfqL.amgR6hD9q6Oe2mbBkfYiQK555zVvZvIy2lSowqnrme', 'customer', '089998887776', 'Jl. Pemuda, Surabaya', NULL, '2026-05-28 21:58:15', '2026-05-28 21:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int UNSIGNED NOT NULL,
  `price_full_day` decimal(12,2) NOT NULL,
  `price_half_day` decimal(12,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('available','maintenance','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `type`, `capacity`, `price_full_day`, `price_half_day`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Toyota Hiace Commuter', 'Minibus', 14, 1200000.00, 800000.00, 'Minibus nyaman dengan kapasitas hingga 14 penumpang, cocok untuk rombongan wisata menengah.', NULL, 'available', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(2, 'Toyota Innova Zenix Hybrid', 'MPV', 6, 1000000.00, 650000.00, 'Mobil keluarga premium yang sangat nyaman dan tangguh, irit bahan bakar dengan teknologi hybrid.', NULL, 'available', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(3, 'Isuzu Elf Long', 'Minibus', 19, 1500000.00, 1000000.00, 'Kapasitas lebih besar untuk rombongan wisata. AC dingin dan kursi yang nyaman.', NULL, 'maintenance', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(4, 'Toyota Avanza', 'MPV', 6, 500000.00, 350000.00, 'Pilihan ekonomis untuk perjalanan keluarga kecil. Sangat praktis untuk di Bali.', NULL, 'available', '2026-05-28 21:58:15', '2026-05-28 21:58:15'),
(5, 'Toyota Alphard Transformer', 'Luxury MPV', 5, 2500000.00, 1500000.00, 'Kendaraan mewah untuk perjalanan VIP atau bisnis. Ekstra nyaman dengan captain seat.', NULL, 'available', '2026-05-28 21:58:15', '2026-05-28 21:58:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airport_transfers`
--
ALTER TABLE `airport_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `airport_transfers_status_index` (`status`),
  ADD KEY `airport_transfers_pickup_location_index` (`pickup_location`),
  ADD KEY `airport_transfers_dropoff_location_index` (`dropoff_location`);

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
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_status_index` (`status`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `hotel_shuttles`
--
ALTER TABLE `hotel_shuttles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_shuttles_status_index` (`status`),
  ADD KEY `hotel_shuttles_hotel_name_index` (`hotel_name`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_payable_type_payable_id_index` (`payable_type`,`payable_id`),
  ADD KEY `payments_user_id_index` (`user_id`),
  ADD KEY `payments_booking_code_index` (`booking_code`),
  ADD KEY `payments_status_index` (`status`),
  ADD KEY `payments_transaction_id_index` (`transaction_id`);

--
-- Indexes for table `rental_bookings`
--
ALTER TABLE `rental_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rental_bookings_booking_code_unique` (`booking_code`),
  ADD KEY `rental_bookings_user_id_index` (`user_id`),
  ADD KEY `rental_bookings_vehicle_id_index` (`vehicle_id`),
  ADD KEY `rental_bookings_driver_id_index` (`driver_id`),
  ADD KEY `rental_bookings_booking_status_index` (`booking_status`),
  ADD KEY `rental_bookings_payment_status_index` (`payment_status`),
  ADD KEY `rental_bookings_start_date_index` (`start_date`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shuttle_bookings`
--
ALTER TABLE `shuttle_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shuttle_bookings_booking_code_unique` (`booking_code`),
  ADD KEY `shuttle_bookings_hotel_shuttle_id_foreign` (`hotel_shuttle_id`),
  ADD KEY `shuttle_bookings_user_id_index` (`user_id`),
  ADD KEY `shuttle_bookings_booking_status_index` (`booking_status`),
  ADD KEY `shuttle_bookings_payment_status_index` (`payment_status`),
  ADD KEY `shuttle_bookings_booking_date_index` (`booking_date`);

--
-- Indexes for table `tour_bookings`
--
ALTER TABLE `tour_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tour_bookings_booking_code_unique` (`booking_code`),
  ADD KEY `tour_bookings_tour_package_id_foreign` (`tour_package_id`),
  ADD KEY `tour_bookings_user_id_index` (`user_id`),
  ADD KEY `tour_bookings_booking_status_index` (`booking_status`),
  ADD KEY `tour_bookings_payment_status_index` (`payment_status`),
  ADD KEY `tour_bookings_booking_date_index` (`booking_date`);

--
-- Indexes for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_packages_status_index` (`status`);

--
-- Indexes for table `transfer_bookings`
--
ALTER TABLE `transfer_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transfer_bookings_booking_code_unique` (`booking_code`),
  ADD KEY `transfer_bookings_airport_transfer_id_foreign` (`airport_transfer_id`),
  ADD KEY `transfer_bookings_user_id_index` (`user_id`),
  ADD KEY `transfer_bookings_booking_status_index` (`booking_status`),
  ADD KEY `transfer_bookings_payment_status_index` (`payment_status`),
  ADD KEY `transfer_bookings_booking_date_index` (`booking_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_status_index` (`status`),
  ADD KEY `vehicles_type_index` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airport_transfers`
--
ALTER TABLE `airport_transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_shuttles`
--
ALTER TABLE `hotel_shuttles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_bookings`
--
ALTER TABLE `rental_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shuttle_bookings`
--
ALTER TABLE `shuttle_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_bookings`
--
ALTER TABLE `tour_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_packages`
--
ALTER TABLE `tour_packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transfer_bookings`
--
ALTER TABLE `transfer_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rental_bookings`
--
ALTER TABLE `rental_bookings`
  ADD CONSTRAINT `rental_bookings_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rental_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shuttle_bookings`
--
ALTER TABLE `shuttle_bookings`
  ADD CONSTRAINT `shuttle_bookings_hotel_shuttle_id_foreign` FOREIGN KEY (`hotel_shuttle_id`) REFERENCES `hotel_shuttles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shuttle_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_bookings`
--
ALTER TABLE `tour_bookings`
  ADD CONSTRAINT `tour_bookings_tour_package_id_foreign` FOREIGN KEY (`tour_package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfer_bookings`
--
ALTER TABLE `transfer_bookings`
  ADD CONSTRAINT `transfer_bookings_airport_transfer_id_foreign` FOREIGN KEY (`airport_transfer_id`) REFERENCES `airport_transfers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfer_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
