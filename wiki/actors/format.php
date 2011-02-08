<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	
	class Format extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$settings = $session->app()->settings();
			$parameters = $session->parameters();
			
			// Find document url:
			$url = strtolower($parameters->{'current-path'});
			$url = preg_replace('%[^/\w]+%', '-', $url);
			$url = preg_replace('%(^[-]+|[-]+$|[-]+(?=/)|(?<=/)[-]+)%', null, $url);
			
			// No path? Use index:
			if ($url == '') {
				$file = $session->constants()->{'app-dir'} . '/docs/index.html';
			}
			
			else {
				$dir = $session->constants()->{'app-dir'} . '/docs';
				$file = $dir . '/' . $url . '.html';
				$created = false;
				
				// Create directory:
				if (!is_dir(dirname($file))) {
					foreach (explode('/', dirname($url)) as $current) {
						$dir .= '/' . $current;
						
						if (!is_dir($dir)) mkdir($dir);
					}
				}
				
				// Create a new empty document?
				if (!is_file($file)) {
					$created = true;
					$title = $parameters->{'current-path'};
					$title = trim(preg_replace('%^.*/%', null, $title));
					
					file_put_contents($file, '<h1>' . $title . '</h1>');
				}
				
				// Redirect to serialised document:
				if ($url != (string)$parameters->{'current-path'}) {
					header('Location: ' . $session->constants()->{'base-url'} . '/' . $url . (
						$created ? '#edit' : null
					)); exit;
				}
			}
			
			try {
				$parameters->{'document-url'} = $url;
				$content = file_get_contents($file);
				$document = $element->ownerDocument;
				
				if ($content == '') {
					throw new \Exception('Cannot format, no content given.');
				}
				
				$html = new \Apps\Wiki\Libs\HTML();
				$content = $html->format($content, $settings);
				
				$fragment = $document->createDocumentFragment();
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