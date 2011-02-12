<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\Document as Document;
	
	class Format extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = Session::current();
			$settings = $session->app()->settings();
			$parameters = $session->parameters();
			
			$edit_on_redirect = false;
			$dirs = 'directory://';
			$docs = 'document://';
			
			// Find document url:
			$url = strtolower($parameters->{'current-path'});
			$url = preg_replace('%[^/\w]+%', '-', $url);
			$url = preg_replace('%(^[-]+|[-]+$|[-]+(?=/)|(?<=/)[-]+)%', null, $url);
			
			// Create directory:
			if (!is_dir($dirs . $url)) {
				$dir = '';
				
				foreach (explode('/', $url) as $current) {
					$dir = ltrim($dir . '/' . $current, '/');
					
					if (!is_dir($dirs . $dir)) mkdir($dir);
				}
			}
			
			// Create a new empty document?
			if (!is_file($docs . $url)) {
				$edit_on_redirect = true;
				$title = $parameters->{'current-path'};
				$title = trim(preg_replace('%^.*/%', null, $title));
				
				file_put_contents($docs . $url, '<h1>' . $title . '</h1>');
			}
			
			// Redirect to serialised document:
			if ($url != (string)$parameters->{'current-path'}) {
				header('Location: ' . $session->constants()->{'base-url'} . '/' . $url . (
					$created ? '#edit' : null
				)); exit;
			}
			
			try {
				$parameters->{'document-url'} = $url;
				$wiki = Document::open($docs . $url);
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