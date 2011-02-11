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
					? explode('/', '/' . $url)
					: array('')
			);
			$path = '';
			
			foreach ($files as $file) {
				$path = ltrim($path . '/' . $file, '/');
				$name = ucfirst(str_replace('-', ' ', $file));
				$content = file_get_contents('document://' . $path);
				
				try {
					$html = new \Apps\Wiki\Libs\HTML();
					$xml = new \Libs\DOM\Document();
					$xml->loadXML(sprintf(
						'<data>%s</data>',
						$html->format($content, $settings)
					));
					$value = $xml->{'string(/data/h1[1])'};
					
					if ($value) $name = $value;
				}
				
				catch (\Exception $e) {
					// De-serialised name is fine.
				}
				
				$item = $document->createElement('item');
				$item->setAttribute('path', $path);
				$item->setAttribute('name', $name);
				$element->appendChild($item);
			}
		}
	}
	
/*----------------------------------------------------------------------------*/
?>