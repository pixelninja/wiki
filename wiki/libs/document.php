<?php
/*---------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Libs;
	use \Exception as Exception;
	use \Libs\DOM as DOM;
	use \Libs\Session as Session;
	use \Apps\Wiki\Libs\HTML as HTML;
	
	class Document {
		static protected $catalog;
		
		static public function open($url) {
			if (!is_file($url)) {
				throw new Exception(sprintf(
					"Unable to open document '%s'.", $url
				));
			}
			
			list($handler, $url) = explode('://', $url, 2);
			
			if (isset(self::$catalog[$url])) {
				$document = self::$catalog[$url];
			}
			
			else {
				$handler .= '://';
				$document = new Document($handler, $url);
				$document->setUnformatted(
					file_get_contents($handler . $url)
				);
				
				self::$catalog[$url] = $document;
			}
			
			return $document;
		}
		
		static public function create($url, $title) {
			list($handler, $url) = explode('://', $url, 2);
			
			$handler .= '://';
			$document = new Document($handler, $url);
			$document->setUnformatted(sprintf(
				"<h1>%s</h1>\n\n<children />", $title
			));
			
			self::$catalog[$url] = $document;
			
			return $document;
		}
		
		protected $formatted;
		protected $unformatted;
		protected $handler;
		protected $url;
		protected $name;
		
		public function __construct($handler, $url) {
			$this->handler = $handler;
			$this->url = $url;
		}
		
		public function appendExcerptTo(\Libs\DOM\Element $parent) {
			$fragment = $parent->ownerDocument->createDocumentFragment();
			$nodes = $this->formatted->{'/data/excerpt[p] | /data/p[1]'};
			$parent->setAttribute('more', 'no');
			$excerpt = null;
			
			foreach ($nodes as $node) {
				$excerpt = $node;
				
				if ($node->nodeName != 'p') break;
			}
			
			if (!$excerpt instanceof DOM\Element) return false;
			
			// Contains additional content?
			if (
				$excerpt->{'count(following-sibling::*)'}
				|| $excerpt->{'count(preceding-sibling::*[name() != "h1"])'}
			) {
				$parent->setAttribute('more', 'yes');
			}
			
			if ($excerpt->nodeName == 'p') {
				$fragment->appendXML($excerpt->saveXML());
			}
			
			else foreach ($excerpt->childNodes as $node) {
				if (!$node instanceof DOM\Element) continue;
				
				$fragment->appendXML($node->saveXML());
			}
			
			try {
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
		
		public function getChildren() {
			$children = array();
			
			foreach (scandir('directory://' . $this->url) as $file) {
				if (preg_match('%^[.]%', $file) || !is_file('document://' . $this->url . '/' . $file)) continue;
				
				$children[] = Document::open($this->handler . ltrim($this->url . '/' . $file, '/'));
			}
			
			return $children;
		}
		
		public function getParent() {
			return Document::open($this->handler . dirname($this->url));
		}
		
		public function getName() {
			return $this->formatted->{'string(/data/h1[1])'};
		}
		
		public function getURL() {
			return $this->url;
		}
		
		public function hasParent() {
			return strlen($this->url) !== 0;
		}
		
		public function save() {
			file_put_contents($this->handler . $this->url, $this->unformatted);
		}
		
		public function setUnformatted($content) {
			$settings = Session::current()->app()->settings();
			$html = new HTML();
			$xml = new DOM\Document();
			$xml->loadXML(
				'<data>' . $html->format($content, $settings) . '</data>'
			);
			
			$this->formatted = $xml;
			$this->unformatted = $content;
		}
	}
	
/*---------------------------------------------------------------------------*/
?>