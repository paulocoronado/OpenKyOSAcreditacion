<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        				   #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
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
* @description  Menu principal
* @usage        
*************************************************************************************************************/

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
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
  <thead style="font-family: Helvetica,Arial,sans-serif;"> <tr>
	<TD WIDTH=100% class="bloquelateralencabezado">
	Informaci&oacute;n
	</TD>
  </tr>
  </thead>
  <tbody>
  		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_programa').'&accion=1&opcion=mostrar&usuario='.$el_usuario; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info_basica.png" alt="Informaci&oacute;n b&aacute;sica del programa." title="Informaci&oacute;n b&aacute;sica del programa." border="0" /> Datos B&aacute;sicos</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_egresado').'&accion=1&hoja=0&usuario='.$el_usuario; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/egresados.png" alt="Informaci&oacute;n de Egresados del programa." title="Informaci&oacute;n de Egresados del programa." border="0" /> Egresados</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_profesor').'&accion=1&hoja=0&admin='.enlace("lista"); ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/profesores.png" alt="Informaci&oacute;n de profesores del programa." title="Informaci&oacute;n de profesores del programa." border="0" /> Profesores</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_proyecto').'&accion=1&usuario='.$el_usuario; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/proyectos.png" alt="Informaci&oacute;n de proyectos adelantados por el programa." title="Informaci&oacute;n de proyectos adelantados por el programa." border="0" /> Proyectos</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_convenio').'&accion=1&usuario='.$el_usuario; ?>">Convenios</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_actividad').'&accion=1&usuario='.$el_usuario; ?>">Actividades</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_visitante').'&accion=1&usuario='.$el_usuario; ?>">Profesores visitantes</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_trabajo_estudiante').'&accion=1&usuario='.$el_usuario; ?>">Trabajos de estudiantes</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_utilizacion').'&accion=1&usuario='.$el_usuario; ?>">Utilizaci&oacute;n de recursos </A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100% class="bloquelateralcuerpo">
				<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_datos_consolidados').'&accion=1&usuario='.$el_usuario; ?>"><img width="16" height="14" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/tabla.png" alt="Informe consolidado del programa." title="Informe consolidado del programa." border="0" /> Datos Consolidados</A>
			</TD>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<BR>
			</TD>
		</TR>
	</tbody>	
	</TABLE>
