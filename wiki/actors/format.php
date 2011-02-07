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
			$path = strtolower($parameters->{'current-path'});
			$path = preg_replace('%[^/\w]+%', '-', $path);
			$path = preg_replace('%(^[-]+|[-]+$|[-]+(?=/)|(?<=/)[-]+)%', null, $path);
			
			// No path? Use index:
			if ($path == '') {
				$path = 'index';
				$file = $session->constants()->{'app-dir'} . '/docs/index.html';
			}
			
			else {
				$file = str_replace('/', '.', $path);
				$file = $session->constants()->{'app-dir'} . '/docs/' . $file . '.html';
				
				// Create a new empty document?
				if (!is_file($file)) {
					$title = $parameters->{'current-path'};
					$title = trim(preg_replace('%^.*/%', null, $title));
					
					file_put_contents($file, '<h1>' . $title . '</h1>');
				}
				
				// Redirect to serialised document:
				if ($path != (string)$parameters->{'current-path'}) {
					header('Location: ' . $session->constants()->{'base-url'} . '/' . $path); exit;
				}
			}
			
			$element->setAttribute('file', $path);
			
			$raw = file_get_contents($file);
			$document = $element->ownerDocument;
			
			if ($raw == '') return;
			
			$html = new \Apps\Wiki\Libs\HTML();
			$tidy = $html->format($raw, $settings);
			
			$fragment = $document->createDocumentFragment();
			$fragment->appendXML($tidy);
			$element->appendChild($fragment);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>