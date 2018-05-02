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
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
if(isset($_POST["cancelar"]))
{
	unset($_POST['action']);
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	$pagina="matriz_edu";
	echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."')</script>";   
	exit;

}
else
{
	if(!key_exists('nombre',$_POST)||!key_exists('codigo_modelo',$_POST))
	{
	
				echo "Faltan datos obligatorios. Por favor regrese y corrija el formulario.";	
		
	}
	else
	{
		
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
		if(!(strlen($_POST['nombre'])>2)||!(strlen($_POST['codigo_modelo'])>4))
		{
			//Instanciar a la clase pagina con mensaje de correccion de datos
			echo "Error en los datos. Por favor regrese y corrija el formulario.";
		}
		else
		{
				
			/**
			Segundo: Se comprueba que la identificacion no exista en la base de datos
			
			**/
			$acceso_db=new dbms($configuracion);
			$enlace=$acceso_db->conectar_db();
			if (is_resource($enlace))
			{	 
				//Recuperar el usuario
	
				$nueva_sesion=new sesiones($configuracion);
				$nueva_sesion->especificar_enlace($enlace);
				$esta_sesion=$nueva_sesion->numero_sesion();
				//Rescatar el valor de la variable usuario de la sesion
				$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
				if($registro)
				{
					
					$id_usuario=$registro[0][0];
		
				}
				else
				{
					exit;
		
				}
				if(isset($_POST['registro']))
				{	
					$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."documento";
					$cadena_sql.=" WHERE id_documento='".$_POST['registro']."'";
					//echo $cadena_sql;	
					//exit;
					$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
					$agregar=$_POST['registro'];
	
				}
				else
				{
					$agregar='NULL';
				}
	
				
				//Tercero: Se guarda el registro en la base de datos
					$cadena_sql = "INSERT INTO ";
					$cadena_sql.= "".$configuracion["prefijo"]."documento ";
					$cadena_sql.= "(";
					$cadena_sql.= "id_documento, ";
					$cadena_sql.= "nombre , ";
					$cadena_sql.= "id_tecnica, ";
					$cadena_sql.= "id_naturaleza, ";
					$cadena_sql.= "codigo_modelo, ";
					$cadena_sql.= "resumen, ";
					$cadena_sql.= "id_usuario ";
					$cadena_sql.= ") ";
					$cadena_sql.= "VALUES ";
					$cadena_sql.= "(";
					$cadena_sql.= $agregar.",";
					$cadena_sql.= "'".$_POST['nombre']."',";
					$cadena_sql.= $_POST['id_tecnica']." , ";
					$cadena_sql.= $_POST['id_naturaleza'].",";
					$cadena_sql.= "'".$_POST['codigo_modelo']."',";
					$cadena_sql.= "'".$_POST['resumen']."',";
					$cadena_sql.= $id_usuario."";
					$cadena_sql.= ")";
					//echo $cadena_sql;
					$db_sel = new dbms($configuracion);
					$db_sel->especificar_enlace($enlace);
					$resultado=$db_sel->ejecutar_acceso_db($cadena_sql); 
					if($resultado==TRUE)
					{
						reset($_POST);
						while(list($clave,$valor)=each($_POST))
						{
							unset($_POST[$clave]);
							 
						}
	?>
	<script type="text/javascript" language="javascript1.2">
	<!--
		alert("El registro ha sido correctamente guardado.");
	//-->
	</script>
	<?php  
						unset($_POST['action']);
						include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
						$pagina="matriz_edu";
						echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."')</script>";   
						//Instanciar a la clase pagina con mensaje de exito
	
					}
					else
					{
						//Instanciar a la clase pagina con mensaje de error
					}
							
				
			} 
			else
			{
				echo "Error fatal al acceder a la base de datos.";
					
			}
		}
	}
}
	
?>
