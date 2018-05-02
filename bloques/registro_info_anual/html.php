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
if(isset($_GET['registro']) && isset($_GET['anno']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="`identificacion` , ";
		$cadena_sql.="`id_programa` , ";
		$cadena_sql.="`id_tipo_vinculacion` , ";
		$cadena_sql.="`id_dedicacion` , ";
		$cadena_sql.="`id_categoria` , ";
		$cadena_sql.="`id_titulo` , ";
		$cadena_sql.="`anno` ";
		$cadena_sql.="FROM ";
		$cadena_sql.="`".$configuracion["prefijo"]."profesor_info_anual` ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="identificacion='".$_GET['registro']."' ";
		$cadena_sql.="AND ";
		$cadena_sql.="anno=".$_GET['anno']." ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Información a&ntilde;o por a&ntilde;o del profesor.
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Programa al que pertenece:
	</td>
        <td class="celdatabla"><?PHP  
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
	$html=new html();
	$busqueda="SELECT ";
	$busqueda.="id_programa, ";
	$busqueda.="nombre_corto ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."programa ";
	$busqueda.="ORDER BY ";
	$busqueda.="nombre_corto";
	
	$mi_cuadro=$html->cuadro_lista($busqueda,'id_programa',$configuracion,$registro[0][1],0,0);
	echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Tipo de Vinculaci&oacute;n:
	</td>
        <td class="celdatabla"><?PHP  
	$busqueda="SELECT ";
	$busqueda.="id_valor,nombre_corto ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."valores_profesor ";
	$busqueda.="WHERE ";
	$busqueda.="id_tipo_valor=1 ";
	$busqueda.="ORDER BY ";
	$busqueda.="nombre_corto";
	$mi_cuadro=$html->cuadro_lista($busqueda,'id_tipo_vinculacion',$configuracion,$registro[0][2],0,0);
	echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Dedicaci&oacute;n:
	</td>
        <td class="celdatabla"><?PHP  
	$busqueda="SELECT ";
	$busqueda.="id_valor,nombre_corto ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."valores_profesor ";
	$busqueda.="WHERE ";
	$busqueda.="id_tipo_valor=4 ";
	$busqueda.="ORDER BY ";
	$busqueda.="nombre_corto";
	$mi_cuadro=$html->cuadro_lista($busqueda,'id_dedicacion',$configuracion,$registro[0][3],0,0);
	echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Categor&iacute;a:
	</td>
        <td class="celdatabla"><?PHP  
	$busqueda="SELECT ";
	$busqueda.="id_valor,nombre_corto ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."valores_profesor ";
	$busqueda.="WHERE ";
	$busqueda.="id_tipo_valor=2 ";
	$busqueda.="ORDER BY ";
	$busqueda.="nombre_corto";
	$mi_cuadro=$html->cuadro_lista($busqueda,'id_categoria',$configuracion,$registro[0][4],0,0);
	echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		T&iacute;tulo Acad&eacute;mico:
	</td>
        <td class="celdatabla"><?PHP  
	$busqueda="SELECT ";
	$busqueda.="id_valor,nombre_corto ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."valores_profesor ";
	$busqueda.="WHERE ";
	$busqueda.="id_tipo_valor=3 ";
	$busqueda.="ORDER BY ";
	$busqueda.="nombre_corto";
	$mi_cuadro=$html->cuadro_lista($busqueda,'id_titulo',$configuracion,$registro[0][5],0,0);
	echo $mi_cuadro;
	?></td>
      </tr>
        </td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" valign="undefined">
		<input type="hidden" name="action" value="registro_info_anual">
		<input type="hidden" name="identificacion" value="<?PHP   echo $registro[0][0]?>">
		<input type="hidden" name="anno" value="<?PHP   echo $_GET['anno']?>">
		<input name="aceptar" value="Aceptar" type="submit"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?PHP  		}
	}
}
else
{
	//Si va a recargar el formulario con mensajes de error
	if(isset($_POST["nombre"])) 
		{
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_profesor" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && seleccion_valida(this,'programa') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Registro para profesores:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="width: 318px; text-align: left; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Nombres:<br>
              </td>
              <td style="width: 365px; background-color: rgb(239, 239, 239);" colspan="1" rowspan="1">
		<input maxlength="80" size="40" tabindex="1" name="nombre" value="<?PHP   echo $_POST["nombre"] ?>"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td style="width: 318px; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Apellidos:<br>
              </td>
              <td colspan="1" rowspan="1" style="width: 128px; background-color: rgb(239, 239, 239);">
                <input maxlength="80" size="40" tabindex="2" name="apellido" value="<?PHP   echo $_POST["apellido"] ?>">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Identificaci&oacute;n:<br>
              </td>
              <td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
              <input maxlength="80" size="40" tabindex="3" name="identificacion" value="<?PHP   echo $_POST["identificacion"] ?>">
	      </td>
            </tr>
		<tr class="bloquecentralcuerpo">
			<td style="background-color: rgb(239, 239, 239);">
				<font color="red">*</font>Programa Actual:<br>
			</td>
			<td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
				<?PHP  
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
		$html=new html();
		
		$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
		$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,0,0);
		echo $mi_cuadro;
			?></td></tr><tr>
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_profesor">
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
<?PHP  
}
else
{ // Si es un registro nuevo
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Información a&ntilde;o por a&ntilde;o del profesor.
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Programa al que pertenece:
	</td>
        <td class="celdatabla"><?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();
$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_programa',$configuracion,-1,0,0);
echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Tipo de Vinculaci&oacute;n:
	</td>
        <td class="celdatabla"><?PHP  
$busqueda="SELECT id_valor,nombre_corto FROM ".$configuracion["prefijo"]."valores_profesor WHERE id_tipo_valor=1 ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_tipo_vinculacion',$configuracion,-1,0,0);
echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Dedicaci&oacute;n:
	</td>
        <td class="celdatabla"><?PHP  
$busqueda="SELECT id_valor,nombre_corto FROM ".$configuracion["prefijo"]."valores_profesor WHERE id_tipo_valor=4 ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_dedicacion',$configuracion,-1,0,0);
echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Categor&iacute;a:
	</td>
        <td class="celdatabla"><?PHP  
$busqueda="SELECT id_valor,nombre_corto FROM ".$configuracion["prefijo"]."valores_profesor WHERE id_tipo_valor=2 ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_categoria',$configuracion,-1,0,0);
echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		T&iacute;tulo Acad&eacute;mico:
	</td>
        <td class="celdatabla"><?PHP  
$busqueda="SELECT id_valor,nombre_corto FROM ".$configuracion["prefijo"]."valores_profesor WHERE id_tipo_valor=3 ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'id_titulo',$configuracion,-1,0,0);
echo $mi_cuadro;
	?></td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1">
		La anterior informaci&oacute;n corresponde a los a&ntilde;os:
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<tr class="bloquecentralcuerpo"><?PHP  
		$contador=0;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			echo '<td class="celdatabla">';
			echo "<input name='anno".$contador."' value='".$anno."' type='checkbox'>\n".$anno;	
			echo '</td>';
			$contador++;
		}
			?></tr>
          	</tbody>
        	</table>
        </td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" valign="undefined">
		<input type="hidden" name="action" value="registro_info_anual">
		<input type="hidden" name="identificacion" value="<?PHP   echo $_GET["identificacion"]?>">
		<input name="aceptar" value="Aceptar" type="submit"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?PHP  
	}
}
?>
