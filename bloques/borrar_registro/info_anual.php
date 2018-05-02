<?php  
$borrar_nombre=" la informaci&oacute;n del profesor correspondiente al a&ntilde;o ".$_GET['anno'];
//Opciones
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('anual_borrado').'&opcion=info_anual&accion=1&anno='.$_GET['anno'].'&registro='.$_GET["registro"].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('editar_profesor').'&registro='.$_GET['registro'].'">No</a><br>'; 
$opciones.="</td>\n";
$opciones.='<br>';
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
