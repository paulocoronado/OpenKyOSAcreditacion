<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."egresado_empleo WHERE id_empleo=".$_GET['id_empleo'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_egresado";
?>
			
