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
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/armar_pregunta_llena.class.php");
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
		$cadena_sql="SELECT ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.id_programa, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.identificacion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.anno, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.nombre, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.ponencia, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.lugar, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.ambito, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nombre, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.apellido ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor ";
		$cadena_sql.="WHERE ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.id_programa=".$this->id_programa." ";
		$cadena_sql.="AND ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.identificacion=".$configuracion["prefijo"]."profesor.identificacion ";
		$cadena_sql.="ORDER BY ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_evento.anno,".$configuracion["prefijo"]."profesor.apellido ASC ";
		
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);

		$registro_recursos=$acceso_db->obtener_registro_db();
		$conteo_recursos=$acceso_db->obtener_conteo_db();
	
		if($conteo_recursos>0)
		{
		
		
		
?><table class="bloquelateral" width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">					
	<tr class="bloquecentralcuerpo">
		<td><?php  //Mostrar los resultados?>
			<table align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>
				<tbody>
					<tr>
						<td align='center'>
						<b>Profesores del programa que han participado como expositor en congresos, seminarios, simposios y talleres nacionales e internacionales de car&aacute;cter acad&eacute;mico.</b><hr>						
						</td>
					</tr>	
					<tr>
						<td class="bloquecentralcuerpo">
						Programa Acad&eacute;mico: <b><?php   echo $mi_programa; ?></b>
						</td>
					</tr>	
				</tbody>
			</table>
			<br>
			<table class='tablarespuesta' align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>
				<tbody>
					<tr class="bloquecentralcuerpo" >
						<td class="celdapresentacion" align='center'>
						<b>Profesor</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>A&ntilde;o</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>Nombre del evento</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>Ponencia</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>Lugar</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>Ambito</b>
						</td>
					</tr><?php  
			for($i=0;$i<$conteo_recursos;$i++)
			{
			?>		<tr class="bloquecentralcuerpo" >
						<td class="celdapresentacion">
						<b><?php   echo $registro_recursos[$i][7]." ".$registro_recursos[$i][8];?></b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b><?php   echo $registro_recursos[$i][2];?></b>
						</td>
						<td class="celdapresentacion" >
						<b><?php   echo $registro_recursos[$i][3];?></b>
						</td>
						<td class="celdapresentacion">
						<b><?php   echo $registro_recursos[$i][4];?></b>
						</td>
						<td class="celdapresentacion">
						<b><?php   echo $registro_recursos[$i][5];?></b>
						</td>
						<td class="celdapresentacion">
						<b><?php   
						if($registro_recursos[$i][6]==0)
						{
							echo "Nacional";
						}
						else
						{
							echo "Internacional";
						}
						?></b>
						</td>
					</tr><?php  
			}	
			?>	</tbody>
			</table>			
		</td>
	</tr>
</table><?php  
		}
		else
		{
?><table align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>
	<tbody>
		<tr>
			<td align='center'>
			<b>Profesores del programa que han participado como expositor en congresos, seminarios, simposios y talleres nacionales e internacionales de car&aacute;cter acad&eacute;mico.</b><hr>						
			</td>
		</tr>	
		<tr>
			<td class="bloquecentralcuerpo">
			Programa Acad&eacute;mico: <b><?php   echo $mi_programa; ?></b>
			</td>
		</tr>
		<tr align="center">
			<td class="bloquecentralcuerpo">
			<b>No se ha ingresado informaci&oacute;n.</b>
			</td>
		</tr>	
	</tbody>
</table>
		<?php  	
			
		}
	}
}

?>
