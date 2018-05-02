<?PHP  
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
?>
<script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_oficio'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td class="bloquelateralencabezado" colspan="2">
			T&iacute;tulo del formulario
		</td>
		
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Nombre:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='text' name='nombre' size='40' maxlength='255' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Fecha (dd/mm/aaaa):
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='text' name='fecha' size='15' maxlength='50' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<textarea name='descripcion' cols='40' rows='2' tabindex='<?PHP   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Remitente:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='text' name='remitente' size='40' maxlength='255' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Destinatario:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='text' name='destinatario' size='40' maxlength='255' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Consecutivo:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='text' name='consecutivo' size='4' maxlength='4' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_oficio'>
			<input name='aceptar' value='Aceptar' type='submit'><br>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</form>
