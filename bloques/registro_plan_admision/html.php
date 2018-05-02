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
* @description  Formulario de registro de grupos de investigacion
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
if(isset($_GET['registro']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT `id_proceso` , `id_programa` , `tipo` , `ingreso`,`inscripcion`,`icfes`,`admision`,`anno`";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."plan_admision` ";		
		$cadena_sql.="WHERE id_proceso=".$_GET['registro']." LIMIT 1";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'ocupacion') && control_vacio(this,'ubicacion') ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="bloquecentralencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n sobre procesos de admisi&oacute;n
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Proceso de selecci&oacute;n:
	</td>
        <td class="celdatabla">
		<textarea cols="30" rows="1" name="tipo" tabindex="2"><?PHP   echo $registro[0][2]?></textarea>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>No de estudiantes inscritos:
	</td>
        <td class="celdatabla">
		<input maxlength="20" size="10" tabindex="3" name="inscripcion" value="<?PHP   echo $registro[0][4]?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>No de estudiantes que ingresaron:
	</td>
        <td class="celdatabla">
		<input maxlength="20" size="10" tabindex="4" name="ingreso" value="<?PHP   echo $registro[0][3]?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Puntaje promedio pruebas de estado:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="10" tabindex="5" name="icfes" value="<?PHP   echo $registro[0][5]?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Puntaje promedio pruebas de admisi&oacute;n:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="10" tabindex="6" name="admision" value="<?PHP   echo $registro[0][6]?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,$registro[0][1],0,0);
echo $mi_cuadro;
            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		<font color="red">*</font>A&ntilde;o:						
		</TD>
		<TD class="celdatabla">
		<?PHP  
				echo "<select name='anno' size='1'>\n";
				echo "<option value='0'> </option>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					if($registro[0][7]==$anno)
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
		</TD>
		</TR>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_plan_admision">
		<input type="hidden" name="id_proceso" value="<?PHP   echo $_GET['registro']?>">
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
{ // Si es un registro nuevo
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="registro_plan_admision" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="bloquecentralencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n sobre procesos de admisi&oacute;n
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Proceso de selecci&oacute;n:
	</td>
        <td class="celdatabla">
		<textarea cols="30" rows="1" name="tipo" tabindex="2"></textarea>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>No de estudiantes inscritos:
	</td>
        <td class="celdatabla">
		<input maxlength="20" size="10" tabindex="3" name="inscripcion">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>No de estudiantes que ingresaron:
	</td>
        <td class="celdatabla">
		<input maxlength="20" size="10" tabindex="4" name="ingreso">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Puntaje promedio pruebas de estado:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="10" tabindex="5" name="icfes">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Puntaje promedio pruebas de admisi&oacute;n:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="10" tabindex="6" name="admision">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,0,0);
echo $mi_cuadro;
            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		<font color="red">*</font>A&ntilde;o:						
		</TD>
		<TD class="celdatabla">
		<?PHP  
				echo "<select name='anno' size='1'>\n";
				echo "<option value='0'> </option>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					echo "<option value='".$anno."'>".$anno."</option>\n";
					
				}
				echo "</select>\n";
		?>
		</TD>
		</TR>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_plan_admision">
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
