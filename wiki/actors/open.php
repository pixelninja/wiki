<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Open extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$constants = \Libs\Session::current()->constants();
			$parameters = \Libs\Session::current()->parameters();
			
			$raw = file_get_contents($constants->{'app-dir'} . '/docs/' . $parameters->{'file'} . '.html');
			$element->nodeValue = htmlentities($raw);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>