<?PHP  
/*
############################################################################
#                                                                          #
#    Desarrollo Por: Teleinformatics Technology Group                      #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@etb.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
* @name          config.inc.php 
* @author        Paulo Cesar Coronado
* @revision      ultima revision 26 de junio de 2005
*****************************************************************************
* @subpackage   
* @package	configuracion
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://acreditacion.udistrital.edu.co
* @description  Archivo en donde se encuentran los parametros globales de configuracion
*
*******************************************************************************/
$configuracion["clases"]="/clase";
$configuracion["grafico"]="/grafico";
$configuracion["bloques"]="/bloques";
$configuracion["arquitectura"]="/bloques/instalar/arquitectura";
$configuracion["configuracion"]="/configuracion";
$configuracion["javascript"]="/funcion";
$configuracion["estilo"]="/estilo";
$configuracion['titulo']="@creditación";
$configuracion["documento"] = '/documento';
$configuracion["prefijo"] = 'aplicativo_';
$configuracion["registros"] = '25'; //Cantidad de registros que se muestran en cada busqueda.
$configuracion["expiracion"]=3600*24;//Las sesiones pueden durar maximo un dia
$configuracion["dbsys"]= 'mysql';
$configuracion["db_dns"] = 'localhost';
$configuracion["db_nombre"] = 'acreditacion';
$configuracion["db_usuario"] = 'acreditacion';
$configuracion["db_clave"] = 'gardel';
$configuracion["correo_admin"] = 'paulocoronado@gmail.com';
$configuracion["host"] = 'http://localhost';
$configuracion["site"] = 'OpenKyOSAcreditacion';
$configuracion["raiz_documento"] = '/var/www/html/'.$configuracion["site"];
$configuracion["tamanno_gui"] = 795;
$configuracion["development_mode"] = FALSE;
define('APLICATIVO_INSTALADO', TRUE);
?>
