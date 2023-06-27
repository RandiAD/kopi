-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 03:41 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_kopi`
--
CREATE DATABASE IF NOT EXISTS `db_kopi` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_kopi`;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE IF NOT EXISTS `jenis` (
  `jeniskopi` varchar(250) NOT NULL,
  `namakopi` varchar(250) NOT NULL,
  PRIMARY KEY (`jeniskopi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`jeniskopi`, `namakopi`) VALUES
('Gelas', 'Kopikap'),
('Hitam', 'Arabika'),
('Instan', 'Kapal Api');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE IF NOT EXISTS `karyawan` (
  `kodekaryawan` varchar(250) NOT NULL,
  `namakaryawan` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`kodekaryawan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`kodekaryawan`, `namakaryawan`, `password`) VALUES
('K-001', 'Randi AD', '123');

-- --------------------------------------------------------

--
-- Table structure for table `kopi`
--

CREATE TABLE IF NOT EXISTS `kopi` (
  `kodekopi` varchar(250) NOT NULL,
  `namakopi` varchar(250) NOT NULL,
  `jeniskopi` varchar(250) NOT NULL,
  `asal` varchar(250) NOT NULL,
  PRIMARY KEY (`kodekopi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kopi`
--

INSERT INTO `kopi` (`kodekopi`, `namakopi`, `jeniskopi`, `asal`) VALUES
('KP-0001', 'Kopi Mix', 'Instan', 'Indonesia'),
('KP-0002', 'Kopinang Kau Dengan Bismillah', 'Kopi Gombal', 'Cintaku padamu'),
('KP-0003', 'Kopikap', 'Gelas', 'Indonesia'),
('KP-0004', 'Kapal Api', 'Instan', 'Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE IF NOT EXISTS `pemesanan` (
  `nomorpemesanan` int(10) NOT NULL AUTO_INCREMENT,
  `meja` char(15) NOT NULL,
  `namapembeli` varchar(50) NOT NULL,
  `kodemenu` char(10) NOT NULL,
  `namamenu` varchar(200) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `totalharga` int(20) NOT NULL,
  PRIMARY KEY (`nomorpemesanan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`nomorpemesanan`, `meja`, `namapembeli`, `kodemenu`, `namamenu`, `jumlah`, `totalharga`) VALUES
(3, '2', 'Randi AD', 'MN-001', 'Kopinang Kau Dengan Bismillah', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tambah`
--

CREATE TABLE IF NOT EXISTS `tambah` (
  `kodemenu` varchar(200) NOT NULL,
  `jeniskopi` varchar(250) NOT NULL,
  `kodekopi` varchar(200) NOT NULL,
  `namakopi` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` char(20) NOT NULL,
  PRIMARY KEY (`kodemenu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tambah`
--

INSERT INTO `tambah` (`kodemenu`, `jeniskopi`, `kodekopi`, `namakopi`, `deskripsi`, `harga`) VALUES
('MN-001', 'Hitam', 'KP-0001', 'Kopinang Kau Dengan Bismillah', 'Kopi yang bikin baper eaaaaaa', '5000'),
('MN-002', 'Gelas', 'KP-0002', 'Kopikap', 'Kopinya anak warnet. Gak basi tentunya.', '1000');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
