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
?><?PHP  
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
?><?PHP  
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
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

		$concatenar=0;
		reset ($_POST);
		$proceso=0;
		$programa=0;
		
		if(isset($_POST["subsistema"]))
		{
			$subsistema=$_POST["subsistema"];
			if($subsistema==3)
			{
				if(isset($_POST["programa"]))
				{
					if($_POST["programa"]>0)
					{
						$programa=$_POST["programa"];					
					}
					else
					{
						$el_error=TRUE;
					
					}				
				
				}
				else
				{
					$el_error=TRUE;				
				}
			
			}
		
		}
		else
		{
			$el_error=TRUE;
		
		}
		
		if(!isset($el_error))
		{
			$cadena_sql="DELETE FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."usuario_subsistema ";
			$cadena_sql.=" WHERE ";
			$cadena_sql.="id_usuario=".desenlace($_POST["registro"]);
			$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
			
			$cadena_sql="DELETE FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."usuario_programa ";
			$cadena_sql.=" WHERE ";
			$cadena_sql.="id_usuario=".desenlace($_POST["registro"]);
			$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
			
			$cadena_sql="DELETE FROM ".$configuracion["prefijo"]."usuario WHERE id_usuario=".desenlace($_POST["registro"])."";
			$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
			
			$cadena_sql="INSERT INTO ";
			$cadena_sql.="".$configuracion["prefijo"]."usuario_subsistema ";
			$cadena_sql.=" ( ";
			$cadena_sql.="`id_usuario` ,";
			$cadena_sql.=" `id_subsistema` ";
			$cadena_sql.=")"; 
			$cadena_sql.="VALUES ";
			$cadena_sql.="(";
			$cadena_sql.=desenlace($_POST["registro"]).",";
			$cadena_sql.=$subsistema;
			$cadena_sql.=")";
			$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
			//echo $cadena_sql."<br>";
			//exit;
			
			
			if($subsistema==3)
			{
				$cadena_sql="INSERT INTO ";
				$cadena_sql.="".$configuracion["prefijo"]."usuario_programa ";
				$cadena_sql.=" ( ";
				$cadena_sql.="`id_usuario` ,";
				$cadena_sql.=" `id_programa` ";
				$cadena_sql.=")"; 
				$cadena_sql.="VALUES ";
				$cadena_sql.="(";
				$cadena_sql.=desenlace($_POST["registro"]).",";
				$cadena_sql.=$programa;
				$cadena_sql.=")";
				$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
				
			}
			
			$cadena_sql="SELECT usuario,clave,tipo,id_usuario FROM ".$configuracion["prefijo"]."registrado WHERE id_usuario=".desenlace($_POST["registro"]);
			
			$base->registro_db($cadena_sql,0);
			$registro_usuario=$base->obtener_registro_db();
			
			$cadena_sql="UPDATE ".$configuracion["prefijo"]."registrado SET estado=1 WHERE id_usuario=".desenlace($_POST["registro"]);
			$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
			
			$cadena_sql="INSERT INTO ";
			$cadena_sql.=$configuracion["prefijo"]."usuario ";
			$cadena_sql.="( ";
			$cadena_sql.="id_usuario,";
			$cadena_sql.="nombre,";
			$cadena_sql.="clave,";
			$cadena_sql.="tipo";
			$cadena_sql.=") ";
			$cadena_sql.="VALUES (".$registro_usuario[0][3].",'".$registro_usuario[0][0] ."','".$registro_usuario[0][1]."',".$registro_usuario[0][2].")";
			//echo $cadena_sql;
			//exit;
			
			$resultado=$base->ejecutar_acceso_db($cadena_sql,0);
			
		}
				
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
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace('admin_usuario').$variable."')</script>";   
			
			
		
		
	
	}
}	


?>
