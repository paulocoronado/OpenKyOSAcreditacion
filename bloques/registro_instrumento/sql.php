<?
/*
############################################################################
#    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2009                                      #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?
/****************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-200

Última revisión 09 de Mayo de 2009

******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.1
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Clausulas sql ha utilizar en el bloque registro_instrumetno
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*******************************************************************************/


function sql_registro_instrumento($tipo)

{
	switch($tipo)
	{
	
		case "buscarPreguntaInstrumento":
			$cadena_sql="SELECT ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta,";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.orden,";
			$cadena_sql.="".$configuracion["prefijo"]."pregunta.tipo ";
			$cadena_sql.="FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta,";
			$cadena_sql.="".$configuracion["prefijo"]."pregunta ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_instrumento=".$instrumento." ";
			$cadena_sql.="AND ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta=".$configuracion["prefijo"]."pregunta.id_pregunta";
			$cadena_sql.=" ORDER BY ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.orden ASC";
			break;

		
		case "borrarPregunta":
			$cadena_html="DELETE ";
			$cadena_html.="FROM ";
			if(!isset($_REQUEST["eval_docente"]))
			{
				$cadena_html.=$configuracion["prefijo"]."resultado ";
			}
			else
			{
				$cadena_html.=$configuracion["prefijo"]."resultado_evaluacion ";
			}	
			$cadena_html.="WHERE ";
			$cadena_html.="encuestado='".$encuestado."' ";
			$cadena_html.="AND ";
			$cadena_html.="id_proceso=".$proceso." ";
			$cadena_html.="AND ";
			$cadena_html.="id_artefacto=".$artefacto." ";
			if(isset($_REQUEST["eval_docente"]))
			{
				$cadena_html.="AND ";
				$cadena_html.="id_eval_actor='".desenlace($_REQUEST["eval_docente"])."' ";
			}
			$cadena_html.="AND ";
			$cadena_html.="id_instrumento=".$instrumento.";;;";
			break;
	
	
	
	}
	
}	
	

?>