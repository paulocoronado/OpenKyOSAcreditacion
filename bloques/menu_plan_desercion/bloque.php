<?php  
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?>
<?php  
/****************************************************************************************************************
  
bloque.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   menu_admin_convenio
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal de la seccion
* @usage        
*****************************************************************************************************************/
?><?php  include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
		<tr>
			<TD WIDTH=100% class="bloquelateralencabezado">
			<B>Deserci&oacute;n</B>
			</TD>
		</tr>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<BR><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_plan_desercion').'&accion=1'; ?>">Agregar registro</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<br>
			</TD>
		</TR>
		<TR class="bloquelateralencabezado">
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<b>Mostrar Estad&iacute;sticas</b>
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
				<input type="hidden" name= "accion" value="2">
				<input type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_plan_desercion') ?>">
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
					<TD WIDTH=100% class="bloquelateralcuerpo">
						<div style="text-align: center;">
							<br><input value="Buscar" name="aceptar" type="submit">
						</div>
					</TD>
				</TR>
            		</table>
            		</form>
            		</td>
            		</tr>
            		<TR>
			<TD WIDTH=100%>
			<br>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<BR>
			</TD>
		</TR>
	</TABLE>
