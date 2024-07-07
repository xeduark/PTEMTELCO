-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-07-2024 a las 00:03:20
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
-- Base de datos: `ptemtelco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `DNI` varchar(10) DEFAULT NULL,
  `NOMBRE` varchar(100) DEFAULT NULL,
  `FECNAC` date DEFAULT NULL,
  `DIR` varchar(255) DEFAULT NULL,
  `TFNO` varchar(15) DEFAULT NULL,
  `CORREO` varchar(255) DEFAULT NULL,
  `CONTRASENA` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `DNI`, `NOMBRE`, `FECNAC`, `DIR`, `TFNO`, `CORREO`, `CONTRASENA`) VALUES
(7, '1039705317', 'jorge', '1998-08-22', 'Barbosa', '3003766780', 'xeduark@gmail.com', '$2y$10$5tHrXB5u17wsoMhpSC/f7.r1wVCRTWIvyZONlDo4qIM.pGRbL9jIG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_personas`
--

CREATE TABLE `tbl_personas` (
  `id` int(11) NOT NULL,
  `DNI` varchar(10) DEFAULT NULL,
  `NOMBRE` varchar(100) DEFAULT NULL,
  `FECNAC` date DEFAULT NULL,
  `DIR` varchar(255) DEFAULT NULL,
  `TFNO` varchar(15) DEFAULT NULL,
  `CORREO` varchar(255) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_personas`
--

INSERT INTO `tbl_personas` (`id`, `DNI`, `NOMBRE`, `FECNAC`, `DIR`, `TFNO`, `CORREO`, `admin_id`) VALUES
(1, '1039703289', 'Tatiana Berrocal', '1996-11-12', 'Vereda Platanito', '3216541273', 'tay@misena.edu.co', NULL),
(10, '1035189375', 'Andres Hernandez', '1999-01-12', 'Vereda Platanito', '3216457896', 'andres@example.com', NULL),
(12, '1035189375', 'Johnny', '1996-02-01', 'bello', '3016458895', 'jhonny@ejemplo.com', NULL),
(14, '1035189375', 'paula', '2000-03-05', 'barbosa', '3022553695', 'paula@ejemplo.com', NULL),
(15, '1039855953', 'carlos Cuesta', '1998-08-05', 'medellin', '3148592665', 'carlos@ejemplo.com', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_id` (`admin_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  ADD CONSTRAINT `fk_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
