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
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
  <thead style="font-family: Helvetica,Arial,sans-serif;"> 
  <tr>
	<TD WIDTH=100% class="bloquelateralencabezado">
	<B>Evaluaci&oacute;n</B>
	</TD>
  </tr>
  </thead>
  <tbody>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_recurso_bibliografico').'&accion=1'; ?>">Informaci&oacute;n de recursos bibliogr&aacute;ficos</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<BR>
			</TD>
		</TR>
 </tbody>	
</TABLE>
