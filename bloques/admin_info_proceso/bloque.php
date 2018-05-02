<?php 
/*
############################################################################
#                                                                         #
#    Desarrollo Por: Tayron Ltda - Division Software                      #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@tayron.com.co                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?>
<?php 
/****************************************************************************************************************
  
index.php 

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
* @description  Formualrio para el registro de usuarios
* @usage        
*****************************************************************************************************************/ 
?><?php 
if(!isset($_POST['action']))
{
	include_once("html.php");	

}
else
{
	include_once("action.php");	
}

?>
