<?PHP  	
class mensaje
{

	function mensaje($id_pagina,$configuracion)
	{
		
		$this->el_mensaje="mensaje_".$id_pagina;		
		
		if(!file_exists ($configuracion["raiz_documento"].$configuracion["bloques"]."/mensaje/".$this->el_mensaje.".php"))
		{
			$this->el_mensaje="mensaje_edicion_usuario_exito";	
		}		

		include_once($configuracion["raiz_documento"].$configuracion["bloques"]."/mensaje/".$this->el_mensaje.".php");
	}
	
	
}	
?>
