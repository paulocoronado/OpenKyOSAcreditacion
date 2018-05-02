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
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal
* @usage        
********************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
?><table width=100% border=0 cellpadding="5" cellspacing=0 class="bloquelateral">
<tr>
	<td width=100% class="bloquelateralencabezado">
	Administraci&oacute;n
	</td>
</tr>
<tr class="bloquelateralcuerpo">
	<td width=100%>
		<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_usuario').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/usuario.png" alt="administraci&oacute;n de usuarios" title="administraci&oacute;n de usuarios" border="0" /> Usuarios</a>
	</td>
</tr>
<tr class="bloquelateralcuerpo">
	<td width=100%>
		<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_grupos').'&accion=1&hoja=1&mostrar=lista'; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/usuarios.png" alt="administraci&oacute;n de grupos especiales de usuarios" title="administraci&oacute;n de usuarios" border="0" /> Grupos</a>
	</td>
</tr>
<tr class="bloquelateralcuerpo">
	<td width=100%>
		<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_criterio').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/proyectos.png" alt="criterios de evaluaci&oacute;n" title="criterios de evaluaci&oacute;n" border="0" /> Criterios de evaluaci&oacute;n</a>
	</td>
</tr>
<tr class="bloquelateralcuerpo">
	<td width=100%>
		<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_programa').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/programas.png" alt="programas acad&eacute;micos" title="programas acad&eacute;micos" border="0" /> Programas acad&eacute;micos</a>
	</td>
</tr>
<tr class="bloquelateralcuerpo">
	<td width=100%>
		<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('lote_clave').'&accion=1&hoja=0'; ?>"><img width="16" height="16" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/formulario.png" alt="programas acad&eacute;micos" title="programas acad&eacute;micos" border="0" /> Enviar Claves</a>
	</td>
</tr>
<tr class="bloquelateralcuerpo">
	<td width=100%>
		<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('informe_programa').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/biblio.png" alt="programas acad&eacute;micos" title="programas acad&eacute;micos" border="0" /> Informe por Programa</a>
	</td>
</tr>
<tr>
	<td width=100%>
	<br>
	</td>
</tr>
</table>
