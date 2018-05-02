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
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta_llena.class.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	if(isset($_GET["mensaje"]))
	{
		?>
<table class="bloquelateral"  border="0" cellpadding="5" cellspacing="0" align="center" width="60%">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td>Formulario procesado</td>
    </tr>
    <tr class="bloquecentralcuerpo">
      <td>
      Los preguntas diligenciadas han sido correctamente guardadas.
      </td>
    </tr>
  </tbody>
</table>
<br>
<?php  		
	}
	
	if(isset($_GET["accion"]))
	{
		$instrumento=desenlace($_GET["accion"]);
		$instrumento=substr($instrumento,5,strlen($instrumento)-10);
		
		/*Rescatar el id_proceso*/
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"id_proceso");
		$proceso=$dato[0][0];
		$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"clave");
		$usuario=$dato[0][0];
		$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"id_artefacto");
		$artefacto=$dato[0][0];
		unset($dato);
	
		$cadena_sql="SELECT ";
		$cadena_sql.="encuestado ";
		$cadena_sql.=" FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."resultado ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="encuestado='".$usuario."' LIMIT 1";
	
		$acceso_db->registro_db($cadena_sql,0);
		$registro_usuario=$acceso_db->obtener_registro_db();
		$conteo_usuario=$acceso_db->obtener_conteo_db();
	
		unset($registro_usuario);	
	
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
		{	
			$cadena_html="<form action='index.php' method='post'>\n";
			$cadena_html.="<input type='hidden' name='action' value='registro_instrumento'>\n";
			$cadena_html.="<input type='hidden' name='instrumento' value='".$_GET["accion"]."'>\n";
			echo $cadena_html;
			$cadena_html="";
			
			if($conteo_usuario==0)
			{
				$esta_pregunta=new armar_pregunta();
			
			}
			else
			{
				$otra_pregunta=new armar_pregunta_llena();
			
			}
			for($contador=0;$contador<$conteo_encabezado;$contador++)
			{
				
				if($registro_instrumento[$contador][2]==0)
				{
					/* El código corresponde a una pregunta primitiva ("0")*/
					if($conteo_usuario==0)
					{
						$cadena_html=$esta_pregunta->numero_pregunta(($contador+1),$configuracion);
						$cadena_html.=$esta_pregunta->primitiva($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto);
					}
					else
					{
						
						$cadena_html=$otra_pregunta->numero_pregunta(($contador+1),$configuracion);
						$cadena_html.=$otra_pregunta->primitiva($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$usuario,$artefacto);
						
					}
				}
				else
				{
					
					/* El código corresponde a una pregunta compuesta ("1")*/
					if($registro_instrumento[$contador][2]==1)
					{
						if($conteo_usuario==0)
						{
							$cadena_html=$esta_pregunta->numero_pregunta(($contador+1));
							$cadena_html.=$esta_pregunta->compuesta($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto);
						}
						else
						{
							/*TODO Para cuando ya está contestado el formulario*/
							$cadena_html=$otra_pregunta->numero_pregunta(($contador+1));
							$cadena_html.=$otra_pregunta->compuesta($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$usuario,$artefacto);
							
						}
					}
					
				}

				echo $cadena_html;
				if($conteo_usuario==0)
				{
					$esta_pregunta->armar_pregunta();
				}
				else
				{
					$otra_pregunta->armar_pregunta_llena();
				}

			
			}
			
		$cadena_html="<br><br><table  width='50%' align='center'>\n<tbody>\n";
		$cadena_html.="<tr>\n";
		/*Solo se pasa al procesamiento general del formulario si se hace click en el botón aceptar*/
		$cadena_html.="<td style='text-align:center'><hr><input type='submit' name='aceptar'";
		$cadena_html.=" value='Aceptar' title='Guarda el formulario'><hr></td>\n";
		$cadena_html.="</tr>\n";
		$cadena_html.="</tbody>\n</table>\n";		
		$cadena_html.="</form>\n";
		echo $cadena_html;
		unset($cadena_html);
		}
	}
	else
	{
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_proceso");
		if($registro!=FALSE)
		{
			$proceso=$registro[0][0];
		}
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_artefacto");
		if($registro!=FALSE)
		{
			$artefacto=$registro[0][0];
		}
		//Presentacion del artefacto
		$cadena_sql="SELECT ";
		$cadena_sql.="presentacion";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."artefacto ";
		$cadena_sql.=" WHERE id_artefacto=".$artefacto;
		$cadena_sql.=" LIMIT 1";
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
		
		
	?><table class="bloquelateral" width="100%" border="0" cellpadding="2" cellspacing="0">
	<tbody>
	<tr>
	<td>
	<table width="100%" border="0" cellpadding="5" cellspacing="1">
	<tbody>
	<tr class="bloquecentralcuerpo">
		<td class="celdatabla">
		<?php   echo $registro[0][0] ?>
		</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<?php   	}
		
		// Componentes
		
		$cadena_sql="SELECT ";
		$cadena_sql.="".$configuracion["prefijo"]."a_instrumento.id_instrumento, ";
		$cadena_sql.="".$configuracion["prefijo"]."a_instrumento.orden, ";
		$cadena_sql.="".$configuracion["prefijo"]."instrumento.etiqueta ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."a_instrumento,".$configuracion["prefijo"]."instrumento ";
		$cadena_sql.=" WHERE ".$configuracion["prefijo"]."a_instrumento.id_artefacto=".$artefacto;
		$cadena_sql.=" AND ".$configuracion["prefijo"]."a_instrumento.id_instrumento=".$configuracion["prefijo"]."instrumento.id_instrumento ";
		$cadena_sql.=" GROUP BY ".$configuracion["prefijo"]."a_instrumento.id_instrumento ORDER BY ".$configuracion["prefijo"]."a_instrumento.orden";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$conteo=$acceso_db->obtener_conteo_db();
		if($conteo>0)
		{	
			
			$cadena_pregunta="<br><table align='center' width= '100%' border='0' cellpadding='7' cellspacing='1' class='bloquelateral'>\n";
			$cadena_pregunta.="<tbody>";
			for($contador=0;$contador<$conteo;$contador++)
			{
				$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
				$cadena_pregunta.="<td class='celdatabla' align='center'>\n";
				$cadena_pregunta.="<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('instrumento')."&accion=".enlace("formu".$registro[$contador][0]."lario")."'>".$registro[$contador][2]."</A>";
				$cadena_pregunta.="</td>\n";
				$cadena_pregunta.="</tr>\n";
			}
			$cadena_pregunta.="</tbody>\n";
			$cadena_pregunta.="</table>\n";
			echo $cadena_pregunta;
		
	
		}
	}
}

?>
