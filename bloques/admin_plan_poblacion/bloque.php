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
	echo "IMPOSIBLE ACCEDER A LA PAGINA";	
	exit;		
}


?>
<script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
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
				$cadena_sql="SELECT id_programa,anno,periodo";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."plan_poblacion ";
				$cadena_sql.="GROUP BY anno ";
				//echo $cadena_sql;
				break;
				
			case '2':
				if($_GET["anno"]==0)
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_programa,anno,periodo";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."plan_poblacion ";
						$cadena_sql.="GROUP BY anno ";
						//echo $cadena_sql;
					}
					else
					{
						$cadena_sql="SELECT id_programa,anno,periodo";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."plan_poblacion ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa'];
						$cadena_sql.=" GROUP BY anno ";
					}
				}
				else
				{
					if($_GET["programa"]==-1)
					{
						$cadena_sql="SELECT id_programa,anno,periodo";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."plan_poblacion ";
						$cadena_sql.=" WHERE anno=".$_GET['anno'];
						$cadena_sql.="GROUP BY anno ";
					}
					else
					{
						$cadena_sql="SELECT id_programa,anno,periodo";
						$cadena_sql.=" FROM ".$configuracion["prefijo"]."plan_poblacion ";
						$cadena_sql.=" WHERE id_programa=".$_GET['programa'];
						$cadena_sql.=" AND anno=".$_GET['anno']." GROUP BY anno ";
					
					}	
				
				}
				//echo $cadena_sql;
				break;
				
						
			
			default:
				$cadena_sql="SELECT id_programa,anno,periodo";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."plan_poblacion ";
				$cadena_sql.="GROUP BY anno ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT id_programa,anno,periodo";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."plan_poblacion ";
		$cadena_sql.="GROUP BY anno ";
		//echo $cadena_sql;
		
	}		
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay informaci&oacute;n sobre poblaci&oacute;n registrada en el sistema</td>
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
<td colspan="6">
Poblaci&oacute;n Estudiantil
</td>
</tr>
<tr align="center" class="mensajealertaencabezado">
<td>a&ntilde;o</td>
<td>Periodo</td>
<td>Programa</td>
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
<td class="celdatabla"><?php   echo $registro[$contador][1] ?></td>
<td class="celdatabla" align="center"><?php   echo $registro[$contador][2] ?></td>
<td class="celdatabla"><?php   echo $programa[0][0] ?></td>
<td align="center" class="celdatabla"><?php  //TODO: IMPLEMENTAR LA FUNCIONALIDAD DE EDICION?>
<a href="<?php  
$opciones=$configuracion["site"].'/index.php?page='.enlace('registro_plan_poblacion');
$opciones.='&anno='.$registro[$contador][1]; 
$opciones.='&periodo='.$registro[$contador][2]; 
$opciones.='&programa='.$registro[$contador][0]; 

echo $opciones;

?>">Editar</a>
</td>
<td align="center" class="celdatabla"><?php  //TODO: Implementar la funcionalidad de Borrar?>
<a href="<?php  

$opciones=$configuracion["site"].'/index.php?page='.enlace('borrar_plan_poblacion');
$opciones.='&opcion=plan_poblacion';
$opciones.='&anno='.$registro[$contador][1]; 
$opciones.='&periodo='.$registro[$contador][2];
$opciones.='&programa='.$registro[$contador][0]; 

echo $opciones;


?>">Borrar</A>
</td>	</tr><?php  		
		}
	}	
?>
</table><br>
</form>
<?php  			
  }
}
?>
