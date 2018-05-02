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
  
borrar_registro.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	formulario
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* 
*
* Borrar registros de la base de datos
*
*****************************************************************************************************************/
?>
<?php  
if(isset($_GET['opcion']))
{
	include_once ($configuracion["raiz_documento"].$configuracion["bloques"]."/borrar_registro/".$_GET['opcion'].".php");
?>
<table class="bloquelateral" cellpadding="0" cellspacing="0">
  <tbody>
  	<tr class="bloquelateralencabezado">
      		<td valign="middle" align="right" width="10%">
      		<img src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
      		</td>
      		<td valign="middle" align="left" style="background-color: rgb(221, 221, 221);font-weight: bold; font-family: Helvetica,Arial,sans-serif; color: rgb(0, 0, 0);">
      		Eliminar un registro del sistema
      		</td>
    	</tr>
  	<tr>
  	<td colspan="2"> 
		<table border="0" cellpadding="10" cellsapcing="0">
		  <tbody>
		    	<tr class="bloquecentralcuerpo">
		      	<td>
		     	Confirma la eliminaci&oacute;n de <b><?php   echo $borrar_nombre ?></b> del sistema. Tenga en cuenta que este cambio no podr&aacute;&nbsp; deshacerse.<br>
		      	</td>
		      	</tr>
		      	<tr class="bloquecentralcuerpo">
		      	<td align="center">
		      	<?php   echo $opciones ?>
		      	<hr style="width: 100%; height: 2px;">
		      	En algunas ocasiones borrar un registro puede implicar la eliminaci&oacute;n de todos sus datos asociados.</span></small></div><br> 
		      	</td>
		    	</tr>
		    </tbody>
		</table>
	</td>
	</tr>
	</tbody>
</table>
<?php  
}
else
{
	echo "<h1>Imposible Eliminar</h1>No se encontr&oacute; el registro de b&uacute;queda.";
}
?>
