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
	$cadena_sql.="anno, ";
	$cadena_sql.="nombre, ";
	$cadena_sql.="objetivo, ";
	$cadena_sql.="funcion, ";
	$cadena_sql.="cooperacion, ";
	$cadena_sql.="curriculo, ";
	$cadena_sql.="social, ";
	$cadena_sql.="estado, ";
	$cadena_sql.="tipo ";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."dir_proyecto ";
	$cadena_sql.=" WHERE id_proyecto=".$_GET['registro']."";	
	$cadena_sql.=" LIMIT 1";
	
		//	0 anno
		//	1.nombre
		//	2.objetivo
		//	3.funcion
		//	4.cooperacion
		//	5.curriculo
		//	6.social
		//	7.estado
		//	8.tipo
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
        <table style="width: 100%; text-align: left;"  cellpadding="5" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Proyectos o Estudios del programa</td>
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
            <font color="red">*</font>Objetivo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="objetivo" tabindex="2"><?php   echo $registro[0][2] ?></textarea><br>
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
		if($registro[0][8]==0)
		{
			echo "<td>\n<input checked='checked' name='tipo' value='0' type='radio'>Proyecto";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input  name='tipo' value='1' type='radio'>Estudio";
			echo "</td>\n";
		}
		else
		{
			echo "<td>\n<input name='tipo' value='0' type='radio'>Proyecto";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input checked='checked' name='tipo' value='1' type='radio'>Estudio";
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
            <font color="red">*</font>Enmarcado dentro de las funciones de:<br>
            </td>
            <td class="celdatabla" align="left" valign="top"><?php  
            	if(substr($registro[0][3],0,1)=="1")
            	{
            		echo '<input checked="checked" name="investigacion" value="1" type="checkbox" tabindex="5">Investigaci&oacute;n<br>';	
            	}
            	else
            	{
            		echo '<input name="investigacion" value="1" type="checkbox" tabindex="5">Investigaci&oacute;n<br>';	
            	}
            
            	if(substr($registro[0][3],1,1)=="1")
            	{
            		echo '<input checked="checked" name="docencia" value="1" type="checkbox" tabindex="6">Docencia<br>';	
            	}
            	else
            	{
            		echo '<input name="docencia" value="1" type="checkbox" tabindex="6">Docencia<br>';	
            	}
            	
            	if(substr($registro[0][3],2,1)=="1")
            	{
            		echo '<input checked="checked" name="proyeccion" value="1" type="checkbox" tabindex="7">Proyecci&oacute;n Social<br>';	
            	}
            	else
            	{
            		echo '<input name="proyeccion" value="1" type="checkbox" tabindex="7">Proyecci&oacute;n Social<br>';	
            	}
            ?>
            
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Estado:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table cellpadding="2" cellspacing="5">
		<tbody>
		<?php  
		if($registro[0][7]==0)
		{
			echo "<tr class='bloquecentralcuerpo'>";
			echo "<td>\n<input checked='checked' name='estado' value='0' type='radio' tabindex='8'>Formulado";
			echo "</td>\n";
			echo "</tr>\n";	
		}
		else
		{
			echo "<tr class='bloquecentralcuerpo'>";
			echo "<td>\n<input name='estado' value='0' type='radio' tabindex='8'>Formulado";
			echo "</td>\n";
			echo "</tr>\n";			
					
		}
		
		if($registro[0][7]==1)
		{
			echo "<tr class='bloquecentralcuerpo'>";
			echo "<td>\n";
			echo "<input checked='checked' name='estado' value='1' type='radio' tabindex='9'>En desarrollo";
			echo "</td>\n";
			echo "</tr>\n";
		}
		else
		{
			echo "<tr class='bloquecentralcuerpo'>";
			echo "<td>\n";
			echo "<input  name='estado' value='1' type='radio' tabindex='9'>En desarrollo";
			echo "</td>\n";
			echo "</tr>\n";
		
		
		}
			
		if($registro[0][7]==2)
		{	
			echo "<tr class='bloquecentralcuerpo'>";
			echo "<td>\n";
			echo "<input checked='checked' name='estado' value='1' type='radio' tabindex='10'>Terminado";
			echo "</td>\n";
			echo "</tr>\n";
		}
		else
		{
			echo "<tr class='bloquecentralcuerpo'>";
			echo "<td>\n";
			echo "<input  name='estado' value='1' type='radio' tabindex='10'>Terminado";
			echo "</td>\n";
			echo "</tr>\n";
		
		}	
		?></tbody>
		</table>
	    </td>
	    </tr>
  <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o de formulaci&oacute;n:
	</td>
        <td class="celdatabla" valign="top" align="left"><?php   echo  $registro[0][0]?></td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td  valign="top" colspan="2" class="celdatabla" >
            	<table cellpadding="2" cellspacing="5" width="100%">
            	<tbody>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla"><?php  
            	if($registro[0][4]==1)
            	{
            		echo '<input checked="checked" name="cooperacion" value="1" type="checkbox" tabindex="12">';	
            	}
            	else
            	{
            		echo '<input name="cooperacion" value="1" type="checkbox" tabindex="12">';	
            	}?></td>
            	<td class="celdatabla">
            	El proyecto es desarrollado como producto de la participaci&oacute;n en actividades de cooperaci&oacute;n acad&eacute;mica.
            	</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla"><?php  
            	if($registro[0][5]==1)
            	{
            		echo '<input checked="checked" name="curriculo" value="1" type="checkbox" tabindex="13">';	
            	}
            	else
            	{
            		echo '<input name="curriculo" value="1" type="checkbox" tabindex="13">';	
            	}?></td>
            	<td class="celdatabla">
            	El proyecto propende por la modernizaci&oacute;n y pertinencia del curr&iacute;culo.
            	</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla"><?php  
            	if($registro[0][6]==1)
            	{
            		echo '<input checked="checked" name="social" value="1" type="checkbox" tabindex="14">';	
            	}
            	else
            	{
            		echo '<input name="social" value="1" type="checkbox" tabindex="14">';	
            	}?></td>
            	<td class="celdatabla">
            	El proyecto es de caracter social.
            	</td>
            	</tr>
            	</tbody>
            	</table>
            </td>
            
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dir_proyecto">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="id_proyecto" value="<?php   echo $_GET['registro'] ?>">
		<input type="hidden" name="nombre" value="<?php   echo $registro[0][1] ?>">
		<input type="hidden" name="anno" value="<?php   echo $registro[0][0] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="13">
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
<form method="post" action="index.php" name="registrar_dir_evento" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;"  cellpadding="5" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Proyectos o Estudios del programa</td>
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
		<td><input checked="checked" name="tipo" value="0" type="radio" tabindex="3">Proyecto
		</td>
		<td>
		<input  name="tipo" value="1" type="radio" tabindex="4">Estudio
		</td>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Enmarcado dentro de las funciones de:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	     <input name="investigacion" value="1" type="checkbox" tabindex="5">Investigaci&oacute;n<br>
	     <input name="docencia" value="1" type="checkbox" tabindex="6">Docencia<br>
	     <input name="proyeccion" value="1" type="checkbox" tabindex="7">Proyecci&oacute;n Social<br>	
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Estado:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table cellpadding="2" cellspacing="5">
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td><input checked="checked" name="estado" value="0" type="radio" tabindex="8">Formulado
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td>
		<input  name="estado" value="1" type="radio" tabindex="9">En desarrollo
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
		<td>
		<input  name="estado" value="2" type="radio" tabindex="10">Terminado
		</td>
		</tr>
		</tbody>
		</table>
	    </td>
	    </tr>
  <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o de formulaci&oacute;n:
	</td>
        <td class="celdatabla" valign="top" align="left"><?php  
		$contador=0;
		echo "<select name='anno' size='1' tabindex='11'>\n";
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			echo "<option value='".$anno."'>".$anno."</option>\n";
			
		}
		echo "</select>\n";
			?>
        </td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td  valign="top" colspan="2" class="celdatabla" >
            	<table cellpadding="2" cellspacing="5" width="100%">
            	<tbody>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<input name="cooperacion" value="1" type="checkbox" tabindex="12">
            	</td>
            	<td class="celdatabla">
            	El proyecto es desarrollado como producto de la participaci&oacute;n en actividades de cooperaci&oacute;n acad&eacute;mica.
            	</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<input name="curriculo" value="1" type="checkbox" tabindex="13">
            	</td>
            	<td class="celdatabla">
            	El proyecto propende por la modernizaci&oacute;n y pertinencia del curr&iacute;culo.
            	</td>
            	</tr>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla">
            	<input name="social" value="1" type="checkbox" tabindex="14">
            	</td>
            	<td class="celdatabla">
            	El proyecto es de caracter social.
            	</td>
            	</tr>
            	</tbody>
            	</table>
            </td>
            
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dir_proyecto">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="13">
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
