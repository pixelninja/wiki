<?php
	
	namespace Apps\Wiki;
	
	class App extends \Libs\App {
		protected $settings;
		
		protected function initialize() {
			$this->settings = new \Libs\Collections\Parameters();
			$this->settings()->{'read-only'} = true;
		}
		
		public function settings() {
			return $this->settings;
		}
	}
	
?>