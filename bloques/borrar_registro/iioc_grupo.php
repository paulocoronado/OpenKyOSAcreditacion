<?php  
$borrar_nombre=$_GET['nombre'];			
//Opciones
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
$opciones.="<td>\n";
//Si
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('grupo_borrado');
$opciones.='&opcion=iioc_grupo';
$opciones.='&accion=1';
$opciones.='&registro='.$_GET['registro'].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_iioc_grupo');
$opciones.='&registro='.$_GET['registro'];
$opciones.='">No</a>';
$opciones.='<br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
