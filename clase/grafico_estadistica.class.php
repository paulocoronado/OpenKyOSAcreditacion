<?PHP  
/*
############################################################################
#                                                                          #
#    Desarrollo Por:                        #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@berosa.com                                                   #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?PHP  
/****************************************************************************************************************
  
grafico_estadisdtica.class.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 27 de noviembre de 2005

*******************************************************************************************************************
* @subpackage   
* @package	clase
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Clase principal para la generacion de graficos
* @usage        
*****************************************************************************************************************/
?><?PHP  

class grafico_estadistica
{
	function barras($valor,$tamanno_x,$tamanno_y,$nombre_archivo,$ancho_barra,$configuracion,$dato)
	{
		$mayor=$valor;
		arsort($mayor);
		reset($mayor);
			
		
		if($dato=='valor')
		{
			$max_valor=array_sum($valor);				
		}
		else
		{
		
			$max_valor=current($mayor);
		
		}
		
		$imagen = grafico_estadistica::marco($tamanno_x,$tamanno_y);
		
		$negro= grafico_estadistica::color("negro",$imagen,0);
		$blanco= grafico_estadistica::color("blanco",$imagen,0);
		$gris= grafico_estadistica::color("gris",$imagen,0);
		grafico_estadistica::rectangulo(0,0,$tamanno_x,$tamanno_y,$blanco,1,$imagen);
		
		
		//Efecto 3D
		
		//Grilla
		
		//Vertical
		$x_1=(0.1)*$tamanno_x;
		$x_2=(0.9)*$tamanno_x;
		
		
		
		for($i=(0.1);$i<0.94;$i+=(0.04))
		{
			$y_1=($i)*$tamanno_y;
			$y_2=(1-$i)*$tamanno_y;
			grafico_estadistica::linea($x_1,$y_2,$x_2,$y_2,$gris,$imagen);
			imagettftext($imagen,8,0, $x_1-25,$y_1, $negro,$configuracion["raiz_documento"].$configuracion["grafico"]."/fuente/Vera.ttf" ,abs(round((0.9*$tamanno_y-$y_1)*($max_valor/(0.8*$tamanno_y)),2)));	
			
		}
		//Horizontal
		$y_1=(0.1)*$tamanno_y;
		$y_2=(0.9)*$tamanno_y;
		for($i=(0.1);$i<0.94;$i+=(0.04))
		{
			$x_1=($i)*$tamanno_x;
			$x_2=(1-$i)*$tamanno_x;
			grafico_estadistica::linea($x_1,$y_1,$x_1,$y_2,$gris,$imagen);
			
			
		}
		
		// Barras 
		//Centradas en cada division
		$esta_barra=1;
		//Area de cada opcion
		$area=(0.8)*$tamanno_x/(count($valor));
		
		
		foreach ($valor as $clave=>$val)
		{
			
			//Punto medio
			$punto_medio=$esta_barra*$area;
			$x_1=($punto_medio+(0.05)*$tamanno_x)-$ancho_barra/2;
			$x_2=($punto_medio+(0.05)*$tamanno_x)+$ancho_barra/2;
					
			unset($color_oscuro);
			unset($color);
			$color=grafico_estadistica::color('',$imagen,0);
			$convenciones[$clave]=$color;
			$mi_color[$clave]=grafico_estadistica::color($color,$imagen,0);
			
		
			
			//La altura se normaliza al valor de la cuadricula
			
			$altura=(0.8)*$tamanno_y*$val/$max_valor;
			
			grafico_estadistica::rectangulo($x_1,(0.9*$tamanno_y-$altura),$x_2,0.9*$tamanno_y,$mi_color[$clave],1,$imagen);
			$esta_barra++;
			
			
		}
		
		//Etiquetas encima de las barras
		$esta_barra=1;
		//Area de cada opcion
		$area=(0.8)*$tamanno_x/(count($valor));
		
		foreach ($valor as $clave=>$val)
		{
			//Punto medio
			$punto_medio=$esta_barra*$area+(0.05)*$tamanno_x;
			//La altura se normaliza al valor de la cuadricula
			
			$altura=(0.8)*$tamanno_y*$val/$max_valor;
			if($dato=="valor")
			{
				imagettftext($imagen,10,0, $punto_medio-(5*strlen($val)),(0.9*$tamanno_y-$altura), $negro,$configuracion["raiz_documento"].$configuracion["grafico"]."/fuente/Vera.ttf" ,$val );
			}
			else
			{
				imagettftext($imagen,10,0, $punto_medio-(5*strlen($val."%")),(0.9*$tamanno_y-$altura), $negro,$configuracion["raiz_documento"].$configuracion["grafico"]."/fuente/Vera.ttf" ,$val."%" );
			}
			$esta_barra++;
			
			
		}
		
		
		// Guardar la imagen
		$nombre_archivo =$configuracion["raiz_documento"].$configuracion["documento"]."/graficos/" .$nombre_archivo.".png";
		imagepng($imagen,$nombre_archivo);
		imagedestroy($imagen); 
		
		//Caja de convenciones
		
		return $convenciones;
	}


	function pie_3d($valor,$tamanno_x,$tamanno_y,$grosor,$radio_mayor,$radio_menor,$nombre_archivo,$configuracion,$dato)
	{
		if($dato=='valor')
		{
			$total_valor=array_sum($valor);	
			
		}
		
		
		
		$imagen = grafico_estadistica::marco($tamanno_x,$tamanno_y);
		
		$negro= grafico_estadistica::color("negro",$imagen,0);
		$blanco= grafico_estadistica::color("blanco",$imagen,0);
		
		grafico_estadistica::rectangulo(0,0,$tamanno_x,$tamanno_y,$blanco,1,$imagen);
		
		
		//Efecto 3D
		for ($i = (round($tamanno_y/2)+$grosor); $i >round($tamanno_y/2); $i--) 
		{
			$angulo_inicial=0;
			foreach ($valor as $clave=>$valor_clave)
			{
				//Crea una matriz con un color aleatorio
				
				if($dato=='valor')
				{
					$val=round(($valor_clave/$total_valor)*100,2);	
					
				}
				else
				{
					$val=$valor_clave;	;					
				}
				//echo $val."<br>";
				if($i==round($tamanno_y/2)+$grosor)
				{
					unset($color_oscuro);
					unset($color);
					$color=grafico_estadistica::color('',$imagen,0);
					foreach($color as $clave_color => $valor_color)
					{
						//Crea una matriz con colores oscuros
						//echo $clave_color."-->".$valor_color."<br>";
						$color_oscuro[(string) $clave_color]=($valor_color-50);
						
					}
					$convenciones[$clave]=$color;
					$mi_color[$clave]=grafico_estadistica::color($color,$imagen,0);
					$mi_color_oscuro[$clave]=grafico_estadistica::color($color_oscuro,$imagen,0);
				}
				
				$angulo_final=floor(($val/100)*360)+$angulo_inicial;
				//echo $angulo." ".$angulo_inicial."<br>";
				grafico_estadistica::arco(($tamanno_x/2),$i,$radio_mayor,$radio_menor,$mi_color_oscuro[$clave],$angulo_inicial,$angulo_final,4,1,$imagen);
				$angulo_inicial=$angulo_final;
				//echo $x."-->".$y."<br>";
				
			}
		}
		
		// Elipse de la superficie
		$angulo_inicial=0;
		foreach ($valor as $clave=>$valor_clave)
		{
			if($dato=='valor')
			{
				$val=round(($valor_clave/$total_valor)*100,2);	
				
			}
			else
			{
				$val=$valor_clave;	;					
			}
			$angulo_final=floor(($val/100)*360)+$angulo_inicial;
			//echo $angulo." ".$angulo_inicial."<br>";
			grafico_estadistica::arco(($tamanno_x/2),($tamanno_y/2), $radio_mayor, $radio_menor,$mi_color[$clave],$angulo_inicial,$angulo_final,4,1,$imagen);
			$angulo_inicial=$angulo_final;
			
			
		}
		
		// Etiquetas
		$angulo_inicial=0;
		foreach ($valor as $clave=>$valor_clave)
		{
			if($dato=='valor')
			{
				$val=round(($valor_clave/$total_valor)*100,2);	
				
			}
			else
			{
				$val=$valor_clave;	;					
			}
			$angulo_final=floor(($val/100)*360)+$angulo_inicial;
			
			$x=($tamanno_x/2)+(($radio_mayor/2)/1.5)*cos(deg2rad(($angulo_inicial+$angulo_final)/2));
			$y=($tamanno_y/2)+(($radio_menor/2)/1.5)*sin(deg2rad(($angulo_inicial+$angulo_final)/2));
			
			$x=round($x);
			$y=round($y);
			if($dato=='valor')
			{
				imagettftext($imagen,10,0, $x-(5*strlen($valor_clave)),$y, $negro,$configuracion["raiz_documento"].$configuracion["grafico"]."/fuente/Vera.ttf"  ,$valor_clave );
			}
			else
			{
				imagettftext($imagen,10,0, $x-(5*strlen($val."%")),$y, $negro,$configuracion["raiz_documento"].$configuracion["grafico"]."/fuente/Vera.ttf"  ,$val."%" );
			}
			$angulo_inicial=$angulo_final;
		}
		
		
		// Guardar la imagen
		$nombre_archivo =$configuracion["raiz_documento"].$configuracion["documento"]."/graficos/" .$nombre_archivo.".png";
		imagepng($imagen,$nombre_archivo);
		imagedestroy($imagen); 
		
		//Caja de convenciones
		
		return $convenciones;
	}


	
	
	
	//Dibuja una linea desde x_1,y_1 hasta x_2, y_2
	
	function linea($x_1,$y_1,$x_2,$y_2,$color,$imagen)
	{
		
		imageline($imagen, $x_1, $y_1, $x_2, $y_2, $color);
		return TRUE;
	
	
	}
	
	function elipse($centro_x,$centro_y,$radio_h,$radio_v,$color,$tipo,$imagen)
	{
		
		if($tipo==1)
		{
			imagefilledellipse ( $imagen, $centro_x, $centro_y, $radio_h, $radio_v, $color );
		}
		else
		{
			imageellipse ( $imagen, $centro_x, $centro_y, $radio_h, $radio_v, $color );
		}
		return TRUE;
	
	}
	
	
	function arco($centro_x,$centro_y,$radio_h,$radio_v,$color,$angulo_inicio,$angulo_final,$estilo,$tipo,$imagen)
	{
		
		if($tipo==1)
		{
			imagefilledarc($imagen,$centro_x, $centro_y, $radio_h, $radio_v,$angulo_inicio,$angulo_final,$color,$estilo);
	
		}
		else
		{
			imagearc($imagen,$centro_x, $centro_y, $radio_h, $radio_v,$angulo_inicio,$angulo_final,$color);	
		}
		
		return TRUE;
	}
	
	function rectangulo($x_1,$y_1,$x_2,$y_2,$color,$tipo,$imagen)
	{
	//Crea un rectangulo empezando desde la coordenada superior izquierda x1,y1  y terminando en x2,y2.
	// Tipo
	// 0: rectangulo vacio
	// 1: Rectangulo lleno
		if($tipo==1)
		{
			imagefilledrectangle($imagen, $x_1,$y_1,$x_2,$y_2,$color);
		}
		else
		{
		
			imagerectangle($imagen, $x_1,$y_1,$x_2,$y_2,$color);
		
		}
	
	}
	
	
	function color($color,$imagen,$alfa)
	{
		if(is_array($color))
		{
			$color = imagecolorallocatealpha($imagen, $color["red"], $color["green"], $color["blue"],$alfa);
		}
		else
		{
			switch($color)
			{
				
				case "negro":
					$r=0;
					$g=0;
					$b=0;
					break;
					
				case "blanco":	
					$r=255;
					$g=255;
					$b=255;
					break;
				
				case "rojo":	
					$r=255;
					$g=0;
					$b=0;
					break;
					
				case "rojo_oscuro":	
					$r=150;
					$g=0;
					$b=0;
					break;	
					
				case "verde":	
					$r=0;
					$g=255;
					$b=0;
					break;
					
				case "verde_oscuro":	
					$r=0;
					$g=150;
					$b=0;
					break;	
					
				case "azul":	
					$r=0;
					$g=0;
					$b=255;
					break;
				
				case "azul_oscuro":	
					$r=0;
					$g=0;
					$b=150;
					break;
					
				case "amarillo":
					$r=255;
					$g=255;
					$b=0;
					break;	
				
				case "amarillo_oscuro":	
					$r=150;
					$g=150;
					$b=0;
					break;
					
				case "gris":	
					$r=200;
					$g=200;
					$b=200;
					break;	
				
				default:	
					$color="";
					mt_srand((double)microtime()*1000000);
					$color["red"]=mt_rand(50,255);
					mt_srand($color["red"]);
					$color["green"]=mt_rand(50,255);
					mt_srand($color["green"]);
					$color["blue"]=mt_rand(50,255);
					return $color;	
			}
			$color = imagecolorallocatealpha($imagen, $r, $g, $b,$alfa);
		}	
		return $color;
	}
	
	
	// Crear el marco de la imagen
	function marco($x,$y)
	{
		$imagen=imagecreate($x, $y);
		return $imagen;
	}
}

?>
