<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Actors;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\Document as Document;
	
	class Format extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$parameters = Session::parameters();
			$edit_on_redirect = false;
			$dirs = 'directory://';
			$docs = 'document://';
			$serialise = function($url) {
				$url = preg_replace('%[^/\w]+%', '-', strtolower($url));
				$url = preg_replace('%(^[-]+|[-]+$|[-]+(?=/)|(?<=/)[-]+)%', null, $url);
				
				return $url;
			};
			
			// Find document url:
			$url = $serialise($parameters->{'current-path'});
			
			// Document doesn't exists, create it:
			if (!is_file($dirs . $url)) {
				$edit_on_redirect = true;
				$path = '';
				
				foreach (explode('/', $parameters->{'current-path'}) as $title) {
					$path = ltrim($path . '/' . $title, '/');
					
					if (is_file($docs . $path)) continue;
					
					$url = $serialise($path);
					$wiki = Document::create($docs . $url, $title);
					$wiki->save();
				}
			}
			
			// Redirect to serialised document:
			if ($url != (string)$parameters->{'current-path'}) {
				header('Location: ' . Session::constants()->{'base-url'} . '/' . $url . (
					$edit_on_redirect ? '#edit' : null
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