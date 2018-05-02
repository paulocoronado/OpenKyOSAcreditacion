<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php
/*************************************************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

**************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal
* @usage        
*************************************************************************************************************/
?><?php

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}


include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");


$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		
		$el_usuario=$registro[0][0];
	}
}


?><table width="100%" border="0" cellpadding="5" celspacing="0" class="bloquelateral">
 	<tr>
		<td width="100%" class="bloquelateralencabezado">
		Ponderaci&oacute;n
		</td>
  	</tr>
	<tr>
		<td width="100%" class="bloquelateralcuerpo">
			<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('comite_registro_esquema').'&accion=1'; ?>">Agregar Esquema</A>
		</td>
	</tr>
	<tr>
		<td class="bloquelateralcuerpo">
		<br>
		</td>
	</tr>		
</table>
<br>
<form action="index.php" method="GET">		
<table width="100%" border="0" cellpadding="5" celspacing="0" class="bloquelateral">
	<tr>
		<td width="100%" class="bloquelateralencabezado">
			<input type="hidden" name="page" VALUE="<?php echo enlace('comite_esquema_ponderacion') ?>">
			<input type="hidden" name= "accion" value="2">
			<input type="hidden" name= "hoja" value="0">
			<img width="16" height="16" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/buscar.png" alt="Buscar" border="0" />
			Buscar esquemas
		</td>
	</tr>		
	<tr>
		<td class="bloquelateralcuerpo">
			Cuyo nombre contiene:
		</td>
	</tr>
	<tr align="center">
		<td class="bloquelateralcuerpo">
			<INPUT TYPE=TEXT NAME="busqueda" SIZE=19> 
		</td>
	<tr>
		<td width="100%" ALIGN=CENTER>				
			<INPUT TYPE=SUBMIT NAME="aceptar" VALUE="buscar">				
		</td>
	</tr>
</table>
</form>
