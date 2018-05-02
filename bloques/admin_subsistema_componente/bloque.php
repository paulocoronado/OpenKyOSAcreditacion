<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
****************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
****************************************************************************/
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
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		$el_usuario=$registro[0][0];
	}
	
	if(isset($_GET['accion']))
	{
		switch($_GET['accion'])
		{	
			//Todos los subsistemas
			case '1':
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="codigo_componente, ";				
				$cadena_sql.="instrumento ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema_componente ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_subsistema=".$_GET["id_subsistema"]." ";
				$cadena_sql.="ORDER BY codigo_componente ";
				//echo $cadena_sql;
				break;
			//Filtrados por cuadro de texto	
			case '2':
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="nombre ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="tipo=0 ";
				$cadena_sql.="ORDER BY nombre ";				
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
					$buscar_nombre.="nombre like '%".$val."%' OR ";	
				}
				
				$buscar_todo=$buscar_nombre.$buscar_apellido.substr($buscar_identificacion,0,(strlen($buscar_identificacion)-3));
				//echo $buscar_todo;
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="nombre ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema ";
				$cadena_sql.=" WHERE ";
				$cadena_sql.="(".$buscar_todo.") ";
				$cadena_hoja.="AND ";
				$cadena_hoja.="tipo=0 ";
				$cadena_sql.="ORDER BY nombre";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema, ";
				$cadena_sql.="codigo_componente, ";				
				$cadena_sql.="instrumento ";				
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."subsistema_componente ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_subsistema=".$_GET["id_subsistema"]." ";
				$cadena_sql.="ORDER BY codigo_componente ";	
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT ";
		$cadena_sql.="id_subsistema, ";
		$cadena_sql.="codigo_componente, ";				
		$cadena_sql.="instrumento ";				
		$cadena_sql.="FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."subsistema_componente ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_subsistema=".$_GET["id_subsistema"]." ";
		$cadena_sql.="ORDER BY codigo_componente ";	
		//echo $cadena_sql;
	}		
	//echo $cadena_sql."<br>";
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
      <td ><span  style="font-weight: bold;">Actualmente no hay informaci&oacute;n registrada</span></td>
    </tr>
    </tbody>
</table>


<?php
	}
	else
	{
/*Si existen subsistemas en el sistema*/
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td>C&oacute;digo</td>
<td width="85%">Indicador</td>
<td>Fuente</td>
</tr>
	<?php
		for($contador=0;$contador<$campos;$contador++)
		{
			
			$id_componente=substr($registro[$contador][1],8,1);
			$id_padre=substr($registro[$contador][1],3,3)/1;
			$cadena_sql="SELECT ";
			$cadena_sql.="valor ";
			$cadena_sql.="FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."modelo_componente ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_modelo=1 ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$id_padre." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_componente='".$id_componente."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="nivel=3";
			//echo $cadena_sql."<br>";
			$acceso_db->registro_db($cadena_sql,0);
			$registro_componente=$acceso_db->obtener_registro_db();
			$total=$acceso_db->obtener_conteo_db();
			if($total>0)
			{
				//De acuerdo al tipo de instrumento se obtiene la informacion del indicador
				//TODO indicadores que soporten multiples fuentes de informacion
				$sql="SELECT ";
				$sql.="id_programa ";
				$sql.="FROM ";
				$sql.=$configuracion["prefijo"]."analista_proceso ";
				$sql.="WHERE ";
				$sql.="id_usuario= ".$el_usuario;
				
				$acceso_db->registro_db($sql,0);
				$programa=$acceso_db->obtener_registro_db();
				$total_programa=$acceso_db->obtener_conteo_db();
				if($total_programa>0)
				{
					$id_programa=$programa[0][0];
				}
				
				switch($registro[$contador][2])
				{
					case 0:
						tabla($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema);
						break;
					case 1:
						informe($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema);
						break;
					case 2:
						taller($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema);	
						break;
					default:
						break;		
				}
				
				
			}
		}
	?>
</table>
<?php			
  	}
}


function informe($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema)
{

	$cadena_sql="SELECT ";
	$cadena_sql.="nombre, ";
	$cadena_sql.="nombre_interno ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."informe ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="codigo_componente='".$registro[$contador][1]."' ";
	//Si se trata de un subsistema de coordinacion
	if($_GET["id_subsistema"]==3)
	{
		$cadena_sql.= "AND id_programa=".$id_programa;
	
	}
	//echo $cadena_sql."<br>";
	$acceso_db->registro_db($cadena_sql,0);
	$registro_informe=$acceso_db->obtener_registro_db();
	$total_informe=$acceso_db->obtener_conteo_db();
	if($total_informe>0)
	{
?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
	<td bgcolor="<?php echo $tema->celda ?>" align="center"><?php 
	echo $registro[$contador][1]
	?></td>
	<td bgcolor="<?php echo $tema->celda ?>"><?php 
echo $registro_componente[0][0] 
?></a>
</td>
<td bgcolor="<?php echo $tema->celda ?>" align="center">
<a href='<?php echo $configuracion["host"].$configuracion["site"]."/documento/".$registro_informe[0][1] ?>'>
<b>Informe</b>
</a>
</td>
</tr><?php				}
				else
				{?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
<td bgcolor="<?php echo $tema->celda ?>" align="center"><?php 
echo $registro[$contador][1]
?></td>
<td bgcolor="<?php echo $tema->celda ?>">
<?php 
echo $registro_componente[0][0] 
?>
</td>
<td bgcolor="<?php echo $tema->celda ?>" align="center">
<b>Informe</b>
</a>
</td>
</tr>
				
				
				<?php}

}

function tabla($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema)
{		
?>	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
		<td bgcolor="<?php echo $tema->celda ?>" align="center"><?php 
		echo $registro[$contador][1]
		?></td>
		<td bgcolor="<?php echo $tema->celda ?>">
		<?php 
		echo $registro_componente[0][0] 
		?></td>
		<td bgcolor="<?php echo $tema->celda ?>" align="center">
		<a href="#" onclick="abrir_ventana('<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_informacion').'&id_componente='.$registro[$contador][1].'&id_programa='.$id_programa; ?>','informacion')">
		<b>Tabla</b>
		</a>
		</td>		
	</tr><?php
}





function taller($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema)
{
?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
<td bgcolor="<?php echo $tema->celda ?>" align="center"><?php 
echo $registro[$contador][1]
?></td>
<td bgcolor="<?php echo $tema->celda ?>"><?php 
echo $registro_componente[0][0]
?></td>
<td bgcolor="<?php echo $tema->celda ?>" align="center">
<a href="#" onclick="abrir_ventana('<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_informacion').'&id_componente=taller&id_programa='.$id_programa; ?>','informacion')">
<b>Taller
</a>
</td>
</tr><?php
}

?>
