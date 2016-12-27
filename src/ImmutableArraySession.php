<?php
declare(strict_types=1);
namespace Interop\Session\Utils\ArraySession;

use Interop\Session\SessionInterface;
use Interop\Session\Utils\ArraySession\Exception\SessionException;
/**
* This object rely on the default session implementation; so this object IS NOT immutable (it set data directly in $_SESSION)
**/
class ImmutableArraySession implements SessionInterface {

	protected $storage;

	protected $prefix;

	public function __construct($storage, $prefix = "") {
		$this->storage = $storage;
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
		return array_key_exists($this->prefix.$key, $this->storage);
	}

	public function with(string $key, ?string $data): SessionInterface {
		$cloneActualSession = $this->storage;
		if ($data !== null) {
			$cloneActualSession[$key] = $data;
		}
		else if ($this->has($key)) {
			unset($cloneActualSession[$key]);
		}
		else {
			return $this;
		}
		return new self($cloneActualSession, $this->prefix);
	}

}
