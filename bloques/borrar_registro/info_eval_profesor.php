<?php  
$borrar_acceso_db=new dbms($configuracion);
$borrar_enlace=$borrar_acceso_db->conectar_db();
if (is_resource($borrar_enlace))
{
	$borrar_cadena_sql="SELECT evaluacion,anno FROM ".$configuracion["prefijo"]."profesor_info_evaluacion WHERE id_evaluacion=".$_GET["id_evaluacion"]." LIMIT 1";
	$borrar_acceso_db->registro_db($borrar_cadena_sql,0);
	$borrar_registro=$borrar_acceso_db->obtener_registro_db();
	$borrar_campos=$borrar_acceso_db->obtener_conteo_db();
	if($borrar_campos>0)
	{
		$borrar_nombre=" la calificaci&oacute;n ".$borrar_registro[0][0]." del a&ntilde;o ".$borrar_registro[0][1];
		
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
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('eval_profesor_borrado');
$opciones.='&opcion=info_eval_profesor';
$opciones.='&accion=1';
$opciones.='&id_evaluacion='.$_GET["id_evaluacion"];
$opciones.='&registro='.$_GET['registro'];
$opciones.='">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('editar_profesor');
$opciones.='&registro='.$_GET['registro'].'">No</a><br>'; 
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";

?>
