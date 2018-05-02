<?php  
$cadena_sql='DELETE FROM aplicativo_investigacion_documento ';
$cadena_sql.='WHERE id_documento='.$_GET['id_documento'];
//echo $cadena_sql.'<br>';
//exit;
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);

$cadena_sql='DELETE FROM aplicativo_doc_vigencia ';
$cadena_sql.='WHERE id_documento='.$_GET['id_documento'];
//echo $cadena_sql.'<br>';
//exit;
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);
$pagina="admin_iioc_doc_institucional";
?>
			
