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
?><?php  
/****************************************************************************************************************
  
autenticacion.inc.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Script para la validacion de usuarios y el control de acceso a los modulos.
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?><?php  

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");


/****
						Verificar sesion y nivel
**/
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_object($enlace))
{
	//Rescatar el nivel de acceso de la pagina
	$cadena_sql="SELECT nivel FROM ".$configuracion["prefijo"]."pagina WHERE nombre='".$nombre."' LIMIT 1";
	echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$total=$acceso_db->obtener_conteo_db();
	if($total<1)
	{
		//TODO Mensaje de error porque la pagina no tiene estructura basica		
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/mensaje/fallo_temporal.php");
		exit;
	}
	else
	{
		$pagina_nivel=$registro[0][0];
		
	}
	
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$nueva_sesion->especificar_nivel($pagina_nivel);
	//echo $pagina_nivel;
	$esta_sesion=$nueva_sesion->sesion($configuracion);
	if($pagina_nivel!=0)
	{
		if(!$esta_sesion)
		{
			echo "<h1>Fallo de Autenticaci&oacute;n</h1>Sesi&oacute;n no v&aacute;lida. Probablemente &eacute;sta haya expirado. ";		
			exit();
		}
		
	}
	//En todo momento se eliminan del sistema la informacion de sesiones expiradas
	$nueva_sesion->borrar_sesion_expirada($configuracion);


}else
{
			
			include_once($configuracion["raiz_documento"].$configuracion["encabezado"].'/header.php');	
			
			$error["encabezado"]="IMPOSIBLE REALIZAR LA ACCI&Oacute;N SOLICITADA";
			$error["cuerpo"]="<br>Se ha detectado un ingreso ilegal al sistema.<br>";
			$error["cuerpo"].="<br>Esto posiblemente se deba a que su sesi&oacute;n de trabajo ha expirado,";
			$error["cuerpo"].="por favor regrese a la p&aacute;gina de autenticaci&oacute;n e ingrese su nombre";
			$error["cuerpo"].="de usuario y contrase&ntilde;a.";
			
			include_once($configuracion["raiz_documento"].$configuracion["incluir"]."/error.php");	
			include_once($configuracion["raiz_documento"].$configuracion["encabezado"].'/footer.php');
			exit();
	
	
	}
unset($acceso_db);
unset($nueva_sesion);

/****
					Fin de verificar sesion y nivel
**/
?>
