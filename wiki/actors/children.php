<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\Document as Document;
	
	class Children extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			try {
				$parameters = Session::parameters();
				$document = $element->ownerDocument;
				$url = $parameters->{'document-url'}->get();
				$wiki = Document::open('document://' . $url);
				
				foreach ($wiki->getChildren() as $child) {
					$item = $document->createElement('item');
					$item->setAttribute('path', $child->getURL());
					$item->setAttribute('name', $child->getName());
					$element->appendChild($item);
					
					$child->appendExcerptTo($item);
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
