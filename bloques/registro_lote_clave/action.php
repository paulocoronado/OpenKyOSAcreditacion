<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 29 de Marzo de 2007

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario para el registro de un archivo de bloques
* @usage        
*******************************************************************************/ 
?><?php
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	//Cargar el informe en el servidor
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/subir_archivo.class.php");
	
	$subir = new subir_archivo();
		
	$subir->directorio_carga= $configuracion['raiz_documento']."/documento/";
	
	
	$subir->nombre_campo="archivo";
	$subir->tipos_permitidos= array("xls");
		
	// Maximo tamanno permitido
	//$subir->tamanno_maximo=5000000;
		
	$subir->especial= "[[:space:]]|[\"\*\\\'\%\$\&\@\<\>]";
			
	$subir->unico=TRUE;
	$subir->permisos=0777;
	$error_carga=$subir->cargar();
	
	$matriz=$subir->log["resultado"];
	
	if(isset($subir->log["resultado"]))
	{
		
		while (list($key, $val) = each($matriz) )
		{
			if($val == "ERROR")
			{
				echo "Imposible cargar el archivo en estos momentos.";
				$error_carga=TRUE;		
			}
		}
	}
	if($error_carga==FALSE)
	{
		
		$nombre_archivo=$subir->log["mi_archivo"][0];
		
		require_once ($configuracion["raiz_documento"].$configuracion["clases"]."/reader.php");
		
		
		// ExcelFile($filename, $encoding);
		$data = new Spreadsheet_Excel_Reader();
		
		
		// Set output Encoding.
		$data->setOutputEncoding('CP1251');
		
		/***
		* if you want you can change 'iconv' to mb_convert_encoding:
		* $data->setUTFEncoder('mb');
		*
		**/
		
		/***
		* By default rows & cols indeces start with 1
		* For change initial index use:
		* $data->setRowColOffset(0);
		*
		**/
		
		
		
		/***
		*  Some function for formatting output.
		* $data->setDefaultFormat('%.2f');
		* setDefaultFormat - set format for columns with unknown formatting
		*
		* $data->setColumnFormat(4, '%.3f');
		* setColumnFormat - set format for column (apply only to number fields)
		*
		**/
		
		$data->read($configuracion['raiz_documento']."/documento/".$nombre_archivo);
		
		
		
		
		$filas=$data->sheets[0]['numRows'];
		$columnas=$data->sheets[0]['numCols'];
		echo "<h1>Procesados: ".$filas." registros.<br></h1>";
		
		if($columnas>3)
		{
			?><script>
				alert("existe un error");
			</script>
			<?php	
		}
		else
		{
		
		
		
		}
		
		
		/*
		$data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column
		
		$data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
		
		$data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
			if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
		$data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
		$data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
		$data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
		*/
		
		error_reporting(E_ALL ^ E_NOTICE);
		
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++)
		{
			$destinatario=$data->sheets[0]['cells'][$i][1];
			$clave=$data->sheets[0]['cells'][$i][2];
			enviar_correo($destinatario, $clave);
		
		}
	}
	else
	{
		echo "Error!!!";   
	}
	
	//print_r($data);
	//print_r($data->formatRecords);
	

}

function enviar_correo($destinatario,$clave)
{
	$encabezado="IMPORTANTE. Encuesta de Identidad";
	$cabecera='MIME-Version: 1.0' . "\r\n";
	$cabecera.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$cabecera.="From: planeac@udistrital.edu.co\n";
	$cabecera.="Cc: siaud@udistrital.edu.co\r\n";
	$mensaje.="<table>";
	$mensaje.="<tr align=center>";
	$mensaje.="<td>";
	$mensaje.="<b>UNIVERSIDAD DISTRITAL <br>Francisco Jos&eacute; de Caldas</b>";
	$mensaje.="</td>";
	$mensaje.="</tr>";
	$mensaje.="<tr align=center>";
	$mensaje.="<td>";
	$mensaje.="<b>Oficina Asesora de Planeaci&oacute;n y Control</b>\n";
	$mensaje.="</td>";
	$mensaje.="</tr>";
	$mensaje.="<tr align=center>";
	$mensaje.="<td>";
	$mensaje.="Programa de implementaci&oacute;n MECI y CALIDAD<br><hr>";
	$mensaje.="</td>";
	$mensaje.="</tr>";
	$mensaje.="<tr>";
	$mensaje.="<td align=center><br>";	
	$mensaje.="<b>ENCUESTA DE DECLARACI&Oacute;N DE IDENTIDAD<b>";
	$mensaje.="<br></td>";
	$mensaje.="</tr>";
	$mensaje.="<tr>";
	$mensaje.="<td align=justify>";
	$mensaje.="<p>Usted, como parte importante del desarrollo de la universidad, ha sido seleccionado entre las personas que m&aacute;s le pueden aportar al desarrollo del proceso de implementaci&oacute;n del Modelo de Control Interno MECI 1000/2005 y Sistema de Gesti&oacute;n de la Calidad NTCGP 1000/2004.</p><p>Por ello, agradezco su colaboraci&oacute;n para darnos a conocer su punto de vista sobre cinco (5) preguntas antes de la 3:00 pm del d&iacute;a mi&eacute;rcoles 31 de octubre de 2007.</p>";
	$mensaje.="<p>Para participar en la autoevaluacion:</p>";
	$mensaje.="<ol>";
	$mensaje.="<li>Desde un navegador web ir a la direccion:<br>";
	$mensaje.="<a href='http://autoevaluacion.udistrital.edu.co'>http://autoevaluacion.udistrital.edu.co</a>\n\n";
	$mensaje.="<li>En el campo correspondiente a nombre de usuario por favor digite:<br>";
	$mensaje.="meci";
	$mensaje.="<li>En el campo de clave digite:<br>";
	$mensaje.=$clave."<br>";
	$mensaje.="</ol>";
	$mensaje.="Nota: Esta clave, asi como el presente mensaje, han sido generados automaticamente con el fin de garantizarle transparencia en la recoleccion de los datos.\n\n";
	$mensaje.="Lea las instrucciones en cada pantalla y diligencie las diferentes preguntas que se le formulan.\n\n";
	$mensaje.="<p>Agradezco su valiosa colaboraci&oacute;n.</p>";
	$mensaje.="</td>";
	$mensaje.="</tr>";
	$mensaje.="<tr align=center>";
	$mensaje.="<td>";
	$mensaje.="<p><b>GERMAN EDUARDO ARENAS REINA</b><br>";
	$mensaje.="Representante de Direcci&oacute;n MECI  CALIDAD<br>";
	$mensaje.="Jefe Oficina Asesora de Planeaci&oacute;n y Control</p>";
	$mensaje.="</td>";
	$mensaje.="</tr>";
	$mensaje.="</table>";
	
	
	
	
	$resultado= mail($destinatario, $encabezado,$mensaje,$cabecera) ;
	echo "1 Mensaje enviado a:<br><b>".$destinatario."</b><br>El d&iacute;a ".date("d - m - Y")." a las ".date("H:i:s"). "horas.<hr>";

}

		
?>
