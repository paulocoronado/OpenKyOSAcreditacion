<?php  
$borrar_nombre=": informaci&oacute;n de empleo del egresado correspondiente al a&ntilde;o ".$_GET['anno'];

$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
$opciones.="<td>\n";
//Si
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('egresado_empleo_borrado');
$opciones.='&opcion=egresado_empleo';
$opciones.='&accion=1';
$opciones.='&id_empleo='.$_GET['id_empleo'];
$opciones.='&usuario='.$_GET["usuario"];
$opciones.='&registro='.$_GET["registro"].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('editar_egresado');
$opciones.='&usuario='.$_GET["usuario"];
$opciones.='&registro='.$_GET['registro'];
$opciones.='">No</a>';
$opciones.='<br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";

?>
