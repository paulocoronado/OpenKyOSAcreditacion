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
if(isset($_GET['id_trabajo']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	//Rescatar datos anuales, con nombre de programa y nombre del tipo de vinculacion
	$cadena_sql="SELECT ";
		$cadena_sql.="id_trabajo, ";
		$cadena_sql.="anno, ";
		$cadena_sql.="nombre, ";
		$cadena_sql.="apellido, ";
		$cadena_sql.="identificacion, ";
		$cadena_sql.="titulo, ";
		$cadena_sql.="descripcion, ";
		$cadena_sql.="premio ";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."estudiante_info_trabajo ";
		$cadena_sql.=" WHERE id_trabajo=".$_GET['id_trabajo']."";	
		$cadena_sql.=" LIMIT 1";
		//	0 id_trabajo
		//	1 anno
		//	2.nombre
		//	3.apellido
		//	4.identificacion
		//	5.titulo
		//	6.descripcion
		//	7.premio
		
		//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_info_trabajo" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1">Trabajo realizado por estudiantes:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nombre del Estudiante:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="100" size="40" tabindex="1" name="nombre" value="<?PHP   echo $registro[0][2] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Apellidos del Estudiante:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="100" size="40" tabindex="2" name="apellido" value="<?PHP   echo $registro[0][3] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Identificaci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <?PHP   echo $registro[0][4] ?><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>T&iacute;tulo del trabajo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="titulo" tabindex="4"><?PHP   echo $registro[0][5] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Descripci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="descripcion" tabindex="5"><?PHP   echo $registro[0][6] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Premio recibido:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="premio" tabindex="6"><?PHP   echo $registro[0][7] ?></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla" valign="top" align="left"><?PHP   echo $registro[0][1] ?>
        </td>
      </tr>
       	  <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_info_trabajo">
		<input type="hidden" name="usuario" value="<?PHP   echo $_GET['usuario'] ?>">
		<input type="hidden" name="anno" value="<?PHP   echo $registro[0][1] ?>">
		<input type="hidden" name="id_trabajo" value="<?PHP   echo $registro[0][0] ?>">
		<input type="hidden" name="identificacion" value="<?PHP   echo $registro[0][4] ?>">
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
<form method="post" action="index.php" name="registrar_info_trabajo" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1">Trabajo realizado por estudiantes:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nombre del Estudiante:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="100" size="40" tabindex="1" name="nombre"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Apellidos del Estudiante:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="100" size="40" tabindex="2" name="apellido"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Identificaci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="100" size="30" tabindex="3" name="identificacion"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>T&iacute;tulo del trabajo:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="titulo" tabindex="4"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Descripci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="descripcion" tabindex="5"></textarea><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Premio recibido:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="premio" tabindex="6"></textarea><br>
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
       	  <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_info_trabajo">
		<input type="hidden" name="usuario" value="<?PHP   echo $_GET['usuario'] ?>">
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
