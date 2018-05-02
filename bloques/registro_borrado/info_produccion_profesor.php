<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_produccion WHERE id_profesor_produccion=".$_GET['id_profesor_produccion'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_iioc_profesor";
?>
			
