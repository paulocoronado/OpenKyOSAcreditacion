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
			<B>Recursos</B>
			</TD>
		</tr>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_recurso_bibliografico').'&accion=1'; ?>">Agregar registro</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<br>
			</TD>
		</TR>
		<TR class="bloquelateralencabezado">
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<b>Mostrar Recursos</b>
			</TD>
		</TR>
		<TR>
		<TD WIDTH=100% class="bloquelateralcuerpo">
				<form action="index.php" method="GET">
				<TABLE class="bloquelateralcuerpo" width="100%" >
				<TR class="bloquecentralcuerpo">
					<TD >
						Del Tipo:						
					</TD>
				</TR>
				<TR>
				<td>
				<input type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_recurso_bibliografico') ?>">
				<input type="hidden" name= "accion" value="2">	
					<?php  
						echo "<select name='tipo' size='1' tabindex='2' onchange='this.form.submit()'>\n";
						echo "<option value='0'> </option>\n";
						echo "<option value='1'>Revista</option>\n";
						echo "<option value='2'>Base de Datos</option>\n";
						echo "<option value='3'>Otro tipo</option>\n";
						echo "</select>\n";
					?>		
					</td>
				</TR>
            		</TABLE>
				</FORM>
			</TD>
		<TR>
			<TD WIDTH=100%>
			<br>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralencabezado">
			Buscar Recurso
			</TD>
		</TR>
		<TR>
			<TD>
				<form action="index.php" method="GET">
				<TABLE >
				<TR>	
					<TD WIDTH=100% class="bloquelateralcuerpo">
						<input type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_recurso_bibliografico') ?>">
						<input type="hidden" name= "accion" value="3">
						<input TYPE=TEXT NAME="busqueda" SIZE=19> 
					</TD>
				</TR>
				<TR>
					<TD WIDTH=100% class="bloquelateralcuerpo">
						<div style="text-align: center;">
							<br><input value="Buscar" name="aceptar" type="submit">
						</div>
					</TD>
				</TR>
				</TABLE>
				</form>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<BR>
			</TD>
		</TR>
	</TABLE>
