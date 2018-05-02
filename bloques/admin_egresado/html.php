<?php 
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
		if(isset($_GET['ir_hoja']))
		{
			$_GET["hoja"]=($_GET['ir_hoja']-1);
			unset($_GET['ir_hoja']);
		}
		
		
		$variable="";
		//Envia todos los datos que vienen con GET
		reset ($_GET);
		while (list ($clave, $val) = each ($_GET)) 
		{
			
			if($clave!='page')
			{
				$variable.="&".$clave."=".$val;
				//echo $clave;
			}
		}
		switch($_GET['accion'])
		{	
			//Todos los egresadoes
			case '1':
				$cadena_hoja="SELECT ";
				$cadena_hoja.=" nombre,";
				$cadena_hoja.=" apellido, ";
				$cadena_hoja.="identificacion";
				$cadena_hoja.=" FROM ";
				$cadena_hoja.=$configuracion["prefijo"]."egresado ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="id_programa=";
				$cadena_hoja.=$id_programa;
				$cadena_hoja.=" ORDER BY apellido, nombre ";			
				//echo $cadena_sql;
				
				$cadena_sql="SELECT ";
				$cadena_sql.=" nombre,";
				$cadena_sql.=" apellido, ";
				$cadena_sql.="identificacion";
				$cadena_sql.=" FROM ";
				$cadena_sql.=$configuracion["prefijo"]."egresado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_programa=";
				$cadena_sql.=$id_programa;
				$cadena_sql.=" ORDER BY apellido, nombre ";
				$cadena_sql.="LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];			
				//echo $cadena_sql;
				break;
				
				
			//Filtrados por cuadros de texto	
			case '2':
				$cadena_hoja="SELECT ";
				$cadena_hoja.=" nombre,";
				$cadena_hoja.=" apellido, ";
				$cadena_hoja.="identificacion";
				$cadena_hoja.=" FROM ";
				$cadena_hoja.=$configuracion["prefijo"]."egresado ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="id_programa=";
				$cadena_hoja.=$id_programa;
				$cadena_hoja.=" ORDER BY apellido, nombre ";			
				//echo $cadena_sql;
				
				$cadena_sql="SELECT ";
				$cadena_sql.=" nombre,";
				$cadena_sql.=" apellido, ";
				$cadena_sql.="identificacion";
				$cadena_sql.=" FROM ";
				$cadena_sql.=$configuracion["prefijo"]."egresado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_programa=";
				$cadena_sql.=$id_programa;
				$cadena_sql.=" ORDER BY apellido, nombre ";
				$cadena_sql.="LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];			
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
					$buscar_nombre.="".$configuracion["prefijo"]."egresado.nombre like '%".$val."%' OR ";
					$buscar_apellido.="".$configuracion["prefijo"]."egresado.apellido like '%".$val."%' OR ";
					$buscar_identificacion.="".$configuracion["prefijo"]."egresado.identificacion like '%".$val."%' OR ";
				}
				
				$buscar_todo=$buscar_nombre.$buscar_apellido.substr($buscar_identificacion,0,(strlen($buscar_identificacion)-3));
				//echo $buscar_todo;
				
				$cadena_hoja="SELECT ";
				$cadena_hoja.=" nombre,";
				$cadena_hoja.=" apellido, ";
				$cadena_hoja.="identificacion";
				$cadena_hoja.=" FROM ";
				$cadena_hoja.=$configuracion["prefijo"]."egresado ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="id_programa=";
				$cadena_hoja.=$id_programa." ";
				$cadena_hoja.="AND ";
				$cadena_hoja.=$buscar_todo;
				$cadena_hoja.=" ORDER BY apellido, nombre ";			
				//echo $cadena_sql;
				
				$cadena_sql="SELECT ";
				$cadena_sql.=" nombre,";
				$cadena_sql.=" apellido, ";
				$cadena_sql.="identificacion";
				$cadena_sql.=" FROM ";
				$cadena_sql.=$configuracion["prefijo"]."egresado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_programa=";
				$cadena_sql.=$id_programa;
				$cadena_sql.="AND ";
				$cadena_sql.=$buscar_todo;
				$cadena_sql.=" ORDER BY apellido, nombre ";
				$cadena_sql.="LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT nombre, apellido, identificacion";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."egresado WHERE id_programa=".$id_programa." ORDER BY apellido, nombre ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT nombre, apellido, identificacion";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."egresado WHERE id_programa=".$id_programa." ORDER BY apellido, nombre ";
		//echo $cadena_sql;
	}		
//echo $cadena_sql."<br>";
 	//echo $cadena_hoja."<br>";
	//Primero obtener el numero de hojas
	$acceso_db->registro_db($cadena_hoja,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	$todos=$campos;
	if($campos>0)
	{
		$hoja=ceil($campos/$configuracion['registros'])-1;
		//echo $hoja;
	}
	else
	{
		$hoja=0;
	
	}
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	
	if($campos==0)
	{
		/*No existen usuarios egresados en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td ><span  style="font-weight: bold;">Actualmente no hay egresados
registrados en el sistema</span></td>
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
<td >Egresado</td>
<?php  //<td>Correo</td> ?>
<td>Identificaci&oacute;n</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php  echo $registro[$contador][0]." ". $registro[$contador][1] ?></td>
<?php  /*<td class="celdatabla"><?php  echo $registro[$contador][2] ?></td>*/?>
<td align="center" class="celdatabla"><?php  echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla"><?php //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('editar_egresado').'&usuario='.$_GET['usuario'].'&registro='.$registro[$contador][2]; ?>">Modificar</a>
</td>
<td align="center" class="celdatabla"><?php //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_egresado').'&opcion=egresado&usuario='.$_GET['usuario'].'&registro='.$registro[$contador][2]; ?>">Borrar</A>
</td>	
</tr><?php }?>
</table><br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php 
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php  echo $_GET["hoja"] ?>" href="<?php 
	$variable="";
	
	//Envia todos los datos que vienen con GET
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='page' && $clave!='hoja')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}
		else
		{
			if($clave=='hoja')
			{
				$variable.="&".$clave."=".($val-1);
				//echo $variable;
			}
			
		}
		
	}
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_dir_egresado');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>"><< Anterior</a>
	<?php 	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	<form method="GET"><?php 
	$variable="";
	
	//Envia todos los datos que vienen con GET
	reset ($_GET);
	
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='hoja' && $clave!='aceptar')
		{
			$variable.="<input type='hidden' name='".$clave."' value='".$val."'>\n";
			//echo $clave;
		}
	}
	echo $variable;
	echo "Hoja  <input type='text' name='ir_hoja' size='2' maxlength='4' value='".($_GET["hoja"]+1)."'> de ".($hoja+1);	
	echo "<br>Mostrando: ".$campos." de ".$todos;
	?>	 
	</form>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?php 
		if($_GET["hoja"]<$hoja)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php  echo $_GET["hoja"]+2 ?>" href="<?php 
	$variable="";
	
	//Envia todos los datos que vienen con GET
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) {
		
		if($clave!='page' && $clave!='hoja')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}
		else
		{
			if($clave=='hoja')
			{
				$variable.="&".$clave."=".($val+1);
				//echo $variable;
			}
			
		}
		
	}
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_dir_egresado');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>">Siguiente>></a>
<?php 
	}
?>
	</td>
</tr>
</table>
</form>
<?php 			
  }
}
