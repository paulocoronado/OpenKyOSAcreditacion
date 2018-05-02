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
?>
<?PHP  
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
$id_instancia=substr ( $codigo, 24,2)
$id_opcion=substr ( $codigo, 27,3)


*/
class mostrar_lista_pregunta
{
	
function mostrar_lista_pregunta()
{
$this->cadena_pregunta="";
}

function lista_encuestado($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$artefacto)
{
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="encuestado ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.=$configuracion["prefijo"]."resultado ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_proceso=".$id_proceso." ";
		$this->cadena_sql.="AND ";
		$this->cadena_sql.="id_artefacto=".$artefacto." ";
		$this->cadena_sql.="AND ";
		$this->cadena_sql.="id_instrumento=".$instrumento." ";
		$this->cadena_sql.="AND ";
		$this->cadena_sql.="id_pregunta=".$id_pregunta." ";
		$this->cadena_sql.="AND ";
		$this->cadena_sql.="id_instancia=".$instancia." ";
		$this->cadena_sql.="GROUP BY ";
		$this->cadena_sql.="encuestado ";
		
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro=$this->acceso_db->obtener_registro_db();
		$this->conteo=$this->acceso_db->obtener_conteo_db();
		if($this->conteo>0)
		{
			return $this->registro;
		}
		else
		{
			return FALSE;
		}
	}
	
}	


function datos_pregunta($configuracion,$id_pregunta)
{
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="tipo ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.=$configuracion["prefijo"]."pregunta ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".$id_pregunta." ";
		$this->cadena_sql.="LIMIT 1 ";
		
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro=$this->acceso_db->obtener_registro_db();
		$this->conteo=$this->acceso_db->obtener_conteo_db();
		if($this->conteo>0)
		{
			return $this->registro;
		}
		else
		{
			return FALSE;
		}
	}
	
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


function compuesta($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$encuestado,$artefacto)
{
	$this->pregunta=$this->rellenar_cadena($id_pregunta,7);
	$this->instancia=$this->rellenar_cadena($instancia,2);
	$this->id_proceso=$this->rellenar_cadena($id_proceso,6);
	$this->instrumento=$this->rellenar_cadena($instrumento,6);
	$this->artefacto=$this->rellenar_cadena($artefacto,6);
	$this->encuestado=$encuestado;
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{	
		
	
		/*Determinar los componentes*/
	
		$this->cadena_sql="SELECT id_hijo,orden FROM ".$configuracion["prefijo"]."p_compuesta WHERE id_padre=";
		$this->cadena_sql.=$this->pregunta." ORDER BY orden ASC";
		
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro=$this->acceso_db->obtener_registro_db();
		$this->campos_c=$this->acceso_db->obtener_conteo_db();
		/*echo $this->cadena_sql."<br>";
		echo $this->campos_c."<br>";*/
		if($this->campos_c==0){
			
				/*TO DO mensaje de error */
			
			}else{
			
				for($this->contador=0;$this->contador<$this->campos_c;$this->contador++)
				{
						/*BUSCA LOS DATOS BÁSICOS DE LAS PREGUNTAS QUE COMPONEN*/
						$this->registro_2=$this->buscar_pregunta($this->registro[$this->contador][0]);		
						
						
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
									//echo $this->codigo."<br>";
									$this->primitiva($configuracion,$this->codigo,$this->id_proceso,$this->instancia,$this->instrumento,$this->encuestado,$this->artefacto);
									
									
									break;
							
							case 3:
									/*Pregunta ABSTRACTA
									Busca para ver si la pegunta tiene un encabezado*/
									$this->la_cadena=new cadenas;
									$this->cadena_sql="SELECT valor FROM ".$configuracion["prefijo"]."p_propiedad WHERE id_pregunta=";
									$this->cadena_sql.=$this->registro_2[0][0]." AND propiedad='encabezado' LIMIT 1";
									/*echo $this->cadena_sql;*/
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
	 * @param array configuracion
	 * @param int  id_instrumento
	 * @return string cadena_sql
	 * @access public
	 */    

function primitiva($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$encuestado,$artefacto)
{
	
		$this->pregunta=$this->rellenar_cadena($id_pregunta,7);
		$this->instancia=$this->rellenar_cadena($instancia,2);
		$this->id_proceso=$this->rellenar_cadena($id_proceso,6);
		$this->artefacto=$this->rellenar_cadena($artefacto,6);
		$this->instrumento=$this->rellenar_cadena($instrumento,6);
		$this->encuestado=$encuestado;
		$this->opcion=$this->rellenar_cadena("",3);
		$this->acceso_db=new dbms($configuracion);
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace))
		{
			$this->pregunta_mostrar=$id_pregunta;
			
			/*Determinar los componentes*/
		
			/*Encabezado*/
			$this->cadena_sql="SELECT valor FROM ".$configuracion["prefijo"]."p_propiedad WHERE id_pregunta=".(($this->pregunta_mostrar)/1);
			$this->cadena_sql.=" AND propiedad='encabezado' LIMIT 1";
			
			/*echo $this->cadena_sql;*/
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
				$this->cadena_pregunta.=ucfirst (strtolower ($this->encabezado));
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="</tr>\n";
				/*}
				else
				{
						
						$this->cadena_pregunta.="<table style='width: 100%; text-align: left;' border='0' cellpadding='2'";
						$this->cadena_pregunta.="cellspacing='5'>\n<tbody>\n";
						
						
					}*/
					
				}
				
		
				/* Determinar el tipo de métrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
			
				$this->cadena_sql="SELECT ";
				$this->cadena_sql.="valor ";
				$this->cadena_sql.="FROM ";
				$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
				$this->cadena_sql.="WHERE ";
				$this->cadena_sql.="id_pregunta=".(($this->pregunta_mostrar)/1);
				$this->cadena_sql.=" AND propiedad='id_metrica' LIMIT 1";
				//echo $this->cadena_sql."<br>";
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
							
							/*Determinar si existe una entrada en la base de datos*/
							$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
							/*Este tipo de métrica supone una sola respuesta por pregunta*/
							
							$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
						
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
							
							if($this->la_respuesta==FALSE)
							{
								$this->cadena_pregunta.="<br>";
							}
							else
							{
								$this->cadena_pregunta.=$this->la_respuesta;	
								unset($this->registro_pregunta);
							}
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 5:
							/* Calificación porcentual*/
							
							/*Determinar si existe una entrada en la base de datos*/
							$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
							/*Este tipo de métrica supone una sola respuesta por pregunta*/
							
							$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
						
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
							
							if($this->la_respuesta==FALSE)
							{
								$this->cadena_pregunta.="<br>";
							}
							else
							{
								$this->cadena_pregunta.=$this->la_respuesta;	
								unset($this->registro_pregunta);
							}
							
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							break;
							
						case 6:
							/*Dato numérico*/
							
							/*Determinar si existe una entrada en la base de datos*/
							$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
							/*Este tipo de métrica supone una sola respuesta por pregunta*/
							
							$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
						
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td style='text-align: center;' class='celdatabla'>\n";
							
							if($this->la_respuesta==FALSE)
							{
								$this->cadena_pregunta.="<br>";
							}
							else
							{
								$this->cadena_pregunta.=$this->la_respuesta;	
								unset($this->registro_pregunta);
							}
							
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							break;
							
						case 7:
							/* Comentario de una línea*/
							/*Determinar si existe una entrada en la base de datos*/
							$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
							/*Este tipo de métrica supone una sola respuesta por pregunta*/
							
							$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
						
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
							
							if($this->la_respuesta==FALSE)
							{
								$this->cadena_pregunta.="<br>";
							}
							else
							{
								$this->cadena_pregunta.=$this->la_respuesta;	
								unset($this->registro_pregunta);
							}
							
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							break;							
						case 8:
							/*Comentario de varias líneas*/
							
							/*Determinar si existe una entrada en la base de datos*/
							$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
							/*Este tipo de métrica supone una sola respuesta por pregunta*/
							
							$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
						
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
							
							if($this->la_respuesta==FALSE)
							{
								$this->cadena_pregunta.="<br>";
							}
							else
							{
								$this->cadena_pregunta.=$this->la_respuesta;	
								unset($this->registro_pregunta);
							}
							
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
	if($this->conteo_multiple>0)
	{
		/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
		controlar un poco más el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
		$this->la_cadena=new cadenas;
		for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
		{
			$this->codigo_opcion=$this->rellenar_cadena($this->registro_multiple[$this->contador_m][2],3);
			$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
			$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
			
			/*Determinar si existe una entrada en la base de datos*/
			$this->mi_pregunta=$this->codigo_pregunta.$this->codigo_opcion;
			/*Este tipo de métrica supone una sola respuesta por pregunta*/
			
			$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->valor)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
			
			$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
			$this->cadena_pregunta.="<td class='celdatabla'>\n";
			
			if($this->la_respuesta==FALSE)
			{
				$this->cadena_pregunta.="<input name='".$this->mi_pregunta;
				$this->cadena_pregunta.="' value='".$this->valor;
				$this->cadena_pregunta.="' type='checkbox' disabled>".$this->etiqueta."\n";
			}
			else
			{
				$this->cadena_pregunta.="<input name='".$this->mi_pregunta;
				$this->cadena_pregunta.="' value='".$this->valor;
				$this->cadena_pregunta.="' type='checkbox' checked='checked' disabled>".$this->etiqueta."\n";
			}
			
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
		$this->cadena_sql.="id_pregunta=".($this->pregunta_mostrar/1);
		$this->cadena_sql.=" ORDER BY orden ASC";
		//echo $this->cadena_sql."<br>";
		
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
				
				/*Determinar si existe una entrada en la base de datos*/
				/*Este tipo de métrica supone una sola respuesta por pregunta*/
				$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->valor)/1),$this->encuestado,$configuracion,1,(($this->artefacto)/1));
				$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
				$this->cadena_pregunta.="<td class='celdatabla'>\n";
				
				
				if($this->la_respuesta==FALSE)
				{
					$this->cadena_pregunta.="<input name='".$this->codigo_pregunta.rand();
					$this->cadena_pregunta.="' value='".$this->valor;
					$this->cadena_pregunta.="' type='radio' disabled>".$this->etiqueta."\n";
				}
				else
				{
					$this->cadena_pregunta.="<input name='".$this->codigo_pregunta.rand();
					$this->cadena_pregunta.="' value='".$this->valor;
					$this->cadena_pregunta.="' type='radio' checked='checked' disabled >".$this->etiqueta."\n";
				}
				
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
			$this->la_cadena=new cadenas;
			
			$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
			$this->cadena_pregunta.="<td class='celdatabla'>\n";
			$this->cadena_pregunta.="<table style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>\n";
			$this->cadena_pregunta.="<tbody>\n";
			for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
			{
				$this->etiqueta=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][1]);
				$this->valor=$this->la_cadena->unhtmlentities($this->registro_multiple[$this->contador_m][2]);
				$this->codigo_opcion=$this->rellenar_cadena($this->contador_m,3);
				/*Determinar si existe una entrada en la base de datos*/
			$this->mi_pregunta=$this->codigo_pregunta.$this->codigo_opcion;
			/*Este tipo de métrica supone una sola respuesta por pregunta*/
			
			$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->contador_m)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
			
			
			$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
						
			if($this->la_respuesta==FALSE)
			{
				$this->cadena_pregunta.="<td class='celdatabla'>\n";
				$this->cadena_pregunta.=$this->etiqueta;
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="<td class='celdatabla'>\n";
				$this->cadena_pregunta.="<br>\n";
				$this->cadena_pregunta.="</td>\n";
			}
			else
			{
			
				$this->cadena_pregunta.="<td>\n";
				$this->cadena_pregunta.=$this->etiqueta;
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="<td>\n";
				$this->cadena_pregunta.=$this->la_respuesta;
				$this->cadena_pregunta.="</td>\n";
			}
			
			$this->cadena_pregunta.="</tr>\n";
				
			}
			
					
		}
	$this->cadena_pregunta.="</tbody>\n</table>\n";
	$this->cadena_pregunta.="</td>\n";
	$this->cadena_pregunta.="</tr>\n";
		
	return $this->cadena_pregunta;
	
	
	
}/* Fin del método campos_multiples*/



function buscar_pregunta($id_pregunta,$configuracion)
{

	$this->cadena_sql="SELECT id_pregunta, nombre, fecha_creacion, comentario, id_usuario, tipo FROM ";
	$this->cadena_sql.="".$configuracion["prefijo"]."pregunta WHERE id_pregunta=".$id_pregunta." LIMIT 1";
	//echo $this->cadena_sql."<br>";
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_buscar=$this->acceso_db->obtener_registro_db();
	return $this->registro_buscar;

}/* Fin método buscar_pregunta*/

function numero_pregunta($id_pregunta)
{

$this->cadena_pregunta.="<table style='width: 100%; text-align: left;' border='0' cellpadding='2' cellspacing='2'>";
$this->cadena_pregunta.="<tbody>\n<tr>\n<td style='font-weight: bold; color: rgb(0, 0, 102); font-family:";
$this->cadena_pregunta.="Helvetica,Arial,sans-serif;'><hr>Pregunta ".$id_pregunta."<hr></td>\n</tr>\n</tbody>\n</table>\n";

}/*Fin del método numero_pregunta*/



function buscar_respuesta($proceso,$instrumento,$pregunta,$instancia,$opcion,$encuestado,$configuracion,$tipo,$artefacto)
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
	$this->el_encuestado=$encuestado;
	
	$this->cadena_sql="SELECT valor FROM ".$configuracion["prefijo"]."resultado WHERE id_proceso=".($this->el_proceso/1);
	$this->cadena_sql.=" AND id_artefacto=".(($this->el_artefacto)/1);
	$this->cadena_sql.=" AND id_instrumento=".(($this->el_instrumento)/1);
	$this->cadena_sql.=" AND id_pregunta=".(($this->la_pregunta)/1);
	$this->cadena_sql.=" AND id_instancia=".(($this->la_instancia)/1);
	$this->cadena_sql.=" AND id_opcion=".(($this->la_opcion)/1);
	if($tipo==1)
	{
		$this->cadena_sql.=" AND valor='".$this->valor."'";
	}
	
	$this->cadena_sql.=" AND encuestado='".$this->el_encuestado."'";
	$this->cadena_sql.=" LIMIT 1";
	//echo $this->cadena_sql."<br>";
	$this->este_acceso=new dbms($configuracion);
	$this->este_enlace=$this->este_acceso->conectar_db();
	if (is_resource($this->enlace))
	{
		$this->este_acceso->registro_db($this->cadena_sql,0);
		$this->el_registro=$this->este_acceso->obtener_registro_db();
		$this->el_conteo=$this->este_acceso->obtener_conteo_db();
		
		if($this->el_conteo==0)
		{
				
				return FALSE;
		}
		else
		{			
					
					$this->la_cadena=new cadenas;
					$this->respuesta=$this->la_cadena->unhtmlentities($this->el_registro[0][0]);
					
					return $this->respuesta;
		}	
	}
	return FALSE;
	
}


	/**
	 *@method primitiva 
	 * @param array configuracion
	 * @param int  id_instrumento
	 * @return string cadena_sql
	 * @access public
	 */    

function asociada($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento,$encuestado,$artefacto)
{
	
		$this->pregunta=$this->rellenar_cadena($id_pregunta,7);
		$this->instancia=$this->rellenar_cadena($instancia,2);
		$this->id_proceso=$this->rellenar_cadena($id_proceso,6);
		$this->artefacto=$this->rellenar_cadena($artefacto,6);
		$this->instrumento=$this->rellenar_cadena($instrumento,6);
		$this->encuestado=$encuestado;
		$this->opcion=$this->rellenar_cadena("",3);
		$this->acceso_db=new dbms($configuracion);
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace))
		{
			$this->pregunta_mostrar=$id_pregunta;
			
			
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="id_padre ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_compuesta ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_hijo=".$this->pregunta_mostrar." ";
			$this->cadena_sql.="LIMIT 1";
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->padre=$this->acceso_db->obtener_registro_db();
			$this->conteo_padre=$this->acceso_db->obtener_conteo_db();
			if($this->conteo_padre>0)
			{
				$this->mi_padre=$this->padre[0][0];			
				unset($this->padre);
			}
			else
			{
				echo "<h1>Error Fatal en el acceso al Sistema. Contacte con el administrador</h1>";
				exit;			
			
			}
			
			
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_propiedad.valor ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_compuesta, ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_propiedad,";
			$this->cadena_sql.=$configuracion["prefijo"]."pregunta ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_compuesta.id_padre=".$this->mi_padre." ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_propiedad.propiedad = 'encabezado' ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.=$configuracion["prefijo"]."pregunta.tipo =3 ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_propiedad.id_pregunta = aplicativo_p_compuesta.id_hijo ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.=$configuracion["prefijo"]."pregunta.id_pregunta = aplicativo_p_compuesta.id_hijo ";
			$this->cadena_sql.="LIMIT 1";
			//echo $this->cadena_sql;
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->encabezado_abstracta=$this->acceso_db->obtener_registro_db();
			$this->conteo_abstracta=$this->acceso_db->obtener_conteo_db();
			if($this->conteo_abstracta>0)
			{
				$this->mi_encabezado=$this->encabezado_abstracta[0][0];			
				unset ($this->encabezado_abstracta);
				
				$this->cadena_pregunta.="<table align='center' style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>\n";
				$this->cadena_pregunta.="<tbody>\n";
				$this->cadena_pregunta.="<tr class='encabezadopregunta'>\n";
				$this->cadena_pregunta.="<td>\n";
				$this->cadena_pregunta.=$this->mi_encabezado;
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="</tr>\n";
				$this->cadena_pregunta.="</tbody>\n";
				$this->cadena_pregunta.="</table>\n";
				
			}
			
			/*Determinar los componentes*/
		
			/*Encabezado*/
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="valor ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."p_propiedad ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_pregunta=".(($this->pregunta_mostrar)/1)." ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.="propiedad='encabezado' ";
			$this->cadena_sql.="LIMIT 1";
			//echo $this->cadena_sql;
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
				$this->cadena_pregunta.=ucfirst (strtolower ($this->encabezado));
				$this->cadena_pregunta.="</td>\n";
				$this->cadena_pregunta.="</tr>\n";
			}
				
		
			/* Determinar el tipo de métrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
		
			$this->cadena_sql="SELECT ";
			$this->cadena_sql.="valor ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.="id_pregunta=".(($this->pregunta_mostrar)/1);
			$this->cadena_sql.=" AND propiedad='id_metrica' LIMIT 1";
			//echo $this->cadena_sql."<br>";
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
						
						/*Determinar si existe una entrada en la base de datos*/
						$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
						/*Este tipo de métrica supone una sola respuesta por pregunta*/
						
						$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
					
						$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
						$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
						
						if($this->la_respuesta==FALSE)
						{
							$this->cadena_pregunta.="<br>";
						}
						else
						{
							$this->cadena_pregunta.=$this->la_respuesta;	
							unset($this->registro_pregunta);
						}
						$this->cadena_pregunta.="</td>\n";
						$this->cadena_pregunta.="</tr>\n";
						
						break;
						
					case 5:
						/* Calificación porcentual*/
						
						/*Determinar si existe una entrada en la base de datos*/
						$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
						/*Este tipo de métrica supone una sola respuesta por pregunta*/
						
						$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
					
						$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
						$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
						
						if($this->la_respuesta==FALSE)
						{
							$this->cadena_pregunta.="<br>";
						}
						else
						{
							$this->cadena_pregunta.=$this->la_respuesta;	
							unset($this->registro_pregunta);
						}
						
						$this->cadena_pregunta.="</td>\n";
						$this->cadena_pregunta.="</tr>\n";
						break;
						
					case 6:
						/*Dato numérico*/
						
						/*Determinar si existe una entrada en la base de datos*/
						$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
						/*Este tipo de métrica supone una sola respuesta por pregunta*/
						
						$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
					
						$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
						$this->cadena_pregunta.="<td style='text-align: center;' class='celdatabla'>\n";
						
						if($this->la_respuesta==FALSE)
						{
							$this->cadena_pregunta.="<br>";
						}
						else
						{
							$this->cadena_pregunta.=$this->la_respuesta;	
							unset($this->registro_pregunta);
						}
						
						$this->cadena_pregunta.="</td>\n";
						$this->cadena_pregunta.="</tr>\n";
						break;
						
					case 7:
						/* Comentario de una línea*/
						/*Determinar si existe una entrada en la base de datos*/
						$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
						/*Este tipo de métrica supone una sola respuesta por pregunta*/
						
						$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
					
						$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
						$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
						
						if($this->la_respuesta==FALSE)
						{
							$this->cadena_pregunta.="<br>";
						}
						else
						{
							$this->cadena_pregunta.=$this->la_respuesta;	
							unset($this->registro_pregunta);
						}
						
						$this->cadena_pregunta.="</td>\n";
						$this->cadena_pregunta.="</tr>\n";
						break;							
					case 8:
						/*Comentario de varias líneas*/
						
						/*Determinar si existe una entrada en la base de datos*/
						$this->mi_pregunta=$this->codigo_pregunta.$this->opcion;
						/*Este tipo de métrica supone una sola respuesta por pregunta*/
						
						$this->la_respuesta=$this->buscar_respuesta((($this->id_proceso)/1),(($this->instrumento)/1),(($this->pregunta)/1),(($this->instancia)/1),(($this->opcion)/1),$this->encuestado,$configuracion,0,(($this->artefacto)/1));
					
						$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
						$this->cadena_pregunta.="<td class='celdatabla' style='text-align: center;'>\n";
						
						if($this->la_respuesta==FALSE)
						{
							$this->cadena_pregunta.="<br>";
						}
						else
						{
							$this->cadena_pregunta.=$this->la_respuesta;	
							unset($this->registro_pregunta);
						}
						
						$this->cadena_pregunta.="</td>\n";
						$this->cadena_pregunta.="</tr>\n";
						break;
						
						
					default:
						
					
					break;
									
							
		}
		$this->cadena_pregunta.="</tbody>\n";
		$this->cadena_pregunta.="</table>\n";					
				
				/*echo "TERMINE UNA PREGUNTA<br>";*/
				return $this->cadena_pregunta;	
		}
		
	}
}/* Fin del método asociada*/

}
?>
