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
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta_estadistica.class.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	if(isset($_GET["proceso"]) && isset($_GET["artefacto"]) && isset($_GET["instrumento"]))
	{
		
		$proceso=$_GET["proceso"];
		$artefacto=$_GET["artefacto"];
		$instrumento=$_GET["instrumento"];
		
		//Preguntas que componen el instrumento
		$cadena_sql="SELECT ";
		$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta,";
		$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.orden,";
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.tipo";
		$cadena_sql.=" FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."i_pregunta,".$configuracion["prefijo"]."pregunta ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_instrumento=".$instrumento;
		$cadena_sql.=" AND ";
		$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta=".$configuracion["prefijo"]."pregunta.id_pregunta";
		$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."i_pregunta.orden ASC";
	
		$acceso_db->registro_db($cadena_sql,0);

		$registro_instrumento=$acceso_db->obtener_registro_db();
		$conteo_encabezado=$acceso_db->obtener_conteo_db();
	
		if($conteo_encabezado>0)
		{	?><table width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">					
<tr class="bloquecentralcuerpo">
<td><?php  
			
			$cadena_html="<script src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/funciones.js' type='text/javascript' language='javascript'></script>";
			$cadena_html.="<table cellspacing='2' width='100%'>\n";
			$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_html.="<td align='center'>\n";
			$cadena_html.="<h3>INFORME GENERAL DE RESULTADOS</h3>";
			$cadena_html.="</td>\n";
			$cadena_html.="</tr>\n";
			$cadena_html.="</table>\n";
			echo $cadena_html;
			$cadena_html="";
			$esta_pregunta=new armar_pregunta_estadistica();
			for($contador=0;$contador<$conteo_encabezado;$contador++)
			{
				
				if($registro_instrumento[$contador][2]==0)
				{
					/* El código corresponde a una pregunta primitiva ("0")*/
					$cadena_html=$esta_pregunta->numero_pregunta(($contador+1));
					$cadena_html.=$esta_pregunta->primitiva($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto,0);
					
				}
				else
				{
					
					/* El código corresponde a una pregunta compuesta ("1")*/
					if($registro_instrumento[$contador][2]==1)
					{
						$cadena_html=$esta_pregunta->numero_pregunta(($contador+1));
						$cadena_html.=$esta_pregunta->compuesta($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto);
						
					}
					
				}

				echo $cadena_html;
				$esta_pregunta->armar_pregunta_estadistica();
				

			
			}
			
		$cadena_html="<br><br>";
		echo $cadena_html;
		unset($cadena_html);?>
</td>
</tr>
</table><?php  
	}
	
	}
}

?>
