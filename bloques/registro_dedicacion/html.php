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
if(isset($_GET['id_dedicacion']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	//Rescatar datos anuales, con nombre de programa y nombre del tipo de vinculacion
	$cadena_sql="SELECT ";
	$cadena_sql.="id_dedicacion, ";
	$cadena_sql.="anno, ";
	$cadena_sql.="docencia, ";
	$cadena_sql.="investigacion, ";
	$cadena_sql.="proyeccion, ";
	$cadena_sql.="administrativa,";
	$cadena_sql.="identificacion,";
	$cadena_sql.="periodo";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor_info_dedicacion ";
	$cadena_sql.=" WHERE id_dedicacion=".$_GET['id_dedicacion'];	
	$cadena_sql.=" LIMIT 1";
	//	0 id_dedicacion
	//	1 anno
	//	2.docencia
	//	3.investigacion
	//	4.proyeccion
	//	5.administrativa
	//	6.identificacion
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dedicacion" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="4" rowspan="1" align="undefined" valign="undefined">Horas de dedicaci&oacute;n: (Promedio semanal de dedicaci&oacute;n en cada &aacute;rea)</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Docencia<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="5" size="4" tabindex="1" name="docencia" value="<?php   echo $registro[0][2] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Investigaci&oacute;n<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="investigacion" value="<?php   echo $registro[0][3] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Proyecci&oacute;n Social <br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="proyeccion" value="<?php   echo $registro[0][4] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Funciones Administrativas<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="administrativa" value="<?php   echo $registro[0][5] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Periodo<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="periodo" value="<?php   echo $registro[0][7] ?>"><br>
	    </td>
	    </tr>
            <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla"  align="center">
        	<?php   echo $registro[0][1] ?>
        </td>
      </tr>
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dedicacion">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="id_dedicacion" value="<?php   echo $registro[0][0] ?>">
		<input type="hidden" name="anno" value="<?php   echo $registro[0][1] ?>">
		<input type="hidden" name="identificacion" value="<?php   echo $registro[0][6] ?>">
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
<?php  		}	
	}
}
else
{

?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dedicacion" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="4" rowspan="1" align="undefined" valign="undefined">Horas de dedicaci&oacute;n (Por semana en cada &aacute;rea:)</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Docencia<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="5" size="4" tabindex="1" name="docencia"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Investigaci&oacute;n<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="investigacion"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Proyecci&oacute;n<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="proyeccion"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Funciones Administrativas<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="administrativa"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla">
            <font color="red">*</font>Periodo<br>
            </td>
            <td class="celdatabla" align="center">
	    <input maxlength="4" size="4" tabindex="1" name="periodo"><br>
	    </td>
	    </tr>
  <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla"  align="center"><?php  
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
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_dedicacion">
		<input type="hidden" name="usuario" value="<?php   echo $_GET['usuario'] ?>">
		<input type="hidden" name="identificacion" value="<?php   echo $_GET['identificacion'] ?>">
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
