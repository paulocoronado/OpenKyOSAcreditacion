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
  
indicador.html.php 

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
?><?php 
if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	
	exit;		
}
include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	

?>
<script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php 
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$cadena_sql="SELECT ";
	$cadena_sql.="id_programa, ";
	$cadena_sql.="titulo, ";
	$cadena_sql.="documento, ";
	$cadena_sql.="id_documento ";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."investigacion_documento ";
	$cadena_sql.=" WHERE id_programa != 0";	
	$cadena_sql.=" ORDER BY titulo";
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existe informacion anual del profesor en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >No hay informaci&oacute;n de documentos institucionales.</td>
    </tr>
    </tbody>
</table>


<?php 

		
	}
	else
	{
/*Si existe informacion anual del profesor - se muestran n registros con los datos mas relevantes*/
?>
<form method="post" action="index.php" name="activar_usuario">
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr class="mensajealertaencabezado">
<td colspan="4">Criterios y pol&iacute;ticas de investigaci&oacute;n:</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td >Programa</td>
<td>Nombre</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			
			$busqueda="SELECT nombre_corto ";
			$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
			$busqueda.="WHERE id_programa=".$registro[$contador][0 ];
			$busqueda.=" ORDER BY nombre_corto LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$programa=$acceso_db->obtener_registro_db();
			$total_programas=$acceso_db->obtener_conteo_db();
			if($total_programas>0)
			{
			?>
<?php /*Campos ocultos para dar continuidad al formulario actual*/?>
<input type="hidden" name= "identificacion" value="<?php echo $_GET["registro"] ?>">
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td align="center" class="celdatabla"><?php  echo $programa[0][0] ?></td>
<td align="center" class="celdatabla">
<?php  echo "<a href='".$configuracion["host"].$configuracion["site"]."/documento/".$registro[0][2]."'>".$registro[0][1]."</a>";?>
</td>
<td align="center" class="celdatabla">
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('registro_iioc_doc_programa').'&id_documento='.$registro[$contador][3]; ?>">Editar</a>		
</td>
<td align="center" class="celdatabla"><?php //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_iioc_documento_programa').'&opcion=iioc_documento_institucional&id_documento='.$registro[$contador][3].'&nombre='.$registro[$contador][1] ?>">Borrar</A>
</td>	
</tr><?php 
			}
		}	
?>
</table><br>
</form>
<?php 			
  }
}  
?>
