-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2022 a las 06:20:37
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
(82, 2, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16'),
(83, 1, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16'),
(84, 118, 'Empresa Josue S.A', '00000000-0', 'San Manuel de Jasis', '0276-0000000', 'Gracias por la compra, ¡Feliz día!', '16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `id_fac` int(11) NOT NULL,
  `id_com` int(11) NOT NULL,
  `id_conf_pdf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Administrador ', 'admin', 'admin@gmail.com', 'root', 1),
(2, 'Super Administrador', 'SuperAdmin', 'superadmin@gmail.com', 'super_root', 2),
(118, 'Pepito', 'pepito', 'pepito@gmail.com', 'pepito', 0);

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
  MODIFY `id_carr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=493;

--
-- AUTO_INCREMENT de la tabla `configuracion_pdf`
--
ALTER TABLE `configuracion_pdf`
  MODIFY `id_conf_pdf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  MODIFY `id_fac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

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
