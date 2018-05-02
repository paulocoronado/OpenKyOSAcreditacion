<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_participacion WHERE id_participacion=".$_GET['id_participacion'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_profesor";
?>
			
