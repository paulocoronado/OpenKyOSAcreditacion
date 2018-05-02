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
?>
<?PHP  
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
?><?PHP  
//Verificar si se tiene un numero de usuario por el metodo GET:
//Puede manejarse cuatro tipos de acceso a este bloque:
// 1. Acceso para edición por parte del administrador
// 2. Acceso para registro de usuarios nuevos
// 3. Acceso para registro de usuarios nuevos por parte del administrador
// 4. Acceso para edición por parte de los usuarios

//Si esta editando
$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$el_usuario=$registro[0][0];
	}
}
unset($registro);


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

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_evento" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr class="bloquecentralcuerpo">
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
	    <?PHP   echo $registro[0][1] ?><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Objetivo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="35" rows="2" name="objetivo" tabindex="2"><?PHP   echo $registro[0][2] ?></textarea><br>
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
		<?PHP  
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
            <td class="celdatabla" align="left" valign="top"><?PHP  
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
		<?PHP  
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
        <td class="celdatabla" valign="top" align="left"><?PHP   echo  $registro[0][0]?></td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td  valign="top" colspan="2" class="celdatabla" >
            	<table cellpadding="2" cellspacing="5" width="100%">
            	<tbody>
            	<tr class="bloquecentralcuerpo">
            	<td valign="top" class="celdatabla"><?PHP  
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
            	<td valign="top" class="celdatabla"><?PHP  
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
            	<td valign="top" class="celdatabla"><?PHP  
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
            <tr class="bloquecentralcuerpo">
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dir_proyecto">
		<input type="hidden" name="usuario" value="<?PHP   echo $_GET['usuario'] ?>">
		<input type="hidden" name="id_proyecto" value="<?PHP   echo $_GET['registro'] ?>">
		<input type="hidden" name="nombre" value="<?PHP   echo $registro[0][1] ?>">
		<input type="hidden" name="anno" value="<?PHP   echo $registro[0][0] ?>">
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
</form><?PHP  		}	
	}
}
else
{
 //Primer paso preguntas primitivas
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registro" onsubmit="return(control_vacio(this,'nombre'))">
<input type="hidden" name=" action" value="registro_primitiva">
<table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
	<table style="width: 100%; text-align: left;" border="0" cellpadding="4" cellspacing="2">
	<tbody>
		<tr class="bloquecentralencabezado">
			<td colspan="2" rowspan="1" align="center" class="celdatabla" valign="top" align="left">Pregunta Primitiva
			<br></td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left" colspan="2" rowspan="1">
			Datos B&aacute;sicos de la pregunta:<br>
			<input type="hidden" name="id_primitiva" value="<?PHP   
			$numero=time();
			echo substr($numero,(strlen($numero)-6),6) ?>">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Nombre: 
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input maxlength="80" size="40"  name="nombre"><br>
			<b>Nota:</b> Use un nombre que la identifique un&iacute;vocamente dentro del banco de preguntas.<br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Encabezado:<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<textarea cols="40" rows="2" name="encabezado"></textarea>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Descripci&oacute;n o Comentario:<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<textarea cols="40" rows="4" name="comentario"></textarea><br>
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="propietario" value="<?PHP   echo $el_usuario?>">
	<input type="hidden" name="fecha_creacion" value="<?PHP   echo time(); ?>" >
	<table style="width: 100%; text-align: left;" border="0" cellpadding="4" cellspacing="2">
		<tbody>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left" colspan="2" rowspan="1">
			Tipo de M&eacute;trica:<br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Selecci&oacute;n M&uacute;ltiple<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="1" type="radio"><br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Selecci&oacute;n &Uacute;nica<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="2" type="radio">
		</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Comentario M&uacute;ltiples campos<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="3" type="radio">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			No de opciones:<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input maxlength="5" size="5" name="opcion">(Solo aplica para tipo selecci&oacute;n)<br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Calificaci&oacute;n Num&eacute;rica<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="4" type="radio">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Calificaci&oacute;n porcentual<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="5" type="radio">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Dato num&eacute;rico<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="6" type="radio">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Comentario de una sola l&iacute;nea<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="7" type="radio">
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Comentario de varias l&iacute;neas<br>
			</td>
			<td class="celdatabla" valign="top" align="left">
			<input name="metrica" value="8" type="radio">
			</td>
		</tr>
	</tbody>
	</table>
	<table style="width: 100%; text-align: left;" border="0" cellpadding="4" cellspacing="2">
		<tbody>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left" colspan="6" rowspan="1">
			La pregunta ser&aacute; usada en:<br>
			</td>
		</tr>
		<tr class="bloquecentralcuerpo">
			<td class="celdatabla" valign="top" align="left">
			Encuesta <input name="instrumento" value="1" type="radio">
			</td>
			<td class="celdatabla" valign="top" align="left">
			Taller <input name="instrumento" value="2" type="radio">
			</td>
			<td class="celdatabla" valign="top" align="left">
			Entrevista <input name="instrumento" value="3" type="radio">
			</td>
		</tr>
		</tbody>
	</table>	
	<br>
	<table style="margin-left: auto; margin-right: auto; width:100%; text-align: left;" border="0" cellpadding="2" cellspacing="2" align="center">
	<tbody>
		<tr align="center">
			<td colspan="2" rowspan="1" >
			<input name="index" value="Aceptar" type="submit"><br>
			</td>
		</tr>
	</tbody>
	</table>
</td>
</tr>
</tbody>
</table>
</form>
<?PHP  
}
?>
