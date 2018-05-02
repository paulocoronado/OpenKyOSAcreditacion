<?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/subir_archivo.class.php");
$borrar_acceso_db=new dbms($configuracion);
$borrar_enlace=$borrar_acceso_db->conectar_db();
if (is_resource($borrar_enlace))
{
	$borrar_cadena_sql="SELECT ";
	$borrar_cadena_sql.="nombre_interno ";
	$borrar_cadena_sql.="FROM ";
	$borrar_cadena_sql.="".$configuracion["prefijo"]."informe ";
	$borrar_cadena_sql.="WHERE ";
	$borrar_cadena_sql.="id_informe='".$_GET["registro"]."' ";
	$borrar_cadena_sql.="LIMIT 1";
	//echo $borrar_cadena_sql;
	$borrar_acceso_db->registro_db($borrar_cadena_sql,0);
	$borrar_registro=$borrar_acceso_db->obtener_registro_db();
	$borrar_campos=$borrar_acceso_db->obtener_conteo_db();
	if($borrar_campos>0)
	{
		$borrar_nombre=$borrar_registro[0][0];
		
	}
	else
	{
	
	}
}
else
{
//ERROR AL INGRESAR A LA BD

}
$subir = new subir_archivo();
$subir->directorio_carga= $configuracion['raiz_documento']."/documento/";
$subir->eliminar_archivo($borrar_nombre);


$borrar_cadena_sql="DELETE FROM ".$configuracion["prefijo"]."informe ";
$borrar_cadena_sql.="WHERE ";
$borrar_cadena_sql.="id_informe=".$_GET['registro']." ";
$borrar_cadena_sql.="LIMIT 1 ";
$borrar_acceso_db->ejecutar_acceso_db($borrar_cadena_sql); 



$pagina="informe_indicador";			
?>
			
