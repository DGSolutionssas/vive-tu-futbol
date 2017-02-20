CREATE DATABASE  IF NOT EXISTS `jcafutbol` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `jcafutbol`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: jcafutbol
-- ------------------------------------------------------
-- Server version	5.6.22-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `resultados`
--

DROP TABLE IF EXISTS `resultados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultados` (
  `IdResultado` int(11) NOT NULL AUTO_INCREMENT,
  `IdFecha` int(11) NOT NULL,
  `IdCampeonato` int(11) NOT NULL,
  `IdEquipo1` int(11) NOT NULL,
  `IdEquipo2` int(11) NOT NULL,
  `Goles1` int(11) NOT NULL,
  `Goles2` int(11) NOT NULL,
  PRIMARY KEY (`IdResultado`),
  KEY `IdCampeonato` (`IdCampeonato`),
  KEY `IdEquipo1` (`IdEquipo1`),
  KEY `IdEquipo2` (`IdEquipo2`),
  KEY `IdFecha` (`IdFecha`),
  CONSTRAINT `fk_Resultado_Campeonato` FOREIGN KEY (`IdCampeonato`) REFERENCES `campeonatos` (`IdCampeonato`),
  CONSTRAINT `fk_Resultado_Equipo1` FOREIGN KEY (`IdEquipo1`) REFERENCES `equipos` (`IdEquipo`),
  CONSTRAINT `fk_Resultado_Equipo2` FOREIGN KEY (`IdEquipo2`) REFERENCES `equipos` (`IdEquipo`),
  CONSTRAINT `fk_Resultado_Fecha` FOREIGN KEY (`IdFecha`) REFERENCES `fechas` (`IdFecha`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Tabla para los resultados';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-10 20:55:19
