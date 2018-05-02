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
?><?PHP  
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
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if($enlace)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($enlace);
	$esta_sesion=$nueva_sesion->numero_sesion();
	//Rescatar el valor de la variable usuario de la sesion
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"usuario");
	if($registro)
	{
		
		$el_usuario=$registro[0][0];
	}
	
	$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
	if($registro)
	{
		
		$id_usuario=$registro[0][0];
	}



//Si esta editando
if(isset($_GET['fecha']))
{
	
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_matriz_edu">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1">
          <tbody>
          	<tr class="bloquecentralencabezado">
              		<td rowspan="1">Evaluaci&oacute;n Documental:</td>
            	</tr>
            	<tr>
        		<td align="center" valign="middle">
            	
            <?PHP  
        
		$cadena_sql="SELECT ";
		$cadena_sql.="id_criterio, ";
		$cadena_sql.="nombre ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."criterio_edu ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="tipo_documento=0 ";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$tab=1;	
			$total_documento=0;
			$calificacion_documento=0;
			for($contador=0;$contador<$campos;$contador++)
			{     
					
				
				$cadena_html="";		
				$cadena_sql="SELECT ";
				$cadena_sql.="id_evidencia, ";
				$cadena_sql.="id_criterio, ";
				$cadena_sql.="nombre, ";
				$cadena_sql.="descripcion, ";
				$cadena_sql.="ponderacion, ";
				$cadena_sql.="justificacion ";								
				$cadena_sql.="FROM ";
				$cadena_sql.=$configuracion["prefijo"]."evidencia_edu ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_criterio=".$registro[$contador][0];
				//echo $cadena_sql;
				
				$acceso_db->registro_db($cadena_sql,0);
				$registro_evidencia=$acceso_db->obtener_registro_db();
				$campos_evidencia=$acceso_db->obtener_conteo_db();
				if($campos_evidencia>0)
				{
					$total_evidencia=0;
					$total_calificacion=0;
					for($i=0;$i<$campos_evidencia;$i++)
					{					
						//obtener evaluacion
						$cadena_sql="SELECT ";
						$cadena_sql.="id_criterio, ";
						$cadena_sql.="id_evidencia, ";
						$cadena_sql.="cumplimiento, ";
						$cadena_sql.=" observaciones";
						$cadena_sql.=" FROM ";
						$cadena_sql.=$configuracion["prefijo"]."edu ";
						$cadena_sql.="WHERE ";
						$cadena_sql.="id_usuario=".$id_usuario." ";
						$cadena_sql.="AND ";
						$cadena_sql.="id_documento=".$_GET['registro']." ";
						$cadena_sql.="AND ";
						$cadena_sql.="fecha='".$_GET['fecha']."'";
						$cadena_sql.="AND ";
						$cadena_sql.="id_evidencia='".$registro_evidencia[$i][0]."'";
						//echo $cadena_sql;
						$acceso_db->registro_db($cadena_sql,0);
						$registro_edu=$acceso_db->obtener_registro_db();
						$campos_2=$acceso_db->obtener_conteo_db();
						//echo $campos_2." campos devueltos";
						if($campos_2>0)
						{
							$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
							$cadena_html.="<td class='celdatabla' >\n";
							$cadena_html.="<b>".$registro_evidencia[$i][2]."</b>";
							$cadena_html.="<input type='hidden' name='evidencia_".$registro_evidencia[$i][0]."' value='".$registro_evidencia[$i][0]."'>\n";
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center' valign='middle'>\n";
							$cadena_html.="<input type='hidden' name='ponderacion_".$registro_evidencia[$i][0]."' value='".$registro_evidencia[$i][4]."'>\n";
							$cadena_html.=$registro_evidencia[$i][4];
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center'>\n";
							$cadena_html.="<input maxlength='4' size='4' tabindex='".$tab++."' name='cumplimiento_".$registro_evidencia[$i][0]."' value='".$registro_edu[0][2]."' onChange=\"return (cumplimiento_evidencia(registrar_matriz_edu,'cumplimiento_".$registro_evidencia[$i][0]."','puntaje_".$registro_evidencia[$i][0]."','ponderacion_".$registro_evidencia[$i][0]."','cumplimiento_criterio_".$registro[$contador][0]."','total_documento','ideal_documento','porcentaje_criterio_".$registro[$contador][0]."','ideal_criterio_".$registro[$contador][0]."'))\"><br>\n";
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center'>\n";
							$cadena_html.=$registro_evidencia[$i][4]*5;
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center'>\n";
							$cadena_html.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='puntaje_".$registro_evidencia[$i][0]."' value='".($registro_edu[0][2]*$registro_evidencia[$i][4])."' ><br>\n";
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center' colspan='3'>\n";
							$cadena_html.="<textarea cols='20' rows='2' name='observaciones_".$registro_evidencia[$i][0]."'>".$registro_edu[0][3]."</textarea><br>";
							$cadena_html.="</td>\n";
							$cadena_html.="</tr>\n";
							$total_evidencia+=$registro_evidencia[$i][4]*5;
							$total_calificacion+=$registro_edu[0][2]*$registro_evidencia[$i][4];
						
						}
						else
						{
							$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
							$cadena_html.="<td class='celdatabla' >\n";
							$cadena_html.="<b>".$registro_evidencia[$i][2]."</b>";
							$cadena_html.="<input type='hidden' name='evidencia_".$registro_evidencia[$i][0]."' value='".$registro_evidencia[$i][0]."'>\n";
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center' valign='middle'>\n";
							$cadena_html.="<input type='hidden' name='ponderacion_".$registro_evidencia[$i][0]."' value='".$registro_evidencia[$i][4]."'>\n";
							$cadena_html.=$registro_evidencia[$i][4];
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center'>\n";
							$cadena_html.="<input maxlength='4' size='4' tabindex='".$tab++."' name='cumplimiento_".$registro_evidencia[$i][0]."' onChange=\"return (cumplimiento_evidencia(registrar_matriz_edu,'cumplimiento_".$registro_evidencia[$i][0]."','puntaje_".$registro_evidencia[$i][0]."','ponderacion_".$registro_evidencia[$i][0]."','cumplimiento_criterio_".$registro[$contador][0]."','total_documento','ideal_documento','porcentaje_criterio_".$registro[$contador][0]."','ideal_criterio_".$registro[$contador][0]."'))\"><br>\n";
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center'>\n";
							$cadena_html.=$registro_evidencia[$i][4]*5;
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center'>\n";
							$cadena_html.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='puntaje_".$registro_evidencia[$i][0]."'><br>\n";
							$cadena_html.="</td>\n";
							$cadena_html.="<td class='celdatabla' align='center' colspan='3'>\n";
							$cadena_html.="<textarea cols='20' rows='2' name='observaciones_".$registro_evidencia[$i][0]."'></textarea><br>";
							$cadena_html.="</td>\n";
							$cadena_html.="</tr>\n";
							$total_evidencia+=$registro_evidencia[$i][4]*5;								
						}
						
						
						
					}
					$total_documento+=$total_evidencia;
					$calificacion_documento+=$total_calificacion;
					$cadena_html.="</table>\n";
					$cadena_html.="<br>";
					
					
					$cadena_encabezado="<table width='100%' class='bloquelateral2' cellpadding='7' cellspacing='1'>";
					$cadena_encabezado.="<tr class='bloquecentralcuerpo'>\n";
					$cadena_encabezado.="<td class='celdatablacontenido'  colspan='5' align='center' valign='middle'>\n";	
					$cadena_encabezado.="<b>".ucfirst(strtolower($registro[$contador][1]))."</b>\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center' valign='middle'>\n";
					$cadena_encabezado.="<input type='hidden' name='ideal_criterio_".$registro[$contador][0]."' value='".$total_evidencia."'>\n";
					$cadena_encabezado.="<input type='hidden' name='criterio_".$registro[$contador][0]."' value='".$registro[$contador][0]."'>\n";
					$cadena_encabezado.=$total_evidencia."\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center' valign='middle'>\n";					
					$cadena_encabezado.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='cumplimiento_criterio_".$registro[$contador][0]."' value='".$total_calificacion."'><br>\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>\n";
					$cadena_encabezado.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='porcentaje_criterio_".$registro[$contador][0]."' value='".($total_calificacion*100)/$total_evidencia."' >%<br>\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="</tr>\n";
					
					$cadena_encabezado.="<tr align='center' class='bloquecentralcuerpo' >\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Evidencia</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Pond</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Cumpl</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Ideal</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Eval</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center' colspan='3'>Observaciones</td>\n";	
					$cadena_encabezado.="</tr>\n";
										
					echo $cadena_encabezado;
					echo $cadena_html;	
					
				
				}
				
				
				
						
			
			}
			$cadena_documento="<table width='100%' class='bloquelateral2' cellpadding='7' cellspacing='1'>";
			$cadena_documento.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_documento.="<td class='celdatablacontenido'  colspan='5' align='center'>\n";	
			$cadena_documento.="Consolidado de Cumplimiento para el documento";
			$cadena_documento.="</td>\n";	
			$cadena_documento.="<td class='celdatablacontenido'  colspan='5' align='center'>\n";	
			$cadena_documento.="<input type='hidden' name='ideal_documento' value='".$total_documento."'><br>\n";
			$cadena_documento.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='total_documento' value='".($calificacion_documento*100/$total_documento)."'>%<br>\n";
			$cadena_documento.="</td>\n";
			$cadena_documento.="</tr>\n";
			$cadena_documento.="</table>\n";	
			echo $cadena_documento;	
       }

  ?>
  			</td>
  		</tr>
                <tr>
			<td colspan="4" rowspan="1" align="center">
				<table width="50%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td align="center">
								<br><input type="hidden" name="action" value="registro_matriz_edu"><?PHP  
								include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
							
								?><input type="hidden" name="fecha" value="<?PHP   echo $_GET["fecha"]?>">
								<input type="hidden" name="accion" value="<?PHP   echo $_GET["accion"]?>">
								<input type="hidden" name="hoja" value="<?PHP   echo $_GET["hoja"]?>">
								<input type="hidden" name="registro" value="<?PHP   echo $_GET["registro"]?>">
								<input type="hidden" name="pagina" value="<?PHP   echo enlace('admin_evaluacion_documental') ?>">
								<input value="enviar" name="aceptar" type="submit">
							</td>
							<td align="center">
								<br><input value="Cancelar" name="cancelar" type="submit" title="Regresar sin guardar.">
							</td>
					</tr>
				</table>
			</td>
            	</tr>
          </tbody>
        </table>
        <br>
        </td>
      </tr>
    </tbody>
  </table>
</form>
<?PHP  	
}
else
{

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_matriz_edu">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1">
          <tbody>
          	<tr class="bloquecentralencabezado">
              		<td rowspan="1">Evaluaci&oacute;n Documental:</td>
            	</tr>
            	<tr>
        		<td align="center" valign="middle">
            	
            <?PHP  
        
		$cadena_sql="SELECT ";
		$cadena_sql.="id_criterio, ";
		$cadena_sql.="nombre ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."criterio_edu ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="tipo_documento=0 ";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$tab=1;	
			$total_documento=0;
			for($contador=0;$contador<$campos;$contador++)
			{     
					
				
				$cadena_html="";		
				$cadena_sql="SELECT ";
				$cadena_sql.="id_evidencia, ";
				$cadena_sql.="id_criterio, ";
				$cadena_sql.="nombre, ";
				$cadena_sql.="descripcion, ";
				$cadena_sql.="ponderacion, ";
				$cadena_sql.="justificacion ";								
				$cadena_sql.="FROM ";
				$cadena_sql.=$configuracion["prefijo"]."evidencia_edu ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_criterio=".$registro[$contador][0];
				//echo $cadena_sql;
				
				$acceso_db->registro_db($cadena_sql,0);
				$registro_evidencia=$acceso_db->obtener_registro_db();
				$campos_evidencia=$acceso_db->obtener_conteo_db();
				if($campos_evidencia>0)
				{
					$total_evidencia=0;
					for($i=0;$i<$campos_evidencia;$i++)
					{					
						$cadena_html.="<tr class='bloquecentralcuerpo'>\n";
						$cadena_html.="<td class='celdatabla' >\n";
						$cadena_html.="<b>".$registro_evidencia[$i][2]."</b>";
						$cadena_html.="<input type='hidden' name='evidencia_".$registro_evidencia[$i][0]."' value='".$registro_evidencia[$i][0]."'>\n";
						$cadena_html.="</td>\n";
						$cadena_html.="<td class='celdatabla' align='center' valign='middle'>\n";
						$cadena_html.="<input type='hidden' name='ponderacion_".$registro_evidencia[$i][0]."' value='".$registro_evidencia[$i][4]."'>\n";
						$cadena_html.=$registro_evidencia[$i][4];
						$cadena_html.="</td>\n";
						$cadena_html.="<td class='celdatabla' align='center'>\n";
						$cadena_html.="<input maxlength='4' size='4' tabindex='".$tab++."' name='cumplimiento_".$registro_evidencia[$i][0]."' onChange=\"return (cumplimiento_evidencia(registrar_matriz_edu,'cumplimiento_".$registro_evidencia[$i][0]."','puntaje_".$registro_evidencia[$i][0]."','ponderacion_".$registro_evidencia[$i][0]."','cumplimiento_criterio_".$registro[$contador][0]."','total_documento','ideal_documento','porcentaje_criterio_".$registro[$contador][0]."','ideal_criterio_".$registro[$contador][0]."'))\"><br>\n";
						$cadena_html.="</td>\n";
						$cadena_html.="<td class='celdatabla' align='center'>\n";
						$cadena_html.=$registro_evidencia[$i][4]*5;
						$cadena_html.="</td>\n";
						$cadena_html.="<td class='celdatabla' align='center'>\n";
						$cadena_html.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='puntaje_".$registro_evidencia[$i][0]."'><br>\n";
						$cadena_html.="</td>\n";
						$cadena_html.="<td class='celdatabla' align='center' colspan='3'>\n";
						$cadena_html.="<textarea cols='20' rows='2' name='observaciones_".$registro_evidencia[$i][0]."'></textarea><br>";
						$cadena_html.="</td>\n";
						$cadena_html.="</tr>\n";
						$total_evidencia+=$registro_evidencia[$i][4]*5;
						
					}
					$total_documento+=$total_evidencia;
					$cadena_html.="</table>\n";
					$cadena_html.="<br>";
					
					
					$cadena_encabezado="<table width='100%' class='bloquelateral2' cellpadding='7' cellspacing='1'>";
					$cadena_encabezado.="<tr class='bloquecentralcuerpo'>\n";
					$cadena_encabezado.="<td class='celdatablacontenido'  colspan='5' align='center' valign='middle'>\n";	
					$cadena_encabezado.="<b>".ucfirst(strtolower($registro[$contador][1]))."</b>\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center' valign='middle'>\n";
					$cadena_encabezado.="<input type='hidden' name='ideal_criterio_".$registro[$contador][0]."' value='".$total_evidencia."'>\n";
					$cadena_encabezado.="<input type='hidden' name='criterio_".$registro[$contador][0]."' value='".$registro[$contador][0]."'>\n";
					$cadena_encabezado.=$total_evidencia."\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center' valign='middle'>\n";					
					$cadena_encabezado.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='cumplimiento_criterio_".$registro[$contador][0]."'><br>\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>\n";
					$cadena_encabezado.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='porcentaje_criterio_".$registro[$contador][0]."'>%<br>\n";
					$cadena_encabezado.="</td>\n";
					$cadena_encabezado.="</tr>\n";
					
					$cadena_encabezado.="<tr align='center' class='bloquecentralcuerpo' >\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Evidencia</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Pond</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Cumpl</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Ideal</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center'>Eval</td>\n";
					$cadena_encabezado.="<td class='celdatabla' align='center' colspan='3'>Observaciones</td>\n";	
					$cadena_encabezado.="</tr>\n";
										
					echo $cadena_encabezado;
					echo $cadena_html;	
					
				
				}
				
				
				
						
			
			}
			$cadena_documento="<table width='100%' class='bloquelateral2' cellpadding='7' cellspacing='1'>";
			$cadena_documento.="<tr class='bloquecentralcuerpo'>\n";
			$cadena_documento.="<td class='celdatablacontenido'  colspan='5' align='center'>\n";	
			$cadena_documento.="Consolidado de Cumplimiento para el documento";
			$cadena_documento.="</td>\n";	
			$cadena_documento.="<td class='celdatablacontenido'  colspan='5' align='center'>\n";	
			$cadena_documento.="<input type='hidden' name='ideal_documento' value='".$total_documento."'><br>\n";
			$cadena_documento.="<input maxlength='4' size='3' readonly tabindex='".$tab++."' name='total_documento'>%<br>\n";
			$cadena_documento.="</td>\n";
			$cadena_documento.="</tr>\n";
			$cadena_documento.="</table>\n";	
			echo $cadena_documento;	
       }

  ?>
  			</td>
  		</tr>
            <tr>
              <td  rowspan="1" align="center">
		      <table width="50%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td align="center">
							<input type="hidden" name="action" value="registro_matriz_edu"><?PHP  
							include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
							?><input type="hidden" name="pagina" value="<?PHP   echo enlace('admin_evaluacion_documental') ?>">
							<input type="hidden" name="registro" value="<?PHP   echo $_GET["registro"]?>">
							<input type="hidden" name="accion" value="<?PHP   echo $_GET["accion"]?>">
							<input type="hidden" name="hoja" value="<?PHP   echo $_GET["hoja"]?>">
							<br><input value="enviar" name="aceptar" type="submit">
						</td>
						<td align="center">
							<br><input value="Cancelar" name="cancelar" type="submit" title="Regresar sin guardar.">
						</td>
				      </tr>
			</table>
              </td>
            </tr>
          </tbody>
        </table>
        <br>
        </td>
      </tr>
    </tbody>
  </table>
</form>
<?PHP  
}
}
?>
