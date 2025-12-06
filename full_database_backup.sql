-- MySQL dump 10.13  Distrib 8.4.7, for Linux (x86_64)
--
-- Host: localhost    Database: u406345208_Sarmiento
-- ------------------------------------------------------
-- Server version	8.4.7

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
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `type` enum('low_stock','out_of_stock') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `resolved_at` timestamp NULL DEFAULT NULL,
  `seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alerts_product_id_index` (`product_id`),
  KEY `alerts_type_index` (`type`),
  KEY `alerts_status_index` (`status`),
  CONSTRAINT `alerts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
/*!40000 ALTER TABLE `alerts` ENABLE KEYS */;
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
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
  `inventory_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  KEY `categories_inventory_id_index` (`inventory_id`),
  KEY `categories_name_index` (`name`),
  KEY `categories_inventory_id_name_index` (`inventory_id`,`name`),
  CONSTRAINT `categories_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,1,'Living Room','Sofas, chairs, tables','2025-11-29 21:12:21','2025-11-29 21:12:21'),(2,1,'Bedroom','Beds, nightstands, dressers','2025-11-29 21:12:21','2025-11-29 21:12:21'),(3,1,'Dining','Dining tables and chairs','2025-11-29 21:12:21','2025-11-29 21:12:21'),(4,1,'Office','Desks and office furniture','2025-11-29 21:12:21','2025-11-29 21:12:21'),(5,2,'Groceries','Food and beverage items','2025-11-29 21:12:21','2025-11-29 21:12:21'),(6,2,'Snacks','Chips, cookies, candies','2025-11-29 21:12:21','2025-11-29 21:12:21'),(7,2,'Beverages','Drinks and juices','2025-11-29 21:12:21','2025-11-29 21:12:21'),(8,2,'Personal Care','Toiletries and hygiene','2025-11-29 21:12:21','2025-11-29 21:12:21'),(9,2,'Household','Cleaning and household items','2025-11-29 21:12:21','2025-11-29 21:12:21'),(10,3,'Smartphones','Mobile phones and accessories','2025-11-29 21:12:21','2025-11-29 21:12:21'),(11,3,'Laptops','Computers and tablets','2025-11-29 21:12:21','2025-11-29 21:12:21'),(12,3,'Accessories','Chargers, cables, adapters','2025-11-29 21:12:21','2025-11-29 21:12:21'),(13,3,'Audio','Headphones and speakers','2025-11-29 21:12:21','2025-11-29 21:12:21');
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
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventories_name_unique` (`name`),
  KEY `inventories_name_index` (`name`),
  KEY `inventories_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventories`
--

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
INSERT INTO `inventories` VALUES (1,'Zeus Furniture Store','Furniture retail and wholesale inventory','Downtown Branch','active','2025-11-29 21:12:21','2025-11-29 21:12:21'),(2,'Zeus Sari-Sari Store','General merchandise and convenience store','Residential Area','active','2025-11-29 21:12:21','2025-11-29 21:12:21'),(3,'Electronics Shop','Electronic devices and accessories','Tech Mall','active','2025-11-29 21:12:21','2025-11-29 21:12:21');
/*!40000 ALTER TABLE `inventories` ENABLE KEYS */;
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
  `attempts` tinyint unsigned NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_11_24_145000_create_inventories_table',1),(5,'2025_11_24_145001_create_user_inventories_table',1),(6,'2025_11_24_145024_create_categories_table',1),(7,'2025_11_24_145044_create_suppliers_table',1),(8,'2025_11_24_145045_create_products_table',1),(9,'2025_11_24_145050_add_inventory_id_to_categories_table',1),(10,'2025_11_24_145051_add_inventory_id_to_suppliers_table',1),(11,'2025_11_24_151050_add_inventory_id_to_products_table',1),(12,'2025_11_24_151051_make_category_supplier_nullable',1),(13,'2025_11_24_151142_create_stock_movements_table',1),(14,'2025_11_24_151206_create_alerts_table',1),(15,'2025_11_28_000001_add_resolved_at_to_alerts_table',1),(16,'2025_11_29_000000_modify_users_table_for_login',1),(17,'2025_11_29_000001_add_seen_at_to_alerts_table',1),(18,'2025_11_30_add_status_to_inventories_table',1),(19,'2025_11_30_create_indexes_for_performance',1),(20,'2025_11_30_make_product_category_supplier_nullable',1),(21,'2025_11_30_remove_supplier_email_unique_constraint',1);
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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `inventory_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `selling_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `reorder_level` int NOT NULL DEFAULT '0',
  `current_stock` int NOT NULL DEFAULT '0',
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_barcode_unique` (`barcode`),
  KEY `products_inventory_id_index` (`inventory_id`),
  KEY `products_category_id_index` (`category_id`),
  KEY `products_supplier_id_index` (`supplier_id`),
  KEY `products_sku_index` (`sku`),
  KEY `products_barcode_index` (`barcode`),
  KEY `products_name_index` (`name`),
  KEY `products_current_stock_index` (`current_stock`),
  KEY `products_reorder_level_index` (`reorder_level`),
  KEY `products_inventory_id_category_id_index` (`inventory_id`,`category_id`),
  KEY `products_inventory_id_supplier_id_index` (`inventory_id`,`supplier_id`),
  KEY `products_inventory_id_current_stock_index` (`inventory_id`,`current_stock`),
  KEY `products_inventory_id_reorder_level_index` (`inventory_id`,`reorder_level`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Leather Sofa','FUR-001','BC-FUR-001',1,1,1,'High quality leather sofa',300.00,500.00,5,15,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(2,'Wooden Dining Table','FUR-002','BC-FUR-002',3,1,1,'High quality wooden dining table',200.00,350.00,5,8,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(3,'Queen Size Bed','FUR-003','BC-FUR-003',2,2,1,'High quality queen size bed',400.00,700.00,5,12,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(4,'Office Chair','FUR-004','BC-FUR-004',4,2,1,'High quality office chair',150.00,250.00,5,20,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(5,'Coffee Table','FUR-005','BC-FUR-005',1,1,1,'High quality coffee table',100.00,180.00,5,25,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(6,'Nightstand','FUR-006','BC-FUR-006',2,2,1,'High quality nightstand',80.00,140.00,5,30,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(7,'Bookshelf','FUR-007','BC-FUR-007',4,1,1,'High quality bookshelf',120.00,220.00,5,18,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(8,'Accent Chair','FUR-008','BC-FUR-008',1,2,1,'High quality accent chair',180.00,320.00,5,22,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(9,'Rice (5kg)','GRO-001','BC-GRO-001',5,3,2,'Quality rice (5kg)',12.00,20.00,10,100,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(10,'Cooking Oil (1L)','GRO-002','BC-GRO-002',5,3,2,'Quality cooking oil (1l)',8.00,14.00,10,80,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(11,'Instant Noodles (Pack)','SNK-001','BC-SNK-001',6,4,2,'Quality instant noodles (pack)',0.50,1.50,10,500,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(12,'Biscuits (Pack)','SNK-002','BC-SNK-002',6,4,2,'Quality biscuits (pack)',2.00,4.00,10,200,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(13,'Coffee Mix (25 pcs)','BEV-001','BC-BEV-001',7,3,2,'Quality coffee mix (25 pcs)',3.00,6.00,10,150,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(14,'Juice Drink (1L)','BEV-002','BC-BEV-002',7,4,2,'Quality juice drink (1l)',2.50,5.00,10,120,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(15,'Soap Bar','PER-001','BC-PER-001',8,3,2,'Quality soap bar',1.00,2.00,10,300,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(16,'Toothpaste (120g)','PER-002','BC-PER-002',8,4,2,'Quality toothpaste (120g)',2.50,5.00,10,100,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(17,'Dishwashing Liquid (1L)','HOU-001','BC-HOU-001',9,3,2,'Quality dishwashing liquid (1l)',2.00,4.00,10,80,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(18,'Floor Cleaner (500ml)','HOU-002','BC-HOU-002',9,4,2,'Quality floor cleaner (500ml)',1.50,3.00,10,120,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(19,'Smartphone X Pro','PHO-001','BC-PHO-001',10,5,3,'Premium smartphone x pro',400.00,700.00,3,20,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(20,'Smartphone Y Plus','PHO-002','BC-PHO-002',10,6,3,'Premium smartphone y plus',300.00,550.00,3,25,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(21,'Laptop Pro 15','LAP-001','BC-LAP-001',11,5,3,'Premium laptop pro 15',800.00,1200.00,3,10,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(22,'Tablet Z','LAP-002','BC-LAP-002',11,6,3,'Premium tablet z',300.00,500.00,3,15,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(23,'USB-C Cable','ACC-001','BC-ACC-001',12,5,3,'Premium usb-c cable',3.00,8.00,3,200,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(24,'Charging Adapter','ACC-002','BC-ACC-002',12,6,3,'Premium charging adapter',5.00,12.00,3,150,NULL,'2025-11-29 21:12:22','2025-11-29 21:12:22'),(25,'Wireless Earbuds','AUD-001','BC-AUD-001',13,5,3,'Premium wireless earbuds',50.00,100.00,3,40,NULL,'2025-11-29 21:12:22','2025-11-29 21:12:22'),(26,'Bluetooth Speaker','AUD-002','BC-AUD-002',13,6,3,'Premium bluetooth speaker',30.00,70.00,3,30,NULL,'2025-11-29 21:12:22','2025-11-29 21:12:22'),(27,'Phone Screen Protector','ACC-003','BC-ACC-003',12,5,3,'Premium phone screen protector',2.00,5.00,3,300,NULL,'2025-11-29 21:12:22','2025-11-29 21:12:22'),(28,'Phone Case','ACC-004','BC-ACC-004',12,6,3,'Premium phone case',4.00,10.00,3,250,NULL,'2025-11-29 21:12:22','2025-11-29 21:12:22');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_movements`
--

DROP TABLE IF EXISTS `stock_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `type` enum('in','out','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `old_stock` int NOT NULL,
  `new_stock` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_product_id_index` (`product_id`),
  KEY `stock_movements_type_index` (`type`),
  KEY `stock_movements_created_at_index` (`created_at`),
  KEY `stock_movements_product_id_created_at_index` (`product_id`,`created_at`),
  CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_movements`
--

LOCK TABLES `stock_movements` WRITE;
/*!40000 ALTER TABLE `stock_movements` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `inventory_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_name_unique` (`name`),
  KEY `suppliers_inventory_id_index` (`inventory_id`),
  KEY `suppliers_name_index` (`name`),
  KEY `suppliers_email_index` (`email`),
  KEY `suppliers_inventory_id_name_index` (`inventory_id`,`name`),
  CONSTRAINT `suppliers_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,1,'Modern Furniture Co.','John Smith','contact@modernfurn.com','555-0101','123 Furniture St, NY','2025-11-29 21:12:21','2025-11-29 21:12:21'),(2,1,'Classic Designs Ltd.','Maria Garcia','sales@classicdesigns.com','555-0102','456 Design Ave, LA','2025-11-29 21:12:21','2025-11-29 21:12:21'),(3,2,'Metro Wholesale','Miguel Santos','bulk@metrosp.com','555-0201','789 Commercial Blvd, Manila','2025-11-29 21:12:21','2025-11-29 21:12:21'),(4,2,'Local Distributor Inc.','Rosa Cruz','sales@localdistr.com','555-0202','321 Trade St, Quezon City','2025-11-29 21:12:21','2025-11-29 21:12:21'),(5,3,'TechHub Distributors','Alex Chen','bulk@techhub.com','555-0301','100 Tech Park, Silicon Valley','2025-11-29 21:12:21','2025-11-29 21:12:21'),(6,3,'ElectroWorld Ltd.','Sarah Johnson','wholesale@electroworld.com','555-0302','200 Digital Ave, San Francisco','2025-11-29 21:12:21','2025-11-29 21:12:21');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_inventories`
--

DROP TABLE IF EXISTS `user_inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `inventory_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_inventories_user_id_inventory_id_unique` (`user_id`,`inventory_id`),
  KEY `user_inventories_user_id_index` (`user_id`),
  KEY `user_inventories_inventory_id_index` (`inventory_id`),
  KEY `user_inventories_user_id_inventory_id_index` (`user_id`,`inventory_id`),
  CONSTRAINT `user_inventories_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_inventories`
--

LOCK TABLES `user_inventories` WRITE;
/*!40000 ALTER TABLE `user_inventories` DISABLE KEYS */;
INSERT INTO `user_inventories` VALUES (1,1,1,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(2,1,2,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(3,2,1,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(4,2,2,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(5,3,1,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(6,3,2,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(7,3,3,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(8,4,3,'2025-11-29 21:12:21','2025-11-29 21:12:21');
/*!40000 ALTER TABLE `user_inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_userid_unique` (`userid`),
  KEY `users_userid_index` (`userid`),
  KEY `users_email_index` (`email`),
  KEY `users_is_admin_index` (`is_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'zeus','Zeus Instructor','zeus@inventory.local',NULL,'$2y$12$H6YIEnesgR3WddsUrGL0D.M/eLk2MPotMoOka.ipKoN2lCmUeKgem',0,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(2,'zeusadmin','Zeus Admin','zeusadmin@inventory.local',NULL,'$2y$12$COy6br7fIS.dGUPBuWhta.7YEgjThnxnqZRNsL5R/EjJNcGTa3STW',1,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(3,'superadmin','Super Administrator','superadmin@inventory.local',NULL,'$2y$12$JcM3QzLvWhobDaH0pfGlpeJw6c3zT0/fROU0cZHtIlFg2b25jcLpq',1,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21'),(4,'user','Regular User','user@inventory.local',NULL,'$2y$12$WvnPDSTW8f1O6sHNbwrNjOW4Ac6dxwG6kOW.a7pPuCjJQ7Uw/DnKO',0,NULL,'2025-11-29 21:12:21','2025-11-29 21:12:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-29 21:14:49
