<?php 
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php 
/****************************************************************************************************************
  
indicador.html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   
* @package	formulario
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* 
*
* Codigo HTML del formulario de autenticacion de usuarios
*
*****************************************************************************************************************/
?><?php 
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	
if(isset($_GET['indicador']))
{
	$indicador=$_GET['indicador'];
}
else
{
	echo "Imposible realizar la acci&oacute;n solicitada. Por favor revise sus privilegios.";
	exit;
}

include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	
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
	$cadena_hoja="SELECT ";
	$cadena_hoja.="`id_informe`, ";
	$cadena_hoja.="`id_subsistema`, ";
	$cadena_hoja.="`id_programa`, ";
	$cadena_hoja.="`codigo_componente`, ";
	$cadena_hoja.="`nombre`, ";
	$cadena_hoja.="`nombre_interno`, ";
	$cadena_hoja.="`observacion` ";
	$cadena_hoja.="FROM ";
	$cadena_hoja.=$configuracion["prefijo"]."informe ";
	$cadena_hoja.="WHERE ";
	$cadena_hoja.="codigo_componente='".$indicador."' ";
	$cadena_hoja.="AND ";
	$cadena_hoja.="id_programa=".$id_programa." ";
	
	$cadena_sql=$cadena_hoja;
	$cadena_sql.="LIMIT ".($_GET["hoja"]*$configuracion['registros']).",".$configuracion['registros'];			
	
	
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
	{?>
<table style="text-align: left;" width="100%" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td align="center"><b>No hay ning&uacute;n informe asociado.</b></td>
    </tr>
    </tbody>
</table>


<?php 
	}
	else
	{
?><script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td width="10%">C&oacute;digo</td>
<td>Nombre</td>
<td colspan="2">Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?php  echo $contador ?>, 'over', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?php  echo $contador ?>, 'out', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?php  echo $contador ?>, 'click', '<?php  echo $tema->celda ?>', '<?php  echo $tema->apuntado ?>', '<?php  echo $tema->seleccionado ?>');">
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
	<?php  echo $registro[$contador][0] ?>
</td>
<td bgcolor="<?php  echo $tema->celda ?>">
	<?php  echo $registro[$contador][4] ?>
</td>
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
	<a href="<?php 
	
	echo $configuracion["host"].$configuracion["site"].$configuracion["documento"]."/".$registro[$contador][5] 
	?>">
	<img width="24" height="24" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/informe.png" alt="Ver el informe" title="Ver el informe" border="0" />
	</a>
</td>
<td bgcolor="<?php  echo $tema->celda ?>" align="center">
	<a href="<?php 
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('borrar_informe');
	$opcion.=$variable; 
	$opcion.="&opcion=informe";
	$opcion.="&registro=".$registro[$contador][0];
	echo $opcion;
	
	?>">
	<img width="24" height="24" src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_borrar.png" alt="Borrar el informe" title="Borrar el informe" border="0" />
	</a>
</td>	
</tr><?php 
			
			
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
	<a title="Pasar a la p&aacute;gina No <?php  echo $_GET["hoja"] ?>" href="<?php 
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
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_informe');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>"><< Anterior</a>
	<?php 	} 
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
	<a title="Pasar a la p&aacute;gina No <?php  echo $_GET["hoja"]+2 ?>" href="<?php 
	$variable="";
	
	//Envia todos los datos que vienen con GET
	reset ($_GET);
	while (list ($clave, $val) = each ($_GET)) {
		
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
	
	$opcion=$configuracion["site"].'/index.php?page='.enlace('admin_informe');
	$opcion.=$variable;
	
	 
	 echo $opcion;

?>">Siguiente>></a>
<?php 
	}
?>
	</td>
</tr>
</table><?php 	}
	
}






