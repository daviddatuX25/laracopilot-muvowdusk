-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Dec 07, 2025 at 04:33 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u406345208_Sarmiento`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `type` enum('low_stock','out_of_stock') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `resolved_at` timestamp NULL DEFAULT NULL,
  `seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `inventory_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Living Room', 'Sofas, chairs, tables', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(2, 1, 'Bedroom', 'Beds, nightstands, dressers', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(3, 1, 'Dining', 'Dining tables and chairs', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(4, 1, 'Office', 'Desks and office furniture', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(5, 2, 'Groceries', 'Food and beverage items', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(6, 2, 'Snacks', 'Chips, cookies, candies', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(7, 2, 'Beverages', 'Drinks and juices', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(8, 2, 'Personal Care', 'Toiletries and hygiene', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(9, 2, 'Household', 'Cleaning and household items', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(10, 3, 'Smartphones', 'Mobile phones and accessories', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(11, 3, 'Laptops', 'Computers and tablets', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(12, 3, 'Accessories', 'Chargers, cables, adapters', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(13, 3, 'Audio', 'Headphones and speakers', '2025-12-07 16:33:10', '2025-12-07 16:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `name`, `description`, `location`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Zeus Furniture Store', 'Furniture retail and wholesale inventory', 'Downtown Branch', 'active', '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(2, 'Zeus Sari-Sari Store', 'General merchandise and convenience store', 'Residential Area', 'active', '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(3, 'Electronics Shop', 'Electronic devices and accessories', 'Tech Mall', 'active', '2025-12-07 16:33:09', '2025-12-07 16:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
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
(4, '2025_11_24_145000_create_inventories_table', 1),
(5, '2025_11_24_145001_create_user_inventories_table', 1),
(6, '2025_11_24_145024_create_categories_table', 1),
(7, '2025_11_24_145044_create_suppliers_table', 1),
(8, '2025_11_24_145045_create_products_table', 1),
(9, '2025_11_24_145050_add_inventory_id_to_categories_table', 1),
(10, '2025_11_24_145051_add_inventory_id_to_suppliers_table', 1),
(11, '2025_11_24_151050_add_inventory_id_to_products_table', 1),
(12, '2025_11_24_151051_make_category_supplier_nullable', 1),
(13, '2025_11_24_151142_create_stock_movements_table', 1),
(14, '2025_11_24_151206_create_alerts_table', 1),
(15, '2025_11_28_000001_add_resolved_at_to_alerts_table', 1),
(16, '2025_11_29_000000_modify_users_table_for_login', 1),
(17, '2025_11_29_000001_add_seen_at_to_alerts_table', 1),
(18, '2025_11_30_001_create_restocks_table', 1),
(19, '2025_11_30_002_create_restock_items_table', 1),
(20, '2025_11_30_003_create_restock_costs_table', 1),
(21, '2025_11_30_004_add_restock_id_to_stock_movements', 1),
(22, '2025_11_30_add_status_to_inventories_table', 1),
(23, '2025_11_30_create_indexes_for_performance', 1),
(24, '2025_11_30_make_product_category_supplier_nullable', 1),
(25, '2025_11_30_remove_supplier_email_unique_constraint', 1),
(26, '2025_12_06_make_sku_nullable', 1);

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `inventory_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `selling_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `reorder_level` int NOT NULL DEFAULT '0',
  `current_stock` int NOT NULL DEFAULT '0',
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `barcode`, `category_id`, `supplier_id`, `inventory_id`, `description`, `cost_price`, `selling_price`, `reorder_level`, `current_stock`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'Leather Sofa', 'FUR-001', 'BC-FUR-001', 1, 1, 1, 'High quality leather sofa', 300.00, 500.00, 5, 15, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(2, 'Wooden Dining Table', 'FUR-002', 'BC-FUR-002', 3, 1, 1, 'High quality wooden dining table', 200.00, 350.00, 5, 8, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(3, 'Queen Size Bed', 'FUR-003', 'BC-FUR-003', 2, 2, 1, 'High quality queen size bed', 400.00, 700.00, 5, 12, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(4, 'Office Chair', 'FUR-004', 'BC-FUR-004', 4, 2, 1, 'High quality office chair', 150.00, 250.00, 5, 20, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(5, 'Coffee Table', 'FUR-005', 'BC-FUR-005', 1, 1, 1, 'High quality coffee table', 100.00, 180.00, 5, 25, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(6, 'Nightstand', 'FUR-006', 'BC-FUR-006', 2, 2, 1, 'High quality nightstand', 80.00, 140.00, 5, 30, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(7, 'Bookshelf', 'FUR-007', 'BC-FUR-007', 4, 1, 1, 'High quality bookshelf', 120.00, 220.00, 5, 18, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(8, 'Accent Chair', 'FUR-008', 'BC-FUR-008', 1, 2, 1, 'High quality accent chair', 180.00, 320.00, 5, 22, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(9, 'Rice (5kg)', 'GRO-001', 'BC-GRO-001', 5, 3, 2, 'Quality rice (5kg)', 12.00, 20.00, 10, 100, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(10, 'Cooking Oil (1L)', 'GRO-002', 'BC-GRO-002', 5, 3, 2, 'Quality cooking oil (1l)', 8.00, 14.00, 10, 80, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(11, 'Instant Noodles (Pack)', 'SNK-001', 'BC-SNK-001', 6, 4, 2, 'Quality instant noodles (pack)', 0.50, 1.50, 10, 500, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(12, 'Biscuits (Pack)', 'SNK-002', 'BC-SNK-002', 6, 4, 2, 'Quality biscuits (pack)', 2.00, 4.00, 10, 200, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(13, 'Coffee Mix (25 pcs)', 'BEV-001', 'BC-BEV-001', 7, 3, 2, 'Quality coffee mix (25 pcs)', 3.00, 6.00, 10, 150, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(14, 'Juice Drink (1L)', 'BEV-002', 'BC-BEV-002', 7, 4, 2, 'Quality juice drink (1l)', 2.50, 5.00, 10, 120, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(15, 'Soap Bar', 'PER-001', 'BC-PER-001', 8, 3, 2, 'Quality soap bar', 1.00, 2.00, 10, 300, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(16, 'Toothpaste (120g)', 'PER-002', 'BC-PER-002', 8, 4, 2, 'Quality toothpaste (120g)', 2.50, 5.00, 10, 100, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(17, 'Dishwashing Liquid (1L)', 'HOU-001', 'BC-HOU-001', 9, 3, 2, 'Quality dishwashing liquid (1l)', 2.00, 4.00, 10, 80, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(18, 'Floor Cleaner (500ml)', 'HOU-002', 'BC-HOU-002', 9, 4, 2, 'Quality floor cleaner (500ml)', 1.50, 3.00, 10, 120, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(19, 'Smartphone X Pro', 'PHO-001', 'BC-PHO-001', 10, 5, 3, 'Premium smartphone x pro', 400.00, 700.00, 3, 20, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(20, 'Smartphone Y Plus', 'PHO-002', 'BC-PHO-002', 10, 6, 3, 'Premium smartphone y plus', 300.00, 550.00, 3, 25, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(21, 'Laptop Pro 15', 'LAP-001', 'BC-LAP-001', 11, 5, 3, 'Premium laptop pro 15', 800.00, 1200.00, 3, 10, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(22, 'Tablet Z', 'LAP-002', 'BC-LAP-002', 11, 6, 3, 'Premium tablet z', 300.00, 500.00, 3, 15, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(23, 'USB-C Cable', 'ACC-001', 'BC-ACC-001', 12, 5, 3, 'Premium usb-c cable', 3.00, 8.00, 3, 200, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(24, 'Charging Adapter', 'ACC-002', 'BC-ACC-002', 12, 6, 3, 'Premium charging adapter', 5.00, 12.00, 3, 150, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(25, 'Wireless Earbuds', 'AUD-001', 'BC-AUD-001', 13, 5, 3, 'Premium wireless earbuds', 50.00, 100.00, 3, 40, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(26, 'Bluetooth Speaker', 'AUD-002', 'BC-AUD-002', 13, 6, 3, 'Premium bluetooth speaker', 30.00, 70.00, 3, 30, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(27, 'Phone Screen Protector', 'ACC-003', 'BC-ACC-003', 12, 5, 3, 'Premium phone screen protector', 2.00, 5.00, 3, 300, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(28, 'Phone Case', 'ACC-004', 'BC-ACC-004', 12, 6, 3, 'Premium phone case', 4.00, 10.00, 3, 250, NULL, '2025-12-07 16:33:10', '2025-12-07 16:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `restocks`
--

CREATE TABLE `restocks` (
  `id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('draft','pending','fulfilled','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `budget_amount` decimal(15,2) NOT NULL,
  `cart_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `shipping_fee` decimal(15,2) NOT NULL DEFAULT '0.00',
  `labor_fee` decimal(15,2) NOT NULL DEFAULT '0.00',
  `other_fees` json DEFAULT NULL COMMENT 'Array of {label, amount}',
  `total_cost` decimal(15,2) NOT NULL,
  `budget_status` enum('under','fit','over') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fit',
  `budget_difference` decimal(15,2) DEFAULT NULL COMMENT 'Positive if under, negative if over',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `fulfilled_at` timestamp NULL DEFAULT NULL,
  `fulfilled_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restock_costs`
--

CREATE TABLE `restock_costs` (
  `id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `cost_type` enum('tax','shipping','labor','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'e.g., VAT, Gas, Handling',
  `amount` decimal(15,2) NOT NULL,
  `is_percentage` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'For tax: 15% vs 200 pesos',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restock_items`
--

CREATE TABLE `restock_items` (
  `id` bigint UNSIGNED NOT NULL,
  `restock_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity_requested` int NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL COMMENT 'quantity * unit_cost',
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
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `type` enum('in','out','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `old_stock` int NOT NULL,
  `new_stock` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `restock_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `inventory_id`, `name`, `contact_person`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Modern Furniture Co.', 'John Smith', 'contact@modernfurn.com', '555-0101', '123 Furniture St, NY', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(2, 1, 'Classic Designs Ltd.', 'Maria Garcia', 'sales@classicdesigns.com', '555-0102', '456 Design Ave, LA', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(3, 2, 'Metro Wholesale', 'Miguel Santos', 'bulk@metrosp.com', '555-0201', '789 Commercial Blvd, Manila', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(4, 2, 'Local Distributor Inc.', 'Rosa Cruz', 'sales@localdistr.com', '555-0202', '321 Trade St, Quezon City', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(5, 3, 'TechHub Distributors', 'Alex Chen', 'bulk@techhub.com', '555-0301', '100 Tech Park, Silicon Valley', '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(6, 3, 'ElectroWorld Ltd.', 'Sarah Johnson', 'wholesale@electroworld.com', '555-0302', '200 Digital Ave, San Francisco', '2025-12-07 16:33:10', '2025-12-07 16:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `userid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'zeus', 'Zeus Instructor', 'zeus@inventory.local', NULL, '$2y$12$anpVE3Ckyp3RsrxRZNeWvubEI0DR1KqoIqjDZaYZckP02Hp0aajtS', 0, NULL, '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(2, 'zeusadmin', 'Zeus Admin', 'zeusadmin@inventory.local', NULL, '$2y$12$owT.oZwzzDDOabULZVETy./A/Quoq00sLgOL79neRzQ8JWIETTuFG', 1, NULL, '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(3, 'superadmin', 'Super Administrator', 'superadmin@inventory.local', NULL, '$2y$12$sZNFTsYmFpcywKFKo/FuZ.lj9QzPNRMOQCqdkBT3sAfHIxbxQNvz2', 1, NULL, '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(4, 'user', 'Regular User', 'user@inventory.local', NULL, '$2y$12$QYUI9/Z5b5PqULGmclMW2OQnJLNjnih2V5xPDMy8mIxMaSiKBKq6K', 0, NULL, '2025-12-07 16:33:09', '2025-12-07 16:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_inventories`
--

CREATE TABLE `user_inventories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_inventories`
--

INSERT INTO `user_inventories` (`id`, `user_id`, `inventory_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(2, 1, 2, '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(3, 2, 1, '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(4, 2, 2, '2025-12-07 16:33:09', '2025-12-07 16:33:09'),
(5, 3, 1, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(6, 3, 2, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(7, 3, 3, '2025-12-07 16:33:10', '2025-12-07 16:33:10'),
(8, 4, 3, '2025-12-07 16:33:10', '2025-12-07 16:33:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alerts_product_id_index` (`product_id`),
  ADD KEY `alerts_type_index` (`type`),
  ADD KEY `alerts_status_index` (`status`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD KEY `categories_inventory_id_index` (`inventory_id`),
  ADD KEY `categories_name_index` (`name`),
  ADD KEY `categories_inventory_id_name_index` (`inventory_id`,`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventories_name_unique` (`name`),
  ADD KEY `inventories_name_index` (`name`),
  ADD KEY `inventories_status_index` (`status`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
  ADD KEY `products_inventory_id_index` (`inventory_id`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_supplier_id_index` (`supplier_id`),
  ADD KEY `products_sku_index` (`sku`),
  ADD KEY `products_barcode_index` (`barcode`),
  ADD KEY `products_name_index` (`name`),
  ADD KEY `products_current_stock_index` (`current_stock`),
  ADD KEY `products_reorder_level_index` (`reorder_level`),
  ADD KEY `products_inventory_id_category_id_index` (`inventory_id`,`category_id`),
  ADD KEY `products_inventory_id_supplier_id_index` (`inventory_id`,`supplier_id`),
  ADD KEY `products_inventory_id_current_stock_index` (`inventory_id`,`current_stock`),
  ADD KEY `products_inventory_id_reorder_level_index` (`inventory_id`,`reorder_level`);

--
-- Indexes for table `restocks`
--
ALTER TABLE `restocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restocks_fulfilled_by_foreign` (`fulfilled_by`),
  ADD KEY `restocks_inventory_id_index` (`inventory_id`),
  ADD KEY `restocks_user_id_index` (`user_id`),
  ADD KEY `restocks_status_index` (`status`),
  ADD KEY `restocks_inventory_id_status_index` (`inventory_id`,`status`);

--
-- Indexes for table `restock_costs`
--
ALTER TABLE `restock_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restock_costs_inventory_id_cost_type_index` (`inventory_id`,`cost_type`),
  ADD KEY `restock_costs_user_id_index` (`user_id`);

--
-- Indexes for table `restock_items`
--
ALTER TABLE `restock_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `restock_items_restock_id_product_id_unique` (`restock_id`,`product_id`),
  ADD KEY `restock_items_product_id_index` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_restock_id_index` (`restock_id`),
  ADD KEY `stock_movements_product_id_index` (`product_id`),
  ADD KEY `stock_movements_type_index` (`type`),
  ADD KEY `stock_movements_created_at_index` (`created_at`),
  ADD KEY `stock_movements_product_id_created_at_index` (`product_id`,`created_at`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_name_unique` (`name`),
  ADD KEY `suppliers_inventory_id_index` (`inventory_id`),
  ADD KEY `suppliers_name_index` (`name`),
  ADD KEY `suppliers_email_index` (`email`),
  ADD KEY `suppliers_inventory_id_name_index` (`inventory_id`,`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_userid_unique` (`userid`),
  ADD KEY `users_userid_index` (`userid`),
  ADD KEY `users_email_index` (`email`),
  ADD KEY `users_is_admin_index` (`is_admin`);

--
-- Indexes for table `user_inventories`
--
ALTER TABLE `user_inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_inventories_user_id_inventory_id_unique` (`user_id`,`inventory_id`),
  ADD KEY `user_inventories_user_id_index` (`user_id`),
  ADD KEY `user_inventories_inventory_id_index` (`inventory_id`),
  ADD KEY `user_inventories_user_id_inventory_id_index` (`user_id`,`inventory_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `restocks`
--
ALTER TABLE `restocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restock_costs`
--
ALTER TABLE `restock_costs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restock_items`
--
ALTER TABLE `restock_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_inventories`
--
ALTER TABLE `user_inventories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restocks`
--
ALTER TABLE `restocks`
  ADD CONSTRAINT `restocks_fulfilled_by_foreign` FOREIGN KEY (`fulfilled_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restocks_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restock_costs`
--
ALTER TABLE `restock_costs`
  ADD CONSTRAINT `restock_costs_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restock_costs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restock_items`
--
ALTER TABLE `restock_items`
  ADD CONSTRAINT `restock_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restock_items_restock_id_foreign` FOREIGN KEY (`restock_id`) REFERENCES `restocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_restock_id_foreign` FOREIGN KEY (`restock_id`) REFERENCES `restocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_inventories`
--
ALTER TABLE `user_inventories`
  ADD CONSTRAINT `user_inventories_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
