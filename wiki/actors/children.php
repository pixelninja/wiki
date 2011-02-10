<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Children extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			ini_set('html_errors', true);
			
			$session = \Libs\Session::current();
			$settings = $session->app()->settings();
			$constants = $session->constants();
			$parameters = $session->parameters();
			$document = $element->ownerDocument;
			
			$url = $parameters->{'document-url'}->get();
			$search = sprintf(
				'%s/docs/%s/*.html',
				$constants->{'app-dir'},
				$url
			);
			
			foreach (glob($search) as $file) {
				if (basename($file) == 'index.html') continue;
				
				$path = $url . '/' . basename($file, '.html');
				$name = ucfirst(str_replace('-', ' ', basename($path)));
				$content = file_get_contents($file);
				
				try {
					$html = new \Apps\Wiki\Libs\HTML();
					$xml = new \Libs\DOM\Document();
					$xml->loadXML(
						'<data>' . $html->format($content, $settings) . '</data>'
					);
					$value = $xml->{'string(/data/h1[1])'};
					$break = $xml->{'/data/*[name() != "h1" and name() != "p"]'};
					$content = null;
					
					if ($break->valid()) $break = $break->current();
					
					foreach ($xml->{'/data/*'} as $node) {
						if ($node === $break) break;
						if ($node->nodeName != 'p') continue;
						
						$content .= $node->saveXML();
					}
					
					if ($value) $name = $value;
					if ($content) {
						$fragment = $document->createDocumentFragment();
						$fragment->appendXML($content);
					}
				}
				
				catch (\Exception $e) {
					// This is safe to ignore...
				}
				
				$item = $document->createElement('item');
				$item->setAttribute('path', $path);
				$item->setAttribute('name', $name);
				$element->appendChild($item);
				
				try {
					if (isset($fragment)) {
						$item->appendChild($fragment);
					}
				}
				
				catch (\Exception $e) {
					// Bad API - no way to test if document fragment is empty.
				}
			}
		}
	}
	
/*----------------------------------------------------------------------------*/
?>
