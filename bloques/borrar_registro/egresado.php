<?php  
$borrar_acceso_db=new dbms($configuracion);
$borrar_enlace=$borrar_acceso_db->conectar_db();
if (is_resource($borrar_enlace))
{
	$borrar_cadena_sql="SELECT ";
	$borrar_cadena_sql.="nombre,apellido ";
	$borrar_cadena_sql.="FROM ";
	$borrar_cadena_sql.="".$configuracion["prefijo"]."egresado ";
	$borrar_cadena_sql.="WHERE ";
	$borrar_cadena_sql.="identificacion='".$_GET["registro"]."' ";
	$borrar_cadena_sql.="LIMIT 1";
	//echo $borrar_cadena_sql;
	$borrar_acceso_db->registro_db($borrar_cadena_sql,0);
	$borrar_registro=$borrar_acceso_db->obtener_registro_db();
	$borrar_campos=$borrar_acceso_db->obtener_conteo_db();
	if($borrar_campos>0)
	{
		$borrar_nombre=$borrar_registro[0][0]." ".$borrar_registro[0][1];
		
	}
	else
	{
	
	}
}
else
{
//ERROR AL INGRESAR A LA BD

}
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('egresado_borrado');
$opciones.='&opcion=egresado';
$opciones.='&accion=1';
$opciones.='&registro='.$_GET["registro"];
$opciones.='&usuario='.$_GET["usuario"];
$opciones.='">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_dir_egresado');
$opciones.='&usuario='.$_GET["usuario"];
$opciones.='">No</a>'; 	
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
