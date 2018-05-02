<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                       				   #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php
/****************************************************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 28/07/2006
*******************************************************************************************************************
* @subpackage   admin_dedicacion
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque para mostrar relacion de registros de dedicacion de los docentes
*
*****************************************************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$cadena_sql="SELECT ";
	$cadena_sql.="COUNT";
	$cadena_sql.="(";
	$cadena_sql.="id_modelo";
	$cadena_sql.=") ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."modelo ";	
	
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		//Error general
		exit;
	}
	else
	{
		$total_registro=$registro[0][0];
		unset($registro);
		
		if($total_registro==0)
		{
			sin_registro($configuracion);	
		
		}
		else
		{
			if(isset($_GET["hoja"]))
			{
				$hoja=$_GET["hoja"];
			}
			else
			{
				$hoja=1;
			}
			
			$hojas=(floor($campos/$configuracion["registros"])+1);
			
			if($hoja>$hojas)
			{
				$hoja=$hojas;
			}
			else
			{
				if($hoja<1)
				{
					$hoja=1;
				}
			}
			
			$cadena_hoja="SELECT ";
			$cadena_hoja.="id_modelo, ";
			$cadena_hoja.="nombre, ";
			$cadena_hoja.="nombre_corto ";
			$cadena_hoja.="FROM ";
			$cadena_hoja.=$configuracion["prefijo"]."modelo ";			
			$cadena_hoja.="LIMIT ".(($hoja-1)*$configuracion['registros']).",".$configuracion['registros'];
			//echo $cadena_hoja;
			$acceso_db->registro_db($cadena_hoja,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();			
			//Validacion redundante
			if($campos>0)
			{
				if(isset($_GET["admin"]))
				{
					if(desenlace($_GET["admin"])=="lista")
					{
						con_registro($configuracion,$registro,$campos);
						navegacion($configuracion,$hoja,$total_registro);
					}
				}
			}
			else
			{
				sin_registro($configuracion);			
			}
		}	
	}
}



/****************************************************************
*  			Funciones				*
****************************************************************/

function sin_registro($configuracion)
{
?><table style="text-align: left;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
	<tr>
		<td >
			<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
					</td>
					<td align="left">
						<b>No hay modelos de evaluaci&oacute;n o seguimiento de la gesti&oacute;n registrados.</b>
					</td>
				</tr>
			</table> 
		</td>
	</tr>  
</table><?php
}


function con_registro($configuracion,$registro,$campos)
{
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="seleccionar_modelo" onsubmit="return(funcion_ejemplo())">
	<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
		<tr align="center" class="mensajealertaencabezado">
			<td >
				C&oacute;digo
			</td>
			<td>
				Nombre del Modelo
			</td>
			<td>
				Selecci&oacute;n
			</td>
		</tr>
			<?php
	for($contador=0;$contador<$campos;$contador++)
	{
?>		<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
			<td align="center" class="celdatabla">
				<?php echo $registro[$contador][0] ?>
			</td>
			<td class="celdatabla">
				<input type="hidden" name= "nombre_modelo" value="<?echo $registro[$contador][2] ?>">
				<?php echo "<b>".$registro[$contador][2]."</b><br>".$registro[$contador][1] ?>
			</td>
			<td align="center" class="celdatabla"><?php//TODO: Implementar la funcionalidad de Borrar?>
				<input name="modelo"  value="<?php echo $registro[$contador][0]; ?>" type="radio" onclick="window.opener.campo_2.value=nombre_modelo.value;window.opener.campo.value=this.value; window.close()">
			</td>	
		</tr><?php
	}
?>	</table>
</form><?php
}

function navegacion($configuracion,$hoja,$total)
{
	$hojas=(floor($total/$configuracion["registros"])+1);

?><br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php
		if($hoja>1)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo ($hoja+1) ?>" href="<?php
	
	$variable="page=".enlace("seleccion_modelo");	
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='page' && $clave!='hoja')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}		
	}
	
	$variable.="&hoja=".($hoja-1);
	
	$variable=$configuracion["site"]."/index.php?".$variable;
	echo $variable;
	
	unset($clave);
	unset($val);
	unset($variable);
	
	

?>"><< Anterior</a>
	<?php	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	<script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script><?php
	
		$formulario="navegar";
		//Validacion de controles
		$validar="control_vacio(".$formulario.",'hoja')";
		$validar.="&&verificar_rango(".$formulario.",'hoja',1,".$hojas.")";
	
	?><form method="GET" name="navegar" onsubmit="return(<?php echo $validar; ?>)"><?php
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
	echo "Hoja  <input type='text' name='hoja' size='2' maxlength='4' value='".$hoja."'> de ".$hojas;	
	$inferior=(($configuracion["registros"]*($hoja-1))+1);
	$superior=(($configuracion["registros"]*($hoja-1))+25);
	if($superior>$total)
	{
		$superior=$total;
	}
	echo "<br>Registros: ".$inferior." - ".$superior." de ".$total;
	unset($inferior);
	unset($superior);
	?>	 
	</form>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?php
		if(($hoja+1)<$hojas)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php echo ($hoja+1) ?>" href="<?php
	$variable="page=".enlace("seleccion_modelo");	
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) 
	{
		
		if($clave!='page' && $clave!='hoja')
		{
			$variable.="&".$clave."=".$val;
			//echo $clave;
		}		
	}
	
	$variable.="&hoja=".($hoja+1);
	
	$variable=$configuracion["site"]."/index.php?".$variable;
	echo $variable;
	
	unset($clave);
	unset($val);
	unset($variable);

?>">Siguiente>></a>
<?php
	}
?>
	</td>
</tr>
</table><?php
}

?>
