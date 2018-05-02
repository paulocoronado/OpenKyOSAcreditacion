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
?><?php  

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
	$esta_sesion=$sesion->numero_sesion();
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"usuario");
	$editor_propietario=$propietario[0][0]; 
	$propietario=$sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	$id_usuario=$propietario[0][0]; 
	unset($propietario); 
	unset($sesion);
	$tab=1;
	
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
	
	
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registro_proceso" onsubmit="return (  control_vacio(this,'nombre') && verificar_rango(this,  'componentes',  1,15))">
<?php  /*Campos obligatorios para poder manejar desde un solo sitio todos los módulos*/?>
<input type="hidden" name= "action" value="registro_aplicacion_proceso">
<input type="hidden" name="id_proceso" value="<?php   echo $registro[0][0] ?>">
<table class="bloquelateral" width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody>
<tr>
<td>
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
		Fecha de Creaci&oacute;n:<br>
	</td>
	<td class="celdatabla">
		<?php   echo date("d-M-Y",$registro[0][2]) ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Nombre del Proceso:
	</td>
	<td class="celdatabla">
	<?php   echo $registro[0][1] ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Propietario:<br>
	</td>
	<td class="celdatabla"><?php  
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
	<td class="celdatabla">
	<?php   echo $registro[0][7] ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Descripci&oacute;n:<br>
	</td>
	<td class="celdatabla">
	<?php   echo $registro[0][5] ?>
	</td>
</tr>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	Presentaci&oacute;n:<br>
	</td>
	<td class="celdatabla">
	<?php   echo $registro[0][4] ?>
	</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<hr><br>
<?php  
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
	for($contador=0;$contador<$total_artefacto;$contador++)
	{
?>
<input type="hidden" name="id_artefacto" value="1">
<input type="hidden" name="id_artefacto_<?PHP   echo $la_artefacto[$contador][0] ?>" value="1">
<table width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">
<tr class="bloquecentralcuerpo">
<td align="left" class="celdatabla" colspan="4">
<?php   echo $la_artefacto[$contador][1]; ?>
</td>
<td class="celdatabla" colspan="2" align="center">
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
<td align="center" class="celdatabla" colspan="2">
	<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_director_clave').'&artefacto='.$la_artefacto[$contador][0].'&proceso='.$registro[0][0]; ?>">Claves</A>
</td>
</tr>
<tr class="mensajealertaencabezado">
<td align="left" colspan="8">
El instrumento ser&aacute; aplicado:
</td>
</tr><?php  
 
	$cadena_sql="SELECT inicio,final FROM ".$configuracion["prefijo"]."aplicacion";
	$cadena_sql.=" WHERE ";
	$cadena_sql.=" id_artefacto=".$la_artefacto[$contador][0];
	$cadena_sql.=" AND id_proceso=".$_GET["registro"];
	$cadena_sql.=" LIMIT 1";
	//echo $cadena_sql;
	$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
	$acceso_db->registro_db($cadena_sql,0);
	$la_fecha=$acceso_db->obtener_registro_db();
	$total_fecha=$acceso_db->obtener_conteo_db();
	if($total_fecha>0)
	{
 		$anno_1=date('Y',$la_fecha[0][0]);
 		$mes_1=date('n',$la_fecha[0][0]);
 		$dia_1=date('d',$la_fecha[0][0])/1;
 		
 		
 		$anno_2=date('Y',$la_fecha[0][1]);
 		$mes_2=date('n',$la_fecha[0][1]);
 		$dia_2=date('d',$la_fecha[0][1])/1;
 	
 
 ?><tr class="bloquecentralcuerpo">
<td align="left" class="celdatabla">
<b>Desde:</b>
</td>
<td class="celdatabla" align="center">D&iacute;a: <?php  
		echo "<select name='dia_1_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($dia=1;$dia<32;$dia++)
		{	
			if($dia==$dia_1)
			{
				echo "<option selected='selected' value='".$dia."'>".$dia."</option>\n";
			}
			else
			{
				echo "<option value='".$dia."'>".$dia."</option>\n";
			}
		}		
		echo "</select>\n";
?></TD>
<td class="celdatabla" align="center">Mes: <?php  
		echo "<select name='mes_1_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($mes=1;$mes<13;$mes++)
		{	
			if($mes==$mes_1)
			{
				echo "<option selected='selected' value='".$mes."'>".$mes."</option>\n";
			}
			else
			{
				echo "<option value='".$mes."'>".$mes."</option>\n";
			}
			
			
		}		
		echo "</select>\n";

?></TD>
<td class="celdatabla" align="center">A&ntilde;o: <?php  
echo "<select name='anno_1_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($anno=2001;$anno<date("Y")+2;$anno++)
		{	
			if($anno==$anno_1)
			{
				echo "<option selected='selected' value='".$anno."'>".$anno."</option>\n";
			}
			else
			{
				echo "<option value='".$anno."'>".$anno."</option>\n";
			}
			
			
		}
		echo "</select>\n";

?>
</TD>
<td align="left" class="celdatabla">
<b>Hasta:</b>
</td>
<td class="celdatabla" align="center">
D&iacute;a: <?php  
		echo "<select name='dia_2_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($dia=1;$dia<32;$dia++)
		{	
			if($dia==$dia_2)
			{
				echo "<option selected='selected' value='".$dia."'>".$dia."</option>\n";
			}
			else
			{
				echo "<option value='".$dia."'>".$dia."</option>\n";
			}
			
		}		
		echo "</select>\n";
?></TD>
<td class="celdatabla" align="center">Mes: <?php  
		echo "<select name='mes_2_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($mes=1;$mes<13;$mes++)
		{	
			if($mes==$mes_2)
			{
				echo "<option selected='selected' value='".$mes."'>".$mes."</option>\n";
			}
			else
			{
				echo "<option value='".$mes."'>".$mes."</option>\n";
			}
			
		}		
		echo "</select>\n";

?></TD>
<td class="celdatabla" align="center">A&ntilde;o: <?php  
		echo "<select name='anno_2_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($anno=2001;$anno<date("Y")+2;$anno++)
		{	
			if($anno==$anno_2)
			{
				echo "<option selected='selected' value='".$anno."'>".$anno."</option>\n";
			}
			else
			{
				echo "<option value='".$anno."'>".$anno."</option>\n";
			}
			
		}
		echo "</select>\n";

?>
</TD>
</tr><?php  
	}
	else
	{

?><tr class="bloquecentralcuerpo">
<td align="left" class="celdatabla">
<b>Desde:</b>
</td>
<td class="celdatabla" align="center">D&iacute;a: <?php  
		echo "<select name='dia_1_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($dia=1;$dia<32;$dia++)
		{	
			echo "<option value='".$dia."'>".$dia."</option>\n";
			
		}		
		echo "</select>\n";
?></TD>
<td class="celdatabla" align="center">Mes: <?php  
		echo "<select name='mes_1_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($mes=1;$mes<13;$mes++)
		{	
			echo "<option value='".$mes."'>".$mes."</option>\n";
			
		}		
		echo "</select>\n";

?></TD>
<td class="celdatabla" align="center">A&ntilde;o: <?php  
echo "<select name='anno_1_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($anno=2001;$anno<date("Y")+2;$anno++)
		{	
			echo "<option value='".$anno."'>".$anno."</option>\n";
			
		}
		echo "</select>\n";

?>
</TD>
<td align="left" class="celdatabla">
<b>Hasta:</b>
</td>
<td class="celdatabla" align="center">
D&iacute;a: <?php  
		echo "<select name='dia_2_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($dia=1;$dia<32;$dia++)
		{	
			echo "<option value='".$dia."'>".$dia."</option>\n";
			
		}		
		echo "</select>\n";
?></TD>
<td class="celdatabla" align="center">Mes: <?php  
		echo "<select name='mes_2_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($mes=1;$mes<13;$mes++)
		{	
			echo "<option value='".$mes."'>".$mes."</option>\n";
			
		}		
		echo "</select>\n";

?></TD>
<td class="celdatabla" align="center">A&ntilde;o: <?php  
		echo "<select name='anno_2_".$la_artefacto[$contador][0]."' size='1'>\n";
		echo "<option value='0'> </option>\n";
		for($anno=2001;$anno<date("Y")+2;$anno++)
		{	
			echo "<option value='".$anno."'>".$anno."</option>\n";
			
		}
		echo "</select>\n";

?>
</TD>
</tr>

<?php        } ?>
</table><br>
<?php  	}
?>
<table  width='100%' align='center'>
<tbody>
<tr>
<td style='text-align:center'>
<input type='submit' name='actualizar' value='Actualizar' title='Acepta las fechas se&ntilde;aladas.' /></td>
</tr>
</tbody>
</table>
</form>
<?php  
	}
	else
	{
		echo "El sistema est&aacute; fuera de l&iacute;nea. Por favor reintente m&aacute;s tarde.";
	}
}
}
?>
