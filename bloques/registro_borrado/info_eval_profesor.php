<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_evaluacion WHERE id_evaluacion=".$_GET['id_evaluacion'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_profesor";
?>
			
