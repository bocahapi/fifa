-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2014 at 09:59 AM
-- Server version: 5.5.35
-- PHP Version: 5.3.10-1ubuntu3.10

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id_informasi`, `judul`, `isi`) VALUES
(1, 'Ultricies massa elementum', '<p><span style="font-family: arial; font-size: 13px;">Ultricies massa elementum dis mattis mauris porta, cum? Eros aliquam, tortor turpis egestas phasellus nunc enim! Rhoncus lorem cras, mattis et ultricies elit integer phasellus augue integer lorem, pulvinar? Ridiculus turpis et ut a, rhoncus, augue? Elementum platea? Eu tempor? Eu porta. Proin vut, cum tincidunt adipiscing pid. Mauris dictumst ac facilisis. Cum urna, elementum nunc turpis a natoque cras? Natoque cras, lorem ac! Velit odio etiam mattis augue in ac porttitor, proin adipiscing? Porttitor turpis eros pulvinar? Elementum nunc egestas proin nisi dolor, ut, tortor pulvinar risus, sed magna? Penatibus eros odio! Magnis mus! Tortor? Aliquam vut, nisi. Pellentesque amet sit duis arcu sagittis! Turpis, in scelerisque, aliquam turpis porttitor, hac, lectus elementum ultrices non cras! Ac magna, ultrices.</span></p>');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `jabatan`) VALUES
(1, 'Admin'),
(2, 'Bagmawa'),
(3, 'Ormawa');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_dana`
--

CREATE TABLE IF NOT EXISTS `jenis_dana` (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(145) NOT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jenis_dana`
--

INSERT INTO `jenis_dana` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Dana Operasional');

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
-- Table structure for table `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `name` varchar(100) NOT NULL,
  `url` varchar(145) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `link`
--

INSERT INTO `link` (`name`, `url`) VALUES
('site', 'http://localhost/fifa');

-- --------------------------------------------------------

--
-- Table structure for table `proker`
--

CREATE TABLE IF NOT EXISTS `proker` (
  `id_proker` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama_file` varchar(145) NOT NULL,
  `tgl_proker` date NOT NULL,
  `status` enum('setuju','tidak') NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sub_dana`
--

INSERT INTO `sub_dana` (`id_sub`, `nama_sub`, `id_jenis`) VALUES
(1, 'Nalar', 1),
(2, 'Non Nalar', 1),
(3, 'Reor', 1);

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
  `tgl_total_dana` varchar(20) NOT NULL,
  `tahun` year(4) NOT NULL,
  PRIMARY KEY (`id_total_dana`),
  KEY `id_user` (`id_user`,`id_jenis`,`id_sub`),
  KEY `id_user_2` (`id_user`),
  KEY `id_sub` (`id_sub`),
  KEY `total_dana` (`total_dana`),
  KEY `id_jenis` (`id_jenis`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `total_dana`
--

INSERT INTO `total_dana` (`id_total_dana`, `id_user`, `id_jenis`, `id_sub`, `total_dana`, `tgl_total_dana`, `tahun`) VALUES
(43, 3, 1, 1, 764764, '11/03', 2013),
(44, 3, 1, 2, 574869, '11/03', 2013),
(45, 3, 1, 3, 6536789, '11/03', 2013),
(52, 3, 1, 1, 9780000, '11/03', 2014),
(53, 3, 1, 2, 96968987, '11/03', 2014),
(54, 3, 1, 3, 32499690, '11/03', 2014);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(145) NOT NULL,
  `nama` varchar(145) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_jabatan` (`id_jabatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `id_jabatan`) VALUES
(1, 'admin', 'MjEyMzJmMjk3YTU3YTVhNzQzODk0YTBlNGE4MDFmYzMvYWRtaW4=', 'Administrator', 1),
(2, 'bagmawa', 'NzY1YzBmMDBkNGIyYzU2Mjg2MTkyODNiMGM4NWYzNWYvYmFnbWF3YQ==', 'Bagmawa', 2),
(3, 'ormawa', 'MzY1NWRiMzY2OGMyYzUxYTcxODRhYzFhNTU2NjA1OGYvb3JtYXdh', 'Ormawa', 3),
(8, 'bem', 'ZDNjNjU0ZDk5YmRmYWYxMDFlMDEyYmZlMjgxMDY3OWUvYmVt', 'BEM FKI', 3);

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
