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
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 26 de junio de 2005
*******************************************************************************************************************
* @subpackage   admin_usuario
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Bloque principal para la administración de usuarios
*
*****************************************************************************************************************/
?><?php  

$base=new dbms($configuracion);
$enlace=$base->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		
		$el_usuario=$registro[0][0];
	}

	
	if(isset($_POST['terminar']))
	{
		//Verificar todos los valores para encontrar elementos y guardarlos en la correspondiente tabla
		$concatenar=0;
		reset ($_POST);
		$proceso=0;
		$programa=0;
		
		while (list ($clave, $val) = each ($_POST)) 
		{
			if($clave=="programa")
			{
				
				if($val>0)
				{
					$programa=$val;	
				}
				
				
								
				
				
			}
			else
			{
				if($clave=="proceso")
				{
					$proceso=$val;
				
				}
			
			}
				
		
		}
		
		$cadena_sql="DELETE FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."analista_proceso ";
		$cadena_sql.=" WHERE ";
		$cadena_sql.="id_usuario=".$_POST["registro"];
		$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
		
		$cadena_sql="INSERT INTO ";
		$cadena_sql.="".$configuracion["prefijo"]."analista_proceso ";
		$cadena_sql.=" ( ";
		$cadena_sql.="`id_usuario` ,";
		$cadena_sql.=" `id_proceso` ,";
		$cadena_sql.=" `id_programa` ";
		$cadena_sql.=")"; 
		$cadena_sql.="VALUES ";
		$cadena_sql.="(";
		$cadena_sql.=$_POST["registro"].",";
		$cadena_sql.=$proceso.",";
		$cadena_sql.=$programa;
		$cadena_sql.=")";
		//echo $cadena_sql."<br>";
		//exit;
		$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
		
				
		if($resultado==TRUE)
		{
			$variable="";
		
			//Envia todos los datos que vienen con GET
			
			unset($_POST["action"]);
			reset ($_POST);
			while (list ($clave, $val) = each ($_POST)) {
				
				if($clave!="programa" && $clave!="proceso")
				{
					$variable.="&".$clave."=".$val;
					//echo $clave;
				}
				
			}
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('director_analista').$variable."')</script>";   
			
			
		
		}
	
	}
}	


?>
