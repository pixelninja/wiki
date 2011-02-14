<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\Document as Document;
	
	class Preview extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = Session::current();
			$settings = $session->app()->settings();
			$parameters = $session->parameters();
			
			try {
				$content = $parameters->{'document-content'};
				$url = $parameters->{'document-url'};
				
				if ($content == '') {
					throw new \Exception('Cannot preview, no content given.');
				}
				
				$wiki = Document::open('document://' . $url);
				$wiki->setContent($content);
				$wiki->appendFormattedTo($element);
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