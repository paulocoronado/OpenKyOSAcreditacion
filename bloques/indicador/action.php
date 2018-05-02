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
  
indicador.action.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	formulario
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* 
*
* Script para mostrar los informes asociados al indicador.
*
*****************************************************************************************************************/
?><?php  
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");

$path= $configuracion['raiz_documento']."/documento";
/* Ruta dentro del servidor hacia el directorio en
donde se almacenan los archivos. */

$url = $configuracion['host'].$configuracion['site']."/documento";
/* URL absoluta del directorio en donde se almacenan
los archivos. */

$tam = 5000;
/* Tamaño máximo para los archivos que sean enviados.
(en kilobytes) */
$directorio= array();

$dir = opendir($path);

while($arch = readdir($dir))

$directorio[count($directorio)] = $arch;
closedir($dir);
$mensaje = "<font face=\"Verdana, Arial\" size=2>\n";
if($_FILES['archivo'] == "none") 
{
	$error=TRUE;
}
elseif(in_array($_FILES['archivo']['name'],$directorio)) 
{
	$error=TRUE;
}
else 
{
	$fichero = $path . "/" . $_FILES['archivo']['name'];
	echo $fichero."<br>";
	copy($_FILES['archivo']['tmp_name'], $fichero);
	$kb = filesize($_FILES['archivo']['tmp_name'])/1024;
	if($kb > $tam) 
	{
		unlink($fichero);
		$error=TRUE;
	}
	else 
	{
		$acceso_db=new dbms($configuracion);
		$enlace=$acceso_db->conectar_db();
		if (is_resource($enlace))
		{
			$error=FALSE;
			$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."informe ";
			$cadena_sql.="( `id_informe` , `id_programa` , `codigo_componente` , `nombre` , `observacion` ) ";
			$cadena_sql.="VALUES (";
			$cadena_sql.="NULL,";
			$cadena_sql.=$id_programa.",";
			$cadena_sql.="'".$_POST['accion']."',";
			$cadena_sql.="'".$_FILES['archivo']['name']."',";
			$cadena_sql.="'".$_POST['descripcion']."'";
			$cadena_sql.=")";
			//echo $cadena_sql;
			
			$acceso_db->ejecutar_acceso_db($cadena_sql);
		}
	}
}


include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");

// Rescatar el nombre de usuario desde los datos de sesion.

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro!=FALSE)
	{
		
		$el_usuario=$registro[0][0];
		
	}
	else
	{
		$el_usuario="";
	}
	//Rescatar el id_subsistema
	$cadena_sql="SELECT ";
	$cadena_sql.="id_subsistema ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."usuario_subsistema ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_usuario=".$el_usuario." ";
	$cadena_sql.="LIMIT 1";
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		$id_subsistema=$registro[0][0];
	}
	else
	{
		$id_subsistema=0;
	}
	unset($registro);
	unset($campos);
}

unset($_POST['action']);
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("indicador_".$id_subsistema)."&usuario=".$el_usuario."&accion=".$_POST['accion']."&error=".$error."')</script>";

?>
