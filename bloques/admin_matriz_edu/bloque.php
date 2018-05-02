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
?>
<?php  
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
include($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$id_usuario=$registro[0][0];
	}
	
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		
		$el_usuario=$registro[0][0];
	}
	
	
	
	if(isset($_GET['accion']))
	{
		switch($_GET['accion'])
		{	
			//Todos las evaluaciones
			case '1':
				
				$cadena_hoja="SELECT fecha,id_usuario,id_documento";
				$cadena_hoja.=" FROM ".$configuracion["prefijo"]."edu ";
				$cadena_hoja.=" WHERE id_usuario=".$id_usuario;
				$cadena_hoja.=" AND id_documento=".$_GET['registro'];
				$cadena_hoja.=" GROUP BY fecha ";
				//echo $cadena_hoja;
				
				$cadena_sql="SELECT fecha,id_usuario,id_documento";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."edu ";
				$cadena_sql.=" WHERE id_usuario=".$id_usuario;
				$cadena_sql.=" AND id_documento=".$_GET['registro'];
				$cadena_sql.=" GROUP BY fecha ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				
				break;
				
			//Filtrados por cuadros de texto	
			case '2':
				
				$cadena_hoja="SELECT fecha,id_usuario,id_documento";
				$cadena_hoja.=" FROM ".$configuracion["prefijo"]."edu ";
				$cadena_hoja.=" WHERE id_usuario=".$id_usuario;
				$cadena_hoja.=" AND id_documento=".$_GET['registro'];
				$cadena_hoja.=" GROUP BY fecha ";
				//echo $cadena_hoja;
				
				$cadena_sql="SELECT fecha,id_usuario,id_documento";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."edu ";
				$cadena_sql.=" WHERE id_usuario=".$id_usuario;
				$cadena_sql.=" AND id_documento=".$_GET['registro'];
				$cadena_sql.=" GROUP BY fecha ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				
				break;
			
			default:
				$cadena_hoja="SELECT fecha,id_usuario,id_documento";
				$cadena_hoja.=" FROM ".$configuracion["prefijo"]."edu ";
				$cadena_hoja.=" WHERE id_usuario=".$id_usuario;
				$cadena_hoja.=" AND id_documento=".$_GET['registro'];
				$cadena_hoja.=" GROUP BY fecha ";
				//echo $cadena_hoja;
				
				$cadena_sql="SELECT fecha,id_usuario,id_documento";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."edu ";
				$cadena_sql.=" WHERE id_usuario=".$id_usuario;
				$cadena_sql.=" AND id_documento=".$_GET['registro'];
				$cadena_sql.=" GROUP BY fecha ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				
				break;
					
			
		}
	}
	else
	{
		$cadena_hoja="SELECT fecha,id_usuario,id_documento";
		$cadena_hoja.=" FROM ".$configuracion["prefijo"]."edu ";
		$cadena_hoja.=" WHERE id_usuario=".$id_usuario;
		$cadena_hoja.=" AND id_documento=".$_GET['registro'];
		$cadena_hoja.=" GROUP BY fecha ";
		//echo $cadena_hoja;
		
		$cadena_sql="SELECT fecha,id_usuario,id_documento";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."edu ";
		$cadena_sql.=" WHERE id_usuario=".$id_usuario;
		$cadena_sql.=" AND id_documento=".$_GET['registro'];
		$cadena_sql.=" GROUP BY fecha ";
		$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
		
		break;
	}		
//	echo $cadena_hoja;
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
		//No existen evaluaciones realizadas por el usuario
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td ><span  style="font-weight: bold;">Actualmente no evaluaciones a este documento</span></td>
    </tr>
    </tbody>
</table>


<?php  

		
	}
	else
	{
		$fila=0;
/*Si existen usuarios en el sistema*/
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td >Fecha de la evaluaci&oacute;n</td>
<td colspan="2">Opciones</td>
</tr>
	<?php  
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php   echo $fila; ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $fila; ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $fila++; ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
	<td bgcolor="<?php   echo $tema->celda ?>" align="center">
	<?php   echo date( "M-d-Y h:i", $registro[$contador][0]) ?>
	</td>
	<td bgcolor="<?php   echo $tema->celda ?>" align="center"><?php  
$opciones="&fecha=".$registro[$contador][0];
$opciones.="&registro=".$_GET['registro'];
$opciones.="&accion=1";
$opciones.="&hoja=".$_GET["hoja"];
$opciones.="&mostrar=1";

?>	<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('evaluar_documento').$opciones; ?>">Editar</a>
	</td>
	<td bgcolor="<?php   echo $tema->celda ?>" align="center"><?php  
$opciones="&opcion=evaluacion_documental";
$opciones.="&fecha=".$registro[$contador][0];
$opciones.="&registro=".$_GET['registro'];
$opciones.="&accion=1";
$opciones.="&hoja=".$_GET["hoja"];
	
	?><a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_evaluacion_documento').$opciones; ?>">Borrar</A>
	</td>	
</tr><?php  }?>
</table><br>
</form><?php  
// Botones de navegacion
?><table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php  
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php   echo $_GET["hoja"] ?>" href="<?php  
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
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_evaluacion_documental');
	$opcion.=$variable;
	
	 
	 echo $opcion;
	
	
	

?>"><< Anterior</a>
	<?php  	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	Hoja <?php   echo ($_GET["hoja"]+1) ?> de <?php   echo ($hoja+1) ?>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?php  
		if($_GET["hoja"]<$hoja)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php   echo $_GET["hoja"]+2 ?>" href="<?php  
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
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_evaluacion_documental');
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
