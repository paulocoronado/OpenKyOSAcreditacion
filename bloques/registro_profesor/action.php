<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
  
registro.action.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Action de registro de usuarios
* @usage        
*******************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}


include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
if(!(strlen($_REQUEST['nombre'])>2)
   ||!(strlen($_REQUEST['apellido'])>2)
   ||!(strlen($_REQUEST['identificacion'])>4))
{

	echo "Error Fatal en el formulario.";
}
else
{
		
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{	 
		$cadena_sql="SELECT ";
		$cadena_sql.="* ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."profesor ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="identificacion='".$_REQUEST["identificacion"]."'";
		$cadena_sql.="LIMIT 1";
		//echo $this->cadena_sql;
		$campos=$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		if($campos>0)
		{
			unset($_REQUEST['action']);
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			$pagina="profesor_existe";
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."')</script>";
		}
		else
		{
			if($_REQUEST['nacimiento_mes']!="" && $_REQUEST['nacimiento_dia']!="" && $_REQUEST['nacimiento_anno']!="")
			{
				$cadena=$_REQUEST['nacimiento_mes']."/".$_REQUEST['nacimiento_dia']."/".$_REQUEST['nacimiento_anno'];
				$nacimiento=strtotime($cadena);
			}
			else
			{
				$nacimiento=0;
			}
			
			
			$la_cadena=new cadenas();
			
			
			$cadena_sql="INSERT INTO ";
			$cadena_sql.=$configuracion["prefijo"]."profesor "; 
			$cadena_sql.="( ";
			$cadena_sql.="`nombre`, ";
			$cadena_sql.="`apellido`, ";
			$cadena_sql.="`id_tipo_identificacion`, ";
			$cadena_sql.="`identificacion`, ";
			$cadena_sql.="`sexo`, ";
			$cadena_sql.="`nacimiento`, ";
			$cadena_sql.="`correo`, ";
			$cadena_sql.="`telefono`, ";
			$cadena_sql.="`fecha` ";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES ";
			$cadena_sql.="( ";
			$cadena_sql.="'".$la_cadena->convertir_a_mayusculas($_REQUEST['nombre'])."', ";
			$cadena_sql.="'".$la_cadena->convertir_a_mayusculas($_REQUEST['apellido'])."', ";
			$cadena_sql.="'".$_REQUEST['id_tipo_identificacion']."', ";
			$cadena_sql.="'".$_REQUEST['identificacion']."', ";
			$cadena_sql.="'".$_REQUEST['sexo']."', ";
			$cadena_sql.="'".$nacimiento."', ";
			$cadena_sql.="'".$_REQUEST['correo']."', ";
			$cadena_sql.="'".$_REQUEST['telefono']."', ";
			$cadena_sql.="'".time()."' ";
			$cadena_sql.=")";			
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
			if($resultado==TRUE)
			{
				unset($_REQUEST['action']);
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				$pagina="registro_profesor_exito";
				$variable="&&registro=".$_REQUEST['identificacion'];
				$variable.="&&opcion=mostrar";
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";

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
	}





?>





	
?>
