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
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
******************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}


$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{

	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		$el_usuario=$registro[0][0];
	}
	unset($registro);
	//Rescatar el valor de la variable usuario de la sesion
		
	/*$pregunta=$_POST["id_primitiva"];
	En la nueva implementación esto no tiene validez
	*/
	$cadena_sql="SELECT ";
	$cadena_sql.="nombre, ";
	$cadena_sql.="fecha_creacion, ";
	$cadena_sql.="comentario, ";
	$cadena_sql.="id_usuario ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."pregunta_borrador ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_pregunta=".$_REQUEST['id_compuesta']." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_sesion='".$esta_sesion."'";
	
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		
			/*TO DO Enviar correo electrónico al administrador con este error. */
			echo "FALLO GENERAL EN EL PROCESO<br><br>Error cr&iacute;tico:<strong> TTG0027</strong>";
			exit();
		
	}
	
	/* Mensaje de finalización*/
	
	/*$la_cadena=new cadenas;
	$el_nombre=$la_cadena->unhtmlentities($registro[0][0]);
	$date=date('Y/m/d-H:i:s',$registro[0][1]);
	$cadena_html.="<table><tbody>\n";
	$cadena_html.="<tr><td style='font-weight: bold;'>Fecha de creaci&oacute;n:</td><td>".$date."</td></tr>\n";
	$cadena_html.="<tr><td style='font-weight: bold;'>Propietario:</td><td>".$registro[0][3]."</td></tr>\n<br>";
	$cadena_html.="<tr><td style='font-weight: bold;'>Nombre de la pregunta:</td><td>".$el_nombre."</td></tr>\n";
	$cadena_html.="</tbody></table>\n";
	echo $cadena_html;
	$cadena_html="";
	unset($registro);
	*/
	
	echo formulario("confirmar","confirmar",$configuracion);
	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta_borrador.class.php");
	$la_pregunta=new armar_pregunta_borrador();
	echo $la_pregunta->numero_pregunta("Datos B&aacute;sicos");
	echo formulario("datos_basicos",$registro,$configuracion,$el_usuario);	
	
	echo $la_pregunta->numero_pregunta('Pregunta Compuesta');
	echo $la_pregunta->compuesta($configuracion,$_REQUEST['id_compuesta'],"0","0","Analista",$esta_sesion);
	
	
}
function formulario($tipo,$registro=FALSE,$configuracion="",$el_usuario="")
{
	switch($tipo)
	{
		case "confirmar":
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			$pagina="comite_pregunta";
			$variables="&accion=1";
			$variables.="&hoja=0";
			$cadena_html="<form action='index.php' method='post' name='".$registro."' \n>";
			$cadena_html.="<input type='hidden' name='action' value='guardar_compuesta'>\n";
			$cadena_html.="<table  width='50%' align='center'>\n<tbody>";
			$cadena_html.="<tr>\n";
			$cadena_html.="<td style='text-align:center;color:rgb(0, 0, 100);' colspan='2' rowspan='1'>\n ";
			$cadena_html.="&iquest;Desea guardar esta pregunta en el Sistema?";
			$cadena_html.="<br><hr>\n";
			$cadena_html.="</td>\n";
			$cadena_html.="</tr><tr>\n";
			$cadena_html.="<td style='text-align:center'>\n";
			$cadena_html.="<img class='enlace' src='". $configuracion["host"].$configuracion["site"].$configuracion["grafico"]."/boton_aceptar.png' alt='Aceptar' title='Aceptar' border='0' onclick=\"return(1)?document.forms['".$registro."'].submit():false\"/>";
			$cadena_html.="</td>\n";
			$cadena_html.="<td style='text-align:center'>\n";
			//$cadena_html.="<img class='enlace' src='". $configuracion["host"].$configuracion["site"].$configuracion["grafico"]."/boton_cancelar.png' alt='Cancelar' title='Cancelar' border='0' onclick=\"location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variables."')\" />";
			$cadena_html.="</td>\n";
			$cadena_html.="</tr>\n";		
			$cadena_html.="</tbody>\n</table>\n";		
			$cadena_html.="</form>\n";
		break;
		
		case "datos_basicos":
			include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
			$esta_cadena=new cadenas;
			$nombre_p=$esta_cadena->unhtmlentities($registro[0][0]);
			$date=date('Y/m/d-H:i:s',$registro[0][1]);
			$cadena_html="<table class='tabla_elegante'>\n";
			$cadena_html.="<tr class='bloquecentralcuerpo'><td class='celda_elegante' ><span class='texto_negrita'>Fecha de creaci&oacute;n:</span></td><td class='celda_elegante'>".$date."</td></tr>\n";
			$cadena_html.="<tr class='bloquecentralcuerpo'><td class='celda_elegante' ><span class='texto_negrita'>Propietario:</span></td><td class='celda_elegante'>".$el_usuario."</td></tr>\n";
			$cadena_html.="<tr class='bloquecentralcuerpo'><td class='celda_elegante' ><span class='texto_negrita'>Nombre de la pregunta:</span></td><td class='celda_elegante'>".$nombre_p."</td></tr>\n";
			$cadena_html.="</table>\n";
			$cadena_html.="<br>\n";
			break;
		
		
		
			
	}
	return $cadena_html;
}
	







?>
