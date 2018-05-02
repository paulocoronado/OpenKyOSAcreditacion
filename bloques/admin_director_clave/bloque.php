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

//La variable $_GET['usuario'] contiene el npmbre del programa que esta editando la información...
// puede tomarse esa informacion desde la variable de sesion correspondiente TODO


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

	if(isset($_POST['clave_proceso']))
	{
		$total=trim($_POST["clave_proceso"]);
		$total=($total/1);
		$proceso=$_POST["proceso"];
		$artefacto=$_POST["artefacto"];
		$fecha=time();
		for($j=0;$j<$total;$j++)
		{
			$numero="";
			$letra="";
			
			for($i=0;$i<4;$i++)
			{
				$numero.=rand(0,9);
				$letra.=chr(rand(65,90));
				
			}
			$clave=$letra.$numero;
			$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."clave ";
			$cadena_sql.="(";
			$cadena_sql.="clave,";
			$cadena_sql.="id_proceso,";
			$cadena_sql.="id_artefacto,";
			$cadena_sql.="fecha";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES(";
			$cadena_sql.="'".$clave."',";
			$cadena_sql.=$proceso.", ";
			$cadena_sql.=$artefacto.", ";
			$cadena_sql.=$fecha.")";
			
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
			//echo $resultado."<br>";
			
			if($resultado==FALSE)
			{
					$j--;
			}
			
		}
		
		$variable="&proceso=".$_POST["proceso"];
		$variable.="&artefacto=".$_POST["artefacto"];
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('admin_director_clave').$variable."')</script>";   
	
	}
?>
<script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php 
	$cadena_sql="SELECT clave,fecha ";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."clave ";
	if(isset($_GET["artefacto"]))
	{
		$cadena_sql.=" WHERE id_proceso=".$_GET["proceso"];
		$cadena_sql.=" AND id_artefacto=".$_GET["artefacto"];
	}
	else
	{
		$cadena_sql.=" WHERE id_proceso=".$_POST["proceso"];
		$cadena_sql.=" AND id_artefacto=".$_POST["artefacto"];
	
	}
	$cadena_sql.=" ORDER BY clave ";
	
			
	//echo $cadena_sql;
	//echo $cadena_hoja;
	//Primero obtener el numero de hojas
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen preguntas en el sistema*/
		?>
<table style="text-align:left; width:100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay claves registradas para este instrumento.</td>
    </tr>
    </tbody>
</table>
<form method="post" action="index.php" name="registro_artefacto" onsubmit="return (  control_vacio(this,'nombre') && verificar_rango(this,  'componentes',  1,15))">
<input type="hidden" name= "action" value="admin_director_clave">
<?php 
	if(isset($_GET["artefacto"]))
	{
?>
<input type="hidden" name="artefacto" value="<?php  echo $_GET["artefacto"]; ?>">
<input type="hidden" name="proceso" value="<?php  echo $_GET["proceso"]; ?>">
<?php 
	}
	else
	{
?>
<input type="hidden" name="artefacto" value="<?php  echo $_POST["artefacto"]; ?>">
<input type="hidden" name="proceso" value="<?php  echo $_POST["proceso"]; ?>">
<?php 
	}
?>
<br>
<table width="300px" border="0" cellpadding="5" cellspacing="1" align="center" class="bloquelateral">
<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
		Generar:<br>
	</td>
	<td class="celdatabla">
		<input maxlength="6" size="5" tabindex="1" name="clave_proceso"> Claves.
	</td>
</tr>
<tr align="center">
	<td  colspan="2">
		<input name="aceptar" value="Aceptar" type="submit" tabindex="2"><br>
	</td>
</tr>
</tbody>
</table>

<?php 

		
	}
	else
	{
/*Si existen claves en el sistema, se muestran en filas de 6 columnas*/
?><form method="post" action="index.php" name="registro_artefacto" onsubmit="return (  control_vacio(this,'nombre') && verificar_rango(this,  'componentes',  1,15))">
<input type="hidden" name= "action" value="admin_director_clave">
<?php 
	if(isset($_GET["artefacto"]))
	{
?>
<input type="hidden" name="artefacto" value="<?php  echo $_GET["artefacto"]; ?>">
<input type="hidden" name="proceso" value="<?php  echo $_GET["proceso"]; ?>">
<?php 
	}
	else
	{
?>
<input type="hidden" name="artefacto" value="<?php  echo $_POST["artefacto"]; ?>">
<input type="hidden" name="proceso" value="<?php  echo $_POST["proceso"]; ?>">
<?php 
	}
?>
<table align="center" width="300px" border="0" cellpadding="5" cellspacing="1" class="bloquelateral">
<tbody>
<tr class="bloquecentralcuerpo">
	<td class="celdatabla">
		Generar:<br>
	</td>
	<td class="celdatabla">
		<input maxlength="6" size="5" tabindex="1" name="clave_proceso"> Nuevas Claves.
	</td>
</tr>
<tr align="center">
	<td colspan="2">
		<input name="aceptar" value="Aceptar" type="submit" tabindex="2"><br>
	</td>
</tr>
</tbody>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
	<td colspan="7">
	<?php  echo (($campos/1)-1);?> claves asociadas al instrumento.
	</td>
</tr>
	<?php 
		
		$columna=0;
		for($contador=0;$contador<$campos;$contador++)
		{
			if($columna==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			echo "<td class='celdatabla' align='center'>\n";
			echo $registro[$contador][0];
			echo "</td>\n";
			$columna++;		
			if($columna==7)
			{
				echo "</tr>\n";
				$columna=0;				
			}
		}
		if($columna<7)
		{
			for($contador=$columna;$contador<7;$contador++)
			{
				echo "<td class='celdatabla' align='center'>\n";
				echo "</td>\n";
				$columna++;		
				if($columna==7)
				{
					echo "</tr>\n";
					$columna=0;				
				}
			}			
		}	
		
	}?>
</table><br>
<?php 			
  }
?>
