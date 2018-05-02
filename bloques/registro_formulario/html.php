<?PHP  
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?PHP  
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
* @description  Formualrio para el registro de usuarios
* @usage        
*****************************************************************************************************************/ 
?><?PHP  

$fecha=time();
$date=date('Y/m/d -H:i:s',$fecha);
// Rescatar el id_modelo desde la base de datos. Usando la función max
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$id_formulario=1;		
	//Rescatar la variable de sesion correspondiente al usuario actualmente registrado.	
	$sesion=new sesiones($configuracion);
	$sesion->especificar_enlace($enlace);
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	$editor_propietario=$propietario[0][0]; 
	unset($propietario); 
	unset($acceso_db);
	unset($sesion);
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript">
</script>
<form method="post" action="index.php" name="crear_formulario" onsubmit="return (  control_vacio(this,'nombre') && control_vacio(this,'presentacion'))">
<table class="bloquelateral" style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1">
	<tbody>
	<tr class="bloquelateralencabezado">
		<td  colspan="2" rowspan="1">
		Formulario para la creaci&oacute;n de Instrumentos de Autoevaluaci&oacute;n<br>
		<input type="hidden" name= "action" value="registro_formulario">
		</td>
	</tr>
	<tr class="bloquelateralcuerpo">
		<td class="celdatabla" valign="top">Nombre del Instrumento: 
		<input type="hidden" name="id_formulario" value="<?PHP   echo $id_formulario; ?>"><br>
		<input type="hidden" name="fecha_creacion" value="<?PHP   echo $fecha;?>" >
		</td>
		<td class="celdatabla">
		<input maxlength="255" size="50" name="nombre"> </td>
	</tr>
	<tr class="bloquelateralcuerpo">
		<td class="celdatabla" valign="top">Etiqueta: 
		</td>
		<td class="celdatabla">
		<input maxlength="150" size="50" name="etiqueta"><br>Nombre breve que se usar&aacute; en los enlaces si es necesario.</td>
	</tr>
	<tr class="bloquelateralcuerpo">
		<td class="celdatabla" valign="top">Entidad Responsable:<br>
		<input type="hidden" name="editor_propietario" value="<?PHP   echo $editor_propietario;?>"> 
		</td>
		<td class="celdatabla">
		<input maxlength="150" size="50" name="entidad_responsable" > </td>
	</tr>
	<tr class="bloquelateralcuerpo">
		<td class="celdatabla" valign="top">Presentaci&oacute;n General:<br>
		</td>
		<td class="celdatabla">
		<textarea cols="45" rows="6" name="presentacion"></textarea><br>
		</td>
	</tr>
	<tr class="bloquelateralcuerpo">
		<td class="celdatabla" valign="top">Comentario:<br>
		</td>
		<td class="celdatabla">
		<textarea cols="45" rows="6" name="comentario"></textarea>
		</td>
	</tr>
	<tr align="center">
		<td colspan="2" rowspan="1">
			<input name="aceptar" value="Aceptar" type="submit"><br>
		</td>
	</tr>
	</tbody>
</table>
</form>
<?PHP  

}
else
{
	"IMPOSIBLE PROCESAR LA P&Aacute;GINA";	
	exit;
}

?>
