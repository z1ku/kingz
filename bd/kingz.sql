-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2023 a las 17:44:02
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kingz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapa`
--

CREATE TABLE `mapa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `mapa`
--

INSERT INTO `mapa` (`id`, `nombre`, `foto`) VALUES
(1, 'LOTUS', '1.jpg'),
(2, 'PEARL', '2.jpg'),
(3, 'FRACTURE', '3.webp'),
(4, 'BREEZE', '4.webp'),
(5, 'ICEBOX', '5.jpg'),
(6, 'BIND', '6.webp'),
(7, 'HAVEN', '7.webp'),
(8, 'SPLIT', '8.jpg'),
(9, 'ASCENT', '9.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` bigint(20) NOT NULL,
  `texto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_partida` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `texto` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participa`
--

CREATE TABLE `participa` (
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_partida` bigint(20) UNSIGNED NOT NULL,
  `equipo` char(1) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `participa`
--

INSERT INTO `participa` (`id_usuario`, `id_partida`, `equipo`) VALUES
(1, 1, 'A'),
(1, 2, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resultado_a` int(2) UNSIGNED NOT NULL,
  `resultado_b` int(2) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) UNSIGNED NOT NULL,
  `id_mapa` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id`, `resultado_a`, `resultado_b`, `fecha`, `estado`, `id_mapa`) VALUES
(1, 13, 9, '2023-04-30', 1, 1),
(2, 10, 13, '2023-04-29', 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `asunto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `texto` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nick` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `mmr` int(5) UNSIGNED DEFAULT NULL,
  `estado` tinyint(1) UNSIGNED DEFAULT NULL,
  `en_partida` tinyint(1) UNSIGNED DEFAULT NULL,
  `buscando` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nick`, `pass`, `correo`, `foto`, `mmr`, `estado`, `en_partida`, `buscando`) VALUES
(0, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', NULL, NULL, NULL, 1, NULL, NULL),
(1, 'z1ku', 'dfec4e38c65ebe19a60a8a6e0511a7f6', 'z1ku1337@gmail.com', '1.jpg', 1100, 1, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mapa`
--
ALTER TABLE `mapa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_mensaje_partida` (`id_partida`),
  ADD KEY `ce_mensaje_usuario` (`id_usuario`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participa`
--
ALTER TABLE `participa`
  ADD PRIMARY KEY (`id_usuario`,`id_partida`),
  ADD KEY `ce_participa_partida` (`id_partida`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_partida_mapa` (`id_mapa`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_ticket_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mapa`
--
ALTER TABLE `mapa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `ce_mensaje_partida` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id`),
  ADD CONSTRAINT `ce_mensaje_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `participa`
--
ALTER TABLE `participa`
  ADD CONSTRAINT `ce_participa_partida` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id`),
  ADD CONSTRAINT `ce_participa_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `ce_partida_mapa` FOREIGN KEY (`id_mapa`) REFERENCES `mapa` (`id`);

--
-- Filtros para la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ce_ticket_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
