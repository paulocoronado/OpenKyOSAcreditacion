<?php  
$borrar_nombre=" la informaci&oacute;n bibliogr&aacute;fica correspondiente al a&ntilde;o ".$_GET['anno'].", semestre ".$_GET["semestre"];			//Opciones
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
$opciones.="<td>\n";
//Si
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('info_bibliografia_borrado');
$opciones.='&opcion=bibliografia_programa';
$opciones.='&accion=1';
$opciones.='&anno='.$_GET['anno'];
$opciones.='&semestre='.$_GET["semestre"];
$opciones.='&registro='.$_GET['registro'];
$opciones.='&programa='.$_GET["programa"].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('editar_recurso_bibliografico');
$opciones.='&registro='.$_GET['registro'];
$opciones.='">No</a>';
$opciones.='<br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
