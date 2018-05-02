<?php  
/*
El modulo se maneja a partir de la variable accion que determina lo que debe hacer:
accion 1: Mostrar todos los usuarios
accion 2: Mostrar usuarios activos
accion 3: Mostrar usuarios inactivos
accion 4: Agregar un nuevo usuario manualmente
accion 5: Borrar un usuario
accion 6: Editar un usuario

*/
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				Proyectos
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_proyecto').'&accion=1&usuario='.$_GET['usuario']; ?>">Todos los proyectos</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_proyecto').'&accion=2&usuario='.$_GET['usuario']; ?>">Proyectos en desarrollo</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_proyecto').'&accion=3&usuario='.$_GET['usuario']; ?>">Proyectos terminados</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
			<BR>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('agregar_dir_proyecto').'&usuario='.$_GET['usuario']; ?>">Agregar nuevo proyecto</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><BR>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralencabezado">
				Buscar Proyecto
			</TD>
		</TR>
		<TR>
			<FORM NAME="Standard" ACTION="index.php" METHOD="GET">
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<INPUT type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_dir_proyecto') ?>">
				<input type="hidden" name= "accion" value="4">
				<input type="hidden" name= "usuario" value="<?php   echo $_GET["usuario"]?>">
				<INPUT TYPE=TEXT NAME="busqueda" SIZE=19> 
			</TD>
			<TR>
			<TD WIDTH=100% ALIGN=CENTER>
				
				<INPUT TYPE=SUBMIT NAME="aceptar" VALUE="buscar">
				
			</TD>
			</TR>
			</FORM>
		</TR>
</TABLE>
