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

			echo "Error Fatal en el formulario. Por favor int&eacute;ntelo m&aacute;s tarde.";
	
}
else
{
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
	if(!(strlen($_POST['nombre'])>2)||!(strlen($_POST['apellido'])>2)||!(strlen($_POST['correo'])>6)||!(strlen($_POST['usuario'])>2)||!(strlen($_POST['clave'])>4))
	{
		//Instanciar a la clase pagina con mensaje de correcion de datos
	}
	else
	{
			
		/**
		Segundo: Se comprueba que la identificacion  no existan en la base de datos
		
		**/
		$this->acceso_db=new dbms($configuracion);
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace))
		{	 
			$this->cadena_sql='SELECT * FROM aplicativo_profesor WHERE correo="'.$_POST['correo'].'"';
			//echo $this->cadena_sql;
			$this->acceso_db->registro_db($this->cadena_sql,0);
			$this->registro=$this->acceso_db->obtener_registro_db();
			$this->campos=$this->acceso_db->obtener_conteo_db();
			if($this->campos>0)
			{
				unset ($_POST["action"]);
				unset ($_POST["correo"]);
				$this->la_pagina=new pagina('registro',$configuracion);
				exit;
			}
			//Tercero: Se guarda el registro en la base de datos y se envia un correo al webmaster para la validación del nivel de acceso.
			$this->cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."profesor ( id_usuario , nombre , apellido, correo, telefono, usuario, clave, tipo,estado) VALUES (NULL, '".$_POST['nombre']."','".$_POST['apellido']."' , '".$_POST['correo']."','".$_POST['telefono']."','".$_POST['usuario']."','".md5($_POST['clave'])."',".$_POST['nivel_acceso'].",0)";
			//echo $this->cadena_sql;
			$this->db_sel = new dbms($configuracion);
			$this->db_sel->especificar_enlace($this->enlace);
			$this->resultado=$this->db_sel->ejecutar_acceso_db($this->cadena_sql); 
			if($this->resultado==TRUE)
			{
				//siempre que se use la clase pagina desde un action debe desasignar la variable $POST['action']
				reset($_POST);
				while(list($clave,$valor)=each($_POST))
				{
					unset($_POST[$clave]);
						
				}
				$this->la_pagina=new pagina('registro_exito',$configuracion);
				//Instanciar a la clase pagina con mensaje de exito

			}
			else
			{
				//Instanciar a la clase pagina con mensaje de error
			}
						
			}
		} 
		else
		{
			echo "Error al conectar con la base de datos.";
				
		}
	}
}

	
?>
