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
  
html.php 

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
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?>
<?php  
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	if(isset($_POST["aceptar"]))
	{
		/*Insertar los campos correspondientes de las tablas de borrador en las tablas definitivas*/
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
		unset($nueva_sesion);
		
		$cadena_sql="SELECT max(id_proceso) FROM ".$configuracion["prefijo"]."proceso";
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos==0)
		{
			$este_instrumento=1;
			
		}
		else
		{
			$este_instrumento=($registro[0][0]/1)+1;		
		}
		
		$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."proceso ";
		$cadena_sql.="(";
		$cadena_sql.="id_proceso,"; 
		$cadena_sql.="fecha_creacion, ";
		$cadena_sql.="id_usuario,";
		$cadena_sql.="nombre, ";
		$cadena_sql.="responsable, ";
		$cadena_sql.="presentacion, ";
		$cadena_sql.="descripcion, ";
		$cadena_sql.="archivo";
		$cadena_sql.=") ";
		$cadena_sql.="SELECT ".$este_instrumento.",";
		$cadena_sql.="fecha_creacion,";
		$cadena_sql.="id_usuario,";
		$cadena_sql.="nombre,";
		$cadena_sql.="responsable,";
		$cadena_sql.="presentacion,";
		$cadena_sql.="descripcion,";
		$cadena_sql.="archivo ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."proceso_borrador ";
		$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";	
		echo $cadena_sql."<br>";	
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		$cadena_sql_1="INSERT INTO ".$configuracion["prefijo"]."p_artefacto";
		$cadena_sql_1.="(";
		$cadena_sql_1.="id_proceso,";
		$cadena_sql_1.="id_artefacto";
		$cadena_sql_1.=") ";
		$cadena_sql_1.="SELECT ".$este_instrumento.",";
		$cadena_sql_1.="id_elemento ";
		$cadena_sql_1.="FROM ".$configuracion["prefijo"]."p_borrador ";
		$cadena_sql_1.="WHERE id_sesion='".$esta_sesion."' ";
		
		echo $cadena_sql_1."<br>";
		$resultado&=$acceso_db->ejecutar_acceso_db($cadena_sql_1);
		
		if($resultado==TRUE)
		{
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."p_borrador ";
			$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."proceso_borrador ";
			$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
			reset($_POST);
			while(list($clave,$valor)=each($_POST))
			{
				unset($_POST[$clave]);
				
			}
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('comite_proceso')."&accion=1&hoja=0')</script>"; 
		}
		else
		{	$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."proceso ";
			$cadena_sql.="WHERE id_proceso=".$este_instrumento;
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."p_artefacto ";
			$cadena_sql.="WHERE id_proceso=".$este_instrumento;
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
			echo "El sistema ha quedado temporalmente fuera de servicio por favor int&eacute;nte la acci&oacute;n en otro momento";
		
		}	
			
	}
	else
	{
		$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."p_borrador ";
		$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
		$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."proceso_borrador ";
		$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
		reset($_POST);
		while(list($clave,$valor)=each($_POST))
		{
			unset($_POST[$clave]);
			
		}
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('comite_proceso')."&accion=1&hoja=0')</script>"; 
	}
}	
?>
