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
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$cadena_hoja="SELECT ";
	$cadena_hoja.="count(usuario) ";
	$cadena_hoja.="FROM ".$configuracion["prefijo"]."registrado "; 
	$cadena_hoja.="WHERE estado=1 ";
	$acceso_db->registro_db($cadena_hoja,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		$activo=$registro[0][0];
		//echo $hoja;
	}
	else
	{
		$activo=0;
	
	}
	$cadena_hoja="SELECT ";
	$cadena_hoja.="count(usuario) ";
	$cadena_hoja.="FROM ".$configuracion["prefijo"]."registrado "; 
	$cadena_hoja.="WHERE estado=0 ";
	$acceso_db->registro_db($cadena_hoja,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		$inactivo=$registro[0][0];
		//echo $hoja;
	}
	else
	{
		$inactivo=0;
	
	}
}
else
{
	$activo=0;
	$inactivo=0;

}
	$todo=$activo+$inactivo;
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD class="bloquelateralencabezado">
				<B>Mostrar</B>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_usuario').'&accion=1&hoja=0'; ?>">Todos los usuarios <b>(<?echo $todo ?>)</b></A>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_usuario').'&accion=2&hoja=0'; ?>">Usuarios activos <b>(<?echo $activo ?>)</b></A>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_usuario').'&accion=3&hoja=0'; ?>">Usuarios inactivos <b>(<?echo $inactivo ?>)</b></A>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
			<BR>
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_admin_usuario').'&admin=true'; ?>"><B>Agregar Usuario</B></A>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<BR>
			</TD>
		</TR>
		<TR class="bloquelateralencabezado">
			<TD WIDTH=100% >
				<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/buscar.png"  border="0" /><B> Buscar Usuario</B>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<FORM NAME="Standard" ACTION="index.php" METHOD="GET">
			<TD WIDTH=100%>
				<INPUT type="hidden" NAME="page" VALUE="<?php echo enlace('admin_usuario') ?>">
				<input type="hidden" name= "accion" value="4">
				<input type="hidden" name= "hoja" value="0">
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
