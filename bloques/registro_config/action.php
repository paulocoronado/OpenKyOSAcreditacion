<?php  

/**
Primero se verifica si todos los campos obligatorios del formulario son pasados por el metodo POST;
En el caso de que esto falle se termina el procesamiento de la página y se envia un mensaje de 
intento de acceso ilegal al sistema
*/

/*
El formulario devuelve una cadena en blanco '' vacio si no se llenó nada en el control de tipo texto.



*/

if(!key_exists('db_dns',$_POST)||!key_exists('db_usuario',$_POST)||!key_exists('db_clave',$_POST)||!key_exists('administrador',$_POST)||!key_exists('clave',$_POST)||!key_exists('correo',$_POST)|!key_exists('db_nombre',$_POST))
{
			
			$raiz="./../../../";
			include_once($raiz."incluir/error_ilegal.php");	
	
	}
	else{
		
		if(!(strlen($_POST['administrador'])>2)||!(strlen($_POST['correo'])>6)||!(strlen($_POST['clave'])>4))
				{
					include_once($raiz.$berosa["incluir"]."/error_datos.php");	
					}
					else
					{
		include_once($raiz.$berosa["clases"]."/sql.class.php");	
		/**
		Revisamos que la conexión a la base de datos con los parámetros dados sea correcta. 
		En caso de éxito se guardan en el archivo de configuración. De otra forma se recarga el
		formulario de administración junto con un mensaje explicando el error.
		**/
		$this->acceso_db=new db_admin($berosa);
	
		/**Seleccionar el DBMS de acuerdo a la elección del  administrador*/
		switch($_POST["db_dbms"]){
			case 1:
				$this->dbms='mysql';
				$this->archivo_arquitectura=$raiz.$berosa["arquitectura"]."/mysql.sql";
				break;
			
			}
	
		$this->acceso_db->especificar_dbms($this->dbms);
		$this->acceso_db->especificar_servidor($_POST["db_dns"]);
		$this->acceso_db->especificar_db($_POST["db_nombre"]);		
		$this->acceso_db->especificar_usuario($_POST["db_usuario"]);
		$this->acceso_db->especificar_clave($_POST["db_clave"]);
		
		
		$this->enlace=$this->acceso_db->conectar_db();
		if (is_resource($this->enlace)){
				/*Como hay una conexión válida se puede crear  la arquitectura de datos a partir del esquema
				correspondiente al DBMS seleccionado.

				*/
				$resultado=$this->acceso_db->arquitectura_db($this->archivo_arquitectura);
				if($resultado){
						/*Se guardan los datos del administrador*/
						$this->cadena_sql="INSERT INTO siaud_usuario ( nombre , clave , tipo ) VALUES ('".$_POST["administrador"]."', '".md5($_POST["clave"])."', 4)";
						$acceso=$this->acceso_db->ejecutar_acceso_db($this->cadena_sql); 
						if($acceso==TRUE){
						
								if(is_writable($raiz.$berosa["configuracion"]."/config.inc.php"))
								{
									$configuracion = "\n/* Variables de configuración del SIAUD*/\n\n";
									$configuracion .= '$berosa["dbms"]= \'' . $this->dbms . '\';' . "\n\n";
									$configuracion .= '$berosa["db_dns"] = \'' . $_POST["db_dns"]. '\';' . "\n";
									$configuracion .= '$berosa["db_nombre"] = \'' . $_POST["db_nombre"]. '\';' . "\n";
									$configuracion .= '$berosa["db_usuario"] = \'' . $_POST["db_usuario"]. '\';' . "\n";
									$configuracion .= '$berosa["db_clave"] = \'' . $_POST["db_clave"]. '\';' . "\n";
									
									$configuracion .= '$berosa["correo_admin"] = \'' . $_POST["correo"]. '\';' . "\n";
									$configuracion .= '$berosa["host"] = \'' . $_POST["host"]. '\';' . "\n";
									$configuracion .= '$berosa["site"] = \'' . $_POST["site"]. '\';' . "\n";
									$configuracion .= '$berosa["raiz_documento"] = \'' . $_POST["raiz"]. '\'.$berosa["site"];' . "\n";
									$configuracion .= "define('SIAUD_INSTALADO', TRUE);"."\n\n";	
									$configuracion .= '?' . '>'; 
									$archivo = @fopen($raiz.$berosa["configuracion"]."/config.inc.php", 'a+');
									$resultado = @fwrite($archivo, $configuracion, strlen($configuracion));
									include_once($raiz.$berosa["incluir"]."/exito.php");
									
									
									}
									else
									{
										
										$this->mensaje_error["encabezado"]="IMPOSIBLE ESCRIBIR EN EL ARCHIVO";
										$this->mensaje_error["cuerpo"]="El archivo de configuración no est&aacute; disponible para escritura.<br><br>Por favor ingrese los datos de configuraci&oacute;n manualmente de acuerdo a las instrucciones.<br>";
										include_once($raiz.$berosa["incluir"]."/error.php");
										
										
										}
							}else{
								
								$this->mensaje_error["encabezado"]="IMPOSIBLE GUARDAR LOS DATOS";
								$this->mensaje_error["cuerpo"]="Aunque se ha accedido a la base de datos no se pueden insertar datos<br>";
								$this->mensaje_error["cuerpo"].="en las tablas.<br><br>";
								$this->mensaje_error["cuerpo"].="Por favor revise los privilegios de su usuario.";
								include_once($raiz.$berosa["incluir"]."/error.php");
								
								
								}			
				}
				else
				{
					$this->error=$this->acceso_db->obtener_error();
					include_once($raiz.$berosa["incluir"]."/error.php");
				}

				
			} else{
       			/*Con los parámetros que se pasaron no se pudo realizar una conexión valida*/
				$this->error=$this->acceso_db->obtener_error();
				include_once($raiz.$berosa["incluir"]."/error.php");
				
				
				}
		}
}

	
?>
