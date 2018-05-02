<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php
/***************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 28/07/2006

****************************************************************************
* @subpackage   registro_esquema
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de tesquemas de ponderacion para modelos de evaluacion/gestion
* @usage        
****************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

if(isset($_GET['opcion']))
{
	$accion=$_GET['opcion'];
	
	if($accion=="mostrar")
	{
		mostrar_registro($configuracion,$tema,$accion);
	}
	else
	{
		
		if($accion=="nuevo")
		{
			nuevo_registro($configuracion,$tema,$accion);
		
		}
		else
		{
			if($accion=="editar")
			{
				editar_registro($configuracion,$tema,$accion);
			
			}		
		}
		
	
	}
}
else
{
	$accion="nuevo";
	nuevo_registro($configuracion,$tema,$accion);
}

/****************************************************************************************
*				Funciones						*
****************************************************************************************/

function editar_registro($configuracion,$tema,$accion)
{
	$tab=1;
	$contador=0;
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="`id_esquema`, ";
		$cadena_sql.="`id_usuario`, ";
		$cadena_sql.="`id_modelo`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`descripcion`, ";
		$cadena_sql.="`observacion`, ";
		$cadena_sql.="`fecha` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."esquema_ponderacion "; 
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_esquema=".$_GET['id_esquema']." ";	
		$cadena_sql.="LIMIT 1 ";
		
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$formulario="registrar_esquema";
			//Validacion de controles
			$validar="control_vacio(".$formulario.",'nombre')";
			
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?echo $formulario;?>" onsubmit="return (<?php echo $validar; ?>)">
  <table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>	
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Nombre del esquema:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<textarea name='nombre' cols='40' rows='2' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][3] ?></textarea>
			<input type='hidden' name='id_esquema' value='<?php echo $registro[0][0] ?>'>
			<input type='hidden' name='id_usuario' value='<?php echo $registro[0][1] ?>'>
			<input type='hidden' name='id_modelo' value='<?php echo $registro[0][2] ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<textarea name='descripcion' cols='40' rows='2' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][4] ?></textarea>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Observaci&oacute;n:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<textarea name='observacion' cols='20' rows='2' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][5] ?></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1' align='center'>
			<table align='center' width='50%'>
			<tr align='center'>
			<td>
				<input type='hidden' name='fecha' value='<?php echo $registro[0][6] ?>'>
				<input type='hidden' name='action' value='registro_esquema'>
				<input name='aceptar' value='Aceptar' type='submit'><br>
			</td>
			<td>
				<input name='cancelar' value='Cancelar' type='submit'><br>
			</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</form><?php
		
		}
	
	
	}
}


function mostrar_registro($configuracion,$tema,$accion)
{
	$tab=1;
	$contador=0;
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="`id_esquema`, ";
		$cadena_sql.="`id_usuario`, ";
		$cadena_sql.="`id_modelo`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`descripcion`, ";
		$cadena_sql.="`observacion`, ";
		$cadena_sql.="`fecha` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."esquema_ponderacion "; 
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_esquema=".$_GET['id_esquema']." ";	
		$cadena_sql.="LIMIT 1 ";
		
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>	
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Modelo:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'><?php
			$busqueda="SELECT ";
			$busqueda.="id_modelo, ";
			$busqueda.="nombre_corto ";
			$busqueda.="FROM ";
			$busqueda.=$configuracion["prefijo"]."modelo ";
			$busqueda.="WHERE ";
			$busqueda.="id_modelo= ".$registro[0][2]." ";
			$acceso_db->registro_db($cadena_sql,0);
			$registro_tipo=$acceso_db->obtener_registro_db();
			$campos_tipo=$acceso_db->obtener_conteo_db();
			if($campos_tipo>0)
			{
				echo $registro_tipo[0][0];
			}
			else
			{
				echo "No determinado";
			}
			unset($registro_tipo);
			unset($campos_tipo);
			unset($busqueda);			
	?>	</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Nombre del Esquema:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<?php echo $registro[0][3] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<?php echo $registro[0][4] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Observaci&oacute;n:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<?php echo $registro[0][5] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Fecha de Creaci&oacute;n:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<?php echo date("d/m/Y",$registro[0][6]) ?>
		</td>
	</tr>
</table>
</td>
</tr>
</table><?php
		}
	}	
}


function nuevo_registro($configuracion,$tema,$accion)
{
	$tab=1;
	$contador=0;	
	//Validacion
	$formulario="registrar_esquema";
	//Validacion de controles
	$validar="control_vacio(".$formulario.",'nombre')";
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?php echo $formulario;?>" onsubmit="return (<?php echo $validar; ?>)">
 <table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Modelo Asociado:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<table width='100%' cellpadding='0' cellspacing='0'>
				<tr class='bloquecentralcuerpo'>
					<td>
						<input type='hidden' align="middle" name='id_modelo' readonly size='4' maxlength='9' tabindex='<?php echo $tab++ ?>' >
						<input type='text' style="color: #0000FF;text-align:center" name='nombre_modelo' disabled tabindex='<?php echo $tab++ ?>' >
					</td>
					<td align="right">
						<a name="stone_1" href="#stone_1" onclick="abrir_emergente('<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('seleccion_modelo').'&admin='.enlace('lista'); ?>','Modelos_Registrados',window.document.<?php echo $formulario?>.id_modelo,window.document.<?php echo $formulario?>.nombre_modelo)"><img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info.png" alt="Mostrar modelos registrados" title="Mostrar modelos registrados" border="0" /> Lista de Modelos registrados.</a>
						<input type='hidden' name='opcion' value='<?php echo enlace("nuevo") ?>'>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="bloquecentralcuerpo">
		<td class="celdatabla" valign="top" align="left">
		Tipo de Esquema:
		</td>
		<td class="celdatabla" align="left" valign="top">
			<table cellpadding="2" cellspacing="5">
				<tr class="bloquecentralcuerpo">
					<td>
						<input checked="checked" name="tipo_esquema" value="0" type="radio" tabindex="5">Orden de Importancia
					</td>
					<td>
						<input  name="tipo_esquema" value="1" type="radio" tabindex="6">An&aacute;lisis Estructural
					</td>
				</tr>				
			</table>
		</td>
	</tr> 
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Nombre:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<textarea name='nombre' cols='40' rows='2' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<textarea name='descripcion' cols='40' rows='2' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			Observaciones:
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<textarea name='observacion' cols='40' rows='2' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='fecha' value='<?php echo time() ?>' >
			<input type='hidden' name='action' value='registro_esquema'>
			<input name='aceptar' value='Aceptar' type='submit'><br>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</form>
<?php
}
?>
