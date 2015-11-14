<?php

namespace JsonSimpleDb;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $table = new Table(__DIR__ . '/data/empty.json');
        $this->assertSame(0, $table->count());
    }

    public function testSampleDataCanBeRead()
    {
        $table = new Table(__DIR__ . '/data/sample.json');
        $this->assertSame(2, $table->count());
        $this->assertSame([
            [
                '_id' => '1',
                'name' => 'foo',
            ],
            [
                '_id' => '2',
                'name' => 'bar',
            ],
        ], $table->find());
    }
}
