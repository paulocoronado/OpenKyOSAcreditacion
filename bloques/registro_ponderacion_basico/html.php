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
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
****************************************************************************
* @subpackage   registro_ponderacion_basico
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Registro de ponderacion de componentes de acuerdo al modelo de orden de importancia
*
*****************************************************************************/
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
	//Cuando se trata de un esquema expuesto se tiene una variable GET con el usuario propietario
	if(isset($_GET["id_usuario"]))
	{
		$id_usuario=$_GET["id_usuario"];
	}
	else
	{
		//Rescatar el valor de la variable usuario de la sesion
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
		if($registro)
		{
			$id_usuario=$registro[0][0];
		}
	}
	$id_componente=$_GET["id_componente"];
	$id_esquema=$_GET["id_esquema"];
	
	//Diseccion del codigo de componente
	$componentes=explode("_",$id_componente);
		
	$mi_modelo=($componentes[0]-1);//Ojo!!!
	$mi_componente=$componentes[1];
	$mi_nivel=$componentes[2];
	$mi_padre=$componentes[3];
	
	
	//Buscar componentes del siguiente nivel cuyo padre es $mi_componente
	$entidad=$configuracion["prefijo"]."modelo_componente";

	
	$cadena_sql="SELECT ";
	$cadena_sql.=$entidad.".`id_componente`, ";
	$cadena_sql.=$entidad.".`id_modelo`, ";
	$cadena_sql.=$entidad.".`nivel`, ";
	$cadena_sql.=$entidad.".`id_padre`, ";
	$cadena_sql.=$entidad.".`valor`, ";
	$cadena_sql.=$entidad.".`nombre` ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$entidad." "; 
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_padre=".$mi_componente." ";
	$cadena_sql.="AND ";
	$cadena_sql.="nivel=".($mi_nivel+1)." ";
	//echo $cadena_sql;
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	
	if($campos>0)
	{
		
		if(isset($_GET['opcion']))
		{
			$accion=desenlace($_GET['opcion']);
			
			if($accion=="mostrar")
			{
				mostrar_registro($registro,$configuracion,$tema,$accion,$id_componente,$id_usuario);
			}
			else
			{
				
				if($accion=="editar")
				{
					editar_registro($configuracion,$tema,$accion,$registro,$id_componente,$id_usuario);
				
				}
				else
				{
					if($accion=="nuevo")
					{
						nuevo_registro($configuracion,$tema,$accion,$registro,$id_componente);
					
					}
				}
			}
		}
		else
		{
		
			
			$cadena_sql="SELECT ";
			$cadena_sql.="`id_esquema`, ";
			$cadena_sql.="`id_usuario`, ";
			$cadena_sql.="`componente_a`, ";
			$cadena_sql.="`componente_b`, ";
			$cadena_sql.="`valor`, ";
			$cadena_sql.="`observacion`, ";
			$cadena_sql.="`fecha` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."esquema_valor ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_esquema=".$_GET['id_esquema']." ";
			$cadena_sql.="AND ";
			$cadena_sql.="componente_a ";
			$cadena_sql.="LIKE ";
			$cadena_sql.="'".$mi_modelo."_%_".($mi_nivel+1)."_".$mi_componente."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_usuario=".$id_usuario." ";	
			$cadena_sql.="LIMIT 1 ";
			
			//echo $cadena_sql;
			$acceso_db->registro_db($cadena_sql,0);
			$registro_ponderacion=$acceso_db->obtener_registro_db();
			$campos_ponderacion=$acceso_db->obtener_conteo_db();
			if($campos_ponderacion>0)
			{
				mostrar_registro($registro,$configuracion,$tema,'mostrar',$id_componente,$id_usuario);
				
			}
			else
			{
				nuevo_registro($configuracion,$tema,"nuevo",$registro,$id_componente);
			}
		
		
		}
	}
  
}


/****************************************************************************************
*				Funciones						*
****************************************************************************************/
function nuevo_registro($configuracion,$tema,$accion,$registro,$id_componente)
{
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$tab=1;
		$contador=0;
		
		//Validacion
		$formulario="ponderar_componente";
		//Validacion de controles
		
		$validar="1";
		
		for($a=0;$a<(count($registro));$a++)
		{
			$mi_componente=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			$validar.="&&control_vacio(".$formulario.",'componente_".$mi_componente."')";
			$validar.="&&control_vacio(".$formulario.",'observacion_".$mi_componente."')";
			$validar.="&&verificar_rango(".$formulario.",'componente_".$mi_componente."',1,".count($registro).")";
				
		}
		$validar.="&&comparar(".$formulario.")";
				
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="ponderar_componente">
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquecentralcuerpo">
		<tr align="center" class="mensajealertaencabezado">
			<td>
				Componente
			</td>
			<td>
				Importancia
			</td>
		</tr><?php	
	
		for($a=0;$a<(count($registro));$a++)
		{
			$mi_componente=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			
		
?>		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				<b><?php echo $registro[$a][5] ?></b><br><?php echo $registro[$a][4] ?>
			</td>
			<td bgcolor='<?php echo $tema->celda ?>' align="center">
				<input style="text-align:center;" type='text' name='componente_<? 
				
				//Componente: id_modelo.id_componente.nivel.id_padre
				echo $mi_componente;
				
				?>' value='0' size='2' maxlength='3' tabindex='<?php echo $tab++ ?>' >
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' align="center" colspan="2">
				<textarea cols="50" rows="2" name='observacion_<? 
				
				//Componente: id_modelo.id_componente.nivel.id_padre
				echo $mi_componente;
				
				?>' tabindex='<?php echo $tab++ ?>' ></textarea>
			</td>
		</tr>
		<?php
		}
?>		<tr align='center'>
			<td colspan='2' rowspan='1' align='center'>
				<table align='center' width='50%'>
				<tr align='center'>
				<td>
					<input type='hidden' name='action' value='registro_ponderacion_basico'>
					<input type='hidden' name='id_esquema' value='<?php echo $_GET['id_esquema'] ?>'>
					<input type='hidden' name='opcion' value='<?php echo enlace($accion) ?>'>
					<input type='hidden' name='id_componente' value='<?php echo $id_componente ?>'>
					
					<input name='aceptar' value='Aceptar' type='submit' onclick="return (<?php echo $validar; ?>)"><br>
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


function editar_registro($configuracion,$tema,$accion,$registro,$id_componente,$id_usuario)
{
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$tab=1;
		$contador=0;
		
		//Validacion
		$formulario="ponderar_componente";
		//Validacion de controles
		
		$validar="1";
		
		for($a=0;$a<(count($registro));$a++)
		{
			$mi_componente=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			$validar.="&&control_vacio(".$formulario.",'componente_".$mi_componente."')";
			$validar.="&&control_vacio(".$formulario.",'observacion_".$mi_componente."')";
			$validar.="&&verificar_rango(".$formulario.",'componente_".$mi_componente."',1,".count($registro).")";
				
		}
		$validar.="&&comparar(".$formulario.")";
				
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="ponderar_componente" >
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquecentralcuerpo">
		<tr align="center" class="mensajealertaencabezado">
			<td>
				Componente
			</td>
			<td>
				Importancia
			</td>
		</tr><?php	
	
		for($a=0;$a<(count($registro));$a++)
		{
			$mi_componente=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			
			$cadena_sql="SELECT ";
			$cadena_sql.="`id_esquema`, ";
			$cadena_sql.="`id_usuario`, ";
			$cadena_sql.="`componente_a`, ";
			$cadena_sql.="`componente_b`, ";
			$cadena_sql.="`valor`, ";
			$cadena_sql.="`observacion`, ";
			$cadena_sql.="`fecha` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."esquema_valor ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_esquema=".$_GET['id_esquema']." ";
			$cadena_sql.="AND ";
			$cadena_sql.="componente_a='".$mi_componente."' ";		
			$cadena_sql.="LIMIT 1 ";
			
			//echo $cadena_sql."<br>";
			$acceso_db->registro_db($cadena_sql,0);
			$registro_ponderacion=$acceso_db->obtener_registro_db();
			$campos_ponderacion=$acceso_db->obtener_conteo_db();
			if($campos_ponderacion>0)
			{
				$ponderacion=$registro_ponderacion[0][4];
				$justificacion=$registro_ponderacion[0][5];
				unset($registro_ponderacion);
				unset($campos_ponderacion);
				
			}
			else
			{
				$ponderacion=0;
				$justificacion="";
			}
?>		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				<b><?php echo $registro[$a][5] ?></b><br><?php echo $registro[$a][4] ?>
			</td>
			<td bgcolor='<?php echo $tema->celda ?>' align="center">
				<input style="text-align:center;" type='text' name='componente_<? 
				
				//Componente: id_modelo.id_componente.nivel.id_padre
				echo $mi_componente;
				
				?>' value='<?php echo $ponderacion ?>' size='2' maxlength='3' tabindex='<?php echo $tab++ ?>' >
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' align="center" colspan="2">
				<textarea cols="50" rows="2" name='observacion_<? 
				
				//Componente: id_modelo.id_componente.nivel.id_padre
				echo $mi_componente;
				
				?>' tabindex='<?php echo $tab++ ?>' ><?php echo $justificacion; ?></textarea>
			</td>
		</tr>
		<?php
		}
?>		<tr align='center'>
			<td colspan='2' rowspan='1' align='center'>
				<table align='center' width='50%'>
				<tr align='center'>
				<td>
					<input type='hidden' name='action' value='registro_ponderacion_basico'>
					<input type='hidden' name='id_esquema' value='<?php echo $_GET['id_esquema'] ?>'>
					<input type='hidden' name='opcion' value='<?php echo enlace("editar") ?>'>
					<input type='hidden' name='id_componente' value='<?php echo $id_componente ?>'>
					
					<input name='aceptar' value='Aceptar' type='submit' onclick="return (<?php echo $validar; ?>)"><br>
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


function mostrar_registro($registro,$configuracion,$tema,$accion,$id_componente,$id_usuario)
{
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$tab=1;
		$contador=0;
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="ponderar_componente">
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquecentralcuerpo">
		<tr align="center" class="mensajealertaencabezado">
			<td>
				Componente
			</td>
			<td>
				Importancia
			</td>
		</tr><?php	
	
		for($a=0;$a<(count($registro));$a++)
		{
			$mi_componente=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			$cadena_sql="SELECT ";
			$cadena_sql.="`id_esquema`, ";
			$cadena_sql.="`id_usuario`, ";
			$cadena_sql.="`componente_a`, ";
			$cadena_sql.="`componente_b`, ";
			$cadena_sql.="`valor`, ";
			$cadena_sql.="`observacion`, ";
			$cadena_sql.="`fecha` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."esquema_valor ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_esquema=".$_GET['id_esquema']." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_usuario=".$id_usuario." ";		
			$cadena_sql.="AND ";
			$cadena_sql.="componente_a='".$mi_componente."' ";		
			$cadena_sql.="LIMIT 1 ";
			
			//echo $cadena_sql."<br>";
			$acceso_db->registro_db($cadena_sql,0);
			$registro_ponderacion=$acceso_db->obtener_registro_db();
			$campos_ponderacion=$acceso_db->obtener_conteo_db();
			if($campos_ponderacion>0)
			{
				$ponderacion=$registro_ponderacion[0][4];
				$justificacion=$registro_ponderacion[0][5];
				unset($registro_ponderacion);
				unset($campos_ponderacion);
				
			}
			else
			{
				$ponderacion="N/D";
				$justificacion="";
			}
?>		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td>
				<b><?php echo $registro[$a][5] ?></b><br><?php echo $registro[$a][4] ?>
			</td>
			<td bgcolor='<?php echo $tema->celda ?>' align="center">
				<?php echo $ponderacion ?> 
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan="2">
				<b>Justificaci&oacute;n: </b><?php 
				
				echo $justificacion;
				
				?></textarea>
			</td>
		</tr>
		<?php
		}
?>		<tr align='center'>
			<td colspan='2' rowspan='1'>
				<input type='hidden' name='action' value='registro_ponderacion_basico'>
				<input type='hidden' name='id_esquema' value='<?php echo $_GET['id_esquema'] ?>'>
				<input name='cancelar' value='Regresar' type='submit'><br>
			</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
</form><?php
	}
}

?>