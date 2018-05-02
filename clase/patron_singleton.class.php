<?php
class patron_singleton
{
	
	
	function &obtener_instancia ($clase, $variable=null)
	{
		static $instancias = array(); 
	
		if (array_key_exists($clase, $instancias)) 
		{
			$instancia =& $instancias[$clase];
			
		} 
		else 
		{
			
			if (!class_exists($clase)) 
			{
				$clase = CLASS_PATH.$class_name.'.class.php';
				//echo $clase;
				if (file_exists($clase))
				{
					require_once $clase;
				}
			}		
			$instancias[$clase] = new $clase($variable);
			$instancia =& $instancias[$clase];
		}
		
		return $instancia;
	
	}
    
}
?>