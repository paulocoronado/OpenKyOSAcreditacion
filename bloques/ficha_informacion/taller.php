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
?><?php  
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
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	if(isset($this->ficha_informacion) && isset($this->id_programa))
	{
		
		//Datos del programa
		$cadena_sql="SELECT ";
		$cadena_sql.="nombre ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."programa ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_programa=".$this->id_programa." ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);

		$registro_programa=$acceso_db->obtener_registro_db();
		$conteo_programa=$acceso_db->obtener_conteo_db();
	
		if($conteo_programa>0)
		{	
		
			$mi_programa=$registro_programa[0][0];
			unset($registro_programa);
		}
		else
		{
			echo "Se&ntilde;or Analista. Por favor solicite al administrador del Sistema que sea asociado a un programa acad&eacute;mico.";
			
		}		
?><table class="bloquelateral" width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">					
	<tr class="bloquecentralcuerpo">
		<td><?php  //Mostrar los resultados?>
			<table align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>
				<tbody>
					<tr>
						<td align='center'>
						<b>Informaci&oacute;n disponible en Talleres</b><hr>						
						</td>
					</tr>	
					<tr>
						<td class="bloquecentralcuerpo">
						Programa Acad&eacute;mico: <b><?php   echo $mi_programa; ?></b>
						</td>
					</tr>
					<tr>
						<td>
							<table cellpadding="10" cellspacing="0" align="center">
								<tbody>
								<tr class="bloquecentralcuerpo">
									<td valign="middle" align="right" width="10%">
									<img src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
									</td>
									<td align="left">
									<b>Se&ntilde;or Analista:</b><br>Por favor consulte la secci&oacute;n de <b>Instrumentos</b> para ver<br>informaci&oacute;n correspondiente a este componente</b>
									</td>
								</tr>									
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<br>
		</td>
	</tr>
</table><?php  
	}	
}

?>
