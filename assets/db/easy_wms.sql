-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2020 at 02:48 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easy_wms`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `satuan` enum('dus','sachet') NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_supplier`, `nama`, `qty`, `satuan`, `harga`) VALUES
(1, 1, 'Indomie Goreng', 5, 'dus', 45000),
(2, 1, 'Goo Day Freeze', 12, 'sachet', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `id_user`, `waktu`) VALUES
(1, 1, '2020-04-28 21:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar_detail`
--

CREATE TABLE `barang_keluar_detail` (
  `id` int(11) NOT NULL,
  `id_barang_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_keluar_detail`
--

INSERT INTO `barang_keluar_detail` (`id`, `id_barang_keluar`, `id_barang`, `qty`) VALUES
(1, 1, 1, 5);

--
-- Triggers `barang_keluar_detail`
--
DELIMITER $$
CREATE TRIGGER `kurangi_barang` BEFORE INSERT ON `barang_keluar_detail` FOR EACH ROW BEGIN
	UPDATE barang
	SET qty = qty - NEW.qty
	WHERE id = NEW.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `id_user`, `waktu`, `total_harga`) VALUES
(1, 1, '2020-04-28 21:31:48', 810000);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id` int(11) NOT NULL,
  `id_barang_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_masuk_detail`
--

INSERT INTO `barang_masuk_detail` (`id`, `id_barang_masuk`, `id_barang`, `qty`, `subtotal`) VALUES
(1, 1, 1, 10, 450000),
(2, 1, 2, 12, 360000);

--
-- Triggers `barang_masuk_detail`
--
DELIMITER $$
CREATE TRIGGER `tambah_barang` AFTER INSERT ON `barang_masuk_detail` FOR EACH ROW UPDATE barang
SET qty = qty + NEW.qty
WHERE id = NEW.id_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `total_harga_masuk` AFTER INSERT ON `barang_masuk_detail` FOR EACH ROW BEGIN
	UPDATE barang_masuk
	SET total_harga = total_harga + NEW.subtotal
	WHERE id = NEW.id_barang_masuk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_keluar`
--

CREATE TABLE `keranjang_keluar` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_masuk`
--

CREATE TABLE `keranjang_masuk` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `keranjang_masuk`
--
DELIMITER $$
CREATE TRIGGER `subtotal_keranjang_masuk` BEFORE INSERT ON `keranjang_masuk` FOR EACH ROW BEGIN
	# ---- Hitung Subtotal ----
	DECLARE harga_barang INT DEFAULT 0;
	SET harga_barang = (SELECT harga FROM barang WHERE id = NEW.id_barang LIMIT 1);

	SET NEW.subtotal = NEW.qty * harga_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `email`, `telefon`, `alamat`, `status`) VALUES
(1, 'Kacong Banjir Pole', 'kacong@gmail.com', '0833747747', 'Bangkalan', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `ktp` varchar(30) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `telefon`, `ktp`, `role`, `status`) VALUES
(1, 'Administrator', 'admin@easywms.com', '$2y$10$UBpSa8Hl07HyfR5CF.RlvOQDmsh6X/aKJPUriqmv99pxjlMwBerv.', '084554433445', '17081010000', 'admin', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang_keluar`
--
ALTER TABLE `keranjang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang_masuk`
--
ALTER TABLE `keranjang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `keranjang_keluar`
--
ALTER TABLE `keranjang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keranjang_masuk`
--
ALTER TABLE `keranjang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
