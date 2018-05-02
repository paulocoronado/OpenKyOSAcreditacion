<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*****************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
******************************************************************************/

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
include ($configuracion["raiz_documento"].$configuracion["clases"]."/navegacion.class.php");


$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		
		$el_usuario=$registro[0][0];
	}
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$usuario=$registro[0][0];
	}
	
	$cadena_sql=cadena_busqueda($configuracion,$usuario);
	//echo $cadena_sql;
	$cadena_hoja=$cadena_sql;
	
	if(!isset($_REQUEST["hoja"]))
	{
		$_REQUEST["hoja"]=1;
	}
	
	$cadena_hoja.=" LIMIT ".(($_REQUEST["hoja"]-1)*$configuracion['registros']).",".$configuracion['registros'];	
	//echo $_REQUEST["hoja"]."<br>";
	//echo $cadena_hoja;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();	
	if($campos>0)
	{
		$hojas=ceil($campos/$configuracion['registros']);	
	}
	else
	{
		$hojas=1;
	
	}
	
	$acceso_db->registro_db($cadena_hoja,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		sin_registro($configuracion);	
	}
	else
	{
		if(isset($_REQUEST["mostrar"]))
		{
			if($_REQUEST["mostrar"]=="lista")
			{
				$esta_pagina=$_REQUEST["hoja"]*$configuracion['registros']-$configuracion['registros']/2;
				if($esta_pagina>$configuracion['registros']/2)
				{
					navegacion::menu_navegacion($configuracion,$_REQUEST["hoja"],$hoja);
				}
				con_registro($configuracion,$registro,$campos,$tema);
				navegacion::menu_navegacion($configuracion,$_REQUEST["hoja"],$hojas,$_REQUEST["page"]);
			}
			else
			{
				estadistica($configuracion,$registro);
			}
		}		
		else
		{
			estadistica($configuracion,$campos);	
		}
	}
}



/****************************************************************
*  			Funciones				*
****************************************************************/

function sin_registro($configuracion)
{
?><table width="100%" align="center" border="0" cellpadding="10" cellspacing="0" >
	<tr>
		<td >
			<table style="text-align: left;" border="0"  cellpadding="5px" cellspacing="0" class="bloquelateral" width="100%">
				<tr>
					<td >
						<table cellpadding="10" cellspacing="0" align="center">
							<tr class="bloquecentralcuerpo">
								<td valign="middle" align="right" width="10%">
									<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
								</td>
								<td align="left">
									<b>Actualmente no hay grupos registrados que cumplan con las caracter&iacute;sticas de la consulta.</b>
								</td>
							</tr>
						</table> 
					</td>
				</tr>  
			</table>
		</td>
	</tr>  
</table><?php
}


function con_registro($configuracion,$registro,$campos,$tema)
{
	
?><table width="100%" align="center" border="0" cellpadding="10" cellspacing="0" >
	<tbody>
		<tr>
			<td >
				<table width="100%" border="0" align="center" cellpadding="0px" cellspacing="3px" >
					<?php
	for($contador=0;$contador<$campos;$contador++)
	{			?>	<tr>
						<td >
							<table width="100%"  class="tablapresentacion" align="center" cellpadding="1" cellspacing="0">
								<tr class="bloquecentralcuerpo">
									<td colspan="2" class="celdatablacontenido">
										<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('editar_grupo')."&registro=".$registro[$contador][0]."&opcion=mostrar"; ?>" alt="Editar Grupo"><?php echo "<b>".$registro[$contador][1]."</b> " ?></a>
									</td>																		
								</tr>
								<tr class="bloquecentralcuerpo">									
									<td  width="100%" >
										<?php echo $registro[$contador][2] ?>
									</td>
									<td>
										<table width="100%" border="0">
											<tr align="right">												
												<td>
													<a href="<?echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('borrar_grupo').'&opcion=grupo&registro='.$registro[$contador][0]; ?>"><img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_borrar.png" alt="Borrar grupo del Sistema" title="Borrar grupo del Sistema" border="0" /></A>
												</td>
											</tr>
										</table>
									</td>									
								</tr>
							</table>
						</td>
					</tr><?php
	}
	?>			</table>
			</td>
		</tr>
	</tbody>
</table><?php
}


function estadistica($configuracion,$contador)
{?><table style="text-align: left;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
	<tr>
		<td >
			<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info.png" border="0" />
					</td>
					<td align="left">
						Actualmente hay <b><?php echo $contador ?> grupos</b> registrados.
					</td>
				</tr>
				<tr class="bloquecentralcuerpo">
					<td align="right" colspan="2" >
						<a href="<?php
						echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('admin_dir_dedicacion').'&registro='.$_REQUEST['registro'].'&accion=1&hoja=0&opcion='.enlace("mostrar").'&admin='.enlace("lista"); 
						
						?>">Ver m&aacute;s informaci&oacute;n >></a>
					</td>
				</tr>
			</table> 
		</td>
	</tr>  
</table>
<?php}


function cadena_busqueda($configuracion,$usuario)
{
	
	$cadena_sql="SELECT ";
	$cadena_sql.="`id_grupo`, ";
	$cadena_sql.="`nombre`, ";
	$cadena_sql.="`descripcion`, ";
	$cadena_sql.="`fecha`, ";
	$cadena_sql.="`tipo` ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."grupo ";
 
	if(isset($_GET['accion']))		
	{
		
		$variable="";
		
		reset ($_GET);
		while (list ($clave, $val) = each ($_GET)) 
		{
			
			if($clave!='pagina')
			{
				$variable.="&".$clave."=".$val;
				//echo $clave;
			}
		}	
		switch($_GET['accion'])
		{	
			//Todos los profesores
			case '1':	
				$cadena_sql.="WHERE ";
				$cadena_sql.="1 ";			
				break;
				
			//Filtrado
			case '2':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='';
				
				while (list ($clave, $val) = each ($buscar)) 
				{
					$buscar_nombre.="nombre like '%".$val."%' OR ";
				}
				
				$buscar_todo=substr($buscar_nombre,0,(strlen($buscar_nombre)-3));
								
				$cadena_sql.="WHERE ";
				$cadena_sql.=$buscar_todo." ";
				break;	
				
						
			
			default:
				break;
					
			
		}
	}
	$cadena_sql.="ORDER BY ";
	$cadena_sql.="nombre ";
	
	return $cadena_sql;
}
?>