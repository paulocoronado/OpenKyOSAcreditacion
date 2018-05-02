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
  
indicador.html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	formulario
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* 
*
* Codigo HTML del formulario de autenticacion de usuarios
*
*****************************************************************************************************************/
?><?PHP  

if(isset($_GET['id_documento']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	//Rescatar datos anuales, con nombre de programa y nombre del tipo de vinculacion
	$cadena_sql="SELECT ";
		$cadena_sql.="id_documento, ";
		$cadena_sql.="id_programa, ";
		$cadena_sql.="titulo, ";
		$cadena_sql.="documento, ";
		$cadena_sql.="descripcion ";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."investigacion_documento ";
		$cadena_sql.=" WHERE id_documento=".$_GET['id_documento']."";	
		$cadena_sql.=" LIMIT 1";
		//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype="multipart/form-data" method="post" action="index.php" name="registrar_iioc_doc_institucional" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
          <tr class="mensajealertaencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Documentos sobre criterios y pol&iacute;ticas institucionales en materia de investigaci&oacute;n:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nombre:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="255" size="40" tabindex="1" name="titulo" value="<?PHP   echo $registro[0][2] ?>"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Descripci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="descripcion" tabindex="2"><?PHP   echo $registro[0][4] ?></textarea><br>
	    </td>
	    </tr>
	    
	    <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top" colspan="2">
		<font color="red">*</font>Vigente en los a&ntilde;os:
	</td>
	</tr>
	<tr>
        <td class="celdatabla" valign="top" align="left" colspan="2"><?PHP  
		$cadena_sql="SELECT anno ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."doc_vigencia ";
		$cadena_sql.="WHERE id_documento=".$_GET['id_documento']; 
		$acceso_db->registro_db($cadena_sql,0);
		//echo $cadena_sql;
		$institucional=$acceso_db->obtener_registro_db();
		$total=$acceso_db->obtener_conteo_db();
		echo "<table width='100%' border='0'>";
		if($total>0)
		{
			
			$fila=0;
			$tab=3;
			for($anno=2001;$anno<date("Y")+1;$anno++)
			{	
				if($fila==0)
				{
					echo "<tr class='bloquecentralcuerpo'>\n";
				}
				
				$seleccion=FALSE;
				for($contador=0;$contador<$total;$contador++)
				{
					if($institucional[$contador][0]==$anno)
					{
						$seleccion=TRUE;
						break;
					}	
					
				}	
				
				if($seleccion==FALSE)
				{
					echo '<td class="celdatabla">';
					echo "<input name='documento_".$anno."' value='".$anno."' type='checkbox' tabindex='".$tab++."'>\n".$anno;	
					echo '</td>';
				}
				else
				{
					echo '<td class="celdatabla">';
					echo "<input name='documento_".$anno."' value='".$anno."' type='checkbox' checked='checked' tabindex='".$tab++."'>\n".$anno;	
					echo '</td>';
				
				}
				
				$fila++;
				if($fila==4)
				{
					echo "</tr>\n";
					$fila=0;
				}
				
			}	
		}
		else
		{
			$fila=0;
			for($anno=2001;$anno<date("Y")+1;$anno++)
			{	
				if($fila==0)
				{
					echo "<tr class='bloquecentralcuerpo'>\n";
				}
				
				
				echo '<td class="celdatabla">';
				echo "<input name='documento_".$anno."' value='".$anno."' type='checkbox' tabindex='".$tab++."'>\n".$anno;	
				echo '</td>';
				$fila++;
				if($fila==4)
				{
					echo "</tr>\n";
					$fila=0;
				}
				
			}
		
		
		
		
		}
		echo "</table>";	
			?>
        </td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td colspan="2" class="celdatabla" valign="top">
            <font color="red">*</font>Documento de soporte:<br>
            </td>
            </tr>
            <tr>
            <td colspan="2" class="celdatabla" align="center" valign="top">
	    <?PHP   echo $registro[0][3]?>
	    </td>
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_iioc_doc_institucional">
		<input type="hidden" name="id_documento" value="<?PHP   echo $_GET['id_documento'] ?>">
		<input type="hidden" name="archivo" value="<?PHP   echo $registro[0][3]?>">
		<input type="hidden" name="id_programa" value="0">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex='<?PHP   echo $tab++; ?>'>
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
<form enctype="multipart/form-data" method="post" action="index.php" name="registrar_iioc_doc_institucional" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="2">
          <tbody>
          <tr class="mensajealertaencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Documentos sobre criterios y pol&iacute;ticas institucionales en materia de investigaci&oacute;n:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
            <td class="celdatabla" valign="top" align="left">
            <font color="red">*</font>Nombre:<br>
            </td>
            <td class="celdatabla" align="left" valign="middle">
	    <input maxlength="255" size="40" tabindex="1" name="titulo"><br>
	    </td>
	    </tr>
	    <tr class="bloquecentralcuerpo">
            <td class="celdatabla" align="left" valign="top">
            <font color="red">*</font>Descripci&oacute;n:<br>
            </td>
            <td class="celdatabla" align="left" valign="top">
	    <textarea cols="40" rows="2" name="descripcion" tabindex="2"></textarea><br>
	    </td>
	    </tr>
	    
	    <tr class="bloquecentralcuerpo">
        <td colspan="2" class="celdatabla" valign="top">
		<font color="red">*</font>Vigente en los a&ntilde;os:
	</td>
	</tr>
	<tr>
        <td colspan="2" class="celdatabla" valign="top" align="left"><?PHP  
        	echo "<table width='100%'>";
		$fila=0;
		$tab=3;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($fila==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			
			
			echo '<td class="celdatabla">';
			echo "<input name='documento_".$anno."' value='".$anno."' type='checkbox' tabindex='".$tab."'>\n".$anno;	
			echo '</td>';
			$fila++;
			$tab++;
			if($fila==4)
			{
				echo "</tr>\n";
				$fila=0;
			}
			
		}
		echo "</table>";
	?>	
        </td>
      </tr>
      	<tr class="bloquecentralcuerpo">
            <td colspan="2" class="celdatabla" valign="top">
            <font color="red">*</font>Documento de soporte:<br>
            </td>
            </tr>
            <tr>
            <td  colspan="2" class="celdatabla" align="center" valign="top">
	    <input name='archivo' type='file' tabindex='<?PHP   echo $tab++; ?>'>
	    </td>
	    </tr>	
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_iioc_doc_institucional">
		<input type="hidden" name="id_programa" value="0">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex='<?PHP   echo $tab++; ?>'>
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
