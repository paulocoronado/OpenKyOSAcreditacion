<?php  
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

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
?><TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
			<TR>
			<TD WIDTH=100% BGCOLOR='#DDDDDD' class="bloquelateralencabezado">
				<FONT FACE="helvetica"><FONT SIZE=2><B>Matriz E.D</B></FONT></FONT>
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<TD WIDTH=100%><?php  
				if(isset($_GET["registro"]))
				{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('evaluar_documento').'&registro='.$_GET['registro'].'&accion=1&hoja='.$_GET['hoja'].'">
				              Evaluar la fuente documental</A>';	
				}
				else
				{
					if(isset($_GET["id_documento"]))
					{
					echo '<a href="'.$configuracion["site"].'/index.php?page='.enlace('evaluar_documento').'&registro='.$_GET['registro'].'&accion=1&hoja='.$_GET['hoja'].'">
				              Evaluar la fuente documental</A>';	
					}
				}
	
			?></TD>
		</TR>
		<TR class="bloquelateralcuerpo">			
			<TD WIDTH=100%>
				<br>
			</TD>
		</TR>
</TABLE>
