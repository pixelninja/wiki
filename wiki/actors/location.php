<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Location extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			ini_set('html_errors', true);
			
			$session = \Libs\Session::current();
			$settings = $session->app()->settings();
			$parameters = $session->parameters();
			
			$url = $parameters->{'document-url'}->get();
			$documents = (
				$url != ''
					? $documents = explode('/', $url)
					: array()
			);
			$path = '';
			
			foreach ($documents as $document) {
				$path = ltrim($path . '/' . $document, '/');
				$item = $element->ownerDocument->createElement('item');
				$item->setAttribute('path', $path);
				$item->setAttribute('name', str_replace('-', ' ', $document));
				$element->appendChild($item);
			}
		}
	}
	
/*----------------------------------------------------------------------------*/
?>