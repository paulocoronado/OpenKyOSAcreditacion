<?php  
echo "<h3>Eliminando registros del sistema...</h3>";
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."artefacto WHERE id_artefacto='".$_GET['registro']."'";
$resultado=$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."p_artefacto WHERE id_artefacto='".$_GET['registro']."'";
$resultado&=$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."a_instrumento WHERE id_artefacto='".$_GET['registro']."'";
$resultado&=$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);

if($resultado==FALSE)
{
	$error=TRUE;
}
$pagina="comite_artefacto";		
?>
			
