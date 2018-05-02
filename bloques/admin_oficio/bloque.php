<?php  
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
?><?php  
$cadena_sql="SELECT ";
$cadena_sql.="`id`, ";
$cadena_sql.="`nombre`, ";
$cadena_sql.="`fecha`, ";
$cadena_sql.="`descripcion`, ";
$cadena_sql.="`remitente`, ";
$cadena_sql.="`destinatario`, ";
$cadena_sql.="`consecutivo` ";
$cadena_sql.="FROM ";
$cadena_sql.="oficio "; 

//Crear una instancia de la clase dbms
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{	
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		?>
		<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
		
		<?php  
		
		for($a=0;$a<$campos;$a++)
		{
			?>
			<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[$a][0] ?>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[$a][1] ?>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[$a][2] ?>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[$a][3] ?>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[$a][4] ?>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[$a][5] ?>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[$a][6] ?>
		</td>
	</tr>
			<?php  
		
		
		}
	?>
	</table>
</td>
</tr>
</table>

	
	<?php  	
	}
	else
	{
	 echo "En la actualidad no se encuentra ning&uacute;n registro en el sistema.";
	}

}


?>
