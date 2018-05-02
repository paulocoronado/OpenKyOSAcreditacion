<?PHP  
/*********************************************************************************************************************
  
								pregunta.class.php 
UNIVERSIDAD DISTRITAL Francisco José de Caldas
Comité Institucional de Acreditación

 
TTG de Colombia
Paulo Cesar Coronado
Copyright (C) 2001-2004 


Este programa es software libre; usted lo puede distribuir o modificar bajo los términos de la version 2 
de GNU - General Public License, tal como es publicada por la Free Software Foundation

Este programa se distribuye con la esperanza de que sea útil pero SIN NINGUNA GARANTÍA; 
sin garantía implícita de COMERCIALIZACIÓN  o de USO PARA UN PROPÒSITO EN PARTICULAR.

Por favor lea GNU General Public License para más detalles.

************************************************************************************************************************
* @subpackage   
* @package	db
* @copyright     GPL
* @version      	1.0
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com

* pregunta Class 
*
* Esta clase de utiliza para armar los diferentes tipos de preguntas que se encuentran en los instrumentos
* 
* 
*
*/

/**********************************************************************************************************************/

/* Las preguntas tienen un codigo de 15 caracteres en donde:

$codigo=00000000000000000000

$id_proceso=substr ( $codigo, 0,5) 
$id_pregunta=substr ( $codigo, 4,6)
$instancia=substr ( $codigo, 10,2)
$opcion=substr ( $codigo, 12,2) 
$id_instrumento=substr ( $codigo, 14,5)

*/
class armar_pregunta_borrador{
	
function armar_pregunta_borrador()
{
$this->cadena_pregunta="";
}

	/**
	 *@method compuesta 
	 * @param array berosa
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


function compuesta($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento)
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
	
		$this->cadena_sql="SELECT id_hijo,orden FROM ".$configuracion["prefijo"]."compuesta_borrador WHERE id_padre=";
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
									$this->primitiva($configuracion,$this->codigo,$this->id_proceso,$this->instancia,$this->instrumento);
									
									
									break;
							
							case 3:
									/*Pregunta ABSTRACTA
									Busca para ver si la pegunta tiene un encabezado*/
									
									$this->cadena_sql="SELECT valor FROM ".$configuracion["prefijo"]."propiedad_borrador WHERE id_pregunta=";
									$this->cadena_sql.=$this->registro_2[0][0]." AND propiedad='encabezado' LIMIT 1";
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

function primitiva($configuracion,$id_pregunta,$id_proceso,$instancia,$instrumento)
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
			$this->cadena_sql="SELECT valor FROM ".$configuracion["prefijo"]."propiedad_borrador WHERE id_pregunta=".$this->pregunta_mostrar." AND propiedad='encabezado' LIMIT 1";
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
		
				/* Determinar el tipo de métrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
			
				$this->cadena_sql="SELECT valor FROM ".$configuracion["prefijo"]."propiedad_borrador WHERE id_pregunta=".$this->pregunta_mostrar." AND propiedad='id_metrica' LIMIT 1";
				
				/*echo $this->cadena_sql;*/
				
				$this->acceso_db->registro_db($this->cadena_sql,0);
				$this->registro_metrica=$this->acceso_db->obtener_registro_db();
				$this->conteo_metrica=$this->acceso_db->obtener_conteo_db();
				if($this->conteo_metrica>0)
				{
					$this->metrica=$this->registro_metrica[0][0];
					
					/*Si la métrica es de selección múltiple explora la tabla ".$configuracion["prefijo"]."m_multiple en futuras versiones existirá 
					una exploración independiente para cada tipo de métrica*/
					$this->codigo_pregunta=$this->id_proceso.$this->pregunta.$this->instancia;
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
							$this->seleccion_unica($this->codigo_pregunta.$this->opcion.$this->instrumento,$configuracion);
							break;
									
						case 3:
						/*Comentario múltiples campos*/
							$this->campos_multiples($this->codigo_pregunta,$configuracion);
							break;

						case 4:
							/*  Calificación numérica*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
							$this->cadena_pregunta.="<input size='3' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 5:
							/* Calificación porcentual*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
							$this->cadena_pregunta.="<input size='5' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 6:
							/*Dato numérico*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
							$this->cadena_pregunta.="<input size='5' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 7:
							/* Comentario de una línea*/
							$this->cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
							$this->cadena_pregunta.="<td class='celdatabla' align='center'>\n";
						$this->cadena_pregunta.="<input size='40' name='".$this->codigo_pregunta.$this->opcion.$this->instrumento."'>";
							$this->cadena_pregunta.="</td>\n";
							$this->cadena_pregunta.="</tr>\n";
							
							break;
							
						case 8:
							/*Comentario de varias líneas*/
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
}/* Fin del método primitiva*/



function seleccion_multiple($codigo_pregunta,$configuracion)
{
	$this->codigo_pregunta=$codigo_pregunta;
	$this->cadena_sql="SELECT id_pregunta, etiqueta, valor, orden FROM ".$configuracion["prefijo"]."multiple_borrador WHERE ";
	$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ORDER BY orden ASC";
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


function seleccion_unica($codigo_pregunta,$configuracion)
{
		$this->codigo_pregunta=$codigo_pregunta;	
		$this->cadena_sql="SELECT id_pregunta, etiqueta, valor, orden FROM ".$configuracion["prefijo"]."multiple_borrador WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ORDER BY orden ASC";
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

}/* Fin del método selección unica*/


function campos_multiples($codigo_pregunta,$configuracion)
{
		$this->codigo_pregunta=$codigo_pregunta;
		
		$this->cadena_sql="SELECT id_pregunta, etiqueta, valor, orden FROM ".$configuracion["prefijo"]."multiple_borrador WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->pregunta_mostrar." ORDER BY orden ASC";
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
	
	
	
}/* Fin del método campos_multiples*/



function buscar_pregunta($id_pregunta,$configuracion)
{

	$this->cadena_sql="SELECT id_pregunta, nombre, fecha_creacion, comentario, id_usuario, tipo FROM ";
	$this->cadena_sql.="".$configuracion["prefijo"]."pregunta_borrador WHERE id_pregunta=".$id_pregunta." LIMIT 1";
	/*echo $this->cadena_sql."<br>";*/
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_buscar=$this->acceso_db->obtener_registro_db();
	return $this->registro_buscar;

}/* Fin método buscar_pregunta*/

function numero_pregunta($id_pregunta)
{

$this->cadena_pregunta="<table style='width: 100%; text-align: left;' border='0' cellpadding='5' cellspacing='1'>";
$this->cadena_pregunta.="<tbody>\n<tr class='bloquecentralcuerpo'>\n<td style='font-weight: bold; color: rgb(0, 0, 102); font-family:";
$this->cadena_pregunta.="Helvetica,Arial,sans-serif;'><hr>Pregunta ".$id_pregunta."<hr></td>\n</tr>\n</tbody>\n</table>\n";

}/*Fin del método numero_pregunta*/

}
?>
