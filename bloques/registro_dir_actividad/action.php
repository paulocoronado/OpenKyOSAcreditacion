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
		if(isset($_POST['id_actividad']))
		{
			$cadena_sql='DELETE FROM aplicativo_dir_actividad WHERE id_actividad='.$_POST['id_actividad'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
		}	
				
		$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."dir_actividad` ";
		$cadena_sql.= "( `id_actividad` , `id_programa` , `nombre` , `descripcion` , `tipo` , `ambito` , `directivo` , `profesor` , `estudiante` , `enfoque` , `nivel` , `inter` , `cooperacion` , `politica` , `anno` ) ";					
		$cadena_sql.= "VALUES (";
		$cadena_sql.= "NULL," ;
		$cadena_sql.= $id_programa."," ;
		$cadena_sql.= "'".$_POST['nombre']."'," ;
		$cadena_sql.= "'".$_POST['descripcion']."'," ;
		$cadena_sql.= "'".$_POST['tipo']."'," ;
		$cadena_sql.= $_POST['ambito']."," ;
		$cadena_sql.= $_POST['directivo']."," ;
		$cadena_sql.= $_POST['profesor']."," ;
		$cadena_sql.= $_POST['estudiante']."," ;
		$funcion="";
		if(isset($_POST["investigacion"]))
		{
			$funcion.="1";
		}
		else
		{
			$funcion.="0";				
		}
		
		if(isset($_POST["docencia"]))
		{
			$funcion.="1";
		}
		else
		{
			$funcion.="0";				
		}
		
		if(isset($_POST["proyeccion"]))
		{
			$funcion.="1";
		}
		else
		{
			$funcion.="0";				
		}
		
		if(isset($_POST["cooperacion"]))
		{
			$funcion.="1";
		}
		else
		{
			$funcion.="0";				
		}
		$cadena_sql.= "'".$funcion."',";
		$cadena_sql.= "'".$_POST['nivel']."'," ;
				
		if(isset($_POST["inter"]))
		{
			$cadena_sql.= "1,";
		}
		else
		{
			$cadena_sql.= "0,";
		}
		
		
		if(isset($_POST["coopera"]))
		{
			$cadena_sql.= "1,";
		}
		else
		{
			$cadena_sql.= "0,";
		}
		
		if(isset($_POST["politica"]))
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
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_dir_actividad")."&usuario=".$_POST['usuario']."')</script>";   
			
	
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
