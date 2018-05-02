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


$tab=1;
//Si esta editando
if(isset($_GET['registro']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="id_recurso, ";
		$cadena_sql.="recurso, ";
		$cadena_sql.="tipo, ";
		$cadena_sql.="codigo, ";
		$cadena_sql.="autor, ";
		$cadena_sql.="descripcion";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."recurso_bibliografico ";
		$cadena_sql.=" WHERE id_recurso=".$_GET['registro']." LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_profesor" onsubmit="return ( control_vacio(this,'recurso'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de recursos bibliogr&aacute;ficos:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Nombre:<br>
              </td>
              <td class="celdatabla" >
		<input maxlength="80" size="45" tabindex="<?PHP   echo $tab++ ?>" name="recurso" value="<?PHP   echo $registro[0][1]?>"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo" align="left">
              <td class="celdatabla">
		<font color="red">*</font>C&oacute;digo Interno:<br>
              </td>
              <td class="celdatabla">
		<input maxlength="80" size="30" tabindex="<?PHP   echo $tab++ ?>" name="codigo" value="<?PHP   echo $registro[0][3]?>"><br>
              </td>
           </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Autor(es):<br>
              </td>
              <td class="celdatabla">
		<textarea cols="40" rows="6" name="autor" tabindex="<?PHP   echo $tab++ ?>"><?PHP   echo $registro[0][4]?></textarea>
              </td>
           </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Descripci&oacute;n:<br>
              </td>
              <td class="celdatabla">
		<textarea cols="40" rows="6" name="descripcion" tabindex="<?PHP   echo $tab++ ?>"><?PHP   echo $registro[0][5]?></textarea>
              </td>
           </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Tipo:<br>
              </td>
              <td class="celdatabla"><?PHP  
		echo "<select name='tipo' size='1' tabindex='".$tab++."'>\n";
		
		switch($registro[0][2])
		{
			case 1:
				echo "<option selected='true' value='1'>Revista Especializada</option>\n";
				echo "<option value='2'>Libro</option>\n";
				echo "<option value='3'>Base de Datos</option>\n";
				echo "<option value='4'>Otro tipo</option>\n";
				echo "</select>\n";
				break;
				
			case 2:
				echo "<option value='1'>Revista Especializada</option>\n";
				echo "<option selected='true' value='2'>Libro</option>\n";
				echo "<option value='3'>Base de datos</option>\n";
				echo "<option value='4'>Otro tipo</option>\n";
				echo "</select>\n";
				break;	
				
			case 3:
				echo "<option value='1'>Revista Especializada</option>\n";
				echo "<option value='2'>Libro</option>\n";
				echo "<option selected='true' value='3'>Base de datos</option>\n";
				echo "<option value='4'>Otro tipo</option>\n";
				echo "</select>\n";
				break;
				
			case 4:
				echo "<option value='1'>Revista Especializada</option>\n";
				echo "<option value='2'>Libro</option>\n";
				echo "<option value='3'>Base de datos</option>\n";
				echo "<option selected='true' value='4'>Otro tipo</option>\n";
				echo "</select>\n";
				break;	
				
						
			default:
				break;		
		}
		?>		
              </td>
           </tr>
            <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="action" value="registro_recurso_bibliografico">
              <input type="hidden" name="id_recurso" value="<?PHP   echo $registro[0][2] ?>"><br>
              <div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="3"><br>
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
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de recursos bibliogr&aacute;ficos:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Nombre del Recurso:<br>
              </td>
              <td class="celdatabla">
		<input maxlength="80" size="30" tabindex="<?PHP   echo $tab++ ?>" name="recurso"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td class="celdatabla" align="left">
		<font color="red">*</font>C&oacute;digo Interno:<br>
              </td>
              <td class="celdatabla">
		<input maxlength="80" size="30" tabindex="<?PHP   echo $tab++ ?>" name="codigo"><br>
              </td>
           </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Autor(es):<br>
              </td>
              <td class="celdatabla">
		<textarea cols="40" rows="6" name="autor" tabindex="<?PHP   echo $tab++ ?>"></textarea>
              </td>
           </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Descripci&oacute;n:<br>
              </td>
              <td class="celdatabla">
		<textarea cols="40" rows="6" name="descripcion" tabindex="<?PHP   echo $tab++ ?>"></textarea>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Tipo de Recurso:<br>
              </td>
                 <td class="celdatabla"><?PHP  
		echo "<select name='tipo' size='1' tabindex='".$tab++."'>\n";
		echo "<option value='0'></option>\n";
		echo "<option value='1'>Revista Especializada</option>\n";
		echo "<option value='2'>Libro</option>\n";
		echo "<option value='3'>Base de Datos</option>\n";
		echo "<option value='4'>Otro tipo</option>\n";
		echo "</select>\n";
		?>		
              </td>
           </tr>
            <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="action" value="registro_recurso_bibliografico"><br>
              <div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="3"><br>
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
