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
  
html.php 

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
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?><?php  
//Verificar si se tiene un numero de usuario por el metodo GET:
//Puede manejarse cuatro tipos de acceso a este bloque:
// 1. Acceso para edición por parte del administrador
// 2. Acceso para registro de usuarios nuevos
// 3. Acceso para registro de usuarios nuevos por parte del administrador
// 4. Acceso para edición por parte de los usuarios

//Si esta editando

if(isset($_GET['asignatura']))
{
	include($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");
	
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT `anno` , `asignatura` ";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."profesor_info_asignatura` ";
		$cadena_sql.="WHERE identificacion='".$_GET['registro']."'";
		$cadena_sql.=" AND id_programa=".$id_programa;
		$cadena_sql.=" AND asignatura='".$_GET['asignatura']."'";
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_asignatura" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Asignatura dictada por el profesor:
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Asignatura:
	</td>
        <td class="celdatabla"><?php   echo $registro[0][1] ?>
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		Dictada en los a&ntilde;os:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo" >
      	<td colspan="2" rowspan="1" class="celdatabla">
      	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="1">
        	<tbody>
          	<?php  
		$fila=0;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($fila==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			
			echo '<td class="celdatabla">';
			$en_matriz=0;
			for($contador=0;$contador<$campos;$contador++)
			{
				if($registro[$contador][0]==$anno)
				{
					$en_matriz=1;
					$contador=$campos+1;			
				}				
			
			}
			if($en_matriz==0)
			{
				echo "<input name='".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
			}
			else
			{
				echo "<input name='".$anno."' value='".$anno."' type='checkbox' checked='checked'>\n".$anno;				
			}
			echo '</td>';
			$fila++;
			if($fila==4)
			{
				echo "</tr>\n";
				$fila=0;
			}
			
		}
		
		?>
            		</tbody>
			</table>
        
      	</td>
      </td>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_asignatura">
		<input type="hidden" name="identificacion" value="<?php   echo $_GET["registro"]?>">
		<input type="hidden" name="asignatura" value="<?php   echo $registro[0][1] ?>">
		<input type="hidden" name="usuario" value="<?php   echo $_GET["usuario"]?>">
		<input name="aceptar" value="Aceptar" type="submit"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?php  		}
	}
}

else
{ // Si es un registro nuevo
?><script src="<?php   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="info_asignatura" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Asignatura dictada por el profesor:
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		Asignatura:
	</td>
        <td class="celdatabla">
		<input maxlength="255" size="30" name="asignatura">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td colspan="2" rowspan="1" class="celdatabla">
		Dictada en los a&ntilde;os:
        </td>
      </tr>
      <tr class="bloquecentralcuerpo">
      	<td colspan="2" rowspan="1" class="celdatabla">
      	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="1">
        	<tbody>
          	<?php  
		$fila=0;
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			if($fila==0)
			{
				echo "<tr class='bloquecentralcuerpo'>\n";
			}
			
			
			echo '<td class="celdatabla">';
			echo "<input name='".$anno."' value='".$anno."' type='checkbox'>\n".$anno;	
			echo '</td>';
			$fila++;
			if($fila==4)
			{
				echo "</tr>\n";
				$fila=0;
			}
			
		}
		
		?>
            		</tbody>
			</table>
        
      	</td>
      </td>
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_asignatura">
		<input type="hidden" name="identificacion" value="<?php   echo $_GET["identificacion"]?>">
		<input type="hidden" name="usuario" value="<?php   echo $_GET["usuario"]?>">
		<input name="aceptar" value="Aceptar" type="submit"><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?php  
	}

?>
