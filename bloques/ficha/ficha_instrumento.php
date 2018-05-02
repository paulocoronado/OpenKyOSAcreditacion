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
?><?php  
/****************************************************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*******************************************************************************************************************
* @subpackage   ficha_autor
* @package	bloques/ficha
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



	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT ";
		$cadena_sql.="`id_instrumento` , ";
		$cadena_sql.="`fecha_creacion` , ";
		$cadena_sql.="`id_usuario` , ";
		$cadena_sql.="`nombre` , ";
		$cadena_sql.="`entidad_responsable` , ";
		$cadena_sql.="`presentacion` , ";
		$cadena_sql.="`comentario` , ";
		$cadena_sql.="`archivo_base` , ";
		$cadena_sql.="`estado`, ";
		$cadena_sql.="`etiqueta` ";
		$cadena_sql.="FROM ";
		$cadena_sql.="`".$configuracion["prefijo"]."instrumento` ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_instrumento=".$_GET["registro"]." ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			
?>
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="700px">
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <table style="width: 100%; text-align: left;" border="0" cellpadding="4" cellspacing="0">
        <tbody>
            <tr>
              <td width="70%"></td>
              <td width="5%" class="bloquecentralencabezado"></td>	
              <td class="bloquecentralencabezado">Ficha del Instrumento</td>
            </tr>
        </tbody>
        </table>
        <table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1">
          <tbody>
        <tr class="bloquecentralcuerpo" >
                <td colspan="2">
                <h2><?php   echo $registro[0][3]; ?></h2>
                </td>                
        </tr>
        <?php   if($registro[0][9]!="")
        	{?>
	<tr  class="bloquecentralcuerpo">
              <td colspan="2">
              <?php   echo $registro[0][9]; ?>
              </td>
        </tr><?php  
        	} 
        	if($registro[0][5]!="")
        	{?>
	<tr  class="bloquecentralcuerpo">
              <td colspan="2">
              <?php   echo $registro[0][5]; ?>
              </td>
        </tr><?php  
        	}
        	if($registro[0][6]!="")
        	{?>
	<tr  class="bloquecentralcuerpo" align="left">
              <td colspan="2">
              <b>Comentario</b>
              </td>
        </tr>
	<tr  class="bloquecentralcuerpo">
              <td colspan="2">
              <?php   echo $registro[0][6]; ?>
              </td>
        </tr><?php  
        	}?>
        	<tr  class="bloquecentralcuerpo" align="left">
              <td align="center" colspan="2">
              <hr>
              </td>
        </tr><?php   if($registro[0][4]!="")
        	{?>
	<tr  class="bloquecentralcuerpo" align="left">
              <td align="left" width="30%">
              <b>Entidad responsable: </b>
              </td>
              <td>
              <?php   echo $registro[0][4]; ?>
              </td>
        </tr><?php  
        	}
        	?>
	<tr  class="bloquecentralcuerpo" >
              <td align="left" width="30%">
              <b>Creado el: </b>
              </td>
              <td align="left">
              <?php   echo date("d-m-Y",$registro[0][1]); ?>
              </td>
        </tr>
        <tr  class="bloquecentralcuerpo" >
              <td align="left" width="30%">
              <b>C&oacute;digo Interno: </b>
              </td>
              <td align="left">
              <b><?php   echo $registro[0][0]; ?></b>
              </td>
        </tr>
        <tr  class="bloquecentralcuerpo" >
              <td align="left" width="30%">
              <b>Correo del autor: </b>
              </td>
              <td align="left"><?php   
              	$cadena_sql="SELECT ";
		$cadena_sql.="`correo` ";
		$cadena_sql.="FROM ";
		$cadena_sql.="`".$configuracion["prefijo"]."registrado` ";
		$cadena_sql.="WHERE ";
		$cadena_sql.="id_usuario=".$registro[0][2]." ";
		$cadena_sql.="LIMIT 1";
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$este_usuario=$acceso_db->obtener_registro_db();
		$usuario=$acceso_db->obtener_conteo_db();
		if($usuario>0)
		{
                    echo "<A HREF='mailto:".$este_usuario[0][0]."'>".$este_usuario[0][0]."</A>";                    
                }
                else
                {
                    "No disponible.";	
                }
                unset($este_usuario);     
            ?></td>
        </tr>
        </tbody>
        </table>
        <br>
        </td>
      </tr>
    </tbody>
  </table>
<?php  		}
}
?>
