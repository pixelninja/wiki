<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Open extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$constants = $session->constants();
			$parameters = $session->parameters();
			
			$url = $parameters->{'document-url'};
			
			try {
				$content = file_get_contents('document://' . $url);
				$element->nodeValue = htmlentities($content);
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