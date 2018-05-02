<?php  
$borrar_nombre=$_GET['nombre'];			//Opciones
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
$opciones.="<td>\n";
//Si
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('doc_institucional_borrado');
$opciones.='&opcion=iioc_documento_institucional';
$opciones.='&accion=1';
$opciones.='&id_documento='.$_GET['id_documento'].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_iioc_doc_institucional');
$opciones.='&registro='.$_GET['id_documento'];
$opciones.='">No</a>';
$opciones.='<br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
