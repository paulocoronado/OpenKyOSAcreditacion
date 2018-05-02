<?PHP  	
class ficha_informacion
{

	function ficha_informacion($id_componente,$id_programa,$configuracion)
	{
		
		$this->ficha_informacion=$id_componente;
		$this->id_programa=$id_programa;
		//echo $this->ficha;		
		
		if(!file_exists ($configuracion["raiz_documento"].$configuracion["bloques"]."/ficha_informacion/".$this->ficha_informacion.".php"))
		{
			$this->id_componente=$this->ficha_informacion;
			$this->ficha_informacion="error";	
			
		}		

		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/ficha_informacion/".$this->ficha_informacion.".php");
	}
	
	
}	
?>
