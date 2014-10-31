<?php
class HoursTest extends PHPUnit_Framework_TestCase
{
  public function test_getworkinghours()
  {
    $this->assertTrue(getworkinghours('1414666350', '1414666359') == 9);
  }
}
