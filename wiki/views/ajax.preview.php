<?php
/*----------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Views;
	
	class AJAX_Preview extends \Libs\View {
		public function execute() {
			$session = \Libs\Session::current();
			$session->headers()->{'content-type'} = 'application/xml';
			$session->actors()->{'preview'} = 'Actors\Preview';
			$session->actors()->{'children'} = 'Actors\Children';
			$session->actors()->{'location'} = 'Actors\Location';
			
			parent::execute();
		}
	}
	
/*----------------------------------------------------------------------------*/
?>