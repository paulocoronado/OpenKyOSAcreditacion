<?php
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado                                                  #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/

include_once("../../configuracion/config.inc.php");
include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/enlace.inc.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
$pagina=enlace("principal_cidc");
echo "<script>location.replace('".$configuracion["host"].$configuracion["site"]."/index.php?page=".$pagina."')</script>";   
?>   
