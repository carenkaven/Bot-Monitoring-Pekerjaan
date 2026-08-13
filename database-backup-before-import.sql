-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_monitoring_laporanpkn
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-lapor_state_08819009058','a:2:{s:4:\"step\";s:11:\"nama_proyek\";s:4:\"data\";a:0:{}}',1784274975),('laravel-cache-lapor_state_6282216255461','a:2:{s:4:\"step\";s:4:\"alat\";s:4:\"data\";a:10:{s:11:\"nama_proyek\";s:23:\"Pembangunan Hotel Aston\";s:8:\"kegiatan\";s:20:\"perancangan bangunan\";s:12:\"sub_kegiatan\";s:24:\"Analisis Kebutuhan Ruang\";s:9:\"pekerjaan\";s:20:\"Plesteran dan acian.\";s:6:\"lokasi\";s:20:\"jl sigura-gura no 78\";s:10:\"kontraktor\";s:13:\"Ariya Milaara\";s:9:\"konsultan\";s:11:\"Vena Bakker\";s:9:\"minggu_ke\";s:1:\"2\";s:6:\"tenaga\";s:19:\"Pekerja=3 Tukang=11\";s:8:\"material\";s:12:\"semenI10Isak\";}}',1784278369),('laravel-cache-lapor_state_6282228053992','a:2:{s:4:\"step\";s:11:\"nama_proyek\";s:4:\"data\";a:0:{}}',1784285547);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karyawans`
--

DROP TABLE IF EXISTS `karyawans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `karyawans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','aktif','nonaktif','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_by` bigint unsigned DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `karyawans_no_hp_unique` (`no_hp`),
  KEY `karyawans_user_id_foreign` (`user_id`),
  KEY `karyawans_verified_by_foreign` (`verified_by`),
  CONSTRAINT `karyawans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `karyawans_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karyawans`
--

LOCK TABLES `karyawans` WRITE;
/*!40000 ALTER TABLE `karyawans` DISABLE KEYS */;
INSERT INTO `karyawans` VALUES (2,3,'Andi Wijaya','Pelaksana','081234567002','andi@monitoring.com','aktif',1,NULL,'2026-07-30 19:04:47','2026-07-12 10:09:37','2026-07-30 19:04:47'),(3,4,'Sri Wahyuni','Pengawas','081234567003','sri@monitoring.com','aktif',1,NULL,'2026-07-30 19:04:47','2026-07-12 10:09:37','2026-07-30 19:04:47'),(4,5,'Rudi Hartono','Mandor','081234567004','rudi@monitoring.com','aktif',1,NULL,'2026-07-30 19:04:47','2026-07-12 10:09:37','2026-07-30 19:04:47'),(5,6,'reno','Staff','082228053992','reno@gmail.com','aktif',1,NULL,NULL,'2026-07-12 23:27:54','2026-07-12 23:27:54'),(6,7,'arya','Safety Officer','082216255462','arya@gmail.com','aktif',1,NULL,'2026-07-13 01:08:40','2026-07-13 01:08:04','2026-07-13 01:08:40'),(9,11,'Akun Bot Dummy','Staff','08819009058','bot_dummy@monitoring.com','aktif',1,NULL,'2026-07-16 07:09:23','2026-07-16 07:09:23','2026-07-16 07:09:23'),(10,11,'Akun Bot Dummy (62)','Staff','628819009058','bot_dummy@monitoring.com','aktif',1,NULL,'2026-07-16 07:09:23','2026-07-16 07:09:23','2026-07-16 07:09:23'),(11,12,'Vena','Quality Control','085123456789','vena@gmail.com','aktif',1,10,'2026-07-16 21:04:09','2026-07-16 21:04:09','2026-07-16 21:04:09'),(12,NULL,'Fanya','Staff','085163550798',NULL,'aktif',1,NULL,NULL,'2026-07-16 23:28:38','2026-07-16 23:28:38'),(13,NULL,'V~','Staff','082248297542','kaven@gmail.com','aktif',1,NULL,NULL,'2026-07-17 00:19:26','2026-07-30 19:23:03'),(14,2,'Budi Santoso','Mandor','081234567001','budi@monitoring.com','aktif',1,NULL,'2026-07-30 19:04:47','2026-07-30 19:04:47','2026-07-30 19:04:47');
/*!40000 ALTER TABLE `karyawans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_alats`
--

DROP TABLE IF EXISTS `laporan_alats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_alats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_id` bigint unsigned NOT NULL,
  `nama_alat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_alats_laporan_id_foreign` (`laporan_id`),
  CONSTRAINT `laporan_alats_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_alats`
--

LOCK TABLES `laporan_alats` WRITE;
/*!40000 ALTER TABLE `laporan_alats` DISABLE KEYS */;
INSERT INTO `laporan_alats` VALUES (4,9,'Obeng',1,'2026-07-17 00:19:26','2026-07-17 00:19:26'),(5,11,'Skop',1,'2026-07-17 01:31:04','2026-07-17 01:31:04'),(6,12,'Sekop',1,'2026-07-17 01:55:12','2026-07-17 01:55:12'),(8,15,'Dump Truck',4,'2026-07-30 19:04:47','2026-07-30 19:04:47'),(9,15,'Bar Bender',2,'2026-07-30 19:04:47','2026-07-30 19:04:47'),(10,16,'Excavator PC-200',1,'2026-07-30 19:04:47','2026-07-30 19:04:47'),(11,16,'Vibrator',3,'2026-07-30 19:04:47','2026-07-30 19:04:47'),(14,18,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(15,18,'Bar Bender',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(16,19,'Concrete Mixer',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(17,19,'Vibrator',3,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(18,20,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(19,20,'Bar Bender',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(20,21,'Concrete Mixer',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(21,21,'Bar Bender',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(22,22,'Concrete Mixer',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(23,22,'Dump Truck',4,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(24,23,'Concrete Mixer',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(25,23,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(26,24,'Concrete Mixer',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(27,24,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(28,25,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(29,25,'Dump Truck',4,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(30,26,'Dump Truck',4,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(31,26,'Bar Bender',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(32,27,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(33,27,'Vibrator',3,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(34,28,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(35,28,'Bar Bender',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(36,29,'Concrete Mixer',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(37,29,'Bar Bender',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(38,30,'Vibrator',3,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(39,30,'Dump Truck',4,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(40,31,'Dump Truck',4,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(41,31,'Bar Bender',2,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(42,32,'Excavator PC-200',1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(43,32,'Dump Truck',4,'2026-07-30 19:04:48','2026-07-30 19:04:48');
/*!40000 ALTER TABLE `laporan_alats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_fotos`
--

DROP TABLE IF EXISTS `laporan_fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_fotos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_id` bigint unsigned NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_fotos_laporan_id_foreign` (`laporan_id`),
  CONSTRAINT `laporan_fotos_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_fotos`
--

LOCK TABLES `laporan_fotos` WRITE;
/*!40000 ALTER TABLE `laporan_fotos` DISABLE KEYS */;
/*!40000 ALTER TABLE `laporan_fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_materials`
--

DROP TABLE IF EXISTS `laporan_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_id` bigint unsigned NOT NULL,
  `nama_material` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` decimal(8,2) NOT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_materials_laporan_id_foreign` (`laporan_id`),
  CONSTRAINT `laporan_materials_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_materials`
--

LOCK TABLES `laporan_materials` WRITE;
/*!40000 ALTER TABLE `laporan_materials` DISABLE KEYS */;
INSERT INTO `laporan_materials` VALUES (3,15,'Besi Beton 12mm',26.00,'batang','2026-07-30 19:04:47','2026-07-30 19:04:47'),(4,15,'Pasir Beton',10.00,'m³','2026-07-30 19:04:47','2026-07-30 19:04:47'),(5,15,'Kerikil 2/3',9.00,'m³','2026-07-30 19:04:47','2026-07-30 19:04:47'),(6,16,'Besi Beton 12mm',27.00,'batang','2026-07-30 19:04:47','2026-07-30 19:04:47'),(7,16,'Kerikil 2/3',11.00,'m³','2026-07-30 19:04:47','2026-07-30 19:04:47'),(8,16,'Ready Mix K-350',19.00,'m³','2026-07-30 19:04:47','2026-07-30 19:04:47'),(12,18,'Semen Portland',56.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(13,18,'Besi Beton 12mm',26.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(14,18,'Kerikil 2/3',9.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(15,19,'Semen Portland',58.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(16,19,'Besi Beton 12mm',26.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(17,19,'Ready Mix K-350',20.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(18,20,'Semen Portland',54.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(19,20,'Besi Beton 12mm',29.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(20,20,'Ready Mix K-350',25.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(21,21,'Besi Beton 12mm',25.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(22,21,'Kerikil 2/3',6.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(23,21,'Ready Mix K-350',25.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(24,22,'Semen Portland',51.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(25,22,'Pasir Beton',11.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(26,22,'Kerikil 2/3',7.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(27,23,'Semen Portland',60.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(28,23,'Pasir Beton',12.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(29,23,'Kerikil 2/3',7.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(30,24,'Semen Portland',58.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(31,24,'Kerikil 2/3',11.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(32,24,'Ready Mix K-350',24.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(33,25,'Semen Portland',59.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(34,25,'Besi Beton 12mm',25.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(35,25,'Pasir Beton',9.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(36,26,'Semen Portland',52.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(37,26,'Pasir Beton',12.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(38,26,'Ready Mix K-350',25.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(39,27,'Besi Beton 12mm',34.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(40,27,'Kerikil 2/3',16.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(41,27,'Ready Mix K-350',15.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(42,28,'Semen Portland',59.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(43,28,'Kerikil 2/3',15.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(44,28,'Ready Mix K-350',19.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(45,29,'Semen Portland',52.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(46,29,'Pasir Beton',8.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(47,29,'Ready Mix K-350',16.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(48,30,'Besi Beton 12mm',31.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(49,30,'Pasir Beton',12.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(50,30,'Ready Mix K-350',20.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(51,31,'Semen Portland',55.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(52,31,'Besi Beton 12mm',30.00,'batang','2026-07-30 19:04:48','2026-07-30 19:04:48'),(53,31,'Ready Mix K-350',15.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(54,32,'Semen Portland',53.00,'sak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(55,32,'Kerikil 2/3',16.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48'),(56,32,'Ready Mix K-350',24.00,'m³','2026-07-30 19:04:48','2026-07-30 19:04:48');
/*!40000 ALTER TABLE `laporan_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_pekerjaans`
--

DROP TABLE IF EXISTS `laporan_pekerjaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_pekerjaans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_id` bigint unsigned NOT NULL,
  `nama_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_pekerjaans_laporan_id_foreign` (`laporan_id`),
  CONSTRAINT `laporan_pekerjaans_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_pekerjaans`
--

LOCK TABLES `laporan_pekerjaans` WRITE;
/*!40000 ALTER TABLE `laporan_pekerjaans` DISABLE KEYS */;
INSERT INTO `laporan_pekerjaans` VALUES (5,9,'Pemasangan kabel pada lantai 3','2026-07-17 00:19:26','2026-07-17 00:19:26'),(6,10,'pembangunan','2026-07-17 01:29:55','2026-07-17 01:29:55'),(7,11,'Plasteran dan acian','2026-07-17 01:31:04','2026-07-17 01:31:04'),(8,12,'Hshsusbam','2026-07-17 01:55:12','2026-07-17 01:55:12'),(10,14,'a','2026-07-19 19:30:55','2026-07-19 19:30:55'),(11,15,'Pembesian','2026-07-30 19:04:47','2026-07-30 19:04:47'),(12,15,'Bekisting','2026-07-30 19:04:47','2026-07-30 19:04:47'),(13,16,'Pembesian','2026-07-30 19:04:47','2026-07-30 19:04:47'),(14,16,'Pengaspalan','2026-07-30 19:04:47','2026-07-30 19:04:47'),(17,18,'Bekisting','2026-07-30 19:04:48','2026-07-30 19:04:48'),(18,18,'Timbunan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(19,19,'Bekisting','2026-07-30 19:04:48','2026-07-30 19:04:48'),(20,19,'Pengaspalan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(21,20,'Galian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(22,20,'Pengaspalan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(23,21,'Galian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(24,21,'Pemasangan Batu','2026-07-30 19:04:48','2026-07-30 19:04:48'),(25,22,'Bekisting','2026-07-30 19:04:48','2026-07-30 19:04:48'),(26,22,'Pengaspalan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(27,23,'Galian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(28,23,'Pengaspalan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(29,24,'Pengecoran','2026-07-30 19:04:48','2026-07-30 19:04:48'),(30,24,'Pengaspalan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(31,25,'Galian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(32,25,'Pemasangan Batu','2026-07-30 19:04:48','2026-07-30 19:04:48'),(33,26,'Pembesian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(34,26,'Timbunan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(35,27,'Pengecoran','2026-07-30 19:04:48','2026-07-30 19:04:48'),(36,27,'Pembesian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(37,28,'Pengecoran','2026-07-30 19:04:48','2026-07-30 19:04:48'),(38,28,'Galian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(39,29,'Bekisting','2026-07-30 19:04:48','2026-07-30 19:04:48'),(40,29,'Timbunan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(41,30,'Pembesian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(42,30,'Bekisting','2026-07-30 19:04:48','2026-07-30 19:04:48'),(43,31,'Pembesian','2026-07-30 19:04:48','2026-07-30 19:04:48'),(44,31,'Pengaspalan','2026-07-30 19:04:48','2026-07-30 19:04:48'),(45,32,'Pengecoran','2026-07-30 19:04:48','2026-07-30 19:04:48'),(46,32,'Pembesian','2026-07-30 19:04:48','2026-07-30 19:04:48');
/*!40000 ALTER TABLE `laporan_pekerjaans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_tenagas`
--

DROP TABLE IF EXISTS `laporan_tenagas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_tenagas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_id` bigint unsigned NOT NULL,
  `pekerja` int NOT NULL DEFAULT '0',
  `tukang` int NOT NULL DEFAULT '0',
  `mandor` int NOT NULL DEFAULT '0',
  `pelaksana` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_tenagas_laporan_id_foreign` (`laporan_id`),
  CONSTRAINT `laporan_tenagas_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_tenagas`
--

LOCK TABLES `laporan_tenagas` WRITE;
/*!40000 ALTER TABLE `laporan_tenagas` DISABLE KEYS */;
INSERT INTO `laporan_tenagas` VALUES (3,11,3,3,0,0,'2026-07-17 01:31:04','2026-07-17 01:31:04'),(4,12,0,8,0,0,'2026-07-17 01:55:12','2026-07-17 01:55:12'),(6,15,5,5,2,1,'2026-07-30 19:04:47','2026-07-30 19:04:47'),(7,16,4,2,2,1,'2026-07-30 19:04:47','2026-07-30 19:04:47'),(9,18,7,7,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(10,19,7,8,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(11,20,11,4,1,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(12,21,10,4,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(13,22,11,5,1,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(14,23,9,5,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(15,24,12,2,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(16,25,12,4,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(17,26,13,3,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(18,27,13,5,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(19,28,5,3,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(20,29,14,3,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(21,30,8,8,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(22,31,7,2,2,1,'2026-07-30 19:04:48','2026-07-30 19:04:48'),(23,32,9,4,1,1,'2026-07-30 19:04:48','2026-07-30 19:04:48');
/*!40000 ALTER TABLE `laporan_tenagas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporans`
--

DROP TABLE IF EXISTS `laporans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `karyawan_id` bigint unsigned NOT NULL,
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
  `progress` int DEFAULT NULL,
  `jam_mulai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_selesai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cuaca` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kendala` text COLLATE utf8mb4_unicode_ci,
  `rencana_besok` text COLLATE utf8mb4_unicode_ci,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Menunggu','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporans_karyawan_id_foreign` (`karyawan_id`),
  KEY `laporans_tanggal_index` (`tanggal`),
  KEY `laporans_status_index` (`status`),
  CONSTRAINT `laporans_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporans`
--

LOCK TABLES `laporans` WRITE;
/*!40000 ALTER TABLE `laporans` DISABLE KEYS */;
INSERT INTO `laporans` VALUES (2,5,'Pembangunan Jalan','PERBAIKAN JALAN','pengrataan Tanah','PEMANTAUAN','KABUPATEN MALANG',NULL,'PT RENO','Ir. Andi Saputra','1','2026-07-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-13 21:52:56','2026-07-13 21:53:03'),(3,6,'pembangunan tempat biliard','pemasangan meja biliard','pemasangan meja','PEMANTAUAN','malang','doremi','PT RENO','deri klau','3','2026-07-16',NULL,NULL,NULL,'sonde ada',NULL,NULL,NULL,NULL,'Disetujui','2026-07-14 01:33:50','2026-07-14 01:34:05'),(9,13,'Perbaikan instalasi','Pemasangan kabel','Kosong','Pemasangan kabel pada lantai 3','Malang jln golf','vena','Arya',NULL,'Minggu ke 3','2026-07-17',NULL,NULL,NULL,'Cuaca cerah',NULL,NULL,NULL,NULL,'Disetujui','2026-07-17 00:19:26','2026-07-17 00:21:47'),(10,12,'pembangunan gedung ITN Malang','pembangunan','','pembangunan','bali','vena','reno, arya',NULL,'5','2026-07-17',NULL,NULL,NULL,'-',NULL,NULL,NULL,NULL,'Ditolak','2026-07-17 01:29:55','2026-07-17 04:34:56'),(11,13,'Pembangun hotel aston','Perancangan bangunan','analisis kebutuhan ruang','Plasteran dan acian','Jl golf 75 malang','Ariya','Venox',NULL,'2','2026-07-17',NULL,NULL,NULL,'-',NULL,NULL,NULL,NULL,'Ditolak','2026-07-17 01:31:04','2026-07-19 21:28:03'),(12,13,'Pembangunan hotel','Pemasangan lantai','Bdjshshb','Hshsusbam','Malang','Arhsba','Hsuahau',NULL,'2','2026-07-17',NULL,NULL,NULL,'a',NULL,NULL,NULL,NULL,'Ditolak','2026-07-17 01:55:12','2026-07-19 19:28:38'),(14,13,'Vena','a',NULL,'a','b',NULL,NULL,NULL,NULL,'2026-07-20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Menunggu','2026-07-19 19:30:55','2026-07-19 19:30:55'),(15,10,'Pembangunan Jalan Lingkar Barat Kota Malang','Pembangunan Infrastruktur Jalan','Rigid Pavement','Pembesian Section 2','Jl. Raya Tlogomas, Lowokwaru, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Konsultan Karya Nusantara','Ir. Andi Saputra, ST','6','2026-07-21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Menunggu','2026-07-30 19:04:47','2026-07-30 19:04:47'),(16,5,'Rehabilitasi Jembatan Sungai Brantas','Rehabilitasi Jembatan','Perkuatan Struktur Beton','Timbunan Section 6','Jl. Raya Gadang, Sukun, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','CV Bina Karya Konsultan','Ir. Budi Hartono','8','2026-06-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Menunggu','2026-07-30 19:04:47','2026-07-30 19:04:47'),(18,3,'Pembangunan Drainase Kawasan Soekarno Hatta','Pembangunan Drainase','Pemasangan U-Ditch','Pengecoran Section 7','Jl. Soekarno Hatta, Lowokwaru, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Mitra Konsultan Indonesia','Ir. Agus Prasetyo','1','2026-06-30',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Menunggu','2026-07-30 19:04:48','2026-07-30 19:04:48'),(19,5,'Pembangunan Gedung RSUD Kota Malang','Pembangunan Gedung','Pekerjaan Struktur','Timbunan Section 3','Jl. Rajasa, Kedungkandang, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Arsitek Nusantara','Ir. Dwi Cahyo','1','2026-06-20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Menunggu','2026-07-30 19:04:48','2026-07-30 19:04:48'),(20,14,'Pelebaran Jalan Raya Karanglo','Pelebaran Jalan','Pekerjaan Aspal','Bekisting Section 1','Jl. Raya Karanglo, Singosari, Kabupaten Malang, Jawa Timur','PT Reno Abirama Sakti','PT Karya Teknik Indonesia','Ir. Rudi Kurniawan','9','2026-06-20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Menunggu','2026-07-30 19:04:48','2026-07-30 19:04:48'),(21,3,'Pembangunan Jembatan Pakis','Pembangunan Jembatan','Pengecoran Pilar','Galian Section 8','Pakis, Kabupaten Malang, Jawa Timur','PT Reno Abirama Sakti','CV Pilar Konsultan','Ir. Bambang Setiawan','8','2026-07-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(22,12,'Pembangunan Jalan Tol Pandaan - Malang Seksi Pendukung','Pembangunan Jalan','Pekerjaan Bahu Jalan','Galian Section 3','Lawang, Kabupaten Malang, Jawa Timur','PT Reno Abirama Sakti','PT Infrastruktur Nusantara','Ir. Hendra Wijaya','10','2026-07-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(23,4,'Pembangunan Jalan Lingkar Barat Kota Malang','Pembangunan Infrastruktur Jalan','Rigid Pavement','Pemasangan Batu Section 1','Jl. Raya Tlogomas, Lowokwaru, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Konsultan Karya Nusantara','Ir. Andi Saputra, ST','12','2026-07-11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(24,2,'Rehabilitasi Jembatan Sungai Brantas','Rehabilitasi Jembatan','Perkuatan Struktur Beton','Pengecoran Section 3','Jl. Raya Gadang, Sukun, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','CV Bina Karya Konsultan','Ir. Budi Hartono','6','2026-06-21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(25,14,'Pembangunan Gedung Kantor Pemerintah Kota Malang','Pembangunan Gedung','Struktur Lantai 3','Timbunan Section 4','Jl. Tugu No.1, Klojen, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Cipta Karya Persada','Ir. Rina Kurniawati','3','2026-07-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(26,13,'Pembangunan Drainase Kawasan Soekarno Hatta','Pembangunan Drainase','Pemasangan U-Ditch','Timbunan Section 1','Jl. Soekarno Hatta, Lowokwaru, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Mitra Konsultan Indonesia','Ir. Agus Prasetyo','9','2026-06-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(27,9,'Pembangunan Gedung RSUD Kota Malang','Pembangunan Gedung','Pekerjaan Struktur','Pengecoran Section 6','Jl. Rajasa, Kedungkandang, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Arsitek Nusantara','Ir. Dwi Cahyo','11','2026-07-25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(28,4,'Pelebaran Jalan Raya Karanglo','Pelebaran Jalan','Pekerjaan Aspal','Galian Section 2','Jl. Raya Karanglo, Singosari, Kabupaten Malang, Jawa Timur','PT Reno Abirama Sakti','PT Karya Teknik Indonesia','Ir. Rudi Kurniawan','3','2026-07-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Disetujui','2026-07-30 19:04:48','2026-07-30 19:04:48'),(29,14,'Pembangunan Jembatan Pakis','Pembangunan Jembatan','Pengecoran Pilar','Pengaspalan Section 4','Pakis, Kabupaten Malang, Jawa Timur','PT Reno Abirama Sakti','CV Pilar Konsultan','Ir. Bambang Setiawan','11','2026-06-26',NULL,NULL,NULL,'Foto dokumentasi kurang jelas, mohon dikirim ulang.',NULL,NULL,NULL,NULL,'Ditolak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(30,13,'Pembangunan Jalan Tol Pandaan - Malang Seksi Pendukung','Pembangunan Jalan','Pekerjaan Bahu Jalan','Pembesian Section 1','Lawang, Kabupaten Malang, Jawa Timur','PT Reno Abirama Sakti','PT Infrastruktur Nusantara','Ir. Hendra Wijaya','1','2026-07-29',NULL,NULL,NULL,'Foto dokumentasi kurang jelas, mohon dikirim ulang.',NULL,NULL,NULL,NULL,'Ditolak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(31,13,'Pembangunan Jalan Lingkar Barat Kota Malang','Pembangunan Infrastruktur Jalan','Rigid Pavement','Pengecoran Section 3','Jl. Raya Tlogomas, Lowokwaru, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','PT Konsultan Karya Nusantara','Ir. Andi Saputra, ST','3','2026-07-14',NULL,NULL,NULL,'Foto dokumentasi kurang jelas, mohon dikirim ulang.',NULL,NULL,NULL,NULL,'Ditolak','2026-07-30 19:04:48','2026-07-30 19:04:48'),(32,5,'Rehabilitasi Jembatan Sungai Brantas','Rehabilitasi Jembatan','Perkuatan Struktur Beton','Galian Section 4','Jl. Raya Gadang, Sukun, Kota Malang, Jawa Timur','PT Reno Abirama Sakti','CV Bina Karya Konsultan','Ir. Budi Hartono','12','2026-07-12',NULL,NULL,NULL,'Foto dokumentasi kurang jelas, mohon dikirim ulang.',NULL,NULL,NULL,NULL,'Ditolak','2026-07-30 19:04:48','2026-07-30 19:04:48');
/*!40000 ALTER TABLE `laporans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_06_060235_create_karyawans_table',1),(5,'2026_07_06_060243_create_proyeks_table',1),(6,'2026_07_06_060258_create_laporans_table',1),(7,'2026_07_06_060306_create_laporan_pekerjaans_table',1),(8,'2026_07_06_060318_create_laporan_tenagas_table',1),(9,'2026_07_06_060424_create_laporan_alats_table',1),(10,'2026_07_06_060435_create_laporan_fotos_table',1),(11,'2026_07_06_060441_create_verifikasis_table',1),(12,'2026_07_08_014626_add_role_to_users_table',1),(13,'2026_07_08_014710_add_user_id_to_karyawans_table',1),(14,'2026_07_08_043938_create_laporan_materials_table',1),(15,'2026_07_08_064559_add_detail_fields_to_proyeks_table',1),(16,'2026_07_09_080822_move_project_fields_to_laporans',1),(17,'2026_07_09_090109_add_project_info_to_laporans_table',1),(18,'2026_07_13_000001_update_karyawans_verification_columns',2),(19,'2026_07_20_092700_add_progress_cuaca_to_laporans_table',3),(20,'2026_07_21_000000_add_daily_report_details_to_laporans_table',3),(21,'2026_07_31_031524_create_notifications_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyeks`
--

DROP TABLE IF EXISTS `proyeks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyeks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proyeks_kode_proyek_unique` (`kode_proyek`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyeks`
--

LOCK TABLES `proyeks` WRITE;
/*!40000 ALTER TABLE `proyeks` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyeks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('BqKaKja9mMp7nYRVjyFjHjEPWAofNrE8DakWIrNw',10,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJtemg0a1JwWG9oRUM4RzhYQjBDSnQ1bks4anNWSHgwdnlvb1hySlZIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9wZGZcL3dlZWtseVwvOVwvUGVsZWJhcmFuJTIwSmFsYW4lMjBSYXlhJTIwS2FyYW5nbG8iLCJyb3V0ZSI6InBkZi53ZWVrbHkifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MTB9',1786544667);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','karyawan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karyawan',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Budi Santoso','budi@monitoring.com',NULL,'$2y$12$XuimLY3pExT4Ai1QliUsAukmoRi2prOczq0hQ.WMBAdyb4ARPpSem','karyawan',NULL,'2026-07-12 10:09:37','2026-07-30 19:04:47'),(3,'Andi Wijaya','andi@monitoring.com',NULL,'$2y$12$M/zsO4OMPHsG13ny8WPP0eB7Ol4krmLl.iAz/5l8MfL9H/J8pxBe6','karyawan',NULL,'2026-07-12 10:09:37','2026-07-30 19:04:47'),(4,'Sri Wahyuni','sri@monitoring.com',NULL,'$2y$12$9csER3NqF.6Habzu93R7euDcxa4SUBic2/wcF2Ue7q9HHq2Qk8KzG','karyawan',NULL,'2026-07-12 10:09:37','2026-07-30 19:04:47'),(5,'Rudi Hartono','rudi@monitoring.com',NULL,'$2y$12$5y.Pkv5ZPeeROI5.hQuA7Og2nxGr4hfVwI9bN6jhMubHbhFVVX3.C','karyawan',NULL,'2026-07-12 10:09:37','2026-07-30 19:04:47'),(6,'reno','reno@gmail.com',NULL,'$2y$12$5ZTqwwKcs8iPbiZ0zdNOF.zfnZPky7Pp7MEa0mNOWRkO.oCnFkaAK','karyawan',NULL,'2026-07-12 23:27:54','2026-07-12 23:27:54'),(7,'arya','arya@gmail.com',NULL,'$2y$12$bRHHwu.EVg8E6aDKq6BmoODvXzyrFmXEhtf8iYjasN13uCsJj0XhO','karyawan',NULL,'2026-07-13 01:08:04','2026-07-13 01:08:04'),(9,'Vena','alen@gmail.com',NULL,'$2y$12$fGXJkmCfPhhAy3nI2/KA6.DJvesLX8FzJz5CMriOm6hthNvjuXv4O','karyawan','5YVQQIF3ahdyBY9SJcvM1oWHhQera9w6hGeqSsJtH5WMuEZCmYoukyVQr8YF','2026-07-16 02:20:12','2026-07-16 02:20:12'),(10,'Administrator','admin@monitoring.com',NULL,'$2y$12$jxZJ9HxBZxPo3ImgdKTFneV2vjZJk5XxTZz56UQNuzfrQGK5hYOhW','admin','cXeUJkMIgjtMeC3HaBBHPhl0gcKcA6rjBwtvHhWcyWLOUdrunx3TEc8HW3gP','2026-07-16 06:57:08','2026-07-30 19:04:46'),(11,'Akun Bot Dummy','bot_dummy@monitoring.com',NULL,'$2y$12$H6DaPyc2UuZkf.2DcLojWuU6310w7DqPzy4hgc9bIMX/kUmN11jIe','karyawan',NULL,'2026-07-16 07:09:23','2026-07-16 07:09:23'),(12,'Vena','vena@gmail.com',NULL,'$2y$12$KYvBDqXd.2o5kF8aN.edeOq0iQ6T0YiBXAg/QxFSwDTM.6h5nzbgq','karyawan',NULL,'2026-07-16 21:04:09','2026-07-16 21:04:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verifikasis`
--

DROP TABLE IF EXISTS `verifikasis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `verifikasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` enum('Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `verifikasis_laporan_id_unique` (`laporan_id`),
  KEY `verifikasis_user_id_foreign` (`user_id`),
  KEY `verifikasis_status_index` (`status`),
  CONSTRAINT `verifikasis_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `verifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verifikasis`
--

LOCK TABLES `verifikasis` WRITE;
/*!40000 ALTER TABLE `verifikasis` DISABLE KEYS */;
INSERT INTO `verifikasis` VALUES (6,9,10,'Disetujui','Laporan disetujui','2026-07-17 00:21:47','2026-07-17 00:21:47','2026-07-17 00:21:47'),(7,10,10,'Ditolak','-','2026-07-17 04:34:56','2026-07-17 04:34:56','2026-07-17 04:34:56'),(8,12,10,'Ditolak','a','2026-07-19 19:28:38','2026-07-19 19:28:38','2026-07-19 19:28:38'),(9,11,10,'Ditolak','-','2026-07-19 21:28:03','2026-07-19 21:28:03','2026-07-19 21:28:03'),(10,21,10,'Disetujui','Laporan sesuai standar.','2026-07-01 20:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(11,22,10,'Disetujui','Laporan sesuai standar.','2026-07-10 11:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(12,23,10,'Disetujui','Laporan sesuai standar.','2026-07-11 05:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(13,24,10,'Disetujui','Laporan sesuai standar.','2026-06-21 06:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(14,25,10,'Disetujui','Laporan sesuai standar.','2026-07-19 00:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(15,26,10,'Disetujui','Laporan sesuai standar.','2026-06-16 09:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(16,27,10,'Disetujui','Laporan sesuai standar.','2026-07-24 20:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(17,28,10,'Disetujui','Laporan sesuai standar.','2026-07-22 06:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(18,29,10,'Ditolak','Foto dokumentasi kurang jelas.','2026-06-25 21:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(19,30,10,'Ditolak','Foto dokumentasi kurang jelas.','2026-07-28 19:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(20,31,10,'Ditolak','Foto dokumentasi kurang jelas.','2026-07-14 05:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48'),(21,32,10,'Ditolak','Foto dokumentasi kurang jelas.','2026-07-12 02:00:00','2026-07-30 19:04:48','2026-07-30 19:04:48');
/*!40000 ALTER TABLE `verifikasis` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-12 22:25:04
