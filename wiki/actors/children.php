<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Children extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$settings = $session->app()->settings();
			$constants = $session->constants();
			$parameters = $session->parameters();
			$document = $element->ownerDocument;
			
			$url = $parameters->{'document-url'}->get();
			$wiki = new \Apps\Wiki\Libs\Document($url);
			
			foreach ($wiki->getChildren() as $child) {
				$item = $document->createElement('item');
				$item->setAttribute('path', $child->getURL());
				$item->setAttribute('name', $child->getName());
				$element->appendChild($item);
				
				$child->appendExcerptTo($item);
			}
		}
	}
	
/*----------------------------------------------------------------------------*/
?>
