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
include($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
$tab=1;
if(isset($_GET['registro']))
{

	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	
	if (is_resource($enlace))
	{
		//Si el valor es negativo indica que se quiere editar los valores del usuario 
		//actualmente registrado en el sistema
		if($_GET['registro']<0)
		{
		
			$nueva_sesion=new sesiones($configuracion);
			$nueva_sesion->especificar_enlace($enlace);
			$esta_sesion=$nueva_sesion->numero_sesion();
			//Rescatar el valor de la variable usuario de la sesion
			$registro=$nueva_sesion->rescatar_valor_sesion($configuracion,"id_usuario");
			if($registro)
			{
				$el_usuario=$registro[0][0];
				
				$cadena_sql="SELECT ";
				$cadena_sql.="nombre,";
				$cadena_sql.="apellido,";
				$cadena_sql.="correo,";
				$cadena_sql.="usuario,";
				$cadena_sql.="telefono,";
				$cadena_sql.="clave,";
				$cadena_sql.="tipo,";
				$cadena_sql.="estado,";
				$cadena_sql.="id_usuario ";
				$cadena_sql.="FROM ";
				$cadena_sql.="".$configuracion["prefijo"]."registrado ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_usuario=".$el_usuario." ";
				$cadena_sql.="LIMIT 1";
			}
			

		}
		else
		{
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre,";
			$cadena_sql.="apellido,";
			$cadena_sql.="correo,";
			$cadena_sql.="usuario,";
			$cadena_sql.="telefono,";
			$cadena_sql.="clave,";
			$cadena_sql.="tipo,";
			$cadena_sql.="estado,";
			$cadena_sql.="id_usuario ";
			$cadena_sql.="FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."registrado ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_usuario=".$_GET["registro"]." ";
			$cadena_sql.=" LIMIT 1";
		}
		
		
		//echo $cadena_sql;
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$campos=$acceso_db->obtener_conteo_db();
		if($campos>0)
		{
			$fila=0;			
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_usuario" onsubmit="return (  control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'correo') && control_vacio(this,'usuario') && control_vacio(this,'clave') && comparar_contenido(this,'clave','clave_2') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'clave',5) && longitud_cadena(this,'usuario',4) && verificar_correo(this,'correo'))" >
<table WIDTH="100%" CELLPADDING=0 CELLSPACING=0 class="bloquelateral" align="center">
<tbody>
<tr>
<td align="center" valign="middle">
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1" >
<tbody>
<tr class="bloquecentralencabezado">
<td colspan="2" rowspan="1">Edici&oacute;n de Registro de Usuario:</td>
</tr>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td width="30%" bgcolor="<?PHP   echo $tema->celda ?>"><font color="red">*</font>Nombres:<br>
</td>
<td style="background-color: rgb(239, 239, 239);"><input maxlength="80" size="40" tabindex="<?PHP   echo $tab++; ?>" name="nombre" value="<?PHP   echo $registro[0][0]?>"><br>
</td>
</tr>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>"><font color="red">*</font>Apellidos:<br>
</td>
<td style="background-color: rgb(239, 239, 239);">
<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++; ?>" name="apellido" value="<?PHP   echo $registro[0][1]?>"> </td>
</tr>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>"><font color="red">*</font>Correo Electr&oacute;nico:<br>
</td>
<td style="background-color: rgb(239, 239, 239);">
<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++; ?>" name="correo" value="<?PHP   echo $registro[0][2] ?>">
</td>
</tr>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>">Tel&eacute;fono:<br>
</td>
<td style="background-color: rgb(239, 239, 239);">
<input maxlength="50" size="30" tabindex="<?PHP   echo $tab++; ?>" name="telefono" value="<?PHP   echo $registro[0][4]?>">
</td>
</tr>
</tbody>
</table>
<br>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
<tbody>
<tr>
<td class="bloquecentralencabezado" colspan="2" rowspan="1" >Datos para la autenticaci&oacute;n:</td>
</tr>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this,<?PHP   echo $fila;  ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td width="30%" bgcolor="<?PHP   echo $tema->celda ?>"><font color="red">*</font>Usuario:<br>
</td>
<td style="background-color: rgb(239, 239, 239);">
<input type="hidden" name="usuario" value="<?PHP   echo $registro[0][3]?>"><b><?PHP   echo $registro[0][3]?></b>
</td>
</tr>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>"><font color="red">*</font>Clave: </td>
<td style="background-color: rgb(239, 239, 239);"><input
maxlength="50" size="30" tabindex="<?PHP   echo $tab++; ?>" name="clave"  type="password" value="9685100f3e2efb32ccfe19405de05901"> </td>
</tr>
<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
<td bgcolor="<?PHP   echo $tema->celda ?>">
<font color="red">*</font>Reescriba la clave:<br>
</td>
<td style="background-color: rgb(239, 239, 239);">
<input maxlength="50" size="30" tabindex="<?PHP   echo $tab++; ?>" name="clave_2" type="password" value="9685100f3e2efb32ccfe19405de05901">
</td>
</tr>
<tr class="bloquecentralcuerpo">
<td bgcolor="<?PHP   echo $tema->celda ?>"><font color="red">*</font>Roles:<br>
</td>
<td style="background-color: rgb(239, 239, 239);">
<?PHP   
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();
$busqueda="SELECT id_usuario,nombre FROM ".$configuracion["prefijo"]."tipo_usuario ORDER BY id_usuario";
$mi_cuadro=$html->cuadro_lista($busqueda,'nivel_acceso',$configuracion,$registro[0][6],0,FALSE,$tab++);
echo $mi_cuadro;
?><br>
</td>
</tr>
<tr align="center" class="bloquecentralcuerpo">
<td colspan="2" rowspan="1" align="center">
<input type="hidden" name="action" value="registro_usuario"><br>
<input value="enviar" name="aceptar" type="submit"><br>
<?PHP  
//Como se esta editando se colocan todos los valores enviados por GET.
reset ($_GET);
while (list ($clave, $val) = each ($_GET)) 
{
	
	if($clave!='page')
	{
		$variable="<input type='hidden' name='".$clave."' value='".$val."'>\n";
		echo $variable;
		//echo $clave;
	}
}
?>
</td>
</tr>
<tr class="bloquecentralcuerpo">
<td colspan="2" rowspan="1">
Los campos marcados con <font color="red">*</font> deben ser diligenciados obligatoriamente.<br><br>
</td>
</tr>
</tbody>
</table>
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
if(isset($_POST["nombre"])) {
$fila=0;

?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_usuario" onsubmit="return (  control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'correo') && control_vacio(this,'usuario') && control_vacio(this,'clave') && comparar_contenido(this,'clave','clave_2') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'clave',5) && longitud_cadena(this,'usuario',4) && verificar_correo(this,'correo'))" >
<table WIDTH="100%" CELLPADDING=0 CELLSPACING=0 class="bloquelateral" align="center">
<tbody>
	<tr>
		<td align="center" valign="middle">
			<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1" >
			<tbody>
				<tr class="bloquecentralencabezado">
					<td colspan="2" rowspan="1">Registro para usuarios nuevos:</td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td width="30%" bgcolor="<?PHP   echo $tema->celda ?>">
						<font color="red">*</font>Nombres:<br>
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++ ?>" name="nombre" value="<?PHP   echo $_POST["nombre"]?>"><br>
					</td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<font color="red">*</font>Apellidos:<br>
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++ ?>" name="apellido" value="<?PHP   echo $_POST["apellido"]?>">
					</td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<font color="red">*</font>Correo Electr&oacute;nico:<br>
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++ ?>" name="correo"<?PHP  
						
						if(isset($_POST["correo"]))
						{
							echo 'value="'.$_POST["correo"].'"';
						}
						else
						{
						
							echo 'style="color: #ff0000;" value="El correo electr&oacute;nico ya est&aacute; registrado" onfocus="value=\'\'"';
						}
					?>></td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						Tel&eacute;fono:<br>
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<input	maxlength="50" size="30" tabindex="<?PHP   echo $tab++ ?>" name="telefono" value="<?PHP   echo $_POST["telefono"]?>">
					</td>
				</tr>
			</tbody>
			</table>
			<br>
			<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
			<tbody>
				<tr>
					<td class="bloquecentralencabezado" colspan="2" rowspan="1">
						Datos para la autenticaci&oacute;n:
					</td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<font color="red">*</font>Usuario:<br>
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
					<?PHP  
						if(isset($_POST["usuario"]))
						{
							echo '<input maxlength="50" size="30" tabindex="'.$tab++.'" name="usuario" value="'.$_POST["usuario"].'">';
						}
						else
						{
							echo '<input style="color: #ff0000;"" onfocus="value=\'\'" maxlength="50" size="30" tabindex="'.$tab++.'" name="usuario" value="El usuario ya existe en el sistema">';
						}
					
					?></td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<font color="red">*</font>Clave: 
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<input maxlength="50" size="30" tabindex="<?PHP   echo $tab++ ?>" name="clave"  type="password">
					</td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<font color="red">*</font>Reescriba la clave:<br>
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<input	maxlength="50" size="30" tabindex="<?PHP   echo $tab++ ?>" name="clave_2" type="password">
					</td>
				</tr>
				<tr class="bloquecentralcuerpo">
					<td bgcolor="<?PHP   echo $tema->celda ?>">
						<font color="red">*</font>Roles:<br>
					</td>
					<td bgcolor="<?PHP   echo $tema->celda ?>">
					<?PHP  
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
		$html=new html();
		$busqueda="SELECT id_usuario,nombre FROM ".$configuracion["prefijo"]."tipo_usuario ORDER BY id_usuario";
		$mi_cuadro=$html->cuadro_lista($busqueda,'nivel_acceso',$configuracion,-1,0,FALSE,$tab++);
		echo $mi_cuadro;
		?><br>
					</td>
				</tr>
				<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
					<td colspan="2" rowspan="1" align="center">
					<input type="hidden" name="action" value="registro_usuario"><br>
					<input value="enviar" name="aceptar" type="submit"><br>
					</td>
				</tr>
				<tr class="bloquecentralcuerpo">
					<td colspan="2" rowspan="1">
						Los campos marcados con <font color="red">*</font> deben ser diligenciados obligatoriamente.<br><br>
					</td>
				</tr>
			</tbody>
			</table>
		</td>
	</tr>
</tbody>
</table>
</form>
<?PHP  
}
else
{
$fila=0;
?><script src="<?PHP   echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="registrar_usuario" onsubmit="return (  control_vacio(this,'nombre') && control_vacio(this,'apellido') && control_vacio(this,'correo') && control_vacio(this,'usuario') && control_vacio(this,'clave') && comparar_contenido(this,'clave','clave_2') && longitud_cadena(this,'nombre',3) && longitud_cadena(this,'apellido',3) && longitud_cadena(this,'clave',5) && longitud_cadena(this,'usuario',4) && verificar_correo(this,'correo'))" >
<?PHP  
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	if(desenlace($_GET["page"])=="registro_usuario")
	{
?><table WIDTH="500px" CELLPADDING=0 CELLSPACING=0 class="bloquelateral" align="center"><?PHP  
	}
	else
	{
?><table WIDTH="100%" CELLPADDING=0 CELLSPACING=0 class="bloquelateral" align="center"><?PHP  
	}
?>
<tbody>
<tr>
<td align="center" valign="middle">
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1">
<tbody>
	<tr class="bloquecentralencabezado">
		<td colspan="2" rowspan="1">Registro para usuarios nuevos:</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<font color="red">*</font>Nombres:<br>
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++ ?>" name="nombre"><br>
		</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<font color="red">*</font>Apellidos:<br>
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++ ?>" name="apellido">
		</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<font color="red">*</font>Correo Electr&oacute;nico:<br>
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<input maxlength="80" size="40" tabindex="<?PHP   echo $tab++ ?>" name="correo">
		</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			Tel&eacute;fono:<br>
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<input maxlength="50" size="30" tabindex="<?PHP   echo $tab++ ?>" name="telefono">
		</td>
	</tr>
</tbody>
</table>
<br>
<table style="width: 100%; text-align: left;" border="0" cellpadding="2" cellspacing="1" >
<tbody>
	<tr>
		<td class="bloquecentralencabezado" colspan="2" rowspan="1">
			Datos para la autenticaci&oacute;n:
		</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<font color="red">*</font>Usuario:<br>
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<input maxlength="50" size="30" tabindex="<?PHP   echo $tab++; ?>" name="usuario">
		</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<font color="red">*</font>Clave:
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<input maxlength="50" size="30" tabindex="<?PHP   echo $tab++; ?>" name="clave"  type="password">
		</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
		<font color="red">*</font>Reescriba la clave:<br>
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<input maxlength="50" size="30" tabindex="<?PHP   echo $tab++; ?>" name="clave_2" type="password">
		</td>
	</tr>
	<tr class="bloquecentralcuerpo" onmouseover="setPointer(this, <?PHP   echo $fila++; ?>, 'over', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <?PHP   echo $fila; ?>, 'out', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <?PHP   echo $fila++; ?>, 'click', '<?PHP   echo $tema->celda ?>', '<?PHP   echo $tema->apuntado ?>', '<?PHP   echo $tema->seleccionado ?>');">
		<td bgcolor="<?PHP   echo $tema->celda ?>">
			<font color="red">*</font>Roles:<br>
		</td>
		<td bgcolor="<?PHP   echo $tema->celda ?>">
		<?PHP  
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
$html=new html();
$busqueda="SELECT id_usuario,nombre FROM ".$configuracion["prefijo"]."tipo_usuario ORDER BY id_usuario";
$mi_cuadro=$html->cuadro_lista($busqueda,'nivel_acceso',$configuracion,-1,0,FALSE,$tab++);
echo $mi_cuadro;
?>		<br>
		</td>
	</tr>
	<tr align="center" class="bloquecentralcuerpo">
		<td colspan="2" rowspan="1" valign="undefined" align="center"><?PHP  
		if(isset($_GET["admin"]))
		{?>
		<input type="hidden" name="admin" value="true">
		<?PHP  }?>
			<input type="hidden" name="action" value="registro_usuario">
			<input value="enviar" name="aceptar" type="submit"><br>
		</td>
	</tr>
	<tr class="bloquecentralcuerpo">
		<td colspan="2" rowspan="1">
			Los campos marcados con <font color="red">*</font> deben ser diligenciados obligatoriamente.<br><br>
		</td>
	</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</form>
<?PHP  
	}
}
?>
