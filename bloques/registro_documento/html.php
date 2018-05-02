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
?>
<?php  
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
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?><?php  
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
$tab=1;
$contador=0;
if(isset($_GET['registro']))
{
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql='SELECT nombre,id_tecnica,id_naturaleza,codigo_modelo,resumen FROM aplicativo_documento WHERE id_documento="'.$_GET['registro'].'" LIMIT 1';
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			if(isset($_GET["mostrar"]))
			{
	?>
<table class='bloquecentralmostrar' align='center' width='100%' cellpadding='5' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='0' cellspacing='1'>
	<tr class='bloquecentralcuerpo' >
		<td>
			<b><?php   echo $registro[0][0] ?></b>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td>
			C&oacute;digo Indicador: <b><?php   echo $registro[0][3] ?></b>
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td align="justify">
			<?php   echo $registro[0][4] ?>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
	<?php  	
			}
			else
			{	
		
			
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_documento" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="mensajealertaencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Registro para documentos:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="text-align: left; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Nombre:<br>
              </td>
              <td style="background-color: rgb(239, 239, 239);" colspan="1" rowspan="1">
		<input maxlength="80" size="30" tabindex="1" name="nombre" value="<?php   echo $registro[0][0] ?>"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td colspan="2" rowspan="1" class="mensajealertaencabezado">
                Clasificaci&oacute;n
	      </td>
            </tr>
           <tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Por t&eacute;cnica:<br>
              </td>
              <td colspan="1" rowspan="1" style="width: 128px; background-color: rgb(239, 239, 239);">
                <?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_tipo_documento,nombre FROM ".$configuracion["prefijo"]."tipo_documento WHERE tipo=0 ORDER BY nombre";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_tecnica',$configuracion,$registro[0][1],0,0);
echo $mi_cuadro;
            ?></td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Por naturaleza:<br>
              </td>
              <td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
              <?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_tipo_documento,nombre FROM ".$configuracion["prefijo"]."tipo_documento WHERE tipo=1 ORDER BY nombre";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_naturaleza',$configuracion,$registro[0][2],0,0);
echo $mi_cuadro;
            ?></td>
            </tr>
<tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>C&oacute;digo del indicador:<br>
              </td>
 	<td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
		<input maxlength="80" size="30" tabindex="4" name="codigo_modelo" value="<?php   echo $registro[0][3] ?>"><br>
		</td>
		</tr>
	<tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Resumen:<br>
              </td>
 	<td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
		<textarea cols="40" rows="5" name="resumen" tabindex="5"><?php   echo $registro[0][4] ?></textarea>
		</td>
		</tr>	
            <tr>
              <td align="center" colspan="2" rowspan="1">
  		<table width="50%" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center">
					<input type="hidden" name="action" value="registro_documento">
					<input type="hidden" name="registro" value="<?php   echo $_GET['registro'] ?>">
			      		<br><input value="Enviar" name="aceptar" type="submit" title="Guardar el registro.">
			      	</td>
			      	<td align="center">
			      		<br><input value="Cancelar" name="cancelar" type="submit" title="Regresar sin guardar.">
			      	</td>
		      </tr>
	      </table>
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
<?php  			
			}
		}	
	}	
}
else
{ // Si es un registro nuevo
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_documento'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class="mensajealertaencabezado">
              	<td colspan="2" rowspan="1" >Registro para documentos:</td>
        </tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<font color="red">*</font>Nombre:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<input type='text' name='nombre' size='40' maxlength='255' tabindex='<?php   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class="bloquecentralcuerpo">
              <td colspan="2" rowspan="1" class="mensajealertaencabezado">
                Clasificaci&oacute;n
	      </td>
         </tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<font color="red">*</font>Por T&eacute;cnica:
		</td>
		<td colspan="1" rowspan="1" style="width: 128px; background-color: rgb(239, 239, 239);">
                <?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_tipo_documento,nombre FROM ".$configuracion["prefijo"]."tipo_documento WHERE tipo=0 ORDER BY nombre";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_tecnica',$configuracion,-1,0,0);
echo $mi_cuadro;
            ?></td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<font color="red">*</font>Por Naturaleza:
		</td>
		<td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
              <?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_tipo_documento,nombre FROM ".$configuracion["prefijo"]."tipo_documento WHERE tipo=1 ORDER BY nombre";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_naturaleza',$configuracion,-1,0,0);
echo $mi_cuadro;
            ?>
	      </td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<font color="red">*</font>C&oacute;digo del Indicador:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<input type='text' name='codigo_modelo' size='12' maxlength='12' tabindex='<?php   echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador++ ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<font color="red">*</font>Resumen:
		</td>
		<td bgcolor='<?php   echo $tema->celda ?>'>
			<textarea name='resumen' cols='40' rows='5' tabindex='<?php   echo $tab++ ?>' ></textarea>
		</td>
	</tr>
	<tr>
              <td align="center" colspan="2" rowspan="1">
  		<table width="50%" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center">
					<input type="hidden" name="action" value="registro_documento">
					<br><input value="Enviar" name="aceptar" type="submit" title="Guardar el registro.">
			      	</td>
			      	<td align="center">
			      		<br><input value="Cancelar" name="cancelar" type="submit" title="Regresar sin guardar.">
			      	</td>
		      </tr>
	      </table>
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
