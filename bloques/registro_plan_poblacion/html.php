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
* @description  Formulario de registro de grupos de investigacion
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?><?PHP  
//Verificar si se tiene un numero de usuario por el metodo GET:
//Puede manejarse cuatro tipos de acceso a este bloque:
// 1. Acceso para edición por parte del administrador
// 2. Acceso para registro de usuarios nuevos
// 3. Acceso para registro de usuarios nuevos por parte del administrador
// 4. Acceso para edición por parte de los usuarios
$tab=0;
//Si esta editando
if(isset($_GET['programa']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT `poblacion`, ";
		$cadena_sql.="`semestre`, periodo ";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."plan_poblacion` ";		
		$cadena_sql.="WHERE id_programa=".$_GET['programa'];
		$cadena_sql.=" AND anno=".$_GET['anno'];
		$cadena_sql.=" AND periodo=".$_GET['periodo'];
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="registro_plan_admision" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n sobre Poblaci&oacute;n Estudiantil
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  
            
			$busqueda="SELECT nombre_corto ";
			$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
			$busqueda.="WHERE id_programa=".$_GET["programa"];
			$busqueda.=" ORDER BY nombre_corto LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$programa=$acceso_db->obtener_registro_db();
			$total_programas=$acceso_db->obtener_conteo_db();
			if($total_programas>0)
			{
				echo $programa[0][0];
            		}
            		else
            		{
            			echo "N/D";
            		}	
            
            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		<font color="red">*</font>A&ntilde;o:						
		</TD>
		<TD class="celdatabla">
		<?PHP   echo $_GET['anno']?>
		</TD>
		</TR>
		<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Periodo No:
	</td>
        <td class="celdatabla">
	<?PHP   echo $_GET['periodo']?>	
	</td>
      </tr>
	<?PHP  
		
		$cadena_sql="SELECT `teorico`,`real`,observacion ";
		$cadena_sql.="FROM `".$configuracion["prefijo"]."plan_duracion` ";		
		$cadena_sql.="WHERE id_programa=".$_GET['programa'];
		$cadena_sql.=" AND anno=".$_GET['anno'];
		$cadena_sql.=" AND periodo=".$_GET['periodo'];
		//echo $cadena_sql;
		
		$acceso_db->registro_db($cadena_sql,0);
		$duracion=$acceso_db->obtener_registro_db();
		$campos_duracion=$acceso_db->obtener_conteo_db();
		if($campos_duracion>0)
		{
	
	?>
	<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Duraci&oacute;n prevista del programa:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="<?PHP   echo $tab++?>" name="teorico" value="<?PHP   echo $duracion[0][0]?>">
	</td>
	</tr>
	<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Duraci&oacute;n promedio real del programa:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="<?PHP   echo $tab++?>" name="real" value="<?PHP   echo $duracion[0][1]?>">
	</td>
      </tr>
	<?PHP  
	}
	else
	{
	?>	
	<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Duraci&oacute;n prevista del programa:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="<?PHP   echo $tab++?>" name="teorica">
	</td>
	</tr>
	<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Duraci&oacute;n promedio real del programa:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="<?PHP   echo $tab++?>" name="real">
	</td>
      </tr>
	<?PHP  
	}
	?>
      
      
      <tr class="mensajealertaencabezado">
        <td class="celdatabla" colspan="2">
		Poblaci&oacute;n estudiantil por semestre:
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla" colspan="2">
		<table align="center" width="100%" cellpadding="0" cellspacing="2" >
		<tr class="bloquecentralcuerpo"><?PHP  
		$nueva_fila=1;
		for($contador=1;$contador<21;$contador++)
		{
			$existe=FALSE;
			for($contador_2=0;$contador_2<$campos;$contador_2++)
			{
				if($registro[$contador_2][1]==$contador)
				{
					$existe=TRUE;
					echo "<td class='celdatabla' align='center'>".$contador."<br><input maxlength='10' size='6' tabindex='".$tab++."' name='semestre_".$contador."' value='".$registro[$contador_2][0]."'></td>\n";
					break;				
				}
			
			}
			
			if($existe==FALSE)
			{
				echo "<td class='celdatabla' align='center'>".$contador."<br><input maxlength='10' size='6' tabindex='".$tab++."' name='semestre_".$contador."'></td>\n";
			
			}
			if($contador==5*$nueva_fila)
			{
				echo "</tr>\n<tr class='bloquecentralcuerpo'>\n";
				$nueva_fila++;
			}
		}
		
		?>	
		</tr>
		</table>
	</td>
      </tr>
     <tr class="mensajealertaencabezado" >
        <td class="celdatabla" colspan="2">
		<font color="red">*</font>Observaciones:
	</td>
	</tr>
	<tr>
        <td class="celdatabla" colspan="2" align="center">
		<textarea cols="40" rows="5" name="observacion" tabindex="<?PHP   echo $tab++ ?>"><?PHP   echo $duracion[0][2]?></textarea>
	</td>
      </tr>					
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_plan_poblacion">
		<input type="hidden" name="programa" value="<?PHP   echo $_GET['programa']?>">
		<input type="hidden" name="anno" value="<?PHP   echo $_GET['anno']?>">
		<input type="hidden" name="periodo" value="<?PHP   echo $_GET['periodo']?>">
		<input name="aceptar" value="Aceptar" type="submit" <?PHP   echo $tab++?> ><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?PHP  		}
	}
}

else
{ // Si es un registro nuevo

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="POST" action="index.php" name="registro_plan_admision" onsubmit="return () ">
  <table class="bloquelateral" cellpadding="5" cellspacing="1" width="100%">
    <tbody>
      <tr class="mensajealertaencabezado">
        <td colspan="2" rowspan="1">
		Informaci&oacute;n sobre Poblaci&oacute;n Estudiantil
	</td>
      </td>
      </tr>	
      <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();

$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,0,0);
echo $mi_cuadro;
            ?></td></tr>
            <TR class="bloquecentralcuerpo">
		<TD class="celdatabla">
		<font color="red">*</font>A&ntilde;o:						
		</TD>
		<TD class="celdatabla">
		<?PHP  
				echo "<select name='anno' size='1'>\n";
				echo "<option value='0'> </option>\n";
				for($anno=2001;$anno<date("Y")+1;$anno++)
				{	
					echo "<option value='".$anno."'>".$anno."</option>\n";
					
				}
				echo "</select>\n";
		?>
		</TD>
		</TR>
		<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Periodo No:
	</td>
        <td class="celdatabla">
		<input maxlength="5" size="5" tabindex="<?PHP   echo $tab++?>" name="periodo">
	</td>
      </tr>
	<tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Duraci&oacute;n prevista del programa:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="<?PHP   echo $tab++?>" name="teorico">
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla">
		<font color="red">*</font>Duraci&oacute;n promedio real del programa:
	</td>
        <td class="celdatabla">
		<input maxlength="10" size="5" tabindex="<?PHP   echo $tab++?>" name="real">
	</td>
      </tr>
      <tr class="mensajealertaencabezado">
        <td class="celdatabla" colspan="2">
		Poblaci&oacute;n estudiantil por semestre:
	</td>
      </tr>
      <tr class="bloquecentralcuerpo">
        <td class="celdatabla" colspan="2">
		<table align="center" width="100%" cellpadding="0" cellspacing="2" >
		<tr class="bloquecentralcuerpo"><?PHP  
		
		$nueva_fila=1;
		for($contador=1;$contador<21;$contador++)
		{
			echo "<td class='celdatabla' align='center'>".$contador."<br><input maxlength='10' size='6' tabindex='".$tab++."' name='semestre_".$contador."'></td>\n";
			if($contador==5*$nueva_fila)
			{
				echo "</tr>\n<tr class='bloquecentralcuerpo'>\n";
				$nueva_fila++;
			}
		}
		
		?>	
		</tr>
		</table>
	</td>
      </tr>
      <tr class="mensajealertaencabezado" >
        <td class="celdatabla" colspan="2">
		Observaciones:
	</td>
	</tr>
	<tr>
        <td class="celdatabla" colspan="2" align="center">
		<textarea cols="40" rows="5" name="observacion" tabindex="<?PHP   echo $tab++ ?>"></textarea>
	</td>
      </tr>		
      <tr align="center">
        <td colspan="2" rowspan="1" v>
		<input type="hidden" name="action" value="registro_plan_poblacion">
		<input name="aceptar" value="Aceptar" type="submit" <?PHP   echo $tab++?>><br>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
</form>
<?PHP  
	}

?>
