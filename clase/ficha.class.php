<?PHP  	
class ficha
{

	function ficha($id_pagina,$configuracion)
	{
		
		$this->ficha=$id_pagina;
		//echo $this->ficha;		
		
		if(!file_exists ($configuracion["raiz_documento"].$configuracion["bloques"]."/ficha/".$this->ficha.".php"))
		{
			$this->ficha="ficha_desconocida";	
		}		

		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/ficha/".$this->ficha.".php");
	}
	
	
}	
?>
