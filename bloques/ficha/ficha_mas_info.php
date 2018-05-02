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
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_informacion_pregunta.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mostrar_lista_pregunta.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mostrar_consolidado_resultado.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/funciones_matematicas.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/grafico_estadistica.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");
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
		$pregunta=$_GET["pregunta"];
		
		//Informacion Basica de la pregunta
		$cadena_sql="SELECT ";
		$cadena_sql.="id_pregunta,";
		$cadena_sql.="tipo ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."pregunta ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_pregunta=".$pregunta." ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);

		$registro_instrumento=$acceso_db->obtener_registro_db();
		$conteo_encabezado=$acceso_db->obtener_conteo_db();
	
		if($conteo_encabezado>0)
		{	
?><table width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">					
	<tr class="bloquecentralcuerpo">
		<td><?php  
			$cadena_html="<script src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/funciones.js' type='text/javascript' language='javascript'></script>";
			$cadena_html.="<table cellspacing='2' width='100%'>\n";
			$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_html.="<td align='center'>\n";
			$cadena_html.="<h3>INFORME ESPECIFICO DE RESULTADOS PARA LA PREGUNTA</h3>\n";
			$cadena_html.="</td>\n";
			$cadena_html.="</tr>\n";
			$cadena_html.="</table>\n";
			echo $cadena_html;
			$cadena_html="";
			$esta_pregunta=new armar_informacion_pregunta();
			if($registro_instrumento[0][1]==0)
			{
				/* El código corresponde a una pregunta primitiva ("0")*/
				$cadena_html=$esta_pregunta->numero_pregunta(1);
				$cadena_html.=$esta_pregunta->primitiva($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$artefacto);
				
			}
			else
			{
				
				/* El código corresponde a una pregunta compuesta ("1")*/
				if($registro_instrumento[0][1]==1)
				{
					$cadena_html=$esta_pregunta->numero_pregunta(1);
					$cadena_html.=$esta_pregunta->compuesta($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$artefacto);
					
				}
				else
				{
					if($registro_instrumento[0][1]==2)
					{
						$cadena_html=$esta_pregunta->numero_pregunta(1);
						$cadena_html.=$esta_pregunta->asociada($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$artefacto);
						
					}
				}
				
			}

		echo $cadena_html;
		$esta_pregunta->armar_informacion_pregunta();
		
		//Tabla de consolidado de resultados
		
		$cadena_html="<br>";
		$cadena_html.="<hr>\n";
		echo $cadena_html;
		echo "<h2>Registro Total de Respuestas</h2>";
		
		$cadena_html="";
		
		$informacion=new mostrar_consolidado_resultado();
		$encuestado=$informacion->lista_encuestado($configuracion,$pregunta,$proceso,0,$instrumento,$artefacto);
					
		if(is_array($encuestado))
		{
			asort($encuestado);
			
			$cadena_resultado="<table class='tablapresentacion' align='center' style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>\n";
			$cadena_resultado.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_resultado.="<td class='celdapresentacion'>\n";
			$cadena_resultado.="Encuestado\n";
			$cadena_resultado.="</td>\n";
			$cadena_resultado.="<td class='celdapresentacion'>\n";
			$cadena_resultado.="Proceso\n";
			$cadena_resultado.="</td>\n";
			$cadena_resultado.="<td class='celdapresentacion'>\n";
			$cadena_resultado.="Instrumento\n";
			$cadena_resultado.="</td>\n";
			$cadena_resultado.="<td class='celdapresentacion'>\n";
			$cadena_resultado.="Pregunta\n";
			$cadena_resultado.="</td>\n";
			$cadena_resultado.="<td class='celdapresentacion'>\n";
			$cadena_resultado.="Opcion\n";
			$cadena_resultado.="</td>\n";
			$cadena_resultado.="<td class='celdapresentacion'>\n";
			$cadena_resultado.="Respuesta\n";
			$cadena_resultado.="</td>\n";
			$cadena_resultado.="</tr>\n";
			for($contador=0;$contador<count($encuestado);$contador++)
			{
				if($registro_instrumento[0][1]==0)
				{
					
					$cadena_resultado.= $informacion->primitiva($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$encuestado[$contador][0],$artefacto);
					
				}
				else
				{
					
					
					if($registro_instrumento[0][1]==1)
					{
						$cadena_resultado.= $informacion->compuesta($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$artefacto);
						
					}
					else
					{
						if($registro_instrumento[0][1]==2)
						{
							$cadena_resultado.= $informacion->asociada($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$encuestado[$contador][0],$artefacto);
							
						}
					}
					
				}
				
				$informacion->mostrar_consolidado_resultado();
			}
			$cadena_resultado.="</table>\n";	
			echo $cadena_resultado;
		}
		
		
		
		$cadena_html="<br>";
		$cadena_html.="<hr>\n";
		echo $cadena_html;
		echo "<h2>Registro Total de Respuestas</h2>";
		
		$cadena_html="";
		
		$informacion=new mostrar_lista_pregunta();
		$encuestado=$informacion->lista_encuestado($configuracion,$pregunta,$proceso,0,$instrumento,$artefacto);
					
		if(is_array($encuestado))
		{
			asort($encuestado);
			for($contador=0;$contador<count($encuestado);$contador++)
			{
				echo "<h3>". $encuestado[$contador][0]."</h3>";
				if($registro_instrumento[0][1]==0)
				{
					
					echo $informacion->primitiva($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$encuestado[$contador][0],$artefacto);
					
				}
				else
				{
					
					
					if($registro_instrumento[0][1]==1)
					{
						echo $informacion->compuesta($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$artefacto);
						
					}
					else
					{
						if($registro_instrumento[0][1]==2)
						{
							echo $informacion->asociada($configuracion,$registro_instrumento[0][0],$proceso,"0",$instrumento,$encuestado[$contador][0],$artefacto);
							
						}
					
					
					
					}
					
				}
				
				$informacion->mostrar_lista_pregunta();
			}
			
		}
		echo $cadena_html;
		unset($cadena_html);
		
		
		
		
		
		?>
</td>
</tr>
</table><?php  
	}
	
	}
}

?>
