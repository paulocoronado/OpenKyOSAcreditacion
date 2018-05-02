<?php  

//La variable $_GET['usuario'] contiene el npmbre del programa que esta editando la información...
// puede tomarse esa informacion desde la variable de sesion correspondiente TODO


if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	
	exit;		
	}


?>
<script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php  
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	$cadena_sql="SELECT nombre, apellido, identificacion";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor WHERE id_programa=".$id_programa." ORDER BY apellido, nombre ";
	//echo $cadena_sql;
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen usuarios profesors en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay profesores del programa registrados en el sistema</td>
    </tr>
    </tbody>
</table>
<?php  

		
	}
	else
	{
	
		$cadena_sql="SELECT identificacion";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."proyecto_profesor WHERE id_proyecto=".$_GET['registro'];
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro_2=$acceso_db->obtener_registro_db();
		$campos_2=$acceso_db->obtener_conteo_db();
		/*Si existen usuarios en el sistema*/
?><form action="index.php" method="POST" >
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="bloquecentralcuerpo">
<td colspan="3" rowspan="1" align="center">
<input type="hidden" name="action" value="admin_proyecto_profesor">
<input type="hidden" name="registro" value="<?php   echo $_GET['registro'] ?>">
<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
<?php  if($campos>40)
{?>
<input value="Aceptar" name="aceptar" type="submit"><br><?php  
}
?>
</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td >Profesor</td>
<?php   //<td>Correo</td> ?>
<td>Identificaci&oacute;n</td>
<td>Asociado</td>
</tr>
	<?php  
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#000000', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php   echo $registro[$contador][0]." ". $registro[$contador][1] ?></td>
<?php   /*<td class="celdatabla"><?php   echo $registro[$contador][2] ?></td>*/?>
<td align="center" class="celdatabla"><?php   echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla"><?php  
			
			$seleccion=0;
			for($contador_2=0;$contador_2<$campos_2;$contador_2++)
			{	
				if($registro[$contador][2]==$registro_2[$contador_2][0])
				{
					$seleccion=1;
					break;
				}

			}
			if($seleccion==0)
			{
				echo '<input tabindex="'.$contador.'" name="'.$contador.'" value="'.$registro[$contador][2].'" type="checkbox">';

			}
			else
			{
				echo '<input checked="checked" tabindex="'.$contador.'" name="'.$contador.'" value="'.$registro[$contador][2].'" type="checkbox">';
			}
			?>
</td>
</tr>
<?php  			
  }
?><tr align="center" class="bloquecentralcuerpo">
<td colspan="3" rowspan="1" align="center">
<input value="Aceptar" name="aceptar" type="submit"><br>
</td>
</tr><?php  }?>
</table><br>
</form>
<?php  
}
?>
