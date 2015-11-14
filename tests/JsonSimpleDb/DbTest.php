<?php

namespace JsonSimpleDb;

class DbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Directory "nonexistent" does not exist!
     */
    public function testNonexistentDir()
    {
        new Db('nonexistent');
    }

    public function testTableExists()
    {
        $db = new Db(__DIR__ . '/workdir');
        $this->assertFalse($db->tableExists('nonexistent'));

        $db = new Db(__DIR__ . '/data');
        $this->assertTrue($db->tableExists('empty'));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Data file for table "nonexistent" does not exist
     */
    public function testGettingNonexistentTableThrowsException()
    {
        $db = new Db(__DIR__ . '/workdir');
        $db->getTable('nonexistent');
    }

    public function testGettingExistingTableWorks()
    {
        $db = new Db(__DIR__ . '/data');
        $this->assertInstanceOf(Table::class, $db->getTable('empty'));
    }

    public function testCreateTable()
    {
        $db = new Db(__DIR__ . '/workdir');
        $this->assertFalse($db->tableExists('table1'));
        $db->createTable('table1');
        $this->assertTrue($db->tableExists('table1'));
        $this->assertSame(0, $db->getTable('table1')->count());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Table "foo" already exists
     */
    public function testCreateAlreadyExistingTableThrowsException()
    {
        if (is_readable(__DIR__ . '/workdir/foo.json')) {
            unlink(__DIR__ . '/workdir/foo.json');
        }
        $db = new Db(__DIR__ . '/workdir');
        $db->createTable('foo');
        $db->createTable('foo');
    }

    protected function tearDown()
    {
        //cleanup
        if (is_readable(__DIR__ . '/workdir/foo.json')) {
            unlink(__DIR__ . '/workdir/foo.json');
        }
        if (is_readable(__DIR__ . '/workdir/table1.json')) {
            unlink(__DIR__ . '/workdir/table1.json');
        }
    }
}
