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
  
001action.php 

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
* Script de procesamiento del formulario de autenticacion de usuarios
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


unset($_POST['action']);
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('indicador_programa')."&usuario=".$_POST['usuario']."&accion=".$_POST['accion']."&error=".$error."')</script>";
/*

$error=FALSE;
if ($_FILES['archivo']=='none')
{
  $error=TRUE;  
 
}
else
{

	if ($_FILES['archivo']['size']==0)
	{
		$error=TRUE;
	
	}
	else
	{
		
		if ($_FILES['archivo']['type'] != 'text/plain')
		{
			$error=TRUE;
			
		}
		else
		{
		
			$directorio_temporal = get_cfg_var('upload_tmp_dir');
			
			if ($directorio_temporal==FALSE) 
			{
				$directorio_temporal = dirname(tempnam('', ''));
			}
			
			$archivo_temporal=$directorio_temporal.'/'.basename($_FILES['archivo']['tmp_name']);
			
			if(ereg_replace('/+', '/', $archivo_temporal) == $_FILES['archivo']['tmp_name'])
			{
				$subir = $configuracion["raiz_documento"].'/documento/'.$_FILES['archivo']['name'];
				if ( !copy($_FILES['archivo']['tmp_name'], $subir))
				{
					$error=TRUE;
				}
				
			}
			else
			{
				$error=TRUE;
			
			}
		}	
	}
}

if($error==FALSE)
{
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
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
unset($_POST['action']);
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('indicador_programa')."&usuario=".$_POST['usuario']."&accion=".$_POST['accion']."&error=".$error."')</script>";
*/
?>
