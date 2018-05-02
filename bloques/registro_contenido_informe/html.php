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
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   registro_analisis_componente
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Registro de analisis de componentes del modelo de evaluacion
*
*****************************************************************************************************************/
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
	$tab=1;
	$contador=0;
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$id_usuario=$registro[0][0];
	}
	
	$id_proceso=$_GET["id_proceso"];
	$id_final=$_GET["id_final"];
	$id_padre=$_GET["id_padre"];
	$id_seccion=$_GET["id_seccion"];
	$nivel=$_GET["nivel"];
	
	//echo "Modelo: ".$mi_modelo."<br>";
	//echo "Nivel: ".$mi_nivel."<br>";
	//echo "Componente: ".$mi_componente."<br>";
	
	//Buscar el registro:
	$cadena_sql="SELECT ";
	$cadena_sql.="`id_final`, ";
	$cadena_sql.="`id_seccion`, ";
	$cadena_sql.="`nivel`, ";
	$cadena_sql.="`id_padre`, ";
	$cadena_sql.="`id_proceso`, ";
	$cadena_sql.="`descripcion`, ";
	$cadena_sql.="`documento`, ";
	$cadena_sql.="`observacion`, ";
	$cadena_sql.="`id_usuario` ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."final_proceso "; 
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_usuario=".$id_usuario." "; 
	$cadena_sql.="AND ";
	$cadena_sql.="id_proceso=".$id_proceso." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_final=".$id_final." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_seccion=".$id_seccion." ";
	$cadena_sql.="LIMIT 1";
	$acceso_db->registro_db($cadena_sql,0);
	//Obtener el registro con el resultado de la busqueda			
	$registro=$acceso_db->obtener_registro_db();
	//Obtener el total de registros devueltos por la consulta
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
	
		if(isset($_GET["mostrar"])||isset($_POST["mostrar"])||isset($mostrar))
		{
			//Mostrar registro
			
		?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			id_final:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][0] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			id_seccion:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][1] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			nivel:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][2] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			id_padre:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][3] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			id_proceso:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][4] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			descripcion:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][5] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			documento:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][6] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			observacion:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][7] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			id_usuario:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][8] ?>
		</td>
	</tr>
</table>
</td>
</tr>
</table><?php  
		}
		else
		{	//Editar registro
			
			?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
			<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_contenido_informe'>
	<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table align='center' width='100%' cellpadding='7' cellspacing='1'>	
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'><?php  
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre";
			$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
			$cadena_sql.=" WHERE ";
			$cadena_sql.="id_proceso=".$_GET['id_proceso'];
			$cadena_sql.=" LIMIT 1";
			
			$acceso_db->registro_db($cadena_sql,0);
			$registro_proceso=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				echo $registro_proceso[0][0];
			}
			else
			{
				echo "Proceso desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'><?php  
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."final ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_final=".$_GET['id_final']." ";
			$cadena_sql.="LIMIT 1";
			
			$acceso_db->registro_db($cadena_sql,0);
			$registro_proceso=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				echo $registro_proceso[0][0];
			}
			else
			{
				echo "Informe desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'><?php  
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."final_estructura ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_final=".$id_final." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_seccion=".$id_seccion." ";
			$cadena_sql.="AND ";
			$cadena_sql.="nivel=".$nivel." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$id_padre." ";
			$cadena_sql.="LIMIT 1";
			//echo $cadena_sql;
			$acceso_db->registro_db($cadena_sql,0);
			$registro_proceso=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				echo "<b>".$registro_proceso[0][0]."</b>";
			}
			else
			{
				echo "Secci&oacute;n desconocida.";
			}
			
		?></td>
	</tr>
	
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<b>Documento:</b>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<input type='text' name='documento' value='<?php   echo $registro[0][6] ?>' size='40' maxlength='255' tabindex='<?php   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'>
			<b>Descripci&oacute;n:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2' align='center'>
			<input type='hidden' name='id_final' value="<?php   echo $_GET["id_final"]?>">
			<input type='hidden' name='id_seccion' value="<?php   echo $_GET["id_final"]?>">
			<input type='hidden' name='id_proceso' value="<?php   echo $_GET["id_proceso"]?>">
			<input type='hidden' name='id_padre' value="<?php   echo $_GET["id_padre"]?>">
			<input type='hidden' name='nivel' value="<?php   echo $_GET["nivel"]?>">
			<textarea name='descripcion' cols='80' rows='5' tabindex='<?php   echo $tab++ ?>' ><?php   echo $registro[0][5] ?></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'>
			<b>Observaci&oacute;n:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php   echo $tema->celda ?>' align='center' colspan='2' align='center'>
			<textarea name='observacion' cols='80' rows='5' tabindex='<?php   echo $tab++ ?>' ><?php   echo $registro[0][7] ?></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_contenido_informe'>
			<input name='aceptar' value='Aceptar' type='submit'><br>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
	</form><?php  
			
		}
	}
	else
	{
		//Si no se ha ingresado informacion del componente se crea un nuevo registro
		?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_contenido_informe'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'><?php  
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre";
			$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
			$cadena_sql.=" WHERE ";
			$cadena_sql.="id_proceso=".$_GET['id_proceso'];
			$cadena_sql.=" LIMIT 1";
			
			$acceso_db->registro_db($cadena_sql,0);
			$registro_proceso=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				echo $registro_proceso[0][0];
			}
			else
			{
				echo "Proceso desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'><?php  
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."final ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_final=".$_GET['id_final']." ";
			$cadena_sql.="LIMIT 1";
			
			$acceso_db->registro_db($cadena_sql,0);
			$registro_proceso=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				echo $registro_proceso[0][0];
			}
			else
			{
				echo "Informe desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'><?php  
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."final_estructura ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_final=".$id_final." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_seccion=".$id_seccion." ";
			$cadena_sql.="AND ";
			$cadena_sql.="nivel=".$nivel." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$id_padre." ";
			$cadena_sql.="LIMIT 1";
			//echo $cadena_sql;
			$acceso_db->registro_db($cadena_sql,0);
			$registro_proceso=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				echo "<b>".$registro_proceso[0][0]."</b>";
			}
			else
			{
				echo "Secci&oacute;n desconocida.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<b>Documento:</b>
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<input type='text' name='documento' size='40' maxlength='255' tabindex='<?php   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'>
			<b>Descripcion:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2' align='center'>
			<input type='hidden' name='id_final' value="<?php   echo $_GET["id_final"]?>">
			<input type='hidden' name='id_seccion' value="<?php   echo $_GET["id_final"]?>">
			<input type='hidden' name='id_proceso' value="<?php   echo $_GET["id_proceso"]?>">
			<input type='hidden' name='id_padre' value="<?php   echo $_GET["id_padre"]?>">
			<input type='hidden' name='nivel' value="<?php   echo $_GET["nivel"]?>">
			<textarea name='descripcion' cols='80' rows='5' tabindex='<?php   echo $tab++ ?>' ></textarea>
		</td>
	</tr>	
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2'>
			<b>Observaci&oacute;n:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php   echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='observacion' cols='80' rows='5' tabindex='<?php   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_contenido_informe'>
			<input name='aceptar' value='Aceptar' type='submit'><br>
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
