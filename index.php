<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/****************************************************************************************************************
* @name          index.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 6 de Marzo de 2006
*******************************************************************************************************************
* @subpackage   
* @package	mescud 
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Pagina principal del aplicativo
*
*****************************************************************************************************************/
require_once("configuracion/config.inc.php");




if(!defined("APLICATIVO_INSTALADO"))
{
	
	
	//include_once("bloques/instalar/bloque.php");	
	exit;
}
if (!defined("CLASS_PATH"))
{
	define ("CLASS_PATH", $configuracion["raiz_documento"].$configuracion["clases"]."/");
}

//Transicion

if(!isset($_REQUEST[$configuracion["enlace"]]))
{
	//Normal sin codificacion
	//Si viene algun valor de pagina encriptado en el metodo GET/POST se usa.
	if(!isset($_GET['page']) && !isset($_POST['page']))
	{
	
		/*
		index.php es la única página que tiene nivel de acceso 0 - todos los usuarios pueden accederla
		*/
		$pagina_nivel=0;
		$nombre="index";
		
		
	}
	else
	{
		if(!isset($_POST['page']))
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			$nombre=desenlace($_GET['page']);
			//echo $nombre;
		}
		else
		{
			$nombre=$_POST['page'];
			
		
		}
		
	}
	//Revisa los parametros de autenticacion de la pagina
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/autenticacion/autenticacion.inc.php");
	
	/*Metodo para armar la pagina*/
	$la_pagina=new pagina($nombre,$configuracion);
}
else
{
	//Enlaces codificados
	$la_pagina=new pagina("",$configuracion);
}


/*Fin metodo de armar la pagina*/
function __autoload($class_name) 
{
	$clase = CLASS_PATH.$class_name.'.class.php';
	//echo $clase;
	if (file_exists($clase)) require_once $clase;
};
?>
