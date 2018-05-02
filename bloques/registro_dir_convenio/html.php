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
if(isset($_GET['registro']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	$cadena_sql="SELECT ";
	$cadena_sql.="nombre, ";
	$cadena_sql.="objetivo, ";
	$cadena_sql.="institucion, ";
	$cadena_sql.="ambito, ";
	$cadena_sql.="tipo, ";
	$cadena_sql.="movilidad, ";
	$cadena_sql.="estudiante, ";
	$cadena_sql.="interaccion, ";
	$cadena_sql.="profesor, ";
	$cadena_sql.="calidad, ";
	$cadena_sql.="anno";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_convenio ";
	$cadena_sql.=" WHERE id_convenio=".$_GET['registro']."";	
	$cadena_sql.=" LIMIT 1";
	
		//	0 nombre
		//	1.objetivo
		//	2.institucion
		//	3.ambito
		//	4.tipo
		//	5.movilidad
		//	6.estudiante
		//	7.interaccion
		//	8.profesor
		//	9.calidad
		//	10.anno
		//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_convenio" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle" class="celdatabla">
        <table style="width: 100%; text-align: left; background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Convenios o Actividades de Cooperaci&oacute;n</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nombre:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <?php   echo $registro[0][0] ?><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Objetivo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="objetivo" ><?php   echo $registro[0][1] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Tipo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table cellpadding="2" cellspacing="5">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<?php  
		if($registro[0][4]==0)
		{
			echo "<td>\n<input checked='checked' name='tipo' value='0' type='radio' tabindex='2'>Convenio";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input  name='tipo' value='1' type='radio' tabindex='3'>Actividad de Cooperaci&oacute;n";
			echo "</td>\n";
		}
		else
		{
			echo "<td>\n<input name='tipo' value='0' type='radio' tabindex='2'>Convenio";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input checked='checked' name='tipo' value='1' type='radio' tabindex='3'>Actividad de Cooperaci&oacute;n";
			echo "</td>\n";
		
		}	
		?>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Instituci&oacute;n con las que se suscribe:<br>(o instituciones)</td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="institucion" tabindex="4"><?php   echo $registro[0][2] ?></textarea><br>
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
			echo "<td>\n<input checked='checked' name='ambito' value='0' type='radio' tabindex='5'>Nacional";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input  name='ambito' value='1' type='radio' tabindex='6'>Internacional";
			echo "</td>\n";
		}
		else
		{
			echo "<td>\n<input name='ambito' value='0' type='radio' tabindex='5'>Nacional";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input checked='checked' name='ambito' value='1' type='radio' tabindex='6'>Internacional";
			echo "</td>\n";
		
		}	
		?>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o de inicio:
	</td>
        <td class="celdatabla" valign="top" align="left"><?php   echo  $registro[0][10] ?></td>
      </tr>	 
	    </tbody>
	    </table>
	    <br>
	    <table style="background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1" width="100%">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td class="celdatabla">
		Una (o varias instituciones) participantes est&aacute;n acreditadas de alta calidad por entidades de reconocida legitimidad nacional o internacional.
		</td>
		<td valign="top" class="celdatabla"><?php  
            	if($registro[0][9]==1)
            	{
            		echo '<input checked="checked" name="calidad" value="1" type="checkbox" tabindex="7">';	
            	}
            	else
            	{
            		echo '<input name="calidad" value="1" type="checkbox" tabindex="7">';	
            	}?>
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td class="celdatabla">
		El convenio garantiza la movilidad estudiantil entre las instituciones participantes.
		</td>
		<td valign="top" class="celdatabla"><?php  
            	if($registro[0][5]==1)
            	{
            		echo '<input checked="checked" name="movilidad" value="1" type="checkbox" tabindex="8">';	
            	}
            	else
            	{
            		echo '<input name="movilidad" value="1" type="checkbox" tabindex="8">';	
            	}?>
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td class="celdatabla">
		El convenio propicia la interacci&oacute;n acad&eacute;mica de los profesores del programa.</td>
		<td valign="top" class="celdatabla">
		<?php  
            	if($registro[0][7]==1)
            	{
            		echo '<input checked="checked" name="interaccion" value="1" type="checkbox" tabindex="9">';	
            	}
            	else
            	{
            		echo '<input name="interaccion" value="1" type="checkbox" tabindex="9">';	
            	}?>
		</td>
		</tr>
		</tbody>
		</table>
		<br>
		<table style="background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1" width="100%">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td valign="top" class="celdatabla">
		N&uacute;mero de profesores del programa que participan en el convenio:
		</td>
		<td class="celdatabla">
		<input maxlength="5" size="4" tabindex="10" name="profesor" value="<?php   echo $registro[0][8]?>">
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td valign="top" class="celdatabla">
		N&uacute;mero de estudiantes beneficiados:</td>
		<td class="celdatabla">
		<input maxlength="5" size="4" tabindex="11" name="estudiante" value="<?php   echo $registro[0][6]?>">
		</td>
		</tr>
		</tbody>
		</table>
		<table style="background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1" width="100%">
		<tbody>
		<tr>
              <td colspan="2" rowspan="1">
		<input type="hidden" name="action" value="registro_dir_convenio">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="anno" value="<?php   echo $registro[0][10] ?>">
		<input type="hidden" name="nombre" value="<?php   echo $registro[0][0] ?>">
		<input type="hidden" name="id_convenio" value="<?php   echo $_GET['registro'] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="12">
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
</form><?php  		}	
	}
}
else
{

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_convenio" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle" class="celdatabla">
        <table style="width: 100%; text-align: left; background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Convenios o Actividades de Cooperaci&oacute;n</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nombre:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="nombre" tabindex="1"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Objetivo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="objetivo" tabindex="2"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Tipo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table cellpadding="2" cellspacing="5">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td><input checked="checked" name="tipo" value="0" type="radio" tabindex="3">Convenio
		</td>
		<td>
		<input  name="tipo" value="1" type="radio" tabindex="4">Actividad de Cooperaci&oacute;n
		</td>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Instituci&oacute;n con las que se suscribe:<br>(o instituciones)</td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="institucion" tabindex="5"></textarea><br>
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
		<td><input checked="checked" name="ambito" value="0" type="radio" tabindex="6">Nacional
		</td>
		<td>
		<input  name="ambito" value="1" type="radio" tabindex="7">Internacional
		</td>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o de inicio:
	</td>
        <td class="celdatabla" valign="top" align="left"><input maxlength="5" size="4" tabindex="13" name="anno" >
        </td>
      </tr>	 
	    </tbody>
	    </table>
	    <br>
	    <table style="background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1" width="100%">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td class="celdatabla">
		Una (o varias instituciones) participantes est&aacute;n acreditadas de alta calidad por entidades de reconocida legitimidad nacional o internacional.
		</td>
		<td valign="top" class="celdatabla">
		<input name="calidad" value="1" type="checkbox" tabindex="9">
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td class="celdatabla">
		El convenio garantiza la movilidad estudiantil entre las instituciones participantes.
		</td>
		<td valign="top" class="celdatabla">
		<input name="movilidad" value="1" type="checkbox" tabindex="10">
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td class="celdatabla">
		El convenio propicia la interacci&oacute;n acad&eacute;mica de los profesores del programa.
		</td>
		<td valign="top" class="celdatabla">
		<input name="interaccion" value="1" type="checkbox" tabindex="11">
		</td>
		</tr>
		</tbody>
		</table>
		<br>
		<table style="background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1" width="100%">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td valign="top" class="celdatabla">
		N&uacute;mero de profesores del programa que participan en el convenio:
		</td>
		<td class="celdatabla">
		<input maxlength="5" size="4" tabindex="12" name="profesor" >
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td valign="top" class="celdatabla">
		N&uacute;mero de estudiantes beneficiados:</td>
		<td class="celdatabla">
		<input maxlength="5" size="4" tabindex="13" name="estudiante" >
		</td>
		</tr>
		</tbody>
		</table>
		<table style="background-color: rgb(255,255,255);" cellpadding="5" cellspacing="1" width="100%">
		<tbody>
		<tr>
              <td colspan="2" rowspan="1">
		<input type="hidden" name="action" value="registro_dir_convenio">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="14">
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
