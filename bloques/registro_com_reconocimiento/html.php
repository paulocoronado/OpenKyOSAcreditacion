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
if(isset($_GET['id_reconocimiento']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT id_material,reconocimiento,descripcion,ambito";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."com_reconocimiento ";
		$cadena_sql.=" WHERE id_reconocimiento=".$_GET['id_reconocimiento'];
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_com_utilizacion" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
		<table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1">
		<tbody>
			<tr class="mensajealertaencabezado">
			<td colspan="2" rowspan="1" >Registro de reconocimiento dados al material:</td>
			</tr>
			<tr class="bloquecentralcuerpo">
					<td class="celdatabla" valign="top" align="left">
					<font color="red">*</font>Nombre:<br>
					</td>
					<td class="celdatabla" align="left" valign="top">
					<textarea cols="35" rows="1" name="nombre" tabindex="1"><?php   echo $registro[0][1] ?></textarea><br>
					</td>
			</tr>
			<tr class="bloquecentralcuerpo">
					<td class="celdatabla" valign="top" align="left">
					<font color="red">*</font>Descripci&oacute;n:<br>
					</td>
					<td class="celdatabla" align="left" valign="top">
					<textarea cols="35" rows="1" name="descripcion" tabindex="2"><?php   echo $registro[0][2] ?></textarea><br>
					</td>
			</tr>
			<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			<font color="red">*</font>Ambito:<br>
			</td>
			<td class="celdatabla" align="left" valign="top">
				<table cellpadding="2" cellspacing="5">
				<tbody>
				<tr class="bloquecentralcuerpo">
				<?php  
				if($registro[0][3]==0)
				{
					echo "<td>\n<input checked='checked' name='ambito' value='0' type='radio' tabindex='3'>Nacional";
					echo "</td>\n";
					echo "<td>\n";
					echo "<input  name='ambito' value='1' type='radio' tabindex='4'>Internacional";
					echo "</td>\n";
				}
				else
				{
					echo "<td>\n<input name='ambito' value='0' type='radio' tabindex='3'>Nacional";
					echo "</td>\n";
					echo "<td>\n";
					echo "<input checked='checked' name='ambito' value='1' type='radio' tabindex='4'>Internacional";
					echo "</td>\n";
				
				}	
				?>
				</tr>
				</tbody>
				</table>				
			</tr>
		<tr>
		<td colspan="2" rowspan="1">
		<input type="hidden" name="action" value="registro_com_reconocimiento"><br>
		<input type="hidden" name="identificacion" value="<?php   echo $_GET['registro'] ?>">
		<input type="hidden" name="id_material" value="<?php   echo $registro[0][0] ?>">
		<input type="hidden" name="id_reconocimiento" value="<?php   echo $_GET['id_reconocimiento'] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit"><br>
		</div>
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
else
{
	
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_com_utilizacion" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de reconocimiento dados al material:</td>
            </tr>
            <tr class="mensajealertaencabezado">
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
			<textarea cols="35" rows="1" name="descripcion" tabindex="2"></textarea><br>
			</td>
	  </tr>
	  <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Ambito:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table cellpadding="2" cellspacing="5">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td><input checked="checked" name="ambito" value="0" type="radio" tabindex="3">Nacional
		</td>
		<td>
		<input  name="ambito" value="1" type="radio" tabindex="4">Internacional
		</td>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
	    <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="action" value="registro_com_reconocimiento"><br>
              <input type="hidden" name="identificacion" value="<?php   echo $_GET['registro'] ?>">
              <input type="hidden" name="id_material" value="<?php   echo $_GET['id_material'] ?>">
              <div style="text-align: center;"><input value="enviar" name="aceptar" type="submit"><br>
              </div>
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
?>
