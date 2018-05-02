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
<script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	if(isset($_GET['accion']))
	{
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos los profesores
			case '1':
				$cadena_sql="SELECT ";
				$cadena_sql.=$configuracion["prefijo"]."profesor.nombre, ";
				$cadena_sql.=$configuracion["prefijo"]."profesor.apellido, ";
				$cadena_sql.=$configuracion["prefijo"]."profesor.identificacion ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$configuracion["prefijo"]."profesor, ";
				$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion ";
				$cadena_sql.="WHERE ";
				$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.id_programa=".$id_programa." ";
				$cadena_sql.="ORDER BY ";
				$cadena_sql.=$configuracion["prefijo"]."profesor.nombre ";
				//echo $cadena_sql;
				break;
			//Filtrados por cuadros de texto	
			case '2':
				$cadena_sql="SELECT nombre,apellido,identificacion,id_programa ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor "; 
				$cadena_sql.=" WHERE id_programa=".$_GET['id_programa']." ORDER BY nombre, identificacion ";
				//echo $cadena_sql;
				break;	
			
			//Filtrado
			case '3':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='(';
				$buscar_apellido='';
				$buscar_identificacion='';
				
				while (list ($clave, $val) = each ($buscar)) {
					$buscar_nombre.="nombre like '%".$val."%' OR ";
					$buscar_apellido.="apellido like '%".$val."%' OR ";
					$buscar_identificacion.="identificacion like '%".$val."%' OR ";
				}
				
				$buscar_todo=$buscar_nombre.$buscar_apellido.substr($buscar_identificacion,0,(strlen($buscar_identificacion)-3)).")";
				//echo $buscar_todo;
				
				$cadena_sql="SELECT nombre,apellido,identificacion,id_programa ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor "; 
				$cadena_sql.=" WHERE ".$buscar_todo." AND id_programa=".$id_programa." ORDER BY nombre, identificacion ";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT nombre, apellido, identificacion";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor WHERE id_programa=".$id_programa." ORDER BY apellido, nombre ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT nombre, apellido, identificacion";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor WHERE id_programa=".$id_programa." ORDER BY apellido, nombre ";
		//echo $cadena_sql;
	}		
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
      <td >Actualmente no hay profesores del programa registrados en el sistema</td>
    </tr>
    </tbody>
</table>


<?php

		
	}
	else
	{
/*Si existen usuarios en el sistema*/
?>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td >Profesor</td>
<?php //<td>Correo</td> ?>
<td>Identificaci&oacute;n</td>
<td>Opciones</td>
</tr>
	<?php
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php echo $registro[$contador][0]." ". $registro[$contador][1] ?></td>
<?php /*<td class="celdatabla"><?php echo $registro[$contador][2] ?></td>*/?>
<td align="center" class="celdatabla"><?php echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla">
<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('editar_dir_profesor').'&informacion=1&usuario='.$_GET['usuario'].'&registro='.$registro[$contador][2]; ?>">Informaci&oacute;n</a>
</td>
</tr><?php}?>
</table><br>
</form>
<?php			
  }
}
