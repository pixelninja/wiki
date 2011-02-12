<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\Document as Document;
	
	class Location extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = Session::current();
			$settings = $session->app()->settings();
			$constants = $session->constants();
			$parameters = $session->parameters();
			$document = $element->ownerDocument;
			
			try {
				$url = $parameters->{'document-url'}->get();
				$files = (
					$url != ''
						? explode('/', '/' . $url)
						: array('')
				);
				$url = '';
				
				foreach ($files as $file) {
					$url = ltrim($url . '/' . $file, '/');
					$wiki = Document::open('document://' . $url);
					
					$item = $document->createElement('item');
					$item->setAttribute('path', $wiki->getURL());
					$item->setAttribute('name', $wiki->getName());
					$element->appendChild($item);
				}
				
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