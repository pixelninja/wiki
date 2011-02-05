<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Save extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$settings = $session->app()->settings();
			$constants = $session->constants();
			$parameters = $session->parameters();
			$file = $parameters->{'file'};
			$raw = $parameters->{'raw'};
			
			if ($settings->{'read-only'} !== true || $raw == '') return;
			
			file_put_contents($constants->{'app-dir'} . '/docs/' . $file . '.html', $raw);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>