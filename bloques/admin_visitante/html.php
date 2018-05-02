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
	if(isset($_GET['accion']))
	{
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos los convenios
			case '1':
				$cadena_sql="SELECT ";
				$cadena_sql.="id_visitante, ";
				$cadena_sql.="anno, ";
				$cadena_sql.="nombre, ";
				$cadena_sql.="apellido ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_visitante ";
				$cadena_sql.=" WHERE id_programa=".$id_programa;	
				$cadena_sql.=" ORDER BY anno";
	
				break;
				
			//Proyectos por anno	
			case '2':
				$cadena_sql="SELECT ";
				$cadena_sql.="id_visitante, ";
				$cadena_sql.="anno, ";
				$cadena_sql.="nombre, ";
				$cadena_sql.="apellido ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_visitante ";
				$cadena_sql.=" WHERE id_programa=".$id_programa;	
				$cadena_sql.=" AND anno=".$_GET['anno'];
				$cadena_sql.=" ORDER BY anno,nombre ";
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
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_visitante, ";
				$cadena_sql.="anno, ";
				$cadena_sql.="nombre, ";
				$cadena_sql.="apellido ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_visitante ";
				$cadena_sql.=" WHERE ".$buscar_todo." AND id_programa=".$id_programa." ORDER BY anno,nombre";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT ";
				$cadena_sql.="id_visitante, ";
				$cadena_sql.="anno, ";
				$cadena_sql.="nombre, ";
				$cadena_sql.="apellido ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_visitante ";
				$cadena_sql.=" WHERE id_programa=".$id_programa;	
				$cadena_sql.=" ORDER BY anno";
	
				break;
				//echo $cadena_sql;
				
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT ";
		$cadena_sql.="id_visitante, ";
		$cadena_sql.="anno, ";
		$cadena_sql.="nombre, ";
		$cadena_sql.="apellido ";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_visitante ";
		$cadena_sql.=" WHERE id_programa=".$id_programa;	
		$cadena_sql.=" ORDER BY anno";

				
		//echo $cadena_sql;
		
	}		
	
	
			

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
      <td >No hay informaci&oacute;n sobre visitantes de otras instituciones.</td>
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
<td colspan="4">Visitantes de otras instituciones:</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td >A&ntilde;o</td>
<td>Visitante</td>
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
<td align="center" class="celdatabla"><?php   echo $registro[$contador][2]." ".$registro[$contador][3] ?></td>
<td align="center" class="celdatabla"><?php  //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_dir_visitante').'&id_visitante='.$registro[$contador][0].'&usuario='.$_GET['usuario']; ?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php  //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_visitante').'&opcion=dir_visitante&registro='.$registro[$contador][0].'&usuario='.$_GET['usuario'].'&nombre='.$registro[$contador][2].' '.$registro[$contador][3].'&anno='.$registro[$contador][1]; ?>">Borrar</A>
</td>	
</tr><?php  }?>
</table><br>
</form>
<?php  			
  }
}
