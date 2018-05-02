<?php
/***************************************************************************
*    Copyright (c) 2004 - 2006 :                                           *
*                                                                          *
*    Comite Institucional de Acreditacion                                  *
*    siae@udistrital.edu.co                                                *
*    Paulo Cesar Coronado                                                  *
*    paulo_cesar@udistrital.edu.co                                         *
*                                                                          *
****************************************************************************
*                                                                          *
*                                                                          *
* SIAE es software libre. Puede redistribuirlo y/o modificarlo bajo los    *
* términos de la Licencia Pública General GNU tal como la publica la       *
* Free Software Foundation en la versión 2 de la Licencia ó, a su elección,*
* cualquier versión posterior.                                             *
*                                                                          *
* SIAE se distribuye con la esperanza de que sea útil, pero SIN NINGUNA    *
* GARANTÍA. Incluso sin garantía implícita de COMERCIALIZACIÓN o ADECUACIÓN*
* PARA UN PROPÓSITO PARTICULAR. Vea la Licencia Pública General GNU para   *
* más detalles.                                                            *
*                                                                          *
* Debería haber recibido una copia de la Licencia pública General GNU junto*
* con SIAE; si esto no ocurrió, escriba a la Free Software Foundation, Inc,*
* 59 Temple Place, Suite 330, Boston, MA 02111-1307, Estados Unidos de     *
* América                                                                  *
*                                                                          *
*                                                                          *
***************************************************************************/
?><?php
/****************************************************************************
* @name          encriptar.class.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 28 de agosto de 2006
*****************************************************************************
* @subpackage   
* @package	clase
* @copyright    
* @version      0.1
* @author      	Paulo Cesar Coronado
* @link		
* @description  Esta clase esta disennada para cifrar y decifrar las variables que se pasan a las paginas
*		se recomienda que en cada distribucion el administrador del sistema use mecanismos de cifrado.
*		diferentes a los originales
******************************************************************************/
?><?php

class encriptar
{
	//Constructor
	function encriptar()
	{
	
	
	
	}
	
	
	
	function codificar_url($cadena,$configuracion)
	{
		$cadena=base64_encode($cadena);
		$cadena=strrev($cadena);
		$cadena=$configuracion["enlace"]."=".$cadena;
		return $cadena;
	
	}
	
	
	function decodificar_url($cadena,$configuracion)
	{
		$cadena=strrev($cadena);
		$cadena=base64_decode($cadena);
		
		parse_str($cadena,$matriz);
		
		foreach($_REQUEST as $clave => $valor) 
		{
			unset($_REQUEST[$clave]);
		} 
		
		foreach($matriz as $clave=>$valor)
		{
			$_REQUEST[$clave]=$valor;			
		}
		
		return TRUE;
	}
	
	function codificar_64($cadena,$configuracion)
	{
		$cadena=base64_encode($cadena);
		$cadena=strrev($cadena);
		return $cadena;
	
	}
	
	
	function decodificar_64($cadena)
	{
		$cadena=strrev($cadena);
		$cadena=base64_decode($cadena);
		
		return $cadena;
	
	
	}
	
	function codificar($nombre)
	{
		$nombre=strrev($nombre);
		$veces=strlen($nombre);
		$enlace='';
		for($j=0;$j<=$veces;$j++)
		{
			
			//Generar una cadena de tres letras
			$letra='';
			for($i=0;$i<3;$i++)
			{
				$opcion=rand(1,2);
				if($opcion==1)
				{
					$letra.=chr(rand(65,90));
				}
				else
				{
					$letra.=chr(rand(97,122));
				}
				
			}
			
			
			$mi_letra=substr($nombre,$j,1);
			
			if (ereg ("([a-z])", $mi_letra)) 
			{
				$otra=ord($mi_letra);		
				$otra++;
				$mi_letra=chr($otra);		
			}
			$enlace.=$letra.$mi_letra;
			
		}
		return $enlace;
		
	
	}
	
	function decodificar($pagina)
	{
	
	
		$nombre="";
		$cadena=$pagina;
		for($contador=1;$contador<=((strlen($cadena)-3)/4);$contador++)
		{
			$mi_letra=substr ($cadena,(4*$contador-1),1);
			if (ereg ("([a-z])|({)", $mi_letra)) 
			{
				$otra=ord($mi_letra);		
				$otra--;
				$mi_letra=chr($otra);		
			}
			$nombre.=$mi_letra;
		
		}
		$nombre=strrev($nombre);
		//echo $nombre;
		return $nombre;
	}
	
	
}//Fin de la clase

?>
