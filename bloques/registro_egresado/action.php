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
?><?php  
if(!key_exists('nombre',$_POST)||!key_exists('apellido',$_POST)||!key_exists('identificacion',$_POST))
{

			echo "Error Fatal en la aplicaci&oacute;n. Por favor informe el fallo al administrador";	
	
}
else
{
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	if(!(strlen($_POST['nombre'])>2)||!(strlen($_POST['apellido'])>2)||!(strlen($_POST['identificacion'])>3))
	{
		//Instanciar a la clase pagina con mensaje de correccion de datos
		echo "Error Fatal en los datos del formulario.";
	}
	else
	{
		$this->acceso_db=new dbms($configuracion);
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace))
		{		
			$this->cadena_sql='SELECT * FROM aplicativo_egresado WHERE identificacion="'.$_POST['identificacion'].'"';
			//echo $this->cadena_sql;
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->registro=$this->acceso_db->obtener_registro_db();
			$this->campos=$this->acceso_db->obtener_conteo_db();
			
			
			if(isset($_POST['accion']))
			{
				
				if($this->campos>0)
				{
					//El usuario ya esta registrado y como se esta editando se realiza un UPDATE
					//Tercero: Se guarda el registro en la base de datos
					$this->cadena_sql = "UPDATE `".$configuracion["prefijo"]."egresado` ";
					$this->cadena_sql.= "SET `nombre` ='".$_POST['nombre']."',`apellido` ='".$_POST['apellido']."' ,`identificacion` = '".$_POST['identificacion']."',`id_programa` = ".$id_programa.",`observacion` = '".$_POST['observacion'];
					$this->cadena_sql.= " WHERE `identificacion` = '".$_POST['identificacion']."' LIMIT 1";
					//echo $this->cadena_sql;
					$this->resultado=$this->acceso_db->ejecutar_acceso_db($this->cadena_sql); 
					if($this->resultado==TRUE)
					{
						$usuario=$_POST["usuario"];
						reset($_POST);
						while(list($clave,$valor)=each($_POST))
						{
							unset($_POST[$clave]);
							
						}
						include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
						echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('registro_egresado_exito')."&usuario=".$usuario."')</script>";   
					//$la_pagina=new pagina($pagina,$configuracion);
	
					}
					else
					{
						//Instanciar a la clase pagina con mensaje de error
					}
					
				}
				else
				{
					echo "Imposible modificar los datos. Por favor contacte al administrador del sistema.";
				
				}
				
				
			}
			else
			{
			 
				
				if($this->campos>0)
				{
					//El usuario ya esta registrado por tanto instancia a la clase pagina
					$this->la_pagina=new pagina('registro_egresado',$configuracion);
				}
				else
				{
					//Tercero: Se guarda el registro en la base de datos
					$this->cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."egresado (nombre , apellido, identificacion,id_programa,observacion) VALUES ('".$_POST['nombre']."','".$_POST['apellido']."' , '".$_POST['identificacion']."',".$id_programa." , '".$_POST['observacion']."')";
					//echo $this->cadena_sql;
					$this->db_sel = new dbms($configuracion);
					$this->db_sel->especificar_enlace($this->enlace);
					$this->resultado=$this->db_sel->ejecutar_acceso_db($this->cadena_sql); 
					if($this->resultado==TRUE)
					{
						$usuario=$_POST["usuario"];
						reset($_POST);
						while(list($clave,$valor)=each($_POST))
						{
							unset($_POST[$clave]);
							
						}
						include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
						echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('registro_egresado_exito')."&usuario=".$usuario."')</script>";   
					//$la_pagina=new pagina($pagina,$configuracion);
	
					}
					else
					{
						//Instanciar a la clase pagina con mensaje de error
					}
				}			
			}
		} 
		else
		{
			echo "Error fatal al acceder a la base de datos.";
				
		}
		
	}
}		
		


	
?>
