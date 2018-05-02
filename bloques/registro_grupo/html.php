<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2007

Última revisión 28 de Mayo de 2007

******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de profesores
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier metodo GET, POST.
********************************************************************************/


if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}


include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
include_once ($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");
$el_estilo=$this->estilo;
//Variables

$formulario="registro_grupo";
$verificar="control_vacio(".$formulario.",'nombre')";
$verificar.="&& longitud_cadena(".$formulario.",'nombre',4)";

if(isset($_REQUEST['etiqueta']))
{
	mostrar_corto_grupo($configuracion,$tema);

}
else
{
	if(isset($_REQUEST['opcion']))
	{
		$accion=$_REQUEST['opcion'];
		
		if($accion=="mostrar")
		{
			
			mostrar_registro_grupo($configuracion,$tema,$accion);
		}
		else
		{
			
			if($accion=="nuevo")
			{
				nuevo_registro_grupo($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab,$el_estilo);
			
			}
			else
			{
				if($accion=="editar")
				{
					editar_registro_grupo($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
				
				}
				else
				{
					if($accion=="corregir")
					{
						corregir_registro_grupo($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
					
					}
				}		
			}
			
		
		}
	}
	else
	{
		$accion="nuevo";
		nuevo_registro_grupo($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab,$el_estilo);
	}	
}
/****************************************************************************************
*				Funciones						*
****************************************************************************************/


function nuevo_registro_grupo($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab,$estilo)
{
	
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?php echo $formulario ?>" >
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table style="width: 100%; text-align: left;" border="0" cellpadding="6" cellspacing="0">
					<tbody>
						<tr class="bloquelateralencabezado">
							<td>
							::.. Registro B&aacute;sico para grupos de usuarios
							</td>
						</tr>
						<tr class="bloquecentralcuerpo">
							<td>
								<table align='center' width='100%' cellpadding='5' cellspacing='0'>
									<tr class="bloquecentralcuerpo">
										<td>
											<span class="texto_rojo">*</span><span onmouseover="<?php 
											$texto_ayuda="Nombre Completo con el cual se identifica el grupo.";		
											echo "this.T_WIDTH=200;return escape('".$texto_ayuda."')" ?>">
											Nombre:
											</span>
										</td>
										<td>
											<input maxlength="80" size="30" tabindex="<?php echo $tab++ ?>" name="nombre"><br>
										</td>
									</tr>
									<tr>
										<td colspan="2">
										<hr class="hr_division">
										</td>
									</tr>									
									<tr class="bloquecentralcuerpo">
										<td colspan="2" rowspan="1">
											<span onmouseover="<?php 
											$texto_ayuda="<b>Descripci&oacute;n</b><br>";		
											$texto_ayuda.="Del rol que juega el equipo dentro del proceso.";		
											echo "this.T_WIDTH=200;return escape('".$texto_ayuda."')" ?>">
											<span class="texto_color">Descripci&oacute;n</span>
											</span>
										</td>
									</tr>
									<tr>
										<td colspan="2" rowspan="1">
											<textarea id="descripcion" cols='50' rows='5' tabindex="<?php echo $tab++ ?>" name="descripcion"></textarea>
											<script type="text/javascript">
												mis_botones='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/';
												archivo_css='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/".$estilo."/estilo.php" ?>';
												editor_html('descripcion', 'bold italic underline | left center right |');
											</script>
										</td>
									</tr>
									<tr class="bloquecentralcuerpo">
										<td>
											<span class="texto_rojo">*</span><span onmouseover="<?php 
											$texto_ayuda="<b>Tipo de Grupo</b><br>";
											$texto_ayuda.="De acuerdo a los grupos especiales de usuarios en el sistema.";
											echo "this.T_WIDTH=200;return escape('".$texto_ayuda."')" ?>">
											Tipo de Grupo:
											</span>
										</td>
										<td>
												<?php
										include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
										$html=new html();
										
										$busqueda="SELECT ";
										$busqueda.="id_valor, ";
										$busqueda.="nombre ";
										$busqueda.="FROM ";
										$busqueda.=$configuracion["prefijo"]."valores_profesor ";
										$busqueda.="WHERE ";
										$busqueda.="id_tipo_valor=7 ";
										$busqueda.="ORDER BY nombre";
										$mi_cuadro=$html->cuadro_lista($busqueda,'id_grupo',$configuracion,0,0,0);
										echo $mi_cuadro;
											?></td>
									</tr>					
									<tr>
										<td colspan="2" rowspan="1" align="center">
											<hr class="hr_division">
											<input type="hidden" name="action" value="registro_grupo">
											<input name='aceptar' value='Aceptar' type='button' onclick="return(<?php echo $verificar; ?>)?this.form.submit():false">
										</td>
									</tr>	
								</table>
							</td>
						</tr>							
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form><?php
}


function corregir_registro_grupo($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab)
{
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_grupo" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && seleccion_valida(this,'programa') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3))">
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="500">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
          <tbody>
            <tr class="bloquecentralencabezado">
              <td colspan="2" rowspan="1" align="undefined" valign="undefined">Registro para profesores:</td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="width: 318px; text-align: left; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Nombres:<br>
              </td>
              <td style="width: 365px; background-color: rgb(239, 239, 239);" colspan="1" rowspan="1">
		<input maxlength="80" size="40" tabindex="1" name="nombre" value="<?php echo $_POST["nombre"] ?>"><br>
              </td>
           </tr>
           <tr class="bloquecentralcuerpo">
              <td style="width: 318px; background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Apellidos:<br>
              </td>
              <td colspan="1" rowspan="1" style="width: 128px; background-color: rgb(239, 239, 239);">
                <input maxlength="80" size="40" tabindex="2" name="apellido" value="<?php echo $_POST["apellido"] ?>">
	      </td>
            </tr>
            <tr class="bloquecentralcuerpo">
              <td style="background-color: rgb(239, 239, 239);">
		<font color="red">*</font>Identificaci&oacute;n:<br>
              </td>
              <td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
              <input maxlength="80" size="40" tabindex="3" name="identificacion" value="<?php echo $_POST["identificacion"] ?>">
	      </td>
            </tr>
		<tr class="bloquecentralcuerpo">
			<td style="background-color: rgb(239, 239, 239);">
				<font color="red">*</font>Programa Actual:<br>
			</td>
			<td style="background-color: rgb(239, 239, 239);" align="undefined" valign="undefined">
				<?php
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
		$html=new html();
		
		$busqueda="SELECT id_programa,nombre_corto FROM ".$configuracion["prefijo"]."programa ORDER BY nombre_corto";
		$mi_cuadro=$html->cuadro_lista($busqueda,'programa',$configuracion,-1,0,0);
		echo $mi_cuadro;
			?></td></tr><tr>
            <tr>
              <td colspan="2" rowspan="1">
              <br>
		<input type="hidden" name="action" value="registro_grupo">
              <div style="text-align: center;"><input value="enviar" name="aceptar" type="submit"><br>
              </div>
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
<?php
}


function editar_registro_grupo($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab)
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nombre, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.apellido, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.id_tipo_identificacion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.identificacion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.correo, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.telefono, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nacimiento, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.sexo ";			
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."profesor, "; 
		$cadena_sql.=$configuracion["prefijo"]."tipo_identificacion ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="identificacion='".$_REQUEST['registro']."' ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_grupo" onsubmit="return ( control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'identificacion') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'identificacion',3) && seleccion_valida(this,'programa'))">
<table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table style="width: 100%; text-align: left;" border="0" cellpadding="6" cellspacing="0">
					<tbody>
						<tr class="bloquecentralencabezado">
							<td>
							Editar Informaci&oacute;n del profesor
							</td>
						</tr>
						<tr class="bloquecentralcuerpo">
							<td>
								<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
									<tr class="bloquecentralcuerpo">
										<td>
											<span class="texto_rojo">*</span><span onmouseover="<?php 
											$texto_ayuda="Nombres del Docente";		
											echo "this.T_WIDTH=200;return escape('".$texto_ayuda."')" ?>">
											Nombres:
											</span>
										</td>
										<td>
											<input maxlength="80" size="30" tabindex="<?php echo $tab++ ?>" name="nombre" value="<?php echo $registro[0][0] ?>"><br>
										</td>
									</tr>
									<tr class="bloquecentralcuerpo">
										<td>
											<span class="texto_rojo">*</span><span onmouseover="<?php 
											$texto_ayuda="<b>Apellidos</b> completos del Docente";		
											echo "this.T_WIDTH=200;return escape('".$texto_ayuda."')" ?>">
											Apellidos:
											</span>
										</td>
										<td colspan="1" rowspan="1">
											<input maxlength="80" size="30" tabindex="<?php echo $tab++ ?>" name="apellido" value="<?php echo $registro[0][1] ?>">
										</td>
									</tr>
									<tr class="bloquecentralcuerpo">
										<td>
											<span class="texto_rojo">*</span><span onmouseover="<?php 
											$texto_ayuda="<b>Tipo de Documento</b> que posee el docente.";		
											echo "this.T_WIDTH=200;return escape('".$texto_ayuda."')" ?>">
											Tipo de Documento:
											</span>
										</td>
										<td>
												<?php
										include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
										$html=new html();
										
										$busqueda="SELECT ";
										$busqueda.="id_tipo_identificacion, ";
										$busqueda.="nombre ";
										$busqueda.="FROM ";
										$busqueda.=$configuracion["prefijo"]."tipo_identificacion ";
										$busqueda.="ORDER BY nombre";
										$mi_cuadro=$html->cuadro_lista($busqueda,'id_tipo_identificacion',$configuracion,$registro[0][2],0,0);
										echo $mi_cuadro;
											?></td>
									</tr>
									<tr class="bloquecentralcuerpo">
										<td>
											<span class="texto_rojo">*</span><span onmouseover="<?php 
											$texto_ayuda="<b>N&uacute;mero del documento de identificaci&oacute;n.</b><br>Escribir solo el n&uacute;mero ";
											$texto_ayuda.="sin puntos ni comas de separaci&oacute;n.";
											echo "this.T_WIDTH=250;return escape('".$texto_ayuda."')" ?>">
											N&uacute;mero:
											</span>
										</td>
										<td>
											<input maxlength="80" size="15" tabindex="<?php echo $tab++ ?>" name="identificacion" value="<?php echo $registro[0][3] ?>"><br>	
										</td>
									</tr>
									<tr>
										<td colspan="2">
										<hr class="hr_division">
										</td>
									</tr><?php
									if($registro[0][6]>0)
									{
										$dia_nacimiento=date("j",$registro[0][6]);
										$mes_nacimiento=date("n",$registro[0][6]);
										$anno_nacimiento=date("Y",$registro[0][6]);
									}
									else
									{
										$dia_nacimiento="";
										$mes_nacimiento="";
										$anno_nacimiento="";
									}
									?><tr class="bloquecentralcuerpo">
										<td>
											<span onmouseover="<?php 
											$texto_ayuda="<b>Fecha de Nacimiento del Docente</b><br> ";
											$texto_ayuda.="Formato: dia/mes/año.";
											echo "this.T_WIDTH=250;return ayuda('".$texto_ayuda."')" ?>">
											Fecha de Nacimiento:
											</span>
										</td>
										<td>
											Dia: <input maxlength="2" size="3" tabindex="<?php echo $tab++ ?>" name="nacimiento_dia" value="<?php echo $dia_nacimiento ?>">
											Mes: <input maxlength="2" size="3" tabindex="<?php echo $tab++ ?>" name="nacimiento_mes" value="<?php echo $mes_nacimiento ?>">
											A&ntilde;o: <input maxlength="4" size="4" tabindex="<?php echo $tab++ ?>" name="nacimiento_anno" value="<?php echo $anno_nacimiento ?>">
										</td>
									</tr><?php
									if($registro[0][7]==1)
									{
										$masculino="checked";
										$femenino="";
										
									}
									else
									{
										if($registro[0][7]==2)
										{
											$masculino="";
											$femenino="checked";
										}
										else
										{
											$masculino="";
											$femenino="";
										}
									}
									?><tr class="bloquecentralcuerpo">
										<td>
											Sexo:
										</td>
										<td>
											Masculino: <input type="radio" tabindex="<?php echo $tab++ ?>" value="1" name="sexo" <?php echo $masculino ?>><br>	
											Femenino: <input type="radio" tabindex="<?php echo $tab++ ?>" value="2" name="sexo" <?php echo $femenino ?>><br>	
										</td>
									</tr>
									<tr class="bloquecentralcuerpo">
										<td>
											Correo Electr&oacute;nico:
										</td>
										<td>
											<input maxlength="80" size="30" tabindex="<?php echo $tab++ ?>" name="correo"><br>	
										</td>
									</tr>
									<tr class="bloquecentralcuerpo">
										<td>
											Tel&eacute;fono:
										</td>
										<td>
											<input maxlength="80" size="20" tabindex="<?php echo $tab++ ?>" name="telefono"><br>	
										</td>
									</tr>
									<tr>
										<td colspan="2" rowspan="1" align="center">
											<hr class="hr_division">
											<input type="hidden" name="action" value="registro_grupo">
											<input value="enviar" name="aceptar" type="submit">
										</td>
									</tr>	
								</table>
							</td>
						</tr>							
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form><?php
		}
	}
}



function mostrar_registro_grupo($configuracion,$tema,$accion)
{
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nombre, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.apellido, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.identificacion, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.correo, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.telefono, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nacimiento, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.sexo, ";
		$cadena_sql.=$configuracion["prefijo"]."tipo_identificacion.etiqueta ";		
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."profesor, "; 
		$cadena_sql.=$configuracion["prefijo"]."tipo_identificacion ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_grupo='".$_REQUEST['registro']."' ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?>
<table style="width: 100%; text-align: left;" align="center" cellpadding="0" cellspacing="0" >
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1">
					<tbody>
						<tr class="bloquecentralcuerpo">
							<td class="encabezado_principal">
								<b><?php echo $registro[0][0]." ".$registro[0][1] ?></b><hr class="hr_division">
							</td>
						</tr>
						<tr class="bloquecentralcuerpo">
							<td>
							<span class="texto_negrita">Identificaci&oacute;n: </span><?php echo $registro[0][7] ?> <?php echo $registro[0][2] ?>
							</td>
						</tr><?php
						if($registro[0][3]!="")
						{?><tr class="bloquecentralcuerpo">
							<td>
							<span class="texto_negrita">Correo Electr&oacute;nico: </span><?php echo $registro[0][3] ?>
							</td>
						</tr>
						<?php}
						if($registro[0][4]!="")
						{?><tr class="bloquecentralcuerpo">
							<td>
							<span class="texto_negrita">Tel&eacute;fono: </span><?php echo $registro[0][4] ?>
							</td>
						</tr>
						<?php}
						if($registro[0][5]>0)
						{?><tr class="bloquecentralcuerpo">
							<td>
							<span class="texto_negrita">Fecha de nacimiento: </span><?php echo date("d/m/Y",$registro[0][5]) ?>
							</td>
						</tr>
						<?php}
						if($registro[0][6]==1)
						{?><tr class="bloquecentralcuerpo">
							<td>
							<span class="texto_negrita">Sexo: </span>Masculino
							</td>
						</tr>
						<?php}
						else
						{
							if($registro[0][6]==2)
							{
						?><tr class="bloquecentralcuerpo">
							<td>
							<span class="texto_negrita">Sexo: </span>Femenino
							</td>
						</tr>
						<?php	}
						}
					?></tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<?php
		}
	}	
}

function mostrar_corto_grupo($configuracion,$tema)
{
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.nombre, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.apellido, ";
		$cadena_sql.=$configuracion["prefijo"]."profesor.correo ";
		$cadena_sql.="FROM ";
		$cadena_sql.=$configuracion["prefijo"]."profesor "; 
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_grupo=".$_REQUEST['registro']." ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?>
<table style="width: 100%; text-align: left;" align="center" cellpadding="0" cellspacing="0" >
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table style="width: 100%; text-align: left;" border="0" cellpadding="3" cellspacing="0">
					<tbody>
						<tr class="bloquelateralcuerpo2">
							<td>
								<span class="texto_color"><?php 
								$convertir=new cadenas();
								
								echo $convertir->convertir_a_mayusculas($registro[0][0]." ".$registro[0][1]) ?></span>
							</td>
						</tr><?php
						if($registro[0][2]!="")
						{?><tr class="texto_pequenno">
							<td>
							<span class="texto_negrita">Correo Electr&oacute;nico: </span><?php echo $registro[0][2] ?>
							</td>
						</tr><?php
						}
					?></tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<hr class="hr_division">
<?php
		}
	}	
}