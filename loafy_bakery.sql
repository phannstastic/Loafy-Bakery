-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2025 at 11:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loafy_bakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkout_temp`
--

CREATE TABLE `checkout_temp` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tlp_pengguna` varchar(15) DEFAULT NULL,
  `total_pesanan` int(11) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `email`, `tlp_pengguna`, `total_pesanan`, `role`) VALUES
(1, 'admin', '$2y$10$rFUDJNmBvrSGYAW.jt802OCPv6qrhB4sq1Q/5dyhefrBXURYE8t5u', 'admin@admin', '5181384483318', 0, 'admin');
-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `id_user`, `total`, `tanggal`) VALUES
(3, 9, 24000, '2025-06-26 00:33:52'),
(4, 10, 490000, '2025-06-26 00:45:47'),
(5, 10, 15000, '2025-06-26 00:46:35'),
(6, 10, 54500, '2025-06-26 01:00:08'),
(7, 9, 12000, '2025-06-26 01:17:21'),
(8, 9, 45000, '2025-07-04 04:34:11'),
(9, 9, 15000, '2025-07-04 04:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id_detail`, `id_pesanan`, `id_produk`, `quantity`, `total_harga`) VALUES
(1, 3, 3, 4, 20000),
(2, 3, 2, 2, 4000),
(3, 4, 3, 98, 490000),
(4, 5, 9, 1, 15000),
(5, 6, 7, 5, 50000),
(6, 6, 8, 1, 4500),
(7, 7, 0, 1, 12000),
(8, 8, 0, 3, 45000),
(9, 9, 0, 1, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `status_produk` enum('tersedia','diarsipk`an') NOT NULL DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama`, `harga`, `gambar`, `status_produk`) VALUES
(0, 'Roti Jala Mak Limah Biadab', 15000, 'roti jala.jpg', 'tersedia'),
(2, 'Roti Panada', 2000, 'roti_panada.jpg', 'tersedia'),
(3, 'Roti Gambang', 5000, 'roti_gambang.jpg', 'tersedia'),
(4, 'Odading', 2000, 'odading.jpg', 'tersedia'),
(5, 'Roti Buaya', 7500, 'rotibuaya.jpeg', 'tersedia'),
(6, 'Roti Bluder', 4000, 'rotibluder.jpeg', 'tersedia'),
(7, 'Paratha', 10000, 'paratha.jpg', 'tersedia'),
(8, 'Kare pan', 14500, 'karepan.jpg', 'tersedia'),
(9, 'Roti Canai', 7000, 'roticanai.jpg', 'tersedia'),
(10, 'Damper', 20000, 'damper.jpg', 'tersedia'),
(11, 'Shaobing', 3000, 'shaobing.jpg', 'tersedia'),
(12, 'Baguette', 20000, 'baguette.webp', 'tersedia'),
(13, 'Pai bao', 8000, 'paibao.jpg', 'tersedia'),
(14, 'Ciabatta', 25000, 'ciabatta.jpg', 'tersedia'),
(15, 'Roti Gembong', 12000, 'gwmbong.jpg', 'tersedia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkout_temp`
--
ALTER TABLE `checkout_temp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout_temp`
--
ALTER TABLE `checkout_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
