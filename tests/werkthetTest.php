<?php

include './zoeker_klik.php';

class StackTest extends PHPUnit_Framework_TestCase {

    function test_zoek_horizontaal() {
        $r = 0;
        $a_r = 5;
        $k = 0;
        zoek_horizontaal($r, $a_r, $k);
        $this->assertEquals(5, $r);
    }
}
