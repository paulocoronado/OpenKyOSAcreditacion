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
	
	/*
	echo "Valores enviados con el método POST:<br>";
	reset ($_POST);
	while (list ($clave, $val) = each ($_POST)) {
	echo "$clave => $val<br>";
	}
	exit;
	*/
	
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{	 
		if(isset($_POST['id_participacion']))
		{
			$cadena_sql='SELECT * FROM aplicativo_profesor_info_evento WHERE id_profesor_evento='.$_POST['id_participacion'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			//Se debe realizar un UPDATE	
			
			if($campos>0)
			{
				//El anno ya esta registrado entonces se realiza un UPDATE
				$cadena_sql = "UPDATE `".$configuracion["prefijo"]."profesor_info_evento` SET ";
				$cadena_sql.= "`identificacion` = '".$_POST['identificacion']."',";
				$cadena_sql.= "`id_programa` = ".$id_programa.",";
				$cadena_sql.= "anno=".$_POST['anno'].",";
				$cadena_sql.= "nombre='".$_POST['nombre']."',";
				$cadena_sql.= "ponencia='".$_POST['ponencia']."',";
				$cadena_sql.= "lugar='".$_POST['lugar']."',";
				$cadena_sql.= "ambito='".$_POST['ambito']."',";
				$cadena_sql.= "observacion='".$_POST['observacion']."'";
				$cadena_sql.= " WHERE id_profesor_evento=".$_POST['id_participacion']." LIMIT 1";
				//echo $cadena_sql.'<br>';
				
			}
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			if($resultado==TRUE)
			{
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_dir_profesor")."&registro=".$_POST['identificacion']."&usuario=".$_POST['usuario']."')</script>";   
				
		
			}
			else
			{
				//Instanciar a la clase pagina con mensaje de error
			}
			
				
		}
		else
		{		
			
			$cadena_sql="SELECT * ";
			$cadena_sql.='FROM aplicativo_profesor_info_evento ';
			$cadena_sql.='WHERE identificacion='.$_POST['identificacion'];
			$cadena_sql=' AND id_programa='.$id_programa;
			$cadena_sql=' AND anno='.$_POST['anno'];
			$cadena_sql=' AND nombre="'.$_POST['nombre'].'"';
			$cadena_sql=' AND ponencia="'.$_POST['ponencia'].'"';
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			
			
			//Se debe realizar un INSERT
			
			if($campos>0)
			{
				//Ya existe un registro con los mismos datos.TODO mensaje de error.
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_dir_profesor")."&registro=".$_POST['identificacion']."&usuario=".$_POST['usuario']."')</script>";   
				
				
				
			}
			else
			{
	
				$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."profesor_info_evento` ";
				$cadena_sql.= "( `id_profesor_evento` , `identificacion` , `id_programa` , `anno` , `nombre` , `ponencia` , `lugar` , `ambito` , `observacion` ) ";					
				$cadena_sql.= "VALUES (";
				$cadena_sql.= "NULL," ;
				$cadena_sql.= "'".$_POST['identificacion']."'," ;
				$cadena_sql.= $id_programa."," ;
				$cadena_sql.= $_POST['anno']."," ;
				$cadena_sql.= "'".$_POST['nombre']."'," ;
				$cadena_sql.= "'".$_POST['ponencia']."'," ;
				$cadena_sql.= "'".$_POST['lugar']."'," ;
				$cadena_sql.= "".$_POST['ambito']."," ;
				$cadena_sql.= "'".$_POST['observacion']."'";				
				$cadena_sql.=")";
				//echo $cadena_sql.'<br>';
			}
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			if($resultado==TRUE)
			{
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_dir_profesor")."&registro=".$_POST['identificacion']."&usuario=".$_POST['usuario']."')</script>";   
				
		
			}
			else
			{
				//Instanciar a la clase pagina con mensaje de error
			}
				
			
		}		
				
				
		
	} 
	else
	{
		echo "Error fatal al acceder a la base de datos.";
			
	}
	


	
?>
