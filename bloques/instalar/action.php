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
* @name          action.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   
* @package	instalar
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* @description  Formulario para el ingreso de los parámetros básicos de configuración del MESCUD; en un archivo de
*               inclusión por si solo no tiene uso. Script para el tratamiento del formulario
*
*****************************************************************************************************************/
?>
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
	/*Se esta tratando de ingresar ilegalmente a la pagina por tanto se muestra el mensaje de acceso ilegal
	No se usa la clase mensaje pues no existe forma de acceder a la base de datos.	
	*/
	$la_raiz="./../../../";
	include_once($la_raiz.$configuracion["incluir"]."/instalar/acceso_ilegal.php");	
	
}
else
{
		
	if(!(strlen($_POST['administrador'])>2)||!(strlen($_POST['correo'])>6)||!(strlen($_POST['clave'])>4))
	{
		//TO DO			
		include_once($raiz.$configuracion["incluir"]."/instalar/error_datos.php");	
	}
	else
	{
		include_once($raiz.$configuracion["clases"]."/sql.class.php");	
		include_once($raiz.$configuracion["clases"]."/dbms.class.php");	
		/**
		Revisamos que la conexión a la base de datos con los parámetros dados sea correcta. 
		En caso de éxito se guardan en el archivo de configuración. De otra forma se recarga el
		formulario de administración junto con un mensaje explicando el error.
		**/
		$acceso_db=new dbms($configuracion);
	
		/**Seleccionar el DBMS de acuerdo a la elección del  administrador*/
		switch($_POST["db_dbms"]){
			case 1:
				$dbms='mysql';
				$archivo_arquitectura=$raiz.$configuracion["arquitectura"]."/mysql.sql";
				break;
			
	}
	
	$acceso_db->especificar_dbsys($dbms);
	$acceso_db->especificar_servidor($_POST["db_dns"]);
	$acceso_db->especificar_db($_POST["db_nombre"]);		
	$acceso_db->especificar_usuario($_POST["db_usuario"]);
	$acceso_db->especificar_clave($_POST["db_clave"]);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace)){
	/*Como hay una conexión válida se puede crear  la arquitectura de datos a partir del esquema
	correspondiente al DBMS seleccionado.
	*/
		$resultado=$acceso_db->arquitectura_db($archivo_arquitectura);
		if($resultado){
		/*Se guardan los datos del administrador*/
		$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."usuario ( nombre , clave , tipo ) VALUES ('".$_POST["administrador"]."', '".md5($_POST["clave"])."', 4)";
		$acceso=$acceso_db->ejecutar_acceso_db($cadena_sql); 
		if($acceso==TRUE){
		
				if(is_writable($raiz.$configuracion["configuracion"]."/config.inc.php"))
				{
					$config = "<?php  /* Variables de configuración del MESCUD*/\n\n";
					$config .= '$configuracion["dbsys"]= \'' . $dbms . '\';' . "\n\n";
					$config .= '$configuracion["db_dns"] = \'' . $_POST["db_dns"]. '\';' . "\n";
					$config .= '$configuracion["db_nombre"] = \'' . $_POST["db_nombre"]. '\';' . "\n";
					$config .= '$configuracion["db_usuario"] = \'' . $_POST["db_usuario"]. '\';' . "\n";
					$config .= '$configuracion["db_clave"] = \'' . $_POST["db_clave"]. '\';' . "\n";
					
					$config .= '$configuracion["correo_admin"] = \'' . $_POST["correo"]. '\';' . "\n";
					$config .= '$configuracion["host"] = \'' . $_POST["host"]. '\';' . "\n";
					$config .= '$configuracion["site"] = \'' . $_POST["site"]. '\';' . "\n";
					$config .= '$configuracion["raiz_documento"] = \'' . $_POST["raiz"]. '\'.$configuracion["site"];' . "\n";
					$config .= "define('APLICATIVO_INSTALADO', TRUE);"."\n\n";	
					$config .= '?>'; 
					$archivo = fopen($raiz.$configuracion["configuracion"]."/config.inc.php", 'a+');
					$resultado = fwrite($archivo, $config, strlen($config));
					echo "La configuraci&oacute;n se ha realizado con &eacute;xito";
					
					
					}
					else
					{
						
						$mensaje_error["encabezado"]="IMPOSIBLE ESCRIBIR EN EL ARCHIVO";
						$mensaje_error["cuerpo"]="El archivo de configuración no est&aacute; disponible para escritura.<br><br>Por favor ingrese los datos de configuraci&oacute;n manualmente de acuerdo a las instrucciones.<br>";
						include_once($raiz.$configuracion["incluir"]."/instalar/error.php");
						
						
						}
			}else{
				
				$mensaje_error["encabezado"]="IMPOSIBLE GUARDAR LOS DATOS";
				$mensaje_error["cuerpo"]="Aunque se ha accedido a la base de datos no se pueden insertar datos<br>";
				$mensaje_error["cuerpo"].="en las tablas.<br><br>";
				$mensaje_error["cuerpo"].="Por favor revise los privilegios de su usuario.";
				include_once($raiz.$configuracion["incluir"]."/error.php");
				
				
				}			
		}
		else
		{
			$error=$acceso_db->obtener_error();
			include_once($raiz.$configuracion["incluir"]."/instalar/error.php");
		}

		
	} else{
	/*Con los parámetros que se pasaron no se pudo realizar una conexión valida*/
		$error=$acceso_db->obtener_error();
		include_once($raiz.$configuracion["incluir"]."/instalar/error.php");
		
		
		}
		}
}

	
?>
