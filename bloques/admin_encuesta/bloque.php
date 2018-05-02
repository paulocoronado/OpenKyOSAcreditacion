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
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
****************************************************************************/
?><?php 

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$mi_proceso=$_REQUEST['proceso'];
	$cadena_sql="SELECT ";
	$cadena_sql.=" id_proceso,";
	$cadena_sql.="nombre,";
	$cadena_sql.="fecha_creacion,";
	$cadena_sql.="id_usuario,";
	$cadena_sql.="presentacion,";
	$cadena_sql.="descripcion,";
	$cadena_sql.="archivo,";
	$cadena_sql.="responsable";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
	$cadena_sql.=" WHERE ";
	$cadena_sql.="id_proceso=".$mi_proceso;
	$cadena_sql.=" LIMIT 1";
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		$el_proceso=$registro[0][1];
	}
	else
	{
		$el_proceso="Proceso no determinado";
	}
	
	$mi_artefacto=$_REQUEST['artefacto'];
	
	$cadena_sql="SELECT ";
	$cadena_sql.=$configuracion["prefijo"]."artefacto.nombre ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."artefacto ";
	$cadena_sql.="WHERE ";
	$cadena_sql.=$configuracion["prefijo"]."artefacto.id_artefacto=".$mi_artefacto." ";
	$cadena_sql.="LIMIT 1";
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		$el_artefacto=$registro[0][0];
	}
	else
	{
		$el_artefacto="Artefacto no determinado";
	}
	
	$cadena_sql="SELECT ";
	$cadena_sql.=$configuracion["prefijo"]."clave.clave, ";
	$cadena_sql.=$configuracion["prefijo"]."resultado.encuestado ";	
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."clave ";
	$cadena_sql.="LEFT JOIN ";
	$cadena_sql.=$configuracion["prefijo"]."resultado ";
	$cadena_sql.="ON ";
	$cadena_sql.=$configuracion["prefijo"]."clave.clave=".$configuracion["prefijo"]."resultado.encuestado ";	
	$cadena_sql.="WHERE ";
	$cadena_sql.=$configuracion["prefijo"]."clave.id_proceso=".$mi_proceso." ";
	$cadena_sql.="AND ";
	$cadena_sql.=$configuracion["prefijo"]."clave.id_artefacto=".$mi_artefacto." ";
	$cadena_sql.="GROUP BY ";
	$cadena_sql.=$configuracion["prefijo"]."clave.clave ";
	$cadena_sql.="ORDER BY ";
	$cadena_sql.=$configuracion["prefijo"]."clave.clave ";
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen claves en el sistema asociadas a este artefacto y proceso*/
		?>
<script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table class="bloquelateral" width="100%" border="0" cellpadding="1" cellspacing="0">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay claves registradas para este instrumento.</td>
    </tr>
    </tbody>
</table>
<?php 	
	}
	else
	{
/*Si existen claves en el sistema, se muestran en filas de 6 columnas*/
		$columna_diligenciada=0;
		$columna_no_diligenciada=0;
		$diligenciada="";
		$no_diligenciada="";
		$total_encuesta=0;
		
		for($contador=0;$contador<$campos;$contador++)
		{
			
			if($registro[$contador][1]!=NULL)
			{
				if($columna_diligenciada==0)
				{
					$diligenciada.="<tr class='bloquecentralcuerpo'>\n";
				}
				$diligenciada.="<td class='celdatabla' align='center'>\n";
				$diligenciada.="<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('mostrar_artefacto')."&usuario=".$registro[$contador][0]."&artefacto=".$mi_artefacto."&proceso=".$mi_proceso."'>".$registro[$contador][0]."</A>";
				$diligenciada.="</td>\n";
				$columna_diligenciada++;
				$total_encuesta++;
				if($columna_diligenciada==7)
				{
					$diligenciada.="</tr>\n";
					$columna_diligenciada=0;				
				}
			}
			else
			{	
				if($columna_no_diligenciada==0)
				{
					$no_diligenciada.="<tr class='bloquecentralcuerpo'>\n";
				}
				$no_diligenciada.="<td class='celdatabla' align='center'>\n";
				$no_diligenciada.=$registro[$contador][0];
				$no_diligenciada.="</td>\n";
				$columna_no_diligenciada++;
				if($columna_no_diligenciada==7)
				{
					$no_diligenciada.="</tr>\n";
					$columna_no_diligenciada=0;				
				}
				
			
			}
			
		}
		
		if($columna_diligenciada>0 && $columna_diligenciada<7)
		{
			for($contador=$columna_diligenciada;$contador<7;$contador++)
			{
				$diligenciada.="<td class='celdatabla' align='center'>\n";
				$diligenciada.="</td>\n";
			}			
			$diligenciada.="</tr>\n";
		}
		if($columna_no_diligenciada>0 && $columna_no_diligenciada<7)
		{
			for($contador=$columna_no_diligenciada;$contador<7;$contador++)
			{
				$no_diligenciada.="<td class='celdatabla' align='center'>\n";
				$no_diligenciada.="</td>\n";
			}			
			$no_diligenciada.="</tr>\n";
		}		
?><script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table class="bloquelateral" width="100%" border="0" cellpadding="1" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="5" cellspacing="1">
					<tbody>
						<tr align="left" class="bloquecentralcuerpo">
							<td class="celdatabla" width="30%">
							Proceso: 
							</td>
							<td class="celdatablacontenido">
							<b><?php  echo $el_proceso ?></b>
							</td>
						</tr>
						<tr align="left" class="bloquecentralcuerpo">
							<td class="celdatabla" width="30%">
							Instrumento: 
							</td>
							<td class="celdatablacontenido">
							<?php  echo $el_artefacto ?>
							</td>
						</tr>
						<tr align="left" class="bloquecentralcuerpo">
							<td class="celdatabla" width="30%">
							Claves generadas: 
							</td>
							<td class="celdatablacontenido">
							<b><?php  echo $campos;?></b>
							</td>
						</tr>
						<tr align="left" class="bloquecentralcuerpo">
							<td class="celdatabla" width="30%">
							Instrumentos Diligenciados:
							</td>
							<td class="celdatablacontenido">
							<b><?php  echo $total_encuesta;?></b>
							</td>
						</tr>
						<tr align="left" class="bloquecentralcuerpo">
							<td class="celdatabla" width="30%">
							Claves sin utilizar:
							</td>
							<td class="celdatablacontenido">
							<b><?php  echo ($campos-$total_encuesta);?></b>
							</td>
						</tr>
						<tr align="left" class="bloquecentralcuerpo">
							<td class="celdatabla" width="30%">
							Participaci&oacute;n:
							</td>
							<td class="celdatablacontenido">
							<b><?php  echo round(($total_encuesta/$campos)*100,2)."%";?></b>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>	
	</tbody>	
</table><br>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">	
	<tr align="center" class="bloquelateralencabezado">
		<td colspan="7">
		<?php  echo $total_encuesta;?> Instrumentos Diligenciados<br>
		</td>
	</tr><?php 
		if($total_encuesta>0)
		{
			echo $diligenciada;
		}
	?>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">	
	<tr align="center" class="bloquelateralencabezado">
		<td colspan="7">
		<?php  echo $campos-$total_encuesta;?> Claves sin Utilizar<br>
		</td>
	</tr><?php 
		if($total_encuesta<$campos)
		{
			echo $no_diligenciada;
		}
	?>	
</table><br>
<?php 
	}
}

?>
