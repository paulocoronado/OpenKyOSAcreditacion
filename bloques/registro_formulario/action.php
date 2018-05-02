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
?><?PHP  
if(!key_exists('id_formulario',$_POST)||!key_exists('fecha_creacion',$_POST)||!key_exists('nombre',$_POST)||!key_exists('editor_propietario',$_POST))
{
			$raiz="./../../../";
			include_once($raiz."incluir/error_ilegal.php");	
		
}
else
{
		
	if(!is_numeric($_POST['id_formulario'])||!is_numeric($_POST['fecha_creacion'])||!is_string($_POST['nombre']))
	{
				"Los datos en el formulario no coinciden con lo esperado";
				
	}
	else
	{
	
		/**
		Segundo: Se comprueba que el nombre y el código del formulario sea único
		
		**/
		
		$acceso_db=new dbms($configuracion);
		$enlace=$acceso_db->conectar_db();
		if (is_resource($enlace))
		{
				
			$nueva_sesion=new sesiones($configuracion);
			$esta_sesion=$nueva_sesion->numero_sesion();
			
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."i_borrador WHERE id_sesion='".$esta_sesion."'";
			//echo $cadena_sql."<br>";
			@$acceso_db->ejecutar_acceso_db($cadena_sql);
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."p_borrador WHERE id_sesion='".$esta_sesion."'";
			//echo $cadena_sql."<br>";
			@$acceso_db->ejecutar_acceso_db($cadena_sql);
			/*Esto se realiza para poder mostrar los valores del formulario antes de guardarlo en la base de datos */
			$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."i_borrador ";
			$cadena_sql.="(";
			$cadena_sql.=" id_instrumento, ";
			$cadena_sql.=" fecha_creacion, ";
			$cadena_sql.="id_usuario, ";
			$cadena_sql.="nombre,";
			$cadena_sql.="entidad_responsable, ";
			$cadena_sql.="presentacion,";
			$cadena_sql.="comentario,";
			$cadena_sql.="archivo_base,";
			$cadena_sql.="id_sesion, ";
			$cadena_sql.="etiqueta";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES ('1', ";
			$cadena_sql.="'".$_POST['fecha_creacion']."', ";
			$cadena_sql.=$_POST['editor_propietario'].",";
			$cadena_sql.="'".$_POST['nombre']."',";
			$cadena_sql.="'".$_POST['entidad_responsable']."',";
			$cadena_sql.="'',";
			$cadena_sql.="'".$_POST['presentacion']."',";
			$cadena_sql.="'".$_POST['comentario']."',";
			$cadena_sql.="'".$esta_sesion."',";
			$cadena_sql.="'".$_POST['etiqueta']."'";
			$cadena_sql.=")";
		
			/*Se crea un registro en una tabla temporal denominada ".$configuracion["prefijo"]."i_borrador la	cual contiene todos los 
			campos de ".$configuracion["prefijo"]."formulario más un campo correspondiente a la sesión en curso.
			*/
				
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
				$pagina="registro_formulario_pregunta";
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
