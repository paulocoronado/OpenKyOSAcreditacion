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
  
registro_analizar_pregunta.action.php 

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
?><?php  
if(!isset($_POST['comentario']))
{

			echo "Error Fatal en la aplicaci&oacute;n. Por favor informe el fallo al administrador";	
	
}
else
{
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");	
	
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{		
		
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
		if($registro)
		{
			
			$el_usuario=$registro[0][0];
		}
		
		$cadena_sql="DELETE ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."votacion ";
		$cadena_sql.="WHERE id_usuario=".$el_usuario;
		$cadena_sql.=" AND id_pregunta=".$_POST["id_pregunta"];
		//echo $cadena_sql;
		//exit;
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		if(isset($_POST['aprobar']))
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."votacion ";
			$cadena_sql .= " (id_pregunta , id_usuario) ";
			$cadena_sql .= " VALUES (";
			$cadena_sql .= $_POST['id_pregunta'].",";
			$cadena_sql .= $el_usuario;
			$cadena_sql .= ")";
			//echo $cadena_sql;
			//exit;
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
		
		}
		
		//Calcular el estado de la pregunta
		
		$cadena_sql = "SELECT id_pregunta";
		$cadena_sql.= " FROM ".$configuracion["prefijo"]."votacion";
		$cadena_sql.= " WHERE id_pregunta=".$_POST["id_pregunta"];
		$resultado=$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$total_votos=$acceso_db->obtener_conteo_db();
		
		$cadena_sql = "SELECT id_usuario";
		$cadena_sql.= " FROM ".$configuracion["prefijo"]."registrado";
		$cadena_sql.= " WHERE tipo=2";
		$cadena_sql.= " AND estado=1";
		$resultado=$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$total_votantes=$acceso_db->obtener_conteo_db();
		
		if($total_votos>($total_votantes/2))
		{
			$cadena_sql="UPDATE `".$configuracion["prefijo"]."pregunta` ";
			$cadena_sql.="SET `estado` = '1' ";
			$cadena_sql.="WHERE `id_pregunta` = ".$_POST["id_pregunta"];
			$cadena_sql.=" LIMIT 1 ";
		
		}
		else
		{
			$cadena_sql="UPDATE `".$configuracion["prefijo"]."pregunta` ";
			$cadena_sql.="SET `estado` = '0' ";
			$cadena_sql.="WHERE `id_pregunta` = ".$_POST["id_pregunta"];
			$cadena_sql.=" LIMIT 1 ";
		
		
		}
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
		
		
		//Tercero: Se guarda el registro en la base de datos
		if(trim($_POST['comentario'])!="")
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."comentario ";
			$cadena_sql .= " (id_pregunta , id_usuario, fecha,mensaje) ";
			$cadena_sql .= " VALUES (";
			$cadena_sql .= $_POST['id_pregunta'].",";
			$cadena_sql .= $el_usuario.",";
			$cadena_sql .=time().",";
			$cadena_sql .= "'".$_POST['comentario']."'";
			$cadena_sql .= ")";
			//echo $cadena_sql;
			//exit;
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
		}
		if($resultado==TRUE)
		{
		
			reset($_POST);
			while(list($clave,$valor)=each($_POST))
			{
				unset($_POST[$clave]);
				
			}
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('comite_pregunta')."&accion=1&hoja=0')</script>"; 
		//$la_pagina=new pagina($pagina,$configuracion);

		}
		else
		{
			//Instanciar a la clase pagina con mensaje de error
		}
						
		
	} 
	else
	{
		echo "Error fatal al acceder a la base de datos.";
			
	}
		
	
}			
?>
