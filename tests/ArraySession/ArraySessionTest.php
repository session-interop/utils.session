<?php

namespace Interop\Session\Utils\ArraySession\TestCase;
use Interop\Session\Utils\ArraySession\ArraySession;

class ArraySessionTest extends \PHPUnit_Framework_TestCase {
/**
  Probably useless
**/
  public function testConstruct() {
    $array = array();
    $session = new ArraySession($array);
    $this->assertInstanceOf("Interop\Session\Utils\ArraySession\ArraySession", $session);
    return array("array"=> &$array, "session"=>$session);
  }
  /**
     * @expectedException Interop\Session\Utils\ArraySession\Exception\SessionException
  */
  public function testConstructException() {
    $t = "foo";
    $t = new ArraySession($t);
  }

}
