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
class armar_pregunta_borrador
{
	
	function armar_pregunta_borrador()
	{
		$this->cadena_pregunta="";
	}
		
	function rellenar_cadena($cadena,$tamanno)
	{
		
		$tamanno_cadena=strlen($cadena);
		
		for($a=$tamanno_cadena;$a<$tamanno;$a++)
		{
			
			$cadena="0".$cadena;
		}
		
		return $cadena;
	}
	
	
	function compuesta($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$sesion=0)
	{
		$this->pregunta=$this->rellenar_cadena($id_pregunta,6);
		$this->instancia=$this->rellenar_cadena($instancia,2);
		$this->id_proceso=$this->rellenar_cadena($id_proceso,5);
		$this->instrumento=$this->rellenar_cadena($instrumento,5);
		$this->acceso_db=new dbms($configuracion);
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace))
		{	
			
		
			/*Determinar los componentes*/
		
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="id_hijo, ";
			$this->cadena_sql.="orden ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."compuesta_borrador ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_padre=";
			$this->cadena_sql.=$this->pregunta." ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.="id_sesion=";
			$this->cadena_sql.="'".$sesion."' ";
			$this->cadena_sql.="ORDER BY orden ASC";
			
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->registro=$this->acceso_db->obtener_registro_db();
			$this->campos_c=$this->acceso_db->obtener_conteo_db();
			//echo $this->cadena_sql."<br>";
			//echo $this->campos_c."<br>";
			if($this->campos_c==0){
				
					/*TO DO mensaje de error */
				
				}else{
				
					for($this->contador=0;$this->contador<$this->campos_c;$this->contador++)
					{
							/*BUSCA LOS DATOS BÃSICOS DE LAS PREGUNTAS QUE COMPONEN*/
							$this->registro_2=$this->buscar_pregunta($this->registro[$this->contador][0],$configuracion);		
							
							
							/*Seleccion de acuerdo al tipo de pregunta*/
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
										$this->primitiva($configuracion,$this->codigo,$this->id_proceso,$this->instancia,$this->instrumento,$sesion);
										
										
										break;
								
								case 3:
										/*Pregunta ABSTRACTA
										Busca para ver si la pegunta tiene un encabezado*/
										
										$this->cadena_sql="SELECT ";
										$this->cadena_sql.="valor ";
										$this->cadena_sql.="FROM ";
										$this->cadena_sql.=$configuracion["prefijo"]."propiedad_borrador ";
										$this->cadena_sql.="WHERE ";
										$this->cadena_sql.="id_pregunta=";
										$this->cadena_sql.=$this->registro_2[0][0]." ";
										$this->cadena_sql.="AND ";
										$this->cadena_sql.="propiedad='encabezado' ";
										$this->cadena_sql.="AND ";
										$this->cadena_sql.="id_sesion=";
										$this->cadena_sql.="'".$sesion."' ";
										$this->cadena_sql.="LIMIT 1";
										/*echo $this->cadena_sql;*/
										$this->acceso_db->registro_db($this->cadena_sql,0);
										$this->registro_encabezado=$this->acceso_db->obtener_registro_db();
										$this->conteo_encabezado=$this->acceso_db->obtener_conteo_db();
										if($this->conteo_encabezado>0)
										{
											$this->la_cadena=new cadenas;
											$this->encabezado=$this->la_cadena->unhtmlentities($this->registro_encabezado[0][0]);
											$this->cadena_pregunta.="<table align ='center' style='width: 100%; text-align: left;' border='0'";
											$this->cadena_pregunta.="cellpadding='5'cellspacing='1'>\n<tbody>\n";
											$this->cadena_pregunta.="<tr class='encabezadopregunta'>\n";
											$this->cadena_pregunta.="<td>\n";
											$this->cadena_pregunta.=ucfirst (strtolower ($this->encabezado));
											$this->cadena_pregunta.="</td>\n";
											$this->cadena_pregunta.="</tr>\n";
										}
										$this->cadena_pregunta.="</tbody>\n</table>\n";
										
										break;
								
								case 4:
									/*Pregunta DEPENDIENTE
									Por el momento es igual a primitiva
									
									*/
									$this->codigo=$this->rellenar_cadena($this->registro_2[0][0],6);
									$this->primitiva($configuracion,$this->codigo,$this->id_proceso,$this->instancia,$this->instrumento);
									
									break;
								
								default:
							
									break;
							
											
								
							}
							
							
					
					}
					
					
					return $this->cadena_pregunta;	
			}
		}
	}/*Fin del metodo compuesta*/
	
	
	
		/**
		*@method primitiva 
		* @param array berosa
		* @param int  id_instrumento
		* @return string cadena_sql
		* @access public
		*/    
	
	function primitiva($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$sesion=0)
	{
		
			$this->pregunta=$this->rellenar_cadena($id_pregunta,6);
			$this->instancia=$this->rellenar_cadena($instancia,2);
			$this->id_proceso=$this->rellenar_cadena($id_proceso,5);
			$this->instrumento=$this->rellenar_cadena($instrumento,5);
			$this->opcion=$this->rellenar_cadena("",2);
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
				$this->cadena_sql.=$configuracion["prefijo"]."propiedad_borrador ";
				$this->cadena_sql.="WHERE ";
				$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ";
				$this->cadena_sql.="AND ";
				$this->cadena_sql.="propiedad='encabezado' ";
				$this->cadena_sql.="AND ";
				$this->cadena_sql.="id_sesion=";
				$this->cadena_sql.="'".$sesion."' ";
				$this->cadena_sql.="LIMIT 1";
				//echo $this->cadena_sql;
				//exit;
				$this->acceso_db->registro_db($this->cadena_sql,0);
				$this->registro_encabezado=$this->acceso_db->obtener_registro_db();
				$this->conteo_encabezado=$this->acceso_db->obtener_conteo_db();
							
				
				if($this->conteo_encabezado>0)
				{
					
					$this->la_cadena=new cadenas;
					
					$this->encabezado=$this->la_cadena->unhtmlentities($this->registro_encabezado[0][0]);
					
					/*if($this->encabezado!="")
					{*/
					$this->cadena_pregunta.="<table align='center' style='width: 100%; text-align: left;' border='0' cellpadding='5'";
					$this->cadena_pregunta.="cellspacing='1'>\n<tbody>\n";
					$this->cadena_pregunta.="<tr class='encabezadopregunta'>\n";
					$this->cadena_pregunta.="<td>\n";
					$this->cadena_pregunta.=$this->encabezado;
					$this->cadena_pregunta.="</td>\n";
					$this->cadena_pregunta.="</tr>\n";
					$this->cadena_pregunta.="</tbody>\n";
					$this->cadena_pregunta.="</table>\n";
								/*}
					else
					{
							
							$this->cadena_pregunta.="<table style='width: 100%; text-align: left;' border='0' cellpadding='2'";
							$this->cadena_pregunta.="cellspacing='5'>\n<tbody>\n";
							
							
						}*/
						
				}
				$this->cadena_pregunta.="<table align='center' style='width: 100%; text-align: left;' border='0' cellpadding='5'";
				$this->cadena_pregunta.="cellspacing='1'>\n<tbody>\n";	
			
					/* Determinar el tipo de metrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
				
					$this->cadena_sql="SELECT ";
					$this->cadena_sql.="valor ";
					$this->cadena_sql.="FROM ".$configuracion["prefijo"]."propiedad_borrador ";
					$this->cadena_sql.="WHERE ";
					$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ";
					$this->cadena_sql.="AND ";
					$this->cadena_sql.="propiedad='id_metrica' ";
					$this->cadena_sql.="AND ";
					$this->cadena_sql.="id_sesion=";
					$this->cadena_sql.="'".$sesion."' ";
					$this->cadena_sql.="LIMIT 1";
					
					//echo $this->cadena_sql;
					
					$this->acceso_db->registro_db($this->cadena_sql,0);
					$this->registro_metrica=$this->acceso_db->obtener_registro_db();
					$this->conteo_metrica=$this->acceso_db->obtener_conteo_db();
					if($this->conteo_metrica>0)
					{
						$this->metrica=$this->registro_metrica[0][0];
						
						/*Si la metrica es de seleccion multiple explora la tabla ".$configuracion["prefijo"]."m_multiple en futuras versiones existirÃ¡ 
						una exploracion independiente para cada tipo de metrica*/
						$this->codigo_pregunta=$this->id_proceso.$this->pregunta.$this->instancia;
						switch($this->metrica)
						{
							case 1:
							/*Seleccion multiple: 
							El metodo POST envia la informacion nombre=<valor; si hay dos controles con el mismo nombre envia el 
							dato del ultimo que ha encontrado. Si el control no estÃ¡ seleccionado no  envia nada.
										*/
								$this->seleccion_multiple($this->codigo_pregunta,$configuracion,$sesion);
								break;
										
							case 2:
							/*Seleccion unica*/
								$this->seleccion_unica($this->codigo_pregunta.$this->opcion.$this->instrumento,$configuracion,$sesion);
								break;
										
							case 3:
							/*Comentario multiples campos*/
								$this->campos_multiples($this->codigo_pregunta,$configuracion,$sesion);
								break;
	
							case 4:
								/*  Calificacion numerica*/
								$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
								$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
								$this->cadena_pregunta.="<input size='3' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
								$this->cadena_pregunta.="</td>\n";
								$this->cadena_pregunta.="</tr>\n";
								
								
								
								break;
								
							case 5:
								/* Calificacion porcentual*/
								$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
								$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
								$this->cadena_pregunta.="<input size='5' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
								$this->cadena_pregunta.="</td>\n";
								$this->cadena_pregunta.="</tr>\n";
								
								break;
								
							case 6:
								/*Dato numerico*/
								$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
								$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
								$this->cadena_pregunta.="<input size='5' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
								$this->cadena_pregunta.="</td>\n";
								$this->cadena_pregunta.="</tr>\n";
								
								break;
								
							case 7:
								/* Comentario de una lÃ­nea*/
								$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
								$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
							$this->cadena_pregunta.="<input size='40' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
								$this->cadena_pregunta.="</td>\n";
								$this->cadena_pregunta.="</tr>\n";
								
								break;
								
							case 8:
								/*Comentario de varias lÃ­neas*/
								$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
								$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
								$this->cadena_pregunta.="<textarea cols='50' rows='4' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'></textarea>";
								$this->cadena_pregunta.="</td>\n";
								$this->cadena_pregunta.="</tr>\n";
								
								break;
				
							default:
								
							
							break;
											
									
				}
				$this->cadena_pregunta.="</tbody>\n</table>\n";
									
						
						/*echo "TERMINE UNA PREGUNTA<br>";*/
						return $this->cadena_pregunta;	
				}
				
			}
	}/* Fin del metodo primitiva*/
	
	
	
	function seleccion_multiple($codigo_pregunta,$configuracion,$sesion=0)
	{
		$this->codigo_pregunta=$codigo_pregunta;
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="id_pregunta, etiqueta, valor, orden ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.=$configuracion["prefijo"]."multiple_borrador ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ";
		$this->cadena_sql.="AND ";
		$this->cadena_sql.="id_sesion=";
		$this->cadena_sql.="'".$sesion."' ";
		
		$this->cadena_sql.="ORDER BY orden ASC";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_multiple=$this->acceso_db->obtener_registro_db();
		$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
		if($this->conteo_multiple>0)
		{
			/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
			controlar un poco mÃ¡s el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
			$this->la_cadena=new cadenas;
			for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
			{
			
				$this->codigo_opcion=$this->rellenar_cadena($this->contador_m,2);
				$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
				$this->valor=$this->registro_multiple[$this->contador_m][2];
				$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
				$this->cadena_pregunta.="<td class='celdatabla'>\n";
				$this->cadena_pregunta.="<input name='".$this->codigo_pregunta;
				$this->cadena_pregunta.=$this->codigo_opcion.$this->instrumento."' value='".$this->valor;
				$this->cadena_pregunta.="' type='checkbox'>".$this->etiqueta."\n";
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="</tr>\n";
			}
							
		}
	
		return $this->cadena_pregunta;  
							
		
		
	}
	
	
	function seleccion_unica($codigo_pregunta,$configuracion,$sesion=0)
	{
			$this->codigo_pregunta=$codigo_pregunta;	
			
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="id_pregunta, etiqueta, valor, orden ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."multiple_borrador ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.="id_sesion=";
			$this->cadena_sql.="'".$sesion."' ";
			$this->cadena_sql.="ORDER BY orden ASC";
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->registro_multiple=$this->acceso_db->obtener_registro_db();
			$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
			if($this->conteo_multiple>0)
			{
				/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
				controlar un poco mÃ¡s el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
				
				$this->la_cadena=new cadenas;
				
				for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
				{
					$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
					$this->valor=$this->registro_multiple[$this->contador_m][2];
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
	
	}/* Fin del metodo seleccion unica*/
	
	
	function campos_multiples($codigo_pregunta,$configuracion,$sesion=0)
	{
			$this->codigo_pregunta=$codigo_pregunta;
					
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="id_pregunta, ";
			$this->cadena_sql.="etiqueta, ";
			$this->cadena_sql.="valor, ";
			$this->cadena_sql.="orden ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."multiple_borrador ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.="id_sesion=";
			$this->cadena_sql.="'".$sesion."' ";
			$this->cadena_sql.="ORDER BY orden ASC";
			
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->registro_multiple=$this->acceso_db->obtener_registro_db();
			$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
			if($this->conteo_multiple>0)
			{
				/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
				controlar un poco mÃ¡s el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
				$this->la_cadena=new cadenas;
				
				for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
				{
					$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
					$this->valor=$this->registro_multiple[$this->contador_m][2];
					$this->codigo_opcion=$this->rellenar_cadena($this->contador_m,2);
					$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
					$this->cadena_pregunta.="<td class='celdatabla'>\n".$this->etiqueta."\n</td>\n";
					$this->cadena_pregunta.="<td class='celdatabla'>\n";
					$this->cadena_pregunta.="<input size='".$this->valor ."' name='".$this->codigo_pregunta;
					$this->cadena_pregunta.=$this->codigo_opcion.$this->instrumento."'"; 							
					$this->cadena_pregunta.="' >";
					$this->cadena_pregunta.="</td>\n";
					$this->cadena_pregunta.="</tr>\n";
					
				}
		
						
			}
		
		return $this->cadena_pregunta;
		
		
		
	}/* Fin del metodo campos_multiples*/
	
	
	
	function buscar_pregunta($id_pregunta,$configuracion)
	{
	
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="id_pregunta, ";
		$this->cadena_sql.="nombre, ";
		$this->cadena_sql.="fecha_creacion, ";
		$this->cadena_sql.="comentario, ";
		$this->cadena_sql.="id_usuario, ";
		$this->cadena_sql.="tipo ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.=$configuracion["prefijo"]."pregunta_borrador ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".$id_pregunta." ";
		$this->cadena_sql.="LIMIT 1";
		/*echo $this->cadena_sql."<br>";*/
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_buscar=$this->acceso_db->obtener_registro_db();
		return $this->registro_buscar;
	
	}/* Fin metodo buscar_pregunta*/
	
	function numero_pregunta($id_pregunta,$tipo=0)
	{
		$cadena_pregunta="<table class='borderless'>";
		$cadena_pregunta.="<tbody>\n";
		$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
		$cadena_pregunta.="<td class='encabezado_normal'>".$id_pregunta."<hr class='hr_division'>\n";
		$cadena_pregunta.="</td>\n";
		$cadena_pregunta.="</tr>\n";
		$cadena_pregunta.="</tbody>\n";
		$cadena_pregunta.="</table>\n";
		return $cadena_pregunta;
	
	}/*Fin del metodo numero_pregunta*/
	
	
	
	function propiedad($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$sesion=0)
	{
		
			$this->pregunta=$this->rellenar_cadena($id_pregunta,6);
			$this->instancia=$this->rellenar_cadena($instancia,2);
			$this->id_proceso=$this->rellenar_cadena($id_proceso,5);
			$this->instrumento=$this->rellenar_cadena($instrumento,5);
			$this->opcion=$this->rellenar_cadena("",2);
			$this->acceso_db=new dbms($configuracion);
			$this->enlace=$this->acceso_db->conectar_db();
			if (is_resource($this->enlace))
			{
				$this->pregunta_mostrar=$id_pregunta;
				
			
			/*Armar las preguntas primitivas*/
				
				
			/*Determinar los componentes*/
				$cadena_pregunta="<table class='tabla_elegante'>\n<tbody>\n";	
			
					/* Determinar el tipo de metrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
				
					$this->cadena_sql="SELECT ";
					$this->cadena_sql.="valor ";
					$this->cadena_sql.="FROM ".$configuracion["prefijo"]."propiedad_borrador ";
					$this->cadena_sql.="WHERE ";
					$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ";
					$this->cadena_sql.="AND ";
					$this->cadena_sql.="propiedad='id_metrica' ";
					$this->cadena_sql.="AND ";
					$this->cadena_sql.="id_sesion=";
					$this->cadena_sql.="'".$sesion."' ";
					$this->cadena_sql.="LIMIT 1";
					
					//echo $this->cadena_sql;
					
					$this->acceso_db->registro_db($this->cadena_sql,0);
					$this->registro_metrica=$this->acceso_db->obtener_registro_db();
					$this->conteo_metrica=$this->acceso_db->obtener_conteo_db();
					if($this->conteo_metrica>0)
					{
						$this->metrica=$this->registro_metrica[0][0];
						
						/*Si la metrica es de seleccion multiple explora la tabla ".$configuracion["prefijo"]."m_multiple en futuras versiones existirÃ¡ 
						una exploracion independiente para cada tipo de metrica*/
						$this->codigo_pregunta=$this->id_proceso.$this->pregunta.$this->instancia;
						
						$this->cadena_sql="SELECT ";
						$this->cadena_sql.="`id_sesion`, ";
						$this->cadena_sql.="`id_pregunta`, ";
						$this->cadena_sql.="`propiedad`, ";
						$this->cadena_sql.="`valor` ";
						$this->cadena_sql.="FROM ".$configuracion["prefijo"]."propiedad_borrador ";
						$this->cadena_sql.="WHERE ";
						$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ";
						$this->cadena_sql.="AND ";
						$this->cadena_sql.="id_sesion=";
						$this->cadena_sql.="'".$sesion."' ";
						//echo $this->cadena_sql;
						$this->acceso_db->registro_db($this->cadena_sql,0);
						$this->registro_propiedad=$this->acceso_db->obtener_registro_db();
						$this->conteo_propiedad=$this->acceso_db->obtener_conteo_db();
						
						switch($this->metrica)
						{
							case 1:
							//Seleccion multiple: 
								break;
										
							case 2:
							/*Seleccion unica*/
								
								break;
										
							case 3:
							/*Comentario multiples campos*/
			
								break;
	
							case 4:
								//  Calificacion numerica
								for($a=0;$a<count($this->registro_propiedad);$a++)
								{
									switch ($this->registro_propiedad[$a][2])
									{
										case "inferior":
										case "superior":
											$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
											$cadena_pregunta.="<td class='celda_elegante'>\n";
											$cadena_pregunta.="<span class='texto_negrita'>L&iacute;mite ".$this->registro_propiedad[$a][2]."</span>";
											$cadena_pregunta.="</td>\n";
											$cadena_pregunta.="<td class='celda_elegante'>\n";
											if($this->registro_propiedad[$a][3]!="")
											{
												$cadena_pregunta.=$this->registro_propiedad[$a][3];
											}
											else
											{
												$cadena_pregunta.="Indefinido";
											}
											$cadena_pregunta.="</td>\n";
											$cadena_pregunta.="</tr>\n";
										break;										
										
										case "entero":
											$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
											$cadena_pregunta.="<td class='celda_elegante'>\n";
											$cadena_pregunta.="<span class='texto_negrita'>Solo valores enteros</span> ";
											$cadena_pregunta.="</td>\n";
											$cadena_pregunta.="<td class='celda_elegante'>\n";
											$cadena_pregunta.="Si";
											$cadena_pregunta.="</td>\n";
											$cadena_pregunta.="</tr>\n";	
										break;
										
									}
								}
								
								
								break;
								
							case 5:
								/* Calificacion porcentual*/
								
								break;
								
							case 6:
								/*Dato numerico*/
								
								break;
								
							case 7:
								/* Comentario de una lÃ­nea*/
								
								
								break;
								
							case 8:
								/*Comentario de varias lÃ­neas*/
								
								
								break;
				
							default:
								
							
							break;
											
									
				}
				$cadena_pregunta.="</tbody>\n</table><br>\n";
									
						
						/*echo "TERMINE UNA PREGUNTA<br>";*/
						return $cadena_pregunta;	
				}
				
			}
	}/* Fin del metodo propiedad*/
	
	
	

}
?>
