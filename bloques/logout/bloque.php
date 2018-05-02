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
* @name          012.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   
* @package	formulario
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************************************************/
?><?php
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");

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
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$usuario=$registro[0][0];
	}
}
if(!isset($_GET['action']))
//Tabla de logout
{
	


?>

	<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral" >
	<TR class="bloquelateralencabezado" >
		<td>Usuario Actual</td>
	</TR>
	<TR class="bloquelateralcuerpo" style="text-align:center">
		<TD WIDTH=100% VALIGN=TOP>
			<?php
			 
			 if(isset($el_usuario))
			 {
			 	echo $el_usuario;
			 }?>
		</TD>
	</TR>
	<TR class="bloquelateralcuerpo" style="text-align:center">
		<TD WIDTH=100% VALIGN=TOP><?include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");?>
			<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('logout').'&action=logout'; ?>">Terminar sesi&oacute;n<br><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/logout.png" alt="Terminar sesi&oacute;n" title="Terminar sesi&oacute;n" border="0" /></A>
		<br><br>
		</TD>
	</TR>
	</TABLE>

	<?php
}
else
{	
	//echo "salir";
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//echo $esta_sesion;
	$nueva_sesion->terminar_sesion($configuracion,$esta_sesion);
	@$log=$acceso_db->logger($configuracion,$usuario,"Salida del sistema.");
	unset($_GET['action']);
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
	$la_pagina=new pagina('logout_exito',$configuracion);
	
}

?>


