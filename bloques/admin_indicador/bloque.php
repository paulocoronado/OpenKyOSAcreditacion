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
*****************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
include ($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();

if (is_resource($enlace))
{
	if(isset($_GET['ir_hoja']))
	{
		$_GET["hoja"]=($_GET['ir_hoja']-1);
		unset($_GET['ir_hoja']);
	}
	
	
	$variable="";
	//Envia todos los datos que vienen con GET
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='page')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}
	}
	
	
	
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
				
				$cadena_hoja="SELECT ";
				$cadena_hoja.="id_subsistema, ";
				$cadena_hoja.="codigo_componente, ";				
				$cadena_hoja.="instrumento ";				
				$cadena_hoja.="FROM ";
				$cadena_hoja.="".$configuracion["prefijo"]."subsistema_componente ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="id_subsistema=".$id_subsistema." ";
				$cadena_hoja.="ORDER BY codigo_componente ";
				
				
				$cadena_sql=$cadena_hoja;
				$cadena_sql.="LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];			
				
				
				//echo $cadena_sql;
				break;
			
			default:
				$cadena_hoja="SELECT ";
				$cadena_hoja.="id_subsistema, ";
				$cadena_hoja.="codigo_componente, ";				
				$cadena_hoja.="instrumento ";				
				$cadena_hoja.="FROM ";
				$cadena_hoja.="".$configuracion["prefijo"]."subsistema_componente ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="id_subsistema=".$id_subsistema." ";
				$cadena_hoja.="ORDER BY codigo_componente ";
				
				
				$cadena_sql=$cadena_hoja;
				$cadena_sql.="LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];			
				
				
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_hoja="SELECT ";
		$cadena_hoja.="id_subsistema, ";
		$cadena_hoja.="codigo_componente, ";				
		$cadena_hoja.="instrumento ";				
		$cadena_hoja.="FROM ";
		$cadena_hoja.="".$configuracion["prefijo"]."subsistema_componente ";
		$cadena_hoja.="WHERE ";
		$cadena_hoja.="id_subsistema=".$id_subsistema." ";
		$cadena_hoja.="ORDER BY codigo_componente ";
		
		
		$cadena_sql=$cadena_hoja;
		$cadena_sql.="LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];			
		
		
		//echo $cadena_sql;
	}		
	//echo $cadena_sql."<br>";
	$acceso_db->registro_db($cadena_hoja,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	$todos=$campos;
	if($campos>0)
	{
		$hoja=ceil($campos/$configuracion['registros'])-1;
		//echo $hoja;
	}
	else
	{
		$hoja=0;
	
	}
	
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
						tabla($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema,$nombre_subsistema);
						break;
					case 1:
						informe($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema,$nombre_subsistema);
						break;
					case 2:
						taller($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema,$nombre_subsistema);	
						break;
					default:
						break;		
				}
				
				
			}
		}
	?>
</table><br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo $_GET["hoja"] ?>" href="<?php
	$variable="";
	
	//Envia todos los datos que vienen con GET
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='page' && $clave!='hoja')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}
		else
		{
			if($clave=='hoja')
			{
				$variable.="&".$clave."=".($val-1);
				//echo $variable;
			}
			
		}
		
	}
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_indicador');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>"><< Anterior</a>
	<?php	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	<form method="GET"><?php
	$variable="";
	
	//Envia todos los datos que vienen con GET
	reset ($_GET);
	
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='hoja' && $clave!='aceptar')
		{
			$variable.="<input type='hidden' name='".$clave."' value='".$val."'>\n";
			//echo $clave;
		}
	}
	echo $variable;
	echo "Hoja  <input type='text' name='ir_hoja' size='2' maxlength='4' value='".($_GET["hoja"]+1)."'> de ".($hoja+1);	
	echo "<br>Mostrando: ".$campos." de ".$todos;
	?>	 
	</form>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?php
	if($_GET["hoja"]<$hoja)
	{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo $_GET["hoja"]+2 ?>" href="<?php
			$variable="";
			
			//Envia todos los datos que vienen con GET
			reset ($_GET);
			while (list ($clave, $val) = each ($_GET)) 
			{
				
				if($clave!='page' && $clave!='hoja')
				{
					$variable.="&".$clave."=".$val;
					//echo $clave;
				}
				else
				{
					if($clave=='hoja')
					{
						$variable.="&".$clave."=".($val+1);
						//echo $variable;
					}
					
				}
				
			}
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_indicador');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>">Siguiente>></a>
<?php
	}
?>
	</td>
</tr>
</table>
<?php			
  	}
}


function informe($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema,$nombre_subsistema)
{
	//Enlazar a la pagina indicador la cual desde la version 1.0.0.3 es independiente del subsistema
	
?><tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php echo $contador ?>, 'over', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php echo $contador ?>, 'out', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php echo $contador ?>, 'click', '<?php echo $tema->celda ?>', '<?php echo $tema->apuntado ?>', '<?php echo $tema->seleccionado ?>');">
	<td bgcolor="<?php echo $tema->celda ?>" align="center">
	<a href="#" onclick="abrir_ventana('<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_indicador').'&indicador='.$registro[$contador][1]; ?>','informacion')">
	<?php 
	echo $registro[$contador][1]
	?></a>
	</td>
	<td bgcolor="<?php echo $tema->celda ?>"><?php 
echo $registro_componente[0][0] 
?></a>
</td>
<td bgcolor="<?php echo $tema->celda ?>" align="center">
<a href='<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('informe_indicador')."&accion=1&hoja=0&indicador=".$registro[$contador][1] ?>'>
<img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/informe.png" alt="Administrar Informes" title="Administrar Informes" border="0" />
</a>
</td>
</tr><?php	
}


function tabla($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema,$nombre_subsistema)
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





function taller($configuracion,$registro,$el_usuario,$registro_componente,$contador,$acceso_db,$id_programa,$tema,$nombre_subsistema)
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
