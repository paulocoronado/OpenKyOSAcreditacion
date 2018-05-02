<?php
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?php
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
?><?php


	include_once("../configuracion/config.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		//17 asuntos docentes
		//39 dir programa
		//15 comite
		//78 sistemas
		//86 biblioteca
		//93 IIOC
		//110 bienestar
		//117 Proyeccion
		//121 Planeacion
		//131 comite evaluacion
		$cadena_sql="SELECT id_pagina ";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."bloque_pagina` ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="`id_bloque`=18 ";
		$cadena_sql.="AND ";
		$cadena_sql.="`seccion=B ";
		$cadena_sql.="AND ";
		$cadena_sql.="`posicion=1 ";
		$cadena_sql.="GROUP BY id_pagina";
		echo $cadena_sql."<br>";
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$conteo=$acceso_db->obtener_conteo_db();
		if($conteo>0)
		{
			for($contador=0;$contador<$conteo;$contador++)
			{
				$cadena_sql="DELETE FROM `".$configuracion["prefijo"]."bloque_pagina` ";
				$cadena_sql.="WHERE id_bloque=18 ";
				$cadena_sql.="AND id_pagina='".$registro[$contador][0]."' ";
				echo $cadena_sql."<br>";
				$acceso_db->ejecutar_acceso_db($cadena_sql);
				
				
				$cadena_sql="INSERT INTO `".$configuracion["prefijo"]."bloque_pagina` ";
				$cadena_sql.="( `id_pagina` , `id_bloque` , `seccion` , `posicion` ) ";
				$cadena_sql.="VALUES (";
				$cadena_sql.="'".$registro[$contador][0]."', '180', 'B', '2'";
				$cadena_sql.=")";
				$acceso_db->ejecutar_acceso_db($cadena_sql);
				echo $cadena_sql."<br>";
				
				$cadena_sql="UPDATE `".$configuracion["prefijo"]."bloque_pagina` ";
				$cadena_sql.="SET `posicion` = '4' ";
				$cadena_sql.="WHERE `id_pagina` = '".$registro[$contador][0]."' AND `id_bloque` = '9' LIMIT 1";
				echo $cadena_sql."<br>";
				$acceso_db->ejecutar_acceso_db($cadena_sql);
				
				$cadena_sql="UPDATE `".$configuracion["prefijo"]."bloque_pagina` ";
				$cadena_sql.="SET `posicion` = '3' ";
				$cadena_sql.="WHERE `id_pagina` = '".$registro[$contador][0]."' AND `id_bloque` = '18' LIMIT 1 ";
				echo $cadena_sql."<br>";
				$acceso_db->ejecutar_acceso_db($cadena_sql);
			}
		
		}
	
	}
		


?>
