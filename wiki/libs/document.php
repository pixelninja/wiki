<?php
/*---------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Libs;
	
	class Document {
		public function registerDocumentStream($name = 'docs') {
			
		}
		
		/*
		protected $unformatted;
		protected $xml;
		
		public function open($filename) {
			if (!is_file($filename) && is_readable($filename)) {
				throw new Exception(sprintf(
					"Unable to read file '%s'.", $filename
				));
			}
			
			$this->unformatted = file_get_contents($filename);
		}
		
		public function formatted() {
			return $this->formatted;
		}
		
		public function unformatted() {
			return $this->unformatted;
		}
		
		public function appendFormattedXML($element) {
			
		}
		*/
	}
	
	class DocumentStream {
		
	}
	
/*---------------------------------------------------------------------------*/
?>