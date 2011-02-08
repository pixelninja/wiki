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
			$element->setAttribute('success', 'no');
			
			try {
				if ($content == '') {
					throw new \Exception('Cannot preview, no content given.');
				}
				
				$html = new \Apps\Wiki\Libs\HTML();
				$content = $html->format($content, $settings);
				
				$fragment = $element->ownerDocument->createDocumentFragment();
				$fragment->appendXML($content);
				$element->appendChild($fragment);
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