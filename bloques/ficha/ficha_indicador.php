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
?><?php  
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

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	
if(isset($_GET['indicador']))
{
	$indicador=$_GET['indicador'];
}
else
{
	echo "Imposible realizar la acci&oacute;n solicitada. Por favor revise sus privilegios.";
	exit;
}
	
//Rescatar los codigos del componente, se ingresan todos los valores en na matriz unidimensional de n filas

include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");

$fila=0;
echo "<table class='bloquelateral' cellpadding=5 cellspacing=0>\n<tbody>\n";
echo "<tr class='bloquecentralencabezado'>\n<td align='justify'>\n Componentes";
echo "</td>\n</tr>\n";
echo "<tr class='bloquecentralcuerpo'>\n<td align='justify'>\n";
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();

if (is_resource($enlace))
{
	for($contador=0;$contador < strlen($indicador);$contador+=3)
	{
		//Componente
		$componente=substr($indicador,$contador,3);
		$componente*=1;
		
		if($componente==0)
		{		
			$componente=substr($indicador,$contador,3);
			$total="";
			for($count=2;$count>=0;$count--)
			{
				$valor=substr($componente,$count,1);
				if($valor!='0')
				{
					$total=$valor.$total;
				}
		
			}
			$componente=$total;
		}
		//Padre
		if($contador>0)
		{
			$componente_padre=substr($indicador,($contador-3),3);
			//echo "<br>Padre:".$componente_padre."<br>";
			$componente_padre*=1;
			
			if($componente_padre==0)
			{		
				$componente_padre=substr($indicador,($contador-3),3);
				$total="";
				for($count=2;$count>=0;$count--)
				{
					$valor=substr($componente_padre,$count,1);
					if($valor!='0')
					{
						$total=$valor.$total;
					}
			
				}
				$componente_padre=$total;
			}
		}	
		else
		{
			$componente_padre=0;
		}
		
		//echo $componente."<br>";
			//echo $componente_padre."<br>";
			
		$cadena_sql="SELECT id_componente,nombre,valor ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."modelo_componente ";
		$cadena_sql.="WHERE id_componente='".$componente."' ";
		$cadena_sql.=" AND nivel=".($fila+1);
		$cadena_sql.=" AND id_padre='".$componente_padre."'";				
		//echo $cadena_sql;
		
			if($acceso_db->registro_db($cadena_sql,0))
			{
				//Obtener el registro con el resultado de la busqueda			
				$registro=$acceso_db->obtener_registro_db();
				//Obtener el total de registros devueltos por la consulta
				$campos=$acceso_db->obtener_conteo_db();
				
				if($campos>0)
				{
					echo "<table cellpadding='5' cellspacing='0'>\n<tbody>\n";
					for($los_campos=1;$los_campos<3;$los_campos++)
					{
						echo "<tr class='bloquecentralcuerpo'>\n<td align='justify'>\n";
						if($los_campos==1)
						{
							echo "<b>".$registro[0][$los_campos]."</b><br>";
						}
						else
						{	
							echo $registro[0][$los_campos]."<br>";
						}
						echo "</td>\n</tr>\n";
						
					}
					echo "</tbody>\n</table>\n";
					echo "<br>";
				}
				else
				{
					echo "El c&oacute;digo del componente no es v&aacute;lido";	
				}
		
			}
			else
			{
				echo "No se logr&oacte; rescatar una secci&oacte;n v&aacute;lida";
			}
		
	
		$fila++;
		
	}
	
	echo "</td>\n</tr>\n";
	echo "</tbody>\n</table>\n";
}	
?>
