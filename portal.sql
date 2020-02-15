-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-02-2020 a las 02:35:05
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `portal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `apellido` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `cedula` int(10) UNSIGNED NOT NULL,
  `telefono` int(11) UNSIGNED NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `edad` tinyint(3) UNSIGNED NOT NULL,
  `ciudad` varchar(15) NOT NULL,
  `departamento` varchar(15) NOT NULL,
  `codigoPostal` mediumint(8) UNSIGNED NOT NULL,
  `imagen` varchar(40) NOT NULL,
  `fecha` int(10) UNSIGNED NOT NULL,
  `rol` enum('administrador','registrado') NOT NULL DEFAULT 'registrado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `apellido`, `email`, `contrasena`, `cedula`, `telefono`, `direccion`, `edad`, `ciudad`, `departamento`, `codigoPostal`, `imagen`, `fecha`, `rol`) VALUES
(1, 'root', 'root', 'root@email.com', '$2a$08$esZ6JVPWaWo.rSYDUJ98JeiJJLk7.he.Om6ouBKetFcEdGw2RQStK', 111111, 111111, 'calle', 55, 'kasa', 'kasa', 1234, 'fotos/root/profile.jpg', 1581729880, 'administrador'),
(2, 'anonimo', 'anonimo', 'anonimo@email.com', '$2a$08$qplDM2ImsRCepEi/BFadluraDAVDM4GKKtc9aNq9cFho.XeXxrfPu', 222222, 222222, 'calle', 55, 'kasa', 'kasa', 4454, 'fotos/anonimo/profile.jpg', 1581729998, 'registrado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `ced_unico` (`cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
