<?php
class BeautifyTest extends PHPUnit_Framework_TestCase
{
  public function test_beautifytime()
  {
    $this->assertTrue(beautifytime(12) == "0h 0m 12s");
  }

  public function test_beautifytime2()
  {
    $this->assertTrue(beautifytime(3600) == "1h 0m 0s");
  }

  public function test_beautifytime3()
  {
    $this->assertTrue(beautifytime(3615) == "1h 0m 15s");
  }

  public function test_beautifytime4()
  {
    $this->assertTrue(beautifytime(136687) == "37h 58m 7s");
  }

  public function test_beautifytime5()
  {
    $this->assertTrue(beautifytime(41548533) == "11547h 15m 33s");
  } 
}

