<?php
declare(strict_types=1);
namespace Interop\Session\Utils\ArraySession;

use Interop\Session\SessionInterface;
use Interop\Session\Utils\ArraySession\Exception\SessionException;
/**
* This object rely on the default session implementation; so this object IS NOT immutable (it set data directly in $_SESSION)
* This object modify the $storage
**/
class ReferenceArraySession implements SessionInterface {

	protected $storage;

	protected $prefix;

	public function __construct(&$storage, $prefix = "") {
		$this->storage = &$storage;
		$this->prefix = $prefix;
	}

	protected function key(string $k): string {
		return $this->prefix.$k;
	}

	public function get(string $key): ?string {
		return $this->has($key) ? $this->storage[$this->key($key)] : null;
	}


	public function set(string $key, ?string $data): void {
		$this->storage[$this->key($key)] = $data;
	}

	private function has(string $key) {
		return array_key_exists($this->key($key), $this->storage);
	}


}
