<?php
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************

  
pregunta.class.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 22 de octubre de 2007

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*******************************************************************************/


class pregunta
{
	
	function pregunta()
	{
		$this->cadena_html="";
	}


/******************************************************************************
* Métodos para los formularios de ingreso de datos de la pregunta *
******************************************************************************/

/*
El método para asociada y dependiente es el mismo por el momento ya que no se tiene ninuna
acción específica para lkas preguntas dependientes. 
TODO Implementar la funcionalidad esperada de las preguntas dependientes de tal forma que sus
datos solo se procesen si la pregunta de la cual depende cumple con los parámetros especificados.
Tener en cuenta que esto supone una carga extra en el momento de estructurar las preguntas compuestas.

Las preguntas primirtivas NO PUEDEN depender de otras preguntas primitivas. Dicha funcionalidad se
implementa por medio de preguntas compuestas sin preguntas abhstractas asociadas

2 Asociada

**/

	/**
	 *@method formulario_primitiva
	 * @param array berosa
	 * @param int  id_instrumento
	 * @return string cadena_sql
	 * @access public
 	 * @comment El parámetro $tipo se coloca para poder volver "polimórfico"  el método pues se tienen algunas acciones
	 * asociadas a cada tipo.
	 *@PARAM 	array	$configuracion					Datos de configuracion
	 *@PARAM 	int 		$id 					Identificador de la pregunta
	 *@PARAM 	int 		$contador 		Número correspondiente a la pregunta dentro de una pregunta compuesta
	 *@PARAM 	int 		$tipo				Tipo de pregunta (0: primitiva; 2: Asociada; 4:dependiente)
	 * USAGE Este método crea el formulario para el ingreso de los datos correspondientes a la pregunta primitiva, asociada 
	 * o dependiente. Los valores de los campos se identifican por el id_pregunta y la ubicación dentro de la pregunta compuesta
	 * si a lugar
	 */    


function formulario_primitiva($configuracion,$id,$contador,$tipo,$editor,$posicion)
{
	
	$this->editor_propietario=$editor;
	$fecha=time();
	if($contador==(-1))
	{
		$contador="";
	}
	$this->id_pregunta=$id;
	
	
	$this->cadena_html="<table class='tabla_elegante'>\n";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr class='bloquecentral'>\n";
	$this->cadena_html.="<td align='center'>";
	
	$this->cadena_html.="<table class='borderless'>\n";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr class='bloquecentralencabezado'>\n";
	$this->cadena_html.="<td colspan='2' rowspan='1' align='center'>";
	
	if($tipo==0)
	{
		$this->cadena_html.="Pregunta Primitiva\n<br>";
		$this->tipo_pregunta="primitiva";
	}
	else
	{
		if($tipo==2)
		{
			$this->cadena_html.="Pregunta Asociada No ".($contador+1)."\n<br>";
			$this->tipo_pregunta="asociada";
		}
	}	
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Datos Básicos de la pregunta
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='encabezado_normal celda_elegante' colspan='2'>\n";
	$this->cadena_html.="Datos B&aacute;sicos de la pregunta:<hr class='hr_division'>\n";
	//id_pregunta (oculto)
	$this->cadena_html.="<input type='hidden' name='id_".$this->tipo_pregunta.$contador."' value='". $this->id_pregunta."'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	
	//Ubicación de la pregunta cuando hace parte de una pregunta compuesta- cuando es de tipo 1 ó 4
	if($tipo==2)
	{
		$this->posicion=$posicion;	
		$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
		$this->cadena_html.="<td class='celda_elegante texto_negrita'>\n";
		$this->cadena_html.="Ubicaci&oacute;n:<br>\n";
		$this->cadena_html.="</td>\n";
		$this->cadena_html.="<td>\n";
		$this->cadena_html.="<input  maxlength='15' size='5' name='ubicacion_".$this->tipo_pregunta.$contador."' value='".$this->posicion."' >";
		$this->cadena_html.="</td>\n";
		$this->cadena_html.="</tr>\n";
	}
	
	if($tipo!=2)
	{
	
		//Nombre de la pregunta
		$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
		$this->cadena_html.="<td class='celda_elegante texto_negrita'>\n";
		$this->cadena_html.="Nombre de la pregunta:<br>\n";
		$this->cadena_html.="</td>\n";
		$this->cadena_html.="<td>";
		$this->cadena_html.="<input maxlength='80' size='40'  name='nombre_".$this->tipo_pregunta.$contador."'><br>";
		$this->cadena_html.="<b>Nota:</b> Use un nombre que la identifique un&iacute;vocamente dentro del banco de preguntas.<br>";
		$this->cadena_html.="</td>\n";
		$this->cadena_html.="</tr>\n";
	}
	else
	{
		
		$this->cadena_html.="<input type='hidden' name='nombre_".$this->tipo_pregunta.$contador."' value='N/A' >\n";
	
	}
	
	
	//Encabezado
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td colspan='2' class='encabezado_normal celda_elegante'>\n";
	$this->cadena_html.="Encabezado<hr class='hr_division'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td colspan='2' align='center'>\n";
	if($tipo==0)
	{
	$this->cadena_html.="<input type='hidden' name='propietario' value='". $this->editor_propietario."'>\n";
	$this->cadena_html.="<input type='hidden' name='fecha_creacion' value='".$fecha."' >\n";
		
	}
	$this->cadena_html.="<textarea cols='60' id=encabezado_".$this->tipo_pregunta.$contador." rows='2' name='encabezado_".$this->tipo_pregunta.$contador."'></textarea>";
	$this->cadena_html.="<script type='text/javascript'>\n";
	$this->cadena_html.="mis_botones='".$configuracion["host"].$configuracion["site"].$configuracion["grafico"]."/';\n";
	$this->cadena_html.="archivo_css='".$configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/basico/estilo.php"."';\n";
	$this->cadena_html.="editor_html('encabezado_".$this->tipo_pregunta.$contador."', 'bold italic underline | left center right | number bullet |');\n";
	$this->cadena_html.="</script>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Comentario
	if($tipo!=2)
	{
		$this->cadena_html.="<tr class='bloquecentralcuerpo'>";
		$this->cadena_html.="<td>";
		$this->cadena_html.="Descripci&oacute;n o Comentario:<br>\n";
		$this->cadena_html.="</td>\n";
		$this->cadena_html.="<td>";
		$this->cadena_html.="<textarea cols='40' rows='4' name='comentario_".$this->tipo_pregunta.$contador."'></textarea>\n";
		$this->cadena_html.="<br>\n</td>\n";
		$this->cadena_html.="</tr>\n";
		
	}
	else
	{
		$this->cadena_html.="<input type='hidden' name='comentario_".$this->tipo_pregunta.$contador."' value='N/A'>\n";
	}
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n<br>";
	
	
	
	
	//Métricas asociadas a la pregunta
	
	$this->cadena_html.="<table style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>\n";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr>\n";
	$this->cadena_html.="<td colspan='2' class='encabezado_normal celda_elegante'>Tipo de M&eacute;trica<hr class='hr_division'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Selección múltiple
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>\n";
	$this->cadena_html.="Selecci&oacute;n M&uacute;ltiple<br>\n</td>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='1' type='radio'><br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Selección única
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>\n";
	$this->cadena_html.="Selecci&oacute;n &Uacute;nica<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='2' type='radio'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Comentario múltiples campos
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>";
	$this->cadena_html.="Comentario M&uacute;ltiples campos<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='3' type='radio'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//No de opciones del tipo de métrica
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>\n";
	$this->cadena_html.="No de opciones:<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<input maxlength='5' size='5' name='opciones_".$this->tipo_pregunta.$contador."'>";
	$this->cadena_html.="(Solo aplica para tipo selecci&oacute;n)<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Calificación numérica
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>";
	$this->cadena_html.="Calificaci&oacute;n Num&eacute;rica<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='4' type='radio'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Calificación porcentual
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>";
	$this->cadena_html.="Calificaci&oacute;n porcentual<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='5' type='radio'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Dato numérico
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>";
	$this->cadena_html.="Dato num&eacute;rico<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='6' type='radio'>";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	//Comentario de una sola línea
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>\n";
	$this->cadena_html.="Comentario de una sola l&iacute;nea<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='7' type='radio'>";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	
	//Comentario 
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td>\n";
	$this->cadena_html.="Comentario de varias l&iacute;neas<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>";
	$this->cadena_html.="<input name='metrica_".$this->tipo_pregunta.$contador."' value='8' type='radio'>";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
		
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n<br>";
	
	return $this->cadena_html;

}/*Fin de la función asociada*/


	/**
	 * @method formulario_abstracta
	 * @param 	array		berosa
	 * @param 	int  			id_instrumento
	 * @return 		string 		cadena_sql
	 * @access public
 	 * @comment 
	 * @PARAM 	array	$configuracion					Datos de configuracion
	 * @PARAM 	int 		$id 					Identificador de la pregunta
	 */   

function formulario_abstracta($configuracion,$id,$posicion)
{
	
	$this->id_pregunta=$id;
	$this->posicion=$posicion;
	
	$fecha=time();
	$date=date('Y/m/d-H:i:s',$fecha);
	$this->cadena_html="";
	$this->cadena_html.="<table style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>\n";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr class='bloquecentralencabezado'>\n";
	$this->cadena_html.="<td colspan='2' rowspan='1' align='center' >\n";
	$this->cadena_html.="Pregunta Abstracta<br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="<tr class='encabezado_normal'>\n";
	$this->cadena_html.="<td class='celda_elegante' colspan='2'>\n";
	$this->cadena_html.="Datos B&aacute;sicos<hr class='hr_division'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='celda_elegante texto_negrita'>\n";
	$this->cadena_html.="Ubicaci&oacute;n<br>";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celda_elegante texto_negrita'>";
	$this->cadena_html.="<input type='hidden' name='nombre_abstracta' value='N/A'>\n";
	$this->cadena_html.="<input type='hidden' name='comentario_abstracta' value='N/A'>\n";
	$this->cadena_html.="<input type='hidden' name='id_abstracta' value='".$this->id_pregunta."'>";
	$this->cadena_html.="<input maxlength='15' size='5' name='ubicacion_abstracta' value='".$this->posicion."' >\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='encabezado_normal cenlda_elegante' colspan='2'>\n";
	$this->cadena_html.="Encabezado<hr class='hr_division'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='celda_elegante' colspan='2' align='center'>\n";
	$this->cadena_html.="<textarea cols='60' id='encabezado_abstracta' name='encabezado_abstracta'></textarea>";
	$this->cadena_html.="<script type='text/javascript'>\n";
	$this->cadena_html.="mis_botones='".$configuracion["host"].$configuracion["site"].$configuracion["grafico"]."/';\n";
	$this->cadena_html.="archivo_css='".$configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/basico/estilo.php"."';\n";
	$this->cadena_html.="editor_html('encabezado_abstracta', 'bold italic underline | left center right | number bullet |');\n";
	$this->cadena_html.="</script>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
	
	return $this->cadena_html;
}/*Fin de la funcion formulario_abstracta*/


	/**
	 * @method formulario_compuesta
	 * @param 	array		berosa
	 * @param 	int  			id_instrumento
	 * @return 		string 		cadena_sql
	 * @access public
 	 * @comment 
	 * @PARAM 	array	$configuracion					Datos de configuracion
	 * @PARAM 	int 		$id 					Identificador de la pregunta
	 */   



function formulario_compuesta($id_pregunta,$editor)
{

$fecha=time();
$date=date('Y/m/d-H:i:s',$fecha);
$this->id_pregunta=$id_pregunta;
$this->editor_propietario=$editor;
	
$this->cadena_html="";
$this->cadena_html.="<table class='tabla_elegante'>\n";
$this->cadena_html.="<tbody>\n";
$this->cadena_html.="<tr class='bloquecentralencabezado'>\n";
$this->cadena_html.="<td colspan='2' rowspan='1' align='center'>\n";
$this->cadena_html.="Pregunta Compuesta<br>\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="</tr>\n";
$this->cadena_html.="<tr class='encabezado_normal'>\n";
$this->cadena_html.="<td class='celda_elegante' colspan='2'>\n";
$this->cadena_html.="Datos B&aacute;sicos<hr class='hr_division'>\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="</tr>\n";
$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
$this->cadena_html.="<td class='celda_elegante'>\n";
$this->cadena_html.="Nombre:\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="<td>\n";
$this->cadena_html.="<input maxlength='80' size='30' name='nombre_principal' >\n";
$this->cadena_html.="<input type='hidden' name='fecha_creacion' value='".$fecha."'>\n";
$this->cadena_html.="<input type='hidden' name='id_compuesta' value='".$this->id_pregunta."'>\n";
$this->cadena_html.="<input type='hidden' name='propietario' value='".$this->editor_propietario."'>\n";
if(isset($_POST["abstracta"] ))
{
	$this->cadena_html.="<input type='hidden' name= 'abstracta' value='". $_POST["abstracta"]."'>\n";
}

if(is_numeric( $_POST["asociada"] ))
{
	$this->cadena_html.="<input type='hidden' name= 'asociada' value='". $_POST["asociada"]."'>\n";
}
//$this->cadena_html.="<b>Nota:</b> Use un nombre que la identifique un&iacute;vocamente dentro del banco de preguntas.<br>";
$this->cadena_html.="</td>\n";
$this->cadena_html.="</tr>\n";
$this->cadena_html.="<td colspan='2'>\n";
$this->cadena_html.="<br>";
$this->cadena_html.="</td>\n";
$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
$this->cadena_html.="<td class='celda_elegante' valign='top'>\n";
$this->cadena_html.="Descripci&oacute;n:\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="<td>\n";
$this->cadena_html.="<textarea cols='40' rows='4' name='comentario_principal'></textarea>\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="</tr>\n";
$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
$this->cadena_html.="<td colspan='2'>\n";
$this->cadena_html.="<br>";
$this->cadena_html.="</td>\n";
$this->cadena_html.="</tr>\n";
$this->cadena_html.="</tbody>\n";
$this->cadena_html.="</table>\n";





$this->cadena_html.="<table style='width: 100%; text-align: left;' border='0' cellpadding='4' cellspacing='2'>\n";
$this->cadena_html.="<tbody>\n";
$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
$this->cadena_html.="<td class='celdatabla' valign='top' align='left' colspan='6' rowspan='1'>\n";
$this->cadena_html.="La pregunta ser&aacute; usada en:<br>\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="</tr>\n";
$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
$this->cadena_html.="<td class='celdatabla' valign='top' align='left'>\n";
$this->cadena_html.="Encuesta <input name='instrumento' value='1' type='radio'>\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="<td class='celdatabla' valign='top' align='left'>\n";
$this->cadena_html.="Taller <input name='instrumento' value='2' type='radio'>\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="<td class='celdatabla' valign='top' align='left'>\n";
$this->cadena_html.="Entrevista <input name='instrumento' value='3' type='radio'>\n";
$this->cadena_html.="</td>\n";
$this->cadena_html.="</tr>\n";
$this->cadena_html.="</tbody>\n";
$this->cadena_html.="</table>\n";

return $this->cadena_html;
}/*Fin de la función dato_básico */


function header_pregunta($configuracion,$accion)
{
	
	$this->form_action=$accion;
	$this->cadena_html="<script src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/funciones.js' type='text/javascript'";
	$this->cadena_html.="language='javascript'></script>\n";
	
	$this->cadena_html.="<form method='post' action='index.php' name='crear_formulario'";
	$this->cadena_html.=" onsubmit='return(control_vacio(this,'nombre_principal'))'>\n";
	/*Campos obligatorios para poder manejar desde un solo sitio todos los módulos*/
	$this->cadena_html.="<table style='margin-left: auto; margin-right: auto; width:100%; text-align: left;'";
	$this->cadena_html.=" border='0' cellpadding='2' cellspacing='2'>\n";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr>\n";
	$this->cadena_html.="<td>\n";
	$this->cadena_html.="<input type='hidden' name= 'action' value='".$this->form_action."'>\n";
	$this->cadena_html.="<input type='hidden' name= 'guardar' value='1'>\n";
	$this->cadena_html.="<input type='hidden' name= 'registro_compuesta' value='1'>";
	$this->cadena_html.="<input type='hidden' name= 'page' value='comite_pregunta_compuesta'>";
	
	return $this->cadena_html;
	
}



function footer_pregunta()
{
		
	$this->cadena_html="<table style='margin-left: auto; margin-right: auto; width:100%; text-align: left;'";
	$this->cadena_html.=" border='0' cellpadding='2' cellspacing='2' align='center'>";
	$this->cadena_html.="<tbody>";
	$this->cadena_html.="<tr align='center'>\n";
	$this->cadena_html.="<td colspan='2' rowspan='1' valign='undefined'>\n";
	$this->cadena_html.="<input name='aceptar' value='Aceptar' type='submit'><br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
	$this->cadena_html.="</form>\n";
	
	return $this->cadena_html;
}



function identificador($configuracion)
{
	
	
	/* Rescatar el id_pregunta desde la base de datos. Usando la función max*/
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace)){
		
		$identificador["pregunta"]=time();
		//Rescatar la variable de sesion correspondiente al usuario actualmente registrado.	
		$this->sesion=new sesiones($configuracion);
		$this->sesion->especificar_enlace($this->enlace);
		$propietario=$this->sesion->rescatar_valor_sesion($configuracion,"id_usuario");
		$nombre=$this->sesion->rescatar_valor_sesion($configuracion,"usuario");
		$identificador["editor"]=$propietario[0][0]; 
		$identificador["nombre_editor"]=$propietario[0][0]; 
	}
	

	return $identificador;


}



function numero_pregunta()
{

$this->cadena_pregunta="<table style='width: 100%; text-align: left;' border='0' cellpadding='2' cellspacing='2'>";
$this->cadena_pregunta.="<tbody>\n<tr class='bloquecentralcuerpo'>\n<td style='color: rgb(0, 0, 102); font-family:";
$this->cadena_pregunta.="Helvetica,Arial,sans-serif;'><hr>Pregunta<hr></td>\n</tr>\n</tbody>\n</table>\n";

return $this->cadena_pregunta;

}

function formulario_metrica_numerico($tipo,$contador,$metrica,$configuracion,$mensaje)
{
	$this->contador=$contador;
	$this->metrica=$metrica;
	$this->contador=$contador;
	$this->pregunta=$this->contador;
	
	$this->cadena_html="<input type='hidden' name= 'id_".$tipo.$this->contador."' value='".$this->pregunta."'>\n";
	$this->cadena_html.="<input type='hidden' name= 'metrica_".$tipo.$this->contador."' value='".$this->metrica."'>\n";
	
	$formulario="crear_formulario";
	
	$verificar="1";
	$verificar.="&&verificar_numero_lleno(".$formulario.",'inferior')";
	$verificar.="&&verificar_numero_lleno(".$formulario.",'superior')";
	
	
	//$this->cadena_html="<script src='".$configuracion['host'].$configuracion['site'].$configuracion['javascript']."/funciones.js' type='text/javascript' language='javascript'></script>\n";
	//$this->cadena_html.="<form method='post' action='index.php' name='".$formulario."' onsubmit=''>\n";
	$this->cadena_html.="<table style='width: 100%; text-align: left;' border='0' cellpadding='2' cellspacing='2'>\n";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='encabezado'>\n";
	$this->cadena_html.="<hr>Pregunta ".$tipo." No ".($this->contador+1)."<hr></td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
	$this->cadena_html.="<table class='bloquelateral' width='100%' align='center' cellpadding='5' cellspacing='2' >\n";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<span class='texto_negrita'>".$this->ayuda_metrica('inferior') ."</span>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<input type='text' maxlength='5' size='5' name='inferior_".$tipo.$this->pregunta."' value=''>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<span class='texto_negrita'>".$this->ayuda_metrica('superior') ."</span>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<input type='text' maxlength='5' size='5' name='superior_".$tipo.$this->pregunta."' value=''>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="".$this->ayuda_metrica('entero') ."\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'>\n";
	$this->cadena_html.="<input type='checkbox' name='entero_".$tipo.$this->pregunta."' checked />\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
	$this->cadena_html.="<br>\n";
	//$this->cadena_html.="<table style='margin-left: auto; margin-right: auto; width:100%; text-align: left;'';\n";
	//$this->cadena_html.="border='0' cellpadding='2' cellspacing='2' align='center'>\n";
	//$this->cadena_html.="<tbody>\n";
	//$this->cadena_html.="<tr align='center'>\n";
	//$this->cadena_html.="<td colspan='2' rowspan='1'>\n";
	//$this->cadena_html.="<img  class='enlace' src='".$configuracion['host'].$configuracion['site'].$configuracion['grafico']."/boton_aceptar.png' alt='Aceptar' title='Aceptar' border='0' onclick='return(".$verificar; .")?document.forms['".$formulario."'].submit():false'/>\n";
	//$this->cadena_html.="<br>\n";
	//$this->cadena_html.="</td>\n";
	//$this->cadena_html.="</tr>\n";
	//$this->cadena_html.="</tbody>\n";
	//$this->cadena_html.="</table>\n";
	//$this->cadena_html.="</form>\n";
	return $this->cadena_html;
}

function ayuda_metrica($tipo)
{
	
	
	switch($tipo)
	{
	
		case "entero":
			
			$etiqueta="Solo valores enteros:";
			$texto_ayuda="Seleccione si la respuesta solo acepta valores enteros.";
			break;
		case "superior":
			$etiqueta="L&iacute;mite Superior:";
			$texto_ayuda="Mayor valor que se puede ingresar. Deje en blanco si no existe l&iacute;mite.";
			break;
		case "inferior":
			$etiqueta="L&iacute;mite Inferior:";
			$texto_ayuda="Menor valor que se puede ingresar. Deje en blanco si no existe l&iacute;mite (Permitir&aacute; valores negativos).";
			break;
		default:
			$etiqueta="";
			$texto_ayuda="";
			
			
	}
	$cadena_html="<span onmouseover=\"";
	$cadena_html.="this.T_WIDTH=200;";
	$cadena_html.="return escape('";
	$cadena_html.=$texto_ayuda;
	$cadena_html.="')\">";
	$cadena_html.=$etiqueta;
	$cadena_html.="</span>";
	
	return $cadena_html;

}

function mostrar_opciones($tipo,$contador,$metrica,$configuracion,$opciones)
{

	$this->metrica=$metrica;
	$this->contador=$contador;
	$this->pregunta=$this->contador;
	$this->opciones=$opciones;
	
	if(!is_numeric($this->opciones))
	{
		$this->opciones=2;
	}
	else
	{
		if($this->opciones<1)
		{
				$this->opciones=2;
		}
		
	}//Fin del if que determina si se lleno el campo de opciones
	
	/* Campos ocultos con los valores de las preguntas para poder ser procesadas*/
	$this->cadena_html="<input type='hidden' name= 'id_".$tipo.$this->contador."' value='".$this->pregunta."'>\n";
	$this->cadena_html.="<input type='hidden' name= 'opciones_".$tipo.$this->contador."' value='".$this->opciones."'>\n";
	$this->cadena_html.="<input type='hidden' name= 'metrica_".$tipo.$this->contador."' value='".$this->metrica."'>\n";
	
	/* Encabezado para separar las preguntas */
	
	$this->cadena_html.="<table class='bloquecentralcuerpo'>";
	$this->cadena_html.="<tbody>\n";
	$this->cadena_html.="<tr>\n";
	$this->cadena_html.="<td class='encabezado'>\n";
	$this->cadena_html.="<hr>Pregunta ".$tipo." No ".($this->contador+1)."<hr></td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
	
	/*Encabezado para la tabla de opciones*/
	
	$this->cadena_html.="<table class='bloquelateral' width='100%' align='center' cellpadding='5' cellspacing='2' ><tbody>\n";
	$this->cadena_html.="<tr class='bloquecentralencabezado' align='center'>";
	$this->cadena_html.="<td>Opci&oacute;n</td>";
	$this->cadena_html.="<td>Etiqueta</td>";
	$this->cadena_html.="<td>";
	if($this->metrica==3)
	{
		$this->cadena_html.="Tama&ntilde;o del Campo";
	}
	else
	{
		$this->cadena_html.="Valor";
		}
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td>Orden</td>\n";
	$this->cadena_html.="</tr>\n";
	
	
	
	/* Formulario para el ingreso de opciones*/
	
	
	
	for($this->opcion=0;$this->opcion<$this->opciones;$this->opcion++)
	{
	
	$this->cadena_html.="<tr class='bloquecentralcuerpo'>\n";
	$this->cadena_html.="<td class='celdatabla'><span style='font-weight: bold;'>". ($this->opcion+1).":</span><br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'><input name='etiqueta_".$tipo.$this->pregunta.$this->opcion."'></td>\n";
	$this->cadena_html.="<td class='celdatabla'><input maxlength='10' size='5' name='valor_".$tipo.$this->pregunta.$this->opcion."'";
	if($this->metrica==3)
	{
		$this->cadena_html.= " value='30'>\n";
	}
	else
	{
		$this->cadena_html.= " value='".($this->opcion+1)."'>\n";
		}
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="<td class='celdatabla'><input maxlength='5' size='5' name='orden_".$tipo.$this->pregunta.$this->opcion."'";
	$this->cadena_html.= " value='".($this->opcion+1)."'>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	
	}
	$this->cadena_html.="</tbody>\n</table>\n<br>";
	
	return $this->cadena_html;

}/*Fin de la función*/				


function header_opciones($configuracion,$accion,$pregunta)
{
	$this->form_action=$accion;
	$this->cadena_html="<script src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/funciones.js' type='text/javascript'";
	$this->cadena_html.="language='javascript'></script>\n";
	$this->cadena_html.="<form method='post' action='index.php' name='crear_formulario'";
	$this->cadena_html.=" onsubmit='return(control_vacio(this,'nombre_principal'))'>\n";
	/*Campos obligatorios para poder manejar desde un solo sitio todos los módulos*/
	$this->cadena_html.="<input type='hidden' name= 'action' value='".$this->form_action."'>\n";
	$this->cadena_html.="<input type='hidden' name= 'id_compuesta' value='".$pregunta."'>\n";
	
	return $this->cadena_html;
	
}



function footer_opciones()
{
	
	$this->cadena_html="<table style='margin-left: auto; margin-right: auto; width:100%; text-align: left;'";
	$this->cadena_html.=" border='0' cellpadding='2' cellspacing='2' align='center'>";
	$this->cadena_html.="<tbody>";
	$this->cadena_html.="<tr align='center'>\n";
	$this->cadena_html.="<td colspan='2' rowspan='1'>\n";
	$this->cadena_html.="<input name='aceptar' value='Aceptar' type='submit'><br>\n";
	$this->cadena_html.="</td>\n";
	$this->cadena_html.="</tr>\n";
	$this->cadena_html.="</tbody>\n";
	$this->cadena_html.="</table>\n";
	
	$this->cadena_html.="</form>\n";
	
	return $this->cadena_html;
}	

}
?>
