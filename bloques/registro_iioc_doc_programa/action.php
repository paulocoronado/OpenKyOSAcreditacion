<?PHP  
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
<?PHP  
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
?><?PHP  
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
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{

	if(isset($_POST['id_documento']))
	{
		$cadena_sql='DELETE FROM aplicativo_investigacion_documento ';
		$cadena_sql.='WHERE id_documento='.$_POST['id_documento'];
		//echo $cadena_sql.'<br>';
		//exit;
		$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		$cadena_sql='DELETE FROM aplicativo_doc_vigencia ';
		$cadena_sql.='WHERE id_documento='.$_POST['id_documento'];
		//echo $cadena_sql.'<br>';
		//exit;
		$acceso_db->ejecutar_acceso_db($cadena_sql);
		$agregar=$_POST['id_documento'];		
		$archivo=$_POST['archivo'];
		
	}
	else
	{
		$agregar="NULL";		
		if($_FILES['archivo'] == "none") 
		{
			$error=TRUE;
			
		}
		else
		{
			$existe=FALSE;
			if(!in_array($_FILES['archivo']['name'],$directorio)) 
			{
				
				$fichero = $path . "/" . $_FILES['archivo']['name'];
				$existe=TRUE;
				copy($_FILES['archivo']['tmp_name'], $fichero);
				$kb = filesize($_FILES['archivo']['tmp_name'])/1024;
				if($kb > $tam) 
				{
					unlink($fichero);
					$error=TRUE;
				}
				$archivo=$_FILES['archivo']['name'];
			}
		}
	}

	$error=FALSE;
				
	$cadena_sql="INSERT INTO `".$configuracion["prefijo"]."investigacion_documento` ";
	$cadena_sql.="( `id_documento` , `id_programa` , `titulo` , `documento` , `descripcion`) ";
	$cadena_sql.="VALUES (";
	$cadena_sql.=$agregar.",";
	$cadena_sql.=$_POST['programa'].",";
	$cadena_sql.="'".$_POST['titulo']."',";
	$cadena_sql.="'".$archivo."',";
	$cadena_sql.="'".$_POST['descripcion']."'";
	$cadena_sql.=")";
	//echo $cadena_sql;
	//exit;
	$acceso_db->ejecutar_acceso_db($cadena_sql);
	
	//insertar vigencia
	if($agregar=='NULL')
	{
		$cadena_sql="SELECT LAST_INSERT_ID()";
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$agregar=$registro[0][0];
		}
	
	
	}
	
	$vigencia=array(); 
	$contador=0;
	reset ($_POST);
	while (list ($clave, $val) = each ($_POST)) 
	{
		if(!strncmp ("docum", $clave, 5))
		{
			$vigencia[$contador]=$val;
			$contador++;
		}
	}
	
	
	for($contador=0;$contador<count($vigencia);$contador++) 	
	
	{
		$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."doc_vigencia ";
		
		//echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
		$cadena_sql.= "( `id_documento` , `anno` )  ";					
		$cadena_sql.= "VALUES (";
		$cadena_sql.= $agregar."," ;
		$cadena_sql.= $vigencia[$contador];
		$cadena_sql.=")";
		//echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
		
				
	}
			
			
}


unset($_POST['action']);
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('admin_iioc_programa')."&accion=".$_POST['accion']."&error=".$error."')</script>";

?>
