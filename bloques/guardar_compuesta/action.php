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
?>
<?php  

if(isset($_POST["aceptar"]))
{
/*Insertar los campos correspondientes de las tablas de borrador en las tablas definitivas*/
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion = $nueva_sesion->numero_sesion();
		$cadena_2=$nueva_sesion->rescatar_valor_sesion($configuracion,"compuesta_1");
		$componentes=$nueva_sesion->rescatar_valor_sesion($configuracion,"compuesta_total");

		/*Rescatar el valor máximo que existe en la base de datos id_pregunta*/		
		$acceso_db->registro_db('SELECT MAX(id_pregunta) FROM aplicativo_pregunta',0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=count($registro);
		if($campos==0)
		{
			
			$id_pregunta_max=1;
		
		}
		else
		{
			$id_pregunta_max=($registro[0][0]/1)+1;
		}


		/* Crear una matriz con cada una de las clausulas SQL provenientes de las cadena HTML */
		$pregunta=$id_pregunta_max;
		
		
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sql.class.php");	
					
					
		/*Para la pregunta padre*/
		$aguja="POSICION1";			
		$cadena_reemplazo=$id_pregunta_max;			
		$cadena_2[0][0] = str_replace($aguja, $cadena_reemplazo, $cadena_2[0][0]);
		
		$id_pregunta_max=($id_pregunta_max*1)+1;
		
		/*Para la pregunta abstracta, si existe*/
		$aguja="ABSTRACTA1";			
		if(strpos ($cadena_2[0][0], $aguja)!==FALSE)
		{ 
			
			$cadena_reemplazo=$id_pregunta_max;			
			$cadena_2[0][0] = str_replace($aguja, $cadena_reemplazo, $cadena_2[0][0]);
			$id_pregunta_max=($id_pregunta_max*1)+1;
		}
		
		/*Para las preguntas componentes*/
		for($contador=0;$contador<$componentes[0][0];$contador++)
		{
				//echo $cadena_2[0][0]."<br>";
				//echo $id_pregunta_max."<br>";
				$aguja="ASOCIADA".$contador.",";
				
				//echo $aguja."<br>";
				
				if(strpos ($cadena_2[0][0], $aguja)!==FALSE)
					{ 
						
						$cadena_reemplazo=$id_pregunta_max.",";
									
						$cadena_2[0][0] = str_replace($aguja, $cadena_reemplazo, $cadena_2[0][0]);
						$id_pregunta_max=($id_pregunta_max*1)+1;
					}
					
				
		}
		
		$sql=new sql();
		$matriz=$sql->rescatar_cadena_sql($cadena_2[0][0],"mysql");
		
		/* Ejecutar la clausulas sql*/
		
		
		reset ($matriz);
		while (list ($clave, $val) = each ($matriz))
		{
		//echo "$clave => $val<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($val,0);
			if($resultado==FALSE)
			{
					$error["encabezado"]="ERROR AL GUARDAR EL REGISTRO";
					$error["cuerpo"]="Debido a un error ha sido imposible guardar la pregunta compuesta.<br><br>";
					$error["cuerpo"].="Esto posiblemente se deba a que no ingres&oacute; los valores correctos o faltaron datos ";
					$error["cuerpo"].="obligatorios.<br><br>Por favor regrese al formulario y corrija los datos de acceso.<br>";
					echo $error["encabezado"];
					exit();
				
			}
			
		
		}
		//exit;
		$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."pregunta_borrador ";
		$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."multiple_borrador ";
		$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
		$resultado&=$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."propiedad_borrador ";
		$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
		$resultado&=$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."compuesta_borrador ";
		$cadena_sql.="WHERE id_sesion='".$esta_sesion."'";
		$resultado&=$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		if($resultado!=FALSE)
		{
		
			reset($_POST);
			while(list($clave,$valor)=each($_POST))
			{
				unset($_POST[$clave]);
				
			}
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('comite_pregunta')."&accion=1&hoja=0')</script>"; 
		/*Visualizar la cadena y mostar un enlace al menu principal*/	
			/*Visualizar la cadena y mostar un enlace al menu principal*/				
		
		}
		else
		{

			echo "Imposible guardar la pregunta";
		}

	}
}
else
{

	reset($_POST);
	while(list($clave,$valor)=each($_POST))
	{
		unset($_POST[$clave]);
		
	}
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('comite_pregunta')."&accion=1&hoja=0')</script>"; 


}
?>
