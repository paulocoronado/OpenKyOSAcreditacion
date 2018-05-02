<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php
/****************************************************************************************************************
  
index.php 

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
* @description  Menu principal
* @usage        
*****************************************************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");

if(isset($_GET["usuario"]))
{
	$el_usuario=$_GET["usuario"];
}
else
{
	$base=new dbms($configuracion);
	$enlace=$base->conectar_db();
	if($enlace)
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
	}
}



?>
<table width=100% border=0 cellpadding=10 cellspacing=0 class="bloquelateral">
   		<tr>
			<td width=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_dir_programa').'&accion=1&opcion=editar&usuario='.$el_usuario; ?>">Editar informaci&oacute;n</a>
			</td>
		</tr>		
		
</table>
