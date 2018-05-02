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
/****************************************************************************
  
login.action.php 

Paulo Cesar Coronado
Copyright (C) 2004-2007

Última revisión 01 de junio de 2007

******************************************************************************
* @subpackage   
* @package	formulario
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* 
*
* Script de procesamiento del formulario de autenticacion de usuarios
*
********************************************************************************/

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();

if (is_resource($enlace))
{
	$es_usuario=usuario_login($configuracion,$acceso_db);	
	
	if($es_usuario!=FALSE)
	{
		enrutar_login($es_usuario,$configuracion);
		
	}
	else
	{
		$es_encuestado=encuestado_login($configuracion,$acceso_db);
		
		if($es_encuestado)
		{	
			enrutar_login("encuestado",$configuracion);
		}
		else
		{
			$es_evaluacion=evaluacion_login($configuracion,$acceso_db);
			if($es_evaluacion)
			{
				enrutar_login("evaluacion_docente",$configuracion);
			}
			else
			{
				enrutar_login("index_no_usuario",$configuracion);
			}
		}
	}

} 
else
{
	echo "El sistema est&aacute; temporalmente fuera de servicio";
	
}

//===========================================================================
//                         FUNCIONES
//===========================================================================

function ejecutar_busqueda($cadena_sql,$acceso_db)
{
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	return $registro;
}

function usuario_login($configuracion,$acceso_db)
{
	$cadena_sql=cadena_sql_login("usuario",$configuracion);
	$registro=ejecutar_busqueda($cadena_sql,$acceso_db);	
	if(is_array($registro))
	{
		sesion_login("",$configuracion,$registro,$acceso_db);
		$cadena_sql=cadena_sql_login("pagina",$configuracion,$registro[0][2]);
		$registro=ejecutar_busqueda($cadena_sql,$acceso_db);
		if(is_array($registro))
		{
			return $registro[0][0];
		}
		
	}
	return FALSE;

}



function encuestado_login($configuracion,$acceso_db)
{
	$cadena_sql=cadena_sql_login("encuestado",$configuracion);
	$registro=ejecutar_busqueda($cadena_sql,$acceso_db);
	if(is_array($registro))
	{
		sesion_login("encuestado",$configuracion,$registro,$acceso_db);
		return TRUE;
		
	
	}
	return FALSE;	
}


function evaluacion_login($configuracion,$acceso_db)
{
	$cadena_sql=cadena_sql_login("evaluacion",$configuracion);						
	$registro=ejecutar_busqueda($cadena_sql,$acceso_db);
	if(is_array($registro))
	{
		$usuario=$registro[0][1];
		$id_usuario=$registro[0][0];
		$cadena_sql=cadena_sql_login("tipo_evaluacion",$configuracion,$registro[0][2]);
		$registro=ejecutar_busqueda($cadena_sql,$acceso_db);
		if(is_array($registro))
		{
			$registro[0][2]=$registro[0][0];
			$registro[0][0]=$usuario;
			$registro[0][3]=$id_usuario;
			sesion_login("",$configuracion,$registro,$acceso_db);
			return TRUE;
		}
	}
	
	return FALSE;
	
}

function enrutar_login($pagina,$configuracion)
{
	unset($_POST['action']);
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."')</script>";   
}

function sesion_login($tipo,$configuracion,$registro,$acceso_db)
{
	$usuario=$registro[0][0];
	if($tipo=="encuestado")
	{
		$acceso="6";							
	}
	else
	{
		$acceso=$registro[0][2];		
	}
	$id_usuario=$registro[0][3];

	
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($acceso_db->obtener_enlace());
	$esta_sesion=$nueva_sesion->numero_sesion();
	//echo $esta_sesion;
	$acceso_db->vaciar_temporales($configuracion,$esta_sesion);
	$nueva_sesion->borrar_sesion($configuracion,$esta_sesion);
	if (strlen($esta_sesion) != 32) 
	{
		$nueva_sesion->especificar_usuario($usuario);
		$nueva_sesion->especificar_nivel($acceso);
		$la_sesion=$nueva_sesion->crear_sesion($configuracion,'','');	
		
		if($tipo=="encuestado")
		{
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"clave",$usuario,$la_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_proceso",$registro[0][1],$la_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_artefacto",$registro[0][2],$la_sesion);
				$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"usuario","Encuestado",$la_sesion);
		}
		else
		{
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"usuario",$usuario,$la_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_usuario",$id_usuario,$la_sesion);
		}
		
	
	} 
	else 
	{
		if($tipo=="encuestado")
		{
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"usuario",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"usuario","Institucional",$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"clave",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"clave",$usuario,$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"id_proceso",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_proceso",$registro[0][0],$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"id_artefacto",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_artefacto",$registro[0][1],$esta_sesion);			
			
		}
		else
		{
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"usuario");
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"usuario",$usuario,$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"id_usuario");
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_usuario",$id_usuario,$esta_sesion);
		}
		$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"acceso");
		$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"acceso",$acceso,$esta_sesion);
		$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"expiracion");
		$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"expiracion",time()+$configuracion["expiracion"],$esta_sesion);
	}
	
	
}

function cadena_sql_login($tipo,$configuracion,$valor="")
{
	$cadena_sql="";
	switch($tipo)
	{
		case "usuario":
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre, ";
			$cadena_sql.="clave, ";
			$cadena_sql.="tipo, ";
			$cadena_sql.="id_usuario ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."usuario ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="nombre='".$_POST['usuario']."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="clave='".md5($_POST['clave'])."' ";
			//echo $cadena_sql;exit;
			break;	
		case "pagina":
			$cadena_sql="SELECT ";
			$cadena_sql.="seccion ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."tipo_usuario ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_usuario=".$valor." ";
			$cadena_sql.="LIMIT 1";	
			break;
		
		case "encuestado":
			$cadena_sql="SELECT ";
			$cadena_sql.="clave, ";
			$cadena_sql.="id_proceso, ";
			$cadena_sql.="id_artefacto ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."clave ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="clave='".$_POST['clave']."' ";
			break;
			
		case "evaluacion":
			$cadena_sql="SELECT "; 
			$cadena_sql.="`id_eval_actor`, "; 
			$cadena_sql.="`nombre`, "; 
			$cadena_sql.="`tipo` ";
			$cadena_sql.="FROM "; 
			$cadena_sql.=$configuracion["prefijo"]."eval_actor "; 
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_eval_actor='".$_POST['usuario']."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="clave='".md5($_POST['clave'])."' ";
			$cadena_sql.="LIMIT 1 ";
			break;
			
		case "tipo_evaluacion":	
			$cadena_sql="SELECT ";
			$cadena_sql.="`id_subsistema` "; 
			$cadena_sql.="FROM "; 
			$cadena_sql.=$configuracion["prefijo"]."subsistema ";
			$cadena_sql.="WHERE ";
			if($valor==1)
			{
				
				$cadena_sql.="`nombre`= 'evaluacion_docente' "; 
				
			}
			else
			{
				//Docente que realiza autoevaluacion docente
				$cadena_sql.="`nombre`= 'autoevaluacion_docente' "; 
			}							
			$cadena_sql.="LIMIT 1";	
			break;
		default:
			break;
	
	}
	return $cadena_sql;


}
	
?>
