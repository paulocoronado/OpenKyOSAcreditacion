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
		if(isset($_POST['id_grupo']))
		{
			$cadena_sql='DELETE FROM aplicativo_grupo_investigacion ';
			$cadena_sql.='WHERE id_grupo='.$_POST['id_grupo'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			
			$cadena_sql='DELETE FROM aplicativo_reconocimiento_grupo ';
			$cadena_sql.='WHERE id_grupo='.$_POST['id_grupo'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			
			$cadena_sql='DELETE FROM aplicativo_estado_grupo ';
			$cadena_sql.='WHERE id_grupo='.$_POST['id_grupo'];
			//echo $cadena_sql.'<br>';
			//exit;
			$acceso_db->ejecutar_acceso_db($cadena_sql);
			
			$agregar=$_POST['id_grupo'];		
			
		}
		else
		{
			$agregar="NULL";		
		}	
				
		// 
		$cadena_sql = "INSERT INTO `".$configuracion["prefijo"]."grupo_investigacion` ";
		$cadena_sql.= "( `id_grupo` , `nombre` , `id_programa` , `director` , `anno` )  ";
		$cadena_sql.= "VALUES (";
		$cadena_sql.= $agregar."," ;
		$cadena_sql.= "'".$_POST['nombre']."'," ;
		$cadena_sql.= $_POST['programa']."," ;
		$cadena_sql.= "'".$_POST['director']."'," ;
		$cadena_sql.= $_POST['anno'];
		$cadena_sql.=")";
		//echo $cadena_sql."<br>";
		$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
		//exit;
		if($agregar=='NULL')
		{
			$cadena_sql="SELECT LAST_INSERT_ID()";
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$campos=$acceso_db->obtener_conteo_db();
			if($campos>0)
			{
				$agregar=$registro[0][0];
			}
		
		
		}
		
		$institucional=array(); 
		$colciencias=array(); 
		$actividad=array(); 
		$contador=0;
		$contador_1=0;
		$contador_2=0;
		reset ($_POST);
		while (list ($clave, $val) = each ($_POST)) 
		{
			if(!strncmp ("insti", $clave, 5))
			{
				$institucional[$contador]=$val;
				$contador++;
			}
			else
			{
				if(!strncmp ("colci", $clave, 5))
				{
					$colciencias[$contador_1]=$val;
					$contador_1++;
				}
				else
				{
					if(!strncmp ("activ", $clave, 5))
					{
						$actividad[$contador_2]=$val;
						$contador_2++;
					}
				}			
			}
		}
		//echo count($annos)."<br>";
		
		// Guardar informacion de estado del grupo
		
		for($contador=0;$contador<count($institucional);$contador++) 	
		
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."reconocimiento_grupo ";
			
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
			$cadena_sql.= "( `id_grupo` , `entidad` , `anno` )  ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= $agregar."," ;
			$cadena_sql.= "'institucional'," ;
			$cadena_sql.= $institucional[$contador];
			$cadena_sql.=")";
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			
					
		}
		
		for($contador=0;$contador<count($colciencias);$contador++) 	
		
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."reconocimiento_grupo ";
			
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
			$cadena_sql.= "( `id_grupo` , `entidad` , `anno` )  ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= $agregar."," ;
			$cadena_sql.= "'colciencias'," ;
			$cadena_sql.= $colciencias[$contador];
			$cadena_sql.=")";
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			
					
		}
		
		for($contador=0;$contador<count($actividad);$contador++) 	
		
		{
			$cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."estado_grupo ";
			
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 
			$cadena_sql.= "( `id_grupo` , `estado` , `anno` )  ";					
			$cadena_sql.= "VALUES (";
			$cadena_sql.= $agregar."," ;
			$cadena_sql.= "1," ;
			$cadena_sql.= $actividad[$contador];
			$cadena_sql.=")";
			//echo $cadena_sql."<br>";
			$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql); 	
			
					
		}
		
		
		
		if($resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("admin_iioc_grupo")."')</script>";   
			
	
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
