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

// Rescatar el nombre de usuario desde los datos de sesion.

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Guardar el valor de las variables GET en la db
	reset ($_GET);
	$variables_get="";
	while (list ($clave, $val) = each ($_GET)) 
	{
	    $variables_get.="&".$clave."=".$val;
	}
	$variables_get=substr($variables_get,1,strlen($variables_get)-1);
	//echo $variables_get;
	$nueva_sesion->guardar_valor_sesion($configuracion,"enlace_edu",$variables_get,$esta_sesion);
}
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral2">
	<TR>
		<TD WIDTH=100% class="bloquelateralcuerpo">
			<table>
				<tr>
					<td class="bloquelateralcuerpo" >
					<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('matriz_edu').'&accion=1'; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/biblio.png" alt="Administraci&oacute;n Documental" title="Administraci&oacute;n Documental" border="0" /> Matriz E.D.</A>
					</td>
				</tr>
			</table>
		</TD>
	</TR>
	
</TABLE>
