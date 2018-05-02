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
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 29 de Marzo de 2007

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
******************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="compuesta_componente" onsubmit="return ())" >
<input type="hidden" name= "action" value="registro_compuesta">
<input type="hidden" name= "registro_compuesta" value="1">
<input type="hidden" name= "page" value="comite_pregunta_compuesta">
<table style="width: 100%; text-align: left;" align="center" border="0" cellpadding="5" cellspacing="1">
	<tbody>
	<tr class="mensajealertaencabezado">
	<td colspan="2" rowspan="1" >Opciones Disponibles<br>
	</td>
	</tr>
	<tr class="bloquecentralcuerpo" style="text-align: center;">
	<td class="celdatabla">Pregunta abstracta
	</td>
	<td class="celdatabla">
	<input name="abstracta" value="1" type="checkbox"><br>
	</td>
	</tr>
	<tr class="mensajealertaencabezado">
	<td style="text-align: center;">Tipo de Pregunta<br>
	</td>
	<td style="text-align: center;">Cantidad<br>
	</td>
	</tr>
	<tr class="bloquecentralcuerpo">
	<td class="celdatabla">Preguntas asociadas<br>
	</td>
	<td class="celdatabla" style="text-align: center;">
	<input maxlength="5" size="5" name="asociada"></td>
	</tr>
	<tr>
	<td colspan="2" rowspan="1"
	style="font-family: serif; background-color: rgb(255, 255, 255); text-align: center;"><input
	value="aceptar" name="aceptar" type="submit">
	</td>
	</tr>
	</tbody>
</table>
</form>
