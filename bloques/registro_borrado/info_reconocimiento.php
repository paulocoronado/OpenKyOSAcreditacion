<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_reconocimiento WHERE id_reconocimiento=".$_GET['id_reconocimiento'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_profesor";
?>
			
