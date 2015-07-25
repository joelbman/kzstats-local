<?php

  include_once(__DIR__ .'/../../api/class/Player.class.php');

  class PlayerTest extends PHPUnit_Framework_TestCase {
    
    // SteamID conversion test
    public function testSteamidConversion() {
      $method = new ReflectionMethod('Player', 'convertId');
      $method->setAccessible(TRUE);
      $player = new Player(null);

      $this->assertEquals('STEAM_1:2:333333', $method->invokeArgs($player, array(12333333)));
      $this->assertEquals('STEAM_1:2:3333334', $method->invokeArgs($player, array('123333334')));
      $this->assertNotEquals('STEAM_1:2:333333', $method->invokeArgs($player, array('123333334')));
    }

    // Countrycode search test
    public function testCountryCodeSearch() {
      $method = new ReflectionMethod('Player', 'countryCode');
      $method->setAccessible(TRUE);
      $player = new Player(null);

      $this->assertEquals('FI', $method->invokeArgs($player, array('Finland')));
      $this->assertEquals('UNK', $method->invokeArgs($player, array('Random')));
      $this->assertEquals('UNK', $method->invokeArgs($player, array(123)));
    }

  }

?>