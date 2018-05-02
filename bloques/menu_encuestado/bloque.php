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
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
  <thead> <tr>
	<TD WIDTH=100% class="bloquelateralencabezado">
	Instrumento
	</TD>
  </tr>
  </thead>
  <tbody>
  <TR>
		<td class="bloquelateralcuerpo">
		<BR>
	</TD>
	</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('instrumento'); ?>">Diligenciar el instrumento.</A>
			</TD>
		</TR>
		<TR>
		<td class="bloquelateralcuerpo">
		<BR>
	</TD>
	</TR>
	</tbody>	
</TABLE>
