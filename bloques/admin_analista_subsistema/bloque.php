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
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	if(isset($_GET['accion']))
	{
		switch($_GET['accion'])
		{	
			//Todos los subsistemas
			case '1':
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="etiqueta ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_subsistema > 2 ";
				$cadena_sql.="ORDER BY etiqueta ";
				//echo $cadena_sql;
				break;
			//Filtrados por cuadro de texto	
			case '2':
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="etiqueta ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
				$cadena_sql.="ORDER BY etiqueta ";				
				//echo $cadena_sql;
				break;	
			
			//Filtrado
			case '3':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='';
				$buscar_apellido='';
				$buscar_identificacion='';
				
				while (list ($clave, $val) = each ($buscar)) 
				{
					$buscar_nombre.="etiqueta like '%".$val."%' OR ";	
				}
				
				$buscar_todo=$buscar_nombre.$buscar_apellido.substr($buscar_identificacion,0,(strlen($buscar_identificacion)-3));
				//echo $buscar_todo;
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="etiqueta ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
				$cadena_sql.=" WHERE ";
				$cadena_sql.=$buscar_todo." ";
				$cadena_sql.="ORDER BY nombre";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="etiqueta ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
				$cadena_sql.="ORDER BY etiqueta ";	
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT ";
		$cadena_sql.="id_subsistema, ";
		$cadena_sql.="etiqueta ";				
		$cadena_sql.="FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
		$cadena_sql.="ORDER BY etiqueta ";	
		//echo $cadena_sql;
	}		
//	echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen subsistemas en el sistema*/
		?>
<table style="text-align: left;" width='100%' border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td ><span  style="font-weight: bold;">Actualmente no hay subsistemas registrados</span></td>
    </tr>
    </tbody>
</table>


<?php 
	}
	else
	{
/*Si existen subsistemas en el sistema*/
?><script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td >Informaci&oacute;n disponible de los siguientes subsistemas </td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php  echo $contador ?>, 'over', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php  echo $contador ?>, 'out', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php  echo $contador ?>, 'click', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');">
<td bgcolor="<?php  echo $tema->celda ?>">
<a href="<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('informacion_subsistema').'&id_subsistema='.$registro[$contador][0]; ?>"><?php  
echo $registro[$contador][1] 
?></a>
</td>
</tr><?php 
		}
	?>
</table>
<?php 			
  	}
}
?>
