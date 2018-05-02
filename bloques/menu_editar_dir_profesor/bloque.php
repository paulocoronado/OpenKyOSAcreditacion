<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Informaci&oacute;n Profesor</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_tiempo_dedicacion').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar tiempo de dedicaci&oacute;n</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_tiempo_dedicacion').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar tiempo de dedicaci&oacute;n</A>';	
				
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_dir_participacion').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar participaci&oacute;n en eventos</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_dir_participacion').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar participaci&oacute;n en eventos</A>';	
				
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_visita').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar visitas a otras instituciones</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_visita').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar visitas a otras instituciones</A>';	
				
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_asignatura').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar asignaturas a cargo</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_asignatura').'&usuario='.$_GET['usuario'].'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar asignaturas a cargo</A>';	
				
				}
	
			?></TD>
		</TR>
		
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
</TABLE>
