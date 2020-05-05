-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2020 a las 14:25:11
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12



-- password: >+(>nI{#-MF2PRhL
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `productos` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `id_usuario`, `fecha`, `productos`) VALUES
(1, 3, '2020-04-24', '2,2,3,10,1,2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` float NOT NULL,
  `oferta` float(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `imagen`, `stock`, `precio`, `oferta`) VALUES
(1, 'naranjas (kilo)', 'https://fotos01.diarioinformacion.com/2019/01/31/328x206/trucos-elegir-mejores-naranjas.jpg', 300, 2, 0),
(2, 'manzanas (kilo)', 'https://img.vixdata.io/pd/jpg-large/es/sites/default/files/imj/elgranchef/D/Deliciosas%20chips%20de%20manzana.jpg', 200, 1.5, 0),
(3, 'platanos (kilo)', 'https://www.lareserva.com/sites/default/files/styles/article_image/public/field/image/banana.jpg?itok=fTQ5a8Vm', 250, 3, 20),
(4, 'pizza (unidad)', 'https://www.telepizza.es/amp/info/pizzas-gourmet/img/pizza-carbonara-gourmet-queso-logo.jpg', 30, 4, 0),
(5, 'aguacates (kilo)', 'https://e00-expansion.uecdn.es/assets/multimedia/imagenes/2017/04/24/14930582517752.jpg', 100, 5, 0),
(6, 'patatas fritas (bolsa)', 'https://vermut.shop/80/bolsa-patatas-espinaler-150gr.jpg', 100, 1, 0),
(7, 'huevos (docena)', 'https://medinashopping.es/wp-content/uploads/2020/04/huevos-frescos.jpg', 50, 2.5, 0),
(8, 'cheesecake (unidad)', 'https://s1.eestatic.com/2019/06/24/cocinillas/actualidad-gastronomica/Actualidad_gastronomica_408720743_126407015_1706x960.jpg', 10, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  `permisos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasena`, `email`, `permisos`) VALUES
(1, 'cotelo', '1234', 'cotelo@cotelo.com', 1),
(3, 'matias', '33333', 'matias@tiendesita.com', 1),
(4, 'jeremias', '1234', 'jeremias@tiendesita.com', 0),
(5, 'amelio', '1234', 'amelio@meilio.com', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
