<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\TechPub\Actors;
	
	class Open extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$parameters = \Libs\Session::current()->parameters();
			
			$raw = file_get_contents(BASE_DIR . '/techpub/docs/' . $parameters->{'file'} . '.html');
			$element->nodeValue = htmlentities($raw);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>