<?PHP  	
class funciones_matematicas
{

	function media($matriz)
	{
		$media=array_sum($matriz) / count($matriz) ;
        	return $media;
	}
	
	
	
	function mediana($matriz)
	{
		sort($matriz) ;

		if ((count($matriz) % 2) == 0)
		{
			//Si se tiene un conjunto par de valores entonces se calcula la media de los
			//dos valores centrales
			$i = count($matriz) / 2 ;
			$mediana=($matriz[$i - 1] + $matriz[$i]) / 2 ;
		}
		else
		{
			//Si se tiene un conjunto impar se devuelve el valor central
			$mediana=$matriz[(int)(count($matriz) / 2)] ;
		}
		return $mediana;
			
	}
	
	function moda($matriz)
	{
		$veces = array() ;
	
		$conteo = count($matriz) ;
	
		for ($i = 0; $i < $conteo; $i++)
		{
			$veces[(string)$matriz[$i]]++ ;
		}
		
		arsort($veces) ;
	
		$moda = array() ;
	
		foreach ($veces as $clave => $valor)
		{
			
			if (count($moda) == 0)
			{
				if($valor>1)
				{
					$la_moda = $valor ;
				}
				else
				{
					break;
				}
			}
		
			if ($la_moda == $valor)
			{
				$moda[] = $clave ;
			}
			else
			{
				break ;
			}
		}
	
		return $moda ;
		
	}
	
	
	
	
	
	
	function varianza($matriz)
	{
		$media = funciones_matematicas::media($matriz);
		$sumatoria = 0.0;
		foreach ($matriz as $valor)
		{
			$sumatoria += pow(($valor - $media), 2) ;
		}
		$varianza=($sumatoria/(count($matriz) - 1)) ;
		return $varianza;
	}
	
	
	function desviacion_estandar($matriz)
	{
		$desviacion=sqrt(funciones_matematicas::varianza($matriz)) ;
		return $desviacion;
	}
	
	//Conjunto de funciones optimizadas para metricas de tipo seleccion
	
	function muestra($matriz)
	{
		//Crear el conjunto de muestras
		
		foreach ($matriz as $clave => $valor)
		{
			for($i=0;$i<$valor;$i++)
			{
				$mi_matriz[] = $clave ;
			}
		}
		
		return $mi_matriz;
	
	}
	
	
	function media_seleccion($matriz)
	{
		
		$mi_matriz=funciones_matematicas::muestra($matriz);
		$media=funciones_matematicas::media($mi_matriz) ;
        	return $media;
	}
	
	function moda_seleccion($matriz)
	{
		arsort($matriz) ;
	
		$moda = array() ;
	
		foreach ($matriz as $clave => $valor)
		{
			
			if (count($moda) == 0)
			{
				if($valor>1)
				{
					$la_moda = $valor ;
				}
				else
				{
					break;
				}
			}
		
			if ($la_moda == $valor)
			{
				$moda[] = $clave ;
			}
			else
			{
				break ;
			}
		}
	
		return $moda ;
		
	}
	
	
	function mediana_seleccion($matriz)
	{
		$mi_matriz=funciones_matematicas::muestra($matriz);
		$mediana=funciones_matematicas::mediana($mi_matriz) ;
		return $mediana;
			
	}
	
	
	function varianza_seleccion($matriz)
	{
		$mi_matriz=funciones_matematicas::muestra($matriz);
		$varianza=funciones_matematicas::varianza($mi_matriz) ;
		return $varianza;
	}
	
	
	function desviacion_estandar_seleccion($matriz)
	{
		$mi_matriz=funciones_matematicas::muestra($matriz);
		$desviacion=funciones_matematicas::desviacion_estandar($mi_matriz) ;
		return $desviacion;
	}
	
	
}	
?>
