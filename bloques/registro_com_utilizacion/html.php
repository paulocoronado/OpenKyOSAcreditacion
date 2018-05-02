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
if(isset($_GET['programa']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT id_material,id_programa,uso,anno";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."com_utilizacion ";
		$cadena_sql.=" WHERE id_material=".$_GET['id_material'];
		$cadena_sql.=" AND id_programa=".$_GET['programa'];
		$cadena_sql.=" AND anno=".$_GET['anno'];
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_com_utilizacion" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="mensajealertaencabezado">
              <td colspan="2" rowspan="1" >Registro de informaci&oacute;n sobre uso del material:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de estudiantes que lo usan:<br>
              </td>
              <td class="celdatabla">
                <input maxlength="10" size="6" tabindex="2" name="estudiante" value="<?php   echo $registro[0][2] ?>">
	      </td>
            </tr>
            <tr class="mensajealertaencabezado">
              <td colspan="2">
		Los datos corresponden:<br>
              </td>
              </tr>
              <tr class="bloquecentralcuerpo">
              <td class="celdatabla" solspan="2">
		Al programa:<br>
              </td>
 		<td class="celdatabla">
		<?php  
$busqueda="SELECT id_programa,nombre_corto ";
$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
$busqueda.=" WHERE id_programa=".$registro[0][1];
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
		<?php   echo $registro[0][3]?>
		</TD>
		</tr>
	        <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="programa" value="<?php   echo $registro[0][1] ?>"><br>
              <input type="hidden" name="anno" value="<?php   echo $registro[0][3] ?>">
              <input type="hidden" name="id_material" value="<?php   echo $registro[0][0] ?>">
              <input type="hidden" name="identificacion" value="<?php   echo $_GET['registro'] ?>">
              <input type="hidden" name="action" value="registro_com_utilizacion">
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

<?php  
}
}	

}
else
{
	
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_com_utilizacion" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="mensajealertaencabezado">
              <td colspan="2" rowspan="1" >Registro de informaci&oacute;n sobre uso del material:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>N&uacute;mero de estudiantes que lo usan:<br>
              </td>
              <td class="celdatabla">
                <input maxlength="10" size="6" tabindex="2" name="estudiante">
	      </td>
            </tr>
            <tr class="mensajealertaencabezado">
              <td colspan="2">
		Los datos corresponden:<br>
              </td>
 	 </tr>
<tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Al programa:<br>
              </td>
 		<td class="celdatabla">
		<?php  
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
		<?php  
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
              <input type="hidden" name="action" value="registro_com_utilizacion"><br>
              <input type="hidden" name="identificacion" value="<?php   echo $_GET['registro'] ?>">
              <input type="hidden" name="id_material" value="<?php   echo $_GET['id_material'] ?>">
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
<?php  
}
?>
