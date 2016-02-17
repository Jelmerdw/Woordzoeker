<?php

include './verticaal.php';

class StackTest extends PHPUnit_Framework_TestCase {

    function test_onoff_verticaal() {
        $v = 0;
        onoff_verticaal ($v);
        $this->assertEquals(1, $v);
    }
}
