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

//La variable $_GET['usuario'] contiene el npmbre del programa que esta editando la información...
// puede tomarse esa informacion desde la variable de sesion correspondiente TODO


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
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	if(isset($_GET['accion']))
	{
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos los servicio
			case '1':
				$cadena_sql="SELECT id_servicio,nombre";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."bienestar_servicio ORDER BY nombre ";
				//echo $cadena_sql;
				break;
				
			//Filtrados tipo
			case '2':
				if($_GET["tipo"]==0)
				{
					$cadena_sql="SELECT id_servicio,nombre";
					$cadena_sql.=" FROM ".$configuracion["prefijo"]."bienestar_servicio ORDER BY nombre ";
					//echo $cadena_sql;
						
				}
				else
				{
					$cadena_sql="SELECT id_servicio,nombre";
					$cadena_sql.=" FROM ".$configuracion["prefijo"]."bienestar_servicio ";
					$cadena_sql.=" WHERE tipo=".$_GET['tipo']." ORDER BY nombre ";
				}
				//echo $cadena_sql;
				break;
			
			
			
			//Filtrado
			case '3':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='(';
				while (list ($clave, $val) = each ($buscar)) {
					$buscar_nombre.="nombre like '%".$val."%' OR ";
				}
				
				$buscar_todo=substr($buscar_nombre,0,(strlen($buscar_nombre)-3)).")";
				//echo $buscar_todo;
				
				$cadena_sql="SELECT id_servicio,nombre";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."bienestar_servicio ";
				$cadena_sql.=" WHERE ".$buscar_todo." ORDER BY nombre ";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT id_servicio,nombre";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."bienestar_servicio ORDER BY nombre ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT id_servicio,nombre";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."bienestar_servicio ORDER BY nombre ";
		//echo $cadena_sql;
		
	}		
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen usuarios profesors en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay servicios de bienestar registrados en el sistema</td>
    </tr>
    </tbody>
</table><?php 
	}
	else
	{
/*Si existen usuarios en el sistema*/
?>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td colspan="5">
Servicios de Bienestar
</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td>Nombre</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php  echo $registro[$contador][1] ?></td>
<td align="center" class="celdatabla"><?php //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('editar_bienestar_servicio').'&registro='.$registro[$contador][0]; ?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php 

$opciones=$configuracion["site"].'/index.php?page='.enlace('borrar_bienestar_servicio');
$opciones.='&opcion=bienestar_servicio';
$opciones.='&registro='.$registro[$contador][0];
$opciones.='&nombre='.$registro[$contador][1]; 

echo $opciones;


?>

">Borrar</A>
</td>	</tr><?php 		
		}
?>
</table><br>
</form>
<?php 			
  }
}
?>
