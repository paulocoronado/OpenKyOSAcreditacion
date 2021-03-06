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
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"usuario");
	$editor_propietario=$propietario[0][0]; 
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	$id_usuario=$propietario[0][0]; 
	unset($propietario); 
	unset($sesion);
	$tab=1;
	
	if(!isset($_GET["registro"]))
	{
		$id_proceso=1;
	
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registro_proceso" onsubmit="return (  control_vacio(this,'nombre') && verificar_rango(this,  'componentes',  1,15))">
<?PHP  /*Campos obligatorios para poder manejar desde un solo sitio todos los módulos*/?>
<input type="hidden" name= "action" value="registro_proceso">
<input type="hidden" name="id_proceso" value="<?PHP   echo $id_proceso; ?>">
<table class="bloquelateral" width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody>
<tr class="bloquecentralencabezado">
<td>Registro de Procesos<br>
</td>
</tr>
<tr>
<td>
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
		Fecha de Creaci&oacute;n:<br>
	</td>
	<td class="celdatabla">
		<input name="fecha_creacion" value="<?PHP   echo $fecha ?>" type="hidden">	
		<?PHP   echo $date ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Nombre del Proceso:
	</td>
	<td class="celdatabla">
	<input maxlength="150" size="50" tabindex="<?PHP   echo $tab++ ?>" name="nombre">
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Propietario:<br>
	</td>
	<td class="celdatabla">
	<input type="hidden" name="id_usuario" value="<?PHP   echo $id_usuario ?>">
	<?PHP   echo $editor_propietario ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Proyecto/Dependencia&nbsp; Responsable:<br>
	</td>
	<td class="celdatabla">
	<input maxlength="150" size="50" tabindex="<?PHP   echo $tab++ ?>" name="responsable">
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Descripci&oacute;n:<br>
	</td>
	<td class="celdatabla">
	<textarea cols="40" rows="6" name="descripcion" tabindex="<?PHP   echo $tab++ ?>"></textarea><br>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Presentaci&oacute;n:<br>
	</td>
	<td class="celdatabla">
	<textarea cols="40" rows="6" name="presentacion" tabindex="<?PHP   echo $tab++ ?>"></textarea>
	</td>
</tr>
<tr align="center">
<td colspan="3" rowspan="1">
<input name="aceptar" value="Aceptar" type="submit" tabindex="<?PHP   echo $tab++ ?>"><br>
</td>
</tr>
</tbody>
</table>
<br>
</td>
</tr>
</tbody>
</table>
</form>
<?PHP  
	}//fin del if para registro nuevo
	else
	{
		if(isset($_GET["mostrar"]))
		{
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
					for($contador=0;$contador<$total_artefacto;$contador++)
					{
?>

<tr class="bloquecentralcuerpo">
<td align="center" class="celdatabla" colspan="2">
	<a href="<?PHP  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_proceso_analista').'&artefacto='.$la_artefacto[$contador][0].'&proceso='.$registro[0][0]; ?>"><img width="12" height="12" src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/mas.png" alt="Ver Instrumentos" title="Ver instrumentos" border="0" /></A>
</td>
<td align="left" class="celdatabla" colspan="4">
<?PHP   echo $la_artefacto[$contador][1]; ?>
</td>
<td class="celdatabla" colspan="2" align="center">
<?PHP  
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
</TD>
</tr>
<?PHP        				} ?>
<?PHP  				}?>
</table><br>
<?PHP  
			}
		}//fin del if de mostrar
		else
		{
			
			
			
		}
	}	
}
else
{
	echo "El sistema est&aacute; fuera de l&iacute;nea. Por favor reintente m&aacute;s tarde.";
}
?> 
