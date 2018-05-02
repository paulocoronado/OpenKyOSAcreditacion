<?php  
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."egresado WHERE identificacion='".$_GET['registro']."' AND id_programa=".$id_programa;
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."egresado_empleo WHERE identificacion='".$_GET['registro']."' AND id_programa=".$id_programa;
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);				
$pagina="admin_dir_egresado";		
?>
			
