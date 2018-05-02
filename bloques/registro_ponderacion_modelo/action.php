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
if(!key_exists('id_proceso',$_POST)||!key_exists('fecha_creacion',$_POST)||!key_exists('nombre',$_POST))
{
			echo "Error grave en los datos del formulario.";
		
}
else
{
		
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
			
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."proceso_borrador WHERE id_sesion='".$esta_sesion."'";
			echo $cadena_sql."<br>";
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."p_borrador WHERE id_sesion='".$esta_sesion."'";
			//echo $cadena_sql."<br>";
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			/*Esto se realiza para poder mostrar los valores del artefacto antes de guardarlo en la base de datos */
			$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."proceso_borrador ";
			$cadena_sql.="(";
			$cadena_sql.="id_proceso, ";
			$cadena_sql.="fecha_creacion,";
			$cadena_sql.="id_usuario,";
			$cadena_sql.="nombre,";
			$cadena_sql.="responsable,";
			$cadena_sql.="presentacion,";
			$cadena_sql.="descripcion,";
			$cadena_sql.="archivo,";
			$cadena_sql.="id_sesion";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES (";
			$cadena_sql.="'1',";
			$cadena_sql.=" '".$_POST['fecha_creacion']."', ";
			$cadena_sql.=$_POST['id_usuario'].",";
			$cadena_sql.="'".$_POST['nombre']."',";
			$cadena_sql.="'".$_POST['responsable']."',";
			$cadena_sql.="'".$_POST['presentacion']."',";
			$cadena_sql.="'".$_POST['descripcion']."',";
			$cadena_sql.="'',";
			$cadena_sql.="'".$esta_sesion."'";
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
				$pagina="registro_proceso_artefacto";
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."&accion=1&hoja=0')</script>";   
			}
					
		} 
		else
		{
				
			echo "El sistema est&aacute; fuera de servicio en estos momentos. Por favor reintentelo dentro de algunos minutos.";
				
		}
	}
}
?>
