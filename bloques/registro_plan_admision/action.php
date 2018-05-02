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
* @description  Action de registro de informacion anual para profesores
* @usage        
*****************************************************************************************************************/
?><?PHP  
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
	include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	
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
		//Guardar la informacion el grupo
		if(isset($_POST['id_proceso']))
		{
			$cadena_sql='DELETE FROM aplicativo_plan_admision ';
			$cadena_sql.='WHERE id_proceso='.$_POST['id_proceso'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			$agregar=$_POST['id_proceso'];		
			
		}
		else
		{
			$agregar="NULL";		
		}	
				
		// 
		$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."plan_admision` ";
		$cadena_sql.= "(  `id_proceso` , `id_programa` , `tipo` , `ingreso` , `inscripcion` , `icfes` , `admision` , `anno`  )  ";
		$cadena_sql.= "VALUES (";
		$cadena_sql.= $agregar."," ;
		$cadena_sql.= $_POST['programa']."," ;
		$cadena_sql.= "'".$_POST['tipo']."'," ;
		$cadena_sql.= $_POST['ingreso']."," ;
		$cadena_sql.= $_POST['inscripcion']."," ;
		$cadena_sql.= $_POST['icfes']."," ;
		$cadena_sql.= $_POST['admision']."," ;
		$cadena_sql.= $_POST['anno'];
		$cadena_sql.=")";
		//echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
		//exit;
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_plan_admision")."')</script>";   
			
	
		}
		else
		{
			//Instanciar a la clase pagina con mensaje de error
			echo "Error";
		}
	} 
	else
	{
		echo "Error fatal al acceder a la base de datos.";
			
	}
	


	
?>
