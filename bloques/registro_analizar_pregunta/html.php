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
  
registro_borrado.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	bloque
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* 
*
* Pagina para eliminar registros del sistema
*
*****************************************************************************************************************/
?><?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");	
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	$cadena_sql="SELECT ";
	$cadena_sql.="tipo,id_usuario,estado,fecha_creacion,comentario ";
	$cadena_sql.="FROM ".$configuracion["prefijo"]."pregunta ";
	$cadena_sql.="WHERE id_pregunta=".$_GET["registro"];
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$pregunta=$acceso_db->obtener_registro_db();
	$total=$acceso_db->obtener_conteo_db();
	if($total>0)
	{
		// Obtener los datos básicos de la pregunta
		$descripcion=$pregunta[0][4];
		$busqueda="SELECT usuario ";
		$busqueda.="FROM ".$configuracion["prefijo"]."registrado ";
		$busqueda.="WHERE id_usuario=".$pregunta[0][1];
		$busqueda.=" LIMIT 1";
		//echo $busqueda;
		$acceso_db->registro_db($busqueda,0);
		$usuario=$acceso_db->obtener_registro_db();
		$total_usuario=$acceso_db->obtener_conteo_db();
		if($total_usuario>0)
		{	
			$propietario=$usuario[0][0];				
		}
		else
		{
			$propietario="Desconocido";
		}
		
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
		if($registro)
		{
			
			$el_usuario=$registro[0][0];
		}
		
		//Para ver si el usuario ha votado la pregunta
		$busqueda="SELECT id_pregunta ";
		$busqueda.="FROM ".$configuracion["prefijo"]."votacion ";
		$busqueda.="WHERE id_usuario=".$el_usuario;
		$busqueda.=" AND id_pregunta=".$_GET["registro"];
		$busqueda.=" LIMIT 1";
		//echo $busqueda;
		$acceso_db->registro_db($busqueda,0);
		$usuario=$acceso_db->obtener_registro_db();
		$total_usuario=$acceso_db->obtener_conteo_db();
		if($total_usuario>0)
		{	
			$votacion=1;				
		}
		else
		{
			$votacion=0;
		}
		
		$cadena_sql="SELECT id_pregunta,fecha,id_usuario,mensaje ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."comentario ";
		$cadena_sql.="WHERE id_pregunta=";
		$cadena_sql.=$_GET["registro"];
		$cadena_sql.=" ORDER BY fecha ASC";
		//echo $cadena_sql;
		$resultado=$acceso_db->registro_db($cadena_sql,0);
		$comentario=$acceso_db->obtener_registro_db();
		$total=$acceso_db->obtener_conteo_db();
		
		$estado=$pregunta[0][2];
		$fecha=date("d-M-Y",$pregunta[0][3]);
		$codigo=$_GET["registro"];
		
		/****Datos Básicos******/
		
		$cadena_html="<table align=\"center\" style=\"width: 100%; text-align: left;\" border=\"0\"";
		$cadena_html.="cellpadding=\"5\"cellspacing=\"0\">\n<tbody>\n";		
		$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
		$cadena_html.="<td class='celdatabla' style=\"width: 50%;\">\n";
		$cadena_html.="Pregunta con c&oacute;digo interno: <b>".$codigo."</b>";
		$cadena_html.="<br>";
		$cadena_html.="Creada por: ";
		$cadena_html.="<b>";
		$cadena_html.=strtoupper($propietario)."</b> ";
		$cadena_html.="el  ".$fecha;
		$cadena_html.="<br>";
		$cadena_html.="La pregunta tiene: <b>".$total."</b> comentarios ";
		if($estado==0)
		{
			$este_estado="NO APROBADA";
		}
		else
		{
			$este_estado="APROBADA";
		}
		$cadena_html.="<br>";
		$cadena_html.="Estado Actual:<strong> ".$este_estado."</strong>";
		$cadena_html.="</td>";
		$cadena_html.="</tr>";
		$cadena_html.="</tbody></table>\n";
		$cadena_html.="<hr size='1' width='80%'>";
		echo $cadena_html;
			
		$esta_pregunta=new armar_pregunta();
		
		/* $cadena_html=$esta_pregunta->numero_pregunta("1"); */
		$cadena_html="";

								
		if($pregunta[0][0]==0)
		{
				/* El código corresponde a una pregunta primitiva ("0")*/
				$cadena_html.=$esta_pregunta->primitiva($configuracion,$codigo,"0","0","0","0");
				
		}
		else
		{
			/* El código corresponde a una pregunta compuesta ("1")*/
			if($pregunta[0][0]==1)
			{
				$cadena_html.=$esta_pregunta->compuesta($configuracion,$codigo,"0","0","0","0");
			}
									
		}
		$cadena_html.="<br>";
		echo $cadena_html;
		//Mostrar la descripcion de la pregunta
		$la_cadena=new cadenas;
		$descripcion=$la_cadena->unhtmlentities($descripcion);
		
		$cadena_html="<table align=\"center\" style=\"width: 100%; text-align: left;\" border=\"0\"";
		$cadena_html.="cellpadding=\"5\"cellspacing=\"0\">\n<tbody>\n";		
		$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
		$cadena_html.="<td class='celdatabla' style=\"width: 50%;\">\n";
		$cadena_html.=$descripcion;
		$cadena_html.="</td>";
		$cadena_html.="</tr>";
		$cadena_html.="</tbody></table>\n";
		$cadena_html.="<hr size='1' width='80%'>";
		echo $cadena_html;
		
		

		/*Formulario para el ingreso de comentarios*/
		
		$cadena_html="<form action='index.php' method=\"POST\">\n";
		$cadena_html.="<table align=\"center\" style=\"width: 100%; text-align: left;\" border=\"0\"";
		$cadena_html.="cellpadding=\"5\"cellspacing=\"1\">\n<tbody>\n";		
		$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
		$cadena_html.="<td class='celdatabla'>\n";
		$cadena_html.="<b>Mi Votaci&oacute;n:</b>";
		$cadena_html.="</td>\n";
		$cadena_html.="<td class='celdatabla'>\n";
		
		if($votacion==0)
		{
			$cadena_html.="Apruebo la validez de la pregunta <input name='aprobar' value='1'  tabindex='1' type='checkbox' ><br>\n";
		}
		else
		{
			$cadena_html.="Apruebo la validez de la pregunta <input name='aprobar' value='1'  tabindex='1' type='checkbox' checked='checked'><br>\n";
		}
		$cadena_html.="</td>\n";
		$cadena_html.="</tr>\n";
		$cadena_html.="</tbody>";
		$cadena_html.="</table>";
		$cadena_html.="<hr size='1' width='80%'>";
		$cadena_html.="<table align=\"center\" style=\"width: 100%; text-align: left;\" border=\"0\"";
		$cadena_html.="cellpadding=\"5\"cellspacing=\"1\">\n<tbody>\n";	
		$cadena_html.="<tr class='mensajealertaencabezado'>\n";
		$cadena_html.="<td>\n";
		$cadena_html.="Comentario/An&aacute;lisis<br>";
		$cadena_html.="</td>\n";
		$cadena_html.="</tr>\n";
		$cadena_html.="<tr align='center'>\n";
		$cadena_html.="<td class='celdatabla'>\n";
		$cadena_html.="<textarea name=\"comentario\" rows=\"10\" cols=\"40\">\n";
		$cadena_html.="</textarea>\n";
		$cadena_html.="</td>\n";
		$cadena_html.="</tr>\n";
		$cadena_html.="<tr>\n";
		$cadena_html.="<td class='celdatabla' align='center'>\n";
		$cadena_html.="<input type='hidden' name='action' value='registro_analizar_pregunta'>\n";
		$cadena_html.="<input type='hidden' name='id_usuario' value='".$pregunta[0][1]."'>\n";
		$cadena_html.="<input type='hidden' name='id_pregunta' value='".$codigo."'>\n";
		$cadena_html.="<input type=\"submit\" name='aceptar' value=\"Aceptar\">\n";
		$cadena_html.="</td>\n";
		$cadena_html.="</tr>\n";
		$cadena_html.="</tbody></table>\n";
		$cadena_html.="</form>\n";
		echo $cadena_html;


		/***Mostrar  comentarios asociados a la pregunta*/
		
		
		
		if($total>0)
		{
			$cadena_html="<br><table width='100%'>\n<tbody>\n";	
			$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_html.="<td>\n";
			$cadena_html.="<b>Otros an&aacute;lisis realizados</b>";
			$cadena_html.="</td>\n";
			$cadena_html.="</tr>\n";
			$cadena_html.="</tbody>\n</table>\n";		
			echo $cadena_html;
					
			for ($i=0;$i<$total;$i++)
			{		
					$cadena_html="<table class='bloquelateral' width='100%' cellpadding='7' cellspacing='0'>\n<tbody>\n";	
					$busqueda="SELECT nombre, apellido ";
					$busqueda.="FROM ".$configuracion["prefijo"]."registrado ";
					$busqueda.="WHERE id_usuario=".$comentario[$i][2];
					$busqueda.=" LIMIT 1";
					//echo $busqueda;
					$acceso_db->registro_db($busqueda,0);
					$usuario=$acceso_db->obtener_registro_db();
					$total_usuario=$acceso_db->obtener_conteo_db();
					if($total_usuario>0)
					{	
						$propietario=$usuario[0][0]." ".$usuario[0][1];				
					}
					else
					{
						$propietario="Desconocido";
					}
					
					/*Cuerpo del mensaje*/
					$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
					$cadena_html.="<td class='celdatabla' colspan='2'>\n";
					$cadena_html.=$comentario[$i][3];
					$cadena_html.="</td>\n";
					$cadena_html.="</tr>\n";
					/*Información  del mensaje*/
					$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
					$cadena_html.="<td class='celdacomentario'>\n";
					$cadena_html.="Mensaje puesto por: <b>".$propietario."</b><br>";
					$cadena_html.="</td>\n";
					$cadena_html.="<td class='celdacomentario'>\n";
					$cadena_html.="El ".date( "d-M-Y",$comentario[$i][1])."<br>";
					$cadena_html.="</td>\n";
					$cadena_html.="</tr>\n";
					$cadena_html.="</tbody>\n</table><br>\n";
					echo $cadena_html;
			}
			
			
		}
		
		
		
		
							
	}
	else
	{
		
		/*TODO Mensaje de error por no haber seleccionado ninguna pregunta*/
		echo "No selecci&oacute;n de pregunta";
	}
			
}
else
{
			/*TODO Mensaje de error para especificar fallo general*/
}
?>
