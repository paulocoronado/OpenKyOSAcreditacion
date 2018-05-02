<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."estudiante_info_trabajo WHERE id_trabajo=".$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;
$pagina="admin_dir_trabajo_estudiante";
?>
			
