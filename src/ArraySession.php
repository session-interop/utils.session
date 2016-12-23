<?php

namespace Interop\Session\Utils\ArraySession;

use Interop\Session\SessionInterface;
use Interop\Session\Utils\ArraySession\Exception\SessionException;

class ArraySession implements SessionInterface {

	private $storage;

	private $prefix;

	public function __construct(&$storage, $prefix = "") {
		$this->storage = &$storage;
		$this->prefix = $prefix;
		if (!is_array($this->storage)) {
			throw new SessionException("Storage must be an array, "
					.(gettype($this->storage) === "object" ? get_class($this->storage) : gettype($this->storage))
					." given"
			);
		}
	}

	public function get($key) {

		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		return $this->has($key) ? $this->storage[$this->prefix.$key] : null;
	}

	private function has($key) {
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		return array_key_exists($this->prefix.$key, $this->storage);
	}


	public function set($key, $data) {
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		if ($data === null) {
			$this->remove($key);
		}
		$this->storage[$this->prefix.$key] = $data;
	}


	private function remove($key) {
		if ($this->has($key)) {
			unset($this->storage[$key]);
		}
	}

}
