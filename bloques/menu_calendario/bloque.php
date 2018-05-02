<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@udistrital.edu.co                                         #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?>
<?php
/****************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu para mostrar el calendario.
* @usage        
*******************************************************************************/
?><?php

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

//include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");


mostrar_mes($configuracion);	



function mostrar_mes($configuracion)
{ 
	if(!isset($_REQUEST["mes_cal"])&&!isset($_REQUEST["anno_cal"]))
	{
		$hoy=date("d",time());
		$mes=date("n",time());
		$el_mes=buscar_mes($mes,$configuracion);	
		$anno=date("Y",time());
		$dias=date("t",time());
	}
	else
	{	
		$hoy=date("d",time());
		$fecha=strtotime($_REQUEST["mes_cal"]."/".$hoy."/".$_REQUEST["anno_cal"]);
		$mes=$_REQUEST["mes_cal"];
		$el_mes=buscar_mes($mes,$configuracion);	
		$anno=$_REQUEST["anno_cal"];
		$dias=date("t",$fecha);	
		
	}
	$pascua=pascua();
	
	
	if($mes==1)
	{
		$mes_anterior=12;
		$anno_anterior=$anno-1;
	}
	else
	{
		$mes_anterior=$mes-1;	
		$anno_anterior=$anno;
	}
	
	if($mes==12)
	{
		$mes_siguiente=1;	
		$anno_siguiente=$anno+1;	
	}
	else
	{
		$mes_siguiente=$mes+1;	
		$anno_siguiente=$anno;	
	
	}
	
	$primer_dia_anterior=$anno_anterior."-".$mes_anterior."-01";
	$dias_anterior=date("t",$primer_dia_anterior);
	
	
	$primer_dia = $anno."-".$mes."-01";
	$dia_semana = date("w",strtotime($primer_dia)); 
	$la_pascua=pascua();
	
	//echo $dia_semana;
	//Llenar la matriz
	$contador=0;
	$indice=$dia_semana;

	//Mes Anterior
	while($contador<$dia_semana)
	{
		$tipos[$indice-($contador+1)]=0;		
		$todos[$indice-($contador+1)]=$dias_anterior-$contador;
		$contador++;
	}
	
	//Mes Actual
	$indice_festivo=0;
	$indice_evento=0;
	for($i=1;$i<($dias+1);$i++)
	{
		$tipos[$indice]=1;
		$el_festivo=buscar_festivo($i,$mes,$anno,$pascua,$configuracion);
		
		if(is_array($el_festivo))
		{
			$es_festivo["dia"][$indice_festivo]=$el_festivo["dia"];
			$es_festivo["mes"][$indice_festivo]=$el_festivo["mes"];
			$es_festivo["descripcion"][$indice_festivo++]=$el_festivo["descripcion"];
		}
		
		
		$todos[$indice++]=$i;
		
	}
		
		
	$i=1;
	
	//Mes Siguiente
	while($indice<(35))
	{
		$tipos[$indice]=2;
		$todos[$indice++]=$i++;
	}
	
	$los_dias['etiqueta'][0]="D";
	$los_dias['etiqueta'][1]="L";
	$los_dias['etiqueta'][2]="M";
	$los_dias['etiqueta'][3]="M";
	$los_dias['etiqueta'][4]="J";
	$los_dias['etiqueta'][5]="V";
	$los_dias['etiqueta'][6]="S";

	
	
	
	
	
	
?><table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="bloquelateralrecto">
	<tbody>
		<tr class="bloquelateralcuerpo">
			<td><span class="encabezado_normal">Calendario de Eventos</span></td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="1" class="tablacalendario" cellpadding="0" cellspacing="0">
					<tr class="encabezado_calendario"><?php
					for($j=0;$j<7;$j++)
					{
					?>
						<td class="texto_centrado">
						<?echo $los_dias['etiqueta'][$j]?>
						</td><?php
					}
					?>
					</tr><?php
					$indice=0;
					for($i=0;$i<5;$i++)
					{
					
					?><tr class="bloquecalendario"><?php
							for($j=0;$j<7;$j++)
							{
								if(isset($todos))
								{
									if($tipos[$j+(7*$indice)]!=1)
									{
									
										echo "<td class='texto_centrado'>";
										echo "<span class='texto_claro'>".$todos[$j+(7*$indice)]."</span>";								
									
									}
									else
									{
										$el_evento=buscar_evento($todos[$j+(7*$indice)],$mes,$anno,$configuracion);
										if(isset($es_festivo["dia"]))
										{	
											if(in_array($todos[$j+(7*$indice)],$es_festivo["dia"]))
											{
												if(is_array($el_evento))
												{
																					
												}
												else
												{
													echo "<td class='festivo_calendario'>";
													echo $todos[$j+(7*$indice)];								
												}
											}
											else
											{
												if(is_array($el_evento))
												{
													if($j==0)
													{
														echo "<td class='encabezado_calendario'>\n";
														echo "<span class='texto_centrado'>".$todos[$j+(7*$indice)]."</span>\n";
													}
													else
													{
														$texto_ayuda="<b>Mes siguiente</b>";
														$datos="&mes_cal=".$mes_siguiente;
														$datos.="&anno_cal=".$anno_siguiente;
														echo "<td class='evento_calendario'>";
														echo "<a class='evento' href='' ";
														echo "onmouseover=\"this.T_WIDTH=100;return escape('".htmlentities($el_evento[0][2])."')\">";
														echo $todos[$j+(7*$indice)]."</a>";								
													}								
												}
												else
												{
													if($j==0)
													{
														echo "<td class='festivo_calendario'>\n";
														echo $todos[$j+(7*$indice)];
													}
													else
													{
														echo "<td class='texto_centrado'>\n";
														echo $todos[$j+(7*$indice)];
													}								
												}
												
												
											}	
										}
										else
										{
											if(is_array($el_evento))
											{
																				
												if($j==0)
												{
													echo "<td class='encabezado_calendario'>";
													echo "<span class='texto_centrado'>".$todos[$j+(7*$indice)]."</span>";
												}
												else
												{
													echo "<td class='evento_calendario'>";
													echo "<span class='texto_color'>".$todos[$j+(7*$indice)]."</span>";
												}
											}
											else
											{
												echo "<td class='texto_centrado'>";
												if($j==0)
												{
													echo "<span class='texto_color'>".$todos[$j+(7*$indice)]."</span>";
												}
												else
												{
													echo $todos[$j+(7*$indice)];
												}
											}
											
										}	
									
									}
										
						?>	</td><?php
								}
								
							}
							$indice++;
							?>
					</tr>	
					
					<?php
					}
				?>	<tr class="bloquecentralcuerpo">
						<td class="texto_centrado">
							<a href="<?php
							$texto_ayuda="<b>Mes anterior</b>";
							$datos="&mes_cal=".$mes_anterior;
							$datos.="&anno_cal=".$anno_anterior;
							$pagina=$configuracion["host"].$configuracion["site"]."/index.php?";
							$variable="";
							while (list ($clave, $val) = each ($_REQUEST)) 
							{
								if($clave=="page")
								{
									$pagina.=$clave."=".$val;
								}
								else
								{
									if($clave=="ann_cal"&&$clave!="mes_cal")
									{
										$variable.="&".$clave."=".$variable;
									}	
								}
							}
							echo $pagina.$variable.$datos."\" onmouseover=\"this.T_WIDTH=100;return escape('".$texto_ayuda."')";
							
							?>"><<</a>
						</td>
						<td colspan="5" class="texto_centrado">
							<span class="texto_negrita"><?php echo $el_mes ?></span>
						</td>
						<td class="texto_centrado">
							<a href="<?php
							$texto_ayuda="<b>Mes siguiente</b>";
							$datos="&mes_cal=".$mes_siguiente;
							$datos.="&anno_cal=".$anno_siguiente;
							echo $pagina.$variable.$datos."\" onmouseover=\"this.T_WIDTH=100;return escape('".$texto_ayuda."')";
							
							?>">>></a>
						</td>
					</tr>	
				</table>
			</td>
		</tr>
	</tbody>
</table><?php
}

function buscar_mes($mes,$configuracion)
{
	$cadena_sql=cadena_busqueda_calendario(2,$configuracion,1,$mes);
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$acceso_db->registro_db($cadena_sql,0);
		$registro_mes=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
	}	
	if($campos>0)
	{
		return $registro_mes[0][0];
	}
	else
	{
		return FALSE;
	}
}
				
function buscar_evento($dia,$mes,$anno,$configuracion)
{
	$buscar=cadena_busqueda_calendario(3,$configuracion,$dia,$mes,$anno);
	//echo $buscar."<hr>";
	
	//echo $pascua["mes"];
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$acceso_db->registro_db($buscar,0);
		$registro_evento=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$es_evento=$registro_evento;
			return $es_evento;
		}
		else
		{
			return FALSE;
		}	
	}	
	
}				
				
function  buscar_festivo($dia,$mes,$anno,$pascua,$configuracion)
{
	//Tipo
	//1:Fecha Fija
	//2:Lunes siguiente
	//3:Respecto a la Pascua Fijos
	//4:Respecto a la Pascua Lunes siguiente
	
	
	
	$buscar=cadena_busqueda_calendario(1,$configuracion,$dia,$mes);
	//echo $buscar."<hr>";
	
	//echo $pascua["mes"];
	
	$nuestra_pascua=strtotime($pascua["mes"]."/".$pascua["dia"]."/".$anno);
	$esta_fecha=strtotime($mes."/".$dia."/".$anno);
		
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$acceso_db->registro_db($buscar,0);
		$registro_festivo=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
	}	
	if($campos>0)
	{
		if($registro_festivo[0][0]==2)
		{
			//Se corre al lunes siguiente.
			//Determinar el dia de la semana...
			
			$este_dia_semana = date("w",$esta_fecha); 
			
			//echo $este_dia_semana;
			
			if($este_dia_semana==0)
			{
				$suma=1;
			}
			else
			{
				if($este_dia_semana==1)
				{
					$suma=0;
				}
				else
				{
					$suma=8-$este_dia_semana;
				}
			}
			$esta_fecha+=($suma*24*60*60);
			$el_dia=date("d",$esta_fecha);
			$el_mes=date("n",$esta_fecha);
			$el_anno=date("Y",$esta_fecha);
			$la_descripcion=$registro_festivo[0][3];
			if($el_mes==$mes)
			{
				$es_festivo["dia"]=$el_dia;
				$es_festivo["descripcion"]=$la_descripcion;
				$es_festivo["mes"]=$el_mes;
				$es_festivo["anno"]=$el_anno;
				return $es_festivo;	
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$es_festivo["dia"]=$registro_festivo[0][1];
			$es_festivo["descripcion"]=$registro_festivo[0][3];
			$es_festivo["mes"]=$registro_festivo[0][2];
			$es_festivo["anno"]=$anno;
			return $es_festivo;
		
		}
		
		
		
	}
	else
	{
		
		if(date("d",$esta_fecha)==date("d",($nuestra_pascua+(43*24*60*60)))
		   && date("n",$esta_fecha)==date("n",($nuestra_pascua+(43*24*60*60)))
		   )
		{
			$es_festivo["descripcion"]="Ascensi&oacute;n de Jes&uacute;s";
			$festivo=1;
		}
		else
		{
			if(date("d",$esta_fecha)==date("d",($nuestra_pascua+(64*24*60*60)))
			  && date("n",$esta_fecha)==date("n",($nuestra_pascua+(64*24*60*60)))
			)
			{
				$es_festivo["descripcion"]="Corpus Christi";
				$festivo=1;
			}
			else
			{
				if(date("d",$esta_fecha)==date("d",($nuestra_pascua+(71*24*60*60)))
				&& date("n",$esta_fecha)==date("n",($nuestra_pascua+(71*24*60*60)))
				)
				{
					$es_festivo["descripcion"]="Sagrado Coraz&oacute;n";
					$festivo=1;
				}
				else
				{
					if(date("d",$esta_fecha)==date("d",($nuestra_pascua-(3*24*60*60)))
					   && date("n",$esta_fecha)==date("n",($nuestra_pascua+(-3*24*60*60)))
					)
					{
						$es_festivo["descripcion"]="Viernes Santo";
						$festivo=1;
					}
					else
					{
						if(date("d",$esta_fecha)==date("d",($nuestra_pascua-(4*24*60*60)))
						   && date("n",$esta_fecha)==date("n",($nuestra_pascua-(4*24*60*60)))
						)
						{
							$es_festivo["descripcion"]="Jueves Santo";
							$festivo=1;
						}
						else
						{
							$festivo=0;
						}
					}
				}
			}
		}
		if($festivo==1)
		{
			
	
			$este_dia_semana = date("w",$esta_fecha); 
			
			if($este_dia_semana==0)
			{
				$suma=1;
			}
			else
			{
				if($este_dia_semana==1)
				{
					$suma=0;
				}
				else
				{
					$suma=8-$este_dia_semana;
				}
			}
			$esta_fecha+=$suma;
			$el_dia=date("d",$esta_fecha);
			$el_mes=date("n",$esta_fecha);
			$el_anno=date("Y",$esta_fecha);
			$la_descripcion=$registro_festivo[0][3];
			
			
			if($el_mes==$mes)
			{
				$es_festivo["dia"]=$el_dia;
				$es_festivo["descripcion"]=$la_descripcion;
				$es_festivo["mes"]=$el_mes;
				$es_festivo["anno"]=$el_anno;
				return $es_festivo;	
			}
			else
			{
				return FALSE;
			}
			
			
		}
		else
		{
					return FALSE;
		}	
	
		
	}
	 

}


function pascua()
{
	$anno=date("Y",time());
	$A=$anno%19;
	$B=$anno%4;
	$C=$anno%7;	
	$D = (19*$A+24)%30;	
	$E = (2*$B+4*$C+6*$D+5)%7;
	
	if(($D+$E)<10)
	{
		$la_pascua["mes"]=3;
		$la_pascua["dia"]=$D + $E + 22;
	}
	else
	{
		$la_pascua["mes"]=4;
		$la_pascua["dia"]=$D+$E-9;
		
		if($la_pascua["dia"]==26)
		{
			$la_pascua["dia"]=19;
		}
		else
		{
			if(($la_pascua["dia"]==25)&&($D==28)&&($E==6)&&($A>10))
			{
				$la_pascua["dia"]=18;
			}
		}
		
	}
		
		
		
		
		
	
	return $la_pascua;

}


function cadena_busqueda_calendario($tipo,$configuracion,$dia,$mes,$anno="")
{
	if ($anno=="")
	{
		$anno=date("Y",time());	
	}
	switch($tipo)
	{
		
		case 1:
			$cadena_sql="SELECT ";
			$cadena_sql.="`tipo`, ";
			$cadena_sql.="`dia`, ";
			$cadena_sql.="`mes`, ";
			$cadena_sql.="`descripcion` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."calendario ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="dia=".$dia." ";
			$cadena_sql.="AND ";
			$cadena_sql.="mes=".$mes." ";
			$cadena_sql.="LIMIT 1";
			break;
		
		case 2:
			$cadena_sql="SELECT ";
			$cadena_sql.="`nombre` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."mes ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_mes=".$mes." ";
			$cadena_sql.="LIMIT 1";
			
			break;
			
		case 3:
			$esta_fecha= strtotime($anno."-".$mes."-".$dia);
			//echo $esta_fecha."<br>";
			$cadena_sql="SELECT ";
			$cadena_sql.="`id_evento`, ";
			$cadena_sql.="`nombre`, ";
			$cadena_sql.="`descripcion`, ";
			$cadena_sql.="`lugar`, ";
			$cadena_sql.="`fecha`, ";
			$cadena_sql.="`hora`, ";
			$cadena_sql.="`organiza`, ";
			$cadena_sql.="`convoca`, ";
			$cadena_sql.="`nombre_contacto`, ";
			$cadena_sql.="`tel_contacto`, ";
			$cadena_sql.="`mail_contacto`, ";
			$cadena_sql.="`id_usuario`, ";
			$cadena_sql.="`fecha_post` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."evento ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="fecha='".$esta_fecha."' ";
			break;
			
		default:
			break;		
	}	
	return $cadena_sql;
}


?>