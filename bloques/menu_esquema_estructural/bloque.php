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
* @subpackage   menu_esquema_estructural
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu Horizontal para esquemas de ponderacion basados en analisis estrucutral
* @usage        
************************************************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

?><table width="100%" border="0" cellpadding="0" celspacing="0" class="bloquelateral">
  	<tr class="bloquecentralcuerpo">
  		<td align="center" >
			<a href="<?php
			
			$opciones="page=".enlace("tabla_ponderacion_estructural");
			$opciones.="&id_esquema=".$_GET['id_esquema'];
			$opciones.="&id_componente=".$_GET['id_componente'];
			$opciones.="&opcion=".enlace("editar");
			
			echo $configuracion["host"].$configuracion["site"].'/index.php?'.$opciones; 
			
			?>" title="Editar matriz de incidencia"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/editar.png" border="0" /> Editar</A>
		</td>
		<td align="center">
			<a href="<?php
			
			$opciones="page=".enlace("clasificar_estructural");
			$opciones.="&id_esquema=".$_GET['id_esquema'];
			$opciones.="&id_componente=".$_GET['id_componente'];
			$opciones.="&opcion=".enlace("editar");
			
			echo $configuracion["host"].$configuracion["site"].'/index.php?'.$opciones; 
			
			?>" title="Clasificar los componentes/variables"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/clasificar.png" border="0" /> Clasificar</A>
		</td>
		<td align="center">
			<a href="<?php
			
			$opciones="page=".enlace("informe_estructural");
			$opciones.="&id_esquema=".$_GET['id_esquema'];
			$opciones.="&id_componente=".$_GET['id_componente'];
			$opciones.="&opcion=".enlace("editar");
			
			echo $configuracion["host"].$configuracion["site"].'/index.php?'.$opciones; 
			
			?>" title="Generar informe completo del esquema de ponderaci&oacute;n"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/informe.png" border="0" /> Informe</A>
		</td>		
		<td class="menucentralencabezado">
			Men&uacute; Esquema
		</td>
	</tr> 		
</table>
