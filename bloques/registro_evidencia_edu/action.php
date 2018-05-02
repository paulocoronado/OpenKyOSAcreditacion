<?PHP  
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?PHP  
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
?><?PHP  
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	if(isset($_POST['id_evidencia']))
	{
		$cadena_sql="DELETE ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."evidencia_edu ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_evidencia=".$_POST['id_evidencia'];
		$acceso_db->ejecutar_acceso_db($cadena_sql);
		$id_evidencia=$_POST['id_evidencia'];
	}
	else
	{
		$id_evidencia='NULL';
	}
	
	$cadena_sql="INSERT INTO aplicativo_evidencia_edu "; 
	$cadena_sql.="( ";
	$cadena_sql.="`id_evidencia`, ";
	$cadena_sql.="`id_criterio`, ";
	$cadena_sql.="`nombre`, ";
	$cadena_sql.="`descripcion`, ";
	$cadena_sql.="`ponderacion`, ";
	$cadena_sql.="`justificacion` ";
	$cadena_sql.=") ";
	$cadena_sql.="VALUES ";
	$cadena_sql.="( ";
	$cadena_sql.=$id_evidencia.", ";
	$cadena_sql.="'".$_POST['id_criterio']."', ";
	$cadena_sql.="'".$_POST['nombre']."', ";
	$cadena_sql.="'".$_POST['descripcion']."', ";
	$cadena_sql.="'".$_POST['ponderacion']."', ";
	$cadena_sql.="'".$_POST['justificacion']."' ";
	$cadena_sql.=")";
	echo $cadena_sql;
	@$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
	if($resultado==FALSE)
	{
		/*TODO Mensaje de error*/
		echo "El sistema est&aacute; fuera de servicio en estos momentos. Por favor reintentelo dentro de algunos minutos.";
		exit;
	}
	else
	{	
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		$pagina="admin_evidencias_edu";
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."&accion=1&hoja=0&criterio=".$_POST['id_criterio']."')</script>";   
	}

}

		


	
?>
