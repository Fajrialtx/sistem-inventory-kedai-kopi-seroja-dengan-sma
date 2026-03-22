ALTER TABLE `user_petugas` MODIFY COLUMN `level` enum('admin','store','purchasing','gudang','owner') NOT NULL;
INSERT INTO `user_petugas` (`nama`, `jabatan`, `phone`, `email`, `password`, `foto_user`, `level`) VALUES
('Owner Senjakopi', 'Owner', '081234567890', 'owner@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', 'owner');
-- Password default adalah: 123
