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
/***************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 28/07/2006
****************************************************************************
* @subpackage   admin_clasificacion_estructural
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque para mostrar el consolidado de resultados del analisis estructural
*
****************************************************************************/
?><?php
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
	//Cuando se trata de un esquema expuesto se tiene una variable GET con el usuario propietario
	if(isset($_GET["id_usuario"]))
	{
		$id_usuario=$_GET["id_usuario"];
	}
	else
	{
		//Rescatar el valor de la variable usuario de la sesion
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
		if($registro)
		{
			$id_usuario=$registro[0][0];
		}
	}
	$id_componente=$_GET["id_componente"];
	$id_esquema=$_GET["id_esquema"];
	
	//Diseccion del codigo de componente
	$componentes=explode("_",$id_componente);
		
	$mi_modelo=$componentes[0];
	$mi_componente=$componentes[1];
	$mi_nivel=$componentes[2];
	$mi_padre=$componentes[3];
	
	
	//Buscar componentes del siguiente nivel cuyo padre es $mi_componente
	$entidad=$configuracion["prefijo"]."modelo_componente";

	
	$cadena_sql="SELECT ";
	$cadena_sql.=$entidad.".`id_componente`, ";
	$cadena_sql.=$entidad.".`id_modelo`, ";
	$cadena_sql.=$entidad.".`nivel`, ";
	$cadena_sql.=$entidad.".`id_padre`, ";
	$cadena_sql.=$entidad.".`valor`, ";
	$cadena_sql.=$entidad.".`nombre` ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$entidad." "; 
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_padre=".$mi_componente." ";
	$cadena_sql.="AND ";
	$cadena_sql.="nivel=".($mi_nivel+1)." ";
	//echo $cadena_sql;
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	
	if($campos>0)
	{
	
		$incidencia=resumen_matriz($configuracion,$acceso_db,$registro,$tema,$id_usuario,$id_esquema);
		$clasificacion=clasificacion($configuracion,$incidencia,$campos,$tema);
		plano_cartesiano($configuracion,$clasificacion);
		
	}	
	
}



/****************************************************************
*  			Funciones				*
****************************************************************/

function resumen_matriz($configuracion,$acceso_db,$registro,$tema,$id_usuario,$id_esquema)
{
		$formulario="clasificar_estructural";
			
		//Calculo Actividad - Pasividad
		
		for($a=0;$a<(count($registro));$a++)
		{
			$incidencia["pasividad"][$a]=0;
			$incidencia["actividad"][$a]=0;
		}
		
		for($b=0;$b<(count($registro));$b++)
		{
			for($a=0;$a<(count($registro));$a++)
			{
				
				
				if($a!=$b)
				{
				
					$mi_componente_a=$registro[$a][1]."_".$registro[$a][0]."_".$registro[$a][2]."_".$registro[$a][3];
					$mi_componente_b=$registro[$b][1]."_".$registro[$b][0]."_".$registro[$b][2]."_".$registro[$b][3];
					
					//Buscar si esta registrado
					$cadena_sql="SELECT ";
					$cadena_sql.="`id_esquema`, ";
					$cadena_sql.="`id_usuario`, ";
					$cadena_sql.="`componente_a`, ";
					$cadena_sql.="`componente_b`, ";
					$cadena_sql.="`valor`, ";
					$cadena_sql.="`observacion`, ";
					$cadena_sql.="`fecha` ";
					$cadena_sql.="FROM ";
					$cadena_sql.=$configuracion["prefijo"]."esquema_valor ";
					$cadena_sql.="WHERE ";
					$cadena_sql.="id_esquema=".$id_esquema." ";
					$cadena_sql.="AND ";
					$cadena_sql.="componente_a='".$mi_componente_a."' ";
					$cadena_sql.="AND ";
					$cadena_sql.="componente_b='".$mi_componente_b."' ";
					$cadena_sql.="AND ";
					$cadena_sql.="id_usuario=".$id_usuario." ";	
					$cadena_sql.="LIMIT 1 ";
					
					//echo $cadena_sql;
					$acceso_db->registro_db($cadena_sql,0);
					$registro_ponderacion=$acceso_db->obtener_registro_db();
					$campos_ponderacion=$acceso_db->obtener_conteo_db();
					if($campos_ponderacion>0)
					{
						$ponderacion=$registro_ponderacion[0][4];
						$incidencia["actividad"][$a]+=$ponderacion;
						$incidencia["pasividad"][$b]+=$ponderacion;
						
					}
					else
					{
						$ponderacion=0;
					}					
				}
			}
		}
		
		$conteo_error=0;
		for($a=0;$a<(count($registro));$a++)
		{
			if($incidencia["pasividad"][$a]==0||$incidencia["actividad"][$a]==0)
			{
			
					error_clasificacion($configuracion,'media');
					exit;
			
			}
		}
		


?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?php echo $formulario ?>">
<table class='bloquelateral' align='center' width='100%' cellpadding='1px' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="0px" cellspacing="1px" class="tablaponderacion">		
		<tr class='bloquecentralcuerpo'><?php
		
		//Listado de Componentes - Encabezado
		for($a=0;$a<(count($registro)+1);$a++)
		{
			if($a!=0)
			{
?>			<td width="<?php echo floor(100/(count($registro)+2)) ?>%" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion" ><b><?php 
				echo ($a);
				?></b>
			</td>
			<?php
			}
			else
			{
?>			<td width="<?php echo floor(100/(count($registro)+2)) ?>%" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
			</td>
			<?php		
			}
		
		}
?>			<td width="<?php echo floor(100/(count($registro)+2)) ?>%" bgcolor='<?php echo $tema->clasificacion ?>' align="center" class="celdaponderacion">
				<b>MED.GEOM</b>
			</td>
		</tr><?php
		
		//Mostrar resumen Actividad
		
?>		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->clasificacion ?>' align="center" class="celdaponderacion">
				<b>Actividad</b>
			</td><?php
		$multiplicatoria=1;
		
		for($a=0;$a<count($registro);$a++)
		{
			if($incidencia["actividad"][$a]!=0)
			{
				$color=	$tema->clasificacion;	
			}
			else
			{
				$color=$tema->seleccionado;
			}
?>			
			<td bgcolor='<?php echo $color ?>' align="center" class="celdaponderacion" >
				<?php echo $incidencia["actividad"][$a]; $multiplicatoria*=$incidencia["actividad"][$a]; ?>
			</td>
			<?php
			
		
		}
			//Media Geometrica
?>			<td bgcolor='<?php echo $tema->seleccionado ?>' align="center" class="celdaponderacion">
				<?php 
				
				$incidencia["actividad"]["media"]=round(pow($multiplicatoria,(1/count($registro))),3);
				echo $incidencia["actividad"]["media"]; ?>
			</td>
		</tr><?php
				
		//Mostrar resumen Pasividad
?>		<tr class='bloquecentralcuerpo'>
			<td bgcolor='<?php echo $tema->clasificacion ?>' align="center" class="celdaponderacion">
				<b>Pasividad</b>
			</td><?php
		$multiplicatoria=1;
		
		for($a=0;$a<count($registro);$a++)
		{	
			if($incidencia["pasividad"][$a]!=0)
			{
				$color=	$tema->clasificacion;	
			}
			else
			{
				$color=$tema->seleccionado;
			}
?>			
			<td bgcolor='<?php echo $color ?>' align="center" class="celdaponderacion" >
				<?php echo $incidencia["pasividad"][$a]; $multiplicatoria*=$incidencia["pasividad"][$a]; ?>
			</td>
			<?php
			
		
		}
			//Media Geometrica
?>			<td bgcolor='<?php echo $tema->seleccionado ?>' align="center" class="celdaponderacion">
				<?php 
				$incidencia["pasividad"]["media"]=round(pow($multiplicatoria,(1/count($registro))),3);
				echo $incidencia["pasividad"]["media"]; ?>
			</td>
		</tr>		
	</table>
	</td>
	</tr>
</table>
</form><?php
	return $incidencia;
}

function plano_cartesiano($configuracion,$clasificacion)
{
	
	$sesion=new sesiones($configuracion);
	$id_sesion=$sesion->numero_sesion();
	
	
	
	
	//Coordenadas
	//Mayor actividad
	if(isset($clasificacion["activa"]["actividad"]))
	{
		arsort ($clasificacion["activa"]["actividad"]);	
		reset($clasificacion["activa"]["actividad"]);
		list($clave,$valor)=each($clasificacion["activa"]["actividad"]);
		$activa_y=$valor;
	}
	
	if(isset($clasificacion["critica"]["actividad"]))
	{
		arsort($clasificacion["critica"]["actividad"]);	
		reset($clasificacion["critica"]["actividad"]);
		list($clave,$valor)=each($clasificacion["critica"]["actividad"]);
		$critica_y=$valor;	
	}
	
	if(isset($activa_y)&&isset($critica_y))
	{
		if($activa_y>=$critica_y)
		{
			($mayor_actividad=$activa_y);
		}
		else
		{	
			($mayor_actividad=$critica_y);
		}
	}
	else
	{
		if(isset($activa_y))
		{
			($mayor_actividad=$activa_y);
		}
		else
		{
			($mayor_actividad=$critica_y);		
		}
	}		
	
	
	
	//Mayor pasividad
	if(isset($clasificacion["critica"]["pasividad"]))
	{
		arsort($clasificacion["critica"]["pasividad"]);	
		reset($clasificacion["critica"]["pasividad"]);
		list($clave,$valor)=each($clasificacion["critica"]["pasividad"]);
		$critica_x=$valor;
	}
	
	if(isset($clasificacion["reactiva"]["pasividad"]))
	{
		arsort($clasificacion["reactiva"]["pasividad"]);	
		reset($clasificacion["reactiva"]["pasividad"]);
		list($clave,$valor)=each($clasificacion["reactiva"]["pasividad"]);
		$reactiva_x=$valor;	
	}
	
	
	if(isset($critica_x)&&isset($reactiva_x))
	{
		if($critica_x>=$reactiva_x)
		{
			($mayor_pasividad=$critica_x);
		}
		else
		{	
			($mayor_pasividad=$reactiva_x);
		}
	}
	else
	{
		if(isset($critica_x))
		{
			($mayor_pasividad=$critica_x);
		}
		else
		{	
			($mayor_pasividad=$reactiva_x);
		}
		
	}	
	
	
	//Menor pasividad
	if(isset($clasificacion["activa"]["pasividad"]))
	{
		asort($clasificacion["activa"]["pasividad"]);	
		reset($clasificacion["activa"]["pasividad"]);
		list($clave,$valor)=each($clasificacion["activa"]["pasividad"]);
		$activa_x=$valor;
	}
	
	if(isset($clasificacion["indiferente"]["pasividad"]))
	{
		asort($clasificacion["indiferente"]["pasividad"]);	
		reset($clasificacion["indiferente"]["pasividad"]);
		list($clave,$valor)=each($clasificacion["indiferente"]["pasividad"]);
		$indiferente_x=$valor;	
	}
	
	
	if(isset($activa_x)&&isset($indiferente_x))
	{
		if($activa_x<=$indiferente_x)
		{
			($menor_pasividad=$activa_x);
		}
		else
		{	
			($menor_pasividad=$indiferente_x);
		}
	}
	else
	{
		if(isset($activa_x))
		{
			($menor_pasividad=$activa_x);
		}
		else
		{	
			if(isset($indiferente_x))
			{
				($menor_pasividad=$indiferente_x);
			}
			else
			{
				($menor_pasividad=0);//ojo!!!!
			}
		}
		
	}	
	
	
	//Menor actividad
	if(isset($clasificacion["reactiva"]["actividad"]))
	{
		asort($clasificacion["reactiva"]["actividad"]);	
		reset($clasificacion["reactiva"]["actividad"]);
		list($clave,$valor)=each($clasificacion["reactiva"]["actividad"]);
		$reactiva_y=$valor;
	}
	
	if(isset($clasificacion["indiferente"]["actividad"]))
	{
		asort($clasificacion["indiferente"]["actividad"]);	
		reset($clasificacion["indiferente"]["actividad"]);
		list($clave,$valor)=each($clasificacion["indiferente"]["actividad"]);
		$indiferente_y=$valor;	
	}
	
	if(isset($reactiva_y)&&isset($indiferente_y))
	{
		if($reactiva_y<=$indiferente_y)
		{
			($menor_actividad=$reactiva_y);
		}
		else
		{	
			($menor_actividad=$indiferente_y);
		}
	}
	else
	{
		if(isset($reactiva_y))
		{
			($menor_actividad=$reactiva_y);
		}
		else
		{	if(isset($indiferente_y))
			{
				($menor_actividad=$indiferente_y);
			}
			else
			{
				($menor_actividad=0);;//ojo!!!!
			}
			
		}
		
	}	
	
	//echo $menor_pasividad."<br>";
	//echo $menor_actividad."<br>";
	//echo $mayor_actividad."<br>";
	//echo $mayor_pasividad."<br>";
	
	
	$coordenada["x"][0]=$menor_pasividad;
	$coordenada["y"][0]=$mayor_actividad;
	
	$coordenada["x"][1]=$mayor_pasividad;
	$coordenada["y"][1]=$mayor_actividad;
	
	$coordenada["x"][2]=$menor_pasividad;
	$coordenada["y"][2]=$menor_actividad;
	
	$coordenada["x"][3]=$mayor_pasividad;
	$coordenada["y"][3]=$menor_actividad;
	
	//Para los puntos
	$i=0;
	$mult_actividad=1;
	$mult_pasividad=1;
	
	if(isset($clasificacion["activa"]["pasividad"]))
	{
		reset($clasificacion["activa"]["pasividad"]);
		while(list($clave,$valor)=each($clasificacion["activa"]["pasividad"]))
		{
			$punto["punto"][$i]=$clave;
			$punto["x"][$i]=$valor;
			$punto["y"][$i++]=$clasificacion["activa"]["actividad"][$clave];
			
			$mult_actividad*=$clasificacion["activa"]["actividad"][$clave];
			$mult_pasividad*=$clasificacion["activa"]["pasividad"][$clave];
		}
	}
	
	if(isset($clasificacion["critica"]["pasividad"]))
	{
	reset($clasificacion["critica"]["pasividad"]);
	while(list($clave,$valor)=each($clasificacion["critica"]["pasividad"]))
	{
		$punto["punto"][$i]=$clave;
		$punto["x"][$i]=$valor;
		$punto["y"][$i++]=$clasificacion["critica"]["actividad"][$clave];
		$mult_actividad*=$clasificacion["critica"]["actividad"][$clave];
		$mult_pasividad*=$clasificacion["critica"]["pasividad"][$clave];
	}
	}
	
	if(isset($clasificacion["indiferente"]["pasividad"]))
	{
		reset($clasificacion["indiferente"]["pasividad"]);
		while(list($clave,$valor)=each($clasificacion["indiferente"]["pasividad"]))
		{
			$punto["punto"][$i]=$clave;
			$punto["x"][$i]=$valor;
			$punto["y"][$i++]=$clasificacion["indiferente"]["actividad"][$clave];
			$mult_actividad*=$clasificacion["indiferente"]["actividad"][$clave];
			$mult_pasividad*=$clasificacion["indiferente"]["pasividad"][$clave];
		}
	}
	
	
	if(isset($clasificacion["reactiva"]["pasividad"]))
	{
		reset($clasificacion["reactiva"]["pasividad"]);
		while(list($clave,$valor)=each($clasificacion["reactiva"]["pasividad"]))
		{
			$punto["punto"][$i]=$clave;
			$punto["x"][$i]=$valor;
			$punto["y"][$i++]=$clasificacion["reactiva"]["actividad"][$clave];
			$mult_actividad*=$clasificacion["reactiva"]["actividad"][$clave];
			$mult_pasividad*=$clasificacion["reactiva"]["pasividad"][$clave];
		}
	}
	
	$eje["y"][0]=round(pow($mult_actividad,(1/($i))),3);
	$eje["x"][0]=round(pow($mult_pasividad,(1/($i))),3);
	
	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/grafico_estadistica.class.php");
	
	$graficar=new grafico_estadistica();
	$graficar->plano_cartesiano($configuracion,$coordenada,$punto,$id_sesion."plano",$eje);
	
?><br>
<table align='center' border='0' >
		<tr>
			<td>
				<img src='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["documento"]."/graficos/".$id_sesion."plano"?>.png'>
			</td>
		</tr>
	</table>
<?php
}

function clasificacion($configuracion,$incidencia,$campos,$tema)
{	
	$factorial=0;
	
	for($i=0;$i<$campos;$i++)
	{
		$factorial+=($i+1);
		if($incidencia["actividad"][$i]>$incidencia["actividad"]["media"] && $incidencia["pasividad"][$i]<$incidencia["pasividad"]["media"])
		{
			//Activa	
			$clasificacion["activa"]["componente"][$i+1]=($i+1);
			$clasificacion["activa"]["actividad"][$i+1]=$incidencia["actividad"][$i];
			$clasificacion["activa"]["pasividad"][$i+1]=$incidencia["pasividad"][$i];
			$clasificacion["activa"]["relacion"][$i+1]=round(($incidencia["actividad"][$i]/$incidencia["pasividad"][$i]),3);
			
		}
		else
		{
			if($incidencia["actividad"][$i]>=$incidencia["actividad"]["media"] && $incidencia["pasividad"][$i]>=$incidencia["pasividad"]["media"])
			{
				//Critica
				$clasificacion["critica"]["componente"][$i+1]=($i+1);
				$clasificacion["critica"]["actividad"][$i+1]=$incidencia["actividad"][$i];
				$clasificacion["critica"]["pasividad"][$i+1]=$incidencia["pasividad"][$i];
				$clasificacion["critica"]["relacion"][$i+1]=round(($incidencia["actividad"][$i]/$incidencia["pasividad"][$i]),3);
				
			}
			else
			{
				if($incidencia["actividad"][$i]<=$incidencia["actividad"]["media"] && $incidencia["pasividad"][$i]<$incidencia["pasividad"]["media"])
				{
					//Indiferente
					$clasificacion["indiferente"]["componente"][$i+1]=($i+1);
					$clasificacion["indiferente"]["actividad"][$i+1]=$incidencia["actividad"][$i];
					$clasificacion["indiferente"]["pasividad"][$i+1]=$incidencia["pasividad"][$i];
					$clasificacion["indiferente"]["relacion"][$i+1]=round(($incidencia["actividad"][$i]/$incidencia["pasividad"][$i]),3);
				}
				else
				{
				
					if($incidencia["actividad"][$i]<=$incidencia["actividad"]["media"] && $incidencia["pasividad"][$i]>=$incidencia["pasividad"]["media"])
					{
						//Reactivas
						$clasificacion["reactiva"]["componente"][$i+1]=($i+1);
						$clasificacion["reactiva"]["actividad"][$i+1]=$incidencia["actividad"][$i];
						$clasificacion["reactiva"]["pasividad"][$i+1]=$incidencia["pasividad"][$i];
						$clasificacion["reactiva"]["relacion"][$i+1]=round(($incidencia["actividad"][$i]/$incidencia["pasividad"][$i]),3);
					}
					else
					{
					
					
					
					
					
					
					
					}
				}
			}
		
		}
	}
	
	
	$fila_1="";
	$fila_2="";
	$fila_3="";
	$fila_4="";
	$fila_5="";
	
	$valoracion=$campos;
	
	if(isset($clasificacion["activa"]["relacion"]))
	{
		arsort ($clasificacion["activa"]["relacion"]);
		reset($clasificacion["activa"]["relacion"]);
		while(list($clave,$valor)=each($clasificacion["activa"]["relacion"]))
		{
			
			$fila_1.="<td bgcolor='".$tema->encabezado_tabla."' align='center' class='celdaponderacion' width='".floor(80/($campos))."%'>\n";
			$fila_1.="<b>".$clave."</b>\n";
			$fila_1.="</td>\n";
			
			$fila_2.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_2.=$clasificacion["activa"]["actividad"][$clave]."\n";
			$fila_2.="</td>\n";
			
			$fila_3.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_3.=$clasificacion["activa"]["pasividad"][$clave]."\n";
			$fila_3.="</td>\n";
			
			$fila_4.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_4.=$clasificacion["activa"]["relacion"][$clave]."\n";
			$fila_4.="</td>\n";
			
			$fila_5.="<td bgcolor='".$tema->seleccionado."' align='center' class='celdaponderacion'>\n";
			$fila_5.=round((($valoracion--*100)/$factorial))."%\n";
			$fila_5.="</td>\n";
			//echo $clave."->".$valor."<br>";
		}
		
	}
	
	
	
	
	
	if(isset($clasificacion["critica"]["relacion"]))
	{
		arsort($clasificacion["critica"]["relacion"]);	
		reset($clasificacion["critica"]["relacion"]);		
		while(list($clave,$valor)=each($clasificacion["critica"]["relacion"]))
		{
			
			$fila_1.="<td bgcolor='".$tema->encabezado_tabla."' align='center' class='celdaponderacion' width='".floor(80/($campos))."%'>\n";
			$fila_1.="<b>".$clave."</b>\n";
			$fila_1.="</td>\n";
			
			$fila_2.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_2.=$clasificacion["critica"]["actividad"][$clave]."\n";
			$fila_2.="</td>\n";
			
			$fila_3.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_3.=$clasificacion["critica"]["pasividad"][$clave]."\n";
			$fila_3.="</td>\n";
			
			$fila_4.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_4.=$clasificacion["critica"]["relacion"][$clave]."\n";
			$fila_4.="</td>\n";
			
			$fila_5.="<td bgcolor='".$tema->seleccionado."' align='center' class='celdaponderacion'>\n";
			$fila_5.=round((($valoracion--*100)/$factorial))."%\n";
			$fila_5.="</td>\n";
			//echo $clave."->".$valor."<br>";
		}
	}	
	
	if(isset($clasificacion["indiferente"]["relacion"]))
	{
		arsort($clasificacion["indiferente"]["relacion"]);	
		reset($clasificacion["indiferente"]["relacion"]);		
		while(list($clave,$valor)=each($clasificacion["indiferente"]["relacion"]))
		{
			
			$fila_1.="<td bgcolor='".$tema->encabezado_tabla."' align='center' class='celdaponderacion' width='".floor(80/($campos))."%'>\n";
			$fila_1.="<b>".$clave."</b>\n";
			$fila_1.="</td>\n";
			
			$fila_2.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_2.=$clasificacion["indiferente"]["actividad"][$clave]."\n";
			$fila_2.="</td>\n";
			
			$fila_3.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_3.=$clasificacion["indiferente"]["pasividad"][$clave]."\n";
			$fila_3.="</td>\n";
			
			$fila_4.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_4.=$clasificacion["indiferente"]["relacion"][$clave]."\n";
			$fila_4.="</td>\n";
			
			$fila_5.="<td bgcolor='".$tema->seleccionado."' align='center' class='celdaponderacion'>\n";
			$fila_5.=round((($valoracion--*100)/$factorial))."%\n";
			$fila_5.="</td>\n";
			//echo $clave."->".$valor."<br>";
		}
	}
	
	if(isset($clasificacion["reactiva"]["relacion"]))
	{
		arsort($clasificacion["reactiva"]["relacion"]);	
		reset($clasificacion["reactiva"]["relacion"]);	
		while(list($clave,$valor)=each($clasificacion["reactiva"]["relacion"]))
		{
			
			$fila_1.="<td bgcolor='".$tema->encabezado_tabla."' align='center' class='celdaponderacion' width='".floor(80/($campos))."%'>\n";
			$fila_1.="<b>".$clave."</b>\n";
			$fila_1.="</td>\n";
			
			$fila_2.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_2.=$clasificacion["reactiva"]["actividad"][$clave]."\n";
			$fila_2.="</td>\n";
			
			$fila_3.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_3.=$clasificacion["reactiva"]["pasividad"][$clave]."\n";
			$fila_3.="</td>\n";
			
			$fila_4.="<td bgcolor='".$tema->clasificacion."' align='center' class='celdaponderacion'>\n";
			$fila_4.=$clasificacion["reactiva"]["relacion"][$clave]."\n";
			$fila_4.="</td>\n";
			
			$fila_5.="<td bgcolor='".$tema->seleccionado."' align='center' class='celdaponderacion'>\n";
			$fila_5.=round((($valoracion--*100)/$factorial))."%\n";
			$fila_5.="</td>\n";
			//echo $clave."->".$valor."<br>";
		}
	}
	
	
	
	//Mostrar la tabla de resultados
?><br>
<script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" >
<table class='bloquelateral' align='center' width='100%' cellpadding='1px' cellspacing='0'>
	<tr>
	<td>
	<table width="100%" border="0" align="center" cellpadding="0px" cellspacing="1px" class="tablaponderacion">		
		<tr class='bloquecentralcuerpo' align="center">
			<td rowspan="2" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
				<b>Variable</b>
			</td><?php
			if(isset($clasificacion["activa"]["relacion"]))
			{
		
?>			<td colspan="<?php echo count($clasificacion["activa"]["relacion"])?>" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
				<b>Activas</b>
			</td><?php
			}			
			if(isset($clasificacion["critica"]["relacion"]))
			{
		
?>			<td colspan="<?php echo count($clasificacion["critica"]["relacion"])?>" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
				<b>Cr&iacute;ticas</b>
			</td><?php
			}
			if(isset($clasificacion["indiferente"]["relacion"]))
			{
		
?>			<td colspan="<?php echo count($clasificacion["indiferente"]["relacion"])?>" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
				<b>Indiferentes</b>
			</td><?php
			}
			if(isset($clasificacion["reactiva"]["relacion"]))
			{
		
?>			
			<td colspan="<?php echo count($clasificacion["reactiva"]["relacion"])?>" bgcolor='<?php echo $tema->encabezado_tabla ?>' align="center" class="celdaponderacion">
				<b>Reactivas</b>
			</td><?php
			}	
?>			
		</tr><?php	
		
		
	for($i=0;$i<5;$i++)
	{
?>		<tr class='bloquecentralcuerpo'><?php
		switch($i)
		{
			case 0:			
			echo $fila_1;
			break;
			
			case 1:		
?>			<td bgcolor='<?php echo $tema->clasificacion ?>' align="center" class="celdaponderacion">
				<b>Actividad</b>
			</td><?php
			echo $fila_2;
			break;
			
			case 2:
?>			<td bgcolor='<?php echo $tema->clasificacion ?>' align="center" class="celdaponderacion">
				<b>Pasividad</b>
			</td><?php
			echo $fila_3;
			break;
			
			case 3:
?>			<td bgcolor='<?php echo $tema->clasificacion ?>' align="center" class="celdaponderacion">
				<b>Relaci&oacute;n</b>
			</td><?php
			echo $fila_4;
			break;
			
			case 4:
?>			<td bgcolor='<?php echo $tema->seleccionado ?>' align="center" class="celdaponderacion">
				<b>Ponderaci&oacute;n</b>
			</td><?php
			echo $fila_5;
			break;	
		}
?>		</tr><?php
	}
	?>
		</table> 
		</td>
	</tr>  
</table><?php
	return $clasificacion;
}	
	


function error_clasificacion($configuracion,$mi_error)
{
	switch ($mi_error)
	{
		case 'media':
		?>
<table style="text-align: left;" border="0"  align="center" cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
	<tr>
		<td >
			<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
					</td>
					<td align="left">
						<b>El valor de la Actividad o Pasividad de un componente es cero.</b><br>
						Los resultados no pueden ser mostrados.
					</td>
				</tr>
			</table> 
		</td>
	</tr>  
</table><br><?php
	}
}

?>
