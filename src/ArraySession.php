<?php
declare(strict_types=1);
namespace Interop\Session\Utils\ArraySession;

use Interop\Session\SessionInterface;
use Interop\Session\Utils\ArraySession\Exception\SessionException;
/**
* This object rely on the default session implementation; so this object IS NOT immutable (it set data directly in $_SESSION)
**/
class ArraySession implements SessionInterface {

	protected $storage;

	protected $prefix;

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

	public function get(string $key): ?string {
		return $this->has($key) ? $this->storage[$this->prefix.$key] : null;
	}

	private function has(string $key) {
		if (!is_string($key)) {
			throw new SessionException("Key must be a string");
		}
		return array_key_exists($this->prefix.$key, $this->storage);
	}


	public function with(string $key, ?string $data): SessionInterface {
		if ($data === null) {
			$this->remove($key);
		}
		else {
			$this->storage[$this->prefix.$key] = $data;
		}
		return new self($this->storage);
	}


	private function remove($key) {
		if ($this->has($key)) {
			unset($this->storage[$key]);
		}
	}

}
