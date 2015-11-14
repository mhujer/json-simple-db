<?php

namespace JsonSimpleDb;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $table = new Table(__DIR__ . '/data/empty.json');
        $this->assertSame(0, $table->count());
    }
}
