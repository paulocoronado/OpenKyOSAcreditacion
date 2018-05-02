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
****************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************/

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
include ($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");

if(!isset($_POST["id_programa"]))
{
	$id_programa=94;
}
else
{
	$id_programa=$_POST["id_programa"];
}

if(!isset($_POST["id_modelo"]))
{
	$id_modelo=1;
}
else
{
	$id_modelo=$_POST["id_modelo"];
}

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();

if (is_resource($enlace))
{
	$nivel=buscar_nivel_modelo($configuracion,$id_modelo,$acceso_db,$enlace,$id_programa);
	if($nivel)
	{
		//Busca los componentes de ultimo nivel susceptibles de guardar info
		mostrar_componente($configuracion,$id_modelo,$nivel,$acceso_db,$enlace,$tema,$id_programa);
	}
}


//****************************************************************************
//                                 FUNCIONES
//****************************************************************************

function buscar_nivel_modelo($configuracion,$id_modelo,$acceso_db,$enlace,$id_programa)
{
	$cadena_sql=cadena_busqueda_info_general($configuracion,$id_modelo,"nivel");
	$registro_nivel=busqueda_info_general($cadena_sql,$configuracion,$enlace,$acceso_db,$id_programa);
	if(is_array($registro_nivel))
	{
		return $registro_nivel[0][0];
	}
	else
	{
		return FALSE;
	}
	
}

function buscar_componente($cadena_sql,$configuracion,$enlace,$acceso_db,$id_programa)
{
	$registro_componente=busqueda_info_general($cadena_sql,$configuracion,$enlace,$acceso_db,$id_programa);
	if(is_array($registro_componente))
	{
		return $registro_componente;
	}
	else
	{
		return FALSE;
	}
	
}

function mostrar_componente($configuracion,$id_modelo,$nivel,$acceso_db,$enlace,$tema,$id_programa)
{
	$cadena_sql=cadena_busqueda_info_general($configuracion,$id_modelo,"componentes");
	//echo $cadena_sql;
	$registro_componente=busqueda_info_general($cadena_sql,$configuracion,$enlace,$acceso_db,$id_programa);
	if(is_array($registro_componente))
	{
		$ficha_informacion=TRUE;
		$conteo=count($registro_componente);
		for($i=0;$i<$conteo;$i++)
		{
			$registro["id_componente"]=trim(substr($registro_componente[$i][1],(($nivel*3)-3),3),'0');
			$registro["id_padre"]=trim(substr($registro_componente[$i][1],(($nivel*3)-6),3),'0');
			$registro["componente"]=$registro_componente[$i][1];
			$registro["id_modelo"]=$id_modelo;
			$cadena_sql=cadena_busqueda_info_general($configuracion,$registro,"componente");
			$componente=buscar_componente($cadena_sql,$configuracion,$enlace,$acceso_db,$id_programa);			
			
			/*
			switch($registro_componente[$i][2])
			{
				case "0":
					informe($configuracion,$componente,$acceso_db,$tema,$registro_componente[$i][1]);
					break;
				case "1":
					tabla($configuracion,$componente,$acceso_db,$tema,$registro_componente[$i][1]);
					break;
				case "2":
					taller($configuracion,$componente,$acceso_db,$tema,$registro_componente[$i][1]);
					break;
				default:
				break;
			}
			*/
			
			if (file_exists($configuracion["raiz_documento"].$configuracion["bloques"]."/informe_general/".$registro_componente[$i][1].".php")) 
			{
				
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/informe_general/".$registro_componente[$i][1].".php");
			}
			/*else
			{
				echo "Imposible cargar el archivo de resultados.<br>";
			} */
			
			
		}
		
	}
	else
	{
		return FALSE;
	}
	

}


function busqueda_info_general($cadena_sql,$configuracion,$enlace,$acceso_db,$id_programa)
{
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro_busqueda=$acceso_db->obtener_registro_db();
	if($registro_busqueda==FALSE)
	{
		$error=$acceso_db->obtener_error();
		if((is_array($error))&&($configuracion["development_mode"]==TRUE))
		{
			echo $error["numero"].":".$error["error"];
		}
		return FALSE;
	}
	else
	{
		$campos_busqueda=$acceso_db->obtener_conteo_db();
		if($campos_busqueda>0)
		{
			return $registro_busqueda;
		}
		else 
		{
			return FALSE;
		
		}
	}
}

function cadena_busqueda_info_general($configuracion,$variable,$tipo)
{
	switch($tipo)
	{
		case "nivel":
			$cadena_sql="SELECT ";
			$cadena_sql.="MAX(nivel) ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."modelo_componente ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_modelo=".$variable." ";
			break;
			
		case "componentes":
			$cadena_sql="SELECT ";
			$cadena_sql.="id_subsistema, ";
			$cadena_sql.="codigo_componente, ";				
			$cadena_sql.="instrumento ";				
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."subsistema_componente ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_modelo=".$variable." ";
			$cadena_sql.="ORDER BY codigo_componente ";
			break;
		
		case "componente":
			
			$cadena_sql="SELECT ";
			$cadena_sql.="`id_componente`, ";
			$cadena_sql.="`id_modelo`, ";
			$cadena_sql.="`nivel`, ";
			$cadena_sql.="`id_padre`, ";
			$cadena_sql.="`valor`, ";
			$cadena_sql.="`nombre` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."modelo_componente ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_modelo='".$variable["id_modelo"]."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_componente='".$variable["id_componente"]."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre='".$variable["id_padre"]."' ";
			$cadena_sql.="LIMIT 1 ";
			
			
		default:
			break;
		
	
	}
	
	return $cadena_sql;

}

function informe($configuracion,$registro,$acceso_db,$tema,$componente)
{
	//Enlazar a la pagina indicador la cual desde la version 1.0.0.3 es independiente del subsistema
	
?><tr class="bloquecentralcuerpo">
	<td bgcolor="<?php echo $tema->celda ?>" align="center">
	<a href="#" onclick="abrir_ventana('<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_indicador').'&indicador='.$registro[$contador][1]; ?>','informacion')">
	<?php 
	echo $componente;
	?></a>
	</td>
	<td bgcolor="<?php echo $tema->celda ?>"><?php 
	echo $registro[0][5]."<br>";
	echo $registro[0][4]; 
?></a>
</td>
<td bgcolor="<?php echo $tema->celda ?>" align="center">
<a href='<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('informe_indicador')."&accion=1&hoja=0&indicador=".$registro[$contador][1] ?>'>
<img width="24" height="24" src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/informe.png" alt="Administrar Informes" title="Administrar Informes" border="0" />
</a>
</td>
</tr><?php	
}


function tabla($configuracion,$registro,$acceso_db,$tema,$componente)
{		
?>	<tr class="bloquecentralcuerpo">
		<td bgcolor="<?php echo $tema->celda ?>" align="center"><?php 
		echo $componente;
		?></td>
		<td bgcolor="<?php echo $tema->celda ?>">
		<?php 
		echo $registro[0][5]."<br>";
		echo $registro[0][4]; 
		?></td>
		<td bgcolor="<?php echo $tema->celda ?>" align="center">
		<a href="#" onclick="abrir_ventana('<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_informacion').'&id_componente='.$registro[$contador][1].'&id_programa='.$id_programa; ?>','informacion')">
		<b>Tabla</b>
		</a>
		</td>		
	</tr><?php
}


function taller($configuracion,$registro,$acceso_db,$tema,$componente)
{
?><tr class="bloquecentralcuerpo">
<td bgcolor="<?php echo $tema->celda ?>" align="center"><?php 
echo $componente;
?></td>
<td bgcolor="<?php echo $tema->celda ?>"><?php 
	echo $registro[0][5]."<br>";
	echo $registro[0][4]; 
?></td>
<td bgcolor="<?php echo $tema->celda ?>" align="center">
<a href="#" onclick="abrir_ventana('<?php echo $configuracion["host"].$configuracion["site"].'/index.php?page='.enlace('ficha_informacion').'&id_componente=taller&id_programa='.$id_programa; ?>','informacion')">
<b>Taller
</a>
</td>
</tr><?php
}

function sin_informacion()
{?><table style="text-align: left;" width='100%' border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td ><span  style="font-weight: bold;">Actualmente no hay informaci&oacute;n registrada</span></td>
    </tr>
    </tbody>
</table><?php
}

?>