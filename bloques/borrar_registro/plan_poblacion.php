<?php  
$borrar_nombre=" la informaci&oacute;n de poblaci&oacute;n correspondiente al periodo ".$_GET['periodo']." del a&ntilde;o ".$_GET['anno'];
//Opciones
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('plan_poblacion_borrado').'&opcion=plan_poblacion&accion=1&anno='.$_GET['anno'].'&periodo='.$_GET["periodo"].'&programa='.$_GET["programa"].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_plan_poblacion').'">No</a><br>'; 
$opciones.="</td>\n";
$opciones.='<br>';
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
