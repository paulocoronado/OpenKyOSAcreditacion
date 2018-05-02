<?php 
/*
############################################################################
#                                                                         #
#    Desarrollo Por: Tayron Ltda - Division Software                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@tayron.com.co                                             #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php 
/*************************************************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 20 de noviembre de 2005

**************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Interfaz para el acceder al analisis de instrumentos
* @usage        
*************************************************************************************************************/ 
?><?php 
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
	$propietario=$sesion->rescatar_valor_sesion("usuario");
	$editor_propietario=$propietario[0][0]; 
	$propietario=$sesion->rescatar_valor_sesion("id_usuario");
	$id_usuario=$propietario[0][0]; 
	unset($propietario); 
	
	$tab=1;
	
	if(isset($_GET["mostrar"]))
	{
		$busqueda="SELECT ";
		$busqueda.=" aplicativo_p_artefacto.id_artefacto,";
		$busqueda.=" aplicativo_artefacto.nombre,";
		$busqueda.=" aplicativo_artefacto.tipo";
		$busqueda.=" FROM ";
		$busqueda.="aplicativo_p_artefacto,aplicativo_artefacto ";
		$busqueda.="WHERE ";
		$busqueda.="aplicativo_p_artefacto.id_proceso=".$_GET["registro"];
		$busqueda.=" AND ";
		$busqueda.="aplicativo_p_artefacto.id_artefacto=aplicativo_artefacto.id_artefacto ";
		$busqueda.=" ORDER BY aplicativo_p_artefacto.id_artefacto ASC";
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
					<?php 
			$fila=1;
			for($contador=0;$contador<$total_artefacto;$contador++)
			{
				if(!$sesion->rescatar_valor_sesion("artefacto_".$la_artefacto[$contador][0]) )
				{
?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?php  echo $fila ?>, 'over', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php  echo $fila ?>, 'out', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php  echo $fila++ ?>, 'click', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');">
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
	<a href="<?php 
	
	$opciones="&registro=".$registro[0][0];
	$opciones.="&artefacto=".$la_artefacto[$contador][0];
	$opciones.="&mas=1";
	$opciones.="&mostrar=1";
	echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_proceso').$opciones; 
		
	?>"><img width="12" height="12" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/mas.png" alt="Ver Instrumentos" title="Ver instrumentos" border="0" /></A>
</td>
<td bgcolor="<?php  echo $tema->celda ?>" align="left">
<?php  echo $la_artefacto[$contador][1]; ?>
</td>
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
<?php 
//To Do Cargar los diferentes valores de los instrumentos desde la base de datos.						
						switch($la_artefacto[$contador][2])
						{
							case 1:
								echo "Encuesta";
								break;
								
							case 2:
								echo "Taller";
								break;
									
							case 3:
								echo "Entrevista";		
								break;
						
							default:
								echo "N/D";		
								break;
						}
				
?></td>
</tr>
<?php       					}
						else //Mostrar los instrumentos
						{
						?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?php  echo $contador ?>, 'over', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php  echo $contador ?>, 'out', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php  echo $contador ?>, 'click', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');">
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
	<a href="<?php 
	
	$opciones="&registro=".$registro[0][0];
	$opciones.="&artefacto=".$la_artefacto[$contador][0];
	$opciones.="&mas=0";
	$opciones.="&mostrar=1";
	echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_proceso').$opciones; 
		
	?>"><img width="12" height="12" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/menos.png" alt="Ocultar Instrumentos" title="Ocultar instrumentos" border="0" /></A>
</td>
<td bgcolor="<?php  echo $tema->celda ?>" align="left">
<b><?php  echo $la_artefacto[$contador][1]; ?></b>
</td>
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
<?php 
						switch($la_artefacto[$contador][2])
						{
							case 1:
								echo "Encuesta";
								break;
								
							case 2:
								echo "Taller";
								break;
									
							case 3:
								echo "Entrevista";		
								break;
						
							default:
								echo "N/D";		
								break;
						}
				
?></td>
</tr><?php    					$busqueda="SELECT ";
						$busqueda.="aplicativo_a_instrumento.id_instrumento, ";
						$busqueda.="aplicativo_a_instrumento.orden ";
						$busqueda.="FROM ";
						$busqueda.="aplicativo_a_instrumento ";
						$busqueda.="WHERE ";
						$busqueda.="aplicativo_a_instrumento.id_artefacto=".$la_artefacto[$contador][0]." ";
						$busqueda.=" ORDER BY aplicativo_a_instrumento.orden ASC";
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
									$busqueda.="`aplicativo_instrumento` ";
									$busqueda.="WHERE ";
									$busqueda.="id_instrumento=".$el_instrumento[$a][0]." ";
									$busqueda.="LIMIT 1";
									//echo $busqueda;
									$acceso_db->registro_db($busqueda,0);
									$mi_instrumento=$acceso_db->obtener_registro_db();
									$instrumento=$acceso_db->obtener_conteo_db();
									if($instrumento>0)
									{
							?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?php  echo $fila ?>, 'over', '<?php  echo $tema->celdacontenido ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php  echo $fila ?>, 'out', '<?php  echo $tema->celdacontenido ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php  echo $fila++ ?>, 'click', '<?php  echo $tema->celdacontenido ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');">
<td bgcolor="<?php  echo $tema->celdacontenido ?>" align="center">
<a href="#" onclick="abrir_ventana('<?php 
	
	$opciones=$configuracion["site"].'/index.php?page='.enlace('ficha_formulario');
	$opciones.='&opcion=mostrar';
	$opciones.='&proceso='.$registro[0][0]; 
	$opciones.='&artefacto='.$la_artefacto[$contador][0]; 
	$opciones.='&instrumento='.$mi_instrumento[0][0]; 
	echo $opciones; 		
	?>','Ficha_Formulario')"><img width="16" height="14" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/tabla.png" alt="Ver Instrumento" title="Ver Instrumento" border="0" /></A>
</td>
<td bgcolor="<?php  echo $tema->celdacontenido ?>" align="left">
<a href="#" onclick="abrir_ventana('<?php 
$opciones=$configuracion["site"].'/index.php?page='.enlace('ficha_instrumento');
$opciones.='&opcion=mostrar';
$opciones.='&registro='.$mi_instrumento[0][0]; 
echo $opciones; 
?>','Ficha_instrumento')"><?php  echo $mi_instrumento[0][3]; ?>
</td>
<td bgcolor="<?php  echo $tema->celdacontenido ?>" align="center">
<a href="#" onclick="abrir_ventana('<?php 
	
	$opciones=$configuracion["site"].'/index.php?page='.enlace('ficha_resultado');
	$opciones.='&opcion=mostrar';
	$opciones.='&proceso='.$registro[0][0]; 
	$opciones.='&artefacto='.$la_artefacto[$contador][0]; 
	$opciones.='&instrumento='.$mi_instrumento[0][0]; 
	echo $opciones; 		
	?>','Ficha_resultados')"><img width="16" height="16" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info.png" alt="Ver resultados" title="Ver resultados" border="0" /></A>
</td>
</tr>
							
							<?php 
								}
								}
							
							}
							else
							{
							
							
							}
						
						
						}
					} ?>
<?php 				}?>
</table><br>
<?php 
			}
		}//fin del if de mostrar
		else
		{
			
			
			
		}
}
else
{
	echo "El sistema est&aacute; fuera de l&iacute;nea. Por favor reintente m&aacute;s tarde.";
}
?> 
