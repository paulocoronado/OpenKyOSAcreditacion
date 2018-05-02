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
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 20 de noviembre de 2005

*******************************************************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formualrio para el registro de usuarios
* @usage        
*****************************************************************************************************************/ 
?><?PHP  
//Rescatar los componentes
if(isset($_GET["final"]))
{
	$final=$_GET["final"];
}
else
{
	$final=1;
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
	$cadena_sql.="MAX(nivel) ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."final_estructura ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_final=".$final." ";
	//echo $cadena_sql;
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
			if(isset($_GET["seccion"]))
			{
				if(isset($_GET["mas"]))
				{
					if($_GET["mas"]==1)
					{
						$sesion->guardar_valor_sesion($configuracion,"seccion_".$_GET["seccion"]."_".$_GET["nivel"],1,$mi_sesion);							
						//echo $mi_sesion."<br>";
					}
					else
					{
						$sesion->borrar_valor_sesion($configuracion,"seccion_".$_GET["seccion"]."_".$_GET["nivel"],$mi_sesion);
					}
				}
			}
			$padre=0;
			$nivel=1;
			$total=$registro[0][0];
			rescatar_componente($final,$nivel,$padre,$acceso_db,$sesion,$configuracion);
			echo "</tbody>\n";
			echo "</table>\n";
			
		
	}
	else
	{
		echo "No existe una estructura de informe de evaluaci&oacute;n definido.";	
	}

}
	
	
function rescatar_componente($final,$nivel,$padre,$acceso_db,$sesion,$configuracion)
{
	include ($configuracion["raiz_documento"].$configuracion["estilo"]."/basico/tema.php");
	
	$cadena_sql="SELECT ";
	$cadena_sql.="id_seccion, ";
	$cadena_sql.="nombre, ";
	$cadena_sql.="descripcion ";
	$cadena_sql.="FROM ";
	$cadena_sql.="".$configuracion["prefijo"]."final_estructura ";
	$cadena_sql.="WHERE ";
	$cadena_sql.="nivel=".$nivel." ";
	$cadena_sql.="AND id_padre=".$padre." ";
	$cadena_sql.="AND id_final=".$final." ";
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
			//mmm nnn ppp iii -> final nivel padre identificador 
			$codigo_componente=$registro_componente[$a][0];
			//Rescatar todos los componentes del modelo.
			$cadena_sql="SELECT ";
			$cadena_sql.="COUNT(nivel) ";
			$cadena_sql.="FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."final_estructura ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_final=".$final." ";
			$cadena_sql.="AND ";
			$cadena_sql.="nivel=".($nivel+1)." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$registro_componente[$a][0]." ";
			
			//echo $cadena_sql."<br>";
			$acceso_db->registro_db($cadena_sql,0);
			//Obtener el registro con el resultado de la busqueda			
			$registro_nivel=$acceso_db->obtener_registro_db();
			//Obtener el total de registros devueltos por la consulta
			$conteo=$acceso_db->obtener_conteo_db();
			if($conteo>0)
			{
				$total=$registro_nivel[0][0];
			}
			
			if($total>0)
			{	
				if($sesion->rescatar_valor_sesion($configuracion,"seccion_".$registro_componente[$a][0]."_".$nivel) )
				{
					
					echo "<tr class='bloquecentralmostrar'>\n";
					
					echo "<td width='1%' bgcolor='".$tema->seleccionado."'>\n";
					echo "<a href='";
					$opciones="&seccion=".$registro_componente[$a][0];
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
					
					echo "<td width='1%' bgcolor='".$tema->apuntado."'>\n";
					echo "<a href='#' onclick=\"abrir_ventana('";	
					$opciones=$configuracion["site"].'/index.php?page='.enlace('contenido_informe');
					$opciones.="&id_proceso=".$_GET["registro"];
					$opciones.="&id_seccion=".$codigo_componente;
					$opciones.="&nivel=".$nivel;
					$opciones.="&id_padre=".$padre;
					$opciones.="&id_final=".$final;
					echo $opciones; 		
					echo "','contenido_informe')\"/>Contenido</a>";				
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
					rescatar_componente($final,($nivel+1),$registro_componente[$a][0],$acceso_db,$sesion,$configuracion);		
				}
				else
				{
					echo "<tr class='bloquecentralmostrar'>\n";
					echo "<td bgcolor='".$tema->celda."' width='1%'>\n";
					echo "<a href='";
					$opciones="&seccion=".$registro_componente[$a][0];
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
					
					echo "<td width='1%' bgcolor='".$tema->apuntado."'>\n";
					echo "<a href='#' onclick=\"abrir_ventana('";	
					$opciones=$configuracion["site"].'/index.php?page='.enlace('contenido_informe');
					$opciones.="&id_proceso=".$_GET["registro"];
					$opciones.="&id_seccion=".$codigo_componente;
					$opciones.="&nivel=".$nivel;
					$opciones.="&id_padre=".$padre;
					$opciones.="&id_final=".$final;
					echo $opciones; 		
					echo "','contenido_informe')\"/>Contenido</a>";				
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
				echo "<td width='1%' bgcolor='".$tema->apuntado."'>\n";
				echo "<a href='#' onclick=\"abrir_ventana('";	
				$opciones=$configuracion["site"].'/index.php?page='.enlace('contenido_informe');
				$opciones.="&id_proceso=".$_GET["registro"];
				$opciones.="&id_seccion=".$codigo_componente;
				$opciones.="&nivel=".$nivel;
				$opciones.="&id_padre=".$padre;
				$opciones.="&id_final=".$final;
				echo $opciones; 		
				echo "','contenido_informe')\"/>Contenido</a>";				
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
