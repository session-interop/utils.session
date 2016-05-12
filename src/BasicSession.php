<?php

namespace Mouf\Utils\BasicSession;

use TheCodingMachine\SessionInterface;


class BasicSession implements SessionInterface {
	public function __construct() {
		echo 'foo';exit;
	}
}