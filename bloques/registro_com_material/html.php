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
//Verificar si se tiene un numero de usuario por el metodo GET:
//Puede manejarse cuatro tipos de acceso a este bloque:
// 1. Acceso para edición por parte del administrador
// 2. Acceso para registro de usuarios nuevos
// 3. Acceso para registro de usuarios nuevos por parte del administrador
// 4. Acceso para edición por parte de los usuarios

//Si esta editando
if(isset($_GET['id_material']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$cadena_sql="SELECT ";
	$cadena_sql.="nombre, ";
	$cadena_sql.="descripcion, ";
	$cadena_sql.="tipo, ";
	$cadena_sql.="anno, ";
	$cadena_sql.="identificacion ";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."com_material ";
	$cadena_sql.=" WHERE id_material='".$_GET['id_material']."'";	
	$cadena_sql.=" LIMIT 1";
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_com_material" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle" class="celdatabla">
        <table style="width: 100%; text-align: left; background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1">
          <tbody>
		<tr class="bloquecentralencabezado">
			<td colspan="2" rowspan="1" align="undefined" valign="undefined">Materiales de apoyo docente</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			<font color="red">*</font>Nombre:<br>
			</td>
			<td class="celdatabla" align="left" valign="top">
			<textarea cols="35" rows="1" name="nombre" tabindex="1"><?php   echo $registro[0][0] ?></textarea><br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			<font color="red">*</font>Descripci&oacute;n:<br>
			</td>
			<td class="celdatabla" align="left" valign="top">
			<textarea cols="35" rows="2" name="descripcion" tabindex="2"><?php   echo $registro[0][1] ?></textarea><br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla">
			<font color="red">*</font>Tipo de material:<br>
			</td>
			<td class="celdatabla">
			<input maxlength="255" size="35" tabindex="3" name="tipo" value="<?php   echo $registro[0][2] ?>"><br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top">
				<font color="red">*</font>A&ntilde;o de creaci&oacute;n:
			</td>
			<td class="celdatabla" valign="top" align="left"><?php  
				$contador=0;
				echo "<select name='anno' size='1' tabindex='4'>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					if($anno==$registro[0][3])
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
			</td>
		</tr>	 
		<tr>
			<td colspan="2" rowspan="1">
			<input type="hidden" name="action" value="registro_com_material">
			<input type="hidden" name="identificacion" value="<?php   echo $registro[0][4] ?>">
			<input type="hidden" name="id_material" value="<?php   echo $_GET['id_material'] ?>">
			<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="5">
			</div>
			</td>
		</tr>
	</tbody>
	</table>
     </td>
   </tr>
  </tbody>
 </table>
</form>
<?php  		}	
	}
}
else
{

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_com_material" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle" class="celdatabla">
        <table style="width: 100%; text-align: left; background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1">
          <tbody>
		<tr class="bloquecentralencabezado">
			<td colspan="2" rowspan="1" align="undefined" valign="undefined">Materiales de apoyo docente</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			<font color="red">*</font>Nombre:<br>
			</td>
			<td class="celdatabla" align="left" valign="top">
			<textarea cols="35" rows="1" name="nombre" tabindex="1"></textarea><br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			<font color="red">*</font>Descripci&oacute;n:<br>
			</td>
			<td class="celdatabla" align="left" valign="top">
			<textarea cols="35" rows="2" name="descripcion" tabindex="2"></textarea><br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla">
			<font color="red">*</font>Tipo de material:<br>
			</td>
			<td class="celdatabla">
			<input maxlength="255" size="35" tabindex="3" name="tipo"><br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top">
				<font color="red">*</font>A&ntilde;o de creaci&oacute;n:
			</td>
			<td class="celdatabla" valign="top" align="left"><?php  
				$contador=0;
				echo "<select name='anno' size='1' tabindex='4'>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					echo "<option value='".$anno."'>".$anno."</option>\n";
					
				}
				echo "</select>\n";
					?>
			</td>
		</tr>	 
		<tr>
			<td colspan="2" rowspan="1">
			<input type="hidden" name="action" value="registro_com_material">
			<input type="hidden" name="identificacion" value="<?php   echo $_GET['registro'] ?>">
			<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="5">
			</div>
			</td>
		</tr>
	</tbody>
	</table>
     </td>
   </tr>
  </tbody>
 </table>
</form>
<?php  
}
?>
