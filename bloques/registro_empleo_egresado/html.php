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
if(isset($_GET['id_empleo']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT `id_empleo` , `identificacion` , `id_programa` , `empleo` , `ocupacion` , `ubicacion`, `anno`";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."egresado_empleo` ";
		$cadena_sql.="WHERE id_empleo=".$_GET['id_empleo']." LIMIT 1";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n de empleo y ocupaci&oacute;n
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Ocupaci&oacute;n principal:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="30" name="ocupacion" value="<?php   echo $registro[0][4] ?>">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Ubicaci&oacute;n Profesional:
	</td>
        <td class="celdatabla">
        	<input maxlength="255" size="30" name="ubicacion" value="<?php   echo $registro[0][5] ?>">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		Empleado durante los meses de:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
      	<td colspan="2" rowspan="1">
      	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
        	<tbody>
          	<tr class="bloquecentralcuerpo">
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],0,1)=="1")
						   {?>
						<input name="1" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="1" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Enero</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],1,1)=="1")
						   {?>
						<input name="2" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="2" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Febrero</td>
				</tr>
			</tbody>
			</table>
            		</td>
                        <td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],2,1)=="1")
						   {?>
						<input name="3" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="3" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Marzo</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],3,1)=="1")
						   {?>
						<input name="4" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="4" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Abril</td>
				</tr>
			</tbody>
			</table>
            		</td>
          </tr>
          <tr class="bloquecentralcuerpo">
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],4,1)=="1")
						   {?>
						<input name="5" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="5" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Mayo</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],5,1)=="1")
						   {?>
						<input name="6" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="6" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Junio</td>
				</tr>
			</tbody>
			</table>
            		</td>
                        <td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],6,1)=="1")
						   {?>
						<input name="7" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="7" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Julio</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],7,1)=="1")
						   {?>
						<input name="8" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="8" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Agosto</td>
				</tr>
			</tbody>
			</table>
            		</td>
          </tr>
          <tr class="bloquecentralcuerpo">
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],8,1)=="1")
						   {?>
						<input name="9" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="9" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Septiembre</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],9,1)=="1")
						   {?>
						<input name="10" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="10" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Octubre</td>
				</tr>
			</tbody>
			</table>
            		</td>
                        <td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],10,1)=="1")
						   {?>
						<input name="11" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="11" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Noviembre</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<?php   if(substr($registro[0][3],11,1)=="1")
						   {?>
						<input name="12" value="1" type="checkbox" checked="TRUE">
						<?php   }
						   else
						   {?>
						<input name="12" value="1" type="checkbox">
						<?php   }?>	
					</td>
					<td style="width: 334px;">Diciembre</td>
				</tr>
			</tbody>
			</table>
            		</td>
          </tr>
        </tbody>
      </table>
      	</td>
      </td>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Del A&ntilde;o:
	</td>
        <td class="celdatabla"><?php  
		
			echo $registro[0][6]."\n";
			
			?>
        </td>
      </tr>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_empleo_egresado">
		<input type="hidden" name="anno_edicion" value="<?php   echo $registro[0][6] ?>">
		<input type="hidden" name="identificacion" value="<?php   echo $_GET["registro"]?>">
		<input type="hidden" name="usuario" value="<?php   echo $_GET["usuario"]?>">
		<input type="hidden" name="id_empleo" value="<?php   echo $_GET["id_empleo"]?>">
		<input name="aceptar" value="Aceptar" type="submit"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?php  		}
	}
}

else
{ // Si es un registro nuevo
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_anual" onsubmit="return ( control_vacio(this,'ocupacion') && control_vacio(this,'ubicacion') ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n de empleo y ocupaci&oacute;n
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Ocupaci&oacute;n principal:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="30" name="ocupacion">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Ubicaci&oacute;n Profesional:
	</td>
        <td class="celdatabla">
        	<input maxlength="255" size="30" name="ubicacion">
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		Empleado durante los meses de:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
      	<td colspan="2" rowspan="1">
      	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
        	<tbody>
          	<tr class="bloquecentralcuerpo">
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="1" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Enero</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="2" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Febrero</td>
				</tr>
			</tbody>
			</table>
            		</td>
                        <td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="3" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Marzo</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="4" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Abril</td>
				</tr>
			</tbody>
			</table>
            		</td>
          </tr>
          <tr class="bloquecentralcuerpo">
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="5" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Mayo</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="6" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Junio</td>
				</tr>
			</tbody>
			</table>
            		</td>
                        <td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="7" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Julio</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="8" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Agosto</td>
				</tr>
			</tbody>
			</table>
            		</td>
          </tr>
          <tr class="bloquecentralcuerpo">
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="9" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Septiembre</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="10" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Octubre</td>
				</tr>
			</tbody>
			</table>
            		</td>
                        <td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="11" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Noviembre</td>
				</tr>
			</tbody>
			</table>
            		</td>
            		<td>
            		<table style="text-align: left; width: 100%;" border="0" cellpadding="2"  cellspacing="2">
						<tbody>
				<tr class="bloquecentralcuerpo">
					<td style="width: 23px;">
						<input name="12" value="1" type="checkbox">
					</td>
					<td style="width: 334px;">Diciembre</td>
				</tr>
			</tbody>
			</table>
            		</td>
          </tr>
        </tbody>
      </table>
      	</td>
      </td>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Del A&ntilde;o:
	</td>
        <td class="celdatabla"><?php  
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
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_empleo_egresado">
		<input type="hidden" name="identificacion" value="<?php   echo $_GET["registro"]?>">
		<input type="hidden" name="usuario" value="<?php   echo $_GET["usuario"]?>">
		<input name="aceptar" value="Aceptar" type="submit"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?php  
	}

?>
