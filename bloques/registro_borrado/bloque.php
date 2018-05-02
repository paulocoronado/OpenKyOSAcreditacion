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
  
registro_borrado.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	bloque
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* 
*
* Pagina para eliminar registros del sistema
*
*****************************************************************************************************************/
?><?php  

if(isset($_GET['accion']))
{
	$borrar_acceso_db=new dbms($configuracion);
	$borrar_enlace=$borrar_acceso_db->conectar_db();
	if (is_resource($borrar_enlace))
	{
				
		include_once ($configuracion["raiz_documento"].$configuracion["bloques"]."/registro_borrado/".$_GET['opcion'].".php");
		
		if(isset($pagina))
		{
			
			unset($_POST['action']);
			$variable="";
			
			//Envia todos los datos que vienen con GET
			reset ($_GET);
			while (list ($clave, $val) = each ($_GET)) 
			{
				if($clave!='page')
				{
				$variable.="&".$clave."=".$val;
				}
			}
			
			if(!isset($error))
			{
				?>
				<script type="text/javascript" language="javascript1.2">
						<!--
							alert("El registro se ha eliminado del sistema.");
						//-->
				</script>
				<?php  
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
			}
			else
			{
				?>
				<script type="text/javascript" language="javascript1.2">
						<!--
							alert("Imposible eliminar el registro del sistema.");
						//-->
				</script>
				<?php  
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
			
			}
		}
				
	}
	else
	{
	//ERROR AL INGRESAR A LA BD
	
	}
	
}
?>
