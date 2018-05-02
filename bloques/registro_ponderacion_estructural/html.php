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
****************************************************************************/
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
		
	$mi_modelo=($componentes[0]-1);
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
					editar_registro($configuracion,$tema,$accion,$registro,$id_componente,$id_usuario,$id_esquema);
				
				}
				else
				{
					if($accion=="nuevo")
					{
						nuevo_registro($configuracion,$tema,$accion,$registro,$id_componente,$id_esquema);
					
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
				mostrar_registro($registro,$configuracion,$tema,'mostrar',$id_componente,$id_usuario,$id_esquema);
				convenciones($registro);
				
			}
			else
			{
				nuevo_registro($configuracion,$tema,"nuevo",$registro,$id_componente,$id_esquema);
				convenciones($registro);
			}
		
		
		}
	}
  
}


/****************************************************************************************
*				Funciones						*
****************************************************************************************/
function nuevo_registro($configuracion,$tema,$accion,$registro,$id_componente,$id_esquema)
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
		for($b=0;$b<(count($registro));$b++)
		{
			for($a=0;$a<(count($registro));$a++)
			{
				if($a!=$b)
				{
				$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
				$mi_componente_b=$registro[$b][1]."_".$registro[$b][0]."_".$registro[$b][2]."_".$registro[$b][3];
				$incidencia="incidencia_". $mi_componente_a."_".$mi_componente_b;
				
				$validar.="&&control_vacio(".$formulario.",'".$incidencia."')";
				$validar.="&&verificar_rango(".$formulario.",'".$incidencia."',0,4)";
				}
					
			}
		}
		
				
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?php echo $formulario ?>">
<table class='bloquelateral' align='center' width='100%' cellpadding='1px' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="0px" cellspacing="1px" class="tablaponderacion"><?php
?>		<tr class='bloquecentralcuerpo'><?php
		for($a=0;$a<(count($registro)+1);$a++)
		{
			if($a!=0)
			{
?>			<td bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion" ><b><?php 
				echo ($a);
				?></b>
			</td>
			<?php
			}
			else
			{
?>			<td bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
			</td>
			<?php		
			}
		
		}
?>			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion">
				<b>Act</b>
			</td>
		</tr><?php
		for($b=0;$b<(count($registro));$b++)
		{
	
	?>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion"><b><?php 
				echo ($b+1);
				?></b>
			</td>
		<?php	
	
			for($a=0;$a<(count($registro));$a++)
			{
				$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
				$mi_componente_b=$registro[$b][1]."_".$registro[$b][0]."_".$registro[$b][2]."_".$registro[$b][3];
				if($a!=$b)
				{
				
					//Cuadro de incidencia
					$incidencia="incidencia_". $mi_componente_a."_".$mi_componente_b;
					$incidencia_anterior="anterior_". $mi_componente_a."_".$mi_componente_b;
					$actividad="actividad_". $mi_componente_b;			
					$pasividad="pasividad_". $mi_componente_a;	
							
					include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		
					$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
					$opciones="?";
					$opciones.="page=".enlace('justificacion_incidencia');
					$opciones.="&&incidencia=".$incidencia;
					$opciones.="&&id_esquema=".$id_esquema;
					
					
?>			<td class="celdaponderacion" align="center" >
				<input class="cuadro_plano" type='text' name='<?echo $incidencia; ?>' value='0' size='3' maxlength='3' tabindex='<?php echo $tab++ ?>' onchange="return(verificar_incidencia(<?php echo $formulario ?>,'<?echo $incidencia; ?>','<?echo $incidencia_anterior; ?>','<?echo $actividad; ?>','<?echo $pasividad; ?>','total'))" onDblClick="<?echo "abrir_ventana('".$ruta.$opciones."','Componente')";?>">
				<input type="hidden" name='<?echo $incidencia_anterior; ?>' value='0'>
				
			</td><?php		
				}
				else
				{
?>			<td bgcolor='<?php echo $tema->celda_oscura; ?>' align="center" class="celdaponderacion">
			</td><?php					
				
				}
			}
			//Cuadro de Actividad
?>			<td bgcolor='<?php echo $tema->apuntado; ?>' align="center" class="celdaponderacion">
				<input class="cuadro_plano" style="background-color: <?php echo $tema->apuntado ?>;" maxlength="4" size="3" readonly name="<?php echo $actividad ?>" value="0">
			</td><?php					
			
?>		</tr><?php
		}
?>		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion">
				<b>P</b>
			</td><?php
		for($a=0;$a<count($registro);$a++)
		{
			$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			$pasividad="pasividad_". $mi_componente_a;	
			//Cuadro de Pasividad			
?>			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion" >
				<input class="cuadro_plano" style="background-color: <?php echo $tema->apuntado ?>;" maxlength="4" size="3" readonly name="<?php echo $pasividad ?>" value="0">
			</td>
			<?php
			
		
		}
			//Cuadro de Total
?>			<td bgcolor='<?php echo $tema->seleccionado ?>' align="center" class="celdaponderacion">
				<input class="cuadro_plano" style="background-color: <?php echo $tema->seleccionado ?>;" maxlength="4" size="3" readonly name="total" value="0">	
			</td>
		</tr>
		<tr align='center'>
			<td colspan='<?php echo (count($registro)+1);?>' rowspan='1' align='center'>
				<table align='center' width='50%'>
				<tr align='center'>
				<td>
					<input type='hidden' name='action' value='registro_ponderacion_estructural'>
					<input type='hidden' name='id_esquema' value='<?php echo $_GET['id_esquema'] ?>'>
					<input type='hidden' name='opcion' value='<?php echo enlace($accion) ?>'>
					<input type='hidden' name='id_componente' value='<?php echo $id_componente ?>'>
					
					<input name='aceptar' value='Aceptar' type='button' onclick="return(<?php echo $validar; ?>)?this.form.submit():false"><br>
				</td>
				<td><?php
				
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				
				$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
				$opciones="?";
				$opciones.="page=".enlace('comite_ponderacion_esquema');
				$opciones.="&&id_esquema=".$id_esquema;				
				
					?><input name='cancelar' value='Cancelar' type='button' onclick="<?php echo "location.replace('".$ruta.$opciones."')" ?>"><br>
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



function convenciones($registro)
{
?>
<br>
<table class='bloquelateral' align='center' width='100%' cellpadding='5px' cellspacing='0'>
	<tr>
		<td>
			<table class='bloquecentralcuerpo' align='center' width='100%' cellpadding='2px' cellspacing='0'>	
				<tr>
					<td colspan="2">
						<b>Convenciones</b>
					</td>
				</tr>
<?php
	for($i=0;$i<(count($registro));$i++)
	{
			?>	<tr>
					<td>
					<b><?php echo ($i+1)?></b>
					</td>
					<td>
					<?php echo $registro[$i][5]?>
					</td>
				</tr>	
<?php		
	}
		
?>				<tr>
					<td>
					<b>Act</b>
					</td>
					<td>
					Actividad
					</td>
				</tr>	
				<tr>
					<td>
					<b>P</b>
					</td>
					<td>
					Pasividad
					</td>
				</tr>	
			</table>
		</td>
	</tr>
</table><?php	
}



function editar_registro($configuracion,$tema,$accion,$registro,$id_componente,$id_usuario,$id_esquema)
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
		for($b=0;$b<(count($registro));$b++)
		{
			for($a=0;$a<(count($registro));$a++)
			{
				if($a!=$b)
				{
				$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
				$mi_componente_b=$registro[$b][1]."_".$registro[$b][0]."_".$registro[$b][2]."_".$registro[$b][3];
				$incidencia="incidencia_". $mi_componente_a."_".$mi_componente_b;
				
				$validar.="&&control_vacio(".$formulario.",'".$incidencia."')";
				$validar.="&&verificar_rango(".$formulario.",'".$incidencia."',0,4)";
				}
					
			}
		}
		
				
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?php echo $formulario ?>">
<table class='bloquelateral' align='center' width='100%' cellpadding='1px' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="0px" cellspacing="1px" class="tablaponderacion"><?php
?>		<tr class='bloquecentralcuerpo'><?php
		for($a=0;$a<(count($registro)+1);$a++)
		{
			$total_pasividad[$a]=0;
			if($a!=0)
			{
?>			<td bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion" ><b><?php 
				echo ($a);
				?></b>
			</td>
			<?php
			}
			else
			{
?>			<td bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
			</td>
			<?php		
			}
		
		}
?>			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion">
				<b>Act</b>
			</td>
		</tr><?php
		for($b=0;$b<(count($registro));$b++)
		{
	
	?>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion"><b><?php 
				echo ($b+1);
				?></b>
			</td>
		<?php	
			$total_actividad=0;
			for($a=0;$a<(count($registro));$a++)
			{
				$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
				$mi_componente_b=$registro[$b][1]."_".$registro[$b][0]."_".$registro[$b][2]."_".$registro[$b][3];
				if($a!=$b)
				{
				
					//Cuadro de incidencia
					$incidencia="incidencia_". $mi_componente_a."_".$mi_componente_b;
					$incidencia_anterior="anterior_". $mi_componente_a."_".$mi_componente_b;
					$actividad="actividad_". $mi_componente_b;			
					$pasividad="pasividad_". $mi_componente_a;	
							
					include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		
					$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
					$opciones="?";
					$opciones.="page=".enlace('justificacion_incidencia');
					$opciones.="&&incidencia=".$incidencia;
					$opciones.="&&id_esquema=".$id_esquema;
					
					//Buscar si esta registrado
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
					$cadena_sql.="id_esquema=".$id_esquema." ";
					$cadena_sql.="AND ";
					$cadena_sql.="componente_a='".$mi_componente_a."' ";
					$cadena_sql.="AND ";
					$cadena_sql.="componente_b='".$mi_componente_b."' ";
					$cadena_sql.="AND ";
					$cadena_sql.="id_usuario=".$id_usuario." ";	
					$cadena_sql.="LIMIT 1 ";
					
					//echo $cadena_sql;
					$acceso_db->registro_db($cadena_sql,0);
					$registro_ponderacion=$acceso_db->obtener_registro_db();
					$campos_ponderacion=$acceso_db->obtener_conteo_db();
					if($campos_ponderacion>0)
					{
						$ponderacion=$registro_ponderacion[0][4];
						$total_actividad+=$ponderacion;
						$total_pasividad[$a]+=$ponderacion;
						
					}
					else
					{
						$ponderacion=0;
					}
					
?>			<td class="celdaponderacion" align="center" >
				<input class="cuadro_plano" type='text' name='<?echo $incidencia; ?>' value='<?php echo $ponderacion ?>' size='3' maxlength='3' tabindex='<?php echo $tab++ ?>' onchange="return(verificar_incidencia(<?php echo $formulario ?>,'<?echo $incidencia; ?>','<?echo $incidencia_anterior; ?>','<?echo $actividad; ?>','<?echo $pasividad; ?>','total'))" onDblClick="<?echo "abrir_ventana('".$ruta.$opciones."','Componente')";?>">
				<input type="hidden" name='<?echo $incidencia_anterior; ?>' value='<?php echo $ponderacion ?>'>
				
			</td><?php		
				}
				else
				{
?>			<td bgcolor='<?php echo $tema->celda_oscura; ?>' align="center" class="celdaponderacion">
			</td><?php					
				
				}
			}
			//Cuadro de Actividad
?>			<td bgcolor='<?php echo $tema->apuntado; ?>' align="center" class="celdaponderacion">
				<input class="cuadro_plano" style="background-color: <?php echo $tema->apuntado ?>;" maxlength="4" size="3" readonly name="<?php echo $actividad ?>" value="<?php echo $total_actividad ?>">
			</td><?php					
			
?>		</tr><?php
		}
?>		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion">
				<b>P</b>
			</td><?php
		$total=0;	
		for($a=0;$a<count($registro);$a++)
		{
			$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			$pasividad="pasividad_". $mi_componente_a;				
			//Cuadro de Pasividad			
?>			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion" >
				<input class="cuadro_plano" style="background-color: <?php echo $tema->apuntado ?>;" maxlength="4" size="3" readonly name="<?php echo $pasividad ?>" value="<?php echo $total_pasividad[$a]; $total+=$total_pasividad[$a]; ?>">
			</td>
			<?php
			
		
		}
			//Cuadro de Total
?>			<td bgcolor='<?php echo $tema->seleccionado ?>' align="center" class="celdaponderacion">
				<input class="cuadro_plano" style="background-color: <?php echo $tema->seleccionado ?>;" maxlength="4" size="3" readonly name="total" value="<?php echo $total ?>">	
			</td>
		</tr>
		<tr align='center'>
			<td colspan='<?php echo (count($registro)+1);?>' rowspan='1' align='center'>
				<table align='center' width='50%'>
				<tr align='center'>
				<td>
					<input type='hidden' name='action' value='registro_ponderacion_estructural'>
					<input type='hidden' name='id_esquema' value='<?php echo $_GET['id_esquema'] ?>'>
					<input type='hidden' name='opcion' value='<?php echo enlace($accion) ?>'>
					<input type='hidden' name='id_componente' value='<?php echo $id_componente ?>'>
										
					<input name='aceptar' value='Aceptar' type='button' onclick="return(<?php echo $validar; ?>)?this.form.submit():false"><br>
				</td>
				<td><?php
				
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				
				$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
				$opciones="?";
				$opciones.="page=".enlace('comite_ponderacion_esquema');
				$opciones.="&&id_esquema=".$id_esquema;				
				
					?><input name='cancelar' value='Cancelar' type='button' onclick="<?php echo "location.replace('".$ruta.$opciones."')" ?>"><br>
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


function mostrar_registro($registro,$configuracion,$tema,$accion,$id_componente,$id_usuario,$id_esquema)
{
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$formulario="ponderar_componente";
		
				
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?php echo $formulario ?>">
<table class='bloquelateral' align='center' width='100%' cellpadding='1px' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="0px" cellspacing="1px" class="tablaponderacion"><?php
?>		<tr class='bloquecentralcuerpo'><?php
		for($a=0;$a<(count($registro)+1);$a++)
		{
			$total_pasividad[$a]=0;
			if($a!=0)
			{
?>			<td width="<?php echo floor(100/(count($registro)+2)) ?>%" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion" ><b><?php 
				echo ($a);
				?></b>
			</td>
			<?php
			}
			else
			{
?>			<td width="<?php echo floor(100/(count($registro)+2)) ?>%" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
			</td>
			<?php		
			}
		
		}
?>			<td width="<?php echo floor(100/(count($registro)+2)) ?>%" bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion">
				<b>Act</b>
			</td>
		</tr><?php
		for($b=0;$b<(count($registro));$b++)
		{
	
	?>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion"><b><?php 
				echo ($b+1);
				?></b>
			</td>
		<?php	
			$total_actividad=0;
			
			for($a=0;$a<(count($registro));$a++)
			{
				$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
				$mi_componente_b=$registro[$b][1]."_".$registro[$b][0]."_".$registro[$b][2]."_".$registro[$b][3];
				if($a!=$b)
				{
				
					//Cuadro de incidencia
					$incidencia="incidencia_". $mi_componente_a."_".$mi_componente_b;
					$incidencia_anterior="anterior_". $mi_componente_a."_".$mi_componente_b;
					$actividad="actividad_". $mi_componente_b;			
					$pasividad="pasividad_". $mi_componente_a;	
							
					include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		
					$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
					$opciones="?";
					$opciones.="page=".enlace('justificacion_incidencia');
					$opciones.="&&incidencia=".$incidencia;
					$opciones.="&&id_esquema=".$id_esquema;
					
					//Buscar si esta registrado
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
					$cadena_sql.="id_esquema=".$id_esquema." ";
					$cadena_sql.="AND ";
					$cadena_sql.="componente_a='".$mi_componente_a."' ";
					$cadena_sql.="AND ";
					$cadena_sql.="componente_b='".$mi_componente_b."' ";
					$cadena_sql.="AND ";
					$cadena_sql.="id_usuario=".$id_usuario." ";	
					$cadena_sql.="LIMIT 1 ";
					
					//echo $cadena_sql;
					$acceso_db->registro_db($cadena_sql,0);
					$registro_ponderacion=$acceso_db->obtener_registro_db();
					$campos_ponderacion=$acceso_db->obtener_conteo_db();
					if($campos_ponderacion>0)
					{
						$ponderacion=$registro_ponderacion[0][4];
						$total_actividad+=$ponderacion;
						$total_pasividad[$a]+=$ponderacion;
						
					}
					else
					{
						$ponderacion=0;
					}
					
?>			<td class="celdaponderacion" bgcolor='<?php echo $tema->celda_oscura; ?>' align="center" >
				<?php echo $ponderacion ?>				
			</td><?php		
				}
				else
				{
?>			<td bgcolor='<?php echo $tema->celda_oscura; ?>' align="center" class="celdaponderacion">
			</td><?php					
				
				}
			}
			//Cuadro de Actividad
?>			<td bgcolor='<?php echo $tema->apuntado; ?>' align="center" class="celdaponderacion">
				<?php echo $total_actividad ?>
			</td><?php					
			
?>		</tr><?php
		}
?>		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion">
				<b>P</b>
			</td><?php
		$total=0;
		for($a=0;$a<count($registro);$a++)
		{
			$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
			$pasividad="pasividad_". $mi_componente_a;	
			//Cuadro de Pasividad			
?>			<td bgcolor='<?php echo $tema->apuntado ?>' align="center" class="celdaponderacion" >
				<?php echo $total_pasividad[$a]; $total+=$total_pasividad[$a]; ?>
			</td>
			<?php
			
		
		}
			//Cuadro de Total
?>			<td bgcolor='<?php echo $tema->seleccionado ?>' align="center" class="celdaponderacion">
				<?php echo $total?>
			</td>
		</tr>
		<tr align='center'>
			<td colspan='<?php echo (count($registro)+2);?>' rowspan='1' align='center'>
				<table align='center' width='50%'>
				<tr align='center'>
					<td><?php
					
					include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
					
					$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
					$opciones="?";
					$opciones.="page=".enlace('comite_ponderacion_esquema');
					$opciones.="&&id_esquema=".$id_esquema;				
					
						?><input name='cancelar' value='Regresar' type='button' onclick="<?php echo "location.replace('".$ruta.$opciones."')" ?>"><br>
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

?>