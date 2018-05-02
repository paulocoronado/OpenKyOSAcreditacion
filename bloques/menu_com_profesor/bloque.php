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
  
menu_com_profesor.bloque.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal
* @usage        
*****************************************************************************************************************/
?><?php  include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{ ?>	
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
	<tr>
		<TD WIDTH=100% class="bloquelateralencabezado">
		Profesores
		</TD>
	</tr>
	<tr class="bloquecentralcuerpo">
		<td>
		<form action="index.php" method="GET">
			<TABLE class="bloquelateralcuerpo" width="100%">
			<TR>
				<td>
				Mostrar solo el programa:
				</td>
			</tr>
			<tr>
			<td><?php  
				include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
				$html=new html();
				
				$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
				$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,1,0);
				echo $mi_cuadro;
			?></td>
			</tr>
			</table>
			<input type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_com_profesor') ?>">
			<input type="hidden" NAME="accion" VALUE="2">
		</form>
		</td>
	</tr>		
	<TR>
		<TD WIDTH=100% class="bloquelateralencabezado">
		Buscar Profesor
		</TD>
	</TR>
	<TR>
		<TD>
			<form action="index.php" method="GET">
			<TABLE>
			<TR>	
				<TD WIDTH=100% class="bloquelateralcuerpo">
				<INPUT type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_com_profesor') ?>">
				<input type="hidden" name= "accion" value="3">
				<INPUT TYPE=TEXT NAME="busqueda" SIZE=19> 
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
	<TR>
		<TD WIDTH=100%>
		<BR>
		</TD>
	</TR>
</TABLE>
<?php  
}
?>	
