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
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
*****************************************************************************************************************/
?><?PHP  
//Verificar si se tiene un numero de usuario por el metodo GET:
//Puede manejarse cuatro tipos de acceso a este bloque:
// 1. Acceso para edición por parte del administrador
// 2. Acceso para registro de usuarios nuevos
// 3. Acceso para registro de usuarios nuevos por parte del administrador
// 4. Acceso para edición por parte de los usuarios

//Si esta editando
if(isset($_GET['anno']))
{	

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/institucional.inc.php");	
	
	$cadena_sql="SELECT ";
	$cadena_sql.="id_programa, ";
	$cadena_sql.="presupuesto, ";
	$cadena_sql.="anno";
	$cadena_sql.=" FROM ".$configuracion["prefijo"]."investigacion_presupuesto ";
	$cadena_sql.=" WHERE id_programa=".$_GET['id_programa'];
	$cadena_sql.=" AND anno=".$_GET['anno'];
	$cadena_sql.=" LIMIT 1";
	
		//	0 nombre
		//	1.objetivo
		//	2.institucion
		//	3.ambito
		//	4.tipo
		//	5.movilidad
		//	6.estudiante
		//	7.interaccion
		//	8.profesor
		//	9.calidad
		//	10.anno
		//echo $cadena_sql;
	$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();
	$campos=$acceso_db->obtener_conteo_db();
	if($campos>0)
	{	

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_convenio" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="5" cellspacing="2" width="100%" >
    <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Presupuesto para investigaci&oacute;n</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td class="celdatabla">
		<font color="red">*</font>Programa:<br>
              </td>
 		<td class="celdatabla">
		<?PHP  	
			$busqueda="SELECT nombre_corto ";
			$busqueda.="FROM ".$configuracion["prefijo"]."programa ";
			$busqueda.="WHERE id_programa=".$registro[0][0];
			$busqueda.=" ORDER BY nombre_corto LIMIT 1";
			//echo $busqueda;
			$acceso_db->registro_db($busqueda,0);
			$programa=$acceso_db->obtener_registro_db();
			$total_programas=$acceso_db->obtener_conteo_db();
			if($total_programas>0)
			{
				echo $programa[0][0];
			}
			?>
            </td></tr>
            <tr class="bloquecentralcuerpo">
		<td valign="top" class="celdatabla">
		Monto destinado:
		</td>
		<td class="celdatabla">$
		<input maxlength="80" size="35" tabindex="2" name="presupuesto" value="<?PHP   echo $registro[0][1]?>"><br>(Miles y millones separados por punto.)
		</td>
		</tr>
            <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla" valign="top" align="left"><?PHP  
		echo $registro[0][2];
			?>
        </td>
      </tr>	
		<tr>
              <td colspan="2" rowspan="1">
		<input type="hidden" name="action" value="registro_iioc_presupuesto">
		<input type="hidden" name="programa" value="<?PHP   echo $registro[0][0] ?>">
		<input type="hidden" name="anno" value="<?PHP   echo $registro[0][2] ?>">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="14">
              </div><br>
              </td>
            </tr>
    </tbody>
  </table>
</form>














<?PHP  		}	
	}
}
else
{

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_dir_convenio" onsubmit="return ()">
  <table class="bloquelateral" align="center" cellpadding="5" cellspacing="2" width="100%" >
    <tbody>
          <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Presupuesto para investigaci&oacute;n</td>
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
            <tr class="bloquecentralcuerpo">
		<td valign="top" class="celdatabla">
		Monto destinado:
		</td>
		<td class="celdatabla">$
		<input maxlength="80" size="35" tabindex="2" name="presupuesto" >
		<br>(Miles y millones separados por punto.)
		</td>
		</tr>
            <tr class="bloquecentralcuerpo">
        <td class="celdatabla" valign="top">
		<font color="red">*</font>A&ntilde;o:
	</td>
        <td class="celdatabla" valign="top" align="left"><?PHP  
		$contador=0;
		echo "<select name='anno' size='1' tabindex='3'>\n";
		for($anno=2001;$anno<date("Y")+1;$anno++)
		{	
			echo "<option value='".$anno."'>".$anno."</option>\n";
			
		}
		echo "</select>\n";
			?>
        </td>
      </tr>	
		<tr>
              <td colspan="2" rowspan="1">
		<input type="hidden" name="action" value="registro_iioc_presupuesto">
		<div style="text-align: center;"><input value="enviar" name="aceptar" type="submit" tabindex="14">
              </div><br>
              </td>
            </tr>
    </tbody>
  </table>
</form>
<?PHP  
}
?>
