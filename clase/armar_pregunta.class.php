<?php
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
                        pregunta.class.php 
Este programa es software libre; usted lo puede distribuir o modificar bajo 
los terminos de la version 2 de GNU - General Public License, tal como es 
publicada por la Free Software Foundation.

Este programa se distribuye con la esperanza de que sea util pero SIN NINGUNA 
GARANTIA; sin garantia implicita de COMERCIALIZACION  o de USO PARA UN PROPO-
SITO EN PARTICULAR.

Por favor lea GNU General Public License para mas detalles.

***************************************************************************
* @subpackage   
* @package	clase
* @copyright    GPL
* @version	1.0
* @author      	Paulo Cesar Coronado
* @link		http://acreditacion.udistrital.edu.co

* pregunta Class 
*
* Esta clase de utiliza para armar los diferentes tipos de preguntas que se 
* encuentran en los instrumentos
* 
****************************************************************************/

/* Las preguntas tienen un codigo de 15 caracteres en donde:

$codigo=00000000000000000000

$id_proceso=substr ( $codigo, 0,5) 
$id_pregunta=substr ( $codigo, 4,6)
$instancia=substr ( $codigo, 10,2)
$opcion=substr ( $codigo, 12,2) 
$id_instrumento=substr ( $codigo, 14,5)

*/
class armar_pregunta
{
	
	function armar_pregunta()
	{
		$this->cadena_pregunta="";
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


	function compuesta($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$id_artefacto)
	{
		
		
		$this->id_proceso=$this->rellenar_cadena($id_proceso,6);
		$this->id_artefacto=$this->rellenar_cadena($id_artefacto,6);
		$this->instrumento=$this->rellenar_cadena($instrumento,6);
		$this->pregunta=$this->rellenar_cadena($id_pregunta,7);
		$this->opcion=$this->rellenar_cadena("",3);
		$this->instancia=$this->rellenar_cadena($instancia,2);
		
		$this->acceso_db=new dbms($configuracion);
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace))
		{	
			
		
			/*Determinar los componentes*/
		
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="id_hijo, ";
			$this->cadena_sql.="orden ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_compuesta ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_padre=".$this->pregunta." ";
			$this->cadena_sql.="ORDER BY ";
			$this->cadena_sql.="orden ASC";
			
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
					$this->registro_2=$this->buscar_pregunta($this->registro[$this->contador][0],$configuracion);		
					
					
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
								$this->codigo=$this->rellenar_cadena($this->registro_2[0][0],6);
								$this->primitiva($configuracion,$this->codigo,$this->id_proceso,$this->instancia,$this->instrumento,$this->id_artefacto);
								
								
								break;
						
						case 3:
								/*Pregunta ABSTRACTA
								Busca para ver si la pegunta tiene un encabezado*/
					
								$this->cadena_sql="SELECT ";
								$this->cadena_sql.="valor ";
								$this->cadena_sql.="FROM ";
								$this->cadena_sql.=$configuracion["prefijo"]."p_propiedad ";
								$this->cadena_sql.="WHERE ";
								$this->cadena_sql.="id_pregunta=".$this->registro_2[0][0]." ";
								$this->cadena_sql.="AND ";
								$this->cadena_sql.="propiedad='encabezado' ";
								$this->cadena_sql.="LIMIT 1";
								/*echo $this->cadena_sql;*/
								$this->acceso_db->registro_db($this->cadena_sql,0);
								$this->registro_encabezado=$this->acceso_db->obtener_registro_db();
								$this->conteo_encabezado=$this->acceso_db->obtener_conteo_db();
								$this->la_cadena=new cadenas;
								if($this->conteo_encabezado>0)
								{
									$this->encabezado=$this->la_cadena->unhtmlentities($this->registro_encabezado[0][0]);
									$this->cadena_pregunta.="<table align ='center' style='width: 100%; text-align: left;' border='0'";
									$this->cadena_pregunta.="cellpadding='5' cellspacing='1'>\n<tbody>\n";
									$this->cadena_pregunta.="<tr class='encabezadopregunta'>\n";
									$this->cadena_pregunta.="<td>\n";
									$this->cadena_pregunta.=$this->encabezado;
									$this->cadena_pregunta.="</td>\n";
									$this->cadena_pregunta.="</tr>\n";
									$this->cadena_pregunta.="</tbody>\n</table>\n";
								}
								
								break;
						
						default:
					
							break;
					
									
						
					}
						
						
				
				}
					
				if(isset($this->validar))
				{
					$this->retorno[0]=$this->cadena_pregunta;	
					$this->retorno[1]=$this->validar;
					return $this->retorno;	
				}
				else
				{
					return $this->cadena_pregunta;	
				}	
					
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

	function primitiva($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$id_artefacto)
	{
		
		
		$this->id_proceso=$this->rellenar_cadena($id_proceso,6);
		$this->id_artefacto=$this->rellenar_cadena($id_artefacto,6);
		$this->instrumento=$this->rellenar_cadena($instrumento,6);
		$this->pregunta=$this->rellenar_cadena($id_pregunta,7);
		$this->opcion=$this->rellenar_cadena("",3);
		$this->instancia=$this->rellenar_cadena($instancia,2);
		
		
		$this->acceso_db=new dbms($configuracion);
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace))
		{
			$this->pregunta_mostrar=$id_pregunta;
			
		
			/*Armar las preguntas primitivas*/
			
			
			/*Determinar los componentes*/
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="valor ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar;
			$this->cadena_sql.=" AND ";
			$this->cadena_sql.="propiedad='encabezado' ";
			$this->cadena_sql.="LIMIT 1";
			
			
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->registro_encabezado=$this->acceso_db->obtener_registro_db();
			$this->conteo_encabezado=$this->acceso_db->obtener_conteo_db();
			
			$this->la_cadena=new cadenas;
			$this->cadena_pregunta.="<table align='center' style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>\n";
			$this->cadena_pregunta.="<tbody>\n";
			
			if($this->conteo_encabezado>0)
			{
				
				$this->encabezado=$this->la_cadena->unhtmlentities($this->registro_encabezado[0][0]);
				/*if($this->encabezado!="")
				{*/
				$this->cadena_pregunta.="<tr class='encabezadopregunta'>\n";
				$this->cadena_pregunta.="<td>\n";
				$this->cadena_pregunta.=$this->encabezado;
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="</tr>\n";
				
				/* Determinar el tipo de métrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
				$this->cadena_sql="SELECT valor ";
				$this->cadena_sql.="FROM ";
				$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
				$this->cadena_sql.="WHERE ";
				$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar;
				$this->cadena_sql.=" AND ";
				$this->cadena_sql.="propiedad='id_metrica' ";
				$this->cadena_sql.="LIMIT 1";
				
				/*echo $this->cadena_sql;*/
				
				$this->acceso_db->registro_db($this->cadena_sql,0);
				$this->registro_metrica=$this->acceso_db->obtener_registro_db();
				$this->conteo_metrica=$this->acceso_db->obtener_conteo_db();
				if($this->conteo_metrica>0)
				{
					$this->metrica=$this->registro_metrica[0][0];
					$this->codigo_pregunta=$this->id_proceso.$this->id_artefacto.$this->instrumento.$this->pregunta.$this->instancia;
					switch($this->metrica)
					{
						case 1:
						/*Selección múltiple: 
						El método POST envia la información nombre=<valor; si hay dos controles con el mismo nombre envia el 
						dato del último que ha encontrado. Si el control no está seleccionado no  envia nada.
									*/
							$this->seleccion_multiple($this->codigo_pregunta,$configuracion);
							break;
									
						case 2:
						/*Selección única*/
							$this->seleccion_unica($this->codigo_pregunta.$this->opcion,$configuracion);
							break;
									
						case 3:
						/*Comentario múltiples campos*/
							$this->campos_multiples($this->codigo_pregunta,$configuracion);
							break;

						case 4:
							/*  Calificación numérica*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
							$this->cadena_pregunta.="<input size='3' name='".$this->codigo_pregunta.$this->opcion."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							//Determinar limites inferiores y superiores
							
							$this->registro_numerica=$this->busqueda_armar_pregunta($this->pregunta,$configuracion,"calificacion_numerica");
							if(is_array($this->registro_numerica))
							{
								$validar="&&verificar_numero_lleno(REEMPLAZO,'".$this->codigo_pregunta.$this->opcion."')";
								for($a=0;$a< count($this->registro_numerica);$a++) 
								{
									switch($this->registro_numerica[$a][0])
									{
										case "inferior":
											$inferior=$this->registro_numerica[$a][1];
										break;
										
										case "superior":
											$superior=$this->registro_numerica[$a][1];
										break;
										
										case "entero":
											$this->validar.="&&validar_entero_lleno(REEMPLAZO,'".$this->codigo_pregunta.$this->opcion."')";
										break;
									
									}
								}
								
								if(isset($inferior)&&isset($superior))
								{
									$this->validar.="&&verificar_rango(REEMPLAZO,'".$this->codigo_pregunta.$this->opcion."', ".$inferior.", ".$superior.")";
								}
								//echo $validar;
							}
							break;
							
						case 5:
							/* Calificación porcentual*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
							$this->cadena_pregunta.="<input size='5' name='".$this->codigo_pregunta.$this->opcion."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 6:
							/*Dato numérico*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
							$this->cadena_pregunta.="<input size='5' name='".$this->codigo_pregunta.$this->opcion."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 7:
							/* Comentario de una línea*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
						$this->cadena_pregunta.="<input size='40' name='".$this->codigo_pregunta.$this->opcion."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 8:
							/*Comentario de varias líneas*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td style='text-align: center;' class='celdatabla'>\n";
							$this->cadena_pregunta.="<textarea cols='45' rows='4' name='".$this->codigo_pregunta.$this->opcion."'></textarea>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							break;
			
						default:
							
						
						break;
										
								
					}
			$this->cadena_pregunta.="</tbody>\n</table>\n";					
					
					if(isset($this->validar))
					{
						$this->retorno[0]=$this->cadena_pregunta;	
						$this->retorno[1]=$this->validar;
						return $this->retorno;	
					}
					else
					{
						return $this->cadena_pregunta;	
					}
				}
			
			}
		}	
	}/* Fin del método primitiva*/



function seleccion_multiple($codigo_pregunta,$configuracion)
{
	$this->codigo_pregunta=$codigo_pregunta;
	$this->cadena_sql="SELECT ";
	$this->cadena_sql.="id_pregunta, ";
	$this->cadena_sql.="etiqueta, ";
	$this->cadena_sql.="valor, ";
	$this->cadena_sql.="orden ";
	$this->cadena_sql.="FROM ";
	$this->cadena_sql.="".$configuracion["prefijo"]."m_multiple ";
	$this->cadena_sql.="WHERE ";
	$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar;
	$this->cadena_sql.=" ORDER BY orden ASC";
	
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_multiple=$this->acceso_db->obtener_registro_db();
	$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
	$this->la_cadena=new cadenas;
	if($this->conteo_multiple>0)
	{
		/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
		controlar un poco más el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
		for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
		{
			$this->codigo_opcion=$this->rellenar_cadena($this->registro_multiple[$this->contador_m][2],3);
			$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
			$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
			$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
			$this->cadena_pregunta.="<td class='celdatabla'>\n";
			$this->cadena_pregunta.="<input name='".$this->codigo_pregunta;
			$this->cadena_pregunta.=$this->codigo_opcion."' value='".$this->valor;
			$this->cadena_pregunta.="' type='checkbox'>".$this->etiqueta."\n";
			$this->cadena_pregunta.="</td>\n";
			$this->cadena_pregunta.="</tr>\n";
		}
						
	}
  
	
	return $this->cadena_pregunta;  
						 
	
	
}


function seleccion_unica($codigo_pregunta,$configuracion)
{
		$this->codigo_pregunta=$codigo_pregunta;	
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="id_pregunta, ";
		$this->cadena_sql.="etiqueta, ";
		$this->cadena_sql.="valor, ";
		$this->cadena_sql.="orden ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."m_multiple ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar;
		$this->cadena_sql.=" ORDER BY orden ASC";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_multiple=$this->acceso_db->obtener_registro_db();
		$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
		if($this->conteo_multiple>0)
		{
			/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
			controlar un poco más el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
			
			$this->la_cadena=new cadenas;
			for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
			{
				$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
				$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
				
				$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
				$this->cadena_pregunta.="<td class='celdatabla'>\n";
				$this->cadena_pregunta.="<input name='".$this->codigo_pregunta;
				$this->cadena_pregunta.="' value='".$this->valor;
				$this->cadena_pregunta.="' type='radio'>".$this->etiqueta."\n";
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="</tr>\n";
				
				
			}
					
		}

return $this->cadena_pregunta;

}/* Fin del método selección unica*/


function campos_multiples($codigo_pregunta,$configuracion)
{
		$this->codigo_pregunta=$codigo_pregunta;
		
		$this->cadena_sql="SELECT id_pregunta, etiqueta, valor, orden FROM ".$configuracion["prefijo"]."m_multiple WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ORDER BY orden ASC";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_multiple=$this->acceso_db->obtener_registro_db();
		$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
		if($this->conteo_multiple>0)
		{
			/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
			controlar un poco más el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
			
			$this->cadena_pregunta.="<tr>\n";
			$this->cadena_pregunta.="<td>\n";
			$this->cadena_pregunta.="<table style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>\n";
			$this->cadena_pregunta.="<tbody>\n";
			$this->la_cadena=new cadenas;
			for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
			{
				$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
				$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
				$this->codigo_opcion=$this->rellenar_cadena($this->contador_m,3);
				$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
				$this->cadena_pregunta.="<td class='celdatabla'>\n".$this->etiqueta."\n</td>\n";
				$this->cadena_pregunta.="<td class='celdatabla'>\n";
				$this->cadena_pregunta.="<input size='".$this->valor ."' name='".$this->codigo_pregunta;
				$this->cadena_pregunta.=$this->codigo_opcion."'"; 							
				$this->cadena_pregunta.="' >";
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="</tr>\n";
				
			}
			$this->cadena_pregunta.="</tbody>\n</table>\n";
					
		}
	
	return $this->cadena_pregunta;
	
	
	
}/* Fin del método campos_multiples*/



function buscar_pregunta($id_pregunta,$configuracion)
{

	$this->cadena_sql="SELECT id_pregunta, nombre, fecha_creacion, comentario, id_usuario, tipo FROM ";
	$this->cadena_sql.="".$configuracion["prefijo"]."pregunta WHERE id_pregunta=".$id_pregunta." LIMIT 1";
	/*echo $this->cadena_sql."<br>";*/
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_buscar=$this->acceso_db->obtener_registro_db();
	return $this->registro_buscar;

}/* Fin método buscar_pregunta*/

function numero_pregunta($id_pregunta,$configuracion)
{

$this->cadena_pregunta.="<table style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>";
$this->cadena_pregunta.="<tbody>\n<tr>\n<td style='font-weight: bold; color: rgb(0, 0, 102); font-family:";
$this->cadena_pregunta.="Helvetica,Arial,sans-serif;'><hr>Pregunta ".$id_pregunta."<hr></td>\n</tr>\n</tbody>\n</table>\n";

}/*Fin del método numero_pregunta*/


	function cadena_sql_armar_pregunta($configuracion, $tipo, $valor)
	{
		
		switch($tipo)
		{
			case "calificacion_numerica":
				$cadena_sql="SELECT ";
				$cadena_sql.="propiedad, ";
				$cadena_sql.="valor ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$configuracion["prefijo"]."p_propiedad ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_pregunta=".($valor/1)." ";
				$cadena_sql.="AND ";
				$cadena_sql.="(";
				$cadena_sql.="propiedad='inferior' ";
				$cadena_sql.="OR ";
				$cadena_sql.="propiedad='superior' ";
				$cadena_sql.="OR ";
				$cadena_sql.="propiedad='entero' ";
				$cadena_sql.=") ";
				$cadena_sql.="LIMIT 3";
			
			
			break;
			
			default:
			break;
			
		
		}
		//echo $cadena_sql;
		return $cadena_sql;
	}
	
	function busqueda_armar_pregunta($valor,$configuracion,$tipo)
	{
		
		$cadena_sql=$this->cadena_sql_armar_pregunta($configuracion,$tipo,$valor);
		//echo $cadena_sql."<br>";		
		$this->acceso_db->registro_db($cadena_sql,0);
		$registro_busqueda=$this->acceso_db->obtener_registro_db();
		if($registro_busqueda==FALSE)
		{
			$error=$this->acceso_db->obtener_error();
			if((is_array($error))&&($configuracion["development_mode"]==TRUE))
			{
				echo $error["numero"].":".$error["error"];
			}
			return FALSE;
		}
		else
		{
			$campos_busqueda=$this->acceso_db->obtener_conteo_db();
			if($campos_busqueda>0)
			{
				return $registro_busqueda;
			}
			else 
			{
				return FALSE;
			
			}
		}
	}

}
?>
