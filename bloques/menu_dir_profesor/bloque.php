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
  
index.php 

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
?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
		<tr>
			<TD WIDTH=100% class="bloquelateralencabezado">
			Profesores
			</TD>
		</tr>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
<?php  
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	$cadena_sql="SELECT nombre";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor WHERE id_programa=".$id_programa;
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
}	
?>		<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px">
		<tr align="center" class="bloquecentralcuerpo">
		<td><b><?php   echo $campos?></b> profesores del programa registrados.</td>
		</tr>	
		</table>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<br>
			</TD>
		</TR>
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
						<INPUT type="hidden" NAME="page" VALUE="<?php   echo enlace('admin_dir_profesor') ?>">
						<input type="hidden" name= "accion" value="3">
						<input type="hidden" name= "usuario" value="<?php   echo $_GET["usuario"] ?>">
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
