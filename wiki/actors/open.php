<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Open extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$constants = $session->constants();
			$parameters = $session->parameters();
			
			try {
				$url = $parameters->{'document-url'};
				$wiki = new \Apps\Wiki\Libs\Document($url);
				$wiki->appendUnformattedTo($element);
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