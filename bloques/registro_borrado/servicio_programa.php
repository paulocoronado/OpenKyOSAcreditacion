<?php  
$cadena_sql='DELETE FROM aplicativo_servicio_programa ';
$cadena_sql.='WHERE id_servicio='.$_GET['registro'];
$cadena_sql.=' AND id_programa='.$_GET['programa'];
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);
//echo $cadena_sql;
$pagina="editar_bienestar_servicio";
?>
			
