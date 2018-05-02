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
?><?php
/****************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 12 de Mayo de 2007

******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*******************************************************************************/
?>
<?php
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/guardar_pregunta.class.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	/*Rescatar el id_proceso*/
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"id_proceso");
	$proceso=$dato[0][0];
	unset($dato);
	if(isset($_REQUEST["eval_docente"]))
	{
		$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	}
	else
	{
		$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"clave");
		
	}
	$encuestado=$dato[0][0];
	unset($dato);
	
	$dato = $nueva_sesion->rescatar_valor_sesion($configuracion,"id_artefacto");
	$artefacto=$dato[0][0];
	unset($dato);
	$instrumento=desenlace($_POST["instrumento"]);
	$instrumento=substr($instrumento,5,strlen($instrumento)-10);
	/*Determinar las preguntas que componen el instrumento*/
	$cadena_sql="SELECT ";
	$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta,";
	$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.orden,";
	$cadena_sql.="".$configuracion["prefijo"]."pregunta.tipo ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."i_pregunta,";
	$cadena_sql.="".$configuracion["prefijo"]."pregunta ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_instrumento=".$instrumento." ";
	$cadena_sql.="AND ";
	$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.id_pregunta=".$configuracion["prefijo"]."pregunta.id_pregunta";
	$cadena_sql.=" ORDER BY ";
	$cadena_sql.="".$configuracion["prefijo"]."i_pregunta.orden ASC";
	//echo $cadena_sql;
	//exit;
	$acceso_db->registro_db($cadena_sql,0);
	
	$registro_instrumento=$acceso_db->obtener_registro_db();
	$conteo_encabezado=$acceso_db->obtener_conteo_db();
	/*echo $conteo_encabezado."<br>";*/
	$cadena_html="";
	
	if($conteo_encabezado>0)
	{	
		$cadena_html="DELETE ";
		$cadena_html.="FROM ";
		if(!isset($_REQUEST["eval_docente"]))
		{
			$cadena_html.=$configuracion["prefijo"]."resultado ";
		}
		else
		{
			$cadena_html.=$configuracion["prefijo"]."resultado_evaluacion ";
		}	
		$cadena_html.="WHERE ";
		$cadena_html.="encuestado='".$encuestado."' ";
		$cadena_html.="AND ";
		$cadena_html.="id_proceso=".$proceso." ";
		$cadena_html.="AND ";
		$cadena_html.="id_artefacto=".$artefacto." ";
		if(isset($_REQUEST["eval_docente"]))
		{
			$cadena_html.="AND ";
			$cadena_html.="id_eval_actor='".desenlace($_REQUEST["eval_docente"])."' ";
		}
		$cadena_html.="AND ";
		$cadena_html.="id_instrumento=".$instrumento.";;;";
				
		$esta_pregunta=new guardar_pregunta();
		/*La primera instrucción que se guarda es la de borrar todos los registros correspondientes al encuestado en 
		este formulario
		*/
				
		for($contador=0;$contador<$conteo_encabezado;$contador++)
		{
			
			$esta_pregunta->guardar_pregunta();	
			$la_pregunta=$esta_pregunta->rellenar_cadena($registro_instrumento[$contador][0],8);
			
			$esta_instancia=$esta_pregunta->rellenar_cadena("",2);
			$esta_opcion=$esta_pregunta->rellenar_cadena("",3);
			$este_proceso=$esta_pregunta->rellenar_cadena($proceso,6);
			$este_artefacto=$esta_pregunta->rellenar_cadena($artefacto,6);
			$este_instrumento=$esta_pregunta->rellenar_cadena($instrumento,6);
			$id=$este_proceso.$este_artefacto.$este_instrumento.$la_pregunta.$esta_instancia.$esta_opcion;
			if($registro_instrumento[$contador][2]==0)
			{
				/* El código corresponde a una pregunta primitiva ("0")*/
				$cadena_html.=$esta_pregunta->primitiva($configuracion,$id,$encuestado);
			}
			else
			{
				
				/* El código corresponde a una pregunta compuesta ("1")*/
				if($registro_instrumento[$contador][2]==1)
				{
					$cadena_html.=$esta_pregunta->compuesta($configuracion,$id,$encuestado);
					/*echo $cadena_html."<br>";*/
				}
				
			}
	
		}
		
		/*Guardar los datos*/
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sql.class.php");	
		
		$sql=new sql;
		
		$archivo_sql=$sql->rescatar_cadena_sql($cadena_html,"mysql");
		$instrucciones=count($archivo_sql);
			
		for($contador=0;$contador<$instrucciones;$contador++)
		{
				//echo $archivo_sql[$contador]."<br>";
				if(isset($archivo_sql[$contador]))
					{	
						
						$acceso=$acceso_db->ejecutar_acceso_db($archivo_sql[$contador]);
						if(!$acceso)
						{
							if($configuracion["development_mode"]==TRUE)
							{
								echo $archivo_sql[$contador]."<br>";
							}
							else
							{
							
							}
							echo "Error al ingresar los datos.";
							exit();
							
						}
						//echo $archivo_sql[$contador]."<br>";						
					}		
		}
		//exit;
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		$pagina="instrumento";
		$variables="&mensaje=".enlace("message");
		if(isset($_REQUEST["eval_docente"]))
		{
			$variables.="&eval_docente=".$_REQUEST["eval_docente"];
		}
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variables."')</script>";   
			
		
	}
}
?>
