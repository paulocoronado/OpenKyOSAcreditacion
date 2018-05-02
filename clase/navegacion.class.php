<?php
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/****************************************************************************
  
html.class.php 
 
Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

******************************************************************************
* @subpackage   
* @package	clase
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* @description  Clase para el manejo de elementos HTML (XML)
*******************************************************************************
*Atributos
*
*@access private
*@param  $conexion_id
*		Identificador del enlace a la base de datos 
*********************************************************************************
*/

/*********************************************************************************
*Métodos
*
*@access public
*
**********************************************************************************/

class navegacion
{

	function navegacion()
	{
		
		
	}
	
	function menu_navegacion($configuracion,$hoja=1,$hojas,$pagina="")
	{
		$variable="index.php?";
		$variable.="page=".$pagina;
		reset ($_REQUEST);
		while (list ($clave, $val) = each ($_REQUEST)) 
		{
			
			if($clave!='page' && $clave!='hoja')
			{
				$variable.="&".$clave."=".$val;
				//echo $clave;
			}
		}	
		
		
	?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
	<table width="90%" align="center" border="0" cellpadding="10" cellspacing="0" >
		<tbody>
			<tr>
				<td >
					<table width="100%" align="center" cellpadding="2" cellspacing="2" class="bloquelateral2">
					<tr class="bloquecentralcuerpo">
						<td align="left"  width="33%">
						<?php
							if($hoja>1)
							{
					?>		<a title="Pasar a la p&aacute;gina No <?php echo $hoja-1 ?>" href="
					<?php			if(isset($_REQUEST["hoja"]))
								{
									echo $variable."&hoja=".($_REQUEST["hoja"]-1);
									
								}
								else
								{
									echo $variable."&hoja=".($hoja-1);
								}
									
							?>"><< Anterior</a>
						<?php	} 
						?>
						</td>
						<td align="center" class="celdatabla"><?php
							if($hojas>1)
							{
								$formulario="menu_navegar";
								$verificar="verificar_numero(document.forms['".$formulario."'],'ir_hoja')";
								$verificar.="&& verificar_rango(document.forms['".$formulario."'],'ir_hoja',1,".$hojas.")";
								?><form method="GET" name="<?php echo $formulario ?>"><?php
								$variables="";
								//Envia todos los datos que vienen con GET
								reset ($_REQUEST);
								
								while (list ($clave, $val) = each ($_REQUEST)) 
								{
									
									if($clave!='hoja' && $clave!='aceptar')
									{
										$variables.="<input type='hidden' name='".$clave."' value='".$val."'>\n";
										//echo $clave;
									}
								}
								echo $variables;
								$texto_ayuda="<b>Desplazarse entre p&aacute;ginas de resultados</b><br>Ingrese el n&uacute;mero de la p&aacute;gina a la que desea ir y presione la tecla ENTER.<br>Existe un total de <b>".$hojas."</b> p&aacute;gina(s).";
								echo "Hoja  <input class='celdanavegacion' type='text' name='ir_hoja' size='2' maxlength='6' value='".$_REQUEST["hoja"]."' onmouseover='return escape(\"".$texto_ayuda."\")' onkeypress=\"if ((event.which == 13) || (event.keyCode == 13) || (event.which == 10) || (event.keyCode == 10)){return(".$verificar.")?document.forms['".$formulario."'].submit():false}\"> de ".($hojas)."\n";	
								
							?></form><?php
							}
							else
							{
								echo "Hoja  ".$_REQUEST["hoja"]." de ".($hojas)."\n";	
							}
					?>	</td>
						<td align="right" width="33%">
						<?php
							if($_REQUEST["hoja"]<$hojas)
							{
						?>
						<a title="Pasar a la p&aacute;gina No <?php echo $_REQUEST["hoja"]+1 ?>" href="<?php
								
								if(isset($_REQUEST["hoja"]))
								{
									echo $variable."&hoja=".($_REQUEST["hoja"]+1);
									
								}
								else
								{
									echo $variable."&hoja=".($hoja+1);
								}
					
					?>">Siguiente>></a>
					<?php
							}
					?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table><?php
	}
	
	
	function menu_hojas()
	{
	
	
	}

	
}//Fin de la clase
	
?>
