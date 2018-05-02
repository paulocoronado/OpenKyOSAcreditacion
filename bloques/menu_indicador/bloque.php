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
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");

// Rescatar el nombre de usuario desde los datos de sesion.

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro!=FALSE)
	{
		
		$el_usuario=$registro[0][0];
		
	}
	else
	{
		$el_usuario="";
	}
	//Rescatar el id_subsistema
	$cadena_sql="SELECT ";
	$cadena_sql.="id_subsistema ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."usuario_subsistema ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_usuario=".$el_usuario." ";
	$cadena_sql.="LIMIT 1";
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		$id_subsistema=$registro[0][0];
	}
	else
	{
		$id_subsistema=0;
	}
	unset($registro);
	unset($campos);
	
	
	
	
}

if($el_usuario!="")
{
	
	
	
	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
	$html=new html();
	$busqueda="SELECT ";
	$busqueda.="codigo_componente,";
	$busqueda.="comentario ";
	$busqueda.="FROM ";
	$busqueda.="".$configuracion["prefijo"]."subsistema_componente ";
	$busqueda.="WHERE ";
	$busqueda.="id_subsistema= '".$id_subsistema."' ";
	$busqueda.="ORDER BY codigo_componente";
	$mi_cuadro=$html->cuadro_lista($busqueda,'accion',$configuracion,-1,1,0);
?><form action="index.php" method="GET">
<input type="hidden" name="page" value="<?php   echo enlace("indicador_".$id_subsistema)?>">
<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 CELLSPACING=0 class="bloquelateral"><?php  /*<thead style="font-family: Helvetica,Arial,sans-serif;"> <tr>
	<TD WIDTH=100% class="bloquelateralencabezado">
	<B>Indicadores</B>
	</TD>
  </tr>
  </thead>*/?>
  <tbody>
<TR class="bloquelateralcuerpo"><TD WIDTH=100% align="justify">
Indicadores de los cuales su dependencia debe ingresar informaci&oacute;n:<br><br></TD>
		</TR>
		<TR>
		<td align="center">
<?php  
echo $mi_cuadro;
?></td>
		</TR>
		<TR>
			<TD WIDTH=100%>
			<BR>
			</TD>
		</TR>
		</tbody>	
	</TABLE>
</form>
<?php  

}
else
{

	echo "Imposible determinar los indicadores asociados.";

}


?>
