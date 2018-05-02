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
		$cadena_sql='DELETE FROM aplicativo_plan_poblacion ';
		$cadena_sql.='WHERE id_programa='.$_POST['programa'];
		$cadena_sql.=' AND anno='.$_POST['anno'];
		$cadena_sql.=' AND periodo='.$_POST['periodo'];
		//echo $cadena_sql.'<br>';
		//exit;
		$acceso_db->ejecutar_acceso_db($cadena_sql);
		
		$cadena_sql='DELETE FROM aplicativo_plan_duracion ';
		$cadena_sql.='WHERE id_programa='.$_POST['programa'];
		$cadena_sql.=' AND anno='.$_POST['anno'];
		$cadena_sql.=' AND periodo='.$_POST['periodo'];
		//echo $cadena_sql.'<br>';
		//exit;
		$acceso_db->ejecutar_acceso_db($cadena_sql);
		
				
		for($contador=1;$contador<21;$contador++)
		{
			$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."plan_poblacion` ";
			$cadena_sql.= "(  `id_programa` , `poblacion` , `semestre`, `anno`, `periodo`)  ";
			$cadena_sql.= "VALUES (";
			$cadena_sql.= $_POST['programa']."," ;
			if(isset($_POST["semestre_".$contador]))
			{
				if($_POST["semestre_".$contador]=="")
				{
					$cadena_sql.= "0," ;
				}
				else
				{
					$cadena_sql.= $_POST["semestre_".$contador]."," ;
				}
			}
			else
			{
				$cadena_sql.= "0," ;
			}
			$cadena_sql.= $contador."," ;
			$cadena_sql.= $_POST['anno'].",";
			$cadena_sql.= $_POST['periodo'];
			$cadena_sql.=")";
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	 
		 
		 
		}
		
		$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."plan_duracion` ";
		$cadena_sql.= "(  `id_programa` , `real` , `teorico`, `anno`, `periodo`,observacion )  ";
		$cadena_sql.= "VALUES (";
		$cadena_sql.= $_POST['programa']."," ;
		
		if(isset($_POST["real"]))
		{
			if($_POST["real"]=="")
			{
				$cadena_sql.= "0," ;
			}
			else
			{
				$cadena_sql.= $_POST["real"]."," ;
			}
		}
		else
		{
			$cadena_sql.= "0," ;
		}
		
		if(isset($_POST["teorico"]))
		{
			if($_POST["teorico"]=="")
			{
				$cadena_sql.= "0," ;
			}
			else
			{
				$cadena_sql.= $_POST["teorico"]."," ;
			}
		}
		else
		{
			$cadena_sql.= "0," ;
		}
		
		$cadena_sql.= $_POST['anno'].",";
		$cadena_sql.= $_POST['periodo'].",";
		$cadena_sql.= "'".$_POST['observacion']."'";
		$cadena_sql.=")";
		//echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
		
		
		//exit;
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_plan_poblacion")."')</script>";   
			
	
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
