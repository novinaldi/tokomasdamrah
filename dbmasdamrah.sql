/*
SQLyog Enterprise v12.5.1 (64 bit)
MySQL - 10.1.30-MariaDB : Database - dbmasdamrah
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `detail_penitipanemas` */

DROP TABLE IF EXISTS `detail_penitipanemas`;

CREATE TABLE `detail_penitipanemas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `notitip` char(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `idjenis` int(11) DEFAULT NULL,
  `pilihan` enum('1','2') DEFAULT NULL,
  `jml` decimal(5,2) DEFAULT NULL,
  `buktifoto` text,
  `ket` text,
  PRIMARY KEY (`id`),
  KEY `notitip` (`notitip`),
  KEY `idjenis` (`idjenis`),
  CONSTRAINT `detail_penitipanemas_ibfk_1` FOREIGN KEY (`notitip`) REFERENCES `penitipanemas` (`notitip`) ON UPDATE CASCADE,
  CONSTRAINT `detail_penitipanemas_ibfk_2` FOREIGN KEY (`idjenis`) REFERENCES `jenisemas` (`jenisid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detail_penitipanemas` */

/*Table structure for table `detailpinjaman_emas` */

DROP TABLE IF EXISTS `detailpinjaman_emas`;

CREATE TABLE `detailpinjaman_emas` (
  `iddetail` bigint(20) NOT NULL AUTO_INCREMENT,
  `nodetail` char(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `pilihan` enum('1','2') DEFAULT NULL,
  `jml` decimal(5,2) DEFAULT NULL,
  `buktifoto` text,
  `ket` text,
  PRIMARY KEY (`iddetail`),
  KEY `nodetail` (`nodetail`),
  CONSTRAINT `detailpinjaman_emas_ibfk_1` FOREIGN KEY (`nodetail`) REFERENCES `pinjaman_emas` (`nomor`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detailpinjaman_emas` */

/*Table structure for table `detailpinjaman_uang` */

DROP TABLE IF EXISTS `detailpinjaman_uang`;

CREATE TABLE `detailpinjaman_uang` (
  `iddetail` bigint(20) NOT NULL AUTO_INCREMENT,
  `nodetail` char(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `pilihan` enum('1','2') DEFAULT NULL,
  `jml` double DEFAULT NULL,
  `buktifoto` text,
  `ket` text,
  PRIMARY KEY (`iddetail`),
  KEY `nodetail` (`nodetail`),
  CONSTRAINT `detailpinjaman_uang_ibfk_1` FOREIGN KEY (`nodetail`) REFERENCES `pinjaman_uang` (`nomor`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detailpinjaman_uang` */

/*Table structure for table `jenisemas` */

DROP TABLE IF EXISTS `jenisemas`;

CREATE TABLE `jenisemas` (
  `jenisid` int(11) NOT NULL AUTO_INCREMENT,
  `jenisnama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`jenisid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `jenisemas` */

insert  into `jenisemas`(`jenisid`,`jenisnama`) values 
(1,'Emas Antam'),
(2,'Emas Murni'),
(3,'Perhiasan');

/*Table structure for table `jenispengeluaran` */

DROP TABLE IF EXISTS `jenispengeluaran`;

CREATE TABLE `jenispengeluaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `jenis` (`jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `jenispengeluaran` */

insert  into `jenispengeluaran`(`id`,`jenis`) values 
(10,'ATK (Alat Tulis Kerja)'),
(14,'Perjalanan');

/*Table structure for table `nn_detailtitipuang` */

DROP TABLE IF EXISTS `nn_detailtitipuang`;

CREATE TABLE `nn_detailtitipuang` (
  `iddetail` bigint(20) NOT NULL AUTO_INCREMENT,
  `notitip` char(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `pilihan` enum('1','2') DEFAULT NULL COMMENT '1 adalah penitipan dan 2 adalah pengambilan',
  `nominal` double DEFAULT NULL,
  `jmlsaldo` double DEFAULT NULL,
  `buktifoto` text,
  `ket` text,
  PRIMARY KEY (`iddetail`),
  KEY `id` (`notitip`),
  CONSTRAINT `nn_detailtitipuang_ibfk_1` FOREIGN KEY (`notitip`) REFERENCES `nn_titipuang` (`notitip`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `nn_detailtitipuang` */

insert  into `nn_detailtitipuang`(`iddetail`,`notitip`,`tgl`,`pilihan`,`nominal`,`jmlsaldo`,`buktifoto`,`ket`) values 
(1,'2343','2019-12-03','1',90,90,NULL,'');

/*Table structure for table `nn_titipuang` */

DROP TABLE IF EXISTS `nn_titipuang`;

CREATE TABLE `nn_titipuang` (
  `notitip` char(20) NOT NULL,
  `tglawal` date DEFAULT NULL,
  `pelnik` char(16) DEFAULT NULL,
  `jmlawal` double DEFAULT NULL,
  `jmlsisa` double DEFAULT NULL,
  `buktifoto` text,
  `ket` text,
  `stt` char(1) DEFAULT '0',
  PRIMARY KEY (`notitip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `nn_titipuang` */

insert  into `nn_titipuang`(`notitip`,`tglawal`,`pelnik`,`jmlawal`,`jmlsisa`,`buktifoto`,`ket`,`stt`) values 
('2343','2019-12-03','1371114509950007',90,90,NULL,NULL,'0');

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `pelnik` char(16) NOT NULL,
  `pelnama` varchar(100) DEFAULT NULL,
  `peljk` char(1) DEFAULT NULL,
  `pelalamat` varchar(100) DEFAULT NULL,
  `pelnohp` char(20) DEFAULT NULL,
  `pelfoto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pelnik`),
  FULLTEXT KEY `pelnama` (`pelnama`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`pelnik`,`pelnama`,`peljk`,`pelalamat`,`pelnohp`,`pelfoto`) values 
('1371102108960005','Ramadhani Fitri','P','Solok',NULL,''),
('1371114509950010','Sumayyah Raudhatul Husna','P','Jl. Solok','087779989',NULL),
('1371114509950012','Mizan Al-Fatih','L','Solok','081364567765',NULL),
('1371114509950090','Al-Fatih Rayhan Abdullah','L','Solok','085272805766',NULL);

/*Table structure for table `pengeluaran` */

DROP TABLE IF EXISTS `pengeluaran`;

CREATE TABLE `pengeluaran` (
  `idpengeluaran` bigint(20) NOT NULL AUTO_INCREMENT,
  `namapengeluaran` varchar(100) DEFAULT NULL,
  `tglpengeluaran` date DEFAULT NULL,
  `jmlpengeluaran` double DEFAULT NULL,
  `uploadbukti` text,
  `jenisid` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpengeluaran`),
  KEY `jenisid` (`jenisid`),
  CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`jenisid`) REFERENCES `jenispengeluaran` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `pengeluaran` */

insert  into `pengeluaran`(`idpengeluaran`,`namapengeluaran`,`tglpengeluaran`,`jmlpengeluaran`,`uploadbukti`,`jenisid`) values 
(5,'Pembelian Pena kwitansi dan lain sebagainya','2019-12-20',90000,'./assets/upload/buktipengeluaran/114320122019.jpg',10);

/*Table structure for table `penitipanemas` */

DROP TABLE IF EXISTS `penitipanemas`;

CREATE TABLE `penitipanemas` (
  `notitip` char(20) NOT NULL,
  `tglawal` date DEFAULT NULL,
  `pelnik` char(16) DEFAULT NULL,
  `totaltitipan` decimal(5,2) DEFAULT NULL,
  `totalambil` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`notitip`),
  KEY `pelnik` (`pelnik`),
  CONSTRAINT `penitipanemas_ibfk_1` FOREIGN KEY (`pelnik`) REFERENCES `pelanggan` (`pelnik`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penitipanemas` */

/*Table structure for table `pinjaman_emas` */

DROP TABLE IF EXISTS `pinjaman_emas`;

CREATE TABLE `pinjaman_emas` (
  `nomor` char(20) NOT NULL,
  `tglawal` date DEFAULT NULL,
  `nikpel` char(16) DEFAULT NULL,
  `stt` char(1) DEFAULT '0',
  `jmltotalpinjam` decimal(5,2) DEFAULT NULL,
  `jmltotalbayar` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`nomor`),
  KEY `nikpel` (`nikpel`),
  CONSTRAINT `pinjaman_emas_ibfk_1` FOREIGN KEY (`nikpel`) REFERENCES `pelanggan` (`pelnik`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pinjaman_emas` */

/*Table structure for table `pinjaman_uang` */

DROP TABLE IF EXISTS `pinjaman_uang`;

CREATE TABLE `pinjaman_uang` (
  `nomor` char(20) NOT NULL,
  `tglawal` date DEFAULT NULL,
  `nikpel` char(16) DEFAULT NULL,
  `stt` char(1) DEFAULT '0',
  `jmltotalpinjam` double DEFAULT NULL,
  `jmltotalbayar` double DEFAULT NULL,
  PRIMARY KEY (`nomor`),
  KEY `nikpel` (`nikpel`),
  CONSTRAINT `pinjaman_uang_ibfk_1` FOREIGN KEY (`nikpel`) REFERENCES `pelanggan` (`pelnik`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pinjaman_uang` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userid` char(10) NOT NULL,
  `usernama` varchar(100) DEFAULT NULL,
  `userpass` varchar(100) DEFAULT NULL,
  `userfoto` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`userid`,`usernama`,`userpass`,`userfoto`) values 
('admin','Administrator','$2y$10$1FAlacn3u1kaXuMCsUcKM.BCaoYSeOFLLvtBi3l6D2ExCsEZTPq2e',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
