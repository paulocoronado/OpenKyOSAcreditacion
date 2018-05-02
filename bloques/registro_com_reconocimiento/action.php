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
* @description  Action de registro de usuarios
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
	if(isset($_POST['id_reconocimiento']))
	{
		$cadena_sql='DELETE FROM aplicativo_com_reconocimiento ';
		$cadena_sql.="WHERE id_reconocimiento='".$_POST['id_reconocimiento']."'";
		//echo $cadena_sql.'<br>';
		//exit;
		$acceso_db->ejecutar_acceso_db($cadena_sql);
		$agregar=$_POST['id_reconocimiento'];
	}	
	else
	{
		
		$agregar="NULL";
	
	}
			
	$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."com_reconocimiento` ";
	$cadena_sql.= "( `id_reconocimiento` , `id_material` , `reconocimiento`,`descripcion`,`ambito` ) ";					
	$cadena_sql.= "VALUES (";
	$cadena_sql.= $agregar.",";
	$cadena_sql.= $_POST['id_material'].",";
	$cadena_sql.= "'".$_POST['nombre']."',";
	$cadena_sql.= "'".$_POST['descripcion']."',";
	$cadena_sql.= $_POST['ambito'];
	$cadena_sql.=")";
	echo $cadena_sql."<br>";
	$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
	if($resultado==TRUE)
	{
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_com_material")."&id_material=".$_POST['id_material']."&registro=".$_POST['identificacion']."')</script>";   
		

	}
	else
	{
		//Instanciar a la clase pagina con mensaje de error
		echo "Error";
	}
} 
else
{
	echo "Error fatal al acceder a la base de datos.";
		
}	
?>
