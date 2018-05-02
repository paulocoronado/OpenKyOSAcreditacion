<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*****************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
******************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
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
		
		switch($_GET['accion'])
		{	
			//Todos los programas
			case '1':
				$cadena_hoja="SELECT ";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre,";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre_corto,";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.id_programa ";
				$cadena_hoja.="FROM ".$configuracion["prefijo"]."programa "; 
				$cadena_hoja.="ORDER BY nombre ";
				
				$cadena_sql=$cadena_hoja;
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;
			
			case '2':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre="";
				$buscar_nombre_corto="";
				
				
				while (list ($clave, $val) = each ($buscar)) 
				{
					$buscar_nombre.="".$configuracion["prefijo"]."programa.nombre like '%".$val."%' OR ";
					$buscar_nombre_corto.="".$configuracion["prefijo"]."programa.nombre_corto like '%".$val."%' OR ";
				}
				
				$buscar_todo=$buscar_nombre.substr($buscar_nombre_corto,0,(strlen($buscar_nombre_corto)-3));
				
				//echo $buscar_todo;
								
				$cadena_hoja="SELECT ";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre,";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre_corto,";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.id_programa ";
				$cadena_hoja.="FROM ".$configuracion["prefijo"]."programa "; 
				$cadena_hoja.="WHERE ".$buscar_todo." ";
				$cadena_hoja.="ORDER BY nombre ";
				//echo $cadena_hoja;
				
				$cadena_sql=$cadena_hoja;
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_hoja="SELECT ";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre,";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre_corto,";
				$cadena_hoja.="".$configuracion["prefijo"]."programa.id_programa ";
				$cadena_hoja.="FROM ".$configuracion["prefijo"]."programa "; 
				$cadena_hoja.="ORDER BY nombre ";
				
				$cadena_sql=$cadena_hoja;
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_hoja="SELECT ";
		$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre,";
		$cadena_hoja.="".$configuracion["prefijo"]."programa.nombre_corto,";
		$cadena_hoja.="".$configuracion["prefijo"]."programa.id_programa ";
		$cadena_hoja.="FROM ".$configuracion["prefijo"]."programa "; 
		$cadena_hoja.="ORDER BY nombre ";
		
		$cadena_sql=$cadena_hoja;
		$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
		//echo $cadena_sql;
	}		
//	echo $cadena_sql;
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
		?>
<table style="text-align: left;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
  <tr>
      <td >
      		<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
					</td>
					<td align="left">
						<b>Actualmente no hay programas registrados en el sistema.</b>
					</td>
				</tr>
		</table>
      
      </td>
    </tr>  
</table><?php
		
	}
	else
	{
//Si existen programas en el sistema
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="bloquecentralencabezado">
<td >Programa</td>
<td>Nombre Corto</td>
<td colspan="2">Opciones</td>
</tr>
	<?php
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<?php/*Campo oculto con el id_usuario para poder realizar la actualización de la información*/?>							
<input type="hidden" name= "usuario<? echo $contador ?>" value="<?echo $registro[$contador][5] ?>">
<input type="hidden" name= "hoja" value="<?echo $_GET["hoja"] ?>">
<input type="hidden" name= "accion" value="<?echo $_GET["accion"] ?>">
<?php/*Campos ocultos para dar continuidad al formulario actual*/?>
<input type="hidden" name= "nombre<? echo $contador ?>" value="<?echo $registro[$contador][6] ?>">
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
<td bgcolor="<?php echo $tema->celda ?>"><b><?php echo $registro[$contador][0] ?></b></td>
<?php /*<td class="celdatabla"><?php echo $registro[$contador][2] ?></td>*/?>
<td align="center" bgcolor="<?php echo $tema->celda ?>"><?php echo $registro[$contador][1] ?></td>
<td align="center" bgcolor="<?php echo $tema->celda ?>">
<a href="<?php
$opcion=$configuracion["site"].'/index.php?page='.enlace('registro_admin_programa');
$opcion.=$variable; 
$opcion.="&opcion=editar";
$opcion.="&registro=".enlace($registro[$contador][2]);
echo $opcion;
?>">
<img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_editar.png" alt="Editar Usuario" title="Editar Usuario" border="0" /></a>
</td>
<td align="center" bgcolor="<?php echo $tema->celda ?>"><?php//TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php
	$opcion=$configuracion["site"].'/index.php?page='.enlace('borrar_programa');
	$opcion.=$variable; 
	$opcion.="&opcion=usuario";
	$opcion.="&registro=".enlace($registro[$contador][2]);
	echo $opcion;
?>">
<img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_borrar.png" alt="Borrar usuario del sistema" title="Borrar usuario del sistema" border="0" /></A>
</td>	
</tr><?php}?>
</table><br><?php
// Botones de navegacion
?><br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo $_GET["hoja"] ?>" href="<?php
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
				$variable.="&".$clave."=".($val-1);
				//echo $variable;
			}
			
		}
		
	}
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_programa');
	$opcion.=$variable;
	
	 
	 echo $opcion;
	
	
	

?>"><< Anterior</a>
	<?php	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	Hoja <?php echo ($_GET["hoja"]+1) ?> de <?php echo ($hoja+1) ?>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?php
		if($_GET["hoja"]<$hoja)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo $_GET["hoja"]+2 ?>" href="<?php
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
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_programa');
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