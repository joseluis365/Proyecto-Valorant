-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 19-10-2025 a las 19:13:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `valorant`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arma`
--

CREATE TABLE `arma` (
  `id_arma` int(11) NOT NULL,
  `nombre_arma` varchar(100) NOT NULL,
  `descrip_arma` text DEFAULT NULL,
  `img_arma` varchar(255) DEFAULT NULL,
  `img_fondo` varchar(255) DEFAULT NULL,
  `balas` int(11) DEFAULT NULL,
  `video_arma` varchar(255) DEFAULT NULL,
  `dano_cabeza` int(11) DEFAULT NULL,
  `dano_cuerpo` int(11) DEFAULT NULL,
  `id_tipo_arma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arma`
--

INSERT INTO `arma` (`id_arma`, `nombre_arma`, `descrip_arma`, `img_arma`, `img_fondo`, `balas`, `video_arma`, `dano_cabeza`, `dano_cuerpo`, `id_tipo_arma`) VALUES
(1, 'Classic', 'Ligera y versátil, el arma por defecto es todo un clásico.', 'img-pistola1.png', 'fondo_pistola1.png', 15, 'video_pistola1.mp4', 10, 7, 2),
(2, 'Ghost', 'Con silenciador, precisa y estupenda a cualquier distancia.', 'img-pistola2.png', 'fondo_pistola2.png', 12, 'video_pistola2.mp4', 5, 3, 2),
(3, 'Sheriff', 'Perfecto para aquellos que busquen siempre el disparo a la cabeza.', 'img-pistola3.png', 'fondo_pistola3.png', 6, 'video_pistola3.mp4', 12, 4, 2),
(4, 'Spectre', 'Ante la duda, apostad por el Spectre', 'img-fusil1.png', 'fondo_fusil1.png', 30, 'video_fusil1.mp4', 20, 10, 3),
(5, 'Vandal', 'Esta precisa y potente arma es temible a media distancia.', 'img-fusil2.png', 'fondo_fusil2.png', 25, 'video_fusil2.mp4', 25, 15, 3),
(6, 'Odin', 'Esta monstruosidad podrá traeros la gloria en el campo.', 'img-fusil3.png', 'fondo_fusil3.png', 40, 'video_fusil3.mp4', 20, 15, 3),
(7, 'Marshal', 'Respirad hondo y conseguid que se arrepientan de doblar la esquina.', 'img-franco1.png', 'fondo_franco1.png', 5, 'video_franco1.mp4', 25, 15, 4),
(8, 'Outlaw', 'Dos cañones, un impacto único. La elección idónea.', 'img-franco2.png', 'fondo_franco2.png', 6, 'video_franco2.mp4', 30, 15, 4),
(9, 'Operator', 'Poneos cómodos, porque la zona es vuestra.', 'img-franco3.png', 'fondo_franco3.png', 4, 'video_franco3.mp4', 35, 20, 4),
(10, 'Navaja Tactica', 'Una solución de lo más íntima.', 'img-cuchillo.png', 'fondo_cuchillo.png', 0, 'video_cuchillo.mp4', 20, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner`
--

CREATE TABLE `banner` (
  `id_banner` int(11) NOT NULL,
  `banner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `tipo_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapa`
--

CREATE TABLE `mapa` (
  `id_mapa` int(11) NOT NULL,
  `nombre_mapa` varchar(100) NOT NULL,
  `imagen_mapa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id_partida` int(11) NOT NULL,
  `id_ganador` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `id_sala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida_jugador`
--

CREATE TABLE `partida_jugador` (
  `id_partida_jugador` int(11) NOT NULL,
  `id_partida` int(11) DEFAULT NULL,
  `id_objetivo` int(11) DEFAULT NULL,
  `id_atacante` int(11) DEFAULT NULL,
  `dano_causado` int(11) DEFAULT NULL,
  `dano_recibido` int(11) DEFAULT NULL,
  `vida_inicial` int(11) DEFAULT NULL,
  `vida_final` int(11) DEFAULT NULL,
  `kills` int(11) DEFAULT NULL,
  `subtotal_puntos` int(11) DEFAULT NULL,
  `jugadores_eliminados` int(11) DEFAULT NULL,
  `dano_cuerpo` int(11) DEFAULT NULL,
  `id_arma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personaje`
--

CREATE TABLE `personaje` (
  `id_personaje` int(11) NOT NULL,
  `nombre_personaje` varchar(100) NOT NULL,
  `imagen_personaje` varchar(255) DEFAULT NULL,
  `descripcion_personaje` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rango`
--

CREATE TABLE `rango` (
  `id_rango` int(11) NOT NULL,
  `nombre_rango` varchar(100) NOT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `puntos_requeridos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rango`
--

INSERT INTO `rango` (`id_rango`, `nombre_rango`, `icono`, `puntos_requeridos`) VALUES
(1, 'Platino', 'platino.png', 0),
(2, 'Diamante', 'diamante.png', 500),
(3, 'Ascendente', 'ascendente.png', 1000),
(4, 'Inmortal', 'inmortal.png', 1500),
(5, 'Radiante', 'radiante.png', 2000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `id_sala` int(11) NOT NULL,
  `max_jugadores` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `imagen_fondo` varchar(255) DEFAULT NULL,
  `id_nivel_min` int(11) DEFAULT NULL,
  `id_mapa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_arma`
--

CREATE TABLE `tipo_arma` (
  `id_tipo_arma` int(11) NOT NULL,
  `tipo_arma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_arma`
--

INSERT INTO `tipo_arma` (`id_tipo_arma`, `tipo_arma`) VALUES
(1, 'Melee'),
(2, 'Pistola'),
(3, 'Ametralladora'),
(4, 'Francotirador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tip_user`
--

CREATE TABLE `tip_user` (
  `id_tipo_user` int(11) NOT NULL,
  `tipo_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `id_tipo_user` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_rango` int(11) DEFAULT NULL,
  `id_banner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_personaje`
--

CREATE TABLE `user_personaje` (
  `id_user_per` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_personaje` int(11) DEFAULT NULL,
  `predeterminado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_sala`
--

CREATE TABLE `usuario_sala` (
  `id_usu_sala` int(11) NOT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `id_sala` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arma`
--
ALTER TABLE `arma`
  ADD PRIMARY KEY (`id_arma`),
  ADD KEY `id_tipo_arma` (`id_tipo_arma`);

--
-- Indices de la tabla `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `mapa`
--
ALTER TABLE `mapa`
  ADD PRIMARY KEY (`id_mapa`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id_partida`),
  ADD KEY `id_ganador` (`id_ganador`),
  ADD KEY `id_sala` (`id_sala`);

--
-- Indices de la tabla `partida_jugador`
--
ALTER TABLE `partida_jugador`
  ADD PRIMARY KEY (`id_partida_jugador`),
  ADD KEY `id_partida` (`id_partida`),
  ADD KEY `id_objetivo` (`id_objetivo`),
  ADD KEY `id_atacante` (`id_atacante`),
  ADD KEY `id_arma` (`id_arma`);

--
-- Indices de la tabla `personaje`
--
ALTER TABLE `personaje`
  ADD PRIMARY KEY (`id_personaje`);

--
-- Indices de la tabla `rango`
--
ALTER TABLE `rango`
  ADD PRIMARY KEY (`id_rango`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`id_sala`),
  ADD KEY `id_nivel_min` (`id_nivel_min`),
  ADD KEY `id_mapa` (`id_mapa`);

--
-- Indices de la tabla `tipo_arma`
--
ALTER TABLE `tipo_arma`
  ADD PRIMARY KEY (`id_tipo_arma`);

--
-- Indices de la tabla `tip_user`
--
ALTER TABLE `tip_user`
  ADD PRIMARY KEY (`id_tipo_user`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_tipo_user` (`id_tipo_user`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_rango` (`id_rango`),
  ADD KEY `id_avatar` (`id_banner`);

--
-- Indices de la tabla `user_personaje`
--
ALTER TABLE `user_personaje`
  ADD PRIMARY KEY (`id_user_per`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_personaje` (`id_personaje`);

--
-- Indices de la tabla `usuario_sala`
--
ALTER TABLE `usuario_sala`
  ADD PRIMARY KEY (`id_usu_sala`),
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arma`
--
ALTER TABLE `arma`
  MODIFY `id_arma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `banner`
--
ALTER TABLE `banner`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mapa`
--
ALTER TABLE `mapa`
  MODIFY `id_mapa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida_jugador`
--
ALTER TABLE `partida_jugador`
  MODIFY `id_partida_jugador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personaje`
--
ALTER TABLE `personaje`
  MODIFY `id_personaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rango`
--
ALTER TABLE `rango`
  MODIFY `id_rango` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_arma`
--
ALTER TABLE `tipo_arma`
  MODIFY `id_tipo_arma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tip_user`
--
ALTER TABLE `tip_user`
  MODIFY `id_tipo_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_personaje`
--
ALTER TABLE `user_personaje`
  MODIFY `id_user_per` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_sala`
--
ALTER TABLE `usuario_sala`
  MODIFY `id_usu_sala` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arma`
--
ALTER TABLE `arma`
  ADD CONSTRAINT `arma_ibfk_1` FOREIGN KEY (`id_tipo_arma`) REFERENCES `tipo_arma` (`id_tipo_arma`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`id_ganador`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `partida_ibfk_2` FOREIGN KEY (`id_sala`) REFERENCES `sala` (`id_sala`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `partida_jugador`
--
ALTER TABLE `partida_jugador`
  ADD CONSTRAINT `partida_jugador_ibfk_1` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id_partida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partida_jugador_ibfk_2` FOREIGN KEY (`id_objetivo`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `partida_jugador_ibfk_3` FOREIGN KEY (`id_atacante`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `partida_jugador_ibfk_4` FOREIGN KEY (`id_arma`) REFERENCES `arma` (`id_arma`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `sala_ibfk_1` FOREIGN KEY (`id_nivel_min`) REFERENCES `rango` (`id_rango`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sala_ibfk_2` FOREIGN KEY (`id_mapa`) REFERENCES `mapa` (`id_mapa`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_tipo_user`) REFERENCES `tip_user` (`id_tipo_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`id_rango`) REFERENCES `rango` (`id_rango`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`id_banner`) REFERENCES `banner` (`id_banner`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_personaje`
--
ALTER TABLE `user_personaje`
  ADD CONSTRAINT `user_personaje_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_personaje_ibfk_2` FOREIGN KEY (`id_personaje`) REFERENCES `personaje` (`id_personaje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_sala`
--
ALTER TABLE `usuario_sala`
  ADD CONSTRAINT `usuario_sala_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `sala` (`id_sala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_sala_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
