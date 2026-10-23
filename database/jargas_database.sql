-- MySQL dump 10.13  Distrib 26.7.0, for Linux (x86_64)
--
-- Host: localhost    Database: jargas_database
-- ------------------------------------------------------
-- Server version	26.7.0

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'abe72870-98e5-11f1-8953-de97a099eea0:1-10877';

--
-- Table structure for table `boqs`
--

DROP TABLE IF EXISTS `boqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `boqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `detailed_area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isMultipleCustomer` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boqs_project_id_foreign` (`project_id`),
  CONSTRAINT `boqs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=358 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boqs`
--

LOCK TABLES `boqs` WRITE;
/*!40000 ALTER TABLE `boqs` DISABLE KEYS */;
INSERT INTO `boqs` VALUES (307,1,'-',1,'2026-10-01 12:25:27','2026-10-01 16:21:48'),(309,104,'-',0,'2026-10-01 16:47:18','2026-10-01 16:47:18');
/*!40000 ALTER TABLE `boqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_section_id_sort_order_index` (`section_id`,`sort_order`),
  CONSTRAINT `categories_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,52,'MATERIAL PIPA PE 63 mm & Aksesoris',1,'2026-09-12 09:39:46','2026-09-12 09:39:46'),(2,52,'KONSTRUKSI',2,'2026-09-12 17:57:59','2026-09-12 17:57:59'),(53,104,'Material Pipa Carbon Steel',1,'2026-10-02 09:40:06','2026-10-02 09:40:06'),(54,105,'Material Pipa 180mm dan Aksesoris',1,'2026-10-02 09:42:04','2026-10-02 09:42:04'),(55,105,'Konstruksi',2,'2026-10-02 09:43:44','2026-10-02 09:43:44'),(56,107,'Material',1,'2026-10-02 09:51:19','2026-10-02 09:51:19'),(57,108,'Material Sambungan Kompor',1,'2026-10-02 09:53:57','2026-10-02 09:53:57'),(58,110,'Pengangkutan dan Pemasangan MRS & RS',0,'2026-10-02 10:08:20','2026-10-02 10:08:20'),(59,111,'Commissioning',0,'2026-10-02 10:09:21','2026-10-02 10:09:21'),(60,113,'PERSIAPAN',1,'2026-10-02 10:15:02','2026-10-02 10:15:02'),(103,154,'PEKERJAAN PERSIAPAN',1,'2026-10-02 10:20:57','2026-10-02 10:20:57');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `item_details`
--

DROP TABLE IF EXISTS `item_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `sub_category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_details_section_id_sort_order_index` (`section_id`,`sort_order`),
  KEY `item_details_category_id_sort_order_index` (`category_id`,`sort_order`),
  KEY `item_details_sub_category_id_sort_order_index` (`sub_category_id`,`sort_order`),
  CONSTRAINT `item_details_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `item_details_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `item_details_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_details`
--

LOCK TABLES `item_details` WRITE;
/*!40000 ALTER TABLE `item_details` DISABLE KEYS */;
INSERT INTO `item_details` VALUES (1,4,NULL,NULL,'Penyediaan Papan Nama Proyek','Unit',1,'2026-09-11 05:38:47','2026-10-02 16:01:08'),(52,52,1,1,'Pipa PE ├ÿ63 mm , MDPE 80/HDPE 100, YELLOW, ISO 4437 SDR 11/SDR 13.6','Meter',1,'2026-09-12 09:39:46','2026-09-12 09:39:46'),(53,52,1,2,'Elbow 90, ├ÿ 63 mm PE 80/PE 100 SDR 11 Electrofusion fitting ISO 4437-3 or EN 1555-3 or EN 12201-3','Buah',1,'2026-09-12 09:40:24','2026-09-12 09:40:24'),(54,52,1,2,'Coupler Electrofusion ├ÿ63 mm, PE 80/PE 100 SDR 11 ISO 4437','Buah',2,'2026-09-12 17:41:35','2026-09-12 17:41:35'),(55,52,1,2,'Tee Equal Electrofusion, PE 80/PE 100 SDR 11 ISO 4437, ├ÿ63 mm x ├ÿ63 mm x ├ÿ63 mm','Buah',3,'2026-09-12 17:45:56','2026-09-12 17:45:56'),(56,4,NULL,NULL,'Sewa Direksi Kit (Include Biaya Consumable)','Bulan',2,'2026-09-12 17:49:43','2026-09-12 17:49:43'),(57,4,NULL,NULL,'Penyediaan Banner','Unit',3,'2026-09-12 17:50:07','2026-09-12 17:50:07'),(58,4,NULL,NULL,'Penyediaan Tanda Pengaman & Rambu-rambu','Unit',4,'2026-09-12 17:50:28','2026-09-12 17:50:28'),(59,4,NULL,NULL,'Sewa Gudang Material','Unit',6,'2026-09-12 17:51:18','2026-09-12 17:51:18'),(60,4,NULL,NULL,'Mobilisasi dan Demobilisasi','Bulan',7,'2026-09-12 17:51:46','2026-09-12 17:51:46'),(61,4,NULL,NULL,'Perizinan','Ls',11,'2026-09-12 17:55:11','2026-09-12 17:55:11'),(62,4,NULL,NULL,'Pengambilan dan Pengembalian Free Issue Material (FIM)','Ls',12,'2026-09-12 17:55:31','2026-09-12 17:55:31'),(64,52,1,2,'End Cap Electrofusion Pipa ├ÿ63 mm, PE 80/PE 100 SDR 11 ISO 4437','Buah',4,'2026-09-12 17:57:20','2026-09-12 17:57:20'),(65,52,2,NULL,'Pekerjaan Penggelaran Pipa PE dia. 63 mm','Meter',1,'2026-09-12 17:57:59','2026-09-12 17:57:59'),(66,52,2,NULL,'Pekerjaan Penyambungan Fitting & Valve PE dia. 63 mm (Electro Fusion)','Titik',2,'2026-09-12 18:00:54','2026-09-12 18:00:54'),(67,52,2,NULL,'Pekerjaan Penyambungan Pipa PE dia. 63 mm Butt Fusion','Joint',3,'2026-09-12 18:01:49','2026-09-12 18:01:49'),(68,52,2,NULL,'Pekerjaan Manual Boring Pipa PE dia. 63 mm (termasuk enty & exit pit, dan reinstatement)','Meter',4,'2026-09-12 18:02:29','2026-09-12 18:02:29'),(69,52,2,NULL,'Pekerjaan Perlintasan Jalan PE dia. 63mm (Manual Boring, termasuk pemasangan casing, aksesoris dan reinstatement)','Meter',5,'2026-09-12 18:02:47','2026-09-12 18:02:47'),(70,52,2,NULL,'Papan Nama Jalur Gas (@500m) Pipa Distribusi Tekanan Rendah (DTR)','Buah',6,'2026-09-12 18:03:42','2026-09-12 18:03:42'),(71,52,2,NULL,'Patok Gas Type B (@100m) Pipa Distribusi Tekanan Rendah (DTR)','Buah',7,'2026-09-12 18:04:13','2026-09-12 18:04:13'),(155,4,NULL,NULL,'Pembuatan Gambar Rencana','Meter',8,'2026-10-02 09:36:42','2026-10-02 09:36:42'),(156,4,NULL,NULL,'Biaya Retribusi atau Sewa Lahan (At Cost)','Ls',9,'2026-10-02 09:37:34','2026-10-02 09:37:34'),(157,4,NULL,NULL,'Modifikasi RS Eksisting','Ls',10,'2026-10-02 09:37:57','2026-10-02 09:37:57'),(158,104,53,52,'Line Pipa 4\", API 5L ...','Meter',1,'2026-10-02 09:40:06','2026-10-02 09:40:06'),(159,105,54,53,'Pipa PE 180mm','Meter',1,'2026-10-02 09:42:04','2026-10-02 09:42:04'),(160,105,55,54,'Pekerjaan Penggelaran Pipa PE dia 180mm','Meter',2,'2026-10-02 09:43:44','2026-10-02 09:43:44'),(161,106,NULL,NULL,'Pekerjaan Testpit termasuk reinstatment','Buah',1,'2026-10-02 09:46:35','2026-10-02 09:46:35'),(162,107,56,NULL,'Regulator RT (Inlet Max....','Unit',1,'2026-10-02 09:51:19','2026-10-02 09:51:19'),(163,108,57,55,'Elbow 3/4 - 1/2 Male Female, Pipa 1/2 hotdip, Elbow 1/2...','Ls',1,'2026-10-02 09:53:57','2026-10-02 09:53:57'),(164,4,NULL,NULL,'Penyediaan Dinding Penahan Galian','m┬▓',5,'2026-10-02 09:56:34','2026-10-02 16:05:11'),(165,109,NULL,NULL,'Metering & Regulating Station (MRS) - P2-A2 G160 300# (Spesifikasi sesuai P&ID dan Datasheet MRS)','Unit',1,'2026-10-02 10:03:33','2026-10-02 10:03:33'),(166,110,58,NULL,'Pondasi, ....','Ls',1,'2026-10-02 10:08:20','2026-10-02 10:08:20'),(167,111,59,NULL,'Pipa Carbon Steel ΓîÇ4\"','Meter',1,'2026-10-02 10:09:21','2026-10-02 10:09:21'),(168,112,NULL,NULL,'Asbuilt Drawing Sambungan Rumah','Lembar',1,'2026-10-02 10:10:13','2026-10-02 10:10:13'),(169,113,60,56,'SPK JABEBOG BEKASI 1 PK','Ls',1,'2026-10-02 10:15:02','2026-10-02 10:15:02'),(170,113,60,57,'SPK JABOBEG 1 PK','Ls',1,'2026-10-02 10:16:39','2026-10-02 10:16:39'),(205,154,103,NULL,'Pekerjaan Survey Lokasi dan Pembuatan Gambar','Lokasi',1,'2026-10-02 10:20:57','2026-10-02 10:20:57');
/*!40000 ALTER TABLE `item_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_16_115735_create_projects_table',1),(5,'2026_08_17_141016_add_status_to_projects_table',1),(6,'2026_08_18_012449_add_column_budget_to_projects',1),(7,'2026_08_18_024857_alter_budget_column_in_projects_table',1),(8,'2026_08_18_030953_add_column_in_projects_table',1),(9,'2026_08_20_160012_add_column_in_projects_table',1),(10,'2026_08_28_150838_create_boqs_table',1),(11,'2026_08_28_200609_create_column_multiple_area_in_projects',1),(12,'2026_08_29_102633_create_plans_table',1),(13,'2026_08_30_162407_add_customs_fields_to_users_table',1),(14,'2026_08_30_163552_drop_project_control_plan_table',1),(15,'2026_08_31_040654_add_column_is_multiple_costumer_in_boqs_table',1),(16,'2026_09_02_131014_add_column_costumer_category_in_table_plans',1),(17,'2026_09_03_130245_create_plan_details_table',1),(103,'2026_09_09_170052_create_sections_table',2),(104,'2026_09_09_170104_create_categories_table',2),(105,'2026_09_09_170118_create_sub_categories_table',2),(106,'2026_09_09_170127_create_item_details_table',2),(154,'2026_09_12_183620_create_price_lists_table',3),(207,'2026_09_12_183912_create_unit_prices_table',4),(208,'2026_09_12_184835_create_record_prices_table',4),(256,'2026_09_20_164136_update_unit_price_foreign_key_on_record_prices_table',5),(257,'2026_09_20_164614_add_column_price_list_id_on_projects_table',6),(258,'2026_09_20_172823_add_column_client_on_price_lists_table',7),(259,'2026_09_20_180819_drop_column_client_on_projects_table',8),(307,'2026_09_22_031457_add_column_date_on_record_prices_table',9),(410,'2026_09_30_150355_recreate_plans_table',10),(460,'2026_10_02_082245_alter_column_price_on_record_prices_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `plan_details`
--

DROP TABLE IF EXISTS `plan_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` bigint unsigned NOT NULL,
  `plan_date` date NOT NULL,
  `plan_volume` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plan_details_plan_id_foreign` (`plan_id`),
  CONSTRAINT `plan_details_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_details`
--

LOCK TABLES `plan_details` WRITE;
/*!40000 ALTER TABLE `plan_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `boq_id` bigint unsigned NOT NULL,
  `unit_price_id` bigint unsigned NOT NULL,
  `volume` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plans_boq_id_foreign` (`boq_id`),
  KEY `plans_unit_price_id_foreign` (`unit_price_id`),
  CONSTRAINT `plans_boq_id_foreign` FOREIGN KEY (`boq_id`) REFERENCES `boqs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `plans_unit_price_id_foreign` FOREIGN KEY (`unit_price_id`) REFERENCES `unit_prices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,307,7,NULL,'2026-10-04 17:18:00','2026-10-04 17:18:00'),(2,307,205,NULL,'2026-10-04 17:18:31','2026-10-04 17:18:31'),(4,307,209,NULL,'2026-10-04 17:18:46','2026-10-04 17:18:46'),(5,307,210,NULL,'2026-10-04 17:21:22','2026-10-04 17:21:22'),(6,307,211,NULL,'2026-10-04 17:21:37','2026-10-04 17:21:37'),(7,307,208,NULL,'2026-10-04 18:21:02','2026-10-04 18:21:02'),(52,307,212,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(53,307,307,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(54,307,103,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(55,307,206,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(56,307,207,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(57,307,214,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(58,307,155,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(59,307,215,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(60,307,216,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(61,307,217,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(62,307,218,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(63,307,219,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(64,307,220,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(65,307,221,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14'),(66,307,358,NULL,'2026-10-05 15:21:14','2026-10-05 15:21:14');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price_lists`
--

DROP TABLE IF EXISTS `price_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price_lists`
--

LOCK TABLES `price_lists` WRITE;
/*!40000 ALTER TABLE `price_lists` DISABLE KEYS */;
INSERT INTO `price_lists` VALUES (1,'Pekerjaan Pembangunan Jaringan Gas Rumah Tangga Gaskita 2025 - 2027','611-277-13-225','PERUSAHAAN GAS NEGARA','2026-09-12 19:51:35','2026-09-30 14:52:45'),(4,'Pekerjaan Pembangunan Jaringan Gas Rumah Tangga (APBN)','311-215-12-226','ESDM (MIGAS)','2026-09-12 20:58:40','2026-09-20 17:42:39');
/*!40000 ALTER TABLE `price_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `price_list_id` bigint unsigned DEFAULT NULL,
  `project_name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` decimal(15,2) DEFAULT NULL,
  `area` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `isMultipleArea` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on progress',
  PRIMARY KEY (`id`),
  KEY `projects_price_list_id_foreign` (`price_list_id`),
  CONSTRAINT `projects_price_list_id_foreign` FOREIGN KEY (`price_list_id`) REFERENCES `price_lists` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,1,'Pekerjaan Jargas Gaskita di Wilayah Tangerang Selatan Tahap 2','-','000100.S/PR.01/INT/20256','Konstruksi',13281184795.00,'Tangerang Selatan','2026-10-01','2026-12-31',0,'2026-09-04 06:05:59','2026-09-20 18:07:29','on progress'),(104,4,'Pekerjaan Pembangunan Jargas Cirebon','123-132-233','00100.S/PR.01/2026','Konstruksi',3200000.00,'Cirebon','2026-07-01','2026-09-30',0,'2026-10-01 16:46:53','2026-10-01 16:48:47','on progress');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `record_prices`
--

DROP TABLE IF EXISTS `record_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `record_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `unit_price_id` bigint unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `price` decimal(16,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_prices_unit_price_id_foreign` (`unit_price_id`),
  CONSTRAINT `record_prices_unit_price_id_foreign` FOREIGN KEY (`unit_price_id`) REFERENCES `unit_prices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `record_prices`
--

LOCK TABLES `record_prices` WRITE;
/*!40000 ALTER TABLE `record_prices` DISABLE KEYS */;
INSERT INTO `record_prices` VALUES (105,205,'2026-10-01',18000000.00,'Initial Records','2026-10-02 16:52:52','2026-10-02 16:52:52'),(106,7,'2026-10-05',3200000.00,'Initial Price','2026-10-02 16:58:34','2026-10-02 16:58:34'),(107,7,'2026-10-01',1300000.00,'Unuploaded Harsat','2026-10-02 16:59:03','2026-10-02 16:59:03'),(108,7,'2026-10-13',320000.00,NULL,'2026-10-02 16:59:48','2026-10-02 16:59:48'),(109,307,'2026-10-01',320000.00,'Initial','2026-10-02 19:00:04','2026-10-02 19:00:04');
/*!40000 ALTER TABLE `record_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_sort_order_index` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (4,'PEKERJAAN PERSIAPAN',1,'2026-09-11 05:38:47','2026-09-11 05:38:47'),(52,'JARINGAN PIPA DISTRIBUSI',4,'2026-09-12 09:39:46','2026-09-12 09:39:46'),(104,'PIPA DISTRIBUSI TEKANAN TINGGI',2,'2026-10-02 09:40:06','2026-10-02 09:40:06'),(105,'JARINGAN PIPA INDUK',3,'2026-10-02 09:42:04','2026-10-02 09:42:04'),(106,'PEKERJAAN TESPIT JARINGAN DISTRIBUSI',5,'2026-10-02 09:46:35','2026-10-02 09:46:35'),(107,'SAMBUNGAN RUMAH (SR)',6,'2026-10-02 09:51:19','2026-10-02 09:51:19'),(108,'SAMBUNGAN KOMPOR (SK)',7,'2026-10-02 09:53:57','2026-10-02 09:53:57'),(109,'PERALATAN UTAMA',8,'2026-10-02 10:03:33','2026-10-02 10:03:33'),(110,'PEKERJAAN SIPIL MRS',9,'2026-10-02 10:08:20','2026-10-02 10:08:20'),(111,'PEKERJAAN PENGUJIAN',10,'2026-10-02 10:09:21','2026-10-02 10:09:21'),(112,'PEKERJAAN PASCA KONSTRUKSI',11,'2026-10-02 10:10:13','2026-10-02 10:10:13'),(113,'PELANGGAN KECIL',12,'2026-10-02 10:15:02','2026-10-02 10:15:02'),(154,'PELANGGAN KOMERSIAL INDUSTRI',13,'2026-10-02 10:20:57','2026-10-02 10:20:57');
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `sessions` VALUES ('iyfJaYbSxXWBkVY7umJSQ9mnzEiSDBVPvOdLDM15',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI2bEdlSFRvSk1udTIydk50enZtbXNMY0FIMURYN0NqTVVSR2haeFFIIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2VuZ2luZWVyaW5nXC9wcmljZS1saXN0XC8xXC91bml0LXByaWNlIiwicm91dGUiOiJ1bml0LXByaWNlLmluZGV4In19',1791274603),('sgBNhWFIsr1erybQL6gBpGUIVI7q4euB5ttmnMqn',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ0Ym5ac2V0UG1XdjYxdnZSVDRUcElZRk1XZUVMVVBleEhpT243ZzFkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1791213626),('Vp5LHUnbXnFxo05SQkhvVBQZtOmdxnPNZgA7rzYa',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJBaXZENHhZbUdnTW9WamJJWkx1eWJvcUlza3RSVjJiTDFGREZrMmpoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1791295624),('xPHp2iUdJOcoy84ooLwCCzsfwlGLtfegkMhmHpB9',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','eyJfdG9rZW4iOiIyeThwcWRhVElHQm9GVUZmYm95VlpyNWV6V3B4VWxlYVJzTUNNQ1VpIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9lbmdpbmVlcmluZ1wvcHJpY2UtbGlzdFwvMVwvdW5pdC1wcmljZSIsInJvdXRlIjoidW5pdC1wcmljZS5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1791221510);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_categories_category_id_sort_order_index` (`category_id`,`sort_order`),
  CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` VALUES (1,1,'Pipa',1,'2026-09-12 09:39:46','2026-09-12 09:39:46'),(2,1,'Fitting',2,'2026-09-12 09:40:24','2026-09-12 09:40:24'),(52,53,'Pipa',1,'2026-10-02 09:40:06','2026-10-02 09:40:06'),(53,54,'Pipa',1,'2026-10-02 09:42:04','2026-10-02 09:42:04'),(54,55,'Konstruksi pipa 180',1,'2026-10-02 09:43:44','2026-10-02 09:43:44'),(55,57,'Material',1,'2026-10-02 09:53:57','2026-10-02 09:53:57'),(56,60,'Perizinan',1,'2026-10-02 10:15:02','2026-10-02 10:15:02'),(57,60,'Pekerjaan Survey dan Pembuatan Gambar Rencana',2,'2026-10-02 10:16:39','2026-10-02 10:16:39');
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_prices`
--

DROP TABLE IF EXISTS `unit_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unit_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `price_list_id` bigint unsigned NOT NULL,
  `item_detail_id` bigint unsigned NOT NULL,
  `isFreeIssueMaterial` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unit_prices_price_list_id_item_detail_id_unique` (`price_list_id`,`item_detail_id`),
  KEY `unit_prices_item_detail_id_foreign` (`item_detail_id`),
  CONSTRAINT `unit_prices_item_detail_id_foreign` FOREIGN KEY (`item_detail_id`) REFERENCES `item_details` (`id`),
  CONSTRAINT `unit_prices_price_list_id_foreign` FOREIGN KEY (`price_list_id`) REFERENCES `price_lists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=460 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_prices`
--

LOCK TABLES `unit_prices` WRITE;
/*!40000 ALTER TABLE `unit_prices` DISABLE KEYS */;
INSERT INTO `unit_prices` VALUES (7,1,1,0,'2026-09-13 17:01:55','2026-09-13 17:01:55'),(103,1,54,0,'2026-09-19 10:07:48','2026-09-19 10:07:48'),(155,1,52,0,'2026-09-20 15:48:03','2026-09-20 15:48:03'),(156,4,56,0,'2026-09-20 15:55:45','2026-09-20 15:55:45'),(205,1,61,0,'2026-09-25 02:20:39','2026-09-25 02:20:39'),(206,1,53,0,'2026-09-25 02:20:39','2026-09-25 02:20:39'),(207,1,55,0,'2026-09-25 02:20:39','2026-09-25 02:20:39'),(208,1,57,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(209,1,58,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(210,1,59,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(211,1,60,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(212,1,62,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(214,1,64,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(215,1,65,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(216,1,66,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(217,1,67,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(218,1,68,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(219,1,69,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(220,1,70,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(221,1,71,0,'2026-09-25 02:26:35','2026-09-25 02:26:35'),(256,4,1,0,'2026-10-01 15:35:42','2026-10-01 15:35:42'),(307,1,56,0,'2026-10-02 08:17:10','2026-10-02 08:17:10'),(358,1,169,0,'2026-10-02 10:19:09','2026-10-02 10:19:09');
/*!40000 ALTER TABLE `unit_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division` enum('Site','PSCM') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PSCM',
  `position` enum('Project Control','Administration and Contract','Finance','HSSE','QAQC','Engineering','General Affair','Procurement','Logistic') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 16:13:21
