-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-11-2025 a las 18:18:51
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
  `id_tipo_arma` int(11) DEFAULT NULL,
  `rango_requerido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arma`
--

INSERT INTO `arma` (`id_arma`, `nombre_arma`, `descrip_arma`, `img_arma`, `img_fondo`, `balas`, `video_arma`, `dano_cabeza`, `dano_cuerpo`, `id_tipo_arma`, `rango_requerido`) VALUES
(1, 'Classic', 'Ligera y versátil, el arma por defecto es todo un clásico.', 'img-pistola1.png', 'fondo_pistola1.png', 15, 'video_pistola1.mp4', 10, 7, 2, 1),
(2, 'Ghost', 'Con silenciador, precisa y estupenda a cualquier distancia.', 'img-pistola2.png', 'fondo_pistola2.png', 12, 'video_pistola2.mp4', 5, 3, 2, 1),
(3, 'Sheriff', 'Perfecto para aquellos que busquen siempre el disparo a la cabeza.', 'img-pistola3.png', 'fondo_pistola3.png', 6, 'video_pistola3.mp4', 12, 4, 2, 1),
(4, 'Spectre', 'Ante la duda, apostad por el Spectre', 'img-fusil1.png', 'fondo_fusil1.png', 30, 'video_fusil1.mp4', 20, 10, 3, 2),
(5, 'Vandal', 'Esta precisa y potente arma es temible a media distancia.', 'img-fusil2.png', 'fondo_fusil2.png', 25, 'video_fusil2.mp4', 25, 15, 3, 2),
(6, 'Odin', 'Esta monstruosidad podrá traeros la gloria en el campo.', 'img-fusil3.png', 'fondo_fusil3.png', 40, 'video_fusil3.mp4', 20, 15, 3, 2),
(7, 'Marshal', 'Respirad hondo y conseguid que se arrepientan de doblar la esquina.', 'img-franco1.png', 'fondo_franco1.png', 5, 'video_franco1.mp4', 25, 15, 4, 2),
(8, 'Outlaw', 'Dos cañones, un impacto único. La elección idónea.', 'img-franco2.png', 'fondo_franco2.png', 6, 'video_franco2.mp4', 30, 15, 4, 2),
(9, 'Operator', 'Poneos cómodos, porque la zona es vuestra.', 'img-franco3.png', 'fondo_franco3.png', 4, 'video_franco3.mp4', 35, 20, 4, 2),
(10, 'Navaja Tactica', 'Una solución de lo más íntima.', 'img-cuchillo.png', 'fondo_cuchillo.png', 0, 'video_cuchillo.mp4', 20, 10, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `id_avatar` int(11) NOT NULL,
  `avatar` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`id_avatar`, `avatar`) VALUES
(1, 'avatar_001.jpg'),
(2, 'avatar_002.jpg'),
(3, 'avatar_003.jpg'),
(4, 'avatar_004.jpg'),
(5, 'avatar_005.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner`
--

CREATE TABLE `banner` (
  `id_banner` int(11) NOT NULL,
  `banner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `banner`
--

INSERT INTO `banner` (`id_banner`, `banner`) VALUES
(1, 'banner_001.jpg'),
(2, 'banner_002.jpg'),
(3, 'banner_003.jpg'),
(4, 'banner_004.jpg'),
(5, 'banner_005.jpg'),
(6, 'banner_006.jpg'),
(7, 'banner_007.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `fecha_mensaje` time NOT NULL,
  `id_sala` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat`
--

INSERT INTO `chat` (`id_chat`, `mensaje`, `fecha_mensaje`, `id_sala`, `id_user`) VALUES
(45, 'hola', '22:14:16', 35, 6),
(46, 'hola', '22:14:20', 35, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `tipo_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `tipo_estado`) VALUES
(1, 'Activo'),
(2, 'Bloqueado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_disparos`
--

CREATE TABLE `log_disparos` (
  `id_log` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_sala` int(11) DEFAULT NULL,
  `id_atacante` int(11) NOT NULL,
  `id_objetivo` int(11) NOT NULL,
  `id_arma` int(11) DEFAULT NULL,
  `tipo_disparo` enum('cabeza','cuerpo') NOT NULL,
  `dano_aplicado` int(11) NOT NULL,
  `puntos_otorgados` int(11) NOT NULL DEFAULT 0,
  `es_eliminacion` tinyint(1) NOT NULL DEFAULT 0,
  `vida_inicial` int(11) DEFAULT NULL,
  `vida_final` int(11) DEFAULT NULL,
  `meta_info` varchar(255) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `log_disparos`
--

INSERT INTO `log_disparos` (`id_log`, `id_partida`, `id_sala`, `id_atacante`, `id_objetivo`, `id_arma`, `tipo_disparo`, `dano_aplicado`, `puntos_otorgados`, `es_eliminacion`, `vida_inicial`, `vida_final`, `meta_info`, `fecha`) VALUES
(43, 6, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 02:25:58'),
(44, 6, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 02:26:00'),
(45, 6, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 02:26:02'),
(46, 6, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 02:26:02'),
(47, 6, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 20, 0, NULL, '2025-11-05 02:26:04'),
(48, 6, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:26:05'),
(49, 6, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:26:06'),
(50, 6, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:26:07'),
(51, 6, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:26:09'),
(52, 6, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:26:09'),
(53, 6, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:26:09'),
(54, 6, NULL, 6, 5, 5, 'cabeza', 25, 10, 0, 100, 75, NULL, '2025-11-05 02:26:24'),
(55, 6, NULL, 6, 5, 5, 'cabeza', 25, 10, 0, 75, 50, NULL, '2025-11-05 02:26:26'),
(56, 6, NULL, 6, 5, 5, 'cabeza', 25, 10, 0, 50, 25, NULL, '2025-11-05 02:26:28'),
(57, 6, NULL, 6, 5, 5, 'cabeza', 25, 90, 1, 25, 0, NULL, '2025-11-05 02:26:30'),
(58, 6, NULL, 6, 5, 5, 'cabeza', 25, 90, 1, 25, 0, NULL, '2025-11-05 02:26:30'),
(59, 6, NULL, 6, 5, 5, 'cabeza', 25, 90, 1, 0, 0, NULL, '2025-11-05 02:26:32'),
(60, 6, NULL, 6, 5, 5, 'cabeza', 25, 90, 1, 0, 0, NULL, '2025-11-05 02:26:32'),
(61, 8, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 02:55:02'),
(62, 8, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 02:55:36'),
(63, 8, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 02:55:37'),
(64, 8, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 02:55:40'),
(65, 8, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 02:55:43'),
(66, 8, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 02:56:14'),
(67, 8, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 02:57:33'),
(68, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 20, 0, NULL, '2025-11-05 02:58:01'),
(69, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:58:24'),
(70, 8, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 02:59:12'),
(71, 8, NULL, 6, 5, 10, 'cabeza', 20, 81, 1, 20, 0, NULL, '2025-11-05 02:59:16'),
(72, 8, NULL, 6, 5, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:59:18'),
(73, 8, NULL, 6, 5, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:59:20'),
(74, 8, NULL, 6, 5, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:59:22'),
(75, 8, NULL, 6, 5, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 02:59:51'),
(76, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:02:09'),
(77, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:02:11'),
(78, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:02:13'),
(79, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:02:13'),
(80, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:02:15'),
(81, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:02:15'),
(82, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:02:39'),
(83, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:03:51'),
(84, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:03:53'),
(85, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:03:53'),
(86, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:03:55'),
(87, 8, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 0, 0, NULL, '2025-11-05 03:04:05'),
(88, 9, NULL, 5, 6, 7, 'cuerpo', 15, 20, 0, 100, 85, NULL, '2025-11-05 03:17:00'),
(89, 9, NULL, 5, 6, 7, 'cuerpo', 15, 20, 0, 85, 70, NULL, '2025-11-05 03:17:03'),
(90, 9, NULL, 5, 6, 7, 'cuerpo', 15, 20, 0, 70, 55, NULL, '2025-11-05 03:17:07'),
(91, 9, NULL, 5, 6, 7, 'cuerpo', 15, 20, 0, 55, 40, NULL, '2025-11-05 03:17:10'),
(92, 9, NULL, 5, 6, 7, 'cuerpo', 15, 20, 0, 40, 25, NULL, '2025-11-05 03:17:13'),
(93, 9, NULL, 5, 6, 7, 'cuerpo', 15, 20, 0, 25, 10, NULL, '2025-11-05 03:17:16'),
(94, 9, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 03:17:28'),
(95, 9, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 03:17:31'),
(96, 9, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 03:17:33'),
(97, 9, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 03:17:36'),
(98, 9, NULL, 6, 5, 10, 'cabeza', 20, 81, 1, 20, 0, NULL, '2025-11-05 03:17:40'),
(99, 10, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 03:28:02'),
(100, 10, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 03:28:05'),
(101, 10, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 03:28:08'),
(102, 10, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 03:28:10'),
(103, 10, NULL, 6, 5, 10, 'cabeza', 20, 81, 1, 20, 0, NULL, '2025-11-05 03:28:13'),
(104, 42, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 05:05:46'),
(105, 42, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 05:05:49'),
(106, 42, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 05:05:52'),
(107, 42, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 05:05:55'),
(108, 42, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 20, 0, NULL, '2025-11-05 05:05:58'),
(109, 46, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 05:22:44'),
(110, 46, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 05:22:47'),
(111, 46, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 05:22:51'),
(112, 46, NULL, 6, 5, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 05:22:55'),
(113, 46, NULL, 5, 6, 10, 'cuerpo', 10, 1, 0, 100, 90, NULL, '2025-11-05 05:23:09'),
(114, 46, NULL, 5, 6, 10, 'cuerpo', 10, 1, 0, 90, 80, NULL, '2025-11-05 05:23:12'),
(115, 46, NULL, 5, 6, 10, 'cuerpo', 10, 1, 0, 80, 70, NULL, '2025-11-05 05:23:14'),
(116, 46, NULL, 5, 6, 10, 'cuerpo', 10, 1, 0, 70, 60, NULL, '2025-11-05 05:23:17'),
(117, 46, NULL, 5, 6, 10, 'cuerpo', 10, 1, 0, 60, 50, NULL, '2025-11-05 05:23:19'),
(118, 46, NULL, 5, 6, 10, 'cuerpo', 10, 1, 0, 50, 40, NULL, '2025-11-05 05:23:22'),
(119, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 100, 95, NULL, '2025-11-05 05:45:33'),
(120, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 95, 90, NULL, '2025-11-05 05:45:36'),
(121, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 90, 85, NULL, '2025-11-05 05:45:39'),
(122, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 85, 80, NULL, '2025-11-05 05:45:43'),
(123, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 80, 75, NULL, '2025-11-05 05:45:50'),
(124, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 75, 70, NULL, '2025-11-05 05:45:54'),
(125, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 70, 65, NULL, '2025-11-05 05:45:56'),
(126, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 65, 60, NULL, '2025-11-05 05:45:59'),
(127, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 60, 55, NULL, '2025-11-05 05:46:02'),
(128, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 55, 50, NULL, '2025-11-05 05:46:05'),
(129, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 50, 45, NULL, '2025-11-05 05:46:09'),
(130, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 45, 40, NULL, '2025-11-05 05:46:12'),
(131, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 40, 35, NULL, '2025-11-05 05:46:15'),
(132, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 35, 30, NULL, '2025-11-05 05:46:18'),
(133, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 30, 25, NULL, '2025-11-05 05:46:21'),
(134, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 25, 20, NULL, '2025-11-05 05:46:24'),
(135, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 20, 15, NULL, '2025-11-05 05:46:27'),
(136, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 15, 10, NULL, '2025-11-05 05:46:31'),
(137, 48, NULL, 5, 6, 2, 'cabeza', 5, 2, 0, 10, 5, NULL, '2025-11-05 05:46:35'),
(138, 48, NULL, 5, 6, 2, 'cabeza', 5, 82, 1, 5, 0, NULL, '2025-11-05 05:46:38'),
(139, 49, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 100, 80, NULL, '2025-11-05 16:49:04'),
(140, 49, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 80, 60, NULL, '2025-11-05 16:49:06'),
(141, 49, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 60, 40, NULL, '2025-11-05 16:49:09'),
(142, 49, NULL, 5, 6, 10, 'cabeza', 20, 1, 0, 40, 20, NULL, '2025-11-05 16:49:13'),
(143, 49, NULL, 5, 6, 10, 'cabeza', 20, 81, 1, 20, 0, NULL, '2025-11-05 16:49:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapa`
--

CREATE TABLE `mapa` (
  `id_mapa` int(11) NOT NULL,
  `nombre_mapa` varchar(100) NOT NULL,
  `imagen_mapa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mapa`
--

INSERT INTO `mapa` (`id_mapa`, `nombre_mapa`, `imagen_mapa`) VALUES
(1, 'ASCENT', 'ascent.png'),
(2, 'CORRODE', 'corrode.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id_partida` int(11) NOT NULL,
  `id_ganador` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT current_timestamp(),
  `estado` enum('en_juego','finalizada','','') DEFAULT NULL,
  `id_sala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id_partida`, `id_ganador`, `fecha_inicio`, `fecha_fin`, `estado`, `id_sala`) VALUES
(6, NULL, '2025-11-04 21:20:38', '2025-11-04 21:26:32', 'finalizada', 32),
(7, NULL, '2025-11-04 21:37:50', '2025-11-04 21:37:50', 'finalizada', 33),
(8, NULL, '2025-11-04 21:51:56', '2025-11-04 22:04:05', 'finalizada', 34),
(9, NULL, '2025-11-04 22:14:24', '2025-11-04 22:17:40', 'finalizada', 35),
(10, NULL, '2025-11-04 22:25:52', '2025-11-04 22:28:13', 'finalizada', 36),
(11, NULL, '2025-11-04 22:40:28', '2025-11-04 22:40:28', 'en_juego', 37),
(12, NULL, '2025-11-04 22:40:40', '2025-11-04 22:40:40', 'en_juego', 37),
(13, NULL, '2025-11-04 22:41:17', '2025-11-04 22:41:17', 'en_juego', 37),
(14, NULL, '2025-11-04 22:41:31', '2025-11-04 22:41:31', 'en_juego', 37),
(15, NULL, '2025-11-04 22:41:35', '2025-11-04 22:41:35', 'en_juego', 37),
(16, NULL, '2025-11-04 22:42:42', '2025-11-04 22:42:42', 'en_juego', 37),
(17, NULL, '2025-11-04 22:42:50', '2025-11-04 22:42:50', 'en_juego', 37),
(18, NULL, '2025-11-04 22:43:07', '2025-11-04 22:43:07', 'en_juego', 37),
(19, NULL, '2025-11-04 22:43:09', '2025-11-04 22:43:09', 'en_juego', 37),
(20, NULL, '2025-11-04 22:43:13', '2025-11-04 22:43:13', 'en_juego', 37),
(21, NULL, '2025-11-04 22:43:25', '2025-11-04 22:43:25', 'en_juego', 37),
(22, NULL, '2025-11-04 22:43:42', '2025-11-04 22:43:42', 'en_juego', 37),
(23, NULL, '2025-11-04 22:43:44', '2025-11-04 22:43:44', 'en_juego', 37),
(24, NULL, '2025-11-04 22:43:46', '2025-11-04 22:43:46', 'en_juego', 37),
(25, NULL, '2025-11-04 22:43:48', '2025-11-04 22:43:48', 'en_juego', 37),
(26, NULL, '2025-11-04 22:43:52', '2025-11-04 22:43:52', 'en_juego', 37),
(27, NULL, '2025-11-04 22:43:54', '2025-11-04 22:43:54', 'en_juego', 37),
(28, NULL, '2025-11-04 22:44:48', '2025-11-04 22:44:48', 'en_juego', 37),
(29, NULL, '2025-11-04 22:45:43', '2025-11-04 22:45:43', 'en_juego', 37),
(30, NULL, '2025-11-04 22:45:48', '2025-11-04 22:45:48', 'en_juego', 37),
(31, NULL, '2025-11-04 22:45:50', '2025-11-04 22:45:50', 'en_juego', 37),
(32, NULL, '2025-11-04 23:23:49', '2025-11-04 23:23:49', 'en_juego', 37),
(33, NULL, '2025-11-04 23:23:55', '2025-11-04 23:23:55', 'en_juego', 37),
(34, NULL, '2025-11-04 23:23:58', '2025-11-04 23:23:58', 'en_juego', 37),
(35, NULL, '2025-11-04 23:29:10', '2025-11-04 23:29:10', 'finalizada', 38),
(36, NULL, '2025-11-04 23:29:10', '2025-11-04 23:29:10', 'finalizada', 38),
(37, NULL, '2025-11-04 23:40:55', '2025-11-04 23:40:55', 'finalizada', 39),
(38, NULL, '2025-11-04 23:40:55', '2025-11-04 23:40:55', 'finalizada', 39),
(39, NULL, '2025-11-04 23:47:49', '2025-11-04 23:47:49', 'en_juego', 40),
(40, NULL, '2025-11-04 23:47:49', '2025-11-04 23:47:49', 'en_juego', 40),
(41, NULL, '2025-11-05 00:03:28', '2025-11-05 00:03:28', 'en_juego', 41),
(42, NULL, '2025-11-05 00:03:28', '2025-11-05 00:05:58', 'finalizada', 41),
(43, NULL, '2025-11-05 00:13:56', '2025-11-05 00:13:56', 'en_juego', 42),
(44, NULL, '2025-11-05 00:13:56', '2025-11-05 00:13:56', 'finalizada', 42),
(45, NULL, '2025-11-05 00:20:53', '2025-11-05 00:20:53', 'en_juego', 43),
(46, NULL, '2025-11-05 00:20:54', '2025-11-05 00:20:54', 'finalizada', 43),
(47, NULL, '2025-11-05 00:43:35', '2025-11-05 00:43:35', 'en_juego', 44),
(48, NULL, '2025-11-05 00:43:35', '2025-11-05 00:46:38', 'finalizada', 44),
(49, NULL, '2025-11-05 11:45:12', '2025-11-05 11:49:16', 'finalizada', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida_jugador`
--

CREATE TABLE `partida_jugador` (
  `id_partida_jugador` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kills` int(11) DEFAULT 0,
  `vida_actual` int(11) NOT NULL DEFAULT 100,
  `vida_final` int(11) DEFAULT NULL,
  `puntos_totales` int(11) DEFAULT 0,
  `posicion_final` int(11) DEFAULT NULL,
  `es_ganador` tinyint(1) DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida_jugador`
--

INSERT INTO `partida_jugador` (`id_partida_jugador`, `id_partida`, `id_user`, `kills`, `vida_actual`, `vida_final`, `puntos_totales`, `posicion_final`, `es_ganador`, `fecha_registro`) VALUES
(11, 6, 5, 7, 0, NULL, 571, NULL, 1, '2025-11-05 02:20:38'),
(12, 6, 6, 4, 0, NULL, 390, NULL, 0, '2025-11-05 02:20:38'),
(13, 7, 6, 0, 100, NULL, 0, NULL, 1, '2025-11-05 02:37:50'),
(14, 7, 5, 0, 100, NULL, 0, NULL, 0, '2025-11-05 02:37:50'),
(15, 8, 6, 5, 0, NULL, 409, NULL, 0, '2025-11-05 02:51:56'),
(16, 8, 5, 14, 0, NULL, 1138, NULL, 1, '2025-11-05 02:51:56'),
(17, 9, 6, 1, 10, NULL, 85, NULL, 0, '2025-11-05 03:14:24'),
(18, 9, 5, 0, 0, NULL, 120, NULL, 0, '2025-11-05 03:14:24'),
(19, 10, 6, 1, 100, NULL, 85, NULL, 0, '2025-11-05 03:25:52'),
(20, 10, 5, 0, 0, NULL, 0, NULL, 0, '2025-11-05 03:25:52'),
(21, 41, 5, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:03:28'),
(22, 41, 6, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:03:28'),
(23, 42, 5, 1, 100, NULL, 85, NULL, 1, '2025-11-05 05:03:28'),
(24, 42, 6, 0, 0, NULL, 0, NULL, 0, '2025-11-05 05:03:28'),
(25, 43, 5, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:13:56'),
(26, 43, 6, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:13:56'),
(27, 44, 5, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:13:56'),
(28, 44, 6, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:13:56'),
(29, 45, 6, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:20:53'),
(30, 45, 5, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:20:53'),
(31, 46, 6, 0, 40, NULL, 4, NULL, 0, '2025-11-05 05:20:54'),
(32, 46, 5, 0, 20, NULL, 6, NULL, 0, '2025-11-05 05:20:54'),
(33, 47, 5, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:43:35'),
(34, 47, 6, 0, 100, NULL, 0, NULL, 0, '2025-11-05 05:43:35'),
(35, 48, 5, 1, 100, NULL, 120, NULL, 1, '2025-11-05 05:43:35'),
(36, 48, 6, 0, 0, NULL, 0, NULL, 0, '2025-11-05 05:43:35'),
(37, 49, 5, 1, 100, NULL, 85, NULL, 1, '2025-11-05 16:45:12'),
(38, 49, 6, 0, 0, NULL, 0, NULL, 0, '2025-11-05 16:45:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personaje`
--

CREATE TABLE `personaje` (
  `id_personaje` int(11) NOT NULL,
  `nombre_personaje` varchar(100) NOT NULL,
  `imagen_personaje` varchar(255) DEFAULT NULL,
  `rango_requerido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personaje`
--

INSERT INTO `personaje` (`id_personaje`, `nombre_personaje`, `imagen_personaje`, `rango_requerido`) VALUES
(1, 'Jett', 'Jett.png', 1),
(2, 'Chamber', 'Chamber.png', 1),
(3, 'Sova', 'Sova.png', 1),
(4, 'Phoenix', 'Phoenix.png', 1),
(5, 'Omen', 'Omen.png', 2),
(6, 'Brimstone', 'Brimstone.png', 2),
(7, 'Reyna', 'Reyna.png', 3),
(8, 'Sage', 'Sage.png', 3),
(9, 'Viper', 'Viper.png', 4),
(10, 'Deadlock', 'Deadlock.png', 4),
(11, 'Neon', 'Neon.png', 5),
(12, 'Fade', 'Fade.png', 5);

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
  `nombre_sala` varchar(100) NOT NULL,
  `max_jugadores` int(11) NOT NULL,
  `estado` enum('disponible','en_juego','cerrada','iniciando','') DEFAULT 'disponible',
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `id_nivel_min` int(11) DEFAULT NULL,
  `id_mapa` int(11) DEFAULT NULL,
  `tipo_juego` enum('Multijugador','1vs1') NOT NULL DEFAULT 'Multijugador',
  `inicio_ts` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`id_sala`, `nombre_sala`, `max_jugadores`, `estado`, `fecha_creacion`, `id_nivel_min`, `id_mapa`, `tipo_juego`, `inicio_ts`) VALUES
(32, 'xx', 2, 'en_juego', '2025-11-04 21:20:17', 1, 2, '1vs1', 1762309243),
(33, 'xxxx', 2, 'en_juego', '2025-11-04 21:37:30', 4, 2, '1vs1', 1762310275),
(34, 'xx', 2, 'en_juego', '2025-11-04 21:51:30', 4, 2, '1vs1', 1762311121),
(35, 'hola', 2, 'en_juego', '2025-11-04 22:13:58', 5, 2, '1vs1', 1762312469),
(36, 'xxxxxx', 2, 'en_juego', '2025-11-04 22:25:41', 5, 2, '1vs1', 1762313157),
(37, 'xx', 2, 'iniciando', '2025-11-04 22:40:17', 5, 2, '1vs1', 1762316622),
(38, 'x', 2, 'iniciando', '2025-11-04 23:28:48', 5, 2, '1vs1', 1762316947),
(39, 'xx', 2, 'iniciando', '2025-11-04 23:40:31', 5, 2, '1vs1', 1762317652),
(40, 'x', 2, 'iniciando', '2025-11-04 23:47:28', 5, 2, '1vs1', 1762318066),
(41, 'm', 2, 'en_juego', '2025-11-05 00:03:03', 5, 2, '1vs1', NULL),
(42, 'z', 2, 'en_juego', '2025-11-05 00:13:34', 5, 2, '1vs1', NULL),
(43, 'z', 2, 'en_juego', '2025-11-05 00:20:30', 5, 2, '1vs1', NULL),
(44, 'a', 2, 'en_juego', '2025-11-05 00:43:12', 5, 2, '1vs1', NULL),
(45, 'zz', 2, 'en_juego', '2025-11-05 11:44:50', 5, 2, '1vs1', NULL);

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

--
-- Volcado de datos para la tabla `tip_user`
--

INSERT INTO `tip_user` (`id_tipo_user`, `tipo_user`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

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
  `puntos` int(11) NOT NULL,
  `id_tipo_user` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_rango` int(11) DEFAULT NULL,
  `id_banner` int(11) DEFAULT 1,
  `id_avatar` int(11) NOT NULL DEFAULT 1,
  `id_personaje` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `nombre`, `usuario`, `email`, `contrasena`, `avatar`, `ultimo_login`, `puntos`, `id_tipo_user`, `id_estado`, `id_rango`, `id_banner`, `id_avatar`, `id_personaje`) VALUES
(5, 'Jose Luis', 'jose', 'joseluis1409rodriguez@gmail.com', '$2y$12$vBhUc4u0qbb4mg32FeRcWu5iHVrok2lsiYLEGeenw96hTQMEB9oJ2', NULL, '2025-11-05 18:05:29', 15573, 1, 1, 5, 2, 1, 1),
(6, 'pepe', 'pedro', 'pedro@gmail.com', '$2y$12$G/u9MJ/IdwfOAGPn6NIVR.Un0BtcF5ZeIaVvVwc077.cn.beBMMc6', NULL, '2025-11-05 17:44:22', 1459, 2, 1, 5, 1, 1, 3),
(7, 'didier', 'didier', 'didierreyes003@gmail.com', '$2y$12$Ej32GDa7TLz01qhIPnE6deoHQQkplaVfGOej58ndhaZuwrFoOFsCy', NULL, '2025-11-05 18:04:29', 0, 2, 1, 1, 1, 1, 1),
(8, 'brayan', 'brayan', 'bastobrayan246@gmail.com', '$2y$12$OixYE85KhvT9Fg0oBxDkgexZuI60keHOfDTf1Y.qhaCp87KFSFy72', NULL, '2025-10-29 23:06:24', 0, 2, 1, 1, 1, 1, 1),
(9, 'pepe', 'pepe', 'pepe@gmail.com', '$2y$12$0HPRET8RP6PbbwVvij5HZuVG/IwFLqH35H3GK71wAqG8sNU1LjeTi', NULL, '2025-10-29 23:06:58', 0, 2, 1, 1, 1, 1, 1),
(10, 'jose luis', 'joseadmin', 'joseluis14@gmail.com', '$2y$12$t5yZ9gfrsAaAz5bkkIERa.sBmXdYtNcQRUB.f5STXYlrAeZ.WL1Zy', NULL, NULL, 0, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_sala`
--

CREATE TABLE `usuario_sala` (
  `id_usu_sala` int(11) NOT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `id_sala` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_sala`
--

INSERT INTO `usuario_sala` (`id_usu_sala`, `rol`, `id_sala`, `id_user`, `joined_at`) VALUES
(56, 'Host', 32, 5, '2025-11-05 02:20:17'),
(57, 'Jugador', 32, 6, '2025-11-05 02:20:28'),
(58, 'Host', 33, 6, '2025-11-05 02:37:30'),
(59, 'Jugador', 33, 5, '2025-11-05 02:37:41'),
(60, 'Host', 34, 6, '2025-11-05 02:51:30'),
(61, 'Jugador', 34, 5, '2025-11-05 02:51:49'),
(62, 'Host', 35, 6, '2025-11-05 03:13:58'),
(63, 'Jugador', 35, 5, '2025-11-05 03:14:07'),
(64, 'Host', 36, 6, '2025-11-05 03:25:41'),
(65, 'Jugador', 36, 5, '2025-11-05 03:25:47'),
(67, 'Host', 37, 5, '2025-11-05 03:40:22'),
(68, 'Jugador', 37, 6, '2025-11-05 03:42:34'),
(69, 'Host', 38, 5, '2025-11-05 04:28:48'),
(70, 'Jugador', 38, 6, '2025-11-05 04:28:54'),
(71, 'Host', 39, 6, '2025-11-05 04:40:31'),
(72, 'Jugador', 39, 5, '2025-11-05 04:40:40'),
(73, 'Host', 40, 5, '2025-11-05 04:47:28'),
(74, 'Jugador', 40, 6, '2025-11-05 04:47:36'),
(75, 'Host', 41, 5, '2025-11-05 05:03:03'),
(76, 'Jugador', 41, 6, '2025-11-05 05:03:13'),
(77, 'Host', 42, 5, '2025-11-05 05:13:34'),
(78, 'Jugador', 42, 6, '2025-11-05 05:13:41'),
(79, 'Host', 43, 6, '2025-11-05 05:20:30'),
(80, 'Jugador', 43, 5, '2025-11-05 05:20:37'),
(81, 'Host', 44, 5, '2025-11-05 05:43:12'),
(82, 'Jugador', 44, 6, '2025-11-05 05:43:20'),
(83, 'Host', 45, 5, '2025-11-05 16:44:50'),
(84, 'Jugador', 45, 6, '2025-11-05 16:44:56');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arma`
--
ALTER TABLE `arma`
  ADD PRIMARY KEY (`id_arma`),
  ADD KEY `id_tipo_arma` (`id_tipo_arma`),
  ADD KEY `rango_requerido` (`rango_requerido`);

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id_avatar`);

--
-- Indices de la tabla `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `log_disparos`
--
ALTER TABLE `log_disparos`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_partida` (`id_partida`),
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_atacante` (`id_atacante`),
  ADD KEY `id_objetivo` (`id_objetivo`),
  ADD KEY `id_arma` (`id_arma`);

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
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `personaje`
--
ALTER TABLE `personaje`
  ADD PRIMARY KEY (`id_personaje`),
  ADD KEY `rango_requerido` (`rango_requerido`);

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
  ADD KEY `id_avatar` (`id_banner`),
  ADD KEY `user_ibfk_5` (`id_avatar`),
  ADD KEY `id_personaje` (`id_personaje`);

--
-- Indices de la tabla `usuario_sala`
--
ALTER TABLE `usuario_sala`
  ADD PRIMARY KEY (`id_usu_sala`),
  ADD UNIQUE KEY `id_user` (`id_user`,`id_sala`),
  ADD KEY `id_sala` (`id_sala`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arma`
--
ALTER TABLE `arma`
  MODIFY `id_arma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id_avatar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `banner`
--
ALTER TABLE `banner`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `log_disparos`
--
ALTER TABLE `log_disparos`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `mapa`
--
ALTER TABLE `mapa`
  MODIFY `id_mapa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `partida_jugador`
--
ALTER TABLE `partida_jugador`
  MODIFY `id_partida_jugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `personaje`
--
ALTER TABLE `personaje`
  MODIFY `id_personaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `rango`
--
ALTER TABLE `rango`
  MODIFY `id_rango` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `tipo_arma`
--
ALTER TABLE `tipo_arma`
  MODIFY `id_tipo_arma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tip_user`
--
ALTER TABLE `tip_user`
  MODIFY `id_tipo_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario_sala`
--
ALTER TABLE `usuario_sala`
  MODIFY `id_usu_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arma`
--
ALTER TABLE `arma`
  ADD CONSTRAINT `arma_ibfk_1` FOREIGN KEY (`id_tipo_arma`) REFERENCES `tipo_arma` (`id_tipo_arma`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `arma_ibfk_2` FOREIGN KEY (`rango_requerido`) REFERENCES `rango` (`id_rango`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `sala` (`id_sala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `log_disparos`
--
ALTER TABLE `log_disparos`
  ADD CONSTRAINT `log_disparos_fk_arma` FOREIGN KEY (`id_arma`) REFERENCES `arma` (`id_arma`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `log_disparos_fk_atacante` FOREIGN KEY (`id_atacante`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `log_disparos_fk_objetivo` FOREIGN KEY (`id_objetivo`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `log_disparos_fk_partida` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id_partida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `log_disparos_fk_sala` FOREIGN KEY (`id_sala`) REFERENCES `sala` (`id_sala`) ON DELETE SET NULL ON UPDATE CASCADE;

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
  ADD CONSTRAINT `partida_jugador_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personaje`
--
ALTER TABLE `personaje`
  ADD CONSTRAINT `personaje_ibfk_1` FOREIGN KEY (`rango_requerido`) REFERENCES `rango` (`id_rango`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`id_banner`) REFERENCES `banner` (`id_banner`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_5` FOREIGN KEY (`id_avatar`) REFERENCES `avatar` (`id_avatar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_6` FOREIGN KEY (`id_personaje`) REFERENCES `personaje` (`id_personaje`) ON DELETE CASCADE ON UPDATE CASCADE;

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
