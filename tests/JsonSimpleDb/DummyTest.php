<?php

namespace JsonSimpleDb;

class DummyTest extends \PHPUnit_Framework_TestCase
{
    public function testDummy()
    {
        $dummy = new Dummy();
        $this->assertEquals(3, $dummy->add(1, 2));
    }
}
