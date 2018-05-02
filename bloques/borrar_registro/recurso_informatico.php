<?php  
$borrar_nombre= " ".$_GET['nombre']." ";	

$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('recurso_informatico_borrado');
$opciones.='&opcion=recurso_informatico';
$opciones.='&accion=1';
$opciones.='&registro='.$_GET["registro"];
$opciones.='">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_recurso_informatico');
$opciones.='">No</a><br>'; 
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
