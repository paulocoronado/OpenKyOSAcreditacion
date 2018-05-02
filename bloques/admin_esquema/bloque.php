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
/*************************************************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
**************************************************************************************************************
* @subpackage   admin_esquema
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para mostrar esquemas de ponderacion
*
*************************************************************************************************************/
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
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$id_usuario=$registro[0][0];
		unset($registro);
		unset($nueva_sesion);
		unset($esta_sesion);
	}
	
	
	
	
	if(isset($_GET['accion']))
	{
		
		$cadena_sql="SELECT ";
		$cadena_sql.="COUNT";
		$cadena_sql.="(";
		$cadena_sql.="id_esquema";
		$cadena_sql.=") ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."esquema_ponderacion ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_usuario=".$id_usuario;
		
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos==0)
		{
			//Error general
			exit;
		}
		else
		{
			$total_registro=$registro[0][0];
			unset($registro);
			
			if($total_registro==0)
			{
				sin_registro($configuracion);	
			
			}
			else
			{
				if(isset($_GET["hoja"]))
				{
					$hoja=$_GET["hoja"];
				}
				else
				{
					$hoja=1;
				}
				
				$hojas=(floor($campos/$configuracion["registros"])+1);
				
				if($hoja>$hojas)
				{
					$hoja=$hojas;
				}
				else
				{
					if($hoja<1)
					{
						$hoja=1;
					}
				}
				
				switch($_GET['accion'])
				{	
					//Todos los esquemas a los quie pertenece el usuario
					case '1':
						$cadena_hoja="SELECT ";
						$cadena_hoja.="`id_esquema`, ";
						$cadena_hoja.="`id_usuario`, ";
						$cadena_hoja.="`id_modelo`, ";
						$cadena_hoja.="`nombre`, ";
						$cadena_hoja.="`descripcion`, ";
						$cadena_hoja.="`observacion`, ";
						$cadena_hoja.="`fecha` ";
						$cadena_hoja.="FROM ";
						$cadena_hoja.=$configuracion["prefijo"]."esquema_ponderacion ";
						$cadena_hoja.="WHERE ";
						$cadena_hoja.="id_usuario=".$id_usuario." ";
						$cadena_hoja.="ORDER BY id_esquema ";						
						$cadena_hoja.="LIMIT ".(($hoja-1)*$configuracion['registros']).",".$configuracion['registros'];
						break;
					
					case '2':
					//Esquemas a los que pertenece el usuario que cumplen con un criterio dado	
						if(isset($_GET['busqueda']))
						{
							$buscar=explode(" ",$_GET['busqueda']);
						}	
						
						$buscar_nombre="";
						
						
						
						while (list ($clave, $val) = each ($buscar)) 
						{
							$buscar_nombre.="nombre like '%".$val."%' OR ";
						
						}
						
						$buscar_todo=substr($buscar_nombre,0,(strlen($buscar_nombre)-3));
						
						//echo $buscar_todo;
										
						$cadena_hoja="SELECT ";
						$cadena_hoja.="`id_esquema`, ";
						$cadena_hoja.="`id_usuario`, ";
						$cadena_hoja.="`id_modelo`, ";
						$cadena_hoja.="`nombre`, ";
						$cadena_hoja.="`descripcion`, ";
						$cadena_hoja.="`observacion`, ";
						$cadena_hoja.="`fecha` ";
						$cadena_hoja.="FROM ";
						$cadena_hoja.=$configuracion["prefijo"]."esquema_ponderacion ";
						$cadena_hoja.="WHERE ";
						$cadena_hoja.="id_usuario=".$id_usuario." ";
						$cadena_hoja.="AND ";
						$cadena_hoja.=$buscar_todo." ";
						$cadena_hoja.="ORDER BY id_esquema ";
						$cadena_hoja.="LIMIT ".(($hoja-1)*$configuracion['registros']).",".$configuracion['registros'];
						break;	
						
								
					
					default:
						
						$cadena_hoja="SELECT ";
						$cadena_hoja.="`id_esquema`, ";
						$cadena_hoja.="`id_usuario`, ";
						$cadena_hoja.="`id_modelo`, ";
						$cadena_hoja.="`nombre`, ";
						$cadena_hoja.="`descripcion`, ";
						$cadena_hoja.="`observacion`, ";
						$cadena_hoja.="`fecha` ";
						$cadena_hoja.="FROM ";
						$cadena_hoja.=$configuracion["prefijo"]."esquema_ponderacion ";
						$cadena_hoja.="WHERE ";
						$cadena_hoja.="id_usuario=".$id_usuario." ";
						$cadena_hoja.="ORDER BY id_esquema ";
						$cadena_hoja.="LIMIT ".(($hoja-1)*$configuracion['registros']).",".$configuracion['registros'];
						break;
							
					
				}
				//echo $cadena_hoja;
				$acceso_db->registro_db($cadena_hoja,0);
				$registro=$acceso_db->obtener_registro_db();
				$campos=$acceso_db->obtener_conteo_db();			
				//Validacion redundante
				if($campos>0)
				{
					if(isset($_GET["admin"]))
					{
						if(desenlace($_GET["admin"])=="lista")
						{
							con_registro($configuracion,$registro,$campos,$tema);
							navegacion($configuracion,$hoja,$total_registro);
						}
						else
						{
							estadistica($configuracion,$registro);
						}
					}		
					else
					{
						estadistica($configuracion,$campos);	
					}
				}
				else
				{
					sin_registro($configuracion);			
				}
			}	
		}
	}
}	

/****************************************************************
*  			Funciones				*
****************************************************************/

function sin_registro($configuracion)
{
?><table style="text-align: left;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
	<tr>
		<td >
			<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
					</td>
					<td align="left">
						<b>Actualmente no tiene esquemas de ponderaci&oacute;n asociados o creados.</b>
					</td>
				</tr>
			</table> 
		</td>
	</tr>  
</table><?php
}


function con_registro($configuracion,$registro,$campos,$tema)
{
?>
<script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
	<tr align="center" class="mensajealertaencabezado">
		<td>
			C&oacute;digo
		</td>
		<td>
			Nombre
		</td>
		<td colspan="2">
			Opciones
		</td>
	</tr><?php
	for($contador=0;$contador<$campos;$contador++)
	{
?>	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' align="center">
			<?php echo $registro[$contador][0]?>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>' align="center" >
			<?php echo $registro[$contador][3] ?>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>' align="center">
			<a href="<?php
			
			$opciones="page=".enlace("comite_ponderacion_esquema");
			$opciones.="&id_esquema=".$registro[$contador][0];
			
			echo $configuracion["host"].$configuracion["site"].'/index.php?'.$opciones; 
			
			?>" title="Ponderar los componentes del Modelo"><img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/ponderacion.png" border="0" /></a>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>' align="center">
			<a href="<?php
			
			$opciones="page=".enlace("comite_socializar_esquema");
			$opciones.="&id_esquema=".$registro[$contador][0];			
			echo $configuracion["host"].$configuracion["site"].'/index.php?'.$opciones;
			
			?>" title="Socializar el esquema de ponderaci&oacute;n al grupo de trabajo."><img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/socializar.png" border="0" /></a>
		</td>
	</tr><?php
	}
		?>
</table><br>
<?php
}

function navegacion($configuracion,$hoja,$total)
{
	$hojas=(floor($total/$configuracion["registros"])+1);

?><br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php
		if($hoja>1)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo ($hoja+1) ?>" href="<?php
	
	$variable="page=".enlace("seleccion_modelo");	
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='page' && $clave!='hoja')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}		
	}
	
	$variable.="&hoja=".($hoja-1);
	
	$variable=$configuracion["site"]."/index.php?".$variable;
	echo $variable;
	
	unset($clave);
	unset($val);
	unset($variable);
	
	

?>"><< Anterior</a>
	<?php	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	<script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script><?php
	
		$formulario="navegar";
		//Validacion de controles
		$validar="control_vacio(".$formulario.",'hoja')";
		$validar.="&&verificar_rango(".$formulario.",'hoja',1,".$hojas.")";
	
	?><form method="GET" name="navegar" onsubmit="return(<?php echo $validar; ?>)"><?php
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
	echo "Hoja  <input type='text' name='hoja' size='2' maxlength='4' value='".$hoja."'> de ".$hojas;	
	$inferior=(($configuracion["registros"]*($hoja-1))+1);
	$superior=(($configuracion["registros"]*($hoja-1))+25);
	if($superior>$total)
	{
		$superior=$total;
	}
	echo "<br>Registros: ".$inferior." - ".$superior." de ".$total;
	unset($inferior);
	unset($superior);
	?>	 
	</form>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?php
		if(($hoja+1)<$hojas)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo ($hoja+1) ?>" href="<?php
	$variable="page=".enlace("seleccion_modelo");	
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='page' && $clave!='hoja')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}		
	}
	
	$variable.="&hoja=".($hoja+1);
	
	$variable=$configuracion["site"]."/index.php?".$variable;
	echo $variable;
	
	unset($clave);
	unset($val);
	unset($variable);

?>">Siguiente>></a>
<?php
	}
?>
	</td>
</tr>
</table><?php
}

function estadistica($configuracion,$contador)
{?><table style="text-align: left;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
	<tr>
		<td >
			<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info.png" border="0" />
					</td>
					<td align="left">
						Actualmente hay <b><?php echo $contador ?> esquemas de ponderaci&oacute;n registrados en el sistema.
					</td>
				</tr>
				<tr class="bloquecentralcuerpo">
					<td align="right" colspan="2" >
						<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_comite_esquema').'&registro='.$_GET['registro'].'&accion=1&hoja=0&opcion='.enlace("mostrar").'&admin='.enlace("lista"); ?>">Ver m&aacute;s informaci&oacute;n >></a>
					</td>
				</tr>
			</table> 
		</td>
	</tr>  
</table>
<?php}
?>