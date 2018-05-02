<?php 
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php 
/****************************************************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************************************************/
?><?php 

//La variable $_GET['usuario'] contiene el npmbre del programa que esta editando la información...
// puede tomarse esa informacion desde la variable de sesion correspondiente TODO

include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	
	exit;		
	}

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	if(isset($_GET['accion']))
	{
		
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
		
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
		//Rescatar el valor de la variable usuario de la sesion
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
		
		if($registro)
		{
			
			$el_usuario=$registro[0][0];
		}
	
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos las preguntas
			case '1':
				
				$cadena_hoja="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario";
				$cadena_hoja.=" FROM ".$configuracion["prefijo"]."proceso ";
				$cadena_hoja.=" ORDER BY nombre ";
				
				$cadena_sql="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
				$cadena_sql.=" ORDER BY id_artefacto ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				
				
				//echo $cadena_sql;
				break;
			
			//Filtrados	
			case '2':
				
				// Para las fechas
				
				for($contador=1;$contador<3;$contador++)
				{
					if(isset($_GET["dia_".$contador]))
					{
						$dia[$contador]=$_GET["dia_".$contador]*1;
							
					}
					else
					{
						$dia[$contador]=0;				
					}
					
					if(isset($_GET["mes_".$contador]))
					{
						$mes[$contador]=$_GET["mes_".$contador]*1;
							
					}
					else
					{
						$mes[$contador]=0;				
					}
					
					if(isset($_GET["anno_".$contador]))
					{
						$anno[$contador]=$_GET["anno_".$contador]*1;
							
					}
					else
					{
						$anno[$contador]=0;				
					}
					
					$fecha[$contador]=mktime(0,0,0,$mes[$contador],$dia[$contador],$anno[$contador]);
				}
				
				//Se tienen dos fechas
				if($fecha[2]==0)
				{
					$fecha[2]=time();
				}
				
				$condicion="";
				
				if($fecha[2]>$fecha[1])
				{
					$condicion.="(fecha_creacion>".$fecha[1]." AND fecha_creacion<=".$fecha[2].") AND";
				}
				
				//Para el autor
				if(isset($_GET["autor"]))
				{
					$id_autor=$_GET["autor"]*1;
					
					if($id_autor>0)
					{
						$condicion.="(id_usuario=".$id_autor.") AND";					
					}
					
				}
				
				//Para nombre
				
				if(isset($_GET['busqueda']))
				{
					if(trim($_GET['busqueda'])!="")
					{
					$buscar=explode(" ",$_GET['busqueda']);
					$buscar_nombre='(';
							
					while (list ($clave, $val) = each ($buscar)) 
					{
						$buscar_nombre.="nombre like '%".$val."%' OR ";
					}
					
					$condicion.=substr($buscar_nombre,0,(strlen($buscar_nombre)-3)).") AND";
					}		
				}			
							
				$cadena_hoja="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario";
				$cadena_hoja.=" FROM ".$configuracion["prefijo"]."proceso ";
				if($condicion!="")
				{
				$cadena_hoja.=" WHERE ".substr($condicion,0,(strlen($condicion)-3));
				}
				
				$cadena_sql="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
				if($condicion!="")
				{
				$cadena_sql.=" WHERE ".substr($condicion,0,(strlen($condicion)-3));
				}
				
				
				$cadena_sql.=" ORDER BY fecha_creacion ";
				
				if(isset($_GET['orden'])) //Si se ha definido un orden se supone que es descendente
				{
					$cadena_sql.=" DESC LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				}
				else
				{
					$cadena_sql.=" ASC LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				}
				
				break;	
			
						
			default:
				
				$cadena_hoja="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario";
				$cadena_hoja.=" FROM ".$configuracion["prefijo"]."proceso ";
											
				$cadena_sql="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
				$cadena_sql.=" ORDER BY nombre ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
		$cadena_hoja="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario,tipo";
		$cadena_hoja.=" FROM ".$configuracion["prefijo"]."proceso ";
							
		$cadena_sql="SELECT id_proceso,nombre,fecha_creacion, descripcion,id_usuario,tipo";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
		$cadena_sql.=" ORDER BY nombre ";
		$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
		//echo $cadena_sql;
	}		
	//echo $cadena_sql;
	//echo $cadena_hoja;
	//Primero obtener el numero de hojas
	$acceso_db->registro_db($cadena_hoja,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
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
		/*No existen preguntas en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay procesos registrados en el sistema</td>
    </tr>
    </tbody>
</table>


<?php 

		
	}
	else
	{
/*Si existen preguntas en el sistema*/
?><script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td>Nombre</td>
<td>Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
		
			$busqueda="SELECT nombre ";
			$busqueda.="FROM ".$configuracion["prefijo"]."registrado ";
			$busqueda.="WHERE id_usuario=".$registro[$contador][4];
			$busqueda.=" LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$usuario=$acceso_db->obtener_registro_db();
			$total_usuario=$acceso_db->obtener_conteo_db();
			if($total_usuario>0)
			{	
		
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?php  echo $contador ?>, 'over', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php  echo $contador ?>, 'out', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php  echo $contador ?>, 'click', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');">
<td bgcolor="<?php  echo $tema->celda ?>"><a title="No:<?php  echo $registro[$contador][0] ?> Creada por: <?php  echo $usuario[0][0] ?> el <?php  echo $fecha=date( "d-m-y",$registro[$contador][2]) ?> "><?php  echo $registro[$contador][1] ?></a></td>
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
<a href="<?php 
	$opcion=$configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('informacion_proceso');
	$opcion.="&registro=".$registro[$contador][0];
	echo $opcion;

?>">Informaci&oacute;n</a>
</td>
</tr><?php 	
		}
	}
// Botones de navegacion
?>
</table><br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php 
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php  echo $_GET["hoja"] ?>" href="<?php 
	$opcion=$configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('director_proceso');
	$opcion.=$variable; 
	echo $opcion;

?>"><< Anterior</a>
	<?php 	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	Hoja <?php  echo ($_GET["hoja"]+1) ?> de <?php  echo ($hoja+1) ?>
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
	
	$opcion=$configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('director_proceso');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>">Siguiente>></a>
<?php 
	}
?>
	</td>
</tr>
</table>


<?php 			
  }
}
?>
