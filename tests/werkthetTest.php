<?php

include './verticaal.php';
include './horizontaal.php';
include './diagonaal.php';

class StackTest extends PHPUnit_Framework_TestCase {

    function test_onoff_verticaal1() {
        $v = 0;
        onoff_verticaal($v);
        $this->assertEquals(1, $v);
    }

    function test_onoff_horizontaal1() {
        $h = 0;
        onoff_verticaal($h);
        $this->assertEquals(1, $h);
    }

    function test_onoff_diagonaal1() {
        $d = 0;
        onoff_verticaal($d);
        $this->assertEquals(1, $d);
    }

    function test_onoff_verticaal2() {
        $v = 1;
        onoff_verticaal($v);
        $this->assertEquals(0, $v);
    }

    function test_onoff_horizontaal2() {
        $h = 1;
        onoff_verticaal($h);
        $this->assertEquals(0, $h);
    }

    function test_onoff_diagonaal2() {
        $d = 1;
        onoff_verticaal($d);
        $this->assertEquals(0, $d);
    }

}
