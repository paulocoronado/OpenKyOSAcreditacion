<?php  
$cadena_sql='DELETE FROM aplicativo_documento ';
$cadena_sql.='WHERE id_documento='.$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);

$cadena_sql='DELETE FROM aplicativo_edu ';
$cadena_sql.='WHERE id_documento='.$_GET['registro'];
$borrar_acceso_db->ejecutar_acceso_db($cadena_sql);
//echo $cadena_sql;
$pagina="matriz_edu";
?>
			
