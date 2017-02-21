-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2017 a las 04:58:46
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 7.0.13

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
-- Estructura de tabla para la tabla `resultadodetalle`
--

CREATE TABLE `resultadodetalle` (
  `IdJuegoLimpio` int(11) NOT NULL,
  `IdJugador` int(11) NOT NULL,
  `IdResultado` int(11) NOT NULL,
  `Amarilla` int(11) NOT NULL,
  `Azul` int(11) NOT NULL,
  `Roja` int(11) NOT NULL,
  `Goles` int(11) NOT NULL,
  `IdEquipo` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla con los detalles del partido, goles y tarjeta';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `resultadodetalle`
--
ALTER TABLE `resultadodetalle`
  ADD PRIMARY KEY (`IdJuegoLimpio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `resultadodetalle`
--
ALTER TABLE `resultadodetalle`
  MODIFY `IdJuegoLimpio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
