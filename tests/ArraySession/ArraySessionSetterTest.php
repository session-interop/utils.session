<?php

namespace Interop\Session\Utils\ArraySession\TestCase;
use Interop\Session\Utils\ArraySession\ArraySession;

class ArraySessionSetterTest extends \PHPUnit_Framework_TestCase {

    protected function getMockSession(&$array, $prefix = "") {
      return $this->getMockBuilder('Interop\Session\Utils\ArraySession\ArraySession')
        ->setConstructorArgs(array(&$array, $prefix))
          ->setMethods(null)
          ->getMock();
    }


  /**
  * @dataProvider provideValues
  */
  public function testSetter($array, $key, $val, $prefix) {
    $session = $this->getMockSession($array, $prefix);

      $s = $session->with($key, $val);
      if (!$val) {
        $this->assertArrayNotHasKey($prefix.$key, $array);
      } else {
        $this->assertEquals($val, $array[$prefix.$key]);
      }
  }

  /**
  * @dataProvider provideValues
  */
  public function testSetterNoValue($array, $key, $val, $prefix) {
    $session = $this->getMockSession($array, $prefix);

      $session->with($key, null);
      $this->assertArrayNotHasKey($prefix.$key, $array);
  }


  public function provideValues() {
    $a1 = [];
    if (!isset($_SESSION)) {
      session_start();
		}
    return [
      [$a1, "oiseau", "baz", "prefix"],
      [$a1, "foo", null, null],
      [$a1, "foo", "baz", "foo"],
      [$_SESSION, "foo", "baz", "baz"],
    ];
  }

}
