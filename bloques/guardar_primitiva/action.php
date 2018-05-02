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
  
registro.action.php 

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
* @description  Action de registro de usuarios
* @usage        
*****************************************************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

/*Insertar los campos correspondientes de las tablas de borrador en las tablas definitivas*/
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion = $nueva_sesion->numero_sesion();
		$cadena_2=$nueva_sesion->rescatar_valor_sesion($configuracion,"primitiva_2");
		$cadena_2A=$nueva_sesion->rescatar_valor_sesion($configuracion,"primitiva_2A");
		
		$cadena_final=$cadena_2[0][0].$cadena_2A[0][0];
		
		
/*Rescatar el valor máximo que existe en la base de datos id_pregunta*/		
$cadena_sql="SELECT ";
$cadena_sql.="MAX(";
$cadena_sql.="id_pregunta";
$cadena_sql.=") ";
$cadena_sql.="FROM ";
$cadena_sql.=$configuracion["prefijo"]."pregunta";
$acceso_db->registro_db($cadena_sql,0);
$registro=$acceso_db->obtener_registro_db();
$campos=$acceso_db->obtener_conteo_db();
if($campos==0){
	
	$id_pregunta_max=1;

}
else
{
	
	$id_pregunta_max=($registro[0][0]/1)+1;
	
}


/* Crear una matriz con cada una de las clausulas SQL provenientes de las cadena HTML */
$pregunta=$id_pregunta_max;


include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sql.class.php");	

$aguja="POSICION1";
$cadena_reemplazo=$id_pregunta_max;


$cadena_final = str_replace($aguja, $cadena_reemplazo, $cadena_final);



$sql=new sql();
$matriz=$sql->rescatar_cadena_sql($cadena_final,"mysql");

/* Ejecutar la clausulas sql*/


reset ($matriz);
while (list ($clave, $val) = each ($matriz))
{
	echo "$clave => $val<br>";
	$resultado=$acceso_db->ejecutar_acceso_db($val);
	if($resultado==FALSE)
	{
			$error["encabezado"]="ERROR AL GUARDAR EL REGISTRO";
			$error["cuerpo"]="Debido a un error interno ha sido imposible guardar la pregunta.<br><br>";
			$error["cuerpo"].="Esto posiblemente se deba a que no ingres&oacute; los valores correctos o faltaron datos ";
			$error["cuerpo"].="obligatorios.<br><br>Por favor regrese al formulario y corrija los datos de acceso.<br>";
			include_once($configuracion["raiz_documento"].$configuracion["incluir"]."/error.php");		
			include_once($configuracion["raiz_documento"].$configuracion["encabezado"]."/footerpregunta.inc.php");
			exit();
		
	}

}

$acceso_db->vaciar_temporales($configuracion,$esta_sesion);

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

}
	
	
}
?>
