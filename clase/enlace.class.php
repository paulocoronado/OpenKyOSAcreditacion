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

/****************************************************************************
* @name          dbms.class.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 11 de Mayo de 2007
******************************************************************************
* @subpackage   
* @package	clase
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://acreditacion.udistrital.edu.co
* @description  Clase disennada para crear enlaces a las paginas
*
*******************************************************************************/

//TODO: Poner los enlaces del sitio a trabajar utilizando esta clase.
//TODO: Crear el metodo de desenlace.

class enlace
{

	function enlace($configuracion)
	{
		if(isset($configuracion['host']) && isset($configuracion['site']))
		{
			$this->ruta = $configuracion['host'].$configuracion['site'];
		}
		else
		{
			return FALSE;
		}
		
		
		if(isset($configuracion['enlace']))
		{
			$this->enlace = $configuracion['enlace'];
		}
		return TRUE;
	}
	
	function crear_enlace($pagina,$variables="",$encriptar)
	{
			$variable=$this->obtener_variable($variables);
			$pagina=$encriptar->codificar($pagina);
			$enlace=$this->ruta."/index.php?page=".$pagina.$variable;   
			return $enlace;
	
	}
	
	
	function obtener_variable($variables)
	{
		$variable="";
		if(is_array($variables))
		{
			foreach ($variables as $clave => $valor) 
			{
				$variable.="&".$clave."=".$valor;
			}
		}
		return $variable;	
	}	
}
?>
