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
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de egresados
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?><?PHP  
//Verificar si se tiene un numero de usuario por el metodo GET:
//Puede manejarse cuatro tipos de acceso a este bloque:
// 1. Acceso para edición por parte del administrador
// 2. Acceso para registro de usuarios nuevos
// 3. Acceso para registro de usuarios nuevos por parte del administrador
// 4. Acceso para edición por parte de los usuarios

//Con el parametro opcion se determina la accion a tomar


include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");


if(isset($_GET['opcion']))
{
	$accion=$_GET['opcion'];
}
else
{
	$accion="nuevo";
}



if($accion=="editar")
{
	editar_registro($configuracion,$tema);
}
else
{
	//Si se esta mostrando
	if($accion=="mostrar")
	{
		mostrar_registro($configuracion,$tema);
	
	}
	else
	{
		if($accion=="nuevo")
		{
			nuevo_registro($configuracion,$tema);
		
		}
	}

}


function editar_registro($configuracion,$tema)
{
	$tab=1;
	$contador=0;
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="`id_informe`, ";
		$cadena_sql.="`id_subsistema`, ";
		$cadena_sql.="`id_programa`, ";
		$cadena_sql.="`codigo_componente`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`nombre_interno`, ";
		$cadena_sql.="`observacion` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."informe "; 
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			?>
	<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_informe'>
	<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
		<tr>
		<td>
		<table align='center' width='100%' cellpadding='7' cellspacing='1'>	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					id_informe
				</td>
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					<input type='text' name='id_informe' value='<?PHP   echo $registro[0][0] ?>' size='10' maxlength='10' tabindex='<?PHP   echo $tab++ ?>' >
				</td>
			</tr>
			<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					id_subsistema
				</td>
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					<input type='text' name='id_subsistema' value='<?PHP   echo $registro[0][1] ?>' size='7' maxlength='7' tabindex='<?PHP   echo $tab++ ?>' >
				</td>
			</tr>
			<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					id_programa
				</td>
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					<input type='text' name='id_programa' value='<?PHP   echo $registro[0][2] ?>' size='5' maxlength='5' tabindex='<?PHP   echo $tab++ ?>' >
				</td>
			</tr>
			<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					codigo_componente
				</td>
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					<input type='text' name='codigo_componente' value='<?PHP   echo $registro[0][3] ?>' size='20' maxlength='20' tabindex='<?PHP   echo $tab++ ?>' >
				</td>
			</tr>
			<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					nombre
				</td>
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					<textarea name='nombre' cols='20' rows='2' tabindex='<?PHP   echo $tab++ ?>' ><?PHP   echo $registro[0][4] ?></textarea>
				</td>
			</tr>
			<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					nombre_interno
				</td>
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					<input type='text' name='nombre_interno' value='<?PHP   echo $registro[0][5] ?>' size='40' maxlength='255' tabindex='<?PHP   echo $tab++ ?>' >
				</td>
			</tr>
			<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					observacion
				</td>
				<td bgcolor='<?PHP   echo $tema->celda ?>'>
					<textarea name='observacion' cols='20' rows='2' tabindex='<?PHP   echo $tab++ ?>' ><?PHP   echo $registro[0][6] ?></textarea>
				</td>
			</tr>
			<tr align='center'>
				<td colspan='2' rowspan='1'>
					<input type='hidden' name='action' value='registro_informe'>
					<input name='aceptar' value='Aceptar' type='submit'><br>
				</td>
			</tr>
		</table>
		</td>
		</tr>
		</table>
	</form><?PHP  
		
		}
	
	
	}
}


function mostrar_registro($configuracion,$tema)
{
	$tab=1;
	$contador=0;
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="`id_informe`, ";
		$cadena_sql.="`id_subsistema`, ";
		$cadena_sql.="`id_programa`, ";
		$cadena_sql.="`codigo_componente`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`nombre_interno`, ";
		$cadena_sql.="`observacion` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."informe "; 
		
		$acceso_db->registro_db($cadena_hoja,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{?><table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			id_informe:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][0] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			id_subsistema:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][1] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			id_programa:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][2] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			codigo_componente:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][3] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			nombre:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][4] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			nombre_interno:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][5] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			observacion:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][6] ?>
		</td>
	</tr>
</table>
</td>
</tr>
</table><?PHP  
		}
	}	
}


function nuevo_registro($configuracion,$tema)
{
$tab=1;
$contador=0;
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");

?><form enctype='multipart/form-data' method='POST' action='index.php' name='registro_informe'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<font color="red">*</font>Nombre:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='hidden' name='id_subsistema' value='<?PHP   echo $id_subsistema ?>' >
			<input type='hidden' name='id_programa'   value='<?PHP   echo $id_programa ?>' >
			<input type='hidden' name='codigo_componente' value='<?PHP  echo $_GET["indicador"] ?>'  >
			<textarea name='nombre' cols='35' rows='1' tabindex='<?PHP   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class="bloquecentralcuerpo">
		<td class="celdatabla" valign="top" align="left">
		<font color="red">*</font>Archivo a registrar:<br>
		</td>
		<td class="celdatabla" colspan="2" align="left">
		<input name='archivo' type='file' tabindex='3'>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<textarea name='observacion' cols='35' rows='2' tabindex='<?PHP   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_informe'>
			<input name='aceptar' value='Aceptar' type='submit'><br>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</form>
<?PHP  



}



?>
