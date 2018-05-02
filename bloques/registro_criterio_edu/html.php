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
?><?php  
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
		$cadena_sql.="`id_criterio`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`observacion`, ";
		$cadena_sql.="`tipo_documento` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."criterio_edu "; 
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
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
			<td bgcolor='<?php   echo $tema->celda ?>'>
				Nombre:
			</td>
			<td bgcolor='<?php   echo $tema->celda ?>'>
				<input type='hidden' name='id_criterio' value='<?php   echo $registro[0][0] ?>'>	
				<input type='text' name='nombre' value='<?php   echo $registro[0][1] ?>' size='40' maxlength='100' tabindex='<?php   echo $tab++ ?>' >
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
			<td bgcolor='<?php   echo $tema->celda ?>'>
				Observaci&oacute;n:
			</td>
			<td bgcolor='<?php   echo $tema->celda ?>'>
				<textarea name='observacion' cols='40' rows='2' tabindex='<?php   echo $tab++ ?>' ><?php   echo $registro[0][2] ?></textarea>
			</td>
		</tr>
		<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
			<td bgcolor='<?php   echo $tema->celda ?>'>
				Tipo de Documento
			</td>
			<td bgcolor='<?php   echo $tema->celda ?>'>
				<?php  
				include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
				$html=new html();
				$busqueda=array();
				$busqueda[0][0]="0";
				$busqueda[0][1]="General";
				$busqueda[1][0]="1";
				$busqueda[1][1]="Documento Programa";
				$mi_cuadro=$html->cuadro_lista($busqueda,'tipo_documento',$configuracion,$registro[0][3],0,0);
				echo $mi_cuadro;
				?>
			</td>
		</tr>
		<tr align='center'>
			<td colspan='2' rowspan='1'>
				<input type='hidden' name='action' value='registro_criterio_edu'>
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
		$cadena_sql.="`id_criterio`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`observacion`, ";
		$cadena_sql.="`tipo_documento` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."criterio_edu "; 
		$acceso_db->registro_db($cadena_hoja,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{?><table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>	
<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			Criterio:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][0] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			Nombre:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][1] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			Observaci&oacute;n:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<?php   echo $registro[0][2] ?>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			Tipo Documento:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
		<?php   echo $registro[0][3] ?>
		</td>
	</tr>
</table>
</td>
</tr>
</table><?php  
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
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			Nombre:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<input type='text' name='nombre' size='40' maxlength='100' tabindex='<?php   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			Observaci&oacute;n:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<textarea name='observacion' cols='20' rows='2' tabindex='<?php   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			Tipo de Documento:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'><?php  
				include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
				$html=new html();
				$busqueda=array();
				$busqueda[0][0]="0";
				$busqueda[0][1]="General";
				$busqueda[1][0]="1";
				$busqueda[1][1]="Documento Programa";
				$mi_cuadro=$html->cuadro_lista($busqueda,'tipo_documento',$configuracion,-1,0,0);
				echo $mi_cuadro;
				?>
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_criterio_edu'>
			<input name='aceptar' value='Aceptar' type='submit'><br>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</form>
<?php  



}



?>
