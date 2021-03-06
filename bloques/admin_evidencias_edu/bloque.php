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
			//Todos los usuarios
			case '1':
				$cadena_hoja="SELECT ";
				$cadena_hoja.="id_evidencia,";
				$cadena_hoja.="id_criterio,";
				$cadena_hoja.="nombre ";
				$cadena_hoja.="FROM ".$configuracion["prefijo"]."evidencia_edu "; 
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="id_criterio=".$_GET["criterio"]." ";;
				$cadena_hoja.="ORDER BY id_evidencia ";
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_evidencia,";
				$cadena_sql.="id_criterio,";
				$cadena_sql.="nombre ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."evidencia_edu "; 
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_criterio=".$_GET["criterio"]." ";;
				$cadena_sql.="ORDER BY id_evidencia ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;
			
			default:
				$cadena_hoja="SELECT ";
				$cadena_hoja.="id_evidencia,";
				$cadena_hoja.="id_criterio,";
				$cadena_hoja.="nombre ";
				$cadena_hoja.="FROM ".$configuracion["prefijo"]."evidencia_edu "; 
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="id_criterio=".$_GET["criterio"]." ";;
				$cadena_hoja.="ORDER BY id_evidencia ";
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_evidencia,";
				$cadena_sql.="id_criterio,";
				$cadena_sql.="nombre ";
				$cadena_sql.="FROM ".$configuracion["prefijo"]."evidencia_edu ";
				$cadena_sql.="WHERE "; 
				$cadena_sql.="id_criterio=".$_GET["criterio"]." ";;
				$cadena_sql.="ORDER BY id_evidencia ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_hoja="SELECT ";
		$cadena_hoja.="id_evidencia,";
		$cadena_hoja.="id_criterio,";
		$cadena_hoja.="nombre ";
		$cadena_hoja.="FROM ".$configuracion["prefijo"]."evidencia_edu "; 
		$cadena_hoja.="WHERE ";
		$cadena_hoja.="id_criterio=".$_GET["criterio"]." ";;
		$cadena_hoja.="ORDER BY id_evidencia ";
		
		$cadena_sql="SELECT ";
		$cadena_sql.="id_evidencia,";
		$cadena_sql.="id_criterio,";
		$cadena_sql.="nombre ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."evidencia_edu "; 
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_criterio=".$_GET["criterio"]." ";
		$cadena_sql.="ORDER BY id_evidencia ";
		$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
		//echo $cadena_sql;
		
		
	}		
	//echo $cadena_sql;
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
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay Evidencias para el criterio registradas en el sistema</td>
    </tr>
    </tbody>
</table><?php 
		
	}
	else
	{
/*Si existen criterios en el sistema*/
?><script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="bloquecentralencabezado">
<td >Evidencia</td>
<?php  //<td>Correo</td> ?>
<td colspan="3">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<?php /*Campo oculto con el id_usuario para poder realizar la actualización de la información*/?>							
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php  echo $contador ?>, 'over', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php  echo $contador ?>, 'out', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php  echo $contador ?>, 'click', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');">
<td bgcolor="<?php  echo $tema->celda ?>"><?php  echo $registro[$contador][2] ?>
<input type="hidden" name= "hoja" value="<?php echo $_GET["hoja"] ?>">
<input type="hidden" name= "accion" value="<?php echo $_GET["accion"] ?>">
<?php /*Campos ocultos para dar continuidad al formulario actual*/?>
<input type="hidden" name= "evidencia_<?PHP  echo $contador ?>" value="<?php echo $registro[$contador][0] ?>">
</td>
<?php  /*<td class="celdatabla"><?php  echo $registro[$contador][2] ?></td>*/?>
<td align="center" bgcolor="<?php  echo $tema->celda ?>">
<a href="<?php 
$opcion=$configuracion["site"].'/index.php?page='.enlace('registro_evidencia_edu');
$opcion.=$variable; 
$opcion.="&opcion=editar";
$opcion.="&evidencia=".$registro[$contador][0];
$opcion.="&criterio=".$registro[$contador][1];
echo $opcion;
?>">
<img width="24" height="24" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_editar.png" alt="Editar" title="Editar" border="0" /></a>
</td>
<td align="center" bgcolor="<?php  echo $tema->celda ?>">
<a href="<?php 
	$opcion=$configuracion["site"].'/index.php?page='.enlace('borrar_evidencia');
	$opcion.=$variable; 
	$opcion.="&opcion=evidencia";
	$opcion.="&evidencia=".$registro[$contador][0];
	echo $opcion;
?>">
<img width="24" height="24" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_borrar.png" alt="Borrar del sistema" title="Borrar del sistema" border="0" /></A>
</td>	
</tr><?php }?>
</table><br>
<?php 
// Botones de navegacion
?><br>
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
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_usuario');
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
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_usuario');
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
