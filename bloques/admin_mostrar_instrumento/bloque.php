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
  
index.php 

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
* @description  Formualrio para el registro de usuarios
* @usage        
*****************************************************************************************************************/ 
?><?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mostrar_pregunta.class.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
		/*Rescatar el id_proceso*/
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$proceso=$_GET["proceso"];
		$usuario=$_GET["usuario"];
		$artefacto=$_GET["artefacto"];
		
		$cadena_sql="SELECT ";
		$cadena_sql.="".$configuracion["prefijo"]."a_instrumento.id_instrumento, ";
		$cadena_sql.="".$configuracion["prefijo"]."a_instrumento.orden, ";
		$cadena_sql.="".$configuracion["prefijo"]."instrumento.etiqueta ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."a_instrumento,".$configuracion["prefijo"]."instrumento ";
		$cadena_sql.=" WHERE ".$configuracion["prefijo"]."a_instrumento.id_artefacto=".$artefacto;
		$cadena_sql.=" AND ".$configuracion["prefijo"]."a_instrumento.id_instrumento=".$configuracion["prefijo"]."instrumento.id_instrumento ";
		$cadena_sql.=" GROUP BY ".$configuracion["prefijo"]."a_instrumento.id_instrumento ORDER BY ".$configuracion["prefijo"]."a_instrumento.orden";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$conteo=$acceso_db->obtener_conteo_db();
		if($conteo>0)
		{	
			
			
			for($contador_instrumento=0;$contador_instrumento<$conteo;$contador_instrumento++)
			{
				$instrumento=$registro[$contador_instrumento][0];
				
				$cadena_sql="SELECT ";
				$cadena_sql.="encuestado ";
				$cadena_sql.=" FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."resultado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="encuestado='".$usuario."' LIMIT 1";
			
				$acceso_db->registro_db($cadena_sql,0);
				$registro_usuario=$acceso_db->obtener_registro_db();
				$conteo_usuario=$acceso_db->obtener_conteo_db();
			
				unset($registro_usuario);	
			
				$cadena_sql="SELECT ";
				$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta,";
				$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.orden,";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.tipo";
				$cadena_sql.=" FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."i_pregunta,".$configuracion["prefijo"]."pregunta ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_instrumento=".$instrumento;
				$cadena_sql.=" AND ";
				$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta=".$configuracion["prefijo"]."pregunta.id_pregunta";
				$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."i_pregunta.orden ASC";
			
				$acceso_db->registro_db($cadena_sql,0);
		
				$registro_instrumento=$acceso_db->obtener_registro_db();
				$conteo_encabezado=$acceso_db->obtener_conteo_db();
			
				if($conteo_encabezado>0)
				{	
					
					$cadena_html="";
					
					if($conteo_usuario==0)
					{
						$esta_pregunta=new mostrar_pregunta();
					
					}
					else
					{
						$otra_pregunta=new mostrar_pregunta();
					
					}
					for($contador=0;$contador<$conteo_encabezado;$contador++)
					{
						
						if($registro_instrumento[$contador][2]==0)
						{
							/* El código corresponde a una pregunta primitiva ("0")*/
							if($conteo_usuario==0)
							{
								$cadena_html=$esta_pregunta->numero_pregunta(($contador+1),$configuracion);
								$cadena_html.=$esta_pregunta->primitiva($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto);
							}
							else
							{
								
								$cadena_html=$otra_pregunta->numero_pregunta(($contador+1),$configuracion);
								$cadena_html.=$otra_pregunta->primitiva($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$usuario,$artefacto);
								
							}
						}
						else
						{
							
							/* El código corresponde a una pregunta compuesta ("1")*/
							if($registro_instrumento[$contador][2]==1)
							{
								if($conteo_usuario==0)
								{
									$cadena_html=$esta_pregunta->numero_pregunta(($contador+1));
									$cadena_html.=$esta_pregunta->compuesta($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$artefacto);
								}
								else
								{
									/*TODO Para cuando ya está contestado el formulario*/
									$cadena_html=$otra_pregunta->numero_pregunta(($contador+1));
									$cadena_html.=$otra_pregunta->compuesta($configuracion,$registro_instrumento[$contador][0],$proceso,"0",$instrumento,$usuario,$artefacto);
									
								}
							}
							
						}
		
						echo $cadena_html;
						if($conteo_usuario==0)
						{
							$esta_pregunta->armar_pregunta();
						}
						else
						{
							$otra_pregunta->mostrar_pregunta();
						}
		
					
					}
				unset($cadena_html);
				}
			}
		}
}

?>
