<?php 
//Rescatar el usuario que esta registrado
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		$el_usuario=$registro[0][0];
	}
	
	//Rescatar los modulos especiales a los que puede acceder 
	
	$cadena_sql="SELECT ".$configuracion["prefijo"]."pagina.nombre ";
	$cadena_sql.="FROM ".$configuracion["prefijo"]."usuario_subsistema, ".$configuracion["prefijo"]."pagina,".$configuracion["prefijo"]."subsistema ";
	$cadena_sql.="WHERE ".$configuracion["prefijo"]."usuario_subsistema.id_usuario = '".$el_usuario."' ";
	$cadena_sql.="AND ".$configuracion["prefijo"]."usuario_subsistema.id_subsistema=".$configuracion["prefijo"]."subsistema.id_subsistema ";
	$cadena_sql.="AND ".$configuracion["prefijo"]."pagina.id_pagina = ".$configuracion["prefijo"]."subsistema.id_pagina LIMIT 1";
	//echo $cadena_sql;
	//exit;
	if($base->registro_db($cadena_sql,0))
	{
		//Obtener el registro con el resultado de la busqueda			
		$registro=$base->obtener_registro_db();
		//Obtener el total de registros devueltos por la consulta
		$campos=$base->obtener_conteo_db();
		if($campos>0)
		{
			$pagina=$registro[0][0];
			echo $pagina;
			unset($_GET['action']);
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."&usuario=".$el_usuario."')</script>";   
		}
		else
		{
			Echo "Imposible realizar la acci&oacute;n solicitada. Por favor int&eacute;ntelo m&aacute;s tarde.";
		}
	}
}
?>
