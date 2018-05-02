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
* @description  Action de registro de informacion anual para profesores
* @usage        
*****************************************************************************************************************/
?><?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
		
  		
		
		
$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{	 
		if(isset($_POST['id_produccion']))
		{
			$cadena_sql='DELETE FROM `aplicativo_profesor_info_produccion` ';
			$cadena_sql.='WHERE id_profesor_produccion='.$_POST['id_produccion'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			$agregar=$_POST['id_produccion'];		
			
		}
		else
		{
			$agregar="NULL";		
		}	
				
		$cadena_sql="SELECT anno ";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."profesor_info_produccion` ";
		$cadena_sql.="WHERE anno= ".$_POST['anno'];
		$cadena_sql.=" AND identificacion="."'".$_POST['identificacion']."'";
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos==0)
		{	
			$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."profesor_info_produccion` ";
			$cadena_sql.= "( `id_profesor_produccion` , `identificacion` , `anno` , `indexada` , `especializada` , `innovacion` , `artistica` , `patente` ) ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= $agregar."," ;
			$cadena_sql.= "'".$_POST['identificacion']."',";
			$cadena_sql.= $_POST['anno'].",";
			$cadena_sql.= (trim($_POST['indexada'])*1).",";
			$cadena_sql.= (trim($_POST['especializada'])*1).",";
			$cadena_sql.= (trim($_POST['innovacion'])*1).",";
			$cadena_sql.= (trim($_POST['artistica'])*1).",";
			$cadena_sql.= (trim($_POST['patente'])*1);
			$cadena_sql.=")";
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			if($resultado==TRUE)
			{
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_iioc_profesor")."&registro=".$_POST['identificacion']."')</script>";   
				
		
			}
			else
			{
				//Instanciar a la clase pagina con mensaje de error
				echo "Error";
			}
		}	
		else
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_iioc_profesor")."&registro=".$_POST['identificacion']."')</script>";   
		}
	} 
	else
	{
		echo "Error fatal al acceder a la base de datos.";
			
	}	
?>
