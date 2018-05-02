<?php  
$borrar_acceso_db=new dbms($configuracion);
$borrar_enlace=$borrar_acceso_db->conectar_db();
if (is_resource($borrar_enlace))
{
	$borrar_cadena_sql="SELECT ";
	$borrar_cadena_sql.="nombre,apellido ";
	$borrar_cadena_sql.="FROM ";
	$borrar_cadena_sql.="".$configuracion["prefijo"]."registrado ";
	$borrar_cadena_sql.="WHERE ";
	$borrar_cadena_sql.="id_usuario=".$_GET["registro"]." ";
	$borrar_cadena_sql.="LIMIT 1 ";
	$borrar_acceso_db->registro_db($borrar_cadena_sql,0);
	$borrar_registro=$borrar_acceso_db->obtener_registro_db();
	$borrar_campos=$borrar_acceso_db->obtener_conteo_db();
	if($borrar_campos>0)
	{
		$borrar_nombre=$borrar_registro[0][0]." ".$borrar_registro[0][1];
		
	}
	else
	{
		$borrar_nombre="Registro Desconocido";
	}
}
else
{
//ERROR AL INGRESAR A LA BD

}	

//Envia todos los datos que vienen con GET
$variable="";
reset ($_GET);
while (list ($clave, $val) = each ($_GET)) 
{
	if($clave!='page')
	{
		$variable.="&".$clave."=".$val;
		//echo $clave;
	}
	
}
//Opciones
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
$opciones.="<td>\n";
//Si
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('usuario_borrado');
$opciones.=$variable.'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_usuario');
$opciones.=$variable;
$opciones.='">No</a>';
$opciones.='<br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
