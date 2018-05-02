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
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 29 de Marzo de 2007

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario para el registro de un archivo de bloques
* @usage        
*******************************************************************************/ 
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

$formulario="registro_lote_clave";
$verificar="control_vacio(".$formulario.",'archivo')";

include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");

registrar_lote_clave($configuracion,$tema,$fila,$tab,$formulario,$verificar);

/*==========================================================*/
/*                    Funciones                             */
/*==========================================================*/

function registrar_lote_clave($configuracion,$tema,$fila,$tab,$formulario,$verificar)
{	
?><script src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method="POST" action="index.php" name="<?php echo $formulario?>" onsubmit="">
<table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table style="width: 100%; text-align: left;" border="0" cellpadding="6" cellspacing="0">
					<tr class="bloquecentralcuerpo">
						<td colspan="2" rowspan="1">
							<span class="encabezado_normal">Envio de Claves a correos</span>
							<hr class="hr_division">
						</td>		
					</tr>	
					<tr class="bloquecentralcuerpo">
						<td>
							<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
								<tr class="bloquecentralcuerpo">
									<td>
										Archivo
									</td>
									<td>
										<input type="file" name="archivo" tabindex="<?php echo $tab++ ?>">
									</td>
								</tr>
								<tr class="bloquecentralcuerpo">
									<td colspan="2">
										<hr class="hr_division">
									</td>									
								</tr>							
								<tr align="center">
									<td colspan="2">
										<table width="80%" align="center" border="0">
											<tr>
												<td align="center">
													<input type="hidden" name="action" value="registro_lote_clave">
													<img  src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_aceptar.png" alt="Aceptar" title="Aceptar" border="0" onclick="return(<?php echo $verificar; ?>)?document.forms['<?php echo $formulario?>'].submit():false"/>
												</td>
												<td align="center"><?php
												$pagina="administrador";
												$variables="";
												
												?>	<img  src="<?php echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/boton_cancelar.png" alt="Cancelar la operaci&oacute;n" title="Cancelar la operaci&oacute;n" border="0" tabindex='<?php echo $tab++ ?>' onclick="location.replace('<?php echo $configuracion["host"].$configuracion["site"]."/index.php?page=".enlace($pagina).$variables ?>')">
												</td>
											</tr>
										</table>	
									</td>
								</tr>	
							</table>
						</td>	
					</tr>									
				</table>
			</td>
		</tr>							
	</tbody>
</table>
</form><?php	
}

?>
