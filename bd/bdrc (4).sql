-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2015 a las 19:19:15
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bdrc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE IF NOT EXISTS `administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `telefono` char(10) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `nombre`, `dni`, `telefono`, `direccion`, `email`, `clave`) VALUES
(12, 'Enma Romero Moran', '45878602', '990183754', 'av. confraternidad S/N', 'enma@enma.com', 'e10adc3949ba59abbe56e057f20f883e'),
(13, 'Elias Ataucusi Flores', '70771143', '990183754', 'av. confraternidad S/N', 'elias@elias.com', 'e10adc3949ba59abbe56e057f20f883e'),
(14, 'Jesus Rosales', '45878669', '973205093', 'Jr. Juan Francisco Ramos N° 380', 'jesus@jesus.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancha`
--

CREATE TABLE IF NOT EXISTS `cancha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `ubicacion` varchar(45) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `calificacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cancha_usuario1_idx` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `cancha`
--

INSERT INTO `cancha` (`id`, `nombre`, `ubicacion`, `admin_id`, `calificacion`) VALUES
(27, 'El Campin', 'Urb. Pochccota n231', 12, 4),
(28, 'El Campin 2', 'Urb. Pochccota n 315', 12, NULL),
(30, 'El Paraiso', 'Jr. Ayacucho n 341', 13, NULL),
(31, 'Maracana', 'Jr. cusco n 234', 14, NULL),
(32, 'La Finka', 'San Jeronimo n 435', 14, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

CREATE TABLE IF NOT EXISTS `control` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE IF NOT EXISTS `reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cancha_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `fecha_realizada` date NOT NULL,
  `calificacion_cancha` int(11) DEFAULT NULL,
  `calificacion_usuario` int(11) DEFAULT NULL,
  `coment_usuario` varchar(200) DEFAULT NULL,
  `coment_administrador` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reserva_cancha1_idx` (`cancha_id`),
  KEY `fk_reserva_usuario1_idx` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id`, `cancha_id`, `usuario_id`, `fecha`, `hora`, `fecha_realizada`, `calificacion_cancha`, `calificacion_usuario`, `coment_usuario`, `coment_administrador`) VALUES
(13, 27, 4, '2015-07-31', '05:00:00', '2015-07-30', 0, 0, NULL, NULL),
(14, 27, 4, '2015-08-10', '11:00:00', '2015-07-30', 0, 0, NULL, NULL),
(15, 27, 5, '2015-07-31', '22:00:00', '2015-07-30', 0, 0, NULL, NULL),
(16, 27, 5, '2015-08-02', '17:00:00', '2015-07-30', 0, 0, NULL, NULL),
(17, 27, 5, '2015-07-31', '23:00:00', '2015-07-30', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `telefono` char(10) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `dni`, `telefono`, `direccion`, `email`, `clave`) VALUES
(4, 'Mariyoli Ataucusi Romero', '70771143', '996311769', 'av. confraternidad S/N', 'marlyar@mariyoli.com', 'e10adc3949ba59abbe56e057f20f883e'),
(5, 'Roxana Ataucusi Romero', '70771142', '996311555', 'av. confraternidad S/N', 'roxana@roxana.com', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cancha`
--
ALTER TABLE `cancha`
  ADD CONSTRAINT `fk_cancha_usuario1` FOREIGN KEY (`admin_id`) REFERENCES `administrador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_reserva_cancha1` FOREIGN KEY (`cancha_id`) REFERENCES `cancha` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reserva_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
