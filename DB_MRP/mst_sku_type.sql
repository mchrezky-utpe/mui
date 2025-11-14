-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Nov 2025 pada 10.59
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
-- Struktur dari tabel `mst_sku_type`
--

CREATE TABLE `mst_sku_type` (
  `id` bigint(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `flag_active` tinyint(1) DEFAULT NULL,
  `group_tag` varchar(50) DEFAULT NULL,
  `flag_trans_type` tinyint(1) DEFAULT NULL COMMENT '1 : sell\r\n2 : buy',
  `flag_primary` tinyint(1) DEFAULT NULL COMMENT '1 : yes',
  `flag_checking` tinyint(1) DEFAULT NULL COMMENT '1 : yes\r\n',
  `flag_checking_result` tinyint(1) DEFAULT NULL COMMENT '1 : good\r\n2 : not good\r\n3 : return\r\n4 : unchecked',
  `flag_bom` tinyint(1) DEFAULT NULL COMMENT '1 : yes',
  `flag_allowance` tinyint(1) DEFAULT NULL COMMENT '1 : fixed\r\n2 : customized',
  `val_allowance` decimal(20,4) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `manual_id` varchar(50) DEFAULT NULL,
  `generated_id` varchar(64) DEFAULT NULL,
  `sku_sub_category_id` bigint(20) DEFAULT NULL,
  `sku_category_id` bigint(20) DEFAULT NULL,
  `sku_classification_id` bigint(20) DEFAULT NULL,
  `counter` smallint(6) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `mst_sku_type`
--

INSERT INTO `mst_sku_type` (`id`, `description`, `prefix`, `flag_active`, `group_tag`, `flag_trans_type`, `flag_primary`, `flag_checking`, `flag_checking_result`, `flag_bom`, `flag_allowance`, `val_allowance`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `manual_id`, `generated_id`, `sku_sub_category_id`, `sku_category_id`, `sku_classification_id`, `counter`) VALUES
(5, 'FINISHED GOODS', 'FGS', 1, '1', 0, 1, 0, 1, 0, 0, 0.0000, 'administrator', '2025-02-09 10:00:00', NULL, NULL, NULL, NULL, 'ITC-001', NULL, 5, NULL, 3, NULL),
(6, 'WIP UNCHECKED', 'WPX', 1, '2', 0, 0, 1, 4, 0, 0, 0.0000, 'administrator', '2025-02-09 10:00:00', NULL, NULL, NULL, NULL, 'ITC-002', NULL, 13, NULL, 7, NULL),
(86, 'ADDITIONAL MATERIAL', 'PAA', 1, '48', 0, 1, 0, 0, 1, 2, 0.0000, 'administrator', '2025-02-09 10:00:00', NULL, NULL, NULL, NULL, 'ITC-082', NULL, 6, NULL, 6, NULL),
(87, 'test type', 'exe', 1, 'test group', 1, 1, 1, 0, 1, 1, 1.0000, NULL, '2025-08-24 00:37:39', NULL, '2025-08-24 00:37:39', NULL, NULL, 'ITC-001', '08e628cb-84a1-4665-bf77-fb7282868d36', 1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mst_sku_type`
--
ALTER TABLE `mst_sku_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mst_sku_type_sku_classification_id` (`sku_classification_id`),
  ADD KEY `FK_mst_sku_type_sku_sub_category_id` (`sku_sub_category_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mst_sku_type`
--
ALTER TABLE `mst_sku_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mst_sku_type`
--
ALTER TABLE `mst_sku_type`
  ADD CONSTRAINT `FK_mst_sku_type_sku_classification_id` FOREIGN KEY (`sku_classification_id`) REFERENCES `mst_sku_classification` (`id`),
  ADD CONSTRAINT `FK_mst_sku_type_sku_sub_category_id` FOREIGN KEY (`sku_sub_category_id`) REFERENCES `mst_sku_sub_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
