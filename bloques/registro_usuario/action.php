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
?>
<?PHP  
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
if(!key_exists('nombre',$_POST)||!key_exists('apellido',$_POST)||!key_exists('correo',$_POST)||!key_exists('usuario',$_POST)||!key_exists('clave',$_POST))
{

			$raiz="./../../../";
			include_once($raiz."incluir/error_ilegal.php");	
	
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
		Segundo: Se comprueba que el usuario y el correo no existan en la base de datos
		**/
		$acceso_db=new dbms($configuracion);
		$enlace=$acceso_db->conectar_db();
		if (is_resource($enlace))
		{	 
			$nueva_sesion=new sesiones($configuracion);
			$nueva_sesion->especificar_enlace($enlace);
			$esta_sesion=$nueva_sesion->numero_sesion();
			//Rescatar el valor de la variable usuario de la sesion
			$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
			if($registro)
			{
				$el_usuario=$registro[0][0];
			}
			if(!isset($_POST["registro"]))
			{
				$cadena_sql="SELECT ";
				$cadena_sql.="* ";
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."registrado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="usuario='".$_POST['usuario']."'";
				//echo $cadena_sql;
				$acceso_db->registro_db($cadena_sql,0);
				$registro=$acceso_db->obtener_registro_db();
				$campos=$acceso_db->obtener_conteo_db();
				if($campos>0)
				{
					//El usuario ya esta registrado por tanto instancia a la clase pagina
					$cadena_sql='SELECT * FROM aplicativo_registrado WHERE correo="'.$_POST['correo'].'"';
					//echo $cadena_sql;
					$acceso_db->registro_db($cadena_sql,0);
					$registro=$acceso_db->obtener_registro_db();
					$campos=$acceso_db->obtener_conteo_db();
					if($campos>0)
					{
						unset ($_POST["correo"]);
					}
					unset ($_POST["action"]);
					unset ($_POST["usuario"]);
					$la_pagina=new pagina('registro',$configuracion);
				}
				else
				{
					$cadena_sql='SELECT * FROM aplicativo_registrado WHERE correo="'.$_POST['correo'].'"';
					//echo $cadena_sql;
					$acceso_db->registro_db($cadena_sql,0);
					$registro=$acceso_db->obtener_registro_db();
					$campos=$acceso_db->obtener_conteo_db();
					if($campos>0)
					{
						unset ($_POST["action"]);
						unset ($_POST["correo"]);
						$la_pagina=new pagina('registro',$configuracion);
						exit;
					}
					//Tercero: Se guarda el registro en la base de datos y se envia un correo al webmaster para la validación del nivel de acceso.
					$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."registrado ( id_usuario , nombre , apellido, correo, telefono, usuario, clave, tipo,estado) VALUES (NULL, '".$_POST['nombre']."','".$_POST['apellido']."' , '".$_POST['correo']."','".$_POST['telefono']."','".$_POST['usuario']."','".md5($_POST['clave'])."',".$_POST['nivel_acceso'].",0)";
					//echo $cadena_sql;
					$db_sel = new dbms($configuracion);
					$db_sel->especificar_enlace($enlace);
					$resultado=$db_sel->ejecutar_acceso_db($cadena_sql); 
					if($resultado==TRUE)
					{
						if(!isset($_POST["admin"]))
						{
							$destinatario=$configuracion["correo_admin"];
							$encabezado="Nuevo Usuario ".$configuracion["titulo"];
							$mensaje="Señor Administrador:\n";
							$mensaje.="Un nuevo usuario ha solicitado acceso a ".$configuracion["titulo"]."\n\n";
							$mensaje.="Por favor visite la seccion de administracion para gestionar esta petición.\n";
							$mensaje.="_____________________________________________________________________\n";
							$mensaje.="Por compatibilidad con los servidores de correo, en este mensaje se han omitido a\n";
							$mensaje.="proposito las tildes.";
							$correo= mail($destinatario, $encabezado,$mensaje) ;
							$destinatario=$_POST['correo'];
							$encabezado="Bienvenido a ".$configuracion["titulo"];
							$mensaje="Apreciado ".$_POST['nombre']." ".$_POST['apellido']."\n";
							$mensaje.="El grupo de trabajo de ".$configuracion["titulo"]." le agradece su interes \n";
							$mensaje.="en vincularse a su Portal Web.\n\n";
							$mensaje.="En las proximas horas estaremos enviando la confirmacion de los datos de registro asi como\n";
							$mensaje.="el nivel autorizado de acceso al sistema.\n";
							$mensaje.="_____________________________________________________________________\n";
							$mensaje.="Ambiente de desarrollo para aplicaciones web.\n ";
							$mensaje.="Software amparado por licencia GPL. Copyright (c) 2004-2006.";
							$mensaje.="_____________________________________________________________________\n";
							$mensaje.="Por compatibilidad con los servidores de correo en este mensaje se han omitido a\n";
							$mensaje.="proposito las tildes.";
							$mensaje.="_____________________________________________________________________\n";
							$mensaje.="Si tiene inquietudes por favor envie un correo a: ".$configuracion["correo_admin"]."\n";
							$correo= mail($destinatario, $encabezado,$mensaje) ;
							//siempre que se use la clase pagina desde un action debe desasignar la variable $POST['action']
							reset($_POST);
							while(list($clave,$valor)=each($_POST))
							{
								unset($_POST[$clave]);
								 
							}
							$la_pagina=new pagina('registro_exito',$configuracion);
							//Instanciar a la clase pagina con mensaje de exito
						}
						else
						{
							unset($_POST['action']);
						include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
						$pagina="admin_usuario";
						$opciones="&accion=1";
						$opciones.="&hoja=0";
						echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$opciones."')</script>";   
						}
					}
					else
					{
						//Instanciar a la clase pagina con mensaje de error
					}
							
				}
			}
			else
			{
				//Rescatar valores anteriores del registro
				$cadena_sql="SELECT ";
				$cadena_sql.="`id_usuario` ,"; 
				$cadena_sql.=" `nombre` , ";
				$cadena_sql.="`apellido` , ";
				$cadena_sql.="`correo` , ";
				$cadena_sql.="`telefono` , ";
				$cadena_sql.="`usuario` , ";
				$cadena_sql.="`clave` , ";
				$cadena_sql.="`tipo`, ";
				$cadena_sql.="`estado` ";
				$cadena_sql.="FROM ";
				$cadena_sql.="`".$configuracion["prefijo"]."registrado` ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_usuario=".$_POST["registro"]." ";
				$cadena_sql.="LIMIT 1";
				//echo $cadena_sql;
				$acceso_db->registro_db($cadena_sql,0);
				$registro=$acceso_db->obtener_registro_db();
				$campos=$acceso_db->obtener_conteo_db();
				if($campos>0)
				{
				
					$cadena_sql = "DELETE FROM ";
					$cadena_sql.= "`".$configuracion["prefijo"]."registrado` ";
					$cadena_sql.= " WHERE ";
					$cadena_sql.= "`id_usuario` = ".$_POST["registro"];
					$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
					$logger=$acceso_db->logger($configuracion,$el_usuario,"Borrado registro de usuario No ".$_POST["registro"]." por edici&oacute;n");
					
					
					if($resultado==TRUE)
					{
						$cadena_sql= "INSERT INTO ";
						$cadena_sql.= "`".$configuracion["prefijo"]."registrado` ";
						$cadena_sql.= "( ";
						$cadena_sql.= "`id_usuario` , ";
						$cadena_sql.= "`nombre` , ";
						$cadena_sql.= "`apellido` , ";
						$cadena_sql.= "`correo` , ";
						$cadena_sql.= "`telefono` , ";
						$cadena_sql.= "`usuario` , ";
						$cadena_sql.= "`clave` , ";
						$cadena_sql.= "`tipo` , ";
						$cadena_sql.= "`estado` ";
						$cadena_sql.= ")";
						$cadena_sql.= "VALUES ";
						$cadena_sql.= "(";
						$cadena_sql.= "'".$registro[0][0]."', ";
						$cadena_sql.= "'".$_POST["nombre"]."', ";
						$cadena_sql.= "'".$_POST["apellido"]."', ";
						$cadena_sql.= "'".$_POST["correo"]."', ";
						$cadena_sql.= "'".$_POST["telefono"]."', ";
						$cadena_sql.= "'".$_POST["usuario"]."', ";
						if($_POST["clave"]==md5("anterior"))
						{
							$cadena_sql.= "'".$registro[0][6]."', ";
						}
						else
						{
							$cadena_sql.= "'".md5($_POST["clave"])."', ";
						}
						$cadena_sql.= "'".$_POST["nivel_acceso"]."', ";
						$cadena_sql.= "'".$registro[0][8]."'";
						$cadena_sql.= ")";
						$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
						$logger=$acceso_db->logger($configuracion,$el_usuario,"Insertar registro de usuario No ".$_POST["registro"]." por edici&oacute;n");
						unset($_POST['action']);
						include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
						//TO DO Posibilidad de ediatra directamente desde la seccion de logout...
						$pagina="admin_usuario";
						$variable="";
						if(isset($_POST["hoja"]))
						{
							$variable="&hoja=".$_POST["hoja"];
							if(isset($_POST["accion"]))
							{
								$variable.="&accion=".$_POST["accion"];
							}
							else
							{
								$variable.="&accion=1";
							}
						}
						echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   
					
					}
					else
					{
					}
					
					
									
				}
				else
				{
					echo "<h1>Error de Acceso</h1>Por favor contacte con el administrador del sistema.";				
				}
			}	
		} 
		else
		{
			include_once($configuracion["raiz_aplicativo"].$configuracion["incluir"]."/error.php");	
				
		}
	}
}

	
?>
