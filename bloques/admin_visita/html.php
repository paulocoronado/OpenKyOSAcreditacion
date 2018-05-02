<?php  
if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	
	exit;		
}
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	

?>
<script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php  
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	if(isset($_GET['registro']))
	{
		//Rescatar datos anuales, con nombre de programa y nombre del tipo de vinculacion
		$cadena_sql="SELECT ";
		$cadena_sql.="id_visita, ";
		$cadena_sql.="anno, ";
		$cadena_sql.="institucion ";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor_info_visita ";
		$cadena_sql.=" WHERE identificacion='".$_GET['registro']."' AND id_programa=".$id_programa;	
		$cadena_sql.=" ORDER BY anno";
		//	0 id_profesor_evento
		//	1 anno
		//	2.institucion
		//echo $cadena_sql;
		
	}
	else
	{
		
		echo "Imposible determinar el registro de b&uacute;squeda.";	

	}		
//	echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existe informacion anual del profesor en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >No hay informaci&oacute;n sobre visitas a otras instituciones.</td>
    </tr>
    </tbody>
</table>


<?php  

		
	}
	else
	{
/*Si existe informacion anual del profesor - se muestran n registros con los datos mas relevantes*/
?>
<form method="post" action="index.php" name="activar_usuario">
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td colspan="4">Visitas realizadas a otras instituciones:</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td >A&ntilde;o</td>
<td>Instituci&oacute;n</td>
<td colspan="2">Opciones</td>
</tr>
	<?php  
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<?php  /*Campos ocultos para dar continuidad al formulario actual*/?>
<input type="hidden" name= "identificacion" value="<?php  echo $_GET["registro"] ?>">
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td align="center" class="celdatabla"><?php   echo $registro[$contador][1] ?></td>
<td align="center" class="celdatabla"><?php   echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla"><?php  //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('agregar_visita').'&id_visita='.$registro[$contador][0].'&usuario='.$_GET['usuario'].'&registro='.$_GET['registro']; ?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php  //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_visita').'&opcion=info_visita&id_visita='.$registro[$contador][0].'&usuario='.$_GET['usuario'].'&nombre='.$registro[$contador][2].'&anno='.$registro[$contador][1].'&registro='.$_GET['registro']; ?>">Borrar</A>
</td>	
</tr><?php  }?>
</table><br>
</form>
<?php  			
  }
}
