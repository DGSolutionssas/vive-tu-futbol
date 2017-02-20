-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2017 a las 04:37:32
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
-- Estructura de tabla para la tabla `resultados`
--

CREATE TABLE `resultados` (
  `IdResultado` int(11) NOT NULL,
  `IdFecha` int(11) NOT NULL,
  `IdCampeonato` int(11) NOT NULL,
  `IdEquipo1` int(11) NOT NULL,
  `IdEquipo2` int(11) NOT NULL,
  `Goles1` int(11) NOT NULL,
  `Goles2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla para los resultados';

--
-- Volcado de datos para la tabla `resultados`
--

INSERT INTO `resultados` (`IdResultado`, `IdFecha`, `IdCampeonato`, `IdEquipo1`, `IdEquipo2`, `Goles1`, `Goles2`) VALUES
(3, 2, 1, 1, 2, 2, 1),
(4, 3, 1, 1, 2, 2, 3),
(5, 2, 4, 6, 5, 1, 6),
(6, 3, 4, 6, 5, 2, 6),
(7, 2, 4, 6, 5, 2, 0),
(8, 3, 4, 5, 6, 3, 3),
(9, 3, 4, 2, 1, 6, 4),
(10, 3, 1, 2, 1, 8, 10),
(11, 4, 4, 2, 5, 5, 4),
(12, 4, 4, 6, 5, 3, 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`IdResultado`),
  ADD KEY `IdCampeonato` (`IdCampeonato`),
  ADD KEY `IdEquipo1` (`IdEquipo1`),
  ADD KEY `IdEquipo2` (`IdEquipo2`),
  ADD KEY `IdFecha` (`IdFecha`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `resultados`
--
ALTER TABLE `resultados`
  MODIFY `IdResultado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `fk_Resultado_Campeonato` FOREIGN KEY (`IdCampeonato`) REFERENCES `campeonatos` (`IdCampeonato`),
  ADD CONSTRAINT `fk_Resultado_Equipo1` FOREIGN KEY (`IdEquipo1`) REFERENCES `equipos` (`IdEquipo`),
  ADD CONSTRAINT `fk_Resultado_Equipo2` FOREIGN KEY (`IdEquipo2`) REFERENCES `equipos` (`IdEquipo`),
  ADD CONSTRAINT `fk_Resultado_Fecha` FOREIGN KEY (`IdFecha`) REFERENCES `fechas` (`IdFecha`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
