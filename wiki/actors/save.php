<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\Document as Document;
	
	class Save extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			try {
				$parameters = Session::parameters();
				$settings = Session::app()->settings();
				$content = $parameters->{'document-content'}->get();
				$url = $parameters->{'document-url'}->get();
				
				if ($settings->{'read-only'} === false) {
					throw new \Exception('Cannot save while in read-only mode.');
				}
				
				if ($content == '') {
					throw new \Exception('Cannot save, no content given.');
				}
				
				$wiki = Document::open('document://' . $url);
				$wiki->setUnformatted($content);
				$wiki->save();
				
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