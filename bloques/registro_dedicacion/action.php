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
		$cadena_sql="SELECT * ";
		$cadena_sql.= " FROM aplicativo_profesor_info_dedicacion";
		$cadena_sql.=" WHERE anno=".$_POST['anno'];
		$cadena_sql.=" AND identificacion=".$_POST['identificacion'];
		$cadena_sql.=" AND id_programa=".$id_programa;
		$cadena_sql.=" AND periodo=".$_POST['periodo'];
		//echo $cadena_sql.'<br>';
		//exit;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		
		if(isset($_POST['id_dedicacion']))
		{
			//Se debe realizar un UPDATE	
			
			if($campos>0)
			{
				//El anno ya esta registrado entonces se realiza un UPDATE
				$cadena_sql = "UPDATE `".$configuracion["prefijo"]."profesor_info_dedicacion` SET ";
				$cadena_sql.= "`identificacion` = '".$_POST['identificacion']."',";
				$cadena_sql.= "`id_programa` = ".$id_programa.",";
				$cadena_sql.= "anno=".$_POST['anno'].",";
				$cadena_sql.= "docencia='".$_POST['docencia']."',";
				$cadena_sql.= "investigacion='".$_POST['investigacion']."',";
				$cadena_sql.= "proyeccion='".$_POST['proyeccion']."',";
				$cadena_sql.= "administrativa='".$_POST['administrativa']."',";
				$cadena_sql.= "periodo='".$_POST['periodo']."'";
				$cadena_sql.= " WHERE id_dedicacion=".$_POST['id_dedicacion']." LIMIT 1";
				
				//echo $cadena_sql.'<br>';
				
			}
			else
			{
				//Esta porcion de codigo no debiera ejecutarse nunca.
				$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."profesor_info_dedicacion` ";
				$cadena_sql.= "( `id_dedicacion` , `identificacion` , `id_programa` , `anno` , `docencia` , `investigacion` , `proyeccion` , `administrativa` ,`periodo` , `observacion` ) ";					
				$cadena_sql.= "VALUES (";
				$cadena_sql.= "NULL," ;
				$cadena_sql.= "'".$_POST['identificacion']."'," ;
				$cadena_sql.= $id_programa."," ;
				$cadena_sql.= $_POST['anno']."," ;
				$cadena_sql.= "'".$_POST['docencia']."'," ;
				$cadena_sql.= "'".$_POST['investigacion']."'," ;
				$cadena_sql.= "'".$_POST['proyeccion']."'," ;
				$cadena_sql.= "'".$_POST['administrativa']."'," ;
				$cadena_sql.= "'".$_POST['periodo']."'," ;
				$cadena_sql.= "''";				
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
		else
		{
			//Se debe realizar un INSERT
			
			if($campos>0)
			{
				//Esta porcion de codigo no debiera ejecutarse nunca. TO DO
				
				$cadena_sql = "UPDATE `".$configuracion["prefijo"]."profesor_info_dedicacion` SET ";
				$cadena_sql.= "`identificacion` = '".$_POST['identificacion']."',";
				$cadena_sql.= "`id_programa` = ".$id_programa.",";
				$cadena_sql.= "anno=".$_POST['anno'].",";
				$cadena_sql.= "docencia='".$_POST['docencia']."',";
				$cadena_sql.= "investigacion='".$_POST['investigacion']."',";
				$cadena_sql.= "proyeccion='".$_POST['proyeccion']."',";
				$cadena_sql.= "administrativa='".$_POST['administrativa']."',";
				$cadena_sql.= "periodo='".$_POST['periodo']."'";
				$cadena_sql.= " WHERE id_dedicacion=".$_POST['id_dedicacion']." LIMIT 1";
				//echo $cadena_sql.'<br>';
				
			}
			else
			{
				
				$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."profesor_info_dedicacion` ";
				$cadena_sql.= "( `id_dedicacion` , `identificacion` , `id_programa` , `anno` , `docencia` , `investigacion` , `proyeccion` , `administrativa` , `periodo` ,`observacion` ) ";					
				$cadena_sql.= "VALUES (";
				$cadena_sql.= "NULL," ;
				$cadena_sql.= "'".$_POST['identificacion']."'," ;
				$cadena_sql.= $id_programa."," ;
				$cadena_sql.= $_POST['anno']."," ;
				$cadena_sql.= "'".$_POST['docencia']."'," ;
				$cadena_sql.= "'".$_POST['investigacion']."'," ;
				$cadena_sql.= "'".$_POST['proyeccion']."'," ;
				$cadena_sql.= "'".$_POST['administrativa']."'," ;
				$cadena_sql.= "'".$_POST['periodo']."'," ;
				$cadena_sql.= "''";				
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
