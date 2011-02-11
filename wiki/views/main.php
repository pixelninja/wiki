<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Views;
	
	class Main extends \Libs\View {
		public function resolveConstants() {
			$actors = \Libs\Session::current()->actors();
			
			$actors->{'format'} = 'Actors\Format';
			$actors->{'children'} = 'Actors\Children';
			$actors->{'location'} = 'Actors\Location';
		}
		
		public function isIndex() {
			return true;
		}
		
		public function execute() {
			parent::execute();
			
			$session = \Libs\Session::current();
			$document = $this->document();
			$root = $document->documentElement;
			
			// Append settings:
			$settings = $document->createElement('settings');
			$session->app()->settings()->appendXML($settings);
			$root->appendChild($settings);
		}
	}
	
/*----------------------------------------------------------------------------*/
?>