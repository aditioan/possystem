-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 07, 2017 at 01:27 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE IF NOT EXISTS `balance` (
  `id_balance` int(11) NOT NULL,
  `id_transaction` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cash_trx` int(11) NOT NULL,
  `cash_total` int(11) NOT NULL,
  `type` enum('modal','penjualan','pembelian','perawatan','retur','gaji','lain-lain') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `action` enum('1','0') NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `balance`:
--

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`id_balance`, `id_transaction`, `cash_trx`, `cash_total`, `type`, `action`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'BAL1486404974', 50000000, 50000000, 'modal', '1', 'Modal Awal', '2017-02-06 18:20:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'BAL1486405527', 5000000, 55000000, 'modal', '1', 'Modal Tambahan', '2017-02-06 18:25:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'BAL1486409565', 100000, 54900000, 'perawatan', '0', 'Perbaikan AC', '2017-02-06 19:33:03', '2017-02-06 19:33:52', '0000-00-00 00:00:00'),
(5, 'IN1486409710', 200000, 54700000, 'pembelian', '0', 'Pembelian barang dengan kode transaksi IN1486409710', '2017-02-06 19:45:26', '2017-02-06 19:49:39', '0000-00-00 00:00:00'),
(6, 'IN1486410397', 100000, 54600000, 'pembelian', '0', 'Pembelian barang dengan kode transaksi IN1486410397', '2017-02-06 19:51:12', '2017-02-06 20:04:24', '2017-02-06 20:04:24'),
(8, 'OUT1486411754', 10000, 54710000, 'penjualan', '1', 'Penjualan barang dengan kode transaksi OUT1486411754', '2017-02-06 20:10:59', '2017-02-06 20:12:30', '2017-02-06 20:12:30'),
(9, 'OUT1486412143', 10000, 54710000, 'penjualan', '1', 'Penjualan barang dengan kode transaksi OUT1486412143', '2017-02-06 20:15:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'RETS1486413559', 4000, 54706000, 'retur', '0', 'Retur penjualan dengan kode transaksi RETS1486413559', '2017-02-06 20:39:25', '2017-02-06 20:40:23', '0000-00-00 00:00:00'),
(12, 'RETP1486413811', 100000, 54806000, 'retur', '1', 'Retur pembelian dengan kode transaksi RETP1486413811', '2017-02-06 20:43:51', '2017-02-06 20:44:13', '2017-02-06 20:44:13'),
(13, 'OUT1486439538', 80000, 54786000, 'retur', '1', 'Penjualan barang dengan kode transaksi OUT1486439538', '2017-02-07 03:52:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'BAL1486448303', 500000, 54286000, 'gaji', '0', 'Gaji 1 karyawan bulan Januari', '2017-02-07 06:18:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `category`:
--

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `category_name`, `category_desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
('KAT1', 'Kipas Angin', 'Kipas Angin', '2016-05-22 16:18:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LAMP', 'Lampu', 'Lampu', '2016-05-25 13:27:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('NAN1', 'Minuman', 'Untuk Diminum Orang', '2017-02-06 14:55:48', '2017-02-06 14:56:01', '2017-02-06 14:56:01'),
('SNACK', 'Snack Ringan', 'Makanan cemilan', '2017-02-03 14:41:20', '2017-02-03 15:01:39', '0000-00-00 00:00:00'),
('TV', 'TV', 'TV', '2016-05-25 13:26:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id_customer` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `customer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `customer_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `customer`:
--

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `customer_name`, `customer_phone`, `customer_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
('CUST0001', 'Erwin', '0812121212', 'Jl Raya Daan Mogot, Apartment Mediterania', '2016-05-22 08:04:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('CUST0002', 'Cyntia', '081212121', 'Cimahi', '2016-05-22 08:22:55', '2017-02-03 14:51:06', '0000-00-00 00:00:00'),
('CUST0003', 'Test Customer 1', '081903103348', 'Tunggul Timur', '2017-02-03 14:30:55', '2017-02-03 14:31:03', '2017-02-03 14:31:03'),
('CUST0004', 'Budi C', '081987645236', 'Bumi', '2017-02-06 14:54:24', '2017-02-06 14:54:43', '2017-02-06 14:54:43'),
('CUSTKASIR', 'Pelanggan Kasir', '', '', '2016-01-16 20:09:58', '2017-02-03 14:28:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id_product` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_category` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `product_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` int(11) NOT NULL DEFAULT '0',
  `minimum_qty` int(11) NOT NULL,
  `product_unit` enum('ea','box','set','rim','dos','roll','pack') COLLATE utf8_unicode_ci NOT NULL,
  `sale_price` int(20) NOT NULL,
  `sale_price_type1` int(20) NOT NULL,
  `sale_price_type2` int(20) NOT NULL,
  `sale_price_type3` int(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `product`:
--   `id_category`
--       `category` -> `id_category`
--

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `product_name`, `id_category`, `product_desc`, `product_qty`, `minimum_qty`, `product_unit`, `sale_price`, `sale_price_type1`, `sale_price_type2`, `sale_price_type3`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1782647903452', 'Wafer Tanggo', 'SNACK', 'Wafer yang mantap...', 25, 5, 'ea', 5000, 4500, 4000, 0, '2017-02-03 15:03:57', '2017-02-03 15:26:34', '2017-02-03 15:26:34'),
('8993430164331', 'Kari Chips', 'SNACK', 'Enak tenan...', 90, 10, 'ea', 20000, 18000, 16000, 15000, '2017-01-15 12:53:11', '2017-02-06 15:54:59', '0000-00-00 00:00:00'),
('8997004000025', 'Tahu Bakso', 'KAT1', 'Titipan', 198, 10, 'ea', 2000, 0, 0, 0, '2017-01-16 21:26:31', '2017-02-06 20:38:46', '0000-00-00 00:00:00'),
('8997009510116', 'Lemon Water', 'SNACK', 'Minuman dingin', 61, 5, 'ea', 6000, 5500, 5000, 0, '2017-02-05 08:43:52', '2017-02-07 06:24:00', '0000-00-00 00:00:00'),
('8997009510117', 'Taro', 'SNACK', 'Cemilan Enak', 75, 20, 'ea', 3000, 2500, 0, 0, '2017-02-06 14:57:38', '2017-02-06 14:58:07', '2017-02-06 14:58:07'),
('MAS10', 'Maspion', 'KAT1', 'Maspion Kipas Baru', 80, 10, 'ea', 120000, 100000, 0, 0, '2016-05-26 14:27:15', '2017-02-06 20:04:24', '0000-00-00 00:00:00'),
('PHIL001', 'Philip Lampu', 'LAMP', 'Philip 12watt', 4, 10, 'ea', 80000, 0, 0, 0, '2016-05-26 16:00:13', '2017-02-07 03:52:32', '0000-00-00 00:00:00'),
('SAM100', 'Samsung TV', 'TV', 'TV 52inc', 74, 10, 'ea', 6200000, 6100000, 6000000, 0, '2016-05-26 15:58:15', '2017-02-06 15:00:49', '0000-00-00 00:00:00'),
('SAM2100', 'Samsung 2100', 'KAT1', 'Samsung Kipas', 12, 10, 'ea', 210000, 200000, 180000, 0, '2016-05-29 14:26:41', '2017-02-06 15:28:37', '0000-00-00 00:00:00'),
('TOS10', 'Toshiba 21', 'TV', 'TV layar datar', 87, 10, 'ea', 1600000, 1500000, 0, 0, '2016-05-26 14:28:21', '2017-02-05 14:20:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_restock`
--

CREATE TABLE IF NOT EXISTS `product_restock` (
  `id_restock` int(11) NOT NULL,
  `id_product` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `stock_qty` int(5) NOT NULL,
  `qty_before` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `product_restock`:
--   `id_product`
--       `product` -> `id_product`
--

--
-- Dumping data for table `product_restock`
--

INSERT INTO `product_restock` (`id_restock`, `id_product`, `stock_qty`, `qty_before`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '8997004000025', 10, 10, '2017-02-02 16:54:53', '2017-02-03 15:19:11', '2017-02-03 15:19:11'),
(5, '8997004000025', 5, 20, '2017-02-02 16:55:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'SAM100', 3, 72, '2017-02-02 18:10:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '8997004000025', 12, 8, '2017-02-03 15:24:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '8997004000025', 15, 5, '2017-02-03 15:26:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '8997009510117', 5, 70, '2017-02-06 14:57:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_data`
--

CREATE TABLE IF NOT EXISTS `purchase_data` (
  `id_pdata` int(11) NOT NULL,
  `id_ptransaction` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_product` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `data_qty` int(4) NOT NULL,
  `price_item` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `purchase_data`:
--   `id_product`
--       `product` -> `id_product`
--   `id_ptransaction`
--       `purchase_transaction` -> `id_ptransaction`
--

--
-- Dumping data for table `purchase_data`
--

INSERT INTO `purchase_data` (`id_pdata`, `id_ptransaction`, `id_product`, `data_qty`, `price_item`, `subtotal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(82, 'IN1486378894', '8997009510116', 10, 5000, 50000, '2017-02-06 11:01:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 'IN1486378912', '8993430164331', 5, 10000, 50000, '2017-02-06 11:02:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 'IN1486378912', '8997009510116', 5, 5000, 25000, '2017-02-06 11:02:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 'IN1486393134', 'PHIL001', 2, 50000, 100000, '2017-02-06 14:59:29', '2017-02-06 15:00:49', '2017-02-06 15:00:49'),
(86, 'IN1486393134', 'SAM100', 1, 500000, 500000, '2017-02-06 14:59:29', '2017-02-06 15:00:49', '2017-02-06 15:00:49'),
(87, 'IN1486409710', '8997009510116', 40, 5000, 200000, '2017-02-06 19:45:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 'IN1486410397', 'MAS10', 1, 100000, 100000, '2017-02-06 19:51:12', '2017-02-06 20:04:24', '2017-02-06 20:04:24'),
(89, 'IN1486448450', '8997009510116', 12, 0, 0, '2017-02-07 06:22:54', '2017-02-07 06:24:00', '2017-02-07 06:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_retur`
--

CREATE TABLE IF NOT EXISTS `purchase_retur` (
  `id_pretur` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_ptransaction` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_item` int(11) NOT NULL,
  `is_return` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `return_by` enum('1','0') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Retur by 1 = barang, 0 = uang',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `purchase_retur`:
--   `id_ptransaction`
--       `purchase_transaction` -> `id_ptransaction`
--

--
-- Dumping data for table `purchase_retur`
--

INSERT INTO `purchase_retur` (`id_pretur`, `id_ptransaction`, `total_price`, `total_item`, `is_return`, `return_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('RETP1486384611', 'IN1486378912', 75000, 10, '1', '0', '2017-02-06 12:36:56', '2017-02-06 15:54:59', '2017-02-06 15:54:59'),
('RETP1486384716', 'IN1486378912', 75000, 10, '1', '0', '2017-02-06 12:38:47', '2017-02-06 12:53:49', '2017-02-06 12:53:49'),
('RETP1486385140', 'IN1486378894', 50000, 10, '1', '1', '2017-02-06 12:45:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RETP1486396609', 'IN1486378912', 75000, 10, '1', '1', '2017-02-06 15:57:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RETP1486413811', 'IN1486409710', 100000, 20, '1', '0', '2017-02-06 20:43:51', '2017-02-06 20:44:13', '2017-02-06 20:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_retur_data`
--

CREATE TABLE IF NOT EXISTS `purchase_retur_data` (
  `id_prdata` int(11) NOT NULL,
  `id_pretur` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_product` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `data_qty` int(4) NOT NULL,
  `price_item` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `purchase_retur_data`:
--   `id_pretur`
--       `purchase_retur` -> `id_pretur`
--

--
-- Dumping data for table `purchase_retur_data`
--

INSERT INTO `purchase_retur_data` (`id_prdata`, `id_pretur`, `id_product`, `data_qty`, `price_item`, `subtotal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'RETP1486384611', '8993430164331', 5, 10000, 50000, '2017-02-06 12:36:56', '2017-02-06 15:54:59', '2017-02-06 15:54:59'),
(5, 'RETP1486384611', '8997009510116', 5, 5000, 25000, '2017-02-06 12:36:56', '2017-02-06 15:54:59', '2017-02-06 15:54:59'),
(6, 'RETP1486384716', '8993430164331', 5, 10000, 50000, '2017-02-06 12:38:47', '2017-02-06 12:53:49', '2017-02-06 12:53:49'),
(7, 'RETP1486384716', '8997009510116', 5, 5000, 25000, '2017-02-06 12:38:47', '2017-02-06 12:53:49', '2017-02-06 12:53:49'),
(10, 'RETP1486385140', '8997009510116', 10, 5000, 50000, '2017-02-06 12:45:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'RETP1486396609', '8993430164331', 5, 10000, 50000, '2017-02-06 15:57:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'RETP1486396609', '8997009510116', 5, 5000, 25000, '2017-02-06 15:57:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'RETP1486413811', '8997009510116', 20, 5000, 100000, '2017-02-06 20:43:51', '2017-02-06 20:44:13', '2017-02-06 20:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_transaction`
--

CREATE TABLE IF NOT EXISTS `purchase_transaction` (
  `id_ptransaction` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `total_price` int(20) NOT NULL,
  `total_item` int(11) NOT NULL,
  `id_supplier` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `purchase_transaction`:
--   `id_supplier`
--       `supplier` -> `id_supplier`
--

--
-- Dumping data for table `purchase_transaction`
--

INSERT INTO `purchase_transaction` (`id_ptransaction`, `total_price`, `total_item`, `id_supplier`, `created_at`, `updated_at`, `deleted_at`) VALUES
('IN1486378894', 50000, 10, 'SUP003', '2017-02-06 11:01:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('IN1486378912', 75000, 10, 'SUP005', '2017-02-06 11:02:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('IN1486393134', 600000, 3, 'SUP004', '2017-02-06 14:59:29', '2017-02-06 15:00:49', '2017-02-06 15:00:49'),
('IN1486409710', 200000, 40, 'SUP004', '2017-02-06 19:45:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('IN1486410397', 100000, 1, 'SUP003', '2017-02-06 19:51:12', '2017-02-06 20:04:24', '2017-02-06 20:04:24'),
('IN1486448450', 0, 12, 'SUP003', '2017-02-07 06:22:53', '2017-02-07 06:24:00', '2017-02-07 06:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_data`
--

CREATE TABLE IF NOT EXISTS `sales_data` (
  `id_sdata` int(11) NOT NULL,
  `id_stransaction` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_product` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `data_qty` int(4) NOT NULL,
  `price_item` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_At` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `sales_data`:
--   `id_product`
--       `product` -> `id_product`
--   `id_stransaction`
--       `sales_transaction` -> `id_stransaction`
--

--
-- Dumping data for table `sales_data`
--

INSERT INTO `sales_data` (`id_sdata`, `id_stransaction`, `id_product`, `data_qty`, `price_item`, `subtotal`, `created_At`, `updated_at`, `deleted_at`) VALUES
(1, 'OUT1486282560', '8997004000025', 5, 2000, 10000, '2017-02-05 08:19:50', '2017-02-05 14:20:50', '2017-02-05 14:20:50'),
(2, 'OUT1486282560', '8993430164331', 1, 20000, 20000, '2017-02-05 08:19:50', '2017-02-05 14:20:50', '2017-02-05 14:20:50'),
(4, 'OUT1486284889', '8993430164331', 2, 20000, 40000, '2017-02-05 08:54:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'OUT1486284889', 'MAS10', 1, 120000, 120000, '2017-02-05 08:54:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'OUT1486284968', '8993430164331', 2, 20000, 40000, '2017-02-05 08:56:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'OUT1486285001', '8993430164331', 1, 20000, 20000, '2017-02-05 08:56:41', '2017-02-05 14:19:05', '2017-02-05 14:19:05'),
(9, 'OUT1486285094', '8993430164331', 2, 20000, 40000, '2017-02-05 08:58:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'OUT1486304542', 'SAM2100', 1, 210000, 210000, '2017-02-05 14:22:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'OUT1486307299', '8997004000025', 1, 2000, 2000, '2017-02-05 15:09:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'OUT1486307299', '8993430164331', 3, 20000, 60000, '2017-02-05 15:09:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'OUT1486373222', '8997004000025', 2, 2000, 4000, '2017-02-06 09:29:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'OUT1486373222', '8997009510116', 1, 6000, 6000, '2017-02-06 09:29:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'OUT1486387836', '8997009510116', 1, 6000, 6000, '2017-02-06 13:30:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'OUT1486393333', '8993430164331', 1, 20000, 20000, '2017-02-06 15:02:35', '2017-02-06 15:03:03', '2017-02-06 15:03:03'),
(17, 'OUT1486393395', '8993430164331', 1, 20000, 20000, '2017-02-06 15:03:59', '2017-02-06 15:05:47', '2017-02-06 15:05:47'),
(20, 'OUT1486411754', '8997004000025', 2, 2000, 4000, '2017-02-06 20:10:59', '2017-02-06 20:12:30', '2017-02-06 20:12:30'),
(21, 'OUT1486411754', '8997009510116', 1, 6000, 6000, '2017-02-06 20:10:59', '2017-02-06 20:12:30', '2017-02-06 20:12:30'),
(22, 'OUT1486412143', '8997009510116', 1, 6000, 6000, '2017-02-06 20:15:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'OUT1486412143', '8997004000025', 2, 2000, 4000, '2017-02-06 20:15:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'OUT1486439538', 'PHIL001', 1, 80000, 80000, '2017-02-07 03:52:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_retur`
--

CREATE TABLE IF NOT EXISTS `sales_retur` (
  `id_sretur` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_stransaction` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_item` int(11) NOT NULL,
  `is_return` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `return_by` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `sales_retur`:
--   `id_stransaction`
--       `sales_transaction` -> `id_stransaction`
--

--
-- Dumping data for table `sales_retur`
--

INSERT INTO `sales_retur` (`id_sretur`, `id_stransaction`, `total_price`, `total_item`, `is_return`, `return_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('RETS1486390871', 'OUT1486387836', 6000, 1, '1', '1', '2017-02-06 14:21:13', '2017-02-06 15:52:21', '2017-02-06 15:52:21'),
('RETS1486391680', 'OUT1486373222', 4000, 2, '1', '1', '2017-02-06 14:35:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RETS1486391732', 'OUT1486307299', 62000, 4, '1', '1', '2017-02-06 14:35:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RETS1486394037', 'OUT1486387836', 6000, 1, '1', '0', '2017-02-06 15:15:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RETS1486394837', 'OUT1486304542', 210000, 1, '1', '1', '2017-02-06 15:27:36', '2017-02-06 15:27:51', '2017-02-06 15:27:51'),
('RETS1486394911', 'OUT1486304542', 210000, 1, '1', '1', '2017-02-06 15:28:37', '2017-02-06 15:30:02', '2017-02-06 15:30:02'),
('RETS1486413559', 'OUT1486412143', 4000, 2, '1', '0', '2017-02-06 20:39:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_retur_data`
--

CREATE TABLE IF NOT EXISTS `sales_retur_data` (
  `id_srdata` int(11) NOT NULL,
  `id_sretur` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_product` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `data_qty` int(4) NOT NULL,
  `price_item` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_At` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `sales_retur_data`:
--   `id_sretur`
--       `sales_retur` -> `id_sretur`
--

--
-- Dumping data for table `sales_retur_data`
--

INSERT INTO `sales_retur_data` (`id_srdata`, `id_sretur`, `id_product`, `data_qty`, `price_item`, `subtotal`, `created_At`, `updated_at`, `deleted_at`) VALUES
(1, 'RETS1486390871', '8997009510116', 1, 6000, 6000, '2017-02-06 14:21:13', '2017-02-06 15:52:21', '2017-02-06 15:52:21'),
(2, 'RETS1486391680', '8997004000025', 2, 2000, 4000, '2017-02-06 14:35:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'RETS1486391732', '8997004000025', 1, 2000, 2000, '2017-02-06 14:35:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'RETS1486391732', '8993430164331', 3, 20000, 60000, '2017-02-06 14:35:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'RETS1486394037', '8997009510116', 1, 6000, 6000, '2017-02-06 15:15:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'RETS1486394837', 'SAM2100', 1, 210000, 210000, '2017-02-06 15:27:37', '2017-02-06 15:27:51', '2017-02-06 15:27:51'),
(7, 'RETS1486394911', 'SAM2100', 1, 210000, 210000, '2017-02-06 15:28:37', '2017-02-06 15:30:02', '2017-02-06 15:30:02'),
(12, 'RETS1486413559', '8997004000025', 2, 2000, 4000, '2017-02-06 20:39:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_transaction`
--

CREATE TABLE IF NOT EXISTS `sales_transaction` (
  `id_stransaction` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_customer` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `is_cash` tinyint(1) NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_item` int(11) NOT NULL,
  `pay_deadline_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `sales_transaction`:
--   `id_customer`
--       `customer` -> `id_customer`
--

--
-- Dumping data for table `sales_transaction`
--

INSERT INTO `sales_transaction` (`id_stransaction`, `id_customer`, `is_cash`, `total_price`, `total_item`, `pay_deadline_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
('OUT1486282560', 'CUSTKASIR', 1, 30000, 6, '2017-02-05', '2017-02-05 08:19:50', '2017-02-05 14:20:50', '2017-02-05 14:20:50'),
('OUT1486284889', 'CUSTKASIR', 1, 160000, 3, '2017-02-05', '2017-02-05 08:54:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OUT1486284968', 'CUSTKASIR', 1, 40000, 2, '2017-02-05', '2017-02-05 08:56:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OUT1486285001', 'CUSTKASIR', 1, 20000, 1, '2017-02-05', '2017-02-05 08:56:41', '2017-02-05 14:19:05', '2017-02-05 14:19:05'),
('OUT1486285094', 'CUSTKASIR', 1, 40000, 2, '2017-02-05', '2017-02-05 08:58:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OUT1486304542', 'CUST0001', 1, 210000, 1, '2017-03-07', '2017-02-05 14:22:40', '2017-02-05 14:32:18', '0000-00-00 00:00:00'),
('OUT1486307299', 'CUSTKASIR', 1, 62000, 4, '2017-02-05', '2017-02-05 15:09:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OUT1486373222', 'CUSTKASIR', 1, 10000, 3, '2017-02-06', '2017-02-06 09:29:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OUT1486387836', 'CUSTKASIR', 1, 6000, 1, '2017-02-06', '2017-02-06 13:30:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OUT1486393333', 'CUSTKASIR', 1, 20000, 1, '2017-02-06', '2017-02-06 15:02:35', '2017-02-06 15:03:03', '2017-02-06 15:03:03'),
('OUT1486393395', 'CUST0001', 1, 20000, 1, '2017-02-06', '2017-02-06 15:03:59', '2017-02-06 15:05:47', '2017-02-06 15:05:47'),
('OUT1486411754', 'CUSTKASIR', 1, 10000, 3, '2017-02-07', '2017-02-06 20:10:59', '2017-02-06 20:12:30', '2017-02-06 20:12:30'),
('OUT1486412143', 'CUSTKASIR', 1, 10000, 3, '2017-02-07', '2017-02-06 20:15:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OUT1486439538', 'CUSTKASIR', 1, 80000, 1, '2017-02-07', '2017-02-07 03:52:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_address` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `supplier`:
--

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `supplier_name`, `supplier_phone`, `supplier_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
('SUP001', 'Alan New', '081751261251', 'Kalibata City', '2016-05-20 17:00:00', '2017-02-03 14:11:52', '2017-02-03 14:11:52'),
('SUP002', 'Made', '', 'Made', '2016-05-25 14:45:17', '2017-02-03 14:07:14', '2017-02-03 14:07:14'),
('SUP003', 'Tahu Bakso', '08198378493988', 'Hongkong', '2017-01-16 21:26:00', '2017-02-03 14:11:39', '0000-00-00 00:00:00'),
('SUP004', 'Test Supplier', '08198378493989', 'Tunggul Timur', '2017-02-03 13:55:41', '2017-02-03 14:07:04', '0000-00-00 00:00:00'),
('SUP005', 'Test Supplier 2', '08198378493970', 'Semanu', '2017-02-03 14:08:06', '2017-02-03 14:08:28', '0000-00-00 00:00:00'),
('SUP006', 'Test Supplier 3', '08198378493922', 'Turi', '2017-02-06 14:53:19', '2017-02-06 14:53:36', '2017-02-06 14:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `photo_profile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `user`:
--

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `photo_profile`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'adminfe', 'aditioan.uny@gmail.com', 'fakultas_ekonomi.png', '8c67c94b6d50d8db0a849e0be902a744', '2017-02-03 01:40:51', '2017-02-03 13:50:24', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id_balance`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `id` (`id_category`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD UNIQUE KEY `id` (`id_customer`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD UNIQUE KEY `id` (`id_product`),
  ADD KEY `id_2` (`id_product`),
  ADD KEY `category_id` (`id_category`);

--
-- Indexes for table `product_restock`
--
ALTER TABLE `product_restock`
  ADD PRIMARY KEY (`id_restock`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `purchase_data`
--
ALTER TABLE `purchase_data`
  ADD PRIMARY KEY (`id_pdata`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_ptransaction` (`id_ptransaction`);

--
-- Indexes for table `purchase_retur`
--
ALTER TABLE `purchase_retur`
  ADD PRIMARY KEY (`id_pretur`),
  ADD UNIQUE KEY `id` (`id_pretur`),
  ADD KEY `id_2` (`id_pretur`),
  ADD KEY `id_ptransaction` (`id_ptransaction`);

--
-- Indexes for table `purchase_retur_data`
--
ALTER TABLE `purchase_retur_data`
  ADD PRIMARY KEY (`id_prdata`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_ptransaction` (`id_pretur`);

--
-- Indexes for table `purchase_transaction`
--
ALTER TABLE `purchase_transaction`
  ADD PRIMARY KEY (`id_ptransaction`),
  ADD UNIQUE KEY `id` (`id_ptransaction`),
  ADD KEY `id_2` (`id_ptransaction`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `sales_data`
--
ALTER TABLE `sales_data`
  ADD PRIMARY KEY (`id_sdata`),
  ADD KEY `id_stransaction` (`id_stransaction`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `sales_retur`
--
ALTER TABLE `sales_retur`
  ADD PRIMARY KEY (`id_sretur`),
  ADD UNIQUE KEY `id` (`id_sretur`),
  ADD KEY `id_stransaction` (`id_stransaction`);

--
-- Indexes for table `sales_retur_data`
--
ALTER TABLE `sales_retur_data`
  ADD PRIMARY KEY (`id_srdata`),
  ADD KEY `id_stransaction` (`id_sretur`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `sales_transaction`
--
ALTER TABLE `sales_transaction`
  ADD PRIMARY KEY (`id_stransaction`),
  ADD UNIQUE KEY `id` (`id_stransaction`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`),
  ADD UNIQUE KEY `id` (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id_balance` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `product_restock`
--
ALTER TABLE `product_restock`
  MODIFY `id_restock` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `purchase_data`
--
ALTER TABLE `purchase_data`
  MODIFY `id_pdata` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `purchase_retur_data`
--
ALTER TABLE `purchase_retur_data`
  MODIFY `id_prdata` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `sales_data`
--
ALTER TABLE `sales_data`
  MODIFY `id_sdata` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `sales_retur_data`
--
ALTER TABLE `sales_retur_data`
  MODIFY `id_srdata` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_restock`
--
ALTER TABLE `product_restock`
  ADD CONSTRAINT `product_restock_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_data`
--
ALTER TABLE `purchase_data`
  ADD CONSTRAINT `purchase_data_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_data_ibfk_2` FOREIGN KEY (`id_ptransaction`) REFERENCES `purchase_transaction` (`id_ptransaction`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_retur`
--
ALTER TABLE `purchase_retur`
  ADD CONSTRAINT `purchase_retur_ibfk_1` FOREIGN KEY (`id_ptransaction`) REFERENCES `purchase_transaction` (`id_ptransaction`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_retur_data`
--
ALTER TABLE `purchase_retur_data`
  ADD CONSTRAINT `purchase_retur_data_ibfk_1` FOREIGN KEY (`id_pretur`) REFERENCES `purchase_retur` (`id_pretur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_transaction`
--
ALTER TABLE `purchase_transaction`
  ADD CONSTRAINT `purchase_transaction_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_data`
--
ALTER TABLE `sales_data`
  ADD CONSTRAINT `sales_data_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_data_ibfk_2` FOREIGN KEY (`id_stransaction`) REFERENCES `sales_transaction` (`id_stransaction`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_retur`
--
ALTER TABLE `sales_retur`
  ADD CONSTRAINT `sales_retur_ibfk_1` FOREIGN KEY (`id_stransaction`) REFERENCES `sales_transaction` (`id_stransaction`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_retur_data`
--
ALTER TABLE `sales_retur_data`
  ADD CONSTRAINT `sales_retur_data_ibfk_1` FOREIGN KEY (`id_sretur`) REFERENCES `sales_retur` (`id_sretur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_transaction`
--
ALTER TABLE `sales_transaction`
  ADD CONSTRAINT `sales_transaction_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
