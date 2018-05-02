<?PHP  
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
<?PHP  
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
?><?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{

$nueva_sesion=new sesiones($configuracion);
$nueva_sesion->especificar_enlace($enlace);
$esta_sesion=$nueva_sesion->numero_sesion();
unset($nueva_sesion);
}

if(isset($_POST['propietario']))
{
	$propietario=htmlentities($_POST['propietario']);
}
if(isset($_POST['nombre']))
{
	$nombre=htmlentities($_POST['nombre']);
}
if(isset($_POST['comentario']))
{	
	$comentario=htmlentities($_POST['comentario']);
}
if(isset($_POST['encabezado']))
{	
	$encabezado=htmlentities($_POST['encabezado']);
}
if(isset($_POST['instrumento']))
{	
	$instrumento=$_POST['instrumento'];
}
else
{
	$instrumento=1;
}

$cadena_sql= "INSERT INTO ";
$cadena_sql.=$configuracion["prefijo"]."pregunta_borrador ";
$cadena_sql.="( ";
$cadena_sql.="id_pregunta , ";
$cadena_sql.="fecha_creacion, ";
$cadena_sql.="id_usuario, ";
$cadena_sql.="nombre, ";
$cadena_sql.="comentario, ";
$cadena_sql.="tipo, ";
$cadena_sql.="id_sesion, ";
$cadena_sql.="instrumento";
$cadena_sql.=") ";
$cadena_sql.="VALUES ";
$cadena_sql.="(";
$cadena_sql.="POSICION1, ";
$cadena_sql.="'".$_POST['fecha_creacion']."' , ";
$cadena_sql.="'".$propietario."', ";
$cadena_sql.="'".$nombre."', ";
$cadena_sql.="'".$comentario."',";
$cadena_sql.="'0',";
$cadena_sql.="'".$esta_sesion."', ";
$cadena_sql.=$instrumento;
$cadena_sql.=")";
$cadena_sql.=";;;";

$cadena_sql_1= "INSERT INTO ";
$cadena_sql_1.=$configuracion["prefijo"]."pregunta";
$cadena_sql_1.="(";
$cadena_sql_1.=" id_pregunta , ";
$cadena_sql_1.="fecha_creacion, ";
$cadena_sql_1.="id_usuario, ";
$cadena_sql_1.="nombre, ";
$cadena_sql_1.="comentario, ";
$cadena_sql_1.="tipo, ";
$cadena_sql_1.="instrumento";
$cadena_sql_1.=") ";
$cadena_sql_1.="VALUES ";
$cadena_sql_1.="(";
$cadena_sql_1.="POSICION1, ";
$cadena_sql_1.="'".$_POST['fecha_creacion']."' , ";
$cadena_sql_1.="'".$propietario."', ";
$cadena_sql_1.="'".$nombre."',";
$cadena_sql_1.="'".$comentario."',";
$cadena_sql_1.="'0',";
$cadena_sql_1.=$instrumento;
$cadena_sql_1.=")";
$cadena_sql_1.=";;;";

/*Clausula para ingresar las propiedades de las preguntas*/
/*Ingreso de encabezado*/
$cadena_sql.= "INSERT INTO ".$configuracion["prefijo"]."propiedad_borrador ( id_pregunta , propiedad, valor,id_sesion) VALUES (POSICION1, 'encabezado' , '".$encabezado."','".$esta_sesion."');;;";

$cadena_sql_1.= "INSERT INTO ".$configuracion["prefijo"]."p_propiedad( id_pregunta , propiedad, valor) VALUES (POSICION1, 'encabezado' , '".$encabezado."');;;";
		
/*Ingreso de id_metrica*/
if(isset($_POST['metrica']))
{

	$cadena_sql.= "INSERT INTO ".$configuracion["prefijo"]."propiedad_borrador ( id_pregunta , propiedad, valor,id_sesion) VALUES (POSICION1, 'id_metrica' , '".$_POST['metrica']."','".$esta_sesion."');;;";

	$cadena_sql_1.= "INSERT INTO ".$configuracion["prefijo"]."p_propiedad( id_pregunta , propiedad, valor) VALUES (POSICION1, 'id_metrica' , '".$_POST['metrica']."');;;";
}
else
{
	$cuerpo="<b>INFORMACION FALTANTE</b><br>";
	$cuerpo.="Todas las preguntas deben tener una m&eacute;trica. <br>";
	$cuerpo.="Por favor regrese al formulario y corrija la informaci&oacute;n.";
	echo $cuerpo;
	exit();

}
		

if (is_resource($enlace)){
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		
		/*echo addslashes($cadena_sql).'<br><br>';
		echo addslashes($cadena_sql_1).'<br><br>';*/
		
/*		echo $cadena_sql_1 ;*/
		
		$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"primitiva_2",addslashes($cadena_sql_1),$esta_sesion);
		$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"primitiva_1",addslashes($cadena_sql),$esta_sesion);
}		
		
if($resultado==FALSE)
	{
			$cuerpo="ERROR AL GUARDAR EL REGISTRO";
			$cuerpo.="Debido a un error interno ha sido imposible guardar la pregunta.<br><br>";
			$cuerpo.="Por favor recargue al formulario y corrija los datos de acceso<br>";
			echo $cuerpo;
		
		
	}
	else
	{
		
		unset($_POST['action']);
		/*Mostrar el siguiente paso en la creacion de preguntas primitivas*/
		$pagina="registro_metrica_primitiva";
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."&metrica=".$_POST['metrica']."&opcion=".$_POST['opcion']."&id_primitiva=".$_POST['id_primitiva']."')</script>";   
		
				
		
	}	
	
	
?>
