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
		$cadena_sql="SELECT `id_grupo` , `nombre` , `id_programa` , `director`,`anno`";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."grupo_investigacion` ";		
		$cadena_sql.="WHERE id_grupo=".$_GET['registro']." LIMIT 1";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'ocupacion') && control_vacio(this,'ubicacion') ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="bloquecentralencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n B&aacute;sica de Grupos de Investigaci&oacute;n
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
		<font color="red">*</font>Director:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="40" tabindex="3" name="director" value="<?PHP   echo $registro[0][3]?>">
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
					if($registro[0][4]==$anno)
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
		
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1" class="celdatabla">
		Reconocimiento Institucional:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<tr class="bloquecentralcuerpo"><?PHP  
		$cadena_sql="SELECT anno ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."reconocimiento_grupo ";
		$cadena_sql.="WHERE entidad='institucional' ";
		$cadena_sql.=" AND id_grupo=".$_GET['registro']; 
		$acceso_db->registro_db($cadena_sql,0);
		//echo $cadena_sql;
		$institucional=$acceso_db->obtener_registro_db();
		$total=$acceso_db->obtener_conteo_db();
		if($total>0)
		{
			
			$fila=0;
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
					echo "<input name='institucional_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
					echo '</td>';
				}
				else
				{
					echo '<td class="celdatabla">';
					echo "<input name='institucional_".$anno."' value='".$anno."' type='checkbox' checked='checked'>\n".$anno;	
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
				echo "<input name='institucional_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
				echo '</td>';
				$fila++;
				if($fila==4)
				{
					echo "</tr>\n";
					$fila=0;
				}
				
			}
		
		
		
		
		}	
			?></tr>
          	</tbody>
        	</table>
        </td>
      </tr>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1" class="celdatabla">
		Reconocimiento COLCIENCIAS:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<tr class="bloquecentralcuerpo"><?PHP  
		$cadena_sql="SELECT anno ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."reconocimiento_grupo ";
		$cadena_sql.="WHERE entidad='colciencias' ";
		$cadena_sql.=" AND id_grupo=".$_GET['registro']; 
		$acceso_db->registro_db($cadena_sql,0);
		//echo $cadena_sql;
		$institucional=$acceso_db->obtener_registro_db();
		$total=$acceso_db->obtener_conteo_db();
		if($total>0)
		{
			
			$fila=0;
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
					echo "<input name='colciencias_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
					echo '</td>';
				}
				else
				{
					echo '<td class="celdatabla">';
					echo "<input name='colciencias_".$anno."' value='".$anno."' type='checkbox' checked='checked'>\n".$anno;	
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
				echo "<input name='colciencias_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
				echo '</td>';
				$fila++;
				if($fila==4)
				{
					echo "</tr>\n";
					$fila=0;
				}
				
			}
		
		
		
		
		}	
			?></tr>
          	</tbody>
        	</table>
        </td>
      </tr>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1" class="celdatabla">
		Activo durante:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<tr class="bloquecentralcuerpo"><?PHP  
		$cadena_sql="SELECT anno ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."estado_grupo ";
		$cadena_sql.="WHERE id_grupo=".$_GET['registro']; 
		$acceso_db->registro_db($cadena_sql,0);
		//echo $cadena_sql;
		$institucional=$acceso_db->obtener_registro_db();
		$total=$acceso_db->obtener_conteo_db();
		if($total>0)
		{
			
			$fila=0;
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
					echo "<input name='actividad_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
					echo '</td>';
				}
				else
				{
					echo '<td class="celdatabla">';
					echo "<input name='actividad_".$anno."' value='".$anno."' type='checkbox' checked='checked'>\n".$anno;	
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
				echo "<input name='actividad_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
				echo '</td>';
				$fila++;
				if($fila==4)
				{
					echo "</tr>\n";
					$fila=0;
				}
				
			}
		
		
		
		
		}	
			?></tr>
          	</tbody>
        	</table>
        </td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_iioc_grupo">
		<input type="hidden" name="id_grupo" value="<?PHP   echo $_GET['registro']?>">
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
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'ocupacion') && control_vacio(this,'ubicacion') ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="bloquecentralencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n B&aacute;sica de Grupos de Investigaci&oacute;n
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Nombre:
	</td>
        <td class="celdatabla">
		<textarea cols="35" rows="2" name="nombre" tabindex="2"></textarea>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Director:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="40" tabindex="3" name="director">
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
		<font color="red">*</font>A&ntilde;o de creaci&oacute;n:						
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
        <td colspan="2" rowspan="1" class="celdatabla">
		Reconocimiento Institucional:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<tr class="bloquecentralcuerpo"><?PHP  
		$fila=0;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($fila==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			
			
			echo '<td class="celdatabla">';
			echo "<input name='institucional_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
			echo '</td>';
			$fila++;
			if($fila==4)
			{
				echo "</tr>\n";
				$fila=0;
			}
			
		}?></tr>
          	</tbody>
        	</table>
        </td>
      </tr>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1" class="celdatabla">
		Reconocimiento COLCIENCIAS:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<tr class="bloquecentralcuerpo"><?PHP  
		$fila=0;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($fila==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			
			
			echo '<td class="celdatabla">';
			echo "<input name='colciencias_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
			echo '</td>';
			$fila++;
			if($fila==4)
			{
				echo "</tr>\n";
				$fila=0;
			}
			
		}
			?></tr>
          	</tbody>
        	</table>
        </td>
      </tr>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1" class="celdatabla">
		Activo durante:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<tr class="bloquecentralcuerpo"><?PHP  
		$fila=0;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($fila==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			
			
			echo '<td class="celdatabla">';
			echo "<input name='actividad_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
			echo '</td>';
			$fila++;
			if($fila==4)
			{
				echo "</tr>\n";
				$fila=0;
			}
			
		}
			?></tr>
          	</tbody>
        	</table>
        </td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_iioc_grupo">
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
