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
?><?php  include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

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
}


?>
		
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral">
   <tbody>		
		<form action="index.php" method="GET">
		<TR>
			<TD WIDTH=100% class="bloquelateralencabezado">
				<INPUT type="hidden" NAME="page" VALUE="<?php   echo enlace('registro_artefacto_formulario') ?>">
				<input type="hidden" name= "accion" value="2">
				<input type="hidden" name= "hoja" value="0">
				Mostrar Formularios
			</TD>
		</TR>
		<TR class="bloquelateralcuerpo">
			<td>
				Creadas desde la fecha:
			</TD>
		</TR>
		<TR>
			<td>
			<table cellpading="2">
			<tr>
			<td class="bloquelateralcuerpo">D&iacute;a <?php  
			$contador=0;
			echo "<select name='dia_1' size='1'>\n";
			echo "<option value='0'> </option>\n";
			for($dia=1;$dia<32;$dia++)
			{	
				echo "<option value='".$dia."'>".$dia."</option>\n";
				
			}		
			echo "</select>\n";
			?></TD>
			<td class="bloquelateralcuerpo">Mes <?php  
			$contador=0;
			echo "<select name='mes_1' size='1'>\n";
			echo "<option value='0'> </option>\n";
			for($mes=1;$mes<13;$mes++)
			{	
				echo "<option value='".$mes."'>".$mes."</option>\n";
				
			}		
			echo "</select>\n";

			?></TD>
			<td class="bloquelateralcuerpo">A&ntilde;o <?php  
			echo "<select name='anno_1' size='1'>\n";
			echo "<option value='0'> </option>\n";
			for($anno=2001;$anno<date("Y")+1;$anno++)
			{	
				echo "<option value='".$anno."'>".$anno."</option>\n";
				
			}
			echo "</select>\n";

			?>
			</TD>
			</tr>
			</table>
		</TR>
		<TR>
			<td class="bloquelateralcuerpo">
				y la fecha:
			</TD>
		</TR>
		<TR>
			<td>
			<table cellpading="2">
			<tr>
			<td class="bloquelateralcuerpo">D&iacute;a <?php  
			$contador=0;
			echo "<select name='dia_2' size='1'>\n";
			echo "<option value='0'> </option>\n";
			for($dia=1;$dia<32;$dia++)
			{	
				echo "<option value='".$dia."'>".$dia."</option>\n";
				
			}		
			echo "</select>\n";
			?></TD>
			<td class="bloquelateralcuerpo">Mes <?php  
			$contador=0;
			echo "<select name='mes_2' size='1'>\n";
			echo "<option value='0'> </option>\n";
			for($mes=1;$mes<13;$mes++)
			{	
				echo "<option value='".$mes."'>".$mes."</option>\n";
				
			}		
			echo "</select>\n";

			?></TD>
			<td class="bloquelateralcuerpo">A&ntilde;o <?php  
			echo "<select name='anno_2' size='1'>\n";
			echo "<option value='0'> </option>\n";
			for($anno=2001;$anno<date("Y")+1;$anno++)
			{	
				echo "<option value='".$anno."'>".$anno."</option>\n";
				
			}
			echo "</select>\n";

			?>
			</TD>
			</tr>
			</table>
		</TR>
		<TR>
			<td class="bloquelateralcuerpo">
				Por el autor:
			</TD>
		</TR>
		<tr>
			<td><?php  
				include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
				$html=new html();
				$busqueda="SELECT id_usuario,nombre FROM ".$configuracion["prefijo"]."registrado WHERE tipo='2' ORDER BY nombre";
				$mi_cuadro=$html->cuadro_lista($busqueda,'autor',$configuracion,-1,0,1);
				echo $mi_cuadro;
				?>
			</td>
            	</tr>		
		<TR>
			<td class="bloquelateralcuerpo">
				Cuyo nombre contiene:
			</TD>
		</TR>
		<TR align="center">
			<td class="bloquelateralcuerpo">
				<INPUT TYPE=TEXT NAME="busqueda" SIZE=19> 
			</TD>
		<TR>
			<TD WIDTH=100% ALIGN=CENTER>
				
				<INPUT TYPE=SUBMIT NAME="aceptar" VALUE="buscar">
				
			</TD>
		</TR>
		</form>
	</tbody>	
	</TABLE>
