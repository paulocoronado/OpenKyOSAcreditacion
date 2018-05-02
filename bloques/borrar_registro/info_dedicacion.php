<?php  
$borrar_nombre=" la informaci&oacute;n correspondiente al tiempo de dedicaci&oacute;n del a&ntilde;o ".$_GET['anno'];	

$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('dedicacion_borrado');
$opciones.='&opcion=info_dedicacion';
$opciones.='&accion=1';
$opciones.='&id_dedicacion='.$_GET["id_dedicacion"];
$opciones.='&usuario='.$_GET["usuario"];
$opciones.='&registro='.$_GET['registro'];
$opciones.='">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('editar_dir_profesor');
$opciones.='&usuario='.$_GET["usuario"];
$opciones.='&registro='.$_GET['registro'].'">No</a><br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
