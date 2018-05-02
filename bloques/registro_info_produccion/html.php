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
if(isset($_GET['id_profesor_produccion']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT `id_profesor_produccion` , `identificacion` , `anno` , `indexada` , `especializada` , `innovacion` , `artistica` , `patente` ";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."profesor_info_produccion` ";
		$cadena_sql.="WHERE id_profesor_produccion=".$_GET['id_profesor_produccion']." LIMIT 1";
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
		Informaci&oacute;n de Producci&oacute;n del profesor
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		No de Publicaciones en revistas indexadas:
	</td>
        <td class="celdatabla">
		<input maxlength="6" size="5" name="indexada" value="<?PHP   echo $registro[0][3] ?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		No de Publicaciones en revistas especializadas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="especializada" value="<?PHP   echo $registro[0][4] ?>">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Innovaciones reconocidas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="innovacion" value="<?PHP   echo $registro[0][5] ?>">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		No de Creaciones art&iacute;sticas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="artistica" value="<?PHP   echo $registro[0][6] ?>">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Patentes registradas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="patente" value="<?PHP   echo $registro[0][7] ?>">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Informaci&oacute;n del A&ntilde;o:
	</td>
        <td class="celdatabla"><?PHP  
		$contador=0;
		echo "<select name='anno' size='1'>\n";
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($anno==$registro[0][2])
			{
				echo "<option selected='true' value='".$anno."'>".$anno."</option>\n";
			}
			else
			{
				echo "<option value='".$anno."'>".$anno."</option>\n";			
			}
			
		}
		echo "</select>\n";
			?>
        </td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" valign="undefined">
		<input type="hidden" name="action" value="registro_info_produccion">
		<input type="hidden" name="identificacion" value="<?PHP   echo $registro[0][1] ?>">
		<input type="hidden" name="id_produccion" value="<?PHP   echo $registro[0][0] ?>">
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
}		
else
{ // Si es un registro nuevo
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n de Producci&oacute;n del profesor
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		No de Publicaciones en revistas indexadas:
	</td>
        <td class="celdatabla">
		<input maxlength="6" size="5" name="indexada">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		No de Publicaciones en revistas especializadas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="especializada">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Innovaciones reconocidas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="innovacion">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		No de Creaciones art&iacute;sticas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="artistica">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Patentes registradas:
	</td>
        <td class="celdatabla">
        	<input maxlength="6" size="5" name="patente">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Informaci&oacute;n del A&ntilde;o:
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
		<input type="hidden" name="action" value="registro_info_produccion">
		<input type="hidden" name="identificacion" value="<?PHP   echo $_GET["registro"]?>">
		<input name="aceptar" value="Aceptar" type="submit"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?PHP  
}
?>
