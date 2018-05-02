<?PHP  
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?PHP  
/****************************************************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 20 de noviembre de 2005

*******************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formualrio para el registro de usuarios
* @usage        
*****************************************************************************************************************/ 
?><?PHP  
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");

$fecha=time();
$date=date('Y/m/d -H:i:s',$fecha);
// Rescatar el id_modelo desde la base de datos. Usando la función max
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{

//Rescatar la variable de sesion correspondiente al usuario actualmente registrado.	
	$sesion=new sesiones($configuracion);
	$sesion->especificar_enlace($enlace);
	$mi_sesion=$sesion->numero_sesion();
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"usuario");
	$editor_propietario=$propietario[0][0]; 
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	$id_usuario=$propietario[0][0]; 
	unset($propietario); 
	
	$tab=1;
	if(isset($_GET["mostrar"]))
	{
			if(isset($_GET["artefacto"]))
			{
				if(isset($_GET["mas"]))
				{
					if($_GET["mas"]==1)
					{
						$sesion->guardar_valor_sesion($configuracion,"artefacto_".$_GET["artefacto"],1,$mi_sesion);	
					}
					else
					{
						$sesion->borrar_valor_sesion($configuracion,"artefacto_".$_GET["artefacto"],$mi_sesion);
					}
				}
			}
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
			$cadena_sql.="id_proceso=".$_GET['registro'];
			$cadena_sql.=" LIMIT 1";
			//echo $cadena_sql;
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table class="bloquelateral" width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody>
<tr>
<td>
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatablacontenido" colspan="2" rowspan="1" align="center">
	<b><?PHP   echo $registro[0][1] ?></b><br>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
		Fecha de Creaci&oacute;n:<br>
	</td>
	<td class="celdatablacontenido">
		<?PHP   echo date("d/m/Y",$registro[0][2]) ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
		Informe de Resultados:<br>
	</td>
	<td class="celdatablacontenido">
		<a href='<?PHP   echo $configuracion["host"].$configuracion["site"]?>/index.php?page=<?PHP   echo enlace('ficha_resultado_total') ?>&usuario=<?PHP   echo $id_usuario ?>&proceso=<?PHP   echo $_GET['registro'] ?>'>Para un informe completo de los resultados click aqui.</a>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Elaborado por:<br>
	</td>
	<td class="celdatablacontenido"><?PHP  
			$busqueda="SELECT nombre ";
			$busqueda.="FROM ".$configuracion["prefijo"]."registrado ";
			$busqueda.="WHERE id_usuario=".$registro[0][3];
			$busqueda.=" LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$usuario=$acceso_db->obtener_registro_db();
			$total_usuario=$acceso_db->obtener_conteo_db();
			if($total_usuario>0)
			{	
				echo $usuario[0][0];
			}
			else
			{
				echo "No determinado";	
			}
	?></td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Proyecto/Dependencia&nbsp; Responsable:<br>
	</td>
	<td class="celdatablacontenido">
	<?PHP   echo $registro[0][7] ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Descripci&oacute;n:<br>
	</td>
	<td class="celdatablacontenido">
	<?PHP   echo $registro[0][5] ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Presentaci&oacute;n:<br>
	</td>
	<td class="celdatablacontenido">
	<?PHP   echo $registro[0][4] ?>
	</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<hr><br>
<?PHP  
				$busqueda="SELECT ";
				$busqueda.=" ".$configuracion["prefijo"]."p_artefacto.id_artefacto,";
				$busqueda.=" ".$configuracion["prefijo"]."artefacto.nombre,";
				$busqueda.=" ".$configuracion["prefijo"]."artefacto.tipo";
				$busqueda.=" FROM ";
				$busqueda.="".$configuracion["prefijo"]."p_artefacto,".$configuracion["prefijo"]."artefacto ";
				$busqueda.="WHERE ";
				$busqueda.="".$configuracion["prefijo"]."p_artefacto.id_proceso=".$_GET["registro"];
				$busqueda.=" AND ";
				$busqueda.="".$configuracion["prefijo"]."p_artefacto.id_artefacto=".$configuracion["prefijo"]."artefacto.id_artefacto ";
				$busqueda.=" ORDER BY ".$configuracion["prefijo"]."p_artefacto.id_artefacto ASC";
				//echo $busqueda;
				$acceso_db->registro_db($busqueda,0);
				$la_artefacto=$acceso_db->obtener_registro_db();
				$total_artefacto=$acceso_db->obtener_conteo_db();
				if($total_artefacto>0)
				{
					?>
<table width="100%" class="bloquecentral" cellpadding="5" cellspacing="1">					
<tr class="bloquecentralcuerpo">
<td>
<b>Instrumentos Asociados al Proceso</b>
</td>
</tr>
</table>
<br>
<table width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">					
					<?PHP  
					$fila=1;
					for($contador=0;$contador<$total_artefacto;$contador++)
					{
						if(!$sesion->rescatar_valor_sesion($configuracion,"artefacto_".$la_artefacto[$contador][0]) )
						{
?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?PHP   echo $fila ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>" align="center">
	<a href="<?PHP  
	
	$opciones="&registro=".$registro[0][0];
	$opciones.="&artefacto=".$la_artefacto[$contador][0];
	$opciones.="&mas=1";
	$opciones.="&mostrar=1";
	echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_proceso').$opciones; 
		
	?>"><img width="12" height="12" src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/mas.png" alt="Ver Instrumentos" title="Ver instrumentos" border="0" /></A>
</td>
<td bgcolor="<?PHP   echo $tema->celda ?>" align="left">
<?PHP   echo $la_artefacto[$contador][1]; ?>
</td>
<td bgcolor="<?PHP   echo $tema->celda ?>" align="center">
<?PHP  
						switch($la_artefacto[$contador][2])
						{
							case 1:
								echo  "<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('mostrar_encuestado')."&usuario=".$registro[0][0]."&artefacto=".$la_artefacto[$contador][0]."&proceso=".$_GET['registro']."'>Encuesta</A>";
								break;
								
							case 2:
								echo "<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('mostrar_encuestado')."&usuario=".$registro[0][0]."&artefacto=".$la_artefacto[$contador][0]."&proceso=".$_GET['registro']."'>Taller</A>";
								break;
									
							case 3:
								echo "<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('mostrar_encuestado')."&usuario=".$registro[0][0]."&artefacto=".$la_artefacto[$contador][0]."&proceso=".$_GET['registro']."'>Entrevista</A>";		
								break;
						
							default:
								echo "N/D";		
								break;
						}
				
?></td>
</tr>
<?PHP        					}
						else //Mostrar los instrumentos
						{
						?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>" align="center">
	<a href="<?PHP  
	
	$opciones="&registro=".$registro[0][0];
	$opciones.="&artefacto=".$la_artefacto[$contador][0];
	$opciones.="&mas=0";
	$opciones.="&mostrar=1";
	echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_proceso').$opciones; 
		
	?>"><img width="12" height="12" src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/menos.png" alt="Ocultar Instrumentos" title="Ocultar instrumentos" border="0" /></A>
</td>
<td bgcolor="<?PHP   echo $tema->celda ?>" align="left">
<b><?PHP   echo $la_artefacto[$contador][1]; ?></b>
</td>
<td bgcolor="<?PHP   echo $tema->celda ?>" align="center">
<?PHP  
						switch($la_artefacto[$contador][2])
						{
							case 1:
								echo  "<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('mostrar_encuestado')."&usuario=".$registro[0][0]."&artefacto=".$la_artefacto[$contador][0]."&proceso=".$_GET['registro']."'>Encuesta</A>";
								break;
								
							case 2:
								echo "<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('mostrar_encuestado')."&usuario=".$registro[0][0]."&artefacto=".$la_artefacto[$contador][0]."&proceso=".$_GET['registro']."'>Taller</A>";
								break;
									
							case 3:
								echo "<a href='".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('mostrar_encuestado')."&usuario=".$registro[0][0]."&artefacto=".$la_artefacto[$contador][0]."&proceso=".$_GET['registro']."'>Entrevista</A>";		
								break;
						
							default:
								echo "N/D";		
								break;
						}
				
?></td>
</tr><?PHP     					$busqueda="SELECT ";
						$busqueda.="".$configuracion["prefijo"]."a_instrumento.id_instrumento, ";
						$busqueda.="".$configuracion["prefijo"]."a_instrumento.orden ";
						$busqueda.="FROM ";
						$busqueda.="".$configuracion["prefijo"]."a_instrumento ";
						$busqueda.="WHERE ";
						$busqueda.="".$configuracion["prefijo"]."a_instrumento.id_artefacto=".$la_artefacto[$contador][0]." ";
						$busqueda.=" ORDER BY ".$configuracion["prefijo"]."a_instrumento.orden ASC";
						//echo $busqueda;
						$acceso_db->registro_db($busqueda,0);
						$el_instrumento=$acceso_db->obtener_registro_db();
						$total_instrumento=$acceso_db->obtener_conteo_db();
						if($total_instrumento>0)
						{
								
								for($a=0;$a<$total_instrumento;$a++)
								{
									$busqueda="SELECT ";
									$busqueda.="`id_instrumento` , ";
									$busqueda.="`fecha_creacion` , ";
									$busqueda.="`id_usuario` , ";
									$busqueda.="`nombre` , ";
									$busqueda.="`entidad_responsable` , ";
									$busqueda.="`presentacion` , ";
									$busqueda.="`comentario` , ";
									$busqueda.="`archivo_base` , ";
									$busqueda.="`estado` ";
									$busqueda.="FROM ";
									$busqueda.="`".$configuracion["prefijo"]."instrumento` ";
									$busqueda.="WHERE ";
									$busqueda.="id_instrumento=".$el_instrumento[$a][0]." ";
									$busqueda.="LIMIT 1";
									//echo $busqueda;
									$acceso_db->registro_db($busqueda,0);
									$mi_instrumento=$acceso_db->obtener_registro_db();
									$instrumento=$acceso_db->obtener_conteo_db();
									if($instrumento>0)
									{
							?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?PHP   echo $fila ?>, 'over', '<?PHP   echo $tema->celdacontenido ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila ?>, 'out', '<?PHP   echo $tema->celdacontenido ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++ ?>, 'click', '<?PHP   echo $tema->celdacontenido ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celdacontenido ?>" align="center">
<a href="#" onclick="abrir_ventana('<?PHP  
	
	$opciones=$configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_formulario');
	$opciones.='&opcion=mostrar';
	$opciones.='&proceso='.$registro[0][0]; 
	$opciones.='&artefacto='.$la_artefacto[$contador][0]; 
	$opciones.='&instrumento='.$mi_instrumento[0][0]; 
	echo $opciones; 		
	?>','Ficha_Formulario')"><img width="16" height="14" src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/tabla.png" alt="Ver Instrumento" title="Ver Instrumento" border="0" /></A>
</td>
<td bgcolor="<?PHP   echo $tema->celdacontenido ?>" align="left">
<a href="#" onclick="abrir_ventana('<?PHP  
$opciones=$configuracion["site"].'/index.php?page='.enlace('ficha_instrumento');
$opciones.='&opcion=mostrar';
$opciones.='&registro='.$mi_instrumento[0][0]; 
echo $opciones; 
?>','Ficha_instrumento')"><?PHP   echo $mi_instrumento[0][3]; ?>
</td>
<td bgcolor="<?PHP   echo $tema->celdacontenido ?>" align="center">
<a href="#" onclick="abrir_ventana('<?PHP  
	//$configuracion["host"].$configuracion["site"]
	$opciones=$configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_resultado');
	$opciones.='&opcion=mostrar';
	$opciones.='&proceso='.$registro[0][0]; 
	$opciones.='&artefacto='.$la_artefacto[$contador][0]; 
	$opciones.='&instrumento='.$mi_instrumento[0][0]; 
	echo $opciones; 		
	?>','Ficha_resultados')"><img width="16" height="16" src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info.png" alt="Ver resultados" title="Ver resultados" border="0" /></A>
</td>
</tr>
							
							<?PHP  
								}
								}
							
							}
							else
							{
							
							
							}
						
						
						}
					} ?>
<?PHP  				}?>
</table><br>
<?PHP  
			}
		}//fin del if de mostrar
		else
		{
			
			echo "Se&ntilde;or analista por favor solicite ser asociado a un proceso.";
			
		}
}
else
{
	echo "El sistema est&aacute; fuera de l&iacute;nea. Por favor reintente m&aacute;s tarde.";
}
?> 
