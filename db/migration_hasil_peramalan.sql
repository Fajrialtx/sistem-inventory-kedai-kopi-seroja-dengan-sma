-- ===========================================================
-- MIGRATION: Tabel hasil_peramalan
-- Menyimpan hasil peramalan SMA untuk semua produk
-- ===========================================================

USE `serojakopi_db`;

CREATE TABLE IF NOT EXISTS `hasil_peramalan` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `tgl_eksekusi` date NOT NULL COMMENT 'Tanggal peramalan dijalankan',
  `periode` int(11) NOT NULL COMMENT 'Periode SMA (3, 5, atau 7)',
  `prediksi` int(11) DEFAULT NULL COMMENT 'Hasil prediksi jumlah penjualan',
  `mad` decimal(10,2) DEFAULT NULL COMMENT 'Mean Absolute Deviation',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_hasil`),
  UNIQUE KEY `unique_eksekusi` (`id_produk`, `tgl_eksekusi`, `periode`),
  KEY `tgl_eksekusi` (`tgl_eksekusi`),
  CONSTRAINT `hasil_peramalan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
