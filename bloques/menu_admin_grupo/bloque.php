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
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2007

Última revisión 28 de Mayo de 2006

*******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal
* @usage        
*********************************************************************************/

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");


?>
<table width=100% border=0 cellpadding=5 cellspacing=0 class="bloquelateral">
		<tr>
			<td width=100% class="bloquelateralencabezado">
			<b>Grupos</b>
			</td>
		</tr>
		<tr>
			<td width=100% class="bloquelateralcuerpo">
				<br><a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_grupo').'&accion=1'; ?>">Agregar grupo</a>
			</td>
		</tr>
		<tr>
			<td width=100% class="bloquelateralcuerpo">
				<hr class="hr_division">
			</td>
		</tr>
		<tr>
			<td width=100% class="bloquecentralcuerpo">
			<img width="16" height="16" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/buscar.png" alt="Buscar grupo" title="Buscar grupo" border="0" /><span class="texto_color"> Buscar grupo</span>
			</td>
		</tr>
		<tr>
			<td>
				<form action="index.php" method="get">
				<table>
				<tr>	
					<td width=100% class="bloquelateralcuerpo">
						<input type="hidden" name="page" value="<?php echo enlace('admin_grupos') ?>">
						<input type="hidden" name= "accion" value="2">
						<input type="hidden" name= "mostrar" value="lista">
						<input type=text name="busqueda" size=19> 
					</td>
				</tr>
				<tr>
					<td width=100% class="bloquelateralcuerpo">
						<div style="text-align: center;">
							<br><input value="buscar" name="aceptar" type="submit">
						</div>
					</td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td width=100%>
			<br>
			</td>
		</tr>
	</table>
