/*
SQLyog Trial v12.2.0 (32 bit)
MySQL - 5.6.25 : Database - db_buku
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_buku` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_buku`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `category_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_ID` int(11) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `description` text,
  `guide` varchar(40) DEFAULT NULL,
  `type` char(20) DEFAULT NULL,
  `order` tinyint(4) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`category_ID`,`parent_ID`,`title`,`description`,`guide`,`type`,`order`,`timestamp`) values 
(1,8,'Guk guk guk....',NULL,'ekonomi','post',2,'2016-05-25 16:48:42'),
(2,0,'hilmi',NULL,'politik','post',8,'2016-05-25 16:50:18'),
(3,4,'Moohhhhhh',NULL,'sosial','post',7,'2016-05-25 17:29:04'),
(4,0,'Kukuruyuuukkk',NULL,'netizen','post',6,'2016-05-25 17:29:17'),
(5,8,'Desainer Hebat',NULL,'perbankan','post',3,'2016-05-25 17:29:34'),
(6,0,'Mbeeekkkk....',NULL,NULL,'post',9,'2016-05-26 13:06:53'),
(7,5,'Lagi bobo',NULL,NULL,'post',4,'2016-05-26 13:07:12'),
(8,0,'Meoonng',NULL,NULL,'post',1,'2016-05-26 13:18:16'),
(9,5,'Gak Boleh looo',NULL,NULL,'post',5,'2016-05-26 13:18:59');

/*Table structure for table `tbl_buku` */

DROP TABLE IF EXISTS `tbl_buku`;

CREATE TABLE `tbl_buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(255) DEFAULT NULL,
  `pengarang` varchar(20) DEFAULT NULL,
  `penerbit` varchar(20) DEFAULT NULL,
  `tahun` char(4) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_buku`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `tbl_buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_buku` */

insert  into `tbl_buku`(`id_buku`,`judul_buku`,`pengarang`,`penerbit`,`tahun`,`id_kategori`) values 
(1,'Penerapan Data Mining','Muhammad Thoha','Elex Media','2014',5),
(2,'Adobe Photoshop','Julianto99','Elex Media','2014',2),
(3,'Tasawuf Untuk Awam','Yuli D','Bina Islam','2015',1),
(4,'Kukejar Cinta ke Negeri Jepang','Dewi','Bineka','2013',3),
(5,'Adobe Premier','Anto','Bineka','2012',2),
(7,'Naruto Expedition 13','Hokage','Tokyo','2015',4),
(16,'Name 4','name4@email.com','name5@email.com',NULL,NULL),
(17,'Name 5',NULL,'name5@email.com',NULL,NULL);

/*Table structure for table `tbl_kategori` */

DROP TABLE IF EXISTS `tbl_kategori`;

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_kategori` */

insert  into `tbl_kategori`(`id_kategori`,`nama_kategori`) values 
(1,'Agama'),
(2,'Komputer'),
(3,'Novel'),
(4,'Cerita'),
(5,'Mobile'),
(32,'Setan Mabor');

/*Table structure for table `tbl_pinjam` */

DROP TABLE IF EXISTS `tbl_pinjam`;

CREATE TABLE `tbl_pinjam` (
  `id_pinjam` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `kasir` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id_pinjam`),
  KEY `id_buku` (`id_buku`),
  CONSTRAINT `tbl_pinjam_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `tbl_buku` (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_pinjam` */

insert  into `tbl_pinjam`(`id_pinjam`,`tanggal`,`id_buku`,`kasir`) values 
(1,'2015-08-31',2,'ana'),
(2,'2015-08-31',5,'ani'),
(3,'2015-08-31',7,'ano');

/*Table structure for table `tbl_tanggalsort` */

DROP TABLE IF EXISTS `tbl_tanggalsort`;

CREATE TABLE `tbl_tanggalsort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_tanggalsort` */

insert  into `tbl_tanggalsort`(`id`,`tanggal`) values 
(1,'2015-09-08'),
(2,'2015-09-07'),
(3,'2015-09-09'),
(4,'2015-09-10'),
(5,'2015-09-09'),
(6,'2015-09-11'),
(7,'2015-09-06');

/*Table structure for table `test` */

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `id` int(11) DEFAULT NULL,
  `kat` enum('Agama','Komputer','Pendidikan','Kamus','Musik') DEFAULT NULL,
  `a` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `test` */

insert  into `test`(`id`,`kat`,`a`) values 
(1,NULL,9.7),
(2,NULL,NULL),
(3,NULL,NULL);

/*Table structure for table `v_buku` */

DROP TABLE IF EXISTS `v_buku`;

/*!50001 DROP VIEW IF EXISTS `v_buku` */;
/*!50001 DROP TABLE IF EXISTS `v_buku` */;

/*!50001 CREATE TABLE  `v_buku`(
 `id_buku` int(11) ,
 `judul_buku` varchar(255) ,
 `pengarang` varchar(20) ,
 `penerbit` varchar(20) ,
 `tahun` char(4) ,
 `id_kategori` int(11) ,
 `nama_kategori` varchar(20) 
)*/;

/*View structure for view v_buku */

/*!50001 DROP TABLE IF EXISTS `v_buku` */;
/*!50001 DROP VIEW IF EXISTS `v_buku` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_buku` AS (select `tbl_buku`.`id_buku` AS `id_buku`,`tbl_buku`.`judul_buku` AS `judul_buku`,`tbl_buku`.`pengarang` AS `pengarang`,`tbl_buku`.`penerbit` AS `penerbit`,`tbl_buku`.`tahun` AS `tahun`,`tbl_buku`.`id_kategori` AS `id_kategori`,`tbl_kategori`.`nama_kategori` AS `nama_kategori` from (`tbl_buku` join `tbl_kategori` on((`tbl_buku`.`id_kategori` = `tbl_kategori`.`id_kategori`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
