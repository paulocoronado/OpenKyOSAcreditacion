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
if(isset($_GET['anno']))
{	
?>
<script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_uso_recurso" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="4" rowspan="1" align="undefined" valign="undefined">Informe de uso (Promedio de Horas de ocupaci&oacute;n al d&iacute;a):</td>
            </tr>
            <?PHP  
        $acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{    
		$cadena_sql="SELECT ".$configuracion["prefijo"]."recurso_fisico.id_recurso, ".$configuracion["prefijo"]."recurso_fisico.nombre, ".$configuracion["prefijo"]."uso_recurso.utilizacion ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."recurso_fisico,".$configuracion["prefijo"]."uso_recurso "; 
		$cadena_sql.="WHERE ".$configuracion["prefijo"]."uso_recurso.anno =".$_GET["anno"]." AND ".$configuracion["prefijo"]."uso_recurso.id_programa =".$_GET["id_programa"]." ";
		$cadena_sql.="AND ".$configuracion["prefijo"]."recurso_fisico.id_recurso = ".$configuracion["prefijo"]."uso_recurso.id_recurso";
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			echo '<tr align="center" class="mensajealertaencabezado"><td class="celdatabla">Recurso</td><td class="celdatabla">Promedio uso diario(Horas)</td>';		
			for($contador=0;$contador<$campos;$contador++)
			{     
					echo '<tr class="bloquecentralcuerpo">';
					echo '<td class="celdatabla">';	
					echo '<font color="red">*</font>'.ucfirst($registro[$contador][1]).'<br>';
					echo '</td>';
					echo '<td class="celdatabla" align="center">';
					echo '<input maxlength="4" size="4" tabindex="'.($contador+1).'" name="'.$registro[$contador][0].'" value="'.$registro[$contador][2].'"><br>';
					echo '</td>';
					echo '</tr>';
			
			}
		}
		
       }     
  ?>
  <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla"  align="center"><?PHP  
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
              <td colspan="4" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_uso_recurso">
		<input type="hidden" name="usuario" value="<?PHP   echo $_GET['usuario'] ?>">
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
{

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_uso_recurso" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="4" rowspan="1" align="undefined" valign="undefined">Informe de uso (Promedio de Horas de ocupaci&oacute;n al d&iacute;a):</td>
            </tr>
            <?PHP  
        $acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{    
        $cadena_sql="SELECT id_recurso,nombre FROM ".$configuracion["prefijo"]."recurso_fisico";
        $acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
	  echo '<tr align="center" class="mensajealertaencabezado"><td class="celdatabla">Recurso</td><td class="celdatabla">Promedio uso diario(Horas)</td>';		
          for($contador=0;$contador<$campos;$contador++)
		{     
            		echo '<tr class="bloquecentralcuerpo">';
            		echo '<td class="celdatabla">';	
            		echo '<font color="red">*</font>'.ucfirst($registro[$contador][1]).'<br>';
            		echo '</td>';
            		echo '<td class="celdatabla" align="center">';
			echo '<input maxlength="4" size="4" tabindex="'.($contador+1).'" name="'.$registro[$contador][0].'"><br>';
			echo '</td>';
			echo '</tr>';
            
            }
       }
              
       }     
  ?>
  <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla"  align="center"><?PHP  
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
              <td colspan="4" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_uso_recurso">
		<input type="hidden" name="usuario" value="<?PHP   echo $_GET['usuario'] ?>">
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
