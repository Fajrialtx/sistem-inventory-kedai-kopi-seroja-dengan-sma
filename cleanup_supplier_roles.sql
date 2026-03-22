-- ==========================================
-- SQL Script: Cleanup Supplier from Database
-- ==========================================

-- 1. Remove the foreign key constraint and then id_supplier column from the barang table
-- Ensure you backup your database before running this!
ALTER TABLE `barang` DROP FOREIGN KEY `barang_ibfk_1`;
ALTER TABLE `barang` DROP COLUMN `id_supplier`;

-- 2. Drop the supplier table completely
DROP TABLE IF EXISTS `supplier`;

-- ==========================================
-- (Optional) If you want to explicitly delete the old user roles, run these:
-- ==========================================
DELETE FROM `user_petugas` WHERE `level` IN ('admin', 'purchasing', 'gudang');
ALTER TABLE `user_petugas` MODIFY COLUMN `level` enum('store','owner') NOT NULL;
