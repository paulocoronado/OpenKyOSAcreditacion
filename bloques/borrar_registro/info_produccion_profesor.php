<?php  
$borrar_nombre=" la informaci&oacute;n del profesor correspondiente al a&ntilde;o ".$_GET['anno'];

$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
$opciones.="<td>\n";
//Si
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('info_produccion_borrado');
$opciones.='&opcion=info_produccion_profesor';
$opciones.='&accion=1';
$opciones.='&id_profesor_produccion='.$_GET['id_profesor_produccion'];
$opciones.='&registro='.$_GET['registro'].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('editar_iioc_profesor');
$opciones.='&registro='.$_GET['registro'];
$opciones.='">No</a>';
$opciones.='<br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";

?>
