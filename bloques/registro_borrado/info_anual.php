<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_anual WHERE identificacion='".$_GET['registro']."' AND anno=".$_GET['anno'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_profesor";
?>
			
