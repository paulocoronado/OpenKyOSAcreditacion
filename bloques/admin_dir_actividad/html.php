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
<script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
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
			//Todos los actividades
			case '1':
				$cadena_sql="SELECT id_actividad,nombre, anno";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_actividad WHERE id_programa=".$id_programa." ORDER BY anno,nombre ";
				//echo $cadena_sql;
				break;
				
			//Actividades de un anno especifico
			case '2':
				$cadena_sql="SELECT id_actividad,nombre, anno";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_actividad WHERE id_programa=".$id_programa." AND anno=".$_GET['anno']." ORDER BY anno,nombre ";
				//echo $cadena_sql;
				break;	
				
			//Filtrados
			case '3':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='(';
				$buscar_apellido='';
				$buscar_identificacion='';
				
				while (list ($clave, $val) = each ($buscar)) {
					$buscar_nombre.="nombre like '%".$val."%' ";
				}
				
				$buscar_todo=$buscar_nombre.$buscar_apellido.substr($buscar_identificacion,0,(strlen($buscar_identificacion)-3)).")";
				//echo $buscar_todo;
				
				$cadena_sql="SELECT id_actividad,nombre, anno ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."dir_actividad ";
				$cadena_sql.=" WHERE ".$buscar_todo." AND id_programa=".$id_programa." ORDER BY anno,nombre";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT id_actividad,nombre, anno";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_actividad WHERE id_programa=".$id_programa." ORDER BY anno,nombre ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT id_actividad,nombre, anno";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_actividad WHERE id_programa=".$id_programa." ORDER BY anno,nombre ";
		//echo $cadena_sql;
		
	}		
//	echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen usuarios actividads en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay actividades del programa registrados en el sistema</td>
    </tr>
    </tbody>
</table>


<?php 

		
	}
	else
	{
/*Si existen actividads en el sistema*/
?>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td>A&ntilde;o</td>
<?php  //<td>Correo</td> ?>
<td>Actividad</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php  echo $registro[$contador][2] ?></td>
<td align="left" class="celdatabla"><?php  echo $registro[$contador][1] ?></td>
<td align="center" class="celdatabla">
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_dir_actividad').'&usuario='.$_GET['usuario'].'&registro='.$registro[$contador][0]; ?>">Editar</a>
</td>
<td align="center" class="celdatabla">
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_dir_actividad').'&opcion=dir_actividad&usuario='.$_GET['usuario'].'&registro='.$registro[$contador][0]; ?>">Borrar</a> 
</td>
</tr><?php }?>
</table><br>
</form>
<?php 			
  }
}
