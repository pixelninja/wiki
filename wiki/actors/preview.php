<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Preview extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$settings = $session->app()->settings();
			$parameters = $session->parameters();
			
			$content = $parameters->{'document-content'};
			
			if ($content == '') return;
			
			$html = new \Apps\Wiki\Libs\HTML();
			$tidy = $html->format($content, $settings);
			
			$fragment = $element->ownerDocument->createDocumentFragment();
			$fragment->appendXML($tidy);
			$element->appendChild($fragment);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>