<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Informaci&oacute;n</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('agregar_info_bibliografia').'&registro='.$_GET['registro'].'&accion=1">
				              Agregar informaci&oacute;n del recurso</A>';	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
		<TR class="bloquelateralencabezado">
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<b>Mostrar Recursos</b>
			</TD>
		</TR>
		<TR>
		<TD WIDTH=100% class="bloquelateralcuerpo">
				<form action="index.php" method="GET">
				<TABLE class="bloquelateralcuerpo" width="100%" >
				<TR class="bloquecentralcuerpo">
					<TD >
						Del a&ntilde;o:						
					</TD>
				</TR>
				<TR>
				<TD>
				<?php  
				$contador=0;
				echo "<select name='anno' size='1'>\n";
				echo "<option value='0'> </option>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					echo "<option value='".$anno."'>".$anno."</option>\n";
					
				}
				echo "</select>\n";
			?></TD>
				</TR>
				<tr class="bloquecentralcuerpo">
				<td>
				<br>Del Programa:
				</td>
				</tr>
				<tr>
				<td>
					<?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,0,0);
echo $mi_cuadro;
				?></td>
            		</tr>
            		<TR>
			<TD WIDTH=100% ALIGN=CENTER>
				<input type="hidden" NAME="page" VALUE="<?php   echo enlace('editar_recurso_bibliografico') ?>">
				<input type="hidden" name= "accion" value="2">	
				<input type="hidden" name= "registro" value="<?php   echo $_GET['registro']?>">	
				<br><input TYPE=SUBMIT NAME="aceptar" VALUE="Mostrar">
				
			</TD>
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
			Buscar Recurso
			</TD>
		</TR>
		<TR>
			<TD>
				<form action="index.php" method="GET">
				<TABLE >
				<TR>	
					<TD WIDTH=100% class="bloquelateralcuerpo">
						<input type="hidden" NAME="page" VALUE="<?php   echo enlace('editar_recurso_bibliografico') ?>">
						<input type="hidden" name= "registro" value="<?php   echo $_GET['registro']?>">	
						<input type="hidden" name= "accion" value="3">
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
</TABLE>
