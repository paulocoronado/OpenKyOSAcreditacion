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
	
	if(isset($ficha_informacion) && isset($id_programa))
	{
		
		//Datos del programa
		$cadena_sql="SELECT ";
		$cadena_sql.="nombre ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."programa ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_programa=".$id_programa." ";
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
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.id_programa, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.anno, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.periodo, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.identificacion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.docencia, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.investigacion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.proyeccion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.administrativa, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nombre, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.apellido ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor ";
		$cadena_sql.="WHERE ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.id_programa=".$id_programa." ";
		$cadena_sql.="AND ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.investigacion>0 ";
		$cadena_sql.="AND ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.identificacion=".$configuracion["prefijo"]."profesor.identificacion"." ";
		$cadena_sql.="ORDER BY ";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.anno,";
		$cadena_sql.=$configuracion["prefijo"]."profesor_info_dedicacion.periodo,";
		$cadena_sql.=$configuracion["prefijo"]."profesor.apellido,";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nombre ";
		$cadena_sql.="ASC ";
		
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);

		$registro_recursos=$acceso_db->obtener_registro_db();
		$conteo_recursos=$acceso_db->obtener_conteo_db();
	
		if($conteo_recursos>0)
		{
		
?><table class="bloquelateral" width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">					
	<tr class="bloquecentralcuerpo">
		<td><?php//Mostrar los resultados?>
			<table align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>
				<tbody>
					<tr>
						<td align='center'>
						<b>Profesores del programa que desarrolla investigaci&oacute;n y tiempo que los profesores dedican a la investigaci&oacute;n.</b><hr>						
						</td>
					</tr>	
					<tr>
						<td class="bloquecentralcuerpo">
						Programa Acad&eacute;mico: <b><?php echo $mi_programa; ?></b>
						</td>
					</tr>	
				</tbody>
			</table>
			<br><?php
			
			$cadena_encabezado="<tr class='bloquecentralcuerpo'>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>A&ntilde;o</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>Periodo</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>Identificaci&oacute;n</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>Nombre</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>Horas semanales<br>de dedicaci&oacute;n</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="</tr>\n";
			
			$cadena_investigacion="<table class='tablarespuesta' align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>\n";
			$cadena_investigacion.="<tbody>\n";
			$cadena_investigacion.="<tr class='bloquecentralcuerpo' >\n";
			$cadena_investigacion.="<td class='celdapresentacion' align='center' colspan='5'>\n";
			$cadena_investigacion.="<b>Enmarcado dentro de las funciones de Investigaci&oacute;n</b>\n";
			$cadena_investigacion.="</td>\n";
			$cadena_investigacion.="</tr>\n";
			$cadena_investigacion.=$cadena_encabezado;
			
			for($i=0;$i<$conteo_recursos;$i++)
			{
				$cadena_registro="<tr class='bloquecentralcuerpo'>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				$cadena_registro.=$registro_recursos[$i][1];
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				$cadena_registro.=$registro_recursos[$i][2];
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				$cadena_registro.=$registro_recursos[$i][3];
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion'>\n";
				$cadena_registro.=$registro_recursos[$i][8]." ".$registro_recursos[$i][9];
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				$cadena_investigacion.=$cadena_registro;
				$cadena_investigacion.=$registro_recursos[$i][5];
				$cadena_registro="</td>\n";
				$cadena_registro.="</tr>\n";
				$cadena_investigacion.=$cadena_registro;
				
			}
				
			echo $cadena_investigacion;
			echo "<br>\n";
						
			?></tbody>
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
			<b>Profesores del programa que desarrolla investigaci&oacute;n y tiempo que los profesores dedican a la investigaci&oacute;n.</b><hr>						
			</td>
		</tr>	
		<tr>
			<td class="bloquecentralcuerpo">
			Programa Acad&eacute;mico: <b><?php echo $mi_programa; ?></b>
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
