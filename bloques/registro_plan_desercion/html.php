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
if(isset($_GET['programa']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT `primero` , `segundo`";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."plan_desercion` ";		
		$cadena_sql.="WHERE id_programa=".$_GET['programa'];
		$cadena_sql.=" AND anno=".$_GET['anno'];
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="registro_plan_desercion" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n sobre Deserci&oacute;n Estudiantil
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  
            
			$busqueda="SELECT nombre_corto ";
			$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
			$busqueda.="WHERE id_programa=".$_GET["programa"];
			$busqueda.=" ORDER BY nombre_corto LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$programa=$acceso_db->obtener_registro_db();
			$total_programas=$acceso_db->obtener_conteo_db();
			if($total_programas>0)
			{
				echo $programa[0][0];
            		}
            		else
            		{
            			echo "N/D";
            		}	
            
            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		<font color="red">*</font>A&ntilde;o:						
		</TD>
		<TD class="celdatabla">
		<?PHP   echo $_GET['anno']?>
		</TD>
		</TR>
		<tr class="mensajealertaencabezado">
        <td class="celdatabla" colspan="2">
		Cantidad de estudiantes que desertaron:
	</td>
      </tr>
	<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Primer semestre del A&ntilde;o:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="3" name="primero" value="<?PHP   echo $registro[0][0]?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Segundo semestre del A&ntilde;o:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="4" name="segundo" value="<?PHP   echo $registro[0][1]?>">
	</td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_plan_desercion">
		<input type="hidden" name="programa" value="<?PHP   echo $_GET['programa']?>">
		<input type="hidden" name="anno" value="<?PHP   echo $_GET['anno']?>">
		<input name="aceptar" value="Aceptar" type="submit" tabindex="5"><br>
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
<form method="POST" action="index.php" name="registro_plan_desercion" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n sobre Deserci&oacute;n Estudiantil
	</td>
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
		<tr class="mensajealertaencabezado">
        <td class="celdatabla" colspan="2">
		Cantidad de estudiantes que desertaron:
	</td>
      </tr>
	<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Primer semestre del A&ntilde;o:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="3" name="primero">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Segundo semestre del A&ntilde;o:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="4" name="segundo">
	</td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_plan_desercion">
		<input name="aceptar" value="Aceptar" type="submit" tabindex="5"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?PHP  
	}

?>
