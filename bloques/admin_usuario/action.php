<?php
if(!key_exists('action',$_POST))
{
			$raiz="./../../../";
			include_once($raiz."incluir/error_ilegal.php");	
	
}
else{
		/**
		Segundo: Actualiza los datos de los registros que se habian mostrado; Como no se ha implementado
		otra cosa se va a trabajar con lotes de 25 registros.
		**/
		$acceso_db=new dbms($configuracion);
		$enlace=$acceso_db->conectar_db();
		if (is_resource($enlace))
		{
					
			//Como no se ha definido un metodo de paginacion se va a trabajar con todos
			// los registros de la tabla registrados
			$cadena_sql="SELECT id_usuario FROM ".$configuracion["prefijo"]."registrado";
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				for($contador=0;$contador<$campos;$contador++)
				{
					if(key_exists('usuario'.$contador,$_POST))
					{
						if(!key_exists('tipo'.$contador,$_POST))
						{
							
							if($_POST['estado'.$contador]==1)
							{
								/*Se realiza un update para deshabilitar el usuario y un borrado de la tabla de usuario*/
								$cadena_sql="UPDATE ".$configuracion["prefijo"]."registrado SET estado=0 WHERE id_usuario=".$_POST["usuario".$contador];
								//echo $cadena_sql;
								$acceso_db->ejecutar_acceso_db($cadena_sql);	
								$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."usuario WHERE nombre='".$_POST["nombre".$contador]."'";
								//echo $cadena_sql;
								$acceso_db->ejecutar_acceso_db($cadena_sql);	
							}
						
						}
						else
						{
							if($_POST['estado'.$contador]==0)
							{
								$cadena_sql="UPDATE ".$configuracion["prefijo"]."registrado SET estado=1 WHERE id_usuario=".$_POST["usuario".$contador];
								$acceso_db->ejecutar_acceso_db($cadena_sql);	
								/*Por seguridad la actualización de la tabal de usuarios se hace a partir de una búsqueda*/
								$cadena_sql="SELECT usuario,clave,tipo,id_usuario FROM ".$configuracion["prefijo"]."registrado WHERE id_usuario=".$_POST["usuario".$contador];
								//echo $cadena_sql;
								$acceso_db->registro_db($cadena_sql,0);
								$registro=$acceso_db->obtener_registro_db();
								$cadena_sql="INSERT INTO ".$configuracion["prefijo"]."usuario ( id_usuario,nombre,clave,tipo) VALUES (".$registro[0][3] .",'".$registro[0][0] ."','".$registro[0][1]."',".$registro[0][2].")";
								//echo $cadena_sql;
								$acceso_db->ejecutar_acceso_db($cadena_sql);	
							}	
							
						}
					}
						
				}	
			}		

		/*TODO Control de errores de esta página.*/	
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		unset($_POST['action']);
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
		
				
		
}

	
?>
