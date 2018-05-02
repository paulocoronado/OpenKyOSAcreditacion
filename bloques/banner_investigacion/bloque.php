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

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
$singleton = new patron_singleton;
?><table cellpadding=0 border=0 cellspacing=0>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-0.png" width="173" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-1.png" width="150" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-2.png" width="106" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-3.png" width="32" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-4.png" width="59" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-5.png" width="31" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-6.png" width="70" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-7.png" width="35" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-8.png" width="59" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-9.png" width="16" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-10.png" width="55" height="67"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-0-11.png" width="14" height="67"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-0.png" width="173" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-1.png" width="150" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-2.png" width="106" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-3.png" width="32" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-4.png" width="59" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-5.png" width="31" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-6.png" width="70" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-7.png" width="35" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-8.png" width="59" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-9.png" width="16" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-10.png" width="55" height="53"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-1-11.png" width="14" height="53"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-0.png" width="173" height="24"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-1.png" width="150" height="24"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-2.png" width="106" height="24" usemap="#acerca" id="enlace_1" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-3.png" width="32" height="24"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-4.png" width="59" height="24" usemap="#grupo" id="enlace_2" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-5.png" width="31" height="24"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-6.png" width="70" height="24" usemap="#proyecto" id="enlace_3" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-7.png" width="35" height="24"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-8.png" width="59" height="24" usemap="#noticia" id="enlace_4" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-9.png" width="16" height="24"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-10.png" width="55" height="24"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/bloque-2-11.png" width="14" height="24"></td>
	</tr>
</table>
<map name="acerca">
<?php
	$pagina="acerca_investigacion";
	$variables="";
	$encriptar=$singleton->obtener_instancia("encriptar");
	$enlace=$singleton->obtener_instancia("enlace",$configuracion);
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
	
?><area shape="rect" coords="0,0,118,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_1','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/enlace_1.png')" />
</map>
<map name="proyecto">
<?php
	$pagina="proyectos_investigacion";	
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
	
?><area shape="rect" coords="0,0,80,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_3','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/enlace_3.png')" />
</map>
<map name="grupo">
<?php
	$pagina="grupos_investigacion";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,65,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_2','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/enlace_2.png')" />
</map>
<map name="noticia">
<?php
	$pagina="noticias";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$variables["subsistema"]="investigacion";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,71,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_4','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/banner_investigacion/" ?>imagen/enlace_4.png')" />
</map>
