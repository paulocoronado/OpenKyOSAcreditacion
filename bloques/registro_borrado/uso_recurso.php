<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."uso_recurso WHERE id_programa=".$_GET['id_programa']." AND anno=".$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="admin_dir_utilizacion";
?>
			
