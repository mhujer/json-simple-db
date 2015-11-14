<?php
namespace JsonSimpleDb;

class Db
{
    /**
     * @var string
     */
    protected $dbDir;

    /**
     * @param string $dbDir
     */
    public function __construct($dbDir)
    {
        if (!is_dir($dbDir)) {
            throw new \InvalidArgumentException(sprintf('Directory "%s" does not exist!', $dbDir));
        }
        $this->dbDir = $dbDir;
    }

    /**
     * @param string $tableName
     * @return string
     */
    protected function getTableFilename($tableName)
    {
        return $this->dbDir . DIRECTORY_SEPARATOR . $tableName . '.json';
    }

    /**
     * @param string $tableName
     * @return bool
     */
    public function tableExists($tableName)
    {
        return is_readable($this->getTableFilename($tableName));
    }

    /**
     * @param string $tableName
     * @return Table
     */
    public function getTable($tableName)
    {
        if (!$this->tableExists($tableName)) {
            throw new \RuntimeException(sprintf('Data file for table "%s" does not exist', $tableName));
        }
        return new Table($this->getTableFilename($tableName));
    }
}
