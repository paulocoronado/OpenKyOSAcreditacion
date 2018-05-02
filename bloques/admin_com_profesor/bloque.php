<?php 
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
<?php 
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
?><?php 

//La variable $_GET['usuario'] contiene el npmbre del programa que esta editando la información...
// puede tomarse esa informacion desde la variable de sesion correspondiente TODO


if(!isset($this->id_pagina))
{
	$raiz="./../../../";
	@include_once($raiz."incluir/error_ilegal.php");
	
	exit;		
	}


?>
<script src="<?php  echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<?php 
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	if(isset($_GET['accion']))
	{
		//La variable accion esta presente si se tiene un filtro para los datos.
		switch($_GET['accion'])
		{	
			//Todos los profesores
			case '1':
				$cadena_sql="SELECT nombre, apellido, identificacion";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor ORDER BY apellido, nombre ";
				//echo $cadena_sql;
				break;
			
			//Filtrados por programa	
			case '2':
				$cadena_sql="SELECT nombre,apellido,identificacion,id_programa ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor "; 
				$cadena_sql.=" WHERE id_programa=".$_GET['programa']." ORDER BY nombre, identificacion ";
				//echo $cadena_sql;
				break;	
			
			//Filtrado
			case '3':
				
				if(isset($_GET['busqueda']))
				{
					$buscar=explode(" ",$_GET['busqueda']);
				}	
				
				$buscar_nombre='(';
				$buscar_apellido='';
				$buscar_identificacion='';
				
				while (list ($clave, $val) = each ($buscar)) {
					$buscar_nombre.="nombre like '%".$val."%' OR ";
					$buscar_apellido.="apellido like '%".$val."%' OR ";
					$buscar_identificacion.="identificacion like '%".$val."%' OR ";
				}
				
				$buscar_todo=$buscar_nombre.$buscar_apellido.substr($buscar_identificacion,0,(strlen($buscar_identificacion)-3)).")";
				//echo $buscar_todo;
				
				$cadena_sql="SELECT nombre,apellido,identificacion,id_programa ";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor "; 
				$cadena_sql.=" WHERE ".$buscar_todo." ORDER BY nombre, identificacion ";
				//echo $cadena_sql;
				break;	
				
						
			
			default:
				$cadena_sql="SELECT nombre, apellido, identificacion";
				$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor ORDER BY apellido, nombre ";
				//echo $cadena_sql;
				break;
					
			
		}
	}
	else
	{
	
		$cadena_sql="SELECT nombre, apellido, identificacion";
		$cadena_sql.=" FROM ".$configuracion["prefijo"]."profesor ORDER BY apellido, nombre ";
		//echo $cadena_sql;
	}		
//	echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos==0)
	{
		/*No existen usuarios profesors en el sistema*/
		?>
<table style="text-align: left; width: 100%;" border="0"  cellpadding="5" cellspacing="0" class="bloquelateral">
  <tbody>
    <tr class="mensajealertaencabezado">
      <td >Actualmente no hay profesores registrados en el sistema</td>
    </tr>
    </tbody>
</table>


<?php 

		
	}
	else
	{
/*Si existen usuarios en el sistema*/
?>
<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1 px" class="bloquelateral">
<tr align="center" class="mensajealertaencabezado">
<td >Profesor</td>
<?php  //<td>Correo</td> ?>
<td>Identificaci&oacute;n</td>
<td>Opciones</td>
</tr>
	<?php 
		for($contador=0;$contador<$campos;$contador++)
		{
			?>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');">
<td class="celdatabla"><?php  echo $registro[$contador][0]." ". $registro[$contador][1] ?></td>
<?php  /*<td class="celdatabla"><?php  echo $registro[$contador][2] ?></td>*/?>
<td align="center" class="celdatabla"><?php  echo $registro[$contador][2] ?></td>
<td align="center" class="celdatabla">
<a href="<?php 
$opciones=$configuracion["site"].'/index.php?page='.enlace('editar_com_profesor');
$opciones.='&informacion=1';
$opciones.='&mostrar=1';
$opciones.='&registro='.$registro[$contador][2]; 

echo $opciones;
?>">Informaci&oacute;n</a>
</td>
</tr><?php }?>
</table><br>
</form>
<?php 			
  }
}
?>
