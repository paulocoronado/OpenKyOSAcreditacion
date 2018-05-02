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
?>
<?php  
/****************************************************************************************************************
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************************************************/
?><?php  

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
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

	
	if(isset($_POST['asociar']) || isset($_POST['actualizar']))
	{
		//Verificar todos los valores para encontrar elementos y guardarlos en la correspondiente tabla
		$cadena_sql_1="INSERT INTO ".$configuracion["prefijo"]."p_borrador (id_elemento,id_sesion,estado,orden) VALUES ";
		$cadena_sql_2="DELETE FROM ".$configuracion["prefijo"]."p_borrador WHERE ";
		
		$concatenar=0;
		$concatenar_2=0;
		reset ($_POST);
		while (list ($clave, $val) = each ($_POST)) 
		{
			//echo $clave."=>".$val."<br>";
			if(isset($_POST['asociar']))
			{
				if(substr($clave,0,6)=="ORDEN_")
				{
					
					if($concatenar>0)
					{
						$cadena_sql_2.=" OR ";
					}
					
					$pregunta=substr($clave,6,(strlen($clave)-6));
					
					if(isset($_POST["ELEMENTO_".$pregunta]))
					{
						if(trim($val)>0)
						{
							$orden=$val;
						}
						else
						{
							$orden=100000;
						}
						
						if($concatenar_2>0)
						{
							$cadena_sql_1.=",";
						}
						$cadena_sql_1.="(".$pregunta.",'".$esta_sesion."',1,".$orden.")";
						$concatenar_2++;
						
					}
					
					$cadena_sql_2.="id_elemento=".$pregunta;
					$concatenar++;
					
					
				}
			}
			else
			{
				if(substr($clave,0,12)=="ACTUAL_ORDEN")
				{
					
					if($concatenar>0)
					{
						$cadena_sql_2.=" OR ";
					}
					
					$pregunta=substr($clave,13,(strlen($clave)-13));
					
					if(isset($_POST["ACTUAL_ELEMENTO_".$pregunta]))
					{
						if(trim($val)>0)
						{
							$orden=$val;
						}
						else
						{
							$orden=100000;
						}
						
						if($concatenar_2>0)
						{
							$cadena_sql_1.=",";
						}
						$cadena_sql_1.="(".$pregunta.",'".$esta_sesion."',1,".$orden.")";
						$concatenar_2++;
						
					}
					
					$cadena_sql_2.="id_elemento=".$pregunta;
					$concatenar++;
					
					
				}
			
			}	
		
		}
		echo $cadena_sql_1."<br>";
		echo $cadena_sql_2."<br>";
		//exit;
		$resultado=$base->ejecutar_acceso_db($cadena_sql_2,0);
		
		if($concatenar_2>0)
		{
			$resultado&=$base->ejecutar_acceso_db($cadena_sql_1,0);
		}
		else
		{
			$resultado&=TRUE;
		}
		
		if($resultado==TRUE)
		{
			$variable="";
		
			//Envia todos los datos que vienen con GET
			
			unset($_POST["action"]);
			reset ($_POST);
			while (list ($clave, $val) = each ($_POST)) {
				
				if(substr($clave,0,6)!="ORDEN_" && substr($clave,0,6)!="ELEMEN" && substr($clave,0,6)!="ACTUAL" )
				{
					$variable.="&".$clave."=".$val;
					//echo $clave;
				}
				
			}
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('registro_artefacto_formulario').$variable."')</script>";   
			
			
		
		}
	
	}
	else
	{	
	
	
	
	
	
	
		//Verificar todos los valores para encontrar elementos y guardarlos en la correspondiente tabla
		$cadena_sql_1="INSERT INTO ".$configuracion["prefijo"]."p_borrador (id_elemento,id_sesion,estado,orden) VALUES ";
		$cadena_sql_2="DELETE FROM ".$configuracion["prefijo"]."p_borrador WHERE ";
		
		$concatenar=0;
		$concatenar_2=0;
		reset ($_POST);
		while (list ($clave, $val) = each ($_POST)) 
		{
			echo $clave."=>".$val."<br>";
			
			if(substr($clave,0,12)=="ACTUAL_ORDEN")
			{
				
				if($concatenar>0)
				{
					$cadena_sql_2.=" OR ";
				}
				
				$pregunta=substr($clave,13,(strlen($clave)-13));
				
				if(isset($_POST["ACTUAL_ELEMENTO_".$pregunta]))
				{
					if(trim($val)>0)
					{
						$orden=$val;
					}
					else
					{
						$orden=100000;
					}
					
					if($concatenar_2>0)
					{
						$cadena_sql_1.=",";
					}
					$cadena_sql_1.="(".$pregunta.",'".$esta_sesion."',1,".$orden.")";
					$concatenar_2++;
					
				}
				
				$cadena_sql_2.="id_elemento=".$pregunta;
				$concatenar++;
				
				
			}
		
		}
		//echo $cadena_sql_1."<br>";
		//echo $cadena_sql_2."<br>";
		//exit;
		$resultado=$base->ejecutar_acceso_db($cadena_sql_2,0);
		
		if($concatenar_2>0)
		{
			$resultado&=$base->ejecutar_acceso_db($cadena_sql_1,0);
		}
		else
		{
			$resultado&=TRUE;
		}
		
		if($resultado==TRUE)
		{
		
			//Siguiente paso
			$variable="";
			
				//Envia todos los datos que vienen con GET
				
			unset($_POST["action"]);
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('agregar_artefacto')."')</script>";   
		
		}
	}
}	


?>
