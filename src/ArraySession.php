<?php

namespace Interop\Session\Utils\ArraySession;

use Interop\Session\SessionInterface;


class ArraySession implements SessionInterface {

	private $storage;

	private $prefix;

	public function __construct(&$storage, $prefix = "") {
		$this->storage = $storage;
		$this->prefix = $prefix;
		if (!is_array($this->storage)) {
			throw new SessionException("Storage must be an array, "
					.(gettype($this->storage) === "object" ? get_class($this->storage) : gettype($this->storage))
					." given"
			);
		}
	}

	public function set($key, $data) {
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		$this->storage[$this->prefix.$key] = $data;
	}

	public function get($key) {
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		return $this->storage[$this->prefix.$key];
	}

	public function has($key) {
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		return isset($this->storage[$this->prefix.$key]);
	}

	public function remove($key) {
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		if ($this->has($key)) {
			unset($this->storage[$key]);
		}
	}

}
