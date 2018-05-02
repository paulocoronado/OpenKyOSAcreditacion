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

&uacute;ltima revisi&oacute;n 6 de Marzo de 2006

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
// 1. Acceso para edici&oacute;n por parte del administrador
// 2. Acceso para registro de usuarios nuevos
// 3. Acceso para registro de usuarios nuevos por parte del administrador
// 4. Acceso para edici&oacute;n por parte de los usuarios

//Si esta editando
if(isset($_GET['registro']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	$cadena_sql="SELECT ";
	$cadena_sql.="anno, ";
	$cadena_sql.="nombre, ";
	$cadena_sql.="descripcion, ";
	$cadena_sql.="tipo, ";
	$cadena_sql.="ambito, ";
	$cadena_sql.="directivo, ";
	$cadena_sql.="profesor, ";
	$cadena_sql.="estudiante, ";
	$cadena_sql.="enfoque, ";
	$cadena_sql.="nivel, ";
	$cadena_sql.="inter, ";
	$cadena_sql.="cooperacion, ";
	$cadena_sql.="politica ";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_actividad ";
	$cadena_sql.=" WHERE id_actividad=".$_GET['registro']."";	
	$cadena_sql.=" LIMIT 1";
	
		//	0 anno
		//	1.nombre
		//	2.descripcion
		//	3.tipo
		//	4.ambito
		//	5.directivo
		//	6.profesor
		//	7.estudiante
		//	8.enfoque
		//	9.nivel
		//	10.inter
		//	11.cooperacion
		//	12.politico
		
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_actividad" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;"  cellpadding="5" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Actividades realizadas en el programa</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nombre:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <?php   echo $registro[0][1] ?><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Descripci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="descripcion" tabindex="2"><?php   echo $registro[0][2] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Tipo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="255" size="35" tabindex="3" name="tipo" value="<?php   echo $registro[0][3] ?>">	
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
	<td class="celdatabla" valign="top">
	<font color="red">*</font>A&ntilde;o de realizaci&oacute;n:
	</td>
	<td class="celdatabla" valign="top" align="left">
	<?php   echo $registro[0][0] ?>
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
		if($registro[0][4]==0)
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
		?>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr> 
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Enfoque:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	     <?php  
            	if(substr($registro[0][8],0,1)=="1")
            	{
            		echo '<input checked="checked" name="investigacion" value="1" type="checkbox" tabindex="5">Investigaci&oacute;n<br>';	
            	}
            	else
            	{
            		echo '<input name="investigacion" value="1" type="checkbox" tabindex="5">Investigaci&oacute;n<br>';	
            	}
            
            	if(substr($registro[0][8],1,1)=="1")
            	{
            		echo '<input checked="checked" name="docencia" value="1" type="checkbox" tabindex="6">Docencia<br>';	
            	}
            	else
            	{
            		echo '<input name="docencia" value="1" type="checkbox" tabindex="6">Docencia<br>';	
            	}
            	
            	if(substr($registro[0][8],2,1)=="1")
            	{
            		echo '<input checked="checked" name="proyeccion" value="1" type="checkbox" tabindex="7">Proyecci&oacute;n Social<br>';	
            	}
            	else
            	{
            		echo '<input name="proyeccion" value="1" type="checkbox" tabindex="7">Proyecci&oacute;n Social<br>';	
            	}
            	
            	if(substr($registro[0][8],3,1)=="1")
            	{
            		echo '<input checked="checked" name="cooperacion" value="1" type="checkbox" tabindex="7">Cooperaci&oacute;n<br>';	
            	}
            	else
            	{
            		echo '<input name="cooperacion" value="1" type="checkbox" tabindex="7">Cooperaci&oacute;n<br>';	
            	}
            ?>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left" colspan="2">
            <B>N&uacute;mero de participantes:</b>
            </td>
            </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Directivos:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="5" size="4" tabindex="11" name="directivo" value="<?php   echo $registro[0][5] ?>">	
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Profesores:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="5" size="4" tabindex="12" name="profesor" value="<?php   echo $registro[0][6] ?>">	
	    </td>
	    </tr> 
	     <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Estudiantes:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="5" size="4" tabindex="13" name="estudiante" value="<?php   echo $registro[0][7] ?>">	
	    </td>
	    </tr>
	     <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nivel Acad&eacute;mico de la actividad:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="200" size="35" tabindex="14" name="nivel" value="<?php   echo $registro[0][9] ?>">	
	    </td>
	    </tr>
	     
  
      	<tr class="bloquecentralcuerpo">
            <td  valign="top" colspan="2" class="celdatabla" >
            	<table cellpadding="2" cellspacing="5" width="100%">
            	<tbody>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla"><?php  
            	if($registro[0][12]==1)
            	{
            		echo '<input checked="checked" name="politica" value="1" type="checkbox" tabindex="15">';	
            	}
            	else
            	{
            		echo '<input name="politica" value="1" type="checkbox" tabindex="15">';	
            	}?>
            	</td>
            	<td class="celdatabla">
            	La actividad es desarrollada para la definici&oacute;n de pol&iacute;ticas en materia de docencia, investigaci&oacute;n, proyecci&oacute;n social y cooperaci&oacute;n internacional, y en las decisiones ligadas al programa.
		</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<?php  
            	if($registro[0][11]==1)
            	{
            		echo '<input checked="checked" name="coopera" value="1" type="checkbox" tabindex="16">';	
            	}
            	else
            	{
            		echo '<input name="coopera" value="1" type="checkbox" tabindex="16">';	
            	}?>
            	</td>
            	<td class="celdatabla">
            	La actividad es de cooperaci&oacute;n acad&eacute;mica con miembros de comunidades de reconocido liderazgo en el &aacute;rea del programa.
            	</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<?php  
            	if($registro[0][10]==1)
            	{
            		echo '<input checked="checked" name="inter" value="1" type="checkbox" tabindex="17">';	
            	}
            	else
            	{
            		echo '<input name="inter" value="1" type="checkbox" tabindex="17">';	
            	}?>
            	</td>
            	<td class="celdatabla">
            	La actividad es de caracter explicitamente interdisciplinario.
            	</td>
            	</tr>
            	</tbody>
            	</table>
            </td>
	    </tr>
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dir_actividad">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="id_actividad" value="<?php   echo $_GET['registro'] ?>">
		<input type="hidden" name="nombre" value="<?php   echo $registro[0][1] ?>">
		<input type="hidden" name="anno" value="<?php   echo $registro[0][0] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="18">
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
<form method="post" action="index.php" name="registrar_dir_actividad" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;"  cellpadding="5" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Actividades realizadas en el programa</td>
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
            <font color="red">*</font>Descripci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="descripcion" tabindex="2"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Tipo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="255" size="35" tabindex="3" name="tipo">	
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
	<td class="celdatabla" valign="top">
	<font color="red">*</font>A&ntilde;o de realizaci&oacute;n:
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
	   <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Ambito:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table cellpadding="2" cellspacing="5">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td><input checked="checked" name="ambito" value="0" type="radio" tabindex="5">Nacional
		</td>
		<td>
		<input  name="ambito" value="1" type="radio" tabindex="6">Internacional
		</td>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr> 
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Enfoque:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	     <input name="investigacion" value="1" type="checkbox" tabindex="7">Investigaci&oacute;n<br>
	     <input name="docencia" value="1" type="checkbox" tabindex="8">Docencia<br>
	     <input name="proyeccion" value="1" type="checkbox" tabindex="9">Proyecci&oacute;n Social<br>	
	     <input name="cooperacion" value="1" type="checkbox" tabindex="10">Cooperaci&oacute;n<br>	
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left" colspan="2">
            <B>N&uacute;mero de participantes:</b>
            </td>
            </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Directivos:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="5" size="4" tabindex="11" name="directivo">	
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Profesores:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="5" size="4" tabindex="12" name="profesor">	
	    </td>
	    </tr> 
	     <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Estudiantes:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="5" size="4" tabindex="13" name="estudiante">	
	    </td>
	    </tr>
	     <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nivel Acad&eacute;mico de la actividad:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="200" size="35" tabindex="14" name="nivel">	
	    </td>
	    </tr>
	     
  
      	<tr class="bloquecentralcuerpo">
            <td  valign="top" colspan="2" class="celdatabla" >
            	<table cellpadding="2" cellspacing="5" width="100%">
            	<tbody>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<input name="politica" value="1" type="checkbox" tabindex="15">
            	</td>
            	<td class="celdatabla">
            	La actividad es desarrollada para la definici&oacute;n de pol&iacute;ticas en materia de docencia, investigaci&oacute;n, proyecci&oacute;n social y cooperaci&oacute;n internacional, y en las decisiones ligadas al programa.
		</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<input name="coopera" value="1" type="checkbox" tabindex="16">
            	</td>
            	<td class="celdatabla">
            	La actividad es de cooperaci&oacute;n acad&eacute;mica con miembros de comunidades de reconocido liderazgo en el &aacute;rea del programa.
            	</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<input name="inter" value="1" type="checkbox" tabindex="17">
            	</td>
            	<td class="celdatabla">
            	La actividad es de caracter explicitamente interdisciplinario.
            	</td>
            	</tr>
            	</tbody>
            	</table>
            </td>
	    </tr>
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dir_actividad">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="18">
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
