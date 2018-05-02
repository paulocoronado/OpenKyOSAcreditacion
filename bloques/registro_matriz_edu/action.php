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
  
registro.action.php 

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
* @description  Action de registro de usuarios
* @usage        
*****************************************************************************************************************/
?><?PHP  
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}
	
if(isset($_POST["cancelar"]))
{
	unset($_POST['action']);
	$opciones="&registro=".$_POST['registro'];
	$opciones.="&accion=".$_POST['accion'];
	$opciones.="&hoja=".$_POST['hoja'];
	$opciones.="&mostrar=1";
	echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".$_POST['pagina'].$opciones."')</script>";   
	exit;

}
else
{	
	
	include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{	 
		
		//Recuperar el usuario
	
		$nueva_sesion=new sesiones($configuracion);
		$nueva_sesion->especificar_enlace($enlace);
		$esta_sesion=$nueva_sesion->numero_sesion();
		//Rescatar el valor de la variable usuario de la sesion
		$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
		if($registro)
		{
			
			$el_usuario=$registro[0][0];

		}
		else
		{
			exit;

		}
		
		if(isset($_POST["fecha"]))
		{
			$cadena_sql="DELETE ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."edu ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_usuario=".$el_usuario." ";
			$cadena_sql.="AND ";
			$cadena_sql.="fecha=".$_POST['fecha']." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_documento=".$_POST['registro'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
		}

		//Seleccionar los criterios
		$cadena_sql="SELECT ";
		$cadena_sql.="id_criterio, ";
		$cadena_sql.="nombre ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."criterio_edu ";
		$cadena_sql.="WHERE tipo_documento=0";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$esta_fecha=time();
			for($contador=0;$contador<$campos;$contador++)
			{     
				
				if(isset($_POST["criterio_".$registro[$contador][0]]))
				{
				
					$cadena_sql="SELECT ";
					$cadena_sql.="id_evidencia, ";
					$cadena_sql.="id_criterio, ";
					$cadena_sql.="nombre, ";
					$cadena_sql.="descripcion, ";
					$cadena_sql.="ponderacion, ";
					$cadena_sql.="justificacion ";								
					$cadena_sql.="FROM ";
					$cadena_sql.=$configuracion["prefijo"]."evidencia_edu ";
					$cadena_sql.="WHERE ";
					$cadena_sql.="id_criterio=".$registro[$contador][0];
					//echo $cadena_sql;					
					$acceso_db->registro_db($cadena_sql,0);
					$registro_evidencia=$acceso_db->obtener_registro_db();
					$campos_evidencia=$acceso_db->obtener_conteo_db();
					if($campos_evidencia>0)
					{
						
						for($i=0;$i<$campos_evidencia;$i++)
						{
						
							$cadena_sql = "INSERT INTO ";
							$cadena_sql.= "`".$configuracion["prefijo"]."edu` ";
							$cadena_sql.= "( ";
							$cadena_sql.= "`id_documento` , ";
							$cadena_sql.= "`id_criterio` , ";
							$cadena_sql.= "`id_evidencia` , ";
							$cadena_sql.= "`cumplimiento` , ";
							$cadena_sql.= "`observaciones` , ";
							$cadena_sql.= "`id_usuario` , ";
							$cadena_sql.= "`fecha` ";
							$cadena_sql.= ")";					
							$cadena_sql.= "VALUES ";
							$cadena_sql.= "(";
							$cadena_sql.= $_POST['registro']."," ;
		
							if(isset($_POST["criterio_".$registro[$contador][0]]))
							{
								$cadena_sql.= $registro[$contador][0]."," ;
							}	
							else
							{
								$cadena_sql.= "0," ;
							}
							
							if(isset($_POST["evidencia_".$registro_evidencia[$i][0]]))
							{
								$cadena_sql.= $registro_evidencia[$i][0]."," ;
							}	
							else
							{
								$cadena_sql.= "0," ;
							}
							
							if(isset($_POST["cumplimiento_".$registro_evidencia[$i][0]]))
							{
								if($_POST["cumplimiento_".$registro_evidencia[$i][0]]!="")
								{
									$cadena_sql.= $_POST["cumplimiento_".$registro_evidencia[$i][0]]."," ;
								}
								else
								{
									$cadena_sql.="0," ;
								}
							}	
							else
							{
								$cadena_sql.= "0," ;
							}
							
		
							if(isset($_POST["observaciones_".$registro_evidencia[$i][0]]))
							{
								$cadena_sql.= "'".$_POST["observaciones_".$registro_evidencia[$i][0]]."'," ;
								
							}	
							else
							{
								$cadena_sql.= "''," ;
							}
							
							$cadena_sql.= $el_usuario."," ;
							$cadena_sql.= $esta_fecha;
							$cadena_sql.=")";
							
							//echo $cadena_sql."<br>";
							//exit;
							$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
						}
					
					
					
					}
					
					
					
					
					
				}
				
			}
			//exit;
			if($resultado==TRUE)
			{
				unset($_POST['action']);
				$opciones="&registro=".$_POST['registro'];
				$opciones.="&accion=".$_POST['accion'];
				$opciones.="&hoja=".$_POST['hoja'];
				$opciones.="&mostrar=1";
				include($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_evaluacion_documental").$opciones."')</script>";   
							
		
			}
			else
			{
				//Instanciar a la clase pagina con mensaje de error
				echo "Error";
			}
		}
				
		
		

		
	} 
	else
	{
		echo "Error fatal al acceder a la base de datos.";
			
	}	
}
?>
