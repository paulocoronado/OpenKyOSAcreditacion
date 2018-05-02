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
?><?PHP  
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	//Cargar el informe en el servidor
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/subir_archivo.class.php");
	
	$subir = new subir_archivo();
		
	$subir->directorio_carga= $configuracion['raiz_documento']."/documento/";
	
	if(isset($_POST['id_informe']))
	{
		$subir->eliminar_archivo($_POST["nombre_interno"]);
		$cadena_sql="DELETE ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."informe ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_informe=".$_POST['id_informe'];
		$acceso_db->ejecutar_acceso_db($cadena_sql);
		$id_informe=$_POST['id_informe'];		
		
		
		
	}
	else
	{
		$id_informe='NULL';
	}
	
	$subir->nombre_campo="archivo";
	$subir->tipos_permitidos= array("pdf","txt","jpg","doc","xls");
		
	// Maximo tamanno permitido
	//$subir->tamanno_maximo=5000000;
		
	$subir->especial= "[[:space:]]|[\"\*\\\'\%\$\&\@\<\>]";
			
	$subir->unico=TRUE;
	$subir->permisos=0777;
	$subir->cargar();
	if($subir->log["resultado"][0]=="ERROR")
	{
		echo "Imposible cargar el archivo en estos momentos.";
		exit;
	}
	
	$cadena_sql="INSERT INTO aplicativo_informe "; 
	$cadena_sql.="( ";
	$cadena_sql.="`id_informe`, ";
	$cadena_sql.="`id_subsistema`, ";
	$cadena_sql.="`id_programa`, ";
	$cadena_sql.="`codigo_componente`, ";
	$cadena_sql.="`nombre`, ";
	$cadena_sql.="`nombre_interno`, ";
	$cadena_sql.="`observacion` ";
	$cadena_sql.=") ";
	$cadena_sql.="VALUES ";
	$cadena_sql.="( ";
	$cadena_sql.=$id_informe.", ";
	$cadena_sql.="'".$_POST['id_subsistema']."', ";
	$cadena_sql.="'".$_POST['id_programa']."', ";
	$cadena_sql.="'".$_POST['codigo_componente']."', ";
	$cadena_sql.="'".$_POST['nombre']."', ";
	$cadena_sql.="'".$subir->log["mi_archivo"][0]."', ";
	$cadena_sql.="'".$_POST['observacion']."' ";
	$cadena_sql.=")";
	
	@$resultado=$acceso_db->ejecutar_acceso_db($cadena_sql);	
	
	if($resultado==FALSE)
	{
		/*TODO Mensaje de error*/
		echo "El sistema est&aacute; fuera de servicio en estos momentos. Por favor reintentelo dentro de algunos minutos.";
		exit;
	}
	else
	{	
		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
		$pagina="informe_indicador";
		echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina)."&accion=1&hoja=0&indicador=".$_POST['codigo_componente']."')</script>";   
	}

}

		
?>
