-- ===========================================================
-- DATA DUMMY PENJUALAN REALISTIS (15 APRIL 2026 - 23 APRIL 2026)
-- ===========================================================

DELETE FROM `penjualan` WHERE `tgl_penjualan` BETWEEN '2026-04-15' AND '2026-04-23';

-- DATA TRANSAKSI TANGGAL: 2026-04-15
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3000, 1, '2026-04-15', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3000, 1, 36, 15000, 540000),
(3000, 2, 37, 18000, 666000),
(3000, 3, 25, 22000, 550000),
(3000, 4, 28, 22000, 616000),
(3000, 5, 16, 25000, 400000),
(3000, 6, 56, 8000, 448000),
(3000, 7, 23, 25000, 575000),
(3000, 8, 27, 15000, 405000),
(3000, 9, 22, 12000, 264000),
(3000, 10, 33, 18000, 594000);
UPDATE `penjualan` SET `total_pendapatan` = 5058000 WHERE `id_penjualan` = 3000;

-- DATA TRANSAKSI TANGGAL: 2026-04-16
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3001, 1, '2026-04-16', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3001, 1, 40, 15000, 600000),
(3001, 2, 45, 18000, 810000),
(3001, 3, 23, 22000, 506000),
(3001, 4, 30, 22000, 660000),
(3001, 5, 12, 25000, 300000),
(3001, 6, 56, 8000, 448000),
(3001, 7, 17, 25000, 425000),
(3001, 8, 27, 15000, 405000),
(3001, 9, 23, 12000, 276000),
(3001, 10, 30, 18000, 540000);
UPDATE `penjualan` SET `total_pendapatan` = 4970000 WHERE `id_penjualan` = 3001;

-- DATA TRANSAKSI TANGGAL: 2026-04-17
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3002, 1, '2026-04-17', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3002, 1, 39, 15000, 585000),
(3002, 2, 36, 18000, 648000),
(3002, 3, 29, 22000, 638000),
(3002, 4, 33, 22000, 726000),
(3002, 5, 12, 25000, 300000),
(3002, 6, 48, 8000, 384000),
(3002, 7, 20, 25000, 500000),
(3002, 8, 29, 15000, 435000),
(3002, 9, 23, 12000, 276000),
(3002, 10, 36, 18000, 648000);
UPDATE `penjualan` SET `total_pendapatan` = 5140000 WHERE `id_penjualan` = 3002;

-- DATA TRANSAKSI TANGGAL: 2026-04-18
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3003, 1, '2026-04-18', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3003, 1, 36, 15000, 540000),
(3003, 2, 45, 18000, 810000),
(3003, 3, 26, 22000, 572000),
(3003, 4, 27, 22000, 594000),
(3003, 5, 17, 25000, 425000),
(3003, 6, 46, 8000, 368000),
(3003, 7, 21, 25000, 525000),
(3003, 8, 26, 15000, 390000),
(3003, 9, 27, 12000, 324000),
(3003, 10, 31, 18000, 558000);
UPDATE `penjualan` SET `total_pendapatan` = 5106000 WHERE `id_penjualan` = 3003;

-- DATA TRANSAKSI TANGGAL: 2026-04-19
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3004, 1, '2026-04-19', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3004, 1, 37, 15000, 555000),
(3004, 2, 42, 18000, 756000),
(3004, 3, 25, 22000, 550000),
(3004, 4, 31, 22000, 682000),
(3004, 5, 12, 25000, 300000),
(3004, 6, 46, 8000, 368000),
(3004, 7, 22, 25000, 550000),
(3004, 8, 27, 15000, 405000),
(3004, 9, 28, 12000, 336000),
(3004, 10, 30, 18000, 540000);
UPDATE `penjualan` SET `total_pendapatan` = 5042000 WHERE `id_penjualan` = 3004;

-- DATA TRANSAKSI TANGGAL: 2026-04-20
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3005, 1, '2026-04-20', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3005, 1, 33, 15000, 495000),
(3005, 2, 42, 18000, 756000),
(3005, 3, 24, 22000, 528000),
(3005, 4, 29, 22000, 638000),
(3005, 5, 12, 25000, 300000),
(3005, 6, 45, 8000, 360000),
(3005, 7, 18, 25000, 450000),
(3005, 8, 31, 15000, 465000),
(3005, 9, 28, 12000, 336000),
(3005, 10, 39, 18000, 702000);
UPDATE `penjualan` SET `total_pendapatan` = 5030000 WHERE `id_penjualan` = 3005;

-- DATA TRANSAKSI TANGGAL: 2026-04-21
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3006, 1, '2026-04-21', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3006, 1, 37, 15000, 555000),
(3006, 2, 38, 18000, 684000),
(3006, 3, 21, 22000, 462000),
(3006, 4, 30, 22000, 660000),
(3006, 5, 13, 25000, 325000),
(3006, 6, 54, 8000, 432000),
(3006, 7, 23, 25000, 575000),
(3006, 8, 33, 15000, 495000),
(3006, 9, 22, 12000, 264000),
(3006, 10, 39, 18000, 702000);
UPDATE `penjualan` SET `total_pendapatan` = 5154000 WHERE `id_penjualan` = 3006;

-- DATA TRANSAKSI TANGGAL: 2026-04-22
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3007, 1, '2026-04-22', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3007, 1, 30, 15000, 450000),
(3007, 2, 37, 18000, 666000),
(3007, 3, 23, 22000, 506000),
(3007, 4, 27, 22000, 594000),
(3007, 5, 18, 25000, 450000),
(3007, 6, 45, 8000, 360000),
(3007, 7, 22, 25000, 550000),
(3007, 8, 30, 15000, 450000),
(3007, 9, 21, 12000, 252000),
(3007, 10, 32, 18000, 576000);
UPDATE `penjualan` SET `total_pendapatan` = 4854000 WHERE `id_penjualan` = 3007;

-- DATA TRANSAKSI TANGGAL: 2026-04-23
INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `tgl_penjualan`, `total_pendapatan`) VALUES (3008, 1, '2026-04-23', 0);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES 
(3008, 1, 31, 15000, 465000),
(3008, 2, 45, 18000, 810000),
(3008, 3, 26, 22000, 572000),
(3008, 4, 33, 22000, 726000),
(3008, 5, 16, 25000, 400000),
(3008, 6, 47, 8000, 376000),
(3008, 7, 24, 25000, 600000),
(3008, 8, 31, 15000, 465000),
(3008, 9, 29, 12000, 348000),
(3008, 10, 33, 18000, 594000);
UPDATE `penjualan` SET `total_pendapatan` = 5356000 WHERE `id_penjualan` = 3008;

