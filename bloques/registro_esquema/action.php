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
?><?php
/************************************************************************************************************
  
registro.action.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 28/07/2006

*************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Action de registro de usuarios
* @usage        
************************************************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{	 
	if(isset($_POST['opcion']))
	{
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
		//Tipo esquema 0: Orden de Importancia, 1: Analisis estructural
		if(desenlace($_POST['opcion'])=='editar')
		{
			$cadena_sql="UPDATE ".$configuracion["prefijo"]."esquema_ponderacion "; 
			$cadena_sql="SET "; 
			$cadena_sql.="`id_usuario`='".desenlace($_POST['id_usuario'])."', ";
			$cadena_sql.="`tipo_esquema`='".$_POST['tipo_esquema']."', ";
			$cadena_sql.="`id_modelo`='".$_POST['id_modelo']."', ";
			$cadena_sql.="`nombre`='".$_POST['nombre']."', ";
			$cadena_sql.="`descripcion`='".$_POST['descripcion']."', ";
			$cadena_sql.="`observacion`='".$_POST['observacion']."', ";
			$cadena_sql.="`fecha`='".desenlace($_POST['fecha'])." ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="`id_esquema`=".desenlace($_POST['id_esquema'])." ";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);		
		}
		else
		{
			if(desenlace($_POST['opcion'])=='nuevo')
			{
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$configuracion["prefijo"]."esquema_ponderacion "; 
				$cadena_sql.="( ";
				$cadena_sql.="`id_esquema`, ";
				$cadena_sql.="`id_usuario`, ";
				$cadena_sql.="`id_modelo`, ";
				$cadena_sql.="`nombre`, ";
				$cadena_sql.="`descripcion`, ";
				$cadena_sql.="`observacion`, ";
				$cadena_sql.="`fecha`, ";
				$cadena_sql.="`tipo_esquema` ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="( ";
				$cadena_sql.="NULL, ";
				$cadena_sql.="'".$id_usuario."', ";
				$cadena_sql.="'".$_POST['id_modelo']."', ";
				$cadena_sql.="'".$_POST['nombre']."', ";
				$cadena_sql.="'".$_POST['descripcion']."', ";
				$cadena_sql.="'".$_POST['observacion']."', ";
				$cadena_sql.="'".$_POST['fecha']."', ";
				$cadena_sql.="'".$_POST['tipo_esquema']."' ";
				$cadena_sql.=")";
				//echo $cadena_sql;
				$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);					
			}
			else
			{
				$resultado=FALSE;
			}
		
		}
		//echo $cadena_sql."<br>";
		
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			$opciones="page=".enlace("comite_esquema_ponderacion");
			$opciones.="&hoja=1";
			$opciones.="&accion=1";
			$opciones.="&admin=".enlace("lista");
			
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?".$opciones."')</script>";   
			
	
		}
		else
		{
			echo "<h3>Informaci&oacute;n.</h3>Imposible guardar o actualizar el registro.";	
		
		}
		
			
	}
	else
	{
		echo "<h3>Informaci&oacute;n.</h3>Imposible realizar la acci&oacute;n solicitada.";		
	}		
			
			
	
} 
else
{
	echo "Error fatal al acceder a la base de datos.";
		
}
	


	
?>
