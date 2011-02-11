<?php
/*---------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Libs;
	
	class Document {
		protected $formatted;
		protected $unformatted;
		protected $url;
		protected $name;
		
		public function __construct($url) {
			$this->url = $url;
			
			if (is_file('document://' . $url)) {
				$this->edit(file_get_contents('document://' . $url));
			}
		}
		
		public function appendExcerptTo(\Libs\DOM\Element $parent) {
			$excerpt = $this->getExcerpt();
			
			if ($excerpt === false) return false;
			
			try {
				$fragment = $parent->ownerDocument->createDocumentFragment();
				$fragment->appendXML($excerpt);
				$parent->appendChild($fragment);
			}
			
			catch (\Exception $e) {
				return false;
			}
			
			return true;
		}
		
		public function appendFormattedTo(\Libs\DOM\Element $parent) {
			foreach ($this->formatted->{'/data/node()'} as $node) {
				$node = $parent->ownerDocument->importNode($node, true);
				$parent->appendChild($node);
			}
			
			return true;
		}
		
		public function appendUnformattedTo(\Libs\DOM\Element $parent) {
			$parent->nodeValue = htmlentities($this->unformatted);
			
			return true;
		}
		
		public function edit($unformatted) {
			$settings = \Libs\Session::current()->app()->settings();
			$html = new \Apps\Wiki\Libs\HTML();
			$xml = new \Libs\DOM\Document();
			$xml->loadXML(
				'<data>' . $html->format($unformatted, $settings) . '</data>'
			);
			
			$this->name = $xml->{'string(/data/h1[1])'};
			$this->formatted = $xml;
			$this->unformatted = $unformatted;
		}
		
		public function getChildren() {
			$children = array();
			
			foreach (scandir('directory://' . $this->url) as $file) {
				if (preg_match('%^[.]%', $file) || !is_file('document://' . $this->url . '/' . $file)) continue;
				
				$children[] = new Document($this->url . '/' . $file);
			}
			
			return $children;
		}
		
		public function getExcerpt() {
			$node = $this->formatted->{'/data/p[1]'}->current();
			
			if (!$node) return false;
			
			return $node->saveXML();
		}
		
		public function getParent() {
			return new Document(dirname($this->url));
		}
		
		public function getName() {
			return $this->name;
		}
		
		public function getURL() {
			return $this->url;
		}
		
		public function hasParent() {
			return strlen($this->url) !== 0;
		}
	}
	
/*---------------------------------------------------------------------------*/
?>