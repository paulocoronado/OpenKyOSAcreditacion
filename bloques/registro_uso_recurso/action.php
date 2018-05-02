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
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
	//TODO: Cambiar acceso a programa
	/*
	echo "Valores enviados con el método POST:<br>";
	reset ($_POST);
	while (list ($clave, $val) = each ($_POST)) {
	echo "$clave => $val<br>";
	}
	exit;
	*/
	
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{	 
		
		$cadena_sql="SELECT id_programa ";
		$cadena_sql.="FROM ".$configuracion["prefijo"]."usuario_programa ";
		$cadena_sql.="WHERE id_usuario=".$_POST['usuario']." ";
		$cadena_sql.="LIMIT 1 ";
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$id_programa=$registro[0][0];
			//echo $id_programa;
		}
	
		
		$cadena_sql="SELECT ";
		$cadena_sql.="* ";
		$cadena_sql.="FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."uso_recurso ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="anno=".$_POST['anno']." ";
		$cadena_sql.="AND ";
		$cadena_sql.="id_programa=".$id_programa;
		echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			//El usuario ya esta registrado por tanto instancia a la clase pagina
			echo "<h2>El a&ntilde; que est&aacute; intentando ingresar ya existe. Por favor edite el registro anterior.</h2>";
		}
		else
		{
			$cadena_sql="SELECT id_recurso,nombre FROM ".$configuracion["prefijo"]."recurso_fisico";
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
			
				for($contador=0;$contador<$campos;$contador++)
				{ 
					//Tercero: Se guarda el registro en la base de datos
					if(isset($_POST[$registro[$contador][0]]))
					{	
						if($_POST[$registro[$contador][0]]=="")
						{
							$valor=0;
						}
						else
						{						
							$valor=$_POST[$registro[$contador][0]];						
						}
						$cadena_sql_2 = "INSERT INTO ";
						$cadena_sql_2.= "".$configuracion["prefijo"]."uso_recurso ";
						$cadena_sql_2.= "(";
						$cadena_sql_2.= "id_programa , ";
						$cadena_sql_2.= "id_recurso, ";
						$cadena_sql_2.= "utilizacion, ";
						$cadena_sql_2.= "anno ";
						$cadena_sql_2.= ") ";
						$cadena_sql_2.= "VALUES ";
						$cadena_sql_2.= "(";
						$cadena_sql_2.= $id_programa.",";
						$cadena_sql_2.= $registro[$contador][0]." , ";
						$cadena_sql_2.= $valor.",";
						$cadena_sql_2.= $_POST['anno'];
						$cadena_sql_2.= ")";
						//echo $cadena_sql_2;
						//exit;
						$db_sel = new dbms($configuracion);
						$db_sel->especificar_enlace($enlace);
						$resultado=$db_sel->ejecutar_acceso_db($cadena_sql_2); 
					}	
				}
				if($resultado==TRUE)
				{
					//exit;
					unset($_POST['action']);
					include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
					echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_dir_utilizacion")."&usuario=".$_POST['usuario']."')</script>";   
				
				}
				else
				{
					//Instanciar a la clase pagina con mensaje de error
					echo "Error al ingresar los datos. Por favor int&eacute;ntelo m&aacute;s tarde.";
				}
	
			}
		}	
	} 
	else
	{
		echo "Error fatal al acceder a la base de datos.";
			
	}
	


	
?>
