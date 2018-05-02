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
  
index.php 

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
* @description  Formualrio para el registro de usuarios
* @usage        
*****************************************************************************************************************/ 
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
		
if(!is_string($_POST['nombre']))
{
		echo "Los datos en el formulario no coinciden con lo esperado";
}
else
{

	/*
	Segundo: Se comprueba que el nombre y el código del artefacto sea único
	*/
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
			
		$nueva_sesion=new sesiones($configuracion);
		$esta_sesion=$nueva_sesion->numero_sesion();
		
		if(isset($_POST['id_programa']))
		{
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."programa WHERE id_programa='".$_POST["id_programa"]."'";
		//echo $cadena_sql."<br>";
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			$el_programa=$_POST['id_programa'];
		}
		else
		{
				$el_programa="NULL";
		}	
		/*Esto se realiza para poder mostrar los valores del artefacto antes de guardarlo en la base de datos */
		$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."programa "; 
		$cadena_sql.="( ";
		$cadena_sql.="`id_programa`, ";
		$cadena_sql.="`id_facultad`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`icfes`, ";
		$cadena_sql.="`mision`, ";
		$cadena_sql.="`vision`, ";
		$cadena_sql.="`institucion`, ";
		$cadena_sql.="`norma`, ";
		$cadena_sql.="`duracion`, ";
		$cadena_sql.="`jornada`, ";
		$cadena_sql.="`modalidad`, ";
		$cadena_sql.="`nivel`, ";
		$cadena_sql.="`fecha_registro`, ";
		$cadena_sql.="`titulo`, ";
		$cadena_sql.="`periodicidad`, ";
		$cadena_sql.="`localidad`, ";
		$cadena_sql.="`semanas_semestre`, ";
		$cadena_sql.="`correo`, ";
		$cadena_sql.="`nombre_corto`, ";
		$cadena_sql.="`codigo`, ";
		$cadena_sql.="`director` ";
		$cadena_sql.=") ";
		$cadena_sql.="VALUES ";
		$cadena_sql.="( ";
		$cadena_sql.=$el_programa.", ";
		$cadena_sql.="'0', ";
		$cadena_sql.="'".$_POST['nombre']."', ";
		$cadena_sql.="'".$_POST['icfes']."', ";
		$cadena_sql.="'".$_POST['mision']."', ";
		$cadena_sql.="'".$_POST['vision']."', ";
		$cadena_sql.="'".$_POST['institucion']."', ";
		$cadena_sql.="'".$_POST['norma']."', ";
		$cadena_sql.="'".$_POST['duracion']."', ";
		$cadena_sql.="'".$_POST['jornada']."', ";
		$cadena_sql.="'".$_POST['modalidad']."', ";
		$cadena_sql.="'".$_POST['nivel']."', ";
		$cadena_sql.="'".$_POST['fecha_registro']."', ";
		$cadena_sql.="'".$_POST['titulo']."', ";
		$cadena_sql.="'".$_POST['periodicidad']."', ";
		$cadena_sql.="'".$_POST['localidad']."', ";
		$cadena_sql.="'".$_POST['semanas_semestre']."', ";
		$cadena_sql.="'".$_POST['correo']."', ";
		$cadena_sql.="'".$_POST['nombre_corto']."', ";
		$cadena_sql.="'".$_POST['codigo']."', ";
		$cadena_sql.="'".$_POST['director']."' ";
		$cadena_sql.=")";
		
		//echo $cadena_sql;
		//exit;
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
			$opcion="&accion=1";
			$opcion="&hoja=0";
			$opcion.="&mostrar=1";
			$pagina="admin_programa";
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$opcion."')</script>";   
		}
				
	} 
	else
	{
			
		echo "El sistema est&aacute; fuera de servicio en estos momentos. Por favor reintentelo dentro de algunos minutos.";
			
	}
}

?>
