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
if(isset($_GET['registro']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT id_recurso,anno,recurso,estudiante,profesor,id_programa";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_informatico ";
		$cadena_sql.=" WHERE id_recurso=".$_GET['registro']." LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_profesor" onsubmit="return ( control_vacio(this,'recurso'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de recursos inform&aacute;ticos:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Nombre del Recurso:<br>
              </td>
              <td class="celdatabla">
		<input maxlength="80" size="45" tabindex="1" name="recurso" value="<?PHP   echo $registro[0][2]?>"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de estudiantes que lo usan:<br>
              </td>
              <td class="celdatabla">
                <input maxlength="10" size="10" tabindex="2" name="estudiante" value="<?PHP   echo $registro[0][3]?>">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de profesores que lo usan:<br>
              </td>
              <td class="celdatabla">
              <input maxlength="10" size="10" tabindex="3" name="profesor" value="<?PHP   echo $registro[0][4]?>">
	      </td>
            </tr>
<tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Los datos corresponden al programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,$registro[0][5],0,0);
echo $mi_cuadro;
            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		<font color="red">*</font>En el a&ntilde;o:						
		</TD>
		<TD class="celdatabla">
		<?PHP  
				echo "<select name='anno' size='1'>\n";
				echo "<option value='0'> </option>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					if($anno==$registro[0][1])
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
            <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="action" value="registro_recurso_informatico"><br>
              <input type="hidden" name= "id_recurso" value="<?PHP   echo $registro[0][0]?>">	
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
}	

}
else
{
	
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_profesor" onsubmit="return ( control_vacio(this,'recurso'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de recursos inform&aacute;ticos:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Nombre del Recurso:<br>
              </td>
              <td class="celdatabla">
		<input maxlength="80" size="45" tabindex="1" name="recurso"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de estudiantes que lo usan:<br>
              </td>
              <td class="celdatabla">
                <input maxlength="10" size="10" tabindex="2" name="estudiante">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de profesores que lo usan:<br>
              </td>
              <td class="celdatabla">
              <input maxlength="10" size="10" tabindex="3" name="profesor">
	      </td>
            </tr>
<tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Los datos corresponden al programa:<br>
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
		<font color="red">*</font>En el a&ntilde;o:						
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
            <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="action" value="registro_recurso_informatico"><br>
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
?>
