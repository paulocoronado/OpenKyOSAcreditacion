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
?><?php  include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=7 CELLSPACING=0 class="bloquelateral">
		<tr>
			<TD WIDTH=100% class="bloquelateralencabezado">
			Material
			</TD>
		</tr>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><a href="<?php  
				
				$opciones=$configuracion["site"].'/index.php?page='.enlace('registro_com_material');
				$opciones.='&accion=1'; 
				$opciones.='&registro='.$_GET['registro'];
				
				echo $opciones;
				
				?>">Agregar Material</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR>
			</TD>
		</TR>
</TABLE>
