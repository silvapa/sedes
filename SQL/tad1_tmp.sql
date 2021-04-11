-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-01-2021 a las 16:00:54
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
-- Estructura de tabla para la tabla `tad1_tmp`
--

CREATE TABLE `tad1_tmp` (
  `Fecha_caratulacion` varchar(16) NOT NULL,
  `Expediente` varchar(23) NOT NULL,
  `Estado_expediente` varchar(10) NOT NULL,
  `Documento_FINUB` varchar(24) NOT NULL,
  `Reparticion_actual_del_expediente` varchar(9) NOT NULL,
  `Sector_actual_del_expediente` varchar(7) NOT NULL,
  `Fecha_de_ultimo_pase` varchar(16) NOT NULL,
  `EMAIL` varchar(80) NOT NULL,
  `TELEFONO` int(11) NOT NULL,
  `NOMBRE_SOLICITANTE` varchar(50) NOT NULL,
  `APELLIDO_SOLICITANTE` varchar(50) NOT NULL,
  `RAZON_SOCIAL_SOLICITANTE` varchar(50) DEFAULT NULL,
  `SEGUNDO_APELLIDO_SOLICITANTE` varchar(50) DEFAULT NULL,
  `TERCER_APELLIDO_SOLICITANTE` varchar(50) DEFAULT NULL,
  `SEGUNDO_NOMBRE_SOLICITANTE` varchar(50) DEFAULT NULL,
  `TERCER_NOMBRE_SOLICITANTE` varchar(50) DEFAULT NULL,
  `CUIT_CUIL` int(11) NOT NULL,
  `DOMICILIO` varchar(80) NOT NULL,
  `PISO` varchar(20) DEFAULT NULL,
  `DPTO` varchar(20) DEFAULT NULL,
  `CODIGO_POSTAL` int(11) NOT NULL,
  `BARRIO` varchar(80) DEFAULT NULL,
  `COMUNA` varchar(80) DEFAULT NULL,
  `ALTURA` varchar(30) DEFAULT NULL,
  `PROVINCIA` varchar(50) NOT NULL,
  `DEPARTAMENTO` varchar(20) NOT NULL,
  `LOCALIDAD` varchar(80) NOT NULL,
  `TIPO_DOCUMENTO` varchar(2) NOT NULL,
  `NUMERO_DOCUMENTO` int(11) NOT NULL,
  `FECHA_NAC` date NOT NULL,
  `GENERO` varchar(9) NOT NULL,
  `NACIONALIDAD` varchar(30) NOT NULL,
  `LUGAR_NAC_BAHRA_PROVINCIA` varchar(50) NOT NULL,
  `LUGAR_NAC_BAHRA_DPTO` varchar(50) NOT NULL,
  `LUGAR_NAC_BAHRA_LOCALIDAD` varchar(50) NOT NULL,
  `REQUIERE_CERTIF_ESP` varchar(2) NOT NULL,
  `DISCAPACIDAD` varchar(2) NOT NULL,
  `CARRERA_A_SEGUIR` varchar(50) NOT NULL,
  `TRABAJA` varchar(2) NOT NULL,
  `DOC_ESTUDIOS_MEDIOS` varchar(100) NOT NULL,
  `OPCION_MAT_ELECTIVA` varchar(50) DEFAULT NULL,
  `mensaje` varchar(40) DEFAULT NULL,
  `id_archivo_tad` int(11) NOT NULL,
  `t_coincidencia` char(1) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'I',
  `f_estado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `en_padron` char(1) DEFAULT NULL,
  `clave` int(6) NOT NULL,
  `anio` smallint(11) NOT NULL,
  `baja` char(1) NOT NULL,
  `sancion` char(1) NOT NULL,
  `t_tramite` char(1) DEFAULT NULL,
  `t_mail_enviar_cbc` char(1) DEFAULT NULL,
  `mail_enviado_cbc` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tad1_tmp`
--

INSERT INTO `tad1_tmp` (`Fecha_caratulacion`, `Expediente`, `Estado_expediente`, `Documento_FINUB`, `Reparticion_actual_del_expediente`, `Sector_actual_del_expediente`, `Fecha_de_ultimo_pase`, `EMAIL`, `TELEFONO`, `NOMBRE_SOLICITANTE`, `APELLIDO_SOLICITANTE`, `RAZON_SOCIAL_SOLICITANTE`, `SEGUNDO_APELLIDO_SOLICITANTE`, `TERCER_APELLIDO_SOLICITANTE`, `SEGUNDO_NOMBRE_SOLICITANTE`, `TERCER_NOMBRE_SOLICITANTE`, `CUIT_CUIL`, `DOMICILIO`, `PISO`, `DPTO`, `CODIGO_POSTAL`, `BARRIO`, `COMUNA`, `ALTURA`, `PROVINCIA`, `DEPARTAMENTO`, `LOCALIDAD`, `TIPO_DOCUMENTO`, `NUMERO_DOCUMENTO`, `FECHA_NAC`, `GENERO`, `NACIONALIDAD`, `LUGAR_NAC_BAHRA_PROVINCIA`, `LUGAR_NAC_BAHRA_DPTO`, `LUGAR_NAC_BAHRA_LOCALIDAD`, `REQUIERE_CERTIF_ESP`, `DISCAPACIDAD`, `CARRERA_A_SEGUIR`, `TRABAJA`, `DOC_ESTUDIOS_MEDIOS`, `OPCION_MAT_ELECTIVA`, `mensaje`, `id_archivo_tad`, `t_coincidencia`, `estado`, `f_estado`, `en_padron`, `clave`, `anio`, `baja`, `sancion`, `t_tramite`, `t_mail_enviar_cbc`, `mail_enviado_cbc`) VALUES
('30/08/2020 00:17', 'EX-2020-1582974-UBA-UBA', 'Iniciaci?n', 'PV-2020-01582976-UBA-UBA', 'DI#SG_CBC', 'GUARANI', '30/08/2020 00:17', 'tizianafernandas@gmail.com', 1153491453, 'TIZIANA FERNANDA', 'SOSA BORQUEZ', '', '', '', '', '', 2147483647, 'Calle A. Guastavino - 0', 'pb', '', 1712, '', '', '', 'BUENOS AIRES', 'MORON', 'CASTELAR', 'DU', 44937296, '0000-00-00', 'Femenino', 'Argentina', 'BUENOS AIRES', 'MORON', 'CASTELAR', 'No', 'No', 'Abogac?a [01]', 'No', 'Tengo t?tulo y/o anal?tico secundario legalizado / sin legalizar por la UBA [1]', '', '', 1, '', 'I', '2021-01-27 16:39:05', 'S', 805419, 2020, 'N', 'N', 'I', 'P', 'N'),
('30/08/2020 17:58', 'EX-2020-1583439-UBA-UBA', 'Iniciaci?n', 'PV-2020-01583441-UBA-UBA', 'DI#SG_CBC', 'GUARANI', '30/08/2020 17:58', 'zoeludmilaacuna@gmail.com', 1159613778, 'ZOE LUDMILA', 'ACU?A', '', '', '', '', '', 2147483647, 'Juan Bautista Alberdi - 1119', 'Ph ', '', 1744, '', '', '', 'BUENOS AIRES', 'MORENO', 'MORENO', 'DU', 42655083, '0000-00-00', 'Femenino', 'Argentina', 'BUENOS AIRES', 'MORENO', 'MORENO', 'No', 'No', 'Dise?o de Imagen y Sonido [76]', 'No', 'Tengo t?tulo y/o anal?tico secundario legalizado / sin legalizar por la UBA [1]', '', '', 1, '', 'I', '2021-01-27 16:39:05', 'S', 210054, 2020, 'N', 'N', 'I', 'P', 'N');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tad1_tmp`
--
ALTER TABLE `tad1_tmp`
  ADD PRIMARY KEY (`Expediente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
