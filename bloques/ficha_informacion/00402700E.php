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
		$cadena_sql.=$configuracion["prefijo"]."grupo_investigacion.id_grupo, ";
		$cadena_sql.=$configuracion["prefijo"]."grupo_investigacion.nombre, ";
		$cadena_sql.=$configuracion["prefijo"]."estado_grupo.anno, ";
		$cadena_sql.=$configuracion["prefijo"]."grupo_investigacion.director, ";
		$cadena_sql.=$configuracion["prefijo"]."estado_grupo.estado ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."grupo_investigacion, ";
		$cadena_sql.=$configuracion["prefijo"]."estado_grupo ";
		$cadena_sql.="WHERE ";
		$cadena_sql.=$configuracion["prefijo"]."grupo_investigacion.id_programa=".$this->id_programa." ";
		$cadena_sql.="AND ";
		$cadena_sql.=$configuracion["prefijo"]."grupo_investigacion.id_grupo=".$configuracion["prefijo"]."estado_grupo.id_grupo ";
		$cadena_sql.="ORDER BY ";
		$cadena_sql.=$configuracion["prefijo"]."estado_grupo.anno,".$configuracion["prefijo"]."grupo_investigacion.nombre ASC ";
		
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
						<b>Grupos de Investigaci&oacute;n</b><hr>
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
						<b>A&ntilde;o</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>Nombre</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>Director</b>
						</td>						
						<td class="celdapresentacion" align='center'>
						<b>Institucional</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>COLCIENCIAS</b>
						</td>
						<td class="celdapresentacion" align='center'>
						<b>Estado</b>
						</td>
					</tr><?php  
			for($i=0;$i<$conteo_recursos;$i++)
			{
			?>		<tr class="bloquecentralcuerpo" >						
						<td class="celdapresentacion" align='center'>
						<b><?php   echo $registro_recursos[$i][2];?></b>
						</td>						
						<td class="celdapresentacion">
						<?php   echo $registro_recursos[$i][1];?>
						</td>
						<td class="celdapresentacion">
						<?php   echo $registro_recursos[$i][3];?>
						</td><?php   
							$cadena_sql="SELECT ";
							$cadena_sql.="`id_grupo`, ";
							$cadena_sql.="`entidad`, ";
							$cadena_sql.="`anno` ";
							$cadena_sql.="FROM ";
							$cadena_sql.=$configuracion["prefijo"]."reconocimiento_grupo "; 
							$cadena_sql.="WHERE ";
							$cadena_sql.="id_grupo=".$registro_recursos[$i][0]." ";
							$cadena_sql.="AND ";
							$cadena_sql.="anno=".$registro_recursos[$i][2]." ";
								
							//echo $cadena_sql."<br>";	
							$acceso_db->registro_db($cadena_sql,0);

							$registro_reconocimiento=$acceso_db->obtener_registro_db();
							$conteo_reconocimiento=$acceso_db->obtener_conteo_db();
							unset($cadena_institucional);
							unset($cadena_colciencias);
							if($conteo_reconocimiento>0)
							{
								for($j=0;$j<$conteo_reconocimiento;$j++)
								{
									if($registro_reconocimiento[$j][1]=="institucional")
									{
										$cadena_institucional="<td class='celdapresentacion'>\n";
										$cadena_institucional.="Si\n";
										$cadena_institucional.="</td>\n";
									}
									else
									{
										if($registro_reconocimiento[$j][1]=="colciencias")
										{
											$cadena_colciencias="<td class='celdapresentacion'>\n";
											$cadena_colciencias.="Si\n";
											$cadena_colciencias.="</td>\n";
										
										}
									}
								
								}
							}
							if(!isset($cadena_institucional))
							{
								$cadena_institucional="<td class='celdapresentacion'>\n";
								$cadena_institucional.="No\n";
								$cadena_institucional.="</td>\n";
							}
							
							if(!isset($cadena_colciencias))
							{
								$cadena_colciencias="<td class='celdapresentacion'>\n";
								$cadena_colciencias.="No\n";
								$cadena_colciencias.="</td>\n";
							}
							echo $cadena_institucional.$cadena_colciencias;
					?>	<td class="celdapresentacion" >
						<?php   
							if($registro_recursos[$i][4]==0)
							{
								echo "Inactivo";
							}
							else
							{
								echo "Activo";
							}?>
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
			<b>Grupos de Investigaci&oacute;n</b><hr>
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
