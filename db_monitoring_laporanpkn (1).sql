-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2026 at 08:28 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitoring_laporanpkn`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-lapor_state_08819009058', 'a:2:{s:4:\"step\";s:11:\"nama_proyek\";s:4:\"data\";a:0:{}}', 1784274975),
('laravel-cache-lapor_state_6282216255461', 'a:2:{s:4:\"step\";s:4:\"alat\";s:4:\"data\";a:10:{s:11:\"nama_proyek\";s:23:\"Pembangunan Hotel Aston\";s:8:\"kegiatan\";s:20:\"perancangan bangunan\";s:12:\"sub_kegiatan\";s:24:\"Analisis Kebutuhan Ruang\";s:9:\"pekerjaan\";s:20:\"Plesteran dan acian.\";s:6:\"lokasi\";s:20:\"jl sigura-gura no 78\";s:10:\"kontraktor\";s:13:\"Ariya Milaara\";s:9:\"konsultan\";s:11:\"Vena Bakker\";s:9:\"minggu_ke\";s:1:\"2\";s:6:\"tenaga\";s:19:\"Pekerja=3 Tukang=11\";s:8:\"material\";s:12:\"semenI10Isak\";}}', 1784278369),
('laravel-cache-lapor_state_6282228053992', 'a:2:{s:4:\"step\";s:11:\"nama_proyek\";s:4:\"data\";a:0:{}}', 1784285547),
('laravel-cache-lapor_state_6285163550798', 'a:2:{s:4:\"step\";s:8:\"template\";s:4:\"data\";a:0:{}}', 1784527196);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','aktif','nonaktif','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_by` bigint UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawans`
--

INSERT INTO `karyawans` (`id`, `user_id`, `nama`, `jabatan`, `no_hp`, `email`, `status`, `is_verified`, `verified_by`, `verified_at`, `created_at`, `updated_at`) VALUES
(2, 3, 'Andi Wijaya', 'Pelaksana', '081234567002', 'andi@monitoring.com', 'aktif', 1, NULL, '2026-07-13 00:59:59', '2026-07-12 10:09:37', '2026-07-13 00:59:59'),
(3, 4, 'Sri Wahyuni', 'Pengawas', '081234567003', 'sri@monitoring.com', 'aktif', 1, NULL, '2026-07-13 01:00:00', '2026-07-12 10:09:37', '2026-07-13 01:00:00'),
(4, 5, 'Rudi Hartono', 'Mandor', '081234567004', 'rudi@monitoring.com', 'aktif', 1, NULL, '2026-07-13 01:00:00', '2026-07-12 10:09:37', '2026-07-13 01:00:00'),
(5, 6, 'reno', 'Staff', '082228053992', 'reno@gmail.com', 'aktif', 1, NULL, NULL, '2026-07-12 23:27:54', '2026-07-12 23:27:54'),
(6, 7, 'arya', 'Safety Officer', '082216255462', 'arya@gmail.com', 'aktif', 1, NULL, '2026-07-13 01:08:40', '2026-07-13 01:08:04', '2026-07-13 01:08:40'),
(9, 11, 'Akun Bot Dummy', 'Staff', '08819009058', 'bot_dummy@monitoring.com', 'aktif', 1, NULL, '2026-07-16 07:09:23', '2026-07-16 07:09:23', '2026-07-16 07:09:23'),
(10, 11, 'Akun Bot Dummy (62)', 'Staff', '628819009058', 'bot_dummy@monitoring.com', 'aktif', 1, NULL, '2026-07-16 07:09:23', '2026-07-16 07:09:23', '2026-07-16 07:09:23'),
(11, 12, 'Vena', 'Quality Control', '085123456789', 'vena@gmail.com', 'aktif', 1, 10, '2026-07-16 21:04:09', '2026-07-16 21:04:09', '2026-07-16 21:04:09'),
(12, NULL, 'Fanya', 'Staff', '085163550798', NULL, 'aktif', 1, NULL, NULL, '2026-07-16 23:28:38', '2026-07-16 23:28:38'),
(13, NULL, 'V~', 'Staff', '082248297542', NULL, 'aktif', 1, NULL, NULL, '2026-07-17 00:19:26', '2026-07-17 00:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint UNSIGNED NOT NULL,
  `karyawan_id` bigint UNSIGNED NOT NULL,
  `nama_proyek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontraktor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konsultan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minggu_ke` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Menunggu','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporans`
--

INSERT INTO `laporans` (`id`, `karyawan_id`, `nama_proyek`, `kegiatan`, `sub_kegiatan`, `pekerjaan`, `lokasi`, `kontraktor`, `konsultan`, `pic`, `minggu_ke`, `tanggal`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(2, 5, 'Pembangunan Jalan', 'PERBAIKAN JALAN', 'pengrataan Tanah', 'PEMANTAUAN', 'KABUPATEN MALANG', NULL, 'PT RENO', 'Ir. Andi Saputra', '1', '2026-07-14', NULL, 'Disetujui', '2026-07-13 21:52:56', '2026-07-13 21:53:03'),
(3, 6, 'pembangunan tempat biliard', 'pemasangan meja biliard', 'pemasangan meja', 'PEMANTAUAN', 'malang', 'doremi', 'PT RENO', 'deri klau', '3', '2026-07-16', 'sonde ada', 'Disetujui', '2026-07-14 01:33:50', '2026-07-14 01:34:05'),
(9, 13, 'Perbaikan instalasi', 'Pemasangan kabel', 'Kosong', 'Pemasangan kabel pada lantai 3', 'Malang jln golf', 'vena', 'Arya', NULL, 'Minggu ke 3', '2026-07-17', 'Cuaca cerah', 'Disetujui', '2026-07-17 00:19:26', '2026-07-17 00:21:47'),
(10, 12, 'pembangunan gedung ITN Malang', 'pembangunan', '', 'pembangunan', 'bali', 'vena', 'reno, arya', NULL, '5', '2026-07-17', '-', 'Ditolak', '2026-07-17 01:29:55', '2026-07-17 04:34:56'),
(11, 13, 'Pembangun hotel aston', 'Perancangan bangunan', 'analisis kebutuhan ruang', 'Plasteran dan acian', 'Jl golf 75 malang', 'Ariya', 'Venox', NULL, '2', '2026-07-17', '-', 'Ditolak', '2026-07-17 01:31:04', '2026-07-19 21:28:03'),
(12, 13, 'Pembangunan hotel', 'Pemasangan lantai', 'Bdjshshb', 'Hshsusbam', 'Malang', 'Arhsba', 'Hsuahau', NULL, '2', '2026-07-17', 'a', 'Ditolak', '2026-07-17 01:55:12', '2026-07-19 19:28:38'),
(13, 12, 'a', 'a', 'a', 'a', 'a', 'a', 'a', NULL, 'a', '2026-07-20', 'a', 'Menunggu', '2026-07-19 19:27:33', '2026-07-19 19:27:33'),
(14, 13, 'Vena', 'a', NULL, 'a', 'b', NULL, NULL, NULL, NULL, '2026-07-20', NULL, 'Menunggu', '2026-07-19 19:30:55', '2026-07-19 19:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_alats`
--

CREATE TABLE `laporan_alats` (
  `id` bigint UNSIGNED NOT NULL,
  `laporan_id` bigint UNSIGNED NOT NULL,
  `nama_alat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_alats`
--

INSERT INTO `laporan_alats` (`id`, `laporan_id`, `nama_alat`, `jumlah`, `created_at`, `updated_at`) VALUES
(4, 9, 'Obeng', 1, '2026-07-17 00:19:26', '2026-07-17 00:19:26'),
(5, 11, 'Skop', 1, '2026-07-17 01:31:04', '2026-07-17 01:31:04'),
(6, 12, 'Sekop', 1, '2026-07-17 01:55:12', '2026-07-17 01:55:12'),
(7, 13, 'a', 1, '2026-07-19 19:27:33', '2026-07-19 19:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_fotos`
--

CREATE TABLE `laporan_fotos` (
  `id` bigint UNSIGNED NOT NULL,
  `laporan_id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_materials`
--

CREATE TABLE `laporan_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `laporan_id` bigint UNSIGNED NOT NULL,
  `nama_material` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` decimal(8,2) NOT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_pekerjaans`
--

CREATE TABLE `laporan_pekerjaans` (
  `id` bigint UNSIGNED NOT NULL,
  `laporan_id` bigint UNSIGNED NOT NULL,
  `nama_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_pekerjaans`
--

INSERT INTO `laporan_pekerjaans` (`id`, `laporan_id`, `nama_pekerjaan`, `created_at`, `updated_at`) VALUES
(5, 9, 'Pemasangan kabel pada lantai 3', '2026-07-17 00:19:26', '2026-07-17 00:19:26'),
(6, 10, 'pembangunan', '2026-07-17 01:29:55', '2026-07-17 01:29:55'),
(7, 11, 'Plasteran dan acian', '2026-07-17 01:31:04', '2026-07-17 01:31:04'),
(8, 12, 'Hshsusbam', '2026-07-17 01:55:12', '2026-07-17 01:55:12'),
(9, 13, 'a', '2026-07-19 19:27:33', '2026-07-19 19:27:33'),
(10, 14, 'a', '2026-07-19 19:30:55', '2026-07-19 19:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_tenagas`
--

CREATE TABLE `laporan_tenagas` (
  `id` bigint UNSIGNED NOT NULL,
  `laporan_id` bigint UNSIGNED NOT NULL,
  `pekerja` int NOT NULL DEFAULT '0',
  `tukang` int NOT NULL DEFAULT '0',
  `mandor` int NOT NULL DEFAULT '0',
  `pelaksana` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_tenagas`
--

INSERT INTO `laporan_tenagas` (`id`, `laporan_id`, `pekerja`, `tukang`, `mandor`, `pelaksana`, `created_at`, `updated_at`) VALUES
(3, 11, 3, 3, 0, 0, '2026-07-17 01:31:04', '2026-07-17 01:31:04'),
(4, 12, 0, 8, 0, 0, '2026-07-17 01:55:12', '2026-07-17 01:55:12'),
(5, 13, 0, 0, 0, 0, '2026-07-19 19:27:33', '2026-07-19 19:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_06_060235_create_karyawans_table', 1),
(5, '2026_07_06_060243_create_proyeks_table', 1),
(6, '2026_07_06_060258_create_laporans_table', 1),
(7, '2026_07_06_060306_create_laporan_pekerjaans_table', 1),
(8, '2026_07_06_060318_create_laporan_tenagas_table', 1),
(9, '2026_07_06_060424_create_laporan_alats_table', 1),
(10, '2026_07_06_060435_create_laporan_fotos_table', 1),
(11, '2026_07_06_060441_create_verifikasis_table', 1),
(12, '2026_07_08_014626_add_role_to_users_table', 1),
(13, '2026_07_08_014710_add_user_id_to_karyawans_table', 1),
(14, '2026_07_08_043938_create_laporan_materials_table', 1),
(15, '2026_07_08_064559_add_detail_fields_to_proyeks_table', 1),
(16, '2026_07_09_080822_move_project_fields_to_laporans', 1),
(17, '2026_07_09_090109_add_project_info_to_laporans_table', 1),
(18, '2026_07_13_000001_update_karyawans_verification_columns', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proyeks`
--

CREATE TABLE `proyeks` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_proyek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_proyek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontraktor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `konsultan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Aktif','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
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
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4UajzbYhjO64G3yw5tD9trQC9HjgCVLucsjpVx4L', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIxd0pLamthakZCUU9aN0FqQnpwOVBGYUVWZlh6WEZDUHBkZVhzQ2hGIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2xhcG9yYW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL3ZlcmlmaWthc2kiLCJyb3V0ZSI6InZlcmlmaWthc2kuaW5kZXgifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEwfQ==', 1784291696),
('dvaz5JjVmwSloSfdfNqS5aeRj49dVdXxktonVODM', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJqUnA1dWxIVmdmQWVwRk5BWW56amFtVnM5WTA3VkJnVTRHSHQ4R215IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sYXBvcmFuIiwicm91dGUiOiJsYXBvcmFuLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEwfQ==', 1784518710),
('EHHGhcs1uAR5ntlPdyRTRiwB51cYs0wWB5w05Hpz', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJrREpIdmJSeTlvRzdtVHM0WGhqTFNZR0RlVHRYbWtuMGUzSDlFMUg1IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2thcnlhd2FuIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvbGFwb3JhbiIsInJvdXRlIjoibGFwb3Jhbi5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxMH0=', 1784529774),
('hUnXJdsfMR8ub80zrblzJCJ9CoElqZSfZd7dZ4g1', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJQRlZNMTU1SGxrbk1RZllmaHJWY3lqMEpIdnhWR0FzdDFYVW1tY1hUIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL3ZlcmlmaWthc2kifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9rYXJ5YXdhbiIsInJvdXRlIjoia2FyeWF3YW4uaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MTB9', 1784525811),
('n1HUoQcA5lXaHoJQ0iHt0shSyL2j2I3rJqgFf1Wg', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJDamZnb1luMVVIbE1EcEs4VlZzazZROFlUUTBpZzJGc05qOHFKTkR5IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9sYXBvcmFuIiwicm91dGUiOiJsYXBvcmFuLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEwfQ==', 1784282271);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','karyawan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karyawan',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Budi Santoso', 'budi@monitoring.com', NULL, '$2y$12$WAMa//TTzCQySTV7cl8qquptUM37GiWryYfBr.b3fYKKfG8sMD67K', 'karyawan', NULL, '2026-07-12 10:09:37', '2026-07-13 00:59:59'),
(3, 'Andi Wijaya', 'andi@monitoring.com', NULL, '$2y$12$CbiwBxznjV8AaZ0qIsnJFeENLt8Ehfaj1qi3jFWgdfnMxrLyVvFxi', 'karyawan', NULL, '2026-07-12 10:09:37', '2026-07-13 00:59:59'),
(4, 'Sri Wahyuni', 'sri@monitoring.com', NULL, '$2y$12$/N36VjAsULH1Mv3XT/maXO3uA0yBExsv0tlVhNWJmljCFlxc0FKbS', 'karyawan', NULL, '2026-07-12 10:09:37', '2026-07-13 01:00:00'),
(5, 'Rudi Hartono', 'rudi@monitoring.com', NULL, '$2y$12$lSXCgB1ooLF3boqLGs9sCOjhmv9bLFm2RYGz6ZjItYaj.E.sJuJ4G', 'karyawan', NULL, '2026-07-12 10:09:37', '2026-07-13 01:00:00'),
(6, 'reno', 'reno@gmail.com', NULL, '$2y$12$5ZTqwwKcs8iPbiZ0zdNOF.zfnZPky7Pp7MEa0mNOWRkO.oCnFkaAK', 'karyawan', NULL, '2026-07-12 23:27:54', '2026-07-12 23:27:54'),
(7, 'arya', 'arya@gmail.com', NULL, '$2y$12$bRHHwu.EVg8E6aDKq6BmoODvXzyrFmXEhtf8iYjasN13uCsJj0XhO', 'karyawan', NULL, '2026-07-13 01:08:04', '2026-07-13 01:08:04'),
(9, 'Vena', 'alen@gmail.com', NULL, '$2y$12$fGXJkmCfPhhAy3nI2/KA6.DJvesLX8FzJz5CMriOm6hthNvjuXv4O', 'karyawan', '5YVQQIF3ahdyBY9SJcvM1oWHhQera9w6hGeqSsJtH5WMuEZCmYoukyVQr8YF', '2026-07-16 02:20:12', '2026-07-16 02:20:12'),
(10, 'Administrator', 'admin@monitoring.com', NULL, '$2y$12$Am5jt6Eu6N.yrDXlGbsfpuyE1pJZKappJS7WphF60yFwqw/P/KPOW', 'admin', 'cXeUJkMIgjtMeC3HaBBHPhl0gcKcA6rjBwtvHhWcyWLOUdrunx3TEc8HW3gP', '2026-07-16 06:57:08', '2026-07-16 06:57:08'),
(11, 'Akun Bot Dummy', 'bot_dummy@monitoring.com', NULL, '$2y$12$H6DaPyc2UuZkf.2DcLojWuU6310w7DqPzy4hgc9bIMX/kUmN11jIe', 'karyawan', NULL, '2026-07-16 07:09:23', '2026-07-16 07:09:23'),
(12, 'Vena', 'vena@gmail.com', NULL, '$2y$12$KYvBDqXd.2o5kF8aN.edeOq0iQ6T0YiBXAg/QxFSwDTM.6h5nzbgq', 'karyawan', NULL, '2026-07-16 21:04:09', '2026-07-16 21:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `verifikasis`
--

CREATE TABLE `verifikasis` (
  `id` bigint UNSIGNED NOT NULL,
  `laporan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verifikasis`
--

INSERT INTO `verifikasis` (`id`, `laporan_id`, `user_id`, `status`, `catatan`, `tanggal_verifikasi`, `created_at`, `updated_at`) VALUES
(6, 9, 10, 'Disetujui', 'Laporan disetujui', '2026-07-17 00:21:47', '2026-07-17 00:21:47', '2026-07-17 00:21:47'),
(7, 10, 10, 'Ditolak', '-', '2026-07-17 04:34:56', '2026-07-17 04:34:56', '2026-07-17 04:34:56'),
(8, 12, 10, 'Ditolak', 'a', '2026-07-19 19:28:38', '2026-07-19 19:28:38', '2026-07-19 19:28:38'),
(9, 11, 10, 'Ditolak', '-', '2026-07-19 21:28:03', '2026-07-19 21:28:03', '2026-07-19 21:28:03');

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
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

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
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawans_no_hp_unique` (`no_hp`),
  ADD KEY `karyawans_user_id_foreign` (`user_id`),
  ADD KEY `karyawans_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporans_karyawan_id_foreign` (`karyawan_id`),
  ADD KEY `laporans_tanggal_index` (`tanggal`),
  ADD KEY `laporans_status_index` (`status`);

--
-- Indexes for table `laporan_alats`
--
ALTER TABLE `laporan_alats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_alats_laporan_id_foreign` (`laporan_id`);

--
-- Indexes for table `laporan_fotos`
--
ALTER TABLE `laporan_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_fotos_laporan_id_foreign` (`laporan_id`);

--
-- Indexes for table `laporan_materials`
--
ALTER TABLE `laporan_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_materials_laporan_id_foreign` (`laporan_id`);

--
-- Indexes for table `laporan_pekerjaans`
--
ALTER TABLE `laporan_pekerjaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_pekerjaans_laporan_id_foreign` (`laporan_id`);

--
-- Indexes for table `laporan_tenagas`
--
ALTER TABLE `laporan_tenagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_tenagas_laporan_id_foreign` (`laporan_id`);

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
-- Indexes for table `proyeks`
--
ALTER TABLE `proyeks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proyeks_kode_proyek_unique` (`kode_proyek`);

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
-- Indexes for table `verifikasis`
--
ALTER TABLE `verifikasis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `verifikasis_laporan_id_unique` (`laporan_id`),
  ADD KEY `verifikasis_user_id_foreign` (`user_id`),
  ADD KEY `verifikasis_status_index` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `laporan_alats`
--
ALTER TABLE `laporan_alats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `laporan_fotos`
--
ALTER TABLE `laporan_fotos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_materials`
--
ALTER TABLE `laporan_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laporan_pekerjaans`
--
ALTER TABLE `laporan_pekerjaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `laporan_tenagas`
--
ALTER TABLE `laporan_tenagas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `proyeks`
--
ALTER TABLE `proyeks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `verifikasis`
--
ALTER TABLE `verifikasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD CONSTRAINT `karyawans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `karyawans_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `laporans`
--
ALTER TABLE `laporans`
  ADD CONSTRAINT `laporans_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_alats`
--
ALTER TABLE `laporan_alats`
  ADD CONSTRAINT `laporan_alats_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_fotos`
--
ALTER TABLE `laporan_fotos`
  ADD CONSTRAINT `laporan_fotos_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_materials`
--
ALTER TABLE `laporan_materials`
  ADD CONSTRAINT `laporan_materials_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_pekerjaans`
--
ALTER TABLE `laporan_pekerjaans`
  ADD CONSTRAINT `laporan_pekerjaans_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_tenagas`
--
ALTER TABLE `laporan_tenagas`
  ADD CONSTRAINT `laporan_tenagas_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verifikasis`
--
ALTER TABLE `verifikasis`
  ADD CONSTRAINT `verifikasis_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `verifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
