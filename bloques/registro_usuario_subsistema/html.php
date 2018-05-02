<?PHP  
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?PHP  
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
?><?PHP  
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
	
		
	if(isset($_GET['registro']))
	{
		
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
	
				$cadena_hoja="SELECT ";
				$cadena_hoja.="id_subsistema,"; 
				$cadena_hoja.="etiqueta "; 
				$cadena_hoja.="FROM "; 
				$cadena_hoja.="".$configuracion["prefijo"]."subsistema ";
				$cadena_hoja.=" ORDER BY etiqueta ";
				
				$cadena_sql=$cadena_hoja;
				
		
	}
	else
	{
		exit;
	}		
	//echo $cadena_sql."<br>";
	//echo $cadena_hoja."<br>";
	//Primero obtener el numero de hojas
	$acceso_db->registro_db($cadena_hoja,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
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
		?>
<table style="text-align: left;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
  <tr>
      <td >
      		<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
					</td>
					<td align="left">
						<b>Actualmente no hay subsistemas registrados.</b>
					</td>
				</tr>
		</table>
      
      </td>
    </tr>  
</table><?PHP  

		
	}
	else
	{

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="registrar_artefacto_artefacto">
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td width="75%">Nombre</td>
<td>Estado</td>
</tr>
	<?PHP  
		for($contador=0;$contador<$campos;$contador++)
		{			
			$busqueda="SELECT ";
			$busqueda.=$configuracion["prefijo"]."usuario_subsistema.id_subsistema, ";
			$busqueda.=$configuracion["prefijo"]."usuario_subsistema.id_usuario ";
			$busqueda.="FROM ";
			$busqueda.=$configuracion["prefijo"]."usuario_subsistema ";
			$busqueda.="WHERE ";
			$busqueda.="id_usuario=".desenlace($_GET["registro"])." ";
			$busqueda.="AND ";
			$busqueda.="id_subsistema=".$registro[$contador][0];
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$la_artefacto=$acceso_db->obtener_registro_db();
			$total_artefacto=$acceso_db->obtener_conteo_db();
			
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?PHP   echo $contador ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $contador ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $contador ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>"><?PHP   echo $registro[$contador][1] ?></a></td>
<?PHP  
			if($total_artefacto>0)
			{
				if($registro[$contador][0]==3)
				{
					$busqueda="SELECT ";
					$busqueda.=$configuracion["prefijo"]."usuario_programa.id_programa, ";
					$busqueda.=$configuracion["prefijo"]."usuario_programa.id_usuario ";
					$busqueda.="FROM ";
					$busqueda.=$configuracion["prefijo"]."usuario_programa ";
					$busqueda.="WHERE ";
					$busqueda.="id_usuario=".desenlace($_GET["registro"])." ";
					$busqueda.="LIMIT 1";
					$acceso_db->registro_db($busqueda,0);
					$el_programa=$acceso_db->obtener_registro_db();
					$total_programa=$acceso_db->obtener_conteo_db();
					if($total_programa>0)
					{
						$programa=$el_programa[0][0];
					}
					else
					{
						$programa=0;
					
					}
				}
				else
				{
					$programa=0;
				}	
?>				
<td bgcolor="<?PHP   echo $tema->celda ?>" align="center">
	<input checked="checked" name="subsistema"  value="<?PHP   echo $registro[$contador][0]; ?>" type="radio">
</td>
<?PHP  
			}
			else
			{
?>
<td bgcolor="<?PHP   echo $tema->celda ?>" align="center" >
	<input name="subsistema"  value="<?PHP   echo $registro[$contador][0]; ?>" type="radio">
</td>
<?PHP  			} ?>
</tr><?PHP  	
	}
// Botones de navegacion
?>
</table>
<br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?PHP  $variable="";
	
		//Envia todos los datos que vienen con GET
		reset ($_GET);
		$oculto="";
		while (list ($clave, $val) = each ($_GET)) {
			
			
			if($clave!='page' && $clave!='hoja')
			{
				$variable.="&".$clave."=".$val;
				if($clave!='asociar' && $clave!='terminar' && $clave!='actualizar' )
				{
					$oculto.="<input type='hidden' name='".$clave."' value='".$val."'>\n";
				}
				
				//echo $clave;
			}
			else
			{
				if($clave=='hoja')
				{
					$variable.="&".$clave."=".($val-11);
					$oculto.="<input type='hidden' name='".$clave."' value='".$val."'>\n";
					
					//echo $variable;
				}
				
			}
			
		}
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?PHP   echo $_GET["hoja"] ?>" href="<?PHP  
	$opcion=$configuracion["site"].'/index.php?page='.enlace('registro_usuario_subsistema');
	$opcion.=$variable; 
	echo $opcion;

?>"><< Anterior</a>
	<?PHP  	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	Hoja <?PHP   echo $_GET['hoja']+1; ?> de <?PHP   echo $hoja+1; ?>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?PHP  	$variable="";
	
		//Envia todos los datos que vienen con GET
		reset ($_GET);
		$oculto="";
		while (list ($clave, $val) = each ($_GET)) {
			
			
			if($clave!='page' && $clave!='hoja')
			{
				$variable.="&".$clave."=".$val;
				if($clave!='asociar' && $clave!='terminar' && $clave!='actualizar' )
				{
					$oculto.="<input type='hidden' NAME='".$clave."' VALUE='".$val."'>\n";
				}
				
				//echo $clave;
			}
			else
			{
				if($clave=='hoja')
				{
					$variable.="&".$clave."=".($val+1);
					$oculto.="<input type='hidden' NAME='".$clave."' VALUE='".$val."'>\n";
					
					//echo $variable;
				}
				
			}
			
		}

		if($_GET["hoja"]<$hoja)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?PHP   echo $_GET["hoja"]+2 ?>" href="<?PHP  
		
	$opcion=$configuracion["site"].'/index.php?page='.enlace('registro_usuario_subsistema');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>">Siguiente>></a>
<?PHP  
	}
?>
</td>
</tr>
</table>
<br>
<hr>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
  <tr class="mensajealertaencabezado">
      <td align="center">
      Informaci&oacute;n del programa:
      </td>
  </tr>    
    <tr class="bloquecentralcuerpo">
      <td class="celdatabla" align="center"><?PHP  
      	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
	$html=new html();
	$busqueda="SELECT ";
	$busqueda.="id_programa,";
	$busqueda.="nombre_corto ";
	$busqueda.="FROM ";
	$busqueda.="".$configuracion["prefijo"]."programa ";
	$busqueda.="ORDER BY nombre_corto";
	if(isset($programa))
	{
		$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,$programa,0,0);
	}
	else
	{
		$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,0,0);
	}
	echo $mi_cuadro;
?>
</td>
    </tr>
    </tbody>
</table><br>
<table width="200px" align="center" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
<tbody>
<tr>
<td align="center">
	<input type='submit' name='terminar' value='Terminar' title='Asociar el subsistema y programa seleccionados' /><br>
</td>
</tr>
</tbody>	
</table>
<?PHP   echo $oculto; ?>
<input type='hidden' name='action' value='registro_usuario_subsistema'>
</form>
<?PHP  
  }
}
?>
