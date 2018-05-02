<?php
/*
############################################################################
#                                                                         #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/****************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2007

Última revisión 1 de Mayo de 2007

*******************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de programas
* @usage        
***********************************************************************************/
?><?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

$el_estilo=$this->estilo;

include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");

if(isset($_GET['opcion']))
{
	$accion=$_GET['opcion'];
}
else
{
	$accion="nuevo";
}


if($accion=="editar")
{
	editar_registro($configuracion,$tema,$el_estilo);
}
else
{
	if($accion=="nuevo")
		{
			nuevo_registro($configuracion,$tema,$el_estilo);
		
		}
}

/*******************************************************************
*                      Funciones                                   *
********************************************************************/
/*===============================================*/
/*              Editar Registro                  */
/*===============================================*/

function editar_registro($configuracion,$tema,$estilo)
{
	$tab=1;
	$contador=0;
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="`id_programa`, ";
		$cadena_sql.="`id_facultad`, ";
		$cadena_sql.="`nombre`, ";
		$cadena_sql.="`icfes`, ";
		$cadena_sql.="`mision`, ";
		$cadena_sql.="`vision`, ";
		$cadena_sql.="`institucion`, ";
		$cadena_sql.="`norma`, ";
		$cadena_sql.="`duracion`, ";
		$cadena_sql.="`jornada`, ";
		$cadena_sql.="`modalidad`, ";
		$cadena_sql.="`nivel`, ";
		$cadena_sql.="`fecha_registro`, ";
		$cadena_sql.="`titulo`, ";
		$cadena_sql.="`periodicidad`, ";
		$cadena_sql.="`localidad`, ";
		$cadena_sql.="`semanas_semestre`, ";
		$cadena_sql.="`correo`, ";
		$cadena_sql.="`nombre_corto`, ";
		$cadena_sql.="`codigo`, ";
		$cadena_sql.="`director` ";
		$cadena_sql.="FROM ";
		$cadena_sql.="".$configuracion["prefijo"]."programa "; 
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_programa=".desenlace($_GET['registro']);
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_dir_programa'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<table align='center' width='100%' cellpadding='7' cellspacing='1'>
				<tr class="bloquelateralencabezado">
					<td colspan="2" rowspan="1">
						::.. Informaci&oacute;n B&aacute;sica del Programa Acad&eacute;mico
					</td>		
				</tr>	
				<tr class='bloquecentralcuerpo'>
					<td>
						Instituci&oacute;n:
					</td>
					<td>
						<input type='text' name='institucion' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' value='<?php echo $registro[0][6] ?>'>
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Nombre Completo registrado ante el ICFES.</b>";
					?>	<span onmouseover="return escape('<?php echo $texto_ayuda?>')" class="texto_negrita">Nombre:</span>
					</td>
					<td>
						<input type='hidden' name='id_programa' value='<?php echo $registro[0][0] ?>'>
						<input type='hidden' name='id_facultad' value='<?php echo $registro[0][1] ?>'>
						<input type='text' name='nombre' value='<?php echo $registro[0][2] ?>' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Ingrese un nombre de no m&aacute;s de 20 caracteres.</b> ";
						$texto_ayuda.="Con el que identifique al programa en las listas desplegables.<br>";
						$texto_ayuda.="En la generaci&oacute;n de informes se utiliza el nombre completo registrado ante el ICFES.";
					?>	<span onmouseover="return escape('<?php echo $texto_ayuda?>')">Nombre Corto:</span>
					</td>
					<td>
						<input type='text' name='nombre_corto' value='<?php echo $registro[0][18] ?>' size='20' maxlength='20' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>N&uacute;mero de registro ICFES del programa.</b> ";
						$texto_ayuda.="Usualmente corresponde al registro en el SNIES.<br>";
					?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Registro ICFES:</span>
					</td>
					<td>
						<input type='text' name='icfes' value='<?php echo $registro[0][3] ?>' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>	
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Fecha de registro del programa por parte del ICFES.</b><br> ";
						$texto_ayuda.="Ingrese la fecha en formato: dd/mm/aaaa.<br>";
					?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Fecha Registro:</span>
					</td>
					<td>
						<input type='text' name='fecha_registro' value='<?php echo $registro[0][12] ?>' size='12' maxlength='25' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>	
				<tr class='bloquecentralcuerpo'>
					<td colspan="2" align="left"><?php
						$texto_ayuda="<b>Visi&oacute;n actualizada del programa.</b>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')" class="texto_negrita">Visi&oacute;n:</span><hr class="hr_division">
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td colspan="2">
						<table align="center">
							<tr>
								<td>
								<textarea id='vision' name='vision' cols='50' rows='2' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][5] ?></textarea>
								<script type="text/javascript">
									mis_botones='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/';
									archivo_css='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/".$estilo."/estilo.php" ?>';
									editor_html('vision', 'bold italic underline | left center right | number bullet |');
								</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>	
				<tr class='bloquecentralcuerpo'>
					<td colspan="2" align="left"><?php
						$texto_ayuda="<b>Misi&oacute;n actualizada del programa.</b>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')" class="texto_negrita">Misi&oacute;n:</span><hr class="hr_division">
					</td>
				</tr>	
				<tr class='bloquecentralcuerpo'>		
					<td colspan="2" align="center">
						<table align="center">
							<tr>
								<td>
									<textarea id='mision' name='mision' cols='50' rows='5' tabindex='<?php echo $tab++ ?>' ><?php echo $registro[0][4] ?></textarea>
									<script type="text/javascript">
										mis_botones='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/';
										archivo_css='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/".$estilo."/estilo.php" ?>';
										editor_html('mision', 'bold italic underline | left center right |');
									</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>	
				<tr>
					<td colspan="2">
					<hr class="hr_division">
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Norma Interna por la cual se crea el programa.</b><br>";
						$texto_ayuda.="Ingrese n&uacute;mero, fecha y &oacute;rgano que la expide.";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Norma de Creaci&oacute;n:</span>
					</td>
					<td>
						<input type='text' name='norma' value='<?php echo $registro[0][7] ?>' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>		
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>C&oacute;digo Interno</b><br>";
						$texto_ayuda.="Con el cual se identifica al programa dentro de la instituci&oacute;n.";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">C&oacute;digo Interno:</span>
					</td>
					<td>
						<input type='text' name='codigo' value='<?php echo $registro[0][19] ?>' size='5' maxlength='5' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>	
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Nombre de los periodos en que se divide el programa.</b><br>";
						$texto_ayuda.="Usualmente se expresa en t&eacute;rminos de tiempo. Ejemplo: ";
						$texto_ayuda.="<b>Bimestre, Trimestre, Semestre, A&ntilde;o,etc.</b> ";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Periodicidad:</span>
					</td>
					<td>
						<input type='text' name='periodicidad' value='<?php echo $registro[0][14] ?>' size='30' maxlength='50' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>	
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>N&uacute;mero de semanas que componen un periodo.</b>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Semanas:</span>
					</td>
					<td>
						<input type='text' name='semanas_semestre' value='<?php echo $registro[0][16] ?>' size='3' maxlength='3' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>N&uacute;mero de periodos que componen el plan de estudios.</b>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Duraci&oacute;n:<br></span>
					</td>
					<td>
						<input type='text' name='duracion' value='<?php echo $registro[0][8] ?>' size='5' maxlength='5' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Jornada en que se desarrolla el plan de estudios.</b><br>";
						$texto_ayuda.="Corresponde a la jornada aprobada por el ICFES y puede ser entre otras:<b>Diurna, nocturna</b>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Jornada:</span>
					</td>
					<td>
						<input type='text' name='jornada' value='<?php echo $registro[0][9] ?>' size='40' maxlength='50' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Modalidad en la que se dicta el plan de estudios.</b><br>";
						$texto_ayuda.="Corresponde a la modalidad aprobada por el ICFES y puede ser entre otras:<b>Presencial, semi presencial, a distancia.</b>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Modalidad:</span>
					</td>
					<td>
						<input type='text' name='modalidad' value='<?php echo $registro[0][10] ?>' size='40' maxlength='50' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Nivel acad&eacute;mico del programa.</b><br>";
						$texto_ayuda.="Corresponde al aprobado por el ICFES y puede ser entre otros:<b> Tecnolog&iacute;a, Pregrado, Especializaci&oacute;n, Maestr&iacute;a, Doctorado.</b>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Nivel:</span>
					</td>
					<td>
						<input type='text' name='nivel' value='<?php echo $registro[0][11] ?>' size='40' maxlength='50' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>T&iacute;tulo que otorga el programa.</b><br>";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">T&iacute;tulo:</span>
					</td>
					<td>
						<input type='text' name='titulo' value='<?php echo $registro[0][13] ?>' size='40' maxlength='200' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Sitio donde se dicta el programa.</b><br>";
						$texto_ayuda.="Ciudad y departamento donde est&aacute; aprobado que se imparta el programa.";
						?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Localizaci&oacute;n:</span>
					</td>
					<td>
						<input type='text' name='localidad' value='<?php echo $registro[0][15] ?>' size='40' maxlength='100' tabindex='<?php echo $tab++ ?>' value="Bogot&aacute;. D.C.">
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<hr class="hr_division">
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Apellidos y Nombres Completos.</b><br>";
						$texto_ayuda.="Del coordinador actual del proyecto curricular o programa acad&eacute;dico.";
						?><span class="texto_negrita" onmouseover="return escape('<?php echo $texto_ayuda?>')">Coordinador:</span>
					</td>
					<td>
						<input type='text' name='director' value='<?php echo $registro[0][20] ?>' size='40' maxlength='255' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr class='bloquecentralcuerpo'>
					<td><?php
						$texto_ayuda="<b>Correo Electr&oacute;nico.</b><br>";
						$texto_ayuda.="E- mail institucional del Proyecto Curricular o Programa Acad&eacute;mico. ";
						$texto_ayuda.="Dejar en blanco si no se tiene uno con dominio educativo.";
						?><span class="texto_negrita" onmouseover="return escape('<?php echo $texto_ayuda?>')">Correo Electr&oacute;nico:</span>
					</td>
					<td>
						<input type='text' name='correo' value='<?php echo $registro[0][17] ?>' size='40' maxlength='100' tabindex='<?php echo $tab++ ?>' >
					</td>
				</tr>
				<tr align='center'>
					<td colspan='2' rowspan='1'>
						<input type='hidden' name='usuario' value='<?php echo $_GET["usuario"] ?>'>
						<input type='hidden' name='action' value='registro_admin_programa'>
						<input name='aceptar' value='Aceptar' type='submit'><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form><?php
		
		}
	
	
	}
}



/*===============================================*/
/*              Nuevo Registro                    */
/*===============================================*/
function nuevo_registro($configuracion,$tema,$estilo)
{
$tab=1;
$contador=0;
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method='POST' action='index.php' name='registro_dir_programa'>
<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table align='center' width='100%' cellpadding='7' cellspacing='1'>
	<tr class="bloquelateralencabezado">
		<td colspan="2" rowspan="1">
			::.. Informaci&oacute;n B&aacute;sica del Programa Acad&eacute;mico
		</td>		
	</tr>	
	<tr class='bloquecentralcuerpo'>
		<td>
			Instituci&oacute;n:
		</td>
		<td>
			<input type='text' name='institucion' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' value="Universidad Distrital Francisco Jos&eacute; de Caldas">
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Nombre Completo registrado ante el ICFES.</b>";
		?>	<span onmouseover="return escape('<?php echo $texto_ayuda?>')" class="texto_negrita">Nombre:</span>
		</td>
		<td>
			<input type='hidden' name='id_facultad' value='0' >
			<input type='text' name='nombre' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Ingrese un nombre de no m&aacute;s de 20 caracteres.</b> ";
			$texto_ayuda.="Con el que identifique al programa en las listas desplegables.<br>";
			$texto_ayuda.="En la generaci&oacute;n de informes se utiliza el nombre completo registrado ante el ICFES.";
		?>	<span onmouseover="return escape('<?php echo $texto_ayuda?>')">Nombre Corto:</span>
		</td>
		<td>
			<input type='text' name='nombre_corto' size='20' maxlength='20' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>N&uacute;mero de registro ICFES del programa.</b> ";
			$texto_ayuda.="Usualmente corresponde al registro en el SNIES.<br>";
		?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Registro ICFES:</span>
		</td>
		<td>
			<input type='text' name='icfes' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>	
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Fecha de registro del programa por parte del ICFES.</b><br> ";
			$texto_ayuda.="Ingrese la fecha en formato: dd/mm/aaaa.<br>";
		?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Fecha Registro:</span>
		</td>
		<td>
			<input type='text' name='fecha_registro' size='12' maxlength='12' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td colspan="2" align="left"><?php
			$texto_ayuda="<b>Visi&oacute;n actualizada del programa.</b>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')" class="texto_negrita">Visi&oacute;n:</span><hr class="hr_division">
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td colspan="2">
			<table align="center">
				<tr>
					<td>
					<textarea id='vision' name='vision' cols='50' rows='2' tabindex='<?php echo $tab++ ?>' ></textarea>
					<script type="text/javascript">
						mis_botones='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/';
						archivo_css='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/".$estilo."/estilo.php" ?>';
						editor_html('vision', 'bold italic underline | left center right | number bullet |');
					</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr class='bloquecentralcuerpo'>
		<td colspan="2" align="left"><?php
			$texto_ayuda="<b>Misi&oacute;n actualizada del programa.</b>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')" class="texto_negrita">Misi&oacute;n:</span><hr class="hr_division">
		</td>
	</tr>	
	<tr class='bloquecentralcuerpo'>		
		<td colspan="2" align="center">
			<table align="center">
				<tr>
					<td>
						<textarea id='mision' name='mision' cols='50' rows='5' tabindex='<?php echo $tab++ ?>' ></textarea>
						<script type="text/javascript">
							mis_botones='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/';
							archivo_css='<?php echo $configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/".$estilo."/estilo.php" ?>';
							editor_html('mision', 'bold italic underline | left center right |');
						</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<hr class="hr_division">
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Norma Interna por la cual se crea el programa.</b><br>";
			$texto_ayuda.="Ingrese n&uacute;mero, fecha y &oacute;rgano que la expide.";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Norma de Creaci&oacute;n:</span>
		</td>
		<td>
			<input type='text' name='norma' size='40' maxlength='250' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>		
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>C&oacute;digo Interno</b><br>";
			$texto_ayuda.="Con el cual se identifica al programa dentro de la instituci&oacute;n.";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">C&oacute;digo Interno:</span>
		</td>
		<td>
			<input type='text' name='codigo' size='5' maxlength='5' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>	
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Nombre de los periodos en que se divide el programa.</b><br>";
			$texto_ayuda.="Usualmente se expresa en t&eacute;rminos de tiempo. Ejemplo: ";
			$texto_ayuda.="<b>Bimestre, Trimestre, Semestre, A&ntilde;o,etc.</b> ";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Periodicidad:</span>
		</td>
		<td>
			<input type='text' name='periodicidad' size='30' maxlength='50' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>	
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>N&uacute;mero de semanas que componen un periodo.</b>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Semanas:</span>
		</td>
		<td>
			<input type='text' name='semanas_semestre' size='3' maxlength='3' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>N&uacute;mero de periodos que componen el plan de estudios.</b>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Duraci&oacute;n:<br></span>
		</td>
		<td>
			<input type='text' name='duracion' size='5' maxlength='5' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Jornada en que se desarrolla el plan de estudios.</b><br>";
			$texto_ayuda.="Corresponde a la jornada aprobada por el ICFES y puede ser entre otras:<b>Diurna, nocturna</b>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Jornada:</span>
		</td>
		<td>
			<input type='text' name='jornada' size='40' maxlength='50' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Modalidad en la que se dicta el plan de estudios.</b><br>";
			$texto_ayuda.="Corresponde a la modalidad aprobada por el ICFES y puede ser entre otras:<b>Presencial, semi presencial, a distancia.</b>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Modalidad:</span>
		</td>
		<td>
			<input type='text' name='modalidad' size='40' maxlength='50' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Nivel acad&eacute;mico del programa.</b><br>";
			$texto_ayuda.="Corresponde al aprobado por el ICFES y puede ser entre otros:<b> Tecnolog&iacute;a, Pregrado, Especializaci&oacute;n, Maestr&iacute;a, Doctorado.</b>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Nivel:</span>
		</td>
		<td>
			<input type='text' name='nivel' size='40' maxlength='50' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>T&iacute;tulo que otorga el programa.</b><br>";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">T&iacute;tulo:</span>
		</td>
		<td>
			<input type='text' name='titulo' size='40' maxlength='200' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Sitio donde se dicta el programa.</b><br>";
			$texto_ayuda.="Ciudad y departamento donde est&aacute; aprobado que se imparta el programa.";
			?><span onmouseover="return escape('<?php echo $texto_ayuda?>')">Localidad:</span>
		</td>
		<td>
			<input type='text' name='localidad' size='40' maxlength='100' tabindex='<?php echo $tab++ ?>' value="Bogot&aacute;. D.C.">
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<hr class="hr_division">
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Nombre Completo.</b><br>";
			$texto_ayuda.="Del coordinador actual del proyecto curricular o programa acad&eacute;dico.";
			?><span class="texto_negrita" onmouseover="return escape('<?php echo $texto_ayuda?>')">Coordinador:</span>
		</td>
		<td>
			<input type='text' name='director' size='40' maxlength='255' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr class='bloquecentralcuerpo'>
		<td><?php
			$texto_ayuda="<b>Correo Electr&oacute;nico.</b><br>";
			$texto_ayuda.="E- mail institucional del Proyecto Curricular o Programa Acad&eacute;mico. ";
			$texto_ayuda.="Dejar en blanco si no se tiene uno con dominio educativo.";
			?><span class="texto_negrita" onmouseover="return escape('<?php echo $texto_ayuda?>')">Correo Electr&oacute;nico:</span>
		</td>
		<td>
			<input type='text' name='correo' size='40' maxlength='100' tabindex='<?php echo $tab++ ?>' >
		</td>
	</tr>
	<tr align='center'>
		<td colspan='2' rowspan='1'>
			<input type='hidden' name='action' value='registro_admin_programa'>
			<input name='aceptar' value='Aceptar' type='submit'><br>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</form>
<?php



}



?>