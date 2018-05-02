<?PHP  
/*
############################################################################
#                                                                          #
#    Desarrollo Por: Teleinformatics Technology Group                      #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@ttg.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?PHP  
/****************************************************************************************************************
* @name          formulario.class.php 
* @editor        Paulo Cesar Coronado
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
	ini_set("memory_limit","32M");
	
	include_once("../configuracion/config.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		for($a=0;$a<10;$a++)
		{
			
			$mi_nombre="../documento/".$a.".txt";
			echo "Procesando archivo: ".$mi_nombre."<br>";
			$estado="CERRADO";
			$mi_archivo=abrir_archivo($mi_nombre,$estado);
			
			if ($mi_archivo) 
			{
				while (!feof($mi_archivo)) 
				{
					$buffer = fgets($mi_archivo, 4096);
					$buffer=trim($buffer);
					$buffer=substr($buffer,0,strlen($buffer)-1);
					//echo $buffer."<br>";
					$resultado=$acceso_db->ejecutar_acceso_db($buffer);
					if($resultado==FALSE)
					{
						
						echo "Se obtuvo el error: ".$acceso_db->obtener_error()."<br>";
					
					}
					
				}
				
			}
			else
			{
			
				echo "No se ha podido abrir.<br>";
			}
			$mi_archivo=cerrar_archivo($estado,$mi_archivo);
		}
		
	}
	else
	{
		echo "esa no es la clave";
	}
	



function abrir_archivo($archivo,&$estado)

{

	if($estado!="CERRADO")

	{

		$error="Error : El archivo est&aacute; en uso";

		return false;

	}	

	 
	if(!empty($archivo))

	{

		@$fp=fopen($archivo,"r");

	}
	else

	{

		$error="Uso : new escritor( string nombre_archivo,[int tipo_archivo]')";

		return false;

	}	

	if($fp==false)

	{

		$error="Error: Imposible crear o abrir el archivo.";

		return false;

	}

	$estado="ABIERTO";

	return $fp;

}

function cerrar_archivo($estado,$fp)

{

	if($estado!="ABIERTO")

	{

		$error="Error : El archivo se encuentra cerrado..";

		return false;

	}	

	fclose($fp);

	$estado="CERRADO";

	return ;

}

function escribir_linea($linea,$fp,$estado)

{

	//echo $estado;
	if($estado!="ABIERTO")

	{

		$error="Error : No existe un archivo abierto.";

		return false;

	}	

	
	fwrite($fp,$linea);

	return TRUE;
	
}

function descargar($archivo)
{
	global $HTTP_ENV_VARS;
	if(isset($HTTP_ENV_VARS['HTTP_USER_AGENT']) and strpos($HTTP_ENV_VARS['HTTP_USER_AGENT'],'MSIE 5.5'))
	{

		Header('Content-Type: application/dummy');

	}	
	else
	{

		Header('Content-Type: application/octet-stream');

	}	
	if(headers_sent())
	{

		$Error('No se puede enviar datos');

	}
	Header('Content-Length: '.strlen($archivo));

	Header('Content-disposition: attachment; filename='.$archivo);


}
?>
ent())
	{

		$Error('No se puede enviar datos');

	}
	Header('Content-Length: '.strlen($archivo));

	Header('Content-disposition: attachment; filename='.$archivo);


}
?>
