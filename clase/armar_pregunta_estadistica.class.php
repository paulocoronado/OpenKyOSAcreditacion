<?PHP  
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?PHP  
/****************************************************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 27 de noviembre de 2005

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
/* Las preguntas tienen un codigo de 30 caracteres en donde:

$codigo=PPPPPPAAAAAAFFFFFFpppppppiiooo

$id_proceso=substr ( $codigo, 0,6) 
$id_artefacto=substr ( $codigo, 5,6)
$id_formulario=substr ( $codigo, 11,6)
$id_pregunta=substr ( $codigo, 17,7) 
$id_instancia=substr ( $codigo, 24,3)
$id_opcion=substr ( $codigo, 27,2)


*/
class armar_pregunta_estadistica{
	
function armar_pregunta_estadistica()
{
	$this->cadena_pregunta="";
	$this->cadena_resultado="";
	$this->cadena_encabezado="";
	$this->cadena_informacion="";
}

	/**
	 *@method compuesta 
	 * @param array configuracion
	 * @param int  id_instrumento
	 * @return string cadena_sql
	 * @access public
	 */    
	
function rellenar_cadena($cadena,$tamanno)
{
	
	$tamanno_cadena=strlen($cadena);
	
	for($a=$tamanno_cadena;$a<$tamanno;$a++)
	{
		
		$cadena="0".$cadena;
	}
	
	return $cadena;
}


function compuesta($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$artefacto)
{
	$this->pregunta=$this->rellenar_cadena($id_pregunta,7);
	$this->instancia=$this->rellenar_cadena($instancia,2);
	$this->id_proceso=$this->rellenar_cadena($id_proceso,6);
	$this->instrumento=$this->rellenar_cadena($instrumento,6);
	$this->artefacto=$this->rellenar_cadena($artefacto,6);
	
	$this->cadena_total="";
	
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{	
		//Inicializar el contador de respuestas, se debe mostrar el mayor valor obtenido de 
		//respuestas de cada pregunta asociada
		
		$this->conteo_total=0;
		
		
		/*Determinar los componentes*/
		
		
		
		$this->cadena_sql="SELECT id_hijo, ";
		$this->cadena_sql.="orden ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.=$configuracion["prefijo"]."p_compuesta ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_padre=";
		$this->cadena_sql.=$this->pregunta." ";
		$this->cadena_sql.=" ORDER BY orden ASC";
		
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro=$this->acceso_db->obtener_registro_db();
		$this->campos_c=$this->acceso_db->obtener_conteo_db();
		/*echo $this->cadena_sql."<br>";
		echo $this->campos_c."<br>";*/
		if($this->campos_c==0)
		{
			
				/*TO DO mensaje de error */
			
		}
		else
		{
			
			for($this->contador=0;$this->contador<$this->campos_c;$this->contador++)
			{
				/*BUSCA LOS DATOS BÁSICOS DE LAS PREGUNTAS QUE COMPONEN*/
				$this->registro_2=$this->buscar_pregunta($configuracion,$this->registro[$this->contador][0]);		
				
				
				/*Selección de acuerdo al tipo de pregunta*/
				switch($this->registro_2[0][5])
				{
					case 0:
							
							/*Esto supone un fallo pues una pregunta compuesta no tiene primitivas*/
							
							break;
							
					case 1:
							/*Esto supone un fallo pues una pregunta compuesta no tiene preguntas compuestas*/
							break;
					
					
					case 2:
							/* PREGUNTA ASOCIADA Llama a primitiva pues es lo mismo*/
							$this->codigo=$this->rellenar_cadena($this->registro_2[0][0],7);
							$this->cadena_resultado="";
							$this->cadena_total.=$this->asociada($configuracion,$this->codigo,$this->id_proceso,$this->instancia,$this->instrumento,$this->artefacto);
							
							
							break;
					
					case 3:
							/*Pregunta ABSTRACTA
							Busca para ver si la pegunta tiene un encabezado*/
							$this->la_cadena=new cadenas;
							$this->cadena_sql="SELECT ";
							$this->cadena_sql.="valor ";
							$this->cadena_sql.="FROM ";
							$this->cadena_sql.=$configuracion["prefijo"]."p_propiedad ";
							$this->cadena_sql.="WHERE ";
							$this->cadena_sql.="id_pregunta=".$this->registro_2[0][0]." ";
							$this->cadena_sql.="AND ";
							$this->cadena_sql.="propiedad='encabezado' ";
							$this->cadena_sql.="LIMIT 1";
							//echo $this->cadena_sql;
							$this->acceso_db->registro_db($this->cadena_sql,0);
							$this->registro_encabezado=$this->acceso_db->obtener_registro_db();
							$this->conteo_encabezado=$this->acceso_db->obtener_conteo_db();
							if($this->conteo_encabezado>0)
							{
								$this->cadena_pregunta.="<table align ='center' style='width: 100%; text-align: left;' border='0'";
								$this->cadena_pregunta.="cellpadding='5'cellspacing='1'>\n<tbody>\n";
								$this->encabezado=$this->la_cadena->unhtmlentities($this->registro_encabezado[0][0]);
								$this->cadena_pregunta.="<tr class='encabezadopregunta'>\n";
								$this->cadena_pregunta.="<td>\n";
								$this->cadena_pregunta.=ucfirst (strtolower ($this->encabezado));
								$this->cadena_pregunta.="</td>\n";
								$this->cadena_pregunta.="</tr>\n";
								$this->cadena_pregunta.="</tbody>\n</table>\n";
							}
							//echo $this->cadena_pregunta;
							//Adicionar el resultado a la cadena total
							$this->cadena_total.=$this->cadena_pregunta;
							break;
					
					default:
				
						break;
				
								
					
				}
					
					
			
			}
			
			
			return $this->cadena_total;	
		}
	}
}/*Fin del metodo compuesta*/



	/**
	 *@method primitiva 
	 * @param array configuracion
	 * @param int  id_instrumento
	 * @return string cadena_sql
	 * @access public
	 */    

function primitiva($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$artefacto)
{
	
	$this->pregunta=$id_pregunta;
	$this->instancia=$instancia;
	$this->id_proceso=$id_proceso;
	$this->artefacto=$artefacto;
	$this->instrumento=$instrumento;
	$this->opcion=0;
	
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{
		
		//Cuantas personas han constestado la pregunta?
		$this->cadena_sql="SELECT valor ";
		$this->cadena_sql.="FROM ".$configuracion["prefijo"]."resultado ";
		$this->cadena_sql.="WHERE id_proceso=".($this->id_proceso/1)." ";
		$this->cadena_sql.="AND id_artefacto=".(($this->artefacto)/1)." ";
		$this->cadena_sql.="AND id_instrumento=".(($this->instrumento)/1)." ";
		$this->cadena_sql.="AND id_pregunta=".(($this->pregunta)/1)." ";
		$this->cadena_sql.="GROUP BY encuestado";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_total=$this->acceso_db->obtener_registro_db();
		$this->conteo_total=$this->acceso_db->obtener_conteo_db();
		//Mostrar
		$this->cadena_informacion="<table cellspacing='2'>\n";
		$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
		$this->cadena_informacion.="<td>\n";
		$this->cadena_informacion.="Personas que han contestado la pregunta:";
		$this->cadena_informacion.="</td>\n";
		$this->cadena_informacion.="<td align='center'>\n";
		$this->cadena_informacion.="<b>".$this->conteo_total."</b>";
		$this->cadena_informacion.="</td>\n";
		$this->cadena_informacion.="</tr>\n";
		$this->cadena_informacion.="</table>\n";	
		
		/*Determinar los componentes*/
	
		/*Encabezado*/
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="valor ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".(($this->pregunta)/1)." ";
		$this->cadena_sql.="AND propiedad='encabezado' LIMIT 1";
		//echo $this->cadena_sql;			
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_encabezado=$this->acceso_db->obtener_registro_db();
		$this->conteo_encabezado=$this->acceso_db->obtener_conteo_db();
		$this->la_cadena=new cadenas;
		$this->cadena_encabezado="<table class='tablarespuesta' align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>\n";
		$this->cadena_encabezado.="<tbody>\n";
		if($this->conteo_encabezado>0)
		{
			
			$this->encabezado=$this->la_cadena->unhtmlentities($this->registro_encabezado[0][0]);
			/*if($this->encabezado!="")
			{*/

			$this->cadena_encabezado.="<tr class='encabezadopregunta'>\n";
			$this->cadena_encabezado.="<td colspan='3' class='celdapresentacion'>\n";
			$this->cadena_encabezado.=ucfirst (strtolower ($this->encabezado));
			$this->cadena_encabezado.="</td>\n";
			$this->cadena_encabezado.="</tr>\n";
		}
			
	
		/* Determinar el tipo de métrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
		
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="valor ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".(($this->pregunta)/1);
		$this->cadena_sql.=" AND propiedad='id_metrica' LIMIT 1";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_metrica=$this->acceso_db->obtener_registro_db();
		$this->conteo_metrica=$this->acceso_db->obtener_conteo_db();
		if($this->conteo_metrica>0)
		{
			$this->metrica=$this->registro_metrica[0][0];
			$this->codigo_pregunta=$this->id_proceso.$this->artefacto.$this->instrumento.$this->pregunta.$this->instancia;
			switch($this->metrica)
			{
				case 1:
					/*Selección múltiple: 
					El método POST envia la información nombre=<valor; si hay dos controles con el mismo nombre envia el 
					dato del último que ha encontrado. Si el control no está seleccionado no  envia nada.
								*/
						$this->cadena_informacion.="<table cellspacing='2'>\n";
						$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
						$this->cadena_informacion.="<td>\n";
						$this->cadena_informacion.="M&eacute;trica usada:";
						$this->cadena_informacion.="</td>\n";
						$this->cadena_informacion.="<td align='left'>\n";
						$this->cadena_informacion.="Selecci&oacute;n m&uacute;ltiple";
						$this->cadena_informacion.="</td>\n";
						$this->cadena_informacion.="</tr>\n";
						$this->cadena_informacion.="</table>\n";		
						$this->seleccion_multiple($configuracion);
						break;
								
				case 2:
				/*Selección única*/
					$this->cadena_informacion.="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Selecci&oacute;n Unica";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";		
					$this->seleccion_unica($configuracion);
					break;
							
				case 3:
				/*Comentario múltiples campos*/
					$this->cadena_informacion.="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Abierta M&uacute;ltiples campos";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					$this->campos_multiples($configuracion);
					break;

				case 4:
					$this->cadena_informacion.="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Calificaci&acute;n num&eacute;rica";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					/*  Calificación numérica*/
					
					
					break;
					
				case 5:
					$this->cadena_informacion.="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Calificaci&acute;n Porcentual";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					/* Calificación porcentual*/
					
					
					break;
					
				case 6:
					/*Dato numérico*/
					$this->cadena_informacion.="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Dato num&eacute;rico";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					
					break;
					
				case 7:
					/* Comentario de una línea*/
					$this->cadena_informacion.="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Comentario corto";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					
					break;							
				case 8:
					$this->cadena_informacion.="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Comentario Largo";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					/*Comentario de varias líneas*/
					
					break;
					
					
				default:
					
				
				break;
								
						
			}
			$opciones=$configuracion["site"].'/index.php?page='.enlace('ficha_mas_info');
			$opciones.='&opcion=mostrar';
			$opciones.='&proceso='.$this->id_proceso; 
			$opciones.='&artefacto='.$this->artefacto; 
			$opciones.='&instrumento='.$this->instrumento; 
			$opciones.='&pregunta='.$this->pregunta; 
			
			$this->cadena_informacion.="<table cellspacing='2'>\n";
			$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
			$this->cadena_informacion.="<td align='center'>";
			$this->cadena_informacion.="<a href='#' onclick=\"abrir_ventana('".$opciones."','Ficha_resultados')\">";
			$this->cadena_informacion.="Ver m&aacute;s informaci&oacute;n";
			$this->cadena_informacion.="</A>";
			$this->cadena_informacion.="</td>";
			$this->cadena_informacion.="</tr>\n";
			$this->cadena_informacion.="</table>\n";
			
			$this->cadena_pregunta=$this->cadena_informacion.$this->cadena_encabezado.$this->cadena_resultado;
			$this->cadena_pregunta.="</tbody>\n</table>\n";					
			return $this->cadena_pregunta;	
		}
		
	}
}/* Fin del método primitiva*/



function seleccion_multiple($configuracion)
{
	
	$this->cadena_sql="SELECT ";
	$this->cadena_sql.="id_pregunta, ";
	$this->cadena_sql.="etiqueta, ";
	$this->cadena_sql.="valor, ";
	$this->cadena_sql.="orden ";
	$this->cadena_sql.="FROM ";
	$this->cadena_sql.="".$configuracion["prefijo"]."m_multiple ";
	$this->cadena_sql.="WHERE ";
	$this->cadena_sql.="id_pregunta=".$this->pregunta;
	$this->cadena_sql.=" ORDER BY orden ASC";
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_multiple=$this->acceso_db->obtener_registro_db();
	$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
	$this->cadena_resultado="";
	if($this->conteo_multiple>0)
	{
		
		$this->la_cadena=new cadenas;
		for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
		{
			$this->codigo_opcion=$this->contador_m;
			$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
			$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
			
			
			$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),((($this->contador_m)/1)+1),$configuracion,0,(($this->artefacto)/1));
			$this->cadena_resultado.="<tr>\n";
			$this->cadena_resultado.="<td width='80%' class='celdapresentacion'>\n";
			$this->cadena_resultado.=$this->etiqueta;
			$this->cadena_resultado.="</td>";
			$this->cadena_resultado.="<td align='center' class='celdapresentacion'>\n";
			if($this->la_respuesta==FALSE)
			{
			$this->cadena_resultado.="0\n";
			}
			else
			{
				$this->cadena_resultado.=$this->la_respuesta."\n";
			}
			
			$this->cadena_resultado.="</td>\n";
			$this->cadena_resultado.="<td align='center' class='celdapresentacion'>\n";
			if($this->la_respuesta==FALSE)
			{
			$this->cadena_resultado.="0\n";
			}
			else
			{
				$this->cadena_resultado.=round($this->la_respuesta/$this->conteo_total,2)*(100)."%\n";
			}
			
			$this->cadena_resultado.="</td>\n";
			$this->cadena_resultado.="</tr>\n";
		}
					
	}
	return $this->cadena_resultado;
						 
	
	
}


function seleccion_unica($configuracion)
{
		//Buscar los componentes de la pregunta revisando la entidad m_multiple
		$this->cadena_sql="SELECT id_pregunta, ";
		$this->cadena_sql.="etiqueta, valor, ";
		$this->cadena_sql.="orden ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."m_multiple ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->pregunta." ";
		$this->cadena_sql.="ORDER BY orden ASC";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_multiple=$this->acceso_db->obtener_registro_db();
		$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
		$this->cadena_resultado="";
		if($this->conteo_multiple>0)
		{
			
			//Armar la pregunta
			$this->la_cadena=new cadenas;
			for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
			{
				$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
				$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
				
			
				//Buscar la respuesta dada en cada opcion de la pregunta
				$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),($this->contador_m+1),$configuracion,1,(($this->artefacto)/1));
				
				//Mostrar la etiqueta de la opcion y la cantidad de respuestas dadas.
				$this->cadena_resultado.="<tr>\n";
				$this->cadena_resultado.="<td width='80%' class='celdapresentacion'>\n";
				$this->cadena_resultado.=$this->etiqueta;
				$this->cadena_resultado.="</td>";
				$this->cadena_resultado.="<td align='center' class='celdapresentacion'>\n";
				if($this->la_respuesta==FALSE)
				{
				$this->cadena_resultado.="0\n";
				}
				else
				{
					$this->cadena_resultado.=$this->la_respuesta."\n";
				}
				
				$this->cadena_resultado.="</td>\n";
				$this->cadena_resultado.="<td align='center' class='celdapresentacion'>\n";
				if($this->la_respuesta==FALSE)
				{
				$this->cadena_resultado.="0\n";
				}
				else
				{
					$this->cadena_resultado.=round($this->la_respuesta/$this->conteo_total,2)*(100)."%\n";
				}
				
				$this->cadena_resultado.="</td>\n";
				$this->cadena_resultado.="</tr>\n";	
			}
			//Mostrar totales:
			
		   		
		}

	return $this->cadena_resultado;

}/* Fin del método selección unica*/


function campos_multiples($configuracion)
{
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="id_pregunta, ";
		$this->cadena_sql.="etiqueta, ";
		$this->cadena_sql.="valor, ";
		$this->cadena_sql.="orden ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."m_multiple ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->pregunta." ";
		$this->cadena_sql.="ORDER BY orden ASC";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_multiple=$this->acceso_db->obtener_registro_db();
		$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
		$this->cadena_resultado="";
		if($this->conteo_multiple>0)
		{
			/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
			controlar un poco más el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
			$this->la_cadena=new cadenas;
			for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
			{
				$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
				$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
				$this->codigo_opcion=$this->rellenar_cadena($this->contador_m,3);
				/*Determinar si existe una entrada en la base de datos*/
				$this->mi_pregunta=$this->codigo_pregunta.$this->codigo_opcion;
				/*Este tipo de métrica supone una sola respuesta por pregunta*/
				
				$this->la_respuesta=$this->buscar_respuesta_campos_multiples((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),$this->contador_m,$configuracion,0,(($this->artefacto)/1));
				
				
				$this->cadena_resultado.="<tr>\n";
							
				if($this->la_respuesta==FALSE)
				{
					$this->cadena_resultado.="<td class='celdapresentacion'>\n";
					$this->cadena_resultado.=$this->etiqueta;
					$this->cadena_resultado.="</td>\n";
					$this->cadena_resultado.="<td class='celdapresentacion'>\n";
					$this->cadena_resultado.="0";
					$this->cadena_resultado.="</td>\n";
				}
				else
				{
				
					$this->cadena_resultado.="<td class='celdapresentacion'>\n";
					$this->cadena_resultado.=$this->etiqueta;
					$this->cadena_resultado.="</td>\n";
					$this->cadena_resultado.="<td class='celdapresentacion'>\n";
					$this->cadena_resultado.=$this->la_respuesta;
					$this->cadena_resultado.="</td>\n";
				}
				
				$this->cadena_resultado.="</tr>\n";
				
			}
			
					
		}
	
	
		
	return $this->cadena_resultado;
	
	
	
}/* Fin del método campos_multiples*/



function buscar_pregunta($configuracion,$id_pregunta)
{

	$this->cadena_sql="SELECT id_pregunta, nombre, fecha_creacion, comentario, id_usuario, tipo FROM ";
	$this->cadena_sql.="".$configuracion["prefijo"]."pregunta WHERE id_pregunta=".$id_pregunta." LIMIT 1";
	/*echo $this->cadena_sql."<br>";*/
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_buscar=$this->acceso_db->obtener_registro_db();
	return $this->registro_buscar;

}/* Fin método buscar_pregunta*/

function numero_pregunta($id_pregunta)
{

	$this->cadena_numero="<table style='width: 100%; text-align: left;' border='0' cellpadding='2' cellspacing='2'>";
	$this->cadena_numero.="<tbody>\n";
	$this->cadena_numero.="<tr>\n";
	$this->cadena_numero.="<td style='font-weight: bold; color: rgb(0, 0, 102); font-family:Helvetica,Arial,sans-serif;'>";
	$this->cadena_numero.="<hr>Pregunta ".$id_pregunta;
	$this->cadena_numero.="</td>\n";
	$this->cadena_numero.="</tr>\n";
	$this->cadena_numero.="</tbody>\n";
	$this->cadena_numero.="</table>\n";
	return $this->cadena_numero;

}/*Fin del método numero_pregunta*/

function buscar_respuesta($proceso,$instrumento,$pregunta,$instancia,$opcion,$configuracion,$tipo,$artefacto)
{
	
	$this->el_proceso=$proceso;
	$this->el_instrumento=$instrumento;
	$this->el_artefacto=$artefacto;
	$this->la_pregunta=$pregunta;
	$this->la_instancia=$instancia;
	if($tipo==0)
	{
		$this->la_opcion=$opcion;
	}
	else
	{
		$this->la_opcion=0;
		$this->valor=$opcion;
	}
	
	$this->cadena_sql="SELECT valor ";
	$this->cadena_sql.="FROM ".$configuracion["prefijo"]."resultado ";
	$this->cadena_sql.="WHERE id_proceso=".($this->el_proceso+0);
	$this->cadena_sql.=" AND id_artefacto=".(($this->el_artefacto)/1);
	$this->cadena_sql.=" AND id_instrumento=".(($this->el_instrumento)/1);
	$this->cadena_sql.=" AND id_pregunta=".(($this->la_pregunta)/1);
	$this->cadena_sql.=" AND id_instancia=".(($this->la_instancia)/1);
	$this->cadena_sql.=" AND id_opcion=".(($this->la_opcion)/1);
	if($tipo==1)
	{
		$this->cadena_sql.=" AND valor='".$this->valor."'";
	}
	
	//echo $this->cadena_sql."<br>";
	$this->este_acceso=new dbms($configuracion);
	$this->este_enlace=$this->este_acceso->conectar_db();
	if (is_resource($this->enlace))
	{
		$this->este_acceso->registro_db($this->cadena_sql,0);
		$this->el_registro=$this->este_acceso->obtener_registro_db();
		$this->el_conteo=$this->este_acceso->obtener_conteo_db();
		return $this->el_conteo;
			
	}
	return FALSE;
	
}

function buscar_respuesta_campos_multiples($proceso,$instrumento,$pregunta,$instancia,$opcion,$configuracion,$tipo,$artefacto)
{
	
	$this->el_proceso=$proceso;
	$this->el_instrumento=$instrumento;
	$this->el_artefacto=$artefacto;
	$this->la_pregunta=$pregunta;
	$this->la_instancia=$instancia;
	if($tipo==0)
	{
		$this->la_opcion=$opcion;
	}
	else
	{
		$this->la_opcion=0;
		$this->valor=$opcion;
	}
	
	$this->cadena_sql="SELECT valor ";
	$this->cadena_sql.="FROM ".$configuracion["prefijo"]."resultado ";
	$this->cadena_sql.="WHERE id_proceso=".($this->el_proceso+0)." ";
	$this->cadena_sql.="AND id_artefacto=".(($this->el_artefacto)/1)." ";
	$this->cadena_sql.="AND id_instrumento=".(($this->el_instrumento)/1)." ";
	$this->cadena_sql.="AND id_pregunta=".(($this->la_pregunta)/1)." ";
	$this->cadena_sql.="AND id_instancia=".(($this->la_instancia)/1)." ";
	$this->cadena_sql.="AND id_opcion=".(($this->la_opcion)/1)." ";
	if($tipo==1)
	{
		$this->cadena_sql.=" AND valor='".$this->valor."'";
	}
	$this->cadena_sql.="GROUP BY valor";
	//echo $this->cadena_sql."<br>";
	$this->este_acceso=new dbms($configuracion);
	$this->este_enlace=$this->este_acceso->conectar_db();
	if (is_resource($this->enlace))
	{
		$this->este_acceso->registro_db($this->cadena_sql,0);
		$this->el_registro=$this->este_acceso->obtener_registro_db();
		$this->el_conteo=$this->este_acceso->obtener_conteo_db();
		return $this->el_conteo;
			
	}
	return FALSE;
	
}


function asociada($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$artefacto)
{
	$this->pregunta=$id_pregunta;
	$this->instancia=$instancia;
	$this->id_proceso=$id_proceso;
	$this->artefacto=$artefacto;
	$this->instrumento=$instrumento;
	$this->opcion=0;
	
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{
		//Cuantas personas han constestado la pregunta?
		$this->cadena_sql="SELECT valor ";
		$this->cadena_sql.="FROM ".$configuracion["prefijo"]."resultado ";
		$this->cadena_sql.="WHERE id_proceso=".($this->id_proceso/1)." ";
		$this->cadena_sql.="AND id_artefacto=".(($this->artefacto)/1)." ";
		$this->cadena_sql.="AND id_instrumento=".(($this->instrumento)/1)." ";
		$this->cadena_sql.="AND id_pregunta=".(($this->pregunta)/1)." ";
		$this->cadena_sql.="GROUP BY encuestado";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_total=$this->acceso_db->obtener_registro_db();
		$this->este_conteo_total=$this->acceso_db->obtener_conteo_db();
		if($this->este_conteo_total>$this->conteo_total)
		{
			$this->conteo_total=$this->este_conteo_total;		
		}
		/*Determinar los componentes*/
	
		/*Encabezado*/
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="valor ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".(($this->pregunta)/1)." ";
		$this->cadena_sql.="AND propiedad='encabezado' LIMIT 1";
		//echo $this->cadena_sql;			
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_encabezado=$this->acceso_db->obtener_registro_db();
		$this->conteo_encabezado=$this->acceso_db->obtener_conteo_db();
		$this->la_cadena=new cadenas;
		$this->cadena_encabezado="<table class='tablarespuesta' align='center' style='width: 100%; text-align: left;' cellpadding='5' cellspacing='1'>\n";
		$this->cadena_encabezado.="<tbody>\n";
		if($this->conteo_encabezado>0)
		{
			
			$this->encabezado=$this->la_cadena->unhtmlentities($this->registro_encabezado[0][0]);
			/*if($this->encabezado!="")
			{*/

			$this->cadena_encabezado.="<tr class='encabezadopregunta'>\n";
			$this->cadena_encabezado.="<td colspan='3' class='celdapresentacion'>\n";
			$this->cadena_encabezado.=ucfirst (strtolower ($this->encabezado));
			$this->cadena_encabezado.="</td>\n";
			$this->cadena_encabezado.="</tr>\n";
		}
			
	
		/* Determinar el tipo de métrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
		
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="valor ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".(($this->pregunta)/1);
		$this->cadena_sql.=" AND propiedad='id_metrica' LIMIT 1";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_metrica=$this->acceso_db->obtener_registro_db();
		$this->conteo_metrica=$this->acceso_db->obtener_conteo_db();
		if($this->conteo_metrica>0)
		{
			$this->metrica=$this->registro_metrica[0][0];
			$this->codigo_pregunta=$this->id_proceso.$this->artefacto.$this->instrumento.$this->pregunta.$this->instancia;
			switch($this->metrica)
			{
				case 1:
					/*Selección múltiple: 
					El método POST envia la información nombre=<valor; si hay dos controles con el mismo nombre envia el 
					dato del último que ha encontrado. Si el control no está seleccionado no  envia nada.
								*/
						$this->cadena_informacion="<table cellspacing='2'>\n";
						$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
						$this->cadena_informacion.="<td>\n";
						$this->cadena_informacion.="M&eacute;trica usada:";
						$this->cadena_informacion.="</td>\n";
						$this->cadena_informacion.="<td align='left'>\n";
						$this->cadena_informacion.="Selecci&oacute;n m&uacute;ltiple";
						$this->cadena_informacion.="</td>\n";
						$this->cadena_informacion.="</tr>\n";
						$this->cadena_informacion.="</table>\n";		
						$this->seleccion_multiple($configuracion);
						break;
								
				case 2:
				/*Selección única*/
					$this->cadena_informacion="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Selecci&oacute;n Unica";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";		
					$this->seleccion_unica($configuracion);
					break;
							
				case 3:
				/*Comentario múltiples campos*/
					$this->cadena_informacion="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Abierta M&uacute;ltiples campos";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					$this->campos_multiples($configuracion);
					break;

				case 4:
					$this->cadena_informacion="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Calificaci&acute;n num&eacute;rica";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					/*  Calificación numérica*/
					
					
					break;
					
				case 5:
					$this->cadena_informacion="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Calificaci&acute;n Porcentual";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					/* Calificación porcentual*/
					
					
					break;
					
				case 6:
					/*Dato numérico*/
					$this->cadena_informacion="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Dato num&eacute;rico";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					
					break;
					
				case 7:
					/* Comentario de una línea*/
					$this->cadena_informacion="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Comentario corto";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					
					break;							
				case 8:
					$this->cadena_informacion="<table cellspacing='2'>\n";
					$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_informacion.="<td>\n";
					$this->cadena_informacion.="M&eacute;trica usada:";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="<td align='left'>\n";
					$this->cadena_informacion.="Comentario Largo";
					$this->cadena_informacion.="</td>\n";
					$this->cadena_informacion.="</tr>\n";
					$this->cadena_informacion.="</table>\n";
					/*Comentario de varias líneas*/
					
					break;
					
					
				default:
					
				
				break;
								
						
			}
			$opciones=$configuracion["site"].'/index.php?page='.enlace('ficha_mas_info');
			$opciones.='&opcion=mostrar';
			$opciones.='&proceso='.($this->id_proceso/1); 
			$opciones.='&artefacto='.($this->artefacto/1); 
			$opciones.='&instrumento='.($this->instrumento/1); 
			$opciones.='&pregunta='.($this->pregunta/1); 
			
			$this->cadena_informacion.="<table cellspacing='2'>\n";
			$this->cadena_informacion.="<tr class='bloquecentralcuerpo'>\n";
			$this->cadena_informacion.="<td align='center'>";
			$this->cadena_informacion.="<a href='#' onclick=\"abrir_ventana('".$opciones."','Ficha_resultados')\">";
			$this->cadena_informacion.="Ver m&aacute;s informaci&oacute;n";
			$this->cadena_informacion.="</A>";
			$this->cadena_informacion.="</td>";
			$this->cadena_informacion.="</tr>\n";
			$this->cadena_informacion.="</table>\n";
			
			$this->cadena_pregunta=$this->cadena_informacion.$this->cadena_encabezado.$this->cadena_resultado;
			$this->cadena_pregunta.="</tbody>\n</table>\n";					
			return $this->cadena_pregunta;	
		}
		
	}
}/* Fin del método asociada*/
}
?>
