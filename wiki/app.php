<?php
	
	namespace Apps\Wiki;
	
	class App extends \Libs\App {
		protected $settings;
		
		protected function initialize() {
			$this->settings = new \Libs\Collections\Parameters();
			$this->settings()->{'read-only'} = true;
			
			// Create new docs directory?
			if (!is_dir($this->dir . '/docs')) {
				mkdir($this->dir . '/docs');
				copy($this->dir . '/assets/wiki.html', $this->dir . '/docs/index.html');
			}
			
			// Load configuration:
			$settings = $this->settings();
			
			require_once '../config.php';
		}
		
		public function settings() {
			return $this->settings;
		}
	}
	
?>