<?php 
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		
		$el_usuario=$registro[0][0];
	}
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$id_usuario=$registro[0][0];
	}
		


	if(isset($_GET['accion']))
	{
		switch($_GET['accion'])
		{	
			//Todos los documentos
			case '1':
				$cadena_sql="SELECT id_documento,nombre, id_tecnica, id_naturaleza ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."documento ";
				$cadena_sql.="WHERE id_usuario=".$id_usuario." ";
				$cadena_sql.="ORDER BY nombre,id_documento ";
				//echo $cadena_sql;
				break;
			//Filtrados por cuadros de texto	
			case '2':
				$cadena_sql="SELECT id_documento,nombre, id_tecnica, id_naturaleza ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."documento "; 
				$cadena_sql.="WHERE id_documento=".$_GET['id_documento']." ";
				$cadena_sql.="AND id_usuario=".$id_usuario." ";
				$cadena_sql.="ORDER BY nombre";
				//echo $cadena_sql;
				break;	
			
			//Filtrado
			case '3':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='';
				$buscar_resumen='';
				
				
				while (list ($clave, $val) = each ($buscar)) 
				{
					$buscar_nombre.="".$configuracion["prefijo"]."documento.nombre like '%".$val."%' OR ";
					$buscar_resumen.="".$configuracion["prefijo"]."documento.resumen like '%".$val."%' OR ";
				}
				
				$buscar_todo=$buscar_nombre.substr($buscar_resumen,0,(strlen($buscar_resumen)-3));
				//echo $buscar_todo;
				
				$cadena_sql="SELECT id_documento,nombre, id_tecnica, id_naturaleza ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."documento ";
				$cadena_sql.="WHERE ".$buscar_todo." ";
				$cadena_sql.="AND id_usuario=".$id_usuario." ";
				$cadena_sql.="ORDER BY nombre";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT id_documento,nombre, id_tecnica, id_naturaleza ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."documento ";
				$cadena_sql.="WHERE id_usuario=".$id_usuario." ";
				$cadena_sql.="ORDER BY nombre,id_documento ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT id_documento,nombre, id_tecnica, id_naturaleza ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."documento ";
		$cadena_sql.="WHERE id_usuario=".$id_usuario." ";
		$cadena_sql.="ORDER BY nombre,id_documento ";

		//echo $cadena_sql;
	}		
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen usuarios documentos en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="10" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td ><span  style="font-weight: bold;">Actualmente no hay documentos
registrados en el sistema</span></td>
    </tr>
    <tr align="justify" class="bloquecentralcuerpo">
      <td >El procedimiento para evaluar las fuentes documentales requieren los siguientes pasos:<br><BR>
<B>Paso 1.</B>  Recolectar los documentos que dan cuenta de la caracter&iacute;stica y el indicador por cada Factor CNA, seg&uacute;n se expresa en la gu&iacute;a entregada por el Comit&eacute; de Acreditaci&oacute;n Institucional.<br><BR>  
<B>Paso 2.</B> Clasificar la informaci&oacute;n seg&uacute;n este instructivo en norma, informe, etc.<br><BR>
<B>Paso 3.</B> Hacer un listado de los documentos encontrados y de aquellos que es necesario formular.  En caso de que en la b&uacute;squeda no se encuentre alg&uacute;n documento, el Grupo de Autoevaluaci&oacute;n del Programa debe proceder a formular el respectivo documento de forma clara y precisa y oportuna.<br><BR>
<B>Paso 4.</B>  Valorar el respectivo documento seg&uacute;n la matriz E.D correspondiente<br><BR>
La matriz  de evaluaci&oacute;n documental ED, se&ntilde;ala los criterios, evidencias esenciales seg&uacute;n criterio, la escala cualitativa, una columna de puntaje y una de observaciones.  La escala propuesta es de tipo cualitativo: CUMPLE O NO CUMPLE, sin embargo, para coincidir con el modelo de autoevaluaci&oacute;n se asimilar&aacute;  a un PUNTAJE dependiendo de los hallazgos del evaluador.</td>
    </tr>
  </tbody>
</table>


<?php 

		
	}
	else
	{
/*Si existen documentos en el sistema*/
?><script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td >Documento</td>
<td>Naturaleza</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php 

$opciones="&registro=".$registro[$contador][0];
$opciones.="&accion=1";
$opciones.="&hoja=0";


?>
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('editar_documento').$opciones; ?>" title="Editar el registro"><?php  echo $registro[$contador][1]?></a>
</td><?php 
//Rescatar el tipo de documento segun naturaleza
$cadena_sql="SELECT nombre";
$cadena_sql.=" FROM ".$configuracion["prefijo"]."tipo_documento ";
$cadena_sql.=" WHERE id_tipo_documento=".$registro[$contador][3]." ORDER BY nombre ASC";
//echo $cadena_sql;
$acceso_db->registro_db($cadena_sql,0);
$registro_2=$acceso_db->obtener_registro_db();
$campos_2=$acceso_db->obtener_conteo_db();
if($campos_2>0)
{
	$tecnica=$registro_2[0][0];
}
else
{
	$tecnica="N/D";
}
?>
<td class="celdatabla"><?php  echo $tecnica ?></td>
<td align="center" class="celdatabla"><?php 

$opciones="&registro=".$registro[$contador][0];
$opciones.="&accion=1";
$opciones.="&hoja=0";
$opciones.="&mostrar=1";

?><a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_evaluacion_documental').$opciones; ?>" title="Evaluaci&oacute;n del documento">Evaluaci&oacute;n</a>
</td>
<td align="center" class="celdatabla"><?php //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php 

$opciones=$configuracion["site"].'/index.php?page='.enlace('borrar_documento');
$opciones.='&opcion=documento';
$opciones.='&registro='.$registro[$contador][0];
$opciones.='&nombre='.$registro[$contador][1];
$opciones.="&accion=1";
$opciones.="&hoja=0";
echo $opciones;

 ?>">Borrar</A>
</td>	
</tr><?php }?>
</table><br>
</form>
<?php 			
  }
}
