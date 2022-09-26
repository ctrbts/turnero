-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 02, 2018 at 10:50 PM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `db_turnero`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_campos_selmultiple`
--

CREATE TABLE `t_campos_selmultiple` (
  `idcamposelmultiple` int(11) NOT NULL,
  `idcampoforma` int(11) DEFAULT NULL,
  `idcampotipo` int(11) DEFAULT NULL,
  `valores` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_campos_selmultiple`
--

INSERT INTO `t_campos_selmultiple` (`idcamposelmultiple`, `idcampoforma`, `idcampotipo`, `valores`) VALUES
(6, 9, 6, 'Consulta General|Urologia|Ginecologia|Pediatria'),
(7, 19, 6, 'subtest1|subtest2|subtest3|subtest4'),
(8, 20, 8, 'opcion 1|opcion 2|opcion 3|opcion 4'),
(9, 21, 7, 'opcion 1|opcion 2|opcion 3|opcion 4'),
(10, 24, 7, 'Opcion 1|opcion 2|opcion 3|opcion 4'),
(11, 25, 8, 'check 1|check 2|check 3|check 4'),
(12, 31, 7, 'Si, Deseo suscribirme|No, Por el momento'),
(13, 33, 7, 'Si, Deseo suscribirme|No, Por el momento');

-- --------------------------------------------------------

--
-- Table structure for table `t_campos_tipos`
--

CREATE TABLE `t_campos_tipos` (
  `idtiposcampo` int(11) NOT NULL,
  `descripcion` varchar(55) DEFAULT NULL,
  `tipo` varchar(55) DEFAULT NULL,
  `activo` varchar(55) DEFAULT NULL,
  `htmlcode` text,
  `selmultiple` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_campos_tipos`
--

INSERT INTO `t_campos_tipos` (`idtiposcampo`, `descripcion`, `tipo`, `activo`, `htmlcode`, `selmultiple`) VALUES
(1, 'Etiqueta simple en formulario', ' Etiqueta', '1', 'PHA+PGxhYmVsIG5hbWU9Jm5hbWU+JnZhbHVlPC9sYWJlbD48cD4=', 0),
(2, 'Muestra un Texto en el formulario', 'Texto Simple', '1', 'PHA+JnZhbHVlPHA+', 0),
(3, 'Muestra una area de Texto ', 'Area Texto', '1', 'Jm5hbWUNCjxicj4NCjx0ZXh0YXJlYSBuYW1lPSImbmFtZV8maWQiIHZhbHVlPSImdmFsdWUiPjwvdGV4dGFyZWE+', 0),
(4, 'Caja de Texto', 'Caja de Texto', '1', 'PGJyLz4mbmFtZTogPGlucHV0IG5hbWU9IiZuYW1lXyZpZCIgdmFsdWU9IiZ2YWx1ZSIgc3R5bGU9ImZvbnQtc2l6ZTogbGFyZ2UiIC8+', 0),
(5, 'Titulo usando html tag h1', 'Encabezado h1', '1', 'PGgyPiZ2YWx1ZTwvaDI+', 0),
(6, 'Seleccion multiple caja de opciones simple', 'Seleccion multiple combobox', '1', 'PHA+Jm5hbWU8c2VsZWN0IG5hbWU9IiZuYW1lXyZpZCI+Jmxpc3Q8b3B0aW9uIHZhbHVlPSImdmFsdWUiPiZ2YWx1ZTwvb3B0aW9uPiZsaXN0PC9zZWxlY3Q+PHA+', 1),
(7, 'Seleccion multiple boton radial ', 'Seleccion multiple boton radial', '1', 'PHA+Jmxpc3Q8aW5wdXQgdHlwZT0icmFkaW8iIG5hbWU9IiZuYW1lXyZpZCIgdmFsdWU9IiZ2YWx1ZSIgLz7CoCAmdmFsdWUgJmxpc3Q8L3A+', 1),
(8, 'Seleccion Multiple Caja de Check', 'Caja Check', '1', 'PGgyPlNlbGVjaW9uZSBsYSBvcGNpb248L2gyPg0KJmxpc3Q8aW5wdXQgdHlwZT0iY2hlY2tib3giIG5hbWU9IiZuYW1lXyZpZCIgdmFsdWU9IiZ2YWx1ZSI+wqAmdmFsdWUgJmxpc3Q=', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_citas`
--

CREATE TABLE `t_citas` (
  `idcita` int(10) UNSIGNED NOT NULL,
  `dia` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
  `mes` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
  `anio` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `hr_inicio` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `hr_fin` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idestatus` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `editmode` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_citas`
--

INSERT INTO `t_citas` (`idcita`, `dia`, `mes`, `anio`, `hr_inicio`, `hr_fin`, `iduser`, `idestatus`, `editmode`) VALUES
(1, '14', '03', '2016', '08:00:00', '08:40:00', 6, '1', 0),
(2, '14', '03', '2016', '14:00:00', '14:40:00', 6, '2', 0),
(3, '31', '03', '2016', '10:00:00', '10:40:00', 6, '2', 0),
(4, '14', '03', '2016', '11:20:00', '12:00:00', 7, '2', 0),
(5, '21', '04', '2016', '09:20:00', '10:00:00', 6, '2', 0),
(6, '25', '10', '2018', '10:00:00', '10:40:00', 6, '2', 0),
(7, '24', '10', '2018', '10:40:00', '11:20:00', 6, '2', 0),
(8, '31', '10', '2018', '10:40:00', '11:20:00', 11, '0', 0),
(9, '31', '10', '2018', '11:20:00', '12:00:00', 11, '0', 0),
(19, '02', '11', '2018', '11:20:00', '12:00:00', 11, '0', 0),
(20, '02', '11', '2018', '14:00:00', '14:40:00', 11, '0', 0),
(21, '02', '11', '2018', '15:20:00', '16:00:00', 11, '0', 0),
(22, '02', '11', '2018', '14:40:00', '15:20:00', 11, '0', 0),
(23, '05', '11', '2018', '08:00:00', '08:40:00', 11, '0', 0),
(24, '08', '11', '2018', '14:00:00', '14:40:00', 11, '0', 0),
(25, '06', '11', '2018', '08:00:00', '08:40:00', 11, '0', 0),
(26, '06', '11', '2018', '09:20:00', '10:00:00', 11, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_citas_estatus`
--

CREATE TABLE `t_citas_estatus` (
  `idestatus` int(11) NOT NULL,
  `estado` varchar(55) COLLATE latin1_general_ci DEFAULT NULL,
  `Activo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_citas_estatus`
--

INSERT INTO `t_citas_estatus` (`idestatus`, `estado`, `Activo`) VALUES
(1, 'Atendida', 1),
(2, 'Cancelada', 1),
(3, 'No Atendida', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_citas_formas`
--

CREATE TABLE `t_citas_formas` (
  `idregistro` int(11) NOT NULL,
  `idcita` int(11) DEFAULT NULL,
  `idforma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_citas_formas`
--

INSERT INTO `t_citas_formas` (`idregistro`, `idcita`, `idforma`) VALUES
(1, 19, 9),
(2, 19, 5),
(3, 19, 16),
(4, 20, 5),
(5, 20, 16),
(6, 21, 16),
(7, 22, 9),
(8, 23, 9),
(9, 23, 16),
(10, 24, 9),
(11, 24, 5),
(12, 24, 16),
(13, 25, 16),
(14, 26, 16);

-- --------------------------------------------------------

--
-- Table structure for table `t_formas`
--

CREATE TABLE `t_formas` (
  `idforma` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `visible` tinyint(4) DEFAULT NULL,
  `seleccion` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_formas`
--

INSERT INTO `t_formas` (`idforma`, `descripcion`, `activo`, `visible`, `seleccion`) VALUES
(5, 'Tipo de Consulta', 1, 0, 1),
(9, 'Datos Paciente', 0, 1, 0),
(16, 'Datos Particulares', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_formas_valores`
--

CREATE TABLE `t_formas_valores` (
  `idformavalores` int(11) NOT NULL,
  `idforma` int(11) DEFAULT NULL,
  `idcampoforma` int(11) DEFAULT NULL,
  `valor` longtext,
  `idcita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_formas_valores`
--

INSERT INTO `t_formas_valores` (`idformavalores`, `idforma`, `idcampoforma`, `valor`, `idcita`) VALUES
(145, 9, 8, 'Fernando Merlo', 19),
(146, 9, 9, 'Urologia', 19),
(147, 9, 22, 'area de texto', 19),
(148, 9, 24, 'Opcion 1', 19),
(149, 9, 25, 'check 1', 19),
(150, 5, 5, '', 19),
(151, 16, 27, 'Mar Negro # 187 fraccionamiento Villas Vallarta', 19),
(152, 16, 28, 'calle', 19),
(153, 16, 29, 'Villas Vallarta', 19),
(154, 16, 30, '63735', 19),
(155, 16, 33, 'Si, Deseo suscribirme', 19),
(156, 5, 5, '37', 20),
(157, 16, 27, '', 20),
(158, 16, 28, '', 20),
(159, 16, 29, '', 20),
(160, 16, 30, '', 20),
(161, 16, 27, 'test', 21),
(162, 16, 28, 'test', 21),
(163, 16, 29, 'test', 21),
(164, 16, 30, 'etst', 21),
(165, 16, 33, 'No, Por el momento', 21),
(166, 9, 8, 'marco cantu gea', 22),
(167, 9, 9, 'Urologia', 22),
(168, 9, 22, 'a bueno si funciona esta area', 22),
(169, 9, 24, 'Opcion 1', 22),
(170, 9, 25, 'check 2', 22),
(171, 9, 8, 'Fernando Merlo', 23),
(172, 9, 9, 'Consulta General', 23),
(173, 9, 22, 'a bueno esta es una prueba', 23),
(174, 9, 24, 'opcion 2', 23),
(175, 9, 25, 'check 2', 23),
(176, 16, 27, 'Mar Negro # 187 fraccionamiento Villas Vallarta', 23),
(177, 16, 28, 'Mar Antillano 225', 23),
(178, 16, 29, 'Villas Vallarta', 23),
(179, 16, 30, '63735', 23),
(180, 16, 33, 'Si, Deseo suscribirme', 23),
(181, 9, 8, 'Fernando Merlo', 24),
(182, 9, 9, 'Urologia', 24),
(183, 9, 22, 'a bueno', 24),
(184, 9, 24, 'opcion 4', 24),
(185, 9, 25, 'check 4', 24),
(186, 5, 5, '37', 24),
(187, 16, 27, 'Mar Negro # 187 fraccionamiento Villas Vallarta', 24),
(188, 16, 30, '63735', 24),
(189, 16, 33, 'Si, Deseo suscribirme', 24),
(190, 16, 27, 'direccion', 25),
(191, 16, 28, 'Mar Antillano 225', 25),
(192, 16, 29, 'Villas Vallarta', 25),
(193, 16, 30, 'sal;fjalkjsdla', 25),
(194, 16, 33, 'No, Por el momento', 25),
(195, 16, 27, 'direccion', 26),
(196, 16, 28, 'Mar Antillano 225', 26),
(197, 16, 29, 'colonia', 26),
(198, 16, 30, '63735', 26),
(199, 16, 33, 'No, Por el momento', 26),
(200, 16, 35, '51651651651', 26);

-- --------------------------------------------------------

--
-- Table structure for table `t_formulario_campos`
--

CREATE TABLE `t_formulario_campos` (
  `idcampoforma` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `valorpordefecto` varchar(255) DEFAULT NULL,
  `idforma` int(11) DEFAULT NULL,
  `idtipocampo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_formulario_campos`
--

INSERT INTO `t_formulario_campos` (`idcampoforma`, `nombre`, `activo`, `valorpordefecto`, `idforma`, `idtipocampo`) VALUES
(5, 'Edad:', 1, '', 5, 4),
(7, 'Letrero Bienvenida', 1, 'Favor de llenar la siguiente informacion:', 9, 2),
(8, 'Nombre Completo', 1, ' Este es un valor', 9, 4),
(9, 'Tipo Consulta ', 1, '', 9, 6),
(10, 'Notificacion', 1, 'Su cita sera cancelada si no se confirma atravez de una llamada telfonica durante las primeras 24hrs', 9, 1),
(22, 'Preba area de texto', 1, 'valor por default', 9, 3),
(23, 'Encabezado de pagina', 1, 'prueba de encabezado', 9, 5),
(24, 'Selecione la opcion', 1, '', 9, 7),
(25, 'Prueba Checkbox', 1, '', 9, 8),
(26, 'Letrero', 1, 'Llene la siguiente informacion', 16, 5),
(27, 'Direccion', 1, '', 16, 4),
(28, 'Calle', 1, '', 16, 4),
(29, 'Colonia', 1, '', 16, 4),
(30, 'Codigo Postal', 1, '', 16, 4),
(32, 'Desea suscribirse a nuestro sitio web', 1, 'Desea suscribirse a nuestro sitio web', 16, 5),
(33, 'Subscripcion', 1, '', 16, 7),
(35, 'tarjeta de credito', 1, '', 16, 4);

-- --------------------------------------------------------

--
-- Table structure for table `t_menus`
--

CREATE TABLE `t_menus` (
  `idMenu` int(11) NOT NULL,
  `etiqueta` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  `path` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `hasmenus` int(11) DEFAULT NULL,
  `accion` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `idModulo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_menus`
--

INSERT INTO `t_menus` (`idMenu`, `etiqueta`, `activo`, `path`, `hasmenus`, `accion`, `idModulo`) VALUES
(1, 'Administraci&oacuten de Modulos', 1, '/modules/SysManager/ModuleManager.php', 0, '', 11),
(6, 'Administraci&oacuten de Menus', 1, '/modules/SysManager/MenuManager.php', 0, '', 11),
(8, 'Ver Turnos Programadas', 1, '/modules/CitasManager/CitasManager.php', 0, '', 12),
(11, 'Configurar Horarios', 1, '/modules/ConfiguracionAgenda/AgendaConfManager.php', 0, '', 13),
(12, 'Roles y Permisos', 1, '/modules/AccessManagement/AccessManagement.php', 0, '', 11),
(13, 'Usuarios Registrados', 1, '/modules/UserManager/UserManager.php', 0, '', 11),
(15, 'Administraci&oacuten de Formas', 1, '/modules/FormsManager/FormsManager.php', 0, '', 11);

-- --------------------------------------------------------

--
-- Table structure for table `t_menus_ficha`
--

CREATE TABLE `t_menus_ficha` (
  `idMenu` int(11) DEFAULT NULL,
  `idModulo` int(11) DEFAULT NULL,
  `ficha` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `espublico` int(11) DEFAULT NULL,
  `acceso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_modulos`
--

CREATE TABLE `t_modulos` (
  `idmodulo` int(11) NOT NULL,
  `etiqueta` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  `path` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `hasmenus` int(11) DEFAULT NULL,
  `accion` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_modulos`
--

INSERT INTO `t_modulos` (`idmodulo`, `etiqueta`, `activo`, `path`, `hasmenus`, `accion`) VALUES
(10, 'Agenda Tu Turno', 1, '/modules/Agenda/ViewAgenda.php', 0, ''),
(11, 'Configuracion de Sistema', 1, '#', 0, ''),
(12, 'Administraci&oacuten Agenda', 1, '#', 0, ''),
(13, 'Configuraci&oacuten Agenda', 1, '#', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `t_modulo_ficha`
--

CREATE TABLE `t_modulo_ficha` (
  `idModulo` int(11) DEFAULT NULL,
  `ficha` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `espublico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_profile_menu`
--

CREATE TABLE `t_profile_menu` (
  `idprofilemenu` int(11) NOT NULL,
  `idprofile` int(11) DEFAULT NULL,
  `idMenu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_profile_menu`
--

INSERT INTO `t_profile_menu` (`idprofilemenu`, `idprofile`, `idMenu`) VALUES
(35, 3, 8),
(36, 3, 9),
(37, 3, 10),
(44, 2, 1),
(45, 2, 6),
(46, 2, 12),
(47, 2, 13),
(48, 2, 8),
(49, 2, 11);

-- --------------------------------------------------------

--
-- Table structure for table `t_profile_module`
--

CREATE TABLE `t_profile_module` (
  `idprofilemodule` int(11) NOT NULL,
  `idprofile` int(11) DEFAULT NULL,
  `idmodulo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_profile_module`
--

INSERT INTO `t_profile_module` (`idprofilemodule`, `idprofile`, `idmodulo`) VALUES
(66, 1, 10),
(71, 3, 12),
(76, 2, 10),
(77, 2, 11),
(78, 2, 12),
(79, 2, 13),
(80, 2, 14);

-- --------------------------------------------------------

--
-- Table structure for table `t_regla_diasasueto`
--

CREATE TABLE `t_regla_diasasueto` (
  `iddiaasueto` int(10) UNSIGNED NOT NULL,
  `dia` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_regla_diasasueto`
--

INSERT INTO `t_regla_diasasueto` (`iddiaasueto`, `dia`) VALUES
(20, '2016-01-01 00:00:00'),
(25, '2016-02-01 00:00:00'),
(28, '2016-03-23 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_regla_diasdisp`
--

CREATE TABLE `t_regla_diasdisp` (
  `iddias` int(10) UNSIGNED NOT NULL,
  `dia` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `activo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_regla_diasdisp`
--

INSERT INTO `t_regla_diasdisp` (`iddias`, `dia`, `activo`) VALUES
(54, 'lunes', 1),
(55, 'martes', 1),
(56, 'miercoles', 1),
(57, 'jueves', 1),
(58, 'viernes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_regla_general`
--

CREATE TABLE `t_regla_general` (
  `idreglageneral` int(10) UNSIGNED NOT NULL,
  `variable` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `valor` varchar(100) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_regla_general`
--

INSERT INTO `t_regla_general` (`idreglageneral`, `variable`, `valor`) VALUES
(9, 'TiempoEstimadoCita', '30'),
(18, 'TiempoEntreCita', '10');

-- --------------------------------------------------------

--
-- Table structure for table `t_regla_horarios`
--

CREATE TABLE `t_regla_horarios` (
  `idhrs` int(11) NOT NULL,
  `hr_inicio` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `hr_fin` varchar(5) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_regla_horarios`
--

INSERT INTO `t_regla_horarios` (`idhrs`, `hr_inicio`, `hr_fin`) VALUES
(4, '08:00', '12:30'),
(5, '14:00', '16:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_systemconf`
--

CREATE TABLE `t_systemconf` (
  `idVariable` int(11) NOT NULL,
  `variable` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `valor` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_systemconf`
--

INSERT INTO `t_systemconf` (`idVariable`, `variable`, `valor`) VALUES
(1, 'ProfileToNewUsers', '1');

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `iduser` int(10) UNSIGNED NOT NULL,
  `email` varchar(1024) COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(1024) CHARACTER SET latin1 DEFAULT NULL,
  `nombre` varchar(1024) COLLATE latin1_general_ci DEFAULT NULL,
  `apellidos` varchar(10124) COLLATE latin1_general_ci DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `idprofile` int(11) DEFAULT NULL,
  `activationtoken` varchar(100) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`iduser`, `email`, `password`, `nombre`, `apellidos`, `active`, `idprofile`, `activationtoken`) VALUES
(6, 'marco.cantu.g@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Marco', 'Cantu', 1, 2, '4fbfb888c7235fce1abcc7d09dc60918'),
(11, 'admin@server.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrador', 'del Sistema', 1, 2, NULL),
(12, 'adminagenda@server.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrador', 'de Agenda', 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_user_profiles`
--

CREATE TABLE `t_user_profiles` (
  `idprofile` int(11) NOT NULL,
  `profile` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `active` varchar(45) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `t_user_profiles`
--

INSERT INTO `t_user_profiles` (`idprofile`, `profile`, `active`) VALUES
(1, 'Publico', '1'),
(2, 'Administradores', '1'),
(3, 'Administradores Agenda', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_campos_selmultiple`
--
ALTER TABLE `t_campos_selmultiple`
  ADD PRIMARY KEY (`idcamposelmultiple`);

--
-- Indexes for table `t_campos_tipos`
--
ALTER TABLE `t_campos_tipos`
  ADD PRIMARY KEY (`idtiposcampo`);

--
-- Indexes for table `t_citas`
--
ALTER TABLE `t_citas`
  ADD PRIMARY KEY (`idcita`);

--
-- Indexes for table `t_citas_estatus`
--
ALTER TABLE `t_citas_estatus`
  ADD PRIMARY KEY (`idestatus`),
  ADD UNIQUE KEY `idestatus_UNIQUE` (`idestatus`);

--
-- Indexes for table `t_citas_formas`
--
ALTER TABLE `t_citas_formas`
  ADD PRIMARY KEY (`idregistro`);

--
-- Indexes for table `t_formas`
--
ALTER TABLE `t_formas`
  ADD PRIMARY KEY (`idforma`);

--
-- Indexes for table `t_formas_valores`
--
ALTER TABLE `t_formas_valores`
  ADD PRIMARY KEY (`idformavalores`);

--
-- Indexes for table `t_formulario_campos`
--
ALTER TABLE `t_formulario_campos`
  ADD PRIMARY KEY (`idcampoforma`);

--
-- Indexes for table `t_menus`
--
ALTER TABLE `t_menus`
  ADD PRIMARY KEY (`idMenu`),
  ADD UNIQUE KEY `idMenu_UNIQUE` (`idMenu`),
  ADD KEY `idModulo_idx` (`idModulo`);

--
-- Indexes for table `t_modulos`
--
ALTER TABLE `t_modulos`
  ADD PRIMARY KEY (`idmodulo`),
  ADD UNIQUE KEY `idmodulo_UNIQUE` (`idmodulo`);

--
-- Indexes for table `t_profile_menu`
--
ALTER TABLE `t_profile_menu`
  ADD PRIMARY KEY (`idprofilemenu`),
  ADD UNIQUE KEY `idprofilemenu_UNIQUE` (`idprofilemenu`);

--
-- Indexes for table `t_profile_module`
--
ALTER TABLE `t_profile_module`
  ADD PRIMARY KEY (`idprofilemodule`),
  ADD UNIQUE KEY `idprofilemodule_UNIQUE` (`idprofilemodule`);

--
-- Indexes for table `t_regla_diasasueto`
--
ALTER TABLE `t_regla_diasasueto`
  ADD PRIMARY KEY (`iddiaasueto`);

--
-- Indexes for table `t_regla_diasdisp`
--
ALTER TABLE `t_regla_diasdisp`
  ADD PRIMARY KEY (`iddias`);

--
-- Indexes for table `t_regla_general`
--
ALTER TABLE `t_regla_general`
  ADD PRIMARY KEY (`idreglageneral`);

--
-- Indexes for table `t_regla_horarios`
--
ALTER TABLE `t_regla_horarios`
  ADD PRIMARY KEY (`idhrs`),
  ADD UNIQUE KEY `idhrs_UNIQUE` (`idhrs`);

--
-- Indexes for table `t_systemconf`
--
ALTER TABLE `t_systemconf`
  ADD PRIMARY KEY (`idVariable`),
  ADD UNIQUE KEY `idVariable_UNIQUE` (`idVariable`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `t_user_profiles`
--
ALTER TABLE `t_user_profiles`
  ADD PRIMARY KEY (`idprofile`),
  ADD UNIQUE KEY `idprofile_UNIQUE` (`idprofile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_campos_selmultiple`
--
ALTER TABLE `t_campos_selmultiple`
  MODIFY `idcamposelmultiple` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `t_campos_tipos`
--
ALTER TABLE `t_campos_tipos`
  MODIFY `idtiposcampo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `t_citas`
--
ALTER TABLE `t_citas`
  MODIFY `idcita` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `t_citas_estatus`
--
ALTER TABLE `t_citas_estatus`
  MODIFY `idestatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_citas_formas`
--
ALTER TABLE `t_citas_formas`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `t_formas`
--
ALTER TABLE `t_formas`
  MODIFY `idforma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `t_formas_valores`
--
ALTER TABLE `t_formas_valores`
  MODIFY `idformavalores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT for table `t_formulario_campos`
--
ALTER TABLE `t_formulario_campos`
  MODIFY `idcampoforma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `t_menus`
--
ALTER TABLE `t_menus`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `t_modulos`
--
ALTER TABLE `t_modulos`
  MODIFY `idmodulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `t_profile_menu`
--
ALTER TABLE `t_profile_menu`
  MODIFY `idprofilemenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `t_profile_module`
--
ALTER TABLE `t_profile_module`
  MODIFY `idprofilemodule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `t_regla_diasasueto`
--
ALTER TABLE `t_regla_diasasueto`
  MODIFY `iddiaasueto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `t_regla_diasdisp`
--
ALTER TABLE `t_regla_diasdisp`
  MODIFY `iddias` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `t_regla_general`
--
ALTER TABLE `t_regla_general`
  MODIFY `idreglageneral` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `t_regla_horarios`
--
ALTER TABLE `t_regla_horarios`
  MODIFY `idhrs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `t_systemconf`
--
ALTER TABLE `t_systemconf`
  MODIFY `idVariable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `iduser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `t_user_profiles`
--
ALTER TABLE `t_user_profiles`
  MODIFY `idprofile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_menus`
--
ALTER TABLE `t_menus`
  ADD CONSTRAINT `idModulo` FOREIGN KEY (`idModulo`) REFERENCES `t_modulos` (`idmodulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
