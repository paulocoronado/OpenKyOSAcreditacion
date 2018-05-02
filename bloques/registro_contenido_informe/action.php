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
/****************************************************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************************************************/
?><?php  

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
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
	$cadena_sql="DELETE FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."final_proceso ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_usuario=".$id_usuario." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_proceso=".$_POST["id_proceso"]." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_seccion=".$_POST["id_seccion"]." ";
	$cadena_sql.="AND ";
	$cadena_sql.="nivel=".$_POST["nivel"]." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_padre=".$_POST["id_padre"]." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_final=".$_POST["id_final"]." ";
	$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
	
	
	$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."final_proceso "; 
	$cadena_sql.="( ";
	$cadena_sql.="`id_final`, ";
	$cadena_sql.="`id_seccion`, ";
	$cadena_sql.="`nivel`, ";
	$cadena_sql.="`id_padre`, ";
	$cadena_sql.="`id_proceso`, ";
	$cadena_sql.="`descripcion`, ";
	$cadena_sql.="`documento`, ";
	$cadena_sql.="`observacion`, ";
	$cadena_sql.="`id_usuario` ";
	$cadena_sql.=") ";
	$cadena_sql.="VALUES ";
	$cadena_sql.="( ";
	$cadena_sql.="'".$_POST['id_final']."', ";
	$cadena_sql.="'".$_POST['id_seccion']."', ";
	$cadena_sql.="'".$_POST['nivel']."', ";
	$cadena_sql.="'".$_POST['id_padre']."', ";
	$cadena_sql.="'".$_POST['id_proceso']."', ";
	$cadena_sql.="'".$_POST['descripcion']."', ";
	$cadena_sql.="'".$_POST['documento']."', ";
	$cadena_sql.="'".$_POST['observacion']."', ";
	$cadena_sql.="'".$id_usuario."' ";
	$cadena_sql.=")";
	echo $cadena_sql."<br>";
	//exit;
	$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
	
			
	if($resultado==TRUE)
	{
		$variable="";
	
		//Envia todos los datos que vienen con GET
		
		unset($_POST["action"]);
		reset ($_POST);
		while (list ($clave, $val) = each ($_POST)) 
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;			
		}
		$variable.="&mostrar=1";
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('contenido_informe').$variable."')</script>";   
		
		
	
	}
	
	
}	


?>
