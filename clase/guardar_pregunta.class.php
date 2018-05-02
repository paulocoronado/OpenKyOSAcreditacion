<?PHP  
/*********************************************************************************************************************
  
								guardar_pregunta.class.php 
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
* @link		http://acreditacion.udistrital.edu.co

* pregunta Class 
*
* Esta clase de utiliza para armar los diferentes tipos de preguntas que se encuentran en los instrumentos
* 
* 
*
*/

/**********************************************************************************************************************/

/* Las preguntas tienen un codigo de 15 caracteres en donde:

$codigo=PPPPPPAAAAAAFFFFFFpppppppiiooo

$id_proceso=substr ( $codigo, 0,6) 
$id_artefacto=substr ( $codigo, 6,6)
$id_formulario=substr ( $codigo, 12,6)
$id_pregunta=substr ( $codigo, 18,7) 
$id_instancia=substr ( $codigo, 25,2)
$id_opcion=substr ( $codigo, 27,3)


*/
class guardar_pregunta{
	
function guardar_pregunta()
{
	$this->cadena_guardar="";
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


	/**
	 *@method compuesta 
	 * @param array berosa
	 * @param int  id_instrumento
	 * @return string cadena_sql
	 * @access public
	 */    



function compuesta($configuracion,$id,$encuestado)
{
	
	$this->este_proceso=substr ( $id, 0,6); 
	$this->este_artefacto=substr ( $id, 6,6);
	$this->este_instrumento=substr ( $id, 12,6);
	$this->esta_pregunta=substr ( $id, 18,8);
	$this->esta_instancia=substr ( $id, 26,2);
	$this->esta_opcion="000";
	$this->este_encuestado=$encuestado;
	$this->cadena="";
	$this->este_valor="";
	
	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{	
		
	
		/*Determinar los componentes*/
	
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="id_hijo,orden ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."p_compuesta ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_padre=".($this->esta_pregunta/1);
		$this->cadena_sql.=" ORDER BY orden ASC";
		
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro=$this->acceso_db->obtener_registro_db();
		$this->campos_c=$this->acceso_db->obtener_conteo_db();
		//echo $this->cadena_sql."<br>";
		//echo $this->campos_c."<br>";
		if($this->campos_c==0)
		{
			
				/*TO DO mensaje de error */
			
		}
		else
		{
			
				for($this->contador=0;$this->contador<$this->campos_c;$this->contador++)
				{
						/*GUARDA LOS DATOS DE LAS PREGUNTAS QUE COMPONEN*/
						/*$this->guardar_pregunta();*/
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
								$this->este_codigo=$this->rellenar_cadena($this->este_proceso,6);
								$this->este_codigo.=$this->rellenar_cadena($this->este_artefacto,6);
								$this->este_codigo.=$this->rellenar_cadena($this->este_instrumento,6);
								$this->este_codigo.=$this->rellenar_cadena($this->registro_2[0][0],8);
								$this->este_codigo.=$this->rellenar_cadena($this->esta_instancia,2);
								$this->este_codigo.=$this->rellenar_cadena("",3);
								$this->cadena.=$this->primitiva($configuracion,$this->este_codigo,$this->este_encuestado);
								//echo $this->cadena."<br> con la pregunta:".$this->registro_2[0][0]."<br><br>";
								break;
									
									
									break;
							
							case 3:
									/*Pregunta ABSTRACTA
									No tiene que hacer nada*/
									break;
							
							default:
						
								break;
						
										
							
						}
						
						
				
				}
				
				
				return $this->cadena;	
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

function primitiva($configuracion,$id,$encuestado)
{
	
	$this->este_proceso=substr ( $id, 0,6); 
	$this->este_artefacto=substr ( $id, 6,6);
	$this->esta_instrumento=substr ( $id, 12,6);
	$this->esta_pregunta=substr ( $id, 18,8);
	//echo $this->esta_pregunta."<br>";
	$this->esta_instancia=substr ( $id, 26,2);
	$this->esta_opcion="000";		
	$this->id=$this->este_proceso.$this->este_artefacto.$this->esta_instrumento.$this->esta_pregunta.$this->esta_instancia;	
	$this->este_encuestado=$encuestado;
	$this->cadena_guardar="";
	$this->este_valor="";

	$this->acceso_db=new dbms($configuracion);
	$this->enlace=$this->acceso_db->conectar_db();
	if (is_resource($this->enlace))
	{
		/* Determinar el tipo de métrica de la pregunta explorando la tabla ".$configuracion["prefijo"]."p_propiedad*/
		$this->cadena_sql="SELECT ";
		$this->cadena_sql.="valor ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."p_propiedad ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".($this->esta_pregunta/1);
		$this->cadena_sql.=" AND propiedad='id_metrica' ";
		$this->cadena_sql.="LIMIT 1";
		//echo $this->cadena_sql."<br>";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_metrica=$this->acceso_db->obtener_registro_db();
		$this->conteo_metrica=$this->acceso_db->obtener_conteo_db();
		if($this->conteo_metrica>0)
		{
			$this->metrica=$this->registro_metrica[0][0];
		
			/*Si la métrica es de selección múltiple explora la tabla ".$configuracion["prefijo"]."m_multiple en futuras versiones existirá 
			una exploración independiente para cada tipo de métrica*/
			
		
			switch($this->metrica)
			{
				case 1:
				/*Selección múltiple: 
				El método POST envia la información nombre=<valor; si hay dos controles con el mismo nombre envia el 
				dato del último que ha encontrado. Si el control no está seleccionado no  envia nada.
				*/
					$this->cadena_guardar=$this->seleccion_multiple($this->id,$this->este_encuestado,$configuracion);
					return $this->cadena_guardar;
					//echo $this->cadena_guardar."<br>";
					break;
							
				case 2:
				/*Selección única*/
					
					/*echo $this->este_codigo."<br>";*/
					//Si existe un control diligenciado con este cpdigo lo guarda	
					if(isset($_POST[$this->id.$this->esta_opcion]))
					{
						
						$this->este_valor=trim($_POST[$this->id.$this->esta_opcion]);
					
					}
					/*echo $this->cadena_guardar;*/
					break;
							
				case 3:
				/*Comentario múltiples campos*/
					$this->cadena_guardar=$this->campos_multiples($this->id,$this->este_encuestado,$configuracion);
					return $this->cadena_guardar;
					break;
	
				case 4:
					/*  Calificación numérica*/
					if(isset($_POST[$this->id.$this->esta_opcion]))
					{
						$this->este_valor=trim($_POST[$this->id.$this->esta_opcion]);
					}
					break;
					
				case 5:
					/* Calificación porcentual*/
					
					if(isset($_POST[$this->id.$this->esta_opcion]))
					{
						$this->este_valor=trim($_POST[$this->este_codigo]);
				
					}
					break;
					
				case 6:
					/*Dato numérico*/
					if(isset($_POST[$this->id.$this->esta_opcion]))
					{
						$this->este_valor=trim($_POST[$this->id.$this->esta_opcion]);
						
					}
					break;
					
				case 7:
					/* Comentario de una línea*/
				case 8:
					/*Comentario de varias líneas*/
					$this->este_codigo.=$this->rellenar_cadena($this->esta_instancia,2);
					$this->este_codigo.=$this->rellenar_cadena($this->esta_opcion,3);
					
					
					if(isset($_POST[$this->id.$this->esta_opcion]))
					{
						$this->este_valor=trim($_POST[$this->id.$this->esta_opcion]);
						
					}
					break;
	
				default:
				break;
										
								
			}
							
			if(isset($this->este_valor))
			{
				if($this->este_valor!="")
				{
					$this->cadena_guardar="INSERT INTO ";
					$this->cadena_guardar.="".$configuracion["prefijo"]."resultado ";
					$this->cadena_guardar.="(";
					$this->cadena_guardar.="id_proceso, ";
					$this->cadena_guardar.="id_artefacto, ";
					$this->cadena_guardar.="encuestado, ";
					$this->cadena_guardar.="id_instrumento, ";
					$this->cadena_guardar.="id_pregunta,";
					$this->cadena_guardar.="id_instancia, ";
					$this->cadena_guardar.="id_opcion, ";
					$this->cadena_guardar.="valor, ";
					$this->cadena_guardar.="fecha";
					$this->cadena_guardar.=")";
					$this->cadena_guardar.=" VALUES (";
					$this->cadena_guardar.=(substr ( $this->id, 0,6)+0).",";
					$this->cadena_guardar.=(substr ( $this->id, 6,6)+0).",";
					$this->cadena_guardar.="'".$this->este_encuestado."',";
					$this->cadena_guardar.=(substr ( $this->id, 12,6)+0).",";
					$this->cadena_guardar.=(substr ( $this->id, 18,8)+0).",";
					$this->cadena_guardar.=(substr ( $this->id, 26,2)+0).",";
					$this->cadena_guardar.=(substr ( $this->id, 28,3)+0).",";
					$this->cadena_guardar.="'".htmlentities($this->este_valor)."',";
					$this->cadena_guardar.="'".time()."'";
					$this->cadena_guardar.=");;;";								
				}
			}						
			return $this->cadena_guardar;
		}
		
	}
}/* Fin del método primitiva*/



function seleccion_multiple($id,$encuestado,$configuracion)
{

	
	$this->este_proceso=substr ( $id, 0,6); 
	$this->este_artefacto=substr ( $id, 6,6); 
	$this->este_instrumento=substr ( $id, 12,6);
	$this->esta_pregunta=substr ( $id, 18,8);
	$this->esta_instancia=substr ( $id, 26,2);
	
	$this->esta_opcion="000";
	$this->este_encuestado=$encuestado;
	$this->cadena_sql="SELECT ";
	$this->cadena_sql.="id_pregunta, ";
	$this->cadena_sql.="etiqueta, ";
	$this->cadena_sql.="valor, ";
	$this->cadena_sql.="orden ";
	$this->cadena_sql.="FROM ";
	$this->cadena_sql.="".$configuracion["prefijo"]."m_multiple ";
	$this->cadena_sql.="WHERE ";
	$this->cadena_sql.="id_pregunta=".($this->esta_pregunta/1);
	$this->cadena_sql.=" ORDER BY orden ASC";
	
	//echo $this->cadena_sql;
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_multiple=$this->acceso_db->obtener_registro_db();
	$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
	if($this->conteo_multiple>0)
	{
		$this->cadena_guardar="";
		/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
		controlar un poco más el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
		for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
		{
			
			
			$this->este_codigo=$this->rellenar_cadena($this->este_proceso,6);
			$this->este_codigo.=$this->rellenar_cadena($this->este_artefacto,6);
			$this->este_codigo.=$this->rellenar_cadena($this->este_instrumento,6);
			$this->este_codigo.=$this->rellenar_cadena($this->esta_pregunta,8);
			$this->este_codigo.=$this->rellenar_cadena($this->esta_instancia,2);
			$this->este_codigo.=$this->rellenar_cadena($this->registro_multiple[$this->contador_m][2],3);
			
			//echo "Codigo:".$this->este_codigo."<br>";  
							
			if(isset($_POST[$this->este_codigo]))
			{
				$this->este_valor=trim($_POST[$this->este_codigo]);
				//echo "Codigo:".$this->este_codigo."<br>";  
				if(is_numeric($this->este_valor))
				{
					$this->cadena_guardar.="INSERT INTO ";
					$this->cadena_guardar.="".$configuracion["prefijo"]."resultado ";
					$this->cadena_guardar.="(";
					$this->cadena_guardar.="id_proceso, ";
					$this->cadena_guardar.="id_artefacto, ";
					$this->cadena_guardar.="encuestado, ";
					$this->cadena_guardar.="id_instrumento, ";
					$this->cadena_guardar.="id_pregunta,";
					$this->cadena_guardar.="id_instancia, ";
					$this->cadena_guardar.="id_opcion, ";
					$this->cadena_guardar.="valor, ";
					$this->cadena_guardar.="fecha";
					$this->cadena_guardar.=")";
					$this->cadena_guardar.=" VALUES (";
					$this->cadena_guardar.=((substr ( $this->este_codigo, 0,6))/1).",";
					$this->cadena_guardar.=((substr ( $this->este_codigo, 6,6))/1).",";
					$this->cadena_guardar.="'".$this->este_encuestado."',";
					$this->cadena_guardar.=((substr ( $this->este_codigo, 12,6))/1).",";
					$this->cadena_guardar.=((substr ( $this->este_codigo, 18,8))/1).",";
					$this->cadena_guardar.=((substr ( $this->este_codigo, 26,2))/1).",";
					$this->cadena_guardar.=((substr ( $this->este_codigo, 28,3))/1).",";
					$this->cadena_guardar.="'".htmlentities($this->este_valor)."',";
					$this->cadena_guardar.="'".time()."'";
					$this->cadena_guardar.=");;;";	
					//echo $this->cadena_guardar."<br>";
								
				}
			}
			
		}
		
						
	}
  
	return $this->cadena_guardar;  
}





function campos_multiples($id,$encuestado,$configuracion)
{
	$this->este_proceso=substr ( $id, 0,6)+0; 
	$this->este_artefacto=substr ( $id, 6,6)+0; 
	$this->este_instrumento=substr ( $id, 12,6)+0;
	$this->esta_pregunta=substr ( $id, 18,8)+0;
	$this->esta_instancia=substr ( $id, 26,2)+0;
	$this->esta_opcion="000";
		$this->este_encuestado=$encuestado;
		
		$this->cadena_sql="SELECT id_pregunta, ";
		$this->cadena_sql.="etiqueta, ";
		$this->cadena_sql.="valor, ";
		$this->cadena_sql.="orden ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.="".$configuracion["prefijo"]."m_multiple ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="id_pregunta=".$this->esta_pregunta;
		$this->cadena_sql.=" ORDER BY orden ASC";
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro_multiple=$this->acceso_db->obtener_registro_db();
		$this->conteo_multiple=$this->acceso_db->obtener_conteo_db();
		if($this->conteo_multiple>0)
		{
			
			$this->cadena_guardar.="";
			/*Ordenar las diferentes opciones en este caso lo voy hacer todo por clausulas echo para poder
			controlar un poco más el proceso, esto puede suponer una sobrecarga en el servidor. REVISAR*/
			
			for($this->contador_m=0;$this->contador_m<$this->conteo_multiple;$this->contador_m++)
			{
				$this->este_codigo=$this->rellenar_cadena($this->este_proceso,6);
				$this->este_codigo.=$this->rellenar_cadena($this->este_artefacto,6);
				$this->este_codigo.=$this->rellenar_cadena($this->este_instrumento,6);
				$this->este_codigo.=$this->rellenar_cadena($this->esta_pregunta,8);
				$this->este_codigo.=$this->rellenar_cadena($this->esta_instancia,2);
				$this->este_codigo.=$this->rellenar_cadena($this->contador_m,3);
				
				if(isset($_POST[$this->este_codigo]))
				{
					$this->cadena_guardar.="INSERT INTO ";
					$this->cadena_guardar.="".$configuracion["prefijo"]."resultado ";
					$this->cadena_guardar.="(";
					$this->cadena_guardar.="id_proceso, ";
					$this->cadena_guardar.="id_artefacto, ";
					$this->cadena_guardar.="encuestado, ";
					$this->cadena_guardar.="id_instrumento, ";
					$this->cadena_guardar.="id_pregunta,";
					$this->cadena_guardar.="id_instancia, ";
					$this->cadena_guardar.="id_opcion, ";
					$this->cadena_guardar.="valor, ";
					$this->cadena_guardar.="fecha";
					$this->cadena_guardar.=")";
					$this->cadena_guardar.=" VALUES (";
					$this->cadena_guardar.=(substr ( $this->este_codigo, 0,6)+0).",";
					$this->cadena_guardar.=(substr ( $this->este_codigo, 6,6)+0).",";
					$this->cadena_guardar.="'".$this->este_encuestado."',";
					$this->cadena_guardar.=(substr ( $this->este_codigo, 12,6)+0).",";
					$this->cadena_guardar.=(substr ( $this->este_codigo, 18,8)+0).",";
					$this->cadena_guardar.=(substr ( $this->este_codigo, 26,2)+0).",";
					$this->cadena_guardar.=(substr ( $this->este_codigo, 28,3)+0).",";
					$this->cadena_guardar.="'".htmlentities($_POST[$this->este_codigo])."',";
					$this->cadena_guardar.="'".time()."'";
					$this->cadena_guardar.=");;;";	
					
					//echo $this->cadena_guardar;
					//$this->cadena_guardar=addslashes($this->cadena_guardar);
					

				}
				
			}
			
					
		}

		
	return $this->cadena_guardar;  
	
}/* Fin del método campos_multiples*/



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
	$this->cadena_sql.="".$configuracion["prefijo"]."pregunta ";
	$this->cadena_sql.="WHERE ";
	$this->cadena_sql.="id_pregunta=".($id_pregunta/1);
	$this->cadena_sql.=" LIMIT 1";
	//echo $this->cadena_sql."<br>";
	$this->acceso_db->registro_db($this->cadena_sql,0);
	$this->registro_buscar=$this->acceso_db->obtener_registro_db();
	return $this->registro_buscar;

}/* Fin método buscar_pregunta*/



}
?>


