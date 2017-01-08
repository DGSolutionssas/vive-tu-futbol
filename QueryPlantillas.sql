/*
SQLyog Community v12.3.2 (64 bit)
MySQL - 10.1.16-MariaDB : Database - jcafutbol
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jcafutbol` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `jcafutbol`;

/*Table structure for table `jugadores` */

DROP TABLE IF EXISTS `jugadores`;

CREATE TABLE `jugadores` (
  `idJugador` int(11) NOT NULL AUTO_INCREMENT,
  `Cedula` varchar(50) DEFAULT NULL,
  `Nombres` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idJugador`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `jugadores` */

insert  into `jugadores`(`idJugador`,`Cedula`,`Nombres`,`Apellidos`) values 
(1,'1115854830','Diego Fernando','Saavedra Reyes'),
(2,'123','Jose Gregorio','Castillo'),
(3,'1234','Gustavo Adolfo','Gonzalez'),
(4,'12345','Sebastian','Melo'),
(5,'123456','Carlos','Agudelo'),
(6,'222222','Jaime','Carreno');

/*Table structure for table `tblequiposjugadores` */

DROP TABLE IF EXISTS `tblequiposjugadores`;

CREATE TABLE `tblequiposjugadores` (
  `IdEquipoJugadores` int(11) NOT NULL AUTO_INCREMENT,
  `IdEquipo` int(11) DEFAULT NULL,
  `IdJugador` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEquipoJugadores`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tblequiposjugadores` */

insert  into `tblequiposjugadores`(`IdEquipoJugadores`,`IdEquipo`,`IdJugador`) values 
(1,1,1),
(2,1,2),
(3,1,3),
(4,4,4),
(5,4,5),
(6,4,6);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
