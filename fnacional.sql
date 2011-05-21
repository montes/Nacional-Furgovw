-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-05-2011 a las 00:52:47
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6-1+lenny10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `furgovw`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fnacional`
--

CREATE TABLE IF NOT EXISTS `fnacional` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `year` varchar(4) NOT NULL,
  `numpago` int(10) unsigned NOT NULL,
  `nif` varchar(15) character set utf8 collate utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `idmember` int(10) unsigned NOT NULL,
  `fllegada` date NOT NULL,
  `adultos` tinyint(3) unsigned NOT NULL,
  `ninyos` tinyint(3) unsigned NOT NULL,
  `animales` varchar(100) NOT NULL,
  `marcavehiculo` varchar(30) NOT NULL,
  `modelovehiculo` varchar(50) NOT NULL,
  `anyovehiculo` int(10) unsigned NOT NULL,
  `matriculavehiculo` varchar(12) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `cp` varchar(5) character set utf8 collate utf8_unicode_ci NOT NULL,
  `movil` varchar(9) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `comentarios` text NOT NULL,
  `pagado` tinyint(3) unsigned NOT NULL,
  `pagado_en_plazo` datetime default NULL,
  `localidad` varchar(100) NOT NULL,
  `fechainscripcion` datetime NOT NULL,
  `Cam_Extra_1` varchar(20) default NULL,
  `Cam_Extra_2` varchar(20) default NULL,
  `Cam_Extra_3` varchar(20) default NULL,
  `Cam_Extra_4` varchar(20) default NULL,
  `Cam_Extra_5` varchar(20) default NULL,
  `Cam_Extra_6` varchar(20) default NULL,
  `Cata_Birra` tinyint(3) unsigned default '0',
  `pago_erroneo` int(11) default NULL,
  `price` int(10) unsigned NOT NULL default '0',
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idmember` (`idmember`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=415 ;
