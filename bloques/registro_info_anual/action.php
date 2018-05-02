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
		
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{	
	if(isset($_POST['anno']))
	{
		$cadena_sql='SELECT * FROM ".$configuracion["prefijo"]."profesor_info_anual WHERE identificacion="'.$_POST['identificacion'].'" AND anno='.$_POST['anno'];
		//echo $cadena_sql.'<br>';
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			//El anno ya esta registrado entonces se realiza un UPDATE
			$cadena_sql = "UPDATE `".$configuracion["prefijo"]."profesor_info_anual` SET ";
			$cadena_sql.= "id_programa=".$_POST['id_programa'].",";
			$cadena_sql.= "id_tipo_vinculacion=".$_POST['id_tipo_vinculacion'].",";
			$cadena_sql.= "id_categoria=".$_POST['id_categoria'].",";
			$cadena_sql.= "id_titulo=".$_POST['id_titulo'];
			$cadena_sql.= " WHERE identificacion='".$_POST['identificacion']."' AND anno=".$_POST['anno'];
			//echo $cadena_sql.'<br>';
			
		}
		else
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."profesor_info_anual ";
			$cadena_sql.= "( `identificacion` , `id_programa` , `id_tipo_vinculacion`, `id_categoria` , `id_titulo` , `anno` ) ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= "'".$_POST['identificacion']."',".$_POST['id_programa'].",".$_POST['id_tipo_vinculacion'].",".$_POST['id_categoria'].",".$_POST['id_titulo'].",".$_POST['anno'];
			$cadena_sql.=")";
		}
		//echo $cadena_sql."<br>";
		$db_sel = new dbms($configuracion);
		$db_sel->especificar_enlace($enlace);
		$resultado=$db_sel->ejecutar_acceso_db($cadena_sql); 	
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_profesor")."&registro=".$_POST['identificacion']."')</script>";   
			
	
		}
		else
		{
			//Instanciar a la clase pagina con mensaje de error
		}


	
	}
	else
	{
		$annos=array(); 
		$contador=0;
		reset ($_POST);
		while (list ($clave, $val) = each ($_POST)) {
			if(!strncmp ("anno", $clave, 4))
			{
				$annos[$contador]=$val;
				$contador++;
			}
		}
		//echo count($annos)."<br>";
		for($contador=0;$contador<count($annos);$contador++) 	
		{
				
			$cadena_sql='SELECT * FROM ".$configuracion["prefijo"]."profesor_info_anual WHERE identificacion="'.$_POST['identificacion'].'" AND anno='.$annos[$contador];
			//echo $cadena_sql.'<br>';
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				//El anno ya esta registrado entonces se realiza un UPDATE
				$cadena_sql = "UPDATE `".$configuracion["prefijo"]."profesor_info_anual` SET ";
				$cadena_sql.= "id_programa=".$_POST['id_programa'].",";
				$cadena_sql.= "id_tipo_vinculacion=".$_POST['id_tipo_vinculacion'].",";
				$cadena_sql.= "id_categoria=".$_POST['id_categoria'].",";
				$cadena_sql.= "id_titulo=".$_POST['id_titulo'];
				$cadena_sql.= " WHERE identificacion='".$_POST['identificacion']."' AND anno=".$annos[$contador];
				//echo $cadena_sql.'<br>';
				
			}
			else
			{
				$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."profesor_info_anual ";
				$cadena_sql.= "( `identificacion` , `id_programa` , `id_tipo_vinculacion`, `id_categoria` , `id_titulo` , `anno` ) ";					
				$cadena_sql.= "VALUES (";
				$cadena_sql.= "'".$_POST['identificacion']."',".$_POST['id_programa'].",".$_POST['id_tipo_vinculacion'].",".$_POST['id_categoria'].",".$_POST['id_titulo'].",".$annos[$contador];
				$cadena_sql.=")";
			}
			//echo $cadena_sql."<br>";
			$db_sel = new dbms($configuracion);
			$db_sel->especificar_enlace($enlace);
			$resultado=$db_sel->ejecutar_acceso_db($cadena_sql); 
					
		}
		
	}
	if($resultado==TRUE)
	{
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_profesor")."&registro=".$_POST['identificacion']."')</script>";   
		

	}
	else
	{
		//Instanciar a la clase pagina con mensaje de error
	}
} 
else
{
	echo "Error fatal al acceder a la base de datos.";
		
}



	
?>
