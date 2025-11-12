-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Nov 2025 pada 02.33
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_sku`
--

CREATE TABLE `mst_sku` (
  `id` bigint(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_sku_type` tinyint(1) DEFAULT NULL COMMENT '1 : finished goods\r\n2 : production materials\r\n3 : general items',
  `flag_sku_procurement_type` tinyint(1) DEFAULT NULL COMMENT '1 : in-house\r\n2 : purchase\r\n3 : supply\r\n4 : purchase & in-house',
  `flag_inventory_register` tinyint(1) NOT NULL DEFAULT 1,
  `flag_active` tinyint(1) DEFAULT NULL,
  `flag_show` tinyint(1) DEFAULT NULL,
  `group_tag` varchar(50) DEFAULT NULL,
  `counter` smallint(6) DEFAULT NULL,
  `set_code_counter` smallint(6) DEFAULT NULL,
  `specification_code` varchar(50) DEFAULT NULL,
  `specification_detail` varchar(100) DEFAULT NULL,
  `val_weight` decimal(20,4) DEFAULT NULL,
  `val_area` decimal(20,4) DEFAULT NULL,
  `val_conversion` decimal(20,4) DEFAULT NULL,
  `blob_image` mediumblob DEFAULT NULL,
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
  `sku_procurement_unit_id` bigint(20) DEFAULT NULL,
  `sku_inventory_unit_id` bigint(20) DEFAULT NULL,
  `sku_sales_category_id` bigint(20) DEFAULT NULL,
  `set_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `mst_sku`
--

INSERT INTO `mst_sku` (`id`, `description`, `prefix`, `flag_sku_type`, `flag_sku_procurement_type`, `flag_inventory_register`, `flag_active`, `flag_show`, `group_tag`, `counter`, `set_code_counter`, `specification_code`, `specification_detail`, `val_weight`, `val_area`, `val_conversion`, `blob_image`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `manual_id`, `generated_id`, `sku_type_id`, `sku_unit_id`, `sku_model_id`, `sku_process_id`, `sku_business_type_id`, `sku_packaging_id`, `sku_detail_id`, `sku_procurement_unit_id`, `sku_inventory_unit_id`, `sku_sales_category_id`, `set_code`) VALUES
(1, 'ORNAMENT CTR L 54771-C0600 D14 (PLATING)', NULL, 1, 1, 1, 1, 1, 'SCO-00001', 1, 1, 'AP4DOR-KORN14CR00', NULL, NULL, NULL, 1.0000, NULL, 'administrator', '2025-02-13 10:00:00', NULL, NULL, NULL, NULL, 'PC-00001-FGS', NULL, 5, NULL, 47, NULL, 7, NULL, NULL, 22, 22, 6, 'SCO-00001'),

(10637, 'PART ABCDEF', NULL, 2, 2, 1, 1, 1, NULL, 215, NULL, 'IC-000001-SPC', '-', NULL, NULL, 1.0000, NULL, NULL, '2025-10-14 19:35:55', NULL, '2025-10-14 19:35:55', NULL, NULL, 'MC-000215-SPN', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, 22, 22, 6, NULL);

--
-- Trigger `mst_sku`
--
DELIMITER $$
CREATE TRIGGER `trg_mst_sku_ins` AFTER INSERT ON `mst_sku` FOR EACH ROW BEGIN

  DECLARE trg_sku_id bigint;



  SET trg_sku_id = (SELECT

      NEW.id);



  CALL sp_trans_sku_insert_moq(trg_sku_id);

  CALL sp_trans_sku_insert_mos(trg_sku_id);

END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mst_sku`
--
ALTER TABLE `mst_sku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_mst_sku_mst_sku_business_type` (`sku_business_type_id`),
  ADD KEY `IXFK_mst_sku_mst_sku_detail` (`sku_detail_id`),
  ADD KEY `IXFK_mst_sku_mst_sku_model` (`sku_model_id`),
  ADD KEY `IXFK_mst_sku_mst_sku_packaging` (`sku_packaging_id`),
  ADD KEY `IXFK_mst_sku_mst_sku_process` (`sku_process_id`),
  ADD KEY `IXFK_mst_sku_mst_sku_type` (`sku_type_id`),
  ADD KEY `IXFK_mst_sku_mst_sku_unit` (`sku_unit_id`),
  ADD KEY `FK_mst_sku_sku_inventory_unit_id` (`sku_inventory_unit_id`),
  ADD KEY `FK_mst_sku_sku_procurement_unit_id` (`sku_procurement_unit_id`),
  ADD KEY `FK_mst_sku_sku_sales_category_id` (`sku_sales_category_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mst_sku`
--
ALTER TABLE `mst_sku`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10638;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mst_sku`
--
ALTER TABLE `mst_sku`
  ADD CONSTRAINT `FK_mst_sku_mst_sku_business_type` FOREIGN KEY (`sku_business_type_id`) REFERENCES `mst_sku_business_type` (`id`),
  ADD CONSTRAINT `FK_mst_sku_mst_sku_detail` FOREIGN KEY (`sku_detail_id`) REFERENCES `mst_sku_detail` (`id`),
  ADD CONSTRAINT `FK_mst_sku_mst_sku_model` FOREIGN KEY (`sku_model_id`) REFERENCES `mst_sku_model` (`id`),
  ADD CONSTRAINT `FK_mst_sku_mst_sku_packaging` FOREIGN KEY (`sku_packaging_id`) REFERENCES `mst_sku_packaging` (`id`),
  ADD CONSTRAINT `FK_mst_sku_mst_sku_process` FOREIGN KEY (`sku_process_id`) REFERENCES `mst_sku_process` (`id`),
  ADD CONSTRAINT `FK_mst_sku_mst_sku_type` FOREIGN KEY (`sku_type_id`) REFERENCES `mst_sku_type` (`id`),
  ADD CONSTRAINT `FK_mst_sku_mst_sku_unit` FOREIGN KEY (`sku_unit_id`) REFERENCES `mst_sku_unit` (`id`),
  ADD CONSTRAINT `FK_mst_sku_sku_inventory_unit_id` FOREIGN KEY (`sku_inventory_unit_id`) REFERENCES `mst_sku_unit` (`id`),
  ADD CONSTRAINT `FK_mst_sku_sku_procurement_unit_id` FOREIGN KEY (`sku_procurement_unit_id`) REFERENCES `mst_sku_unit` (`id`),
  ADD CONSTRAINT `FK_mst_sku_sku_sales_category_id` FOREIGN KEY (`sku_sales_category_id`) REFERENCES `mst_sku_sales_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
