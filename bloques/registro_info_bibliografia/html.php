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
if(isset($_GET['edicion']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT id_recurso,anno,semestre,cantidad,profesor,estudiante,id_programa";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."bibliografia_programa ";
		$cadena_sql.=" WHERE id_recurso=".$_GET['registro'];
		$cadena_sql.=" AND id_programa=".$_GET['programa'];
		$cadena_sql.=" AND anno=".$_GET['anno'];
		$cadena_sql.=" AND semestre=".$_GET['semestre'];
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_info_bibliografia" onsubmit="return ( control_vacio(this,'recurso'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de informaci&oacute;n Bibliogr&aacute;fica:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Cantidad:<br>
              </td>
              <td class="celdatabla">
		<input maxlength="5" size="4" tabindex="1" name="cantidad" value="<?PHP   echo $registro[0][3] ?>"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de estudiantes que lo usan:<br>
              </td>
              <td class="celdatabla">
                <input maxlength="10" size="6" tabindex="2" name="estudiante" value="<?PHP   echo $registro[0][5] ?>">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de profesores que lo usan:<br>
              </td>
              <td class="celdatabla">
              <input maxlength="10" size="6" tabindex="3" name="profesor" value="<?PHP   echo $registro[0][4] ?>">
	      </td>
            </tr>
<tr class="bloquecentralcuerpo">
              <td class="celdatabla" colspan="2">
		Los datos corresponden:<br>
              </td>
              </tr>
              <tr class="bloquecentralcuerpo">
              <td class="celdatabla" solspan="2">
		Al programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  
$busqueda="SELECT id_programa,nombre_corto ";
$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
$busqueda.=" WHERE id_programa=".$registro[0][6];
$busqueda.=" LIMIT 1";
$acceso_db->registro_db($busqueda,0);
$programa=$acceso_db->obtener_registro_db();
$total=$acceso_db->obtener_conteo_db();
if($total>0)
{
	echo $programa[0][1];
}
else
{
	echo "No determinado";

}


            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		En el a&ntilde;o:						
		</TD>
		<TD class="celdatabla">
		<?PHP   echo $registro[0][1]?>
		</TD>
		</tr>
		<tr  class="bloquecentralcuerpo">
		<TD class="celdatabla">
		Semestre:						
		</TD>
		<TD class="celdatabla">
		<?PHP  
			if($registro[0][2]==1)
			{	
				echo "I";
			}
			else
			{
				echo "II";
			
			
			}	
		?>
		</TD>
	    </TR>
            <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="programa" value="<?PHP   echo $registro[0][6] ?>"><br>
              <input type="hidden" name="anno" value="<?PHP   echo $registro[0][1] ?>">
              <input type="hidden" name="semestre" value="<?PHP   echo $registro[0][2] ?>">
              <input type="hidden" name="registro" value="<?PHP   echo $registro[0][0] ?>">
              <input type="hidden" name="edicion" value="1">
              <input type="hidden" name="action" value="registro_info_bibliografia">
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
<form method="post" action="index.php" name="registrar_info_bibliografia" onsubmit="return ( control_vacio(this,'recurso'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de informaci&oacute;n Bibliogr&aacute;fica:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Cantidad:<br>
              </td>
              <td class="celdatabla">
		<input maxlength="5" size="4" tabindex="1" name="cantidad"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de estudiantes que lo usan:<br>
              </td>
              <td class="celdatabla">
                <input maxlength="10" size="6" tabindex="2" name="estudiante">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de profesores que lo usan:<br>
              </td>
              <td class="celdatabla">
              <input maxlength="10" size="6" tabindex="3" name="profesor">
	      </td>
            </tr>
            <tr class="bloquecentralencabezado">
              <td class="celdatabla" colspan="2">
		Los datos corresponden:<br>
              </td>
 	 </tr>
<tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Al programa:<br>
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
		<TR class='bloquecentralcuerpo'>
		<TD class="celdatabla">
		<font color="red">*</font>Semestre:						
		</TD>
		<TD class="celdatabla">
		<?PHP  
				echo "<table>";
				echo "<tr class='bloquecentralcuerpo'>";
				echo "<td class='celdatabla'>\n<input checked='checked' name='semestre' value='1' type='radio' tabindex='5'>I";
				echo "</td>\n";
				echo "<td class='celdatabla'>\n";
				echo "<input  name='semestre' value='2' type='radio' tabindex='6'>II";
				echo "</td>\n";
				echo "</tr>";
				echo "</table>";
		?>
		</TD>
	    </TR>
            <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="action" value="registro_info_bibliografia"><br>
              <input type="hidden" name="registro" value="<?PHP   echo $_GET['registro'] ?>">
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
