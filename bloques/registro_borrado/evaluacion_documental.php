<?php  
//Rescatar id_usuario
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
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."edu ";
$borrar_cadena_sql.="WHERE ";
$borrar_cadena_sql.="id_usuario=".$el_usuario." ";
$borrar_cadena_sql.="AND id_documento=".$_GET['registro']." ";
$borrar_cadena_sql.="AND fecha='".$_GET['fecha']."' ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;

$pagina="admin_evaluacion_documental";
}	
?>
			
