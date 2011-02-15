<?php
/*---------------------------------------------------------------------------*/
	
	namespace Apps\Wiki\Libs;
	
	class DocumentStream {
		protected $file;
		protected $handle;
		protected $resource;
		
		static public function create() {
			stream_wrapper_register('document', 'Apps\Wiki\Libs\DocumentStream');
			stream_wrapper_register('directory', 'Apps\Wiki\Libs\DocumentStream');
		}
		
		public function dir_closedir() {
			return closedir($this->resource);
		}
		
		public function dir_opendir($path, $options) {
			$this->resource = opendir($this->find($path));
			
			return is_resource($this->resource);
		}
		
		public function dir_readdir() {
			return readdir($this->resource);
		}
		
		public function dir_rewinddir($path, $options) {
			return rewinddir($this->resource);
		}
		
		public function find($path) {
			list($type, $path) = explode(':/', $path, 2);
			
			$path = \Libs\Session::current()->constants()->{'app-dir'} . '/docs' . $path;
			
			if ($type == 'document') $path .= '/index.html';
			
			return $path;
		}
		
		public function mkdir($path, $mode, $options) {
			return mkdir($this->find($path), $mode);
		}
		
		public function rename($path_from, $path_to) {
			return rename($this->find($path_from), $this->find($path_to));
		}
		
		public function stream_close() {
			return fclose($this->handle);
		}
		
		public function stream_eof() {
			return feof($this->handle);
		}
		
		public function stream_flush() {
			return fflush($this->handle);
		}
		
		public function stream_lock($operation) {
			return flock($this->handle, $operation);
		}
		
		public function stream_open($path, $mode, $options, &$opened_path) {
			$file = $this->find($path);
			
			if (!is_dir(dirname($file))) {
				mkdir(dirname($file));
			}
			
			$this->file = $file;
			$this->handle = fopen($file, $mode);
			
			return true;
		}
		
		public function stream_read($length) {
			return fread($this->handle, $length);
		}
		
		public function stream_seek($offset, $whence) {
			return fseek($this->handle, $offset, $whence);
		}
		
		public function stream_stat() {
			return fstat($this->handle);
		}
		
		public function stream_tell() {
			return ftell($this->handle);
		}
		
		public function stream_write($data) {
			return fwrite($this->handle, $data);
		}
		
		public function unlink($path) {
			return unlink($this->find($path));
		}
		
		public function url_stat($path, $flags) {
			try {
				return stat($this->find($path));
			}
			
			catch (\Exception $e) {
				return false;
			}
		}
	}
	
/*---------------------------------------------------------------------------*/
?>