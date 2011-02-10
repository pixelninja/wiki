<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Location extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$settings = $session->app()->settings();
			$constants = $session->constants();
			$parameters = $session->parameters();
			$document = $element->ownerDocument;
			
			$url = $parameters->{'document-url'}->get();
			$files = (
				$url != ''
					? explode('/', $url)
					: array()
			);
			$path = '';
			
			foreach ($files as $file) {
				$path = $path . '/' . $file;
				$name = ucfirst(str_replace('-', ' ', $file));
				
				try {
					$xml = new \Libs\DOM\Document();
					$xml->loadHTMLFile(sprintf(
						'%s/docs%s.html',
						$constants->{'app-dir'},
						$path
					));
					$value = $xml->{'string(//h1[1])'};
					
					if ($value) $name = $value;
				}
				
				catch (\Exception $e) {
					// De-serialised name is fine.
				}
				
				$item = $document->createElement('item');
				$item->setAttribute('path', ltrim($path, '/'));
				$item->setAttribute('name', $name);
				$element->appendChild($item);
			}
		}
	}
	
/*----------------------------------------------------------------------------*/
?>