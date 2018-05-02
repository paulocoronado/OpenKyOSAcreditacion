<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2007

Última revisión 19 de junio de 2007

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************/

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
		$cadena_sql.="nombre, ";
		$cadena_sql.="objetivo, ";
		$cadena_sql.="estado, ";
		$cadena_sql.="funcion, ";
		$cadena_sql.="anno, ";
		$cadena_sql.="tipo ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."dir_proyecto ";
		$cadena_sql.="WHERE ";
		$cadena_sql.=$configuracion["prefijo"]."dir_proyecto.id_programa=".$id_programa." ";
		$cadena_sql.="AND ";
		$cadena_sql.=$configuracion["prefijo"]."dir_proyecto.social=1 ";
		$cadena_sql.="ORDER BY ";
		$cadena_sql.=$configuracion["prefijo"]."dir_proyecto.anno,".$configuracion["prefijo"]."dir_proyecto.nombre ASC ";
		
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
						<b>Proyectos de Caracter Social que ha adelantado el programa</b><hr>						
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
			$cadena_encabezado.="<b>Proyecto</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>Objetivo</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>Estado</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>a&ntilde;o<br>formulaci&oacute;n</b>\n";
			$cadena_encabezado.="</td>\n";
			$cadena_encabezado.="<td class='celdapresentacion' align='center'>\n";
			$cadena_encabezado.="<b>Tipo</b>\n";
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
			
			$cadena_docencia="<table class='tablarespuesta' align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>\n";
			$cadena_docencia.="<tbody>\n";
			$cadena_docencia.="<tr class='bloquecentralcuerpo' >\n";
			$cadena_docencia.="<td class='celdapresentacion' align='center' colspan='5'>\n";
			$cadena_docencia.="<b>Enmarcado dentro de las funciones de Docencia</b>\n";
			$cadena_docencia.="</td>\n";
			$cadena_docencia.="</tr>\n";
			$cadena_docencia.=$cadena_encabezado;
			
			$cadena_extension="<table class='tablarespuesta' align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>\n";
			$cadena_extension.="<tbody>\n";
			$cadena_extension.="<tr class='bloquecentralcuerpo' >\n";
			$cadena_extension.="<td class='celdapresentacion' align='center' colspan='5'>\n";
			$cadena_extension.="<b>Enmarcado dentro de las funciones de Proyecci&oacute;n Social</b>\n";
			$cadena_extension.="</td>\n";
			$cadena_extension.="</tr>\n";
			$cadena_extension.=$cadena_encabezado;
			
			
			for($i=0;$i<$conteo_recursos;$i++)
			{
				$cadena_registro="<tr class='bloquecentralcuerpo'>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				$cadena_registro.=$registro_recursos[$i][0];
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				$cadena_registro.=$registro_recursos[$i][1];
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				switch($registro_recursos[$i][2])
				{
					case 0:
					$cadena_registro.="Formulado";
					break;
					
					case 1:
					$cadena_registro.="En desarrollo";
					break;
					
					case 2:
					$cadena_registro.="Terminado";
					break;
					
					default:
					$cadena_registro.="No determinado";
					break;
				}
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				$cadena_registro.=$registro_recursos[$i][4];
				$cadena_registro.="</td>\n";
				$cadena_registro.="<td class='celdapresentacion' align='center'>\n";
				switch($registro_recursos[$i][5])
				{
					case 0:
					$cadena_registro.="Proyecto";
					break;
					
					case 1:
					$cadena_registro.="Estudio";
					break;
					
					
					default:
					$cadena_registro.="No determinado";
					break;
				}
				$cadena_registro.="</td>\n";
				$cadena_registro.="</tr>\n";
				
				if(($registro_recursos[$i][3] & "001")!=0)
				{
					$cadena_extension.=$cadena_registro;
				}
				
				if(($registro_recursos[$i][3] & "010")!=0)
				{
					$cadena_docencia.=$cadena_registro;
				
				}
				
				if(($registro_recursos[$i][3] & "100")!=0)
				{
					$cadena_investigacion.=$cadena_registro;
				}
			
			
			}
				
			echo $cadena_investigacion;
			echo "<br>\n";
			echo $cadena_docencia;
			echo "<br>\n";
			echo $cadena_extension;
			echo "<br>\n";
			
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
			<b>Proyectos de Caracter Social que ha adelantado el programa</b><hr>						
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
