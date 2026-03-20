-- --------------------------------------------------------
-- Migration: Tambah quantity di produk + Tabel Penjualan
-- Jalankan SQL ini di phpMyAdmin pada database serojakopi
-- --------------------------------------------------------

-- Tambah kolom quantity di tabel produk
ALTER TABLE `produk` ADD COLUMN `quantity` int(11) NOT NULL DEFAULT 0 AFTER `harga`;

-- Update quantity default untuk data yang sudah ada
UPDATE `produk` SET `quantity` = 50 WHERE `quantity` = 0;

-- --------------------------------------------------------
-- Tabel penjualan (header per transaksi)
-- --------------------------------------------------------

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

-- --------------------------------------------------------
-- Tabel detail_penjualan (item per transaksi)
-- --------------------------------------------------------

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
