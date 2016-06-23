<?php

namespace Interop\Session\Utils\ArraySession\TestCase;
use Interop\Session\Utils\ArraySession\ArraySession;

class ArraySessionRemoveTest extends \PHPUnit_Framework_TestCase {

    protected function getMockSession(&$array, $prefix = "") {
      return $this->getMockBuilder('Interop\Session\Utils\ArraySession\ArraySession')
        ->setConstructorArgs(array(&$array, $prefix))
          ->disableOriginalClone()
          ->setMethods(array('has'))
          ->getMock();
    }

  /**
  * @dataProvider provideValues
  */
  public function textRemove($array, $key, $val, $prefix) {
    $session = $this->getMockSession($array, $prefix);

      $array[$key] = $val;
      $session->expects($this->once())
        ->method('has')
        ->with($this->equalTo($key))
        ->willReturn(true);

      $session->remove($key);
      $this->assertArrayNotHasKey($key, $array);
  }

  /**
  * @dataProvider provideValues
  */
  public function testRemoveNoValue($array, $key, $val, $prefix) {
      $session = $this->getMockSession($array, $prefix);

      $session->expects($this->once())
        ->method('has')
        ->with($this->equalTo($key))
        ->willReturn(true);


      $session->remove($key);
      $this->assertArrayNotHasKey($key, $array);
  }

  /**
  * @dataProvider provideValues
  * @expectedException Interop\Session\Utils\ArraySession\Exception\SessionException
  */
  public function testRemoveIsString($array, $key, $val, $prefix) {
    $session = $this->getMockSession($array, $prefix);


        $session->remove(array($key));
  }

  public function provideValues() {
    $a1 = [];

    return [
      [$a1, "JOhnny", "Raiel", "Dui"],
      [$a1, "foo", null, null],
      [$a1, "汉字", "汉字", "汉字"],
      [$a1, "ألف", "ألف", "ألف"],
    ];
  }

}
