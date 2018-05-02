<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."evidencia_edu WHERE id_evidencia=".$_GET['evidencia'];
$borrar_cadena_sql.=" LIMIT 1 ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql); 
$pagina="admin_evidencias_edu";			
?>
			
