<?php
class BeautifyTest extends PHPUnit_Framework_TestCase
{
  public function test_beautifytime()
  {
    $this->assertTrue(beautifytime(12) == "0h 0m 12s");
  }
}

