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
?><?php
/****************************************************************************************************************
  
enlace.inc.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	incluir
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://acreditacion.udistrital.edu.co
* @description  Pequenna funcion para codificar los enlaces de los menus
* @usage        invocar a la funcion enlace con el nombre de la pagina
*****************************************************************************************************************/
?><?php
function enlace($nombre)
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

function desenlace($pagina)
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

function enlace_numero($numero)
{
	$veces=strlen($numero);
	$enlace='';
	for($j=0;$j<=$veces;$j++)
	{
		
		//Generar una cadena de tres letras
		$letra='';
		for($i=0;$i<2;$i++)
		{
			
				$letra.=chr(rand(65,90));
		}
		$enlace.=$letra.substr($numero,$j,1);;
		
	}
        return $enlace;
	

}

function desenlace_numero($numero)
{


	$nombre="";
	$cadena=$numero;
	for($contador=1;$contador<=((strlen($cadena)-2)/3);$contador++)
	{
		$nombre.=substr ($cadena,(3*$contador-1),1);
	
	}

	return $nombre;
}


?>
