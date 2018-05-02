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
	if(isset($_GET['accion']))
	{
		switch($_GET['accion'])
		{	
			//Todos los profesores
			case '1':
				$cadena_sql="SELECT nombre, apellido, identificacion";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor ORDER BY apellido, nombre ";
				//echo $cadena_sql;
				break;
			//Filtrados por cuadros de texto	
			case '2':
				$cadena_sql="SELECT ".$configuracion["prefijo"]."profesor.nombre,".$configuracion["prefijo"]."profesor.apellido,".$configuracion["prefijo"]."profesor.identificacion,".$configuracion["prefijo"]."profesor.id_programa ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor "; 
				$cadena_sql.=" WHERE id_programa=".$_GET['programa']." ORDER BY nombre, identificacion ";
				//echo $cadena_sql;
				break;	
			
			//Filtrado
			case '3':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='';
				$buscar_apellido='';
				$buscar_identificacion='';
				
				while (list ($clave, $val) = each ($buscar)) {
					$buscar_nombre.="".$configuracion["prefijo"]."profesor.nombre like '%".$val."%' OR ";
					$buscar_apellido.="".$configuracion["prefijo"]."profesor.apellido like '%".$val."%' OR ";
					$buscar_identificacion.="".$configuracion["prefijo"]."profesor.identificacion like '%".$val."%' OR ";
				}
				
				$buscar_todo=$buscar_nombre.$buscar_apellido.substr($buscar_identificacion,0,(strlen($buscar_identificacion)-3));
				//echo $buscar_todo;
				
				$cadena_sql="SELECT ".$configuracion["prefijo"]."profesor.nombre,".$configuracion["prefijo"]."profesor.apellido,".$configuracion["prefijo"]."profesor.identificacion,".$configuracion["prefijo"]."profesor.id_programa ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor "; 
				$cadena_sql.=" WHERE ".$buscar_todo."ORDER BY nombre, identificacion ";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT nombre, apellido, identificacion";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor ORDER BY apellido, nombre ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT nombre, apellido, identificacion";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor ORDER BY apellido, nombre ";
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
      <td ><span  style="font-weight: bold;">Actualmente no hay profesores
registrados en el sistema</span></td>
    </tr>
    <tr align="justify" class="bloquecentralcuerpo">
      <td >El registro de los docentes de cada uno de los programas junto con los datos relativos a sus
evaluaciones, reconocimientos, t&iacute;tulos, categor&iacute;a, dedicaci&oacute;n; entre otros es de vital
importancia para poder determinar claramente el cumplimiento de algunos indicadores de Alta Calidad en los programas.<br>      <br>
Por favor ingrese los datos correspondientes a cada docente para estructurar los informes necesarios para realizar an&aacute;lisis
reales. Los datos que usted ingrese en esta secci&oacute;n le ayur&aacute;n al Comit&eacute; de Acreditaci&oacute;n, los
programas y a la instituci&oacute;n en general en su proceso de autoevaluaci&oacute;n y mejoramiento continuo. </td>
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
<?php   //<td>Correo</td> ?>
<td>Identificaci&oacute;n</td>
<td colspan="2">Opciones</td>
</tr>
	<?php  
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php   echo $registro[$contador][0]." ". $registro[$contador][1] ?></td>
<?php   /*<td class="celdatabla"><?php   echo $registro[$contador][2] ?></td>*/?>
<td align="center" class="celdatabla"><?php   echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla"><?php  //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('editar_profesor').'&registro='.$registro[$contador][2]; ?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php  //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_profesor').'&opcion=profesor&registro='.$registro[$contador][2]; ?>">Borrar</A>
</td>	
</tr><?php  }?>
</table><br>
</form>
<?php  			
  }
}
