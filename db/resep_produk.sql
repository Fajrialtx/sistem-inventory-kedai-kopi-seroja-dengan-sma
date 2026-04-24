-- --------------------------------------------------------
-- Migration: Tabel Resep Produk (Bill of Materials)
-- Menghubungkan produk dengan bahan baku (barang)
-- Jalankan SQL ini di phpMyAdmin pada database serojakopi
-- --------------------------------------------------------

CREATE TABLE `resep_produk` (
  `id_resep` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_pakai` decimal(10,2) NOT NULL COMMENT 'Jumlah bahan baku yang dipakai per 1 produk (sesuai satuan barang)',
  PRIMARY KEY (`id_resep`),
  UNIQUE KEY `unique_produk_barang` (`id_produk`, `id_barang`),
  KEY `id_produk` (`id_produk`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `resep_produk_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE,
  CONSTRAINT `resep_produk_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
