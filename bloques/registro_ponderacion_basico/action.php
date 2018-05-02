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
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
****************************************************************************
* @subpackage   registro_pnderacion_basico
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Procesamiento del registro de ponderacion basico
*
*****************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");	

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		$id_usuario=$registro[0][0];
	}
	
	
	if(isset($_POST["cancelar"]))
	{
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		
		$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
		$opciones="?";
		$opciones.="page=".enlace('comite_ponderacion_esquema');
		$opciones.="&&id_esquema=".$_POST["id_esquema"];
		
		echo "<script>location.replace('".$ruta.$opciones."')</script>";   
	
	
	}
	
	
	
	
	
	
	if(isset($_POST["opcion"]))
	{
		$accion=desenlace($_POST["opcion"]);
		//echo $accion;
		
		if($accion=="editar")
		{
			editar_registro($configuracion,$base,$id_usuario);
		
		}
		else
		{
			if($accion=="nuevo")
			{
				nuevo_registro($configuracion,$base,$id_usuario);			
			}
			else
			{
				error_procesamiento($configuracion);
			}
		}	
		
	}
	else
	{
		error_procesamiento($configuracion);
		
	}
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		
		$ruta=$configuracion["host"].$configuracion["site"]."/index.php";
		$opciones="?";
		$opciones.="page=".enlace('tabla_ponderacion_basico');
		$opciones.="&&id_esquema=".$_POST["id_esquema"];
		$opciones.="&&id_componente=".$_POST["id_componente"];
		
		echo "<script>location.replace('".$ruta.$opciones."')</script>";  	
	
}
/****************************************************************
*  			Funciones				*
****************************************************************/	
	
function error_procesamiento($configuracion)
{
?><table style="text-align: left;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral" width="100%">
	<tr>
		<td >
			<table cellpadding="10" cellspacing="0" align="center">
				<tr class="bloquecentralcuerpo">
					<td valign="middle" align="right" width="10%">
						<img src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/importante.png" border="0" />
					</td>
					<td align="left">
						<b>Imposible realizar la acci&oacute;n solicitada.</b>
					</td>
				</tr>
			</table> 
		</td>
	</tr>  
</table><?php
}	
	
	
function editar_registro($configuracion,$base,$id_usuario)
{
	$id_esquema=$_POST["id_esquema"];
	
	//Diseccion del codigo de componente
	$componentes=explode("_",$_POST["id_componente"]);
		
	$mi_modelo=$componentes[0];
	$mi_componente=$componentes[1];
	$mi_nivel=$componentes[2];
	$mi_padre=$componentes[3];
	
	$fecha=time();
	//Recorrer la matriz POST en busca de componentes
	reset($_POST);
	$resultado=TRUE;
	while(list($clave,$valor)=each($_POST))
	{
		if(substr($clave,0,strlen("componente_"))=="componente_")
		{
			$cadena_sql="UPDATE ";
			$cadena_sql.=$configuracion["prefijo"]."esquema_valor "; 
			$cadena_sql.="SET "; 
			$cadena_sql.="`id_esquema`='".$_POST['id_esquema']."', ";
			$cadena_sql.="`id_usuario`='".$id_usuario."', ";
			$cadena_sql.="`componente_a`='".substr($clave,strlen("componente_"))."', ";
			$cadena_sql.="`componente_b`='', ";
			$cadena_sql.="`valor`='".$valor."', ";
			$cadena_sql.="`observacion`='".$_POST['observacion_'.substr($clave,strlen("componente_"))]."', ";
			$cadena_sql.="`fecha`='".$fecha."' ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_usuario='".$id_usuario."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="`id_esquema`='".$_POST['id_esquema']."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="`componente_a`='".substr($clave,strlen("componente_"))."' ";
			//echo $cadena_sql."<br>";
			$resultado&=$base->ejecutar_acceso_db($cadena_sql,0);		
		}
			
	}
	
	
	if($resultado==TRUE)
	{
		return $resultado;
	
	}
	else
	{
		error_procesamiento($configuracion);
		return FALSE;
	}
	
}

function nuevo_registro($configuracion,$base,$id_usuario)
{
	$id_esquema=$_POST["id_esquema"];
	
	//Diseccion del codigo de componente
	$componentes=explode("_",$_POST["id_componente"]);
		
	$mi_modelo=$componentes[0];
	$mi_componente=$componentes[1];
	$mi_nivel=$componentes[2];
	$mi_padre=$componentes[3];
	
	$fecha=time();
	//Recorrer la matriz POST en busca de componentes
	reset($_POST);
	$resultado=TRUE;
	while(list($clave,$valor)=each($_POST))
	{
		if(substr($clave,0,strlen("componente_"))=="componente_")
		{
			$cadena_sql="INSERT INTO ";
			$cadena_sql.=$configuracion["prefijo"]."esquema_valor "; 
			$cadena_sql.="( ";
			$cadena_sql.="`id_esquema`, ";
			$cadena_sql.="`id_usuario`, ";
			$cadena_sql.="`componente_a`, ";
			$cadena_sql.="`componente_b`, ";
			$cadena_sql.="`valor`, ";
			$cadena_sql.="`observacion`, ";
			$cadena_sql.="`fecha` ";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES ";
			$cadena_sql.="( ";
			$cadena_sql.="'".$_POST['id_esquema']."', ";
			$cadena_sql.="'".$id_usuario."', ";
			$cadena_sql.="'".substr($clave,strlen("componente_"))."', ";
			$cadena_sql.="'', ";
			$cadena_sql.="'".$valor."', ";
			$cadena_sql.="'".$_POST['observacion_'.substr($clave,strlen("componente_"))]."', ";
			$cadena_sql.="'".$fecha."' ";
			$cadena_sql.=")";
			//echo$cadena_sql."<br>";
			
			$resultado&=$base->ejecutar_acceso_db($cadena_sql,0);		
		}
			
	}
	
	
	if($resultado==TRUE)
	{
		return $resultado;
	
	}
	else
	{
		error_procesamiento($configuracion);
		return FALSE;
	}
	
}
?>
