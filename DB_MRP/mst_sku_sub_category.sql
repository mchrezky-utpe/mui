-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Nov 2025 pada 11.00
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
-- Struktur dari tabel `mst_sku_sub_category`
--

CREATE TABLE `mst_sku_sub_category` (
  `id` bigint(20) NOT NULL,
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
  `sku_category_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=1260 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `mst_sku_sub_category`
--

INSERT INTO `mst_sku_sub_category` (`id`, `description`, `prefix`, `flag_active`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `manual_id`, `generated_id`, `sku_category_id`) VALUES
(1, 'GENERAL', 'GEN', 1, 'administrator', '2025-02-09 14:26:52', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'NON RETURNABLE PACKAGING', 'NRP', 1, 'administrator', '2025-02-09 14:27:14', NULL, NULL, NULL, NULL, NULL, NULL, 2),
(13, 'WIP', 'WIP', 1, 'administrator', '2025-02-09 14:30:18', NULL, NULL, NULL, NULL, NULL, NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mst_sku_sub_category`
--
ALTER TABLE `mst_sku_sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mst_sku_sub_category_sku_category_id` (`sku_category_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mst_sku_sub_category`
--
ALTER TABLE `mst_sku_sub_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mst_sku_sub_category`
--
ALTER TABLE `mst_sku_sub_category`
  ADD CONSTRAINT `FK_mst_sku_sub_category_sku_category_id` FOREIGN KEY (`sku_category_id`) REFERENCES `mst_sku_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
