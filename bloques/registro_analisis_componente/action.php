<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
****************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if(is_array($registro))
	{
		
		$el_usuario=$registro[0][0];
	}
	$cadena_sql="DELETE FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."analisis_componente ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_usuario=".$_POST["id_usuario"]." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_proceso=".$_POST["id_proceso"]." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_componente='".$_POST["id_componente"]."'";
	$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
	
	$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."analisis_componente "; 
	$cadena_sql.="( ";
	$cadena_sql.="`id_proceso`, ";
	$cadena_sql.="`id_usuario`, ";
	$cadena_sql.="`id_componente`, ";
	$cadena_sql.="`ponderacion`, ";
	$cadena_sql.="`cuantitativa`, ";
	$cadena_sql.="`cualitativa`, ";
	$cadena_sql.="`diagnostico`, ";
	$cadena_sql.="`juicio`, ";
	$cadena_sql.="`fortaleza`, ";
	$cadena_sql.="`debilidad`, ";
	$cadena_sql.="`amenaza`, ";
	$cadena_sql.="`oportunidad`, ";
	$cadena_sql.="`mejoramiento`, ";
	$cadena_sql.="`accion`, ";
	$cadena_sql.="`observacion` ";
	$cadena_sql.=") ";
	$cadena_sql.="VALUES ";
	$cadena_sql.="( ";
	$cadena_sql.="'".$_POST['id_proceso']."', ";
	$cadena_sql.="'".$_POST['id_usuario']."', ";
	$cadena_sql.="'".$_POST['id_componente']."', ";
	$cadena_sql.="'".$_POST['ponderacion']."', ";
	$cadena_sql.="'".$_POST['cuantitativa']."', ";
	$cadena_sql.="'".$_POST['cualitativa']."', ";
	$cadena_sql.="'".$_POST['diagnostico']."', ";
	$cadena_sql.="'".$_POST['juicio']."', ";
	$cadena_sql.="'".$_POST['fortaleza']."', ";
	$cadena_sql.="'".$_POST['debilidad']."', ";
	$cadena_sql.="'".$_POST['amenaza']."', ";
	$cadena_sql.="'".$_POST['oportunidad']."', ";
	$cadena_sql.="'".$_POST['mejoramiento']."', ";
	$cadena_sql.="'".$_POST['accion']."', ";
	$cadena_sql.="'".$_POST['observacion']."' ";
	$cadena_sql.=")";
	
	$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
	
			
	if($resultado==TRUE)
	{
		$variable="&id_usuario=".$_POST["id_usuario"];
		$variable.="&id_proceso=".$_POST["id_proceso"];
		$variable.="&id_componente=".$_POST["id_componente"];
		$variable.="&mostrar=1";
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('tabla_analisis').$variable."')</script>";   
		
		
	
	}
	
	
}	


?>
