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
* @description  Formulario de registro de visitas de los profesores
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
if(isset($_GET['id_visita']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	//Rescatar datos anuales, con nombre de programa y nombre del tipo de vinculacion
	$cadena_sql="SELECT ";
		$cadena_sql.="id_visita, ";
		$cadena_sql.="anno, ";
		$cadena_sql.="institucion, ";
		$cadena_sql.="permanencia, ";
		$cadena_sql.="objetivo, ";
		$cadena_sql.="resultado, ";
		$cadena_sql.="par, ";
		$cadena_sql.="observacion, ";
		$cadena_sql.="identificacion ";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor_info_visita ";
		$cadena_sql.=" WHERE id_visita=".$_GET['id_visita']."";	
		$cadena_sql.=" LIMIT 1";
		//	0 id_visita
		//	1 anno
		//	2.institucion
		//	3.permanencia
		//	4.objetivo
		//	5.resultado
		//	6.par
		//	7.observacion
		//	8.identificacion
		//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_visita" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Visitas a otras instituciones:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Nombre de la instituci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="institucion" tabindex="1"><?PHP   echo $registro[0][2] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="middle" align="left">
            <font color="red">*</font>Permanencia (en d&iacute;as):<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <input maxlength="255" size="40" tabindex="2" name="permanencia" value="<?PHP   echo $registro[0][3] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Objetivo de la visita:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="objetivo" tabindex="3"><?PHP   echo $registro[0][4] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Resultados obtenidos con la visita:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
            <textarea cols="40" rows="2" name="resultado" tabindex="4"><?PHP   echo $registro[0][5] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Visita en calidad de par acad&eacute;mico:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table>
		<tbody>
		<tr class="bloquecentralcuerpo">
		<?PHP  
		if($registro[0][6]==0)
		{
			echo "<td>\n<input checked='checked' name='par' value='0' type='radio'>No";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input  name='par' value='1' type='radio'>Si";
			echo "</td>\n";
		}
		else
		{
			echo "<td>\n<input name='par' value='0' type='radio'>No";
			echo "</td>\n";
			echo "<td>\n";
			echo "<input checked='checked' name='par' value='1' type='radio'>Si";
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
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla"  align="left" valign="top"><?PHP   $registro[0][1]?>
        </td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Observaciones:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="observacion" tabindex="8"><?PHP   echo $registro[0][7] ?></textarea><br>
	    </td>
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_visita">
		<input type="hidden" name="usuario" value="<?PHP   echo $_GET['usuario'] ?>">
		<input type="hidden" name="anno" value="<?PHP   echo $registro[0][1] ?>">
		<input type="hidden" name="id_visita" value="<?PHP   echo $registro[0][0] ?>">
		<input type="hidden" name="identificacion" value="<?PHP   echo $_GET['registro'] ?>">
              <div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="9">
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
<?PHP  		}	
	}
}
else
{

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_visita" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Visitas a otras instituciones:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Nombre de la instituci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="institucion" tabindex="1"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Permanencia (en d&iacute;as):<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="4" size="4" tabindex="2" name="permanencia"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Objetivo de la visita:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="objetivo" tabindex="3"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Resultados obtenidos con la visita:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
            <textarea cols="40" rows="2" name="resultado" tabindex="4"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top">
            <font color="red">*</font>Visita en calidad de par acad&eacute;mico:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
		<table>
		<tbody>
		<tr class="bloquecentralcuerpo">
		<td><input checked="checked" name="par" value="0" type="radio" tabindex="5">No
		</td>
		<td>
		<input  name="par" value="1" type="radio" tabindex="6">Si
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
        <td class="celdatabla" valign="top" align="left"><?PHP  
		$contador=0;
		echo "<select name='anno' size='1' tabindex='7'>\n";
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
	    <textarea cols="40" rows="2" name="observacion" tabindex="8"></textarea><br>
	    </td>
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_visita">
		<input type="hidden" name="usuario" value="<?PHP   echo $_GET['usuario'] ?>">
		<input type="hidden" name="identificacion" value="<?PHP   echo $_GET['identificacion'] ?>">
              <div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="9">
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
<?PHP  
}
?>
