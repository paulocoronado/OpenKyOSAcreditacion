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
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************************************************/
?><?php 
if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	
	exit;		
	}


?>
<script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php 
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	if(isset($_GET['id_material']))
	{
		//Rescatar datos anuales, con nombre de programa y nombre del tipo de vinculacion
		$cadena_sql="SELECT ";
		$cadena_sql.="id_programa, ";
		$cadena_sql.="uso, ";
		$cadena_sql.="anno ";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."com_utilizacion ";
		$cadena_sql.=" WHERE id_material='".$_GET['id_material']."' ";	
		$cadena_sql.=" ORDER BY id_programa,anno";
		
		
	}
	else
	{
		
		echo "Imposible determinar el registro de b&uacute;squeda.";	
		exit;

	}		
//	echo $cadena_sql;
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
      <td >No hay informaci&oacute;n de utilizaci&oacute;n del material.</td>
    </tr>
    </tbody>
</table>


<?php 

		
	}
	else
	{
/*Si existe informacion anual del profesor - se muestran n registros con los datos mas relevantes*/
?>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td >A&ntilde;o</td>
<td >Programa</td>
<td >No Usuarios</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
		
			$busqueda="SELECT nombre_corto ";
			$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
			$busqueda.="WHERE id_programa=".$registro[$contador][0];
			$busqueda.=" ORDER BY nombre_corto LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$programa=$acceso_db->obtener_registro_db();
			$total_programas=$acceso_db->obtener_conteo_db();
			if($total_programas>0)
			{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td align="center" class="celdatabla"><?php  echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla"><?php  echo $programa[0][0] ?></td>
<td align="center" class="celdatabla"><?php  echo $registro[$contador][1] ?></td>
<td align="center" class="celdatabla">
<a href="<?php 

$opciones=$configuracion["site"].'/index.php?page='.enlace('agregar_com_utilizacion');
$opciones.='&id_material='.$_GET['id_material'];
$opciones.='&anno='.$registro[$contador][2]; 
$opciones.='&programa='.$registro[$contador][0]; 
$opciones.='&registro='.$_GET['registro'];

echo $opciones

?>">Editar</a>
</td>
<td align="center" class="celdatabla">
<a href="<?php 

$opciones=$configuracion["site"].'/index.php?page='.enlace('borrar_com_utilizacion');
$opciones.='&opcion=com_utilizacion';
$opciones.='&id_material='.$_GET['id_material'];
$opciones.='&anno='.$registro[$contador][2]; 
$opciones.='&programa='.$registro[$contador][0]; 
$opciones.='&registro='.$_GET['registro'];

echo $opciones; 

?>">Borrar</A>
</td>	
</tr><?php }
	}
?>
</table><br>
<?php 			
  }
}
?>
