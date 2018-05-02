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
/***************************************************************************
  
estilo.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Definicion de estilos - es una pagina CSS
* @usage        
******************************************************************************/

   include_once("../../configuracion/config.inc.php");
   include_once("tema.php");

    if (!isset($mi_tema)) 
    {
        $mi_tema = "basico";
	
    }

?>

body
{
margin:0;
font-family: "Arial", Helvetica, sans-serif;

}

td, th, li 
{
    font-family: "Arial";
}


td.seccion_B
{
	width:<?PHP echo $configuracion["tamanno_gui"]*(0.2) ?>;
	border: 0px;
	border-collapse: collapse;
	border-spacing: 0px;
}

td.seccion_C
{
	width:<?PHP echo $configuracion["tamanno_gui"]*(0.6) ?>;
	border: 0px;
	border-collapse: collapse;
	border-spacing: 0px;
}


td.seccion_D
{
	width:<?PHP echo $configuracion["tamanno_gui"]*(0.2) ?>;
	border: 0px;
	border-collapse: collapse;
	border-spacing: 0px;
}

td.seccion_C_colapsada
{
	width:<?PHP echo $configuracion["tamanno_gui"]*(0.8) ?>;
	border: 0px;
	border-collapse: collapse;
	border-spacing: 0px;
}

td.seccion_colapsada
{
	width:<?PHP echo $configuracion["tamanno_gui"]*(0.5) ?>;
	border: 0px;
	border-collapse: collapse;
	border-spacing: 0px;
}


th {
    font-weight: bold;
    background-color: <?PHP echo $tema->cellheading?>;
    background-image: url(<?PHP echo $configuracion['host'].$configuracion['site'].$configuracion['estilo'].'/'.$mi_tema ?>/gradient.jpg);
}

a:link 
{
    text-decoration: none;
    color: <?php echo $tema->enlace ?>;
}

a:link.interno
{
    text-decoration: none;
    color:#555555;
}

a:visited 
{
    text-decoration: none;
    color:#555555;
}

a:hover 
{
    text-decoration: underline;
    color: <?php echo $tema->sobre ?>;
}


a:hover.interno
{
    text-decoration: underline;
    color: <?php echo $tema->sobre ?>;
    font-size: 12;
    font-family: "Arial";    
}

a:visited.interno
{
    text-decoration: none;
    color: <?php echo $tema->enlace ?>;
}



a:visited.enlace
{
    text-decoration: underline;
    color: <?php echo $tema->enlace ?>;
}

a:link.enlace
{
    text-decoration: underline;
    color:#555555;
}

a:hover.enlace
{
    text-decoration: underline;
    color: <?php echo $tema->sobre ?>;
}

.login_celda1 
{
    background-image: url(<?php echo $configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/principal_cidc/" ?>imagen/login-1.png);
}

form 
{
    margin-bottom: 0;
}

hr.hr_division
{
	border: 0;
	background-color: #AAAAAA;
	height: 1px;
	width: 100%;	
}

hr.hr_elegante
{
	border: 0;
	background-color: #AAAAAA;
	height: 1px;
	width: 50%;	
	align:right;
}
.highlight 
{
    background-color: <?PHP echo $tema->highlight?>;
}

.bloquelateral 
{
    border-width: 1px;
    border-color: <?PHP echo $tema->bordes?>;
    border-style: solid;
    -moz-border-radius-bottomleft: 10px;
    -moz-border-radius-bottomright: 10px;
    background-color: <?PHP echo $tema->cuerpotabla?>;
}

.bloquelateral2 {
    border-width: 1px;
    border-color: <?PHP echo $tema->bordes?>;
    border-style: solid;
    -moz-border-radius-bottomleft: 10px;
    -moz-border-radius-bottomright: 10px;
    -moz-border-radius-topleft: 10px;
    -moz-border-radius-topright: 10px;
    background-color: <?PHP echo $tema->cuerpotabla?>;
}

.bloquelateralrecto 
{
    border-width: 1px;
    border-color: <?PHP echo $tema->bordes?>;
    border-style: solid;
    background-color: <?PHP echo $tema->cuerpotabla?>;
}


.tablapresentacion 
{
    border-width: 1px;
    border-color:#EEEEEE;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    border-spacing:0;
    -moz-border-radius-bottomleft: 10px;
    -moz-border-radius-bottomright: 10px;
    -moz-border-radius-topleft: 10px;
    -moz-border-radius-topright: 10px;   
}

.mostrar_registro 
{
    border-width: 0px;
    border-color:#EFEFEF;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    border-spacing:0;
    font-size: 12;
    font-family: "Arial";
}

.mostrar_registro_out 
{
    border-width: 1px;
    border-color:#DDDDDD;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    border-spacing:0;
    font-size: 12;
    font-family: "Arial";

}


.celdapresentacion 
{
    border-width: 1px;
    border-color:#000000;
    border-style: solid;
    border-collapse:collapse; 
    border-spacing:0;   
}


.cuadro_plano {
    border-width: 0px;
    font-size: 12;
    font-family: "Arial", Verdana, Trebuchet MS, Helvetica, sans-serif;
    text-align: center;
}


.tablaponderacion {
    border-collapse:collapse; 
    border-spacing:0;   
}

.celdaponderacion {
    border-width: 1px;
    border-color:#555555;
    border-style: solid;
    border-collapse:collapse; 
    border-spacing:0;   
}

.celdanavegacion 
{
    border-width: 1px;
    border-color:#AAAAAA;
    border-style: solid;
    border-collapse:collapse; 
    border-spacing:0;
    font-weight: bold;
    text-align: center;
    font-size: 11;
    font-family: "Arial";	   
}



.centrar
{
   text-align:center;
}

.tablarespuesta 
{
    border-width: 1px;
    border-color:#000000;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    border-spacing:0;   
}

.tabla_principal 
{
    border-width: 0px;
    border-color:#000000;
    border-style: solid;    
    border-spacing:0;    
    margin-left:auto; 
    margin-right:auto;
    text-align:center;
}

.paginacentral 
{
    border-width: 1px;
    border-color: <?PHP echo $tema->bordes?>;
    border-style: solid;
    -moz-border-radius-bottomleft: 10px;
    -moz-border-radius-bottomright: 10px;
    -moz-border-radius-topleft: 10px;
    -moz-border-radius-topright: 10px;
    background-color: <?PHP echo $tema->cuerpotabla?>;
}


.bloquelateralencabezado 
{
    font-size: 12;
    font-family: "Arial";
    font-weight: bold;	
    color:#662222;
    background-color: <?PHP echo $tema->encabezado?>;
    background-image: url(<?PHP echo $configuracion['host'].$configuracion['site'].$configuracion['estilo'].'/'.$mi_tema ?>/gradient.jpg)
}

.encabezadopregunta 
{
    font-size: 13;
    font-family: "Arial";
     font-weight: bold;	
}

.mensajealertaencabezado 
{
    font-size: 13;
    font-family: "Arial";
    font-weight: bold;	
    text-decoration: underline;
    background-color: <?PHP echo $tema->mensajealerta?>;
}
.bloquelateralcuerpo 
{
    font-size: 12;
    font-family: "Arial";
    

}
    
.bloquelateralcuerpo2 
{
    font-size: 11;
    font-family: "Arial";
}

<?php
//=========================================================================
//                      CALENDARIO
//=========================================================================
?>
.encabezado_calendario 
{
	font-size: 10px;
	font-family: "sans-serif", Arial, Helvetica;
	background-color: <?PHP echo $tema->fondo_cal_columna ?>;
	
	
}

.evento_calendario 
{
	font-family: "sans-serif", Arial, Helvetica;
	text-align: center;
	background-color: <?PHP echo $tema->fondo_evento ?>;
	color: #FFFFFF;
}

.festivo_calendario 
{
	font-family: "sans-serif", Arial, Helvetica;
	text-align: center;
	background-color: <?PHP echo $tema->fondo_festivo ?>;
}

.bloquecalendario
{
    font-size: 10;
    font-family: "Arial";
}


.tablacalendario
{
    border-width: 1px;
    border-color:#c3d9ff;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    border-spacing:0;   
}


a:link.evento
{
    text-decoration: none;
    color: #FFFFFF;
}

a:visited.evento 
{
    text-decoration: none;
    color:#FFFFFF;
}

a:hover.evento 
{
	text-decoration: underline;
	font-weight: bold;
	color:#FFFFFF;
}


<?php
//=========================================================================
//                      FIN CALENDARIO
//=========================================================================
//=========================================================================
//                      INVESTIGACION
//=========================================================================
?>
.menu_investigacion
{
    font-size: 11;
    font-family: "Arial";
    color:<?PHP echo $tema->texto_menu?>;
    border-width: 0px;
    border-color:<?PHP echo $tema->bordes?>;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    border-spacing:0;       
}

.celda_t_inv
{
    border-width: 0px;
    border-color:<?PHP echo $tema->bordes?>;
    border-style: solid;
    background-color: #19497E;
    border-collapse:collapse; 
    border-spacing:0;
    font-size: 11;
    font-family: "Arial";
    color:<?PHP echo $tema->texto_menu?>;
}

.tabla_menu_inv
{
    border-width: 1px;
    border-color:<?PHP echo $tema->bordes?>;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    width:100%;
    border-spacing:0;   
}

.encabezado_investigacion
{
    font-size: 16px;
    font-family: "Arial";
    font-weight: bold;	
    color: #19497E;;
		
}  
<?php
//=========================================================================
//                      FIN INVESTIGACION
//=========================================================================
?>
.texto_pie
{
	font-size: 10;
	font-family: "Arial";
	text-align: center;
}

.texto_pequenno 
{
    font-size: 11;
    font-family: "Arial";
}

.texto_enano 
{
    font-size: 9px;
    font-family: "Arial";
}

.texto_centrado
{
    text-align: center;
}

    
.bloquecentralencabezado {
    font-size: 13;
    font-family: "Arial";
    font-weight: bold;	
    background-color: <?PHP echo $tema->encabezado?>;
    background-image: url(<?PHP echo $configuracion['host'].$configuracion['site'].$configuracion['estilo'].'/'.$mi_tema ?>/gradient.jpg)
}

.encabezado {
    font-size: 13;
    font-family: "Arial";
    font-weight: bold;	
    
   }

.bloquecentralcuerpo 
{
	font-size: 12;
	font-family: "Arial";
	text-align: justify;
}


 
.bloquecentralmostrar 
{
	font-size: 13;
	font-family: "Arial";
	background-color: <?PHP echo $tema->celdacontenido ?>;
}    
    


.titulocuadrotexto
{
	background-image: url(<?PHP echo $configuracion['host'].$configuracion['site'].$configuracion['estilo'].'/'.$mi_tema ?>/gradient.jpg);	
	text-align: center;	
	font-weight: bold;	
} 
        
.encabezado_datos
{
	font-size: 16px;
	font-family: "Arial";
	font-weight: bold;
	color: <?php echo $tema->color_estilo ?>;
}

.fuentetablaeval
{
    background-color: <?PHP echo $tema->celdacontenido?>;
    font-size: 10px;
    font-family: "Arial";
    color: <?php echo $tema->fuente_clara ?>;
} 

.encabezado_normal
{
    font-size: 12px;
    font-family: "Arial";
    font-weight: bold;
    color: <?php echo $tema->color_estilo ?>;
	
}
             
.encabezado_principal
{
    font-size: 16px;
    font-family: "Arial";
    font-weight: bold;	
    color: <?php echo $tema->color_estilo ?>;
		
}   
    
.texto_color
{
    font-family: "Arial";
    font-weight: bold;	
    color:<?php echo $tema->color_estilo ?>;
}

.texto_claro
{
    font-family: "Arial";
    color:<?php echo $tema->color_claro ?>;
}

.texto_negrita
{
    font-family: "Arial";
    font-weight: bold;	
}

.texto_rojo
{
    font-size: 12;
    font-family: "Arial";
    color: #FF0000;	
}

.texto_gris
{
    color: #333333;
}

.cuerpotabla
{
    background-color: <?PHP echo $tema->cuerpotabla?>;
}

.fondoprincipal
{
    background-color: <?PHP echo $tema->fondo?>;
}
<?php
//=========================================================================
//                          Tablas
//=========================================================================
?>
.tabla_elegante
{
    
    border-width: 1px;
    border-color:<?PHP echo $tema->bordes?>;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    width:100%;
}

.borderless
{
    
    border-width: 0px;
    border-color:<?PHP echo $tema->bordes?>;
    border-style: solid;
    background-color: #FFFFFF;
    border-collapse:collapse; 
    width:100%;   
}
<?php
//=========================================================================
//                          Celdas
//=========================================================================
?>

.celdatabla
{
	background-color: <?PHP echo $tema->celda?>;
} 

.celda_elegante
{
	background-color: <?PHP echo $tema->celdacontenido?>;
	padding-left: 10px;
	
} 

.celdacomentario
{
	background-color: <?PHP echo $tema->comentario?>;
} 
    
.celdatablacontenido
{
	background-color: <?PHP echo $tema->celdacontenido?>;
}
 
.celdaclara 
{
    border-width: 0px;
    border-color:#FFFFFF;
    background-color: #EFEFEF;
    border-style: solid;
    border-collapse:collapse; 
    border-spacing:0;   
}


<?php
//=========================================================================
//                          Puntero
//=========================================================================
?>
.enlace
{
	cursor: pointer;
}