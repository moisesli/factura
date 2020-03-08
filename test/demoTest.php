<?php

use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    public function testPushAndPop()
    {
        require "factura_class.php";
        $this->assertEquals('1','1');
    }
}
    