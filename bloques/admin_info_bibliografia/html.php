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
			//Todos los recursos
			case '1':
				$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
				$cadena_sql.=" WHERE id_recurso= '".$_GET['registro']."'";
				$cadena_sql.=" ORDER BY anno";
				//echo $cadena_sql;
				break;
				
			//Filtrados por programa y anno	
			case '2':
				if($_GET["anno"]==0)
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
						$cadena_sql.=" WHERE id_recurso= '".$_GET['registro']."'";
						$cadena_sql.=" ORDER BY anno";
						//echo $cadena_sql;
						
					}
					else
					{
						$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa'];
						$cadena_sql.=" AND id_recurso= '".$_GET['registro']."'";
						$cadena_sql.=" ORDER BY anno";
					}
				}
				else
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
						$cadena_sql.=" WHERE anno=".$_GET['anno'];
						$cadena_sql.=" AND id_recurso= '".$_GET['registro']."'";
						$cadena_sql.=" ORDER BY anno";
					}
					else
					{
						$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa'];
						$cadena_sql.=" AND id_recurso= '".$_GET['registro']."'";
						$cadena_sql.=" AND anno=".$_GET['anno']." ORDER BY anno";
					
					}	
				
				}
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
					$buscar_nombre.="recurso like '%".$val."%' OR ";
				}
				
				$buscar_todo=substr($buscar_nombre,0,(strlen($buscar_nombre)-3)).")";
				//echo $buscar_todo;
				
				$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
				$cadena_sql.=" WHERE id_recurso= '".$_GET['registro']."'";
				$cadena_sql.=" AND ".$buscar_todo." ORDER BY anno";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
				$$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
				$cadena_sql.=" WHERE id_recurso= '".$_GET['registro']."'";
				$cadena_sql.=" ORDER BY anno";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT id_recurso,anno,semestre,id_programa";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
 		$cadena_sql.=" WHERE id_recurso= '".$_GET['registro']."'";
		$cadena_sql.=" ORDER BY anno";
		//echo $cadena_sql;
		
	}		
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
      <td >No hay informaci&oacute;n adicional del recurso.</td>
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
<td colspan="5">
Recursos Bibliogr&aacute;ficos
</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td >Programa</td>
<td>A&ntilde;o</td>
<td>Semestre</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			
			$busqueda="SELECT nombre_corto ";
			$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
			$busqueda.="WHERE id_programa=".$registro[$contador][3];
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
<td class="celdatabla"><?php  echo $registro[$contador][1] ?></td>
<td align="center" class="celdatabla"><?php  echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla">
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('agregar_info_bibliografia').'&edicion=1&registro='.$registro[$contador][0].'&anno='.$registro[$contador][1].'&semestre='.$registro[$contador][2].'&programa='.$registro[$contador][3]; ?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php 
$opciones=$configuracion["site"].'/index.php?page='.enlace('borrar_info_bibliografia');
$opciones.='&opcion=bibliografia_programa';
$opciones.='&registro='.$registro[$contador][0];
$opciones.='&anno='.$registro[$contador][1]; 
$opciones.='&semestre='.$registro[$contador][2]; 
$opciones.='&programa='.$registro[$contador][3]; 

echo $opciones;

?>">Borrar</A>
</td>	</tr><?php 		}
		}
?>
</table><br>
</form>
<?php 			
  }
}
