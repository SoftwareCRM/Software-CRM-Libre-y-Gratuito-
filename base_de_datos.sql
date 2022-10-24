-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2022 a las 00:40:00
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd`
--
CREATE DATABASE IF NOT EXISTS `bd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carr` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `cantidad_vender_carr` int(11) NOT NULL,
  `estado_carr` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carr`, `id_usu`, `id_prod`, `cantidad_vender_carr`, `estado_carr`) VALUES
(217, 64, 88, 8, 0),
(220, 64, 88, 10, 0),
(223, 64, 87, 8, 0),
(224, 64, 88, 5, 0),
(227, 64, 87, 3, 0),
(228, 64, 88, 5, 0),
(231, 64, 87, 10, 0),
(232, 64, 88, 5, 0),
(235, 64, 87, 10, 0),
(236, 64, 88, 5, 0),
(242, 64, 87, 2, 0),
(245, 64, 87, 10, 0),
(246, 64, 88, 280, 0),
(249, 64, 87, 5, 0),
(250, 64, 88, 50, 0),
(253, 64, 87, 15, 0),
(254, 64, 87, 45, 0),
(255, 64, 88, 1, 0),
(259, 64, 87, 3, 0),
(260, 64, 88, 2, 0),
(264, 64, 87, 1, 0),
(265, 64, 88, 4, 0),
(268, 64, 87, 1, 0),
(269, 64, 88, 13, 0),
(272, 64, 87, 2, 0),
(273, 64, 88, 4, 0),
(276, 64, 87, 3, 0),
(277, 64, 88, 2, 0),
(278, 64, 87, 1, 0),
(281, 64, 88, 1, 0),
(284, 64, 87, 1, 0),
(285, 64, 88, 1, 0),
(288, 64, 87, 1, 0),
(292, 64, 87, 9, 0),
(293, 64, 88, 3, 0),
(294, 64, 87, 3, 0),
(295, 64, 88, 5, 0),
(296, 64, 87, 3, 0),
(297, 64, 88, 4, 0),
(299, 64, 89, 3, 0),
(300, 64, 94, 4, 0),
(302, 64, 87, 4, 0),
(303, 64, 88, 6, 0),
(304, 64, 87, 0, 0),
(305, 64, 89, 2, 1),
(306, 64, 90, 1, 1),
(307, 113, 91, 2, 0),
(308, 113, 94, 1, 0),
(309, 111, 89, 1, 1),
(310, 64, 92, 2, 1),
(311, 111, 92, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nom_cliente` varchar(255) NOT NULL,
  `ced_cliente` varchar(50) NOT NULL,
  `fecha` varchar(100) DEFAULT NULL,
  `estado_cliente` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nom_cliente`, `ced_cliente`, `fecha`, `estado_cliente`) VALUES
(221, 'Josesito', '10000000', '21-10-2022 10:44:45', 1),
(222, 'ARMANDO PAREDES', '123456789', '24-10-2022 10:04:44', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_com` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_carr` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` varchar(50) NOT NULL,
  `monto_total` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_com`, `id_prod`, `id_usu`, `id_carr`, `id_cliente`, `fecha`, `monto_total`) VALUES
(487, 87, 64, 302, 221, '21-10-2022 10:44:45', '604.000'),
(488, 88, 64, 303, 221, '21-10-2022 10:44:45', '604.000'),
(489, 91, 113, 307, 222, '24-10-2022 10:04:44', '1116.000'),
(490, 94, 113, 308, 222, '24-10-2022 10:04:44', '1116.000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_pdf`
--

CREATE TABLE `configuracion_pdf` (
  `id_conf_pdf` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `tit_pdf` varchar(100) NOT NULL DEFAULT 'Titulo',
  `ide_pdf` varchar(100) NOT NULL DEFAULT '0001',
  `dir_pdf` varchar(100) NOT NULL DEFAULT 'Dirección',
  `num_pdf` varchar(100) NOT NULL DEFAULT '00-00',
  `pie_pdf` varchar(100) NOT NULL DEFAULT 'Pie de página',
  `iva` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `configuracion_pdf`
--

INSERT INTO `configuracion_pdf` (`id_conf_pdf`, `id_usu`, `tit_pdf`, `ide_pdf`, `dir_pdf`, `num_pdf`, `pie_pdf`, `iva`) VALUES
(28, 64, 'EMPRESA JERRY A&S', '000000', 'TUCAPE SAN CRISTOBAL TACHIRA', '0000-00000', '¡QUE LE VAYA BIEN!', '16'),
(29, 65, 'EMPRESA JERRY A&S', '000000', 'TUCAPE SAN CRISTOBAL TACHIRA', '0000-00000', '¡QUE LE VAYA BIEN!', '16'),
(31, 67, 'EMPRESA JERRY A&S', '000000', 'TUCAPE SAN CRISTOBAL TACHIRA', '0000-00000', '¡QUE LE VAYA BIEN!', '16'),
(75, 111, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16'),
(77, 113, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16'),
(78, 114, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16'),
(79, 115, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16'),
(80, 116, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `id_fac` int(11) NOT NULL,
  `id_com` int(11) NOT NULL,
  `id_conf_pdf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facturacion`
--

INSERT INTO `facturacion` (`id_fac`, `id_com`, `id_conf_pdf`) VALUES
(15, 487, 28),
(16, 489, 77);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_acceso`
--

CREATE TABLE `permisos_acceso` (
  `id_perm` tinyint(1) NOT NULL,
  `nv_acceso_perm` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos_acceso`
--

INSERT INTO `permisos_acceso` (`id_perm`, `nv_acceso_perm`) VALUES
(0, 'Usuario'),
(1, 'Administrador'),
(2, 'Super Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_prod` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `nom_prod` varchar(255) NOT NULL,
  `pre_prod` decimal(10,3) NOT NULL,
  `cantidad_prod` int(11) NOT NULL,
  `iva_prod` tinyint(11) NOT NULL,
  `estado_prod` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_prod`, `id_usu`, `nom_prod`, `pre_prod`, `cantidad_prod`, `iva_prod`, `estado_prod`) VALUES
(87, 65, 'HARINA', '50.000', 0, 0, 1),
(88, 65, 'ARVEJAS MARISOL', '50.000', 90, 0, 0),
(89, 65, 'Pasta LA GRAN ESPERANZA', '123.000', 11, 0, 1),
(90, 65, 'Panela EL LEON', '12.000', 10, 0, 1),
(91, 65, 'Salsa de Tomate LA POLAR', '50.000', 53, 0, 1),
(92, 65, 'Mayonesa POLAR', '150.000', 45, 0, 1),
(93, 65, 'Arvejas SAN JUAN', '456.000', 78, 0, 1),
(94, 65, 'Mortadela PLUMROSE', '1000.000', 9, 0, 1),
(95, 65, 'Pasta MARISOL GUTIERREZ', '20.000', 12, 0, 1),
(96, 65, 'MALTA LA POLAR', '5000.000', 500, 16, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `nom_usu` varchar(255) NOT NULL,
  `usu_usu` varchar(255) NOT NULL,
  `email_usu` varchar(255) NOT NULL,
  `contrasenna_usu` varchar(255) NOT NULL,
  `acceso_usu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nom_usu`, `usu_usu`, `email_usu`, `contrasenna_usu`, `acceso_usu`) VALUES
(64, 'Jorge Luis Heredia Jaimes', 'jorge12', 'jorge@gmail.com', '123', 0),
(65, 'Administrador ', 'admin', 'admin@gmail.com', 'root', 1),
(67, 'Super Administrador', 'SuperAdmin', 'superadmin@gmail.com', 'super_root', 2),
(111, 'JORGE CHAVEZ', 'chaves1234', 'chaves@gmail.com', '1234', 0),
(113, 'Mafalda', 'malfada_1964', 'mafalda@gmail.com', '123', 0),
(114, 'manuelita', 'sra_manuela', 'manu@gmail.com', '123', 0),
(115, 'josesito', 'jose123', 'jose12@gmail.com', '123', 0),
(116, 'felipe', 'felipe123', 'fel@gmail.com', '123', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carr`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `estado_carr` (`estado_carr`),
  ADD KEY `cantidad_vender_carr` (`cantidad_vender_carr`),
  ADD KEY `id_carr` (`id_carr`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fecha` (`fecha`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_com`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `id_carr` (`id_carr`),
  ADD KEY `nom_cliente` (`id_cliente`);

--
-- Indices de la tabla `configuracion_pdf`
--
ALTER TABLE `configuracion_pdf`
  ADD PRIMARY KEY (`id_conf_pdf`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `id_conf_pdf` (`id_conf_pdf`);

--
-- Indices de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD PRIMARY KEY (`id_fac`),
  ADD KEY `id_com` (`id_com`),
  ADD KEY `id_conf_pdf` (`id_conf_pdf`);

--
-- Indices de la tabla `permisos_acceso`
--
ALTER TABLE `permisos_acceso`
  ADD KEY `id_perm` (`id_perm`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `id_prod` (`id_prod`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `acceso_usu` (`acceso_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT de la tabla `configuracion_pdf`
--
ALTER TABLE `configuracion_pdf`
  MODIFY `id_conf_pdf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  MODIFY `id_fac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`id_carr`) REFERENCES `carrito` (`id_carr`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_ibfk_4` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `configuracion_pdf`
--
ALTER TABLE `configuracion_pdf`
  ADD CONSTRAINT `configuracion_pdf_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD CONSTRAINT `facturacion_ibfk_1` FOREIGN KEY (`id_conf_pdf`) REFERENCES `configuracion_pdf` (`id_conf_pdf`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facturacion_ibfk_2` FOREIGN KEY (`id_com`) REFERENCES `compras` (`id_com`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`acceso_usu`) REFERENCES `permisos_acceso` (`id_perm`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
