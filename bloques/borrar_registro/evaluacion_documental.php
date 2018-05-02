<?php  
$borrar_nombre=" la informaci&oacute;n de evaluaci&oacute;n correspondiente a ".date( "M-d-Y h:i",$_GET['fecha']);

$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
$opciones.="<td>\n";
//Si
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('evaluacion_documental_borrado');
$opciones.='&opcion=evaluacion_documental';
$opciones.='&accion='.$_GET["accion"];
$opciones.='&hoja='.$_GET["hoja"];
$opciones.='&mostrar=1';
$opciones.='&fecha='.$_GET["fecha"];
$opciones.='&registro='.$_GET['registro'].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_evaluacion_documental');
$opciones.='&accion='.$_GET["accion"];
$opciones.='&hoja='.$_GET["hoja"];
$opciones.='&mostrar=1';
$opciones.='&registro='.$_GET['registro'];
$opciones.='">No</a>';
$opciones.='<br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";

?>
