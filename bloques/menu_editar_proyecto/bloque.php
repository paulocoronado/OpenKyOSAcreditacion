<?php  $acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Informaci&oacute;n Profesor</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				$cadena_sql="SELECT id_proyecto ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."proyecto_profesor ";
				$cadena_sql.="WHERE id_proyecto=".$_GET['registro'];
				$acceso_db->registro_db($cadena_sql,0);
				$registro=$acceso_db->obtener_registro_db();
				$campos=$acceso_db->obtener_conteo_db();
				echo "<b>".$campos."</b> profesores asociados al proyecto.";
				
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_profesor_proyecto').'&usuario='.$_GET['usuario'].'&registro='.$_GET['registro'].'&accion=1">
				              Asociar profesores al proyecto</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_profesor_proyecto').'&usuario='.$_GET['usuario'].'&registro='.$_GET['identificacion'].'&accion=1">
				              Asociar profesores al proyecto</A>';	
				
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
</TABLE><?php  
}
?>
