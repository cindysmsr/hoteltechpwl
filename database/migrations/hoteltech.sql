-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Bulan Mei 2025 pada 06.28
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hoteltech`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `id_card_type` varchar(255) NOT NULL,
  `id_card_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guests`
--

INSERT INTO `guests` (`id`, `name`, `email`, `phone`, `address`, `id_card_type`, `id_card_number`, `created_at`, `updated_at`) VALUES
(1, 'Guest', 'guest@example.com', '(+62) 873 6708 792', 'Gg. Sumpah Pemuda No. 545, Pekanbaru 19796, Kaltim', 'ID Card', '22YQ69JAS6', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(2, 'laura melati mawar', 'laura@example.com', '089876543212', 'jalan bidan lubuk pakam no 10', 'KTP', '1234567898765432', '2025-05-15 05:34:29', '2025-05-15 05:34:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','paid','partially_paid','refunded') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `reservation_id`, `total_amount`, `tax_amount`, `grand_total`, `payment_method`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'INV-2025040001', 1, 100000.00, 11000.00, 111000.00, 'e-wallet', 'paid', 'Reservasi online', '2025-04-13 23:46:16', '2025-04-13 23:47:10'),
(2, 'INV-2025050001', 2, 300000.00, 33000.00, 333000.00, 'pending', 'pending', 'Reservasi online', '2025-05-15 05:35:06', '2025-05-15 05:35:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_18_142134_create_room_types_table', 1),
(5, '2025_03_18_142135_create_rooms_table', 1),
(6, '2025_03_18_142136_create_guests_table', 1),
(7, '2025_03_18_142137_create_reservations_table', 1),
(8, '2025_03_18_142138_create_invoices_table', 1),
(9, '2025_03_18_142138_create_reservation_rooms_table', 1),
(10, '2025_03_27_102634_create_review_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_number` varchar(255) NOT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `adults` int(11) NOT NULL,
  `children` int(11) NOT NULL DEFAULT 0,
  `status` enum('confirmed','checked_in','checked_out','cancelled') NOT NULL DEFAULT 'confirmed',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','partially_paid','refunded') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_number`, `guest_id`, `check_in_date`, `check_out_date`, `adults`, `children`, `status`, `total_amount`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 'RES-JNLPRLEI', 1, '2025-04-14', '2025-04-15', 2, 0, 'confirmed', 100000.00, 'paid', '2025-04-13 23:46:16', '2025-04-13 23:47:10'),
(2, 'RES-WLKLXPTO', 2, '2025-05-15', '2025-05-18', 1, 0, 'confirmed', 300000.00, 'pending', '2025-05-15 05:35:06', '2025-05-15 05:35:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservation_rooms`
--

CREATE TABLE `reservation_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservation_rooms`
--

INSERT INTO `reservation_rooms` (`id`, `reservation_id`, `room_id`, `price_per_night`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100000.00, '2025-04-13 23:46:16', '2025-04-13 23:46:16'),
(2, 2, 2, 100000.00, '2025-05-15 05:35:06', '2025-05-15 05:35:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `staff_rating` text DEFAULT NULL,
  `cleanliness_rating` text DEFAULT NULL,
  `comfort_rating` text DEFAULT NULL,
  `would_recommend` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `floor` int(11) NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type_id`, `floor`, `status`, `created_at`, `updated_at`) VALUES
(1, '101', 1, 1, 'available', '2025-04-01 09:50:59', '2025-05-18 21:06:31'),
(2, '102', 1, 1, 'available', '2025-04-01 09:50:59', '2025-05-18 21:06:48'),
(3, '103', 1, 1, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(4, '104', 1, 1, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(5, '105', 1, 1, 'available', '2025-04-01 09:50:59', '2025-05-18 21:07:17'),
(6, '106', 1, 1, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(7, '107', 1, 1, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(8, '108', 1, 1, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(9, '109', 1, 1, 'available', '2025-04-01 09:50:59', '2025-05-18 21:07:29'),
(10, '1010', 1, 1, 'available', '2025-04-01 09:50:59', '2025-05-18 21:07:43'),
(11, '201', 2, 2, 'occupied', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(12, '202', 2, 2, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(13, '203', 2, 2, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(14, '204', 2, 2, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(15, '205', 2, 2, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(16, '206', 2, 2, 'occupied', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(17, '207', 2, 2, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(18, '208', 2, 2, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(19, '301', 3, 3, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(20, '302', 3, 3, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(21, '303', 3, 3, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(22, '304', 3, 3, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(23, '305', 3, 3, 'available', '2025-04-01 09:50:59', '2025-04-01 09:50:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`amenities`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `img`, `description`, `price`, `capacity`, `amenities`, `created_at`, `updated_at`) VALUES
(1, 'Standard', 'room-types/X8UbKcQkHZo9bSBfcV89KNKhRAmtamCbdJoQWglI.jpg', 'Comfortable room with basic amenities for a pleasant stay.', 100000.00, 2, '[\"TV\",\"AC\",\"WiFi\",\"Private Bathroom\"]', '2025-04-01 09:50:59', '2025-04-14 00:03:31'),
(2, 'Deluxe', 'room-types/iej9icbyOwSu9XxSH0wE4JLAR8sX7Z2N784uxO8M.jpg', 'Spacious room with premium amenities and scenic views.', 200000.00, 2, '[\"TV\",\"AC\",\"WiFi\",\"Private Bathroom\",\"Mini Bar\",\"Coffee Maker\"]', '2025-04-01 09:50:59', '2025-04-14 00:03:52'),
(3, 'Suite', 'room-types/3cq3nrzATKti2CL4kgsUsUWaNdRn0huNjbVfFLDQ.jpg', 'Luxury suite with separate living area and exclusive amenities.', 350000.00, 4, '[\"TV\",\"AC\",\"WiFi\",\"Private Bathroom\",\"Mini Bar\",\"Coffee Maker\",\"Jacuzzi\",\"Kitchenette\",\"Living Room\"]', '2025-04-01 09:50:59', '2025-04-14 00:04:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BdTRvktjnN090CGcCo3tHMyJzOR37mJArMVFh7z0', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHpoT2xmUm9JYlRQOHpJeG5qM1N5YzJWNFo4RHA4U1BndkpoejZ0dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yb29tcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1747627664);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guest') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$12$XTZ5SFmSmKDRq3E8hqHYZu3RpqU9x1g82ELTbzSw3URqKszEe/9dG', 'admin', NULL, '2025-04-01 09:50:58', '2025-04-01 09:50:58'),
(2, 'Guest', 'guest@example.com', NULL, '$2y$12$tJ.iJITuwXdbZ86uYOoSheBZIhBMbb.4oHvsbHK6/O4P.3en13XGq', 'guest', NULL, '2025-04-01 09:50:59', '2025-04-01 09:50:59'),
(3, 'laura melati mawar', 'laura@example.com', NULL, '$2y$12$gFiUp5RWx4bpDvmSdu4K/Ovn9n87JRUELc4jZNrX7cAIh6zup7Ad.', 'guest', NULL, '2025-05-15 05:34:30', '2025-05-15 05:34:30');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_reservation_id_foreign` (`reservation_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservations_reservation_number_unique` (`reservation_number`),
  ADD KEY `reservations_guest_id_foreign` (`guest_id`);

--
-- Indeks untuk tabel `reservation_rooms`
--
ALTER TABLE `reservation_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_rooms_reservation_id_foreign` (`reservation_id`),
  ADD KEY `reservation_rooms_room_id_foreign` (`room_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_reservation_id_foreign` (`reservation_id`),
  ADD KEY `reviews_guest_id_foreign` (`guest_id`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indeks untuk tabel `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `reservation_rooms`
--
ALTER TABLE `reservation_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservation_rooms`
--
ALTER TABLE `reservation_rooms`
  ADD CONSTRAINT `reservation_rooms_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_rooms_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
