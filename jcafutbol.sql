-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-01-2017 a las 23:45:53
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
-- Estructura de tabla para la tabla `campeonatos`
--

CREATE TABLE `campeonatos` (
  `IdCampeonato` int(11) NOT NULL,
  `Campeonato` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Grupos` int(11) NOT NULL,
  `Equipos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `campeonatos`
--

INSERT INTO `campeonatos` (`IdCampeonato`, `Campeonato`, `Descripcion`, `Grupos`, `Equipos`) VALUES
(1, 'CAMPEONATO NAVIDEO 2016', 'CAMPEONATO NAVIDEO 2016', 2, 12),
(2, 'Prueba', 'Prueba', 1, 1),
(4, 'La Championsssss', 'Campeonato Aficionado', 2, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `IdEquipo` int(11) NOT NULL,
  `IdCampeonato` int(11) DEFAULT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Puntos` int(11) DEFAULT NULL,
  `Grupo` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`IdEquipo`, `IdCampeonato`, `Nombre`, `Descripcion`, `Puntos`, `Grupo`) VALUES
(1, 1, 'Cachamas FC', 'Cachamas FC Casanare', 0, '1'),
(2, 1, 'Sirenas F.C', 'Sirenas F.C', NULL, '1'),
(3, 1, 'DGFutbol', 'DGFutbol', NULL, '2'),
(4, 1, 'Leopardos FC', 'Leopardos FC', NULL, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas`
--

CREATE TABLE `fechas` (
  `IdFecha` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fechas`
--

INSERT INTO `fechas` (`IdFecha`, `Descripcion`) VALUES
(1, 'fecha1');

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
(1, 1, 1, 1, 2, 2, 3),
(2, 1, 1, 1, 2, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Usuario`, `Nombre`, `Password`) VALUES
(1, 'admin', 'ADMINISTRADOR JCA FUTBOL', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `campeonatos`
--
ALTER TABLE `campeonatos`
  ADD PRIMARY KEY (`IdCampeonato`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`IdEquipo`),
  ADD KEY `fk_Equipos_Campeonatos` (`IdCampeonato`);

--
-- Indices de la tabla `fechas`
--
ALTER TABLE `fechas`
  ADD PRIMARY KEY (`IdFecha`);

--
-- Indices de la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`IdResultado`),
  ADD KEY `IdCampeonato` (`IdCampeonato`),
  ADD KEY `IdEquipo1` (`IdEquipo1`),
  ADD KEY `IdEquipo2` (`IdEquipo2`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `campeonatos`
--
ALTER TABLE `campeonatos`
  MODIFY `IdCampeonato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `IdEquipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `fechas`
--
ALTER TABLE `fechas`
  MODIFY `IdFecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `resultados`
--
ALTER TABLE `resultados`
  MODIFY `IdResultado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `fk_Equipos_Campeonatos` FOREIGN KEY (`IdCampeonato`) REFERENCES `campeonatos` (`IdCampeonato`);

--
-- Filtros para la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `fk_Resultado_Campeonato` FOREIGN KEY (`IdCampeonato`) REFERENCES `campeonatos` (`IdCampeonato`),
  ADD CONSTRAINT `fk_Resultado_Equipo1` FOREIGN KEY (`IdEquipo1`) REFERENCES `equipos` (`IdEquipo`),
  ADD CONSTRAINT `fk_Resultado_Equipo2` FOREIGN KEY (`IdEquipo2`) REFERENCES `equipos` (`IdEquipo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
