<?php  
$cadena_sql='DELETE FROM aplicativo_grupo_investigacion ';
$cadena_sql.='WHERE id_grupo='.$_GET['registro'];
//echo $cadena_sql.'<br>';
//exit;
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);

$cadena_sql='DELETE FROM aplicativo_reconocimiento_grupo ';
$cadena_sql.='WHERE id_grupo='.$_GET['registro'];
//echo $cadena_sql.'<br>';
//exit;
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);

$cadena_sql='DELETE FROM aplicativo_estado_grupo ';
$cadena_sql.='WHERE id_grupo='.$_GET['registro'];
//echo $cadena_sql.'<br>';
//exit;
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);
$pagina="admin_iioc_grupo";
?>
			
