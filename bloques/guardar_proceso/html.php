<?php  
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?>
<?php  
/****************************************************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?><?php  

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		$el_usuario=$registro[0][0];
	}

/*Armar el instrumento*/
	
/*Como es una previsualización se muestran los datos básicos del formulario*/	
	$cadena_html="<form action='index.php' method='post' \n>";
	$cadena_html.="<input type='hidden' name='action' value='guardar_proceso'>\n";
	$cadena_html.="<table  width='50%' align='center'>\n<tbody>\n<tr>\n";
	/*Solo se pasa al procesamiento general del formulario si se hace click en el botón aceptar*/
	$cadena_html.="<tr>\n";
	$cadena_html.="<td style='text-align:center;color:rgb(0, 0, 100);' colspan='2' rowspan='1'>\n ";
	$cadena_html.="&iquest;Desea guardar el proceso en el Sistema?";
	$cadena_html.="</td>\n";
	$cadena_html.="</tr>\n";
	$cadena_html.="<td style='text-align:center'><input type='submit' name='aceptar'";
	$cadena_html.=" value='&nbsp;&nbsp;Si&nbsp;&nbsp;' title='Guarda el proceso'></td>\n";
	$cadena_html.="<td style='text-align:center'><input type='submit' name='cancelar'";
	$cadena_html.=" value='&nbsp;&nbsp;No&nbsp;&nbsp;' title='Cancela la creaci&oacute;n'></td>\n";
	$cadena_html.="</tr>\n";
	$cadena_html.="</tbody>\n</table>\n";		
	$cadena_html.="</form>\n";
	echo $cadena_html;
		
	$cadena_sql="SELECT id_proceso, fecha_creacion, id_usuario, nombre, responsable,";
	$cadena_sql.="presentacion, descripcion FROM ".$configuracion["prefijo"]."proceso_borrador WHERE id_proceso=1 AND ";
	$cadena_sql.="id_sesion='".$esta_sesion."' LIMIT 1";
	//echo $cadena_sql;
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro_instrumento=$acceso_db->obtener_registro_db();
	$conteo_encabezado=$acceso_db->obtener_conteo_db();
	if($conteo_encabezado>0)
	{
			$cadena_pregunta="<br><hr>\n";
			$cadena_pregunta.="<table align='center' style='width: 80%; text-align: left;' border='0' cellpadding='5'";
			$cadena_pregunta.="cellspacing='2'>\n<tbody>";
			$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_pregunta.="<td style='font-weight:bold;'>\n";
			$cadena_pregunta.="Editor Propietario: ";
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="<td>\n";
			$cadena_pregunta.=$el_usuario;
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="</tr>\n";
			$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_pregunta.="<td style='font-weight:bold;'>\n";
			$cadena_pregunta.="Nombre: ";
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="<td>\n";
			$cadena_pregunta.=$registro_instrumento[0][3];
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="</tr>\n";
			$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_pregunta.="<td style='font-weight:bold;'>\n";
			$cadena_pregunta.="Descripci&oacute;n: ";
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="<td>\n";
			$cadena_pregunta.=$registro_instrumento[0][6];
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="</tr>\n";
			$cadena_pregunta.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_pregunta.="<td style='font-weight:bold;'>";
			$cadena_pregunta.="Fecha Creación: ";
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="<td>\n";
			$cadena_pregunta.=date("d-m-yy h:i.s",$registro_instrumento[0][1]);
			$cadena_pregunta.="</td>\n";
			$cadena_pregunta.="</tr>\n";
			$cadena_pregunta.="</tbody>\n";
			$cadena_pregunta.="</table>\n";
			
			
			/*Para liberar algo de memoria se visualiza la cadena que se ha estructurado y se inicializa a vacio*/
			echo $cadena_pregunta;
			$cadena_pregunta="";
			
			//Preguntas actualmente asociadas al instrumento?>
<hr><br>
<table width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">
<tr class="mensajealertaencabezado">
<td colspan="3">Proceso compuesto por:</td>
</tr>
<tr class="mensajealertaencabezado">
<td align="center">Nombre</td>
<td align="center">Orden</td>
</tr>
<?php  
$busqueda="SELECT ";
$busqueda.=" ".$configuracion["prefijo"]."p_borrador.id_elemento,";
$busqueda.="".$configuracion["prefijo"]."p_borrador.orden, ";
$busqueda.="".$configuracion["prefijo"]."artefacto.nombre ";
$busqueda.="FROM ";
$busqueda.="".$configuracion["prefijo"]."p_borrador,".$configuracion["prefijo"]."artefacto ";
$busqueda.="WHERE ";
$busqueda.="id_sesion='".$esta_sesion."' ";
$busqueda.="AND ";
$busqueda.="".$configuracion["prefijo"]."p_borrador.id_elemento=".$configuracion["prefijo"]."artefacto.id_artefacto ";
$busqueda.=" ORDER BY ".$configuracion["prefijo"]."p_borrador.orden ASC";

//echo $busqueda;
$acceso_db->registro_db($busqueda,0);
$la_instrumento=$acceso_db->obtener_registro_db();
$total_instrumento=$acceso_db->obtener_conteo_db();
if($total_instrumento>0)
{
	for($contador=0;$contador<$total_instrumento;$contador++)
	{
?>
<tr class="bloquecentralcuerpo">
<td align="left" class="celdatabla">
<?php   echo $la_instrumento[$contador][2]; ?>
</td>
<td align="center" class="celdatabla">
	<?php   echo $la_instrumento[$contador][1]; ?>
</td>
</tr>
<?php  	}
}
else
{
?>

<?php  			}
?></table><br>
<?php  			
}
}





?>
