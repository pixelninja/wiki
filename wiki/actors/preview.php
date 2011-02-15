<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\Document as Document;
	
	class Preview extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			try {
				$parameters = Session::parameters();
				$content = $parameters->{'document-content'}->get();
				$url = $parameters->{'document-url'}->get();
				
				if ($content == '') {
					throw new \Exception('Cannot preview, no content given.');
				}
				
				$wiki = Document::open('document://' . $url);
				$wiki->setUnformatted($content);
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