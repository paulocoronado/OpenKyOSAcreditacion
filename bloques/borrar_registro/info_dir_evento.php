<?php  
$borrar_nombre= " ".$_GET['nombre']." ";	

$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('dir_participacion_borrado');
$opciones.='&opcion=info_dir_evento';
$opciones.='&accion=1';
$opciones.='&id_participacion='.$_GET["id_participacion"];
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
