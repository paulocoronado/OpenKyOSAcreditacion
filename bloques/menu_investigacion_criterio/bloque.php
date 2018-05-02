<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Editar Profesor</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_info_anual').'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar informaci&oacute;n anual</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_info_anual').'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar informaci&oacute;n anual</A>';	
				
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_participacion').'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar participaci&oacute;n</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_participacion').'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar participaci&oacute;n</A>';	
				
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_reconocimiento').'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar reconocimiento</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_reconocimiento').'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar reconocimiento</A>';	
				
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_eval_profesor').'&identificacion='.$_GET['registro'].'&accion=1">
				              Agregar resultado evaluaci&oacute;n</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_eval_profesor').'&identificacion='.$_GET['identificacion'].'&accion=1">
				              Agregar resultado evaluaci&oacute;n</A>';	
				
				}
	
			?></TD>
		</TR>
		
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
</TABLE>
