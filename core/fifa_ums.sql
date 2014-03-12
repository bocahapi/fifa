-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2014 at 05:06 PM
-- Server version: 5.5.35
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fifa_ums`
--

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE IF NOT EXISTS `informasi` (
  `id_informasi` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  PRIMARY KEY (`id_informasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `informasi_dana`
--

CREATE TABLE IF NOT EXISTS `informasi_dana` (
  `id_informasi_dana` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  `id_total_dana` int(11) NOT NULL,
  `id_kelola_dana` int(11) NOT NULL,
  `sisa_dana` int(11) NOT NULL,
  PRIMARY KEY (`id_informasi_dana`),
  KEY `id_user` (`id_user`,`id_jenis`,`id_sub`,`id_total_dana`,`id_kelola_dana`),
  KEY `id_jenis` (`id_jenis`),
  KEY `id_sub` (`id_sub`),
  KEY `id_total_dana` (`id_total_dana`),
  KEY `id_total_dana_2` (`id_total_dana`),
  KEY `id_kelola_dana` (`id_kelola_dana`),
  KEY `id_kelola_dana_2` (`id_kelola_dana`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE IF NOT EXISTS `jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(11) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_dana`
--

CREATE TABLE IF NOT EXISTS `jenis_dana` (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(145) NOT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kelola_dana`
--

CREATE TABLE IF NOT EXISTS `kelola_dana` (
  `id_kelola_dana` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  `jenis_kegiatan` varchar(200) NOT NULL,
  `input_dana` int(11) NOT NULL,
  `tgl_kelola_dana` date NOT NULL,
  PRIMARY KEY (`id_kelola_dana`),
  KEY `id_kelola_dana` (`id_kelola_dana`,`id_user`,`id_jenis`,`id_sub`),
  KEY `id_jenis` (`id_jenis`),
  KEY `jenis_kegiatan` (`jenis_kegiatan`),
  KEY `jenis_kegiatan_2` (`jenis_kegiatan`),
  KEY `id_sub` (`id_sub`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `proker`
--

CREATE TABLE IF NOT EXISTS `proker` (
  `id_proker` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama_file` varchar(145) NOT NULL,
  `tgl_proker` date NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id_proker`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_dana`
--

CREATE TABLE IF NOT EXISTS `sub_dana` (
  `id_sub` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sub` varchar(145) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  PRIMARY KEY (`id_sub`),
  KEY `id_jenis` (`id_jenis`),
  KEY `id_jenis_2` (`id_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `total_dana`
--

CREATE TABLE IF NOT EXISTS `total_dana` (
  `id_total_dana` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  `total_dana` int(11) NOT NULL,
  `tgl_total_dana` date NOT NULL,
  PRIMARY KEY (`id_total_dana`),
  KEY `id_user` (`id_user`,`id_jenis`,`id_sub`),
  KEY `id_user_2` (`id_user`),
  KEY `id_sub` (`id_sub`),
  KEY `total_dana` (`total_dana`),
  KEY `id_jenis` (`id_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(45) NOT NULL,
  `nama` varchar(145) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_jabatan` (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `informasi_dana`
--
ALTER TABLE `informasi_dana`
  ADD CONSTRAINT `informasi_dana_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `informasi_dana_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_dana` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `informasi_dana_ibfk_3` FOREIGN KEY (`id_sub`) REFERENCES `sub_dana` (`id_sub`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `informasi_dana_ibfk_4` FOREIGN KEY (`id_total_dana`) REFERENCES `total_dana` (`id_total_dana`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `informasi_dana_ibfk_5` FOREIGN KEY (`id_kelola_dana`) REFERENCES `kelola_dana` (`id_kelola_dana`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelola_dana`
--
ALTER TABLE `kelola_dana`
  ADD CONSTRAINT `kelola_dana_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelola_dana_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_dana` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelola_dana_ibfk_3` FOREIGN KEY (`id_sub`) REFERENCES `sub_dana` (`id_sub`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_dana`
--
ALTER TABLE `sub_dana`
  ADD CONSTRAINT `sub_dana_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_dana` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `total_dana`
--
ALTER TABLE `total_dana`
  ADD CONSTRAINT `total_dana_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `total_dana_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_dana` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `total_dana_ibfk_3` FOREIGN KEY (`id_sub`) REFERENCES `sub_dana` (`id_sub`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
