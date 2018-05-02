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
  
index.php 

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
* @description  Menu principal
* @usage        
*****************************************************************************************************************/
?><?php  
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
?><TABLE WIDTH=100% BORDER=0 CELLPADDING="5" CELLSPACING=0 class="bloquelateral">
<tr>
	<TD class="bloquelateralencabezado">
	Criterio
	</TD>
</tr>
<TR class="bloquelateralcuerpo">
	<TD>
		<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_criterio_edu').'&accion=1&hoja=0'; ?>">Agregar Criterio</A>
	</TD>
</TR>

<?php  
/*
<TR class="bloquelateralcuerpo">
	<TD WIDTH=100%>
		<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_programa').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/programas.png" alt="Administraci&oacute;n de Programas" title="Administraci&oacute;n de Programas" border="0" /> Programas</A>
	</TD>
</TR>
<TR class="bloquelateralcuerpo">
	<TD WIDTH=100%>
		<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dependencia').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/dependencias.png" alt="Administraci&oacute;n de Dependencias" title="Administraci&oacute;n de Dependencias" border="0" /> Dependencias</A>
	</TD>
</TR>
<TR class="bloquelateralcuerpo">
	<TD WIDTH=100%>
		<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_configuracion').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/configuracion.png" alt="Configuraci&oacute;n" title="Configuraci&oacute;n" border="0" /> Configuraci&oacute;n</A>
	</TD>
</TR>
<TR class="bloquelateralcuerpo">
	<TD WIDTH=100%>
		<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_backup').'&accion=1&hoja=0'; ?>"><img width="24" height="24" src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/backup.png" alt="Copia de seguridad" title="Copia de seguridad" border="0" /> Backup</A>
	</TD>
</TR>
*/?>
<TR>
	<TD WIDTH=100%>
	<BR>
	</TD>
</TR>
</TABLE>
