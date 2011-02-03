<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\TechPub\Actors;
	
	class Preview extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$parameters = \Libs\Session::current()->parameters();
			$raw = $parameters->{'raw'};
			
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
			
			$fragment = $element->ownerDocument->createDocumentFragment();
			$fragment->appendXML($tidy);
			$element->appendChild($fragment);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>