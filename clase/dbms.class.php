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

/****************************************************************************
* @name          dbms.class.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 11 de Mayo de 2007
******************************************************************************
* @subpackage   
* @package	clase
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://www.openkyos.com
* @description  Esta clase esta disennada para administrar todas las tareas relacionadas con la base de datos.
*
*******************************************************************************/


/******************************************************************************
*Atributos
*
*@access private
*@param  $servidor
*		URL del servidor de bases de datos. 
*@param  $db
*		Nombre de la base de datos
*@param  $usuario
*		Usuario de la base de datos
*@param  $clave
*		Clave de acceso al servidor de bases de datos
*@param  $enlace
*		Identificador del enlace a la base de datos
*@param  $dbms
*		Nombre del DBMS, por defecto se tiene MySQL
*@param  $cadena_sql
*		Clausula SQL a ejecutar
*@param  $error
*		Mensaje de error devuelto por el DBMS
*@param  $numero
*		Número de registros a devolver en una consulta
*@param  $conteo
*		Número de registros que existen en una consulta
*@param  $registro
*		Matriz para almacenar los resultados de una búsqueda
*@param  $campo
*		Número de campos que devuelve una consulta
*TO DO    	Implementar la funcionalidad en DBMS diferentes a MySQL		
**************************************************************************************
*/

/*************************************************************************************
*Métodos
*
*@access public
*
*@method db_admin
*		 Constructor. Define los valores por defecto 
*@method especificar_db
*		 Para especificar a través de código el nombre de la base de datos
*@method especificar_usuario
*		Para especificar a través de código el nombre del usuario de la base de datos
*@method especificar_clave
*		Para especificar a través de código la clave de acceso al servidor de bases de datos
*@method especificar_servidor
*		Para especificar a través de código la URL del servidor de DB
*@method especificar_dbms
*		Para especificar a través de código el nombre del DBMS
*@method especificar_enlace
*		Para especificar el recurso de enlace a la DBMS
*@method conectar_db
*		Conecta a un DBMS
*@method probar_conexion
*		Con la cual se realizan acciones que prueban la validez de la conexión
*@method desconectar_db
*		Libera la conexion al DBMS
*@method ejecutar_acceso_db
*		Ejecuta clausulas SQL de tipo INSERT, UPDATE, DELETE
*@method obtener_error
*		Devuelve el mensaje de error generado por el DBMS
*@method obtener_conteo_dbregistro_db
*		Devuelve el número de registros que tiene una consulta
*@method registro_db
*		Ejecuta clausulas SQL de tipo SELECT
*@method obtener_registro_db
*		Devuelve el resultado de una consulta como una matriz bidimensional
*@method obtener_error
*		Realiza una consulta SQL y la guarda en una matriz bidimensional
*
*****************************************************************************************
*/

class dbms
{
	/*** Atributos: ***/
	/**
	 * 
	 * @access private
	 */
	var $servidor;
	var $db;
	var $usuario;
	var $clave;
	var $enlace;
	var $dbsys;
	var $cadena_sql;
	var $error;
	var $numero;
	var $conteo;
	var $registro;
	var $campo;


	/*** Fin de sección Atributos: ***/

	/**
	 *@method especificar_db 
	 * @param string nombre_db 
	 * @return void
	 * @access public
	 */

	function especificar_db( $nombre_db )
	{
		$this->db = $nombre_db;
	} // Fin del método especificar_db

	/**
	 *@method especificar_usuario 
	 * @param string usuario_db 
	 * @return void
	 * @access public
	 */
	function especificar_usuario( $usuario_db )
	{
		$this->usuario = $usuario_db;
	} // Fin del método especificar_usuario


	/**
	 *@method especificar_clave 
	 * @param string nombre_db 
	 * @return void
	 * @access public
	 */
	function especificar_clave( $clave_db )
	{
		$this->clave = $clave_db;
	} // Fin del método especificar_clave

	/**
	 * 
	 *@method especificar_servidor
	 * @param string servidor_db 
	 * @return void
	 * @access public
	 */
	function especificar_servidor( $servidor_db )
	{
		$this->servidor = $servidor_db;
	} // Fin del método especificar_servidor

	/**
	 * 
	 *@method especificar_dbms
	 *@param string dbms
	 * @return void
	 * @access public
	 */
	
	function especificar_dbsys( $sistema )
	{
		$this->dbsys = $sistema;
	
	} // Fin del método especificar_dbsys

	/**
	 * 
	 *@method especificar_enlace
	 *@param resource enlace
	 * @return void
	 * @access public
	 */
	
	function especificar_enlace($enlace )
	{
		if(is_resource($enlace))
		{
			$this->enlace = $enlace;
		}
	} // Fin del método especificar_enlace

	
	/**
	 * 
	 *@method obtener_enlace
	 * @return void
	 * @access public
	 */
	
	function obtener_enlace()
	{
		return $this->enlace;
		
	} // Fin del método obtener_enlace
	
	
	/**
	 * 
	 * @method conectar_db
	 * @return void
	 * @access public
	 */
	function conectar_db()
	{
		switch($this->dbsys)
		{
			
			case 'mysql':
					
					$this->enlace=mysql_connect($this->servidor, $this->usuario, $this->clave);
					
					if($this->enlace)
					{
						$base=mysql_select_db($this->db);	
						if($base)
						{
							
							return $this->enlace;	
							
						}
						else
						{
							$this->error["numero"] =mysql_errno();
							$this->error["error"] =mysql_error();	
						}
						
									
					}
					else
					{
						$this->error["numero"] =mysql_errno();
						$this->error["error"] =mysql_error();
					}
					
		}
	} // Fin del método conectar_db

	/**
	 * 
	 * @method probar_conexion
	 * @return void
	 * @access public
	 */
	function probar_conexion()
	{
		
		if($this->enlace==TRUE)
		{
			return TRUE;
		
		}
		else
		{
			return FALSE;		
		}
		
		
	} // Fin del método probar_conexion
	
	function logger($configuracion,$id_usuario,$evento)
	{
		$this->cadena_sql = "INSERT INTO ";
	 	$this->cadena_sql.= "".$configuracion["prefijo"]."logger ";
	 	$this->cadena_sql.= "( ";
	 	$this->cadena_sql.= "`id_usuario` ,";
		$this->cadena_sql.= " `evento` , ";
		$this->cadena_sql.= "`fecha`  ";
		$this->cadena_sql.= ") ";
		$this->cadena_sql.= "VALUES (";
		$this->cadena_sql.= $id_usuario."," ;
		$this->cadena_sql.= "'".$evento."'," ;
		$this->cadena_sql.= "'".time()."'" ;
		$this->cadena_sql.=")";
		//echo $this->cadena_sql;
	 	$this->ejecutar_acceso_db($this->cadena_sql); 
		unset($this->db_sel);
		return TRUE;	
	
	}
	

	/**
	 * 
	 * @method desconectar_db
	 * @param resource enlace
	 * @return void
	 * @access public
	 */
	function desconectar_db()
	{
		mysql_close($this->enlace);
		
	} //Fin del método desconectar_db

	
	/**
	* @method ejecutar_acceso_db	 
	* @param string cadena_sql 
	* @param string conexion_id
	* @return boolean
	* @access public
	 */
	
	function ejecutar_acceso_db($cadena_sql) 
	{
		if(!mysql_query($cadena_sql,$this->enlace)) 
		{
			$this->error["numero"] =mysql_errno();
			$this->error["error"] =mysql_error();
			return FALSE;
		} 
		else 
		{
			return TRUE;
		}
	}

	/**
	* @method obtener_error	 
	* @param string cadena_sql 
	* @param string conexion_id
	* @return boolean
	* @access public
	 */
	
	function obtener_error(){
		
		return $this->error;
	
	}//Fin del método obtener_error

	/**
	* @method registro_db	 
	* @param string cadena_sql 
	* @param int numero
	* @return boolean
	* @access public
	 */
	function registro_db($cadena_sql,$numero) 
	{
		
		unset($this->registro);
		if(!is_resource($this->enlace))
		{
			return FALSE;
		}
		$busqueda=mysql_query($cadena_sql,$this->enlace);
		//echo '<strong>'.$cadena_sql.'</strong><br>';

		//Determinamos el número de campos retornados en la consulta
		
		if($busqueda)
		{
			
			$this->campo = mysql_num_fields($busqueda);
			$this->conteo = mysql_num_rows($busqueda);
			if($numero==0){
				
					$numero=$this->conteo;
					
				}	
		
		
			 for($j=0; $j<$numero; $j++)
			 {
				//echo $j.'<br>';
				$salida = mysql_fetch_array($busqueda);
				for($un_campo=0; $un_campo<$this->campo; $un_campo++)
				{
					
					$this->registro[$j][$un_campo] = $salida[$un_campo];
					//echo 'registro['.$j.']['.$un_campo.'] = '.$salida[$un_campo].'<br>';
				}
			}
			mysql_free_result($busqueda);
			return $this->conteo;
		}
		else
		{
				
				//echo '<strong>'.$cadena_sql.'</strong><br>';
				$this->error["numero"] =mysql_errno();
				$this->error["error"] =mysql_error();
				$this->conteo = 0;
				$this->registro=FALSE;
				return FALSE;
		}
		unset($busqueda);
	}// Fin del método registro_db
	
	
	/**
	* @method obtener_registro_db	 
	* @return registro []
	* @access public
	 */

	function obtener_registro_db() 
	{
		if(isset($this->registro))
		{
			return $this->registro;		
		}
		else
		{
			return FALSE;
		}
	}//Fin del método obtener_registro_db
	
	
	/**
	* @method obtener_conteo_db	 
	* @return int conteo
	* @access public
	 */
	function obtener_conteo_db() {
		return $this->conteo;
	
	}//Fin del método obtener_conteo_db

	function ultimo_insertado($enlace)
	{
		return mysql_insert_id($enlace);
	
	}

	/**
	* @method arquitectura_db
	* @return boolean resultado
	* @access public
	 */
	function arquitectura_db($archivo_arquitectura) {
	
		switch($this->dbsys){
			
			case 'mysql':
			
				/*crear arquitectura de datos en el servidor MySQL*/	
				/*Abrir el archivo correspondiente a la arquitectura de la base de datos*/
				$archivo=fopen($archivo_arquitectura, 'r');
				$tamanno=filesize($archivo_arquitectura);
				$archivo_sql = fread($archivo, $tamanno);
		
				$this->sql=new sql;
				$archivo_sql=$this->sql->remover_marcas($archivo_sql,$this->dbsys);

				$archivo_sql=$this->sql->rescatar_cadena_sql($archivo_sql,$this->dbsys);
				
				$this->instrucciones=count($archivo_sql);
				for($contador=0;$contador<$this->instrucciones;$contador++)
				{
					//echo $this->instrucciones." instrucciones<br><br>";
					//echo $archivo_sql[$contador].'<br><br>';
					$acceso=$this->ejecutar_acceso_db($archivo_sql[$contador]);
				
					if(!$acceso)
					{
						//echo $this->error;
						return FALSE;
						
						}
					
				}
				
				
				
				
				
					
					
					
				break;
					
		}
		return $archivo_sql;
	
	}//Fin del método arquitectura_db


/**
	* @method transaccion
	* @return boolean resultado
	* @access public
	 */
	function transaccion($insert,$delete) 
	{
	
				$this->instrucciones=count($insert);
				
				for($contador=0;$contador<$this->instrucciones;$contador++)
				{
					/*echo $insert[$contador];*/
					$acceso=$this->ejecutar_acceso_db($insert[$contador]);
				
					if(!$acceso)
					{
						
						for($contador_2=0;$contador_2<$this->instrucciones;$contador_2++)
						{
							@$acceso=$this->ejecutar_acceso_db($delete[$contador_2]);
							/*echo $delete[$contador_2]."<br>";*/
							}
						return FALSE;
					
						}
					
				}
		return TRUE;
	
	}//Fin del método transaccion


function vaciar_temporales($configuracion,$sesion)
{
			$this->esta_sesion=$sesion;
			$this->cadena_sql="DELETE FROM ".$configuracion["prefijo"]."compuesta_borrador WHERE id_sesion=\"".$this->esta_sesion."\"";
			$this->ejecutar_acceso_db($this->cadena_sql);
			$this->cadena_sql="DELETE FROM ".$configuracion["prefijo"]."i_borrador WHERE id_sesion=\"".$this->esta_sesion."\"";
			$this->ejecutar_acceso_db($this->cadena_sql);	
			$this->cadena_sql="DELETE FROM ".$configuracion["prefijo"]."multiple_borrador WHERE id_sesion=\"".$this->esta_sesion."\"";
			$this->ejecutar_acceso_db($this->cadena_sql);	
			$this->cadena_sql="DELETE FROM ".$configuracion["prefijo"]."p_borrador WHERE id_sesion=\"".$this->esta_sesion."\"";
			$this->ejecutar_acceso_db($this->cadena_sql);	
			$this->cadena_sql="DELETE FROM ".$configuracion["prefijo"]."pregunta_borrador WHERE id_sesion=\"".$this->esta_sesion."\"";
			$this->ejecutar_acceso_db($this->cadena_sql);	
			$this->cadena_sql="DELETE FROM ".$configuracion["prefijo"]."propiedad_borrador WHERE id_sesion=\"".$this->esta_sesion."\"";
			$this->ejecutar_acceso_db($this->cadena_sql);	
}


	/**
	 * @method db_admin
	 *	
	 */
	function dbms($configuracion)
	{
		
		
		if(isset($configuracion['db_dns'])){
		$this->servidor = $configuracion['db_dns'];
		//echo $this->servidor.'<br>';
		}
		if(isset($configuracion['db_nombre'])){
		$this->db = $configuracion['db_nombre'];
		//echo $this->db.'<br>';
		}
		if(isset($configuracion['db_usuario'])){
		$this->usuario = $configuracion['db_usuario'];
		//echo $this->usuario.'<br>';
		}
		if(isset($configuracion['db_clave'])){
		$this->clave = $configuracion['db_clave'];
		//echo $this->clave.'<br>';
		}
		if(isset($configuracion['dbsys'])){
		$this->dbsys = $configuracion['dbsys'];
		//echo $this->dbsys.'<br>';
		}
		
		//Para optimizar la utilizacion de esta clase se modifica para que automaticamente se conecte
		//a la base de datos.
		$this->enlace=$this->conectar_db();
		if (is_resource($this->enlace)){
			return TRUE;
		}
		return FALSE;
	}//Fin del método db_admin

	
}//Fin de la clase db_admin

?>
