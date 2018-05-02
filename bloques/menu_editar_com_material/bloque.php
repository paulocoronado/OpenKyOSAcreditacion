<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Informaci&oacute;n del Material</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_com_utilizacion').'&registro='.$_GET['registro'].'&accion=1'.'&id_material='.$_GET['id_material'].'">Agregar informaci&oacute;n sobre uso del material</A>';	
				
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_com_reconocimiento').'&registro='.$_GET['registro'].'&accion=1'.'&id_material='.$_GET['id_material'].'">Agregar informaci&oacute;n sobre reconocimientos</A>';	
			?></TD>
		</TR>		
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
</TABLE>
