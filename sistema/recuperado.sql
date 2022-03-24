-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2021 a las 00:33:25
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shaddai`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperado`
--

CREATE TABLE `recuperado` (
  `codrecuperado` int(11) NOT NULL,
  `descripcion_recuperado` varchar(100) NOT NULL,
  `fecha_recuperado` datetime NOT NULL,
  `codproducto` int(11) NOT NULL,
  `peso_recuperado` decimal(11,2) NOT NULL,
  `precioventa_recuperado` decimal(10,0) NOT NULL,
  `fechaventa_recuperado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recuperado`
--
ALTER TABLE `recuperado`
  ADD PRIMARY KEY (`codrecuperado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recuperado`
--
ALTER TABLE `recuperado`
  MODIFY `codrecuperado` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
