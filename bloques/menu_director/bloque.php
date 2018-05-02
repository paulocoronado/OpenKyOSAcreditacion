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
  <thead style="font-family: Helvetica,Arial,sans-serif;"> <tr>
	<TD WIDTH=100% class="bloquelateralencabezado">
	Director
	</TD>
  </tr>
  </thead>
  <tbody>
		<?php  /* 
		<TR>
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('comite_modelo').'&accion=1'; ?>"><FONT SIZE=2><FONT FACE="helvetica">Modelos de Autoevaluaci&oacute;n</FONT></FONT></A>
			</TD>
		</TR>
		*/ ?>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('director_proceso').'&accion=1&hoja=0'; ?>">Administraci&oacute;n de procesos</A>
			</TD>
		</TR> 
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('director_analista').'&accion=1&hoja=0'; ?>">Analistas</A>
			</TD>
		</TR> 
		<TR>
			<TD WIDTH=100%>
			<BR>
			</TD>
		</TR>
	</tbody>	
	</TABLE>
