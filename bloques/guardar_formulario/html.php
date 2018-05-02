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
?><?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta.class.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		$el_usuario=$registro[0][0];
	}

/*Armar el instrumento*/
	
/*Como es una previsualización se muestran los datos básicos del formulario*/	
	$cadena_html="<form action='index.php' method='post' \n>";
	$cadena_html.="<input type='hidden' name='action' value='guardar_formulario'>\n";
	$cadena_html.="<table  width='50%' align='center'>\n<tbody>\n<tr>\n";
	/*Solo se pasa al procesamiento general del formulario si se hace click en el botón aceptar*/
	$cadena_html.="<tr>\n";
	$cadena_html.="<td style='text-align:center;color:rgb(0, 0, 100);' colspan='2' rowspan='1'>\n ";
	$cadena_html.="&iquest;Desea guardar este instrumento en el Sistema?";
	$cadena_html.="<br><hr>\n";
	$cadena_html.="</td>\n";
	$cadena_html.="</tr>\n";
	$cadena_html.="<td style='text-align:center'><input type='submit' name='aceptar'";
	$cadena_html.=" value='&nbsp;&nbsp;Si&nbsp;&nbsp;' title='Guarda el instrumento'></td>\n";
	$cadena_html.="<td style='text-align:center'><input type='submit' name='cancelar'";
	$cadena_html.=" value='&nbsp;&nbsp;No&nbsp;&nbsp;' title='Cancela la creaci&oacute;n'></td>\n";
	$cadena_html.="</tr>\n";
	$cadena_html.="</tbody>\n</table>\n";		
	$cadena_html.="</form>\n";
	echo $cadena_html;
		
	$cadena_sql="SELECT id_instrumento, fecha_creacion, id_usuario, nombre, entidad_responsable,";
	$cadena_sql.="presentacion, comentario FROM ".$configuracion["prefijo"]."i_borrador WHERE id_instrumento=1 AND ";
	$cadena_sql.="id_sesion='".$esta_sesion."' LIMIT 1";
	/*echo $cadena_sql;*/
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro_instrumento=$acceso_db->obtener_registro_db();
	$conteo_encabezado=$acceso_db->obtener_conteo_db();
	if($conteo_encabezado>0)
	{
			$cadena_pregunta="<table style='width: 50%; text-align: left;' border='0' cellpadding='2'";
			$cadena_pregunta.="cellspacing='5' class='bloquecentralcuerpo'>\n<tbody>";
			$cadena_pregunta.="<tr>\n";
			$cadena_pregunta.="<td style='font-weight:bold;'>\n";
			$cadena_pregunta.="Editor Propietario: ";
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="<td>\n";
			$cadena_pregunta.=$el_usuario;
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="</tr>\n";
			$cadena_pregunta.="<tr>\n";
			$cadena_pregunta.="<td style='font-weight:bold;'>";
			$cadena_pregunta.="Fecha Creación: ";
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="<td>\n";
			$cadena_pregunta.=date("d-m-Y h:i.s",$registro_instrumento[0][1]);
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="</tr>\n";
			$cadena_pregunta.="</tbody>\n";
			$cadena_pregunta.="</table>\n";
			$cadena_pregunta.="<table align='center' style='width: 100%; text-align: justify;' border='0' cellpadding='2'";
			$cadena_pregunta.="cellspacing='5'>\n<tbody>";
			$cadena_pregunta.="<tr>\n";
			$cadena_pregunta.="<td>\n";
			$cadena_pregunta.= nl2br ($registro_instrumento[0][5]);
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="</tr>\n";
			$cadena_pregunta.="</tbody>\n";
			$cadena_pregunta.="</table>\n";
			
			/*Para liberar algo de memoria se visualiza la cadena que se ha estructurado y se inicializa a vacio*/
			echo $cadena_pregunta;
			$cadena_pregunta="";
			
			/*Determinar las preguntas que componen el instrumento*/
			$cadena_sql="SELECT ".$configuracion["prefijo"]."p_borrador.id_sesion, ".$configuracion["prefijo"]."p_borrador.id_elemento,".$configuracion["prefijo"]."p_borrador.orden,";
			$cadena_sql.="".$configuracion["prefijo"]."pregunta.tipo FROM ".$configuracion["prefijo"]."p_borrador,".$configuracion["prefijo"]."pregunta WHERE ";
			$cadena_sql.="".$configuracion["prefijo"]."p_borrador.id_sesion='";
			$cadena_sql.=$esta_sesion."' AND ".$configuracion["prefijo"]."p_borrador.id_elemento=".$configuracion["prefijo"]."pregunta.id_pregunta";
			$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."p_borrador.orden ASC";
			/*echo $cadena_sql;*/
			$acceso_db->registro_db($cadena_sql,0);
			$registro_instrumento=$acceso_db->obtener_registro_db();
			$conteo_encabezado=$acceso_db->obtener_conteo_db();
			/*echo $conteo_encabezado."<br>";*/
			
			if($conteo_encabezado>0)
			{	
					/*Mostrar las preguntas creando una instancia de la clase armar_pregunta*/
					$esta_pregunta=new armar_pregunta();
					
					for($contador=0;$contador<$conteo_encabezado;$contador++)
					{
						
						$cadena_html=$esta_pregunta->numero_pregunta(($contador+1),$configuracion);
						
						if($registro_instrumento[$contador][3]==0)
						{
							/* El código corresponde a una pregunta primitiva ("0")*/
							$cadena_html.=$esta_pregunta->primitiva($configuracion,$registro_instrumento[$contador][1],"0","0","0","0");
							
						}
						else
						{
							
							/* El código corresponde a una pregunta compuesta ("1")*/
							if($registro_instrumento[$contador][3]==1)
							{
					$cadena_html.=$esta_pregunta->compuesta($configuracion,$registro_instrumento[$contador][1],"0","0","0","0");
							}
							
						}

						echo $cadena_html;
						$esta_pregunta->armar_pregunta();

					
					}
				}
}
}





?>
