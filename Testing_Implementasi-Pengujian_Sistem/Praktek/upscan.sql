-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 09, 2018 at 11:32 AM
-- Server version: 10.0.34-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upscan`
--

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE `captcha` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(1, 1522806823, '::1', 'y465'),
(2, 1522806829, '::1', '2TXp'),
(3, 1522806831, '::1', 'LWml'),
(4, 1522807278, '::1', 'xWiB'),
(5, 1522807313, '::1', '30uq'),
(6, 1522807319, '::1', 'pnKi'),
(7, 1522807321, '::1', 'ucz0'),
(8, 1522809658, '::1', 'UyNj'),
(9, 1522809662, '::1', 'fuqQ'),
(10, 1522809665, '::1', 'pVhA'),
(11, 1522809668, '::1', 'ixZU'),
(12, 1522809681, '::1', 'fmLK'),
(13, 1522809700, '::1', 'HKbv'),
(14, 1522809864, '::1', 'a5dV'),
(15, 1522809871, '::1', 'qwJt'),
(16, 1522809874, '::1', '8h72'),
(17, 1522809879, '::1', 'd2rs'),
(18, 1522809897, '::1', '1DZ2'),
(19, 1522809922, '::1', 'sOih');

-- --------------------------------------------------------

--
-- Table structure for table `scankp`
--

CREATE TABLE `scankp` (
  `id_kp` int(11) NOT NULL,
  `nim_kp` char(13) NOT NULL,
  `nama_kp` varchar(50) NOT NULL,
  `telp_kp` varchar(15) NOT NULL,
  `judul_kp` text NOT NULL,
  `semester_kp` char(5) NOT NULL,
  `file_kp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scanprop`
--

CREATE TABLE `scanprop` (
  `id_prop` int(11) NOT NULL,
  `nim_prop` char(13) NOT NULL,
  `nama_prop` varchar(50) NOT NULL,
  `telp_prop` varchar(15) NOT NULL,
  `judul_prop` text NOT NULL,
  `semester_prop` char(5) NOT NULL,
  `file_prop` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scanta`
--

CREATE TABLE `scanta` (
  `id_ta` int(11) NOT NULL,
  `nim_ta` char(13) NOT NULL,
  `nama_ta` varchar(50) NOT NULL,
  `telp_ta` varchar(15) NOT NULL,
  `judul_ta` text NOT NULL,
  `semester_ta` char(5) NOT NULL,
  `status_ta` enum('Ya','Tidak') NOT NULL DEFAULT 'Ya',
  `file_ta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `name` char(8) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `pass`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`captcha_id`),
  ADD KEY `word` (`word`);

--
-- Indexes for table `scankp`
--
ALTER TABLE `scankp`
  ADD PRIMARY KEY (`id_kp`);

--
-- Indexes for table `scanprop`
--
ALTER TABLE `scanprop`
  ADD PRIMARY KEY (`id_prop`);

--
-- Indexes for table `scanta`
--
ALTER TABLE `scanta`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `captcha`
--
ALTER TABLE `captcha`
  MODIFY `captcha_id` bigint(13) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `scankp`
--
ALTER TABLE `scankp`
  MODIFY `id_kp` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scanprop`
--
ALTER TABLE `scanprop`
  MODIFY `id_prop` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scanta`
--
ALTER TABLE `scanta`
  MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
