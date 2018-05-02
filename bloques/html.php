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
<script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php  
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	if(isset($_GET['accion']))
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
	
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos las preguntas
			case '1':
				
				$cadena_hoja="SELECT ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.nombre,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.comentario,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.estado,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."registrado.nombre ";
				$cadena_hoja.="FROM "; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta, ";
				$cadena_hoja.="".$configuracion["prefijo"]."registrado ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario=".$el_usuario;
				$cadena_hoja.=" AND ";
				$cadena_hoja.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
				$cadena_hoja.=" AND ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				$cadena_hoja.=" ORDER BY ".$configuracion["prefijo"]."pregunta.nombre ";
				
				$cadena_sql="SELECT ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.nombre,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.comentario,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.estado,"; 
				$cadena_sql.="".$configuracion["prefijo"]."registrado.nombre ";
				$cadena_sql.="FROM "; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta, ";
				$cadena_sql.="".$configuracion["prefijo"]."registrado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario=".$el_usuario;
				$cadena_sql.=" AND ";
				$cadena_sql.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
				$cadena_sql.=" AND ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."pregunta.id_pregunta ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				
				//echo $cadena_sql;
				break;
			
			//Filtrados	
			case '2':
				
				// Para las fechas
				
				for($contador=1;$contador<3;$contador++)
				{
					if(isset($_GET["dia_".$contador]))
					{
						$dia[$contador]=$_GET["dia_".$contador]*1;
							
					}
					else
					{
						$dia[$contador]=0;				
					}
					
					if(isset($_GET["mes_".$contador]))
					{
						$mes[$contador]=$_GET["mes_".$contador]*1;
							
					}
					else
					{
						$mes[$contador]=0;				
					}
					
					if(isset($_GET["anno_".$contador]))
					{
						$anno[$contador]=$_GET["anno_".$contador]*1;
							
					}
					else
					{
						$anno[$contador]=0;				
					}
					
					$fecha[$contador]=mktime(0,0,0,$mes[$contador],$dia[$contador],$anno[$contador]);
				}
				
				//Se tienen dos fechas
				if($fecha[2]==0)
				{
					$fecha[2]=time();
				}
				
				$condicion="";
				
				if($fecha[2]>$fecha[1])
				{
					$condicion.="(".$configuracion["prefijo"]."pregunta.fecha_creacion>".$fecha[1]." AND ".$configuracion["prefijo"]."pregunta.fecha_creacion<=".$fecha[2].") AND";
				}
				
				//Para el autor
				if(isset($_GET["autor"]))
				{
					$id_autor=$_GET["autor"]*1;
					
					if($id_autor>0)
					{
						$condicion.="(".$configuracion["prefijo"]."pregunta.id_usuario=".$id_autor.") AND";					
					}
					
				}
				
				//Para nombre
				
				if(isset($_GET['busqueda']))
				{
					if(trim($_GET['busqueda'])!="")
					{
					$buscar=explode(" ",$_GET['busqueda']);
					$buscar_nombre='(';
							
					while (list ($clave, $val) = each ($buscar)) 
					{
						$buscar_nombre.="".$configuracion["prefijo"]."pregunta.nombre like '%".$val."%' OR ";
					}
					
					$condicion.=substr($buscar_nombre,0,(strlen($buscar_nombre)-3)).") AND";
					}		
				}			
							
				$cadena_hoja="SELECT ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.nombre,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.comentario,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.estado,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."registrado.nombre ";
				$cadena_hoja.="FROM "; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta, ";
				$cadena_hoja.="".$configuracion["prefijo"]."registrado ";
				$cadena_hoja.="WHERE ";
				
				
				if($condicion!="")
				{
					$cadena_hoja.=substr($condicion,0,(strlen($condicion)-3));
					$cadena_hoja.=" AND ";
					$cadena_hoja.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
					$cadena_hoja.=" AND ";
					$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				}
				else
				{
					$cadena_hoja.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
					$cadena_hoja.=" AND ";
					$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				}
				
				$cadena_sql="SELECT ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.nombre,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.comentario,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.estado,"; 
				$cadena_sql.="".$configuracion["prefijo"]."registrado.nombre ";
				$cadena_sql.="FROM "; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta, ";
				$cadena_sql.="".$configuracion["prefijo"]."registrado ";
				$cadena_sql.="WHERE ";
							
				if($condicion!="")
				{
					$cadena_sql.=substr($condicion,0,(strlen($condicion)-3));
					$cadena_sql.=" AND ";
					$cadena_sql.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
					$cadena_sql.=" AND ";
					$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				}
				else
				{
					$cadena_sql.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
					$cadena_sql.=" AND ";
					$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				}
				
				
				$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."pregunta.fecha_creacion ";
				
				if(isset($_GET['orden'])) //Si se ha definido un orden se supone que es descendente
				{
					$cadena_sql.=" DESC LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				}
				else
				{
					$cadena_sql.=" ASC LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				}
				
				break;	
					
						
			default:
				
				$cadena_hoja="SELECT ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.nombre,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.comentario,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.estado,"; 
				$cadena_hoja.="".$configuracion["prefijo"]."registrado.nombre ";
				$cadena_hoja.="FROM "; 
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta, ";
				$cadena_hoja.="".$configuracion["prefijo"]."registrado ";
				$cadena_hoja.="WHERE ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario=".$el_usuario;
				$cadena_hoja.=" AND ";
				$cadena_hoja.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
				$cadena_hoja.=" AND ";
				$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				$cadena_hoja.=" ORDER BY ".$configuracion["prefijo"]."pregunta.nombre ";
				
				$cadena_sql="SELECT ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.nombre,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.comentario,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.estado,"; 
				$cadena_sql.="".$configuracion["prefijo"]."registrado.nombre ";
				$cadena_sql.="FROM "; 
				$cadena_sql.="".$configuracion["prefijo"]."pregunta, ";
				$cadena_sql.="".$configuracion["prefijo"]."registrado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario=".$el_usuario;
				$cadena_sql.=" AND ";
				$cadena_sql.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
				$cadena_sql.=" AND ";
				$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
				$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."pregunta.id_pregunta ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
		$cadena_hoja="SELECT ";
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.nombre,"; 
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.comentario,"; 
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.estado,"; 
		$cadena_hoja.="".$configuracion["prefijo"]."registrado.nombre ";
		$cadena_hoja.="FROM "; 
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta, ";
		$cadena_hoja.="".$configuracion["prefijo"]."registrado ";
		$cadena_hoja.="WHERE ";
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario=".$el_usuario;
		$cadena_hoja.=" AND ";
		$cadena_hoja.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
		$cadena_hoja.=" AND ";
		$cadena_hoja.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
		$cadena_hoja.=" ORDER BY ".$configuracion["prefijo"]."pregunta.nombre ";
		
		$cadena_sql="SELECT ";
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_pregunta,"; 
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.nombre,"; 
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.fecha_creacion, ";
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.comentario,"; 
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario,"; 
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.estado,"; 
		$cadena_sql.="".$configuracion["prefijo"]."registrado.nombre ";
		$cadena_sql.="FROM "; 
		$cadena_sql.="".$configuracion["prefijo"]."pregunta, ";
		$cadena_sql.="".$configuracion["prefijo"]."registrado ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario=".$el_usuario;
		$cadena_sql.=" AND ";
		$cadena_sql.="( ".$configuracion["prefijo"]."pregunta.tipo =0 OR ".$configuracion["prefijo"]."pregunta.tipo =1 ) ";
		$cadena_sql.=" AND ";
		$cadena_sql.="".$configuracion["prefijo"]."pregunta.id_usuario = ".$configuracion["prefijo"]."registrado.id_usuario ";
		$cadena_sql.=" ORDER BY ".$configuracion["prefijo"]."pregunta.id_pregunta ";
		$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
		//echo $cadena_sql;
	}		
	//echo $cadena_sql;
	//echo $cadena_hoja;
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
		/*No existen preguntas en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay preguntas registradas en el sistema</td>
    </tr>
    </tbody>
</table>


<?php  

		
	}
	else
	{
/*Si existen preguntas en el sistema*/
?><form method="POST" action="index.php" name="registrar_instrumento_pregunta" onsubmit="return ()">
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td width="75%">Nombre</td>
<td>Estado</td>
<td>Posici&oacute;n</td>
</tr>
	<?php  
		for($contador=0;$contador<$campos;$contador++)
		{
			//realizar la busqueda para ver si la pregunta esta asociada al instrumento
			$busqueda="SELECT ";
			$busqueda.=" id_elemento,orden ";
			$busqueda.="FROM ";
			$busqueda.="".$configuracion["prefijo"]."p_borrador ";
			$busqueda.="WHERE ";
			$busqueda.="id_elemento=".$registro[$contador][0];
			$busqueda.=" AND ";
			$busqueda.="id_sesion='".$esta_sesion."'";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$la_pregunta=$acceso_db->obtener_registro_db();
			$total_pregunta=$acceso_db->obtener_conteo_db();
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><a title="No:<?php   echo $registro[$contador][0] ?> Creada por: <?php   echo $registro[$contador][6] ?> el <?php   echo $fecha=date( "d-m-y",$registro[$contador][2]) ?> "><?php   echo $registro[$contador][1] ?></a></td>
<?php  
			if($total_pregunta>0)
			{
?>
<td align="center" class="celdatabla">
	<input checked="checked" name="ELEMENTO_<?PHP   echo $registro[$contador][0]; ?>"  value="1" type="checkbox">
</td>
<td align="center" class="celdatabla">
	<input size='3' maxlength='6' name="ORDEN_<?PHP   echo $registro[$contador][0]; ?>" value="<?php   echo $la_pregunta[0][1]; ?>">
</td>
<?php  
			}
			else
			{
?>
<td align="center" class="celdatabla">
	<input name="ELEMENTO_<?PHP   echo $registro[$contador][0]; ?>"  value="1" type="checkbox">
</td>
<td align="center" class="celdatabla">
	<input size='3' maxlength='6' name="ORDEN_<?PHP   echo $registro[$contador][0]; ?>">
</td>

<?php  			}
?></tr><?php  	
	}
// Botones de navegacion
?>
</table>
<br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php  
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php   echo $_GET["hoja"] ?>" href="<?php  
	$opcion=$configuracion["site"].'/index.php?page='.enlace('registro_formulario_pregunta');
	$opcion.=$variable; 
	echo $opcion;

?>"><< Anterior</a>
	<?php  	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	<input type='submit' name='asociar' value='Asociar' title='Asociar las preguntas seleccionadas' /><br>
	</td>
	<td align="right" class="celdatabla" width="33%">
	<?php  	$variable="";
	
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
	<a title="Pasar a la p&aacute;gina No <?php   echo $_GET["hoja"]+2 ?>" href="<?php  
		
	$opcion=$configuracion["site"].'/index.php?page='.enlace('registro_formulario_pregunta');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>">Siguiente>></a>
<?php  
	}
?>
</td>
</tr>
</table>
<?php   echo $oculto; ?>
<input type='hidden' name='action' value='registro_formulario_pregunta'>
<br><hr>
<table  width='100%' align='center'>
<tbody>
<tr>
<td style='text-align:center'>
<input type='submit' name='terminar' value='Terminar' title='Continuar con el siguiente paso' /></td>
</tr>
<tr>
<td style='text-align:left;color:rgb(0, 0, 100);'>
<font  size='1'> Recuerde: Pulse Terminar solo cuando haya seleccionado todas las preguntas que componen su instrumento.
</font>
</td>
</tr>
</tbody>
</table>		
<?php  //Preguntas actualmente asociadas al instrumento?>
<hr><br>
<table width="100%" class="bloquelateral" cellpadding="5" cellspacing="1">
<tr class="mensajealertaencabezado">
<td colspan="3">Preguntas asociadas al instrumento</td>
</tr>
<tr class="mensajealertaencabezado">
<td align="center">Nombre</td>
<td align="center">Estado</td>
<td align="center">Orden</td>
</tr>
<?php  
$busqueda="SELECT ";
$busqueda.=" ".$configuracion["prefijo"]."p_borrador.id_elemento,";
$busqueda.="".$configuracion["prefijo"]."p_borrador.orden, ";
$busqueda.="".$configuracion["prefijo"]."pregunta.nombre ";
$busqueda.="FROM ";
$busqueda.="".$configuracion["prefijo"]."p_borrador,".$configuracion["prefijo"]."pregunta ";
$busqueda.="WHERE ";
$busqueda.="id_sesion='".$esta_sesion."' ";
$busqueda.="AND ";
$busqueda.="".$configuracion["prefijo"]."p_borrador.id_elemento=".$configuracion["prefijo"]."pregunta.id_pregunta ";
$busqueda.=" ORDER BY ".$configuracion["prefijo"]."p_borrador.orden ASC";

//echo $busqueda;
$acceso_db->registro_db($busqueda,0);
$la_pregunta=$acceso_db->obtener_registro_db();
$total_pregunta=$acceso_db->obtener_conteo_db();
if($total_pregunta>0)
{
	for($contador=0;$contador<$total_pregunta;$contador++)
	{
?>
<tr class="bloquecentralcuerpo">
<td align="left" class="celdatabla">
<?php   echo $la_pregunta[$contador][2]; ?>
</td>
	<td align="center" class="celdatabla">
	<input checked="checked" name="ACTUAL_ELEMENTO_<?PHP   echo $la_pregunta[$contador][0]; ?>"  value="1" type="checkbox">
</td>
<td align="center" class="celdatabla">
	<input size='3' maxlength='6' name="ACTUAL_ORDEN_<?PHP   echo $la_pregunta[$contador][0]; ?>" value="<?php   echo ($contador+1); ?>">
</td>
</tr>
<?php  	}
}
else
{
?>

<?php  			}
?></table><br>
<table  width='100%' align='center'>
<tbody>
<tr>
<td style='text-align:center'>
<input type='submit' name='actualizar' value='Actualizar' title='Continuar con el siguiente paso' /></td>
</tr>
</tbody>
</table>
</form>
<?php  
  }
}
?>
