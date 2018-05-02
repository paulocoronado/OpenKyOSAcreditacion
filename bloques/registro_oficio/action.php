<?PHP  
$cadena_sql="INSERT INTO oficio "; 
$cadena_sql.="( ";
$cadena_sql.="`id`, ";
$cadena_sql.="`nombre`, ";
$cadena_sql.="`fecha`, ";
$cadena_sql.="`descripcion`, ";
$cadena_sql.="`remitente`, ";
$cadena_sql.="`destinatario`, ";
$cadena_sql.="`consecutivo` ";
$cadena_sql.=") ";
$cadena_sql.="VALUES ";
$cadena_sql.="( ";
$cadena_sql.="NULL, ";
$cadena_sql.="'".$_POST['nombre']."', ";
$cadena_sql.="'".$_POST['fecha']."', ";
$cadena_sql.="'".$_POST['descripcion']."', ";
$cadena_sql.="'".$_POST['remitente']."', ";
$cadena_sql.="'".$_POST['destinatario']."', ";
$cadena_sql.="'".$_POST['consecutivo']."' ";
$cadena_sql.=")";

//Crear una instancia de la clase dbms
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{	
	$acceso_db->ejecutar_acceso_db($cadena_sql);

}

unset($_POST['action']);
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
$pagina="mostrar_oficio";
echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."')</script>";   











?>
