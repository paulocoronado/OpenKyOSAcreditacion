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
$formulario="autenticacion";
$validar="control_vacio(".$formulario.",'usuario')";
$validar.="&& control_vacio(".$formulario.",'clave')";

?><form method="post" action="index.php" name="<?echo $formulario?>">
<table cellpadding=0 border=0 cellspacing=0>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-0.png" width="200" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-1.png" width="196" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-2.png" width="21" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-3.png" width="99" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-4.png" width="27" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-5.png" width="47" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-6.png" width="27" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-7.png" width="61" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-8.png" width="27" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-9.png" width="54" height="10"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-0-10.png" width="41" height="10"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-0.png" width="200" height="34"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-1.png" width="196" height="34"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-2.png" width="21" height="34"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-3.png" width="99" height="34"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-4.png" width="27" height="34"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-5.png" width="47" height="34"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-6.png" width="27" height="34"></td>
		<td rowspan="2" colspan="2" class="login_celda1">
			<table align="center" border="0" cellpadding="0" cellspacing="4">
				<tr>
					<td>
					<input  class="cuadro_login" maxlength="30" size="9" tabindex="1" name="usuario" >
					</td>
				</tr>
				<tr>
					<td>
					<input class="cuadro_login" maxlength="60" size="9" tabindex="1" name="clave" type="password" onkeyup="if(enter(event)){return(<?php echo $validar; ?>)? document.forms['<?php echo $formulario?>'].submit():false}">
					<input type="hidden" name="action" value="principal_cidc">
					</td>
				</tr>
			</table>
		</td>		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-9.png" width="54" height="34"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-1-10.png" width="41" height="34"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-0.png" width="200" height="31"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-1.png" width="196" height="31"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-2.png" width="21" height="31"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-3.png" width="99" height="31"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-4.png" width="27" height="31"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-5.png" width="47" height="31"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-6.png" width="27" height="31"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-9.png" width="54" height="31" usemap="#ingresar" id="enlace_1" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-2-10.png" width="41" height="31"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-0.png" width="200" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-1.png" width="196" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-2.png" width="21" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-3.png" width="99" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-4.png" width="27" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-5.png" width="47" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-6.png" width="27" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-7.png" width="61" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-8.png" width="27" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-9.png" width="54" height="92"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-3-10.png" width="41" height="92"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-0.png" width="200" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-1.png" width="196" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-2.png" width="21" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-3.png" width="99" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-4.png" width="27" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-5.png" width="47" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-6.png" width="27" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-7.png" width="61" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-8.png" width="27" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-9.png" width="54" height="103"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-4-10.png" width="41" height="103"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-0.png" width="200" height="22"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-1.png" width="196" height="22"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-2.png" width="21" height="22"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-3.png" width="99" height="22" usemap="#acerca" id="enlace_2" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-4.png" width="27" height="22"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-5.png" width="47" height="22" usemap="#grupo" id="enlace_3" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-6.png" width="27" height="22"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-7.png" width="61" height="22" usemap="#proyecto" id="enlace_4" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-8.png" width="27" height="22"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-9.png" width="54" height="22" usemap="#noticia" id="enlace_5" border="0"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-5-10.png" width="41" height="22"></td>
	</tr>
	<tr>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-0.png" width="200" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-1.png" width="196" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-2.png" width="21" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-3.png" width="99" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-4.png" width="27" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-5.png" width="47" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-6.png" width="27" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-7.png" width="61" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-8.png" width="27" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-9.png" width="54" height="62"></td>
		<td><img alt=" " src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/cidc-6-10.png" width="41" height="62"></td>
	</tr>
</table>
</form>
<map name="ingresar">
<?php
$evento="return(".$validar.")? document.forms['".$formulario."'].submit():false;";
?><area shape="rect" coords="12,6,61,28" onclick="<?php echo $evento ?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_1','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/enlace-1.png')" />
</map>
<map name="acerca">
<?php
	$pagina="acerca_investigacion";
	$variables="";
	$encriptar=$singleton->obtener_instancia("encriptar");
	$enlace=$singleton->obtener_instancia("enlace",$configuracion);
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
	
?><area shape="rect" coords="0,0,118,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_2','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/enlace-2.png')" />
</map>
<map name="proyecto">
<?php
	$pagina="proyectos_investigacion";	
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);
	
?><area shape="rect" coords="0,0,80,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_4','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/enlace-4.png')" />
</map>
<map name="grupo">
<?php
	$pagina="grupos_investigacion";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,65,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_3','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/enlace-3.png')" />
</map>
<map name="noticia">
<?php
	$pagina="noticias";
	$variables["mostrar"]="lista";
	$variables["accion"]="1";
	$variables["subsistema"]="investigacion";
	$mi_enlace=$enlace->crear_enlace($pagina,$variables,$encriptar);	
	
?><area shape="rect" coords="0,0,71,25" href="<?php echo $mi_enlace?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('enlace_5','<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/enlace-5.png')" />
</map>
