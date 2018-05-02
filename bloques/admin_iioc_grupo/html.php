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
		
	if(isset($_GET['accion']))
	{
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos los grupos de investigacion
			case '1':
				$cadena_sql="SELECT id_grupo,nombre,id_programa";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion ORDER BY nombre ";
				//echo $cadena_sql;
				break;
				
			//Grupos de investigacion por programa y anno	
			case '2':
				if($_GET["anno"]==0)
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_grupo,nombre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion ";
						$cadena_sql.=" ORDER BY nombre ";
						//echo $cadena_sql;
					}
					else
					{
						$cadena_sql="SELECT id_grupo,nombre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa'];
						$cadena_sql.=" ORDER BY nombre ";
					}
				}
				else
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_grupo,nombre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion ";
						$cadena_sql.=" WHERE anno=".$_GET['anno'];
						$cadena_sql.=" ORDER BY nombre ";
					}
					else
					{
						$cadena_sql="SELECT id_grupo,nombre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa'];
						$cadena_sql.=" AND anno=".$_GET['anno']." ORDER BY nombre ";
					
					}	
				
				}
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
				
				$cadena_sql="SELECT id_grupo,nombre,id_programa";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion ";
				$cadena_sql.=" WHERE ".$buscar_todo." ORDER BY nombre";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT id_grupo,nombre,id_programa";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion  ORDER BY nombre ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT id_grupo,nombre,id_programa";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."grupo_investigacion ORDER BY nombre ";
		//echo $cadena_sql;
		
	}		
//	echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen usuarios convenios en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay grupos de investigaci&oacute;n registrados en el sistema</td>
    </tr>
    </tbody>
</table>


<?php 

		
	}
	else
	{
/*Si existen convenios en el sistema*/
?>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td>Programa</td>
<?php  //<td>Correo</td> ?>
<td>Grupo</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			$busqueda="SELECT nombre_corto ";
			$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
			$busqueda.="WHERE id_programa=".$registro[$contador][2];
			$busqueda.=" ORDER BY nombre_corto LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$programa=$acceso_db->obtener_registro_db();
			$total_programas=$acceso_db->obtener_conteo_db();
			if($total_programas>0)
			{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php  echo $programa[0][0] ?></td>
<td align="left" class="celdatabla"><?php  echo $registro[$contador][1] ?></td>
<td align="center" class="celdatabla">
<a href="<?php 

$opciones=$configuracion["site"].'/index.php?page='.enlace('registro_iioc_grupo');
$opciones.='&registro='.$registro[$contador][0];

echo $opciones;

?>">Editar</a>
</td>
<td align="center" class="celdatabla">
<a href="<?php 

$opciones=$configuracion["site"].'/index.php?page='.enlace('borrar_iioc_grupo');
$opciones.='&opcion=iioc_grupo';
$opciones.='&registro='.$registro[$contador][0]; 
$opciones.='&nombre='.$registro[$contador][1]; 
echo $opciones;

?>">Borrar</a> 
</td>
</tr><?php }
}
?>
</table><br>
</form>
<?php 			
  }
}
