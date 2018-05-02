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
Copyright (C) 2001-2007

Última revisión 17 de septiembre de 2007

****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal
* @usage        
*****************************************************************************/

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");

// Rescatar el nombre de usuario desde los datos de sesion.

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	
	$pagina=$nueva_sesion->rescatar_valor_sesion($configuracion,"enlace_admin_informe");
}
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral2" >
	<TR>
		<TD WIDTH=100% class="bloquelateralcuerpo">
			<table>
			<tr>
			<td class="bloquelateralcuerpo" >
			<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?'.$pagina[0][0]; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/hogar.png" alt="Regresar" title="Regresar" border="0" /> Ir a subsistema</A>
			</td>
			</tr>
			</table>
		</TD>
	</TR>
	
</TABLE>
