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
/***************************************************************************
  
registro.action.php 

Paulo Cesar Coronado
Copyright (C) 2001-2007

Última revisión 22 de Octubre de 2007

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, GET.
******************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

if(!isset($_REQUEST["metrica"]))
{
		$cuerpo="<b>INFORMACION FALTANTE</b><br>";
		$cuerpo.="Todas las preguntas deben tener una m&eacute;trica. <br>Por favor regrese ";
		$cuerpo.="al formulario y corrija la informaci&oacute;n.";
		echo $cuerpo;
		exit();
		
}

$metrica=$_REQUEST["metrica"];

/*El el caso de métricas de opciones*/


switch($metrica)
{
	case 1:
	case 2:
	case 3:
	formulario_metrica_multiple($metrica,$configuracion);
	break;
	
	case 4:
	formulario_metrica_numerico($metrica,$configuracion);
	break;
	
	default:
	//Ir directamente a guardar registro primitiva
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/registro_metrica_primitiva/action.php");
	/*unset($_POST['action']);
	$variable="";
	$variable.="&id_primitiva=".$_POST["id_primitiva"];
	
	$pagina="guardar_primitiva";
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
	*/	
	break;

}
/*=============================================================================
                           FUNCIONES
===============================================================================*/

function formulario_metrica_multiple($metrica,$configuracion)
{
	$con_opciones=0;
	
	
	$formulario="crear_formulario";
	$verificar="1";
	
	
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"] ?>/funciones.js" type="text/javascript" language="javascript"></script>
	<form method="post" action="index.php" name="<?php echo $formulario ?>" onsubmit="">
	<input type="hidden" name= "action" value="registro_metrica_primitiva"><?php
	$con_opciones++;
	$cadena="";
	
	
	$pregunta=$_REQUEST["id_primitiva"];
	$opciones=$_REQUEST["opcion"];
	
	if(!is_numeric($opciones))
	{
		$opciones=2;
	}
	else
	{
		if($opciones<1)
		{
				$opciones=2;
		}
		
	}
	?><input type="hidden" name= "id_primitiva" value="<?php echo $pregunta ?>">
	<input type="hidden" name= "opcion" value="<?php echo $opciones ?>">
	<input type="hidden" name= "metrica" value="<?php echo $metrica ?>">
	
	<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
	<tr class="bloquecentralcuerpo">
	<td class="encabezado">
	<hr>Opciones de la respuesta:<hr></td>
	</tr>
	</tbody>
	</table>
	<table class='bloquelateral' width='100%' align='center' cellpadding='5' cellspacing='2' ><tbody>
	<tr class='bloquecentralencabezado' align='center'>
	<td>Opci&oacute;n</td>
	<td>Etiqueta</td>
	<td><?php
	if($metrica==3)
	{
		?>Tama&ntilde;o del Campo<?
	}
	else
	{
		?>Valor<?
	}
	?></td>
	<td>Orden</td>
	</tr><?php
	for($opcion=0;$opcion<$opciones;$opcion++)
	{
?>	<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	<span style="font-weight: bold;"><?php echo ($opcion+1) ?>:</span><br>
	</td>
	<td class="celdatabla">
		<input name="etiqueta_<? 
		echo $opcion;
		$verificar.="&&control_vacio(".$formulario.",'etiqueta_".$opcion."')";
		
		?>">
	</td>
	<td class="celdatabla"><?php		
		if($metrica==3)
		{
			?><input maxlength="10" size="5" name="valor_<? echo $opcion?>" value="30" ><?php
		}
		else
		{
			?><input maxlength="10" size="5" name="valor_<? echo $opcion?>" value="<?php echo ($opcion+1) ?>"><?php
			
		}	
	?></td>
	<td class="celdatabla">
		<input maxlength="5" size="5" name="orden_<? echo $opcion?>" value="<?php echo ($opcion+1) ?>">
	</td>
	</tr><?php
	
	}
	?></tbody>
	</table>
	<br>
	<table style="margin-left: auto; margin-right: auto; width:100%; text-align: left;"";
	 border="0" cellpadding="2" cellspacing="2" align="center">
	<tbody>
	<tr align="center">
	<td colspan="2" rowspan="1">
	<img  src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_aceptar.png" alt="Aceptar" title="Aceptar" border="0" onclick="return(<?php echo $verificar; ?>)?document.forms['<?php echo $formulario?>'].submit():false"/>
	<br>
	</td>
	</tr>
	</tbody>
	</table>
	</form><?php	

}

function formulario_metrica_numerico($metrica,$configuracion)
{
	
	$pregunta=$_REQUEST["id_primitiva"];
	$opciones=$_REQUEST["opcion"];
	
	$formulario="crear_formulario";
	
	$verificar="1";
	$verificar.="&&verificar_numero_lleno(".$formulario.",'inferior')";
	$verificar.="&&verificar_numero_lleno(".$formulario.",'superior')";
	
	
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"] ?>/funciones.js" type="text/javascript" language="javascript"></script>
	<form method="post" action="index.php" name="<?php echo $formulario ?>" onsubmit="">
	<input type="hidden" name= "action" value="registro_metrica_primitiva">
	<input type="hidden" name= "id_primitiva" value="<?php echo $pregunta ?>">
	<input type="hidden" name= "opcion" value="<?php echo $opciones ?>">
	<input type="hidden" name= "metrica" value="<?php echo $metrica ?>">
	
	<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
	<tr class="bloquecentralcuerpo">
	<td class="encabezado">
	<hr>Opciones de la respuesta:<hr></td>
	</tr>
	</tbody>
	</table>
	<table class='bloquelateral' width='100%' align='center' cellpadding='5' cellspacing='2' >
		<tbody>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla">
			<span class="texto_negrita"><?php echo ayuda_metrica("inferior") ?></span>
			</td>
			<td class="celdatabla">
				<input type="text" maxlength="5" size="5" name="inferior" value="">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla">
			<span class="texto_negrita"><?php echo ayuda_metrica("superior") ?></span>
			</td>
			<td class="celdatabla">
				<input type="text" maxlength="5" size="5" name="superior" value="">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla">
			<?php echo ayuda_metrica("entero") ?>
			</td>
			<td class="celdatabla">
				<input type="checkbox" name="entero" checked />
			</td>
		</tr>
	</tbody>
	</table>
	<br>
	<table style="margin-left: auto; margin-right: auto; width:100%; text-align: left;"";
	 border="0" cellpadding="2" cellspacing="2" align="center">
	<tbody>
	<tr align="center">
	<td colspan="2" rowspan="1">
	<img  class="enlace" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_aceptar.png" alt="Aceptar" title="Aceptar" border="0" onclick="return(<?php echo $verificar; ?>)?document.forms['<?php echo $formulario?>'].submit():false"/>
	<br>
	</td>
	</tr>
	</tbody>
	</table>
	</form><?php	

}

function ayuda_metrica($tipo)
{
	
	
	switch($tipo)
	{
	
		case "entero":
			
			$etiqueta="Solo valores enteros:";
			$texto_ayuda="Seleccione si la respuesta solo acepta valores enteros.";
			break;
		case "superior":
			$etiqueta="L&iacute;mite Superior:";
			$texto_ayuda="Mayor valor que se puede ingresar. Deje en blanco si no existe l&iacute;mite.";
			break;
		case "inferior":
			$etiqueta="L&iacute;mite Inferior:";
			$texto_ayuda="Menor valor que se puede ingresar. Deje en blanco si no existe l&iacute;mite (Permitir&aacute; valores negativos).";
			break;
		default:
			$etiqueta="";
			$texto_ayuda="";
			
			
	}
	$cadena_html="<span onmouseover=\"";
	$cadena_html.="this.T_WIDTH=200;";
	$cadena_html.="return escape('";
	$cadena_html.=$texto_ayuda;
	$cadena_html.="')\">";
	$cadena_html.=$etiqueta;
	$cadena_html.="</span>";
	
	return $cadena_html;

}
