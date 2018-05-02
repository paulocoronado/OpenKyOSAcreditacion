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

Última revisión 6 de Marzo de 2006

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*******************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pregunta.class.php");
/*
foreach ($_REQUEST as $key => $value) 
{
echo $key."=>".$value."<br>";

}
*/
/*
if(isset($_POST["guardar"]))
{
	echo "la variable existe";
	exit;
}
else
{
	echo "la variable no existe";
	exit;
}
*/
if(isset($_POST["guardar"]))
{
	$contador_compuesta=0;
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	
	if (is_resource($enlace))
	{
		$formulario=new pregunta();
		$identificador=$formulario->identificador($configuracion);
		
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
		
		unset($nueva_sesion);
		
			
		$el_nombre=htmlentities($_POST['nombre_principal']);
		$el_comentario=htmlentities($_POST['comentario_principal']);
		if(!isset($_POST['instrumento']))
		{
			$el_instrumento='1';
		}
		else
		{
			$el_instrumento=$_POST['instrumento'];
		}
		
		$cadena_sql_1="INSERT INTO ";
		$cadena_sql_1.=$configuracion["prefijo"]."pregunta_borrador ";
		$cadena_sql_1.="( ";
		$cadena_sql_1.="id_pregunta , ";
		$cadena_sql_1.="fecha_creacion, ";
		$cadena_sql_1.="id_usuario, ";
		$cadena_sql_1.="nombre, ";
		$cadena_sql_1.="comentario, ";
		$cadena_sql_1.="tipo, ";
		$cadena_sql_1.="id_sesion";
		$cadena_sql_1.=") ";
		$cadena_sql_1.="VALUES ";
		$cadena_sql_1.="(";
		$cadena_sql_1.="POSICION1, ";
		$cadena_sql_1.="'".$_POST['fecha_creacion']."' , ";
		$cadena_sql_1.="'".$_POST['propietario']."',";
		$cadena_sql_1.="'".$el_nombre."',";
		$cadena_sql_1.="'".$el_comentario."',";
		$cadena_sql_1.="'0',";
		$cadena_sql_1.="'".$esta_sesion."'";
		$cadena_sql_1.=")";
		$cadena_sql_1.=";;;";
		
		
		
		$cadena_sql= "INSERT INTO ";
		$cadena_sql.=$configuracion["prefijo"]."pregunta ";
		$cadena_sql.="(";
		$cadena_sql.="id_pregunta , ";
		$cadena_sql.="fecha_creacion, ";
		$cadena_sql.="id_usuario, ";
		$cadena_sql.="nombre,";
		$cadena_sql.="comentario, ";
		$cadena_sql.="tipo,";
		$cadena_sql.="instrumento";
		$cadena_sql.=") ";
		$cadena_sql.="VALUES ";
		$cadena_sql.="(";
		$cadena_sql.="POSICION1, ";
		$cadena_sql.="'".$_POST['fecha_creacion']."' , ";
		$cadena_sql.="'".$_POST['propietario']."',";
		$cadena_sql.="'".$el_nombre."',";
		$cadena_sql.="'".$el_comentario."',";
		$cadena_sql.="'1',";
		$cadena_sql.=$el_instrumento;
		$cadena_sql.=")";
		$cadena_sql.=";;;";
		
		
		
		unset($el_nombre);
		unset($el_comentario);
		
		if(isset($_POST["abstracta"]))
		{
			/**Guardar los datos básicos de la pregunta*/
			$el_nombre=htmlentities($_POST['nombre_abstracta']);
			$el_comentario=htmlentities($_POST['comentario_abstracta']);
		
			$cadena_sql_1.="INSERT INTO ";
			$cadena_sql_1.=$configuracion["prefijo"]."pregunta_borrador ";
			$cadena_sql_1.="(";
			$cadena_sql_1.="id_pregunta , ";
			$cadena_sql_1.="fecha_creacion, ";
			$cadena_sql_1.="id_usuario, ";
			$cadena_sql_1.= "nombre, ";
			$cadena_sql_1.= "comentario, ";
			$cadena_sql_1.= "tipo, ";
			$cadena_sql_1.= "id_sesion ";
			$cadena_sql_1.= ") ";
			$cadena_sql_1.= "VALUES ";
			$cadena_sql_1.= "(";
			$cadena_sql_1.= "ABSTRACTA1, ";
			$cadena_sql_1.= "'".$_POST['fecha_creacion']."' , ";
			$cadena_sql_1.= "'".$_POST['propietario']."',";
			$cadena_sql_1.= "'".$el_nombre."',";
			$cadena_sql_1.= "'".$el_comentario."',";
			$cadena_sql_1.= "'3',";
			$cadena_sql_1.= "'".$esta_sesion."'";
			$cadena_sql_1.= ")";
			$cadena_sql_1.= ";;;";
			
			$cadena_sql.="INSERT INTO ";
			$cadena_sql.=$configuracion["prefijo"]."pregunta ";
			$cadena_sql.="( ";
			$cadena_sql.="id_pregunta , ";
			$cadena_sql.="fecha_creacion, ";
			$cadena_sql.="id_usuario, ";
			$cadena_sql.="nombre, ";
			$cadena_sql.="comentario, ";
			$cadena_sql.="tipo";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES ";
			$cadena_sql.="(";
			$cadena_sql.="ABSTRACTA1, ";
			$cadena_sql.="'".$_POST['fecha_creacion']."' , ";
			$cadena_sql.="'".$_POST['propietario']."',";
			$cadena_sql.="'".$el_nombre."',";
			$cadena_sql.="'".$el_comentario."',";
			$cadena_sql.="'3'";
			$cadena_sql.=")";
			$cadena_sql.=";;;";
			
			/*echo $cadena_sql;*/
			$cadena_sql_1.= "INSERT INTO ";
			$cadena_sql_1.=$configuracion["prefijo"]."compuesta_borrador ";
			$cadena_sql_1.="(";
			$cadena_sql_1.="id_padre,";
			$cadena_sql_1.="id_hijo,";
			$cadena_sql_1.="orden,";
			$cadena_sql_1.="id_sesion";
			$cadena_sql_1.=") ";
			$cadena_sql_1.="VALUES ";
			$cadena_sql_1.="(";
			$cadena_sql_1.="POSICION1,";
			$cadena_sql_1.="ABSTRACTA1,";
			$cadena_sql_1.=$_POST['ubicacion_abstracta'].",";
			$cadena_sql_1.="'".$esta_sesion."'";
			$cadena_sql_1.= ")";
			$cadena_sql_1.= ";;;";
			
			$cadena_sql.= "INSERT INTO ";
			$cadena_sql.=$configuracion["prefijo"]."p_compuesta ";
			$cadena_sql.="(";
			$cadena_sql.="id_padre, ";
			$cadena_sql.="id_hijo, ";
			$cadena_sql.="orden";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES ";
			$cadena_sql.="(";
			$cadena_sql.="POSICION1,";
			$cadena_sql.="ABSTRACTA1,";
			$cadena_sql.=$_POST['ubicacion_abstracta'];
			$cadena_sql.=")";
			$cadena_sql.=";;;";
			
			/*Clausula para ingresar las propiedades de las preguntas*/
			$el_encabezado=htmlentities($_POST['encabezado_abstracta']);
			
			$cadena_sql_1.= "INSERT INTO ";
			$cadena_sql_1.=$configuracion["prefijo"]."propiedad_borrador ";
			$cadena_sql_1.="( ";
			$cadena_sql_1.="id_pregunta , ";
			$cadena_sql_1.="propiedad, ";
			$cadena_sql_1.="valor, ";
			$cadena_sql_1.="id_sesion";
			$cadena_sql_1.=") ";
			$cadena_sql_1.="VALUES ";
			$cadena_sql_1.="(";
			$cadena_sql_1.="ABSTRACTA1, ";
			$cadena_sql_1.="'encabezado' , ";
			$cadena_sql_1.="'".$el_encabezado."',";
			$cadena_sql_1.="'".$esta_sesion."')";
			$cadena_sql_1.=";;;";
			
			
			$cadena_sql.= "INSERT INTO ";
			$cadena_sql.=$configuracion["prefijo"]."p_propiedad ";
			$cadena_sql.="( ";
			$cadena_sql.="id_pregunta , ";
			$cadena_sql.="propiedad, ";
			$cadena_sql.="valor";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES ";
			$cadena_sql.="(";
			$cadena_sql.="ABSTRACTA1, ";
			$cadena_sql.="'encabezado' , ";
			$cadena_sql.="'".$el_encabezado."'";
			$cadena_sql.=")";
			$cadena_sql.=";;;";
		}
	
		if(isset($_POST["asociada"]))
		{
			/*Guardar los datos básicos de las preguntas asociadas*/
			for($contador=0;$contador<$_POST["asociada"];$contador++)
			{
				$el_nombre=htmlentities($_POST['nombre_asociada'.$contador]);
				$el_comentario=htmlentities($_POST['comentario_asociada'.$contador]);
				$cadena_sql_1.="INSERT INTO ";
				$cadena_sql_1.=$configuracion["prefijo"]."pregunta_borrador ";
				$cadena_sql_1.="(";
				$cadena_sql_1.="id_pregunta , ";
				$cadena_sql_1.="fecha_creacion, ";
				$cadena_sql_1.="id_usuario, ";
				$cadena_sql_1.="nombre, ";
				$cadena_sql_1.="comentario, ";
				$cadena_sql_1.="tipo, ";
				$cadena_sql_1.="id_sesion ";
				$cadena_sql_1.=") ";
				$cadena_sql_1.="VALUES ";
				$cadena_sql_1.="(";
				$cadena_sql_1.="ASOCIADA".$contador.", ";				
				$cadena_sql_1.="'".$_POST['fecha_creacion']."' , ";
				$cadena_sql_1.="'".$_POST['propietario']."',";
				$cadena_sql_1.="'".$el_nombre."',";
				$cadena_sql_1.="'".$el_comentario."',";
				$cadena_sql_1.="'2',";
				$cadena_sql_1.="'".$esta_sesion."'";
				$cadena_sql_1.=")";
				$cadena_sql_1.=";;;";
				
				
				$cadena_sql.="INSERT INTO ";
				$cadena_sql.=$configuracion["prefijo"]."pregunta ";
				$cadena_sql.="( ";
				$cadena_sql.="id_pregunta , ";
				$cadena_sql.="fecha_creacion, ";
				$cadena_sql.="id_usuario, ";
				$cadena_sql.="nombre, ";
				$cadena_sql.="comentario, ";
				$cadena_sql.="tipo";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="(";
				$cadena_sql.="ASOCIADA".$contador.", ";
				$cadena_sql.="'".$_POST['fecha_creacion']."' , ";
				$cadena_sql.="'".$_POST['propietario']."',";
				$cadena_sql.="'".$el_nombre."',";
				$cadena_sql.="'".$el_comentario."',";
				$cadena_sql.="'2'";
				$cadena_sql.=")";
				$cadena_sql.=";;;";
				
				$cadena_sql_1.= "INSERT INTO ";
				$cadena_sql_1.=$configuracion["prefijo"]."compuesta_borrador ";
				$cadena_sql_1.="(";
				$cadena_sql_1.="id_padre,";
				$cadena_sql_1.="id_hijo,";
				$cadena_sql_1.="orden,";
				$cadena_sql_1.="id_sesion";
				$cadena_sql_1.=") ";
				$cadena_sql_1.="VALUES ";
				$cadena_sql_1.="(";
				$cadena_sql_1.="POSICION1,";
				$cadena_sql_1.="ASOCIADA".$contador.", ";
				$cadena_sql_1.=$_POST['ubicacion_asociada'.$contador].",";
				$cadena_sql_1.="'".$esta_sesion."'";
				$cadena_sql_1.= ")";
				$cadena_sql_1.= ";;;";
				
				$cadena_sql.= "INSERT INTO ";
				$cadena_sql.=$configuracion["prefijo"]."p_compuesta ";
				$cadena_sql.="(";
				$cadena_sql.="id_padre, ";
				$cadena_sql.="id_hijo, ";
				$cadena_sql.="orden";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="(";
				$cadena_sql.="POSICION1,";
				$cadena_sql.="ASOCIADA".$contador.",";
				$cadena_sql.=$_POST['ubicacion_asociada'.$contador];
				$cadena_sql.=")";
				$cadena_sql.=";;;";
		
				/*Ingreso de encabezado*/
				$el_encabezado=htmlentities($_POST['encabezado_asociada'.$contador]);
								
				$cadena_sql_1.= "INSERT INTO ";
				$cadena_sql_1.=$configuracion["prefijo"]."propiedad_borrador ";
				$cadena_sql_1.="( ";
				$cadena_sql_1.="id_pregunta , ";
				$cadena_sql_1.="propiedad, ";
				$cadena_sql_1.="valor, ";
				$cadena_sql_1.="id_sesion";
				$cadena_sql_1.=") ";
				$cadena_sql_1.="VALUES ";
				$cadena_sql_1.="(";
				$cadena_sql_1.="ASOCIADA".$contador.", ";
				$cadena_sql_1.="'encabezado' , ";
				$cadena_sql_1.="'".$el_encabezado."',";
				$cadena_sql_1.="'".$esta_sesion."')";
				$cadena_sql_1.=";;;";
				
				$cadena_sql.= "INSERT INTO ";
				$cadena_sql.=$configuracion["prefijo"]."p_propiedad ";
				$cadena_sql.="( ";
				$cadena_sql.="id_pregunta , ";
				$cadena_sql.="propiedad, ";
				$cadena_sql.="valor";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="(";
				$cadena_sql.="ASOCIADA".$contador.", ";
				$cadena_sql.="'encabezado' , ";
				$cadena_sql.="'".$el_encabezado."'";
				$cadena_sql.=")";
				$cadena_sql.=";;;";
				
				
				
				
				/*Ingreso de id_metrica*/
				if(isset($_POST['metrica_asociada'.$contador]))
				{
				
					$cadena_sql_1.="INSERT INTO ";
					$cadena_sql_1.=$configuracion["prefijo"]."propiedad_borrador ";
					$cadena_sql_1.="( ";
					$cadena_sql_1.="id_pregunta , ";
					$cadena_sql_1.="propiedad, ";
					$cadena_sql_1.="valor, ";
					$cadena_sql_1.="id_sesion ";
					$cadena_sql_1.=") ";
					$cadena_sql_1.="VALUES ";
					$cadena_sql_1.="(";
					$cadena_sql_1.="ASOCIADA".$contador.", ";
					$cadena_sql_1.="'id_metrica' , ";
					$cadena_sql_1.="'".$_POST['metrica_asociada'.$contador]."', ";
					$cadena_sql_1.="'".$esta_sesion."'";
					$cadena_sql_1.=")";
					$cadena_sql_1.=";;;";
					
					
					$cadena_sql.= "INSERT INTO ";
					$cadena_sql.=$configuracion["prefijo"]."p_propiedad ";
					$cadena_sql.="( ";
					$cadena_sql.="id_pregunta , ";
					$cadena_sql.="propiedad, ";
					$cadena_sql.="valor";
					$cadena_sql.=") ";
					$cadena_sql.="VALUES ";
					$cadena_sql.="(";
					$cadena_sql.="ASOCIADA".$contador.", ";
					$cadena_sql.="'id_metrica' , ";
					$cadena_sql.="'".$_POST['metrica_asociada'.$contador]."'";
					$cadena_sql.=")";
					$cadena_sql.=";;;";
				}
				else
				{
					
					echo $contador;
					$tipo_error=0;
					mensaje_error($tipo_error);
					exit();
				
				}
			
			}
		}
	
	
	/*CREAR UNA VARIABLE DE SESION LLAMADA compuesta_1 para guardar la clausula SQL*/
	
	/*echo $cadena_sql;*/
	
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"compuesta_1",addslashes($cadena_sql),$esta_sesion);
	$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"compuesta_2",addslashes($cadena_sql_1),$esta_sesion);
	
	
	if($resultado==FALSE)
	{
		$error["encabezado"]="ERROR AL GUARDAR EL REGISTRO<br>";
		$error["cuerpo"]="Debido a un error interno ha sido imposible guardar la pregunta compuesta.<br><br>";
		$error["cuerpo"].="Por favor recargue al formulario y corrija los datos de acceso<br>";
		echo $$error["cuerpo"];
		exit();
				
			
	}
	else
	{
		
		$cadena=$formulario->header_opciones($configuracion,'registro_compuesta',$_POST['id_compuesta']);

		/*Rutina principal para determinar cual de las preguntas tiene como métrica 1,2, o 3*/
		$con_opciones=0;

		if(isset($_POST["asociada"]))
		{
			/*Recorrer todas las preguntas para saber que métrica tiene cada una, en el caso de que alguna no presente 
			métrica se considera un error */
			$cadena.="<input type='hidden' name= 'asociada' value='".$_POST["asociada"] ."'>\n";	
			$cadena.="<input type='hidden' name= 'guardar_metrica' value='1'>\n";	
			for($contador=0;$contador<$_POST["asociada"];$contador++)
			{
				if(!isset($_POST["metrica_asociada".$contador]))
				{
						echo $contador;
						mensaje_error();
						exit();
						
				}
				$metrica=$_POST["metrica_asociada".$contador];
				
				/*El el caso de métricas de opciones*/
				switch($metrica)
				{
					case 1:
					case 2:
					case 3:
					/*Se invoca a la función mostrar opciones*/
					$mensaje=$_POST["opciones_asociada".$contador];					
					//echo $mensaje."<br>";
					$cadena.=$formulario->mostrar_opciones("asociada",$contador,$metrica,$configuracion,$mensaje);
					$con_opciones++;
					break;
					
					case 4:
						$mensaje=$_POST["opciones_asociada".$contador];					
						//echo $mensaje."<br>";
						$cadena.=$formulario->formulario_metrica_numerico("asociada",$contador,$metrica,$configuracion,$mensaje);
						$con_opciones++;
					
					break;
				
				
				}
				
				
			}
		}
	
		if($con_opciones==0)
		{
			/*Quiere decir que ninguna de las métricas de las preguntas era de opciones y no se muestra ningún formulario*/
			
			/*¿Como manejamos esto? Incluyendo directamente la funcion guardar_metrica*/
			
			$resultado=guardar_metrica($configuracion);
			unset($_POST['action']);
			$variable="";
			$variable.="&id_compuesta=".$_POST["id_compuesta"];
			$pagina="guardar_compuesta";
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
			
		}
		else
		{
			
			$cadena.=$formulario->footer_opciones();
			echo $cadena;
		}

		}
	}	
}
else
{
	
	if(isset($_POST["guardar_metrica"]))
	{
		$resultado=guardar_metrica($configuracion);
		unset($_POST['action']);
		$variable="";
		$variable.="&id_compuesta=".$_POST["id_compuesta"];
		
		$pagina="guardar_compuesta";
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
	}
	else
	{
		$formulario=new pregunta();
		$identificador=$formulario->identificador($configuracion);
		
		$cadena=$formulario->header_pregunta($configuracion,'registro_compuesta');
		echo $cadena;
		
		/*
		Se usa la variable $componente para manejar los componentes de la pregunta compuesta, esto con el fin de
		lograr un trabajo temporal y acceder los datos solo al final del proceso.
		
		*/
		$componente=1;
		
		$cadena=$formulario->formulario_compuesta($componente++, $identificador["editor"]);
		
		$cadena.="<br>";
		echo $cadena;
		
		$posicion=1;
		if(isset($_POST["abstracta"]))
		{
			$identificador=$formulario->identificador($configuracion);
			$cadena=$formulario->numero_pregunta();
			echo $cadena;
			$cadena=$formulario->formulario_abstracta($configuracion,$componente++,$posicion);
			$posicion++;
			$cadena.="<br>";
			echo $cadena;
		}/*Fin del if que revisa si se tiene pregunta abstracta*/
				
		if(is_numeric($_POST["asociada"]))
		{
			for($contador=0;$contador<$_POST["asociada"];$contador++)
			{
				$identificador=$formulario->identificador($configuracion);
				$cadena=$formulario->numero_pregunta();
				echo $cadena;
				$cadena=$formulario->formulario_primitiva($configuracion,$componente++,$contador,"2",$identificador["editor"],$posicion);
				$posicion++;
				$cadena.="<br>";
				echo $cadena;
			}
		}
		
		$acceso_db=new dbms($configuracion);
		$enlace=$acceso_db->conectar_db();
		
		if (is_resource($enlace))
		{
			$nueva_sesion=new sesiones($configuracion);
			$nueva_sesion->especificar_enlace($enlace);
			$esta_sesion=$nueva_sesion->numero_sesion();
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"compuesta_total",($componente-1),$esta_sesion);
		
		}
		
		if($resultado==FALSE)
		{
					$error["encabezado"]="ERROR AL GUARDAR EL REGISTRO";
					$error["cuerpo"]="Debido a un error interno ha sido imposible guardar la pregunta compuesta.<br><br>";
					$error["cuerpo"].="Por favor recargue al formulario y corrija los datos de acceso<br>";
					
					
				
				
		}
		else
		{
					$cadena=$formulario->footer_pregunta();
					echo $cadena;
		}
	
	}
}
		
function guardar_metrica($configuracion)
{
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
	$nueva_sesion=new sesiones($configuracion);
	$esta_sesion=$nueva_sesion->numero_sesion();
	
	$cadena_sql="";
	$cadena_sql_1="";
	if(isset($_POST["asociada"]))
	{
	/*El número de preguntas viene en la variable $_POST["asociada"] */	
	/* El número de opciones de cada pregunta viene en la variable $_POST["asociada".$contador]*/	
		for($contador=0;$contador<$_POST["asociada"];$contador++)
		{
			if(isset($_POST['metrica_asociada'.$contador]))
			{
							
				/*La tabla ".$configuracion["prefijo"]."m_multiple guarda la información de las propiedades de cada opción en las preguntas
				de tipo 1,2 o 3
				*/	
				$metrica=$_POST['metrica_asociada'.$contador];

				/*Invalida el campo de opciones_asociada en las métricas en donde no tiene razón de ser*/
				if($metrica==1||$metrica==2||$metrica==3)
				{
					$total=$_POST["opciones_asociada".$contador];
					for($opcion=0;$opcion<$total;$opcion++)
					{
						$la_etiqueta=htmlentities($_POST["etiqueta_asociada".$contador.$opcion]);
						$el_valor=htmlentities($_POST["valor_asociada".$contador.$opcion]);
						$cadena_sql_1.="INSERT INTO ".$configuracion["prefijo"]."multiple_borrador(id_pregunta,etiqueta,valor,orden,id_sesion) VALUES(ASOCIADA".$contador.",'".$la_etiqueta."','".$el_valor."','".$_POST["orden_asociada".$contador.$opcion]."','".$esta_sesion."');;;";
						$cadena_sql.="INSERT INTO ".$configuracion["prefijo"]."m_multiple(id_pregunta,etiqueta,valor,orden) VALUES(ASOCIADA".$contador.",'".$la_etiqueta."','".$el_valor."','".$_POST["orden_asociada".$contador.$opcion]."');;;";
					}
				}
				else
				{
					if($metrica==4)
					{
						$cadena = sql_propiedad($configuracion,"inferior", $_REQUEST["inferior_asociada".$contador], $esta_sesion,$contador);
						$cadena_sql.=$cadena[1];
						$cadena_sql_1.=$cadena[0];
						
						$cadena = sql_propiedad($configuracion,"superior", $_REQUEST["superior_asociada".$contador], $esta_sesion,$contador);
						$cadena_sql.=$cadena[1];
						$cadena_sql_1.=$cadena[0];
						
						if(isset($_REQUEST["entero_asociada".$contador]))
						{
							$cadena = sql_propiedad($configuracion,"entero", "1", $esta_sesion, $contador);
							$cadena_sql.=$cadena[1];
							$cadena_sql_1.=$cadena[0];
						}
					}
				}
			}
		}
	
	}
	
	/*Vaciar los trabajos anteriores basados en esta sesión*/
	$acceso_db->vaciar_temporales($configuracion,$esta_sesion);
	/*Procesar las cadenas HTML del paso 1 y la actual para guardar los datos de las preguntas*/
	/*Original*/
	$cadena_1 = $nueva_sesion->rescatar_valor_sesion($configuracion,"compuesta_1");
	/*echo $cadena_1[0][0];*/
		
	/*Borrador*/
	$cadena_2 = $nueva_sesion->rescatar_valor_sesion($configuracion,"compuesta_2");
		
	$componentes = $nueva_sesion->rescatar_valor_sesion($configuracion,"compuesta_total");
	
	/*Rescatar el valor máximo que existe en la base de datos id_pregunta*/		
	$esta_cadena="SELECT ";
	$esta_cadena.="MAX";
	$esta_cadena.="(";
	$esta_cadena.="id_pregunta";
	$esta_cadena.=") ";
	$esta_cadena.="FROM ";
	$esta_cadena.=$configuracion["prefijo"]."pregunta_borrador ";
	$esta_cadena.="WHERE ";
	$esta_cadena.="id_sesion='".$esta_sesion."'";
	
	$acceso_db->registro_db($esta_cadena,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=count($registro);
	if($campos==0)
	{
		$id_pregunta_max=1;
	}
	else
	{
		$id_pregunta_max=($registro[0][0]*1)+1;
	}

/* Crear una matriz con cada una de las clausulas SQL provenientes de las cadena HTML */
	$pregunta=$id_pregunta_max;
	$cadena_2[0][0].=$cadena_sql_1;
	$cadena_1[0][0].=$cadena_sql;
			
	/*addslashes, addslashes*/
	$resultados=$nueva_sesion->guardar_valor_sesion($configuracion,"compuesta_1",addslashes($cadena_1[0][0]),$esta_sesion);
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sql.class.php");	
	
	/*Para la pregunta padre*/
	$aguja="POSICION1";			
	$cadena_reemplazo=$id_pregunta_max;			
	$cadena_2[0][0] = str_replace($aguja, $cadena_reemplazo, $cadena_2[0][0]);

	$id_pregunta_max++;
	
	/*Para la pregunta abstracta, si existe*/
	$aguja="ABSTRACTA1";			
	if(strpos ($cadena_2[0][0], $aguja)!==FALSE)
	{ 
		
		$cadena_reemplazo=$id_pregunta_max;			
		$cadena_2[0][0] = str_replace($aguja, $cadena_reemplazo, $cadena_2[0][0]);
		$id_pregunta_max++;
	}
			
	/*Para las preguntas componentes*/
	for($contador=0;$contador<$componentes[0][0];$contador++)
	{
		/*echo $cadena_2[0][0];*/
		$aguja="ASOCIADA".$contador;
			
		$cadena_reemplazo=$id_pregunta_max;
		if(strpos ($cadena_2[0][0], $aguja)!==FALSE)
		{ 
			
			$cadena_reemplazo=$id_pregunta_max;			
			$cadena_2[0][0] = str_replace($aguja, $cadena_reemplazo, $cadena_2[0][0]);
			$id_pregunta_max++;
		}
	}
	$sql=new sql();
	$matriz=$sql->rescatar_cadena_sql($cadena_2[0][0],"mysql");
	
	/* Ejecutar la clausulas sql*/
	
	reset ($matriz);
	while (list ($clave, $val) = each ($matriz))
	{
		echo "$clave => $val<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($val,0);
		if($resultado==FALSE)
		{
				$tipo_error=1;
				mensaje_error($tipo_error);
				exit();
			
		}
		

	}
	}
	//exit();
	return $resultado;
}		
	
function sql_propiedad($configuracion, $propiedad, $valor, $esta_sesion, $contador)
{
	$cadena[0]="INSERT INTO ";
	$cadena[0].=$configuracion["prefijo"]."propiedad_borrador ";
	$cadena[0].="( ";
	$cadena[0].="id_pregunta , ";
	$cadena[0].="propiedad, ";
	$cadena[0].="valor, ";
	$cadena[0].="id_sesion ";
	$cadena[0].=") ";
	$cadena[0].="VALUES ";
	$cadena[0].="( ";
	$cadena[0].="ASOCIADA".$contador.",";
	$cadena[0].="'".$propiedad."' , ";
	$cadena[0].="'".$valor."', ";
	$cadena[0].="'".$esta_sesion."' ";
	$cadena[0].=")";
	$cadena[0].=";;;";
	
	$cadena[1]="INSERT INTO ";
	$cadena[1].=$configuracion["prefijo"]."p_propiedad ";
	$cadena[1].="( ";
	$cadena[1].="id_pregunta , ";
	$cadena[1].="propiedad, ";
	$cadena[1].="valor ";
	$cadena[1].=") ";
	$cadena[1].="VALUES ";
	$cadena[1].="( ";
	$cadena[1].="ASOCIADA".$contador.",";
	$cadena[1].="'".$propiedad."' , ";
	$cadena[1].="'".$valor."' ";
	$cadena[1].=")";
	$cadena[1].=";;;";
	
	//echo $cadena[0]."<hr>";
	//echo $cadena[1]."<hr>";
	return $cadena;

}
	
function mensaje_error($tipo_error)
	{
		switch($tipo_error)
		{
			case 0:
	?><table class="bloquelateral" cellpadding="0" cellspacing="0">
		<tbody>
			<tr class="bloquelateralencabezado">
				<td valign="middle" align="right" width="10%">
				<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
				</td>
				<td valign="middle" align="left" style="background-color: rgb(221, 221, 221);font-weight: bold; font-family: Helvetica,Arial,sans-serif; color: rgb(0, 0, 0);">
				Informaci&oacute;n Faltante
				</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<table border="0" cellpadding="10" cellsapcing="0">
					<tbody>
						<tr class="bloquecentralcuerpo">
						<td>
						Todas las preguntas deben tener asociada una m&eacute;trica. <br><br>Por favor regrese al formulario y corrija la informaci&oacute;n.<br>
						</td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table><?php
			break;
			
			case 1:
			?><table class="bloquelateral" cellpadding="0" cellspacing="0">
		<tbody>
			<tr class="bloquelateralencabezado">
				<td valign="middle" align="right" width="10%">
				<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
				</td>
				<td valign="middle" align="left" style="background-color: rgb(221, 221, 221);font-weight: bold; font-family: Helvetica,Arial,sans-serif; color: rgb(0, 0, 0);">
				Informaci&oacute;n Faltante
				</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<table border="0" cellpadding="10" cellsapcing="0">
					<tbody>
						<tr class="bloquecentralcuerpo">
						<td>
						Todas las preguntas deben tener asociada una m&eacute;trica. <br><br>Por favor regrese al formulario y corrija la informaci&oacute;n.<br>
						</td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table><?php
			break;
		}
	}		
		
?>		
