-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2019 a las 15:43:40
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
-- Base de datos: `asesorcompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `idanuncio` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_estonian_ci NOT NULL,
  `foto` varchar(250) COLLATE utf8_estonian_ci NOT NULL,
  `precio_venta` decimal(10,0) NOT NULL,
  `urlportalventa` varchar(250) COLLATE utf8_estonian_ci NOT NULL,
  `idsitioweb` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_estonian_ci NOT NULL,
  `precio_correcto` decimal(10,0) NOT NULL,
  `precio_chollo` decimal(10,0) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `fecha_alta_mod` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idanuncio`, `nombre`, `foto`, `precio_venta`, `urlportalventa`, `idsitioweb`, `email`, `precio_correcto`, `precio_chollo`, `idcategoria`, `fecha_alta_mod`) VALUES
(18, 'OnePlus 6T 8GB/128GB Mirror Black Libre', 'https://img.pccomponentes.com/articles/17/175106/mirroblack6t1.jpg', '579', 'https://www.pccomponentes.com/oneplus-6t-8gb-128gb-mirror-black-libre', 4, 'jc.perdiguerocarlos@gmail.com', '590', '400', 22, '2019-02-18'),
(19, 'Puma . ESS PANTS - Pantalones deportivos', 'https://mosaic03.ztat.net/vgs/media/pdp-zoom/PU/14/1E/09/SC/11/PU141E09S-C11@10.jpg', '40', 'https://www.zalando.es/puma-ess-pants-pantalon-de-deporte-pu141e09s-c11.html', 3, 'jc.perdiguerocarlos@gmail.com', '30', '20', 13, '2019-02-18'),
(20, 'Xiaomi Redmi 6 3/32GB Dual Sim Negro Libre', 'https://img.pccomponentes.com/articles/16/169656/i0.jpg', '119', 'https://www.pccomponentes.com/xiaomi-redmi-6-3-32gb-dual-sim-negro-libre', 4, 'jc.perdiguerocarlos@gmail.com', '100', '90', 22, '2019-02-18'),
(21, 'Dorothy Perkins ', 'https://mosaic04.ztat.net/vgs/media/packshot/pdp-zoom/DP/51/1B/09/5E/11/DP511B095-E11@11.jpg', '30', 'https://www.zalando.es/dorothy-perkins-danielle-tacones-dp511b095-e11.html', 3, 'jc.perdiguerocarlos@gmail.com', '40', '32', 9, '2019-02-18'),
(22, 'Nike. PHANTOM ACADEMY IC - Botas de fútbol sin tacos', 'https://mosaic03.ztat.net/vgs/media/packshot/pdp-zoom/N1/24/2A/1M/FG/11/N1242A1MF-G11@4.jpg', '80', 'https://www.zalando.es/nike-performance-phantom-academy-ic-botas-de-futbol-sin-tacos-bright-crimsonblackmetallic-silver-n1242a1mf-g11.html', 3, 'jc.perdiguerocarlos@gmail.com', '90', '80', 10, '2019-02-19'),
(32, 'THE TRUCKER JACKET - Chaqueta vaquera', 'https://mosaic03.ztat.net/vgs/media/packshot/pdp-zoom/LE/22/2T/01/AK/11/LE222T01A-K11@4.jpg', '110', 'https://www.zalando.es/levisr-the-trucker-jacket-chaqueta-fina-le222t01a-k12.html', 3, 'jc.perdiguerocarlos@gmail.com', '120', '111', 13, '2019-02-19'),
(33, 'BICICLETA DE MONTAÑA ELÉCTRICA E-ST500 NEGRO Y AZUL', 'https://contents.mediadecathlon.com/p1576542/k$03c3ec3c8ea247ce858d26a7bbce84e4/sq/Bicicleta+de+Monta+a+el+ctrica+E+ST500+negro+y+azul.webp?f=1000x100', '1199', 'https://www.decathlon.es/es/p/bicicleta-de-montana-electrica-e-st500-negro-y-azul/_/R-p-168867?mc=8487238&c=NEGRO', 2, 'jc.perdiguerocarlos@gmail.com', '1330', '1000', 10, '2019-02-19'),
(34, '4R Helicóptero de Rescate 1:32', 'https://juguettos.com/1221974-thickbox_default/A0004668.jpg', '33', 'https://juguettos.com/juguetes/1032-A0004668.html', 6, 'jc.perdiguerocarlos@gmail.com', '40', '30', 12, '2019-02-19'),
(35, 'Educativos Memo Photo', 'https://juguettos.com/1222000-thickbox_default/A0014904.jpg', '11', 'https://juguettos.com/juguetes/16381-A0014904.html', 6, 'jc.perdiguerocarlos@gmail.com', '15', '12', 12, '2019-02-19'),
(36, 'PANTALÓN TÉRMICO DE ESQUÍ WED\"ZE 500 MUJER CORAL', 'https://contents.mediadecathlon.com/p1509131/k$4a23e3ad9c02697ab92ccc2b3a17ab58/sq/Pantal+n+T+rmico+de+Esqu+500+Mujer+Ciruela.webp?f=1000x1000', '10', 'https://www.decathlon.es/es/p/pantalon-termico-de-esqui-500-mujer-coral/_/R-p-194771?mc=8504288&c=P%C3%9ARPURA', 5, 'jc.perdiguerocarlos@gmail.com', '15', '12', 10, '2019-02-20'),
(39, 'GRAPHIC 10 R T SS - Camiseta estampada', 'https://mosaic04.ztat.net/vgs/media/packshot/pdp-zoom/GS/12/2O/0G/MC/11/GS122O0GM-C11@7.jpg', '28', 'https://www.zalando.es/g-star-graphic-10-r-t-ss-camiseta-estampada-grey-heather-gs122o0gm-c11.html', 3, 'jc.perdiguerocarlos@gmail.com', '40', '20', 13, '2019-02-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_estonian_ci NOT NULL,
  `foto` varchar(50) COLLATE utf8_estonian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `nombre`, `foto`) VALUES
(9, 'Calzado', 'calzado.jpg'),
(10, 'Deporte', 'deporte.jpg'),
(11, 'Libros', 'libros.jpg'),
(12, 'Juguetes', 'juguetes.jpg'),
(13, 'Moda', 'moda.jpg'),
(15, 'Perfumes', 'perfumes.jpg'),
(22, 'Electrónica', 'eletronica.jpg'),
(25, 'Viajes', 'VIAJES.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitiosweb`
--

CREATE TABLE `sitiosweb` (
  `idsitioweb` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_estonian_ci NOT NULL,
  `url` varchar(150) COLLATE utf8_estonian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;

--
-- Volcado de datos para la tabla `sitiosweb`
--

INSERT INTO `sitiosweb` (`idsitioweb`, `nombre`, `url`) VALUES
(2, 'Fotocasa', 'www.fotocasa.com'),
(3, 'Zalando', 'https://www.zalando.es'),
(4, 'PC-COMPONENTES', 'https://www.pccomponentes.com'),
(5, 'Decathlon', 'https://www.decathlon.es/es/'),
(6, 'Juggettos', 'https://juguettos.com'),
(7, 'Booking', 'https://www.booking.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `email` varchar(100) COLLATE utf8_estonian_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8_estonian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_estonian_ci NOT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `token` varchar(100) COLLATE utf8_estonian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `nombre`, `password`, `confirmado`, `token`) VALUES
('andrea@perdiguero@gmail.com', 'Andrea Perdiguero Urretabizkaia', 'MTExMQ==', 1, 'uxc7wGEfIGmjrX5UfAiwrFdgOMlMDh'),
('asier.perdiguero@gmail.com', 'Asier', 'MTExMQ==', 1, 'a2In8hHkWHzgXB0Y9XXirD4nL1WTwp'),
('jc.perdiguerocarlos@gmail.com', 'Karlos Perdiguero Otxoa', 'MTExMQ==', 1, 'nVnvmwkgYQNnz9Zqv0MOTihhbOXdE2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`idanuncio`),
  ADD KEY `id_categoria` (`idcategoria`),
  ADD KEY `e_mail` (`email`),
  ADD KEY `id_sitioweb` (`idsitioweb`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `sitiosweb`
--
ALTER TABLE `sitiosweb`
  ADD PRIMARY KEY (`idsitioweb`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `idanuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `sitiosweb`
--
ALTER TABLE `sitiosweb`
  MODIFY `idsitioweb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`idsitioweb`) REFERENCES `sitiosweb` (`idsitioweb`),
  ADD CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `anuncios_ibfk_3` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
