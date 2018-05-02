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
		if(isset($_POST['edicion']))
		{
			$cadena_sql='DELETE FROM aplicativo_servicio_programa ';
			$cadena_sql.='WHERE id_servicio='.$_POST['registro'];
			$cadena_sql.=' AND id_programa='.$_POST['programa'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			
		}
		$institucional=array();
		$contador=0;
		
		reset ($_POST);
		while (list ($clave, $val) = each ($_POST)) 
		{
			if(!strncmp ("servi", $clave, 5))
			{
				$institucional[$contador++]=$val;
				
			}
			
		}
		//echo count($annos)."<br>";
		
		// Guardar informacion de estado del grupo
		$resultado=TRUE;
		
		for($contador=0;$contador<count($institucional);$contador++) 	
		
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."servicio_programa ";
			$cadena_sql.= "( `id_servicio` , `id_programa` , `anno` )  ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= $_POST['registro'].",";
			$cadena_sql.= $_POST['programa'].",";
			$cadena_sql.= $institucional[$contador];
			$cadena_sql.=")";
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			
					
		}
		//exit;
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_bienestar_servicio")."&registro=".$_POST['registro']."')</script>";   
			
	
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
