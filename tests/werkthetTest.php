<?php

include './verticaal.php';
include './horizontaal.php';
include './diagonaal.php';

class StackTest extends PHPUnit_Framework_TestCase {

    function test_onoff_verticaal() {
        $v = 0;
        onoff_verticaal ($v);
        $this->assertEquals(1, $v);
    }
    
    function test_onoff_horizontaal() {
        $h = 0;
        onoff_verticaal ($h);
        $this->assertEquals(1, $h);
    }
    
    function test_onoff_diagonaal() {
        $d = 0;
        onoff_verticaal ($d);
        $this->assertEquals(1, $d);
    }
}
