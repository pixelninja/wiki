<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Save extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$constants = \Libs\Session::current()->constants();
			$parameters = \Libs\Session::current()->parameters();
			$file = $parameters->{'file'};
			$raw = $parameters->{'raw'};
			
			if ($raw == '') return;
			
			file_put_contents($constants->{'app-dir'} . '/docs/' . $file . '.html', $raw);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>