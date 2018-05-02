<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 20 de noviembre de 2005

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formualrio para el registro de usuarios
* @usage        
******************************************************************************/ 
//Rescatar los componentes
if(isset($_GET["modelo"]))
{
	$modelo=$_GET["modelo"];
}
else
{
	$modelo=1;
}

$fila=0;
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();

if (is_resource($enlace))
{
	$sesion=new sesiones($configuracion);
	$sesion->especificar_enlace($enlace);
	$mi_sesion=$sesion->numero_sesion();
	
	
	//Rescatar todos los componentes del modelo.
	$cadena_sql="SELECT ";
	$cadena_sql.="MAX(nivel)";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."modelo_componente ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_modelo=".$modelo." ";
	$acceso_db->registro_db($cadena_sql,0);
	//Obtener el registro con el resultado de la busqueda			
	$registro=$acceso_db->obtener_registro_db();
	//Obtener el total de registros devueltos por la consulta
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		//echo "El modelo usado tiene ".$registro[0][0]." niveles.";
			echo "<table class='bloquelateral' border='0' cellpadding='4' cellspacing='1'>\n";
			echo "<tbody>\n";
			echo "<script src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/funciones.js' type='text/javascript' language='javascript'></script>\n";
			if(isset($_GET["componente"]))
			{
				if(isset($_GET["mas"]))
				{
					if($_GET["mas"]==1)
					{
						$sesion->guardar_valor_sesion($configuracion,"componente_".$_GET["componente"]."_".$_GET["nivel"],1,$mi_sesion);							
					}
					else
					{
						$sesion->borrar_valor_sesion($configuracion,"componente_".$_GET["componente"]."_".$_GET["nivel"],$mi_sesion);
					}
				}
			}
			$padre=0;
			$nivel=1;
			$total=$registro[0][0];
			rescatar_componente($modelo,$nivel,$padre,$total,$acceso_db,$sesion,$configuracion);
			echo "</tbody>\n";
			echo "</table>\n";
			
		
	}
	else
	{
		echo "No existe un modelo de evaluaci&oacute;n definido.";	
	}

}
	
	
function rescatar_componente($modelo,$nivel,$padre,$total,$acceso_db,$sesion,$configuracion)
{
	
	include ($configuracion["raiz_documento"].$configuracion["estilo"]."/basico/tema.php");
	$cadena_sql="SELECT ";
	$cadena_sql.="id_componente, ";
	$cadena_sql.="nombre,";
	$cadena_sql.="valor ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."modelo_componente ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="nivel=".$nivel." ";
	$cadena_sql.="AND id_padre=".$padre." ";
	$cadena_sql.="AND id_modelo=".$modelo." ";
	//echo $cadena_sql."<br>";
	//Busca todos los componentes de un determinado padre en el nivel
	$acceso_db->registro_db($cadena_sql,0);
	//Obtener el registro con el resultado de la busqueda			
	$registro_componente=$acceso_db->obtener_registro_db();
	//Obtener el total de registros devueltos por la consulta
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{
		for($a=0;$a<$campos;$a++)
		{
			//Armar elcodigo del componente
			//mmm nnn ppp iii -> modelo nivel padre identificador 
			$codigo_componente=rellenar_cadena($modelo);
			$codigo_componente.=rellenar_cadena($nivel);
			$codigo_componente.=rellenar_cadena($padre);
			$codigo_componente.=rellenar_cadena($registro_componente[$a][0]);
			
			if($nivel<$total)
			{	
				if($sesion->rescatar_valor_sesion($configuracion,"componente_".$registro_componente[$a][0]."_".$nivel) )
				{
					echo "<tr class='bloquecentralmostrar'>\n";
					
					echo "<td width='1%' bgcolor='".$tema->seleccionado."'>\n";
					echo "<a href='";
					$opciones="&componente=".$registro_componente[$a][0];
					$opciones.="&nivel=".$nivel;
					$opciones.="&mas=0";
					$opciones.="&mostrar=1";
					$opciones.="&registro=".$_GET["registro"];
					echo $configuracion["host"].$configuracion["site"].'/index.php?page='.$_GET['page'].$opciones; 
					echo "'><img width='12' height='12' src='";
					echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"];
					echo "/menos.png' alt='Ver componentes' title='Ver componentes' border='0' /></A>";
					echo "</td>\n";
					
					echo "<td bgcolor='".$tema->seleccionado."'>\n";
					echo "<b>".$registro_componente[$a][1]."</b>";
					echo "</td>\n";
					
					echo "<td width='1%' bgcolor='".$tema->seleccionado."'>\n";
					echo "<a href=\"#\" onclick=\"abrir_ventana('";	
					$opciones=$configuracion["host"].$configuracion["site"];
					$opciones.='index.php?page='.enlace('tabla_analisis');
					$opciones.="&id_proceso=".$_GET["registro"];
					$opciones.="&id_componente=".$codigo_componente;
					echo $opciones; 		
					echo "','tabla_analisis')\">Analizar</a>";				
					echo "</td>\n";
					echo "</tr>\n";
					
					echo "<tr class='bloquecentralcuerpo'>\n";
					
					echo "<td>\n";
					echo "</td>\n";
					
					echo "<td colspan='2'>\n";
					echo $registro_componente[$a][2];
					echo "</td>\n";
					
					echo "</tr>\n";
					unset($_GET["mas"]);
					rescatar_componente($modelo,($nivel+1),$registro_componente[$a][0],$total,$acceso_db,$sesion,$configuracion);		
				}
				else
				{
					echo "<tr class='bloquecentralmostrar'>\n";
					echo "<td bgcolor='".$tema->celda."' width='1%'>\n";
					echo "<a href='";
					$opciones="&componente=".$registro_componente[$a][0];
					$opciones.="&nivel=".$nivel;
					$opciones.="&mas=1";
					$opciones.="&mostrar=1";
					$opciones.="&registro=".$_GET["registro"];		
					echo $configuracion["host"].$configuracion["site"].'/index.php?page='.$_GET['page'].$opciones; 
					echo "'><img width='12' height='12' src='";
					echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"];
					echo "/mas.png' alt='Ver componentes' title='Ver componentes' border='0' /></A>";
					echo "</td>\n";
					echo "<td bgcolor='".$tema->celda."'>\n";
					echo "<b>".$registro_componente[$a][1]."</b>";
					echo "</td>\n";
					
					echo "<td width='1%' bgcolor='".$tema->seleccionado."'>\n";
					echo "<a href=\"#\" onclick=\"abrir_ventana('";	
					$opciones= $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('tabla_analisis');
					$opciones.="&id_proceso=".$_GET["registro"];
					$opciones.="&id_componente=".$codigo_componente;
					echo $opciones; 		
					echo "','tabla_analisis')\">Analizar</a>";				
					echo "</td>\n";
					
					echo "</tr>\n";
					
					echo "<tr class='bloquecentralcuerpo'>\n";
					echo "<td>\n";
					echo "</td>\n";
					echo "<td colspan='2'>\n";
					echo $registro_componente[$a][2];
					echo "</td>\n";
					echo "</tr>\n";
				}
			}
			else
			{
				echo "<tr class='bloquecentralmostrar'>\n";
				echo "<td bgcolor='".$tema->celdacontenido."'>\n";
				echo "</td>\n";
				echo "<td bgcolor='".$tema->celdacontenido."'>\n";
				echo "<b>".$registro_componente[$a][1]."</b>";
				echo "</td>\n";
				echo "<td width='1%' bgcolor='".$tema->seleccionado."'>\n";
				echo "<a href=\"#\" onclick=\"abrir_ventana('";	
				$opciones=$configuracion["site"].'/index.php?page='.enlace('tabla_analisis');
				$opciones.="&id_proceso=".$_GET["registro"];
				$opciones.="&id_componente=".$codigo_componente;
				echo $opciones; 		
				echo "','tabla_analisis')\">Analizar</a>";				
				echo "</td>\n";
				echo "</tr>\n";
				
				echo "<tr class='bloquecentralcuerpo'>\n";
				echo "<td>\n";
				echo "</td>\n";
				echo "<td colspan='2'>\n";
				echo $registro_componente[$a][2];
				echo "</td>\n";
				echo "</tr>\n";
			}

		}
		
	}
	else
	{
		return FALSE;		
	}
	return TRUE;
}

function rellenar_cadena($cadena)
{
	
	$tamanno_cadena=strlen($cadena);
	
	for($a=$tamanno_cadena;$a<3;$a++)
	{
		
		$cadena="0".$cadena;
	}
	
	return $cadena;
}
	

	
?> 
