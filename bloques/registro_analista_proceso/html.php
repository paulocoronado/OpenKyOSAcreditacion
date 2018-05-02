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
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	
	exit;		
	}
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
		
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
			//Todos los procesos
			case '1':
				
				$cadena_hoja="SELECT ";
				$cadena_hoja.="id_proceso,"; 
				$cadena_hoja.="nombre "; 
				$cadena_hoja.="FROM "; 
				$cadena_hoja.="".$configuracion["prefijo"]."proceso ";
				$cadena_hoja.=" ORDER BY nombre ";
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_proceso,"; 
				$cadena_sql.="nombre, "; 
				$cadena_sql.="fecha_creacion "; 
				$cadena_sql.="FROM "; 
				$cadena_sql.="".$configuracion["prefijo"]."proceso ";
				$cadena_sql.=" ORDER BY nombre ";
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
					$condicion.="(".$configuracion["prefijo"]."artefacto.fecha_creacion>".$fecha[1]." AND ".$configuracion["prefijo"]."artefacto.fecha_creacion<=".$fecha[2].") AND ";
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
						$buscar_nombre.="nombre like '%".$val."%' OR ";
					}
					
					$condicion.=substr($buscar_nombre,0,(strlen($buscar_nombre)-3)).") AND";
					}		
				}			
							
				$cadena_hoja="SELECT ";
				$cadena_hoja.="id_proceso,"; 
				$cadena_hoja.="nombre "; 
				$cadena_hoja.="FROM "; 
				$cadena_hoja.="".$configuracion["prefijo"]."proceso ";
				$cadena_hoja.="WHERE ";
				
				
				if($condicion!="")
				{
					$cadena_hoja.=substr($condicion,0,(strlen($condicion)-3));
				}
				else
				{
					$cadena_hoja.="1 ";
				}
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_proceso,"; 
				$cadena_sql.="nombre, "; 
				$cadena_sql.="fecha_creacion "; 
				$cadena_sql.="FROM "; 
				$cadena_sql.="".$configuracion["prefijo"]."proceso ";
				$cadena_sql.="WHERE ";
							
				if($condicion!="")
				{
					$cadena_sql.=substr($condicion,0,(strlen($condicion)-3));
				}
				else
				{
					$cadena_sql.="1 ";
				}
				
				
				$cadena_sql.=" ORDER BY fecha_creacion ";
				
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
				$cadena_hoja.="id_proceso,"; 
				$cadena_hoja.="nombre "; 
				$cadena_hoja.="FROM "; 
				$cadena_hoja.="".$configuracion["prefijo"]."proceso ";
				$cadena_hoja.=" ORDER BY nombre ";
				
				$cadena_sql="SELECT ";
				$cadena_sql.="id_proceso,"; 
				$cadena_sql.="nombre, ";
				$cadena_sql.="fecha_creacion ";  
				$cadena_sql.="FROM "; 
				$cadena_sql.="".$configuracion["prefijo"]."proceso ";
				$cadena_sql.=" ORDER BY nombre ";
				$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
		$cadena_hoja="SELECT ";
		$cadena_hoja.="id_proceso,"; 
		$cadena_hoja.="nombre "; 
		$cadena_hoja.="FROM "; 
		$cadena_hoja.="".$configuracion["prefijo"]."proceso ";
		$cadena_hoja.=" ORDER BY nombre ";
		
		$cadena_sql="SELECT ";
		$cadena_sql.="id_proceso,"; 
		$cadena_sql.="nombre, "; 
		$cadena_sql.="fecha_creacion "; 
		$cadena_sql.="FROM "; 
		$cadena_sql.="".$configuracion["prefijo"]."proceso ";
		$cadena_sql.=" ORDER BY nombre ";
		$cadena_sql.=" LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];
		//echo $cadena_sql;
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
		/*No existen preguntas en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay procesos registrados en el sistema</td>
    </tr>
    </tbody>
</table>


<?php  

		
	}
	else
	{
/*Si existen preguntas en el sistema*/
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="registrar_artefacto_artefacto">
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td width="75%">Nombre</td>
<td>Estado</td>
</tr>
	<?php  
		for($contador=0;$contador<$campos;$contador++)
		{
			//Buscar si el artefacto esta asociado al usuario. se deja aqui para 
			//futuras implementaciones con mas de un proceso asociado
			
			$busqueda="SELECT ";
			$busqueda.=" id_proceso,id_usuario,id_programa ";
			$busqueda.="FROM ";
			$busqueda.="".$configuracion["prefijo"]."analista_proceso ";
			$busqueda.="WHERE ";
			$busqueda.="id_usuario=".$_GET["registro"]." ";
			$busqueda.="AND ";
			$busqueda.="id_proceso=".$registro[$contador][0];
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$la_artefacto=$acceso_db->obtener_registro_db();
			$total_artefacto=$acceso_db->obtener_conteo_db();
			
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this,<?php   echo $contador ?>, 'over', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php   echo $contador ?>, 'out', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php   echo $contador ?>, 'click', '<?php   echo $tema->celda ?>', '<?php   echo $tema->apuntado ?>', '<?php   echo $tema->seleccionado ?>');">
<td bgcolor="<?php   echo $tema->celda ?>"><a title="No:<?php   echo $registro[$contador][0] ?> Creado el <?php   echo $fecha=date( "d-m-y",$registro[$contador][2]) ?> "><?php   echo $registro[$contador][1] ?></a></td>
<?php  
			if($total_artefacto>0)
			{
				$programa=$la_artefacto[0][2];
?>
<td bgcolor="<?php   echo $tema->celda ?>" align="center">
	<input checked="checked" name="proceso"  value="<?php   echo $registro[$contador][0]; ?>" type="radio">
</td>
<?php  
			}
			else
			{
?>
<td bgcolor="<?php   echo $tema->celda ?>" align="center" >
	<input name="proceso"  value="<?php   echo $registro[$contador][0]; ?>" type="radio">
</td>
<?php  			} ?>
</tr><?php  	
	}
// Botones de navegacion
?>
</table>
<br>
<table width="100%" cellpadding="2" cellspacing="2" class="bloquelateral">
<tr class="bloquecentralcuerpo">
	<td align="left" class="celdatabla" width="33%">
	<?php  $variable="";
	
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
					$variable.="&".$clave."=".($val-11);
					$oculto.="<input type='hidden' NAME='".$clave."' VALUE='".$val."'>\n";
					
					//echo $variable;
				}
				
			}
			
		}
		if($_GET["hoja"]>0)
		{
	?>
	<a title="Pasar a la p&aacute;gina No <?php   echo $_GET["hoja"] ?>" href="<?php  
	$opcion=$configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analista_proceso');
	$opcion.=$variable; 
	echo $opcion;

?>"><< Anterior</a>
	<?php  	} 
	?>
	</td>
	<td align="center" class="celdatabla">
	Hoja <?php   echo $_GET['hoja']+1; ?> de <?php   echo $hoja+1; ?>
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
		
	$opcion=$configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('analista_proceso');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>">Siguiente>></a>
<?php  
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
      <td class="celdatabla" align="center"><?php  
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
	<input type='submit' name='terminar' value='Terminar' title='Asociar el proceso y programa seleccionados' /><br>
</td>
</tr>
</tbody>	
</table>
<?php   echo $oculto; ?>
<input type='hidden' name='action' value='registro_analista_proceso'>
</form>
<?php  
  }
}
?>
