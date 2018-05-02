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
		$cadena_sql.="`id_evidencia`, ";
		$cadena_sql.="`id_criterio`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`descripcion`, ";
		$cadena_sql.="`ponderacion`, ";
		$cadena_sql.="`justificacion` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."evidencia_edu ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_evidencia=".$_GET["evidencia"]." ";
		$cadena_sql.="AND ";
		$cadena_sql.="id_criterio=".$_GET["criterio"]." "; 
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			?>
	<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_criterio_edu'>
	<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>	
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Nombre:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='hidden' name='id_criterio' value='<?PHP   echo $registro[0][1] ?>'>
			<input type='hidden' name='id_evidencia' value='<?PHP   echo $registro[0][0] ?>' >
			<input type='text' name='nombre' value='<?PHP   echo $registro[0][2] ?>' size='40' maxlength='255' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<textarea name='descripcion' cols='20' rows='2' tabindex='<?PHP   echo $tab++ ?>' ><?PHP   echo $registro[0][3] ?></textarea>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Ponderaci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='text' name='ponderacion' value='<?PHP   echo $registro[0][4] ?>' size='2' maxlength='2' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Justificaci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<textarea name='justificacion' cols='20' rows='2' tabindex='<?PHP   echo $tab++ ?>' ><?PHP   echo $registro[0][5] ?></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_evidencia_edu'>
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
		$cadena_sql.="`id_evidencia`, ";
		$cadena_sql.="`id_criterio`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`descripcion`, ";
		$cadena_sql.="`ponderacion`, ";
		$cadena_sql.="`justificacion` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."evidencia_edu "; 
		$acceso_db->registro_db($cadena_hoja,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{?><table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			C&oacute;digo Evidencia:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][0] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Nombre:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][2] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][3] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Ponderaci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][4] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Justificaci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<?PHP   echo $registro[0][5] ?>
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
?><form enctype='multipart/form-data' method='POST' action='index.php' name='registro_criterio_edu'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Nombre:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='hidden' name='id_criterio' value="<?PHP   echo $_GET["criterio"]; ?>">
			<input type='text' name='nombre' size='40' maxlength='255' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Descripci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<textarea name='descripcion' cols='20' rows='2' tabindex='<?PHP   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Ponderaci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<input type='text' name='ponderacion' size='2' maxlength='2' tabindex='<?PHP   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador++ ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			Justificaci&oacute;n:
		</td>
		<td bgcolor='<?PHP   echo $tema->celda ?>'>
			<textarea name='justificacion' cols='20' rows='2' tabindex='<?PHP   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_evidencia_edu'>
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
