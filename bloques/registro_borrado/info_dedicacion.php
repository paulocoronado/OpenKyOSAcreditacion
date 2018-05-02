<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_dedicacion WHERE id_dedicacion=".$_GET['id_dedicacion'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_dir_profesor";
?>
			
