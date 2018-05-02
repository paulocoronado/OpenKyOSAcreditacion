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
	
	if(isset($_GET['accion']))
	{
		$indicador=$_GET['accion'];
	}
	else
	{
		echo "Imposible realizar la acci&oacute;n solicitada. Por favor revise sus privilegios.";
		exit;
	}
	
	//Rescatar los codigos del componente, se ingresan todos los valores en na matriz unidimensional de n filas
	
	include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	
	$fila=0;
	echo "<table class='bloquelateral' cellpadding=5 cellspacing=0>\n<tbody>\n";
	echo "<tr class='bloquecentralencabezado'>\n<td align='justify'>\n Componentes";
	echo "</td>\n</tr>\n";
	echo "<tr class='bloquecentralcuerpo'>\n<td align='justify'>\n";
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	
	if (is_resource($enlace))
	{
		for($contador=0;$contador < strlen($indicador);$contador+=3)
		{
			//Componente
			$componente=substr($indicador,$contador,3);
			$componente*=1;
			
			if($componente==0)
			{		
				$componente=substr($indicador,$contador,3);
				$total="";
				for($count=2;$count>=0;$count--)
				{
					$valor=substr($componente,$count,1);
					if($valor!='0')
					{
						$total=$valor.$total;
					}
			
				}
				$componente=$total;
			}
			//Padre
			if($contador>0)
			{
				$componente_padre=substr($indicador,($contador-3),3);
				//echo "<br>Padre:".$componente_padre."<br>";
				$componente_padre*=1;
				
				if($componente_padre==0)
				{		
					$componente_padre=substr($indicador,($contador-3),3);
					$total="";
					for($count=2;$count>=0;$count--)
					{
						$valor=substr($componente_padre,$count,1);
						if($valor!='0')
						{
							$total=$valor.$total;
						}
				
					}
					$componente_padre=$total;
				}
			}	
			else
			{
				$componente_padre=0;
			}
			
			//echo $componente."<br>";
			//echo $componente_padre."<br>";
			
			$cadena_sql="SELECT id_componente,nombre,valor ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."modelo_componente ";
			$cadena_sql.="WHERE id_componente='".$componente."' ";
			$cadena_sql.=" AND nivel=".($fila+1);
			$cadena_sql.=" AND id_padre='".$componente_padre."'";				
			//echo $cadena_sql;
			
				if($acceso_db->registro_db($cadena_sql,0))
				{
					//Obtener el registro con el resultado de la busqueda			
					$registro=$acceso_db->obtener_registro_db();
					//Obtener el total de registros devueltos por la consulta
					$campos=$acceso_db->obtener_conteo_db();
					
					if($campos>0)
					{
						echo "<table cellpadding='5' cellspacing='0'>\n<tbody>\n";
						for($los_campos=1;$los_campos<3;$los_campos++)
						{
							echo "<tr class='bloquecentralcuerpo'>\n<td align='justify'>\n";
							if($los_campos==1)
							{
								echo "<b>".$registro[0][$los_campos]."</b><br>";
							}
							else
							{	
								echo $registro[0][$los_campos]."<br>";
							}
							echo "</td>\n</tr>\n";
							
						}
						echo "</tbody>\n</table>\n";
						echo "<br>";
					}
					else
					{
						echo "El c&oacute;digo del componente no es v&aacute;lido";	
					}
			
				}
				else
				{
					echo "No se logr&oacte; rescatar una secci&oacte;n v&aacute;lida";
				}
			
		
			$fila++;
			
		}
		
		echo "</td>\n</tr>\n";
		echo "</tbody>\n</table>\n";
//Si se recarga con un mensaje de error
		if(isset($_GET['error']))
		{
			if($_GET['error']==TRUE)
			{?><br>
<table class="bloquelateral" align="center" cellpadding="5" cellspacing="1" width="100%" >
<tbody>
<tr class="bloquecentralcuerpo">
<td class="celdatabla" colspan="2">
Error al registrar el documento.
</td>
</tr>
</tbody>
</table>			
			
			<?php  }
		
		}
		
		// Rescatar el tipo de instrumento que esta asociado al indicador
		$cadena_sql="SELECT instrumento ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."subsistema_componente ";
		$cadena_sql.="WHERE codigo_componente='".$indicador."'";
		$cadena_sql.=" LIMIT 1";
		//echo $cadena_sql;
		if($acceso_db->registro_db($cadena_sql,0))
		{
			//Obtener el registro con el resultado de la busqueda			
			$registro=$acceso_db->obtener_registro_db();
			//Obtener el total de registros devueltos por la consulta
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				if($registro[0][0]==1)
				{
					
					$cadena_sql="SELECT nombre,observacion ";
					$cadena_sql.="FROM ".$configuracion["prefijo"]."informe ";
					$cadena_sql.="WHERE codigo_componente='".$indicador."'";
					$cadena_sql.=" AND id_programa=".$id_programa;
					$cadena_sql.=" LIMIT 1";
					//echo $cadena_sql;
					if($acceso_db->registro_db($cadena_sql,0))
					{
						//Obtener el registro con el resultado de la busqueda			
						$registro=$acceso_db->obtener_registro_db();
						//Obtener el total de registros devueltos por la consulta
						$campos=$acceso_db->obtener_conteo_db();
						if($campos>0)
						{
							//Mostrar un enlace al archivo, el nombre y la observacion
							?><br>
<table class="bloquelateral" align="center" cellpadding="5" cellspacing="1" width="100%" >
<tbody>
<tr class="bloquecentralcuerpo">
<td class="celdatabla" colspan="2">
Informe asociado al indicador:
</td>
<td class="celdatabla" colspan="2">
<?php   echo "<a href='".$configuracion["host"].$configuracion["site"]."/documento/".$registro[0][0]."'>".$registro[0][0]."</a>";?>
</td>
</tr>
<tr class="bloquecentralcuerpo">
<td class="celdatabla" colspan="2">
Descripci&oacute;n:
</td>
<td class="celdatabla" colspan="2">
<?php   echo $registro[0][1]; ?>
</td>
</tr><?php  
							echo "</tbody>\n";
							echo "</table>\n";
							
						}
						else
						{
							//Mostrar un formulario para ingresar el informe
							?><br>
<form enctype="multipart/form-data" action='index.php' method='POST'>
<table class="bloquelateral" align="center" cellpadding="5" cellspacing="1" width="100%" >
<tbody>
<tr class="bloquecentralcuerpo">
<td class="celdatabla" colspan="2">
Informe asociado al indicador:
</td>
</tr>
<tr class="bloquecentralcuerpo">
<td class="celdatabla" valign="top" align="left">
<font color="red">*</font>Archivo a registrar:<br>
</td>
<td class="celdatabla" colspan="2" align="left">
<input type='hidden' name='action' value='indicador'>
<input type='hidden' name='accion' value='<?php   echo $_GET['accion']?>'>
<input type='hidden' name='usuario' value='<?php   echo $_GET['usuario'] ?>'>
<input name='archivo' type='file' tabindex='3'>
</td>
</tr>
<tr class="bloquecentralcuerpo">
<td class="celdatabla" valign="top" align="left">
<font color="red">*</font>Descripci&oacute;n:<br>
</td>
<td class="celdatabla" align="left" valign="top">
<textarea cols="50" rows="2" name="descripcion" tabindex="2"></textarea><br>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input type='submit' value='Enviar' tabindex="4">
</td>
</tr>						
</tbody>
</table>
</form><?php  

						
						}
					}
					
					
				
				}
				
				
			}
		}
		else
		{
		
			echo "Se debe ingresar informacion en una tabla";
		
		}	
	
	}



?>
