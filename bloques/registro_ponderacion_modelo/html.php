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
* @description  Formulario principal para ponderar modelos de evaluacion/seguimiento a la gestion
* @usage        
******************************************************************************/ 
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

$fila=0;
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();

if (is_resource($enlace))
{
	if(isset($_GET["id_esquema"]))
	{
		$esquema=$_GET["id_esquema"];
		
		$cadena_sql="SELECT ";
		$cadena_sql.="`id_esquema`, ";
		$cadena_sql.="`id_usuario`, ";
		$cadena_sql.="`id_modelo`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`descripcion`, ";
		$cadena_sql.="`observacion`, ";
		$cadena_sql.="`fecha`, ";
		$cadena_sql.="`tipo_esquema` ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."esquema_ponderacion "; 
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_esquema=".$esquema." ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);				
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$modelo=$registro[0][2];	
			$tipo_esquema=$registro[0][7];
		}
		else
		{
			exit;
		}
		
	}
	else
	{
		//Modelo por defecto
		$modelo=0;
	}
	
	$sesion=new sesiones($configuracion);
	$sesion->especificar_enlace($enlace);
	$mi_sesion=$sesion->numero_sesion();
		
	//Rescatar todos los componentes del modelo.
	$cadena_sql="SELECT ";
	$cadena_sql.="MAX(nivel) ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."modelo_componente ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_modelo=".$modelo." ";
	//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
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
			$nivel=0;
			$total=$registro[0][0];
			rescatar_componente($modelo,$nivel,$padre,$total,$acceso_db,$sesion,$configuracion,$tipo_esquema);
			echo "</tbody>\n";
			echo "</table>\n";
			
		
	}
	else
	{
		echo "No existe un modelo de evaluaci&oacute;n definido.";	
	}

}
	
	
function rescatar_componente($modelo,$nivel,$padre,$total,$acceso_db,$sesion,$configuracion,$tipo_esquema)
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
			$codigo_componente=$modelo;
			$codigo_componente.="_".$registro_componente[$a][0];			
			$codigo_componente.="_".$nivel;
			$codigo_componente.="_".$padre;
			
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
					$opciones.="&id_esquema=".$_GET["id_esquema"];
					echo $configuracion["host"].$configuracion["site"].'/index.php?page='.$_GET['page'].$opciones; 
					echo "'><img width='12' height='12' src='";
					echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"];
					echo "/menos.png' alt='Ver componentes' title='Ver componentes' border='0' /></a>";
					echo "</td>\n";
					
					echo "<td bgcolor='".$tema->seleccionado."'>\n";
					echo "<b>".$registro_componente[$a][1]."</b>";
					echo "</td>\n";
					
					echo "<td width='1%' bgcolor='".$tema->seleccionado."'>\n";
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
					rescatar_componente($modelo,($nivel+1),$registro_componente[$a][0],$total,$acceso_db,$sesion,$configuracion,$tipo_esquema);		
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
					$opciones.="&id_esquema=".$_GET["id_esquema"];		
					echo $configuracion["host"].$configuracion["site"].'/index.php?page='.$_GET['page'].$opciones; 
					echo "'><img width='12' height='12' src='";
					echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"];
					echo "/mas.png' alt='Ver componentes' title='Ver componentes' border='0' /></A>";
					echo "</td>\n";
					echo "<td bgcolor='".$tema->celda."'>\n";
					echo "<b>".$registro_componente[$a][1]."</b>";
					echo "</td>\n";
					
					echo "<td width='1%' bgcolor='".$tema->seleccionado."'>\n";
					echo "<a href='";
						
					$ruta=$configuracion["host"].$configuracion["site"]."/index.php?";
					
					if($tipo_esquema==0)
					{
						$opciones="page=".enlace('tabla_ponderacion_basico');
					}
					else
					{
						$opciones="page=".enlace('tabla_ponderacion_estructural');
					}
					$opciones.="&id_esquema=".$_GET["id_esquema"];
					$opciones.="&id_componente=".$codigo_componente;
					
					echo $ruta.$opciones; 		
							
					echo "'\>Ponderar</a>";				
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
				echo "";				
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

	
?> 
