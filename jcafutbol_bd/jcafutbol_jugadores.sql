-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-01-2017 a las 18:36:28
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jcafutbol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Jugador`
--

CREATE TABLE `Jugador` (
  `IdJugador` int(11) NOT NULL,
  `NombreJugador` varchar(255) NOT NULL,
  `Documento` int(30) NOT NULL,
  `CorreoElectronico` varchar(255) NOT NULL,
  `Celular` int(10) NOT NULL,
  `DirectorTecnico` tinyint(1) NOT NULL DEFAULT '0',
  `Delegado` tinyint(1) NOT NULL DEFAULT '0',
  `RepresentanteLegal` tinyint(1) NOT NULL DEFAULT '0',
  `Url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Jugador`
--

INSERT INTO `Jugador` (`IdJugador`, `NombreJugador`, `Documento`, `CorreoElectronico`, `Celular`, `DirectorTecnico`, `Delegado`, `RepresentanteLegal`, `Url`) VALUES
(1, 'juan', 12345, 'sebastian', 317672637, 1, 0, 0, ''),
(3, 'sebasia', 1234, 'sebas@as.com', 1234, 1, 0, 0, ''),
(4, 'julian', 123440, 's@s.c', 1203948390, 0, 1, 0, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Jugador`
--
ALTER TABLE `Jugador`
  ADD PRIMARY KEY (`IdJugador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Jugador`
--
ALTER TABLE `Jugador`
  MODIFY `IdJugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
