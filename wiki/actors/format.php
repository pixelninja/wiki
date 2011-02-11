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
			$edit_on_redirect = false;
			
			// Create directory:
			if (!is_dir('directory://' . $url)) {
				$dir = '';
				
				foreach (explode('/', $url) as $current) {
					$dir = ltrim($dir . '/' . $current, '/');
					
					if (!is_dir('directory://' . $dir)) mkdir($dir);
				}
			}
			
			// Create a new empty document?
			if (!is_file('document://' . $url)) {
				$edit_on_redirect = true;
				$title = $parameters->{'current-path'};
				$title = trim(preg_replace('%^.*/%', null, $title));
				
				file_put_contents('document://' . $url, '<h1>' . $title . '</h1>');
			}
			
			// Redirect to serialised document:
			if ($url != (string)$parameters->{'current-path'}) {
				header('Location: ' . $session->constants()->{'base-url'} . '/' . $url . (
					$created ? '#edit' : null
				)); exit;
			}
			
			try {
				$parameters->{'document-url'} = $url;
				$content = file_get_contents('document://' . $url);
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