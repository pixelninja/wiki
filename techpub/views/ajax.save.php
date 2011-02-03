<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\TechPub\Views;
	
	class AJAX_Save extends \Libs\View {
		public function execute() {
			$session = \Libs\Session::current();
			$session->headers()->{'content-type'} = 'application/xml';
			$session->actors()->{'save'} = 'Actors\Save';
			
			parent::execute();
		}
	}
	
/*----------------------------------------------------------------------------*/
?>