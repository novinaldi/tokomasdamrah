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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbmasdamrah` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dbmasdamrah`;

/*Table structure for table `bayarpinjaman` */

DROP TABLE IF EXISTS `bayarpinjaman`;

CREATE TABLE `bayarpinjaman` (
  `bayarid` bigint(20) NOT NULL AUTO_INCREMENT,
  `bayartgl` date DEFAULT NULL,
  `bayarpinjamanno` char(20) DEFAULT NULL,
  `bayarjml` int(11) DEFAULT NULL,
  `bayarcara` char(1) DEFAULT NULL,
  `bayarfoto` text,
  PRIMARY KEY (`bayarid`),
  KEY `bayarpinjamanno` (`bayarpinjamanno`),
  CONSTRAINT `bayarpinjaman_ibfk_1` FOREIGN KEY (`bayarpinjamanno`) REFERENCES `pinjaman` (`pinjamanno`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bayarpinjaman` */

/*Table structure for table `detailpenitipan` */

DROP TABLE IF EXISTS `detailpenitipan`;

CREATE TABLE `detailpenitipan` (
  `dettitipid` bigint(20) NOT NULL AUTO_INCREMENT,
  `dettitipno` char(20) DEFAULT NULL,
  `dettitiptgl` date DEFAULT NULL,
  `dettitipjml` int(11) DEFAULT NULL,
  PRIMARY KEY (`dettitipid`),
  KEY `dettitipno` (`dettitipno`),
  CONSTRAINT `detailpenitipan_ibfk_1` FOREIGN KEY (`dettitipno`) REFERENCES `penitipan` (`penitipanid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `detailpenitipan` */

insert  into `detailpenitipan`(`dettitipid`,`dettitipno`,`dettitiptgl`,`dettitipjml`) values 
(4,'0911190002','2019-11-09',50),
(5,'0911190001','2019-11-09',25),
(6,'0911190001','2019-11-10',15);

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `pelnik` char(16) NOT NULL,
  `pelnama` varchar(100) DEFAULT NULL,
  `peljk` char(1) DEFAULT NULL,
  `pelalamat` varchar(100) DEFAULT NULL,
  `pelnohp` char(20) DEFAULT NULL,
  `pelfoto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pelnik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`pelnik`,`pelnama`,`peljk`,`pelalamat`,`pelnohp`,`pelfoto`) values 
('1371102108960005','Ramadhani Fitri','P','Solok',NULL,NULL),
('1371114509950007','Novinaldi','L','Olo Ladang','085272805760','./temp/upload/ktppelanggan/1371114509950007.jpg');

/*Table structure for table `pengeluaran` */

DROP TABLE IF EXISTS `pengeluaran`;

CREATE TABLE `pengeluaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `namapengeluaran` varchar(100) DEFAULT NULL,
  `tglpengeluaran` date DEFAULT NULL,
  `jmlpengeluaran` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `pengeluaran` */

insert  into `pengeluaran`(`id`,`namapengeluaran`,`tglpengeluaran`,`jmlpengeluaran`) values 
(1,'adfadsf','2019-11-11',600000);

/*Table structure for table `penitipan` */

DROP TABLE IF EXISTS `penitipan`;

CREATE TABLE `penitipan` (
  `penitipanid` char(20) NOT NULL,
  `penitipantgl` date DEFAULT NULL,
  `penitipanpelnik` char(16) DEFAULT NULL,
  `penitipantotal` double DEFAULT NULL,
  `penitipanstt` char(1) DEFAULT '0',
  `penitipantglambil` date DEFAULT NULL,
  PRIMARY KEY (`penitipanid`),
  KEY `penitipanpelnik` (`penitipanpelnik`),
  CONSTRAINT `penitipan_ibfk_1` FOREIGN KEY (`penitipanpelnik`) REFERENCES `pelanggan` (`pelnik`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penitipan` */

insert  into `penitipan`(`penitipanid`,`penitipantgl`,`penitipanpelnik`,`penitipantotal`,`penitipanstt`,`penitipantglambil`) values 
('0911190001','2019-11-09','1371114509950007',40,'0','0000-00-00'),
('0911190002','2019-11-09','1371102108960005',50,'1','2019-11-13');

/*Table structure for table `pinjaman` */

DROP TABLE IF EXISTS `pinjaman`;

CREATE TABLE `pinjaman` (
  `pinjamanno` char(20) NOT NULL,
  `pinjamantgl` date DEFAULT NULL,
  `pinjamanpelnik` char(16) DEFAULT NULL,
  `pinjamanjml` int(11) DEFAULT NULL,
  `pinjamansisa` int(11) DEFAULT NULL,
  `pinjamanstt` char(1) DEFAULT '0',
  PRIMARY KEY (`pinjamanno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pinjaman` */

insert  into `pinjaman`(`pinjamanno`,`pinjamantgl`,`pinjamanpelnik`,`pinjamanjml`,`pinjamansisa`,`pinjamanstt`) values 
('PJ-1011190001','2019-11-10','1371102108960005',90,NULL,'0');

/*Table structure for table `testdummy` */

DROP TABLE IF EXISTS `testdummy`;

CREATE TABLE `testdummy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `jenis` enum('M','K') DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `testdummy` */

insert  into `testdummy`(`id`,`tgl`,`jenis`,`jumlah`) values 
(1,'2019-11-13','M',10000000),
(2,'2019-11-14','M',500000),
(3,'2019-11-15','K',200000),
(4,'2019-11-16','M',100000),
(5,'2019-11-17','K',1000000),
(6,'2019-11-17','M',1000000),
(7,'2019-11-18','K',500000),
(8,'2019-11-19','K',900000),
(9,'2019-11-20','K',9000000),
(10,'2019-11-21','K',100000);

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
