<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."criterio_edu WHERE id_criterio=".$_GET['registro'];
$borrar_cadena_sql.=" LIMIT 1 ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql); 
$pagina="admin_criterio";			
?>
			
