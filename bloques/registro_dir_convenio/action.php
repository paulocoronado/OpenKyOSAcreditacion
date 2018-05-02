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
		if(isset($_POST['id_convenio']))
		{
			$cadena_sql='DELETE FROM aplicativo_dir_convenio WHERE id_convenio='.$_POST['id_convenio'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
		}	
				
		$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."dir_convenio` ";
		$cadena_sql.= "( `id_convenio` , `id_programa` , `nombre` , `objetivo` , `institucion` , `ambito` , `tipo` , `movilidad` , `estudiante` , `interaccion` , `profesor` , `calidad` , `anno` ) ";					
		$cadena_sql.= "VALUES (";
		$cadena_sql.= "NULL," ;
		$cadena_sql.= $id_programa."," ;
		$cadena_sql.= "'".$_POST['nombre']."'," ;
		$cadena_sql.= "'".$_POST['objetivo']."'," ;
		$cadena_sql.= "'".$_POST['institucion']."'," ;
		$cadena_sql.= $_POST['ambito']."," ;
		$cadena_sql.= $_POST['tipo']."," ;
		if(isset($_POST["movilidad"]))
		{
			$cadena_sql.= "1,";
		}
		else
		{
			$cadena_sql.= "0,";
		}
		$cadena_sql.= $_POST['estudiante']."," ;
		
		
		if(isset($_POST["interaccion"]))
		{
			$cadena_sql.= "1,";
		}
		else
		{
			$cadena_sql.= "0,";
		}
		$cadena_sql.= $_POST['profesor']."," ;
		if(isset($_POST["calidad"]))
		{
			$cadena_sql.= "1,";
		}
		else
		{
			$cadena_sql.= "0,";
		}
		
		$cadena_sql.= $_POST['anno'];
		$cadena_sql.=")";
		//echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_dir_convenio")."&usuario=".$_POST['usuario']."')</script>";   
			
	
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
