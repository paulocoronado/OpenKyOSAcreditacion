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
registro.action.php 

Paulo Cesar Coronado
Copyright (C) 2004-2007

Última revisión 22 de Octubre de 2007

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Action de registro de usuarios
* @usage        
******************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");


$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{

	$cadena_sql="";
	//El número de pregunta viene en la variable $_REQUEST["primitiva"]
	// El número de opciones de cada pregunta viene en la variable $_REQUEST["primitiva".$contador]
	
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$cadena_1 = $nueva_sesion->rescatar_valor_sesion($configuracion,"primitiva_1");
	$cadena_2=$nueva_sesion->rescatar_valor_sesion($configuracion,"primitiva_2");
	$esta_sesion=$nueva_sesion->numero_sesion();	

	if(isset($_REQUEST['metrica']))
	{
			
		$metrica=$_REQUEST['metrica'];
		$id_pregunta=$_REQUEST['id_primitiva'];
		
		$acceso_db->vaciar_temporales($configuracion,$esta_sesion);
		$cadenas=procesar_metrica($configuracion,$metrica,$esta_sesion);
		
		
		/*Se debe colocar addslashes porque de otra forma el servidor mysql lo interpretaría como clausulas SQL*/
		
		/*Para temporal*/
		$nueva_sesion->guardar_valor_sesion($configuracion,"primitiva_1A",addslashes($cadenas[0]),$esta_sesion);		
		
		/*Para definitivo*/
		$nueva_sesion->guardar_valor_sesion($configuracion,"primitiva_2A",addslashes($cadenas[1]),$esta_sesion);		
		
		/*Para guardar los datos temporales se concatenan las clausulas correspondientes*/
		$cadena_1[0][0].=$cadenas[0];
	}
	else
	{
		if(isset($_REQUEST["id_primitiva"]))
		{
			$id_pregunta=$_REQUEST['id_primitiva'];		
		
		}
	
	
	
	}
				
	$resultado=procesar_sql($configuracion,$cadena_1[0][0],$id_pregunta,$acceso_db);
	
	if($resultado==TRUE)
	{
		redirigir($configuracion,$id_pregunta);			
	}
	
	
	

}

/****************************************************************************************
*				Funciones						*
****************************************************************************************/

function procesar_sql($configuracion,$cadena_1,$id_pregunta,$acceso_db)
{
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sql.class.php");	
	
	$aguja="POSICION1";
	$cadena_reemplazo=$id_pregunta;
	/*echo "<br><br>Esta es lo que tenemos de primitiva 1:".$cadena_1[0][0];*/
	$cadena_1 = str_replace($aguja, $cadena_reemplazo, $cadena_1);
	$sql=new sql();
	$matriz=$sql->rescatar_cadena_sql($cadena_1,"mysql");
	
	/* Ejecutar la clausulas sql*/
	
	reset ($matriz);
	while (list ($clave, $val) = each ($matriz))
	{
		echo "$clave => $val<br>";
		
		$resultado=$acceso_db->ejecutar_acceso_db($val);
		if($resultado==FALSE)
		{
				$cuerpo="ERROR AL GUARDAR EL REGISTRO<br>";
				$cuerpo.="Debido a un error interno ha sido imposible guardar la pregunta.<br><br>";
				$cuerpo.="Esto posiblemente se deba a que no ingres&oacute; los valores correctos o faltaron datos ";
				$cuerpo.="obligatorios.<br><br>Por favor regrese al formulario y corrija los datos de acceso.<br>";
				echo $cuerpo;
				return FALSE;
			
		}
	
	}
	
	return TRUE;
	//exit;


}

function procesar_metrica($configuracion,$metrica,$esta_sesion)
{
	$cadena_sql="";
	$cadena_sql_1="";
	switch($metrica)
	{
		case 1:
		case 2:
		case 3:
			$total=$_REQUEST["opcion"];
			for($opcion=0;$opcion<$total;$opcion++)
			{
			
				$el_valor=htmlentities($_REQUEST["valor_".$opcion]);
				$la_etiqueta=htmlentities($_REQUEST["etiqueta_".$opcion]);
				$cadena_sql.="INSERT INTO ";
				$cadena_sql.=$configuracion["prefijo"]."multiple_borrador ";
				$cadena_sql.="( ";
				$cadena_sql.="id_pregunta, ";
				$cadena_sql.="etiqueta, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="orden, ";
				$cadena_sql.="id_sesion ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="( ";
				$cadena_sql.="POSICION1, ";
				$cadena_sql.="'".$la_etiqueta."', ";
				$cadena_sql.="'".$el_valor."', ";
				$cadena_sql.="'".$_REQUEST["orden_".$opcion]."', ";
				$cadena_sql.="'".$esta_sesion."' ";
				$cadena_sql.=")";
				$cadena_sql.=";;;";
				
				$cadena_sql_1.="INSERT INTO ";
				$cadena_sql_1.=$configuracion["prefijo"]."m_multiple ";
				$cadena_sql_1.="( ";
				$cadena_sql_1.="id_pregunta, ";
				$cadena_sql_1.="etiqueta, ";
				$cadena_sql_1.="valor, ";
				$cadena_sql_1.="orden ";
				$cadena_sql_1.=") ";
				$cadena_sql_1.="VALUES ";
				$cadena_sql_1.="( ";
				$cadena_sql_1.="POSICION1, ";
				$cadena_sql_1.="'".$la_etiqueta."', ";
				$cadena_sql_1.="'".$el_valor."', ";
				$cadena_sql_1.="'".$_REQUEST["orden_".$opcion]."' ";
				$cadena_sql_1.=")";
				$cadena_sql_1.=";;;";
			
			}
			
			break;
		
		case 4:
			$cadena = sql_propiedad($configuracion,"inferior", $_REQUEST["inferior"], $esta_sesion);
			$cadena_sql.=$cadena[0];
			$cadena_sql_1.=$cadena[1];
			
			
			
			
			$cadena = sql_propiedad($configuracion,"superior", $_REQUEST["superior"], $esta_sesion);
			$cadena_sql.=$cadena[0];
			$cadena_sql_1.=$cadena[1];
			
			if(isset($_REQUEST["entero"]))
			{
				$cadena = sql_propiedad($configuracion,"entero", "1", $esta_sesion);
				$cadena_sql.=$cadena[0];
				$cadena_sql_1.=$cadena[1];
			}
			
			break;
		
		default:
		break;
	
	}
	
	$cadenas[0]=$cadena_sql;
	$cadenas[1]=$cadena_sql_1;
	return $cadenas;
}

function redirigir($configuracion, $id_pregunta,$tipo="")
{
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	
	unset($_REQUEST['action']);
	$pagina="guardar_primitiva";
	$variable="";
	$variable.="&id_primitiva=".$id_pregunta;
	
	echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
}

function sql_propiedad($configuracion, $propiedad, $valor, $esta_sesion)
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
	$cadena[0].="POSICION1, ";
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
	$cadena[1].="POSICION1, ";
	$cadena[1].="'".$propiedad."' , ";
	$cadena[1].="'".$valor."' ";
	$cadena[1].=")";
	$cadena[1].=";;;";
	
	return $cadena;

}
	
?>
