<?php

namespace Interop\Session\Utils\ArraySession\TestCase;
use Interop\Session\Utils\ArraySession\ArraySession;

class ArraySessionGetterTest extends \PHPUnit_Framework_TestCase {

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
    public function testGetter($array,  $key, $val, $prefix) {
        $keyWithPrefix = (is_string($prefix) ? $prefix.$key : $key);
        $array[$keyWithPrefix] = $val;
        //$session->get($key)->willReturn($val);
        $session = $this->getMockSession($array, $prefix);
        //$session->expects($this->once())
        //->method('has')
        //->with($this->equalTo($key))
        //->willReturn(true);
        $this->assertEquals($val, $session->get($key));
    }

    /**
    * @dataProvider provideValues
    */
    public function testGetterNoValue($array, $key, $val, $prefix) {

      $session = $this->getMockSession($array, $prefix);
      //$session->expects($this->once())
      //->method('has')
      //->with($this->equalTo($key))
      //->willReturn(false);
      $this->assertEquals(null, $session->get($key));
    }


  public function provideValues() {
    $a1 = [];
    if (!isset($_SESSION)) {
      session_start();
		}
    return [
      [$a1, "bim", "bam", "boumx"],
      [$a1, "ping", null, null],
      [$a1, "tic", "tac", "toc"],
      [$_SESSION, "bird", "eat", "seed"],
    ];
  }

}
