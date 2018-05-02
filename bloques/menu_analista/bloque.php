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
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
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
		
		$id_usuario=$registro[0][0];
	}
}

$cadena_sql="SELECT ";
$cadena_sql.="id_proceso ";
$cadena_sql.="FROM ";
$cadena_sql.="".$configuracion["prefijo"]."analista_proceso ";
$cadena_sql.="WHERE ";
$cadena_sql.="id_usuario=".$id_usuario;
$acceso_db->registro_db($cadena_sql,0);
$registro=$acceso_db->obtener_registro_db();
$campos=$acceso_db->obtener_conteo_db();

if($campos>0)
{


?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
  <thead style="font-family: Helvetica,Arial,sans-serif;"> <tr>
	<TD WIDTH=100% class="bloquelateralencabezado">
	Analista
	</TD>
  </tr>
  </thead>
  <tbody>
		<?php  /* 
		<TR>
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('comite_modelo').'&accion=1'; ?>"><FONT SIZE=2><FONT FACE="helvetica">Modelos de Autoevaluaci&oacute;n</FONT></FONT></A>
			</TD>
		</TR>
		*/ ?>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_proceso').'&accion=1&hoja=0&registro='.$registro[0][0].'&mostrar=1'; ?>">Instrumentos</A>
			</TD>
		</TR> 
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_subsistema').'&accion=1&hoja=0&registro='.$registro[0][0]; ?>">Informaci&oacute;n</A>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_tablas').'&accion=1&hoja=0&registro='.$registro[0][0]; ?>">Tablas de an&aacute;lisis</A>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analizar_informe').'&accion=1&hoja=0&registro='.$registro[0][0]; ?>">Informe</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<BR>
			</TD>
		</TR>
	</tbody>	
	</TABLE>
<?php  
}
else
{
?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
  <thead style="font-family: Helvetica,Arial,sans-serif;"> <tr>
	<TD WIDTH=100% class="bloquelateralencabezado">
	Comit&eacute;
	</TD>
  </tr>
  </thead>
  <tbody>
		<?php  /* 
		<TR>
			<TD WIDTH=100%>
				<a href="<?php  echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('comite_modelo').'&accion=1'; ?>"><FONT SIZE=2><FONT FACE="helvetica">Modelos de Autoevaluaci&oacute;n</FONT></FONT></A>
			</TD>
		</TR>
		*/ ?>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100% align="center">
			<font color="#DD0000"><b>Atenci&oacute;n</b></font><br>
			Actualmente no est&aacute; asignado a ning&uacute;n proceso. 
			Por favor contacte al director para que realice la asignaci&oacute;n correspondiente	
			</TD>
		</TR> 
	</tbody>	
	</TABLE>
<?php  
}
?>
