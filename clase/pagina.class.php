<?php
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
* @name          pagina.class.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 9 de marzo de 2007
****************************************************************************
* @subpackage   
* @package	clase
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Esta clase esta disennada para manejar la presentacion de las diferentes paginas usadas en la 
*               aplicacion. Se encarga de administrar los bloques constitutivos de las paginas
*
*****************************************************************************/

class pagina
{
	
	
	//Metodo constructor
	function pagina($id_pagina,$configuracion)
	{
		//Declaracion de variable para controlar accesos indebidos
		$GLOBALS["autorizado"]=TRUE;
		
		if($id_pagina=="")
		{
			
			include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
			$cripto=new encriptar();
			
			if(isset($_REQUEST[$configuracion["enlace"]]))
			{		
				
				
				$cripto->decodificar_url($_REQUEST[$configuracion["enlace"]],$configuracion);
				if(isset($_REQUEST["pagina"]))
				{
					$this->especificar_pagina($_REQUEST["pagina"]);	
				}
				else
				{
					$this->especificar_pagina("");	
				}	
				
			}
			else
			{
				if(isset($_REQUEST["redireccion"]))
				{
					$variable="";		
					reset ($_REQUEST);
					while (list ($clave, $val) = each ($_REQUEST)) 
					{
						if($clave !="redireccion")
						{
							$variable.="&".$clave."=".$val;
						}
					}
					
					$cripto->decodificar_url($_REQUEST["redireccion"],$configuracion);
					
					while (list ($clave, $val) = each ($_REQUEST)) 
					{
							$variable.="&".$clave."=".$val;
					}
					
					$variable=$cripto->codificar_url($variable,$configuracion);
					$indice=$configuracion["host"].$configuracion["site"]."/index.php?";
					echo "<script>location.replace('".$indice.$variable."')</script>";
					
				}
				else
				{
					//Variables de Formulario POST codificadas.
					if(isset($_REQUEST["formulario"]))
					{
						$variable="";		
						reset ($_REQUEST);
						while (list ($clave, $val) = each ($_REQUEST)) 
						{
							if($clave !="formulario")
							{
								$formulario[$clave]=$val;
							}
						}
						
						$cripto->decodificar_url($_REQUEST["formulario"],$configuracion);
						
						while (list ($clave, $val) = each ($formulario)) 
						{
								$_REQUEST[$clave]=$val;
						}
						
						
					}
					
					$pagina_nivel=0;			
					$this->especificar_pagina("index");
				}
			
			}
			
			//Transicion
			//Se realiza la autenticacion de entrada en este punto
			include_once($configuracion["raiz_documento"].$configuracion["clases"]."/autenticacion.class.php");
			autenticacion::autenticacion($this->id_pagina,$configuracion);
		}
		else
		{
			$this->especificar_pagina($id_pagina);
		
		}		
		
		if(!isset($_POST['registro_compuesta']))
		{
			if(!isset($_POST['action']) && !isset($_GET['action']))
			{
				
				//29/08/2005 se inserta el manejo de pagina con el metodo post
				$this->mostrar_pagina($configuracion);
			}
			else
			{
				//echo 'Procesamiento de la pagina';
				$this->procesar_pagina($configuracion);
			}
		}
		else
		{
			$this->mostrar_pagina($configuracion);		
		}
	}
	//Fin del metodo constructor
	
	//Metodo especificar_pagina
	function especificar_pagina($id_pagina)
	{
	
		$this->id_pagina=$id_pagina;
	
	}
	//Fin del metodo especificar_pagina
	
		
	//Metodo mostrar_pagina
	function mostrar_pagina($configuracion)
	{
	
		if ($this->id_pagina=='instalar')
		{
			//La pagina de instalacion es la unica que tiene una estructura autocontenida			
			//Aun no hay acceso a la base de datos por tanto se incluye la pagina de instalacion
			$this->raiz="./";
			include_once($this->raiz.$configuracion["bloques"]."/instalar/index.php");
		}
		else
		{
			//Verificar si la pagina tiene una estructura valida - todas las paginas deben tener al menos un bloque
			$this->cadena_sql="SELECT  ";
			$this->cadena_sql.=$configuracion["prefijo"]."bloque_pagina.*,";
			$this->cadena_sql.=$configuracion["prefijo"]."bloque.nombre ";
			$this->cadena_sql.="FROM ";
			$this->cadena_sql.=$configuracion["prefijo"]."pagina, ";
			$this->cadena_sql.=$configuracion["prefijo"]."bloque_pagina, ";
			$this->cadena_sql.=$configuracion["prefijo"]."bloque ";
			$this->cadena_sql.="WHERE ";
			$this->cadena_sql.=$configuracion["prefijo"]."pagina.nombre='".$this->id_pagina."' ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.=$configuracion["prefijo"]."bloque_pagina.id_bloque=".$configuracion["prefijo"]."bloque.id_bloque ";
			$this->cadena_sql.="AND ";
			$this->cadena_sql.=$configuracion["prefijo"]."bloque_pagina.id_pagina=".$configuracion["prefijo"]."pagina.id_pagina";
			$this->base=new dbms($configuracion);
			
			
			$this->base->registro_db($this->cadena_sql,0);
			$this->registro=$this->base->obtener_registro_db();
			$this->total=$this->base->obtener_conteo_db();
			//echo 'El numero total de registros es: '.$this->total.'<br>';
			//echo $this->cadena_sql;
			
			if($this->total<1)
			{
				//TODO Mensaje de error porque la pagina no tiene estructura basica		
				echo "La pagina que esta intentando acceder no esta disponible.<BR>";
				echo $this->cadena_sql.'<br>';
				exit;
			}
			else
			{
				
				$nueva_sesion=new sesiones($configuracion);
				$esta_sesion=$nueva_sesion->numero_sesion();
				$this->registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
				if($this->registro)
				{
					$this->id_usuario=$this->registro[0][0];
				}
				else
				{
					$this->id_usuario=0;
				}
				
				
				//Rescatar el estilo
				$this->SQL='SELECT  usuario,estilo';
				$this->SQL.=' FROM '.$configuracion["prefijo"].'estilo';
				$this->SQL.=' WHERE usuario="'.$this->id_usuario.'"';
				//echo $this->SQL;
				$this->base->registro_db($this->SQL,0);
				$this->registro_estilo=$this->base->obtener_registro_db();
				$this->total_estilo=$this->base->obtener_conteo_db();
				//echo 'El numero total de registros es: '.$this->total_estilo.'<br>';
				
				if($this->total_estilo<1)
				{
					//Se usa el estilo por defecto
					$this->estilo='basico';
				}
				else
				{
					$this->estilo=$this->registro_estilo[0][1];
				}
				
				$this->tamanno=$configuracion["tamanno_gui"];
				$GLOBALS["fila"]=0;
				$GLOBALS["tab"]=1;
				
				//$this->html_pagina.="<html>\n";
				$this->html_pagina.='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">';
				$this->html_pagina.="\n<head>\n";
				$this->html_pagina.="<title>".$configuracion['titulo']."</title>\n";
				$this->html_pagina.="<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />\n";
				$this->html_pagina.="<link rel='stylesheet' type='text/css' href='".$configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/".$this->estilo."/estilo.php'/>\n";
				$this->html_pagina.="<link rel='shortcut icon' href='".$configuracion["host"].$configuracion["site"]."/favicon.png'>";
				$this->html_pagina.="<script src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/funciones.js' type='text/javascript' language='javascript'></script>";
				$this->html_pagina.="<script type='text/javascript' src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/textarea.js"."'></script>";
				$this->html_pagina.="</head>\n";
				$this->html_pagina.="<body class='fondoprincipal'>\n";
				
				if($this->id_pagina=='index' || $this->id_pagina=='registro_exito'||$this->id_pagina=='logout_exito'||$this->id_pagina=='index_no_usuario')
				{
					$this->html_pagina.="<table width='".$this->tamanno."' align='center' cellspacing='0' border='0' cellpadding='0'>\n";
				}
				else
				{
					$this->html_pagina.="<table width='".$this->tamanno."' align='center' cellspacing='0' border='0' cellpadding='0px' class='tabla_principal'>\n";
				}
				$this->html_pagina.="<tbody>\n";
				
				$this->html_pagina.="<tr>\n";
				echo $this->html_pagina;
				$this->html_pagina="";
				$secciones=$this->ancho_seccion($this->cadena_sql,$configuracion);
				$this->armar_seccion('A',$this->cadena_sql,$configuracion,$GLOBALS["fila"],$GLOBALS["tab"],$secciones);
				$this->html_pagina.="</tr>\n";
				echo $this->html_pagina;
				
				$this->html_pagina="<tr>\n";
				echo $this->html_pagina;
				$this->armar_seccion('B',$this->cadena_sql,$configuracion,$GLOBALS["fila"],$GLOBALS["tab"],$secciones);
				$this->armar_seccion('C',$this->cadena_sql,$configuracion,$GLOBALS["fila"],$GLOBALS["tab"],$secciones);
				$this->armar_seccion('D',$this->cadena_sql,$configuracion,$GLOBALS["fila"],$GLOBALS["tab"],$secciones);
				$this->html_pagina="</tr>\n";
				echo $this->html_pagina;
				
				$this->html_pagina="<tr>\n";
				echo $this->html_pagina;
				$this->armar_seccion('E',$this->cadena_sql,$configuracion,$GLOBALS["fila"],$GLOBALS["tab"],$secciones);
				$this->html_pagina="</tr>\n";
				$this->html_pagina.="</tbody>\n";
				$this->html_pagina.="</table>\n";
				echo $this->html_pagina;
				
				$this->html_pagina="<script language='JavaScript' type='text/javascript' src='".$configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/tooltip.js'></script>";
				$this->html_pagina.="</body>\n";
				$this->html_pagina.="</html>\n";
				echo $this->html_pagina;
				
				
				
			}
			
			
			
		}
		
		
	
	}
	//Fin del metodo mostrar_pagina
	
	//Metodo procesar_pagina
	function procesar_pagina($configuracion)
	{
		//echo $this->id_pagina;
		//echo $_POST['action'];
		//En el action del formulario viene el nombre del bloque que contiene el procesador del formulario
		if(isset($_POST['action']))
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/".$_POST['action']."/bloque.php");
		}
		else
		{
			if(isset($_GET['action']))
			{
				//echo $this->incluir;
				include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/".$_GET['action']."/bloque.php");			
			}	
		}
	}
	//Fin del metodo procesar_pagina
	
	function ancho_seccion($cadena,$configuracion)
	{
		$secciones=array("B","C","D");
		
		$la_seccion=array();
		foreach ($secciones as $key => $value) 
		{
			$this->la_cadena=$cadena." ";
			$this->la_cadena.="AND ";
			$this->la_cadena.=$configuracion["prefijo"]."bloque_pagina.seccion='".$value."' ";
			$this->la_cadena.="LIMIT 1 ";
			//echo $this->la_cadena;
			$this->base->registro_db($this->la_cadena,0);
			$this->armar_registro=$this->base->obtener_registro_db();
			$this->total=$this->base->obtener_conteo_db();
			if($this->total>0)
			{
				$la_seccion[$value]=1;
			
			}
		}
		return $la_seccion;
	}
	//Metodo armar_seccion
	function armar_seccion($seccion,$cadena,$configuracion,$fila,$tab,$secciones)
	{
		$this->la_cadena=$cadena." ";
		$this->la_cadena.="AND ";
		$this->la_cadena.=$configuracion["prefijo"]."bloque_pagina.seccion='".$seccion."' ";
		$this->la_cadena.="ORDER BY ";
		$this->la_cadena.=$configuracion["prefijo"]."bloque_pagina.posicion ASC";
		//echo $this->la_cadena;
		$this->base->registro_db($this->la_cadena,0);
		$this->armar_registro=$this->base->obtener_registro_db();
		$this->total=$this->base->obtener_conteo_db();
		if($this->total>0)
		{
			if($seccion=='B'||$seccion=='D')
			{
				if(!isset($secciones["C"]))
				{
					echo "<td valign='top' class='seccion_colapsada'>\n";				
				}
				else
				{
					echo "<td valign='top' class='seccion_".$seccion."'>\n";	
				}
				
			}
			else
			{
				if($seccion=='C')
				{
					if(!isset($secciones["B"])||!isset($secciones["D"]))
					{
						echo "<td valign='top' class='seccion_C_colapsada'>\n";				
					}
					else
					{
						echo "<td valign='top' class='seccion_".$seccion."'>\n";	
					}
				}
				else
				{
					echo "<td colspan='3' valign='top' width='100%'>\n";
				}	
				
			
			}
			
			echo "<table width='100%' cellpadding='0' cellspacing='4' border='0'>\n";
			
			for($this->contador=0;$this->contador<$this->total;$this->contador++)
			{
				echo "<tr>\n";
				echo "<td>\n";	
				$this->id_bloque=$this->armar_registro[$this->contador][0];
				$this->incluir=$this->armar_registro[$this->contador][4];
				include($configuracion["raiz_documento"].$configuracion["bloques"]."/".$this->incluir."/bloque.php");
				echo "</td>\n";
				echo "</tr>\n";
				
			}
			
			echo "</table>\n";			
			echo "</td>\n";		
		}
		$GLOBALS["fila"]=$fila;
		$GLOBALS["tab"]=$tab;
		return TRUE;	
		
	}
	//Fin del metodo armar_seccion	
}



?>
