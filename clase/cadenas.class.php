<?php
/************************************************************************************
cadenas.class.php 
UNIVERSIDAD DISTRITAL Francisco José de Caldas
Comité Institucional de Acreditación
 
TTG de Colombia
Paulo Cesar Coronado
Copyright (C) 2001-2004 


Este programa es software libre; usted lo puede distribuir o modificar bajo los términos de la version 2 
de GNU - General Public License, tal como es publicada por la Free Software Foundation

Este programa se distribuye con la esperanza de que sea útil pero SIN NINGUNA GARANTÍA; 
sin garantía implícita de COMERCIALIZACIÓN  o de USO PARA UN PROPÒSITO EN PARTICULAR.

Por favor lea GNU General Public License para más detalles.

************************************************************************************
* @subpackage   
* @package	db
* @copyright     GPL
* @version      	1.0
* @author      	Paulo Cesar Coronado
* @link		http://acreditacion.udistrital.edu.co

* pregunta Class 
*
* Esta clase de utiliza manejar las tildes
* 
* 
*
*/

/**************************************************************************************/

class cadenas
{

	function cadenas()
	{
		$this->cadenas="";
	}
	
	/**
	*@method unhtmlentities 
	* @param array berosa
	* @param int  id_instrumento
	* @return string cadena_sql
	* @access public
	*/    
	
	
	function unhtmlentities($cadena)
	{
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($cadena, $trans_tbl);
	}
	
	function convertir_a_mayusculas($str)
	{
		return strtr($str,"abcdefghijklmnopqrstuvwxyzáéíóúñ", "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚÑ");
	}
	
	function convertir_a_minusculas($str)
	{
		return strtr($str,"ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚÑ","abcdefghijklmnopqrstuvwxyzáéíóúñ");
	}

}
?>
