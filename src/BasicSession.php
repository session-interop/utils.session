<?php

namespace Mouf\Utils\BasicSession;

use TheCodingMachine\SessionInterface\SessionInterface;


class BasicSession implements SessionInterface {
	
	private $storage;
	
	private $prefix;	
	
	public function __construct($storage, $prefix = "") {
		$this->storage = $storage;
		$this->prefix = $prefix;
	}
	
	public function set($key, $data) {
		if (!$this->storage) {
			throw new SessionException("No storage detected");
		}
		
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		
		if (!$this->has($key)) {
			throw new SessionException("Key is not in session");
		}
		
		$this->storage[$this->prefix.$key] = $data;
	}
	
	public function get($key) {
		if (!$this->storage) {
			throw new SessionException("No storage detected");
		}
		
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		return $this->storage[$this->prefix.$key];
	}
	
	public function has($key) {
		if (!$this->storage) {
			throw new SessionException("No storage detected");
		}
		
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		return isset($this->storage[$this->prefix.$key]);
	}
	
}