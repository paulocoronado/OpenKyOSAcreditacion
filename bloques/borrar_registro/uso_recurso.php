<?php  
$borrar_nombre=" la informaci&oacute;n correspondiente al a&ntilde;o ".$_GET['anno'];	
//TODO: Cambiar acceso a programa
switch($_GET['id_programa'])
{
	
	case 1:
		$programa='veterinaria';
		break;
		
	case 2:
		$programa='agronomia';
		break;
			
	case 3:
		$programa='enfermeria';
		break;
		
	case 4:
		$programa='edufisica';
		break;
	default:
		$programa="";
	
}
$opciones="<table width='50%' align='center' border='0'>\n";
$opciones.="<tr align='center'>\n";
//Si
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('uso_recurso_borrado');
$opciones.='&opcion=uso_recurso';
$opciones.='&accion=1';
$opciones.='&usuario='.$programa;
$opciones.='&id_programa='.$_GET["id_programa"];
$opciones.='&registro='.$_GET['anno'].'">Si</a>';
$opciones.="</td>\n";
//No
$opciones.="<td>\n";
$opciones.='<a href="'.$configuracion["site"].'/index.php?page='.enlace('admin_dir_utilizacion');
$opciones.='&accion=1';
$opciones.='&usuario='.$programa.'">No</a><br>';
$opciones.="</td>\n"; 
$opciones.="</tr>\n";
$opciones.="</table>\n";
?>
