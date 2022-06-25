/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.14-MariaDB : Database - autoSkola
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`autoSkola` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `autoSkola`;

/*Table structure for table `iskustvo` */

DROP TABLE IF EXISTS `iskustvo`;

CREATE TABLE `iskustvo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `iskustvo` */

insert  into `iskustvo`(`id`,`naziv`) values 
(1,'zavrsio teorijsku obuku'),
(2,'zavrsio prakticnu obuku'),
(3,'ucio u drugoj autoskoli'),
(4,'pao');

/*Table structure for table `kandidat` */

DROP TABLE IF EXISTS `kandidat`;

CREATE TABLE `kandidat` (
  `id` bigint(20) NOT NULL,
  `imePrezime` varchar(40) NOT NULL,
  `godiste` int(20) NOT NULL,
  `napomena` varchar(90) DEFAULT NULL,
  `iskustvo` bigint(20) NOT NULL,
  `kategorija` bigint(20) NOT NULL,
  `slika` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kandidat_ibfk_1` (`iskustvo`),
  KEY `kandidat_ibfk_2` (`kategorija`),
  CONSTRAINT `kandidat_ibfk_1` FOREIGN KEY (`iskustvo`) REFERENCES `iskustvo` (`id`),
  CONSTRAINT `kandidat_ibfk_2` FOREIGN KEY (`kategorija`) REFERENCES `kategorija` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `kandidat` */

/*Table structure for table `kategorija` */

DROP TABLE IF EXISTS `kategorija`;

CREATE TABLE `kategorija` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kategorija` */

insert  into `kategorija`(`id`,`naziv`) values 
(1,'crvena'),
(2,'bela'),
(3,'plava'),
(4,'siva'),
(5,'crna');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
