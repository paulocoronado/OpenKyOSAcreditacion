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
if(isset($_GET['id_participacion']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	//Rescatar datos anuales, con nombre de programa y nombre del tipo de vinculacion
	$cadena_sql="SELECT ";
		$cadena_sql.="id_profesor_evento, ";
		$cadena_sql.="anno, ";
		$cadena_sql.="nombre, ";
		$cadena_sql.="ponencia, ";
		$cadena_sql.="lugar, ";
		$cadena_sql.="ambito, ";
		$cadena_sql.="observacion, ";
		$cadena_sql.="identificacion ";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor_info_evento ";
		$cadena_sql.=" WHERE id_profesor_evento=".$_GET['id_participacion']."";	
		$cadena_sql.=" LIMIT 1";
		//	0 id_profesor_evento
		//	1 anno
		//	2.nombre
		//	3.ponencia
		//	4.lugar
		//	5.ambito
		//	6.observacion
		//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_evento" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" >Participaci&oacute;n en eventos:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Nombre del evento:<br>
            </td>
            <td class="celdatabla" align="center" valign="top">
	    <textarea cols="40" rows="2" name="nombre"><?php   echo $registro[0][2] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>T&iacute;tulo de la ponencia o producto:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="ponencia"><?php   echo $registro[0][3] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Lugar:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="255" size="40" tabindex="1" name="lugar" value="<?php   echo $registro[0][4] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Ambito:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table>
		<tbody>
		<tr><?php  
		if($registro[0][5]==0)
		{
			echo "<td>\n<input checked='checked' name='ambito' value='0' type='radio'>Nacional";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input  name='ambito' value='1' type='radio'>Internacional";
			echo "</td>\n";
		}
		else
		{
			echo "<td>\n<input name='ambito' value='0' type='radio'>Nacional";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input checked='checked' name='ambito' value='1' type='radio'>Internacional";
			echo "</td>\n";
		
		}	
		?></tr>
		</tbody>
		</table>
	    </td>
	    </tr>
  <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla"  align="left" valign="top"><?php   $registro[0][1]?>
        </td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Observaciones:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="observacion"><?php   echo $registro[0][6] ?></textarea><br>
	    </td>
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dir_evento">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="anno" value="<?php   echo $registro[0][1] ?>">
		<input type="hidden" name="id_participacion" value="<?php   echo $registro[0][0] ?>">
		<input type="hidden" name="identificacion" value="<?php   echo $_GET['registro'] ?>">
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
{

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_evento" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Participaci&oacute;n en eventos:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Nombre del evento:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="nombre" tabindex="1"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>T&iacute;tulo de la ponencia o producto:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="ponencia" tabindex="2"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Lugar:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="255" size="40" tabindex="3" name="lugar"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Ambito:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table>
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td><input checked="checked" name="ambito" value="0" type="radio" tabindex="4">Nacional
		</td>
		<td>
		<input  name="ambito" value="1" type="radio" tabindex="5">Internacional
		</td>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
  <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla" valign="top" align="left"><?php  
		$contador=0;
		echo "<select name='anno' size='1' tabindex='6'>\n";
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			echo "<option value='".$anno."'>".$anno."</option>\n";
			
		}
		echo "</select>\n";
			?>
        </td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Observaciones:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="observacion" tabindex="7"></textarea><br>
	    </td>
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dir_evento">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="identificacion" value="<?php   echo $_GET['identificacion'] ?>">
              <div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="8">
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
