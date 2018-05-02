<?php
// +----------------------------------------------------------------------
// | PHP Source                                                           
// +----------------------------------------------------------------------
// | Copyright (C) 2005 by Paulo Cesar Coronado <paulo_cesar@localhost.localdomain>
// +----------------------------------------------------------------------
// |
// | Copyright: See COPYING file that comes with this distribution
// +----------------------------------------------------------------------
//

?><?php
if(isset($_POST["aceptar"]))
{

	include_once("../configuracion/config.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
	$pagina=desenlace($_POST["pagina"]);
	echo "P&aacute;gina: <b>".$pagina."</b><br>";
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$cadena_sql="SELECT id_pagina FROM ".$configuracion["prefijo"]."pagina WHERE nombre='".$pagina."' LIMIT 1";
		$acceso_db->registro_db($cadena_sql,0);
		$registro=$acceso_db->obtener_registro_db();
		$conteo=$acceso_db->obtener_conteo_db();
		if($conteo>0)
		{
			echo "id_pagina: ".$registro[0][0]."<br>";
			echo "Bloques que componen esta p&aacute;gina:<br>";
			$cadena_sql="SELECT ";
			$cadena_sql.="".$configuracion["prefijo"]."bloque_pagina.id_bloque, ";
			$cadena_sql.="".$configuracion["prefijo"]."bloque_pagina.seccion, ";
			$cadena_sql.="".$configuracion["prefijo"]."bloque_pagina.posicion, ";
			$cadena_sql.="".$configuracion["prefijo"]."bloque.nombre ";
			$cadena_sql.="FROM ";
			$cadena_sql.="".$configuracion["prefijo"]."bloque_pagina,";
			$cadena_sql.="".$configuracion["prefijo"]."bloque "; 
			$cadena_sql.="WHERE ";
			$cadena_sql.="".$configuracion["prefijo"]."bloque_pagina.id_pagina='".$registro[0][0]."' ";
			$cadena_sql.="AND ";
			$cadena_sql.="".$configuracion["prefijo"]."bloque_pagina.id_bloque=".$configuracion["prefijo"]."bloque.id_bloque";
			//echo $cadena_sql."<br>";
			$acceso_db->registro_db($cadena_sql,0);
			$registro=$acceso_db->obtener_registro_db();
			$conteo=$acceso_db->obtener_conteo_db();
			if($conteo>0)
			{
				?>
<table border="0" align="center" cellpadding="5" cellspacing="1">
<tr bgcolor="#ECECEC">
		<td align="center">id</td>			
		<td align="center">nombre</td>
		<td align="center">secci&oacute;n</td>
		<td align="center">posici&oacute;n</td>
</tr>	
<?php
				for($contador=0;$contador<$conteo;$contador++)
				{
				?>
	<tr bgcolor="#ECECEC">
		<td><?php echo  $registro[$contador][0]?></td>			
		<td><?php echo  $registro[$contador][3]?></td>
		<td><?php echo  $registro[$contador][1]?></td>
		<td><?php echo  $registro[$contador][2]?></td>
	</tr>	
				<?php	
					
				}
				?>
</table>
<hr>
P&aacute;gina generada autom&aacute;ticamente el: <?php echo date("d/m/Y",time())?><br>
Ambiente de desarrollo para aplicaciones web. - Software amparado por licencia GPL. Copyright (c) 2004-2006.<br>
Paulo Cesar Coronado - Universidad Distrital Francisco Jos&eacute; de Caldas.<br>
<hr>
				
				<?php
				
			}
		
		}
		else
		{
			echo "La p&aacute;gina no se encuentra registrada en el sistema<br>";?>
<hr>
P&aacute;gina generada autom&aacute;ticamente el: <?php echo date("d/m/Y",time())?><br>
Ambiente de desarrollo para aplicaciones web. - Software amparado por licencia GPL. Copyright (c) 2004-2006.<br>
Paulo Cesar Coronado - Universidad Distrital Francisco Jos&eacute; de Caldas. - Universidad de los Llanos<br>
<hr>			
			<?php
		}
	}
	
}
?><form method="post" action="desenlace.php" name="desenlazar" >
  <table class="bloquelateral" align="center" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
      <tr>
        <td align="center" valign="middle">
        <input size="40" tabindex="1" name="pagina">
        </td>
      </tr>
      <tr>
        <td align="center" valign="middle">
        <input value="aceptar" name="aceptar" type="submit">
        </td>
      </tr>
    <tbody>
 </table>
<form>
