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
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

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
?><?php  
if(!key_exists('id_proceso',$_POST)||!key_exists('id_artefacto',$_POST))
{
			echo "Error grave en los datos del formulario.";
		
}
else
{
	/*
	echo "Valores enviados con el metodo POST:<br>";
	reset ($_POST);
	while (list ($clave, $val) = each ($_POST)) 
	{
		echo "$clave => $val<br>";
	}
	exit;
	*/
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		
		reset ($_POST);
		while (list ($clave, $val) = each ($_POST)) 
		{
			$error=TRUE;
			if(substr($clave,0,13)=="id_artefacto_")
			{
				
				$error=FALSE;
				$artefacto=substr($clave,13,(strlen($clave)-13));
				
				if(isset($_POST["dia_1_".$artefacto]))
				{
					if($_POST["dia_1_".$artefacto]==0)
					{
						$error=TRUE;					
					}
					else
					{
						$dia_1=$_POST["dia_1_".$artefacto];
					
					}	
					
				}
				else
				{
					$error=TRUE;
				}
				
				if(isset($_POST["mes_1_".$artefacto]))
				{
					if($_POST["mes_1_".$artefacto]==0)
					{
						$error=TRUE;					
					}
					else
					{
						$mes_1=$_POST["mes_1_".$artefacto];
					
					}	
					
				}
				else
				{
					$error=TRUE;
				}
				
				if(isset($_POST["anno_1_".$artefacto]))
				{
					if($_POST["anno_1_".$artefacto]==0)
					{
						$error=TRUE;					
					}
					else
					{
						$anno_1=$_POST["anno_1_".$artefacto];
					
					}	
					
				}
				else
				{
					$error=TRUE;
				}
				
				if(isset($_POST["dia_2_".$artefacto]))
				{
					if($_POST["dia_2_".$artefacto]==0)
					{
						$error=TRUE;					
					}
					else
					{
						$dia_2=$_POST["dia_2_".$artefacto];
					
					}	
					
				}
				else
				{
					$error=TRUE;
				}
				
				if(isset($_POST["mes_2_".$artefacto]))
				{
					if($_POST["mes_2_".$artefacto]==0)
					{
						$error=TRUE;					
					}
					else
					{
						$mes_2=$_POST["mes_2_".$artefacto];
					
					}	
					
				}
				else
				{
					$error=TRUE;
				}
				
				if(isset($_POST["anno_2_".$artefacto]))
				{
					if($_POST["anno_2_".$artefacto]==0)
					{
						$error=TRUE;					
					}
					else
					{
						$anno_2=$_POST["anno_2_".$artefacto];
					
					}	
					
				}
				else
				{
					$error=TRUE;
				}
				
				
			}
			if($error==FALSE)
			{
				$inicio=mktime(0,0,0,$mes_1, $dia_1, $anno_1);
				$final=mktime(0,0,0,$mes_2, $dia_2, $anno_2);
				
				if($inicio<=$final)
				{
					$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."aplicacion";
					$cadena_sql.=" WHERE ";
					$cadena_sql.=" id_artefacto=".$artefacto;
					$cadena_sql.=" AND id_proceso=".$_POST["id_proceso"];
					$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
					
					$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."aplicacion";
					$cadena_sql.="(";
					$cadena_sql.="`id_proceso` ,";
					$cadena_sql.="`id_artefacto` ,";
					$cadena_sql.="`inicio` , ";
					$cadena_sql.="`final` ";
					$cadena_sql.=")";
					$cadena_sql.="VALUES (";
					$cadena_sql.="'".$_POST["id_proceso"]."',";
					$cadena_sql.="'".$artefacto."',";
					$cadena_sql.="'".$inicio."',";
					$cadena_sql.="'".$final."'";
					$cadena_sql.=")";
					$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
				}
			}
		}
		
		$variable="&registro=".$_POST["id_proceso"];
		$pagina="informacion_proceso";
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
		
	}
}
?>
