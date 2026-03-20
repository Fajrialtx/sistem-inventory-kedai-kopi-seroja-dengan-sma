-- --------------------------------------------------------
-- Tabel produk (Menu Makanan & Minuman)
-- Jalankan SQL ini di phpMyAdmin pada database serojakopi
-- --------------------------------------------------------

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(100) NOT NULL,
  `kategori_produk` enum('Makanan','Minuman') NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('Tersedia','Habis') NOT NULL DEFAULT 'Tersedia',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data contoh
-- --------------------------------------------------------

INSERT INTO `produk` (`nama_produk`, `kategori_produk`, `harga`, `deskripsi`, `status`) VALUES
('Espresso', 'Minuman', 15000, 'Kopi espresso shot dengan biji kopi pilihan', 'Tersedia'),
('Americano', 'Minuman', 18000, 'Espresso dengan tambahan air panas', 'Tersedia'),
('Cappuccino', 'Minuman', 22000, 'Espresso dengan susu dan busa lembut', 'Tersedia'),
('Caffe Latte', 'Minuman', 22000, 'Espresso dengan susu steamed', 'Tersedia'),
('Matcha Latte', 'Minuman', 25000, 'Teh matcha Jepang dengan susu', 'Tersedia'),
('Es Teh Manis', 'Minuman', 8000, 'Teh manis segar dengan es batu', 'Tersedia'),
('Nasi Goreng Spesial', 'Makanan', 25000, 'Nasi goreng dengan telur, ayam, dan sayuran', 'Tersedia'),
('Roti Bakar Coklat', 'Makanan', 15000, 'Roti bakar dengan selai coklat premium', 'Tersedia'),
('Pisang Goreng', 'Makanan', 12000, 'Pisang goreng crispy dengan topping keju/coklat', 'Tersedia'),
('Kentang Goreng', 'Makanan', 18000, 'French fries crispy dengan saus sambal dan mayo', 'Tersedia');
