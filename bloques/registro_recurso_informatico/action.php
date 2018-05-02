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
?><?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	
	
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{	 
		if(isset($_POST['id_recurso']))
		{
			$cadena_sql='DELETE FROM aplicativo_recurso_informatico WHERE id_recurso='.$_POST['id_recurso'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
		}	
				
		$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."recurso_informatico` ";
		$cadena_sql.= "( `id_recurso` , `anno` , `recurso` , `estudiante` , `profesor` , `id_programa` ) ";					
		$cadena_sql.= "VALUES (";
		$cadena_sql.= "NULL," ;
		$cadena_sql.= $_POST['anno'].",";
		$cadena_sql.= "'".$_POST['recurso']."'," ;
		$cadena_sql.= $_POST['estudiante']."," ;
		$cadena_sql.= $_POST['profesor']."," ;
		$cadena_sql.= $_POST['programa'];
		$cadena_sql.=")";
		echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_recurso_informatico")."')</script>";   
			
	
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
