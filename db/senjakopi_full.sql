-- ===========================================================
-- FULL DATABASE: senjakopi
-- Sistem Informasi Inventory Gudang Kopi — Kedai Kopi Seroja
-- Generated: 2026-03-25
-- ===========================================================
-- CATATAN: Import file ini di phpMyAdmin untuk setup database
-- dari awal. Database lama akan di-DROP jika sudah ada.
-- ===========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- -----------------------------------------------------------
-- Buat database
-- -----------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `senjakopi`;
USE `senjakopi`;

-- ===========================================================
-- TABEL: user_petugas (User & Login)
-- ===========================================================
CREATE TABLE `user_petugas` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(35) NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto_user` varchar(100) NOT NULL DEFAULT '',
  `level` enum('store','owner') NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_petugas` (`id_user`, `nama`, `jabatan`, `phone`, `email`, `password`, `foto_user`, `level`) VALUES
(1, 'Silvia Wastuti', 'Manager Stores', '087516756155', 'store@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'female-2.png', 'store'),
(2, 'Owner Senjakopi', 'Owner', '081234567890', 'owner@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', 'owner');
-- Password default: 123

-- ===========================================================
-- TABEL: kategori (Kategori Bahan Baku)
-- ===========================================================
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(20) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Minuman'),
(2, 'Tepung'),
(3, 'Bahan Pokok');

-- ===========================================================
-- TABEL: barang (Bahan Baku / Raw Materials)
-- ===========================================================
CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NOT NULL,
  `kode_barang` varchar(5) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `stock_toko` varchar(20) NOT NULL DEFAULT '0',
  `stock_gudang` varchar(20) NOT NULL DEFAULT '0',
  `satuan` enum('Liter','Kilogram','Gram') NOT NULL,
  PRIMARY KEY (`id_barang`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `barang` (`id_barang`, `id_kategori`, `kode_barang`, `nama_barang`, `stock_toko`, `stock_gudang`, `satuan`) VALUES
(1, 3, 'BR001', 'Biji Kopi Arabika', '500', '200', 'Gram'),
(2, 1, 'BR002', 'Susu Segar', '50', '20', 'Liter'),
(3, 1, 'BR003', 'Air Mineral', '100', '50', 'Liter'),
(4, 3, 'BR004', 'Gula Pasir', '300', '100', 'Gram'),
(5, 2, 'BR005', 'Tepung Terigu', '60', '70', 'Kilogram'),
(6, 3, 'BR006', 'Coklat Bubuk', '200', '80', 'Gram');



-- ===========================================================
-- TABEL: stok_masuk (Stok Masuk Harian)
-- ===========================================================
CREATE TABLE `stok_masuk` (
  `id_stokmasuk` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_stokmasuk`),
  KEY `id_barang` (`id_barang`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `stok_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===========================================================
-- TABEL: produk (Menu Makanan & Minuman)
-- ===========================================================
CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(100) NOT NULL,
  `kategori_produk` enum('Makanan','Minuman') NOT NULL,
  `harga` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('Tersedia','Habis') NOT NULL DEFAULT 'Tersedia',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `produk` (`nama_produk`, `kategori_produk`, `harga`, `quantity`, `deskripsi`, `status`) VALUES
('Espresso', 'Minuman', 15000, 50, 'Kopi espresso shot dengan biji kopi pilihan', 'Tersedia'),
('Americano', 'Minuman', 18000, 50, 'Espresso dengan tambahan air panas', 'Tersedia'),
('Cappuccino', 'Minuman', 22000, 50, 'Espresso dengan susu dan busa lembut', 'Tersedia'),
('Caffe Latte', 'Minuman', 22000, 50, 'Espresso dengan susu steamed', 'Tersedia'),
('Matcha Latte', 'Minuman', 25000, 50, 'Teh matcha Jepang dengan susu', 'Tersedia'),
('Es Teh Manis', 'Minuman', 8000, 50, 'Teh manis segar dengan es batu', 'Tersedia'),
('Nasi Goreng Spesial', 'Makanan', 25000, 50, 'Nasi goreng dengan telur, ayam, dan sayuran', 'Tersedia'),
('Roti Bakar Coklat', 'Makanan', 15000, 50, 'Roti bakar dengan selai coklat premium', 'Tersedia'),
('Pisang Goreng', 'Makanan', 12000, 50, 'Pisang goreng crispy dengan topping keju/coklat', 'Tersedia'),
('Kentang Goreng', 'Makanan', 18000, 50, 'French fries crispy dengan saus sambal dan mayo', 'Tersedia');

-- ===========================================================
-- TABEL: resep_produk (Bill of Materials / Resep Produk)
-- Menghubungkan produk dengan bahan baku (barang)
-- ===========================================================
CREATE TABLE `resep_produk` (
  `id_resep` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_pakai` decimal(10,2) NOT NULL COMMENT 'Jumlah bahan baku per 1 produk (sesuai satuan barang)',
  PRIMARY KEY (`id_resep`),
  UNIQUE KEY `unique_produk_barang` (`id_produk`, `id_barang`),
  KEY `id_produk` (`id_produk`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `resep_produk_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE,
  CONSTRAINT `resep_produk_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contoh resep: Cappuccino = 20g kopi + 0.3L susu + 0.2L air
INSERT INTO `resep_produk` (`id_produk`, `id_barang`, `jumlah_pakai`) VALUES
(3, 1, 20.00),   -- Cappuccino → Biji Kopi Arabika 20 gram
(3, 2, 0.30),    -- Cappuccino → Susu Segar 0.3 liter
(3, 3, 0.20),    -- Cappuccino → Air Mineral 0.2 liter
(1, 1, 18.00),   -- Espresso → Biji Kopi Arabika 18 gram
(1, 3, 0.03),    -- Espresso → Air Mineral 0.03 liter
(2, 1, 18.00),   -- Americano → Biji Kopi Arabika 18 gram
(2, 3, 0.25),    -- Americano → Air Mineral 0.25 liter
(4, 1, 18.00),   -- Caffe Latte → Biji Kopi Arabika 18 gram
(4, 2, 0.35),    -- Caffe Latte → Susu Segar 0.35 liter
(4, 3, 0.05);    -- Caffe Latte → Air Mineral 0.05 liter

-- ===========================================================
-- TABEL: penjualan (Header Transaksi Penjualan)
-- ===========================================================
CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `total_pendapatan` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_penjualan`),
  KEY `id_user` (`id_user`),
  KEY `tgl_penjualan` (`tgl_penjualan`),
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_petugas` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===========================================================
-- TABEL: detail_penjualan (Item per Transaksi)
-- ===========================================================
CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_penjualan` (`id_penjualan`),
  KEY `id_produk` (`id_produk`),
  CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE,
  CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
