<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor WHERE identificacion='".$_GET['registro']."'";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_anual WHERE identificacion='".$_GET['registro']."'";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_participacion WHERE identificacion='".$_GET['registro']."'";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_reconocimiento WHERE identificacion='".$_GET['registro']."'";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="admin_profesor";		
?>
			
