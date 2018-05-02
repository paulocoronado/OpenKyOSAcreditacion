<?php  
$borrar_cadena_sql="DELETE FROM ";
$borrar_cadena_sql.="".$configuracion["prefijo"]."plan_poblacion ";
$borrar_cadena_sql.="WHERE ";
$borrar_cadena_sql.="anno='".$_GET['anno']."' ";
$borrar_cadena_sql.="AND ";
$borrar_cadena_sql.="periodo='".$_GET['periodo']."' ";
$borrar_cadena_sql.="AND ";
$borrar_cadena_sql.="id_programa='".$_GET['programa']."' ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);
//echo $borrar_cadena_sql;
$borrar_cadena_sql="DELETE FROM ";
$borrar_cadena_sql.="".$configuracion["prefijo"]."plan_duracion ";
$borrar_cadena_sql.="WHERE ";
$borrar_cadena_sql.="anno='".$_GET['anno']."' ";
$borrar_cadena_sql.="AND ";
$borrar_cadena_sql.="periodo='".$_GET['periodo']."' ";
$borrar_cadena_sql.="AND ";
$borrar_cadena_sql.="id_programa='".$_GET['programa']."' ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql);

$pagina="admin_plan_poblacion";		
?>
			
