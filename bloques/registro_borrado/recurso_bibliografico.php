<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."recurso_bibliografico WHERE id_recurso=".$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."bibliogrqafia_programa WHERE id_recurso=".$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);				
$pagina="admin_recurso_bibliografico";
?>
			
