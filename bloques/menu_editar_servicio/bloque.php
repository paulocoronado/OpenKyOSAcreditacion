<?php  include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Informaci&oacute;n</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_info_servicio').'&registro='.$_GET['registro'].'&accion=1">
				              Agregar informaci&oacute;n del servicio</A>';	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<br>
			</TD>
		</TR>		
</TABLE>
