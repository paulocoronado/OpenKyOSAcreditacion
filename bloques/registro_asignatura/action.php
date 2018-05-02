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
  
registro.action.php 

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
* @description  Action de registro de informacion anual para profesores
* @usage        
*****************************************************************************************************************/
?><?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");		
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{	
		
	//Borrar todas las entradas en la base de datos correspondientes a esa asignatura
	$cadena_sql="DELETE ";
	$cadena_sql.="FROM ".$configuracion["prefijo"]."profesor_info_asignatura ";
	$cadena_sql.="WHERE asignatura='".$_POST['asignatura']."' ";
	$cadena_sql.="AND identificacion='".$_POST['identificacion']."' ";
	$cadena_sql.="AND id_programa=".$id_programa." ";
	//echo $cadena_sql.'<br>';
	$borrar=$acceso_db->ejecutar_acceso_db($cadena_sql);
	
	if($borrar==TRUE)
	{
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			
			if(isset($_POST[$anno]))
			{
				$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."profesor_info_asignatura` ";
				$cadena_sql.= "( `identificacion` , `id_programa` , `anno` , `asignatura` , `observacion` ) ";					
				$cadena_sql.= "VALUES (";
				$cadena_sql.= "'".$_POST['identificacion']."','".$id_programa."','".$_POST[$anno]."','".$_POST['asignatura']."',''";
				$cadena_sql.=")";
				//echo $cadena_sql.'<br>';
				$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			}
		}
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_dir_profesor")."&registro=".$_POST['identificacion']."&usuario=".$_POST['usuario']."')</script>";   
		
	
	}
	

} 
else
{
	echo "Error fatal al acceder a la base de datos.";
		
}



	
?>
