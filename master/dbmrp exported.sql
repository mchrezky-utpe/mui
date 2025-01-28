-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: dbmrp
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_global_params`
--

DROP TABLE IF EXISTS `app_global_params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_global_params` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `param_name` varchar(100) DEFAULT NULL,
  `value_text` varchar(255) DEFAULT NULL,
  `value_numeric` int(11) DEFAULT NULL,
  `value_decimal` decimal(20,4) DEFAULT NULL,
  `value_date` date DEFAULT NULL,
  `value_timestamp` timestamp NULL DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_global_params`
--

LOCK TABLES `app_global_params` WRITE;
/*!40000 ALTER TABLE `app_global_params` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_global_params` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_module`
--

DROP TABLE IF EXISTS `app_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_module` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_module`
--

LOCK TABLES `app_module` WRITE;
/*!40000 ALTER TABLE `app_module` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_purchase_request_approval`
--

DROP TABLE IF EXISTS `log_purchase_request_approval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_purchase_request_approval` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `flag_status` smallint(6) DEFAULT NULL COMMENT '1 : uncheck\r\n2 : approved\r\n3 : suspended',
  `flag_active` tinyint(1) DEFAULT NULL,
  `trans_pr_id` bigint(20) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_log_purchase_request_approval_trans_purchase_request` (`trans_pr_id`),
  CONSTRAINT `FK_log_purchase_request_approval_trans_purchase_request` FOREIGN KEY (`trans_pr_id`) REFERENCES `trans_purchase_request` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=2730 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_purchase_request_approval`
--

LOCK TABLES `log_purchase_request_approval` WRITE;
/*!40000 ALTER TABLE `log_purchase_request_approval` DISABLE KEYS */;
INSERT INTO `log_purchase_request_approval` VALUES (1,'Transaction created',1,0,1,'administrator','2025-01-24 17:00:00',NULL,NULL),(2,'Transaction created',1,1,2,'administrator','2025-01-24 17:00:00',NULL,NULL),(3,'Transaction created',1,1,3,'administrator','2025-01-24 17:00:00',NULL,NULL),(4,'Transaction created',1,1,4,'administrator','2025-01-24 17:00:00',NULL,NULL),(5,'Transaction created',1,1,5,'administrator','2025-01-24 17:00:00',NULL,NULL),(6,'OK',2,1,1,'boss','2025-01-25 21:48:24',NULL,NULL);
/*!40000 ALTER TABLE `log_purchase_request_approval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'2025_01_12_095946_create_sku_table',1),(3,'2025_01_12_101100_create_mst_sku_unit_table',1),(4,'2025_01_12_101349_create_mst_sku_model_table',1),(5,'2025_01_12_101530_create_mst_sku_process_table',1),(6,'2025_01_12_101643_create_mst_sku_packaging_table',1),(7,'2025_01_12_101708_create_mst_sku_detail_table',1),(8,'2025_01_12_101744_create_mst_sku_type_table',1),(9,'2025_01_13_151653_create_mst_sku_business_type_table',1),(10,'2025_01_13_154235_create_mst_person_supplier_table',1),(11,'2025_01_18_032226_create_trans_purchase_order_table',1),(12,'2025_01_18_032424_create_trans_purchase_order_detail_table',1),(13,'2025_01_18_032432_create_trans_purchase_order_deduction_table',1),(14,'2025_01_18_032441_create_trans_purchase_order_othercost_table',1),(15,'2025_01_18_123551_create_mst_general_terms',1),(16,'2025_01_18_142800_create_mst_general_department',1),(17,'2025_01_18_224108_create_mst_general_currency',1),(18,'2025_01_18_230950_create_mst_general_tax_table',1),(19,'2025_01_19_084533_create_mst_general_deductor_table',1),(20,'2025_01_19_092117_create_mst_general_other_cost_table',1),(21,'2025_01_19_102322_create_mst_general_exchange_rates_table',1),(23,'2025_01_21_113334_create_trans_sku_pricelist_table',1),(24,'2025_01_21_113920_create_trans_sku_minofstock_table',1),(25,'2025_01_21_113934_create_trans_sku_minofqty_table',1),(26,'2025_01_21_094300_create_mst_person_customer_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_currency`
--

DROP TABLE IF EXISTS `mst_general_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_currency` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=91 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_currency`
--

LOCK TABLES `mst_general_currency` WRITE;
/*!40000 ALTER TABLE `mst_general_currency` DISABLE KEYS */;
INSERT INTO `mst_general_currency` VALUES (1,'UAE Dirham','AED',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(2,'Afghani','AFN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,'Lek','ALL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(4,'Armenian Dram','AMD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(5,'Netherlands Antillean Guilder','ANG',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(6,'Kwanza','AOA',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(7,'Argentine Peso','ARS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(8,'Australian Dollar','AUD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(9,'Aruban Florin','AWG',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(10,'Azerbaijan Manat','AZN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(11,'Convertible Mark','BAM',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(12,'Barbados Dollar','BBD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(13,'Taka','BDT',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(14,'Bulgarian Lev','BGN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(15,'Bahraini Dinar','BHD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(16,'Burundi Franc','BIF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(17,'Bermudian Dollar','BMD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(18,'Brunei Dollar','BND',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(19,'Boliviano','BOB',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(20,'Mvdol','BOV',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(21,'Brazilian Real','BRL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(22,'Bahamian Dollar','BSD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(23,'Ngultrum','BTN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(24,'Pula','BWP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(25,'Belarusian Ruble','BYN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(26,'Belize Dollar','BZD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(27,'Canadian Dollar','CAD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(28,'Congolese Franc','CDF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(29,'WIR Euro','CHE',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(30,'Swiss Franc','CHF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(31,'WIR Franc','CHW',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(32,'Unidad de Fomento','CLF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(33,'Chilean Peso','CLP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(34,'Yuan Renminbi','CNY',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(35,'Colombian Peso','COP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(36,'Unidad de Valor Real','COU',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(37,'Costa Rican Colon','CRC',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(38,'Peso Convertible','CUC',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(39,'Cuban Peso','CUP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(40,'Cabo Verde Escudo','CVE',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(41,'Czech Koruna','CZK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(42,'Djibouti Franc','DJF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(43,'Danish Krone','DKK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(44,'Dominican Peso','DOP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(45,'Algerian Dinar','DZD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(46,'Egyptian Pound','EGP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(47,'Nakfa','ERN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(48,'Ethiopian Birr','ETB',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(49,'Euro','EUR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(50,'Fiji Dollar','FJD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(51,'Falkland Islands Pound','FKP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(52,'Pound Sterling','GBP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(53,'Lari','GEL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(54,'Ghana Cedi','GHS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(55,'Gibraltar Pound','GIP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(56,'Dalasi','GMD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(57,'Guinean Franc','GNF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(58,'Quetzal','GTQ',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(59,'Guyana Dollar','GYD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(60,'Hong Kong Dollar','HKD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(61,'Lempira','HNL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(62,'Kuna','HRK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(63,'Gourde','HTG',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(64,'Forint','HUF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(65,'Rupiah','IDR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(66,'New Israeli Sheqel','ILS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(67,'Indian Rupee','INR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(68,'Iraqi Dinar','IQD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(69,'Iranian Rial','IRR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(70,'Iceland Krona','ISK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(71,'Jamaican Dollar','JMD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(72,'Jordanian Dinar','JOD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(73,'Yen','JPY',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(74,'Kenyan Shilling','KES',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(75,'Som','KGS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(76,'Riel','KHR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(77,'Comorian Franc','KMF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(78,'North Korean Won','KPW',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(79,'Won','KRW',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(80,'Kuwaiti Dinar','KWD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(81,'Cayman Islands Dollar','KYD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(82,'Tenge','KZT',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(83,'Lao Kip','LAK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(84,'Lebanese Pound','LBP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(85,'Sri Lanka Rupee','LKR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(86,'Liberian Dollar','LRD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(87,'Loti','LSL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(88,'Libyan Dinar','LYD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(89,'Moroccan Dirham','MAD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(90,'Moldovan Leu','MDL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(91,'Malagasy Ariary','MGA',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(92,'Denar','MKD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(93,'Kyat','MMK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(94,'Tugrik','MNT',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(95,'Pataca','MOP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(96,'Ouguiya','MRU',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(97,'Mauritius Rupee','MUR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(98,'Rufiyaa','MVR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(99,'Malawi Kwacha','MWK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(100,'Mexican Peso','MXN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(101,'Mexican Unidad de Inversion (UDI)','MXV',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(102,'Malaysian Ringgit','MYR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(103,'Mozambique Metical','MZN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(104,'Namibia Dollar','NAD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(105,'Naira','NGN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(106,'Cordoba Oro','NIO',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(107,'Norwegian Krone','NOK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(108,'Nepalese Rupee','NPR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(109,'New Zealand Dollar','NZD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(110,'Rial Omani','OMR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(111,'Balboa','PAB',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(112,'Sol','PEN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(113,'Kina','PGK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(114,'Philippine Peso','PHP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(115,'Pakistan Rupee','PKR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(116,'Zloty','PLN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(117,'Guarani','PYG',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(118,'Qatari Rial','QAR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(119,'Romanian Leu','RON',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(120,'Serbian Dinar','RSD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(121,'Russian Ruble','RUB',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(122,'Rwanda Franc','RWF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(123,'Saudi Riyal','SAR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(124,'Solomon Islands Dollar','SBD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(125,'Seychelles Rupee','SCR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(126,'Sudanese Pound','SDG',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(127,'Swedish Krona','SEK',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(128,'Singapore Dollar','SGD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(129,'Saint Helena Pound','SHP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(130,'Leone','SLL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(131,'Somali Shilling','SOS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(132,'Surinam Dollar','SRD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(133,'South Sudanese Pound','SSP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(134,'Dobra','STN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(135,'El Salvador Colon','SVC',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(136,'Syrian Pound','SYP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(137,'Lilangeni','SZL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(138,'Baht','THB',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(139,'Somoni','TJS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(140,'Turkmenistan New Manat','TMT',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(141,'Tunisian Dinar','TND',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(142,'Pa’anga','TOP',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(143,'Turkish Lira','TRY',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(144,'Trinidad and Tobago Dollar','TTD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(145,'New Taiwan Dollar','TWD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(146,'Tanzanian Shilling','TZS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(147,'Hryvnia','UAH',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(148,'Uganda Shilling','UGX',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(149,'US Dollar','USD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(150,'US Dollar (Next day)','USN',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(151,'Uruguay Peso en Unidades Indexadas (UI)','UYI',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(152,'Peso Uruguayo','UYU',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(153,'Unidad Previsional','UYW',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(154,'Uzbekistan Sum','UZS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(155,'Bolívar Soberano','VES',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(156,'Dong','VND',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(157,'Vatu','VUV',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(158,'Tala','WST',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(159,'CFA Franc BEAC','XAF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(160,'Silver','XAG',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(161,'Gold','XAU',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(162,'Bond Markets Unit European Composite Unit (EURCO)','XBA',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(163,'Bond Markets Unit European Monetary Unit (E.M.U.-6)','XBB',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(164,'Bond Markets Unit European Unit of Account 9 (E.U.A.-9)','XBC',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(165,'Bond Markets Unit European Unit of Account 17 (E.U.A.-17)','XBD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(166,'East Caribbean Dollar','XCD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(167,'SDR (Special Drawing Right)','XDR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(168,'CFA Franc BCEAO','XOF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(169,'Palladium','XPD',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(170,'CFP Franc','XPF',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(171,'Platinum','XPT',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(172,'Sucre','XSU',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(173,'Codes specifically reserved for testing purposes','XTS',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(174,'ADB Unit of Account','XUA',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(175,'The codes assigned for transactions where no currency is involved','XXX',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(176,'Yemeni Rial','YER',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(177,'Rand','ZAR',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(178,'Zambian Kwacha','ZMW',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(179,'Zimbabwe Dollar','ZWL',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_general_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_deductor`
--

DROP TABLE IF EXISTS `mst_general_deductor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_deductor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `app_module_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_mst_general_deductor_app_module` (`app_module_id`),
  CONSTRAINT `FK_mst_general_deductor_app_module` FOREIGN KEY (`app_module_id`) REFERENCES `app_module` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_deductor`
--

LOCK TABLES `mst_general_deductor` WRITE;
/*!40000 ALTER TABLE `mst_general_deductor` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_general_deductor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_department`
--

DROP TABLE IF EXISTS `mst_general_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_department` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `gen_cost_center_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=8192 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_department`
--

LOCK TABLES `mst_general_department` WRITE;
/*!40000 ALTER TABLE `mst_general_department` DISABLE KEYS */;
INSERT INTO `mst_general_department` VALUES (1,'PPIC','PPIC',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Purchasing','PRC',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_general_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_exchange_rates`
--

DROP TABLE IF EXISTS `mst_general_exchange_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_exchange_rates` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `valid_from_date` date DEFAULT NULL,
  `valid_to_date` date DEFAULT NULL,
  `val_exchangerates` decimal(20,4) NOT NULL DEFAULT 1.0000,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `gen_currency_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mst_general_exchange_rates_mst_general_currency` (`gen_currency_id`),
  CONSTRAINT `FK_mst_general_exchange_rates_mst_general_currency` FOREIGN KEY (`gen_currency_id`) REFERENCES `mst_general_currency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=16384 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_exchange_rates`
--

LOCK TABLES `mst_general_exchange_rates` WRITE;
/*!40000 ALTER TABLE `mst_general_exchange_rates` DISABLE KEYS */;
INSERT INTO `mst_general_exchange_rates` VALUES (1,'Kurs Pajak','2025-01-22','2025-01-28',16322.0000,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,149);
/*!40000 ALTER TABLE `mst_general_exchange_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_other_cost`
--

DROP TABLE IF EXISTS `mst_general_other_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_other_cost` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `app_module_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_mst_general_other_cost_app_module` (`app_module_id`),
  CONSTRAINT `FK_mst_general_other_cost_app_module` FOREIGN KEY (`app_module_id`) REFERENCES `app_module` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_other_cost`
--

LOCK TABLES `mst_general_other_cost` WRITE;
/*!40000 ALTER TABLE `mst_general_other_cost` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_general_other_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_tax`
--

DROP TABLE IF EXISTS `mst_general_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_tax` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `value` decimal(20,4) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=5461 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_tax`
--

LOCK TABLES `mst_general_tax` WRITE;
/*!40000 ALTER TABLE `mst_general_tax` DISABLE KEYS */;
INSERT INTO `mst_general_tax` VALUES (1,'PPN','PPN',11.0000,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(2,'PPH 21','PPH21',15.0000,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,'PPH 23','PPH23',2.0000,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_general_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_terms`
--

DROP TABLE IF EXISTS `mst_general_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_terms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `app_module_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_mst_terms_app_module` (`app_module_id`),
  CONSTRAINT `FK_mst_terms_app_module` FOREIGN KEY (`app_module_id`) REFERENCES `app_module` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_terms`
--

LOCK TABLES `mst_general_terms` WRITE;
/*!40000 ALTER TABLE `mst_general_terms` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_general_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_general_terms_detail`
--

DROP TABLE IF EXISTS `mst_general_terms_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_general_terms_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `general_terms_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mst_general_terms_detail_mst_general_terms` (`general_terms_id`),
  CONSTRAINT `FK_mst_general_terms_detail_mst_general_terms` FOREIGN KEY (`general_terms_id`) REFERENCES `mst_general_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_general_terms_detail`
--

LOCK TABLES `mst_general_terms_detail` WRITE;
/*!40000 ALTER TABLE `mst_general_terms_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_general_terms_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_person_customer`
--

DROP TABLE IF EXISTS `mst_person_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_person_customer` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact_person` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_person_customer`
--

LOCK TABLES `mst_person_customer` WRITE;
/*!40000 ALTER TABLE `mst_person_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_person_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_person_supplier`
--

DROP TABLE IF EXISTS `mst_person_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_person_supplier` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `address_01` text DEFAULT NULL,
  `address_02` text DEFAULT NULL,
  `address_03` text DEFAULT NULL,
  `phone_01` varchar(50) DEFAULT NULL,
  `phone_02` varchar(50) DEFAULT NULL,
  `phone_03` varchar(50) DEFAULT NULL,
  `fax_01` varchar(50) DEFAULT NULL,
  `fax_02` varchar(50) DEFAULT NULL,
  `fax_03` varchar(50) DEFAULT NULL,
  `email_01` varchar(50) DEFAULT NULL,
  `email_02` varchar(50) DEFAULT NULL,
  `email_03` varchar(50) DEFAULT NULL,
  `contact_person_01` varchar(50) DEFAULT NULL,
  `contact_person_02` varchar(50) DEFAULT NULL,
  `contact_person_03` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_person_supplier`
--

LOCK TABLES `mst_person_supplier` WRITE;
/*!40000 ALTER TABLE `mst_person_supplier` DISABLE KEYS */;
INSERT INTO `mst_person_supplier` VALUES (1,'Ahmad','SUP0001',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,'2025-01-26 03:41:23',NULL,'2025-01-26 03:41:23',NULL,NULL,NULL,'ca56a3d3-4be7-43ae-80d2-8c6334ce36f0');
/*!40000 ALTER TABLE `mst_person_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku`
--

DROP TABLE IF EXISTS `mst_sku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `sku_type_id` bigint(20) DEFAULT NULL,
  `sku_unit_id` bigint(20) DEFAULT NULL,
  `sku_model_id` bigint(20) DEFAULT NULL,
  `sku_process_id` bigint(20) DEFAULT NULL,
  `sku_business_type_id` bigint(20) DEFAULT NULL,
  `sku_packaging_id` bigint(20) DEFAULT NULL,
  `sku_detail_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_mst_sku_mst_sku_business_type` (`sku_business_type_id`),
  KEY `IXFK_mst_sku_mst_sku_detail` (`sku_detail_id`),
  KEY `IXFK_mst_sku_mst_sku_model` (`sku_model_id`),
  KEY `IXFK_mst_sku_mst_sku_packaging` (`sku_packaging_id`),
  KEY `IXFK_mst_sku_mst_sku_process` (`sku_process_id`),
  KEY `IXFK_mst_sku_mst_sku_type` (`sku_type_id`),
  KEY `IXFK_mst_sku_mst_sku_unit` (`sku_unit_id`),
  CONSTRAINT `FK_mst_sku_mst_sku_business_type` FOREIGN KEY (`sku_business_type_id`) REFERENCES `mst_sku_business_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_mst_sku_mst_sku_detail` FOREIGN KEY (`sku_detail_id`) REFERENCES `mst_sku_detail` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_mst_sku_mst_sku_model` FOREIGN KEY (`sku_model_id`) REFERENCES `mst_sku_model` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_mst_sku_mst_sku_packaging` FOREIGN KEY (`sku_packaging_id`) REFERENCES `mst_sku_packaging` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_mst_sku_mst_sku_process` FOREIGN KEY (`sku_process_id`) REFERENCES `mst_sku_process` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_mst_sku_mst_sku_type` FOREIGN KEY (`sku_type_id`) REFERENCES `mst_sku_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_mst_sku_mst_sku_unit` FOREIGN KEY (`sku_unit_id`) REFERENCES `mst_sku_unit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=1092 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku`
--

LOCK TABLES `mst_sku` WRITE;
/*!40000 ALTER TABLE `mst_sku` DISABLE KEYS */;
INSERT INTO `mst_sku` VALUES (1,'Gear A1','SP-001',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,3,2,NULL,6,4,1,NULL),(2,'Van Belt A2','SP-002',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,3,1,NULL,6,4,1,NULL),(3,'Cat Merah','CH-001',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,4,5,NULL,1,1,1,NULL),(4,'Cat Kuning','CH-002',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,4,5,NULL,1,1,1,NULL),(5,'Cat Hijau','CH-003',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,4,5,NULL,1,1,1,NULL),(6,'Baja 0.65mm','MT-001',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,3,5,3,NULL),(7,'Baja 0.75mm','MT-002',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,3,5,3,NULL),(8,'Baja 0.80mm','MT-003',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,3,5,3,NULL),(9,'Baja 1.00mm','MT-004',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,3,5,3,NULL),(10,'Kertas A3','OF-001',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,12,NULL,3,3,1,NULL),(11,'Kertas A4','OF-002',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,12,NULL,3,3,1,NULL),(12,'Pensil 2B','OF-003',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,3,NULL,3,3,1,NULL),(13,'Spidol','OF-004',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,3,3,1,NULL),(14,'Penghapus','OF-005',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,3,3,1,NULL),(15,'Stempel','OF-006',1,1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,3,3,1,NULL);
/*!40000 ALTER TABLE `mst_sku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku_business_type`
--

DROP TABLE IF EXISTS `mst_sku_business_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku_business_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=3276 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku_business_type`
--

LOCK TABLES `mst_sku_business_type` WRITE;
/*!40000 ALTER TABLE `mst_sku_business_type` DISABLE KEYS */;
INSERT INTO `mst_sku_business_type` VALUES (1,'Motorcycle','MT',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(2,'Automobile','AM',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,'Back Office','BO',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(4,'Factory Machine','FM',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(5,'Development','DV',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_sku_business_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku_detail`
--

DROP TABLE IF EXISTS `mst_sku_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` text DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku_detail`
--

LOCK TABLES `mst_sku_detail` WRITE;
/*!40000 ALTER TABLE `mst_sku_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_sku_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku_model`
--

DROP TABLE IF EXISTS `mst_sku_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku_model` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `image_path` text DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku_model`
--

LOCK TABLES `mst_sku_model` WRITE;
/*!40000 ALTER TABLE `mst_sku_model` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_sku_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku_packaging`
--

DROP TABLE IF EXISTS `mst_sku_packaging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku_packaging` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=5461 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku_packaging`
--

LOCK TABLES `mst_sku_packaging` WRITE;
/*!40000 ALTER TABLE `mst_sku_packaging` DISABLE KEYS */;
INSERT INTO `mst_sku_packaging` VALUES (1,'Kardus','BOX',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(2,'Plastik','PLASTIC',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,'Kayu','WD-PKG',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_sku_packaging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku_process`
--

DROP TABLE IF EXISTS `mst_sku_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku_process` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=2730 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku_process`
--

LOCK TABLES `mst_sku_process` WRITE;
/*!40000 ALTER TABLE `mst_sku_process` DISABLE KEYS */;
INSERT INTO `mst_sku_process` VALUES (1,'ADDITIONAL MATERIAL','AM',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(2,'FINISHED GOODS','FG',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,'GENERAL','GE',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(4,'SEMI FINISHED GOOD','SI',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(5,'WIP','WI',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(6,'SPAREPART','SP',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_sku_process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku_type`
--

DROP TABLE IF EXISTS `mst_sku_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=4096 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku_type`
--

LOCK TABLES `mst_sku_type` WRITE;
/*!40000 ALTER TABLE `mst_sku_type` DISABLE KEYS */;
INSERT INTO `mst_sku_type` VALUES (1,'GENERAL ITEM','GI',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(2,'PACKAGING','PG',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,'PART','PR',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(4,'PRODUCTION MATERIAL','PM',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_sku_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_sku_unit`
--

DROP TABLE IF EXISTS `mst_sku_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_sku_unit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=1365 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_sku_unit`
--

LOCK TABLES `mst_sku_unit` WRITE;
/*!40000 ALTER TABLE `mst_sku_unit` DISABLE KEYS */;
INSERT INTO `mst_sku_unit` VALUES (1,'Pieces','PCS',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(2,'Unit','UNIT',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(3,'Box','BOX',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(4,'Liter','L',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(5,'Kilogram','KG',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(6,'Ton','TON',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(7,'Meter','M',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(8,'Roll','ROLL',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(9,'Drum','DRUM',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(10,'Tabung','TBG',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(11,'Pak','PAK',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(12,'Rim','RIM',1,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mst_sku_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_user`
--

DROP TABLE IF EXISTS `mst_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `flag_active` tinyint(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_user`
--

LOCK TABLES `mst_user` WRITE;
/*!40000 ALTER TABLE `mst_user` DISABLE KEYS */;
INSERT INTO `mst_user` VALUES (1,'admin','ahmad','US0001','202cb962ac59075b964b07152d234b70',1,NULL,'2025-01-21 09:50:34',NULL,'2025-01-21 09:50:35',NULL,NULL);
/*!40000 ALTER TABLE `mst_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
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
INSERT INTO `sessions` VALUES ('A3Xt6idgVEzUjz99uKI7tcvdcm69D7iKEGk0g4Tb',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidDNsNEw3ckZZSDFPMUNUSWVENEY3Rk1SUDZpSmxoaWgxWmhDZFFYaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9za3UtdW5pdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1738067248),('u6snkTvOUMb1gXZjb6zC3e6hVmUAOmMNSDd1IYOq',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV21YZFpZdDdIQmE5RGZ4V3FkVVFyN09GVHFLTThoSzJRa29mTUduWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1738045572);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_purchase_order`
--

DROP TABLE IF EXISTS `trans_purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_purchase_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_date` date DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `doc_num` varchar(50) DEFAULT NULL,
  `doc_counter` smallint(6) DEFAULT NULL,
  `flag_status` smallint(6) DEFAULT NULL,
  `valid_from_date` date DEFAULT NULL,
  `valid_to_date` date DEFAULT NULL,
  `revision` smallint(6) DEFAULT NULL,
  `flag_type` smallint(6) DEFAULT NULL COMMENT '1 : production project material\r\n	2 : general item',
  `flag_active` tinyint(1) DEFAULT NULL,
  `val_exchangerates` decimal(20,4) NOT NULL DEFAULT 1.0000,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `gen_terms_detail_id` bigint(20) DEFAULT NULL,
  `gen_currency_id` bigint(20) DEFAULT NULL,
  `gen_department_id` bigint(20) DEFAULT NULL,
  `prs_supplier_id` bigint(20) DEFAULT NULL,
  `purchase_request_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trans_purchase_order_trans_purchase_request` (`purchase_request_id`),
  CONSTRAINT `FK_trans_purchase_order_trans_purchase_request` FOREIGN KEY (`purchase_request_id`) REFERENCES `trans_purchase_request` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=16384 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_purchase_order`
--

LOCK TABLES `trans_purchase_order` WRITE;
/*!40000 ALTER TABLE `trans_purchase_order` DISABLE KEYS */;
INSERT INTO `trans_purchase_order` VALUES (4,'2025-01-27','OK','MUI/PO/25/01/0001',1,3,'2025-01-27','2025-02-05',0,1,1,16322.0000,'administrator','2025-01-25 21:27:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,149,1,1,1),(5,'2025-01-26','ok','MUI/PO/25/01/0002',2,1,'2025-01-26','2025-01-26',0,2,0,1.0000,NULL,'2025-01-26 12:40:18',NULL,'2025-01-26 13:05:33',NULL,'2025-01-26 13:05:33',NULL,'0ed96e32-4e7b-4cf4-b0c5-4c7018a72e5a',2,5,2,1,NULL),(6,'2025-01-26','ok','MUI/PO/25/01/0003',3,1,'2025-01-26','2025-01-26',0,2,0,1.0000,NULL,'2025-01-26 12:40:36',NULL,'2025-01-26 13:06:01',NULL,'2025-01-26 13:06:01',NULL,'773d2f63-8874-4d98-8bcf-cd9585e361c5',2,5,2,1,NULL),(7,'2025-01-26','ok','MUI/PO/25/01/0004',4,1,'2025-01-26','2025-01-26',0,2,0,1.0000,NULL,'2025-01-26 12:40:44',NULL,'2025-01-26 13:06:05',NULL,'2025-01-26 13:06:05',NULL,'277ccf08-af29-4daf-b0ea-5d436bb1072b',2,5,2,1,NULL),(24,'2025-01-26',NULL,'MUI/PO/25/01/0005',5,1,'2025-01-26','2025-01-26',0,2,0,1.0000,NULL,'2025-01-26 12:57:42',NULL,'2025-01-27 19:35:45',NULL,'2025-01-27 19:35:45',NULL,'6f38b198-fb68-4f72-a21a-8a85c8108560',4,4,2,1,NULL);
/*!40000 ALTER TABLE `trans_purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_purchase_order_deduction`
--

DROP TABLE IF EXISTS `trans_purchase_order_deduction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_purchase_order_deduction` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `value_d` decimal(20,4) DEFAULT NULL,
  `value_f` decimal(20,4) DEFAULT NULL,
  `qty` decimal(20,4) DEFAULT NULL,
  `total_d` decimal(20,4) DEFAULT NULL,
  `total_f` decimal(20,4) DEFAULT NULL,
  `counter` smallint(6) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `trans_po_id` bigint(20) DEFAULT NULL,
  `gen_deductor_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trans_purchase_order_deduction_mst_general_deductor` (`gen_deductor_id`),
  KEY `FK_trans_purchase_order_deduction_trans_purchase_order` (`trans_po_id`),
  CONSTRAINT `FK_trans_purchase_order_deduction_mst_general_deductor` FOREIGN KEY (`gen_deductor_id`) REFERENCES `mst_general_deductor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_trans_purchase_order_deduction_trans_purchase_order` FOREIGN KEY (`trans_po_id`) REFERENCES `trans_purchase_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_purchase_order_deduction`
--

LOCK TABLES `trans_purchase_order_deduction` WRITE;
/*!40000 ALTER TABLE `trans_purchase_order_deduction` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_purchase_order_deduction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_purchase_order_detail`
--

DROP TABLE IF EXISTS `trans_purchase_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_purchase_order_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `sku_description` varchar(100) DEFAULT NULL,
  `sku_prefix` varchar(50) DEFAULT NULL,
  `price_d` decimal(20,4) DEFAULT NULL,
  `price_f` decimal(20,4) DEFAULT NULL,
  `qty` decimal(20,4) DEFAULT NULL,
  `subtotal_d` decimal(20,4) DEFAULT NULL,
  `subtotal_f` decimal(20,4) DEFAULT NULL,
  `discount_flag` tinyint(1) DEFAULT NULL,
  `discount_percentage` decimal(10,2) DEFAULT NULL,
  `discount_d` decimal(20,4) DEFAULT NULL,
  `discount_f` decimal(20,4) DEFAULT NULL,
  `afterdiscount_d` decimal(20,4) DEFAULT NULL,
  `afterdiscount_f` decimal(20,4) DEFAULT NULL,
  `vat_flag` tinyint(1) DEFAULT NULL,
  `vat_percentage` decimal(10,2) DEFAULT NULL,
  `vat_d` decimal(20,4) DEFAULT NULL,
  `vat_f` decimal(20,4) DEFAULT NULL,
  `total_d` decimal(20,4) DEFAULT NULL,
  `total_f` decimal(20,4) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `trans_po_id` bigint(20) DEFAULT NULL,
  `sku_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trans_purchase_order_detail_mst_sku` (`sku_id`),
  KEY `FK_trans_purchase_order_detail_trans_purchase_order` (`trans_po_id`),
  CONSTRAINT `FK_trans_purchase_order_detail_mst_sku` FOREIGN KEY (`sku_id`) REFERENCES `mst_sku` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_trans_purchase_order_detail_trans_purchase_order` FOREIGN KEY (`trans_po_id`) REFERENCES `trans_purchase_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=16384 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_purchase_order_detail`
--

LOCK TABLES `trans_purchase_order_detail` WRITE;
/*!40000 ALTER TABLE `trans_purchase_order_detail` DISABLE KEYS */;
INSERT INTO `trans_purchase_order_detail` VALUES (1,NULL,'Gear A1','SP-001',2448300.0000,150.0000,2.0000,4896600.0000,300.0000,0,0.00,0.0000,0.0000,4896600.0000,300.0000,0,0.00,0.0000,0.0000,4896600.0000,300.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,4,1),(2,NULL,'Gear A1','SP-001',30000.0000,15000.0000,2.0000,30000.0000,30000.0000,NULL,0.00,0.0000,0.0000,30000.0000,30000.0000,NULL,11.00,3300.0000,3300.0000,33300.0000,33300.0000,NULL,NULL,NULL,NULL,NULL,NULL,'','a5a9f21f-5beb-4dac-8faa-763727a441cb',24,1);
/*!40000 ALTER TABLE `trans_purchase_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_purchase_order_othercost`
--

DROP TABLE IF EXISTS `trans_purchase_order_othercost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_purchase_order_othercost` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `value_d` decimal(20,4) DEFAULT NULL,
  `value_f` decimal(20,4) DEFAULT NULL,
  `qty` decimal(20,4) DEFAULT NULL,
  `total_d` decimal(20,4) DEFAULT NULL,
  `total_f` decimal(20,4) DEFAULT NULL,
  `counter` smallint(6) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `trans_po_id` bigint(20) DEFAULT NULL,
  `gen_othercost_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trans_purchase_order_othercost_mst_general_other_cost` (`gen_othercost_id`),
  KEY `FK_trans_purchase_order_othercost_trans_purchase_order` (`trans_po_id`),
  CONSTRAINT `FK_trans_purchase_order_othercost_mst_general_other_cost` FOREIGN KEY (`gen_othercost_id`) REFERENCES `mst_general_other_cost` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_trans_purchase_order_othercost_trans_purchase_order` FOREIGN KEY (`trans_po_id`) REFERENCES `trans_purchase_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_purchase_order_othercost`
--

LOCK TABLES `trans_purchase_order_othercost` WRITE;
/*!40000 ALTER TABLE `trans_purchase_order_othercost` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_purchase_order_othercost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_purchase_request`
--

DROP TABLE IF EXISTS `trans_purchase_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_purchase_request` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_date` date DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `doc_num` varchar(50) DEFAULT NULL,
  `doc_counter` smallint(6) DEFAULT NULL,
  `flag_status` smallint(6) DEFAULT NULL COMMENT '1 : requested\r\n	2 : approval\r\n	3 : PO active\r\n	4 : canceled',
  `flag_type` smallint(6) DEFAULT NULL COMMENT '1 : production project material\r\n	2 : general item',
  `flag_purpose` smallint(6) DEFAULT NULL COMMENT '1 : project development\r\n	2 : additional\r\n	3 : recovery\r\n	4 : early development',
  `flag_active` tinyint(1) DEFAULT NULL,
  `val_exchangerates` decimal(20,4) NOT NULL DEFAULT 1.0000,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `gen_currency_id` bigint(20) DEFAULT NULL,
  `gen_department_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trans_purchase_request_mst_general_currency` (`gen_currency_id`),
  KEY `FK_trans_purchase_request_mst_general_department` (`gen_department_id`),
  CONSTRAINT `FK_trans_purchase_request_mst_general_currency` FOREIGN KEY (`gen_currency_id`) REFERENCES `mst_general_currency` (`id`),
  CONSTRAINT `FK_trans_purchase_request_mst_general_department` FOREIGN KEY (`gen_department_id`) REFERENCES `mst_general_department` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=3276 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_purchase_request`
--

LOCK TABLES `trans_purchase_request` WRITE;
/*!40000 ALTER TABLE `trans_purchase_request` DISABLE KEYS */;
INSERT INTO `trans_purchase_request` VALUES (1,'2025-01-25','Pembelian Suku Cadang Mesin A1','MUI/PR/25/01/0001',1,2,1,3,1,16322.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,149,1),(2,'2025-01-25','Pembelian Suku Cadang Mesin A2','MUI/PR/25/01/0002',2,1,1,3,1,16322.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,149,1),(3,'2025-01-25','Pembelian Besi Baja','MUI/PR/25/01/0003',3,1,1,1,1,1.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,65,1),(4,'2025-01-25','Pembelian Cat','MUI/PR/25/01/0004',4,1,1,1,1,1.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,65,1),(5,'2025-01-25','Pembelian ATK Kantor','MUI/PR/25/01/0005',5,1,2,2,1,1.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,65,2);
/*!40000 ALTER TABLE `trans_purchase_request` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_purchase_request_approval_ins

AFTER INSERT

ON trans_purchase_request

FOR EACH ROW

BEGIN

  INSERT INTO log_purchase_request_approval (description, flag_status, flag_active, trans_pr_id, created_by, created_at)

    VALUES ('Transaction created', 1, 1, NEW.id, NEW.created_by, NEW.created_at);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_purchase_request_approval_del

AFTER DELETE

ON trans_purchase_request

FOR EACH ROW

BEGIN

  DELETE

    FROM log_purchase_request_approval

    WHERE id = OLD.id;

    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `trans_purchase_request_detail`
--

DROP TABLE IF EXISTS `trans_purchase_request_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_purchase_request_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `sku_description` varchar(100) DEFAULT NULL,
  `sku_prefix` varchar(50) DEFAULT NULL,
  `price_d` decimal(20,4) DEFAULT NULL,
  `price_f` decimal(20,4) DEFAULT NULL,
  `qty` decimal(20,4) DEFAULT NULL,
  `subtotal_d` decimal(20,4) DEFAULT NULL,
  `subtotal_f` decimal(20,4) DEFAULT NULL,
  `discount_flag` tinyint(1) DEFAULT NULL,
  `discount_percentage` decimal(10,2) DEFAULT NULL,
  `discount_d` decimal(20,4) DEFAULT NULL,
  `discount_f` decimal(20,4) DEFAULT NULL,
  `afterdiscount_d` decimal(20,4) DEFAULT NULL,
  `afterdiscount_f` decimal(20,4) DEFAULT NULL,
  `vat_flag` tinyint(1) DEFAULT NULL,
  `vat_percentage` decimal(10,2) DEFAULT NULL,
  `vat_d` decimal(20,4) DEFAULT NULL,
  `vat_f` decimal(20,4) DEFAULT NULL,
  `total_d` decimal(20,4) DEFAULT NULL,
  `total_f` decimal(20,4) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `flag_status` smallint(6) DEFAULT NULL COMMENT '1 : accepted\r\n	2 : denied\r\n	3 : hold',
  `trans_pr_id` bigint(20) DEFAULT NULL,
  `sku_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trans_purchase_request_detail_mst_sku` (`sku_id`),
  KEY `FK_trans_purchase_request_detail_trans_purchase_request` (`trans_pr_id`),
  CONSTRAINT `FK_trans_purchase_request_detail_mst_sku` FOREIGN KEY (`sku_id`) REFERENCES `mst_sku` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_trans_purchase_request_detail_trans_purchase_request` FOREIGN KEY (`trans_pr_id`) REFERENCES `trans_purchase_request` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AVG_ROW_LENGTH=1365 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_purchase_request_detail`
--

LOCK TABLES `trans_purchase_request_detail` WRITE;
/*!40000 ALTER TABLE `trans_purchase_request_detail` DISABLE KEYS */;
INSERT INTO `trans_purchase_request_detail` VALUES (1,NULL,'Gear A1','SP-001',2448300.0000,150.0000,2.0000,4896600.0000,300.0000,0,0.00,0.0000,0.0000,4896600.0000,300.0000,0,0.00,0.0000,0.0000,4896600.0000,300.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,1,1,1),(2,NULL,'Van Belt A2','SP-002',3264400.0000,200.0000,5.0000,16322000.0000,1000.0000,0,0.00,0.0000,0.0000,16322000.0000,1000.0000,0,0.00,0.0000,0.0000,16322000.0000,1000.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,2,2),(3,NULL,'Baja 0.65mm','MT-001',100000.0000,100000.0000,250.0000,25000000.0000,25000000.0000,0,0.00,0.0000,0.0000,25000000.0000,25000000.0000,0,0.00,0.0000,0.0000,25000000.0000,25000000.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,3,6),(4,NULL,'Baja 1.00mm','MT-004',150000.0000,150000.0000,100.0000,15000000.0000,15000000.0000,0,0.00,0.0000,0.0000,15000000.0000,15000000.0000,0,0.00,0.0000,0.0000,15000000.0000,15000000.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,3,9),(5,'Merk Propan','Cat Merah','CH-001',80000.0000,80000.0000,24.0000,1920000.0000,1920000.0000,0,0.00,0.0000,0.0000,1920000.0000,1920000.0000,0,11.00,211200.0000,211200.0000,2131200.0000,2131200.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,4,3),(6,'Merk Propan','Cat Kuning','CH-002',85000.0000,85000.0000,20.0000,1700000.0000,1700000.0000,0,0.00,0.0000,0.0000,1700000.0000,1700000.0000,0,11.00,187000.0000,187000.0000,1887000.0000,1887000.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,4,4),(7,'Merk Propan','Cat Hijau','CH-003',75000.0000,75000.0000,14.0000,1050000.0000,1050000.0000,0,0.00,0.0000,0.0000,1050000.0000,1050000.0000,0,11.00,115500.0000,115500.0000,1165500.0000,1165500.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,4,5),(8,'Merk SIDU','Kertas A4','OF-002',35000.0000,35000.0000,15.0000,525000.0000,525000.0000,0,10.00,52500.0000,52500.0000,472500.0000,472500.0000,0,11.00,51975.0000,51975.0000,524475.0000,524475.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,5,11),(9,'Merk PaperOne','Kertas A4','OF-002',30000.0000,30000.0000,20.0000,600000.0000,600000.0000,0,20.00,120000.0000,120000.0000,480000.0000,480000.0000,0,11.00,52800.0000,52800.0000,532800.0000,532800.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,5,11),(10,'Merk Snowman','Spidol','OF-004',15000.0000,15000.0000,5.0000,75000.0000,75000.0000,0,25.00,18750.0000,18750.0000,56250.0000,56250.0000,0,0.00,0.0000,0.0000,56250.0000,56250.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,5,13),(11,'Merk Joyko','Spidol','OF-004',12000.0000,12000.0000,5.0000,60000.0000,60000.0000,0,50.00,30000.0000,30000.0000,30000.0000,30000.0000,0,0.00,0.0000,0.0000,30000.0000,30000.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,5,13),(12,NULL,'Stempel','OF-006',35000.0000,35000.0000,2.0000,70000.0000,70000.0000,0,0.00,0.0000,0.0000,70000.0000,70000.0000,0,0.00,0.0000,0.0000,70000.0000,70000.0000,'administrator','2025-01-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,5,15);
/*!40000 ALTER TABLE `trans_purchase_request_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_sku_minofqty`
--

DROP TABLE IF EXISTS `trans_sku_minofqty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_sku_minofqty` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `qty` decimal(20,4) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `sku_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_trans_sku_minofqty_mst_sku` (`sku_id`),
  CONSTRAINT `FK_trans_sku_minofqty_mst_sku` FOREIGN KEY (`sku_id`) REFERENCES `mst_sku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_sku_minofqty`
--

LOCK TABLES `trans_sku_minofqty` WRITE;
/*!40000 ALTER TABLE `trans_sku_minofqty` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_sku_minofqty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_sku_minofstock`
--

DROP TABLE IF EXISTS `trans_sku_minofstock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_sku_minofstock` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `qty` decimal(20,4) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `sku_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_trans_sku_minofstock_mst_sku` (`sku_id`),
  CONSTRAINT `FK_trans_sku_minofstock_mst_sku` FOREIGN KEY (`sku_id`) REFERENCES `mst_sku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_sku_minofstock`
--

LOCK TABLES `trans_sku_minofstock` WRITE;
/*!40000 ALTER TABLE `trans_sku_minofstock` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_sku_minofstock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_sku_pricelist`
--

DROP TABLE IF EXISTS `trans_sku_pricelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_sku_pricelist` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `price` decimal(20,4) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `sku_id` bigint(20) DEFAULT NULL,
  `gen_currency_id` bigint(20) DEFAULT NULL,
  `prs_supplier_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_trans_sku_pricelist_mst_general_currency` (`gen_currency_id`),
  KEY `IXFK_trans_sku_pricelist_mst_person_supplier` (`prs_supplier_id`),
  KEY `IXFK_trans_sku_pricelist_mst_sku` (`sku_id`),
  CONSTRAINT `FK_trans_sku_pricelist_mst_general_currency` FOREIGN KEY (`gen_currency_id`) REFERENCES `mst_general_currency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_trans_sku_pricelist_mst_person_supplier` FOREIGN KEY (`prs_supplier_id`) REFERENCES `mst_person_supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_trans_sku_pricelist_mst_sku` FOREIGN KEY (`sku_id`) REFERENCES `mst_sku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_sku_pricelist`
--

LOCK TABLES `trans_sku_pricelist` WRITE;
/*!40000 ALTER TABLE `trans_sku_pricelist` DISABLE KEYS */;
INSERT INTO `trans_sku_pricelist` VALUES (1,15000.0000,1,NULL,'2025-01-26 03:42:22',NULL,'2025-01-26 03:42:22',NULL,NULL,NULL,'09f3ea9f-2f0b-476c-82f0-fa19cef71e83',1,65,1);
/*!40000 ALTER TABLE `trans_sku_pricelist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vw_app_list_log_pr_approval_dt`
--

DROP TABLE IF EXISTS `vw_app_list_log_pr_approval_dt`;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_log_pr_approval_dt`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_app_list_log_pr_approval_dt` (
  `id` tinyint NOT NULL,
  `trans_pr_id` tinyint NOT NULL,
  `sku_name` tinyint NOT NULL,
  `val_price` tinyint NOT NULL,
  `qty` tinyint NOT NULL,
  `val_subtotal` tinyint NOT NULL,
  `val_discount` tinyint NOT NULL,
  `val_vat` tinyint NOT NULL,
  `val_total` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `flag_status` tinyint NOT NULL,
  `item_status` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_app_list_log_pr_approval_hd`
--

DROP TABLE IF EXISTS `vw_app_list_log_pr_approval_hd`;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_log_pr_approval_hd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_app_list_log_pr_approval_hd` (
  `id` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `flag_status` tinyint NOT NULL,
  `transaction_status` tinyint NOT NULL,
  `created_by` tinyint NOT NULL,
  `created_at` tinyint NOT NULL,
  `trans_date` tinyint NOT NULL,
  `doc_num` tinyint NOT NULL,
  `requested_by` tinyint NOT NULL,
  `requested_at` tinyint NOT NULL,
  `trans_pr_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_app_list_mst_exchangerates`
--

DROP TABLE IF EXISTS `vw_app_list_mst_exchangerates`;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_mst_exchangerates`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_app_list_mst_exchangerates` (
  `id` tinyint NOT NULL,
  `currency` tinyint NOT NULL,
  `currency_prefix` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `valid_from_date` tinyint NOT NULL,
  `valid_to_date` tinyint NOT NULL,
  `val_exchangerates` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_app_list_mst_sku`
--

DROP TABLE IF EXISTS `vw_app_list_mst_sku`;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_mst_sku`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_app_list_mst_sku` (
  `id` tinyint NOT NULL,
  `flag_show` tinyint NOT NULL,
  `sku_id` tinyint NOT NULL,
  `sku_name` tinyint NOT NULL,
  `sku_description` tinyint NOT NULL,
  `sku_business_type` tinyint NOT NULL,
  `sku_img_path` tinyint NOT NULL,
  `sku_packaging` tinyint NOT NULL,
  `sku_process_type` tinyint NOT NULL,
  `sku_type` tinyint NOT NULL,
  `sku_unit` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_app_list_trans_pr_dt`
--

DROP TABLE IF EXISTS `vw_app_list_trans_pr_dt`;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_trans_pr_dt`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_app_list_trans_pr_dt` (
  `id` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `sku_name` tinyint NOT NULL,
  `sku_id` tinyint NOT NULL,
  `val_price` tinyint NOT NULL,
  `qty` tinyint NOT NULL,
  `val_subtotal` tinyint NOT NULL,
  `discount_percentage` tinyint NOT NULL,
  `val_discount` tinyint NOT NULL,
  `vat_percentage` tinyint NOT NULL,
  `val_vat` tinyint NOT NULL,
  `val_total` tinyint NOT NULL,
  `flag_status` tinyint NOT NULL,
  `item_status` tinyint NOT NULL,
  `trans_pr_id` tinyint NOT NULL,
  `created_by` tinyint NOT NULL,
  `created_at` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_app_list_trans_pr_hd`
--

DROP TABLE IF EXISTS `vw_app_list_trans_pr_hd`;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_trans_pr_hd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_app_list_trans_pr_hd` (
  `id` tinyint NOT NULL,
  `trans_date` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `doc_num` tinyint NOT NULL,
  `doc_counter` tinyint NOT NULL,
  `flag_status` tinyint NOT NULL,
  `flag_purpose` tinyint NOT NULL,
  `created_by` tinyint NOT NULL,
  `created_at` tinyint NOT NULL,
  `transaction_status` tinyint NOT NULL,
  `transaction_purpose` tinyint NOT NULL,
  `currency` tinyint NOT NULL,
  `department` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'dbmrp'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_log_pr_approval_update_dt_all` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_log_pr_approval_update_dt_all`(IN trg_trans_pr_id bigint, IN trg_flag_status smallint)
BEGIN

  UPDATE trans_purchase_request_detail

  SET flag_status = trg_flag_status

  WHERE trans_pr_id = trg_trans_pr_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_log_pr_approval_update_dt_single` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_log_pr_approval_update_dt_single`(IN trg_trans_pr_dt_id bigint, IN trg_flag_status smallint)
BEGIN

  UPDATE trans_purchase_request_detail

  SET flag_status = trg_flag_status

  WHERE id = trg_trans_pr_dt_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_log_pr_approval_update_hd` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_log_pr_approval_update_hd`(IN trg_trans_pr_id bigint, IN trg_flag_status smallint, IN trg_description varchar(255), IN trg_created_by varchar(50))
BEGIN

  UPDATE log_purchase_request_approval

  SET flag_active = 0

  WHERE trans_pr_id = trg_trans_pr_id;



  UPDATE trans_purchase_request

  SET flag_status = 2

  WHERE id = trg_trans_pr_id;



  INSERT INTO log_purchase_request_approval (description, flag_status, flag_active, trans_pr_id, created_by, created_at)

    VALUES (trg_description, trg_flag_status, 1, trg_trans_pr_id, trg_created_by, NOW());

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_trans_pr_create_po` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_trans_pr_create_po`(IN trg_trans_pr_id bigint, IN trg_mst_supplier_id bigint, IN trg_mst_terms_dt_id bigint, IN trg_trans_date date, IN trg_valid_from_date date, IN trg_valid_to_date date, IN trg_description varchar(100), IN trg_doc_num varchar(50), IN trg_doc_counter smallint)
BEGIN

  DECLARE trg_trans_po_id bigint;



  #Insert Header

  INSERT INTO trans_purchase_order (trans_date, description, doc_num, doc_counter, flag_status, valid_from_date, valid_to_date, revision, flag_type,

  flag_active, val_exchangerates, created_by, created_at, gen_terms_detail_id, gen_currency_id, gen_department_id,

  prs_supplier_id, purchase_request_id)

    SELECT

      trg_trans_date,

      trg_description,

      trg_doc_num,

      trg_doc_counter,

      tpr.flag_status,

      trg_valid_from_date,

      trg_valid_to_date,

      0,

      tpr.flag_type,

      1,

      tpr.val_exchangerates,

      tpr.created_by,

      NOW(),

      trg_mst_terms_dt_id,

      tpr.gen_currency_id,

      tpr.gen_department_id,

      trg_mst_supplier_id,

      tpr.id

    FROM trans_purchase_request tpr

    WHERE tpr.id = trg_trans_pr_id;



  #Insert Detail

  SET trg_trans_po_id = LAST_INSERT_ID();



  INSERT INTO trans_purchase_order_detail (description, sku_description, sku_prefix, price_d, price_f, qty, subtotal_d, subtotal_f, discount_flag, discount_percentage, discount_d, discount_f,

  afterdiscount_d, afterdiscount_f, vat_flag, vat_percentage, vat_d, vat_f, total_d, total_f, created_by, created_at, updated_by, updated_at, deleted_by,

  deleted_at, manual_id, generated_id, trans_po_id, sku_id)

    SELECT

      tprd.description,

      tprd.sku_description,

      tprd.sku_prefix,

      tprd.price_d,

      tprd.price_f,

      tprd.qty,

      tprd.subtotal_d,

      tprd.subtotal_f,

      tprd.discount_flag,

      tprd.discount_percentage,

      tprd.discount_d,

      tprd.discount_f,

      tprd.afterdiscount_d,

      tprd.afterdiscount_f,

      tprd.vat_flag,

      tprd.vat_percentage,

      tprd.vat_d,

      tprd.vat_f,

      tprd.total_d,

      tprd.total_f,

      tprd.created_by,

      tprd.created_at,

      tprd.updated_by,

      tprd.updated_at,

      tprd.deleted_by,

      tprd.deleted_at,

      tprd.manual_id,

      tprd.generated_id,

      trg_trans_po_id,

      tprd.sku_id

    FROM trans_purchase_request_detail tprd

    WHERE tprd.trans_pr_id = trg_trans_pr_id

    AND tprd.flag_status = 1;



  #Update PR Status

  UPDATE trans_purchase_request

  SET flag_status = 3

  WHERE id = trg_trans_pr_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `vw_app_list_log_pr_approval_dt`
--

/*!50001 DROP TABLE IF EXISTS `vw_app_list_log_pr_approval_dt`*/;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_log_pr_approval_dt`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_app_list_log_pr_approval_dt` AS select `valtpd`.`id` AS `id`,`valtpd`.`trans_pr_id` AS `trans_pr_id`,`valtpd`.`sku_name` AS `sku_name`,`valtpd`.`val_price` AS `val_price`,`valtpd`.`qty` AS `qty`,`valtpd`.`val_subtotal` AS `val_subtotal`,`valtpd`.`val_discount` AS `val_discount`,`valtpd`.`val_vat` AS `val_vat`,`valtpd`.`val_total` AS `val_total`,`valtpd`.`description` AS `description`,`valtpd`.`flag_status` AS `flag_status`,`valtpd`.`item_status` AS `item_status` from (`vw_app_list_trans_pr_dt` `valtpd` join `vw_app_list_log_pr_approval_hd` `vallpah` on(`valtpd`.`trans_pr_id` = `vallpah`.`trans_pr_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_app_list_log_pr_approval_hd`
--

/*!50001 DROP TABLE IF EXISTS `vw_app_list_log_pr_approval_hd`*/;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_log_pr_approval_hd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_app_list_log_pr_approval_hd` AS select `lpra`.`id` AS `id`,`lpra`.`description` AS `description`,`lpra`.`flag_status` AS `flag_status`,case `lpra`.`flag_status` when 1 then 'Unchecked' when 2 then 'Approved' when 3 then 'Canceled' when 3 then 'Suspended' end AS `transaction_status`,`lpra`.`created_by` AS `created_by`,`lpra`.`created_at` AS `created_at`,`valtph`.`trans_date` AS `trans_date`,`valtph`.`doc_num` AS `doc_num`,`valtph`.`created_by` AS `requested_by`,`valtph`.`created_at` AS `requested_at`,`lpra`.`trans_pr_id` AS `trans_pr_id` from (`log_purchase_request_approval` `lpra` join `vw_app_list_trans_pr_hd` `valtph` on(`lpra`.`trans_pr_id` = `valtph`.`id`)) where `lpra`.`flag_active` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_app_list_mst_exchangerates`
--

/*!50001 DROP TABLE IF EXISTS `vw_app_list_mst_exchangerates`*/;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_mst_exchangerates`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_app_list_mst_exchangerates` AS select `mger`.`id` AS `id`,`mgc`.`description` AS `currency`,`mgc`.`prefix` AS `currency_prefix`,`mger`.`description` AS `description`,`mger`.`valid_from_date` AS `valid_from_date`,`mger`.`valid_to_date` AS `valid_to_date`,coalesce(`mger`.`val_exchangerates`,1) AS `val_exchangerates` from (`mst_general_currency` `mgc` left join `mst_general_exchange_rates` `mger` on(`mgc`.`id` = `mger`.`gen_currency_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_app_list_mst_sku`
--

/*!50001 DROP TABLE IF EXISTS `vw_app_list_mst_sku`*/;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_mst_sku`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_app_list_mst_sku` AS select `ms`.`id` AS `id`,`ms`.`flag_show` AS `flag_show`,`ms`.`prefix` AS `sku_id`,`ms`.`description` AS `sku_name`,`msd`.`description` AS `sku_description`,`msbt`.`description` AS `sku_business_type`,`msm`.`image_path` AS `sku_img_path`,`msp`.`description` AS `sku_packaging`,`msp1`.`description` AS `sku_process_type`,`mst`.`description` AS `sku_type`,`msu`.`prefix` AS `sku_unit` from (((((((`mst_sku` `ms` left join `mst_sku_detail` `msd` on(`ms`.`sku_detail_id` = `msd`.`id`)) left join `mst_sku_business_type` `msbt` on(`ms`.`sku_business_type_id` = `msbt`.`id`)) left join `mst_sku_model` `msm` on(`ms`.`sku_model_id` = `msm`.`id`)) left join `mst_sku_packaging` `msp` on(`ms`.`sku_packaging_id` = `msp`.`id`)) left join `mst_sku_process` `msp1` on(`ms`.`sku_process_id` = `msp1`.`id`)) left join `mst_sku_type` `mst` on(`ms`.`sku_type_id` = `mst`.`id`)) left join `mst_sku_unit` `msu` on(`ms`.`sku_unit_id` = `msu`.`id`)) where `ms`.`flag_active` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_app_list_trans_pr_dt`
--

/*!50001 DROP TABLE IF EXISTS `vw_app_list_trans_pr_dt`*/;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_trans_pr_dt`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_app_list_trans_pr_dt` AS select `tprd`.`id` AS `id`,`tprd`.`description` AS `description`,`valms`.`sku_name` AS `sku_name`,`valms`.`sku_id` AS `sku_id`,`tprd`.`price_f` AS `val_price`,`tprd`.`qty` AS `qty`,`tprd`.`subtotal_f` AS `val_subtotal`,`tprd`.`discount_percentage` AS `discount_percentage`,`tprd`.`discount_f` AS `val_discount`,`tprd`.`vat_percentage` AS `vat_percentage`,`tprd`.`vat_f` AS `val_vat`,`tprd`.`total_f` AS `val_total`,`tprd`.`flag_status` AS `flag_status`,case coalesce(`tprd`.`flag_status`,0) when 0 then 'Requested' when 1 then 'Accepted' when 2 then 'Denied' when 3 then 'Hold' else 'Unknown' end AS `item_status`,`tprd`.`trans_pr_id` AS `trans_pr_id`,`tpr`.`created_by` AS `created_by`,`tpr`.`created_at` AS `created_at` from ((`trans_purchase_request_detail` `tprd` join `trans_purchase_request` `tpr` on(`tprd`.`trans_pr_id` = `tpr`.`id`)) left join `vw_app_list_mst_sku` `valms` on(`tprd`.`sku_id` = `valms`.`id`)) where `tpr`.`flag_active` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_app_list_trans_pr_hd`
--

/*!50001 DROP TABLE IF EXISTS `vw_app_list_trans_pr_hd`*/;
/*!50001 DROP VIEW IF EXISTS `vw_app_list_trans_pr_hd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_app_list_trans_pr_hd` AS select `tpr`.`id` AS `id`,`tpr`.`trans_date` AS `trans_date`,`tpr`.`description` AS `description`,`tpr`.`doc_num` AS `doc_num`,`tpr`.`doc_counter` AS `doc_counter`,`tpr`.`flag_status` AS `flag_status`,`tpr`.`flag_purpose` AS `flag_purpose`,`tpr`.`created_by` AS `created_by`,`tpr`.`created_at` AS `created_at`,case `tpr`.`flag_status` when 1 then 'Requested' when 2 then 'Approved' when 3 then 'PO Active' when 4 then 'Canceled' else 'Unknown' end AS `transaction_status`,case `tpr`.`flag_purpose` when 1 then 'Project Development' when 2 then 'Additional' when 3 then 'Recovery' when 4 then 'Early Development' else 'Unknown' end AS `transaction_purpose`,`mgc`.`prefix` AS `currency`,`mgd`.`description` AS `department` from ((`trans_purchase_request` `tpr` left join `mst_general_currency` `mgc` on(`tpr`.`gen_currency_id` = `mgc`.`id`)) left join `mst_general_department` `mgd` on(`tpr`.`gen_department_id` = `mgd`.`id`)) where `tpr`.`flag_active` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-28 20:26:31
