<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?>
<?php
/****************************************************************************************************************
* @name          index.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   
* @package	instalar
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario para el ingreso de los parámetros básicos de configuración del SIAUD; en un archivo de
*               inclusión por si solo no tiene uso
*
*****************************************************************************************************************/
?><?php


	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");
	$mensaje=new mensaje($this->id_pagina,$configuracion);
	
	
	
	
?>
