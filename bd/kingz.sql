-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2023 a las 19:09:50
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
  `marca` int(100) NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_partida` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `texto`, `marca`, `id_usuario`, `id_partida`) VALUES
(1, 'Hola', 1683622150, 1, 4),
(2, 'que tal', 1683622219, 1, 4),
(3, 'soy colosal', 1683622406, 1, 4),
(4, 'soy colosal', 1683622426, 1, 4),
(5, 'si', 1683622584, 1, 4),
(6, 'te la mamas', 1683622611, 2, 4),
(25, 'pene', 1683623471, 2, 4),
(26, 'awdawwd', 1683623479, 2, 4),
(27, 'adwaad', 1683623480, 2, 4),
(29, 'dada', 1683627953, 1, 4),
(30, 'aadwadwaawawaaaaa', 1683635131, 1, 4),
(31, 'aaaa', 1683635331, 1, 4),
(32, 'Amazing', 1683635454, 1, 4),
(33, 'keeek', 1683636217, 1, 4),
(34, 'Hola', 1683636498, 2, 4),
(35, 'dawd', 1683638668, 2, 4);

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
(1, 2, 'A'),
(1, 3, 'A'),
(1, 4, 'A'),
(2, 3, 'B'),
(2, 4, 'B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resultado_a` int(2) UNSIGNED DEFAULT NULL,
  `resultado_b` int(2) UNSIGNED DEFAULT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) UNSIGNED NOT NULL,
  `id_mapa` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id`, `resultado_a`, `resultado_b`, `fecha`, `estado`, `id_mapa`) VALUES
(1, 13, 9, '2023-04-30', 1, 1),
(2, 10, 13, '2023-04-29', 1, 8),
(3, 13, 8, '2023-05-07', 1, 4),
(4, 13, 9, '2023-05-07', 1, 7);

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
(1, 'z1ku', 'dfec4e38c65ebe19a60a8a6e0511a7f6', 'z1ku1337@gmail.com', '1.jpg', 3020, 1, 0, 1),
(2, 'xaxy', 'd3349b369d1ff01490bdb9760d4fcea8', NULL, NULL, 1080, 1, 0, 0),
(3, 'deeky', '0650f453b5b1d2266da93e86cd39910a', NULL, NULL, 1100, 1, 0, 0);

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
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
