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
?><?php 
/****************************************************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************************************************/
?><?php 

//La variable $_GET['usuario'] contiene el npmbre del programa que esta editando la información...
// puede tomarse esa informacion desde la variable de sesion correspondiente TODO


if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	exit;		
}

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{

//Rescatar la variable de sesion correspondiente al usuario actualmente registrado.	
	$sesion=new sesiones($configuracion);
	$sesion->especificar_enlace($enlace);
	$esta_sesion=$sesion->numero_sesion();
	$proceso=$sesion->rescatar_valor_sesion($configuracion,"id_proceso");
		
	$cadena_sql="SELECT ";
	$cadena_sql.="presentacion";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."proceso ";
	$cadena_sql.=" WHERE id_proceso=".$proceso;
	$cadena_sql.=" LIMIT 1";
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
	
	
?><table class="bloquelateral" width="100%" border="0" cellpadding="2" cellspacing="0">
<tbody>
<tr>
<td>
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
	<?php  echo $registro[0][0] ?>
	</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<?php  }
}
?>
