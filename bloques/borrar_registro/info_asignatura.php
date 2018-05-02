<?php  
$borrar_nombre= " ".$_GET['nombre']." ";	
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('asignatura_borrado');
$opciones.='&opcion=info_asignatura';
$opciones.='&accion=1';
$opciones.='&nombre='.$_GET["nombre"];
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
