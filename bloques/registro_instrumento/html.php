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
/****************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 7 de Mayo de 2007

*******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
**********************************************************************************/
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta_llena.class.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	
	$dato=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_proceso");
	if($dato!=FALSE)
	{
		$proceso=$dato[0][0];
	}
	
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_artefacto");
	if($registro!=FALSE)
	{
		$artefacto=$registro[0][0];
	}
	
	if(isset($_REQUEST["eval_docente"]))
	{
		$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	}
	else
	{
		$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"clave");
		
	}	
	$usuario=$dato[0][0];
	
	unset($dato);
	
	
	
	if(isset($_REQUEST["mensaje"]))
	{
		mostrar_mensaje($configuracion);
	}
	else
	{
		mostrar_presentacion($configuracion,$artefacto,$enlace,$acceso_db);	
	
	}	
	if(isset($_REQUEST["accion"]))
	{
		mostrar_instrumento($configuracion,$enlace,$acceso_db,$proceso,$artefacto,$usuario);
	}
	else
	{
		mostrar_lista_artefactos($configuracion,$enlace,$acceso_db,$proceso,$artefacto);
	}
}

//======================================================================================
//                           FUNCIONES
//======================================================================================

function mostrar_instrumento($configuracion,$enlace,$acceso_db,$proceso,$artefacto,$usuario)
{
	$instrumento=desenlace($_REQUEST["accion"]);
	$instrumento=substr($instrumento,5,strlen($instrumento)-10);
	$formulario="encuesta_general";
	
	$registro_usuario=busqueda_registro_instrumento($usuario,$configuracion,"encuestado",$enlace,$acceso_db);
	if(is_array($registro_usuario))
	{
		$conteo_usuario=count($registro_usuario);
	}
	else
	{
		$conteo_usuario=0;
	}
	unset($registro_usuario);
		
	$registro_instrumento=busqueda_registro_instrumento($instrumento,$configuracion,"pregunta",$enlace,$acceso_db);
	if(is_array($registro_instrumento))
	{
		$conteo_encabezado=count($registro_instrumento);
		if($conteo_encabezado>0)
		{	
			$cadena_html="<form action='index.php' method='post' name='".$formulario."'>\n";
			$cadena_html.="<input type='hidden' name='action' value='registro_instrumento'>\n";
			$cadena_html.="<input type='hidden' name='instrumento' value='".$_REQUEST["accion"]."'>\n";
			if(isset($_REQUEST["eval_docente"]))
			{
				$cadena_html.="<input type='hidden' name='eval_docente' value='".$_REQUEST["eval_docente"]."'>\n";
			}
			echo $cadena_html;
			$cadena_html="";
			$verificar="1";
			
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
						$la_pregunta=$esta_pregunta->primitiva($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto);
					}
					else
					{
						
						$cadena_html=$otra_pregunta->numero_pregunta(($contador+1),$configuracion);
						$la_pregunta=$otra_pregunta->primitiva($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$usuario,$artefacto);
						
					}
				}
				else
				{
					
					/* El código corresponde a una pregunta compuesta ("1")*/
					if($registro_instrumento[$contador][2]==1)
					{
						if($conteo_usuario==0)
						{
							$cadena_html=$esta_pregunta->numero_pregunta(($contador+1),$configuracion);
							$la_pregunta=$esta_pregunta->compuesta($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto);
						}
						else
						{
							/*TODO Para cuando ya está contestado el formulario*/
							$cadena_html=$otra_pregunta->numero_pregunta(($contador+1),$configuracion);
							$la_pregunta=$otra_pregunta->compuesta($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$usuario,$artefacto);
							
						}
					}
					
				}
				
				if(is_array($la_pregunta))
				{
					$cadena_html.=$la_pregunta[0];
					$verificar.=str_replace ( "REEMPLAZO", $formulario, $la_pregunta[1]);
				}
				else
				{
					$cadena_html.=$la_pregunta;
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
			$cadena_html.="<td style='text-align:center'><hr>";
			$cadena_html.="<input value='Aceptar' name='aceptar' tabindex='". $tab++ ."' type='button' onclick=\"return(".$verificar.")?document.forms['".$formulario."'].submit():false\">";
			$cadena_html.="<hr></td>\n";
			$cadena_html.="</tr>\n";
			$cadena_html.="</tbody>\n</table>\n";		
			$cadena_html.="</form>\n";
			echo $cadena_html;
			unset($cadena_html);
		}
	
	
	}
	
	
}


function mostrar_mensaje($configuracion)
{
?><table class="bloquelateral2" cellpadding="10" cellspacing="0">
	<tbody>
		<tr class="bloquecentralcuerpo">
			<td valign="middle" align="right" width="10%">
			<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/notificacion.png" border="0" />
			</td>
			<td>
			<span class="encabezado_normal">Formulario Procesado.</span><hr class="hr_division">
			Las preguntas diligenciadas en el formulario han sido correctamente ingresadas al sistema.<br>
			</td>
		</tr><?php
		if(isset($_REQUEST["eval_docente"]))
		{
			unset($_REQUEST['action']);
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			$pagina="evaluacion_docente";
		?><tr class="bloquecentralcuerpo">
			<td valign="middle" align="right" colspan="2">
				<a href="<?php echo $configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina) ?>">
				Regresar al listado de Docentes.
				</a> 
			</td>
		</tr><?php
		}  	
	?></tbody>
</table>
<br><?php
}

function mostrar_presentacion($configuracion,$artefacto,$enlace,$acceso_db)
{	

	if(!isset($_REQUEST["accion"]))
	{
		$registro=busqueda_registro_instrumento($artefacto,$configuracion,"presentacion",$enlace,$acceso_db);	
	}
	else
	{
		$registro=busqueda_registro_instrumento($artefacto,$configuracion,"presentacion_formulario",$enlace,$acceso_db);
	
	}
	
	if(is_array($registro))
	{
		if(count($registro>0))
		{
	?><table class="bloquelateral" width="100%" border="0" cellpadding="2" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="5" cellspacing="1">
					<tbody>
					<tr class="bloquecentralcuerpo">
						<td>
						<?php echo $registro[0][0] ?>
						</td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
		</tbody>
	</table><?php
		}
	
	}
}


function mostrar_lista_artefactos($configuracion,$enlace,$acceso_db,$proceso,$artefacto)
{
	$registro=busqueda_registro_instrumento($artefacto,$configuracion,"componentes",$enlace,$acceso_db);
	if(is_array($registro))
	{
		$conteo=count($registro);
		if($conteo>0)
		{
		
			$cadena_pregunta="<br><table align='center' width= '100%' border='0' cellpadding='7' cellspacing='1' class='bloquelateral'>\n";
			$cadena_pregunta.="<tbody>";
			for($contador=0;$contador<$conteo;$contador++)
			{
				$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
				$cadena_pregunta.="<td class='celdatabla' align='center'>\n";
				if(!isset($_REQUEST["eval_docente"]))
				{
					$cadena_pregunta.="<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('instrumento')."&accion=".enlace("formu".$registro[$contador][0]."lario")."'>".$registro[$contador][2]."</a>";
				}
				else
				{
					$cadena_pregunta.="<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('instrumento')."&accion=".enlace("formu".$registro[$contador][0]."lario")."&eval_docente=".$_REQUEST["eval_docente"]."'>".$registro[$contador][2]."</a>";
				}
				$cadena_pregunta.="</td>\n";
				$cadena_pregunta.="</tr>\n";
			}
			$cadena_pregunta.="</tbody>\n";
			$cadena_pregunta.="</table>\n";
			echo $cadena_pregunta;	
		}
	}
}


function cadena_registro_instrumento($configuracion,$tipo,$valor="")
{
	//echo $valor;
	switch($tipo)
	{
		case "encuestado":
			$cadena_sql="SELECT ";
			$cadena_sql.="encuestado ";
			$cadena_sql.="FROM ";
			if(isset($_REQUEST["eval_docente"]))
			{
				$cadena_sql.="".$configuracion["prefijo"]."resultado_evaluacion ";
			}
			else
			{
				$cadena_sql.="".$configuracion["prefijo"]."resultado ";
			}
			$cadena_sql.="WHERE ";
			$cadena_sql.="encuestado='".$valor."' LIMIT 1";
			break;
			
		case "pregunta":			
			$cadena_sql="SELECT ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta,";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.orden,";
			$cadena_sql.="".$configuracion["prefijo"]."pregunta.tipo";
			$cadena_sql.=" FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta,".$configuracion["prefijo"]."pregunta ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_instrumento=".$valor;
			$cadena_sql.=" AND ";
			$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta=".$configuracion["prefijo"]."pregunta.id_pregunta";
			$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."i_pregunta.orden ASC";
			break;
		
		case "presentacion":
			$cadena_sql="SELECT ";
			$cadena_sql.="presentacion";
			$cadena_sql.=" FROM ".$configuracion["prefijo"]."artefacto ";
			$cadena_sql.=" WHERE id_artefacto=".$valor;
			$cadena_sql.=" LIMIT 1";
			break;
		
		case "componentes":
			$cadena_sql="SELECT ";
			$cadena_sql.="".$configuracion["prefijo"]."a_instrumento.id_instrumento, ";
			$cadena_sql.="".$configuracion["prefijo"]."a_instrumento.orden, ";
			$cadena_sql.="".$configuracion["prefijo"]."instrumento.etiqueta ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."a_instrumento,".$configuracion["prefijo"]."instrumento ";
			$cadena_sql.=" WHERE ".$configuracion["prefijo"]."a_instrumento.id_artefacto=".$valor;
			$cadena_sql.=" AND ".$configuracion["prefijo"]."a_instrumento.id_instrumento=".$configuracion["prefijo"]."instrumento.id_instrumento ";
			$cadena_sql.=" GROUP BY ".$configuracion["prefijo"]."a_instrumento.id_instrumento ORDER BY ".$configuracion["prefijo"]."a_instrumento.orden";
			break;
		default:
			$cadena_sql="";
	}
	//echo $cadena_sql;
	return $cadena_sql;
}


function busqueda_registro_instrumento($valor,$configuracion,$tipo,$enlace,$acceso_db)
{
	
	$cadena_sql=cadena_registro_instrumento($configuracion,$tipo,$valor);
	//echo $cadena_sql."<br>";		
	$acceso_db->registro_db($cadena_sql,0);
	$registro_busqueda=$acceso_db->obtener_registro_db();
	if($registro_busqueda==FALSE)
	{
		$error=$acceso_db->obtener_error();
		if((is_array($error))&&($configuracion["development_mode"]==TRUE))
		{
			echo $error["numero"].":".$error["error"];
		}
		return FALSE;
	}
	else
	{
		$campos_busqueda=$acceso_db->obtener_conteo_db();
		if($campos_busqueda>0)
		{
			return $registro_busqueda;
		}
		else 
		{
			return FALSE;
		
		}
	}
}

?>
