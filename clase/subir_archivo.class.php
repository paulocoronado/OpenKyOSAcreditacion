<?php
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/

/****************************************************************************
  
institucional.inc.php 

Paulo Cesar Coronado
Universidad Distrital Francisco Jose de Caldas
Universidad de los Llanos
Copyright (C) 2001-2006

Última revisión 6 de Marzo de 2006

******************************************************************************
* @subpackage   
* @package	clase
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Clase para gestionar la carga de archivos al servidor
* @usage
*******************************************************************************/
// 
class subir_archivo{
	
	var $tipo_archivo;
	var $tamanno_maximo;
	var $directorio_carga;
	var $remotebasepath;
	var $especial;
	var $nombre_campo;
	var $tipos_permitidos;
	var $maxfiles;
	var $unico;
	var $permisos;
	
	function subir_archivo()
	{
	
		$this->especial = "[[:space:]]|[\"\*\\\'\%\$\&\@\<\>]";
		$this->tamanno_maximo = 20*1000*1000;
		$this->unico = FALSE;
		
		$this->semilla = 1;
		
		@set_time_limit (0);
		
	}
		
		
	function cargar()
	{
		
		global $_FILES,$HTTP_POST_FILES;
		
		$indice=0;
		// 1. Obtener todos los datos del archivo
		
		if($this->nombre_campo == "")
		{
			$this->log["resultado"][$indice] = "ERROR";
			$this->log["explicacion"][$indice++] = "Nombre de archivo erroneo.";
		}
		
		// Verificar la ruta del directorio de carga
		
		if($this->directorio_carga != "" AND !is_dir($this->directorio_carga))
		{
			$this->log["resultado"][$indice] = "ERROR";
			$this->log["explicacion"][$indice++] = "Imposible determinar el directorio de carga.";
		}
		
		$archivo = $_FILES;
		
		$this->nombre_archivo	= $archivo[$this->nombre_campo]["name"];
		$this->tipo_MIME	= $archivo[$this->nombre_campo]["type"];
		$this->tammano		= $archivo[$this->nombre_campo]["size"];
		$this->nombre_temporal	= $archivo[$this->nombre_campo]["tmp_name"];
		$this->error		= $archivo[$this->nombre_campo]["error"];
			
		if($this->tammano<=0)
		{
			$this->log["resultado"][$indice] = "ERROR";
			$this->log["explicacion"][$indice++] = "Tama&ntilde;o de archivo no aceptado.";
		} 
		elseif($this->tammano>$this->tamanno_maximo) 
		{
			echo $this->tammano."<br>";
			echo $this->tamanno_maximo;
			$this->log["resultado"][$indice] = "ERROR";
			$this->log["explicacion"][$indice++] = "Tama&ntilde;o de archivo demasiado grande.";

		} 
		else
		{
			$this->primer_paso($indice);
		}
	
		
	}
		
		
function primer_paso($indice)
{
	
	if(!is_uploaded_file($this->nombre_temporal))
	{
		return FALSE;
	}
	$this->resolver_bug($this->nombre_campo,$indice);
	$this->revisar_nombre($this->nombre_archivo,$indice);
	$this->nombre_archivo = $this->revisar_caracteres($this->nombre_archivo,$indice);
	$this->tipo_archivo = $this->obtener_tipo($this->nombre_archivo,$indice);
	$this->revisar_tipo($this->tipo_archivo,$indice);
			
	if(isset($this->log))
	{			
		while (list($key, $val) = each($this->log["resultado"]) )
		{
			if($val == "ERROR")
			{
				return FALSE;
			}
		}
		
		
		
	}			
			
			// Nuevo
			if($this->unico === TRUE)
			{
				$this->mi_archivo = $this->nuevo_nombre();
			} 
			else 
			{
				$this->mi_archivo = $this->nombre_archivo;
			}
			
			
			// Copiar el archivo
			if(file_exists($this->directorio_carga . $this->mi_archivo))
			{
				$this->log["resultado"][$indice] = "ERROR";
				$this->log["explicacion"][$indice++] = "El archivo ya existe en el servidor.";

			}
			elseif (move_uploaded_file($this->nombre_temporal, $this->directorio_carga . $this->mi_archivo)) 
			{
				if($this->permisos != "")
				{
					chmod($this->directorio_carga . $this->mi_archivo,$this->permisos);
				}
			
				$this->log["resultado"][$indice] = "OK";
				$this->log["mi_archivo"][$indice++] = $this->mi_archivo;
				$this->log["nombre_archivo"][$indice++] = $this->nombre_archivo;
			} 
			else 
			{
				$this->log["resultado"][$indice] = "ERROR";
				$this->log["explicacion"][$indice++] = "No se puede cargar el archivo en el servidor.";
			}
			
			
		}
		
		function nuevo_nombre()
		{
			
			$tiempo = date("hms");
			mt_srand($tiempo);
			
			$url = mt_rand().$this->semilla.".".$this->tipo_archivo;
			while(file_exists($this->directorio_carga.$url))
			{
				$this->semilla++;
				$tiempo = date("hms");
				mt_srand($tiempo);
				$url = mt_rand().$this->semilla.".".$this->tipo_archivo;
			}
			return $url;
		}
		
		
		function resolver_bug($nombre_campo,$indice)
		{

			global $HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_GET_VARS;

			if(isset($HTTP_COOKIE_VARS[$nombre_campo]) 
			    || isset($HTTP_POST_VARS  [$nombre_campo]) 
			    || isset($HTTP_GET_VARS   [$nombre_campo]) 
			   )
			{
				$this->log["resultado"][$indice] = "ERROR";
				$this->log["explicacion"][$indice++] = "Problemas de seguridad al cargar el archivo.";
				
			}

		}
		
		
		function revisar_nombre($mi_archivo,$indice)
		{
			
			if($mi_archivo == "")
			{
				$this->log["resultado"][$indice] = "ERROR";
				$this->log["explicacion"][$indice++] = "Nombre de Archivo no aceptado.";
			} 
			elseif(ereg("\.+.+\.+",$mi_archivo))
			{
				$this->log["resultado"][$indice] = "ERROR";
				$this->log["explicacion"][$indice++] = "Nombre de Archivo no aceptado.";
			} 
			else 
			{
				return TRUE;
			}
		}
		
		
		function revisar_caracteres($mi_archivo,$indice)
		{
			
			if($this->especial != "")
			{
				$nuevo_archivo = eregi_replace($this->especial,"",$mi_archivo);
			} 
			else 
			{
				$nuevo_archivo = $mi_archivo;
			}
			$nuevo_archivo = strtolower($nuevo_archivo);
			return $nuevo_archivo;
		}
		
		
		function obtener_tipo($nombre_archivo,$indice)
		{
			
			$fileinfo = @pathinfo($nombre_archivo);
			
			if(is_array($fileinfo) AND ($fileinfo["extension"] != ""))
			{
				return $fileinfo["extension"];
			}
			else
			{
				$this->log["resultado"][$indice] = "ERROR";
				$this->log["explicacion"][$indice++] = "Extensi&oacute;n de archivo no aceptada.";
			}
		}
		
		
		function revisar_tipo($tipo_archivo,$indice)
		{
			
			if(is_array($this->tipos_permitidos))
			{
				if(in_array($tipo_archivo,$this->tipos_permitidos))
				{

					return TRUE;
				} 
				else 
				{
					$this->log["resultado"][$indice] = "ERROR";
					$this->log["explicacion"][$indice++] = "Extensi&oacute;n de archivo no aceptada.";
				}
			}
		}
		
		function eliminar_archivo($mi_archivo,$indice)
		{
			
			if(!unlink($this->directorio_carga.$mi_archivo))
			{
					return FALSE;
			} 
			else 
			{
					return TRUE;
			}
		}
		
		
		
	}

	

?>
