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
					
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_info_servicio" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="2">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de informaci&oacute;n del servicio:</td>
            </tr>
            <tr class="mensajealertaencabezado">
              <td class="celdatabla" colspan="2">
		El servicio beneficia:<br>
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
$busqueda.=" WHERE id_programa=".$_GET['programa'];
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
            <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1" class="celdatabla">
		En los a&ntilde;os:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody><?PHP  
		$cadena_sql="SELECT anno";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."servicio_programa ";
		$cadena_sql.="WHERE id_servicio=".$_GET['registro']; 
		$cadena_sql.=" AND id_programa=".$_GET['programa']; 
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
					echo "<input name='servicio_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
					echo '</td>';
				}
				else
				{
					echo '<td class="celdatabla">';
					echo "<input name='servicio_".$anno."' value='".$anno."' type='checkbox' checked='checked'>\n".$anno;	
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
				echo "<input name='servicio_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
				echo '</td>';
				$fila++;
				if($fila==4)
				{
					echo "</tr>\n";
					$fila=0;
				}
				
			}
		
		
		
		
		}	
			?>
          	</tbody>
        	</table>
        </td>
      </tr>
	      <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="programa" value="<?PHP   echo $_GET['programa'] ?>"><br>
               <input type="hidden" name="registro" value="<?PHP   echo $_GET['registro'] ?>">
              <input type="hidden" name="edicion" value="1">
              <input type="hidden" name="action" value="registro_info_servicio">
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
else
{
	
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_info_servicio" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="2">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" >Registro de informaci&oacute;n del servicio:</td>
            </tr>
            <tr class="mensajealertaencabezado">
              <td class="celdatabla" colspan="2">
		El servicio beneficia:<br>
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
            <tr class="mensajealertaencabezado">
		<td colspan="2" rowspan="1" class="celdatabla">
			En los a&ntilde;os:
		</td>
      	    </tr>
      	    <tr class="bloquecentralcuerpo">
        	<td colspan="2" rowspan="1" class="celdatabla">
		<table style="text-align: left; width: 100%;" border="0" cellpadding="5" cellspacing="0">
		<tbody>
			<?PHP  
		$fila=0;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($fila==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			
			
			echo '<td class="celdatabla">';
			echo "<input name='servicio_".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
			echo '</td>';
			$fila++;
			if($fila==4)
			{
				echo "</tr>\n";
				$fila=0;
			}
			
		}?>
		</tbody>
		</table>
	    </tr>		
	     <tr>
              <td colspan="2" rowspan="1">
              <input type="hidden" name="action" value="registro_info_servicio"><br>
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
