<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\TechPub\Views;
	
	class Main extends \Libs\View {
		public function resolveConstants() {
			$constants = \Libs\Session::current()->constants();
			$constants->{'aloha-url'} = $constants->{'app-url'} . '/assets/aloha';
		}
		
		public function isIndex() {
			return true;
		}
	}
	
/*----------------------------------------------------------------------------*/
?>