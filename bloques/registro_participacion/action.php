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
?>
<?PHP  
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
* @description  Action de registro de informacion anual para profesores
* @usage        
*****************************************************************************************************************/
?><?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/mensaje.class.php");	
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/pagina.class.php");	
		
$this->acceso_db=new dbms($configuracion);
$this->enlace=$this->acceso_db->conectar_db();
if (is_resource($this->enlace))
{	
	if(isset($_POST['id_participacion']))
	{
		$this->cadena_sql='SELECT * FROM aplicativo_profesor_info_participacion WHERE id_participacion='.$_POST['id_participacion'];
		//echo $this->cadena_sql.'<br>';
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro=$this->acceso_db->obtener_registro_db();
		$this->campos=$this->acceso_db->obtener_conteo_db();
		if($this->campos>0)
		{
			//El anno ya esta registrado entonces se realiza un UPDATE
			$this->cadena_sql = "UPDATE `".$configuracion["prefijo"]."profesor_info_participacion` SET ";
			$this->cadena_sql.= "nombre='".$_POST['nombre']."',";
			$this->cadena_sql.= "id_tipo_participacion=".$_POST['id_tipo_participacion'];
			$this->cadena_sql.= " WHERE id_participacion=".$_POST['id_participacion'];
			echo $this->cadena_sql.'<br>';
			
		}
		else
		{
			$this->cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."profesor_info_participacion ";
			$this->cadena_sql.= "( `id_participacion` ,`identificacion` , `nombre` , `id_tipo_participacion`,`anno` ) ";					
			$this->cadena_sql.= "VALUES (";
			$this->cadena_sql.= "NULL, '".$_POST['identificacion']."','".$_POST['nombre']."',".$_POST['id_tipo_participacion'].",".$_POST['anno'];
			$this->cadena_sql.=")";
			echo $this->cadena_sql.'<br>';
		}
		//echo $this->cadena_sql."<br>";
		$this->db_sel = new dbms($configuracion);
		$this->db_sel->especificar_enlace($this->enlace);
		$this->resultado=$this->db_sel->ejecutar_acceso_db($this->cadena_sql); 	
		if($this->resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_profesor")."&registro=".$_POST['identificacion']."')</script>";   
			
	
		}
		else
		{
			//Instanciar a la clase pagina con mensaje de error
		}
	}
	else
	{	
		$this->cadena_sql='SELECT * FROM aplicativo_profesor_info_participacion WHERE nombre="'.$_POST['nombre'].'" AND anno='.$_POST['anno'];
		//echo $this->cadena_sql.'<br>';
		$this->acceso_db->registro_db($this->cadena_sql,0);
		$this->registro=$this->acceso_db->obtener_registro_db();
		$this->campos=$this->acceso_db->obtener_conteo_db();
		if($this->campos>0)
		{
			//El anno ya esta registrado entonces se realiza un UPDATE
			$this->cadena_sql = "UPDATE `".$configuracion["prefijo"]."profesor_info_participacion` SET ";
			$this->cadena_sql.= "nombre='".$_POST['nombre']."',";
			$this->cadena_sql.= "id_tipo_participacion=".$_POST['id_tipo_participacion'];
			$this->cadena_sql.= " WHERE id_participacion=".$_POST['id_participacion'];
			echo $this->cadena_sql.'<br>';
			
		}
		else
		{
			$this->cadena_sql = "INSERT INTO ".$configuracion["prefijo"]."profesor_info_participacion ";
			$this->cadena_sql.= "( `id_participacion` ,`identificacion` , `nombre` , `id_tipo_participacion`,`anno` ) ";					
			$this->cadena_sql.= "VALUES (";
			$this->cadena_sql.= "NULL, '".$_POST['identificacion']."','".$_POST['nombre']."',".$_POST['id_tipo_participacion'].",".$_POST['anno'];
			$this->cadena_sql.=")";
			echo $this->cadena_sql.'<br>';
		}
		//echo $this->cadena_sql."<br>";
		$this->db_sel = new dbms($configuracion);
		$this->db_sel->especificar_enlace($this->enlace);
		$this->resultado=$this->db_sel->ejecutar_acceso_db($this->cadena_sql); 	
		if($this->resultado==TRUE)
		{
			include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
			echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".enlace("editar_profesor")."&registro=".$_POST['identificacion']."')</script>";   
			
	
		}
		else
		{
			//Instanciar a la clase pagina con mensaje de error
		}
		
	}

} 
else
{
	echo "Error fatal al acceder a la base de datos.";
		
}



	
?>
