<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/****************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal
* @usage        
********************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
$formulario_buscar="buscar_grupo";
$ruta_grafico=$configuracion["host"].$configuracion["site"].$configuracion["grafico"];
$singleton = new patron_singleton;
$encriptar=$singleton->obtener_instancia("encriptar");
$enlace=$singleton->obtener_instancia("enlace",$configuracion);
?><table width=100% border=0 cellpadding="5" cellspacing=0>
<tr>
	<td width=100%>
	<img src="<?php echo $ruta_grafico?>/encabezado_grupo.png" alt="administraci&oacute;n de usuarios" title="administraci&oacute;n de usuarios" border="0" />
	</td>
</tr>
<tr>
	<td>
		<table>
		
			<tr class="bloquelateralcuerpo">
				<td width=100%>
					<a href="<?php
					$pagina="admin_grupo_investigacion";
					$variables["mostrar"]="lista";
					$variables["accion"]="1";
					$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
					echo $mi_enlace;
					?>"><img src="<?php echo $ruta_grafico ?>/ingenieria.png" id="ingenieria" usemap="#ingenieria" border="0" /></a>
				</td>
			</tr>
			<tr class="bloquelateralcuerpo">
				<td width=100%>
					<a href="<?php
					$variables["accion"]="2";
					$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
					echo $mi_enlace;
					?>"><img src="<?php echo $ruta_grafico ?>/medio.png" id="medio" usemap="#medio" border="0" /></a>
				</td>
			</tr>
			<tr class="bloquelateralcuerpo">
				<td width=100%>
					<a href="<?php
					$variables["accion"]="3";
					$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
					echo $mi_enlace;
					?>"><img src="<?php echo $ruta_grafico ?>/ciencias.png" id="ciencias" usemap="#ciencias" border="0" /></a>
				</td>
			</tr>
			<tr class="bloquelateralcuerpo">
				<td width=100%>
					<a href=""><img src="<?php echo $ruta_grafico ?>/asab.png" id="asab" usemap="#asab" border="0" /></a>
				</td>
			</tr>
			<tr class="bloquelateralcuerpo">
				<td width=100%>
					<a href=""><img src="<?php echo $ruta_grafico ?>/tecno.png" id="tecno" usemap="#tecno" border="0" /></a>
				</td>
			</tr>
			<tr>
				<td width=100%>
				<br>
				</td>
			</tr>
			<tr class="bloquelateralcuerpo">
				<td width=100%>
					<a href=""><img src="<?php echo $ruta_grafico ?>/colciencias.png" id="colciencias" usemap="#colciencias" border="0" /></a>
				</td>
			</tr>
			<tr class="bloquelateralcuerpo">
				<td width=100%>
					<a href=""><img src="<?php echo $ruta_grafico ?>/institucional.png" id="institucional" usemap="#institucional" border="0" /></a>
				</td>
			</tr>			
		</table>
	</td>
</tr>
<tr>
	<td width=100%>
	<img src="<?php echo $ruta_grafico?>/encabezado_buscar.png"  border="0" />
	</td>
</tr>
<tr>
	<td>
	<form action="index.php" method="GET" name="<?php echo $formulario_buscar?>">
		<table>
			<tr>	
				<td width=100% class="bloquelateralcuerpo">
					<input type="hidden" name="page" value="<?php echo enlace('admin_grupo') ?>">
					<input type="hidden" name= "accion" value="3">
					<input type=text name="busqueda" size=19> 
				</td>
			</tr>
			<tr>
				<td width=100% class="bloquelateralcuerpo">
					<div style="text-align: center;">
						<img  src="<?php echo $ruta_grafico ?>/boton_aceptar.png" alt="Aceptar" title="Aceptar" border="0" onclick="document.forms['<?php echo $formulario_buscar?>'].submit()"/>
					</div>
				</td>
			</tr>
		</table>
	</form>			
	</td>
</tr>
</table>
<map name="ingenieria">
<?php
	$pagina="acerca_investigacion";
	$variables="";
	$encriptar=$singleton->obtener_instancia("encriptar");
	$enlace=$singleton->obtener_instancia("enlace",$configuracion);
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
	
?><area shape="rect" coords="0,0,120,20" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('ingenieria','<?php echo $ruta_grafico ?>/ingenieria_on.png')" />
</map>
<map name="medio">
<?php
	$pagina="proyectos_investigacion";	
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
	
?><area shape="rect" coords="0,0,120,20" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('medio','<?php echo $ruta_grafico ?>/medio_on.png')" />
</map>
<map name="ciencias">
<?php
	$pagina="grupos_investigacion";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,120,20" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('ciencias','<?php echo $ruta_grafico ?>/ciencias_on.png')" />
</map>
<map name="asab">
<?php
	$pagina="noticias";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$variables["subsistema"]="investigacion";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,120,20" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('asab','<?php echo $ruta_grafico ?>/asab_on.png')" />
</map>
<map name="tecno">
<?php
	$pagina="noticias";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$variables["subsistema"]="investigacion";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,120,20" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('tecno','<?php echo $ruta_grafico ?>/tecno_on.png')" />
</map>
<map name="colciencias">
<?php
	$pagina="noticias";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$variables["subsistema"]="investigacion";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,120,20" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('colciencias','<?php echo $ruta_grafico ?>/colciencias_on.png')" />
</map>
<map name="institucional">
<?php
	$pagina="noticias";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$variables["subsistema"]="investigacion";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,120,20" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('institucional','<?php echo $ruta_grafico ?>/institucional_on.png')" />
</map>
