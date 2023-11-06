/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.28-MariaDB : Database - db_camera
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_camera` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_camera`;

/*Table structure for table `tb_camera` */

DROP TABLE IF EXISTS `tb_camera`;

CREATE TABLE `tb_camera` (
  `id_camera` int(11) NOT NULL AUTO_INCREMENT,
  `nama_camera` varchar(255) DEFAULT NULL,
  `harga_sewa_harian` decimal(10,0) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_camera`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tb_camera` */

insert  into `tb_camera`(`id_camera`,`nama_camera`,`harga_sewa_harian`,`deskripsi`) values 
(1,'Canon',150000,'Ini adalah canon'),
(2,'Panasonic',140000,'Ini adalah panasonic'),
(3,'Sony',150000,'Ini adalah sony');

/*Table structure for table `tb_customer` */

DROP TABLE IF EXISTS `tb_customer`;

CREATE TABLE `tb_customer` (
  `id_customer` int(11) NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tb_customer` */

insert  into `tb_customer`(`id_customer`,`nama_customer`,`email`,`alamat`,`nomor_telepon`) values 
(1,'Patrik','patrik45@gmail.com','jalan komodo 149','089789567345');

/*Table structure for table `tb_det_transaksi` */

DROP TABLE IF EXISTS `tb_det_transaksi`;

CREATE TABLE `tb_det_transaksi` (
  `id_det_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `id_camera` int(11) NOT NULL,
  `jumlah_hari_sewa` int(11) NOT NULL,
  `harga_sewa` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_det_transaksi`),
  KEY `id_transaksi` (`id_transaksi`),
  KEY `id_camera` (`id_camera`),
  CONSTRAINT `tb_det_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id_transaksi`),
  CONSTRAINT `tb_det_transaksi_ibfk_2` FOREIGN KEY (`id_camera`) REFERENCES `tb_camera` (`id_camera`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tb_det_transaksi` */

insert  into `tb_det_transaksi`(`id_det_transaksi`,`id_transaksi`,`id_camera`,`jumlah_hari_sewa`,`harga_sewa`) values 
(33,10,2,1,140000),
(34,9,3,8,1200000),
(35,9,1,8,1200000),
(36,12,2,1,140000),
(37,12,1,1,150000);

/*Table structure for table `tb_pegawai` */

DROP TABLE IF EXISTS `tb_pegawai`;

CREATE TABLE `tb_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tb_pegawai` */

insert  into `tb_pegawai`(`id_pegawai`,`nama_pegawai`,`email`,`alamat`,`nomor_telepon`) values 
(1,'Psnjul','panjul71@gmail.com','jalan melati 14','081345543567');

/*Table structure for table `tb_pengembalian` */

DROP TABLE IF EXISTS `tb_pengembalian`;

CREATE TABLE `tb_pengembalian` (
  `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id_pengembalian`),
  KEY `id_transaksi` (`id_transaksi`),
  CONSTRAINT `tb_pengembalian_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tb_pengembalian` */

/*Table structure for table `tb_transaksi` */

DROP TABLE IF EXISTS `tb_transaksi`;

CREATE TABLE `tb_transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `tanggal_mulai_sewa` date NOT NULL,
  `tanggal_akhir_sewa` date NOT NULL,
  `total_harga` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_pegawai` (`id_pegawai`),
  KEY `id_customer` (`id_customer`),
  CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `tb_pegawai` (`id_pegawai`),
  CONSTRAINT `tb_transaksi_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `tb_customer` (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tb_transaksi` */

insert  into `tb_transaksi`(`id_transaksi`,`id_pegawai`,`id_customer`,`tanggal_pemesanan`,`tanggal_mulai_sewa`,`tanggal_akhir_sewa`,`total_harga`) values 
(9,1,1,'2023-10-30','2023-11-02','2023-11-10',2400000),
(10,1,1,'2023-10-31','2023-11-01','2023-11-02',140000),
(12,1,1,'2023-10-31','2023-11-01','2023-11-02',290000);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
