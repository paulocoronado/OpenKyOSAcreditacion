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
?><?php  
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
* @description  Menu registro
* @usage        
*****************************************************************************************************************/
?><?php  include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral" >
	<tr>
		<td>		
			<table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 >	
				<TR>
					<TD WIDTH=100% ALIGN=CENTER class="bloquelateralcuerpo">
						Si pertenece al <b>Comit&eacute; de Acreditaci&oacute;n</b> puede solicitar una cuenta para acceder al aplicativo:<br><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro').'&accion=1'; ?>">Registrarse ahora</A>
					</TD>
				</TR>
				<TR class="bloquelateralcuerpo">
					<TD WIDTH=100% ALIGN=CENTER>
						&iquest;Olvid&oacute; su clave?<br><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('recordar_clave').'&accion=1'; ?>">Recordar mi clave</A>
					</TD>
				</TR>
				<TR class="bloquelateralcuerpo" ALIGN=JUSTIFY>
					<TD WIDTH=100% >
						<b>Importante</b><br>Si desea diligenciar la encuesta de Autoevaluaci&oacute;n y no dispone de nombre de usuario por favor <b>NO SE REGISTRE</b>, solic&iacute;telo en la direcci&oacute;n de su programa.<br><br>
					</TD>
				</TR>
			</table>	
		</td>
	</tr>			
</TABLE>
