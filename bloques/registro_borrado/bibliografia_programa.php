<?php  
$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."bibliografia_programa ";
$borrar_cadena_sql.="WHERE id_recurso=".$_GET['registro'];
$borrar_cadena_sql.=" AND id_programa=".$_GET['programa'];
$borrar_cadena_sql.=" AND anno=".$_GET['anno'];
$borrar_cadena_sql.=" AND semestre=".$_GET['semestre'];
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;

$pagina="editar_recurso_bibliografico";
?>
			
