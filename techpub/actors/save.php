<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\TechPub\Actors;
	
	class Save extends \Libs\Actor {
		public function execute(\Libs\DOM\Element $element) {
			parent::execute($element);
			
			$parameters = \Libs\Session::current()->parameters();
			$file = $parameters->{'file'};
			$raw = $parameters->{'raw'};
			
			if ($raw == '') return;
			
			file_put_contents(BASE_DIR . '/techpub/docs/' . $file . '.html', $raw);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>