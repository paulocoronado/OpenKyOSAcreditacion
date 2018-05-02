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
	
	if(isset($_GET['accion']))
	{
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos los recursos
			case '1':
				$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ORDER BY anno, recurso ";
				//echo $cadena_sql;
				break;
				
			//Filtrados por programa y anno	
			case '2':
				if($_GET["anno"]==0)
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ORDER BY anno, recurso ";
						//echo $cadena_sql;
						
					}
					else
					{
						$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa']." ORDER BY anno, recurso ";
					}
				}
				else
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ";
						$cadena_sql.=" WHERE anno=".$_GET['anno']." ORDER BY anno, recurso ";
					}
					else
					{
						$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa'];
						$cadena_sql.=" AND anno=".$_GET['anno']." ORDER BY anno, recurso ";
					
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
				
				$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ";
				$cadena_sql.=" WHERE ".$buscar_todo." ORDER BY anno, recurso ";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ORDER BY anno, recurso ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT id_recurso,recurso,id_programa,anno";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ORDER BY anno, recurso ";
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
      <td >Actualmente no hay recursos inform&aacute;ticos registrados en el sistema</td>
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
Recursos Inform&aacute;ticos
</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td >Programa</td>
<td>Recurso</td>
<td>A&ntilde;o</td>
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
<td class="celdatabla"><?php   echo $programa[0][0] ?></td>
<td class="celdatabla"><?php   echo $registro[$contador][1] ?></td>
<td align="center" class="celdatabla"><?php   echo $registro[$contador][3] ?></td>
<td align="center" class="celdatabla"><?php  //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_recurso_informatico').'&registro='.$registro[$contador][0]; ?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php  //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_recurso_informatico').'&opcion=recurso_informatico&registro='.$registro[$contador][0].'&nombre='.$registro[$contador][1]; ?>">Borrar</A>
</td>	</tr><?php  		}
		}
?>
</table><br>
</form>
<?php  			
  }
}
