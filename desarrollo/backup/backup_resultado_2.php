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
	ini_set("memory_limit","64M");
	
$configuracion["clases"]="/clase";
$configuracion["grafico"]="/grafico";
$configuracion["bloques"]="/bloques";
$configuracion["arquitectura"]="/bloques/instalar/arquitectura";
$configuracion["configuracion"]="/configuracion";
$configuracion["javascript"]="/funcion";
$configuracion["estilo"]="/estilo";
$configuracion['titulo']="Sistema Integrado de Autoevaluaci&oacute;n Universitaria";
$configuracion["documento"] = '/documento';
$configuracion["prefijo"] = 'aplicativo_';
$configuracion["registros"] = '25'; //Cantidad de registros que se muestran en cada busqueda.
$configuracion["expiracion"]=3600*24;//Las sesiones pueden durar maximo un dia
$configuracion["dbsys"]= 'mysql';
$configuracion["db_dns"] = 'localhost';
$configuracion["db_nombre"] = 'autoevaluacion';
$configuracion["db_usuario"] = 'autoevaluacion';
$configuracion["db_clave"] = 'gardelmagaldy';
$configuracion["correo_admin"] = 'paulo_cesar@udistrital.edu.co';
$configuracion["host"] = 'http://autoevaluacion.udistrital.edu.co';
$configuracion["site"] = '/version2';
$configuracion["raiz_documento"] = '/var/www/html/htdocs/comunidad/dependencias/autoevaluacion'.$configuracion["site"];

	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	$total=0;
	//$numero=1;
	if (is_resource($enlace))
	{
		for($a=123;$a<183;$a++)
		{
			
			switch($a)
			{
				case 8:
				case 24:
				case 34:
				
				$id_proceso=1; 
				break;
				
				case 9:
				case 33:
				case 23:
				case 82:
				
				$id_proceso=2;
				break;
				
				case 10:
				case 29:
				case 19:
				
				$id_proceso=3; 
				break;
				
				case 11:
				case 30:
				case 20:
				
				$id_proceso=4; 
				break;
				
				case 12:
				case 31:
				case 21:
				
				$id_proceso=5; 
				break;
				
				case 13:
				case 32:
				case 22:
				
				$id_proceso=6; 
				break;
				
				case 35:
				case 25:
				
				$id_proceso=7; 
				break;
			
				case 3:
				case 26:
				case 77:
				
				$id_proceso=8; 
				break;
				
				case 42:
				case 41:
				case 40:
				
				$id_proceso=9;
				break;
				
				case 45:
				case 44:
				case 43:
				
				$id_proceso=10; 
				break;
				
				case 7:
				case 28:
				case 18:
				
				$id_proceso=11; 
				break;
				
				case 34:
				case 35:
				case 36:
				
				$id_proceso=12; 
				break;
				
				case 37:
				case 38:
				case 39:
				
				$id_proceso=13; 
				break;
				
				case 40:
				case 41:
				
				
				$id_proceso=14; 
				break;
				
				case 59:
				case 60:
				case 61:
				
				
				$id_proceso=15;
				break;
				
				case 62:
				case 63:
				case 64:
				
				$id_proceso=16; 
				break;
				
				case 65:
				case 66:
				case 67:
				
				$id_proceso=17; 
				break;
				
				case 68:
				case 69:
				case 70:
				
				$id_proceso=18; 
				break;
				
				case 71:
				case 72:
				case 73:
				
				$id_proceso=19; 
				break;
				
				case 74:
				case 75:
				case 76:
				
				$id_proceso=20; 
				break;
			
				case 78:
				case 80:
				case 81:
				
				$id_proceso=21; 
				break;
				
				case 85:
				case 84:
				case 83:
				case 146:
				
				$id_proceso=22;
				break;
				
				case 90:
				case 91:
				case 92:
				case 93:
				
				$id_proceso=23; 
				break;
				
				case 94:
				case 95:
				case 96:
				
				$id_proceso=24; 
				break;
				
				case 98:
				case 99:
				case 100:
				
				$id_proceso=25; 
				break;
				
				case 147:
				case 148:
				case 149:
				
				$id_proceso=26; 
				break;
				
				
				case 150:
				case 151:
				case 152:
				
				$id_proceso=27; 
				break;
				
				case 105:
				case 104:
				case 101:
				case 102:
				case 103:
				case 139:
				
				$id_proceso=28; 
				break;
				
				case 110:
				case 109:
				case 106:
				case 107:
				case 108:
				case 149:
				
				$id_proceso=29; 
				break;
				
				case 115:
				case 114:
				case 111:
				case 112:
				case 113:
				case 141:
				
				
				$id_proceso=30; 
				break;
				
				case 120:
				case 119:
				case 116:
				case 117:
				case 118:
				case 142:
				
				
				$id_proceso=31;
				break;
				
				case 121:
				case 122:
				case 123:
				case 124:
				case 125:
				case 143:
				
				$id_proceso=32; 
				break;
				
				case 126:
				case 127:
				case 128:
				case 129:
				case 130:
				case 144:
				
				$id_proceso=33; 
				break;
				
				case 131:
				case 132:
				case 133:
				case 134:
				case 145:
				
				$id_proceso=34; 
				break;
				
				case 182:
				case 138:
				case 135:
				case 136:
				case 137:
				
				$id_proceso=35; 
				break;
				
				case 151:
				case 153:
				case 155:
				case 156:
				
				$id_proceso=36; 
				break;
			
				case 157:
				case 158:
						
				$id_proceso=37; 
				break;
				
			}
			
			
			
			$cadena_sql="SELECT ";
			$cadena_sql.="count(`id_proceso`) ";
			$cadena_sql.="FROM ";
			$cadena_sql.="`siaud_resultado` ";
			$cadena_sql.="WHERE id_proceso=".$a;
			
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$conteo=$acceso_db->obtener_conteo_db();
			
			
			$total+=$registro[0][0];
			
			if($conteo>0 )
			{
					$cadena_sql="SELECT ";
					$cadena_sql.="`id_proceso` , ";
					$cadena_sql.="`encuestado` , ";
					$cadena_sql.="`id_instrumento` , ";
					$cadena_sql.="`id_pregunta` , ";
					$cadena_sql.="`id_instancia` , ";
					$cadena_sql.="`id_opcion` , ";
					$cadena_sql.="`valor`, ";
					$cadena_sql.="fecha ";
					$cadena_sql.="FROM ";
					$cadena_sql.="`siaud_resultado` ";
					$cadena_sql.="WHERE id_proceso=".$a;
					$acceso_db->registro_db($cadena_sql,0);
					$registro=$acceso_db->obtener_registro_db();
					$este_conteo=$acceso_db->obtener_conteo_db();
					if($este_conteo>0)
					{
						
						for($contador=0;$contador<$este_conteo;$contador++)
						{
							
							$cadena_insertar="INSERT INTO ";
							$cadena_insertar.="`aplicativo_resultado` ";
							$cadena_insertar.="(";
							$cadena_insertar.="`id_proceso` , ";
							$cadena_insertar.="`id_artefacto` , ";
							$cadena_insertar.="`encuestado` , ";
							$cadena_insertar.="`id_instrumento` , ";
							$cadena_insertar.="`id_pregunta` , ";
							$cadena_insertar.="`id_instancia` , ";
							$cadena_insertar.="`id_opcion` , ";
							$cadena_insertar.="`valor` , ";
							$cadena_insertar.="`fecha` ";
							$cadena_insertar.=")";
							$cadena_insertar.="VALUES ";
							$cadena_insertar.="(";
							$cadena_insertar.="'".$id_proceso."', ";
							$cadena_insertar.="'".$registro[$contador][0]."', ";
							$cadena_insertar.="'".$registro[$contador][1]."', ";
							$cadena_insertar.="'".$registro[$contador][2]."', ";
							$cadena_insertar.="'".$registro[$contador][3]."', ";
							$cadena_insertar.="'".$registro[$contador][4]."', ";
							$cadena_insertar.="'".$registro[$contador][5]."', ";
							$cadena_insertar.="'".$registro[$contador][6]."', ";
							$cadena_insertar.="'".$registro[$contador][7]."'";
							$cadena_insertar.=");";					
							
							$otra_configuracion["clases"]="/clase";
							$otra_configuracion["grafico"]="/grafico";
							$otra_configuracion["bloques"]="/bloques";
							$otra_configuracion["arquitectura"]="/bloques/instalar/arquitectura";
							$otra_configuracion["configuracion"]="/configuracion";
							$otra_configuracion["javascript"]="/funcion";
							$otra_configuracion["estilo"]="/estilo";
							$otra_configuracion['titulo']="Sistema Integrado de Autoevaluaci&oacute;n Universitaria";
							$otra_configuracion["documento"] = '/documento';
							$otra_configuracion["prefijo"] = 'aplicativo_';
							$otra_configuracion["registros"] = '25'; //Cantidad de registros que se muestran en cada busqueda.
							$otra_configuracion["expiracion"]=3600*24;//Las sesiones pueden durar maximo un dia
							$otra_configuracion["dbsys"]= 'mysql';
							$otra_configuracion["db_dns"] = 'localhost';
							$otra_configuracion["db_nombre"] = 'comiteacred';
							$otra_configuracion["db_usuario"] = 'comiteacred';
							$otra_configuracion["db_clave"] = 'gardel';
							$otra_configuracion["correo_admin"] = 'paulo_cesar@udistrital.edu.co';
							$otra_configuracion["host"] = 'http://autoevaluacion.udistrital.edu.co';
							$otra_configuracion["site"] = '/version2';
							$otra_configuracion["raiz_documento"] = '/var/www/html/htdocs/comunidad/dependencias/autoevaluacion'.$otra_configuracion["site"];
							
							$acceso=new dbms($otra_configuracion);
							$enlace_2=$acceso->conectar_db();
							$total=0;
							//$numero=1;
							if (is_resource($enlace_2))
							{
								$resultado=$acceso->ejecutar_acceso_db($cadena_insertar);
								if($resultado==TRUE)
								{
									$cadena_sql="";
								}
							}
						}
						
					}
					
					unset($registro);
				
				
			}
			else
			{
				
			}
		}
		
		echo "Existe: ".$total;
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

		$fp=fopen($archivo,"w+");

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
erto.";

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