<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."dir_proyecto WHERE id_proyecto=".$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."proyecto_profesor WHERE id_proyecto=".$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);				
$pagina="admin_dir_proyecto";
?>
			
