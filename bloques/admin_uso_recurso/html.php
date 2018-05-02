<?php  
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
	//
	
	$cadena_sql="SELECT id_programa ";
	$cadena_sql.="FROM ".$configuracion["prefijo"]."usuario_programa ";
	$cadena_sql.="WHERE id_usuario=".$_GET['usuario']." ";
	$cadena_sql.="LIMIT 1 ";
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		$id_programa=$registro[0][0];
		//echo $id_programa;
	}
	
	
	$cadena_sql="SELECT anno ";
	$cadena_sql.="FROM ".$configuracion["prefijo"]."uso_recurso ";
	$cadena_sql.="WHERE id_programa=".$id_programa." ";
	$cadena_sql.="GROUP BY anno ORDER BY anno ";
			
//	echo $cadena_sql;
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
      <td ><span  style="font-weight: bold;">Actualmente no hay estad&iacute;sticas de uso</span></td>
    </tr>
  </tbody>
</table>


<?php  

		
	}
	else
	{
/*Si existe estadisticas de uso en el sistema*/
?>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td >a&ntilde;o</td>
<td colspan="2">Opciones</td>
</tr>
	<?php  
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td align="center" class="celdatabla"><?php   echo $registro[$contador][0] ?></td>
<td align="center" class="celdatabla"><?php  //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('editar_uso_recurso').'&anno='.$registro[$contador][0].'&id_programa='.$id_programa.'&usuario='.$_GET['usuario']; ?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php  //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_uso_recurso').'&opcion=uso_recurso&id_programa='.$id_programa.'&anno='.$registro[$contador][0].'&usuario='.$_GET['usuario']; ?>">Borrar</A>
</td>	
</tr><?php  }?>
</table><br>
</form>
<?php  			
  }
}
