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
  
001html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	formulario
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://acreditacion.udistrital.edu.co
* 
*
* Codigo HTML del formulario de autenticacion de usuarios
*
*****************************************************************************************************************/
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="autenticacion" onsubmit="return ( control_vacio(this,'usuario') && control_vacio(this,'clave'))">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="bloquelateral">
<tbody>
<tr>
<td colspan="2" rowspan="1" class="bloquelateralencabezado">Ingresar</td>
</tr>
<tr class="bloquelateralcuerpo">
<td style='text-size:10;'>Usuario:
</td>
<td><input maxlength="50" size="10" tabindex="1" name="usuario"><br>
</td>
</tr>
<tr class="bloquelateralcuerpo">
<td>Clave:
</td>
<td><input maxlength="50" size="10" tabindex="2" name="clave" type="password"> </td>
</tr>
<tr align="center">
<td colspan="2" rowspan="1" >
<input type="hidden" name="action" value="login">
<input name="aceptar" value="Aceptar" type="submit"><br>
</td>
</tr>
</tbody>
</table>
</form>

