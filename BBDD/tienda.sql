-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2020 a las 20:42:11
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

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
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `usuario` int(11) NOT NULL,
  `calle` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `numero` int(11) NOT NULL,
  `cp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`usuario`, `calle`, `numero`, `cp`) VALUES
(5, 'saladino', 23, 18220),
(1, 'le barriamiento', 24, 18910);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `carro` longtext COLLATE utf8_spanish_ci NOT NULL,
  `importe_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `usuario`, `fecha`, `carro`, `importe_total`) VALUES
(2, 5, '2020-05-12', '[{\"id\":\"3\",\"nombre\":\"platanos (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/www.lareserva.com\\/sites\\/default\\/files\\/styles\\/article_image\\/public\\/field\\/image\\/banana.jpg?itok=fTQ5a8Vm\",\"precioFinal\":4,\"precio\":\"5\",\"oferta\":\"20\"},{\"id\":\"4\",\"nombre\":\"pizza (unidad)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/www.telepizza.es\\/amp\\/info\\/pizzas-gourmet\\/img\\/pizza-carbonara-gourmet-queso-logo.jpg\",\"precioFinal\":2,\"precio\":\"4\",\"oferta\":\"50\"}]', 6),
(3, 5, '2020-05-12', '[{\"id\":\"3\",\"nombre\":\"platanos (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/www.lareserva.com\\/sites\\/default\\/files\\/styles\\/article_image\\/public\\/field\\/image\\/banana.jpg?itok=fTQ5a8Vm\",\"precioFinal\":4,\"precio\":\"5\",\"oferta\":\"20\"},{\"id\":\"4\",\"nombre\":\"pizza (unidad)\",\"cantidad\":\"3\",\"imagen\":\"https:\\/\\/www.telepizza.es\\/amp\\/info\\/pizzas-gourmet\\/img\\/pizza-carbonara-gourmet-queso-logo.jpg\",\"precioFinal\":2,\"precio\":\"4\",\"oferta\":\"50\"},{\"id\":\"7\",\"nombre\":\"huevos (docena)\",\"cantidad\":\"3\",\"imagen\":\"https:\\/\\/medinashopping.es\\/wp-content\\/uploads\\/2020\\/04\\/huevos-frescos.jpg\",\"precioFinal\":2.38,\"precio\":\"2.5\",\"oferta\":\"5\"},{\"id\":\"5\",\"nombre\":\"aguacates (kilo)\",\"cantidad\":\"2\",\"imagen\":\"https:\\/\\/e00-expansion.uecdn.es\\/assets\\/multimedia\\/imagenes\\/2017\\/04\\/24\\/14930582517752.jpg\",\"precioFinal\":5,\"precio\":\"5\",\"oferta\":\"0\"}]', 27.14),
(4, 1, '2020-05-12', '[{\"id\":\"2\",\"nombre\":\"manzanas (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/img.vixdata.io\\/pd\\/jpg-large\\/es\\/sites\\/default\\/files\\/imj\\/elgranchef\\/D\\/Deliciosas%20chips%20de%20manzana.jpg\",\"precioFinal\":1.26,\"precio\":\"1.6\",\"oferta\":\"21\"},{\"id\":\"1\",\"nombre\":\"naranjas (kilo)\",\"cantidad\":\"10\",\"imagen\":\"https:\\/\\/fotos01.diarioinformacion.com\\/2019\\/01\\/31\\/328x206\\/trucos-elegir-mejores-naranjas.jpg\",\"precioFinal\":4,\"precio\":\"4\",\"oferta\":\"0\"}]', 41.26),
(5, 5, '2020-05-12', '[{\"id\":\"4\",\"nombre\":\"pizza (unidad)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/www.telepizza.es\\/amp\\/info\\/pizzas-gourmet\\/img\\/pizza-carbonara-gourmet-queso-logo.jpg\",\"precioFinal\":2,\"precio\":\"4\",\"oferta\":\"50\"}]', 2),
(6, 5, '2020-05-12', '[{\"id\":\"4\",\"nombre\":\"pizza (unidad)\",\"cantidad\":\"2\",\"imagen\":\"https:\\/\\/www.telepizza.es\\/amp\\/info\\/pizzas-gourmet\\/img\\/pizza-carbonara-gourmet-queso-logo.jpg\",\"precioFinal\":2,\"precio\":\"4\",\"oferta\":\"50\"},{\"id\":\"2\",\"nombre\":\"manzanas (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/img.vixdata.io\\/pd\\/jpg-large\\/es\\/sites\\/default\\/files\\/imj\\/elgranchef\\/D\\/Deliciosas%20chips%20de%20manzana.jpg\",\"precioFinal\":1.26,\"precio\":\"1.6\",\"oferta\":\"21\"},{\"id\":\"1\",\"nombre\":\"naranjas (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/fotos01.diarioinformacion.com\\/2019\\/01\\/31\\/328x206\\/trucos-elegir-mejores-naranjas.jpg\",\"precioFinal\":4,\"precio\":\"4\",\"oferta\":\"0\"},{\"id\":\"7\",\"nombre\":\"huevos (docena)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/medinashopping.es\\/wp-content\\/uploads\\/2020\\/04\\/huevos-frescos.jpg\",\"precioFinal\":2.38,\"precio\":\"2.5\",\"oferta\":\"5\"}]', 11.64),
(7, 1, '2020-05-12', '[{\"id\":\"2\",\"nombre\":\"manzanas (kilo)\",\"cantidad\":\"4\",\"imagen\":\"https:\\/\\/img.vixdata.io\\/pd\\/jpg-large\\/es\\/sites\\/default\\/files\\/imj\\/elgranchef\\/D\\/Deliciosas%20chips%20de%20manzana.jpg\",\"precioFinal\":1.26,\"precio\":\"1.6\",\"oferta\":\"21\"},{\"id\":\"3\",\"nombre\":\"platanos (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/www.lareserva.com\\/sites\\/default\\/files\\/styles\\/article_image\\/public\\/field\\/image\\/banana.jpg?itok=fTQ5a8Vm\",\"precioFinal\":4,\"precio\":\"5\",\"oferta\":\"20\"},{\"id\":\"14\",\"nombre\":\"guindillas (tarro)\",\"cantidad\":\"5\",\"imagen\":\"https:\\/\\/www.iberianwinesandfood.com\\/WebRoot\\/StoreES3\\/Shops\\/ec3804\\/579B\\/169F\\/4FCC\\/2457\\/AE57\\/52DF\\/D03B\\/6FD2\\/Guindillas-picantes-FRUTOS-DE-LA-TIERRA-430GR.jpg\",\"precioFinal\":3.25,\"precio\":\"5\",\"oferta\":\"35\"}]', 25.29),
(9, 1, '2020-05-12', '[{\"id\":\"3\",\"nombre\":\"platanos (kilo)\",\"cantidad\":\"6\",\"imagen\":\"https:\\/\\/www.lareserva.com\\/sites\\/default\\/files\\/styles\\/article_image\\/public\\/field\\/image\\/banana.jpg?itok=fTQ5a8Vm\",\"precioFinal\":4,\"precio\":\"5\",\"oferta\":\"20\"},{\"id\":\"14\",\"nombre\":\"guindillas (tarro)\",\"cantidad\":\"5\",\"imagen\":\"https:\\/\\/www.iberianwinesandfood.com\\/WebRoot\\/StoreES3\\/Shops\\/ec3804\\/579B\\/169F\\/4FCC\\/2457\\/AE57\\/52DF\\/D03B\\/6FD2\\/Guindillas-picantes-FRUTOS-DE-LA-TIERRA-430GR.jpg\",\"precioFinal\":3.25,\"precio\":\"5\",\"oferta\":\"35\"}]', 40.25),
(10, 1, '2020-05-12', '[{\"id\":\"4\",\"nombre\":\"pizza (unidad)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/www.telepizza.es\\/amp\\/info\\/pizzas-gourmet\\/img\\/pizza-carbonara-gourmet-queso-logo.jpg\",\"precioFinal\":2,\"precio\":\"4\",\"oferta\":\"50\"},{\"id\":\"2\",\"nombre\":\"manzanas (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/img.vixdata.io\\/pd\\/jpg-large\\/es\\/sites\\/default\\/files\\/imj\\/elgranchef\\/D\\/Deliciosas%20chips%20de%20manzana.jpg\",\"precioFinal\":1.26,\"precio\":\"1.6\",\"oferta\":\"21\"},{\"id\":\"1\",\"nombre\":\"naranjas (kilo)\",\"cantidad\":\"1\",\"imagen\":\"https:\\/\\/fotos01.diarioinformacion.com\\/2019\\/01\\/31\\/328x206\\/trucos-elegir-mejores-naranjas.jpg\",\"precioFinal\":4,\"precio\":\"4\",\"oferta\":\"0\"}]', 7.26);

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
(1, 'naranjas (kilo)', 'https://fotos01.diarioinformacion.com/2019/01/31/328x206/trucos-elegir-mejores-naranjas.jpg', 300, 4, 0),
(2, 'manzanas (kilo)', 'https://img.vixdata.io/pd/jpg-large/es/sites/default/files/imj/elgranchef/D/Deliciosas%20chips%20de%20manzana.jpg', 200, 1.6, 21),
(3, 'platanos (kilo)', 'https://www.lareserva.com/sites/default/files/styles/article_image/public/field/image/banana.jpg?itok=fTQ5a8Vm', 250, 5, 20),
(4, 'pizza (unidad)', 'https://www.telepizza.es/amp/info/pizzas-gourmet/img/pizza-carbonara-gourmet-queso-logo.jpg', 30, 4, 50),
(5, 'aguacates (kilo)', 'https://e00-expansion.uecdn.es/assets/multimedia/imagenes/2017/04/24/14930582517752.jpg', 100, 5, 0),
(6, 'patatas fritas (bolsa)', 'https://vermut.shop/80/bolsa-patatas-espinaler-150gr.jpg', 100, 1.1, 5),
(7, 'huevos (docena)', 'https://medinashopping.es/wp-content/uploads/2020/04/huevos-frescos.jpg', 50, 2.5, 5),
(8, 'cheesecake (unidad)', 'https://s1.eestatic.com/2019/06/24/cocinillas/actualidad-gastronomica/Actualidad_gastronomica_408720743_126407015_1706x960.jpg', 10, 6, 25),
(17, 'Futebolas (bolsa)', 'https://serunion-vending.com/public/upload/10/191_4.-Cheetos-Pelotazos-product.jpg', 200, 1.35, 10);

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
(5, 'amelio', '1234', 'amelio@meilio.com', 0),
(7, 'luis', '1234', 'luis@cotelo.com', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD KEY `usuario` (`usuario`);

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
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
