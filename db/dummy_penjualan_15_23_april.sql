-- ===========================================================
-- DATA DUMMY PENJUALAN (15 APRIL 2026 - 23 APRIL 2026)
-- ===========================================================

-- DATA TRANSAKSI TANGGAL: 2026-04-15
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2000, 1, '2026-04-15', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2000, 1, 24, 15000, 360000),
(2000, 2, 21, 18000, 378000),
(2000, 3, 32, 22000, 704000),
(2000, 4, 26, 22000, 572000),
(2000, 5, 38, 25000, 950000),
(2000, 6, 30, 8000, 240000),
(2000, 7, 39, 25000, 975000),
(2000, 8, 44, 15000, 660000),
(2000, 9, 15, 12000, 180000),
(2000, 10, 12, 18000, 216000);
UPDATE `penjualan` SET `total_pendapatan` = 5235000 WHERE `id_penjualan` = 2000;

-- DATA TRANSAKSI TANGGAL: 2026-04-16
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2001, 1, '2026-04-16', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2001, 1, 42, 15000, 630000),
(2001, 2, 24, 18000, 432000),
(2001, 3, 15, 22000, 330000),
(2001, 4, 25, 22000, 550000),
(2001, 5, 30, 25000, 750000),
(2001, 6, 45, 8000, 360000),
(2001, 7, 32, 25000, 800000),
(2001, 8, 27, 15000, 405000),
(2001, 9, 39, 12000, 468000),
(2001, 10, 29, 18000, 522000);
UPDATE `penjualan` SET `total_pendapatan` = 5247000 WHERE `id_penjualan` = 2001;

-- DATA TRANSAKSI TANGGAL: 2026-04-17
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2002, 1, '2026-04-17', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2002, 1, 42, 15000, 630000),
(2002, 2, 39, 18000, 702000),
(2002, 3, 23, 22000, 506000),
(2002, 4, 20, 22000, 440000),
(2002, 5, 44, 25000, 1100000),
(2002, 6, 23, 8000, 184000),
(2002, 7, 12, 25000, 300000),
(2002, 8, 32, 15000, 480000),
(2002, 9, 19, 12000, 228000),
(2002, 10, 30, 18000, 540000);
UPDATE `penjualan` SET `total_pendapatan` = 5110000 WHERE `id_penjualan` = 2002;

-- DATA TRANSAKSI TANGGAL: 2026-04-18
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2003, 1, '2026-04-18', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2003, 1, 42, 15000, 630000),
(2003, 2, 28, 18000, 504000),
(2003, 3, 37, 22000, 814000),
(2003, 4, 11, 22000, 242000),
(2003, 5, 39, 25000, 975000),
(2003, 6, 32, 8000, 256000),
(2003, 7, 23, 25000, 575000),
(2003, 8, 33, 15000, 495000),
(2003, 9, 29, 12000, 348000),
(2003, 10, 10, 18000, 180000);
UPDATE `penjualan` SET `total_pendapatan` = 5019000 WHERE `id_penjualan` = 2003;

-- DATA TRANSAKSI TANGGAL: 2026-04-19
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2004, 1, '2026-04-19', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2004, 1, 28, 15000, 420000),
(2004, 2, 28, 18000, 504000),
(2004, 3, 40, 22000, 880000),
(2004, 4, 38, 22000, 836000),
(2004, 5, 37, 25000, 925000),
(2004, 6, 32, 8000, 256000),
(2004, 7, 24, 25000, 600000),
(2004, 8, 43, 15000, 645000),
(2004, 9, 14, 12000, 168000),
(2004, 10, 43, 18000, 774000);
UPDATE `penjualan` SET `total_pendapatan` = 6008000 WHERE `id_penjualan` = 2004;

-- DATA TRANSAKSI TANGGAL: 2026-04-20
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2005, 1, '2026-04-20', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2005, 1, 36, 15000, 540000),
(2005, 2, 19, 18000, 342000),
(2005, 3, 18, 22000, 396000),
(2005, 4, 20, 22000, 440000),
(2005, 5, 20, 25000, 500000),
(2005, 6, 31, 8000, 248000),
(2005, 7, 13, 25000, 325000),
(2005, 8, 16, 15000, 240000),
(2005, 9, 27, 12000, 324000),
(2005, 10, 44, 18000, 792000);
UPDATE `penjualan` SET `total_pendapatan` = 4147000 WHERE `id_penjualan` = 2005;

-- DATA TRANSAKSI TANGGAL: 2026-04-21
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2006, 1, '2026-04-21', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2006, 1, 18, 15000, 270000),
(2006, 2, 23, 18000, 414000),
(2006, 3, 11, 22000, 242000),
(2006, 4, 21, 22000, 462000),
(2006, 5, 35, 25000, 875000),
(2006, 6, 11, 8000, 88000),
(2006, 7, 41, 25000, 1025000),
(2006, 8, 12, 15000, 180000),
(2006, 9, 34, 12000, 408000),
(2006, 10, 30, 18000, 540000);
UPDATE `penjualan` SET `total_pendapatan` = 4504000 WHERE `id_penjualan` = 2006;

-- DATA TRANSAKSI TANGGAL: 2026-04-22
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2007, 1, '2026-04-22', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2007, 1, 19, 15000, 285000),
(2007, 2, 41, 18000, 738000),
(2007, 3, 18, 22000, 396000),
(2007, 4, 10, 22000, 220000),
(2007, 5, 31, 25000, 775000),
(2007, 6, 22, 8000, 176000),
(2007, 7, 14, 25000, 350000),
(2007, 8, 30, 15000, 450000),
(2007, 9, 11, 12000, 132000),
(2007, 10, 45, 18000, 810000);
UPDATE `penjualan` SET `total_pendapatan` = 4332000 WHERE `id_penjualan` = 2007;

-- DATA TRANSAKSI TANGGAL: 2026-04-23
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (2008, 1, '2026-04-23', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(2008, 1, 37, 15000, 555000),
(2008, 2, 43, 18000, 774000),
(2008, 3, 37, 22000, 814000),
(2008, 4, 11, 22000, 242000),
(2008, 5, 41, 25000, 1025000),
(2008, 6, 24, 8000, 192000),
(2008, 7, 38, 25000, 950000),
(2008, 8, 39, 15000, 585000),
(2008, 9, 38, 12000, 456000),
(2008, 10, 18, 18000, 324000);
UPDATE `penjualan` SET `total_pendapatan` = 5917000 WHERE `id_penjualan` = 2008;

