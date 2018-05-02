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
		$cadena_sql="SELECT `id_proyecto` , `nombre` , `id_programa` , `actividad`, `beneficiario`,`anno`";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."proy_proyecto` ";		
		$cadena_sql.="WHERE id_proyecto=".$_GET['registro']." LIMIT 1";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="registro_proy_proyecto" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="bloquecentralencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n B&aacute;sica de Proyectos de Proyecci&oacute;n
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Nombre:
	</td>
        <td class="celdatabla">
		<textarea cols="35" rows="2" name="nombre" tabindex="2"><?PHP  
		echo $registro[0][1];
		?></textarea>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Actividad de extensi&oacute;n:
	</td>
        <td class="celdatabla">
		<textarea cols="35" rows="2" name="actividad" tabindex="2"><?PHP  
		echo $registro[0][3];
		?></textarea>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Entidad o colectividad beneficiaria:
	</td>
        <td class="celdatabla">
		<textarea cols="35" rows="2" name="beneficiario" tabindex="3"><?PHP  
		echo $registro[0][4];
		?></textarea>
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
$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,$registro[0][2],0,0);
echo $mi_cuadro;
            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		<font color="red">*</font>A&ntilde;o de creaci&oacute;n:						
		</TD>
		<TD class="celdatabla">
		<?PHP  
				echo "<select name='anno' size='1'>\n";
				echo "<option value='0'> </option>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					if($registro[0][5]==$anno)
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
		<input type="hidden" name="action" value="registro_proy_proyecto">
		<input type="hidden" name="id_proyecto" value="<?PHP   echo $_GET['registro']?>">
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
<form method="POST" action="index.php" name="registro_proy_proyecto" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="bloquecentralencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n B&aacute;sica de Proyectos de Proyecci&oacute;n
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Nombre:
	</td>
        <td class="celdatabla">
		<textarea cols="35" rows="2" name="nombre" tabindex="1"></textarea>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Actividad de extensi&oacute;n:
	</td>
        <td class="celdatabla">
		<textarea cols="35" rows="2" name="actividad" tabindex="2"></textarea>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Entidad o colectividad beneficiaria:
	</td>
        <td class="celdatabla">
		<textarea cols="35" rows="2" name="beneficiario" tabindex="3"></textarea>
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
		<font color="red">*</font>A&ntilde;o de inicio:						
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
		<input type="hidden" name="action" value="registro_proy_proyecto">
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
