<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Views;
	
	class AJAX_Open extends \Libs\View {
		public function execute() {
			$session = \Libs\Session::current();
			$session->headers()->{'content-type'} = 'application/xml';
			$session->actors()->{'open'} = 'Actors\Open';
			
			parent::execute();
		}
	}
	
/*----------------------------------------------------------------------------*/
?>