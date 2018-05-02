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
			<B>Actividades</B>
			</TD>
		</tr>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_dir_actividad').'&usuario='.$_GET['usuario'].'&accion=1'; ?>">Agregar registro</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<br>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<b>Mostrar Actividades</b>
			</TD>
		</TR>
		<TR>
		<TD WIDTH=100% class="bloquelateralcuerpo">
				<form action="index.php" method="GET">
				<TABLE class="bloquelateralcuerpo">
				<TR>
					<TD>
						Del a&ntilde;o:
						<input type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_dir_actividad') ?>">
						<input type="hidden" name= "accion" value="2">
						<input type="hidden" name= "usuario" value="<?php   echo $_GET['usuario'] ?>">
					</TD>
				</TR>
				<TR>
				<TD width="100%" align="center" class="bloquelateralcuerpo"><?php  
				$contador=0;
				echo "<select name='anno' size='1' onchange='this.form.submit()'>\n";
				echo "<option value='0'> </option>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					echo "<option value='".$anno."'>".$anno."</option>\n";
					
				}
				echo "</select>\n";
			?></TD>
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
			Buscar Actividad
			</TD>
		</TR>
		<TR>
			<TD>
				<form action="index.php" method="GET">
				<TABLE >
				<TR>	
					<TD WIDTH=100% class="bloquelateralcuerpo">
						<input type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_dir_actividad') ?>">
						<input type="hidden" name= "accion" value="3">
						<input type="hidden" name= "usuario" value="<?php   echo $_GET['usuario'] ?>">
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
