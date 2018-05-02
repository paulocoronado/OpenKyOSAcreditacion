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

/*
OJO!!!!!!!!!!!!!! Este es el menu de la seccion de administracion hay que programar cada una de las acciones...
es decir, hay que desarrollar las subsecciones



*/
?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
		<tr>
			<TD WIDTH=100% class="bloquelateralencabezado">
			<B>Documentos</B>
			</TD>
		</tr>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_iioc_doc_programa').'&accion=1'; ?>">Agregar documento</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_iioc_presupuesto').'&accion=1'; ?>">Agregar informaci&oacute;n de presupuesto</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<br>
			</TD>
		</TR>
		
	</TABLE>
