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
* @name          html.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   
* @package	instalar
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* @description  Formulario para el ingreso de los parámetros básicos de configuración del SIAUD; en un archivo de
*               inclusión por si solo no tiene uso. Codigo HTML para el formulario
*
*****************************************************************************************************************/
?>

<?php  
if(!isset($id_pagina))
{
	$raiz="./../../../";
	include_once($raiz."incluir/error_ilegal.php");
	exit;		
	}
?>
<script src="<?php   echo $raiz.$configuracion["javascript"] ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_usuario"
onsubmit="return ( control_vacio(this,'db_dns') && control_vacio(this,'db_nombre') && control_vacio(this,'db_usuario') && control_vacio(this,'db_clave') && control_vacio(this,'administrador') && control_vacio(this,'clave') && control_vacio(this,'clave_2') && comparar_contenido(this,'clave','clave_2') && longitud_cadena(this,'clave',3) && longitud_cadena(this,'administrador',3) && verificar_correo(this,'correo',6))">
<table style="width: 650px;" align="center" border="0" cellpadding="2"
cellspacing="5">
<tbody>
<tr>
<td>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2"
cellspacing="5">
<tbody>
<tr style="background-image: url(grafico/bgtable.jpg); background-color: rgb(239, 239, 239);">
<td colspan="2" rowspan="1" align="undefined" valign="undefined">Configuraci&oacute;n para la Base de Datos:</td>
</tr>
<tr>
<td style="background-color: rgb(241, 241, 241);">DBMS:<br>
</td>
<td style="background-color: rgb(241, 241, 241);">
<select name="db_dbms">
<option value="1">MySQL 3.x</option>
</select>
<br>
</td>
</tr>
<tr>
<td style="text-align: left; background-color: rgb(241, 241, 241);">Hostname
del DBMS:<br>
</td>
<td style="background-color: rgb(241, 241, 241);" colspan="1"
rowspan="1"><input maxlength="80" size="40" tabindex="1" name="db_dns"><br>
</td>
</tr>
<tr>
<td style="background-color: rgb(241, 241, 241);">Nombre de la Base de Datos:<br>
</td>
<td colspan="1" rowspan="1" style="background-color: rgb(241, 241, 241);">
<input maxlength="80" size="40" tabindex="2" name="db_nombre"> </td>
</tr>
<tr>
<td style="background-color: rgb(241, 241, 241);"
align="undefined" valign="undefined">Usuario:<br>
</td>
<td style="background-color: rgb(241, 241, 241);"
align="undefined" valign="undefined"><input maxlength="80" size="40"
tabindex="3" name="db_usuario"> </td>
</tr>
<tr>
<td style="background-color: rgb(241, 241, 241);">Clave:<br>
</td>
<td style="background-color: rgb(241, 241, 241);"><input
maxlength="80" size="40" tabindex="4" name="db_clave" type="password"></td>
</tr>
</tbody>
</table>
<div style="text-align: left;"><br>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2"
cellspacing="5">
<tbody>
<tr style="background-image: url(grafico/bgtable.jpg); background-color: rgb(239, 239, 239);">
<td style="width: 371px;"
colspan="2" rowspan="1" align="undefined" valign="undefined">Configuraci&oacute;n del sitio web:</td>
</tr>
<tr>
<td style="background-color: rgb(241, 241, 241); width: 236px;">DOCUMENT_ROOT:<br>
</td>
<td style="background-color: rgb(241, 241, 241); width: 371px;">
<input value="<?php   echo $_SERVER["DOCUMENT_ROOT"] ?>" maxlength="80" size="40" tabindex="5" name="raiz"
</td>
</tr>
<tr>
<td
style="text-align: left; background-color: rgb(241, 241, 241); width: 236px;">Host:
(ej: http://misitio.com)<br>
</td>
<td style="background-color: rgb(241, 241, 241); width: 371px;"
colspan="1" rowspan="1"><input maxlength="80" size="40" tabindex="6"
name="host"><br>
</td>
</tr>
<tr>
<td style="background-color: rgb(241, 241, 241); width: 236px;">Ruta
del
sitio: (ej:/misitio)<br>
</td>
<td colspan="1" rowspan="1"
style="background-color: rgb(241, 241, 241); width: 371px;"><input
maxlength="80" size="40" tabindex="7" name="site"> </td>
</tr>
</tbody>
</table>
<br>
</div>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2"
cellspacing="5">
<tbody>
<tr style="background-image: url(grafico/bgtable.jpg); background-color: rgb(239, 239, 239);">
<td colspan="2" rowspan="1" align="undefined" valign="undefined">Datos para la administraci&oacute;n:</td>
</tr>
<tr>
<td style="width: 216px; background-color: rgb(241, 241, 241);">Nombre
de
administrador:<br>
</td>
<td style="width: 336px; background-color: rgb(241, 241, 241);"><input
maxlength="50" size="30" tabindex="8" name="administrador"> </td>
</tr>
<tr>
<td style="width: 216px; background-color: rgb(241, 241, 241);">Clave
de
administrador: </td>
<td style="width: 336px; background-color: rgb(241, 241, 241);"><input
maxlength="50" size="30" tabindex="9" name="clave" type="password"> </td>
</tr>
<tr>
<td style="width: 216px; background-color: rgb(241, 241, 241);">Reescriba
la clave:<br>
</td>
<td style="width: 336px; background-color: rgb(241, 241, 241);"><input
maxlength="50" size="30" tabindex="10" name="clave_2" type="password">
</td>
</tr>
<tr>
<td style="width: 216px; background-color: rgb(241, 241, 241);">Correo
Electr&oacute;nico de Administrador:<br>
</td>
<td style="width: 336px; background-color: rgb(241, 241, 241);"> <input
maxlength="50" size="30" tabindex="11" name="correo"></td>
</tr>
<tr align="center">
<td colspan="2" rowspan="1" valign="undefined"><input
value="aceptar" name="<?php   echo $id_pagina ?>" type="submit"><br>
</td>
</tr>
</tbody>
</table>
</form>
