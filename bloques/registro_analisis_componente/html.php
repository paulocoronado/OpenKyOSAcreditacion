<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*****************************************************************************
* @subpackage   registro_analisis_componente
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Registro de analisis de componentes del modelo de evaluacion
*
*****************************************************************************/

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
	$id_componente=$_GET["id_componente"];
	$id_proceso=$_GET["id_proceso"];
	
	$mi_modelo=substr($_GET["id_componente"],0,3)/1;
	$mi_nivel=substr($_GET["id_componente"],3,3)/1;
	$mi_padre=substr($_GET["id_componente"],6,3)/1;
	$mi_componente=substr($_GET["id_componente"],9,3)/1;
	
	//echo "Modelo: ".$mi_modelo."<br>";
	//echo "Nivel: ".$mi_nivel."<br>";
	//echo "Componente: ".$mi_componente."<br>";
	
	//Buscar el registro:
	$cadena_sql="SELECT ";
	$cadena_sql.="`id_proceso`, ";
	$cadena_sql.="`id_usuario`, ";
	$cadena_sql.="`id_componente`, ";
	$cadena_sql.="`ponderacion`, ";
	$cadena_sql.="`cuantitativa`, ";
	$cadena_sql.="`cualitativa`, ";
	$cadena_sql.="`diagnostico`, ";
	$cadena_sql.="`juicio`, ";
	$cadena_sql.="`fortaleza`, ";
	$cadena_sql.="`debilidad`, ";
	$cadena_sql.="`amenaza`, ";
	$cadena_sql.="`oportunidad`, ";
	$cadena_sql.="`mejoramiento`, ";
	$cadena_sql.="`accion`, ";
	$cadena_sql.="`observacion` ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."analisis_componente "; 
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_usuario=".$id_usuario." "; 
	$cadena_sql.="AND ";
	$cadena_sql.="id_proceso=".$id_proceso." ";
	$cadena_sql.="AND ";
	$cadena_sql.="id_componente='".$id_componente."' ";
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
			
		?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
		<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table align='center' width='100%' cellpadding='7' cellspacing='1'>	
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'><?php
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
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Modelo:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'><?php
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre";
			$cadena_sql.=" FROM ".$configuracion["prefijo"]."modelo ";
			$cadena_sql.=" WHERE ";
			$cadena_sql.="id_modelo=".$mi_modelo;
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
				echo "Modelo desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Componente:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'><?php
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."modelo_componente ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_modelo=".$mi_modelo." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$mi_padre." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_componente=".$mi_componente." ";
			$cadena_sql.="AND ";
			$cadena_sql.="nivel=".$mi_nivel." ";
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
				echo "Proceso desconocido.";
			}
			
		?></td>
	</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Ponderaci&oacute;n:
			</td>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][3] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Valoraci&oacute;n Cuantitativa:
			</td>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][4] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Valoraci&oacute;n Cualitativa:
			</td>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][5] ?>
			</td>
		</tr>
	</table>
	<table align='center' width='100%' cellpadding='7' cellspacing='1'>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Diagn&oacute;stico:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][6] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Juicio:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][7] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Fortalezas:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][8] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Debilidades:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][9] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				amenaza:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][10] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Oportunidades:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][11] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Directrices de mejoramiento:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][12] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				Directrices de acci&oacute;n:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][13] ?>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				observacion:
			</td>
		</tr>
		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<?php echo $registro[0][14] ?>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
		
		
		
		<?php
		}
		else
		{	//Editar registro
			
			?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
			<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_analisis_componente'>
	<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table align='center' width='100%' cellpadding='7' cellspacing='1'>	
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'><?php
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
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Modelo:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'><?php
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre";
			$cadena_sql.=" FROM ".$configuracion["prefijo"]."modelo ";
			$cadena_sql.=" WHERE ";
			$cadena_sql.="id_modelo=".$mi_modelo;
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
				echo "Modelo desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Componente:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'><?php
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."modelo_componente ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_modelo=".$mi_modelo." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$mi_padre." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_componente=".$mi_componente." ";
			$cadena_sql.="AND ";
			$cadena_sql.="nivel=".$mi_nivel." ";
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
				echo "Proceso desconocido.";
			}
			
		?></td>
	</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				<b>Ponderaci&oacute;n:</b>
			</td>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<input type='hidden' name='id_proceso' value="<?php echo $_GET["id_proceso"]?>">
				<input type='hidden' name='id_usuario' value="<?php echo $id_usuario?>">
				<input type='hidden' name='id_componente' value="<?php echo $_GET["id_componente"]?>">
				<input type='text' name='ponderacion' value='<?php echo $registro[0][3] ?>' size='4' maxlength='7' tabindex='<?php echo $tab++ ?>' >%
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				<b>Valoraci&oacute;n cuantitativa</b>
			</td>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<input type='text' name='cuantitativa' value='<?php echo $registro[0][4] ?>' size='7' maxlength='7' tabindex='<?php echo $tab++ ?>' >
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>'>
				<b>Valoraci&oacute;n cualitativa</b>
			</td>
			<td bgcolor='<?php echo $tema->celda ?>'>
				<input type='text' name='cualitativa' value='<?php echo $registro[0][5] ?>' size='40' maxlength='255' tabindex='<?php echo $tab++ ?>' >
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Diagn&oacute;stico:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='diagnostico' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][6] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Juicio del grado de cumplimiento:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='juicio' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][7] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Fortalezas:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='fortaleza' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][8] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Debilidades:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='debilidad' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][9] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Amenazas:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='amenaza' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][10] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Oportunidades:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='oportunidad' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][11] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Directrices de mejoramiento:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='mejoramiento' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][12] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Directrices de acci&oacute;n:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='accion' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][13] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
				<b>Observaciones generales:</b>
			</td>
		</tr>
		<tr>
			<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
				<textarea name='observacion' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][14] ?></textarea>
			</td>
		</tr>
		<tr align='center'>
			<td colspan='2' rowspan='1'>
				<input type='hidden' name='action' value='registro_analisis_componente'>
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
		?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_analisis_componente'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'><?php
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
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Modelo:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'><?php
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre";
			$cadena_sql.=" FROM ".$configuracion["prefijo"]."modelo ";
			$cadena_sql.=" WHERE ";
			$cadena_sql.="id_modelo=".$mi_modelo;
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
				echo "Modelo desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Componente:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'><?php
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."modelo_componente ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_modelo=".$mi_modelo." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$mi_padre." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_componente=".$mi_componente." ";
			$cadena_sql.="AND ";
			$cadena_sql.="nivel=".$mi_nivel." ";
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
				echo "Proceso desconocido.";
			}
			
		?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Ponderaci&oacute;n:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<input type='hidden' name='id_proceso' value="<?php echo $_GET["id_proceso"]?>">
			<input type='hidden' name='id_usuario' value="<?php echo $id_usuario?>">
			<input type='hidden' name='id_componente' value="<?php echo $_GET["id_componente"]?>">
			<input type='text' name='ponderacion' size='4' maxlength='7' tabindex='<?php echo $tab++ ?>' >%
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Valoraci&oacute;n Cuantitativa:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<input type='text' name='cuantitativa' size='7' maxlength='7' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>'>
			<b>Valoraci&oacute;n Cualitativa:</b>
		</td>
		<td bgcolor='<?php echo $tema->celda ?>'>
			<input type='text' name='cualitativa' size='40' maxlength='255' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Diagn&oacute;stico:</b>
		</td>
	<tr>
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='diagnostico' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Juicio:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='juicio' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Fortalezas:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='fortaleza' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Debilidades:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='debilidad' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Amenazas:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='amenaza' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Oportunidades:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='oportunidad' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Directrices de Mejoramiento:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='mejoramiento' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Directrices de acci&oacute;n:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='accion' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralencabezado' onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador++ ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2'>
			<b>Observaciones:</b>
		</td>
	</tr>
	<tr>	
		<td bgcolor='<?php echo $tema->celda ?>' colspan='2' align='center'>
			<textarea name='observacion' cols='80' rows='3' tabindex='<?php echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_analisis_componente'>
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
