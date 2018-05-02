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
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{	 
	$cadena_sql='DELETE FROM aplicativo_proyecto_profesor WHERE id_proyecto='.$_POST["registro"];
	//echo $cadena_sql;
	$acceso_db->ejecutar_acceso_db($cadena_sql);
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	$cadena_sql="SELECT identificacion";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor WHERE id_programa=".$id_programa;
	//echo $cadena_sql;
	
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	
	for($contador=0;$contador<$campos;$contador++)
	{
		if(isset($_POST[$contador]))
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."proyecto_profesor ";
			$cadena_sql .= "( id_proyecto , identificacion) ";
			$cadena_sql .= "VALUES (".$_POST['registro'].",'".$_POST[$contador]."')";
			//echo $cadena_sql;
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);
		}
	
	}
	if($resultado==TRUE)
	{
		//siempre que se use la clase pagina desde un action debe desasignar la variable $POST['action']
		unset($_POST['action']);
		$variable="&usuario=".$_POST["usuario"]."&registro=".$_POST["registro"];
		
		while(list($clave,$valor)=each($_POST))
		{
			unset($_POST[$clave]);
				
		}
		
		$pagina="editar_dir_proyecto";
		
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variable."')</script>";   reset($_POST);

		
		
		//Instanciar a la clase pagina con mensaje de exito

	}
	else
	{
		//Instanciar a la clase pagina con mensaje de error
	}
	
	
				
	
} 
else
{
	echo "Error al conectar con la base de datos.";
		
}


	
?>
