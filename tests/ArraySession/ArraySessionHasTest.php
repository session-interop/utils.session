<?php

namespace Interop\Session\Utils\ArraySession\TestCase;
use Interop\Session\Utils\ArraySession\ArraySession;

class ArraySessionHasTest extends \PHPUnit_Framework_TestCase {
    protected function getMockSession(&$array, $prefix = "") {
      return $this->getMockBuilder('Interop\Session\Utils\ArraySession\ArraySession')
        ->setConstructorArgs(array(&$array, $prefix))
        ->setMethods(null)
        ->getMock();
    }

  /**
  * @dataProvider provideValues
  */
  public function testHas($array, $key, $val, $prefix) {
    $session = $this->getMockSession($array, $prefix);
      $this->assertEquals(in_array($val, $array) && array_key_exists($key, $array), $session->has($key));
  }


  /**
  * @dataProvider provideValues
  * @expectedException Interop\Session\Utils\ArraySession\Exception\SessionException
  */
  public function testHasIsString($array, $key, $val, $prefix) {
    $session = $this->getMockSession($array, $prefix);
      $session->has(array());
  }

  public function provideValues() {
    $a1 = [];
    if (!isset($_SESSION)) {
      session_start();
		}
    return [
      [$a1, "nurf", "xorf", "prefix"],
      [$a1, "Ping", null, null],
      [$a1, "Pong", "doe", "john"],
      [$_SESSION, "Carburant", "Voix", "Mexicain"],
    ];
  }

}
