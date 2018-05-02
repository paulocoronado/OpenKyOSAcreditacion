<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        				   #
#    Paulo Cesar Coronado 2004 - 2006                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php
/************************************************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

**************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal subsistema comite
* @usage        
************************************************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");


?><table width="100%" border="0" cellpadding="5" celspacing="0" class="bloquelateral">
  	<tr>
		<td width="100%" class="bloquelateralencabezado">
		Ponderaci&oacute;n
		</td>
  	</tr>
  	<tr class="bloquelateralcuerpo">
		<td width="100%">
			<a href="<?php
			$ruta= $configuracion["host"].$configuracion["site"]."/index.php";
			
			$opciones="?";
			$opciones.="page=".enlace('tabla_ponderacion_basico');
			$opciones.="&id_esquema=".$_GET["id_esquema"];
			$opciones.="&id_componente=".$_GET["id_componente"];
			$opciones.="&opcion=".enlace("editar");
			 
			 echo $ruta.$opciones;
			?>" title="Editar esquema de Ponderaci&oacute;n"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/editar.png" alt="Editar esquema de Ponderaci&oacute;n" border="0" /> Editar Esquema</A>
		</td>
	</tr> 
</table>