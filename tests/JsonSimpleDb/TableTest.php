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

    public function testCanSearchForDataWithoutResults()
    {
        $table = new Table(__DIR__ . '/data/sample.json');
        $this->assertSame([], $table->find(['_id' => '999']));
    }

    public function testCanSearchForData()
    {
        $table = new Table(__DIR__ . '/data/sample.json');
        $this->assertSame([
            [
                '_id' => '2',
                'name' => 'bar',
            ],
        ], $table->find(['_id' => '2']));
    }

    public function testCanSearchForMultipleResults()
    {
        $table = new Table(__DIR__ . '/data/sample-multiple.json');
        $this->assertSame([
            [
                '_id' => '1',
                'category' => 'cat1',
            ],
            [
                '_id' => '3',
                'category' => 'cat1',
            ],
        ], $table->find(['category' => 'cat1']));
    }

    public function testInsertData()
    {
        $table = new Table(__DIR__ . '/data/empty.json');
        $table->insert([
            'foo' => 'bar',
            'baz' => 'bat',
        ]);
        $this->assertSame(1, $table->count());
        $this->assertSame([[
            'foo' => 'bar',
            'baz' => 'bat',
        ]], $table->find(['baz' => 'bat']));
    }

    public function testUpdateData()
    {
        $table = new Table(__DIR__ . '/data/sample.json');
        $this->assertSame([[
            '_id' => '2',
            'name' => 'bar',
        ]], $table->find(['_id' => '2']));
        $table->update([
            '_id' => '2',
        ], [
            'name' => 'gaz'
        ]);
        $this->assertSame([[
            '_id' => '2',
            'name' => 'gaz',
        ]], $table->find(['_id' => '2']));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Missing query for delete
     */
    public function testDeleteNoParam()
    {
        $table = new Table(__DIR__ . '/data/sample.json');
        $table->delete();
    }

    public function testDelete()
    {
        $table = new Table(__DIR__ . '/data/sample.json');
        $table->delete(['_id' => '2']);
        $this->assertSame([[
            '_id' => '1',
            'name' => 'foo',
        ]], $table->find());

        $table->delete(['name' => 'boo']);
        $this->assertSame([[
            '_id' => '1',
            'name' => 'foo',
        ]], $table->find());

        $table->delete(['name' => 'foo']);
        $this->assertSame([], $table->find());
    }

    public function testPersist()
    {
        $jsonFilename = __DIR__ . '/workdir/persisting.json';
        file_put_contents($jsonFilename, '[]');
        $table = new Table($jsonFilename);
        $table->insert([
            'foo' => 'bar',
            'baz' => 'bat',
        ]);
        $table->insert([
            'ab' => 'cd',
            'ef' => 'gh',
        ]);
        $table->persist();

        $tableLoaded = new Table($jsonFilename);
        $this->assertSame(2, $tableLoaded->count());

        unlink($jsonFilename);
    }
}
