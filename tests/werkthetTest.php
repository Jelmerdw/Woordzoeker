<?php

include './zoekerFuncties.php';

class StackTest extends PHPUnit_Framework_TestCase {

    function testUitvoeringen() {
        $u = 1;
        $h = 1;
        $e = 0;
        uitvoeringen($u, $h, $e);
        $this->assertEquals(1, $e);
    }

    function testUitvoeringen2() {
        $u = 1;
        $h = 2;
        $e = 4;
         $this->assertEquals(4, $e, "initial");
        uitvoeringen($u, $h, $e);
        $this->assertEquals(2, $u);
        $this->assertEquals(4, $e, "mag niet aangepast zijn");
    }

}
