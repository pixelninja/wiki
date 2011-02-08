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
			
			$content = $parameters->{'document-content'};
			$url = (
				$parameters->{'document-url'} != ''
					? $parameters->{'document-url'}
					: 'index'
			);
			
			try {
				if ($settings->{'read-only'} === false) {
					throw new \Exception('Cannot save while in read-only mode.');
				}
				
				if ($content == '') {
					throw new \Exception('Cannot save, no content given.');
				}
				
				file_put_contents($constants->{'app-dir'} . '/docs/' . $url . '.html', $content);
				
				$element->setAttribute('success', 'yes');
			}
			
			catch (\Exception $e) {
				$element->setAttribute('success', 'no');
				$element->setAttribute('message', $e->getMessage());
			}
		}
	}
	
/*----------------------------------------------------------------------------*/
?>