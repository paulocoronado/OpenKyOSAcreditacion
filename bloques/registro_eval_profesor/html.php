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
if(isset($_GET['id_evaluacion']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT `evaluacion` , `accion_programa` , `accion_institucion`, `anno`,`identificacion` ";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."profesor_info_evaluacion` ";
		$cadena_sql.="WHERE id_evaluacion=".$_GET['id_evaluacion']." LIMIT 1";
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
		Informaci&oacute;n de evaluaciones docentes
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Calificaci&oacute;n:
	</td>
        <td class="celdatabla">
		<input maxlength="50" size="10" name="evaluacion" value="<?PHP   echo $registro[0][0] ?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Acciones del programa:
	</td>
        <td class="celdatabla">
        	<textarea cols="30" rows="5" name="accion_programa"><?PHP   echo $registro[0][1] ?></textarea>

        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Acciones de la instituci&oacute;n:
	</td>
        <td class="celdatabla">
        	<textarea cols="30" rows="5" name="accion_institucion"><?PHP   echo $registro[0][2] ?></textarea>

        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		A&ntilde;o:
	</td>
        </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" valign="undefined">
		<input type="hidden" name="action" value="registro_eval_profesor">
		<input type="hidden" name="anno" value="<?PHP   echo $registro[0][3]?>">
		<input type="hidden" name="id_evaluacion" value="<?PHP   echo $_GET["id_evaluacion"]?>">
		<input type="hidden" name="identificacion" value="<?PHP   echo $registro[0][4]?>">
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
		Informaci&oacute;n de evaluaciones docentes
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Calificaci&oacute;n:
	</td>
        <td class="celdatabla">
		<input maxlength="50" size="10" name="evaluacion">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Acciones del programa:
	</td>
        <td class="celdatabla">
        	<textarea cols="30" rows="5" name="accion_programa"></textarea>

        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Acciones de la instituci&oacute;n:
	</td>
        <td class="celdatabla">
        	<textarea cols="30" rows="5" name="accion_institucion"></textarea>

        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		A&ntilde;o:
	</td>
        <td class="celdatabla"><?PHP  
		$contador=0;
		echo "<select name='anno' size='1'>\n";
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			echo "<option value='".$anno."'>".$anno."</option>\n";
			
		}
		echo "</select>\n";
			?>
        </td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" valign="undefined">
		<input type="hidden" name="action" value="registro_eval_profesor">
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
