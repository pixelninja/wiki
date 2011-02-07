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
			
			$url = $parameters->{'document-url'};
			$content = $parameters->{'document-content'};
			
			if ($settings->{'read-only'} === false || $content == '') return;
			
			file_put_contents($constants->{'app-dir'} . '/docs/' . $url . '.html', $content);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>