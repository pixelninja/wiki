<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\TechPub\Actors;
	
	class Format extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$session = \Libs\Session::current();
			$parameters = $session->parameters();
			
			// Find current document name:
			$path = $parameters->{'current-path'};
			$path = strtolower(trim(preg_replace('%\W+%', '-', $path), '-'));
			$file = $session->constants()->{'base-dir'} . '/techpub/docs/' . $path . '.html';
			
			// Redirect to serialised document:
			if ($path != (string)$parameters->{'current-path'}) {
				header('Location: ' . $session->constants()->{'base-url'} . '/' . $path); exit;
			}
			
			// No path? Use index:
			if ($path == '') {
				$path = 'index';
				$file = $session->constants()->{'base-dir'} . '/techpub/docs/index.html';
			}
			
			// Create a new empty document?
			if (!is_file($file)) {
				$title = ucfirst(strtr($path, '-', ' '));
				
				file_put_contents($file, '<h1>' . $title . '</h1>');
			}
			
			$element->setAttribute('file', $path);
			
			$raw = file_get_contents($file);
			$document = $element->ownerDocument;
			
			if ($raw == '') return;
			
			$html = new \Apps\TechPub\Libs\HTML();
			$tidy = $html->format($raw, array(
				'pretty_acronyms'			=> true,
				'pretty_ampersands'			=> true,
				'pretty_dashes'				=> true,
				'pretty_ellipses'			=> true,
				'pretty_quotation_marks'	=> true,
				'pretty_sentence_spacing'	=> true,
				'pretty_symbols'			=> true,
				'prevent_widowed_words'		=> true
			));
			
			$fragment = $document->createDocumentFragment();
			$fragment->appendXML($tidy);
			$element->appendChild($fragment);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>