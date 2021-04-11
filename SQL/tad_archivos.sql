-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-01-2021 a las 16:01:05
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cbc_sede`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tad_archivos`
--

CREATE TABLE `tad_archivos` (
  `id_archivo_tad` int(11) NOT NULL,
  `d_archivo_tad` varchar(100) NOT NULL,
  `d_archivo_orig` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tad_archivos`
--

INSERT INTO `tad_archivos` (`id_archivo_tad`, `d_archivo_tad`, `d_archivo_orig`) VALUES
(1, 'tad11.csv', ''),
(2, 'tad12.csv', ''),
(3, 'tad13.csv', ''),
(4, 'tad14.csv', ''),
(5, 'tad15.csv', ''),
(6, 'tad16.csv', ''),
(7, 'tad17.csv', ''),
(8, 'tad18.csv', ''),
(9, 'tad19.csv', ''),
(10, 'tad110.csv', ''),
(11, 'tad111.csv', ''),
(12, 'tad112.csv', ''),
(13, 'tad113.csv', ''),
(14, 'tad114.csv', ''),
(15, 'tad115.csv', ''),
(16, 'tad116.csv', ''),
(17, 'tad117.csv', ''),
(18, 'tad124.csv', ''),
(19, 'tad125.csv', ''),
(20, 'tad126.csv', ''),
(21, 'tad127.csv', ''),
(22, 'tad128.csv', ''),
(23, 'tad129.csv', ''),
(24, 'tad130.csv', ''),
(25, 'tad131.csv', ''),
(26, 'tad132.csv', ''),
(27, 'tad133.csv', ''),
(28, 'tad134.csv', ''),
(29, 'tad135.csv', ''),
(30, 'tad136.csv', ''),
(31, 'tad137.csv', ''),
(32, 'tad138.csv', ''),
(33, 'tad139.csv', ''),
(34, 'tad140.csv', ''),
(35, 'tad141.csv', ''),
(36, 'tad142.csv', ''),
(37, 'tad143.csv', ''),
(38, 'tad144.csv', ''),
(39, 'tad145.csv', ''),
(40, 'tad146.csv', ''),
(41, 'tad147.csv', ''),
(42, 'tad148.csv', ''),
(43, 'tad149.csv', ''),
(44, 'tad150.csv', ''),
(45, 'tad151.csv', ''),
(46, 'tad152.csv', ''),
(47, 'tad153.csv', ''),
(48, 'tad154.csv', ''),
(49, 'tad155.csv', ''),
(50, 'tad156.csv', ''),
(51, 'tad157.csv', ''),
(52, 'tad158.csv', ''),
(53, 'tad159.csv', ''),
(54, 'tad160.csv', ''),
(55, 'tad1-prueba.csv', ''),
(56, 'tad1-prueba1.csv', ''),
(57, 'tad161.csv', ''),
(58, 'tad2.csv', ''),
(59, 'tad21.csv', ''),
(60, 'tad162.csv', ''),
(61, 'tad163.csv', ''),
(62, 'tad164.csv', ''),
(63, 'tad165.csv', ''),
(64, 'tad166.csv', ''),
(65, 'tad167.csv', ''),
(66, 'tad168.csv', ''),
(67, 'tad169.csv', ''),
(68, 'tad170.csv', ''),
(69, 'tad171.csv', ''),
(70, 'tad172.csv', ''),
(71, 'tad173.csv', ''),
(72, 'tad174.csv', ''),
(73, 'tad175.csv', ''),
(74, 'tad1-prueba2.csv', ''),
(75, 'tad1-prueba3.csv', ''),
(76, 'tad1-prueba4.csv', ''),
(77, 'tad1-prueba5.csv', ''),
(78, 'tad1-prueba6.csv', ''),
(79, 'tad1-prueba7.csv', ''),
(80, 'tad1-prueba8.csv', ''),
(81, 'tad1-prueba9.csv', ''),
(82, 'tad1-prueba10.csv', ''),
(83, 'tad1-prueba11.csv', ''),
(84, 'tad1-prueba12.csv', ''),
(85, 'tad1-prueba13.csv', ''),
(86, 'tad1-prueba14.csv', ''),
(87, 'tad1-prueba15.csv', ''),
(88, 'tad1-prueba16.csv', ''),
(89, 'tad1-prueba17.csv', ''),
(90, 'tad1-prueba18.csv', ''),
(91, 'tad1-prueba19.csv', ''),
(92, 'tad1-prueba20.csv', ''),
(93, 'tad1-prueba21.csv', ''),
(94, 'tad1-prueba22.csv', ''),
(95, 'tad1-prueba23.csv', ''),
(96, 'tad1-prueba24.csv', ''),
(97, 'tad1-prueba25.csv', ''),
(98, 'tad176.csv', ''),
(99, 'tad177.csv', ''),
(100, 'tad178.csv', ''),
(101, 'tad179.csv', ''),
(102, 'tad180.csv', ''),
(103, 'tad181.csv', ''),
(104, 'tad182.csv', 'csv'),
(105, 'tad183.csv', 'tad1.csv'),
(106, 'tad184.csv', 'tad1.csv'),
(107, 'tad185.csv', 'tad1.csv'),
(108, 'tad186.csv', 'tad1.csv'),
(109, 'tad187.csv', 'tad1.csv'),
(110, 'tad188.csv', 'tad1.csv'),
(111, 'tad189.csv', 'tad1.csv'),
(112, 'tad190.csv', 'tad1.csv'),
(113, 'tad191.csv', 'tad1.csv'),
(114, 'tad192.csv', 'tad1.csv'),
(115, 'tad193.csv', 'tad1.csv'),
(116, 'tad194.csv', 'tad1.csv'),
(117, 'tad195.csv', 'tad1.csv'),
(118, 'tad22.csv', 'tad2.csv'),
(119, 'tad196.csv', 'tad1.csv'),
(120, 'tad1_utf8.csv', 'tad1_utf8.csv'),
(121, 'tad1_utf81.csv', 'tad1_utf8.csv'),
(122, 'tad1_utf82.csv', 'tad1_utf8.csv'),
(123, 'tad1_ansi.csv', 'tad1_ansi.csv'),
(124, 'tad197.csv', 'tad1.csv'),
(125, 'tad198.csv', 'tad1.csv');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tad_archivos`
--
ALTER TABLE `tad_archivos`
  ADD PRIMARY KEY (`id_archivo_tad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tad_archivos`
--
ALTER TABLE `tad_archivos`
  MODIFY `id_archivo_tad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
