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
* @description  Action de registro de informacion anual para profesores
* @usage        
*****************************************************************************************************************/
?><?php  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
		
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{	
	if(isset($_POST["usuario"]))
	{		
		switch($_POST['usuario'])
		{
			
			case 'veterinaria':
				$id_programa=1;
				break;
				
			case 'agronomia':
				$id_programa=2;
				break;
					
			case 'enfermeria':
				$id_programa=3;
				break;
				
			case 'edufisica':
				$id_programa=4;
				break;
			default:
				$id_programa=0;
			
		}
	}	
//Primero se verifica si se viene desde el formulario de edicion

	if(isset($_POST['id_empleo']))
	{
		$empleo="";
		for($mes=1;$mes<13;$mes++)
		{
			if(isset($_POST[$mes]))
			{
				$empleo=$empleo."1";
			
			}
			else
			{
				$empleo=$empleo."0";
			
			}
		
		}
		
		$cadena_sql='SELECT * FROM ".$configuracion["prefijo"]."egresado_empleo WHERE id_empleo='.$_POST['id_empleo'];
		//echo $cadena_sql.'<br>';
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			//El anno ya esta registrado entonces se realiza un UPDATE
			$cadena_sql = "UPDATE `".$configuracion["prefijo"]."egresado_empleo` SET ";
			$cadena_sql.= "ocupacion='".$_POST['ocupacion']."',";
			$cadena_sql.= "ubicacion='".$_POST['ubicacion']."',";
			$cadena_sql.= "empleo='".$empleo."'";
			$cadena_sql.= " WHERE id_empleo=".$_POST['id_empleo'];
			//echo $cadena_sql.'<br>';
			
		}
		else
		{
			//Esta porcion de codigo no debiera ejecutarse nunca.
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."egresado_empleo ";
			$cadena_sql.= "(`id_empleo` ,`identificacion`,`id_programa` , `ocupacion` , `ubicacion`,`empleo`,`anno` ) ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= "NULL, '".$_POST['identificacion']."','".$id_programa."','".$_POST['ocupacion']."','".$_POST['ubicacion']."','".$empleo."',".$_POST['anno'];
			$cadena_sql.=")";
			//echo $cadena_sql.'<br>';
		}
		echo $cadena_sql."<br>";
		$db_sel = new dbms($configuracion);
		$db_sel->especificar_enlace($enlace);
		$resultado=$db_sel->ejecutar_acceso_db($cadena_sql); 	
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_egresado")."&registro=".$_POST['identificacion']."&usuario=".$_POST['usuario']."')</script>";   
			
	
		}
		else
		{
			//Instanciar a la clase pagina con mensaje de error
		}
	}
	else
	{	
	
		$empleo="";
		for($anno=1;$anno<13;$anno++)
		{
			if(isset($_POST[$anno]))
			{
				$empleo=$empleo."1";
			
			}
			else
			{
				$empleo=$empleo."0";
			
			}
		
		}
	
	
	
	
		//Si es nuevo se verifica el anno
		$cadena_sql='SELECT * FROM aplicativo_egresado_empleo WHERE identificacion="'.$_POST['identificacion'].'" AND anno='.$_POST['anno'];
		//echo $cadena_sql.'<br>';
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			//El anno ya esta registrado entonces no se realiza nada. TO DO
			$cadena_sql = "UPDATE `".$configuracion["prefijo"]."egresado_empleo` SET ";
			$cadena_sql.= "ocupacion='".$_POST['ocupacion']."',";
			$cadena_sql.= "ubicacion=".$_POST['ubicacion'];
			$cadena_sql.= "empleo=".$empleo;
			$cadena_sql.= " WHERE identificacion=".$_POST['identificacion'];
			//echo $cadena_sql.'<br>';
			
		}
		else
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."egresado_empleo ";
			$cadena_sql.= "( `id_empleo` ,`identificacion`,`id_programa` , `ocupacion` , `ubicacion`,`empleo`,`anno` ) ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= "NULL, '".$_POST['identificacion']."','".$id_programa."','".$_POST['ocupacion']."','".$_POST['ubicacion']."','".$empleo."',".$_POST['anno'];
			$cadena_sql.=")";
			//echo $cadena_sql.'<br>';
		}
			//echo $cadena_sql."<br>";
			$db_sel = new dbms($configuracion);
			$db_sel->especificar_enlace($enlace);
			$resultado=$db_sel->ejecutar_acceso_db($cadena_sql); 	
			if($resultado==TRUE)
			{
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
				echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_egresado")."&registro=".$_POST['identificacion']."&usuario=".$_POST['usuario']."')</script>";   
				
		
			}
			else
			{
				//Instanciar a la clase pagina con mensaje de error
			}
		
	}

} 
else
{
	echo "Error fatal al acceder a la base de datos.";
		
}



	
?>
