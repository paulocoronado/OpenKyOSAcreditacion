<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
		<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Editar egresado</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET['usuario']))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_empleo_egresado').'&registro='.$_GET['registro'].'&accion=1&usuario='.$_GET['usuario'].'">Agregar informaci&oacute;n nivel de empleo</A>';	
				}
				else
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_empleo_egresado').'&registro='.$_POST['registro'].'&accion=1&usuario='.$_POST['usuario'].'">Agregar informaci&oacute;n nivel de empleo</A>';	
				}
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
</TABLE>
