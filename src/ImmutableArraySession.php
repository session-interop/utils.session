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

	public function __construct(array $storage, string $prefix = "") {
		$this->storage = $storage;
		$this->prefix = $prefix;
	}

	protected function key(string $k): string {
		return $this->prefix.$k;
	}


	public function get(string $key): ?string {
		return $this->has($key) ? $this->storage[$this->prefix.$key] : null;
	}

	private function has(string $key) {
		return array_key_exists($this->prefix.$key, $this->storage);
	}

	public function with(string $key, ?string $data): SessionInterface {
		$cloneActualSession = $this->storage;
		$cloneActualSession[$this->key($key)] = $data;
		return new self($cloneActualSession, $this->prefix);
	}

}
