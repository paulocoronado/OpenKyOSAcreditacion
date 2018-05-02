<?php  
$borrar_cadena_sql="UPDATE `".$configuracion["prefijo"]."registrado` ";
$borrar_cadena_sql.="SET `estado` = '2' ";
$borrar_cadena_sql.="WHERE id_usuario=".$_GET['registro'];
$borrar_cadena_sql.=" LIMIT 1 ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."usuario WHERE id_usuario=".$_GET['registro'];
$borrar_cadena_sql.=" LIMIT 1 ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql); 
$pagina="admin_usuario";			
?>
			
