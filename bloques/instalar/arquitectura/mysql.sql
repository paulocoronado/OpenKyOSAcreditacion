# phpMyAdmin SQL Dump
# version 2.5.7-pl1
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Aug 22, 2005 at 03:09 
# Server version: 3.23.58
# PHP Version: 4.3.4
# 
# Database : `aplicativo`
# 

# --------------------------------------------------------

#
# Table structure for table `aplicativo_acceso`
#

CREATE TABLE `aplicativo_acceso` (
  `id_usuario` varchar(5) NOT NULL default '',
  `acceso` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id_usuario`,`acceso`)
)  COMMENT='Registro de acceso de los usuarios';;;



#
# Table structure for table `aplicativo_bloque`
#

CREATE TABLE `aplicativo_bloque` (
  `id_bloque` int(5) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL default '',
  `descripcion` text,
  `grupo` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id_bloque`),
  KEY (`id_bloque`)
)  COMMENT='Bloques disponibles';;;

# --------------------------------------------------------

#
# Table structure for table `aplicativo_bloque_pagina`
#

CREATE TABLE `aplicativo_bloque_pagina` (
  `id_pagina` int(5) NOT NULL default '0',
  `id_bloque` int(5) NOT NULL default '0',
  `seccion` char(2) NOT NULL default '',
  `posicion` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id_pagina`,`id_bloque`)
)  COMMENT='Estructura de bloques de las paginas en el aplicativo';;;

# --------------------------------------------------------

#
# Table structure for table `aplicativo_ciudad`
#

CREATE TABLE `aplicativo_ciudad` (
  `id_ciudad` int(5) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  PRIMARY KEY  (`id_ciudad`)
)  AUTO_INCREMENT=2 ;;;

# --------------------------------------------------------

#
# Table structure for table `aplicativo_ciudad_pais`
#

CREATE TABLE `aplicativo_ciudad_pais` (
  `id_pais` int(5) default NULL,
  `id_ciudad` int(5) default NULL
) ;;;


# --------------------------------------------------------

#
# Table structure for table `aplicativo_estilo`
#

CREATE TABLE `aplicativo_estilo` (
  `usuario` varchar(50) NOT NULL default '0',
  `estilo` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`usuario`,`estilo`)
)  COMMENT='Estilo de pagina en el sitio';;;

#
# Dumping data for table `aplicativo_estilo`
#

INSERT INTO `aplicativo_estilo` (`usuario`, `estilo`) VALUES ('0', 'basico');;;

# --------------------------------------------------------

#
# Table structure for table `aplicativo_pagina`
#

CREATE TABLE `aplicativo_pagina` (
  `id_pagina` int(5) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL default '',
  `descripcion` text NOT NULL,
  `modulo` varchar(50) NOT NULL default '',
  `nivel` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id_pagina`)
)  PACK_KEYS=0 COMMENT='Relacion de paginas en el aplicativo' ;;;

#
# Table structure for table `aplicativo_pais`
#

CREATE TABLE `aplicativo_pais` (
  `id_pais` int(5) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL default '',
  `identificador` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`id_pais`),
  KEY `id_pais` (`id_pais`)
)  ;;;

#
# Dumping data for table `aplicativo_pais`
#


# --------------------------------------------------------

#
# Table structure for table `aplicativo_registrado`
#

CREATE TABLE `aplicativo_registrado` (
  `id_usuario` int(4) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL default '',
  `apellido` varchar(50) NOT NULL default '',
  `correo` varchar(100) NOT NULL default '',
  `usuario` varchar(50) NOT NULL default '',
  `clave` varchar(50) NOT NULL default '',
  `tipo` int(2) NOT NULL default '0',
  `estado` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_usuario`),
  KEY (`id_usuario`)
)  ;;;

# --------------------------------------------------------

#
# Table structure for table `aplicativo_tipo_usuario`
#

CREATE TABLE `aplicativo_tipo_usuario` (
  `id_usuario` int(1) NOT NULL default '0',
  `nombre` varchar(50) NOT NULL default '',
  `Descripcion` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id_usuario`)
)  COMMENT='Tipos de usuarios que pueden existir en el sistema';;;

# --------------------------------------------------------

#
# Table structure for table `aplicativo_usuario`
#

CREATE TABLE `aplicativo_usuario` (
  `nombre` varchar(50) NOT NULL default '',
  `clave` varchar(50) NOT NULL default '',
  `tipo` int(2) NOT NULL default '0',
  PRIMARY KEY  (`nombre`,`clave`)
) ;;;

#
# Table structure for table `aplicativo_valor_sesion`
#

CREATE TABLE `aplicativo_valor_sesion` (
  `id_sesion` varchar(32) NOT NULL default '',
  `variable` varchar(20) NOT NULL default '',
  `valor` text NOT NULL,
  PRIMARY KEY  (`id_sesion`,`variable`)
)  COMMENT='Valores de sesion';;;

