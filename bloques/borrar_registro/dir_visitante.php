<?php  
$borrar_nombre= " ".$_GET['nombre']." ";	

$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('visitante_borrado');
$opciones.='&opcion=dir_visitante';
$opciones.='&accion=1';
$opciones.='&registro='.$_GET["registro"];
$opciones.='&usuario='.$_GET["usuario"];
$opciones.='">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_dir_visitante');
$opciones.='&usuario='.$_GET["usuario"].'">No</a><br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
