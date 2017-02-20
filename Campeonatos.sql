/*
SQLyog Community v12.3.2 (64 bit)
MySQL - 10.1.16-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `campeonatos` (
	`IdCampeonato` int (11),
	`Campeonato` varchar (765),
	`Descripcion` varchar (765),
	`Grupos` int (11),
	`Equipos` int (11),
	`CantidadJugadores` int (2)
); 
insert into `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`, `CantidadJugadores`) values('1','CAMPEONATO NAVIDEO 2016','CAMPEONATO NAVIDEO 2016','2','12',NULL);
insert into `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`, `CantidadJugadores`) values('2','Prueba','Prueba','1','1',NULL);
insert into `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`, `CantidadJugadores`) values('3','Prueba2','Prueba2','3','4',NULL);
insert into `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`, `CantidadJugadores`) values('4','Prueba Campeonato','Prueba Campeonato','2','12',NULL);
insert into `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`, `CantidadJugadores`) values('5','Campeonato Femenino','Campeonato Femenino','5','8',NULL);
insert into `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`, `CantidadJugadores`) values('6','Campeonato Femenino 2','Campeonato Femenino 2','5','40',NULL);
insert into `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`, `CantidadJugadores`) values('8','PRUE','PRUEB','2','12',NULL);
