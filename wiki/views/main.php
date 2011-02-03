<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Views;
	
	class Main extends \Libs\View {
		public function resolveConstants() {
			$actors = \Libs\Session::current()->actors();
			
			$actors->{'format'} = 'Actors\Format';
		}
		
		public function isIndex() {
			return true;
		}
	}
	
/*----------------------------------------------------------------------------*/
?>