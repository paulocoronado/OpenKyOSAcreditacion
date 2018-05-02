<?php  
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."profesor_info_asignatura WHERE asignatura='".$_GET['nombre']."' AND id_programa=".$id_programa." AND identificacion='".$_GET['registro']."'";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$pagina="editar_dir_profesor";
?>
			
