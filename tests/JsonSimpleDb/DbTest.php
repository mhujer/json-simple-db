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
}
