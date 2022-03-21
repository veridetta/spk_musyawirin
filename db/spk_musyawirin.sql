-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2022 at 12:11 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_musyawirin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(10) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `username`, `password`, `level`) VALUES
(1, 'user', 'user', '21232f297a57a5a743894a0e4a801fc3', 'pimpinan'),
(2, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'entry');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_produk`
--

CREATE TABLE `kriteria_produk` (
  `id_kriteria_produk` int(11) NOT NULL,
  `kode_kriteria_produk` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `nama_kriteria_produk` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `kriteria_produk`
--

INSERT INTO `kriteria_produk` (`id_kriteria_produk`, `kode_kriteria_produk`, `nama_kriteria_produk`) VALUES
(10, 'K03', 'Kehadiran'),
(9, 'K02', 'Sikap'),
(8, 'K01', 'Akademik'),
(11, 'K04', 'Ekstrakulikuler');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_kriteria_produk`
--

CREATE TABLE `nilai_kriteria_produk` (
  `id_nilai_kriteria_produk` int(11) NOT NULL,
  `id_kriteria_produk_1` int(11) NOT NULL,
  `id_kriteria_produk_2` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `teknis` enum('1','2') COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `nilai_kriteria_produk`
--

INSERT INTO `nilai_kriteria_produk` (`id_nilai_kriteria_produk`, `id_kriteria_produk_1`, `id_kriteria_produk_2`, `nilai`, `teknis`) VALUES
(1, 8, 9, 5, NULL),
(2, 8, 10, 4, NULL),
(3, 8, 11, 3, NULL),
(4, 9, 10, 2, NULL),
(5, 9, 11, 2, NULL),
(6, 10, 11, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_produk`
--

CREATE TABLE `nilai_produk` (
  `id_nilai_produk` int(11) NOT NULL,
  `id_kriteria_produk` int(11) NOT NULL,
  `id_produk_1` int(11) NOT NULL,
  `id_produk_2` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `nilai_produk`
--

INSERT INTO `nilai_produk` (`id_nilai_produk`, `id_kriteria_produk`, `id_produk_1`, `id_produk_2`, `nilai`) VALUES
(706, 0, 12, 13, 1),
(702, 0, 10, 12, 1),
(701, 0, 10, 11, 1),
(712, 9, 12, 13, 6),
(711, 9, 11, 13, 5),
(710, 9, 11, 12, 4),
(709, 9, 10, 13, 3),
(708, 9, 10, 12, 2),
(707, 9, 10, 11, 1),
(592, 10, 12, 13, 6),
(591, 10, 11, 13, 5),
(590, 10, 11, 12, 4),
(589, 10, 10, 13, 3),
(588, 10, 10, 12, 2),
(587, 10, 10, 11, 1),
(604, 11, 12, 13, 6),
(603, 11, 11, 13, 5),
(602, 11, 11, 12, 4),
(601, 11, 10, 13, 3),
(600, 11, 10, 12, 2),
(700, 8, 12, 13, 1),
(699, 8, 11, 13, 2),
(599, 11, 10, 11, 1),
(698, 8, 11, 12, 3),
(697, 8, 10, 13, 4),
(696, 8, 10, 12, 5),
(695, 8, 10, 11, 6),
(704, 0, 11, 12, 1),
(705, 0, 11, 13, 1),
(703, 0, 10, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `nama_produk` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`) VALUES
(13, 'A004', 'Syifa'),
(10, 'A001', 'Yuli'),
(11, 'A002', 'Indra'),
(12, 'A003', 'Akbar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kriteria_produk`
--
ALTER TABLE `kriteria_produk`
  ADD PRIMARY KEY (`id_kriteria_produk`);

--
-- Indexes for table `nilai_kriteria_produk`
--
ALTER TABLE `nilai_kriteria_produk`
  ADD PRIMARY KEY (`id_nilai_kriteria_produk`);

--
-- Indexes for table `nilai_produk`
--
ALTER TABLE `nilai_produk`
  ADD PRIMARY KEY (`id_nilai_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kriteria_produk`
--
ALTER TABLE `kriteria_produk`
  MODIFY `id_kriteria_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nilai_kriteria_produk`
--
ALTER TABLE `nilai_kriteria_produk`
  MODIFY `id_nilai_kriteria_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nilai_produk`
--
ALTER TABLE `nilai_produk`
  MODIFY `id_nilai_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=713;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
