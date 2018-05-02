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
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_proy_proyecto').'&accion=1'; ?>">Todos los proyectos</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
			<BR>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registrar_proy_proyecto'); ?>">Agregar nuevo proyecto</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><BR>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<b>Mostrar Proyectos</b>
			</TD>
		</TR>
		<TR>
		<TD WIDTH=100% class="bloquelateralcuerpo">
				<form action="index.php" method="GET">
				<TABLE class="bloquelateralcuerpo">
				<tr class="bloquecentralcuerpo">
				<td>
				Del Programa:
				</td>
				</tr>
				<tr>
				<td>
				<input type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_proy_proyecto') ?>">
				<input type="hidden" name= "accion" value="2">
					<?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,1,0);
echo $mi_cuadro;
				?></td>
            		</tr>
				</TABLE>
				</FORM>
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
				<INPUT type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_proy_proyecto') ?>">
				<input type="hidden" name= "accion" value="3">
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
