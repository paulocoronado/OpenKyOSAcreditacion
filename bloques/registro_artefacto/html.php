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
?><?php  
/****************************************************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 20 de noviembre de 2005

*******************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formualrio para el registro de usuarios
* @usage        
*****************************************************************************************************************/ 
?><?php  

$fecha=time();
$date=date('Y/m/d -H:i:s',$fecha);
// Rescatar el id_modelo desde la base de datos. Usando la función max
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{

//Rescatar la variable de sesion correspondiente al usuario actualmente registrado.	
	$sesion=new sesiones($configuracion);
	$sesion->especificar_enlace($enlace);
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"usuario");
	$editor_propietario=$propietario[0][0]; 
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	$id_usuario=$propietario[0][0]; 
	unset($propietario); 
	unset($acceso_db);
	unset($sesion);
	$tab=1;
	$id_artefacto=1;
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registro_artefacto" onsubmit="return (  control_vacio(this,'nombre') && verificar_rango(this,  'componentes',  1,15))">
<?php  /*Campos obligatorios para poder manejar desde un solo sitio todos los módulos*/?>
<input type="hidden" name= "action" value="registro_artefacto">
<input type="hidden" name="id_artefacto" value="<?php   echo $id_artefacto; ?>">
<table class="bloquelateral" width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody>
<tr class="bloquecentralencabezado">
<td>Creaci&oacute;n de Artefactos<br>
</td>
</tr>
<tr>
<td>
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
		Fecha de Creaci&oacute;n:<br>
	</td>
	<td class="celdatabla">
		<input name="fecha_creacion" value="<?php   echo $fecha ?>" type="hidden">	
		<?php   echo $date ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Nombre del Artefacto:
	</td>
	<td class="celdatabla">
	<input maxlength="150" size="50" tabindex="<?php   echo $tab++ ?>" name="nombre">
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Propietario:<br>
	</td>
	<td class="celdatabla">
	<input type="hidden" name="id_usuario" value="<?php   echo $id_usuario ?>">
	<?php   echo $editor_propietario ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Proyecto/Dependencia&nbsp; Responsable:<br>
	</td>
	<td class="celdatabla">
	<input maxlength="150" size="50" tabindex="<?php   echo $tab++ ?>" name="responsable">
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Descripci&oacute;n:<br>
	</td>
	<td class="celdatabla">
	<textarea cols="40" rows="6" name="descripcion" tabindex="<?php   echo $tab++ ?>"></textarea><br>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Presentaci&oacute;n:<br>
	</td>
	<td class="celdatabla">
	<textarea cols="40" rows="6" name="presentacion" tabindex="<?php   echo $tab++ ?>"></textarea>
	</td>
</tr>
</tbody>
</table>
<table style="width: 100%; text-align: left;" border="0" cellpadding="4" cellspacing="2">
		<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla" valign="top" align="left" colspan="6" rowspan="1">
	Tipo de Artefacto:<br>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla" valign="top" align="left">
	Encuesta <input name="tipo" value="1" type="radio">
	</td>
	<td class="celdatabla" valign="top" align="left">
	Taller <input name="tipo" value="2" type="radio">
	</td>
	<td class="celdatabla" valign="top" align="left">
	Entrevista <input name="tipo" value="3" type="radio">
	</td>
</tr>
<tr>
	<td colspan="3" rowspan="1">
	<hr style="width: 100%; height: 2px;">
	</td>
</tr>
<tr align="center">
<td colspan="3" rowspan="1">
<input name="aceptar" value="Aceptar" type="submit" tabindex="<?php   echo $tab++ ?>"><br>
</td>
</tr>
</tbody>
</table>
<br>
</td>
</tr>
</tbody>
</table>
</form>
<?php  

}
else
{
	echo "El sistema est&aacute; fuera de l&iacute;nea. Por favor reintente m&aacute;s tarde.";
}
?> 
