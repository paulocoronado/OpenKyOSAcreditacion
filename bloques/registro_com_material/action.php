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
		if(isset($_POST['id_material']))
		{
			$cadena_sql='DELETE FROM aplicativo_com_material WHERE id_material='.$_POST['id_material'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			$agregar=$_POST['id_material'];
		}
		else
		{
			$agregar='NULL';
		}	
		
				
		$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."com_material` ";
		$cadena_sql.= "( `id_material` , `identificacion` , `nombre` , `descripcion` , `tipo` , `anno` ) ";					
		$cadena_sql.= "VALUES (";
		$cadena_sql.= $agregar.",";
		$cadena_sql.= "'".$_POST['identificacion']."'," ;
		$cadena_sql.= "'".$_POST['nombre']."'," ;
		$cadena_sql.= "'".$_POST['descripcion']."'," ;
		$cadena_sql.= "'".$_POST['tipo']."'," ;
		$cadena_sql.= $_POST['anno'];
		$cadena_sql.=")";
		echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_com_profesor")."&registro=".$_POST['identificacion']."&mostrar=1&informacion=1')</script>";   
			
	
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
