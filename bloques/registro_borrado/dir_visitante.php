<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."dir_visitante WHERE id_visitante=".$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;
$pagina="admin_dir_visitante";
?>
			
