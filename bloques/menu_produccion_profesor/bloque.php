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
  
bloque.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   menu_admin_convenio
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal de la seccion
* @usage        
*****************************************************************************************************************/
?><?php  include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
	<tr>
		<TD WIDTH=100% class="bloquelateralencabezado">
		<B>Producci&oacute;n</B>
		</TD>
	</tr>
	<TR>
		<TD WIDTH=100% class="bloquelateralcuerpo">
			<BR><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_info_produccion').'&registro='.$_GET['registro'].'&accion=1'; ?>">Agregar registro</A>
		</TD>
	</TR>
	<TR>
		<TD WIDTH=100%>
		<BR>
		</TD>
	</TR>
</TABLE>
