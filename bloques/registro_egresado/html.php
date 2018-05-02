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

//Si esta editando
if(isset($_GET['registro']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql='SELECT nombre,apellido,identificacion,id_programa,observacion FROM aplicativo_egresado WHERE identificacion="'.$_GET['registro'].'" LIMIT 1';
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?>
<script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_profesor" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && seleccion_valida(this,'programa') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Registro para egresados del programa:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="width: 318px; text-align: left; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Nombres:<br>
              </td>
              <td style="width: 365px; background-color: rgb(239, 239, 239);" colspan="1" rowspan="1">
		<input maxlength="80" size="40" tabindex="1" name="nombre" value="<?php   echo $registro[0][0]?>"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td style="width: 318px; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Apellidos:<br>
              </td>
              <td colspan="1" rowspan="1" style="width: 128px; background-color: rgb(239, 239, 239);">
                <input maxlength="80" size="40" tabindex="2" name="apellido" value="<?php   echo $registro[0][1]?>">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Identificaci&oacute;n:<br>
              </td>
              <td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
              <?php   echo $registro[0][2] ?>
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Observaciones:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="observacion" tabindex="5"><?php   echo $registro[0][4]?></textarea><br>
	    </td>
	    </tr>
	     <tr>
              <td colspan="2" rowspan="1">
                <input type="hidden" name="identificacion" value="<?php   echo $registro[0][2] ?>">
             	<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="action" value="registro_egresado">
		<input type="hidden" name="accion" value="editar">
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
<?php  		}
	}
}
else
{ // Si es un registro nuevo
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_egresado" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Registro para egresados del Programa:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="width: 318px; text-align: left; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Nombres:<br>
              </td>
              <td style="width: 365px; background-color: rgb(239, 239, 239);" colspan="1" rowspan="1">
		<input maxlength="80" size="40" tabindex="1" name="nombre"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td style="width: 318px; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Apellidos:<br>
              </td>
              <td colspan="1" rowspan="1" style="width: 128px; background-color: rgb(239, 239, 239);">
                <input maxlength="80" size="40" tabindex="2" name="apellido">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Identificaci&oacute;n:<br>
              </td>
              <td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
              <input maxlength="80" size="40" tabindex="3" name="identificacion">
	      </td>
            </tr>
             <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Observaciones:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="observacion" tabindex="5"></textarea><br>
	    </td>
	    </tr>
            <tr>
              <td colspan="2" rowspan="1">
             	<input type="hidden" name="action" value="registro_egresado">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario']?>">
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
