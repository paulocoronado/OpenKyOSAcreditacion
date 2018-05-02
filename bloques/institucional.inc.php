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
?><?php  
/***********************************************************************************************************
  
institucional.inc.php 

Paulo Cesar Coronado
Universidad Distrital Francisco Jose de Caldas
Universidad de los Llanos
Copyright (C) 2001-2006

Última revisión 6 de Marzo de 2006

************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Archivo de inclusion para la gestion del acceso al subsistema institucional:
*		a. Determina el subsistema al cual pertenece el usuario
*		b. Si el subsistema es coordinación determina el programa al cual pertenece el usuario.
* @usage
************************************************************************************************************/
// ?><?php  
//Version 2.0

//Rescatar el ID de usuario de la sesion en curso
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro!=FALSE)
	{
		//Buscar el subsistema
		$id_usuario=$registro[0][0];
		$cadena_sql="SELECT ";
		$cadena_sql.=$configuracion["prefijo"]."usuario_subsistema.id_subsistema, ";
		$cadena_sql.=$configuracion["prefijo"]."usuario_subsistema.id_usuario, ";
		$cadena_sql.=$configuracion["prefijo"]."subsistema.nombre ";
		$cadena_sql.="FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."usuario_subsistema, ";
		$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_usuario=".$id_usuario." ";
		$cadena_sql.="AND ";
		$cadena_sql.="".$configuracion["prefijo"]."subsistema.id_subsistema=".$configuracion["prefijo"]."usuario_subsistema.id_subsistema ";;
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$id_subsistema=$registro[0][0];
			$nombre_subsistema=$registro[0][2];
			unset($registro);
		}
		else
		{
			$id_subsistema=0;
			$nombre_subsistema="";
		}
		
		if($nombre_subsistema=='coordinacion')
		{		
			//Buscar el programa
			$cadena_sql="SELECT ";
			$cadena_sql.="id_programa,id_usuario ";
			$cadena_sql.="FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."usuario_programa ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_usuario=".$id_usuario." ";
			$cadena_sql.="LIMIT 1";
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				$id_programa=$registro[0][0];
				unset($registro);
			}
			else
			{
				$id_programa=0;
			}
		}
		else
		{
			$id_programa=0;		
		}
	}
}

	
?>
