<?php

include './verticaal.php';
include './horizontaal.php';
include './diagonaal.php';
include './zoeker_over.php';

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
    
    //Deze volgede twee tests geven een failure, omdat in de functie global staat. 
    //Als je in de funcitie global even uit zet, krijgen we geen failure meer, 
    //maar dan werkt de functie in ons programma niet goed meer:
    function test_uitvoeringen1() {
        $u = 0;
        $h = 1;
        $e = 0;
        uitvoeringen($u, $h, $e);
        $this->assertEquals(1, $u);
    }
    function test_uitvoeringen2() {
        $u = 1;
        $h = 1;
        $e = 0;
        uitvoeringen($u, $h, $e);
        $this->assertEquals(1, $e);
    }
}
